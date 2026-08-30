<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();

?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        font-size: 13px !important;
    }
@page {
   /* size: 7in 9.25in;
   margin: 20mm 20mm 20mm 20mm;
   font-size: 20px !important; */
   font-family: Arial, Helvetica, sans-serif;
}
@media print {
    html, body {
      /* width: 215mm;
      height: 297mm; */
      font-family: Arial, Helvetica, sans-serif;
    }
    div.footer {
        position: fixed;
        bottom: 0;
    }

    tr {
        font-size: 10px !important;
    }
}
table td {
    vertical-align: top !important;
}
table.footer {
    position: fixed;
    bottom: 0;
}
@media all {
.page-break { display: none; }
}

@media print {
.page-break { display: block; page-break-before: always; }
}

.nama-label {
    width : 180px;
}
.titik {
    width : 10px;
}

td {
        font-size: 13px !important;
    }
</style>
<?php 
if(!empty($modPendaftaran->pegawai_id)){
    // $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
    // $model->dokter = $cekPegawai->namaLengkap;
    // $model->jabatan= (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
    // $cekSIP = StrT::model()->findByAttributes(array('pegawai_id'=>$modPendaftaran->pegawai_id, 'jenis_str'=>'SIP'));
    /*
    if(!empty($cekSIP)){
        $model->sip = !empty($cekSIP->no_sk) ? $cekSIP->no_sk : '-';
    }else{
        $model->sip = '-';
    }
     * 
     */
}
?>
<div>
    <div>
        <?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
        <table width="100%" border="0px" >
            <tr>
                <td width="15%" align="center" >
                <?php
                     if(!empty($modProfilRs->logo_rumahsakit) && file_exists(Params::pathProfilRSDirectory().$modProfilRs->logo_rumahsakit)){ ?>
                 
                        <img src="<?php echo Params::urlProfilRSPDFPath().$modProfilRs->logo_rumahsakit ?> " style="float:left; max-width: 60px; width:60px;" class='image_report'/>
                    <?php } ?>

                </td>
                <td align="center" style="font-size:22px">
                    <div style="font-size:22px">
                        <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
                    </div>
                    <div style="font-size:17px;font-weight: bolder">
                        <?php echo $modProfilRs->alamatlokasi_rumahsakit.', '.$modProfilRs->no_telp_profilrs.' - '.Yii::app()->user->getState('kabupaten_nama') ?>
                    </div>
                   
                </td>
            </tr>
        </table>
        <hr style="border:1px solid">
        <TABLE ALIGN="CENTER">
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Arial" SIZE=3><U><?php echo $judul->jenissurat_nama; ?></U></FONT></B>
                </TD>
            </TR>
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE>
                    <B><FONT FACE="Arial" SIZE=3>NO : <?php echo $model->nomorsurat; ?></FONT></B>
                </TD>
            </TR>
        </TABLE>
    </div>
    <br>
    <table width="100%" >
        <tr>
            <td class="nama-label">No. Rekam Medik</td>
            <td class="titik">:</td>
            <td style="float:left"></td>
        </tr>        
        <tr>
            <td class="nama-label">Nama Pasien</td>
            <td class="titik">:</td>
            <td><?= $model->nama_pasien ?></td>
        </tr>

        <tr>
            <td class="nama-label">Jenis Kelamin</td>
            <td class="titik">:</td>
            <td></td>
        </tr>
        <tr>
            <td class="nama-label">Jenis Penjamin/Penjamin</td>
            <td class="titik">:</td>
            <td></td>
        </tr>
        <tr>
            <td class="nama-label">Diagnosa</td>
            <td class="titik">:</td>
            <td width="150px">- Diagnosa Utama</td>
            <td class="titik">:</td>
            <td><?php if(isset($modDiagnosa->diagnosa_nama)){
                    echo $modDiagnosa->diagnosa_nama." - ".$modDiagnosa->diagnosa_kode; 
                }else{
                    echo ""; 
                } ?>
            </td>
            
        </tr>
        <tr>
            <td class="nama-label"></td>
            <td class="titik"></td>
            <td width="150px" style="text-align :left">- Diagnosa Tambahan</td>
            <td class="titik">:</td>
            <td><?php if(isset($modTambahan)){
                    foreach($modTambahan as $diagnosa){
                        $modDiagnosaTambahan = DiagnosaM::model()->findByAttributes(array('diagnosa_id'=>$diagnosa->diagnosa_id));
                        echo "- ".$modDiagnosaTambahan->diagnosa_nama." - ".$modDiagnosaTambahan->diagnosa_kode."<br>"; 
                    }
                }else{
                    echo " "; 
                } ?>
            </td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td class="nama-label">Terapi</td>
            <td class="titik">:</td>
            <td style="font-size:20px"><?php echo $model->kontrolri_terapipulang?></td>
        </tr>
         
    </table>
    <br>
    <table width="100%">
        <tr>
            <td class="nama-label">Tanggal Surat Rujukan</td>
            <td class="titik">:</td>
            <td style="font-size:20px"><?php echo $model->tglsurat ?></td>
        </tr>
        <?php if (!empty($model->nomorsurat_bpjs)): ?>
        <tr>
            <td class="nama-label">No. Surat Kontrol BPJS</td>
            <td class="titik">:</td>
            <td style="font-size:20px"><?php echo $model->nomorsurat_bpjs ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td class="nama-label">Dokter Tujuan Kontrol</td>
            <td class="titik">:</td>
            <td style="font-size:20px"><?php 
            
            if (!empty($modPendaftaran->doktertujuankontrol_id)) {
                $peg = PegawaiM::model()->findByPk($modPendaftaran->doktertujuankontrol_id);

                echo empty($peg) ? "-" : $peg->namaLengkap;
            } else {
                echo "-";
            }
            
            ?></td>
        </tr>
         
    </table>
    <br><br>
    <p style="text-align :left">
        Belum dapat dikembalikan ke fasilitas kesehatan tingkat pertama dengan alasan :
    </p>
    <p style="text-align :left">
        <?php echo $model->kontrol_alasan ?>
    </p>
    <br><br>
    <p style="text-align :left">
        Rencana tindak lanjut yang akan dilakukan pada kunjungan selanjutnya :
    </p>
    <p style="text-align :left">
        <?php echo $model->konrol_rencanatindaklanjut ?>
    </p>

    <br><br>
    <p style="text-align :left">
        Surat keterangan ini digunakan untuk (1) kali kunjungan dengan diagnosa di atas pada Tanggal : <?php echo date('d ', strtotime($model->tglrenkontrol)).MyFormatter::getMonthId(date('m', strtotime($model->tglrenkontrol))).date(' Y', strtotime($model->tglrenkontrol));  ?>
    </p>
