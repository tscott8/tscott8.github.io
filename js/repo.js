/*!
 * @mekwall's .vangogh() for Syntax Highlighting
 *
 * All code is open source and dual licensed under GPL and MIT.
 * Check the individual licenses for more information.
 * https://github.com/mekwall/jquery-vangogh/blob/master/GPL-LICENSE.txt
 * https://github.com/mekwall/jquery-vangogh/blob/master/MIT-LICENSE.txt
 */
 (function($, window, hljs){
     // one can become many
     var painters = 1,
         waitForLoad = false,
         waitForSource = false;

     // tool to parse/manipulate hash
     var hashTool = {
         get: function(id) {
             var hash = window.location.hash;
             if (hash.length > 0) {
                 var match = hash.match(new RegExp(id+":{([a-zA-Z0-9,-]*)}"));
                 if (match) {
                     return match[1].split(",");
                 }
             }
             return [];
         },
         set: function(id, hl) {
             var hash = window.location.hash,
                 newHash, addHash = id+":{"+hl.join(",")+"}",
                 match = hash.indexOf(id+":{");

             if (hl.length === 0) {
                 return this.remove(id);
             }
             if (match !== -1) {
                 newHash = hash.replace(
                     new RegExp("("+id+":{[a-zA-Z0-9,-]*})"),
                     addHash
                 );
             } else {
                 newHash = (hash.length > 0) ? hash+","+addHash : addHash;
             }
             window.location.hash = newHash;
         },
         remove: function(id) {
             window.location.hash = window.location.hash.replace(
                 new RegExp("([,]?"+id+":{[a-zA-Z0-9,-]*}[,]?)"),
                 ""
             );
         }
     };

 	// precompile regex patterns
 	var rxp = {
 		numberRange: /^([0-9]+)-([0-9]+)$/,
 		pageNumber: /-([0-9]+)$/,
 		multilineBegin: /<span class="([\w-_][^"]+)">(?:.[^<]*(?!<\/span>)|)$/ig,
 		multilineEnd: /(<span class="([\w-_][^"]+)">)?(?:.[^<]*)?(<\/span>)/ig
 	};

     // hey vincent!
     $.fn.vanGogh = function(options){
         var defaults = {
             language: "auto",
             firstLine: 1,
             maxLines: 0,
             numbers: true,
             highlight: null,
             animateGutter: true,
             autoload: "http://softwaremaniacs.org/media/soft/highlight/highlight.pack.js",
             tab: "    "
         };
         // merge defaults and passed options
         options = $.extend({}, defaults, options);

         // scope vars
         var elems = this,
             run = 0,
             remoteData;

         // cross-browser compatible selection
         function selectCode(elm) {
             var w = window,
                 d = window.document;
             if (d.body.createTextRange) {
                 var range = d.body.createTextRange();
                 range.moveToElementText(elm);
                 range.select();
             } else if (d.createRange) {
                 var sel = w.getSelection(),
                     range = d.createRange();
                 range.selectNodeContents(elm);
                 sel.removeAllRanges();
                 sel.addRange(range);
             }
         }

         // this function puts Van Gogh into action
         function paint() {
             // check if we're waiting for ajax request
             if (waitForLoad || waitForSource) {
                 setTimeout(paint, 100);
                 return;
             }
             run++;
             // abort if run 10 times or more
             if (run >= 10) { return; }
             // load remote source
             if (options.source && !remoteData) {
                 waitForSource = true;
                 $.ajax({
                     url: options.source,
                     crossDomain: true,
                     dataType: "text",
                     success: function(result){
                         remoteData = result;
                     },
                     error: function(xhr, textStatus){
                         remoteData = "ERROR: "+textStatus;
                     },
                     complete: function() {
                         waitForSource = false;
                         paint();
                     }
                 });
                 return;
             }
             hljs = hljs || window.hljs;
             if (!hljs) {
                 // autoload highlight.js
                 waitForLoad = true;
                 $.getScript(options.autoload, function(){
                     waitForLoad = false;
                     paint();
                 });
                 return;
             }
             // iterate passed elements
             elems.filter("pre,code").each(function(){
                 var self = $(this)
                         .addClass("vg-container")
                         .attr("id", this.id || "vg-"+painters++),
                     id = this.id,
                     container = self.find("code"),
                     inline = false,
                     lastClicked = false,
                     highlighted = [];

                 // if there's no code element,
                 // assume it's self and inline
                 if (!container.length) {
                     container = self;
                     inline = true;
                 }

                 // put remote data in container
                 (options.source && remoteData) && container.text(remoteData);

                 // copy the original text
                 var original = container.text();

                 // fire off highlight.js
                 hljs.highlightBlock(container[0], options.tab);

                 // split the result into lines so that we can process them
                 var lines = container.html().split("\n"),
                     numbers = "",
                     code = "";

                 // highlight a line/word/phrase
                 function highlight(num, clear, initial){
                     var range = false,
                         lines = self.find(".vg-line");

                     // clear all previous highlights
                     if (clear) {
                         // remove class
                         self.find(".vg-highlight").removeClass("vg-highlight");
                         // remove from hash
                         hashTool.remove(id);
                         // clear highlighted array
                         highlighted = [];
                     }

                     // if not array, make it into one
                     num = ($.type(num) === "array") ?
                         num : [num];

                     // iterate array
                     $.each(num, function(i, hl){
                         // if already highlighted, do nothing
                         if (highlighted.indexOf(hl) > -1) { return; }
                         // convert to int if string is number
                         if (!isNaN(parseFloat(hl, 10)) && isFinite(hl)) {
                             hl = parseInt(hl, 10);
                         }
                         // handle strings
                         if ($.type(hl) === "string") {
                             // check for range
                             var match = rxp.numberRange.exec(hl);
                             if (match) {
                                 var from = match[1], to = match[2], range = "";
                                 for (var i = from; i <= to; i++) {
                                     range += ',#'+id+'-'+i;
                                     highlighted.push(i);
                                 }
                                 lines.filter(range.substring(1)).addClass("vg-highlight");
                             } else {
                                 // check for word/phrase
                                 self.find(".vg-line:contains("+hl+")").each(function(){
                                     var line = $(this).addClass("vg-highlight");
                                     line.html(line.html().replace(hl, '<span class="vg-highlight">'+hl+'</span>'));
                                 });
                                 highlighted.push(hl);
                             }
                         } else {
                             var lineId = id+'-'+this,
                             line = lines.filter('#'+lineId);

                             // line found
                             if (line.length) {
                                 line.addClass("vg-highlight");
                                 highlighted.push(hl);
                             }
                         }
                     });
                     // update hash
                     !initial && hashTool.set(id, highlighted);
                 }

                 // if not inline
                 if (!inline) {
                     // iterate the lines
 					var multiline = {},
 						level = 0;
                     $.each(lines, function(i, line){
                         var num = i+options.firstLine,
                             lineId = id+'-'+num,
 							newLine = line;
                         // if numbers is enabled, add number to gutter
                         if (options.numbers) {
                             numbers += '<a class="vg-number" rel="#'+lineId+'">'+num+'</a>';
                         }
 						// check if in multiline mode
 						if (multiline[level]) {
 							// check for closing tag
 							var end = rxp.multilineEnd.exec(line);
 							// simulate a negative lookbehind by forcing first group not to match
 							if (end && !end[1]) {
 								// closing tag found
 								newLine = '<span class="'+multiline[level]+'">'+newLine;
 								// down a level
 								delete multiline[level];
 								level--;
 							} else {
 								// we're still on the same level
 								newLine = '<span class="'+multiline[level]+'">'+newLine+'</span>';
 							}
 						}
 						// detect and retain multiline styles
 						// (inline languages, multi-line comments etc.)
 						var match = rxp.multilineBegin.exec(line);
 						if (match) {
 							// up a level
 							level++;
 							// store current style
 							multiline[level] = match[1];
 						}
                         // wrap the line
                         code += '<div class="vg-line" id="'+lineId+'">'+newLine+'</div>';
                     });
                     // wrap all lines
                     code = '<code class="vg-code">'+code+'</code>';
                     // add gutter to container if numbers is enabled
                     if (options.numbers) {
                         code = '<div class="vg-gutter">'+numbers+'</div>'+code;
                     }
                     // put new code in container
                     self.html(code);
                     // reset the container since we just replaced the original element
                     container = self.find("code");
                     // we want numbersto be clickable
                     self.find(".vg-number").click(function(e){
                         var number = $(this),
                             rel = number.attr("rel"),
                             line = self.find(rel);

                         // check if already highlighted
                         if (line.hasClass("vg-highlight")) {
                             // remove highlight class
                             line.removeClass("vg-highlight");
                             // remove from highlighted
                             highlighted.splice(highlighted.indexOf(number.text()), 1);
                             // update hash
                             hashTool.set(id, highlighted);
                             lastClicked = false;
                             return false;
                         }

                         var prevClicked = lastClicked;
                         lastClicked = parseInt(rxp.pageNumber.exec(rel)[1], 10);

                         // handle shift-click to allow selecting range
                         if (e.shiftKey && lastClicked) {
                             highlight(
                                 prevClicked < lastClicked ?
                                     prevClicked+'-'+lastClicked :
                                     lastClicked+'-'+prevClicked,
                                 true
                             );
                         } else {
                             // handle ctrl-click to allow multiple highlightings
                             highlight(lastClicked, e.ctrlKey ? false : true);
                         }
                         return false;
                     });

                     var gutter = self.find(".vg-gutter"),
                         gutterWidth = gutter.outerWidth(),
                         oldLeft = 0,
                         scrollTimer = false;

                     // animate gutter on horizontal scroll
                     if (options.animateGutter) {
                         self.scroll(function(e){
                             if (this.scrollLeft === oldLeft) { return; }
                             else if (this.scrollLeft <= gutterWidth) {
                                 oldLeft = this.scrollLeft;
                                 clearTimeout(scrollTimer);
                                 scrollTimer = false;
                                 gutter.css({
                                     "float": "",
                                     "position": "",
                                     "left": ""
                                 }).show();
                             } else if (this.scrollLeft < oldLeft) {
                                 oldLeft = this.scrollLeft;
                                 gutter.hide();
                             } else if (this.scrollLeft !== oldLeft) {
                                 if (scrollTimer) { return; }
                                 var elm = this;
                                 oldLeft = this.scrollLeft;
                                 scrollTimer = setTimeout(function(){
                                     scrollTimer = false;
                                     var scrollLeft = elm.scrollLeft;
                                     container.css("marginLeft", gutterWidth);
                                     gutter.css({
                                         "float": "none",
                                         "position": "absolute",
                                         "left": scrollLeft-gutterWidth
                                     }).show().stop().animate({ left: scrollLeft });
                                 }, 500);
                             }
                         });
                     }

                 } else if (inline) {
                     self.addClass("vg-code");
                 }

                 // double-clicking the container will select all code (if supported)
                 container.dblclick(function(){
                     selectCode(container[0]);
                     return false;
                 });

                 if (options.maxLines > 0) {
 					var lineHeight = self.find(".vg-line").height(),
 						padding = parseInt(container.css("paddingTop")),
 						newHeight = lineHeight*(options.maxLines+1)+padding;
 					self.css({
 						minHeight: lineHeight+padding,
 						maxHeight: newHeight
 					});
                 }

                 // highlight rows passed in options
                 options.highlight && highlight(options.highlight, true, true);
                 // highlight lines that exist in hash
                 var hashLines = hashTool.get(id);
                 hashLines.length && highlight(hashLines, false, true);
             });
         }
         // let the master begin
         paint();
         // return elements
         return elems;
     }

 })(jQuery, this, (typeof this.hljs !== "undefined") ? this.hljs : false);

