document.addEventListener("DOMContentLoaded", function(){
  $('.preloader-background').delay(1700).fadeOut('slow');
  
  $('.preloader-wrapper')
    .delay(1700)
    .fadeOut();
});
$(document).ready(function(){
	$('.parallax').parallax();
	$('.carousel').carousel();
	$('.sidenav').sidenav();
	$('.scrollspy').scrollSpy();
	$('.scrollspy').on('scrollSpy:enter', function() {
    $('.nav-wrapper').find('a[href="#'+$(this).attr('id')+'"]').parent().addClass('active');
	});
	$('scrollspy').on('scrollSpy:exit', function(){
	$('.nav-wrapper').find('a[href="#'+$(this).attr('id')+'"]').parent().removeClass('active');
	})
	$('.tabs').tabs();
	$('.tooltipped').tooltip();
	$('.modal').modal();
	$('.slider').slider();
	});
      
Amplitude.init({
    "bindings": {
      37: 'prev',
      39: 'next',
      32: 'play_pause'
    },
    "songs": [
    {
     "name": "Couch Potato",
     "artist": "Jakubi",
     "album": "Holiday",
     "url": "./audio/couch.mp3",
     "cover_art_url": "https://f4.bcbits.com/img/a1498885152_10.jpg"
   },
   {
     "name": "They Reminisce Over You (Poldoore Remix)",
     "artist": "Pete Rock & C.L. Smooth",
     "album": "Hip Hop Soul Party 3",
     "url": "./audio/poldoore.mp3",
     "cover_art_url": "https://i.imgur.com/yAMIrIN.jpg"
   },
   {
     "name": "Pumped Up Kicks",
     "artist": "Foster the People",
     "album": "Torches",
     "url": "./audio/pumpedup.mp3",
     "cover_art_url": "https://is1-ssl.mzstatic.com/image/thumb/Music5/v4/3b/36/dc/3b36dc9c-c1c3-4fe6-047e-f07ac0e12722/dj.lajxsvkg.jpg/600x600bf.png"
   },
   {
     "name": "Tank!",
     "artist": "Seatbelts",
     "album": "Cowboy Bebop",
     "url": "./audio/tank.mp3",
     "cover_art_url": "https://i.kfs.io/album/global/12299034,0v1/fit/500x500.jpg"
   },
   {
     "name": "Aerodynamic",
     "artist": "Daft Punk",
     "album": "Discovery",
     "url": "./audio/aero.mp3",
     "cover_art_url": "https://images-na.ssl-images-amazon.com/images/I/410UITi3BhL.jpg"
   },
   {
     "name": "Childish war",
     "artist": "Kagamine Rin & Len (Reol ft. kradness)",
     "album": "KRAD VORTEX",
     "url": "./audio/childishwar.mp3",
     "cover_art_url": "https://i.imgur.com/kyrdg1L.jpg"
   },
   {
     "name": "Lose Yourself",
     "artist": "Eminem",
     "album": "8 Mile",
     "url": "./audio/eminem.mp3",
     "cover_art_url": "https://is2-ssl.mzstatic.com/image/thumb/Music/y2004/m06/d08/h21/s06.yffhaixw.jpg/600x600bf.png"
   },
   {
     "name": "Kimagure Mercy",
     "artist": "Hatsune Miku (HachiojiP)",
     "album": "(Single)",
     "url": "./audio/hmiku.mp3",
     "cover_art_url": "https://zenius-i-vanisher.com/simfiles/Supra%27s%20Song%20Pack/KIMAGURE%20MERCY/KIMAGURE%20MERCY-jacket.png"
   },
   {
     "name": "Do it for love",
     "artist": "P-Holla",
     "album": "The Sara Bareilles project",
     "url": "./audio/pholla.mp3",
     "cover_art_url": "https://i1.sndcdn.com/artworks-000015836236-zdkul0-t500x500.jpg"
   },
   {
     "name": "Stairway to Heaven",
     "artist": "Led Zeppelin",
     "album": "(Sans nom)",
     "url": "./audio/stairway.mp3",
     "cover_art_url": "https://www.ultimate-guitar.com/static/article/news/1/69761_ver1516630290.jpg"
   },
   {
     "name": "Down the road",
     "artist": "C2C",
     "album": "Tetra",
     "url": "./audio/c2c.mp3",
     "cover_art_url": "https://images-na.ssl-images-amazon.com/images/I/71N4r1LnhsL._SL1400_.jpg"
   }
   ]
 });

function goodbye() {
  var audio = new Audio('./audio/game.mp3');
  audio.play();
  setTimeout(actu, 1250);
}

function actu(){
	location.reload();
}