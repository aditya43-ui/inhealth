<?php
$this->breadcrumbs = array(
    'Jenis Pembayaran' => array('admin'),
    $model->jnspembayar_id,
);

$nama_d = "-";
$nama_k = "-";

$rekD = JnspembrekM::model()->findByAttributes(array(
    'jnspembayar_id' => $model->jnspembayar_id,
    'debitkredit' => 'D',
));
$rekK = JnspembrekM::model()->findByAttributes(array(
    'jnspembayar_id' => $model->jnspembayar_id,
    'debitkredit' => 'K',
));

if (!empty($rekD)) {
    $rek = Rekening5M::model()->findByPk($rekD->rekening5_id);
    if (!empty($rek)) {
        $nama_d = $rek->nmrekening5;
    }
}

if (!empty($rekK)) {
    $rek = Rekening5M::model()->findByPk($rekK->rekening5_id);
    if (!empty($rek)) {
        $nama_k = $rek->nmrekening5;
    }
}

$bank_nama = "";
$modJenisPemRek = JnspembrekM::model()->findByAttributes(array('jnspembayar_id' => $model->jnspembayar_id));

if (isset($modJenisPemRek)) {
    $bank_nama = (isset($modJenisPemRek->bank) ? $modJenisPemRek->bank->bankDanAtasNama : "");
}
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jenis Pembayaran</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'jnspembayar_id',
                'jnspembayar_nama',
                //'jnspembayar_namalain',
                array(
                    'label' => 'Bank',
                    'type' => 'raw',
                    'value' => $bank_nama,
                ),
                //'bank_id',
                array(
                    'label' => 'Lama Jatuh Tempo',
                    'value' => empty($model->jatuhtempo) ? "-" : ($model->jatuhtempo . " Hari"),
                ),
                'jnspembayar_cp',
                'jnspembayar_nomobile',

                array(
                    'label' => 'Rekening Debit',
                    'value' => $nama_d,
                ),
                array(
                    'label' => 'Rekening Kredit',
                    'value' => $nama_k,
                ),

                array(
                    'label' => 'Status',
                    'value' => $model->jnspembayar_aktif ? "Aktif" : "Tidak Aktif",
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl('update', array('id' => $model->jnspembayar_id, 'modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('title' => 'Ubah', 'class' => 'btn btn-danger')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jenis Pembayaran', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('content' => '')); ?>
        </div>
    </div>
</div>