const ENV = 'dev';

jQuery(function() {

	window.cookieconsent.initialise({
		"palette": {
			"popup": {
				"background": "#edeff5",
				"text": "#838391"
			},
			"button": {
				"background": "#007bff"
			}
		},
		"position": "bottom-right",
		"content": {
			"message": "This website uses cookies to ensure you get the best experience on our website.",
			"dismiss": "Got it !",
			"link": "Learn more"
		}
	});

	$('.setLanguage').click((event) => {
		event.preventDefault();

		var language = $(event.currentTarget).data('lang');

		$.post(location.origin + '/language', { language }).done(() => {
			location.reload();
		});
	});
});
