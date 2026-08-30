<?php
	$format = new MyFormatter();
?>
<tr>
    <td>
		<?php echo CHtml::textField('no_urut',isset($i)?$i:0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>
	<td>
		<?php echo $format->formatDateTimeForUser(date('Y-m-d H:i:s')); ?>
	</td>
    <td>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($i)?$i:'i').']gambartubuh_id',array('style'=>'width:50px;', 'class'=>'integer')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($i)?$i:'i').']bagiantubuh_id',array('style'=>'width:50px;', 'class'=>'integer', 'data-delete'=> $modPemeriksaanGbr->gambartubuh_id)); ?>
    	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($i)?$i:'i').']namabagtubuh',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td>
	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']look',array('readonly'=>true,'style'=>'width:100px;')); ?>
    </td>
    <td>
	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']feel',array('readonly'=>true,'style'=>'width:100px;')); ?>
    </td>
    <td>
	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']move',array('readonly'=>true,'style'=>'width:100px;')); ?>
    </td>
    <td>
	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']sensory',array('readonly'=>true,'style'=>'width:80px;')); ?>
    </td>
    <td>
	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']motorik',array('readonly'=>true,'style'=>'width:80px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($i)?$i:'i').']keterangan_periksa_gbr',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($i)?$i:'i').']kordinat_tubuh_x',array('style'=>'width:50px;', 'class'=>'integer')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($i)?$i:'i').']kordinat_tubuh_y',array('style'=>'width:50px;', 'class'=>'integer')); ?>
        
    </td>
    <td>
    	<a onclick="batalTambahBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-form-silang"></i></a>
    </td>
</tr>