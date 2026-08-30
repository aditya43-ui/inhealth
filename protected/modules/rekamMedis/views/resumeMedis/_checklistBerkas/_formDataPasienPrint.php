<style>
.outer tr,
.outer td {
    border: 1px solid black;
}

.inner tr,
.inner td {
    border: 1px solid white;
    line-height: 30px;

}

.judul-hd {
    margin: 5px;
}

table tr,
table td {
    vertical-align: top;
}
</style>



<table style="width: 100%; margin: 5px; margin-top: 0px; border: 1px solid black;" class="outer">
    <tr>
        <td style="font-size: 14pt;">
            <p class="judul-hd">Data Pasien</p>
        </td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%; margin: 8px;" class="inner">
                <tr>
                    <td style="width: 20%;">No. Rekam Medik</td>
                    <td style="width: 25%;">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'no_rekam_medik', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td style="width: 5%;"></td>
                    <td style="width: 20%;">Umur</td>
                    <td style="width: 25%;">
                        <?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td style="width: 5%;"></td>
                </tr>
                <tr>
                    <td>No. Pendaftaran</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                    <td>Jenis Kasus Penyakit</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'jeniskasuspenyakit_nama', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'nama_pasien', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                    <td>Ruangan</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'ruangan_nama', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Nama Panggilan</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'nama_bin', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                    <td>Kelas Pelayanan</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'kelaspelayanan_nama', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'jeniskelamin', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                    <td>Jenis Penjamin / Penjamin</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'carabayar_nama', array('disabled'=>true, 'style'=>"background-color: #ededed; width: 42%;")); ?>
                        &nbsp;/&nbsp;
                        <?php echo CHtml::activeTextField($modPendaftaran, 'penjamin_nama', array('disabled'=>true, 'style'=>"background-color: #ededed; width: 42%;")); ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Tanggal Pendaftaran</td>
                    <td>
                        <?php $modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                    <td>Dokter</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'nama_pegawai', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>Alamat Pasien</td>
                    <td>
                        <?php echo CHtml::activeTextArea($modPendaftaran, 'alamat_pasien', array('disabled'=>true, 'style'=>"background-color: #ededed;")); ?>
                    </td>
                    <td></td>
                    <td>Cara Masuk / Rujuk</td>
                    <td>
                        <?php echo CHtml::activeTextField($modPendaftaran, 'caramasuk_nama', array('disabled'=>true, 'style'=>"background-color: #ededed; width: 42%;")); ?>
                        &nbsp;/&nbsp;
                        <?php echo CHtml::activeTextField($modPendaftaran, 'nama_perujuk', array('disabled'=>true, 'style'=>"background-color: #ededed; width: 42%;")); ?>
                    </td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>