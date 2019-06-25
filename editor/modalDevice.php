<style>
	.icon-dv{
		font-size: 50px
	}

	.rot{
		transform: rotate(90deg);
	}
</style>
<div class="col-12 flex-row-between-start flex-wrap">
	<div class="col-12 flex-col-center-center p-2 border mb-2">
		<button class="btn-device btn btn-warning" data-device="desktop" data-orientation="">
			<i class="icon-dv fa fa-desktop m-2"></i>
		</button>
		<b class="mt-1 text-center">Escritorio</b>
	</div>
	<div class="col-5 flex-col-center-center p-2 border mb-2">
		<button class="btn-device btn btn-warning" data-device="tablet" data-orientation="portrait">
			<i class="icon-dv fa fa-tablet-alt m-2"></i>
		</button>
		<b class="mt-1 text-center">Tablet Portrait</b>
	</div>
	<div class="col-5 flex-col-center-center p-2 border mb-2">
		<button class="btn-device btn btn-warning" data-device="tablet" data-orientation="landscape">
			<i class="icon-dv fa fa-tablet-alt m-2 rot"></i>
		</button>
		<b class="mt-1 text-center">Tablet Landscape</b>
	</div>
	<div class="col-5 flex-col-center-center p-2 border mb-2">
		<button class="btn-device btn btn-warning" data-device="smartphone" data-orientation="portrait">
			<i class="icon-dv fa fa-mobile-alt m-2"></i>
		</button>
		<b class="mt-1 text-center">Smartphone Portrait</b>
	</div>
	<div class="col-5 flex-col-center-center p-2 border mb-2">
		<button class="btn-device btn btn-warning" data-device="smartphone" data-orientation="landscape">
			<i class="icon-dv fa fa-mobile-alt m-2 rot"></i>
		</button>
		<b class="mt-1 text-center">Smartphone Landscape</b>
	</div>
	<div id="exit" class="d-none" data-dismiss="modal"></div>
</div>


<script>
	
	$('.btn-device').click(function(){
		$('#exit').trigger('click')
		var dvc = $(this).data('device'),
			ori = $(this).data('orientation')
		blank('demo.php?device=' + dvc + '&orientation=' + ori + '&id=' + TEMA.id)
	})
</script>