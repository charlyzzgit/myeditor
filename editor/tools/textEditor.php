
<style>
	.sector{
		height: 300px;
		position: relative;
	}

	#apply{
		position: absolute;
		top:60px;
		right: 15px;
		z-index: 10
	}
</style>
<div id="form-tool" class="col-12 flex-row-center-start">
	<div class="sector flex-row-center-center p-2">
		<textarea id="editor">
          <!-- <h1>Hello world!</h1>
          <p>I'm an instance of <a href="https://ckeditor.com">CKEditor</a>.</p> -->
        </textarea>
        <button id="apply" class="btn btn-success btn-sm">Aplicar Cambios</button>
	</div>
	
</div>



<script>
	'use strict'
	$('#editor').html(OBJ.html())
	var ckeditor = CKEDITOR//.replace('editor')
	//CKFinder.setupCKEditor(ckeditor, '../ckfinder')
	try{
		var iEditor = ckeditor.instances['editor']
		    if (iEditor) {
		        iEditor.destroy(true); 
		       
		    }  
		}catch(e){}

	
 initSample()

   


$('#apply').click(function(){
	ver(['html', ckeditor.instances['editor'].getData()])
	OBJ.html(ckeditor.instances['editor'].getData())
})

</script>