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
        text-indent: 50px;
        text-align: justify;
        font-size: 20px !important;
    }
@page {
   size: 7in 9.25in;
   margin: 20mm 20mm 20mm 20mm;
   font-size: 20px !important;
   font-family: Arial, Helvetica, sans-serif;
}
@media print {
    html, body {
      width: 215mm;
      height: 297mm;
      font-family: Arial, Helvetica, sans-serif;
    }
    div.footer {
        position: fixed;
        bottom: 0;
    }
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
</style>

<div>
    <div>
        <?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
        <table width="100%" border="0px">
            <tr>
                <td width="15%" align="center">
                    <img src="<?php echo Params::pathImageErrorAdmin()."Jawa_Timur.png"?> " style="max-width: 100px; width:100px;"/>
                </td>
                <td align="center" style="font-size:20px">
                    <div style="font-size:20px">
                        <b><?php echo strtoupper($modProfilRs->nama_rumahsakit); ?></b>
                    </div>
                    <div style="font-size:20px">
                        <b>BAGIAN CHECK-UP</b>
                    </div>
                    <div style="font-size:20px;font-weight: bolder">
                        <?php echo $modProfilRs->alamatlokasi_rumahsakit.', '.$modProfilRs->no_telp_profilrs ?>
                    </div>
                    <div style="font-size:20px">
                        <b><?php echo Yii::app()->user->getState('kabupaten_nama'); ?></b>
                    </div>
                </td>
                <td width="15%" align="center" style="font-size:20px">
                    <img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit ?> " style="max-width: 130px; width:130px;"/>
                </td>
            </tr>
        </table>
        <hr style="border:1px solid">
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Arial" SIZE=5><U><?php echo "SURAT KETERANGAN SEHAT"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Arial" SIZE=5>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br>
    <p style="text-align :left">
        Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>
    <p align="justify">
        <table width="100%" style="margin:0px 50px 0px 50px;">
            <tr>
                <td style="font-size:20px; width: 20%">Nama</td>
                <td style="font-size:20px">:</td>
                <td style="font-size:20px"><?php echo $modPasien->nama_pasien ?></td>
            </tr>
             <tr>
                <td style="font-size:20px">Umur</td>
                <td style="font-size:20px">:</td>
                <td style="font-size:20px">                     
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    echo $umur[0].' TAHUN' ?>
            </tr>
            <tr>
                <td style="font-size:20px">Jenis Kelamin</td>
                <td style="font-size:20px">:</td>
                <td style="font-size:20px"><?php echo $modPasien->jeniskelamin ?> </td>
            </tr>            
            <tr>
                <td style="font-size:20px">Alamat</td>
                <td style="font-size:20px">:</td>
                <td style="font-size:20px"><?php echo strtoupper($modPasien->alamat_pasien.', '.$modPasien->kecamatan->kecamatan_nama.', '.$modPasien->kabupaten->kabupaten_nama) ?></td>
            </tr>
        </table>
        <br>
        <p align="justify">Setelah dilakukan pemeriksaan secara seksama pada saat ini dinyatakan :</p>
        <table style="width: 100%; border: none;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE  style="font-size:20px; font-weight: bold">
                    <?php echo !empty($model->status_fisik) ? $model->status_fisik : "SEHAT / TIDAK SEHAT" ?><br>
                </td>
            </tr>
        </TABLE>
            
        </p>
        <p align="justify">
        Demikian surat keterangan ini kami berikan untuk melengkapi persyaratan
        </p>
        <table style="width: 100%; border: none;">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE style="font-size: 20px">
                    <?php  echo strtoupper($model->keterangan).'<br>' ?>
                </td>
            </tr>
        </TABLE>
        <br>
            <table width="100%" style="margin:0px 50px 0px 50px;">
                <tr>
                    <td style="font-size:20px" width="20%">Tinggi Badan</td>
                    <td style="font-size:20px">:</td>
                    <td style="font-size:20px"><?php 
                            echo $model->tinggibadan;
                        ?> cm
                    </td>
                </tr>
                 <tr>
                    <td style="font-size:20px">Berat Badan</td>
                    <td style="font-size:20px">:</td>
                    <td style="font-size:20px"><?php 
                            echo $model->beratbadan;
                        ?> kg
                    </td>
                </tr>
                <tr>
                    <td style="font-size:20px">Tensi</td>
                    <td style="font-size:20px">:</td>
                    <td style="font-size:20px"><?php 
                            echo $model->tekanandarah_sistolik.' / '.$model->tekanandarah_diastolik;
                        ?> mmhg
                    </td>
                </tr>            
            </table>
</div><br><br><br>
<div >
    <div>
        <label class="font-13px"  style="width:100%;" border="1">
            <table class="tabel-surat" width="100%" style="margin:0px 50px 0px 50px;color: rgb(51, 51, 51);">
                <tr>
                    <td width="40%" style="text-align: left; vertical-align:top;font-size:20px">
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
                    <td width="60%" style="text-align: center;font-size:20px">                        
                        <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo date('d ', strtotime($model->tglsurat)).MyFormatter::getMonthId(date('m', strtotime($model->tglsurat))).date(' Y', strtotime($model->tglsurat)); ?><br><br>
                        Pemeriksa
                        <br><br><br><br><br><br>
                       
                        <?php 
                        echo $model->mengetahui_surat; 
                        $cekPegawai = PegawaiM::model()->findByPk($model->mengetahuipeg_id);
                        if (!empty($model->no_sk)) {
                            echo '<br><br>NIP. '.$cekPegawai->nomorindukpegawai.'<br><br>SIP. '.$model->no_sk;  
                        } else {
                            echo '<br><br>NIP. '.$cekPegawai->nomorindukpegawai;
                        }
                        ?>
                        
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>
