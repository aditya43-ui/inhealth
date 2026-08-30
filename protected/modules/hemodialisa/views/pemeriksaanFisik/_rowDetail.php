<tr>
	<td>
		<?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
	</td>
    <td>
		<?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '[i]bagiantubuh_id',array('style'=>'width:50px;', 'class'=>'integer')); ?>
    	<?php echo CHtml::activeTextField($modPemeriksaanGbr, '[i]namabagtubuh',array('readonly'=>true,'style'=>'width:110px;')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modPemeriksaanGbr, '[i]keterangan_periksa_gbr',array('readonly'=>true,'style'=>'width:110px;')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '[i]kordinat_tubuh_x',array('style'=>'width:50px;', 'class'=>'integer')); ?>
        <?php echo CHtml::activeHiddenField($modPemeriksaanGbr, '[i]kordinat_tubuh_y',array('style'=>'width:50px;', 'class'=>'integer')); ?>
        
    </td>
    <td>
    	<a onclick="batalTambahBagianTubuh(this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk membatalkan pemilihan pemeriksaan ini"><i class="icon-remove"></i></a>
    </td>
</tr>