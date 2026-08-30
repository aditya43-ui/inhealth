<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
        size: 7in 9.25in;
        margin: 27mm 16mm 27mm 16mm;
        font-size: 10px !important;
        padding-top: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    @media print {
        html, body {
            padding-top: 30px;
            width: 210mm;
            height: 297mm;
            line-height: 12pt;
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
        .page-break { display: block; page-break-before: always;}
    }
</style>
<table width="55%" border="0px">
    <tr>
        <td style="width:50% !important"><?php echo $this->renderPartial('anestesi.views.persetujuanTindakanAnastesi._headerPrint'); ?></td>
    </tr>
</table>
<br>
<table width="100%" class="table-condensed" border="1">
    <tr>
        <td colspan='2'>
            <table>
                <tr>
                    <td style="text-align:center;" colspan="6"><b>PERSETUJUAN TINDAKAN ANESTESI</b><br></td>
                </tr>
                <tr>
                    <td style="text-align:center;" colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">Setelah mendapat informasi mengenai tindakan anestesi/sedasi, maka yang bertanda tangan di bawah ini :</td>
                </tr>
                <tr>
                    <td style="width:10%">Nama</td>
                    <td colspan="2">: <?php echo $model->namapenanggungjawab ?></td>
                </tr>
                <tr>
                    <td style="width:20%">Umur</td>
                    <td style="width:60%">: <?php echo $model->umurpenanggungjawab ?></td>   
                    <td style="width:20%">Jenis kelamin : 
                        <?php 
                        if($model->jeniskelamin_penanggungjawab == 'LAKI-LAKI'){ 
                            echo 'L '; 
                            
                        }else if($model->jeniskelamin_penanggungjawab == 'PEREMPUAN'){ 
                            echo 'P'; 
                        }else{ 
                            echo 'L / P';
                        } ?> 
                    </td>
                </tr>
                <tr>
                    <td>Alamat  </td>
                    <td colspan="2">: <?php echo $model->alamat_penanggungjawab ?></td>  
                </tr>
                <tr>
                    <td>No. Kartu Identitas </td>
                    <td>: <?php echo $model->noidentitas_penanggungjawab ?></td>  
                    <td>(
                        <?php 
                        if($model->jenisidentitas_penanggungjawab == 'KTP'){ 
                            echo 'KTP / <span style="text-decoration: line-through">SIM</span>'; 
                            
                        }else if($model->jenisidentitas_penanggungjawab == 'SIM'){ 
                            echo '<span style="text-decoration: line-through">KTP</span> / SIM'; 
                            
                        }else{ 
                            echo 'KTP / SIM';
                        } ?> 
                        )</td>
                </tr>
                <tr>
                    <td colspan="3">Menyatakan PERSETUJUAN untuk dilakukan tindakan anestesi berupa :</td> 
                </tr>
                <tr>
                    <td colspan="3">
                        <?php
                        if ($model->jnsanestesi_sedasiberatsedang) {
                            echo " <b>Sedasi Sedang dan Berat</b>";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_regional_sab || $model->jnsanestesi_regional_blokperifer || $model->jnsanestesi_regional_sedasi || $model->jnsanestesi_regional_tnpsedasi || $model->jnsanestesi_regional_epidural || $model->jnsanestesi_regional_kombinasi) {
                            echo " <b>Anestesi Regional : </b>";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_regional_sab) {
                            echo " SAB";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_regional_blokperifer) {
                            echo " Blok Perifer";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_kombinasi) {
                            echo " <b>Anestesi Kombinasi</b>";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_umum) {
                            echo " <b>Anestesi Umum</b>";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_regional_sedasi) {
                            echo " Sedasi";
                        } else {
                            echo " ";
                        }
                        ?>
                        &nbsp;&nbsp;
                        <?php
                        if ($model->jnsanestesi_regional_tnpsedasi) {
                            echo " Tanpa Sedasi";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_regional_epidural) {
                            echo " Epidural";
                        } else {
                            echo " ";
                        }
                        ?>
                        <?php
                        if ($model->jnsanestesi_regional_kombinasi) {
                            echo " Kombinasi";
                        } else {
                            echo " ";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Terhadap pasien :</td>
                    <td colspan="2">  </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td colspan="2">: <?php echo !empty($model->pasien_id) ? $model->pasien->nama_pasien : '' ?> </td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td colspan="2">: <?php echo !empty($model->pasien_id) ? date('d ', strtotime($model->pasien->tanggal_lahir)).MyFormatter::getMonthId(date('m', strtotime($model->pasien->tanggal_lahir))).date(' Y', strtotime($model->pasien->tanggal_lahir)) : '' ?> </td>
                </tr>
                <tr>
                    <td>No. Rekam Medis</td>
                    <td colspan="2">: <?php echo !empty($model->pasien_id) ? $model->pasien->no_rekam_medik : '' ?> </td>
                </tr>
                <tr>
                    <td>Diagnosis</td>
                    <td colspan="2">: <?php echo !empty($model->diagnosa_id) ? $model->diagnosa->diagnosa_nama : '' ?> </td>
                </tr>
                <tr>
                    <td>Tindakan</td>
                    <td colspan="2">: <?php echo !empty($model->tindakan) ? $model->tindakan : "";?></td>
                </tr>
                <tr>
                    <td colspan="3">Saya menyatakan dengan sesungguhnya dan tanpa paksaan bahwa :</td> 
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <tr>
                                <td style="vertical-align:top">1.</td>
                                <td style="text-align:justify">Saya telah membaca penjelasan secara teliti tentang tindakan anestesia yang diberikan, mengerti dan menyetujui penjelasan tentang tindakan yang akan dilakukan termasuk kemungkinan komplikasi yang mungkin terjadi serta kelebihan atau kelemahan dari setiap jenis pilihan pembiusan yang dapat dilakukan, serta telah diberikan kesempatan untuk bertanya dan berdiskusi dengan dokter</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">2.</td>
                                <td style="text-align:justify">Saya menyadari bahwa pelayanan di rumah sakit ini merupakan suatu kerja team (termasuk dokter dan perawat anestesi) dan bahwasanya anestesi untuk tindakan operasi ini akan dilakukan di bawah pengawasan dokter <?php echo!empty($model->dokteranestesi_id) ? $model->dokteranestesi->namaLengkap : ''; ?></td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">3.</td>
                                <td style="text-align:justify">Saya mengerti bahwa tindakan anestesi mengandung beberapa risiko, termasuk perubahan tekanan darah, reaksi obat (alergi), henti jantung, kerusakan otak, kelumpuhan, kerusakan saraf serta kompilasi lain yang juga mungkin terjadi, bahkan kematian</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">4.</td>
                                <td style="text-align:justify">Saya menyadari dan mengerti bahwa ilmu kedokteran (termasuk anestesi) bukan merupakan ilmu pengetahuan yang pasti dalam praktiknya, sehingga tidak ada seorang pun yang dapat menjanjikan atau menjamin sesuatu yang berhubungan dengan praktik ilmu kedokteran (termasuk anestesi)</td>
                            </tr>
                            <tr>
                                <td style="vertical-align:top">5.</td>
                                <td style="text-align:justify">Saya mempunyai kewajiban untuk memberikan kepada dokter mengenai semua penyakit dan obat yang saya/pasien minum seperti aspirin, pengencer darah, kontrasepsi, obat-obat flu, narkotika, marijuana, kokain dan lain-lain, mengingat hal-hal tersebut dapat menimbulkan kompilasi bagi anestesi maupun pembedahan</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:justify">
                        Berdasarkan hal-hal tersebut di atas, saya menjamin sepenuhnya bahwa tindakan saya untuk menyetujui tindakan anestesia di atas adalah untuk mewakili kepentingan saya/pasien dan keluarga pasien, dan saya bertanggung jawab sepenuhnya apabila terdapat pihak lain yang mengajukan keberatan atas persetujuan ini.
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:justify">
                        Demikian surat persetujuan ini dibuat dengan penuh kesadaran dan tanpa paksaan dari pihak manapun juga
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:justify">
                        <table width="100%" id="persetujuan">
                            <tr>
                                <td></td>
                                <td style="text-align:center">Surabaya, <?php echo !empty($model->pasien_id) ? date('d ').MyFormatter::getMonthId(date('m')).date(' Y') : '' ?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align:center">Yang membuat pernyataan,</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align:center"><?php echo $model->hubungan_pembuatpernyataan; ?></td>
                                <td></td>
                                <td style="text-align:center">Saksi Pihak Keluarga,</td>
                            </tr>
                            <tr>
                                <td style="height:80px;"></td>
                                <td style="text-align:center; vertical-align: bottom"><?php echo $model->namapenanggungjawab ?></td>
                                <td style="height:80px;"></td>
                                <td style="text-align:center; vertical-align: bottom;"><?php echo $model->nama_pihakkeluarga; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align: center">No. KTP/SIM : <?php echo $model->noidentitas_penanggungjawab ?></td>
                                <td></td>
                                <td style="text-align: center">No. KTP/SIM : <?php echo $model->noidentitas; ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="text-align:center">Dokter,</td>
                                <td></td>
                                <td style="text-align:center">Saksi Pihak RS,</td>
                            </tr>
                            <tr>
                                <td style="height:80px;"></td>
                                <td style="text-align:center; vertical-align: bottom;"><?php echo!empty($model->dokteranestesi_id) ? $model->dokteranestesi->namaLengkap : ''; ?></td>
                                <td style="height:80px;"></td>
                                <td style="text-align:center; vertical-align: bottom;"><?php echo!empty($model->saksipihakrs_id) ? $model->saksipihakrs->namaLengkap : ''; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>          
        </td>
    </tr>
</table>
