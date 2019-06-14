
<script src="js/jquery-2.1.3.min.js"></script>
<script src="js/icons.js"></script>


<script type="text/javascript">
	
	$.each(ICONS, function(i,icon){
		var aux = icon.split('<i class="')[1].split('"></i')[0]
		document.write("'" + aux + "',")
		document.write('</br>')
	})
	
</script>