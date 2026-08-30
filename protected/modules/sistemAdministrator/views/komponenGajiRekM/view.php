<?php
$this->breadcrumbs = array(
    'Rekening Komponen Gaji' => array('admin'),
    $model->komponengajirek_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Rekening Komponen Gaji</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <?php
            $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'komponengajirek_id',
                    array(
                        'label' => 'Komponen Gaji',
                        'type' => 'raw',
                        'value' => isset($model->komponengaji->komponengaji_nama) ? $model->komponengaji->komponengaji_nama : "Tidak diset",
                    ),
                    array(
                        'label' => 'Rekening',
                        'type' => 'raw',
                        'value' => isset($model->rekening5->nmrekening5) ? $model->rekening5->nmrekening5 : "Tidak diset",
                    ),
                    array(
                        'label' => 'Jenis',
                        'type' => 'raw',
                        'value' => ($model->ispenggajian == 1) ? "Penggajian" : (($model->ispembayarangaji == 1) ? "Pembayaran Gaji" : " - "),
                    ),
                    array(
                        'label' => 'Debit / Kredit',
                        'type' => 'raw',
                        'value' => ($model->debitkredit == "D") ? "Debit" : "Kredit",
                    ),
                ),
            ));
            ?>

        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->komponengajirek_id, 'modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Rekening Komponen Gaji', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
        </div>
    </div>
</div>