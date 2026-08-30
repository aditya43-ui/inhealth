<?php 	
	echo "<div name='PSPemeriksaanpartografobatT[".$ii."][obat][".$det->obatalkes_id."][div]'>";
	echo CHtml::activeTextField($det, '['.$ii.'][obat]['.$det->obatalkes_id.']obatalkes_nama',array('class' => 'manyinput span2',  'readonly'=>true));			
	echo ' ';
	echo CHtml::activeTextField($det, '['.$ii.'][obat]['.$det->obatalkes_id.']obatalkes_jumlah',array('onkeyup'=>'setNumbersOnly(this);','class' => 'manyinput span1', 'style'=>'text-align:right;'));
	echo ' ';
	echo "<button type='button' name='PSPemeriksaanpartografobatT[".$ii."][obat][".$det->obatalkes_id."][obatalkes_hapus]' class='btn btn-danger' onclick='delObat(this,".$det->obatalkes_id.",".$ii.",\"PSPemeriksaanpartografobatT\")'><i class='".MyIcon::getIcons('batal')."'></i></button>";
	echo CHtml::activeHiddenField($det,'['.$ii.'][obat]['.$det->obatalkes_id.']obatalkes_id',array('readonly'=>true,'class'=>'manyinput'));
	echo CHtml::activeHiddenField($det,'['.$ii.'][obat]['.$det->obatalkes_id.']pemeriksaanpartografobat_id',array('readonly'=>true,'class'=>'manyinput'));
	echo "</div>";	
										
										
?>