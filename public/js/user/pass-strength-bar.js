jQuery(document).ready(function () {
	"use strict";
	var options = {};
	options.ui = {
		container: "#pwd-container",
		viewports: {
			progress: ".pwstrength_viewport_progress",
			verdict: ".pwstrength_viewport_verdict"
		}
	};
	options.common = {
		onLoad: function () {
			$('#messages').text('Start typing password');
		},
		zxcvbn: true
	};
	$(':password').pwstrength(options);
});