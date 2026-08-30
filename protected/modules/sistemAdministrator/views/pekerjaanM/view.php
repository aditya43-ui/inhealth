<div class="white-container">
    <legend class="rim2">Lihat <b>Pekerjaan</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sapekerjaan Ms' => array('index'),
        $model->pekerjaan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Pekerjaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Pekerjaan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Pekerjaan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Pekerjaan', 'icon'=>'pencil','url'=>array('update','id'=>$model->pekerjaan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Pekerjaan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->pekerjaan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Pekerjaan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'pekerjaan_id',
            'pekerjaan_nama',
            'pekerjaan_namalainnya',
            array(               // related city displayed as a link
                'name' => 'pekerjaan_aktif',
                'type' => 'raw',
                'value' => (($model->pekerjaan_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
            ),
        ),
    )); ?>

    <div class="form-actions">
        <?php // echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->pekerjaan_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Pekerjaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/sistemAdministrator/PekerjaanM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>