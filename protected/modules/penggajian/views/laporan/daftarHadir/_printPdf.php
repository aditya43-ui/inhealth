<?php
    echo $this->renderPartial(
        'application.views.headerReport.headerLaporanTransaksi',
            array(
                'judulLaporan'=>false,
            )
    );
?>
<fieldset>
    <div style="text-align: center;"><b>Detail Presensi Pasien</b></div>
    <table style="width: 100%; border: none;">
        <tr>
            <td width="50%">
                <table>
                    <tr>
                        <td>Nama Pegawai</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nama_pegawai; ?></td>
                    </tr>
                    <tr>
                        <td>No. Finger</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nofingerprint; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->alamat_pegawai; ?></td>
                    </tr>
                    <tr>
                        <td>Unit</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->unit_perusahaan; ?></td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nomorindukpegawai; ?></td>
                    </tr>
                    <tr>
                        <td>Kelompok</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->kelompokpegawai->kelompokpegawai_nama; ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->jabatan->jabatan_nama; ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Absensi</td>
                        <td>:</td>
                        <td>
                        <?php
                            $count = count((array)$model->printDetailPresensi()->getData());
                            echo $count;
                        ?>
                        </td>
                    </tr>
                </table>            
            </td>
        </tr>
    </table>
</fieldset>
<br>
<?php
      $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'lapegawai-d-grid',
            'dataProvider'=>$model->printDetailPresensi(),
            'template'=>"{pager}\n{items}",
            'columns'=>array(
                array(
                    'header' => 'No.',
                    'value' => '$row+1',
                    'htmlOptions'=>array('style'=>'text-align: center; width:50px'),
                ),
                array(
                   'header'=>'Tanggal',
                   'type'=>'raw',
                   'value'=>'date("d/m/Y", strtotime($data->datepresensi))',
                   'htmlOptions'=>array('style'=>'width:120px'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Masuk</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
                
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Pulang</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Keluar</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>3, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Datang</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>4, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions'=>array('style'=>'text-align: center; width:120px'),
                ),
            ),
        )
  );
?>
