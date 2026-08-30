<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kategori Pengaduan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Kategori Pengaduan' => array('view', 'id' => $model->kategoripengaduan_id),
            $model->kategoripengaduan_id,
        );

        $arrMenu = array();

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'kategoripengaduan_id',
                'namakategori',
                'warnakategoripengaduan',
                'estimasipenyelesaian',
                array(
                    'name' => 'kategoripengaduan_aktif',
                    'type' => 'raw',
                    'value' => (($model->kategoripengaduan_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kategori Pengaduan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('MasterKategoriPengaduan/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>