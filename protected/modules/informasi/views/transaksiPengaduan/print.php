<style type="text/css">
   .deskripsi{
        padding-left: 25px;
    }
    table tr td {
        padding: 5px;
    }
</style>
<?php
echo $this->renderPartial('application.views.headerReport.headerRincianBaru');
?>
<p style="margin: 0; text-align: center;">
    <h3>FORMULIR TANGGAPAN</h3>
    <h3>ATAS PENYAMPAIAN KELUHAN PASIEN </h3>
</p>
<br>
<p>
    Solusi / Tanggapan atas penyampaian keluahan dengan :
</p>
<table style="width: 100%; border: none;">
    <tr>
        <td style="width: 230px;">Nama Pelapor</td>
        <td>: <?php echo $model->kp_namapelapor; ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo $pasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $model->kp_alamat_pelapor; ?></td>
    </tr>
    <tr>
        <td>No Identitas</td>
        <td>: <?php echo $model->kp_noidentitasn_pelapor; ?></td>
    </tr>
    <tr>
        <td>Tanggal Penyampaian Keluhan</td>
        <td>: <?php echo $format->formatDateTimeId($model->kepuasanpasien_tgl); ?></td>
    </tr>
    <tr>
        <td>Jam Penyampaian Keluhan</td>
        <td>: -</td>
    </tr>
    <tr>
        <td>Unit Terkait</td>
        <td>: <?php echo $model->kp_namaunit; ?></td>
    </tr>
    <tr>
        <td>Target Tanggal Penyelesaian</td>
        <td>: <?php echo $format->formatDateTimeId($model->kp_tindaklanjut_tgl); ?></td>
    </tr>
    <tr>
        <td>Telepon Yang Bisa Dihubungi</td>
        <td>: <?php echo $model->kp_hp_pelapor; ?></td>
    </tr>
    <tr>
        <td>Uraian Keluhan</td>
        <td>: <?php echo $model->kp_deskripsi_aduan; ?> </td>
    </tr>
	<tr>
        <td>Tindakan Awal</td>
        <td>: <?php echo $model->kp_tindakawal_desk; ?> </td>
    </tr>
	<tr>
        <td>Tindakan Lanjut</td>
        <td>: <?php echo $model->kp_tindaklanjut_desk; ?> </td>
    </tr>
    <tr>
        <td colspan="2" class="deskripsi"> <?php // echo $model->kp_deskripsi_aduan; ?> </td>
    </tr>
</table>
<br><br>
<table>
	<tr>
            <td width="75%" style="text-align: center;">
                <br><br><br>
                Direktur RSUD dr.R.Soedarsono,
                <br><br><br><br><br>
                ( ............................. )
            </td>
            <td style="text-align: center;"> 
		<?php echo Yii::app()->user->getState('kabupaten_nama') ?>, 
                <?php echo $format->formatDateTimeId(date('Y-m-d')); ?>
                <br><br>
                Ka Sie Pengaduan,
		<br><br><br><br><br>
                <?php // $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                <b><?php // echo $pegawai->nama_pegawai; ?></b>
                ( ............................. )
            </td>
	</tr>
</table>