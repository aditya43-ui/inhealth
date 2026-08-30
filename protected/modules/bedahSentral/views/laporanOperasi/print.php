<head>
    <link rel="stylesheet"
        href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet"
        href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
/* @page {
    size: A4;
    margin: 0;
} */

/* @media print {

    html,
    body {
        width: 210mm;
        height: 297mm;
    }

    body {
        color: black;
        font-size: 8pt !important;
    }
} */

html {
    font-size: 10pt !important;
    color: black;
}

body {
    color: black !important;
    margin: 0;
    padding: 0;
    font-size: 10pt !important;
}

table {
    font-size: 10pt !important;
    color: black;
}

p {
    text-align: justify;
}

.borderclass {
    border: 1px solid black;
}

.bordertopclass {
    border-top: 1px solid black;
}

.borderrightclass {
    border-right: 1px solid black;
}

.borderleftclass {
    border-left: 1px solid black;
}

.borderbottomclass {
    border-bottom: 1px solid black !important;
}

.padding5 {
    padding: 0px;
}

header,
footer {
    height: 30px;
}

.tablefont td {
    color: black;
    padding: 5px;
}

.fa {
    font-size: 10pt;
}

.disable-panel {
    margin: 0;
    padding: 0 !important;
    cursor: not-allowed;
    position: absolute;
    z-index: 99999;
    height: 96%;
    width: 97%;
}

select[disabled] {
    background: #eeeeee;
}

.textbold {
    font-weight: bold;
}

.textcenter {
    text-align: center;
}

.textright {
    text-align: right;
}

.table-costum th,
.table-costum td {
    border: 1px solid #000;
    padding: 10px;
}

.headertext {
    padding-bottom: 10px !important;
}

.textcoret {
    text-decoration: line-through;
}

#tbl-isi td {
    vertical-align: top;
}

#tbl-isi td>span {
    max-width: 100px;
}

.ttd-img {
    z-index: -1;
}
</style>

<?php
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT);
$konfig = KonfigsystemK::model()->find();
?>
<div style="padding: 5px;">
    <?php 
    echo $this->renderPartial($this->path_view."_headerPrint", array(
       'modProfilRs'=>$modProfilRs,'modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran
   ), true); 
   ?>
