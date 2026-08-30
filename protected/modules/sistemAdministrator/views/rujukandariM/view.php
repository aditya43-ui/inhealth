<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Perujuk</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Rujukandari Ms' => array('index'),
            $model->rujukandari_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Rujukan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rujukan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <!--<fieldset class="box">-->
        <!--<legend class="rim">Lihat Rujukan</legend>-->
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'asalrujukan.asalrujukan_nama',
                'namaperujuk',
                'spesialis',
                'alamatlengkap',
                'notelp',
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Perujuk', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('Admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
        <!--</fieldset> DAFTAR RUJUKAN-->
    </div>
</div>