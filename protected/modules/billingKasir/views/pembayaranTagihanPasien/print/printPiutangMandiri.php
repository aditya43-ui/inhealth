<style>
    .tab_list {
        width: 100%;
        border-collapse: collapse;
    }
    
    .tab_list td {
        padding-bottom: 1px;
        vertical-align: top;
    }

    .tandatangan_head {
        height: 3cm;
    }
</style>


<?php
$format = new MyFormatter;
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
// $model->jumlah_total = 60000000;
?>
<?php
echo $this->renderPartial('application.views.headerReport.headerDefaultNewV1', array(
    'judulLaporan'=>'SURAT PERNYATAAN'
));
?>
<br/></br>
Yang bertandatangan dibawah ini :
<table class="tab_list">
    <tr>
        <td width="200">Nama</td>
        <td width="10">:</td>
        <td><?php echo $model->nama_penanggungjawab; ?></td>
    </tr>
    <tr>
        <td>Alamat (Sesuai KTP)</td>
        <td>:</td>
        <td><?php echo $model->alamatktp_penanggungjawab; ?></td>
    </tr>
    <tr>
        <td>Umur</td>
        <td>:</td>
        <td><?php echo $model->umur_penanggungjawab; ?> Th</td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td>:</td>
        <td><?php echo $model->pekerjaan_penanggungjawab; ?></td>
    </tr>
    <tr>
        <td>No. Telp / HP</td>
        <td>:</td>
        <td><?php echo $model->notelp_penanggungjawab." / ".($model->nomobile_penanggungjawab ?? "-"); ?></td>
    </tr>
</table>
<br/>
Dengan ini menyatakan : 
<table class="tab_list">
    <tr>
        <td width="200">Nama Pasien</td>
        <td width="10">:</td>
        <td><?php echo $pasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>:</td>
        <td><?php echo $pasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td>No. RM / No. Billing</td>
        <td>:</td>
        <td><?php echo $pasien->no_rekam_medik." / ".$model->nopembayaran; ?></td>
    </tr>
    <tr>
        <td>Tgl MRS / Tgl KRS</td>
        <td>:</td>
        <td><?php echo $model->tglmrs_krs; ?></td>
    </tr>
    <tr>
        <td>Tempat Layanan</td>
        <td>:</td>
        <td><?php 
        $ruangan = RuanganM::model()->findByPk($model->ruanganpelakhir_id);

        echo $ruangan->ruangan_nama ?? "-";

        if (!empty($model->pasienadmisi_id)) {
            $admisi = PasienadmisiT::model()->findByPk($model->pasienadmisi_id);
            echo " - ".($admisi->kelaspelayanan->kelaspelayanan_nama ?? "-");
        }

        
        ?></td>
    </tr>
</table>
<br/>
Adalah benar masih mempunyai tanggungan biaya sejumlah 
Rp. <?php echo empty($model->jumlah_total) ? "-" : $model->jumlah_total; ?>
 ( <?php echo empty($model->jumlah_total) ? "-" : (MyFormatter::formatNumberTerbilang($model->jumlah_total, 3)." Rupiah"); ?> ).<br/>
Adapun tanggungan tersebut akan kami selesaikan dalam waktu <?php echo $model->jangka_waktu ?? "-"; ?> hari.
<br/></br>
<?php echo $model->catatan; ?>
<br/>
<br/>
Demikian pernyataan ini dibuat untuk dipergunakan sebagaimana mestinya.
<br/><br/><br/>

<?php

if (!empty($model->jumlah_total)) {
    $model->jumlah_total = MyFormatter::formatRupiahForDB($model->jumlah_total);
}

$total_piutang = $model->jumlah_total ?? 0;
$persen = "50%";
$level = 2;

if ($total_piutang <= 20000000) {
    $level = 2;
    $persen = "50%";
} else if ($total_piutang <= 50000000) {
    $level = 3;
    $persen = "33%";
} else {
    $level = 4;
    $persen = "25%";
}

$kabupaten = strtolower(Yii::app()->user->getState('kabupaten_nama'));
$kabupaten = str_replace("kota", "", $kabupaten);
$kabupaten = trim(ucwords($kabupaten));

$lokasi_tanggal = $kabupaten.", ".$format->formatDateTimeId(date('Y-m-d'));

?>

<table class="tab_list">
    <tr>
        <td width="50%" style="text-align: center">Mengetahui,<br/>Petugas Loket
        <br/><br/><br/><br/><br/>
        (
        <?php $peg = LoginpemakaiK::model()->findByPk($model->create_loginpemakai_id);
        echo $peg->pegawai->namaLengkap ?? "-"; ?>
        )
        </td>
        <td></td>
        <td width="50%" style="text-align: center">
            <?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?><br/>
            Yang membuat pernyataan
            <br/><br/><br/><br/><br/>
            ( <?php echo $model->nama_penanggungjawab ?? "-" ?> )
        </td>
    </tr>
</table>

<br/>
<br/>
Keterangan : 
<table class="tab_list">
    <tr>
        <td width="100">Lembar 1</td>
        <td width="10">:</td>
        <td>Bagian Tagihan - Sub. Bag. Penerimaan & Pendapatan</td>
    </tr>
    <tr>
        <td>Lembar 2</td>
        <td>:</td>
        <td>Pasien / Penanggung Jawab Pasien</td>
    </tr>
    <tr>
        <td>Lembar 3</td>
        <td>:</td>
        <td>Tempat Layanan</td>
    </tr>
</table>


<?php //if ($level >= 3): ?>
<br/>
<br/>
<table class="tab_list">
    <tr>
        <td width=<?php echo $persen; ?> style="text-align: center">Mengetahui,<br/>
        <div class="tandatangan_head">Petugas Pengendali Piutang Umum</div>
        (
        <?php 
        echo "____________________"; ?>
        )
        </td>
        <td width=<?php echo $persen; ?> style="text-align: center"><br/>
        <div class="tandatangan_head">Sub Koordinator</div>
        (
        <?php 
        echo "____________________"; ?>
        )
        </td>
        <?php if ($level >= 3): ?>
        <td width=<?php echo $persen; ?> style="text-align: center"><br/>
        <div class="tandatangan_head">Kepala Bagian Keuangan dan akuntansi</div>
        (
        <?php 
        echo "____________________"; ?>
        )
        </td>
        <?php endif; ?>
        <?php if ($level >= 4): ?>
        <td width=<?php echo $persen; ?> style="text-align: center"><br/>
        <div class="tandatangan_head">Wakil Direktur Umum Dan Keuangan</div>
        (
        <?php 
        echo "____________________"; ?>
        )
        </td>
        <?php endif; ?>
    </tr>
</table>
<?php // endif; ?>


<br/><br/>
<?php if (empty($caraPrint)) { ?>
<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'printPiutangMandiriPasien()')); //formSubmit(this,event) ?>

<script>
    function printPiutangMandiriPasien() {
        window.open("<?php echo $this->createUrl('printBayarPiutang', array('id'=>$model->pembayaranpelayanan_id, 'caraPrint'=>'PRINT')); ?>","",'location=_new, width=1024px');
    }
</script>
<?php } ?>