</div>
<table width="100%">
    <tr>
        <td class="padding5 borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" width="50%"
            valign="top">
            <table width="100%" id="tbl-isi">
                <tr>
                    <td width="120px">Dokter Bedah</td>
                    <td colspan="3">:
                        <?php echo (!empty($rencana->dokter1)?$rencana->dokter1->namaLengkap:"");  ?></td>
                </tr>
                <tr>
                    <td width="120px">Asisten </td>
                    <td>: <?php echo (!empty($rencana->dokter2)?$rencana->dokter2->namaLengkap:"");  ?></td>
                </tr>
                <tr>
                    <td width="100px">Dokter Anastesi</td>
                    <td colspan="3">:
                        <?php echo (!empty($rencana->dokteranastesi)?$rencana->dokteranastesi->namaLengkap:"");  ?>
                    </td>
                </tr>
                <tr>
                    <td width="100px">Instrumen</td>
                    <td colspan="3">: <?php echo (!empty($rencana->bidan)?$rencana->bidan->namaLengkap:"");  ?>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Operasi</td>
                    <td colspan="3">:&nbsp;
                        <?php echo ($model->is_cyto != null) && ($model->is_cyto==true)? 'Cito' : 'Elektif' ?>
                    </td>
                </tr>
                <tr>
                    <td>Golongan Operasi</td>
                    <td colspan="3">:
                        <?php echo !empty($model->golonganoperasi_keterangan) ? ucfirst($model->golonganoperasi_keterangan) : ''?>
                    </td>
                </tr>
            </table>
        </td>
        <td class="padding5 borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" width="50%"
            valign="top">
            <table width="100%">
                <tr>
                    <td colspan="2" width="120px" rowspan="" valign="top">Tanggal Operasi</td>
                    <td>:
                        <?php

                                $pasienkirimkeunitlain_id = $model->pasienmasukpenunjang->pasienkirimkeunitlain_id;
                                $pasienmasukpenunjang_id = $model->pasienmasukpenunjang_id;
                                
                                $signin = OperasisigninT::model()->find("pasienkirimkeunitlain_id = $pasienkirimkeunitlain_id order by operasisignin_id desc");
                                $signout = OperasisignoutT::model()->find("pasienmasukpenunjang_id = $pasienmasukpenunjang_id order by operasisignout_id desc");

                                $tglmulai = '-';
                                $tglselesai = '-';

                                $diag_pre = '';
                                $diag_pasca = '';

                                if(!empty($signin)) {
                                    $tglmulai = !empty($signin->signin_tgl) ? MyFormatter::formatDateTimeForUser($signin->signin_tgl) : '-';
                                    $diag_pre = $signin->signin_diagnosapreop;
                                }

                                if(!empty($signout)) {
                                    $tglselesai = !empty($signout->signout_tgl) ? MyFormatter::formatDateTimeForUser($signout->signout_tgl) : '-';
                                    $diag_pasca = $signout->signout_diagnosapostop;

                                }

                                echo "$tglmulai s/d<br>$tglselesai";
                   
                            ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Dikirim Untuk Pemeriksaan </td>
                    <td>:

                        <?php
                            $dikirim = "";

                            $is_dikirim = $model->is_dikirimpemeriksaan ? "Ya" : "Tidak";
                            $dikirim = $model->is_pa ? ', PA' : $dikirim;
                            $dikirim = $model->is_vc ? ', VC' : $dikirim;
                            $dikirim = $model->is_kultur ? ', Kultur' : $dikirim;
                            $dikirim = $model->is_analisa ? ', Analisa' : $dikirim;
                            

                            echo $is_dikirim . $dikirim;
                        ?>

                    </td>
                </tr>
                <tr>
                    <td colspan="2" valign="top">Jaringan yang di eksisi/insisi </td>
                    <td valign="top">: <?php echo $model->jaringan; ?></td>
                </tr>
                <tr>
                    <td colspan="2">Drain/ Tampon </td>
                    <td>: <?php echo $model->drain; ?></td>
                </tr>
                <tr>
                    <td colspan="2">Pendarahan</td>
                    <td>: <?php echo $model->perdarahan; ?></td>
                </tr>
                <tr>
                    <td colspan="2">Alat Implan</td>
                    <td>: <?php echo $model->alatimplan; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="padding5 borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            Jenis Anestesi :
            <?php
            $lookup = LookupM::model()->findAll("lookup_type = 'jenisanestesi'");
            $html = "";
            if(!empty($lookup)){
              foreach($lookup as $look){
                $ischeck =  false;

                if(!empty($model->jenis_anestesi) && $model->jenis_anestesi == $look->lookup_value){
                  $ischeck =  true;
                }

                $html .= "<span style='padding-left: 50px'>[".(($ischeck ==true)?'<i class="fa fa-check"></i>':'&nbsp;')."] ".$look->lookup_value."</span> ";
              }
            }
            echo $html;
          ?>
        </td>
    </tr>
    <tr>
        <td class="padding5 borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            <table width="100%">
                <tr>
                    <td colspan="2" style="font-weight: bold; text-decoration: underline; font-size: 10pt">
                        DIAGNOSA
                    </td>
                </tr>
                <tr>
                    <td width="150px">Diagnosa pra bedah</td>
                    <td>: <?php echo $diag_pre ?></td>
                </tr>
                <tr>
                    <td>Diagnosa pasca bedah</td>
                    <td>: <?php echo $diag_pasca ?></td>
                </tr>
                <tr>
                    <td>Tindakan</td>
                    <td>:
                        <?php echo (!empty($rencana->operasi)? (!empty($rencana->operasi->daftartindakan)?$rencana->operasi->daftartindakan->daftartindakan_nama:"") :""); ?>
                    </td>
                </tr>
                <tr>
                    <td>Komplikasi</td>
                    <td>: </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            1. Persiapan Operasi (Profilaksis, Inform consent)<br>
            <span style="margin-left: 15px;"><?php echo strip_tags($model->persiapanoperasi); ?></span>
        </td>
    </tr>
    <tr>
        <td class="borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            2. Posisi pasien<br>
            <span style="margin-left: 15px;"><?php echo strip_tags($model->posisipasien); ?></span>
        </td>
    </tr>
    <tr>
        <td class="borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            3. Desinfeksi<br>
            <span style="margin-left: 15px;"><?php echo strip_tags($model->desinfeksi); ?></span>
        </td>
    </tr>
    <tr>
        <td class="borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            4. Insisi kulit dan pembukaan lapangan operasi<br>
            <span style="margin-left: 15px;"><?php echo strip_tags($model->insisikulit); ?></span>
        </td>
    </tr>
    <tr>
        <td class="borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            5. Pendapatan pada eksplorasi<br>
            <span style="margin-left: 15px;"><?php echo strip_tags($model->pendapataneksplorasi); ?></span>
        </td>
    </tr>
    <tr>
        <td class="borderleftclass bordertopclass borderrightclass" style="padding-left: 20px" colspan="2">
            6. Deskripsi/ uraian operasi<br>

            <?php 
                
                $des = strip_tags($model->deskripsioeprasi);

                $des = str_replace(" ", ", ", $des);
                
                //echo '<pre>'; var_dump($model->deskripsioeprasi); die;
            ?>
            <span style="margin-left: 15px;"><?php echo $des; ?></span>
        </td>
    </tr>
    <?php

            $peg = '';
            $url_ttd = '';
            if(!empty($rencana->dokterpelaksana1_id)) {
              $peg = PegawaiM::model()->findByPk($rencana->dokterpelaksana1_id);
              $url_ttd = (empty($peg->ttd_pegawai) ? '' : Params::pathPegawaiDirectory() . $peg->ttd_pegawai);
            }
            // echo '<pre>'; var_dump($rencana->dokterpelaksana1_id, $peg->ttd_pegawai); die;  

            $path = $url_ttd;

            $res = "";
            $ext = "png";
            if(!empty($peg->ttd_pegawai)){
                if (file_exists($path)) {
                    $content = file_get_contents($path);
                    $ext_data = pathinfo($path);
                
                    if (!empty($ext_data) && is_array($ext_data) && !empty($ext_data)) {
                        $ext = $ext_data['extension'];
                    }
                  
                    $res = "data:image/" . $ext . ";base64," . base64_encode($content);
                }
            }

          ?>
    <tfoot>
        <tr>
            <td class="borderleftclass borderbottomclass borderrightclass" style="padding-left: 20px;" colspan="2">
                <br><br><br>
                <table width="100%">
                    <tr>
                        <td width="30%"></td>
                        <td width="30%"></td>
                        <td width="40%">
                            <center>
                                <?php echo ucwords(strtolower($modProfilRs->kabupaten->kabupaten_nama)); ?>,
                                <?php echo (!empty($model->create_time)? MyFormatter::formatDateTimeId(date('Y-m-d',strtotime(MyFormatter::formatDateTimeForDb($model->create_time)))): "");  ?>
                                &nbsp;&nbsp;
                                Jam :
                                <?php echo (!empty($model->create_time)? date('H:i:s',strtotime(MyFormatter::formatDateTimeForDb($model->create_time))): "");  ?>
                                <br />
                                <span style="z-index: 9999;">
                                    Dokter Operator
                                </span>
                                <br />
                                <div style='width:100%; z-index: -1; position: relative;'>
                                    <img style="margin-top: -20px; margin-bottom: -20px; width: 65%; max-width: 40%; max-height: 150px;"
                                        src="<?php echo $res; ?>" class="ttd-img" />
                                </div>

                                (<?php echo (!empty($rencana->dokter1)?$rencana->dokter1->namaLengkap:"");  ?>)
                            </center>
                            <br><br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tfoot>
</table>