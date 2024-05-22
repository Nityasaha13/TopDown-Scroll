
document.addEventListener("DOMContentLoaded", function() {
    
    var scrollToTopBtn = document.getElementById("td-scroll-to-top");
    var scrollToBottomBtn = document.getElementById("td-scroll-to-down");
  
    scrollToTopBtn.addEventListener("click", function() {
      window.scrollTo({
        top: 0,
        behavior: "smooth" 
      });
    });
  
    scrollToBottomBtn.addEventListener("click", function() {
      window.scrollTo({
        top: document.body.scrollHeight,
        behavior: "smooth"
      });
    });
  });
  