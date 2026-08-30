<?php
if (isset($pendaftaran->pasien_id)):
    $pendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
    $pasien = PasienM::model()->findByPk($pendaftaran->pasien_id);
else:
    echo "<h2>Silakan Pilih Pasien Terlebih dahulu</h2>";
    return false;
endif;

?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="100px;">Tgl. Pendaftaran</td><td>:</td><td><?php echo MyFormatter::formatDateTimeForUser($pendaftaran->tgl_pendaftaran); ?></td>
        <td width="100px;" nowrap>No. Rekam Medik</td><td>:</td><td><?php echo $pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td><td>:</td><td><?php echo $pendaftaran->no_pendaftaran; ?></td>
        <td>Nama Pasien</td><td>:</td><td><?php echo $pasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td nowrap>Tgl. Lahir / Umur</td><td>:</td><td><?php echo MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir) . ' / ' . $pendaftaran->umur; ?></td>
        <td>Bin / Binti</td><td>:</td><td><?php echo $pasien->nama_bin; ?></td>
    </tr>
    <tr>
        <td nowrap>Kasus Penyakit</td><td>:</td><td><?php echo (isset($pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama) ? $pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : ""); ?></td>
        <td>Jenis Kelamin</td><td>:</td><td><?php echo $pasien->jeniskelamin; ?></td>
    </tr>
    <tr>
        <td nowrap>Golongan Darah</td><td>:</td><td><?php echo $pasien->golongandarah; ?></td>
        <td>Alamat</td><td>:</td><td><?php echo $pasien->alamat_pasien; ?></td>
    </tr>
    <tr>
        <td style="text-align: center;" colspan="6">
        <?php
        $this->widget('Odontogram', array('gigis' => $gigi));
        ?> 
        </td>
    </tr>
</table>
<br>
<?php  //echo CHtml::htmlButton(Yii::t('mds', '{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')), array('class' => 'btn btn-danger','onclick'=>'print();')); ?>
