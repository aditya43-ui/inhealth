<div class="white-container">
    <legend class="rim2">Lihat <b>Gelar Belakang</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sagelar Belakang Ms' => array('index'),
        $model->gelarbelakang_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Gelar Belakang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Gelar Belakang', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Gelar Belakang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess('Update')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Gelar Belakang', 'icon'=>'pencil','url'=>array('update','id'=>$model->gelarbelakang_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Gelar Belakang','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->gelarbelakang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    //                (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Gelar Belakang', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'gelarbelakang_id',
            'gelarbelakang_nama',
            'gelarbelakang_namalainnya',
            array(               // related city displayed as a link
                'name' => 'gelarbelakang_aktif',
                'type' => 'raw',
                'value' => (($model->gelarbelakang_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
            ),
        ),
    )); ?>


    <div class="form-actions">
        <?php // echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl('update',array('id'=>$model->gelarbelakang_id,'modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Gelar Belakang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/sistemAdministrator/gelarBelakangM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>