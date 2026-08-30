<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    body{
        width: 11cm;
        height: 16.5cm;
        /* border:1px solid; */
        padding:2px;
    }
    th, td, div{
        font-family:Times New Roman;
        font-size: 9.7pt;
        line-height: 16px;
        /* padding:2px; */
        vertical-align:top;
    }
    .judulcontent{
        /* margin:10px 0px; */
    }
</style>
<?php
$format = new MyFormatter;
 //echo $this->renderPartial('application.views.headerReport.headerRincianV2');
?>
 
<table style="width: 100%; border: none;">
    <!-- <thead>
        <tr>
             <td>
                <div class="header"><?php
                    // echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div>  
            </td>
        </tr>
    </thead> -->
    <tbody>
        <?php 
            if(count((array)$modPasienMasukPenunjangs) > 0){
                foreach($modPasienMasukPenunjangs AS $i => $penunjang){
                ?>
        <tr>
            <td style="padding-top:4px;">
                <div class="content">
			<div class="judulcontent" style="font-size:8pt !important;"><?php echo $judul_print ?></div>
                        <table class="status">
       
         <!-- <tr>
            <td align="center" valig="middle" colspan="3">
                Data Pasien
            </td>
        </tr> -->
        <tr>
            <td width="40%">Nomor Lab</td>
            <td>:</td>
            <!-- <td><?php //echo $penunjang->no_masukpenunjang; ?></td> -->
            <td><?php echo !empty($penunjang->noorderlis)?$penunjang->noorderlis:""; ?></td>
            <!-- <td><?php //echo $penunjang->pasienmasukpenunjang_id; ?></td> -->
        </tr>
        <tr>
            <td>No. RM</td>
            <td>:</td>
            <td><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Tanggal Permintaan</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeId(date('Y/m/d'),strtotime($penunjang->tglmasukpenunjang)); ?></td>
        </tr>
        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td><?php echo !empty($modPasien->no_identitas_pasien)?$modPasien->no_identitas_pasien:""; ?></td>
        </tr>
        <tr>
            <td>Poli</td>
            <td>:</td>
            <td><?php echo $penunjang->ruangan->ruangan_nama; ?></td>
        </tr>
        <tr>
            <td>Dokter Pengririm</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->pegawai->NamaLengkap) ? $modPendaftaran->pegawai->NamaLengkap : "-"; ?></td>
        </tr>
        <tr>
            <td>Umur / Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->umur; ?> / <?php echo $modPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Jaminan</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?> - <?php echo !empty($modPendaftaran->sep_id)?$modPendaftaran->sepTs->nokartuasuransi:"-"; ?> / <?php echo !empty($modPendaftaran->sep_id)?$modPendaftaran->sepTs->norujukan:"-"; ?></td>
        </tr>
        <tr>
            <td>Nomor Telepon</td>
            <td>:</td>
            <td><?php echo $modPasien->no_mobile_pasien; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td></td>
            <td>:</td>
            <td><?php echo " - ".$modPasien->kecamatan->kecamatan_nama." - ".$modPasien->kabupaten->kabupaten_nama; ?></td>
        </tr>
        <tr>
            <td>Diagnosa</td>
            <td>:</td>
            <td><?php
            // echo $penunjang->pasienkirimkeunitlain_id;
            $morbi=PasienmorbiditasT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id));
            $diagnosa_nama = !empty($morbi->diagnosa_id)?$morbi->diagnosa->diagnosa_nama:"";
             
            echo !empty($diagnosa_nama) ? $diagnosa_nama : "-"; ?></td>
        </tr>
        <tr>
            <td valign=top>Pemeriksaan Lab</td>
            <td valign=top>:</td>
            <td valign=top>
            </td>
        </tr>
        <tr>
            <td valign=top>
                
            <?php
                    $namatindakan = "";
                    foreach ($daftartindakan[$i] as $i=>$daftartindakans){
                        if(count((array)$daftartindakans) > 1){
                            $namatindakan .= $daftartindakans->daftartindakan->daftartindakan_nama.",";
                        }else{
                            $namatindakan .= $daftartindakans->daftartindakan->daftartindakan_nama;
                        }
                    }
                    $namatindakan .= "";
                    echo $namatindakan;
                    ?>
            </td>
            <td valign=top></td>
            <td valign=top></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Petugas Sampling</td>
            <td>:</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="3" align="center" style="padding:5px 0px !important;">
                <div align="center" valign="middle">--------------------------------<i>potong disini</i>--------------------------------</div>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center" style="padding:5px;">
                <div class="judulcontent" align="center" valign="middle" style="font-size:8pt !important;">LABORATORIUM PATOLOGI ANATOMI</div>
            </td>
        </tr>
        <tr>
            <td>NOMOR SAMPLE</td>
            <td>:</td>
            <td><?php echo !empty($penunjang->noorderlis)?$penunjang->noorderlis:""; ?></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien.(!empty($modPasien->nama_bin) ? " (".$modPasien->nama_bin.")" : ""); ?></td>
        </tr>
        <tr>
            <td>UMUR / JENIS KELAMIN</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->umur; ?> / <?php echo $modPasien->jeniskelamin; ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeId(date('Y/m/d'),strtotime($penunjang->tglmasukpenunjang)); ?></td>
        </tr>
        <tr>
            <td>ALAMAT</td>
            <td>:</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
        <tr>
            <td></td>
            <td>:</td>
            <td><?php echo " - ".$modPasien->kecamatan->kecamatan_nama." - ".$modPasien->kabupaten->kabupaten_nama; ?></td>
        </tr>
        <tr>
            <td valign=top>Pemeriksaan Lab</td>
            <td valign=top>:</td>
            <td valign=top>
            </td>
        </tr>
        <tr>
            <td valign=top>
                
            <?php
                echo $namatindakan;
                ?>
            </td>
            <td valign=top></td>
            <td valign=top></td>
        </tr>
                    
        
                <?php    
                }
        } ?>
        
        
        
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
    