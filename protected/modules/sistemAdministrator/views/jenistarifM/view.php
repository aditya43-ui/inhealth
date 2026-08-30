<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis tarif</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sajenis Tarif Ms' => array('index'),
            $model->jenistarif_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Tarif ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Tarif', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Tarif', 'icon'=>'pencil','url'=>array('update','id'=>$model->jenistarif_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Jenis Tarif','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jenistarif_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Tarif', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'jenistarif_id',
                'jenistarif_nama',
                'jenistarif_namalainnya',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->jenistarif_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Tarif', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>