/*!
 * Repo.js
 * @author Darcy Clarke
 *
 * Copyright (c) 2012 Darcy Clarke
 * Dual licensed under the MIT and GPL licenses.
 * http://darcyclarke.me/
 */
 (function($){

    // Github repo
    $.fn.repo = function( options ){

        // Context and Base64 methods
        var _this       = this,
            keyStr64    = "ABCDEFGHIJKLMNOP" + "QRSTUVWXYZabcdef" + "ghijklmnopqrstuv" + "wxyz0123456789+/" + "=",
            encode64    = function(a){a=escape(a);var b="";var c,d,e="";var f,g,h,i="";var j=0;do{c=a.charCodeAt(j++);d=a.charCodeAt(j++);e=a.charCodeAt(j++);f=c>>2;g=(c&3)<<4|d>>4;h=(d&15)<<2|e>>6;i=e&63;if(isNaN(d)){h=i=64}else if(isNaN(e)){i=64}b=b+keyStr64.charAt(f)+keyStr64.charAt(g)+keyStr64.charAt(h)+keyStr64.charAt(i);c=d=e="";f=g=h=i=""}while(j<a.length);return b},
            decode64    = function(a){var b="";var c,d,e="";var f,g,h,i="";var j=0;var k=/[^A-Za-z0-9\+\/\=]/g;if(k.exec(a)){}a=a.replace(/[^A-Za-z0-9\+\/\=]/g,"");do{f=keyStr64.indexOf(a.charAt(j++));g=keyStr64.indexOf(a.charAt(j++));h=keyStr64.indexOf(a.charAt(j++));i=keyStr64.indexOf(a.charAt(j++));c=f<<2|g>>4;d=(g&15)<<4|h>>2;e=(h&3)<<6|i;b=b+String.fromCharCode(c);if(h!=64){b=b+String.fromCharCode(d)}if(i!=64){b=b+String.fromCharCode(e)}c=d=e="";f=g=h=i=""}while(j<a.length);return unescape(b)},
            transition  = function(el, direction, init){
                var opposite    = (direction === 'left') ? '' : 'left';

                if(init){
                    el.addClass('active');
                    _this.container.css({'height' : calculateHeight(el) + 'px'});
                } else {
                    _this.container
                        .find('.page.active')
                        .css('position','absolute')
                        .addClass(direction)
                        .removeClass('active')
                        .end()
                        .css({'height' : calculateHeight(el) + 'px'});
                    el.addClass('active')
                        .removeClass(opposite)
                        .delay(250)
                        .queue(function(){
                            $(this).css('position','relative').dequeue();
                        });
                }
            },

            calculateHeight = function(el){
                // This calculates the height of the bounding box for the repo display.
                // clientHeight is element containing fetched results, plus the h1 tag, plus
                // the div repo margin has of 15 pixels.
                return (el[0].clientHeight + _this.container.find('h1').outerHeight(true) + 15);
            },

            getMimeTypeByExtension = function(extension){
                var mimeTypes = {
                    // images
                    'png': 'image/png',
                    'gif': 'image/gif',
                    'jpg': 'image/jpeg',
                    'jpeg': 'image/jpeg',
                    'ico': 'image/x-icon'
                };
                return mimeTypes[extension] ? mimeTypes[extension] : 'text/plain';
            };

        // Settings
        _this.settings = $.extend({
                user    : '',
                name    : '',
                branch  : 'master',
                css     : '@font-face{font-family:"Octicons Regular";src:url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.eot?639c50d4");src:url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.eot?639c50d4#iefix") format("embedded-opentype"),url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.woff?0605b255") format("woff"),url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.ttf?f82fcba7") format("truetype"),url("https://a248.e.akamai.net/assets.github.com/fonts/octicons/octicons-regular-webfont.svg?1f7afa21#newFontRegular") format("svg");font-weight:normal;font-style:normal}@font-face{font-family:"repo-icons";src:url("./RepoJS/fonts/repo.eot");src:url("./RepoJS/fonts/repo.eot#iefix") format("embedded-opentype"),url("./RepoJS/fonts/repo.woff") format("woff"),url("./RepoJS/fonts/repo.ttf") format("truetype"),url("./RepoJS/fonts/repo.svg") format("svg");font-weight:normal;font-style:normal}.repo,.repo *{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;-ms-box-sizing:border-box;box-sizing:border-box}.repo ul *{display:block;font-family:sans-serif;font-size:13px;line-height:18px}.repo{width:100%;margin:0 0 15px 0;position:relative;padding-bottom:1px;color:#aaa;overflow:hidden;height:300px;-webkit-transition:height .25s;-moz-transition:height .25s;-o-transition:height .25s;-ms-transition:height .25s;transition:height .25s}.repo .page{background:#070707;border:4px solid rgba(0,0,0,0.08);border-radius:3px;-ms-filter:"alpha(opacity=0)";filter:alpha(opacity=0);opacity:0;left:100%;width:98%;position:absolute;-webkit-transition:all .25s;-moz-transition:all .25s;-o-transition:all .25s;-ms-transition:all .25s;transition:all .25s}.repo .page.active{left:1%!important;-ms-filter:"alpha(opacity=100)";filter:alpha(opacity=100);opacity:1;display:block}.repo .page.left{left:-100%}.repo .loader{position:absolute;display:block;width:100%;height:300px;top:0;left:0;background:url(http://i.imgur.com/pKopwXp.gif) center; background-repeat:no-repeat; background-size:20%;}.repo.loaded .loader{display:none}.repo h1{padding:0 0 0 10px;font-family:sans-serif;font-size:20px;line-height:26px;color:#fff;font-weight:normal}.repo h1 a:nth-of-type(1),.repo h1 a.active{font-weight:bold}.repo h1 a.active,.repo h1 a.active:active,.repo h1 a.active:visited,.repo h1 a.active:hover{color:#1051c4}.repo h1 a,.repo h1 a:active,.repo h1 a:visited,.repo h1 a:hover{color:#4183c4;text-decoration:none}.repo h1 a:after{content:"/";color:#666;padding:0 5px;font-weight:normal}.repo h1 a:last-child:after{content:""}.repo .page,.repo ul{zoom:1}.repo .page:before,.repo .page:after,.repo ul:before,.repo ul:after{content:"";display:table}.repo .page:after,.repo ul:after{clear:both}.repo ul{border:1px solid rgba(0,0,0,0.25);margin:0;padding:0}.repo li{width:100%;margin:0;padding:0;float:left;border-bottom:1px solid #333;position:relative;white-space:nowrap}.repo li.titles{background:-webkit-linear-gradient(#151515,#050505);background:-moz-linear-gradient(#151515,#050505);background:-o-linear-gradient(#151515,#050505);background:-ms-linear-gradient(#151515,#050505);background:linear-gradient(#151515,#050505);font-weight:bold;padding:10px 10px 8px 36px;text-shadow:0 1px 0 #000}.repo li:before{content:"t";font-family:"repo-icons";position:absolute;top:10px;left:10px;font-size:18px;-webkit-font-smoothing:antialiased}.repo li.dir:before{content:"f ";color:#80a6cd}.repo li.titles:before,.repo li.back:before{content:""}.repo li:last-child{border:0;padding-bottom:none;margin:0}.repo li a,.repo li a:visited,.repo li a:active{color:#4183c4;width:100%;padding:10px 10px 8px 36px;display:block;text-decoration:none}.repo li a:hover{text-decoration:underline}.repo li span{display:inline-block}.repo li span:nth-of-type(1){width:30%}.repo li span:nth-of-type(2){width:20%}.repo li span:nth-of-type(3){width:40%}.repo .vg-container{position:relative;overflow:auto;white-space:pre!important;word-wrap:normal!important}.repo .vg-container,.repo .vg-code{border:0;margin:0;overflow:auto}.repo .vg-code .vg-line,.repo .vg-gutter .vg-number{display:block;height:1.5em;line-height:1.5em!important}.repo .vg-gutter{float:left;min-width:20px;width:auto;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.repo .vg-number{cursor:pointer}.repo .vg-container{font-family:"Bitstream Vera Sans Mono","Courier New",monospace;font-size:13px;border:1px solid #222}.repo .vg-gutter{background-color:#131313;border-right:1px solid #222;text-align:right;color:#555;padding:1em .5em;margin-right:.5em}.repo .vg-code *::-moz-selection,.repo .vg-code *::-webkit-selection,.repo .vg-code *::selection,.repo .vg-line.vg-highlight{background-color:#ffc}.repo .vg-line span.vg-highlight{color:blue;font-weight:bold;text-decoration:underline}.repo .vg-container .vg-code{display:block;padding:1em .5em;background:#000}.repo .vg-code{color:#fff;background:#070700;border:0;padding:.4em}.repo .vg-code .comment,.repo .vg-code .template_comment,.repo .vg-code .diff .header,.repo .vg-code .javadoc{color:#998;font-style:italic}.repo .vg-code .keyword,.repo .vg-code .css .rule .keyword,.repo .vg-code .winutils,.repo .vg-code .javascript .title,.repo .vg-code .lisp .title,.repo .vg-code .subst{color:000;font-weight:bold}.vg-code .number,.vg-code .hexcolor{color:#40a070}.vg-code .string,.repo .vg-code .tag .value,.repo .vg-code .phpdoc,.repo .vg-code .tex .formula{color:#d14}.repo .vg-code .title,.repo .vg-code .id{color:#900;font-weight:bold}.repo .vg-code .javascript .title,.repo .vg-code .lisp .title,.repo .vg-code .subst{font-weight:normal}.repo .vg-code .class .title,.repo .vg-code .haskell .label,.repo .vg-code .tex .command{color:#458;font-weight:bold}.repo .vg-code .tag,.repo .vg-code .tag .title,.repo .vg-code .rules .property,.repo .vg-code .django .tag .keyword{color:#000080;font-weight:normal}.repo .vg-code .attribute,.repo .vg-code .variable,.repo .vg-code .instancevar,.repo .vg-code .lisp .body{color:#008080}.repo .vg-code .regexp{color:#009926}.repo .vg-code .class{color:#458;font-weight:bold}.repo .vg-code .symbol,.repo .vg-code .ruby .symbol .string,.repo .vg-code .ruby .symbol .keyword,.repo .vg-code .ruby .symbol .keymethods,.repo .vg-code .lisp .keyword,.repo .vg-code .tex .special,.repo .vg-code .input_number{color:#990073}.repo .vg-code .builtin,.repo .vg-code .built_in,.repo .vg-code .lisp .title{color:#0086b3}.repo .vg-code .codeprocessor,.repo .vg-code .pi,.repo .vg-code .doctype,.repo .vg-code .shebang,.repo .vg-code .cdata{color:#999;font-weight:bold}.repo .vg-code .deletion{background:#fdd}.repo .vg-code .addition{background:#dfd}.repo .vg-code .diff .change{background:#0086b3}.repo .vg-code .chunk{color:#aaa}.repo .vg-code .tex .formula{-ms-filter:"alpha(opacity=50)";filter:alpha(opacity=50);opacity:.5}'
            }, options);

        // Extension Hashes
        _this.extensions = {
            as          : 'actionscript',
            coffee      : 'coffeescript',
            css         : 'css',
            html        : 'html',
            js          : 'javascript',
            md          : 'markdown',
            php         : 'php',
            py          : 'python',
            rb          : 'ruby'
        };

        // Repo
        _this.repo = {
            name        : 'default',
            folders     : [],
            files       : []
        };

        // Namespace - strip out characters that would have to be escaped to be used in selectors
        _this.namespace = _this.settings.name.toLowerCase().replace(/[^a-z0-9_-]/g, '');

        // Check if this namespace is already in use
        var usedNamespaces = $('[data-id^='+ _this.namespace +']');
        if(usedNamespaces.length){
            _this.namespace += String(usedNamespaces.length);
        }

        // Insert CSS
        if(typeof _this.settings.css != 'undefined' && _this.settings.css !== '' && $('#repojs_css').length <= 0)
            $('body').prepend($('<style id="repojs_css">').html(_this.settings.css));

        // Query Github Tree API
        $.ajax({
            url: 'https://api.github.com/repos/' + _this.settings.user + '/' + _this.settings.name + '/git/trees/' + _this.settings.branch + '?recursive=1',
            type: 'GET',
            data: {},
            dataType: 'jsonp',
            success: function(response){

                var treeLength = response.data.tree.length;
                $.each(response.data.tree, function(i){

                    // Setup if last element
                    if(!--treeLength){
                        _this.container.addClass('loaded');
                        // Add 10ms timeout here as some browsers require a bit of time before calculating height.
                        setTimeout( function(){
                            transition(_this.container.find('.page').first(), 'left', true);
                        }, 10 );
                    }

                    // Return if data is not a file
                    if(this.type != 'blob')
                        return;

                    // Setup defaults
                    var first       = _this.container.find('.page').first()
                        ctx         = _this.repo,
                        output      = first,
                        path        = this.path,
                        arr         = path.split('/'),
                        file        = arr[(arr.length - 1)],
                        id          = '';

                    // Remove file from array
                    arr = arr.slice(0,-1);
                    id = _this.namespace;

                    // Loop through folders
                    $.each(arr, function(i){

                        var name    = String(this),
                            index   = 0,
                            exists  = false;

                        id = id + '_split_' + name.replace('.','_dot_');

                        // Loop through folders and check names
                        $.each(ctx.folders, function(i){
                            if(this.name == name){
                                index = i;
                                exists = true;
                            }
                        });

                        // Create folder if it doesn't exist
                        if(!exists){

                            // Append folder to DOM
                            if(output !== first){
                                output.find('ul li.back').after($('<li class="dir"><a href="#" data-id="' + id + '">' + name +'</a></li>'));
                            } else {
                                output.find('ul li').first().after($('<li class="dir"><a href="#" data-id="' + id + '">' + name +'</a></li>'));
                            }

                            // Add folder to repo object
                            ctx.folders.push({
                                name        : name,
                                folders     : [],
                                files       : [],
                                element     : $('<div class="page" id="' + id + '"><ul><li class="titles"><span>name</span></li><li class="back"><a href="#">..</a></li></ul></page>').appendTo(_this.container)[0]
                            });
                            index = ctx.folders.length-1;

                        }

                        // Change context & output to the proper folder
                        output = $(ctx.folders[index].element);
                        ctx = ctx.folders[index];

                    });

                    // Append file to DOM
                    output.find('ul').append($('<li class="file"><a href="#" data-path="' + path + '" data-id="' + id + '">' + file +'</a></li>'));

                    // Add file to the repo object
                    ctx.files.push(file);

                });

                // Bind to page links
                _this.container.on('click', 'a', function(e){

                    e.preventDefault();

                    var link        = $(this),
                        parent      = link.parents('li'),
                        page        = link.parents('.page'),
                        repo        = link.parents('.repo'),
                        el          = $('#' + link.data('id'));

                    // Is link a file
                    if(parent.hasClass('file')){

                        el = $('#' + link.data('id'));

                        if(el.legnth > 0){
                            el.addClass('active');
                        } else {
                            $.ajax({
                                url: 'https://api.github.com/repos/' + _this.settings.user + '/' + _this.settings.name + '/contents/' + link.data('path') + '?ref=' + _this.settings.branch,
                                type: 'GET',
                                data: {},
                                dataType: 'jsonp',
                                success: function(response){
                                    var fileContainer = $('<div class="file page" id="' + link.data('id') + '"></div>'),
                                        extension = response.data.name.split('.').pop().toLowerCase(),
                                        mimeType = getMimeTypeByExtension(extension);

                                    if('image' === mimeType.split('/').shift()){
                                        el = fileContainer.append($('<div class="image"><span class="border-wrap"><img src="" /></span></div>')).appendTo(repo);
                                        el.find('img')
                                            .attr('src', 'data:' + mimeType + ';base64,' + response.data.content)
                                            .attr('alt', response.data.name);
                                    }
                                    else {
                                        el = fileContainer.append($('<pre><code></code></pre>')).appendTo(repo);
                                        if(typeof _this.extensions[extension] != 'undefined')
                                            el.find('code').addClass(_this.extensions[extension]);
                                        el.find('code').html(String(decode64(response.data.content)).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;'));
                                        el.find('pre').vanGogh();
                                    }

                                    transition(el, 'left');
                                },
                                error: function(response){
                                    if(console && console.log)
                                        console.log('Request Error:', e);
                                }
                            });
                        }

                    // Is link a folder
                    } else if(parent.hasClass('dir')) {

                        _this.container
                            .find('h1')
                            .find('.active')
                            .removeClass('active')
                            .end()
                            .append('<a href="#" data-id="' + link.data('id') + '" class="active">' + link.text() + '</a>');
                        transition(el, 'left');

                    // Is link a back link
                    } else if(parent.hasClass('back')){

                        _this.container.find('h1 a').last().remove();
                        el = page[0].id.split('_split_').slice(0,-1).join('_split_');
                        el = (el == _this.namespace) ? _this.container.find('.page').first() : $('#' + el);
                        transition(el, 'right');

                    // Is nav link
                    } else {
                        el = el.length ? el : _this.container.find('.page').eq(link.index());

                        if(link[0] !== _this.container.find('h1 a')[0])
                            link.addClass('active');
                        _this.container.find('h1 a').slice((link.index()+1),_this.container.find('h1 a').length).remove();
                        transition(el, 'right');
                    }
                });
            },
            error : function(response){
                if(console && console.log)
                    console.log('Request Error:', response);
            }
        });

        // Setup repo container
        return this.each(function(){
            _this.container = $('<div class="repo"><h1><a href="#" data-id="' + _this.namespace + '_split_default">' + _this.settings.name + '</a></h1><div class="loader"></div><div class="page" id="' + _this.namespace + '_split_default"><ul><li class="titles"><span>name</span></li></ul></div></div>').appendTo($(this));
        });
    };

})(jQuery);
