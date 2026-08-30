
<style>
   
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
               
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judul_print));
                ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                       
  <table style="width: 100%; border: none;">
    <tr>
        <td align="center" valig="middle" colspan="3">
            <b><?php echo $judul_print ?></b>
        </td>
    </tr>
     <tr>
        <td align="center" valig="middle" colspan="3">
			&nbsp;
        </td>
    </tr>

    <tr>
        <td>No. Antrian</td>
        <td>:</td>
        <td><b><?php echo $model->ruangan->ruangan_singkatan; ?>-<?php echo $model->no_antrianjanji; ?></b></td>
    </tr>
    <tr>
        <td>No. Janji Poliklinik</td>
        <td>:</td>
        <td><b><?php echo $model->no_buatjanji; ?></b></td>
    </tr>
    <tr>
        <td>Tanggal Janji Poliklinik</td>
        <td>:</td>
        <td><b><?php echo MyFormatter::formatDateTimeForUser($model->tgljadwal); ?></b></td>
    </tr>
    <tr>
        <td>No. Rekam Medis</td>
        <td>:</td>
        <td><b><?php echo $modPasien->no_rekam_medik; ?></b></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>Poliklinik Tujuan</td>
        <td>:</td>
        <td><?php echo $model->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Dokter Pemeriksa</td>
        <td>:</td>
        <td><?php echo !empty($model->pegawai->gelardepan)?$model->pegawai->gelardepan.' ':''; echo $model->pegawai->nama_pegawai; ?></td>
    </tr>
    <tr>
        <td colspan="3"><i>&nbsp;</i></td>
    </tr>
    <tr>
        <td colspan="3"><i>(Sebelum ke ruangan pemeriksaan mohon ke pendaftaran terlebih dahulu)</i></td>
    </tr>
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
<div class="">
</div>
<div class="footer">
   
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
   
</div>   
