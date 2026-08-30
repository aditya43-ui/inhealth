
<style>
    .boldmerah{
		color:#d80000;
		font-weight:bold;
	}

    .lab_kes_main {
        width: 100%;
        font-size: 8pt;
        vertical-align: top;
        margin-top: 10px;
        border-collapse: collapse;
    }

    .lab_kes_main td {
        border: 1px solid black;
        padding: 5px;
    }

    .tab_senter td {
        text-align: center;
    }
</style>
<div class="anamnesis_judul">PEMERIKSAAN LABORATORIUM</div>
    <?php

    // echo $this->renderPartial('application.views.headerReport.headerPrint',array('judulLaporan'=>$judulLaporan, 'colspan'=>7)); 
    $no_urut = 1;
    $class='';
    ?>
    <table width="100%" class="anamnesa_content">
                        <tr>
                            <td><?php echo $modKunjungan->getAttributeLabel('no_pendaftaran') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->no_pendaftaran ?></td>
                            <td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->no_rekam_medik ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modKunjungan->getAttributeLabel('tgl_pendaftaran') ?></td>
                            <td>:</td>
                            <td><?php echo $modKunjungan->tgl_pendaftaran ?></td>
                            <td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->namadepan . " " . $modKunjungan->nama_pasien ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modKunjungan->getAttributeLabel('no_masukpenunjang') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->no_masukpenunjang ?></td>
                            <td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') . '/' . $modKunjungan->getAttributeLabel('umur') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->tanggal_lahir . '/ ' . CustomFunction::getUmur(MyFormatter::formatDateTimeForDb($modKunjungan->tanggal_lahir)); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modKunjungan->getAttributeLabel('tglmasukpenunjang') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->tglmasukpenunjang ?></td>
                            <td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->jeniskelamin ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modKunjungan->getAttributeLabel('ruangan_nama') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->ruangan_nama ?></td>
                            <td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td>
                            <td>:</td>
                            <td> <?php echo $modKunjungan->alamat_pasien ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modHasilPemeriksaan->getAttributeLabel('nohasilperiksalab') ?></td>
                            <td>:</td>
                            <td> <?php echo $modHasilPemeriksaan->nohasilperiksalab; ?></td>
                            <td>
                                Dokter Perujuk
                                <?php //echo $modHasilPemeriksaan->getAttributeLabel('diagnosaket_klinik') 
                                ?></td>
                            <td>:</td>
                            <td> <?php echo (!empty($modHasilPemeriksaan->pendaftaran->pegaw) ? $modHasilPemeriksaan->pendaftaran->pegawai->namaLengkap : '') ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $modHasilPemeriksaan->getAttributeLabel('tglhasilpemeriksaanlab') ?></td>
                            <td>:</td>
                            <td> <?php echo $format->formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab); ?></td>
                        </tr>
                    </table>
	<br>
	<br>
    <?php
    foreach ($data as $dt1) {
    ?>
        <h6 style="color:#b75858"><?php echo $dt1['jenispemeriksaanlab_nama']; ?></h6>
        <table class="anamnesa_content anamnesa_border">
                <tr bgcolor="#e5e5e5">
                    <!--th width="25%">Nama Pemeriksaan</th -->
                    <th width="20%">Pemeriksaan</th>
                    <th width="20%" style="text-align:center;" colspan="2">Hasil</th>
                    <th width="20%" style="text-align:center;">Satuan</th>
                    <th width="20%" style="text-align:center;">Nilai Rujukan</th>
                    <th width="20%" style="text-align:center;">Metode</th>
                </tr>
                <?php
                foreach ($dt1['pemeriksaanlab'] as $dt2) {

                    $a = 1;
                    $i = 1;
                    $b = 1;
                    foreach ($dt2['kelompokdet'] as $dt3) {
                        if (count((array)$dt3['nilairujukan']) > 1) {
                            
                ?>
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
    <table class="lab_kes_main">
        <tr>
            <td>
                <?php echo $modHasilPemeriksaan->getAttributeLabel('catatanlabklinik') ?> :<br>
                <div class="lab_kes">                
                <?php echo $modHasilPemeriksaan->catatanlabklinik; ?>
                </div>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $modHasilPemeriksaan->getAttributeLabel('kesimpulan') ?> :<br>
                <div class="lab_kes">                
                <?php echo $modHasilPemeriksaan->kesimpulan; ?>
                </div>
                </div><br>
            </td>
        </tr>
    </table>
    <br/><br/><br/><br/>
    <table class="anamnesa_content tab_senter">
            <tr>

                <td><?php echo Yii::app()->user->getState('kabupaten_nama') ?>, <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')); ?></td>
            </tr>
            <tr>
                <td width="250"> <br>Dokter Penanggung Jawab,</td>
                <td> </td>
                <td width="250"> <br>Analis Laboratorium,</td>

            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td style="text-decoration: underline;"><?php echo $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama; ?></td>
                <td> </td>
                <td style="text-decoration: underline;"><?php
                                                        $peg = PegawaiM::model()->findByPk(Yii::app()->user->getState("pegawai_id"));

                                                        if (!empty($peg)) {
                                                            echo    $peg->namaLengkap;
                                                        } else {
                                                            //echo Yii::app()->user->getState("nama_pegawai"); 
                                                        }
                                                        ?></td>

            </tr>
    </table>





