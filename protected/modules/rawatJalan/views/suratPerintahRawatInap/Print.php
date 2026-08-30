<style>
    body {
        color: black !important;
    }

    h5 {
        color: black !important;
    }

    label {
        color: black !important;
    }

    .tab_header {
        width: 100%;
    }

    .pilihan_ijin,
    .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
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
</style>


<?php

$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
?>

<div class="pull-right">RM LL.03 REV 02</div>
<br>
<?php echo $this->renderPartial($this->path_view . '_headerSurat'); ?>
<br>
<table width="100%">
    <TR>
        <TD ALIGN=CENTER VALIGN=MIDDLE>
            <B>
                <FONT FACE="Liberation Serif" SIZE=4><u>SURAT PERINTAH RAWAT INAP</u></FONT>
            </B>
        </TD>
    </TR>
    <TR>
        <TD ALIGN=CENTER VALIGN=MIDDLE>
            <B>
                <FONT FACE="Liberation Serif" SIZE=4>NO. <?php echo $model->nomorsurat; ?></FONT>
            </B>
        </TD>
    </TR>
</table>
<br>
<table width="100%">
    <tr>
        <td style="width:70%; text-align: left;" colspan="2">
        </td>
        <td style="width:30%; text-align: left;" colspan="2">
            <center>Kepada: Yth <br>
                Kepala Ruangan Rawat Inap <br>
                di- <br>
                Tempat
            </center>
        </td>
    </tr>
</table>
<br>
<p>
    Bersama ini kami kirimkan Pasien dengan data sebagai berikut:
