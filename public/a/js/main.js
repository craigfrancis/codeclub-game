
;(function(document, window, undefined) {

	'use strict';

	if (!document.addEventListener) {
		return;
	}

	var map_colours = {},
		map_svg_ref,
		map_svg_doc,
		path_id;

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
		// SVG ref

			map_svg_ref = document.getElementById('map');
			if (map_svg_ref) {

				map_svg_ref.style.display = 'none';

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
