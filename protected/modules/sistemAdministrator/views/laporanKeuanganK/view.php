<?php
    $this->breadcrumbs = array(
        'Konfigurasi Laporan Keuangan' => array('admin'),
        'Lihat',
    );

    $arrMenu = array();

    $this->menu = $arrMenu;
    ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Lihat <b>Konfigurasi Laporan Keuangan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                        array(
                                'name'=>'menu_id',
                                'label'=>'Nama Menu',
                                'value'=>(!empty($model->menu)? $model->menu->menu_nama:""),
                        ),
                        'menu_url',
                        'keterangan',
                        'levelrek',
                ),
        )); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->laporankeuangan_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')).'&nbsp;';?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Laporan Keuangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>
