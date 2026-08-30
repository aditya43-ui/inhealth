<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <?= ($this->module->id == 'hemodialisa')?'Tempat Tidur (Bed)':'Kamar Ruangan' ?></div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Kamar Ruangan' => array('view', 'id' => $model->kamarruangan_id),
            $model->kamarruangan_id
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Kamar Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kamar Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kamar Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kamar Ruangan', 'icon'=>'pencil','url'=>array('update','id'=>$model->kamarruangan_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kamar Ruangan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kamarruangan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kamar Ruangan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kamarruangan_id',
                array(
                    'name' => 'kelaspelayanan_id',
                    'type' => 'raw',
                    'value' => $model->kelaspelayanan->kelaspelayanan_nama,
                ),
                array(
                    'name' => 'ruangan_id',
                    'type' => 'raw',
                    'value' => $model->ruangan->ruangan_nama,
                ),
                'kamarruangan_nokamar',
                'kamarruangan_jmlbed',
                'kamarruangan_nobed',
                array(               // related city displayed as a link
                    'name' => 'kamarruangan_status',
                    'type' => 'raw',
                    'value' => (($model->kamarruangan_status == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
                array(               // related city displayed as a link
                    'name' => 'kamarruangan_aktif',
                    'type' => 'raw',
                    'value' => (($model->kamarruangan_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan '.($this->module->id == 'hemodialisa')?'Tempat Tidur (Bed)':'Kamar Ruangan', array('{icon}' => '<i class="entypo-folder"></i>')),
            $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success','style'=>'margin:6px 12px !important;')
        );
        
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>