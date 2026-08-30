<?php
//========= Dialog Detail Hasil Pemeriksaaan Lab =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailHasilLab',
    'options' => array(
        'title' => 'Data Hasil Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="pesan" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
//=======================================================================
?>


<?php
//========= Dialog Detail Tindakan, Terapi dan Pemakaian Bahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailData',
    'options' => array(
        'title' => 'Detail Data',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="detailDialog" width="100%" height="500">
</iframe>
<?php
$this->endWidget();
?>

<?php
//========= Dialog Verifikasi Form Transaksi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogVerifikasi',
    'options' => array(
        'title' => 'Verifikasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 600,
        'resizable' => false,
    ),
));
?>
<div id="frame_verifikasi">
    <table width="100%">
        <tr>
            <td>No. RM</td>
            <td>:</td>
            <td id="no_rekam_medik_ver"></td>
            <td>Nama Pasien</td>
            <td>:</td>
            <td id="nama_pasien_ver"></td>
        </tr>
        <tr>
            <td>Tgl. Lahir</td>
            <td>:</td>
            <td id="tanggal_lahir_ver"></td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td id="jeniskelamin_ver"></td>
        </tr>
        <tr>
            <td>Alamat Pasien</td>
            <td>:</td>
            <td id="alamat_pasien_ver"></td>
        </tr>
    </table>
    <br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                Hasil Penggabungan No RM
            </div>
        </div>
        <div class="panel-body">
            <ul class="nav nav-tabs bordered">
                <li class="active">
                    <a href="#tab_menu_kunjungan_verifikasi" data-toggle="tab">Riwayat Kunjungan</a>
                </li>
                <li>
                    <a href="#tab_menu_medis_verifikasi" data-toggle="tab">Riwayat Medis</a>
                </li>
                <li>
                    <a href="#tab_menu_tagihan_verifikasi" data-toggle="tab">Riwayat Tagihan</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab_menu_kunjungan_verifikasi" class="tab-pane active">
                    <table class="table table-bordered table-condensed" width="100%">
                        <thead>
                            <tr>
                                <th>Tgl. Pendaftaran</th>
                                <th>No. Pendaftaran</th>
                                <th>Instalasi</th>
                                <th>Ruangan</th>
                            </tr>
                        </thead>
                        <tbody id="list_kunjungan">

                        </tbody>
                    </table>
                </div>

                <div id="tab_menu_medis_verifikasi" class="tab-pane">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Tgl. Pendaftaran/<br />No. Pendaftaran</th>
                                <th>Anamnesis</th>
                                <th>Pemeriksaan Penunjang</th>
                                <th>Pelayanan</th>
                                <th>Diagnosis</th>
                            </tr>
                        </thead>
                        <tbody id="list_medis">

                        </tbody>
                    </table>
                </div>
                <div id="tab_menu_tagihan_verifikasi" class="tab-pane">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Tgl. Pendaftaran/<br />No. Pendaftaran</th>
                                <th>Pembayaran/<br />No. Pembayaran</th>
                                <th>Ruangan Pelayanan</th>
                                <th>Jumlah Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody id="list_tagihan">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="form-action">
        <?php
        echo CHtml::htmlButton('<i class="entypo-check"></i> Gabung', array(
            'title' => 'Gabung',
            'class' => 'btn btn-primary',
            'type' => 'button',
            'onclick' => 'confirmSubmit();',
            'disabled' => false
        ));

        ?>
    </div>
</div>
<?php
$this->endWidget();
?>