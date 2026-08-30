
<?php
if (!empty($modPemeriksaanGbr->pemeriksaangambarawalmedis_id)){
    $color='rgba(0, 128, 255, 0.8)';
    
}else{
    $color='rgba(219, 50, 92, 0.9)';
}
	$format = new MyFormatter();
?>
<tr >
    <td >
		<?php echo CHtml::textField('no_urut',isset($i)?$i:0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>"width:20px;border-color:".$color."")); ?>
	</td>	
    <td >
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']pemeriksaangambarawalmedis_id',array('style'=>'width:50px;', 'class'=>'integer pemeriksaangambarawalmedis_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']gambartubuh_id',array('style'=>'width:50px;', 'class'=>'integer gambartubuh_id')); ?>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']bagiantubuh_id',array('style'=>'width:50px;', 'class'=>'integer bagiantubuh_id', 'data-delete'=> $modPemeriksaanGbr->gambartubuh_id.'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_x).'_'.str_replace('.','_',$modPemeriksaanGbr->kordinat_tubuh_y))); ?>
    	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']namabagtubuh',array('readonly'=>true,'style'=>"width:110px;border-color:".$color."")); ?>
    </td>
    <td >
        <?php echo CHtml::activeTextField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']keterangan_periksa_gbr',array('readonly'=>true,'style'=>"width:110px;border-color:".$color."",'class'=> 'keterangan_periksa_gbr')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_x',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_x')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '['.(isset($a)?$a:'i').']kordinat_tubuh_y',array('style'=>'width:50px;', 'class'=>'integer kordinat_tubuh_y')); ?>
        
    </td>
    <td >
		<?php 
			if (!empty($modPemeriksaanGbr->pemeriksaangambarawalmedis_id)){
		?>
        <a onclick="hapusBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="glyphicon glyphicon-trash" style="font-size:15px"></i></a>
		<?php
		?>
			<?php }else{ ?>
			<a onclick="batalTambahBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="glyphicon glyphicon-remove" style="font-size:15px"></i></a>
			<?php } ?>
    </td>
</tr>