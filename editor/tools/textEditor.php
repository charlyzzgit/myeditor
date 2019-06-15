<style>
	.sector{
		height: 300px;
		position: relative;
	}

	#apply{
		position: absolute;
		top:76px;
		right: 15px;
		z-index: 10
	}
</style>
<div id="form-tool" class="col-12 flex-row-center-start">
	<div class="sector flex-row-center-center p-2">
		<div id="editor">
          <!-- <h1>Hello world!</h1>
          <p>I'm an instance of <a href="https://ckeditor.com">CKEditor</a>.</p> -->
        </div>
        <button id="apply" class="btn btn-success btn-sm">Aplicar Cambios</button>
	</div>
	
</div>



<script>
	'use strict'
	$('#editor').html(OBJ.html())
	CKEDITOR.replace( 'editor',

		{

		toolbar : 'Basic'

		}

		);
	// CKEDITOR.editorConfig = function( config ) {
 //               config.toolbar = 'BASIC'
 //              //   { name: 'document', items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
 //              //   { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
 //              //   { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
 //              //   { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
 //              //   '/',
 //              //   { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
 //              //   { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
 //              //   { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
 //              //   { name: 'insert', items: [ 'EasyImageUpload', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
 //              //   '/',
 //              //   { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
 //              //   { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
 //              //   { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
 //              //   { name: 'about', items: [ 'About' ] },
 //              // ];

 //            }
 initSample()

$('#apply').click(function(){
	ver(['html', CKEDITOR.instances['editor'].getData()])
	OBJ.html(CKEDITOR.instances['editor'].getData())
})

</script>