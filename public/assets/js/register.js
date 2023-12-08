
	// Variables
    let current_fs,
    next_fs,
    previous_fs; // fieldsets
    let left,
    opacity,
    scale; // fieldset properties which we will animate
    let animating;
    // flag to prevent quick multi-click glitches
    
    // Function for next button click
    function handleClickNext() {
    if (animating) 
    return false;
    
    
    
    animating = true;
    
    current_fs = this.parentNode;
    next_fs = this.parentNode.nextElementSibling;
    
    // Activate next step on progressbar using the index of next_fs
    document.querySelectorAll("fieldset").forEach(function (elem, index) {
    if (elem === next_fs) {
    document.querySelectorAll("#progressbar li")[index].classList.add("active");
    }
    });
    
    // Show the next fieldset
    next_fs.style.display = "block";
    
    // Hide the current fieldset with style
    let opacityValue = 1;
    let interval = setInterval(function () {
    // As the opacity of current_fs reduces to 0
    // 1. Scale current_fs down to 80%
    scale = 1 - (1 - opacityValue) * 0.2;
    // 2. Bring next_fs from the right(50%)
    left = (opacityValue * 50) + "%";
    // 3. Increase opacity of next_fs to 1 as it moves in
    opacity = 1 - opacityValue;
    current_fs.style.transform = "scale(" + scale + ")";
    current_fs.style.position = "absolute";
    next_fs.style.left = left;
    next_fs.style.opacity = opacity;
    opacityValue -= 0.1;
    
    if (opacityValue <= 0) {
    clearInterval(interval);
    current_fs.style.display = "none";
    animating = false;
    }
    }, 80);
    // Duration
    
    // Custom easing function
    function easeInOutBack(t, b, c, d, s) {
    if (s === undefined) 
    s = 1.70158;
    
    
    
    if ((t /= d / 2) < 1) 
    return c / 2 * (t * t * (((s *=( 1.525)) + 1) * t - s)) + b;
    
    
    
    return c / 2 * ((t -= 2) * t * (((s *=( 1.525)) + 1) * t + s) + 2) + b;
    }
    }
    
    // Function for previous button click
    function handleClickPrevious() {
    if (animating) 
    return false;
    
    
    
    animating = true;
    
    current_fs = this.parentNode;
    previous_fs = this.parentNode.previousElementSibling;
    
    // De-activate current step on progressbar
    document.querySelectorAll("fieldset").forEach(function (elem, index) {
    if (elem === current_fs) {
    document.querySelectorAll("#progressbar li")[index].classList.remove("active");
    }
    });
    
    // Show the previous fieldset
    previous_fs.style.display = "block";
    
    // Hide the current fieldset with style
    let opacityValue = 1;
    let interval = setInterval(function () {
    // As the opacity of current_fs reduces to 0
    // 1. Scale previous_fs from 80% to 100%
    scale = 0.8 + (1 - opacityValue) * 0.2;
    // 2. Take current_fs to the right(50%) - from 0%
    left = ((1 - opacityValue) * 50) + "%";
    // 3. Increase opacity of previous_fs to 1 as it moves in
    opacity = 1 - opacityValue;
    current_fs.style.left = left;
    previous_fs.style.transform = "scale(" + scale + ")";
    previous_fs.style.opacity = opacity;
    opacityValue -= 0.1;
    
    if (opacityValue <= 0) {
    clearInterval(interval);
    current_fs.style.display = "none";
    animating = false;
    }
    }, 80);
    // Duration
    
    // Custom easing function
    function easeInOutBack(t, b, c, d, s) {
    if (s === undefined) 
    s = 1.70158;
    
    
    
    if ((t /= d / 2) < 1) 
    return c / 2 * (t * t * (((s *=( 1.525)) + 1) * t - s)) + b;
    
    
    
    return c / 2 * ((t -= 2) * t * (((s *=( 1.525)) + 1) * t + s) + 2) + b;
    }
    }
    
    // Attach event listeners to the buttons
    document.querySelectorAll(".next").forEach(function (button) {
    button.addEventListener("click", handleClickNext);
    });
    
    document.querySelectorAll(".previous").forEach(function (button) {
    button.addEventListener("click", handleClickPrevious);
    });