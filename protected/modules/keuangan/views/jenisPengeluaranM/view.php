<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Pengeluaran Umum</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Pengeluaran Umum' => array('admin'),
            $model->jenispengeluaran_id,
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'jenispengeluaran_id',
                'jenispengeluaran_kode',
                'jenispengeluaran_nama',
                'jenispengeluaran_namalain',
                array(
                    'label' => 'PPh 21 (%)',
                    'name' => 'persenpph_21',
                    'value' => str_replace(".", ",", $model->persenpph_21),
                ),
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
                    'name' => 'jenispengeluaran_aktif',
                    'type' => 'raw',
                    'value' => (($model->jenispengeluaran_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),

            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Pengeluaran Umum', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('jenisPengeluaranM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>