<tr>
<td><?php echo CHtml::activeTextField($model, '['.$i.']jam_ke', array('class'=>'span1 numbers-only jam_ke', 'style'=>'text-align: right;')); ?></td>
    <td>
        <?php   
        $this->widget('MyDateTimePicker',array(
            'model'=>$model,
            'attribute'=>'['.$i.']waktu',
            'mode'=>'datetime',
            'options'=> array(
                'dateFormat'=>Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5 date_pemantauan'),
        )); ?>
        
    </td>
    <td nowrap><?php echo CHtml::activeTextField($model, '['.$i.']systolic', array('class'=>'span1 numbers-only p_systolic', 'style'=>'text-align: right;')); ?>mm/<br><?php echo CHtml::activeTextField($model, '['.$i.']diastolic', array('class'=>'span1 numbers-only p_diastolic', 'style'=>'text-align: right;')); ?>Hg</td>
    <td><?php echo CHtml::activeTextField($model, '['.$i.']nadi', array('class'=>'span1 numbers-only p_nadi', 'style'=>'text-align: right;')); ?>/menit</td>
    <td nowrap><?php echo CHtml::activeTextField($model, '['.$i.']suhu', array('class'=>'span1 p_suhu', 'style'=>'text-align: right;')); ?>C</td>
    <td><?php echo CHtml::activeTextField($model, '['.$i.']tinggi_fundus_uteri', array('class'=>'span2 p_tinggi')); ?></td>
    <td><?php echo CHtml::activeTextArea($model, '['.$i.']kontraksi_uterus', array('class'=>'span2 p_kontraksi')); ?></td>
    <td><?php echo CHtml::activeTextArea($model, '['.$i.']kantung_kemih', array('class'=>'span2 p_kantung')); ?></td>
    <td><?php echo CHtml::activeTextArea($model, '['.$i.']darah_yang_keluar', array('class'=>'span2 p_darah')); ?></td>
    <td><?php echo CHtml::htmlButton('<i class="entypo-minus"></i>', array('class'=>'btn btn-default', 'onclick'=>'hapusBarisPemantauan(this);')); ?></td>
</tr>