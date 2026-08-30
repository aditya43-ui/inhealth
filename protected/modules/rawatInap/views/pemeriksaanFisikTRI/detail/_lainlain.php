
        <table id="tblDaftarAnamnesa" width="100%" class="table table-bordered table-condensed" border="2">
            <tr>
                <td>
                    <b>Pemeriksaan Penunjang</b><br>
                    <?php echo !empty($modPemeriksaanFisik->periksa_penunjang) ? $modPemeriksaanFisik->periksa_penunjang : "-<br>" ?>
                    <b>Diagnosa Kerja</b><br>
                    <?php
                    $diag = DiagnosakerjaT::model()->findAllByAttributes(array(
                        'pemeriksaanfisik_id'=>$modPemeriksaanFisik->pemeriksaanfisik_id,
                    ));
                    
                    if (count((array)$diag) == 0) {
                        echo "-<br>";
                    } else {
                        echo "<ul>";
                        foreach ($diag as $item) {
                            echo "<li>".$item->diagnosakerja_isi."</li>";
                        }
                        echo "</ul>";
                    }
                    
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Terapi IGD</b><br>
                    <?php echo !empty($modPemeriksaanFisik->terapi_igd) ? $modPemeriksaanFisik->terapi_igd : "-" ?><br>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Terapi Rawat Inap</b><br>
                    <?php echo !empty($modPemeriksaanFisik->terapi_rawatinap) ? $modPemeriksaanFisik->terapi_rawatinap : "-" ?><br>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Monitoring</b><br>
                    <?php echo !empty($modPemeriksaanFisik->monitoring) ? $modPemeriksaanFisik->monitoring : "-" ?><br>
                </td>
            </tr>
        </table>
        <table id="tblDaftarAnamnesa" width="100%" class="table table-bordered table-condensed" border="2">
            <tr>
                <td colspan="2"><b>Rencana Tindak Lanjut</b></td>
            </tr>
            <tr>
                <td width="30%">Rawat Inap Ruang</td>
                <td><?php echo !empty($modPemeriksaanFisik->tl_rawatinap_ruang) && trim($modPemeriksaanFisik->tl_rawatinap_ruang) != "" ? $modPemeriksaanFisik->tl_rawatinap_ruang : "-"; ?></td>
            </tr>
            <tr>
                <td>Rawat Inap DPJP</td>
                <td><?php echo !empty($modPemeriksaanFisik->tl_rawatinap_dpjp) && trim($modPemeriksaanFisik->tl_rawatinap_dpjp) != "" ? $modPemeriksaanFisik->tl_rawatinap_dpjp : "-"; ?></td>
            </tr>
            <tr>
                <td>Indikasi</td>
                <td><?php echo !empty($modPemeriksaanFisik->tl_indikasi) && trim($modPemeriksaanFisik->tl_indikasi) != "" ? $modPemeriksaanFisik->tl_indikasi : "-"; ?></td>
            </tr>
            <tr>
                <td>Pengantar Pasien</td>
                <td><?php echo empty($modPemeriksaanFisik->tl_pengantar_pasien) && trim($modPemeriksaanFisik->tl_pengantar_pasien) != "" ? "Tidak" : "Ya"; ?></td>
            </tr>
            <tr>
                <td>Rujuk ke</td>
                <td><?php 
                if (empty($modPemeriksaanFisik->tl_asalrujukan_id)) {
                    echo "-";
                } else {
                    $asal = AsalrujukanM::model()->findByPk($modPemeriksaanFisik->tl_asalrujukan_id);
                    
                    if (empty($asal)) {
                        echo "-";
                    } else {
                        echo $asal->asalrujukan_nama.", ".$modPemeriksaanFisik->tl_rujuk_nama;
                    }
                    
                }
                
                ?></td>
            </tr>
        </table>
        <table id="tblDaftarAnamnesa" width="100%" class="table table-bordered table-condensed" border="2">
            <tr>
                <td>
                    <b>Edukasi Pasien</b><br>
                    Edukasi awal, disampaikan tentang Diagnosis, Rencana, dan Tujuan Terapi Kepada :</br>
                    <?php  
                    if (empty($modPemeriksaanFisik->edukasi_dituju_ke)) {
                        echo "-";
                    } else {
                        echo $modPemeriksaanFisik->edukasi_dituju_ke;
                        
                        if ($modPemeriksaanFisik->edukasi_dituju_ke == "KELUARGA") {
                            echo " (".$modPemeriksaanFisik->edukasi_nama_keluarga.")";
                        } else if ($modPemeriksaanFisik->edukasi_dituju_ke == "TIDAK BISA") {
                            echo " karena, ".$modPemeriksaanFisik->edukasi_alasan_tidakbisa;
                        }
                    }
                    
                    ?>
                </td>
            </tr>
        </table>