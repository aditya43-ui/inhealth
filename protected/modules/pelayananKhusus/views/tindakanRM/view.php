<div class='panel panel-success'>
    <div class="panel-heading">
        <div class="panel-title">Lihat <b>Tindakan #<?php echo $model->tindakanrm_id ?></b></div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Rmtindakanrm Ms'=>array('index'),
            $model->tindakanrm_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tindakan #'.$model->tindakanrm_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tindakan ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'tindakanrm_id',
                    'jenistindakanrm_id',
                    'daftartindakan_id',
                    'tindakanrm_nama',
                    'tindakanrm_namalainnya',
            array(
                            'name'=>'Status',
                            'value'=>('$data->jenistindakanrm_aktif' == TRUE ) ? "Aktif" : "Tidak Aktif",
                            'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
            ),
    )); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tindakan', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
                                                                        $this->createUrl('tindakanRM/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php $this->widget('UserTips',array('type'=>'view'));?>
    </div>
</div>