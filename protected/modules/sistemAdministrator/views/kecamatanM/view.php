<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kecamatan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sakecamatan Ms' => array('index'),
            $model->kecamatan_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kecamatan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kecamatan', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kecamatan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Kecamatan', 'icon'=>'pencil','url'=>array('update','id'=>$model->kecamatan_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Kecamatan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->kecamatan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kecamatan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'kecamatan_id',
                        'kabupaten.kabupaten_nama',
                        'kecamatan_nama',
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'kecamatan_namalainnya',
                        'latitude',
                        'longitude',
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        array(
                            'label' => 'Aktif',
                            'type' => 'raw',
                            'value' => (($model->kecamatan_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                        ),
                    ),
                ));
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->kecamatan_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kecamatan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('KecamatanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>