<div class="white-container">
    <legend class="rim2">Lihat <b>PTKP</b></legend>
    <?php
    $this->breadcrumbs=array(
            'PTKP Ms'=>array('index'),
            $model->ptkp_id,
    );

    $arrMenu = array();
    //array_push($arrMenu,array('label'=>Yii::t('mds','View').'  PTKP  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').'  PTKP ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'ptkp_id',
                    'tglberlaku',
                    'statusperkawinan',
                    'jmltanggunan',
                    'wajibpajak_thn',
                    'wajibpajak_bln',
            array(
                'label'=>'Berlaku',
                'value'=>(($model->berlaku==1)? "Ya" : "Tidak"),
            ),
            ),
    )); ?>

    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan PTKP', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    $this->widget('UserTips',array('type'=>'view'));
    ?>
</div>