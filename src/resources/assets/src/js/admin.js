jQuery(function($) {
    // Delete confirmation
	jQuery(function() {
		$("a.delete, a.remove-item").on(function (e) {
			e.preventDefault();
			e.stopPropagation();
			if (confirm("Are you sure you want to delete?")) {
				window.location = $(this).attr("href");
			}
		});
	});

    // Delete confirmation AJAX
	jQuery(function() {
		$("body").on('button.delete', 'click', function (e) {
			e.preventDefault();
		});
	});

    // CTRL + S to save in admin
    jQuery(document).on(function (event) {
        if (!(String.fromCharCode(event.which).toLowerCase() === 's' && event.ctrlKey) && event.which !== 19)
            return true;
        $(".save").trigger("click");
        event.preventDefault();
        return false;
    });

	jQuery(document).on(function () {
		$('ul.account').on(function (e) {
			e.stopPropagation();
			$(this).find('.submenu-down').fadeToggle();
		});
	});

	jQuery(document).on(function () {
		$('body').on(function () {
			$('ul.account').find('.submenu-down').fadeOut();
		});
	});

    // on change submit sort
	jQuery(function() {
		$('.sort-search-wrap .select-style').change(function () {
			$(this).parent().submit();
		});
	});

    // datapicker
	jQuery(function() {
		$('.datepicker').datepicker({
			dateFormat: 'yy-mm-dd',
			altField: '#date',
			yearRange: '1930:' + (new Date).getFullYear()
		});
	});

	jQuery(function() {
		$('.icon-menu').on(function () {
			$(this).toggleClass('open');
			$(this).parent().toggleClass('open');

			$(this).siblings('.submenu').slideToggle();
		});
	});

	jQuery(function() {
		$('.input-box-wrap .button').on(function () {
			$('.input-popup').fadeToggle();
		});
	});

	jQuery(function() {
		$(".upload").on(function () {
			readImageFromInput(this);
		});
	});
});

$(window).on("load", function () {
    hideAlert();

	jQuery(function() {
		$(".sortable").sortable({
			stop: function (event, ui) {
				var order = [];
				var sortingObject = $(this);
				var link = sortingObject.data('link');

				sortingObject.find('.items-order').each(function () {
					order.push($(this).data('id'));
				});

				if ($(ui.item).next('.no-scrolable').length > 0) {
					sortingObject.sortable('cancel');
				}

				if (!sortingObject.hasClass("no-ajax")) {
					$.post(link, {order: order}, function (data) {
						if (data === 'Success') {
							$(sortingObject).parent().append("<span class='alert alert-success'>Order saved!</span>");
						} else {
							$(sortingObject).parent().append("<span class='alert alert-error'>Order saving error!</span>");
						}
						hideAlert();
					});
				}
			},
			cancel: ".no-scrolable"
		});
	});

	jQuery(function() {
		$('.copy').on(function () {
			$(this).addClass('clicked');
			setTimeout(function () {
				$('.copy.clicked').removeClass('clicked');
			}, 1000);
		});
	});
});

function codeAddress(address, proposal, resultsMap) {
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            $('#latitude').val(results[0].geometry.location.lat())
            $('#longitude').val(results[0].geometry.location.lng())
            if (!empty(resultsMap)) {
                resultsMap.setCenter(results[0].geometry.location);
                deleteMarkers();
                var marker = new google.maps.Marker({
                    icon: 'images/map-marker-orange.png',
                    map: resultsMap,
                    position: results[0].geometry.location
                });
                markers.push(marker);
            }
        } else {
            alert("We couldn't find your address: " + status);
        }
        if (!empty(proposal)) {
            var mapSrc = 'https://maps.googleapis.com/maps/api/staticmap?center=' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng() + '&zoom=' + resultsMap.getZoom() + '&scale=2&size=640x300&maptype=roadmap&key=AIzaSyCvMo4tix_7-gqUXt4QQuA8buWLcxzLyMw&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xf17201%7Clabel:%7C' + results[0].geometry.location.lat() + ',' + results[0].geometry.location.lng()
            $('#mapImage').val(mapSrc);
        }
    });
}

function codeAddressAjax(item_id, address) {
    geocoder.geocode({'address': address}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            var data = {
                'latitude': results[0].geometry.location.lat(),
                'longitude': results[0].geometry.location.lng()
            };
            updateTrackRecordItemLocation(item_id, data);
        } else if (status === google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            setTimeout('codeAddressAjax(' + item_id + ',"' + address.replace(/'/g, '') + '")', 1000);
        } else {
            alert("We couldn't find your address: " + status);
        }
    });
}

function hideAlert() {
    setTimeout(function () {
        if (!$('.alert').hasClass('no-hide')) {
            $('.alert').slideUp(function () {
                $(this).remove();
            });
        }
    }, 5000);
}

function ajaxDeleteGalleryImage(url, id) {
    if (confirm("Are you sure you want delete?")) {
        $.post(url, function (data) {
            if (data) {
                $('[data-id=' + id + ']').remove();
            }
        });
    }
}

function readImageFromInput(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(input).parent().parent().find('.small-image-preview').remove();
            $(input).parent().parent().find('[type=checkbox]').remove();
            $(input).parent().parent().find('label').remove();
            $(input).parent().parent().append('<div class="small-image-preview" style="background-image: url(' + e.target.result + ')"></div>');
        };
        reader.readAsDataURL(input.files[0]);
    }
}