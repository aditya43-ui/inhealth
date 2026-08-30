
<?php
if (isset($_POST["EXCEL"])) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . "Surat Keterangan" . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
if(!empty($_GET['pendaftaran_id'])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPemeriksaanFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // var_dump($modPemeriksaanFisik);die;
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
    if(!empty($modPendaftaran->pasienadmisi_id)){
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
        $model->mengetahui_surat = (isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pegawai->nama_pegawai : "");
    }else{
        $modAdmisi = new PasienadmisiT;
        $modAdmisi->tgladmisi = date('Y-m-d')." 00:00:00";
        $modAdmisi->tglpulang = date('Y-m-d')." 00:00:00";
    }
}else{
    $model->tglsurat = date('Y-m-d');
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

<div>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew2'); ?>
        <div>
            <div class="content">
                <div>

                    <TABLE ALIGN="CENTER">
                    <tr>
                            <td ALIGN=CENTER VALIGN=MIDDLE>
                                <B><span  SIZE=4><?php echo $model->nomorsurat; ?></span></B>
                            </td>
                        </tr>
                        <tr>
                            <td ALIGN=CENTER VALIGN=MIDDLE>
                                <div class="judulcontent"> <B><span  SIZE=4><?php echo "SURAT KETERANGAN SEHAT<br><i>CERTIFICATE OF HEALTH</i>"; ?></span></B></div>
                            </td>
                        </tr>
                        
                    </TABLE>
                </div>
                </br><br>
                <p align="justify">
                    <u>Yang bertanda tangan dibawah ini menerangkan bahwa :</u>
                </p>
                <p align="justify">
                    <i>i herebly state that:</i>
                </p>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td>Nama &nbsp; <i>(Name)</td>
                        <td width="10">:</td>
                        <td><?php echo $modPasien->nama_pasien ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin &nbsp; <i>(Gender)</td>
                        <td>:</td>
                        <td>                     
                            <?php
                            $umur = explode(' ', $modPendaftaran->umur);

                            $jkPR = Params::JENIS_KELAMIN_PEREMPUAN;
                            $jkLK = Params::JENIS_KELAMIN_LAKI_LAKI;
                            if (!empty($modPasien->jeniskelamin)) {
                                if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
                                    $jkPR = '<span style="text-decoration: line-through;">' . $jkPR . '</span>';
                                } else {
                                    $jkLK = '<span style="text-decoration: line-through;">' . $jkLK . '</span>';
                                }
                            }
                            ?>
                            <span><?php echo $jkLK; ?></span>
                            /
                            <span><?php echo $jkPR; ?></span> *

                    </tr>
                    <tr>
                        <td>Usia &nbsp; <i>(Ages)</td>
                        <td>:</td>
                        <td>                     
                            <?php
                                $umur = explode(' ', $modPendaftaran->umur);
                                echo $umur[0] . ' Tahun,'
                            ?>
                    </tr>
                    <tr>
                        <td>Pekerjaan &nbsp; <i>(Occupation)</td>
                        <td>:</td>
                        <td><?php echo!empty($modPasien->pekerjaan_id) ? $modPasien->pekerjaan->pekerjaan_nama : '-'; ?> </td>
                    </tr>            
                    <tr>
                        <td>Alamat &nbsp; <i>(Address)</td>
                        <td>:</td>
                        <td><?php echo $modPasien->alamat_pasien ?></td>
                    </tr>
                    <!-- <tr>
                        <td>No. RM &nbsp; <i>(No. RM)</td>
                        <td>:</td>
                        <td><?php //echo $modPasien->no_rekam_medik ?></td>
                    </tr> -->
                </table><br>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td><u>Telah diperiksa dengan teliti dan dinyatakan:</u>&nbsp;<?php echo $model->hasil_periksa ; ?><br> <i>It  Has Been examined carefully and expressed</i></td>
                    </tr>
                    <tr>
                        <td><u>Surat Keterangan ini dipergunakan untuk:</u>&nbsp;<?php echo $model->pergunaan_surat; ?><br> <i>Health Certificate is used for</i></td>
                        <td> </td>
                    </tr> 
                </table>
                <p align="justify">
                <u>Hasil Pemeriksaan</u><br><i>Test Result</i>
                </p>
                <table style="width: 100%; border: none; margin-left:10px;">
                    <tr>
                        <td>Tekanan Darah &nbsp;<i>(Blood Pressure)</i></td>
                        <td><?php echo !empty($modPemeriksaanFisik)?$modPemeriksaanFisik->tekanandarah."Hg":'-'; ?></td>
                        <td>Denyut Nadi &nbsp;<i>(Pulse)</i></td>
                        <td><?php echo !empty($modPemeriksaanFisik)?$modPemeriksaanFisik->detaknadi."/Menit":'-'; ?></td></td>
                    </tr>
                    <tr>
                        <td>Suhu &nbsp;<i>(Temperature)</i></td>
                        <td><?php echo !empty($modPemeriksaanFisik)?$modPemeriksaanFisik->suhutubuh."°Celcius":'-'; ?></td></td>
                        <td>RR &nbsp;<i>(Respiration Rate)</i></td>
                        <td><?php echo !empty($modPemeriksaanFisik)?$modPemeriksaanFisik->pernapasan."/Menit":'-'; ?></td></td>
                    </tr>
                    <tr>
                        <td>Tinggi Badan &nbsp;<i>(Height)</i></td>
                        <td><?php echo !empty($modPemeriksaanFisik)?$modPemeriksaanFisik->tinggibadan_cm."Cm":'-'; ?></td></td>
                        <td>Berat Badan &nbsp;<i>(Weight)</i></td>
                        <td><?php echo!empty($modPemeriksaanFisik)?$modPemeriksaanFisik->beratbadan_kg."Kg":'-'; ?></td></td>
                    </tr>
                    <tr>
                        <td>Golongan Darah &nbsp;<i>(Blood type)</i></td>
                        <td><?php echo !empty($modPasien->golongandarah)?$modPasien->golongandarah:'-'; ?></td></td>
                        <td>Buta Warna &nbsp;<i>(Color Blindness)</i></td>
                        <td><?php echo $model->butawarna; ?></td>
                    </tr> 
                </table>
                <table width="100%" style="border:none">
            <tr>
                <td width="30%"><u>Swab PCR RT Covid-19</u></td>
                <td><?php echo $model->hasil_swab; ?></td>
            </tr>
            <tr>
                <td><u>Catatan Dokter</u> <i>(Note)</i></td>
                <td><?php echo $model->catatan_dokter; ?></td>
            </tr>
            <tr>
                <td><u>Kesimpulan</u> <i>(Summary)</i></td>
                <td><?php echo $model->kesimpulan; ?></td>
            </tr>
        </table>
        <p align="justify">
            <u>Surat Keterangan ini dikeluarkan untuk dipergunakan sebagaimana mestinya</u>
        </p>
        <p align="justify">
            <i>This letter is for the use of specified person only</i>
        </p>
                
                <br>
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
                            <?php echo strtoupper($data->kabupaten->kabupaten_nama); ?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                            <?php //echo strtoupper($data->nama_rumahsakit); ?>
                            Dokter Pemeriksa
                            <br><br><br><br><br>

                            <?php
                            echo $model->mengetahui_surat;
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
        </div>