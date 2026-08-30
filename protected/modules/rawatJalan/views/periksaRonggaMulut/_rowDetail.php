<?php
	$format = new MyFormatter();
?>
<tr>
    <td>
		<?php echo CHtml::textField('no_urut',isset($i)?$i:0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>	
    <td>
        <?php echo $modPemeriksaanGbr->namabagtubuh; ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']pemeriksaangambarronggamulut_id',array('style'=>'width:50px;', 'class'=>'integer pemeriksaangambarronggamulut_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']gambartubuh_id',array('style'=>'width:50px;', 'class'=>'integer gambartubuh_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']bagiantubuh_id',array('style'=>'width:50px;', 'class'=>'integer bagiantubuh_id', 'data-delete'=> $modPemeriksaanGbr->gambartubuh_id.'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_x).'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_y))); ?>
    	<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']namabagtubuh',array('readonly'=>true,'style'=>'width:110px;')); ?>
    	<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']reguler',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td><?php echo $modPemeriksaanGbr->reguler == 1 ? 'Reguler' : 'Ireguler'; ?></td>
    <td>
        <?php echo $modPemeriksaanGbr->keterangan_periksa_gbr; ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']keterangan_periksa_gbr',array('readonly'=>true,'style'=>'width:110px;','class'=> 'keterangan_periksa_gbr')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_x',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_x')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_y',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_y')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']rotasi',array('style'=>'width:50px;', 'class'=>'integer rotasi')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']lebar',array('style'=>'width:50px;', 'class'=>'integer lebar')); ?>
        
    </td>
    <td>
		<?php 
			if (!empty($modPemeriksaanGbr->pemeriksaangambarronggamulut_id)){
		?>
				<a onclick="hapusBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-trash"></i></a>
		<?php
		?>
			<?php }else{ ?>
			<a onclick="batalTambahBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-form-silang"></i></a>
			<?php } ?>
    </td>
</tr>