<?php 
	$filas = array(4, 3, 2, 1);
 ?>
<style>
	#list-example{
		list-style: none;
		height: 460px;
		overflow-y: auto;
	}

	.ex-column{
		/*height: 100px;*/
		border:dotted thin black;
	}

	.ex-fila{
		background: #C4C4C4
	}
</style>

<div class="col-12 flex-row-around-center p-1">
	<span class="alert alert-light elevation-1">Principal</span>
	<span class="alert alert-secondary elevation-1">Bloque</span>
	<span class="alert alert-warning elevation-1">Columna</span>
	<span class="alert alert-success elevation-1">Contenido (Texto - Imágenes- Tablas - Listas - etc.)</span>
</div>
<div class="col-12 flex-col-start-start p-3 border bg-light">
	<h4>Titulo Tema</h4>
	<ul id="list-example" class="col-12 flex-col-start-center m-0">
		<?php foreach ($filas as $key => $cols) {
				$col_n = 'col-12';
				switch($cols){
					case 1: $col_n = 'col-12'; break;
					case 2: $col_n = 'col-6'; break;
					case 3: $col_n = 'col-4'; break;
					case 4: $col_n = 'col-3'; break;
				}
			?>
			<li class="ex-fila col-12 flex-col start-center p-2 mb-3">
				<div class="col-12 flex-row-between-center">
					<h5>Titulo Bloque</h5>
					<span class="badge badge-dark"><?php print($cols); ?> Columnas</span>
				</div>
				
				<div class="col-12 flex-row-start-start">
					<?php for($i = 0; $i < $cols; $i++) { ?>
					<div class="ex-column <?php print($col_n); ?> flex-row-start-start flex-wrap p-1 bg-warning">
						<div class="col-12"><h5>Columna <?php print($i + 1); ?></h5></div>
						<p style="line-height: 1.2" class="text-success"><img src="../img/iconos/noimage.png" width="25%" class="float-left m-2 border border-success">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
					</div>
					<?php } ?>
				</div>
			</li>
		<?php } ?>
		
	</ul>
</div>