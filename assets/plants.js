jQuery(function() {
	const search = instantsearch({
		appId: 'HXKCUJ2CLO',
		apiKey: '8c007e787a8d136b64119d973fef596f',
		indexName: 'plants',
		urlSync: true
	});

	search.addWidget(
		instantsearch.widgets.searchBox({
			container: '#search-box',
			placeholder: 'Search for products'
		})
	);

	search.addWidget(
		instantsearch.widgets.hits({
			container: '#hits',
			templates: {
				empty: 'No results',
				item: '<strong>Nom scientifique : </strong> {{{_highlightResult.ScientificName.value}}}'
			}
		})
	);

	search.start();

	serialize = function(obj) {
		var str = [];
		for(var p in obj)
		if (obj.hasOwnProperty(p)) {
			str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
		}
		return str.join("&");
	}

	var results = $('#results');

	$('#plant_input').keyup(function(event) {
		var path = location.origin + '/plantsAPI';

		results.html('');

		$.get(path, serialize({ db: 'plant', table: 'data', column: 'ScientificName', value: $(this).val() })).done((data) => {
			if(data.length == 0) {
				results.html('<div class="alert alert-info">No results</div>');
			} else {
				results.append(data.length + ' résultats trouvés<br><br>');
				for(plant in data) {
					let html = "";
					html += '<div class="card plant-card">';
					html += '<h4 class="card-header">'+ data[plant].CommonName +'</h4>';
					html += '<div class="card-body">';
					html += '<p class="card-text">'+ data[plant].ScientificName +'</p>';
					html += '</div>';
					html += '</div>';
					html += '<br>';
					results.append(html);
				}
			}
		});
	});
});