</p>
<div style="padding-left: 30px">
    <table width="100%">
        <tr>
            <td width="120px">Nama</td>
            <td>:</td>
            <td>
                <?php echo $modPasien->nama_pasien; ?> &nbsp;&nbsp;&nbsp;
                <?php
                $jenisKelamin = '';
                if (!empty($modPasien->jeniskelamin)) {
                    if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_PEREMPUAN) { ?>
                        <span><del>Laki-Laki</del></span> / <span>Perempuan</span>
                    <?php } else { ?>
                        <span>Laki-Laki</span> / <span><del>Perempuan</del></span>
                    <?php }
                } ?>
            </td>
        </tr>
        <tr>
            <td width="120px">No. Rekam Medis</td>
            <td>:</td>
            <td>
                <?php echo $modPasien->no_rekam_medik; ?>
            </td>
        </tr>
        <tr>
            <td width="120px">Jenis Penjamin / Penjamin</td>
            <td>:</td>
            <td>
                <?php echo $modPendaftaran->carabayar->carabayar_nama . " / " . $modPendaftaran->penjamin->penjamin_nama; ?>
            </td>
        </tr>
        <?php if (!empty($modSep)) { ?>
            <tr>
                <td width="120px">No. Kartu BPJS</td>
                <td>:</td>
                <td>
                    <?php echo $modSep->nokartuasuransi; ?>
                </td>
            </tr>
            <tr>
                <td width="120px">No. SEP</td>
                <td>:</td>
                <td>
                    <?php echo $modSep->nosep; ?>
                </td>
            </tr>
            <tr>
                <td width="120px">No. SPRI BPJS</td>
                <td>:</td>
                <td>
                    <?php echo $model->nomorspri_bpjs; ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td width="120px" valign="top">Alamat</td>
            <td valign="top">:</td>
            <td>
                <?php
                $alamat = $modPasien->alamat_pasien . " RT." . $modPasien->rt . " RW." . $modPasien->rw . " " . (isset($modPasien->kelurahan) ? "Kel." . $modPasien->kelurahan->kelurahan_nama : "") . " " . (isset($modPasien->kecamatan) ? "Kec." . $modPasien->kecamatan->kecamatan_nama : "") . " " . (isset($modPasien->kabupaten) ? "Kab/Kota." . $modPasien->kabupaten->kabupaten_nama : "") . " " . (isset($modPasien->propinsi) ? $modPasien->propinsi->propinsi_nama : "");
                echo $alamat; ?>
            </td>
        </tr>
        <tr>
            <td width="120px" valign="top">Diagnosa</td>
            <td valign="top">:</td>
            <td>
                <?php
                $diagUtama = "";
                $diagTambah = "";
                if(!empty($modResume)) {
                    $modDiagnosa = ResumemedisMorbiditasR::model()->findAllByAttributes(['resumemedis_id' => $modResume->resumemedis_id]);
                    $iUtm = 0;
                    $iCd = 0;
                    if (count($modDiagnosa) > 0) {
                        foreach ($modDiagnosa as $dataPasienMorb) {
                            $modDiagnosa = DiagnosaM::model()->findByPk($dataPasienMorb->diagnosa_id);
    
                            if ($dataPasienMorb->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA) {
                                if ($iUtm > 0) {
                                    $diagUtama .= ", ";
                                }
                                $diagUtama .= (isset($modDiagnosa) ? $modDiagnosa->diagnosa_nama : "");
                                $iUtm++;
                            } else  if ($dataPasienMorb->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH) {
                                if ($iCd > 0) {
                                    $diagTambah .= ", ";
                                }
                                $diagTambah .= (isset($modDiagnosa) ? $modDiagnosa->diagnosa_nama : "");
                                $iCd++;
                            }
                        }
                    } 
                }
                ?>

                <div style="float: left;">
                    Utama : <?php echo $diagUtama; ?>
                </div>
                <div style="padding-left: 100px; float: left;">
                    Tambahan/Penyerta : <?php echo $diagTambah; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td width="120px" valign="top">Therapi Sementara</td>
            <td valign="top">:</td>
            <td style="padding: 5px">
                <?php echo $model->therapi_sementara; ?>
            </td>
        </tr>
    </table>
</div>
<br>

<!--<p style="padding-left:30px">
    Therapi Sementara <span style="padding-left:50px;"><b>Pemakaian Bahan</b></span>
-->
</p>
<!--<div style="padding-left:190px">-->
<!--
<table style="width: 650px">
    <thead>
        <tr>
            <th class="borderclass">Tgl. Pemakaian</th>
            <th class="borderclass">Jenis Obat Alkes</th>
            <th class="borderclass">Nama Obat Alkes</th>
            <th class="borderclass">Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //        $modObatalkesPasienBm = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruangan_id'=>$modPendaftaran->ruangan_id,'oa'=>'BM'));
        //            if(count($modObatalkesPasienBm)){
        //                foreach ($modObatalkesPasienBm as $dataBm){
        //                    $obatAleksBm = ObatalkesM::model()->findByPk($dataBm->obatalkes_id);
        ?>
                    <tr>
                        <td class="borderclass"><?php // echo MyFormatter::formatDateTimeForUser($dataBm->tglpelayanan); 
                                                ?></td>
                        <td class="borderclass"><?php // echo (isset($obatAleksBm->jenisobatalkes)? $obatAleksBm->jenisobatalkes->jenisobatalkes_nama: ""); 
                                                ?></td>
                        <td class="borderclass"><?php // echo $obatAleksBm->obatalkes_nama; 
                                                ?></td>
                        <td class="borderclass"><?php // echo number_format($dataBm->qty_oa); 
                                                ?></td>
                    </tr>
                <?php
                //                }
                //            }else{
                ?>
                <tr>
                    <td colspan="4" class="borderclass">Tidak Ada</td>
                </tr>
                <?php
                //            }
                ?>
    </tbody>
</table>-->
<?php // $modResep = ResepturT::model()->findByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'ruanganreseptur_id'=>$modPendaftaran->ruangan_id)); 
?>
<!--    <br>
    <b>Resep</b>
    <p>Tgl. Resep : <?php // echo (isset($modResep)? MyFormatter::formatDateTimeForUser($modResep->tglreseptur) : ""); 
                    ?></p>
    <p>no. Resep : <?php // echo (isset($modResep)? $modResep->noresep : ""); 
                    ?></p>
    -->
<!--    <table style="width: 800px">
    <thead>
        <tr>
            <th class="borderclass" width="50px">R</th>
            <th class="borderclass">Kode / Nama Obat</th>
            <th class="borderclass">Jumlah</th>
            <th class="borderclass">Signa</th>
            <th class="borderclass">Cara Penggunaan Obat</th>
            <th class="borderclass">Sediaan</th>
        </tr>
    </thead>
    <tbody>-->
<?php
//            if(isset($modResep)){
//                $modResepDetail = ResepturdetailT::model()->findAllByAttributes(array('reseptur_id'=>$modResep->reseptur_id));
//                if(count($modResepDetail)){
//                    foreach ($modResepDetail as $dataResep){
//                        $obatAleksBm = ObatalkesM::model()->findByPk($dataResep->obatalkes_id);
?>
<!--                        <tr>
                            <td class="borderclass"><?php // echo $dataResep->rke; 
                                                    ?></td>
                            <td class="borderclass"><?php // echo $obatAleksBm->obatalkes_kode . "/". $obatAleksBm->obatalkes_nama; 
                                                    ?></td>
                            <td class="borderclass"><?php // echo number_format($dataResep->qty_reseptur); 
                                                    ?></td>
                            <td class="borderclass"><?php // echo $dataResep->signa_reseptur; 
                                                    ?></td>
                            <td class="borderclass"><?php // echo $dataResep->etiket; 
                                                    ?></td>
                            <td class="borderclass"><?php // echo $dataResep->satuansediaan; 
                                                    ?></td>
                        </tr>-->
<?php
//                    }
//                }else{
?>
<!--                    <tr>
                        <td colspan="6" class="borderclass">Tidak Ada</td>
                    </tr>-->
<?php
//                }
//            }else{
?>
<!--<tr>-->
<!--                        <td colspan="6" class="borderclass">Tidak Ada</td>
                    </tr>-->
<?php
//                }
?>
<!--</tbody>-->
<!--</table>-->
<!--</div>-->
<br />
<p style="padding-left: 30px">
    Mohon perawatan Selanjutnya, atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.
</p>
<?php if(empty($model->nomorspri_bpjs)){?>
<?php } else {?>
    <div style="padding-top: 20px">
    <table width="100%">
        <tr>
            <td rowspan="2" style="width:70%; text-align: left;" >
                <span style="margin-left: 2rem;">
                <?php
                $this->widget('ext.qrcode.QRCodeGenerator', array(
                    'data' => $model->nomorspri_bpjs,
                    'subfolderVar' => false,
                    'matrixPointSize' => 5,
                    'displayImage' => true, // default to true, if set to false display a URL path
                    'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                    'matrixPointSize' => 5, // 1 to 10 only
                ))
                ?>
                </span>
                <br>
                <br>
                <span><?php echo $model->nomorspri_bpjs ?></span>
            </td>
            <td style="width:30%; text-align: left;" colspan="2">
                <center>
                    <?php
                    $profil = ProfilrumahsakitM::model()->find();
                    $nama_kota = empty($profil->kabupaten) ? "-" : $profil->kabupaten->kabupaten_nama;

                    echo $nama_kota; ?>, <?php echo MyFormatter::formatDateTimeForUser($model->tgl_suratperintahranap); ?>
                </center>
                <center><b>Dokter</b>
                    <br><br><br><br><br><br>
                    <?php
                    echo empty($model->dpjp) ? "-" : $model->dpjp->namaLengkap; ?>
                </center>
            </td>
        </tr>
    </table>
    <table width="100%">

    </table>
</div>
<?php }?>   
