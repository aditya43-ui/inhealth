<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> 10 Pasien Terakhir yang Mendaftar
            <?php echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), 'javascript:void(0);', array('rel' => 'tooltop', 'title' => 'Klik untuk me-refresh tabel', 'class' => 'btn btn-default', 'onclick' => "refreshDaftarPasien();", 'disabled' => FALSE, 'style' => 'color:#000')); ?>
        </div>
    </div>
    <div class="panel-body" style="max-height: 200px; overflow: auto;">


        <?php
        //	LNG-1578 untuk notif pemberitahuan sbelum simpan, jika pasien yang sudah terdaftar.	
        //	NIK : 201410001 
        //        $modListPendaftaran = new PPInfoKunjunganRDV();
        //        $this->widget('ext.bootstrap.widgets.BootGridView',array(
        //                'id'=>'pendaftarterakhir-rj-grid',
        //                'dataProvider'=>$modListPendaftaran->searchPendaftaranTerakhir(),
        //                'template'=>"{pager}\n{items}",
        //                'itemsCssClass'=>'table table-striped table-condensed table-responsive',
        //                'enableSorting' => false,
        //                'columns'=>array(
        //                    array(
        //                        'header'=>'No.',
        //                        'value' => '$row+1',
        //                        'type'=>'raw',
        //                        'htmlOptions'=>array('style'=>'text-align:right;'),
        //                    ),
        //                    array(
        //                        'name'=>'tgl_pendaftaran',
        //                        'type'=>'raw',
        //                        'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
        //                    ),
        //                    'no_pendaftaran',
        //                    'no_rekam_medik',
        //                    'nama_pasien',
        //                    array(
        //                        'name'=>'tempat_lahir',
        //                        'type'=>'raw',
        //                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_lahir)',
        //                    ),
        //                    'umur',
        //                    'jeniskelamin',
        //                    'alamat_pasien',
        ////                    'no_mobile_pasien',
        //                    'ruangan_nama',
        //                    array(
        //                        'name'=>'nama_pegawai',
        //                        'type'=>'raw',
        //                        'value'=>'$data->gelardepan.$data->nama_pegawai.(isset($data->gelarbelakang_nama)?",".$data->gelarbelakang_nama : "")',
        //                    ),
        //                    'carabayar_nama',
        //                    'penjamin_nama',
        //                ),
        //            )); 
        ?>

        <table class="items table table-bordered table-striped table-condensed" id="table-pasienterakhir">
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
                            <?php echo CHtml::activeHiddenField($pasien, '[' . $i . ']pasien_id', array('class' => 'span2 pasien_id', 'style' => 'width:90px;', 'readonly' => true)); ?>
                        </td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($pasien->tgl_pendaftaran); ?></td>
                        <td><?php echo $pasien->no_pendaftaran; ?></td>
                        <td><?php echo $pasien->no_rekam_medik; ?></td>
                        <td><?php echo $pasien->namadepan . $pasien->nama_pasien; ?></td>
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