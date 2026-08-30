
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
        <td colspan="">No. Rekam Medik &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $modPasien->no_rekam_medik; ?></td>
        <td colspan=""></td>
        <td colspan="3">&nbsp;</td>
        <td colspan="">Tanggal Pengisian</td>
        <td colspan=""><?php echo MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td align="center" valig="middle" colspan="9">DATA UMUM PASIEN</td>
    </tr>
    <tr>
        <td valig="middle" colspan="9" style="font-weight:bold">Data Awal Pasien</td>
    </tr>
    <tr>
        <td colspan="5">Nama lengkap pasien sesuai KTP/Identitas lain</td>
        <td colspan="4"><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
    </tr>
    <tr>
        <td colspan="5">Nama panggilan</td>
        <td colspan="4"><?php echo isset($modPasien->nama_bin)?$modPasien->nama_bin:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="5">Alamat lengkap</td>
        <td colspan="4"><?php echo isset($modPasien->alamat_pasien)?$modPasien->alamat_pasien:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td>Kecamatan</td>
        <td><?php echo isset($modPasien->kecamatan->kecamatan_nama)?$modPasien->kecamatan->kecamatan_nama:"-"; ?></td>
        <td>Kelurahan</td>
        <td><?php echo isset($modPasien->kelurahan->kelurahan_nama)?$modPasien->kelurahan->kelurahan_nama:"-"; ?></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td>Kota</td>
        <td><?php echo $modPasien->kabupaten->kabupaten_nama; ?></td>
        <td>Kode pos</td>
        <td><?php echo isset($modPasien->kelurahan->kode_pos)?$modPasien->kelurahan->kode_pos:"-"; ?></td>
    </tr>
<!--<tr>
        <td colspan="5"></td>
        <td>Perumahan</td>
        <td><?php echo isset($modPasien->nama_bin)?$modPasien->nama_bin:' - '; ?></td>
        <td></td>
        <td></td>
    </tr>-->
    <tr>
        <td colspan="5">Nomor Telepon</td>
        <td>Rumah</td>
        <td><?php echo isset($modPasien->no_telepon_pasien)?$modPasien->no_telepon_pasien:' - '; ?></td>
        <td>No. Handphone</td>
        <td><?php echo isset($modPasien->no_mobile_pasien)?$modPasien->no_mobile_pasien:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Tempat Tanggal Lahir</td>
        <td colspan="4"><?php echo (isset($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>
    <tr>
        <td colspan="5">Jenis Kelamin</td>
        <td colspan="4"><?php echo isset($modPasien->jeniskelamin)?$modPasien->jeniskelamin:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Status Perkawinan</td>
        <td colspan="4"><?php echo isset($modPasien->statusperkawinan)?$modPasien->statusperkawinan:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Kewarganegaraan</td>
        <td colspan="4"><?php echo isset($modPasien->warga_negara)?$modPasien->warga_negara:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Agama</td>
        <td colspan="4"><?php echo isset($modPasien->agama)?$modPasien->agama:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Pekerjaan</td>
        <td colspan="4"><?php echo isset($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Pendidikan</td>
        <td colspan="4"><?php echo isset($modPasien->pendidikan_id)?$modPasien->pendidikan->pendidikan_nama:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Email</td>
        <td colspan="4"><?php echo isset($modPasien->alamatemail)?$modPasien->alamatemail:' - '; ?></td>
    </tr>
     <tr>
        <td valig="middle" colspan="9" style="font-weight:bold">Dalam keadaan darurat dapat menghubungi</td>
    </tr>
    <tr>
        <td colspan="5">Nama</td>
        <td colspan="4"><?php echo isset($modPenanggungjawab->nama_pj)?$modPenanggungjawab->nama_pj:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="5">Hubungan dengan pasien</td>
        <td colspan="4"><?php echo isset($modPenanggungjawab->hubungankeluarga)?$modPenanggungjawab->hubungankeluarga:" - "; ?></td>
    </tr>
    <tr>
        <td colspan="5">Alamat lengkap</td>
        <td colspan="4"><?php echo isset($modPenanggungjawab->alamat_pj)?$modPenanggungjawab->alamat_pj:' - '; ?></td>
    </tr>
    <tr>
        <td colspan="5">Nomor Telepon</td>
        <td>Rumah</td>
        <td><?php echo isset($modPenanggungjawab->no_teleponpj)?$modPenanggungjawab->no_teleponpj:' - '; ?></td>
        <td>No. Handphone</td>
        <td><?php echo isset($modPenanggungjawab->no_mobilepj)?$modPenanggungjawab->no_mobilepj:' - '; ?></td>
    </tr>
<!--<tr>
        <td colspan="5">Tempat Tanggal Lahir</td>
        <td colspan="4"><?php echo (isset($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>
    <tr>
        <td colspan="5">Tempat Tanggal Lahir</td>
        <td colspan="4"><?php echo (isset($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>
    <tr>
        <td colspan="5">Tempat Tanggal Lahir</td>
        <td colspan="4"><?php echo (isset($modPasien->tempat_lahir)?$modPasien->tempat_lahir:' - ').", ".(isset($modPasien->tanggal_lahir)?MyFormatter::formatDateTimeId($modPasien->tanggal_lahir):' - '); ?></td>
    </tr>-->
</table>

<!--<div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
    <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPendaftaran->pendaftaran_id; ?>&is_text=">  
    <div class="barcode-label"><?php echo $modPendaftaran->pendaftaran_id; ?></div>
</div>-->
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
