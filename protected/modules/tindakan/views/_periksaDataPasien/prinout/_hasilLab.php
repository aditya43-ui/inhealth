<?php // $pathTemplate = "application.modules.laboratorium.views.daftarPasien.template.";
?>
<style>
    .boldmerah{
		color:#d80000;
		font-weight:bold;
	}
</style>
<?php
    echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array( 'colspan'=>9)); 
    echo '<hr/>';
    $no_urut = 1;
   
    ?>
    <table class='prinout w100'>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('no_pendaftaran') ?></td><td>: <?php echo $modKunjungan->no_pendaftaran ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('no_rekam_medik') ?></td><td>: <?php echo $modKunjungan->no_rekam_medik ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('tgl_pendaftaran') ?></td><td>: <?php echo $modKunjungan->tgl_pendaftaran ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('nama_pasien') ?></td><td>: <?php echo $modKunjungan->namadepan." ".$modKunjungan->nama_pasien ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('no_masukpenunjang') ?></td><td>: <?php echo $modKunjungan->no_masukpenunjang ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('tanggal_lahir') ?></td><td>: <?php echo $modKunjungan->tanggal_lahir ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('tglmasukpenunjang') ?></td><td>: <?php echo $modKunjungan->tglmasukpenunjang ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('jeniskelamin') ?></td><td>: <?php echo $modKunjungan->jeniskelamin ?></td>
        </tr>
        <tr>
            <td><?php echo $modKunjungan->getAttributeLabel('ruangan_nama') ?></td><td>: <?php echo $modKunjungan->ruangan_nama ?></td>
            <td><?php echo $modKunjungan->getAttributeLabel('alamat_pasien') ?></td><td>: <?php echo $modKunjungan->alamat_pasien ?></td>
        
        </tr>
        <tr>
        <td>Dokter Pemeriksa</td><td> : <?php echo $modKunjungan->nama_pegawai ?></td>
        </tr>
        <tr>
            <td><?php echo $modHasilPemeriksaan->getAttributeLabel('nohasilperiksalab') ?></td><td>: <?php echo $modHasilPemeriksaan->nohasilperiksalab; ?></td>
        </tr>
        <tr>
            <td><?php echo $modHasilPemeriksaan->getAttributeLabel('tglhasilpemeriksaanlab') ?></td><td>: <?php echo $format->formatDateTimeForUser($modHasilPemeriksaan->tglhasilpemeriksaanlab); ?></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
    </table>
	
    <table class='prinout w100'>
        <tr>
            <td>
                <div style="font-family:arial;font-size:12pt;">
                    <b>
                        <p style="margin: 0; text-align: center;">
                            <h4>HASIL PEMERIKSAAN LABORATORIUM</h4>
                        </p>
                    </b>
                </div>
            </td>
        </tr>
    </table>  

    <table class='prinout grid w100'>
        <thead>
            <tr>
                <th>NO.</th>
                <th width="30%">DETAIL PEMERIKSAAN</th>
                <th>HASIL PEMERIKSAAN</th>
                <th>NILAI RUJUKAN</th>
                <th>SATUAN</th>
                <th>METODE</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count((array)$modDetailHasilPemeriksaans) > 0){
                foreach($modDetailHasilPemeriksaans AS $i => $modDetail){
                    
                    $masterDet = PemeriksaanlabdetM::model()->findByPk($modDetail->pemeriksaanlabdet_id);
                    $nilai = NilairujukanM::model()->findByPk($masterDet->nilairujukan_id);
                                        
                    $trpemeriksaan = false;
                    if($i == 0){
                        echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
                    }else if(($i) < count((array)$modDetailHasilPemeriksaans)){
                        if($modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id != $modDetailHasilPemeriksaans[$i-1]->pemeriksaanlab_id){
                            echo "<tr><td colspan='6' style='font-weight:bold; text-align:center;'>".$modDetailHasilPemeriksaans[$i]->pemeriksaanlab->pemeriksaanlab_nama."</td></tr>";
                            $no_urut--;
                        }
                    }
            ?>   
                <tr>
                    <td>
                        <?php echo $no_urut; ?>
                    </td>
                    <td><?php echo $modDetail->pemeriksaandetail->nilairujukan->namapemeriksaandet ?></td>
                    <td style="text-align: center;"><?php 
                    
                        $spanclass = '';
                        $ubahData = '';
                    
                          if ($nilai['nilairujukan_nama'] != '') {
                            if (($nilai['nilairujukan_min'] != 0 || $nilai['nilairujukan_max'] != 0)) {

                                $hasil = str_replace('.', '.', $modDetail['hasilpemeriksaan']);
                                $hasil = str_replace(',', '.', $hasil);
                                //var_dump($hasil);							
                                if (($hasil < $nilai['nilairujukan_min']) || ($hasil > $nilai['nilairujukan_max'])) {
                                    $spanclass = 'boldmerah';
                                } else {
                                }
                            } else {
                                $cekNilai = Params::hasilDetLabTextNumber(strtolower($nilai['namapemeriksaandet']));
                                if (!empty($cekNilai)) {
                                    if ($cekNilai == 2) {
                                        $nilaiRujuk = $nilai['nilairujukan'];
                                        $nilaiPecah1 = explode('/', $nilaiRujuk);

                                        $nilai1 = array();
                                        foreach ($nilaiPecah1 as $idx => $p) {
                                            $nilaiPecah2 = explode('-', $p);

                                            $nilai1[$idx] = array(
                                                'min' => isset($nilaiPecah2[0]) ? trim($nilaiPecah2[0]) : null,
                                                'max' => isset($nilaiPecah2[1]) ? trim($nilaiPecah2[1]) : null
                                            );
                                        }

                                        $hsl = $modDetail['hasilpemeriksaan'];
                                        $pecah1 = explode('/', $modDetail['hasilpemeriksaan']);

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
//                                    var_dump($nilai->attributes); die;
                                    $nilai['nilairujukan_nama'] = str_replace("'", "", $nilai['nilairujukan_nama']);
                                    $nilai['nilairujukan_nama'] = str_replace('"', "", $nilai['nilairujukan_nama']);
                                    if (strtolower(trim($modDetail['hasilpemeriksaan'])) != strtolower(trim($nilai['nilairujukan_nama']))) {
                                        // $spanclass='boldmerah';
                                        $spanclass = '';
                                    }
                                }
                            }
                        }
                        
                        echo "<span class='" . $spanclass . "'>";
                        if ($spanclass == 'ubah') {
                            echo $ubahData;
                        } else {
                            echo $modDetail['hasilpemeriksaan'];
                        }
                        echo "</span>"
                    

                    ?></td>
                    <td style="text-align: center;"><?php 
                        // i/
                        echo $modDetail->NilaiRujukan; 

                    ?></td>
                    <td><?php echo $modDetail->HasilPemeriksaanSatuan; ?></td>
                    <td><?php echo $modDetail->HasilPemeriksaanMetode; ?></td>
                </tr>
            <?php 
                    $no_urut++;
                }
            }
            ?>
        </tbody>
    </table>

    <table class='prinout w100'>
        <tr>
            <td><br>
                <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('catatanlabklinik') ?> :</span><br>
                <table class='prinout w100 grid'>
                    <tr>
                        <td><?php echo $modHasilPemeriksaan->catatanlabklinik; ?></td>
                    </tr>
                </table>
            </td>
        </tr>        
        <tr>
            <td><br>
                <span style='font-size:9pt'><?php echo $modHasilPemeriksaan->getAttributeLabel('kesimpulan') ?> :</span><br>
                <table class='prinout w100 grid'>
                    <tr>
                        <td><?php echo $modHasilPemeriksaan->kesimpulan; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

