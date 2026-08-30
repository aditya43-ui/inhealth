<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN BMHP di Billing Kasir 
?>
<?php
if (isset($_GET['sukses'])) {
    //Yii::app()->user->setFlash('success',"Data pemakaian Bahan berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pemakaianbahp-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#no_pendaftaran',
)); ?>

<?php
$kelaspelayanan_id = (!empty($modPasienAdmisi->kelaspelayanan_id) ? $modPasienAdmisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id);
$carabayar_id = (!empty($modPasienAdmisi->carabayar_id) ? $modPasienAdmisi->carabayar_id : $modPendaftaran->carabayar_id);
$penjamin_id = (!empty($modPasienAdmisi->penjamin_id) ? $modPasienAdmisi->penjamin_id : $modPendaftaran->penjamin_id);
$instalasi_id = (!empty($modPasienAdmisi->ruangan->instalasi_id) ? $modPasienAdmisi->ruangan->instalasi_id : $modPendaftaran->ruangan->instalasi_id);
$ruangan_id = (!empty($modPasienAdmisi->ruangan_id) ? $modPasienAdmisi->ruangan_id : $modPendaftaran->ruangan_id);
?>
<div style="display:none;">
    <?php echo Chtml::textField('pendaftaran_id', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('pasienadmisi_id', $modPasienAdmisi->pasienadmisi_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('kelaspelayanan_id', $kelaspelayanan_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('carabayar_id', $carabayar_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('penjamin_id', $penjamin_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('instalasi_id', $instalasi_id, array('readonly' => true)); ?>
    <?php echo Chtml::textField('ruangan_id', $ruangan_id, array('readonly' => true)); ?>
</div>

<?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'riwayat-obatalkespasien-t',
    'content' => array(
        'content-riwayat-obatalkespasien-t' => array(
            'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
            'isi' => '
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <th>No.</th>
                                        <th>Tgl. Pelayanan</th>
                                        <th>Obat / Alat Kesehatan</th>
                                        <th>Satuan Kecil</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Hapus</th>
                                        <th>Verifikasi</th>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan=7>Data tidak ditemukan</td></tr>
                                    </tbody>
                                </table>',
            'active' => true,
        ),
    ),
)); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class='fas fa-tablets'></i> Obat dan Alkes
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <?php $this->renderPartial($this->path_view_bmhp . '_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>BMHP</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="items table table-bordered table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Obat / Alat Kesehatan</th>
                    <th>Satuan Kecil</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$dataOas) > 0) {
                    foreach ($dataOas as $i => $modObatAlkesPasien) {
                        echo $this->renderPartial($this->path_view_bmhp . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien));
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
    if (!isset($_GET['frame'])) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            "javascript:void(0);",
            array(
                'class' => 'btn btn-default',
                'onclick' => 'refreshHalaman();'
            )
        );
    }
    if (!isset($_GET['sukses'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ");return false"));
    }

    $content = $this->renderPartial($this->path_view_bmhp . 'tips/tipsPemakaianBmhp', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view_bmhp . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>

<script>

function verifTindakan(obj){

var tindakanpelayanan_id = $(obj).closest('tr').find('.tindakanpelayanan_id').val();
var pendaftaran_id = $(obj).closest('tr').find('.pendaftaran_id').val();

if($(obj).is(':checked')) {

    $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('billingKasir/tindakanRawatJalan/VerifikasiTindakan'); ?>',
        data: {tindakanpelayanan_id:tindakanpelayanan_id},
        dataType: "json",
        success:function(data){
            $(obj).closest('tr').detach();
            myAlert(data.pesan);
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
        }
    });

}

}
</script>