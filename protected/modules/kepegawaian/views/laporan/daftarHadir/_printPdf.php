<?php
    echo $this->renderPartial(
        'application.views.headerReport.headerLaporanTransaksi',
            array(
                'judulLaporan'=>false,
            )
    );
?>
<fieldset>
    <div style="text-align: center;"><b>DETAIL PRESENSI PEGAWAI</b></div>
    <table style="width: 100%; border: none;">
        <tr>
            <td width="50%" style="vertical-align:top;">
                <table>
                    <tr>
                        <td>No. Finger</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nofingerprint; ?></td>
                    </tr>
                    <tr>
                        <td>Kelompok Pegawai</td>
                        <td>:</td>
                        <td><?php echo isset($modPegawai->kelompokpegawai_id)?$modPegawai->kelompokpegawai->kelompokpegawai_nama:''; ?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?php echo  isset($modPegawai->jabatan_id)?$modPegawai->jabatan->jabatan_nama:""; ?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nomorindukpegawai; ?></td>
                    </tr>                    
                    <tr>
                        <td>Nama Pegawai</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->nama_pegawai; ?></td>
                    </tr> 
                    <?php /*
                    <tr>
                        <td>Shift</td>
                        <td>:</td>
                        <td><?php echo ($modPegawai->shift_id)?$modPegawai->shift->shift_nama:'-'; ?></td>
                    </tr>*/ ?>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td style = "text-align:right;">Hadir</td>
                        <td>:</td>
                        <td><?php  echo $modPegawai->hadir; ?></td>
                    </tr>
                    <tr>
                        <td style = "text-align:right;">Izin</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->izin; ?></td>
                    </tr>
                    <tr>
                        <td style = "text-align:right;">Sakit</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->sakit; ?></td>
                    </tr>
                    <tr>
                        <td style = "text-align:right;">Dinas</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->dinas; ?></td>
                    </tr>
                    <tr>
                        <td style = "text-align:right;">Alpha</td>
                        <td>:</td>
                        <td><?php echo $modPegawai->alpha; ?></td>
                    </tr>
                   <!--<tr>
                        <td style = "text-align:right;">Rerata Jam Masuk</td>
                        <td>:</td>
                        <td><?php //echo $modPegawai->rerata_jam_masuk; ?></td>
                    </tr>
                    <tr>
                        <td style = "text-align:right;">Rerata Jam Pulang</td>
                        <td>:</td>
                        <td><?php //echo $modPegawai->rerata_jam_keluar; ?></td>
                    </tr>-->
                    <?php /*<tr>
                        <td >Jumlah Absensi</td>
                        <td>:</td>
                        <td>
                        <?php
                            $count = count((array)$model->printDetailPresensi()->getData());
                            echo $count;
                        ?>
                        </td>
                    </tr>*/ ?>
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
                    'htmlOptions'=>array('style'=>'text-align: center; width:20px'),
                ),
//                array(
//                    'header'=>'<p style="margin: 0; text-align: center;">Masuk</p>',
//                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->tglpresensi),true)',
//                ),
                array(
                   'header'=>'Tanggal Presensi',
                   'type'=>'raw',
                   'value'=>'MyFormatter::formatDateTimeForUser($data->datepresensi)',
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Masuk</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Keluar</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>3, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Datang</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>4, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                array(
                    'header'=>'<p style="margin: 0; text-align: center;">Pulang</p>',
                    'value'=>'$this->grid->owner->renderPartial("daftarHadir/_statusscan",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),                                
                 array(
                    'header'=>'<p style="margin: 0; text-align: center;">Terlambat</p>',                     
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_terlambat",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                   //  'value'=>'""',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),                                             
                   //  'footer' => $this->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$model->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi.' 00:00:00','tgl_akhir'=>$model->tglpresensi_akhir.' 23:59:59'),true),
                     'footerHtmlOptions' => array('style'=>'text-align: center;'),
                         
                ), 
                 array(
                    'header'=>'<p style="margin: 0; text-align: center;">Pulang Awal</p>',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_pulangAwal",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    // 'value'=>'""',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                     //'footer' => $this->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$model->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi.' 00:00:00','tgl_akhir'=>$model->tglpresensi_akhir.' 23:59:59'),true),                     
                     'footerHtmlOptions' => array('style'=>'text-align: center;'),
                ), 
                 array(
                    'header' => 'Status',
                    'value'=>'$this->grid->owner->renderPartial("presensiT/_statuskehadiran",array("statuskehadiran_id"=>1,"pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2, "datepresensi"=>$data->datepresensi),true)',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                     'type' => 'raw'
                ), 
            ),
        )
  );
?>