</div><br>
<div >
    <div>
        <label class="font-13px"  style="width:100%;">
            <table class="tabel-surat" width="100%" >
                <tr>
                    <td width="50%" style="text-align: left; vertical-align:top;font-size:20px">
                        <?php if(!empty($modLampiran)){ ?>
                        Lampiran/catatan<br><br>
                        <?php $no=1; foreach ($modLampiran as $value){ ?>
                        <table style="line-height: 20pt; margin-left: -20px">
                            <tr>
                                <td style="font-size:20px; vertical-align: top"> <?php echo $no++;?>. </td>
                                <td style="font-size:20px;"><?php echo $value->lampiransuratsehat_nama."<br>";?> </td>
                            </tr>
                        </table>
                        <?php } }?>
                    </td>
                    <td width="50%" style="text-align: center;font-size:15px">                        
                        <?php echo Yii::app()->user->getState('kabupaten_nama') ?>, <?php echo date('d ', strtotime($model->tglsurat)).MyFormatter::getMonthId(date('m', strtotime($model->tglsurat))).date(' Y', strtotime($model->tglsurat));  ?><br><br>
                        Dokter yang Merawat
                        <br><br><br><br><br><br>
                       
                        <?php 
                        echo $model->nama_pegawai; 
                        // echo '<br><br>SIP. '.$model->sip;  ?>
                        
                    </td>
                </tr>
            </table>
        </label>
    </div>
</div>
<strong><p style="text-align :left">
        NB : Harap surat ini dibawa ketika kontrol ke
</p></strong>
<p style="text-align :left">
        <?php echo $modRuangan->ruangan_nama?>
</p>