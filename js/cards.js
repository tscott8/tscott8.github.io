var array = [
{id:'tableiness', imgURL:'http://i.stack.imgur.com/7611u.png', cTitle:'Tableiness', smText:'A Java Program built to generate truth tables to assist Discrete Math students.', lgText:'A Java Program built to generate truth tables to assist Discrete Math students.', repoID:'repo2', actionURL:'https://github.com/tscott8/cs246/raw/master/TruthTableVUE.jar', actionText:'Download'},
{id:'superRecruiter', imgURL:'images/superRecruiterScreenshot.png', cTitle:'Super Recruiter', smText:'A limited career recruitment App, still has a lot of room to grow.', lgText:'A limited career recruitment App, still has a lot of room to grow.', repoID:'repo3', actionURL:'http://tscott8.github.io/superRecruiter/Startup.html', actionText:'Full Demo'},
{id:'tripCast', imgURL:'https://github.com/tscott8/TripCast/blob/master/WeatherAppStore/src/main/webapp/files/index.JPG?raw=true', cTitle:'Super Recruiter', smText:'An app to help you map the weather before a trip.', lgText:'An app to help you map the weather before a trip.', repoID:'repo4', actionURL:'http://tscott8.github.io/TripCast/WeatherAppStore/src/main/webapp/appStore.html', actionText:'Full Demo'},
{id:'VNAness', imgURL:'https://github.com/tscott8/VNAness/raw/master/images/3.png', cTitle:'VNAness', smText:'Visual tool for understanding the basic architecture of a PC.', lgText:'Visual tool for understanding the basic architecture of a PC.', repoID:'repo5', actionURL:'http://tscott8.github.io/VNAness/VNADemo.html', actionText:'Full Demo'},
{id:'Shift', imgURL:'http://blog.mailgun.com/content/images/2016/09/ml.jpg', cTitle:'Shift', smText:'Using clustering algorithms to predict better recommendations on Spotify.', lgText:'Using clustering algorithms to predict better recommendations on Spotify.', repoID:'repo6', actionURL:'http://tscott8.github.io/shift', actionText:'Unavailable'},
{id:'Arcane', imgURL:'https://github.com/tscott8/sr_project_research/blob/master/arcane/static/images/audience-desktop.jpg?raw=true', cTitle:'Arcane', smText:'Streaming Service, Customizeable Music Player, and more.', lgText:'Streaming Service, Customizeable Music Player, and more.', repoID:'repo7', actionURL:'http://tscott8.github.io/arcane', actionText:'Under Construction'},
]
// var el = $.map(array, function(obj, i) {
//   return (
//     '<div class="col s12 m6">\
//         <div id="' + obj.id + '" class="card medium grey darken-3 sticky-action">\
//           <div class="card-image waves-effect waves-block waves-light">\
//             <img class="activator" src="' + obj.imgURL + '">\
//           </div>\
//           <div class="card-content grey darken-3">\
//             <span class="card-title activator white-text">' + obj.cTitle + '<i class="material-icons right">more_vert</i></span>\
//             <p>' + obj.smText + '</p>\
//           </div>\
//           <div class="card-reveal grey darken-3">\
//             <span class="card-title white-text">' + obj.cTitle + '<i class="material-icons right white-text">close</i></span>\
//             <p>'+obj.lgText+'</p>\
//             <div id="'+obj.repoID+'"></div>\
//           </div>\
//           <div class="card-action grey darken-3">\
//             <a class="pink-text" href="' + obj.actionURL + '">' + obj.actionText + '</a>\
//           </div>\
//         </div>\
//       </div>');
//     });

var el = $.map(array, function(obj, i) {
  return (
    '<div class="col s12 m6">\
        <div id="' + obj.id + '" class="card medium grey darken-3 sticky-action">\
          <div class="card-image waves-effect waves-block waves-light">\
            <img class="activator" src="' + obj.imgURL + '">\
          </div>\
          <div class="card-content grey darken-3">\
            <span class="card-title activator white-text">' + obj.cTitle + '<i class="material-icons right">more_vert</i></span>\
            <p>' + obj.smText + '</p>\
          </div>\
          <div class="card-reveal grey darken-3">\
            <span class="card-title white-text">Source Code<i class="material-icons right white-text">close</i></span>\
            <div id="'+obj.repoID+'"></div>\
          </div>\
          <div class="card-action grey darken-3">\
            <a class="pink-text" href="' + obj.actionURL + '">' + obj.actionText + '</a>\
          </div>\
        </div>\
      </div>');
    });
document.write(el.join(""));
// $(".element").html(el.join(""));
