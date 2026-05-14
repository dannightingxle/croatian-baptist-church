(function () {
	'use strict';
	var toggle = document.querySelector('.nav-toggle');
	var nav    = document.getElementById('primary-nav');
	if (!toggle || !nav) return;
	toggle.addEventListener('click', function () {
		var open = nav.classList.toggle('is-open');
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
	});
	// Close on link click (mobile)
	nav.querySelectorAll('a').forEach(function (a) {
		a.addEventListener('click', function () {
			if (window.innerWidth <= 880) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			}
		});
	});
})();
