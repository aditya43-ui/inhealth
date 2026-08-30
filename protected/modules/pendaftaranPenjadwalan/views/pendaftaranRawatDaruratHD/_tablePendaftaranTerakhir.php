<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> 10 Pasien Terakhir yang Mendaftar
            <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), 'javascript:void(0);', array('rel' => 'tooltop', 'title' => 'Klik untuk me-refresh tabel', 'class' => 'btn btn-default', 'onclick' => "refreshDaftarPasien();", 'disabled' => FALSE, 'style' => '')); ?>
        </div>
    </div>
    <div class="panel-body" style="max-height: 200px; overflow: auto;">

        <?php
        ?>

        <table class="items table table-striped table-condensed" id="table-pasienterakhir">
            <thead>
                <tr>
                    <th width="2%">No.</th>
                    <th>Tanggal Pendaftaran</th>
                    <th>No. Pendaftaran</th>
                    <th>No. Rekam Medik</th>
                    <th>Pasien</th>
                    <th>Tempat Tanggal Lahir</th>
                    <th>Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat Pasien</th>
                    <th>Ruangan</th>
                    <th>Dokter</th>
                    <th>Jenis Penjamin</th>
                    <th>Penjamin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modPasienTerakhir as $i => $pasien) { ?>
                    <tr>
                        <td width="2%">
                            <?php echo $i + 1;
                            echo "." ?>
                            <?php echo CHtml::activeHiddenField($pasien, '[' . $i . ']pasien_id', array('class' => 'span3 pasien_id', 'style' => 'width:90px;', 'readonly' => true)); ?>
                        </td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($pasien->tgl_pendaftaran); ?></td>
                        <td><?php echo $pasien->no_pendaftaran; ?></td>
                        <td><?php echo $pasien->no_rekam_medik; ?></td>
                        <td><?php echo $pasien->nama_pasien; ?></td>
                        <td><?php echo $pasien->tempat_lahir . ", " . MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
                        <td><?php echo $pasien->umur; ?></td>
                        <td><?php echo $pasien->jeniskelamin; ?></td>
                        <td><?php echo $pasien->alamat_pasien; ?></td>
                        <td><?php echo $pasien->ruangan_nama; ?></td>
                        <td><?php echo $pasien->gelardepan . $pasien->nama_pegawai . (isset($pasien->gelarbelakang_nama) ? "," . $pasien->gelarbelakang_nama : ""); ?></td>
                        <td><?php echo $pasien->carabayar_nama; ?></td>
                        <td><?php echo $pasien->penjamin_nama; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>