<?php

    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger btn-simpan ', 'type' => 'submit','disabled'=>!isset($_GET['sukses'])?false:true));  
    ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default  btn-ulang',
        'onclick' => 'window.parent.myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('index',['pendaftaran_id'=>$model->pendaftaran_id, 'pasienadmisi_id'=>$model->pasienadmisi_id]).'";}); return false;'));
    echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '', array(
        'class' => 'btn btn-success  btn-cetak',
        'rel' =>'tooltip',
        'disabled' => !empty($model->cpispasien_id)?false:true,
        'title' => 'Klik untuk cetak cpis pasien',
        'onclick' => 'cetak("'.$model->cpispasien_id.'")'));
    ?>    
    <?php
    $tips = array(
        '0' => 'simpan',
        '1' => 'ulang',
    );
    $content = $this->renderPartial('perawatanIntensif.views.tips.transaksi', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>