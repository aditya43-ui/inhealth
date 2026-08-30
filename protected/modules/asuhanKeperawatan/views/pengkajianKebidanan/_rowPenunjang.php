<?php
if (isset($modTambahPenunjang->tglmasukpenunjang)) {
	$tgl = date('d/m/Y H:i:s',strtotime($modTambahPenunjang->tglmasukpenunjang));
} else if(isset($modPenunjang->datapenunjang_tgl)){
	$tgl = date('d/m/Y H:i:s',strtotime($modPenunjang->datapenunjang_tgl));
}else {
	$tgl = date('d/m/Y H:i:s');
}
if(isset($modTambahPenunjang)){
	$data = (isset($modTambahPenunjang->ruangan_nama) ? 'Ruangan :' . $modTambahPenunjang->ruangan_nama : "-") . ' ' . (isset($modTambahPenunjang->jeniskasuspenyakit_nama) ? 'Jenis Kasus Penyakit :' . $modTambahPenunjang->jeniskasuspenyakit_nama : "-");
}
if(isset($modPenunjang)){
	$data = $modPenunjang->datapenunjang_nama;
}

?>

<tr>
	<td style="text-align: center;">
		<?php echo CHtml::activeHiddenField($modPenunjang, '[ii]datapenunjang_id', array('readonly' => true)); ?>
		<?php echo CHtml::activeHiddenField($modPenunjang, '[ii]pengkajianaskep_id', array('readonly' => true)); ?>
		<?php echo CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_tgl', array('readonly' => true,'class' => 'span2 datetimemask', 'value' => $tgl)); ?>
	</td>
	<td style="text-align: center;">
		<?php echo CHtml::activeTextField($modPenunjang, '[ii]datapenunjang_nama', array('readonly' => true,'class' => 'span12','value' => $data)); ?>
	</td>
<!--	<td style="text-align: center;" class="rowbutton">
		<?php // echo CHtml::link('<i class="icon-plus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'tambahPenunjang()')); ?>
		<?php // echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-primary', 'onclick' => 'hapusLookup(this)')); ?>
	</td>-->
</tr>
