<!--div class="white-container"-->

<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
// echo $this->renderPartial('application.views.headerReport.headerDefaultLabV2',array('judulLaporan'=>$judulLaporan, 'colspan'=>3)); 
$no_urut = 1;
$class = '';
if (isset($_GET['frame'])) {
    $class = "table table-striped";
}


?>
<style>
    body {
        padding: 10px;
    }

    h5 {
        line-height: 5px !important;
    }

    h6 {
        line-height: 5px !important;
    }

    .boldmerah {
        color: #d80000;
        font-weight: bold !important;
    }
</style>
<?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array()); 
?>
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultLabCiputat', array()); ?>
<table style="width: 100%; border: none;">
    <!-- <thead>
        <tr>
             <td>
                <div class="header">
                    <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array()); 
                    ?>
                </div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> -->
    <div class="content">
        

        <table width="100%" class="paddingtext2">
            <tr>
                <td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td>
                <td>:</td>
                <td> <?php echo $modKunjungan->no_rekam_medik ?></td>

                <td><?php echo $modKunjungan->getAttributeLabel('tgl_pendaftaran') ?></td>
                <td>:</td>
                <td><?php echo $modKunjungan->tgl_pendaftaran ?></td>
            </tr>
            <tr>
                <td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td>
                <td>:</td>
                <td> <?php echo $modKunjungan->namadepan . " " . $modKunjungan->nama_pasien ?></td>

                <td><?php echo $modKunjungan->getAttributeLabel('no_masukpenunjang') ?></td>
                <td>:</td>
                <td> <?php echo $modKunjungan->no_masukpenunjang ?></td>
            </tr>
            <tr>
                <td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td>
                <td>:</td>
                <td> <?php echo $modKunjungan->jeniskelamin ?></td>

                <td><?php echo $modKunjungan->getAttributeLabel('tglmasukpenunjang') ?></td>
                <td>:</td>
                <td> <?php echo $modKunjungan->tglmasukpenunjang ?></td>
            </tr>
            <tr>
                <td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') . '/' . $modKunjungan->getAttributeLabel('umur') ?></td>
                <td>:</td>
                <td> <?php echo $modKunjungan->tanggal_lahir . '/ ' . CustomFunction::getUmur(MyFormatter::formatDateTimeForDb($modKunjungan->tanggal_lahir)); ?></td>

                <td>Instalasi Asal</td>
                <td>:</td>
                <td> <?php echo $modKunjungan->instalasiasal_nama ?></td>
            </tr>
            <tr>
                <td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td>
                <td>:</td>
                <td> <?php echo $modKunjungan->alamat_pasien ?></td>

                <td>Ruangan Asal</td>
                <td>:</td>
                <td> <?php echo $modKunjungan->ruanganasal_nama ?></td>
    
            </tr>
            <tr>
                <td>
                    Dokter Pengirim
                </td>
                <td>:</td>
                <td> <?php echo (!empty($modHasilPemeriksaan->pendaftaran->pegawai) ? $modHasilPemeriksaan->pendaftaran->pegawai->namaLengkap : '') ?></td>
                <td><?php echo $modHasilPemeriksaan->getAttributeLabel('nohasilperiksalab') ?></td>
                <td>:</td>
                <td> <?php echo $modHasilPemeriksaan->nohasilperiksalab; ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $modHasilPemeriksaan->getAttributeLabel('tglhasilpemeriksaanlab') ?></td>
                <td>:</td>
                <td> <?php echo $format->formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Dokter Penanggung Jawab</td>
                <td>:</td>
                <td> <?php echo $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama; ?></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <br>
        <div>
            Hasil : 
        </div>
        <style>
            table thead th {
                background-color: #a9ccff;
            }
        </style>
        <table class="table border paddingtext2">
            <thead>
                <th>Jenis Pemeriksaan</th>
                <th>Hasil</th>
                <th>Satuan</th>
                <th>Nilai Rujukan Dewasa Normal</th>
                <th>Keterangan</th>
            </thead>
            <tbody>
                <?php $authorization_user = ''; ?>
                <?php if(!empty($modHasilLis)) { ?>
                    <?php foreach($modHasilLis as $i => $val) : ?>
                        <?php $authorization_user = $val->authorization_user . ' ' . MyFormatter::formatDateTimeForUser($val->authorization_date); ?>
                        <tr>
                            <td><?= $val->test_name ?></td>
                            <td><?= $val->result ?></td>
                            <td><?= $val->test_units_name ?></td>
                            <td><?= $val->reference_value ?></td>
                            <td><?= $val->reference_note ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
        </table>
        <?php
        foreach ($data as $dt1) {
        ?>
            <br>
            <h6 style="color:#b75858"><?php $dt1['jenispemeriksaanlab_nama']; ?></h6>
            <table class="table border paddingtext2 hide">
                <!-- <thead> -->
                <!-- <br> -->
                <tr bgcolor="#e5e5e5">
                    <!--th width="25%">Nama Pemeriksaan</th -->
                    <th width="20%">Pemeriksaan</th>
                    <th width="20%" style="text-align:center;" colspan="2">Hasil</th>
                    <th width="20%" style="text-align:center;">Satuan</th>
                    <th width="20%" style="text-align:center;">Nilai Rujukan</th>
                    <th width="20%" style="text-align:center;">Metode</th>
                </tr>
                <!-- </thead> -->
                <?php
                foreach ($dt1['pemeriksaanlab'] as $dt2) {

                    $a = 1;
                    $i = 1;
                    $b = 1;
                    foreach ($dt2['kelompokdet'] as $dt3) {
                        if (count((array)$dt3['nilairujukan']) > 1) {
                            
                ?>
                            <tbody>
                                <tr>

                                    <!-- td style="border-bottom:white 1px solid !important;">
                                        <?php /* 
                                        if ($i == 1) {
                                            echo $dt2['pemeriksaanlab_nama'];
                                        } */

                                        ?>
                                    </td -->
                                    <td colspan="3">
                                        <?php echo $dt3['kelompokdet'] . ' :    '; ?>
                                    </td>
                                </tr>
                            <?php
                        }
                        $j = 1;
                        foreach ($dt3['nilairujukan'] as $dt4) {
                            if (count((array)$dt2['kelompokdet']) == $b) {
                                if (count((array)$dt3['nilairujukan']) > 1) {
                                    if (count((array)$dt3['nilairujukan']) == $j) {
                                        $border = 'border-bottom:1px solid #000 !important;';
                                    } else {
                                        $border = 'border-bottom:1px solid #fff !important;';
                                    }
                                } else {
                                    $border = 'border-bottom:1px solid #000 !important;';
                                }
                            } else {
                                $border = 'border-bottom:1px solid #fff !important;';
                            }
                            ?>
                                <?php if ($dt4['tipe'] == 'ST') { ?>
                                <tr>
                                    <td colspan="6"><strong><?php echo $dt4['namapemeriksaandet']; ?></strong></td>
                                </tr>
                                <?php 
                                    continue;
                                } ?>
                                <tr>

                                    <!-- td style="<?php echo $border; ?>">
                                        <?php /*
                                        if ($i == 1) {

                                            echo $dt2['pemeriksaanlab_nama'];
                                        } else {
                                        }
                                        */
                                        ?>
                                    </td -->
                                    <td>
                                        <?php
                                            echo "&nbsp;&nbsp;&nbsp;&nbsp;";
                                            echo $dt4['namapemeriksaandet'];
                                        ?>
                                    </td>
                                    <td style="text-align:center;" width="10%">
                                        <?php echo $dt4['status']; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php
                                        $spanclass = '';
                                        $ubahData = '';
                                        if (!empty($dt4['status'])) {
                                            if ($dt4['status'] != 'N') {
                                                $spanclass = 'boldmerah';
                                            }
                                        } else if (trim($dt4['nilairujukan']) != '-') {

                                            if ($dt4['nilairujukan'] != '') {
                                                if (($dt4['nilaimin'] != 0 || $dt4['nilaimax'] != 0)) {

                                                    $hasil = str_replace('.', '.', $dt4['hasilpemeriksaan']);
                                                    $hasil = str_replace(',', '.', $hasil);
                                                    //var_dump($hasil);							
                                                    if (($hasil < $dt4['nilaimin']) || ($hasil > $dt4['nilaimax'])) {
                                                        $spanclass = 'boldmerah';
                                                    } else {
                                                    }
                                                } else {
                                                    $cekNilai = Params::hasilDetLabTextNumber(strtolower($dt4['namapemeriksaandet']));
                                                    if (!empty($cekNilai)) {
                                                        if ($cekNilai == 2) {
                                                            $nilaiRujuk = $dt4['nilairujukan'];
                                                            $nilaiPecah1 = explode('/', $nilaiRujuk);

                                                            $nilai1 = array();
                                                            foreach ($nilaiPecah1 as $idx => $p) {
                                                                $nilaiPecah2 = explode('-', $p);

                                                                $nilai1[$idx] = array(
                                                                    'min' => isset($nilaiPecah2[0]) ? trim($nilaiPecah2[0]) : null,
                                                                    'max' => isset($nilaiPecah2[1]) ? trim($nilaiPecah2[1]) : null
                                                                );
                                                            }

                                                            $hsl = $dt4['hasilpemeriksaan'];
                                                            $pecah1 = explode('/', $dt4['hasilpemeriksaan']);

                                                            $nilai2 = array();
                                                            foreach ($pecah1 as $idx => $p) {
                                                                $nilai2[$idx] = $p;
                                                            }

                                                            $g = 0;
                                                            foreach ($nilai1 as $idx => $sh) {
                                                                if (isset($nilai2[$idx])) {
                                                                    $hasil = str_replace('.', '.', $nilai2[$idx]);

                                                                    $hasil = str_replace(',', '.', $hasil);

                                                                    if (count((array)$nilai1) > 0) {
                                                                        if ($g > 0) {
                                                                            $ubahData .= '/';
                                                                        }
                                                                    }

                                                                    if (($hasil < $sh['min']) || ($hasil > $sh['max'])) {
                                                                        $spanclass = 'ubah';
                                                                        $ubahData .= '<span class="boldmerah">' . $hasil . '</span>';
                                                                    } else {
                                                                        $ubahData .= '<span class="">' . $hasil . '</span>';
                                                                    }

                                                                    $g++;
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $dt4['nilairujukan'] = str_replace("'", "", $dt4['nilairujukan']);
                                                        $dt4['nilairujukan'] = str_replace('"', "", $dt4['nilairujukan']);
                                                        if (strtolower(trim($dt4['hasilpemeriksaan'])) != strtolower(trim($dt4['nilairujukan']))) {
                                                            // $spanclass='boldmerah';
                                                            $spanclass = '';
                                                        }
                                                    }
                                                }
                                            }
                                        }



                                        echo "<span class='" . $spanclass . "'>";
                                        if ($spanclass == 'ubah') {
                                            echo $ubahData;
                                        } else {
                                            echo $dt4['hasilpemeriksaan'];
                                        }
                                        echo "</span>"
                                        ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $dt4['satuan']; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $dt4['nilairujukan']; ?>
                                    </td>
                                    <td style="text-align:center;">
                                        <?php echo $dt4['metode']; ?>
                                    </td>
                                </tr>
                            </tbody>


                <?php
                            $i++;
                            $j++;
                        }

                        $b++;
                    }
                } ?>
            </table>
        <?php
        }
        ?>
       

        <?php /*
        <table width="100%" class="paddingtext2">
            <tr>
                <td><br>
                    <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('catatanlabklinik') ?> :<br>
                        <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 100%;float:left;border-color: black;'>
                            <?php echo $modHasilPemeriksaan->catatanlabklinik; ?>
                        </div>
                </td>
            </tr>
            <tr>
                <td><br>
                    <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('kesimpulan') ?> :<br>
                        <div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 100%;float:left;border-color: black;'>
                            <?php echo $modHasilPemeriksaan->kesimpulan; ?>
                        </div>
    </div><br>
    </td>
    </tr>
</table>
        */ ?>


<?php
if (isset($_GET['frame']) && $_GET['frame'] == 1) {
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printHasil();'));
} else {
}
?>

<!--/div-->
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
    <?php
    $dok = "Dokter Pemeriksa,";
    $layoutkiri = "Hasil sudah divalidasi secara elektronik tidak perlu tanda tangan";
    ?>
    <table width="100%" class="footer">
        <tr>
            <td width="50%" style="text-align:left" align="left" class="">
                <?php echo  $layoutkiri ?>
            </td>
            <td class="" style="text-align:right" width="50%" align="right">
                <?php
               
                if (!empty($modKunjungan)) {
                    echo $dok . ' ' . $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama;
                } else {
                    //echo Yii::app()->user->getState("nama_pegawai"); 
                } ?>
                <br>
                <?php echo 'Autorizhed By : ' . $authorization_user ?>
            </td>
        </tr>

    </table>
</div>
<?php if (empty($caraPrint)) : ?>
    <script>
        /**
         * print hasil pemeriksaan 
         */
        function printHasil() {
            var pasienmasukpenunjang_id = <?php echo $_GET['pasienmasukpenunjang_id']; ?>;
            if (pasienmasukpenunjang_id != "") {
                <?php if ($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) { ?>
                    window.open('<?php echo $this->createUrl('/laboratorium/pencatatanHasilPemeriksaan/print'); ?>&pasienmasukpenunjang_id=' + pasienmasukpenunjang_id, 'printwin', 'left=100,top=0,width=768,height=640');
                <?php } else if ($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) { ?>
                    window.open('<?php echo $this->createUrl('/laboratorium/pencatatanHasilPemeriksaan/printPA'); ?>&pasienmasukpenunjang_id=' + pasienmasukpenunjang_id, 'printwin', 'left=100,top=0,width=1024,height=640');
                <?php } ?>
            } else {
                myAlert("Silakan pilih data kunjungan pasien!");
            }
        }
    </script>
<?php endif; ?>