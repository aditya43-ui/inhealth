<?php
/**
* digunakan untuk Master Termin
* @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
**/
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Lihat <strong>Termin</strong></div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'ADLookup Ms' => array('index'),
                    $model->lookup_id,
                );
                $arrMenu = array();
                $this->menu = $arrMenu;
                $this->widget('bootstrap.widgets.BootAlert');
                ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'lookup_id',
                        'lookup_name',
                        'lookup_value',
                        'lookup_urutan',
                        array(
                            'label' => 'Status',
                            'type' => 'raw',
                            'value' => ($model->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                        ),
                    ),
                ));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Termin', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
                $this->widget('UserTips', array('type' => 'view'));
                ?>
            </div>
        </div>
    </div>
</div>
