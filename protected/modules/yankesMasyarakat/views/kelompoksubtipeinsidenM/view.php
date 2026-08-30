<?php
/**
 * digunakan untuk Master kelompok subtipe insiden
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * */
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Kelompok Subtipe Insiden</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Kelompok subtipe insiden' => array('index'),
                    $model->kelompoksubtipeinsiden_id,
                );
                $arrMenu = array();
                $this->menu = $arrMenu;
                $this->widget('bootstrap.widgets.BootAlert');
                
                $tipeinsiden = TipeinsidenM::model()->findByPk($model->tipeinsiden_id);
                if(!empty($tipeinsiden)){
                    $tipeinsiden_nama = $tipeinsiden->tipeinsiden_nama;
                }else{
                    $tipeinsiden_nama = '-';
                }
                ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'label' => 'ID',
                            'value' => $model->kelompoksubtipeinsiden_id,
                        ),
                        array(
                            'label' => 'Tipe Insiden',
                            'value' => $tipeinsiden_nama,
                        ),
                        array(
                            'label' => 'Nama Kelompok Subtipe Insiden',
                            'value' => $model->kelompoksubtipeinsiden_nama,
                        ),
                        array(
                            'label' => 'Nama Lainnya',
                            'value' => $model->kelompoksubtipeinsiden_namalainnya,
                        ),
                        array(
                            'label' => 'Status',
                            'type' => 'raw',
                            'value' => ($model->kelompoksubtipeinsiden_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
                ));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Subtipe Insiden', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
                $this->widget('UserTips', array('type' => 'view'));
                ?>
            </div>
        </div>
    </div>
</div>
