<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Tipe Paket</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Pengaturan Tipe Paket' => array('admin'),
            $model->tipepaket_id,
        );

        //$arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tipe Paket', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        ////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tipe Paket', 'icon'=>'list', 'url'=>array('index'))) ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Paket', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tipe Paket', 'icon'=>'pencil','url'=>array('update','id'=>$model->tipepaket_id))) :  '' ;
        ////                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Tipe Paket','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->tipepaket_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        ////                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Paket', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;
        //
        //$this->menu=$arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //		'tipepaket_id',
                'carabayar.carabayar_nama',
                'penjamin.penjamin_nama',
                'kelaspelayanan.kelaspelayanan_nama',
                'tipepaket_nama',
                'tipepaket_singkatan',
                'tipepaket_namalainnya',
                'tglkesepakatantarif',
                'nokesepakatantarif',
                'tarifpaket',
                'paketsubsidiasuransi',
                // 'paketsubsidipemerintah',
                'paketsubsidirs',
                'paketiurbiaya',
                'nourut_tipepaket',
                'keterangan_tipepaket',
                array(               // related city displayed as a link
                    'name' => 'tipepaket_aktif',
                    'type' => 'raw',
                    'value' => (($model->tipepaket_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Tipe Paket', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>