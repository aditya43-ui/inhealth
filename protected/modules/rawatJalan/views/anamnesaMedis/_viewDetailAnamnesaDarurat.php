<style>
.table tfoot td {
    color: black !important;
}
</style>
<?php
$modPasien =isset($modAnamnesa->pasien) ? $modAnamnesa->pasien : "";
?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <label class='control-label'><?php echo 'Nama Pasien' ?>:</label>
            <?php
            $result = isset($modAnamnesa->pasien->nama_pasien) ? $modAnamnesa->pasien->nama_pasien : "";
            echo CHtml::encode($result); ?>
        </td>
        <td>
            <label class='control-label'><?php echo 'Tanggal Pendaftaran' ?>:</label>
            <?php
            $result = isset($modAnamnesa->pendaftaran->tgl_pendaftaran) ? MyFormatter::formatDateTimeForUser($modAnamnesa->pendaftaran->tgl_pendaftaran) : "";
            echo CHtml::encode($result); ?>
        </td>
    </tr><br>
    <tr>
        <td>
            <label class='control-label'><?php echo 'Jenis Kelamin' ?>:</label>
            <?php
                  $result = isset($modAnamnesa->pasien->jeniskelamin) ? $modAnamnesa->pasien->jeniskelamin : "";
       
                echo CHtml::encode($result); ?>
        </td>
        <td>
            <label class='control-label'><?php echo 'No. Pendaftaran' ?>:</label>
            <?php
                  $result = isset($modAnamnesa->pendaftaran->no_pendaftaran) ? $modAnamnesa->pendaftaran->no_pendaftaran : "";
       
                echo CHtml::encode($result); ?>
        </td>
    </tr><br>
    <tr>
        <td>
            <label class='control-label'><?php echo 'Umur' ?>:</label>
            <?php
                   $result = isset($modAnamnesa->pasien->umur) ? $modAnamnesa->pasien->umur : "";
       
                echo CHtml::encode($result); ?>
        </td>
        <td>
            <label class='control-label'><?php echo 'Kelas Pelayanan'; ?>:</label>
            <?php 
               $result = isset($modAnamnesa->pasienadmisi_id)?$modAnamnesa->pasienadmisi_id : "";
                $pasienAdmisi = PasienadmisiT::model()->findByPk($result);
                $kelasPelayanan = isset($modAnamnesa->kelaspelayanan->kelaspelayanan_nama) ? $modAnamnesa->kelaspelayanan->kelaspelayanan_nama : "";
                
                if(isset($pasienAdmisi)){
                    if(isset($pasienAdmisi->kelaspelayanan)){
                        $kelasPelayanan = $pasienAdmisi->kelaspelayanan->kelaspelayanan_nama;
                    }
                }
                
            echo CHtml::encode($kelasPelayanan); ?>
        </td>
    </tr><br>
    <tr>
        <td>
            <label class='control-label'><?php echo 'Jenis Penjamin / Penjamin '; ?>:</label>
            <?php 
                   $result = isset($modAnamnesa->carabayar->carabayar_nama)?$modAnamnesa->carabayar->carabayar_nama: "";
                   $results = isset($modAnamnesa->penjamin->penjamin_nama)?$modAnamnesa->penjamin->penjamin_nama: "";
            
                echo CHtml::encode($result); ?> / <?php echo CHtml::encode($results); ?>

        </td>
        <td>
            <label class='control-label'><?php echo 'Nama Dokter'; ?>:</label>
            <?php 
              $result = isset($modAnamnesa->pegawai->nama_pegawai)?$modAnamnesa->pegawai->nama_pegawai: "";
                  
            echo CHtml::encode($result); ?>
        </td>
    </tr>
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td style="width:30%">Perawat</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->paramedis_nama)?$modAnamnesa->paramedis_nama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Utama</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhanutama)?$modAnamnesa->keluhanutama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Tambahan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhantambahan)?$modAnamnesa->keluhantambahan:" - "; ?>
        </td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Pasien</td>
        <td style="width:70%">
            <?php echo isset($modAnamnesa->riwayatperjalananpasien)?$modAnamnesa->riwayatperjalananpasien:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%;height:86px">Keterangan</td>
        <td style="width:70%;height:86px">
            <?php echo isset($modAnamnesa->keterangananamesa)?$modAnamnesa->keterangananamesa:" - "; ?></td>
    </tr>
</table>

<?php if (isset($modAnamnesa->skrining_dewasa)): ?>

<div style="text-align: center" hidden>SKRINING GIZI DEWASA</div>
<table width="100%" class="table table-bordered table-condensed hide">
    <thead>
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">Kriteria.</th>
            <th colspan="2">Jawaban</th>
        </tr>
        <tr>
            <th>Ya<br>Skor=1</th>
            <th>Tidak<br>Skor=0</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="10">1</td>
            <td>Apakah IMT < 20,5 atau LLA < 25 cm untuk wanita dan LLA < 26,3 cm untuk pria ?</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria1 == true ? '<i class="entypo-check">' : '' ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria1 == false ? '<i class="entypo-check">' : '' ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria2 == true ? '<i class="entypo-check">' : '' ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria2 == false ? '<i class="entypo-check">' : '' ?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria3 == true ? '<i class="entypo-check">' : '' ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria3 == false ? '<i class="entypo-check">' : '' ?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria4 == true ? '<i class="entypo-check">' : '' ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_dewasa_kriteria4 == false ? '<i class="entypo-check">' : '' ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td>TOTAL SKOR</td>
            <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_dewasa_skor ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_dewasa_hasil; ?></td>
        </tr>

    </tfoot>
