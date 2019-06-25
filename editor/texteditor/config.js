/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';

	// config.toolbarGroups = [
				//     { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
				//     { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
				//     { name: 'links' },
				//     { name: 'insert' },
				//     { name: 'forms' },
				//     { name: 'tools' },
				//     { name: 'document',       groups: [ 'mode', 'document', 'doctools' ] },
				//     { name: 'others' },
				//     '/',
				//     { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
				//     { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
				//     { name: 'styles' },
				//     { name: 'colors' },
				//     { name: 'about' }
				// ];
				
               config.toolbar = [
                //{ name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
                //{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                //{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                //{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                //{ name: 'insert', items: [ 'EasyImageUpload', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                { name: 'insert', items: [ 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'CodeSnippet' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'about', items: [ 'About' ] },
              ];

	config.uiColor = '#CCE5FF';
	config.extraPlugins = 'codesnippet';
	config.extraPlugins = 'insertpre';
	config.removePlugins = 'Save,Print,Preview,Find,About,Maximize,ShowBlocks';
				// config.toolbarGroups = [
};
