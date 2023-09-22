function loadAds() {
	const head = document.querySelector('head');
	const adsScript = document.createElement('script');

	adsScript.setAttribute('async', '');
	adsScript.setAttribute('crossorigin', 'anonymous');
	adsScript.setAttribute('src', 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6117958085618253');

	head.appendChild(adsScript);
}

window.onload = loadAds;
