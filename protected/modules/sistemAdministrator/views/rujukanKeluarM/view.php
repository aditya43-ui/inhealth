<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Rujukan ke Luar</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <!--<fieldset class="box">-->
        <!--<legend class="rim">Lihat Rujukan Keluar</legend>-->
        <?php
        $this->breadcrumbs = array(
            'Lkrujukankeluar Ms' => array('index'),
            $model->rujukankeluar_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Rujukan Keluar '/*.$model->rujukankeluar_id*/, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Rujukan Keluar', 'icon'=>'list', 'url'=>array('index'))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Rujukan Keluar', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Rujukan Keluar', 'icon'=>'pencil','url'=>array('update','id'=>$model->rujukankeluar_id))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Rujukan Keluar','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->rujukankeluar_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
        //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Rujukan Keluar', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(

                'rumahsakitrujukan',
                'alamatrsrujukan',
                'telp_fax',
                //'rujukankeluar_aktif',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->rujukankeluar_aktif) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
                'kodeppk_dirujuk'
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Rujukan Keluar', array('{icon}' => '<i class="entypo-folder"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            );
            $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
        <!--</fieldset>-->
    </div>
</div>