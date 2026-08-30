<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <?= ($this->module->id == 'hemodialisa')?'Tempat Tidur (Bed)':'Slot Bed' ?></div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Slot Bed' => array('view', 'id' => $model->slotbed_id),
            $model->slotbed_id
        );

        $arrMenu = array();
        array_push($arrMenu, array('label' => Yii::t('mds', 'View') . ' Slot Bed ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Slot Bed', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Slot Bed', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Slot Bed', 'icon'=>'pencil','url'=>array('update','id'=>$model->slotbed_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Slot Bed','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->slotbed_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Slot Bed', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'slotbed_id',
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
                'slotbed_noslot',
                'slotbed_jmlbed',
                'slotbed_nobed',
                array(               // related city displayed as a link
                    'name' => 'slotbed_status',
                    'type' => 'raw',
                    'value' => (($model->slotbed_status == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
                array(               // related city displayed as a link
                    'name' => 'slotbed_aktif',
                    'type' => 'raw',
                    'value' => (($model->slotbed_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan '.($this->module->id == 'hemodialisa')?'Tempat Tidur (Bed)':'Slot Bed', array('{icon}' => '<i class="entypo-folder"></i>')),
            $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success','style'=>'margin:6px 12px !important;')
        );
        
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>