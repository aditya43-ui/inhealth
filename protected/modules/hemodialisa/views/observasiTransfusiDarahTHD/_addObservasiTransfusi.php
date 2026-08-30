<tr class="tr-observasitransfusi" baris="<?= $key; ?>">
    <td>
        <?= CHtml::activeHiddenField($model, '['.$key.']kantong_transfusi_darah_det_id', array('readonly' => true, 'class' => 'span2')); ?>
        <?= CHtml::activeTextField($model, '['.$key.']kantong_transfusi_darah_det_no', array('readonly' => true, 'class' => 'span2')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']tanggal_observasi', array('readonly' => true, 'class' => '', 'style'=>'width: 80px;')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']jam_observasi', array('readonly' => true, 'class' => '', 'style'=>'width: 80px;')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']reaksi_transfusi', array('readonly' => true, 'class' => '', 'style'=>'width: 80px;')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']keluhan', array('readonly' => true, 'class' => 'span2')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']kesadaran', array('readonly' => true, 'class' => 'span2')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']tensi_sistolik', array('readonly' => true, 'class' => 'span1')); ?> /
        <?= CHtml::activeTextField($model, '['.$key.']tensi_diatolik', array('readonly' => true, 'class' => 'span1')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']nadi', array('readonly' => true, 'class' => 'span1')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']suhu', array('readonly' => true, 'class' => 'span1')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']pernapasan', array('readonly' => true, 'class' => 'span1')); ?>
    </td>
    <td>
        <?= CHtml::activeTextField($model, '['.$key.']lainnya', array('readonly' => true, 'class' => 'span2')); ?>
    </td>
    <td>
        <?= CHtml::activeHiddenField($model, '['.$key.']petugas_observasi_id', array('readonly' => true, 'class' => 'span1')); ?>
        <?= CHtml::activeTextField($model, '['.$key.']petugas_observasi_nama', array('readonly' => true, 'class' => 'span3')); ?>
    </td>
    <td>
        <?= CHtml::link('<span style="font-size:20px;color:red;"><i class="entypo-trash"></i></span>', 'javascript:void(0);', array('class'=>'','onclick'=>"batalObservasiTransfusi(this);return false", 'title'=>'Klik untuk membatalkan Observasi Transfusi'))."&nbsp;"; ?>
    </td>
</tr>
    