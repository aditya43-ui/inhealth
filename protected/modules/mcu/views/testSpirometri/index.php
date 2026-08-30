<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Tes Spirometri</div>
    </div>
    <div class="panel-body">
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-riwayat',
            'content' => array(
                'content-riwayat' => array(
                    'header' => '<b>Riwayat Tes Spirometri</b>',
                    'isi' => $this->renderPartial($this->path_view . '_formRiwayat', array(
                        //'form'=>$form,
                        'format' => $format,
                        'model' => $model,
                        'modelRiwayat' => $modelRiwayat,
                    ), true),
                    'active' => false,
                ),
            ),
        )); ?>
        <div class="panel-body">
            <div style="float:right;margin-bottom:0px">
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                    $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&baru="baru"'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return tambahbaru(this);',
                        "rel" => "tooltip",
                        "title" => "Klik untuk tambah data baru"
                    )
                ); ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?php

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'tes-spirometri-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));

        $this->widget('bootstrap.widgets.BootAlert');

        echo $this->renderPartial($this->path_view . '_info', array(
            'form' => $form,
            'model' => $model,
            'modPemeriksaanFisik' => $modPemeriksaanFisik,
        ), true);

        echo $this->renderPartial($this->path_view . '_formSpirometri', array(
            'form' => $form,
            'model' => $model,
        ), true);

        echo $this->renderPartial($this->path_view . '_formKesimpulan', array(
            'form' => $form,
            'model' => $model,
        ), true);
        ?>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
            );
            //if($model->isNewRecord){
            //    echo CHtml::link(Yii::t('mds', '{icon} Print Tes Spirometri', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
            //}else{
            //    echo CHtml::link(Yii::t('mds', '{icon} Print Tes Spirometri', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemeriksaanFisik();return false",'disabled'=>FALSE  ));
            //}
            ?>
            <?php
            // $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
            // $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>

        <?php $this->endWidget();
        ?>
    </div>
</div>
<?php
echo $this->renderPartial($this->path_view . '_jsFunctions', array(
    'form' => $form,
    'model' => $model,
), true);
?>