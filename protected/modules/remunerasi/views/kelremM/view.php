<fieldset class="box">
    <legend class="rim">Lihat Kelompok Remunerasi</legend>
    <!--<div class="white-container">
    <legend class="rim2">Kelompok <b>Remunerasi</b></legend>-->
    <?php
    $this->breadcrumbs = array(
        'Kelrem Ms' => array('index'),
        $model->kelrem_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelompok Remunerasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Remunerasi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelompok Remunerasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess('Update')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelompok Remunerasi', 'icon'=>'pencil','url'=>array('update','id'=>$model->gelarbelakang_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kelompok Remunerasi','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->gelarbelakang_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
    (Yii::app()->user->checkAccess('Admin')) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelompok Remunerasi', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'kelrem_id',
            'kelrem_urutan',
            'kelrem_kode',
            'kelrem_nama',
            'kelrem_desc',
            'kelrem_singkatan',
            'kelrem_rate',
            array(               // related city displayed as a link
                'name' => 'kelrem_aktif',
                'type' => 'raw',
                'value' => (($model->kelrem_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
            ),
        ),
    )); ?>
    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kelompok Remunerasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('admin', array('tab' => 'frame', 'modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
    <!--</div>-->
</fieldset>