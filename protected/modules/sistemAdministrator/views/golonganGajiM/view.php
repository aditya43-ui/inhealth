<div class="panel panel-gradient">
    <div class="panel-heading">
        <?php if ($this->hasTab) : ?>
            <div class="panel-title">
                <i class="far fa-eye"></i> Lihat <b>Golongan Gaji</b>
            </div>
        <?php else : ?>
            <div class="panel-title">
                <i class="far fa-eye"></i> Lihat <b>Golongan Gaji</b>
            </div>
        <?php endif; ?>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Golongan Gaji' => array('admin'),
            $model->golongangaji_id,
        );

        $arrMenu = array();
        //    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Golongan Gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        //    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Gaji', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'golongangaji_id',
                'golonganpegawai.golonganpegawai_nama',
                'masakerja',
                'jmlgaji',
                'jenisgolongan',
                array(
                    'name' => 'golongangaji_aktif',
                    'type' => 'raw',
                    'value' => (($model->golongangaji_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Golongan Gaji', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>