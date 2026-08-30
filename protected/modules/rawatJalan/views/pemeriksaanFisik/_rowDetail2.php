<?php
	$format = new MyFormatter();
?>
<tr>
    <td>
		<?php echo CHtml::textField('no_urut',isset($i)?$i:0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>	
    <td>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']pemeriksaangambar_id',array('style'=>'width:50px;', 'class'=>'integer pemeriksaangambar_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']gambartubuh_id',array('style'=>'width:50px;', 'class'=>'integer gambartubuh_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']bagiantubuh_id',array('style'=>'width:50px;', 'class'=>'integer bagiantubuh_id', 'data-delete'=> $modPemeriksaanGbr->gambartubuh_id.'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_x).'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_y))); ?>
    	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']namabagtubuh',array('readonly'=>true,'style'=>'width:110px;')); ?>
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
        <?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']keterangan_periksa_gbr',array('readonly'=>true,'style'=>'width:110px;','class'=> 'keterangan_periksa_gbr')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_x',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_x')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_y',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_y')); ?>
        
    </td>
    <td>
		<?php 
			if (!empty($modPemeriksaanGbr->pemeriksaangambar_id)){
		?>
				<a onclick="hapusBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-trash"></i></a>
		<?php
		?>
			<?php }else{ ?>
			<a onclick="batalTambahBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-form-silang"></i></a>
			<?php } ?>
    </td>
</tr>