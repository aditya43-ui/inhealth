<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Asal Aset</b></div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Asal Aset' => array('admin'),
            $model->asalaset_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Asal Aset', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SAAsalasetM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SAAsalasetM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SAAsalasetM', 'icon'=>'pencil','url'=>array('update','id'=>$model->asalaset_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SAAsalasetM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->asalaset_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Asal Aset', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'asalaset_id',
                'asalaset_nama',
                'asalaset_singkatan',
                'asalaset_aktif',
            ),
        ));
        ?>
        <div class="form-actions">
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Asal Aset', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success',));
            $this->widget('UserTips', array('type' => 'view'));
            ?>
        </div>
    </div>
</div>