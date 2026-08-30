<?php

if (empty($model)) {
    $model = new SpesimenhasiloperasiT();
}

if (empty($ii)) {
    $ii = 'ii';
}

?>

<tr>
    <td>
        <?php echo CHtml::activeHiddenField($model, '[detail]['.$ii.']jenisspesimen_pa_id', array('class'=>'tab_jenisspesimen_pa_id')); ?>
        <?php echo CHtml::activeHiddenField($model, '[detail]['.$ii.']jenisspesimen_pa_lainnya', array('class'=>'tab_jenisspesimen_pa_lainnya')); ?>
        <?php echo CHtml::activeHiddenField($model, '[detail]['.$ii.']teknikpengambilanspesimen_id', array('class'=>'tab_teknikpengambilanspesimen_id')); ?>
        <?php echo CHtml::activeHiddenField($model, '[detail]['.$ii.']lokasipengambilanspesimen', array('class'=>'tab_lokasipengambilanspesimen')); ?>
        <span class="label_jenis"><?php 
        if ($model->jenisspesimen_pa_id == Params::JENISSPESIMEN_PA_LAINNYA) {
            echo $model->jenisspesimen_pa_lainnya;
        } else {
            $jenis = JenisspesimenPaM::model()->findByPk($model->jenisspesimen_pa_id);
            echo empty($jenis) ? "-" : $jenis->jenisspesimen_pa_nama;
        }
        ?></span>
    </td>
    <td class="label_teknik"><?php
                $teknik = TeknikpengambilanspesimenM::model()->findByPk($model->teknikpengambilanspesimen_id);
                echo empty($teknik) ? "-" : $teknik->teknikpengambilanspesimen_nama;
    ?></td>
    <td class="label_lokasi"><?php echo $model->lokasipengambilanspesimen; ?></td>
    <td>
        <?php echo CHtml::htmlButton('<i class="entypo-minus"></i>', array(
            'class' => 'btn btn-default',
            'onclick'=>"$(this).parents('tr').remove();",
        )); ?>
    </td>
</tr>