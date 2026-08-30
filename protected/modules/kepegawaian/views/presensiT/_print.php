<?php $data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<style>
  body,h4 {
        color: black;
    }

    .border th, .border td{
        border:1px solid #000;
        padding:2px;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .table tbody tr td, .table tbody tr th {
        background-color: none;
    }
    .table {
        box-shadow: none;
    }
    .tblpadding td{
        padding: 5px;

    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                <div class="judulcontent">  
                    <b>RINCIAN PRESENSI PEGAWAI</b>
                </div>
                <br/>
                <table class='' width="100%">
                    <tr>
                        <td width="40%" valign="top">
                            <table class='tblpadding' style = "border: 0;">
                                <tr>
                                    <td width="120px"> No Fingerprint </td>
                                   <td>
                                       : <?php echo $modPegawai->nofingerprint; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> Nama Pegawai</td>
                                    <td>
                                       : <?php echo $modPegawai->NamaLengkap; ?>
                                   </td>
                                </tr>
                                <tr>
                                    <td> NIP </td>
                                   <td>
                                       : <?php echo $modPegawai->nomorindukpegawai; ?>
                                   </td>
                                </tr>
                            </table>
                        </td> 
                        <td width="60%" valign="top">
                            <table class='tblpadding' style = "border: 0;">
                              
                                    <tr>
                                        <td width="120px"> Jabatan </td>
                                       <td>
                                           : <?php echo (!empty($modPegawai->jabatan) ? $modPegawai->jabatan->jabatan_nama : ""); ?>
                                       </td>
                                    </tr>
                                <tr>
                                  <td> Unit Kerja </td>
                                   <td>
                                   : <?php echo (!empty($modPegawai->unitkerja) ? $modPegawai->unitkerja->namaunitkerja : ""); ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td> Shift </td>
                                   <td>
                                   : <?php echo (!empty($model->shift) ? $model->shift->shiftJam : ""); ?>
                                   </td>
                                </tr>
                            </table>
                        </td>  
                    </tr>
                </table>
                <br>
                    <center>
                        <h4>DETAIL DATA PRESENSI </h4>
                        <br/>
                        <div style="border: 1px solid black; width: 80%;"></div>
                    </center>
                    <br>
                <table width="100%" style='margin-left:auto; margin-right:auto;' class ="border">
                    <thead>
                        <tr class="border">
                            <th>Tanggal Presensi</th>
                            <th>Status Kehadiran</th>
                            <th>Jam Kerja Datang</th>
                            <th>Jam Kerja Keluar</th>
                            <th>Jam Kerja Masuk</th>
                            <th>Jam Kerja Pulang</th>
                            <th>Waktu Keterlambatan</th>
                            <th>Pulang Awal</th>
                            <th>Keterangan</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border">
                            <td><?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d',strtotime((string)MyFormatter::formatDateTimeForDb($model->tglpresensi)))); ?></td>
                            <td><?php echo $model->statuskehadiranpresensi->statuskehadiran_nama; ?></td>
                            <td><?php echo ((!empty($model->statusscan_id) && $model->statusscan_id == Params::STATUSSCAN_DATANG) ? date('H:i:s',strtotime((string)MyFormatter::formatDateTimeForDb($model->tglpresensi))): ""); ?></td>
                            <td><?php echo ((!empty($model->statusscan_id) && $model->statusscan_id == Params::STATUSSCAN_KELUAR) ? date('H:i:s',strtotime((string)MyFormatter::formatDateTimeForDb($model->tglpresensi))): ""); ?></td>
                            <td><?php echo ((!empty($model->statusscan_id) && $model->statusscan_id == Params::STATUSSCAN_MASUK) ? date('H:i:s',strtotime((string)MyFormatter::formatDateTimeForDb($model->tglpresensi))): ""); ?></td>
                            <td><?php echo ((!empty($model->statusscan_id) && $model->statusscan_id == Params::STATUSSCAN_PULANG) ? date('H:i:s',strtotime((string)MyFormatter::formatDateTimeForDb($model->tglpresensi))): ""); ?></td>
                            <td>
                                <?php 
                                    $model->terlambat_mnt = (empty($model->terlambat_mnt) ? 0 : $model->terlambat_mnt);
                                    echo floor($model->terlambat_mnt / 3600).' Jam '.(($model->terlambat_mnt / 60) % 60).' Menit '.($model->terlambat_mnt % 60).' Detik'; ?>
                            </td>
                            <td>
                                <?php 
                                    $model->pulangawal_mnt = (empty($model->pulangawal_mnt) ? 0 : $model->pulangawal_mnt);
                                    echo floor($model->pulangawal_mnt / 3600).' Jam '.(($model->pulangawal_mnt / 60) % 60).' Menit '.($model->pulangawal_mnt % 60).' Detik'; ?>
                            </td>
                            <td>
                                <?php echo $model->keterangan; ?>
                            </td>
                        </tr>
                    </tbody>
                    </table>
		        </div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>