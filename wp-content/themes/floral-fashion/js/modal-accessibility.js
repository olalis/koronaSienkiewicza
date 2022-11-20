jQuery(document).ready(function ($) {
    
    /**
     * =========================
     * trap focus jquery for secondary navigation
     * =========================
     */
     var focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
     var modals = document.querySelector(".site-header.style-four  .secondary-nav div "); // select the modal by it's element
     if (modals == null) {
         return;
     } 
    
   var closeBttn = document.querySelector('#closeBttn'); // select the modal by it's id
   var firstFocusableElements = modals.querySelectorAll(focusableElements)[0]; // get first element to be focused inside modal
    
   var focusableContents = modals.querySelectorAll(focusableElements);
   var lastFocusableElements = focusableContents[focusableContents.length - 1]; // get last element to be focused inside modal
     
 
   document.addEventListener('keydown', function (e) {
       var isTabPressed = e.key === 'Tab' || e.which == 9;
       if (!isTabPressed) {
           return;
       }
       if (e.shiftKey) {
           // if shift key pressed for shift + tab combination
           if (document.activeElement === firstFocusableElements) {
               lastFocusableElements.focus(); // add focus for the last focusable element
               e.preventDefault();
           }
       } else {
           // if tab key is pressed
           if (document.activeElement === lastFocusableElements) {
               // if focused has reached to last focusable element then focus first focusable element after pressing tab
             //   firstFocusableElements.focus(); // add focus for the first focusable element
               closeBttn.focus(); // add focus for the first focusable element
               e.preventDefault();
           }
       }
   });
   firstFocusableElements.focus();
    /**
     * =========================
     * trap focus jquery for secondary navigation
     * =========================
     */
  


     });
  