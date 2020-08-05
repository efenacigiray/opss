////////////////////////////////
// Form File Upload Functions //
////////////////////////////////

"use strict";

$(document).ready(function(){

	/**
	 * engz_dropzone created the customized dropzone feature
	 */
	function engz_dropzone(){
		// "fileUploadLight" is the camelized version of the HTML element's ID
		Dropzone.options.fileUploadLight = {
			init: function(){
				this.on("addedfile", function(file){
					$("#customized-dropzone-results-light > p").hide();
				});
				this.on("complete", function(file){
					$('.sample-image-light-bg').attr({
						'src' : 'view/template/b5b_qore_engine/themes/circloid_2/default/images/user_upload/logo-mixed.png'
					});
					$("#customized-dropzone-results-light .dz-preview").delay(2500).fadeOut(300, function(){
						$(this).remove();
						$("#customized-dropzone-results-light > p").fadeIn(300);
					});
				});
			},
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 2, // MB
			acceptedFiles: "image/*",
			uploadMultiple: false,
			createImageThumbnails: false,
			previewsContainer: "#customized-dropzone-results-light",
			previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-filename"><span><strong>Filename:</strong></span> <span data-dz-name></span></div><div class="dz-size"><span><strong>Size:</strong></span> <span data-dz-size></span></div><div class="dz-progress"><span class="progress"><span class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></span></span></div>'
		};

		// "fileUploadDark" is the camelized version of the HTML element's ID
		Dropzone.options.fileUploadDark = {
			init: function(){
				this.on("addedfile", function(file){
					$("#customized-dropzone-results-dark > p").hide();
				});
				this.on("complete", function(file){
					$('.sample-image-dark-bg').attr({
						'src' : 'view/template/b5b_qore_engine/themes/circloid_2/default/images/user_upload/logo-white-mixed.png'
					});
					$("#customized-dropzone-results-dark .dz-preview").delay(2500).fadeOut(300, function(){
						$(this).remove();
						$("#customized-dropzone-results-dark > p").fadeIn(300);
					});
				});
			},
			paramName: "file", // The name that will be used to transfer the file
			maxFilesize: 2, // MB
			acceptedFiles: "image/*",
			uploadMultiple: false,
			createImageThumbnails: false,
			previewsContainer: "#customized-dropzone-results-dark",
			previewTemplate: '<div class="dz-preview dz-file-preview"><div class="dz-filename"><span><strong>Filename:</strong></span> <span data-dz-name></span></div><div class="dz-size"><span><strong>Size:</strong></span> <span data-dz-size></span></div><div class="dz-progress"><span class="progress"><span class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></span></span></div>'
		};
	}

	/* Call Functions */
	engz_dropzone();
});