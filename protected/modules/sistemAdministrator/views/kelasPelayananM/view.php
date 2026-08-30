<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelas Pelayanan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sakelas Pelayanan Ms' => array('index'),
            $model->kelaspelayanan_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelas Pelayanan ','header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Pelayanan', 'icon'=>'list', 'url'=>array('index'))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Pelayanan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kelas Pelayanan', 'icon'=>'pencil','url'=>array('update','id'=>$model->kelaspelayanan_id))) :  '' ;
        // array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kelas Pelayanan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kelaspelayanan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Pelayanan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kelaspelayanan_id',
                'jeniskelas.jeniskelas_nama',
                'kelaspelayanan_nama',
                'kelaspelayanan_namalainnya',
                array(
                    'label' => 'Ruangan',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_ruangan', array('kelaspelayanan_id' => $model->kelaspelayanan_id), true),
                ),
                array(               // related city displayed as a link
                    'name' => 'kelaspelayanan_aktif',
                    'type' => 'raw',
                    'value' => (($model->kelaspelayanan_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kelas Pelayanan', array('{icon}' => '<i class="icon-file icon-white"></i>')),
                $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>