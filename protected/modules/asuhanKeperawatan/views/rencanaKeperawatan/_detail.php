<?php
/**
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * digunakan untuk menampilkan detail rincian
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>

<table class="table noborder paddingtext2">
    <tr>
        <td style="text-align:center;" align="center"><b>PENGKAJIAN </b></td>
    </tr>
</table>

<table class="table noborder paddingtext2">
    <tr>
        <th><p>No. Pengkajian</p></th>
        <td ><p> : <?php echo isset($modPengkajian->no_pengkajian) ? $modPengkajian->no_pengkajian : "-"; ?></p></td>				
        <td>&nbsp;</td>
        <th ><p>Nama Perawat</p></th>
        <td ><p> : <?php echo isset($modPengkajian->nama_pegawai) ? $modPengkajian->nama_pegawai : "-"; ?></p></td>
    </tr>
    <tr>
        <th><p>Tanggal Pengkajian</p></th>
        <td ><p> : <?php echo isset($modPengkajian->pengkajianaskep_tgl) ? MyFormatter::FormatDateTimeForUser($modPengkajian->pengkajianaskep_tgl) : "-"; ?></p></td>
    </tr>
</table>

<div class="panel panel-dark">
    <span class="group-title">
        <b>Data Pasien</b>
    </span>
    <div class="panel-body">
        <table class="table noborder paddingtext2">
            <tr>
                <th><p>No. Pendaftaran</p></th>
                <td ><p> : <?php echo isset($modPengkajian->no_pendaftaran) ? $modPengkajian->no_pendaftaran : "-"; ?></p></td>
                <th><p>Jenis Kelamin</p></th>
                <td ><p> : <?php echo isset($modPengkajian->jeniskelamin) ? $modPengkajian->jeniskelamin : "-"; ?></p></td>
                <th ><p>Ruangan</p></th>
                <td ><p> : <?php echo isset($modPengkajian->ruangan_nama) ? $modPengkajian->ruangan_nama : "-" ?></p></td>
            </tr>
            <tr>
                <th ><p>Tanggal Pendaftaran</p></th>
                <td><p> : <?php echo isset($modPengkajian->tgl_pendaftaran) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgl_pendaftaran) : "-"; ?></p></td>
                <th ><p>Pekerjaan</p></th>
                <td ><p> : <?php echo isset($modPengkajian->pekerjaan_nama) ? $modPengkajian->pekerjaan_nama : "-"; ?></p></td>
                <th ><p>Kelas</p></th>
                <td ><p> : <?php echo isset($modPengkajian->kelaspelayanan_nama) ? $modPengkajian->kelaspelayanan_nama : $modPengkajian->getKelasPelayanan($modPengkajian->pendaftaran_id) ?></p></td>
            </tr>
            <tr>
                <th ><p>No. Rekam Medik</p></th>
                <td ><p> : <?php echo isset($modPengkajian->no_rekam_medik) ? $modPengkajian->no_rekam_medik : "-"; ?></p></td>
                <th ><p>Pendidikan</p></th>
                <td ><p> : <?php echo isset($modPengkajian->pendidikan_nama) ? $modPengkajian->pendidikan_nama : "-"; ?></p></td>
                <th ><p>No Kamar / No. Bed</p></th>
                <td ><p> : <?php echo (isset($modPengkajian->kamarruangan_nokamar) ? $modPengkajian->kamarruangan_nokamar : $modPengkajian->getNoKamar($modPengkajian->pendaftaran_id) ) . ' / ' . (isset($modPengkajian->kamarruangan_nobed) ? $modPengkajian->kamarruangan_nobed : $modPengkajian->getNoBed($modPengkajian->pendaftaran_id) ) ?></p></td>
            </tr>
            <tr>
                <th ><p>Nama Pasien</p></th>
                <td ><p> : <?php echo isset($modPengkajian->nama_pasien) ? $modPengkajian->nama_pasien : "-"; ?></p></td>
                <th ><p>Agama</p></th>
                <td ><p> : <?php echo isset($modPengkajian->agama) ? $modPengkajian->agama : "-"; ?></p></td>
                <th ><p>Diagnosa Medik Masuk</p></th>
                <td ><p> : <?php echo isset($modPengkajian->diagnosa_nama) ? $modPengkajian->diagnosa_nama : $modPengkajian->getDiagnosaMedis($modPengkajian->pasien_id, $modPengkajian->pendaftaran_id) ?></p></td>
            </tr>
            <tr>
                <th ><p>Umur</p></th>
                <td ><p> : <?php echo isset($modPengkajian->umur) ? $modPengkajian->umur : "-"; ?></p></td>
                <th ><p>Alamat</p></th>
                <td ><p> : <?php echo isset($modPengkajian->alamat_pasien) ? $modPengkajian->alamat_pasien : "-"; ?></p></td>
            </tr>
            <tr>
                <th ><p>Status Perkawinan</p></th>
                <td ><p> : <?php echo isset($modPengkajian->statusperkawinan) ? $modPengkajian->statusperkawinan : "-"; ?></p></td>
            </tr>
        </table>
    </div>
</div>	
<p>&nbsp;</p>        
<div class="panel panel-dark">
    <span class="group-title">
        <b>Data Penanggung Jawab</b>
    </span>
    <div class="panel-body">
        <table class="table noborder paddingtext2">
            <tr>
                <th ><p>Nama</p></th>
                <td ><p> : <?php echo isset($modPengkajian->nama_pj) ? $modPengkajian->nama_pj : "-"; ?></p></td>
                <th ><p>Tanggal Lahir</p></th>
                <td ><p> : <?php echo isset($modPengkajian->tgllahir_pj) ? MyFormatter::FormatDateTimeForUser($modPengkajian->tgllahir_pj) : "-"; ?></p></td>
                <th ><p>Hubungan Dengan Klien</p></th>
                <td ><p> : <?php echo isset($modPengkajian->hubungankeluarga) ? $modPengkajian->hubungankeluarga : "-" ?></p></td>
            </tr>
            <tr>
                <th ><p>No Identitas</p></th>
                <td ><p> : <?php echo isset($modPengkajian->no_identitas) ? $modPengkajian->no_identitas : "-"; ?></p></td>
                <th ><p>No. Telepon</p></th>
                <td ><p> : <?php echo isset($modPengkajian->no_teleponpj) ? $modPengkajian->no_teleponpj : "-"; ?></p></td>
                <th ><p>Alamat</p></th>
                <td ><p> : <?php echo isset($modPengkajian->alamat_pj) ? $modPengkajian->alamat_pj : "-" ?></p></td>
            </tr>
            <tr>
                <th ><p>Jenis Kelamin</p></th>
                <td ><p> : <?php echo isset($modPengkajian->jk) ? $modPengkajian->jk : "-"; ?></p></td>
                <th ><p>No. Handphone</p></th>
                <td ><p> : <?php echo isset($modPengkajian->no_mobilepj) ? $modPengkajian->no_mobilepj : "-"; ?></p></td>
            </tr>
        </table>
    </div>
</div>
<?php
$this->renderPartial('_tabMenu', array(
    'modPengkajian' => $modPengkajian,
    'modAwalMedis' => $modAwalMedis,
    'modAwalKeperawatan' => $modAwalKeperawatan,
    'modAwalKritis' => $modAwalKritis,
    'modAwalKebidanan' => $modAwalKebidanan));
?>
<?php $this->renderPartial('_jsFunctions2', array('modPengkajian' => $modPengkajian)); ?>
<div>
    <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
</div>