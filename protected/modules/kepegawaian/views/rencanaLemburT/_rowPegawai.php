<tr>
    <td>
        <?php
        echo CHtml::activeTextField($modRencanaLembur,'[detail]['.$pegawailembur_id.']nourut',array('class'=>'span1 noUrut','readonly'=>TRUE));
        echo CHtml::activeHiddenField($modRencanaLembur,'[detail]['.$pegawailembur_id.']pegawai_id',array('value'=>$modPegawai->pegawai_id, 'class'=>'karlemburNama Pegawai_id'));                                
        echo CHtml::activeHiddenField($modPegawai,'nomorindukpegawai',array('value'=>$modPegawai->nomorindukpegawai, 'class'=>'karlemburNik'));
        ?>
    </td>
    <td><?php echo $modPegawai->nomorindukpegawai; ?></td>
    <td><?php echo $modPegawai->namaLengkap; ?></td>
    <td nowrap><?php echo $this->renderPartial($this->path_view.'_jam', array('detail'=>$modRencanaLembur,'no'=>$pegawailembur_id,'jam'=>'mulai'), true, true); ?></td>
    <td nowrap><?php echo $this->renderPartial($this->path_view.'_jam', array('detail'=>$modRencanaLembur,'no'=>$pegawailembur_id,'jam'=>'selesai'), true, true); ?></td>
    <td nowrap><?php  echo CHtml::activeDropDownList($modRencanaLembur,'[detail]['.$pegawailembur_id.']biayalembur_id',CHtml::listData(BiayalemburM::model()->findAll(array(
		'order'=>'biayalembur_id asc'
	)), 'biayalembur_id', 'biayalembur_nama'), array('value'=>1, 'class'=>'karlemburNama Pegawai_id', 'style'=>'width: 100px;')); ?></td>
    <td><?php echo CHtml::activetextArea($modRencanaLembur,'[detail]['.$pegawailembur_id.']alasanlembur',array('class'=>'span3 autogrow','readonly'=>false, 'onkeypress'=>'return $(this).focusNextInputField(event)')); ?></td>
    <td><?php echo CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'#',array('href'=>'','onclick'=>'hapusBaris(this); return false;')); ?></td>
</tr>