<tr>
    <td>
		<span name="[ii][namatindakan]"><?php echo (!empty($modHasilPemeriksaanRad->pemeriksaanrad_nama) ? $modHasilPemeriksaanRad->pemeriksaanrad_nama : "-") ?></span>
		<?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>
        <?php echo CHtml::activeHiddenField($modHasilPemeriksaanRad,'[ii]hasilpemeriksaanrad_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modHasilPemeriksaanRad,'[ii]tindakanpelayanan_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modHasilPemeriksaanRad,'[ii]pasienmasukpenunjang_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modHasilPemeriksaanRad,'[ii]pemeriksaanrad_id',array('readonly'=>true,'class'=>'span1')); ?>
        <?php echo CHtml::activeHiddenField($modHasilPemeriksaanRad,'[ii]pendaftaran_id',array('readonly'=>true,'class'=>'span1')); ?>
		<?php echo CHtml::link("<i class='entypo-print'></i>", '#', array('onclick'=>'printHasil(this);return false;','rel'=>'tooltip','title'=>'Klik untuk print')); ?>
    </td>
    <td>
        <?php echo $modHasilPemeriksaanRad->hasilexpertise; ?>
    </td>
	<td>
		<?php echo CHtml::activeTextField($modHasilPemeriksaanRad, '[ii]kesan_hasilrad',array('readonly'=>$readonly,'class'=>'span3')); ?>
    </td>
	<td>
        <?php echo $modHasilPemeriksaanRad->kesimpulan_hasilrad; ?>
    </td>
	<td >
		<?php echo CHtml::activeTextField($modHasilPemeriksaanRad, '[ii]hasil_radiologi',array('readonly'=>$readonly,'class'=>'span3', 'maxlength' => 20)); ?>
    </td>
</tr>