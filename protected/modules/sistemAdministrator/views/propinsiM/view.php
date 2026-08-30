<div class="white-container">
    <legend class="rim2">Lihat <b>Provinsi</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sapropinsi Ms' => array('index'),
        $model->propinsi_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Provinsi', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Provinsi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Provinsi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Provinsi', 'icon'=>'pencil','url'=>array('update','id'=>$model->propinsi_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Provinsi','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->propinsi_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Provinsi', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'propinsi_id',
                    'propinsi_nama',
                    'propinsi_namalainnya',
                ),
            )); ?>
        </div>
        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'longitude',
                    'latitude',
                    array(
                        'label' => 'Aktif',
                        'type' => 'raw',
                        'value' => (($model->propinsi_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                    ),
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
            $this->createUrl('update', array('id' => $model->propinsi_id, 'modul_id' => Yii::app()->session['modul_id'])),
            array('title' => 'Ubah', 'class' => 'btn btn-danger',)
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Provinsi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('PropinsiM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>