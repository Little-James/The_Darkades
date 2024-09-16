const up = document.querySelector("#up");
up.addEventListener("click", (event) => {
	window.scrollTo({
		left: 0,
		top: 0,
		behavior: 'smooth'
	});
});

const header = document.querySelector("header");
window.addEventListener("scroll", (event) => {

	/* timto nastavime pozici pro responzivitu na vice zarizenich */
	const positionOfHeader = header.getBoundingClientRect();

	if (window.scrollY > positionOfHeader.bottom) {
		up.classList.add("show");
	}
	else {
		up.classList.remove("show");
	}
});

/* přejetí na hlavní obsah stránky (body) po otevření prohlížeče */

window.onload = function () {
	// Automaticky plynule přejde na hlavní obsah
	document.getElementById("sect").scrollIntoView({ behavior: 'smooth' });
};


// Funkce pro plynulé scrollování
function smoothScrollTo(targetPosition, duration) {
	const startPosition = window.pageYOffset;
	const distance = targetPosition - startPosition;
	let startTime = null;

	function animation(currentTime) {
		if (startTime === null) startTime = currentTime;
		const timeElapsed = currentTime - startTime;
		const progress = Math.min(timeElapsed / duration, 4);

		// Použijeme "easeInOutQuad" pro plynulejší animaci
		const easeInOutQuad = progress * (2 - progress);

		// Scrollování na základě vypočteného času a rychlosti
		window.scrollTo(0, startPosition + distance * easeInOutQuad);

		if (timeElapsed < duration) {
			requestAnimationFrame(animation);
		}
	}

	requestAnimationFrame(animation);
}

// Automaticky scroll po načtení stránky
window.onload = function () {
	const target = document.getElementById("sect").offsetTop;

	// Scrolluj na hlavní obsah za x sekundy (x ms)
	smoothScrollTo(target, 2000);
};



