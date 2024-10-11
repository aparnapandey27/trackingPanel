/*
Template Name: Festinator

File: Common Plugins Js File
*/

//Common plugins
if(document.querySelectorAll("[toast-list]") || document.querySelectorAll('[data-choices]') || document.querySelectorAll("[data-provider]")){ 
  document.writeln("<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'></script>");
  document.writeln("<script type='text/javascript' src='/assets/libs/choices.js/public/static/scripts/choices.min.js></script>");
  document.writeln("<script type='text/javascript' src='/assets/libs/flatpickr/dist/flatpickr.min.js'></script>");    
}