<?php 
function ceklis($st){
    $icon = '<span  style="font-family:FontAwesome;" >&#xf096;</span>';
    if ($st){
        $icon = '<span  style="font-family:FontAwesome;" >&#xf046;</span>';
    }
    
    return $icon;
}

$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
if(!empty($_GET["pendaftaran_id"])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pegawai_id);
        $model->mengetahui_surat = (isset($modAdmisi->pegawai->nama_pegawai) ? $modAdmisi->pegawai->nama_pegawai : "");
    }
}


// $model->tglistirahat = $model->tglistirahat;
// $model->istirahat_tgl_sd = date('Y-m-d');

if(!empty($_GET['lama_hari'])){
    $model->lama_istirahat = $_GET['lama_hari'];
}

if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
}

?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    body {
/*        font-size: 8pt;*/
    }
    
    p{
        margin-left: 0;
        text-align: justify;
    }
    
    .tab-foot, .tab-foot td {
/*        font-size: 6pt;*/
    }
</style>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew2'); ?>
<div class="content">
    <div>

        <TABLE ALIGN="CENTER">
            <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <div class="judulcontent"><B><span  SIZE=4><?php echo $model->nomorsurat; ?></span></B></div>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span SIZE=4><?php echo "SURAT KETERANGAN SAKIT"."<br><span style='font-style: italic;'>CERTIFICATE OF ILLNES<span>" ?></span></B>
                </td>
            </tr>
             
        </TABLE>
    </div>
    </br><br>
    <div>        
    <p align="justify">
        Yang bertanda tangan dibawah ini menerangkan bahwa :<br><span style="font-style: italic;">I hereby state that:<span>
    </p>
    <p align="justify">
    <table style="margin-left:50px;">
            <tr>
                <td width="100">Nama<br><span style="font-style: italic;">Name<span></td>
                <td width="10">:</td>
                <td><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td>Usia<br><span style="font-style: italic;">Age<span></td>
                <td>:</td>
                <td>
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    
                            
                            $jkPR = '';
                            $jkLK = '';
                            if (!empty($modPasien->jeniskelamin)){
                                if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                    $jkPR = 'line-words';
                                }else{
                                    $jkLK = 'line-words';
                                }
                            }
                       
                    echo $umur[0].' Tahun' ?>
                    <?php /*
                    <span class='<?php echo $jkLK ?>'><?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?></span>
                            /
                        <span class='<?php echo $jkPR ?>'><?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?></span>
                     * 
                     */ ?>
                    
            </tr>
            <tr>
                <td>Pekerjaan<br><span style="font-style: italic;">Occupation<span></td>
                <td>:</td>
                <td><?php echo !empty($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:'-'; ?> </td>
            </tr>            
            <tr>
                <td>Alamat<br><span style="font-style: italic;">Address<span></td>
                <td>:</td>
                <td><?php echo $modPasien->alamat_pasien ?></td>
            </tr>
            <tr>
                <td>No. RM<br><span style="font-style: italic;">No. RM<span></td>
                <td>:</td>
                <td><?php echo $modPasien->no_rekam_medik ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Memerlukan cuti/istirahat selama <?php echo $model->lamaistirahat." (".$this->terbilang($model->lamaistirahat).")"; ?> hari karena<br><span style="font-style: italic;">
            Needs to have <?php echo $model->lamaistirahat; ?> day(s) sick leave/rest due to
            <span>
        </p>
        <table style="margin-left:50px;">
            <tr>
                <td><?php echo ceklis($model->jenisizin == 'Sakit')."Sakit<span style='font-style: italic;'><br>Illnes<span>" ?> </td>
                <td></td>
                <td></td>
                <td><?php echo ceklis($model->jenisizin == 'Melahirkan/Periksa Hamil')."Melahirkan/Periksa Hamil<br><span style='font-style: italic;'>Delivery<span>" ?></td>
            </tr>
        </table>
        <p align="justify">  Mulai tanggal <?php echo $format->formatDateTimeForUser($model->tglistirahat); ?> sampai <?php echo $format->formatDateTimeForUser($model->istirahat_tgl_sd); ?><br><span style='font-style: italic;'>
            Starting from <?php echo $format->formatDateTimeForUser($model->tglistirahat); ?> to <?php echo $format->formatDateTimeForUser($model->istirahat_tgl_sd); ?> 
            <span>
        </p>
        
        <p align="justify">
            Surat Keterangan ini dikeluarkan untuk dipergunakan sebagaimana mestinya.<br><span style='font-style: italic;'>
            This letter is for the use of specified person only
            <span>
        </p>
</div><br>

<table style="width: 100%; border: none;">
    <tr>
        <td>
        <?php 
                $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
                                  'data' =>$modPegawai->suratizinpraktek,
                                  'subfolderVar' => true,
                                  'displayImage'=>true, // default to true, if set to false display a URL path
                                  'errorCorrectionLevel'=>'M', // available parameter is L,M,Q,H
                                  'matrixPointSize'=>6, // 1 to 10 only
                                  'filename'=>str_replace('/','-',$model->nomorsurat)
                              )); 
                ?>
        </td>
        <td width="200">                        
                   <?php $date = date('Y-m-d'); ?>
                    <?php echo strtoupper($data->kabupaten->kabupaten_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                    <?php //echo strtoupper($data->nama_rumahsakit);?>
                    
                    <br><br><br><br><br>

            <?php
                   echo (!empty($model->mengetahui_surat) ? "".$model->mengetahui_surat : " _________________ " ) ;
                ?>

        </td>
    </tr>
    <!--tr style="padding:10px;">
        <td colspan="2">
            <b>*Coret Salah Satu</b>
        </td>
    </tr-->
</table>
</div>