</table>

<?php endif; ?>

<!-- Amamnesa Anak -->
<?php if (isset($modAnamnesa->anamnesa_anak)) { ?>

<div style="text-align: center" hidden>RIWAYAT VAKSINASI</div>
<?php

$riwayat = CJSON::decode($modAnamnesa->riwayat_vaksinasi);
// var_dump($riwayat); die;

?>
<table class="tab_vaksinasi hide">
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
        <td colspan="3"><?php echo !empty($riwayat['campak']['booster'][1]) ? $riwayat['campak']['booster'][1] : ""; ?>
        </td>
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
<table width='100%' class='form_anak hide'>
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
<div style="text-align: center" hidden>MODIFIKASI STRONG-KIDS</div>
<table width="100%" class="tab_strong_kids hide">
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
            <td width="50" class="skcenter">
                <?php echo $modAnamnesa->strongkids_nutrisikurang ? '<i class="entypo-check"></i>' : "" ?></td>
            <td width="50" class="skcenter">
                <?php echo !$modAnamnesa->strongkids_nutrisikurang ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_nutrisikurang ?></td>
        </tr>
        <tr>
            <td class="num">2</td>
            <td>Apakah Terdapat Penurunan Berat Badan selama satu bulan terakhir atau untuk bayi < 1 tahun dan BB tidak
                    naik selama 3 bulan terakhir ?<br>
                    Jika Ibu pasien menjawab tidak tahu dianggap Ya</td>
            <td class="skcenter">
                <?php echo $modAnamnesa->strongkids_peneurunanberat ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter">
                <?php echo !$modAnamnesa->strongkids_peneurunanberat ? '<i class="entypo-check"></i>' : "" ?></td>
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
            <td class="skcenter">
                <?php echo $modAnamnesa->strongkids_diare_profus ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter">
                <?php echo !$modAnamnesa->strongkids_diare_profus ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter"><?php echo $modAnamnesa->strongkids_diare_profus ?></td>
        </tr>
        <tr>
            <td class="num">4</td>
            <td>Apakah terdapat penyakit besar atau keadaan yang melibatkan pasien beresiko mengalami malnutrisi
                (lihat tabel daftar penyakit yang beresiko malnutrisi) ?
            </td>
            <td class="skcenter">
                <?php echo $modAnamnesa->strongkids_penyakit_dasar ? '<i class="entypo-check"></i>' : "" ?></td>
            <td class="skcenter">
                <?php echo !$modAnamnesa->strongkids_penyakit_dasar ? '<i class="entypo-check"></i>' : "" ?></td>
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
                KESIMPULAN :
                <?php echo $modAnamnesa->strongkids_skor >= 2 ? "Dikonsultasikan Ahli Gizi" : "Konsultasi belum diperlukan"; ?>
            </td>
        </tr>
    </tfoot>
</table>



<?php } ?>
<!-- End Amamnesa Anak -->


<?php if (isset($modAnamnesa->skrining_anak)): ?>
<div style="text-align: center" hidden>SKRINING GIZI ANAK</div>
<table width="100%" class="table table-bordered table-condensed hide">
    <thead>
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">Kriteria.</th>
            <th colspan="2">Jawaban</th>
        </tr>
        <tr>
            <th>Ya<br>Skor=1</th>
            <th>Tidak<br>Skor=0</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="10">1</td>
            <td>Apakah IMT anak berada dibawah nilai cut-off tabel IMT rujukan ?</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria1 == true ? '<i class="entypo-check">' : ''; ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria1 == false ? '<i class="entypo-check">' : ''; ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak disengaja,
                baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria2 == true ? '<i class="entypo-check">' : ''; ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria2 == false ? '<i class="entypo-check">' : ''; ?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama 1
                minggu terakhir ?</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria3 == true ? '<i class="entypo-check">' : ''; ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria3 == false ? '<i class="entypo-check">' : ''; ?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1 minggu
                kedepan ?</td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria4 == true ? '<i class="entypo-check">' : ''; ?></td>
            <td class="pilih_center" width="50">
                <?php echo $modAnamnesa->skrining_anak_kriteria4 == false ? '<i class="entypo-check">' : ''; ?></td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td>TOTAL SKOR</td>
            <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_anak_skor; ?></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_anak_hasil; ?></td>
        </tr>

    </tfoot>
</table>

<?php endif; ?>

<table>
    <tr>
        <td><?php echo CHtml::link(Yii::t('mds', '{icon} Print Detail', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printAnamnesa();return false")); ?>
        </td>
    </tr>
</table>


<script type="text/javascript">
function printAnamnesa() {
    window.open(
        '<?php echo $this->createUrl('printAnamnesaDarurat',array('notriage_pasien_id'=>$modAnamnesa->notriage_pasien_id)); ?>',
        'printwin', 'left=100,top=100,width=640,height=480');
}
</script>