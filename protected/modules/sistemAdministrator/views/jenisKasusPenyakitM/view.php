<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Kasus Penyakit</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Jenis Kasus Penyakit' => array('admin'),
            $model->jeniskasuspenyakit_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jenis Kasus Penyakit Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kasus Penyakit', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Kasus Penyakit', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Jenis Kasus Penyakit', 'icon'=>'pencil','url'=>array('update','id'=>$model->jeniskasuspenyakit_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Jenis Kasus Penyakit','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->jeniskasuspenyakit_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Kasus Penyakit Ruangan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'ID',
                    'type' => 'raw',
                    'name' => 'jeniskasuspenyakit_id',
                ),
                'jeniskasuspenyakit_nama',
                'jeniskasuspenyakit_namalainnya',
                array(
                    'label' => 'Ruangan',
                    'type' => 'raw',
                    'value' => $this->renderPartial($this->path_view . '_ruangan', array('jeniskasuspenyakit_id' => $model->jeniskasuspenyakit_id), true),
                ),
                array(               // related city displayed as a link
                    'name' => 'jeniskasuspenyakit_aktif',
                    'type' => 'raw',
                    'value' => (($model->jeniskasuspenyakit_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Jenis Kasus Penyakit', array('{icon}' => '<i class="entypo-folder"></i>')),
            $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        );
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>