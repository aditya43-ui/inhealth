<div class="white-container">
    <legend class="rim2">Lihat <b>Shift</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Shift Ms'=>array('index'),
            $model->shift_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Shift', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' ShiftM', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' ShiftM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' ShiftM', 'icon'=>'pencil','url'=>array('update','id'=>$model->shift_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' ShiftM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->shift_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Shift', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                    'shift_id',
                    'shift_nama',
                    'shift_namalainnya',
                    'shift_jamawal',
                    'shift_jamakhir',
                    'shift_aktif',
                                    array(
                                        'label'=>'Aktif',
                                        'value'=>(($model->shift_aktif==1)? "Ya" : "Tidak"),
                                    ),
            ),
    )); ?>

    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Shift', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    $this->widget('UserTips',array('type'=>'view'));?>
</div>