<?php
	$format = new MyFormatter();
?>
<tr>
    <td>
		<?php echo CHtml::textField('no_urut',isset($i)?$i:0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>	
    <td>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']gambarnyeri_id',array('style'=>'width:50px;', 'class'=>'integer gambarnyeri_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']gambartubuh_id',array('style'=>'width:50px;', 'class'=>'integer gambartubuh_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']bagiantubuh_id',array('style'=>'width:50px;', 'class'=>'integer bagiantubuh_id', 'data-delete'=> $modPemeriksaanGbr->gambartubuh_id.'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_x).'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_y))); ?>
    	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']namabagtubuh',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']ket_gambar',array('readonly'=>true,'style'=>'width:110px;','class'=> 'keterangan_periksa_gbr')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_x',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_x')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_y',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_y')); ?>
        
    </td>
</tr>