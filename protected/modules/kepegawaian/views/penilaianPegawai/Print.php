
<style>

    .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
        border-spacing: 0;
        padding: 0;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judul_print));
                   
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table class="table noborder">
                        <tr>
                            <td><b>Nama</b></td>
                            <td><b>:</b></td>
                            <td><?php echo $modPenilaianPegawai->pegawai->namaLengkap ?></td>
                            <td>&nbsp;</td>
                            <td><b>Status</b></td>
                            <td><b>:</b></td>
                            <td><?php echo $modPenilaianPegawai->pegawai->kategoripegawai; //echo $modPenilaianPegawai->pegawai->namaLengkap    ?></td>
                        </tr>
                        <tr>
                            <td><b>Unit</b></td>
                            <td><b>:</b></td>
                            <td><?php
                                echo!empty($modPenilaianPegawai->pegawai->unitkerja_id) ? $modPenilaianPegawai->pegawai->unitkerja->namaunitkerja : '-';
                                ?></td>
                            <td>&nbsp;</td>
                            <td><b>Periode Penilaian</b></td>
                            <td><b>:</b></td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($modPenilaianPegawai->periodepenilaian) . ' s/d ' . MyFormatter::formatDateTimeForUser($modPenilaianPegawai->sampaidengan) ?></td>
                        </tr>
                        <tr>
                            <td><b>Jabatan</b></td>
                            <td><b>:</b></td>
                            <td><?php echo!empty($modPenilaianPegawai->pegawai->jabatan_id) ? $modPenilaianPegawai->pegawai->jabatan->jabatan_nama : '-' ?></td>
                            <td>&nbsp;</td>		
                        </tr>
                    </table>
                    <br><br>

                    <?php
                    $table = $generateTable;
                    $a = 1;
                    $d = 0;
                    $jmlAspekPenilaian = array();
                    foreach ($table as $dt) {
                        ?>   

                        <ol style="list-style-type: upper-alpha;font-weight: bold;margin: 0;padding: 0;" start="<?php echo $a ?>">
                            <li><b><?php echo $dt['jenispenilaian'] ?></b></li>
                        </ol>
                        <table class="table border" width="100%" id="">                         
                            <tr>
                                <th>NO</th>
                                <th>ASPEK PENILAIAN</th>
                                <th width="10%">NILAI</th>
                                <th width="15%">NAMA NILAI</th>
                                <th>KETERANGAN</th>
                            </tr>

                            <?php
                            $b = 1;
                            $grandTotal = 0;
                            $grandRata = 0;
                            $grandAspek = 0;
                            $data[$dt['jenispenilaian_id']] = 0;
                            foreach ($dt['kompetensi'] as $dt2) {
                                ?>
                                <tr>
                                    <td>
                                        <ol style="padding: 0;margin: 0;" start="<?php echo $b; ?>">
                                            <li>&nbsp;</li>
                                        </ol>                                            
                                    </td>
                                    <td colspan="4"><?php echo $dt2['kompetensi_nama']; ?></td>

                                </tr>
                                <?php
                                $c = 1;
                                $subTotal = 0;
                                $subRata = 0;
                                $countIndikator = 0;
                                $subAspek = 0;

                                foreach ($dt2['indikator'] as $dt3) {
                                    $subTotal = $subTotal + $dt3['nilai'];
//            $subRata = number_format($subTotal / count((array)$dt2['indikator']), 2); //RSPMC-686
                                    $countIndikator = $countIndikator + $dt3['bobotnilai_indikator'];
                                    $subRata = number_format($subTotal / $countIndikator, 2);
                                    ?>
                                    <tr id="<?php echo $dt['jenispenilaian_id'] . '-' . $dt2['kompetensi_id'] . '-' . $c; ?>">
                                        <td></td>
                                        <td>
                                            <ol style="list-style-type: lower-alpha;padding: 0;margin: 0;" start="<?php echo $c; ?>">
                                                <li><?php echo $dt3['indikatorperilaku_nama']; ?></li>
                                            </ol>                                            
                                        </td>
                                        <td style="text-align:right;">
                                            <?php echo $dt3['nilai'] ?>
                                        </td>
                                        <td>
                                            <?php echo $dt3['namanilai'] ?>
                                        </td>
                                        <td>                                        
                                            <?php echo $dt3['keterangan'] ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $c++;
                                    $d++;
                                }
                                $grandRata = number_format($grandRata + $subRata, 2);
                                $grandTotal = $grandTotal + $subTotal;
                                $subAspek = $subRata * ($dt['bobot_penilaian'] / 100);
                                array_push($jmlAspekPenilaian, $subAspek);
                                ?>
                                <tr>
                                    <td colspan="2" style="text-align:right;"><b>Sub Jumlah</b></td>
                                    <td style="text-align:right;"><?php echo $subTotal; ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:right;"><b>Rata - Rata <?php echo $b ?></b></td>
                                    <td style="text-align:right;"><?php echo number_format($subRata, 2); ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:right;"><b>Nilai Aspek <?php echo $b ?></b></td>
                                    <td style="text-align:right;"><?php echo number_format($subAspek, 2); ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <?php
                                $b++;
                            }

                            if (count((array)$dt['kompetensi']) > 1) {
                                ?>                
                                <tr>
                                    <td colspan="2" style="text-align:right;"><b>Total Jumlah</b></td>
                                    <td style="text-align:right;"><?php echo $grandTotal; //CHtml::textField("totalJumlah".$dt['jenispenilaian_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;'))   ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align:right;"><b> Total Rata - Rata</b></td>
                                    <td style="text-align:right;"><?php echo number_format($grandRata / count((array)$dt['kompetensi']), 2); //CHtml::textField("totalRataRata".$dt['jenispenilaian_id'],'',array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;'))    ?></td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            <?php } ?>
                        </table>
                        <p>&nbsp;</p>
                        <?php
                        $data[$dt['jenispenilaian_id']] = number_format($grandRata / count((array)$dt['kompetensi']), 2);
                        $a++;
                    }
                    ?>

                    <table>
                        <tr>
                            <th><u>Keterangan Nilai</u></th>
                        </tr>	
                        <?php
                        $j = 1;
                        $forNilai = $ketNilai;
                        foreach ($ketNilai as $nl) {
                            ?>	
                            <tr>
                                <td><?php echo $nl->kolomrating_namalevel; ?></td>
                                <td> : &nbsp;&nbsp;</td>
                                <td>
                                    <?php
                                    if ($j == count((array)$ketNilai)) {
                                        echo 'Kurang dari ' . ($nl->kolomrating_nilaiakhir + 1);
                                        echo CHtml::hiddenField("ketNilai-" . $j, '', array('min' => $nl->kolomrating_nilaiawal, 'max' => $nl->kolomrating_nilaiakhir, 'keterangan' => $nl->kolomrating_namalevel));
                                    } else {
                                        echo $nl->kolomrating_nilaiawal;
                                        ?> - <?php
                                        echo $nl->kolomrating_nilaiakhir;
                                        echo CHtml::hiddenField("ketNilai-" . $j, '', array('min' => $nl->kolomrating_nilaiawal, 'max' => $nl->kolomrating_nilaiakhir, 'keterangan' => $nl->kolomrating_namalevel));
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                        }
                        ?>
                    </table>
                    <p>&nbsp;</p>
                    <b><h6 style="color:#333;">Total Nilai</h6></b>
                    <table class="table border" width="100%" id="">
                        <tr>
                            <th>NO</th>
                            <th>Aspek Penilaian</th>
                            <th style="text-align: center;" width="10%">Jumlah</th>
                            <th style="text-align: center;" width="10%">Nama Nilai</th>
                            <th>Keterangan</th>
                        </tr>
                        <?php
                        $no = 1;
                        $totalSeluruh = 0;
                        $totalAspekAll = 0;
                        $keterangan = explode('{{aspek}}', $modPenilaianPegawai->penilaianpegawai_keterangan);
                        foreach ($table as $jns) {
                            $totalSeluruh = number_format($totalSeluruh + $data[$jns['jenispenilaian_id']], 2);

                            foreach ($forNilai as $sc) {
                                $dataJns = number_format($data[$jns['jenispenilaian_id']], 0);
                                if (($dataJns >= $sc->kolomrating_nilaiawal) AND ( $dataJns <= $sc->kolomrating_nilaiakhir)) {
                                    $namaNilai = $sc->kolomrating_uraian;
                                }

                                if ((ceil($totalSeluruh / count((array)$table)) >= $sc->kolomrating_nilaiawal) AND ( ceil($totalSeluruh / count((array)$table)) <= $sc->kolomrating_nilaiakhir)) {
                                    $ketNilai = $sc->kolomrating_uraian;
                                }
                            }
                            $totalAspekAll += $jmlAspekPenilaian[$no - 1];
                            ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?php echo $jns['jenispenilaian']; ?></td>
                                <td style="text-align: right;">
                                    <?php
//                    echo $data[$jns['jenispenilaian_id']]; 
                                    echo number_format($jmlAspekPenilaian[$no - 1], 2);
                                    ?>
                                </td>
                                <td ><?php echo $namaNilai; ?></td>
                                <!--<td ><?php //echo CHtml::textArea("statusKet-".$jns['jenispenilaian_id'], '',array('readonly'=>true,'class'=>'autorow')); ?></td>-->
                                <td><?php echo $keterangan[$no - 1]; //echo CHtml::activeTextArea($model, 'penilaianpegawai_keterangan['.($no-1).']',array('class' => 'autogrow'))    ?></td>
                            </tr>
                            <?php
                            $no++;
                        }
                        ?>	
                        <tr>
                            <td></td>
                            <td style="text-align:right;">Total</td>
                            <td style="text-align: right;">
                                <?php
//                echo $totalSeluruh; //echo CHtml::activeTextField($model, 'jumlahpenilaian', array('readonly'=>true, 'style' => 'text-align:right;'));//echo CHtml::textField("grandTotal",'',array('readonly'=>true, 'style' => 'text-align:right;'));  
                                echo number_format($totalAspekAll, 2);
                                ?>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="display:none;">
                            <td></td>
                            <td style="text-align:right;">Rata - rata</td>
                            <!--<td><?php //echo //$totalSeluruh//count((array)$table);//echo CHtml::textField("grandAverage",'',array('readonly'=>true, 'style' => 'text-align:right;')); ?></td>-->
                            <td style="text-align: right;">
                                <?php
//                echo floor(($totalSeluruh / count((array)$table) * 100)) / 100//echo CHtml::activeTextField($model, 'nilairatapenilaian', array('readonly'=>true, 'style' => 'text-align:right;'));//echo CHtml::textField("grandTotal",'',array('readonly'=>true, 'style' => 'text-align:right;'));  
                                echo number_format($totalAspekAll, 2);
                                ?>
                            </td>
                            <td ><?php echo $ketNilai; ?></td>
                            <td ><?php //echo CHtml::textArea("statusTotal", '',array('readonly'=>true,'class'=>'autorow')); ?></td>
                        </tr>
                    </table>

                    <table class="border table">
                        <tr>
                            <td>
                                Rekomendasi dari hasil penilaian : <br>
                                <?php echo $modPenilaianPegawai->rekomendasi ?>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Catatan : <br>
                                <?php echo $modPenilaianPegawai->catatan; ?>
                                <br>
                                <br>
                                <br>
                            </td>
                        </tr>
                    </table>

                    <table class="table noborder">
                        <tr>
                            <td colspan="3" style="text-align:center;">Jombang, <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d')); ?></td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr style="text-align:center;">
                            <td style="text-align:center;">Atasan Penilai</td>
                            <td style="text-align:center;">Penilai</td>
                            <td style="text-align:center;">Pegawai</td>
                        </tr>
                        <tr style="text-align:center;">
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr style="text-align:center;">
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr style="text-align:center;">
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;"><?php echo '(' . $modPenilaianPegawai->pimpinannama . ')'; ?></td>
                            <td style="text-align:center;"><?php echo '(' . $modPenilaianPegawai->penilainama . ')'; ?></td>
                            <td style="text-align:center;"><?php echo '(' . $modPenilaianPegawai->pegawai->namaLengkap . ')'; ?></td>
                        </tr>

                    </table>
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
</div>
<div class="footer">

    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div>   
