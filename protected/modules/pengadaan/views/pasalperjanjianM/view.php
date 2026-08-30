<?php
/**
* digunakan untuk Master pasal perjanjian
* @author Elham Budianto <elhambudianto1@gmail.com>
**/
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Pasal Perjanjian</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Pasal Perjanjian' => array('index'),
                    $model->pasalperjanjian_id,
                );
                $arrMenu = array();
                $this->menu = $arrMenu;
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'pasalperjanjian_id',
                        'pasalperjanjian_nama',
                        'pasalperjanjian_uraian',
                        array(
                            'label' => 'Isi Pasal Perjanjian',
                            'type' => 'raw',
                            'value' => $model->pasalperjanjian_isi,
                        ),
                        array(
                            'label' => 'Status',
                            'type' => 'raw',
                            'value' => ($model->pasalperjanjian_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
                ));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pasal Perjanjian', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
                $this->widget('UserTips', array('type' => 'view'));
                ?>
            </div>
        </div>
    </div>
</div>
