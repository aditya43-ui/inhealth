<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Tanggungan Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Tanggungan Penjamin' => array('admin'),
            $model->tanggunganpenjamin_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tanggungan Penjamin #'.$model->tanggunganpenjamin_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SATanggunganpenjaminM', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' SATanggunganpenjaminM', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' SATanggunganpenjaminM', 'icon'=>'pencil','url'=>array('update','id'=>$model->tanggunganpenjamin_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' SATanggunganpenjaminM','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->tanggunganpenjamin_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tanggungan Penjamin', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    //'tanggunganpenjamin_id',
                    'carabayar.carabayar_nama',
                    //'penjamin.penjamin_nama',
                    array(
                        'label' => 'Nama Penjamin',
                        'type' => 'raw',
                        'value' => $this->renderPartial($this->path_view . '_tanggunganPenjamin', array('carabayar_id' => $model->carabayar_id, 'kelaspelayanan_id' => $model->kelaspelayanan_id), true),
                    ),
                    'kelaspelayanan.kelaspelayanan_nama',
                    array(
                        'name' => 'tipenonpaket',
                        'value' => (($model->tipenonpaket_id == Params::TIPEPAKET_ID_NONPAKET) ? "Ya" : "Tidak"),
                    ),
                    //		'subsidiasuransitind',
                    //		'subsidipemerintahtind',
                    //		'subsidirumahsakittind',
                    //		'iurbiayatind',
                    //		'subsidiasuransioa',
                    //		'subsidipemerintahoa',
                    //		'subsidirumahsakitoa',
                    //		'iurbiayaoa',
                    //		'persentanggcytopel',
                    //		'makstanggpel',
                    //'tanggunganpenjamin_aktif',
                    array(
                        'name' => 'tanggunganpenjamin_aktif',
                        'value' => ((!empty($model->tanggunganpenjamin_aktif)) ? "Ya" : "Tidak"),
                    ),

                ),
            )); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(

                    'subsidiasuransitind',
                    'subsidipemerintahtind',
                    'subsidirumahsakittind',
                    'iurbiayatind',
                    'subsidiasuransioa',
                    'subsidipemerintahoa',
                    'subsidirumahsakitoa',
                    'iurbiayaoa',
                    'persentanggcytopel',
                    'makstanggpel',
                ),
            )); ?>
        </div>

        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Tanggungan Penjamin', array('{icon}' => '<i class="icon-file icon-white"></i>')),
            $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        );
        $this->widget('UserTips', array('type' => 'view'));
        ?>
    </div>
</div>