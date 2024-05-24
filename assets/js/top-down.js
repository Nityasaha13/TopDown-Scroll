document.addEventListener("DOMContentLoaded", function() {
  var scrollToTopBtn = document.getElementById("td-scroll-to-top");
  var scrollToBottomBtn = document.getElementById("td-scroll-to-down");

  // Check if the scroll-to-top button exists and add event listener
  if (scrollToTopBtn) {
      scrollToTopBtn.addEventListener("click", function() {
          window.scrollTo({
              top: 0,
              behavior: "smooth"
          });
      });
  }

  // Check if the scroll-to-bottom button exists and add event listener
  if (scrollToBottomBtn) {
      scrollToBottomBtn.addEventListener("click", function() {
          window.scrollTo({
              top: document.body.scrollHeight,
              behavior: "smooth"
          });
      });
  }
});
