<?php
/**
 * Public representation of the widget.
 * All form data is available here in form of variables.
 * Please check the existence of all variables as at the beginning widget has no data.
 */
?>

<?php 
/*
function generateTable($cells, $cols, $type = 'table'){
	echo  "<table class=\"$type\">";
	echo "	<thead>";
	echo "		<tr>";

	

	echo "		</tr>";
	echo "	</thead>";

	echo "	<tbody>";

	for ($i=1; $i < $cols; $i++) { 
		echo "	<tr>";
		for ($i=0; $i < $cells; $i++) { 
			echo "	<td></td>";
		}
		echo "	</tr>";
	}

	echo "	</tbody>";
	echo "</table>";

}
*/

if(isset($rows) && $rows > 0){
	if(isset($columns) && $columns > 0){?>
		<table class="<?=$classes?>" id="<?=$tblid?>">
			<thead>
				<tr>
		<?php   for ($i=0; $i < $columns; $i++): ?>
					<td>
					<?php echo ipBlock($blocks[0][$i])->render($revisionId);?>
					</td>
		<?php	endfor; ?>
				</tr>
			</thead>
			<tbody>
	<?php   for ($i=1; $i < $rows; $i++): ?>
				<tr>
		<?php   for ($j=0; $j < $columns; $j++): ?>
					<td>
					<?php $id = (string) $tblid . '-tb-' . $i; ?>
					<?php echo ipBlock($blocks[$i][$j])->render($revisionId);?>
					</td>
		<?php	endfor; ?>
				</tr>
	<?php	endfor; ?>
			</tbody>
		</table>
<?php
	}else{
		echo '<p>Colunas precisam ser maior que <b>0</b></p>';
	}
}else{
	echo '<p>Linhas precisam ser maior que <b>0</b></p>';
}
