<style>
    .table tfoot td {
        color: black !important;
    }
</style>

<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td style="width:30%">No. Triage Pasien</td>
        <td style="width:70%"><?php echo isset($modTriage->no_bed_triage)?$modTriage->no_bed_triage:" - "; ?></td>
    </tr>
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
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhantambahan)?$modAnamnesa->keluhantambahan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Perjalanan Penyakit Pasien</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatperjalananpasien)?$modAnamnesa->riwayatperjalananpasien:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Lama sakit</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->lamasakit)?$modAnamnesa->lamasakit:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Terdahulu</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatpenyakitterdahulu)?$modAnamnesa->riwayatpenyakitterdahulu:"riwayatpenyakitterdahulu "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Keluarga</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatpenyakitkeluarga)?$modAnamnesa->riwayatpenyakitkeluarga:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Alergi Obat</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatalergiobat)?$modAnamnesa->riwayatalergiobat:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Pengobatan yang sudah dilakukan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->pengobatanygsudahdilakukan)?$modAnamnesa->pengobatanygsudahdilakukan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Alergi Makanan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatmakanan)?$modAnamnesa->riwayatmakanan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Kelahiran</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatkelahiran)?$modAnamnesa->riwayatkelahiran:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Imunisasi</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->riwayatimunisasi)?$modAnamnesa->riwayatimunisasi:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Operasi</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->riwayat_operasi)?$modAnamnesa->riwayat_operasi:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Status Rokok</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->statusmerokok) && $modAnamnesa->statusmerokok == 1?"Ya":" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Jumlah Rokok (Batang)</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->jmlrokok_btg_hr)?$modAnamnesa->jmlrokok_btg_hr." per hari":" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Konsumsi Alkohol</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->keb_konsumsialkohol) ? $modAnamnesa->keb_konsumsialkohol : " - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Jumlah Alkohol yang rutin minum</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->jmlalkohol_rutinminum) ? $modAnamnesa->jmlalkohol_rutinminum : " - "; ?></td>
    </tr>
    <tr>
        <td>Kebiasaan Minum</td>
        <td>
            <ul>
                <?php echo $modAnamnesa->keb_minumkopi ? '<li>Kopi</li>' : '' ?>
                <?php echo $modAnamnesa->keb_minumteh ? '<li>Teh</li>' : '' ?>
                <?php echo $modAnamnesa->keb_minumsoda ? '<li>Soda</li>' : '' ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="width:30%">Kebiasaan Olahraga Rutin</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keb_olahraga) ? $modAnamnesa->keb_olahraga : " - "; ?></td>
    </tr>
    <tr>
        <td>Gangguan Komunikasi</td>
        <td>
            <ul>
                <?php echo $modAnamnesa->gangguankomunikasi_bahasaindonesia ? '<li>Bahasa Indonesia</li>' : '' ?>
                <?php echo $modAnamnesa->gangguankomunikasi_gangguanpendengaran ? '<li>Gangguan Pendengaran/Tuli</li>' : '' ?>
                <?php echo $modAnamnesa->gangguankomunikasi_gangguanbicara ? '<li>Gangguan Bicara</li>' : '' ?>
                <?php echo $modAnamnesa->gangguankomunikasi_tidakada ? '<li>Tidak Ada</li>' : '' ?>
            </ul>
        </td>
    </tr>
    <tr>
        <td style="width:30%">Apakah pasien pernah diperiksa untuk diagnosa HIV</td>
        <td style="width:70%"><?php echo !empty($modAnamnesa->riwayatperiksa_diagnosahiv) ? $modAnamnesa->riwayatperiksa_diagnosahiv : " - "; 
            if ($modAnamnesa->riwayatperiksa_diagnosahiv == "Ya" && !empty($modAnamnesa->riwayatperiksa_diagnosahivhasil)) {
                echo ", Hasil : ".$modAnamnesa->riwayatperiksa_diagnosahivhasil;
            }
        ?></td>
    </tr>
    <tr>
        <td>Apakah Pasien memakai Gigi Palsu & Alat Bantu Dengar</td>
        <td>
            <ul>
                <?php echo $modAnamnesa->ismemakaigigipalsu ? '<li>Gigi Palsu</li>' : '' ?>
                <?php echo $modAnamnesa->ismemakaialatbantudengar ? '<li>Alat Bantu Dengar</li>' : '' ?>
                <?php echo $modAnamnesa->istidakmemakai_gigipalsualatbantudengar ? '<li>Tidak Ada</li>' : '' ?>
            </ul>
        </td>
    </tr>
    
    <tr>
        <td style="width:30%;height:86px">Keterangan</td>
        <td style="width:70%;height:86px"><?php echo isset($modAnamnesa->keterangananamesa)?$modAnamnesa->keterangananamesa:" - "; ?></td>
    </tr>
</table>

<?php if ($modAnamnesa->skrining_dewasa): ?>
            
        <div style="text-align: center">SKRINING GIZI DEWASA</div>
        <table width="100%" class="table table-bordered table-condensed">
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
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == false ? '<i class="entypo-check">' : '' ?></td>
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

        <?php if ($modAnamnesa->anamnesa_anak) {
            echo $this->renderPartial('/_periksaDataPasien/_anamnesa_anak', array(
                'modAnamnesa'=>$modAnamnesa,
            ), true);
        } ?>

        <?php if ($modAnamnesa->skrining_anak): ?>
        <div style="text-align: center">SKRINING GIZI ANAK</div>
        <table width="100%" class="table table-bordered table-condensed">
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
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak disengaja, baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama 1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1 minggu kedepan ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == false ? '<i class="entypo-check">' : ''; ?></td>
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
    <td><?php echo CHtml::link(Yii::t('mds', '{icon} Print Detail', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printAnamnesaTriage();return false")); ?></td>
</tr>
</table>
<script type="text/javascript">
function printAnamnesaTriage() {
    window.open(
        '<?php echo $this->createUrl('printAnamnesaTriage', array('anamesa_id' => $modAnamnesa->anamesa_id)); ?>',
        'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
}

</script>