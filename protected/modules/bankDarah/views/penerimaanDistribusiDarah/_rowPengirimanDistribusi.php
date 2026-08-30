<tr>
    <td><?php echo CHtml::textField('no',$no,array('readonly'=>true,'value'=>$no, 'class' => 'span1'))?> </td>
    <td><?php echo CHtml::activeHiddenField($modDetail,"[$i]distribusidarahdet_id"); ?>
        <?php echo CHtml::textField('no_kantongdarah',$data->nomorbarcode,array('readonly'=>true,'value'=>$data->nomorbarcode, 'class' => 'span3'))?>
    </td>
    <td><?php echo CHtml::textField('jeniskomponen',$komponenDarah->singkatan_komp,array('readonly'=>true,'value'=>$no, 'class' => 'span1'))?> </td>
    <td><?php echo CHtml::textField('jeniskantong',$jenisKantong->nama_jenis,array('readonly'=>true,'value'=>$no, 'class' => 'span2'))?> </td>
    <td><?php echo CHtml::textField('golongan_darah',$data->golongan_darah,array('readonly'=>true,'value'=>$no, 'class' => 'span1'))?> </td>
    <td><?php echo CHtml::textField('rhesus',$data->rhesus,array('readonly'=>true,'value'=>$no, 'class' => 'span2'))?> </td>
    <td style="text-align: center;"><?php echo CHtml::activeCheckBox($modDetail,"[$i]checklist", array('checked'=>true,'class'=>'checklist','onclick'=>'setNol(this);')); ?></td>
</tr>