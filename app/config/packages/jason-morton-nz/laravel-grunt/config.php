<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Assets Folder Base Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your assets
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'assets_path' => 'public/cms_assets/assets',

	/*
	|--------------------------------------------------------------------------
	| Published Assets Folder Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your completed compiled,
	| minified and linted assets to be published to directory. We've set a 
	| sensible default, but feel free to update it.
	|
	*/
	'publish_path' => 'public/cms_assets',

	/*
	|--------------------------------------------------------------------------
	| The CSS Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your CSS
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'css_path' => 'public/cms_assets/css',

	/*
	|--------------------------------------------------------------------------
	| The CSS File Order
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom order in which
	| CSS files will be concatenated, compiled and minified.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'css_files' => array(
		'public/cms_assets/sass.css',
	),

	/*
	|--------------------------------------------------------------------------
	| The JavaScript Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your JavaScript
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'js_path' => 'public/cms_assets/js',

	/*
	|--------------------------------------------------------------------------
	| The JavaScript File Order
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom order in which
	| JavaScript files will be concatenated, compiled and minified.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'js_files' => array(
            //JQUERY + UI
            'public/cms_assets/vendor/jquery/jquery.js',
            'public/cms_assets/vendor/jquery-ui/ui/jquery-ui.js',
            
            //BOOTSTRAP
            'public/cms_assets/vendor/bootstrap-sass/js/bootstrap.js',
            'public/cms_assets/vendor/bootstrap-sass/js/alert.js',
            'public/cms_assets/vendor/bootstrap-sass/js/modal.js',
            'public/cms_assets/vendor/bootstrap-sass/js/tab.js',
            
            //JSTREE
            'public/cms_assets/vendor/jstree/dist/jstree.js',
            
            //BlueIMP FiLE UPLOADER.
            'public/cms_assets/vendor/blueimp-tmpl/js/tmpl.min.js',
            'public/cms_assets/vendor/blueimp-load-image/js/load-image.min.js',
            'public/cms_assets/vendor/blueimp-canvas-to-blob/js/canvas-to-blob.min.js',

            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.iframe-transport.js',
            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.fileupload.js',
            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.fileupload-process.js',
            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.fileupload-image.js',
            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.fileupload-audio.js',
            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.fileupload-video.js',
            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.fileupload-validate.js',
            'public/cms_assets/vendor/blueimp-file-upload/js/jquery.fileupload-ui.js',
            
            //TINY MCE
            'public/cms_assets/vendor/tinymce-builded/js/tinymce/tinymce.jquery.js' 
	),

    	// JavaScript files in order you'd like them concatenated and minified

    
    
	/*
	|--------------------------------------------------------------------------
	| The LESS Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your LESS
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'less_path' => 'assets/less',

	/*
	|--------------------------------------------------------------------------
	| The Main LESS file
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your main LESS
	| file, which should include all imports to other LESS files.
	| We've set a sensible default, but feel free to update it.
	|
	| Note: you LESS will be compiled into a file named "less.css" in the
	| specified "css_path" above. So be sure to add it into your "css_files" array
	*/
	'less_file' => 'assets/less/main.less',

	/*
	|--------------------------------------------------------------------------
	| The SASS Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your SASS
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'sass_path' => 'public/cms_assets/sass',

	/*
	|--------------------------------------------------------------------------
	| The Main SASS file
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your main SASS
	| file, which should include all imports to other SASS files.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'sass_file' => 'public/cms_assets/sass/main.scss',

	/*
	|--------------------------------------------------------------------------
	| The Stylus Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your Stylus
	| directory. We've set a sensible default, but feel free to update it.
	|
	*/
	'stylus_path' => 'assets/stylus',

	/*
	|--------------------------------------------------------------------------
	| The Main Stylus file
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path to your main Stylus
	| file, which should include all imports to other Stylus files.
	| We've set a sensible default, but feel free to update it.
	|
	*/
	'stylus_file' => 'assets/stylus/main.stylus',

	/*
	|--------------------------------------------------------------------------
	| Bower Dependencies (vendor) Folder Path
	|--------------------------------------------------------------------------
	|
	| This is where you can specify a custom path for you bower dependencies to
	| reside in. We've set a sensible default, but feel free to update it.
	|
	*/
	"vendor_path" => "public/cms_assets/vendor",

	/*
	|--------------------------------------------------------------------------
	| Bower Dependencies
	|--------------------------------------------------------------------------
	|
	| This is where you can specify your bower dependencies. We've set a 
	| sensible default, but feel free to update it.
	| 
	| **Note**: Please use key/value pair to represent dependency & version. Use 
	| the word "null" if you require the latest version, or don't know a version
	| number
	|
	*/
	"bower_dependencies" => array(
		"jquery"    => "~1.10.2",
                "jquery-ui" => "1.10.4",
		"bootstrap-sass" => "~3",
                "jstree" => "~3",
                "tinymce-builded" => "~4",
                "blueimp-file-upload" => "~9.5"
	),

);
