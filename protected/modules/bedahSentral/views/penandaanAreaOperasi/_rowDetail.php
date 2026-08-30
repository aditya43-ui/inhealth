<?php
	$format = new MyFormatter();
?>
<tr>
    <td>
		<?php echo CHtml::textField('no_urut',isset($i)?$i:0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>	
    <td>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']areaoperasidet_id',array('style'=>'width:50px;', 'class'=>'integer areaoperasidet_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']gambartubuh_id',array('style'=>'width:50px;', 'class'=>'integer gambartubuh_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']bagiantubuh_id',array('style'=>'width:50px;', 'class'=>'integer bagiantubuh_id', 'data-delete'=> $modPemeriksaanGbr->gambartubuh_id.'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_x).'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_y))); ?>
    	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']namabagtubuh',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']areaoperasidet_ket',array('readonly'=>true,'style'=>'width:110px;','class'=> 'areaoperasidet_ket')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_x',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_x')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_y',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_y')); ?>
        
    </td>
    <td>
		<?php 
			if (!empty($modPemeriksaanGbr->areaoperasidet_id)){
		?>
				<a onclick="hapusBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-trash"></i></a>
		<?php
		?>
			<?php }else{ ?>
			<a onclick="batalTambahBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-form-silang"></i></a>
			<?php } ?>
    </td>
</tr>