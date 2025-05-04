document.addEventListener("DOMContentLoaded", function () {
    const tableWrapper = document.querySelector(".bct-table-wrapper");
  
    if (!tableWrapper) return;
  
    const animationType = tableWrapper.getAttribute("data-animation");
  
    switch (animationType) {
      case "fade":
        tableWrapper.style.animationName = "fadeIn";
        break;
      case "slide":
        tableWrapper.style.animationName = "slideIn";
        break;
      case "zoom":
        tableWrapper.style.animationName = "zoomIn";
        break;
      case "bounce":
        tableWrapper.style.animationName = "bounceIn";
        break;
      default:
        break;
    }
  });
  