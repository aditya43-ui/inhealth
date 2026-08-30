<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Sysdia</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Rmsys Dias' => array('index'),
            $model->sysdia_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Sysdia ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' RKSysDia', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' RKSysDia', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' RKSysDia', 'icon'=>'pencil','url'=>array('update','id'=>$model->sysdia_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' RKSysDia','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->sysdia_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sysdia', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'sysdia_id',
                'kelompokumur_id',
                'systolic_min',
                'systolic_max',
                'diastolic_min',
                'diastolic_max',
                'sysdia_range',
                'sysdia_nama',
                'sysdia_desc',
                array(
                    'label' => 'Aktif',
                    'value' => (($model->sysdia_aktif == 1) ? "Ya" : "Tidak"),
                )
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Sysdia', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('sysDia/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>