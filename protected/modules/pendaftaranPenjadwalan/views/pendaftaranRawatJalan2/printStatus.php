
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
        <td nowrap>No. Rekam Medik</td>
        <td width="100%">: <?php echo $modPasien->no_rekam_medik; ?></td>
        <td nowrap>Tanggal Pengisian</td>
        <td width="50%" nowrap>: <?php echo MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
</table>
<table style="width: 100%; border: none;">
    
    <tr>
        <td align="center" valig="middle" colspan="4" style="text-decoration: underline; font-weight: bold;"><br>DATA UMUM PASIEN</td>
    </tr>
    <tr>
        <td valig="middle" colspan="4" style="font-weight:bold">Data Awal Pasien</td>
    </tr>
    <tr>
        <td>Nama lengkap pasien <!--sesuai KTP/Identitas lain--></td>
        <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td>Nama panggilan</td>
        <td><?php echo isset($modPasien->nama_bin)?$modPasien->nama_bin:"-"; ?></td>
    </tr>
    <tr>
        <td>Alamat lengkap</td>
        <td><?php echo isset($modPasien->alamat_pasien)?$modPasien->alamat_pasien:"-"; ?></td>
    </tr>
    <tr>
        <td>Kota/Kabupaten</td>
        <td><?php echo $modPasien->kabupaten->kabupaten_nama; ?></td>
    </tr>
    <tr>
        <td>Kecamatan</td>
        <td><?php echo isset($modPasien->kecamatan->kecamatan_nama)?$modPasien->kecamatan->kecamatan_nama:"-"; ?></td>
    </tr>
    <tr>
        <td>Kelurahan</td>
        <td><?php echo isset($modPasien->kelurahan->kelurahan_nama)?$modPasien->kelurahan->kelurahan_nama:"-"; ?></td>
    </tr>
    <tr>
        <td>Kode Pos</td>
        <td><?php echo !empty($modPasien->kelurahan->kode_pos)?$modPasien->kelurahan->kode_pos:"-"; ?></td>
    </tr>
<!--<tr>
        <td colspan="5"></td>
        <td>Perumahan</td>
        <td><?php echo isset($modPasien->nama_bin)?$modPasien->nama_bin:' - '; ?></td>
        <td></td>
        <td></td>
    </tr>-->
    <tr>
        <td>Nomor Telepon</td>
        <td><?php echo !empty($modPasien->no_telepon_pasien)?$modPasien->no_telepon_pasien:' - '; ?></td>
    </tr>
    <tr>
        <td>Nomor Mobile</td>
        <td><?php echo !empty($modPasien->no_mobile_pasien)?$modPasien->no_mobile_pasien:' - '; ?></td>
    </tr>
    <tr>
        <td>Tempat Tanggal Lahir</td>
        <td><?php echo (!empty($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td><?php echo !empty($modPasien->jeniskelamin)?$modPasien->jeniskelamin:' - '; ?></td>
    </tr>
    <tr>
        <td>Status Perkawinan</td>
        <td><?php echo !empty($modPasien->statusperkawinan)?$modPasien->statusperkawinan:' - '; ?></td>
    </tr>
    <tr>
        <td>Kewarganegaraan</td>
        <td><?php echo !empty($modPasien->warga_negara)?$modPasien->warga_negara:' - '; ?></td>
    </tr>
    <tr>
        <td>Agama</td>
        <td><?php echo !empty($modPasien->agama)?$modPasien->agama:' - '; ?></td>
    </tr>
    <tr>
        <td>Pekerjaan</td>
        <td><?php echo !empty($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:' - '; ?></td>
    </tr>
    <tr>
        <td>Pendidikan</td>
        <td><?php echo !empty($modPasien->pendidikan_id)?$modPasien->pendidikan->pendidikan_nama:' - '; ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo !empty($modPasien->alamatemail)?$modPasien->alamatemail:' - '; ?></td>
    </tr>
     <tr>
         <td valig="middle" colspan="4" style="font-weight:bold"><br>Dalam keadaan darurat dapat menghubungi</td>
    </tr>
    <tr>
        <td>Nama</td>
        <td><?php echo !empty($modPenanggungjawab->nama_pj)?$modPenanggungjawab->nama_pj:" - "; ?></td>
    </tr>
    <tr>
        <td>Hubungan dengan pasien</td>
        <td><?php echo !empty($modPenanggungjawab->hubungankeluarga)?$modPenanggungjawab->hubungankeluarga:" - "; ?></td>
    </tr>
    <tr>
        <td>Alamat lengkap</td>
        <td><?php echo !empty($modPenanggungjawab->alamat_pj)?$modPenanggungjawab->alamat_pj:' - '; ?></td>
    </tr>
    <tr>
        <td>Nomor Telepon</td>
        <td><?php echo !empty($modPenanggungjawab->no_teleponpj)?$modPenanggungjawab->no_teleponpj:' - '; ?></td>
    </tr>
    <tr>
        <td>No. Handphone</td>
        <td><?php echo !empty($modPenanggungjawab->no_mobilepj)?$modPenanggungjawab->no_mobilepj:' - '; ?></td>
    </tr>
<!--<tr>
        <td colspan="5">Tempat Tanggal Lahir</td>
        <td colspan="4"><?php echo (!empty($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>
    <tr>
        <td colspan="5">Tempat Tanggal Lahir</td>
        <td colspan="4"><?php echo (!empty($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>
    <tr>
        <td colspan="5">Tempat Tanggal Lahir</td>
        <td colspan="4"><?php echo (!empty($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>-->
    
</table>

<div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
    <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
    <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
</div>

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
