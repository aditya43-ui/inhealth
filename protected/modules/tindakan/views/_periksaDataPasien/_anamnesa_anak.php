<div style="text-align: center">RIWAYAT VAKSINASI</div>
<?php

$riwayat = CJSON::decode($modAnamnesa->riwayat_vaksinasi);
// var_dump($riwayat); die;

?>
<table class="tab_vaksinasi">
                <tr>
                    <th rowspan="2">Jenis</th>
                    <th rowspan="2" width='50'>1</th>
                    <th rowspan="2" width='50'>2</th>
                    <th rowspan="2" width='50'>3</th>
                    <th colspan="3">Booster</th>
                </tr>
                <tr>
                    <th width='50'>1</th>
                    <th width='50'>2</th>
                    <th width='50'>3</th>
                </tr>
                <tr>
                    <td>BCG</td>
                    <td><?php echo !empty($riwayat['bcg'][1]) ? $riwayat['bcg'][1] : ""; ?></td>
                    <td colspan="2"><?php echo !empty($riwayat['bcg'][2]) ? $riwayat['bcg'][2] : ""; ?></td>
                    <td colspan="3"><?php echo !empty($riwayat['bcg']['booster'][1]) ? $riwayat['bcg']['booster'][1] : ""; ?></td>
                </tr>
                <tr>
                    <td>DPT</td>
                    <td><?php echo !empty($riwayat['dpt'][1]) ? $riwayat['dpt'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['dpt'][2]) ? $riwayat['dpt'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['dpt'][3]) ? $riwayat['dpt'][3] : ""; ?></td>
                    <td><?php echo !empty($riwayat['dpt']['booster'][1]) ? $riwayat['dpt']['booster'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['dpt']['booster'][2]) ? $riwayat['dpt']['booster'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['dpt']['booster'][3]) ? $riwayat['dpt']['booster'][3] : ""; ?></td>
                </tr>
                <tr>
                    <td>Polio</td>
                    <td><?php echo !empty($riwayat['polio'][1]) ? $riwayat['polio'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['polio'][2]) ? $riwayat['polio'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['polio'][3]) ? $riwayat['polio'][3] : ""; ?></td>
                    <td><?php echo !empty($riwayat['polio']['booster'][1]) ? $riwayat['polio']['booster'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['polio']['booster'][2]) ? $riwayat['polio']['booster'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['polio']['booster'][3]) ? $riwayat['polio']['booster'][3] : ""; ?></td>
                </tr>
                <tr>
                    <td>Campak</td>
                    <td colspan="3"><?php echo !empty($riwayat['campak'][1]) ? $riwayat['campak'][1] : ""; ?></td>
                    <td colspan="3"><?php echo !empty($riwayat['campak']['booster'][1]) ? $riwayat['campak']['booster'][1] : ""; ?></td>
                </tr>
                <tr>
                    <td>MMR</td>
                    <td colspan="3"><?php echo !empty($riwayat['mmr'][1]) ? $riwayat['mmr'][1] : ""; ?></td>
                    <td colspan="3"><?php echo !empty($riwayat['mmr']['booster'][1]) ? $riwayat['mmr']['booster'][1] : ""; ?></td>
                </tr>
                <tr>
                    <td>HB</td>
                    <td><?php echo !empty($riwayat['hb'][1]) ? $riwayat['hb'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['hb'][2]) ? $riwayat['hb'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['hb'][3]) ? $riwayat['hb'][3] : ""; ?></td>
                    <td><?php echo !empty($riwayat['hb']['booster'][1]) ? $riwayat['hb']['booster'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['hb']['booster'][2]) ? $riwayat['hb']['booster'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['hb']['booster'][3]) ? $riwayat['hb']['booster'][3] : ""; ?></td>
                </tr>
                <tr>
                    <td>Lain2</td>
                    <td><?php echo !empty($riwayat['lain2'][1]) ? $riwayat['lain2'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['lain2'][2]) ? $riwayat['lain2'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['lain2'][3]) ? $riwayat['lain2'][3] : ""; ?></td>
                    <td><?php echo !empty($riwayat['lain2']['booster'][1]) ? $riwayat['lain2']['booster'][1] : ""; ?></td>
                    <td><?php echo !empty($riwayat['lain2']['booster'][2]) ? $riwayat['lain2']['booster'][2] : ""; ?></td>
                    <td><?php echo !empty($riwayat['lain2']['booster'][3]) ? $riwayat['lain2']['booster'][3] : ""; ?></td>
                </tr>
                
            </table>
