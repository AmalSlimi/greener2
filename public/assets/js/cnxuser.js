var signupBtn = document.getElementById('signup');
var signinBtn = document.getElementById('signin');
	var pinkbox = document.querySelector('.pinkbox');
	var signin = document.querySelector('.signin');
	var signup = document.querySelector('.signup');
	
	signupBtn.addEventListener('click', function () {
	pinkbox.style.transform = 'translateX(80%)';
	signin.classList.add('nodisplay');
	signup.classList.remove('nodisplay');
	});
	
	signinBtn.addEventListener('click', function () {
	pinkbox.style.transform = 'translateX(0%)';
	signup.classList.add('nodisplay');
	signin.classList.remove('nodisplay');
	});