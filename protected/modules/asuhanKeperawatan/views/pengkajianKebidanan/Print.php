<style>
    .spasi1 {
        margin: 0 0px 0px 10px;
    }

    .spasi2 {
        padding: 0 0px 0px 20px;
    }
</style>
<div class="white-container">
    <?php
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
    $no_urut = 1;
    $class = '';
    if (isset($_GET['frame'])) {
        $class = "table table-striped";
    }
    ?>
    <?php echo '<b>I. IDENTITAS</b>'; ?>
    <br>
    <br>
    <table width="100%" class="spasi1">
        <tr>
            <td width="20%">Nama Pasien</td>
            <td width="30%">: <?php echo (isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : " - "); ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">Umur</td>
            <td width="30%">: <?php echo (isset($modPendaftaran->umur) ? $modPendaftaran->umur : " - "); ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">No. Rekam Medis</td>
            <td width="30%">: <?php echo isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : " - "; ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">Ruang / Kelas</td>
            <td width="30%">: <?php echo isset($modPendaftaran->ruangan->ruangan_nama) ? $modPendaftaran->ruangan->ruangan_nama : " - " . ' / ' . (isset($modPendaftaran->kelaspelayanan->kelaspelayanan_nama) ? $modPendaftaran->kelaspelayanan->kelaspelayanan_nama : " - "); ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">Agama</td>
            <td width="30%">: <?php echo (isset($modPasien->agama) ? $modPasien->agama : " - "); ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">Pendidikan / Pekerjaan</td>
            <td width="30%">: <?php echo isset($modPasien->pendidikan->pendidikan_nama) ? $modPasien->pendidikan->pendidikan_nama : " - " . ' / ' . (isset($modPasien->pekerjaan->pekerjaan_nama) ? $modPasien->pekerjaan->pekerjaan_nama : " - "); ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">Diagnosa Medis</td>
            <td width="30%">: <?php echo (isset($modDiagnosa->diagnosa_nama) ? $modDiagnosa->diagnosa_nama : $modPengkajian->getDiagnosaMedis($modPasien->pasien_id, $modPengkajian->pendaftaran_id)); ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">Dokter</td>
            <td width="30%">: <?php echo (isset($modPendaftaran->pegawai->nama_pegawai) ? $modPendaftaran->getNamaDokter($modPendaftaran->pegawai_id) : " - "); ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
        <tr>
            <td width="20%">Alamat</td>
            <td width="30%">: <?php echo isset($modPasien->alamat_pasien) ? $modPasien->alamat_pasien : " - "; ?></td>
            <td width="20%"></td>
            <td width="30%"></td>
        </tr>
    </table>
    <br>
    <?php echo '<b>II. ANAMNESA</b>'; ?>
    <br>
    <br>
    <p>A. Keluhan Utama: <?php echo (isset($modAnamnesa->keluhanutama) ? $modAnamnesa->keluhanutama : "-"); ?></p>
    <p>B. Riwayat Kesehatan Sekarang: <?php echo (isset($modAnamnesa->riwayatperjalananpasien) ? $modAnamnesa->riwayatperjalananpasien : "-"); ?></p>
    <p>C. Riwayat Kesehatan Masa Lalu: <?php echo (isset($modAnamnesa->riwayatpenyakitterdahulu) ? $modAnamnesa->riwayatpenyakitterdahulu : "-"); ?></p>
    <p>C. Riwayat Kesehatan Keluarga: <?php echo (isset($modAnamnesa->riwayatpenyakitkeluarga) ? $modAnamnesa->riwayatpenyakitkeluarga : "-"); ?></p>
    <p>E. Riwayat Menstruasi: </p>
    <ol>
        <li>
            <?php echo 'Haid pertama/ Menarche umur : ' . (isset($modAnamnesa->menarcheumur_thn) ? $modAnamnesa->menarcheumur_thn : "-") . ' Tahun'; ?>
        </li>
        <li>
            <?php echo 'Siklus menstruasi : ' . (isset($modAnamnesa->siklusmenstruasi_hari) ? $modAnamnesa->siklusmenstruasi_hari : "-") . ' Hari     ' . (($modAnamnesa->siklusmenstruasiteratur == 1) ? "Teratur" : "Tidak Teratur"); ?>
        </li>
        <li>
            <?php echo 'Dismenorche : ' . (($modAnamnesa->dismenorche == 1) ? "Ya" : "Tidak"); ?>
        </li>
    </ol>
    <p>F. Riwayat Perkawinan: </p>
    <ol>
        <li>
            <?php echo 'Status Perkawinan : ' . (($modAnamnesa->statusperkawinan == 1) ? "Kawin" : "Tidak Kawin") . '     ' . (isset($modAnamnesa->jmlperkawinan_kali) ? $modAnamnesa->jmlperkawinan_kali : "-") . ' kali'; ?>
        </li>
        <li>
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'informasiasuhankeperawatan-grid',
                'dataProvider' => $modPerkawinan,
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns' => array(
                    array(
                        'header' => 'Perkawinan Ke-',
                        'type' => 'raw',
                        'value' => '$data->perkawinan_ke',
                    ),
                    array(
                        'header' => 'Tanggal Perkawinan',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tglperkawanan)',
                    ),
                    array(
                        'header' => 'Lamanya (Tahun)',
                        'name' => 'lamaperkawinan_thn',
                        'type' => 'raw',
                        'value' => '$data->lamaperkawinan_thn',
                    ),
                    array(
                        'header' => 'Tgl. Lahir Suami',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgllahir_suami)',
                    ),
                    array(
                        'header' => 'Umur Suami (Tahun)',
                        'type' => 'raw',
                        'value' => '$data->umursuami_thn',
                    ),
                    array(
                        'header' => 'Anak (Orang)',
                        'type' => 'raw',
                        'value' => '$data->jmlanak_org',
                    ),
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        </li>
    </ol>
    <p>G. Riwayat Kehamilan, Persalinan, Nifas dan Laktasi yang lalu : </p>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php
    $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
        'id' => 'informasiasuhankeperawatan-grid',
        'dataProvider' => $modPersalinan,
        'mergeHeaders' => array(
            array(
                'name' => '<p style="margin: 0; text-align: center;">Anak</p>',
                'start' => 6,
                'end' => 7,
            ),
        ),
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Tgl/Bln/Th Partus',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpartus)',
            ),
            array(
                'header' => 'Tempat Partus',
                'type' => 'raw',
                'value' => '$data->tempatpartus',
            ),
            array(
                'header' => 'Umur Hamil',
                'name' => 'umurhamil_bln',
                'type' => 'raw',
                'value' => '$data->umurhamil_bln',
            ),
            array(
                'header' => 'Jenis Persalinan',
                'type' => 'raw',
                'value' => '$data->jenispersalinan',
            ),
            array(
                'header' => 'Penolong Persalinan',
                'type' => 'raw',
                'value' => '$data->penolongpersalinan',
            ),
            array(
                'header' => 'Penyulit',
                'type' => 'raw',
                'value' => '$data->penyulit',
            ),
            array(
                'header' => 'BB',
                'type' => 'raw',
                'value' => '$data->bbanak_gram',
            ),
            array(
                'header' => 'PB',
                'type' => 'raw',
                'value' => '$data->pbanak_cm',
            ),
            array(
                'header' => 'Pemberian Asi',
                'type' => 'raw',
                'value' => '$data->pemberianasi',
            ),
            array(
                'header' => 'Keadaan Anak Sekarang',
                'type' => 'raw',
                'value' => '$data->keadaananakskrg',
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));
    ?>
    <p>H. Riwayat kehamilan saat ini : </p>
    <ol>
        <li>
            <?php echo 'HPHT : ' . (isset($modAnamnesa->hpht) ? $modAnamnesa->hpht : "-"); ?>
        </li>
        <li>
            <?php echo 'Taksiran Persalinan : ' . (isset($modAnamnesa->taksiranpersalinan) ? $modAnamnesa->taksiranpersalinan : "-"); ?>
        </li>
        <li>
            <?php echo 'Keluhan saat hamil : ' . (isset($modAnamnesa->keluhansaathamil) ? $modAnamnesa->keluhansaathamil : "-"); ?>
        </li>
        <li>
            <?php echo 'ANC : ' . (isset($modAnamnesa->anc) ? $modAnamnesa->anc : "-"); ?>
        </li>
        <li>
            <?php echo 'Imunisasi : ' . (isset($modAnamnesa->riwayatimunisasi) ? $modAnamnesa->riwayatimunisasi : "-"); ?>
        </li>
    </ol>
    <p><?php echo 'I. Riwayat Keluarga Berencana (KB) : ' . (isset($modAnamnesa->riwayatkb) ? $modAnamnesa->riwayatkb : "-"); ?></p>
    <p>J. Pola Kebiasaan Sehari-hari </p>
    <ol>
        <li>
            <?php
            echo 'Pola Nutrisi<br>Prekuensi makan : ' . (isset($modAnamnesa->frekmakan_hari) ? $modAnamnesa->frekmakan_hari : "-") . ' x/Hari, makanan yang dipantang : ' .
                (($modAnamnesa->makananyangdipantang == 1) ? "Ada" : "Tidak Ada");
            ?>
        </li>
        <li>
            <?php
            echo 'Pola Istirahat Tidur :<br>Lama Tidur : ' . (isset($modAnamnesa->lamatidur_jam_hari) ? $modAnamnesa->lamatidur_jam_hari : "-") . ' jam/Hari, masalah : ' .
                (($modAnamnesa->masalah == 1) ? "Ada" : "Tidak Ada");
            ?>
        </li>
        <li>
            <?php
            echo 'Pola Istirahat Tidur :<br>Kegiatan : ' . (($modAnamnesa->kegiatan_aktivitas == 1) ? "Ada" : "Tidak Ada") . '          Olah Raga : ' .
                (($modAnamnesa->olahraga == 1) ? "Ya" : "Tidak");
            ?>
        </li>
        <li>
            <?php
            echo 'Gaya Hidup :<br>Merokok : ' . (($modAnamnesa->statusmerokok == 1) ? "Ya" : "Tidak ") . ' <br> Minuman Keras :' .
                (($modAnamnesa->minumankeras == 1) ? "Ya" : "Tidak") . ' <br> Ketergantungan Obat :' .
                (($modAnamnesa->ketergantunganobat == 1) ? "Ya" : "Tidak");
            ?>
        </li>
    </ol>
    <?php echo '<b>III. PEMERIKSAAN FISIK</b>'; ?>
    <p><?php echo 'A. Keadaan Umum '; ?></p>
    <ol>
        <li>
            <?php echo 'Kesadaran : ' . (isset($modPeriksaFisik->keadaanumum) ? $modPeriksaFisik->keadaanumum : "-"); ?>
        </li>
        <li>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="50%">
                        <?php echo 'BB saat ini : ' . (isset($modPeriksaFisik->beratbadan_kg) ? $modPeriksaFisik->beratbadan_kg : "-") . ' Kg'; ?>
                    </td>
                    <td width="50%">
                        <?php echo 'BB sebelum hamil : ' . (isset($modPeriksaFisik->bbsebelumhamil_kg) ? $modPeriksaFisik->bbsebelumhamil_kg : "-") . ' Kg'; ?>
                    </td>
                </tr>
            </table>
        </li>
        <li>
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="25%">
                        TD : <?php echo (isset($modPeriksaFisik->tekanandarah) ? $modPeriksaFisik->tekanandarah : "-"); ?> mmHg
                    </td>
                    <td width="25%">
                        Nadi : <?php echo (isset($modPeriksaFisik->detaknadi) ? $modPeriksaFisik->detaknadi : "-"); ?> x/menit
                    </td>
                    <td width="25%">
                        Pernapasan : <?php echo (isset($modPeriksaFisik->pernapasan) ? $modPeriksaFisik->pernapasan : "-"); ?> x/menit
                    </td>
                    <td width="25%">
                        Suhu : <?php echo (isset($modPeriksaFisik->suhutubuh) ? $modPeriksaFisik->suhutubuh : "-"); ?>
                    </td>
                </tr>
            </table>
        </li>
    </ol>
    <p>B. Pemeriksaan Sistematis</p>
    <ol>
        <li>
            <?php echo 'Kepala : '; ?><br>
            <p><?php
                echo 'a. Rambut : ' .
                    (($modPeriksaFisik->rambut_mengkilat == 1) ? "Mengkilat, " : "") .
                    (($modPeriksaFisik->rambut_kusam == 1) ? "Kusam, " : "") .
                    (($modPeriksaFisik->rambut_mudahrontok == 1) ? "Mudah Ronto, " : "") .
                    (($modPeriksaFisik->rambut_kotor == 1) ? "Kotor, " : "") .
                    (($modPeriksaFisik->rambut_bersih == 1) ? "Bersih, " : "");
                ?></p>
            <p><?php
                echo 'b. Mata : ' .
                    'konjungtiva : ' . (($modPeriksaFisik->mata_konjungtiva_anemis == 1) ? "Anemis" : "Tidak") .
                    ', sklera : ' . (($modPeriksaFisik->mata_sklera_ikterik == 1) ? "Ikterik" : "Tidak") .
                    ', penglihatan : ' . (($modPeriksaFisik->mata_penglihatan == 1) ? "Jelas" : "Tidak Jelas");
                ?></p>
            <p><?php
                echo 'c. Hidung : ' .
                    (($modPeriksaFisik->hidung_bersih == 1) ? "Bersih" : "Kotor") .
                    ', sumbatan jalan nafas : ' . (($modPeriksaFisik->sumbatanjalannafas == 1) ? "Ada" : "Tidak Ada");
                ?></p>
            <p><?php
                echo 'd. Mulut : ' .
                    'bibir : ' . (($modPeriksaFisik->bibir_simetris == 1) ? "Simetris" : "Tidak Simetris") .
                    ', jumlah gigi : ' . (isset($modPeriksaFisik->jumlahgigi_buah) ? $modPeriksaFisik->jumlahgigi_buah : "-") .
                    ', karies : ' . (($modPeriksaFisik->gigi_karies == 1) ? "Ya" : "Tidak");
                ?></p>
            <p><?php
                echo 'e. Leher : ' .
                    'Kelenjar tiroid : ' . (($modPeriksaFisik->leher_kelenjartiroid_teraba == 1) ? "Teraba" : "Tidak Teraba") .
                    ', Kelenjar getah bening : ' . (($modPeriksaFisik->leher_kelgetahbening_teraba == 1) ? "Teraba" : "Tidak Teraba");
                ?></p>
        </li>
        <li>
            <?php echo 'Dada : '; ?><br>
            <p><?php
                echo 'Bentuk mamae : ' . (($modPeriksaFisik->dada_bentukmamae_simetris == 1) ? "Simetris" : "Tidak Simetris") .
                    ', Tumor : ' . (($modPeriksaFisik->dada_tumor == 1) ? "Ada" : "Tidak Ada");
                ?></p>
            <p><?php echo 'Puting Susu : ' . (isset($modPeriksaFisik->dada_putingsusu) ? $modPeriksaFisik->dada_putingsusu : "-"); ?></p>
            <p><?php
                echo 'Kolostrum : ' . (($modPeriksaFisik->dada_kolostrum == 1) ? "Ada" : "Tidak Ada") .
                    ', Warna areola : ' . (isset($modPeriksaFisik->dada_warnaareola) ? $modPeriksaFisik->dada_warnaareola : "-");
                ?></p>
        </li>
        <li>
            <?php echo 'Ekstremitas : '; ?><br>
            <p><?php
                echo 'Bentuk : ' . (($modPeriksaFisik->bentuk_ekstremitas == 1) ? "Simetris" : "Tidak Simetris") .
                    '<br>Kelainan : ' .
                    (($modPeriksaFisik->ekstremitas_kelainan_oedema == 1) ? "Oedema, " : "") .
                    (($modPeriksaFisik->ekstremitas_kelainan_varies == 1) ? "Varies, " : "") .
                    (($modPeriksaFisik->ekstremitas_kelainan_parese == 1) ? "Parese, " : "") .
                    (($modPeriksaFisik->ekstremitas_kelainan_atropi == 1) ? "Atropi, " : "") .
                    '<br>Kekuatan otot : ' . (isset($modPeriksaFisik->kekuatanotot) ? $modPeriksaFisik->kekuatanotot : "-");
                ?></p>
        </li>
    </ol>
    <p>C. Pemeriksaan Khusus Obstetri</p>
    <ol>
        <li>
            <?php echo 'Abdomen : '; ?><br>
            <p>
                <?php
                echo 'Inspeksi : ' .
                    (($modPeriksaFisik->abdo_insp_pelebaranvena == 1) ? "Pelebaran Vena, " : "") .
                    (($modPeriksaFisik->abdo_insp_nigra == 1) ? "Linea Alba/Nigra, " : "") .
                    (($modPeriksaFisik->abdo_insp_striae == 1) ? "Striae Albican, " : "");
                ?>
            </p>
            <p>
                <?php
                echo 'Palpasi : <br>' .
                    'Kontraksi : ' . (($modPeriksaFisik->kontraksi_palpasi == 1) ? "Ada" : "Tidak Ada") .
                    ', Keterangan : ' . (isset($modPeriksaFisik->ketkontraksi) ? $modPeriksaFisik->ketkontraksi : "-") .
                    '<br>Leopold I : <br>' .
                    '<ul><li>TFU : ' . (isset($modPeriksaFisik->leopold1_tfu) ? $modPeriksaFisik->leopold1_tfu : "-") . '</li>' .
                    '<li>FU Terisi : ' . (isset($modPeriksaFisik->leopold1_tfu) ? $modPeriksaFisik->leopold1_tfu : "-") . '</li></ul>' .
                    '<br>Leopold II : Kanan : ' . (isset($modPeriksaFisik->leopold2_kanan) ? $modPeriksaFisik->leopold2_kanan : "-") .
                    ', Kiri : ' . (isset($modPeriksaFisik->leopold2_kiri) ? $modPeriksaFisik->leopold2_kiri : "-") .
                    '<br>Leopold III : Bagian bawah terisi : ' . (isset($modPeriksaFisik->leopold3_bagbawahterisi) ? $modPeriksaFisik->leopold3_bagbawahterisi : "-") .
                    '<br>Leopold IV : <img height="20px;" width="20px;" src =' . $modPeriksaFisik->leopold4_pathgambar . '>';
                ?>
            </p>
            <p>
                <?php
                echo 'Auskultasi : Frekuensi : ' . (isset($modPeriksaFisik->frek_auskultasi) ? $modPeriksaFisik->frek_auskultasi : "-") . ' x/Menit , Teratur : ' . (($modPeriksaFisik->frekuensiteratur == 1) ? "Teratur" : "Tidak");
                ?>
            </p>
        </li>
        <li>
            <?php echo 'Genitalia : '; ?><br>
            <p><?php echo 'Kelainan : ' . (isset($modPeriksaFisik->kelainan_genitalia) ? $modPeriksaFisik->kelainan_genitalia : "-"); ?></p>
            <p><?php echo 'Pengeluaran : ' . (isset($modPeriksaFisik->pengeluaran_genitalia) ? $modPeriksaFisik->pengeluaran_genitalia : "-"); ?></p>
            <?php echo 'Periksa dalam (vaginal toucher) : '; ?><br>
            <ul>
                <li>
                    <?php echo 'Vaginal : ' . (isset($modPeriksaFisik->vaginal_genitalia) ? $modPeriksaFisik->vaginal_genitalia : "-"); ?>
                </li>
                <li>
                    <?php echo 'Portio : ' . (isset($modPeriksaFisik->portio_genitalia) ? $modPeriksaFisik->portio_genitalia : "-"); ?>
                </li>
                <li>
                    <?php echo 'Pembukaan : ' . (isset($modPeriksaFisik->pembukaan_genitalia) ? $modPeriksaFisik->pembukaan_genitalia : "-"); ?>
                </li>
                <li>
                    <?php echo 'Ketuban : ' . (isset($modPeriksaFisik->ketuban_genitalia) ? $modPeriksaFisik->ketuban_genitalia : "-"); ?>
                </li>
                <li>
                    <?php echo 'Presentasi : ' . (isset($modPeriksaFisik->presentasi_genitalia) ? $modPeriksaFisik->presentasi_genitalia : "-"); ?>
                </li>
                <li>
                    <?php echo 'Posisi : ' . (isset($modPeriksaFisik->posisi_genitalia) ? $modPeriksaFisik->posisi_genitalia : "-"); ?>
                </li>
                <li>
                    <?php echo 'Penurunan : ' . (isset($modPeriksaFisik->penurunan_genitalia) ? $modPeriksaFisik->penurunan_genitalia : "-"); ?>
                </li>
            </ul>
        </li>
    </ol>
    <?php echo '<b>IV. PEMERIKSAAN PENUNJANG</b>'; ?>
    <br>
    <br>
    <?php if (!empty($modPenunjang)) { ?>
        <div class="row">
            <div class='block-tabel'>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'penunjang-grid',
                    'enableSorting' => false,
                    'template' => "{items}",
                    'dataProvider' => $modPenunjang,
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'Tanggal',
                            'name' => 'datapenunjang_tgl',
                            'value' => 'isset($data->datapenunjang_tgl) ? MyFormatter::FormatDateTimeForUser($data->datapenunjang_tgl) : " - "',
                        ),
                        array(
                            'header' => 'Data Penunjang',
                            'name' => 'datapenunjang_nama',
                            'value' => '$data->datapenunjang_nama'
                        )
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
                ));
                ?>
            </div>
        </div>
    <?php } ?>
    <table class="table">
        <tr>
            <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">

            </th>
            <th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
                <?php echo $modProfile->kabupaten->kabupaten_nama . ' , ' . MyFormatter::formatDateTimeForUser(date("Y-m-d")); ?>
                <br>
                Bidan
                <br><br><br><br><br><br>
                ( <?php echo (isset($modPengkajian->pegawai->nama_pegawai) ? $modPengkajian->pegawai->nama_pegawai : ""); ?> )
            </th>
        </tr>
    </table>
</div>