<br>
<table width='100%' class='form_anak'>
    <tr>
        <td colspan='3' width='50%'>
            <div style="text-align: center">KEBIASAAN</div>
            <table width='100%'>
                <tr>
                    <td width='130'>Menghisap Jari</td>
                    <td width='10'>:</td>
                    <td><?php echo $modAnamnesa->kebiasaan_menghisap_jari ? "Ya" : "Tidak" ?></td>
                </tr>
                <tr>
                    <td>Pakai Dot</td>
                    <td>:</td>
                    <td><?php echo $modAnamnesa->kebiasaan_pakai_dot ? "Ya" : "Tidak"  ?></td>
                </tr>
            </table>
            <br>
            <div style="text-align: center">KEMAMPUAN PERGERAKAN</div>
            <table width='100%'>
                <tr>
                    <td width='130'>Kemampuan Pergerakan</td>
                    <td width='10'>:</td>
                    <td><?php echo $modAnamnesa->kemampuan_pergerakan ?></td>
                </tr>
                <tr>
                    <td>Tangisan</td>
                    <td>:</td>
                    <td><?php echo $modAnamnesa->tangisan ?></td>
                </tr>
            </table>
            <br>
            <div style="text-align: center">NUTRISI</div>
            <table width='100%'>
                <tr>
                    <td width='130'>BB</td>
                    <td width='10'>:</td>
                    <td><?php echo $modAnamnesa->nutrisi_beratbadan ?> kg</td>
                </tr>
                <tr>
                    <td width='130'>TB</td>
                    <td width='10'>:</td>
                    <td><?php echo $modAnamnesa->nutrisi_tinggibadan ?> cm</td>
                </tr>
                <tr>
                    <td width='130'>Tipe Makanan</td>
                    <td width='10'>:</td>
                    <td><?php 
                    echo "<ul>";
                    if (!empty($modAnamnesa->nutrisi_tipemakan) && trim($modAnamnesa->nutrisi_tipemakan) != "") {
                        $modAnamnesa->nutrisi_tipemakan = CJSON::decode($modAnamnesa->nutrisi_tipemakan);
                        if (is_array($modAnamnesa)) {
                            foreach ($modAnamnesa->nutrisi_tipemakan as $item) {
                                echo "<li>".$item."</li>";
                            }
                        }
                    }
                    echo "</ul>";
                    
                    ?></td>
                </tr>
                <tr>
                    <td width='130'>Makanan yang disukai</td>
                    <td width='10'>:</td>
                    <td><?php echo $modAnamnesa->nutrisi_makanan_suka ?></td>
                </tr>
                <tr>
                    <td width='130'>Makanan yang tidak disukai</td>
                    <td width='10'>:</td>
                    <td><?php echo $modAnamnesa->nutrisi_makanan_tdk_suka ?></td>
                </tr>
                <tr>
                    <td width='130'>Konsidi yang Perlu Dikaji</td>
                    <td width='10'>:</td>
                    <td><?php 
                    echo "<ul>";
                    if (!empty($modAnamnesa->nutrisi_kondisi) && trim($modAnamnesa->nutrisi_kondisi) != "") {
                        $modAnamnesa->nutrisi_kondisi = CJSON::decode($modAnamnesa->nutrisi_kondisi);
                        if (is_array($modAnamnesa->nutrisi_kondisi)) {
                            foreach (($modAnamnesa->nutrisi_kondisi) as $item) {
                                echo "<li>".$item."</li>";
                            }
                        }
                    }
                    echo "</ul>";
                    
                    ?></td>
                </tr>
            </table>
        </td>
        <td colspan='3'>
            <div style="text-align: center">ELIMINASI</div>
            <table width='100%'>
                <tr>
                    <td width='100'>Buang Air Besar</td>
                    <td width='10'>:</td>
                    <td><?php 
                    echo "<ul>";
                    if (!empty($modAnamnesa->eliminasi_buangairbesar) && trim($modAnamnesa->eliminasi_buangairbesar) != "") {
                        $modAnamnesa->eliminasi_buangairbesar = CJSON::decode($modAnamnesa->eliminasi_buangairbesar);
                        if (is_array($modAnamnesa->eliminasi_buangairbesar)) {
                            foreach ($modAnamnesa->eliminasi_buangairbesar as $item) {
                                echo "<li>".$item;
                                if ($item == 'Lain-Lain' && !empty($modAnamnesa->eliminasi_buangairbesar_lain2)) {
                                    echo "<br>(".$modAnamnesa->eliminasi_buangairbesar_lain2.")";
                                }
                                if ($item == 'Diare' && !empty($modAnamnesa->eliminasi_buangairbesar_diarehari)) {
                                    echo "<br>(".$modAnamnesa->eliminasi_buangairbesar_diarehari."x / hari)";
                                }
                                echo "</li>";
                            }
                        }
                    }
                    echo "</ul>";
                    
                    ?></td>
                </tr>
                <tr>
                    <td width='100'>Buang Air Kecil</td>
                    <td width='10'>:</td>
                    <td><?php 
                    echo "<ul>";
                    if (!empty($modAnamnesa->eliminasi_buangairkecil) && trim($modAnamnesa->eliminasi_buangairkecil) != "") {
                        $modAnamnesa->eliminasi_buangairkecil = CJSON::decode($modAnamnesa->eliminasi_buangairkecil);
                        if (is_array($modAnamnesa->eliminasi_buangairkecil)) {
                            foreach ($modAnamnesa->eliminasi_buangairkecil as $item) {
                                echo "<li>".$item;
                                if ($item == 'Lain-Lain' && !empty($modAnamnesa->eliminasi_buangairkecil_lain2)) {
                                    echo "<br>(".$modAnamnesa->eliminasi_buangairkecil_lain2.")";
                                }
                                echo "</li>";
                            }
                        }
                    }
                    echo "</ul>";
                    
                    ?></td>
                </tr>
                
            </table>
            <br>
            <div style="text-align: center">INTEGRITAS KULIT</div>
            <table width='100%'>
                <tr>
                    <td width='130'>Integritas Kulit</td>
                    <td width='10'>:</td>
                    <td><?php echo $modAnamnesa->integritas_kulit ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div style="text-align: center">MODIFIKASI STRONG-KIDS</div>
