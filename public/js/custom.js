var open = [];

// Redirect
function redirect (location, delay = 0) {
	setTimeout(function() { window.location = location; }, delay);
}

// Alerts
$('.alert').delay(5000).fadeOut();

// Add slide up & down animation to Bootstrap dropdown when expanding.
$('.dropdown').on('show.bs.dropdown', function () {
	$(this).find('.dropdown-menu').first().stop(true, true).slideDown();
});

$('.dropdown').on('hide.bs.dropdown', function () {
	$(this).find('.dropdown-menu').first().stop(true, true).slideUp(0);
});

// Preview image
function previewFile() {
	var file = document.querySelector('#new-pic-input').files[0];
	var size = Math.round(file.size/1024);
	var type = file.type;
	var reader = new FileReader();

	reader.addEventListener('load', function () {
		$('#new-pic-output').removeClass('hide');
		
		if (size <= 500 && (type == 'image/png' || type == 'image/jpg' || type == 'image/jpeg' || type == 'image/gif')) {
			$('#image-upload-error').remove();
			$('#new-pic-output').attr('src', reader.result);
			open['newImgSrc'] = reader.result;
		} else if (size > 500) {
			$('#src-new-pic').remove();
			$('#image-upload-error').remove();
			$('#new-pic-output').addClass('hide');
			$('#new-pic-input').after('<div class="error" id="image-upload-error">Maximaal 500 KB</div>');
		} else {
			$('#src-new-pic').remove();
			$('#image-upload-error').remove();
			$('#new-pic-output').addClass('hide');
			$('#new-pic-input').after('<div class="error" id="image-upload-error">Alleen png, jp(e)g of gif</div>');
		}

	}, false);

	if (file) {
		reader.readAsDataURL(file);
	}
}

