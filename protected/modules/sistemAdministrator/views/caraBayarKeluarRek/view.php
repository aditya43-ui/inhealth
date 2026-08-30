<?php
$this->breadcrumbs = array(
    'Jurnal Rekening Cara Pembayaran Keluar' => array('index'),
    $model->carabayarkeluarrek_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jurnal Rekening Cara Pembayaran Keluar</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'carabayarkeluarrek_id',
                array(
                    'label' => 'Jenis Penjamin Keluar',
                    'type' => 'raw',
                    'value' => isset($model->carabayarkeluar) ? $model->carabayarkeluar : "Tidak diset",
                ),
                array(
                    'label' => 'Rekening',
                    'type' => 'raw',
                    'value' => isset($model->rekening5->nmrekening5) ? $model->rekening5->nmrekening5 : "Tidak diset",
                ),
                array(
                    'label' => 'Debit / Kredit',
                    'type' => 'raw',
                    'value' => ($model->debitkredit == "D") ? "Debit" : "Kredit",
                ),
            ),
        ));
        ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->carabayarkeluarrek_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Cara Pembayaran Keluar', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
        </div>
    </div>
</div>