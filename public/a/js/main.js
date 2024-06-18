
;(function(document, window, undefined) {

	'use strict';

	if (!document.addEventListener) {
		return;
	}

	var map_colours = {},
		map_svg_ref,
		map_svg_doc,
		map_ready = false,
		path_id,
		button_names_ref,
		button_names_shown = false;

	function map_loaded() {

		map_svg_ref.style.display = 'block';

		var colour_wrapper = map_svg_doc.getElementById('colours'),
			colour_refs = [];

		if (colour_wrapper) {
			colour_refs = colour_wrapper.getElementsByTagName('path');
		}

		for (var k = (colour_refs.length - 1); k >= 0; k--) {
			path_id = parseInt(colour_refs[k].getAttribute('data-id'), 10);
			if (map_colours[path_id]) {
				colour_refs[k].setAttribute('fill', map_colours[path_id]['c']);
			}
		}

		map_ready = true;

		if (button_names_ref) {
			button_names_ref.removeAttribute('disabled');
		}

	}

	function toggle_names() {

		if (map_ready) {

			var lines_wrapper = map_svg_doc.getElementById('lines'),
				names_wrapper = map_svg_doc.getElementById('country_names');

			if (lines_wrapper && names_wrapper) {
				if (button_names_shown) {
					lines_wrapper.style.display = 'none';
					names_wrapper.style.display = 'none';
				} else {
					lines_wrapper.style.display = 'inline';
					names_wrapper.style.display = 'inline';
				}
				button_names_shown = !(button_names_shown);
			}

		}

	}

	function init() {

		//--------------------------------------------------
		// Colours specified in the HTML

			var table_ref = document.getElementById('tableBody'),
				table_rows = [],
				row_id = null;

			if (table_ref) {
				table_rows = table_ref.getElementsByTagName('tr');
				for (var k = (table_rows.length - 1); k >= 0; k--) {
					row_id = parseInt(table_rows[k].getAttribute('data-id'), 10);
					if (row_id > 0) {

						map_colours[row_id] = {
								'c': table_rows[k].getAttribute('data-colour'),
								't': table_rows[k].getAttribute('data-text'),
								'b': table_rows[k].getAttribute('data-battalions')
							};

					}
				}
			}

		//--------------------------------------------------
		// SVG Map

			map_svg_ref = document.getElementById('map');
			if (map_svg_ref) {

				//--------------------------------------------------
				// Temp hide

					map_svg_ref.style.display = 'none';

				//--------------------------------------------------
				// Toggle buttons

					var p = document.createElement('p');

					button_names_ref = document.createElement('button');
					button_names_ref.setAttribute('disabled', 'disabled');
					button_names_ref.addEventListener('click', toggle_names);
					button_names_ref.textContent = 'Names';

					p.appendChild(button_names_ref);

					map_svg_ref.parentNode.insertBefore(p, map_svg_ref.nextSibling);

				//--------------------------------------------------
				// SVG ref

					map_svg_doc = map_svg_ref.getSVGDocument();

					if (map_svg_doc) {

						map_loaded();

					} else {

						map_svg_ref.addEventListener('load', function() {
								map_svg_doc = map_svg_ref.getSVGDocument();
								if (map_svg_doc) {
									map_loaded();
								}
							});

					}

			}

	}

	if (document.readyState !== 'loading') {
		window.setTimeout(init); // Handle asynchronously
	} else {
		document.addEventListener('DOMContentLoaded', init);
	}

})(document, window);
