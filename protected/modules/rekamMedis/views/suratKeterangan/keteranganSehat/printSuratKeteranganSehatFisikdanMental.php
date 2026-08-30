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
       font-family: Times new roman, sans-serif;
       padding-top: 30px;
       margin-top: 0;
       margin-bottom: 0;
       
    }
    @media print {
      html, body {
        padding-top: 30px;
        padding-left: 10px;
        width: 210mm;
        height: 297mm;
        line-height: 1.3;
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
<?php
if(!empty($modPendaftaran->pegawai_id)){
    $cekPegawai = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
    $model->dokter = $cekPegawai->namaLengkap;
    $model->jabatan= (isset($cekPegawai->jabatan_id) ? $cekPegawai->jabatan->jabatan_nama : "");
    
}
?>
<div>
    <div>
        <table width="100%" style="margin:0px 50px 0px 50px;">
            <tr>
                <td style="font-size:20px; width: 22%">Lampiran<br>Perkonsil No.9 Tahun 2012<br><br><br></td>
            </tr>
        </table>
        <table ALIGN="CENTER" style="text-align: center;">
            <tr>
               <td ALIGN=CENTER VALIGN=MIDDLE style="font-size:22px;">
                   <b>
                       SURAT KETERANGAN SEHAT FISIK DAN MENTAL <br> 
                       UNTUK DAPAT MELAKSANAKAN PRAKTIK KEDOKTERAN
                   </b>
               </td>
           </tr>
       </table>
    </div>
    </br><br>
    <p style="text-align :left">
        Yang bertanda tangan dibawah ini :
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:50px;">
            <tr>
                <td style="font-size:20px; width:22%">Dokter</td>
                <td style="font-size:20px;">: <?php echo $model->dokter; ?></td>
            </tr>
             <tr>
                <td style="font-size:20px; width:22%">NPA IDI</td>
                <td style="font-size:20px;">: <?php echo $model->npaidi_dokter; ?></td>
            </tr>
            <?php /*
            <tr>
                <td style="font-size:20px; width:22%">S.I.P</td>
                <td style="font-size:20px;">: <?php echo $model->no_sk; ?></td>
            </tr>   
             * 
             */ ?>         
            <tr>
                <td style="font-size:20px; width:22%">Jabatan</td>
                <td style="font-size:20px;">: <span>Dokter Pemeriksa Kesehatan di IDI Cabang</span> <u><?php echo $model->idi_cabang; ?></u></td>
            </tr>
            <tr>
                <td style="font-size:20px; width:22%"></td>
                <td style="font-size:20px;"><span style="color:transparent">:</span> Surat Keputusan
                    <u><?php echo $model->suratkeputusan; ?></u>
                    <span> No. </span>
                    <u><?php echo $model->suratkeputusan_no; ?></u>
                </td>
            </tr>
        </table>
        <br>
        <p align="justify">Menerangkan Bahwa :</p>
        <table width="100%" style="margin-left:50px;">
            <tr>
                <td style="font-size:20px; width:22%">Nama</td>
                <td style="font-size:20px;">: <?php echo $modPasien->nama_pasien; ?></td>
            </tr>
             <tr>
                <td style="font-size:20px; width:22%">Umur</td>
                <td style="font-size:20px;">: 
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    echo $umur[0].' TAHUN' ?>
            </tr>          
            <tr>
                <td style="font-size:20px; width:22%">Alamat</td>
                <td style="font-size:20px;">: <?php echo strtoupper($modPasien->alamat_pasien.', '.$modPasien->kecamatan->kecamatan_nama.', '.$modPasien->kabupaten->kabupaten_nama) ?></td>
            </tr>
            <tr>
                <td style="font-size:20px; width:22%">Spesialis</td>
                <td style="font-size:20px;">: <?php echo strtoupper(!empty($model->spesialis) ? $model->spesialis : '-') ?></td>
            </tr>
            <tr>
                <td style="font-size:20px; width:22%; vertical-align: top;">Hasil Pemeriksaan </td>
                <td style="font-size:20px;"> :<br>
                    <?php foreach ($modLampiran as $value){ ?>
                    <table>
                        <tr>
                            <td style="font-size:20px; vertical-align: top"> - </td>
                            <td style="font-size:20px;"><?php echo $value->lampiransuratsehat_nama."<br>";?> </td>
                        </tr>
                    </table>
                    <?php } ?>
                    <br>
                </td>
            </tr>
            <tr>
                <td style="font-size:20px; width:22%">Tempat</td>
                <td style="font-size:20px;">: <?php echo Yii::app()->user->getState('kabupaten_nama'); ?></td>
            </tr>
            <tr>
                <td style="font-size:20px; width:22%">Tanggal</td>
                <td style="font-size:20px;">: 
                    <?php echo date('d ', strtotime($model->tglsurat)).MyFormatter::getMonthId(date('m', strtotime($model->tglsurat))).date(' Y', strtotime($model->tglsurat)); ?>
                </td>
            </tr>
        </table>
</div><br><br><br>
<div>
    <label class="font-13px"  style="width:100%;">
        <table class="tabel-surat" width="100%" style="margin:0px 50px 0px 50px;color: rgb(51, 51, 51);">
            <tr>
                <td width="50%" style="text-align: left; vertical-align:top;font-size:20px">
                    <br><br><br><br><br><br>

                    <?php 
                    echo $model->mengetahui_surat; 
                    $cekPegawai = PegawaiM::model()->findByPk($model->mengetahuipeg_id);
                    echo '<br><br>NPA IDI. '.$model->npaidi_dokter;  ?>

                </td>
                <td width="50%" style="text-align: center;font-size:20px">                        

                </td>
            </tr>
        </table>
  </label>
</div>
