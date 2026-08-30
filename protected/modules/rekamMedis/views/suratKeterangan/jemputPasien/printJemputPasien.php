<?php
if (isset($_POST["EXCEL"])) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . "Surat Jalan" . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
$tglberangkat = explode(' ', $model->tglberangkatpst);
$tgl = $format->formatDateTimeForUser($tglberangkat[0]);
$waktu = $tglberangkat[1];
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p .paragraph {
        text-indent: 50px;
        text-align: justify;
    }
</style>
<TABLE>
    <div>
        <TABLE ALIGN="CENTER">
            <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT JALAN AMBULANCE JEMPUT PASIEN"; ?></U></span></B>
                </td>
            </tr>
            <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <div style="margin-left:50px;">
        <p align="justify">
            Kepada Yth :<br>
            <?php echo $model->kepadayth; ?></br>
            <?php echo $data->kecamatan->kecamatan_nama . " " . $this->kodepos; ?>
        </p><br>
        <p align="justify" class="paragraph">
            Saya yang bertanda tangan di bawah ini :
            Saya yang bertanda tangan dibawah ini, Dokter <?php echo $data->nama_rumahsakit; ?>, dengan ini menerangkan bahwa:
        </p>
        <p align="justify" class="paragraph">
        <table style="width: 750px;margin-left:50px;">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo (!empty($model->ygbertandatangan_id) ? $model->pegawai->namaLengkap : "-"); ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td><?php echo (!empty($model->ygbertandatangan_id) ? $model->pegawai->kelompokjabatan : "") . " " . $data->nama_rumahsakit; ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo $data->alamatlokasi_rumahsakit; ?></td>
            </tr>
        </table>
        <p align="justify" class="paragraph">
            Dengan ini memohon izin untuk masuk ke Bandara Udara untuk menjemput pasien dengan data sebagai berikut :
            <br>
        <table style="width:310px;margin-left:50px;width:">
            <tr>
                <td>Nama Pasien</td>
                <td>:</td>
                <td><?php echo $modPasien->nama_pasien; ?></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->umur; ?></td>
            </tr>
            <tr>
                <td>Dari/Ke</td>
                <td>:</td>
                <td><?php echo $model->dari_ke; ?></td>
            </tr>
            <tr>
                <td>Nama Pesawat</td>
                <td>:</td>
                <td><?php echo $model->namapesawat; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td><?php echo (!empty($tgl) ? $tgl : "-"); ?></td>
            </tr>
            <tr>
                <td>Pukul</td>
                <td>:</td>
                <td><?php echo (!empty($waktu) ? $waktu : "-"); ?></td>
            </tr>
        </table>
        Menggunakan kendaraaan Ambulans sebagai berikut :
        <br><br>
        <table style="width:315px;margin-left:50px;">
            <tr>
                <td>RS / POLIKLINIK</td>
                <td>:</td>
                <td><?php echo $data->nama_rumahsakit; ?></td>
            </tr>
            <tr>
                <td>Nomor Polisi</td>
                <td>:</td>
                <td><?php echo (!empty($model->mobilambulans_id) ? $model->mobil->nopolisi : "-"); ?></td>
            </tr>
            <tr>
                <td>No. SIM Pengemudi</td>
                <td>:</td>
                <td><?php echo (!empty($model->keterangan) ? $model->keterangan : "-"); ?></td>
            </tr>
            <tr>
                <td>Nama Pengemudi</td>
                <td>:</td>
                <td><?php
                    $supir = PegawaiM::model()->findByPk($model->supirambulans_id);
                    echo empty($supir) ? "-" : $supir->nama_pegawai; ?></td>
            </tr>
        </table>
        Demikian permohonan ini kami perbuat. Atas perhatian Bapak kami ucapakan terima kasih.
        </p>
    </div><br><br><br><br><br>
    <div style="margin-left:400px;text-align: center;">
        <?php $date = date('Y-m-d'); ?>
        <?php echo $data->kecamatan->kecamatan_nama; ?>, <?php echo $format->formatDateTimeForUser($date); ?>
        <br><br><br><br><br>
        <?php echo (!empty($model->mengetahui_surat) ? "<u><b>" . $model->mengetahui_surat . "</b></u>" : " _________________ "); ?>
    </div>
</TABLE>