<table width="100%" class="tab_strong_kids">
    <thead>
        <tr>
            <th rowspan="2" width="30">NO</th>
            <th rowspan="2">PERTANYAAN</th>
            <th colspan="2">JAWABAN</th>
            <th rowspan="2" width="50">SKOR</th>
        </tr>
        <tr>
            <th>Ya</th>
            <th>Tidak</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="num">1</td>
            <td>Apakah Pasien memiliki status nutrisi kurang atau buruk secara klinik 
                (anak kurus/sangat kurus, mata cekung, wajah tampak tua, edema, rambut tipis dan jarang, 
                otot lengan dan paha tipis, iga gambang, perut kempes, bokong tipis dan kisut) ?</td>
            <td width="50" class="skcenter"><?php echo $modAnamnesa->strongkids_nutrisikurang ? '<i class="entypo-check"></i>' : "" ?></td>
            <td width="50" class="skcenter"><?php echo !$modAnamnesa->strongkids_nutrisikurang ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_nutrisikurang ?></td>
        </tr>
        <tr>
            <td class="num">2</td>
            <td>Apakah Terdapat Penurunan Berat Badan selama satu bulan terakhir atau untuk bayi < 1 tahun dan BB tidak naik selama 3 bulan terakhir ?<br>
            Jika Ibu pasien menjawab tidak tahu dianggap Ya</td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_peneurunanberat ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo !$modAnamnesa->strongkids_peneurunanberat ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_peneurunanberat ?></td>
        </tr>
        <tr>
            <td class="num">3</td>
            <td>Apakah terdapat SALAH SATU dari kondisi berikut :
                <ul>
                    <li>Diare Profuse ( > 5x/hari) dan atau muntah ( > 3x/hari)</li>
                    <li>Asupan makanan berkurang selama 1 minggu terakhir</li>
                </ul>
            </td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_diare_profus ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo !$modAnamnesa->strongkids_diare_profus ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_diare_profus ?></td>
        </tr>
        <tr>
            <td class="num">4</td>
            <td>Apakah terdapat penyakit besar atau keadaan yang melibatkan pasien beresiko mengalami malnutrisi 
                (lihat tabel daftar penyakit yang beresiko malnutrisi) ?
            </td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_penyakit_dasar ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo !$modAnamnesa->strongkids_penyakit_dasar ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_penyakit_dasar ?></td>
         </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: right; font-weight: bold;">Total Skor</td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_skor; ?></td>
        </tr>
        <tr>
            <td colspan="5" style="font-weight: bold;">
                KESIMPULAN : <?php echo $modAnamnesa->strongkids_skor >= 2 ? "Dikonsultasikan Ahli Gizi" : "Konsultasi belum diperlukan"; ?>
            </td>
        </tr>
    </tfoot>
</table>
