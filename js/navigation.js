var portfolio_links = [
  {label:'Tableiness', url:'portfolio.html#tableiness'},
  {label:'SuperRecruiter', url:'portfolio.html#superRecruiter'},
  {label:'Walle & Eva', url:'portfolio.html#walleEva'},
  {label:'TripCast', url:'portfolio.html#tripCast'},
  {label:'Vonn Neumann Architecture Demo', url:'portfolio.html#VNAness'},
  {label:'Shift', url:'portfolio.html#Shift'},
  {label:'Arcane', url:'portfolio.html#Arcane'},
]
var p = $.map(portfolio_links, function(obj, i) {
  return '<li><a class="white-text" href="'+obj.url+'">'+obj.label+'</a></li>';
});

var nav_links = [
  {label:'ABOUT ME', url:'index.html#about'},
  {label:'SKILLS', url:'index.html#skills'},
  {label:'PORTFOLIO', url:'portfolio.html'},
  {label:'RESUME', url:'Resume.pdf'},
  {label:'CONTACT', url:'index.html#contact'},
]
function get_nav_links (type) {
  var n = $.map(nav_links, function(obj, i) {
    if(obj.label === "PORTFOLIO")
     return '<li><a class="white-text" href="'+obj.url+'" data-induration="300" data-outduration="225" data-beloworigin="true" data-hover="true" data-activates="'+type+'"">'+obj.label+'</a></li>';
    else
      return '<li><a class="white-text" href="'+obj.url+'">'+obj.label+'</a></li>';
  });
  console.log(n);
  return n;
}
$('#insert-nav').html('\
<div class="navbar">\
  <ul id="portfolioDrop" class="dropdown-content grey darken-4">'+p.join("")+'</ul>\
  <ul id="portfolioDrop-mobile" class="dropdown-content dropdown-content-mobile grey darken-4">'+p.join("")+'</ul>\
  <nav class="grey darken-4" role="navigation">\
    <div class="nav-wrapper container">\
        <a href="#!" class="brand-logo"> <img class="mylogo" src="images/logo.png" /></a>\
        <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>\
        <ul class="right hide-on-med-and-down">\
          '+get_nav_links('portfolioDrop').join("")+'\
        </ul>\
        <ul class="side-nav grey darken-4" id="nav-mobile">\
          '+get_nav_links('portfolioDrop-mobile').join("")+'\
      </ul>\
    </div>\
  </nav>\
</div>\
');
