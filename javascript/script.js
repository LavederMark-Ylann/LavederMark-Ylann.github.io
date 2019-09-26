document.addEventListener("DOMContentLoaded", function(){
  $('.preloader-background').delay(1700).fadeOut('slow');
  
  $('.preloader-wrapper')
    .delay(1700)
    .fadeOut();
});
$(document).ready(function(){
  $('.scrollspy').scrollSpy();
  $('.scrollspy').on('scrollSpy:enter', function() {
    $('.nav-wrapper').find('a[href="#'+$(this).attr('id')+'"]').parent().addClass('active');
  });
  $('scrollspy').on('scrollSpy:exit', function(){
    $('.nav-wrapper').find('a[href="#'+$(this).attr('id')+'"]').parent().removeClass('active');
  })
  $('.parallax').parallax();
  $('.sidenav').sidenav();
  $('textarea#icon_prefix4').characterCounter();
  
});

function openSkill(evt, skillName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("skill");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(skillName).style.display = "block";
  evt.currentTarget.className += " active";
}

function openSubject(evt, subjectName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("matiere");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(subjectName).style.display = "block";
  evt.currentTarget.className += " active";
}

function openProject(evt, projectName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("projet");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the link that opened the tab
  document.getElementById(projectName).style.display = "block";
  evt.currentTarget.className += " active";
}



$(".lienmenu").on("click", function(e){
  $("li.lienmenu").removeClass("active");
  $(this).addClass("active");
});
