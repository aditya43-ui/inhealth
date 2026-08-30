<?php
$this->breadcrumbs = array(
    'Layar Antrian' => array('admin'),
    $model->layarantrian_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Data Layar Antrian</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'layarantrian_id',
                        'layarantrian_jenis',
                        'layarantrian_nama',
                        'layarantrian_judul',
                        'layarantrian_runningtext',
                        //		'layarantrian_latarbelakang',
                        /* array(
                            'label'=>'Latar Belakang',
                            'type'=>'raw',
                            'value'=>'<img src="'.Params::urlBackgroundAntrianThumbs().'kecil_'.$model->layarantrian_latarbelakang.'"></img>',
                        ),
                         * 
                         */
                        //'layarantrian_maksitem',
                        //'layarantrian_itemhigh',
                        //'layarantrian_itemwidth',
                        //'layarantrian_intrefresh',
                        //'layarantrian_aktif',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'layarantrian_id',
                        //'layarantrian_jenis',
                        //'layarantrian_nama',
                        //'layarantrian_judul',
                        //'layarantrian_runningtext',
                        //'layarantrian_latarbelakang',
                        'layarantrian_maksitem',
                        'layarantrian_itemhigh',
                        'layarantrian_itemwidth',
                        'layarantrian_intrefresh',
                        //		'layarantrian_aktif',
                        array(
                            'label' => 'Status Layar Antrian',
                            'type' => 'raw',
                            'value' => (($model->layarantrian_aktif == TRUE) ? "Aktif" : "Tidak Aktif"),
                        ),
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->layarantrian_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Data Layar Antrian', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php
            //  $content = $this->renderPartial($this->path_view.'tips/tipsView',array(),true);
            $this->widget('UserTips', array('type' => 'view'));
            ?>
        </div>
    </div>
</div>