<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<style>
    .border th, .border td{
        border:1px solid #000 !important;
        color: black;
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
        
        border: 1px solid black;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    
    .tab-header th, .tab-header td {
        padding: 2px;
        color: black;
    }
</style>
<table width="100%" class='tab-header'>
    <tr>
        <td nowrap><b>Nama Pasien / No. RM</b></td>
        <td>:</td><td width="100%"> <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td nowrap><b>No. Pendaftaran</b></td>
        <td>:</td><td> <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td><b>Umur</b></td>
        <td>:</td><td> <?php echo $modPendaftaran->umur; ?></td>
        <td><b>Alamat</b></td>
        <td>:</td><td nowrap> <?php echo $modPasien->alamat_pasien;?> <?php echo $modPasien->rt;?> <?php echo $modPasien->rw; ?></td>
    </tr>
</table>
<hr>
<br>
<?php
    if (count((array)$modGinekologi)>0){
        echo "<h5>Pemeriksaan Ginekologi</h5>";
    }
?>
<?php 

if (count((array)$modGinekologi)>0){
foreach ($modGinekologi as $i => $ginekologi){    
?>        
<table width="100%" class="table border">
    <tr>
        <td><b>Tanggal Pemeriksa</b></td>
        <td><?php echo MyFormatter::formatDateTimeForUser($ginekologi->tglperiksaobgyn); ?></td>        
        <td>&nbsp;</td>
        <td><b>Pemeriksa</b></td>
        <td><?php echo $ginekologi->pegawai->namaLengkap; ?></td>        
    </tr>            
    <tr>
        <td><b>Keluhan</b></td>
        <td><?php echo $ginekologi->gin_keluhan; ?></td>        
        <td>&nbsp;</td>
        <td><b>Menarche</b></td>
        <td><?php echo $ginekologi->gin_menarche_thn; ?> Tahun</td>        
    </tr> 
    <tr>
        <td><b>Jumlah Kawin</b></td>
        <td><?php echo $ginekologi->gin_jmlkawin_kali; ?> Kali</td>        
        <td>&nbsp;</td>
        <td><b>Siklus Haid</b></td>
        <td><?php echo $ginekologi->gin_menarche_thn; ?> Hari</td>        
    </tr> 
    <tr>
        <td><b>Status Perkawinan</b></td>
        <td><?php  echo $ginekologi->gin_statuskawin; ?>
        </td>        
        <td>&nbsp;</td>
        <td><b>Lama Haid</b></td>
        <td><?php echo $ginekologi->gin_lamahaid_hari; ?> Hari</td>        
    </tr> 
    <tr>
        <td><b>Usia Perkawinan</b></td>
        <td><?php  echo $ginekologi->gin_usiakawin_thn; ?>
        </td>        
        <td>&nbsp;</td>
        <td><b>Darah Haid</b></td>
        <td>
            <?php   echo $ginekologi->gin_darahhaid; 
                    echo '<br>';
                    if ($ginekologi->gin_darahhaid_tambahkurang == TRUE){
                        echo 'Berkurang';
                    }elseif ($ginekologi->gin_darahhaid_tambahkurang == FALSE){
                        echo 'Bertambah';
                    }
            
            ?>             
        </td>        
    </tr>  
    <tr>
        <td colspan="2" rowspan="3"><b>Riwayat Kelahiran</b>
            <?php
                if (count((array)$modRiwayatKelahiran)>0){
            ?>
            <table class="table border">                
                <tr>
                    <td><b>Anak Ke -</b></td>
                    <td><b>keterangan</b></td>
                </tr>               
                <?php 
                    foreach ($modRiwayatKelahiran as $riwayat){
                ?>
                        <tr>
                            <td><?php echo $riwayat->anak_ke ?></td>
                            <td><?php echo $riwayat->keterangan ?></td>
                        </tr>
                <?php
                    }
                }else{
                    echo "<tr><td>Tidak ada data riwayat kelahiran.</td></tr>";
                }
                
                ?>                
            </table>
        </td>
                
        <td>&nbsp;</td>
        <td><b>Nafsu Makan</b></td>
        <td><?php   echo $ginekologi-> gin_nafsumakan ; 
                    echo '<br>';
                    if ($ginekologi->gin_nafsumakan_kurusgemuk == TRUE){
                        echo 'Menjadi Gemuk';
                    }elseif ($ginekologi->gin_nafsumakan_kurusgemuk == FALSE){
                        echo 'Menjadi Kurus';
                    }
            
            ?>    
        </td>        
    </tr> 
    <tr>
        <td colspan="1">
            &nbsp;
        </td>     
        
        <td><b>Mictio</b></td>
        <td><?php echo $ginekologi->gin_mictio;   ?>    
        </td>        
    </tr> 
    <tr>
        <td colspan="1">
            &nbsp;
        </td>                        
      
        <td><b>Defecatio</b></td>
        <td><?php echo $ginekologi->gin_defecatio;   ?>    
        </td>        
    </tr>
    <tr>
        <td colspan='4'>
            Dibuat Oleh : <?php 
        $login = LoginpemakaiK::model()->findByPk($ginekologi->create_loginpemakai_id);
        if (!empty($login->pegawai)) {
            echo $login->pegawai->namaLengkap;
        } else {
            echo $login->nama_pemakai;
        }
        
        
        ?>
        </td>
    </tr>
</table> 
<?php }
}else{
?>
<table width="100%" class="table border">
    <tr>
        <td colspan="9">* Tidak ada riwayat pemeriksaan ginekologi</td>
    </tr> 
</table> 
<?php } ?>
