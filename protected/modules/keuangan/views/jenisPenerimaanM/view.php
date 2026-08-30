<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Pencarian Umum</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Penerimaan Umum' => array('admin'),
            $model->jenispenerimaan_id,
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'jenispenerimaan_id',
                'jenispenerimaan_kode',
                'jenispenerimaan_nama',
                'jenispenerimaan_namalain',
                array(
                    'label' => 'PPh 23 (%)',
                    'name' => 'persenpph_23',
                    'value' => str_replace(".", ",", $model->persenpph_23),
                ),
                array(
                    'label' => 'PPh Final (%)',
                    'name' => 'persenpph_22',
                    'value' => str_replace(".", ",", $model->persenpph_22),
                ),
                array(               // related city displayed as a link
                    'name' => 'jenispenerimaan_aktif',
                    'type' => 'raw',
                    'value' => (($model->jenispenerimaan_aktif == 1) ? 'Aktif' : 'Tidak Aktif'),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Penerimaan Umum', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('jenisPenerimaanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>