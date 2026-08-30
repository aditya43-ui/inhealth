<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 11));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <div>
            <fieldset>
                <legend>Data Pegawai</legend>
                <table class="table-striped">
                    <tr>
                        <!--====================== kolom ke-1 ==============================================-->
                        <td>
                            NIP : <?php echo $model->nomorindukpegawai; ?></td>
                        <td></td>
                        <td>Jenis Kelamin :<?php echo $model->jeniskelamin; ?></td>

                        <td rowspan="4">
                            <?php
                            if (!empty($model->photopasien)) {
                                echo CHtml::image(Params::urlPasienTumbsDirectory() . 'kecil_' . $model->photopasien, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                            } else {
                                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nama Pegawai :<?php echo $model->nama_pegawai; ?></td>
                        <td></td>
                        <td>Status Perkawinan :<?php echo $model->statusperkawinan; ?></td>
                    </tr>
                    <tr>
                        <td>Tempat, Tgl. Lahir :<?php echo $model->tempatlahir_pegawai; ?>
                            <?php echo MyFormatter::formatDateTimeForUser($model->tgl_lahirpegawai); ?></td>
                        <td></td>
                        <td>Jabatan :<?php echo isset($model->jabatan_id) ? $model->jabatan->jabatan_nama : "-"; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Pegawai :<?php echo isset($model->alamat_pegawai) ? $model->alamat_pegawai : "-"; ?><td>
                        <td></td>
                        <td><td>
                        <td><td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="row">

            <!--==================================== View Riwayat diklat =============================-->
            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaidiklat">
                <thead>
                    <tr>
                        <th colspan="10" bgcolor="white">Pegawai Diklat</th>
                    </tr>
                    <tr>
                        <th rowspan="2">No. urut</th>
                        <th rowspan="2">Jenis diklat</th>
                        <th rowspan="2">Nama diklat</th>
                        <th rowspan="2">Tgl. mulai diklat</th>
                        <th rowspan="2">Lama diklat</th>
                        <th rowspan="2">Tempat</th>
                        <th colspan="3" style="text-align:center;">Keputusan diklat</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Tgl. penetapan</th>
                        <th>Nama pimpinan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modPegawaidiklat as $a => $data_diklat) {
                        ?>
                        <tr>
                            <td><?php echo ($a + 1); ?></td>
                            <td><?php echo $data_diklat->jenisdiklat->jenisdiklat_nama; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_nama; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_tahun; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_lamanya; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_tempat; ?></td>
                            <td><?php echo $data_diklat->nomorkeputusandiklat; ?></td>
                            <td><?php echo $data_diklat->tglditetapkandiklat; ?></td>
                            <td><?php echo $data_diklat->pejabatygmemdiklat; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_keterangan; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--==================================== Akhir view Riwayat diklat =============================-->
            <!--==================================== View Riwayat pengalaman kerja =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPengalamankerja">
                        <thead>
                            <tr>
                                <th colspan="9" bgcolor="white">Pengalaman Kerja</th>
                            </tr>
                            <tr>
                                <th>No. urut</th>
                                <th>Nama perusahaan</th>
                                <th>Bidang usaha</th>
                                <th>Jabatan</th>
                                <th>Tgl. masuk</th>
                                <th>Tgl. keluar</th>
                                <th>Lama kerja</th>
                                <th>Alasan berhenti</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPengalamankerja as $b => $data_pengalaman) {
                                ?>
                                <tr>
                                    <td><?php echo ($b + 1); ?></td>
                                    <td><?php echo $data_pengalaman->namaperusahaan; ?></td>
                                    <td><?php echo $data_pengalaman->bidangperusahaan; ?></td>
                                    <td><?php echo $data_pengalaman->jabatanterahkir; ?></td>
                                    <td><?php echo $data_pengalaman->tglmasuk; ?></td>
                                    <td><?php echo $data_pengalaman->tglkeluar; ?></td>
                                    <td><?php echo $data_pengalaman->lama_tahun . " " . $data_pengalaman->lama_bulan . " bulan"; ?></td>
                                    <td><?php echo $data_pengalaman->alasanberhenti; ?></td>
                                    <td><?php echo $data_pengalaman->keterangan; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat pengalaman kerja =============================-->
            <!--==================================== View Riwayat jabatan =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatJabatan">
                        <thead>
                            <tr>
                                <th colspan="7" bgcolor="white">Jabatan Pegawai</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>No. SK</th>
                                <th>Tgl. ditetapkan</th>
                                <th>TMT jabatan</th>
                                <th>Tgl. akhir jabatan</th>
                                <th>Keterangan</th>
                                <th>Pejabat yang menjabatkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPegawaijabatan as $b => $data_jabatan) {
                                ?>
                                <tr>
                                    <td><?php echo ($b + 1); ?></td>
                                    <td><?php echo $data_jabatan->nomorkeputusanjabatan; ?></td>
                                    <td><?php echo $data_jabatan->tglditetapkanjabatan; ?></td>
                                    <td><?php echo $data_jabatan->tmtjabatan; ?></td>
                                    <td><?php echo $data_jabatan->tglakhirjabatan; ?></td>
                                    <td><?php echo $data_jabatan->keterangan; ?></td>
                                    <td><?php echo $data_jabatan->pejabatygmemjabatan; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat jabatan =============================-->
            <!--==================================== View Riwayat Pegawai mutasi =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegmutasi">
                        <thead>
                            <tr>
                                <th colspan="11" bgcolor="white">Mutasi Pegawai</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>No. Surat</th>
                                <th>Jabatan</th>
                                <th>Pangkat</th>
                                <th>No. SK</th>
                                <th>Tgl. SK</th>
                                <th>TMT SK</th>
                                <th>Jabatan baru</th>
                                <th>Pangkat baru</th>
                                <th>Mengetahui</th>
                                <th>Pimpinan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPegmutasi as $d => $data_mutasi) {
                                ?>
                                <tr>
                                    <td><?php echo ($d + 1); ?></td>
                                    <td><?php echo $data_mutasi->nomorsurat; ?></td>
                                    <td><?php echo $data_mutasi->jabatan_nama; ?></td>
                                    <td><?php echo $data_mutasi->pangkat_nama; ?></td>
                                    <td><?php echo $data_mutasi->nosk; ?></td>
                                    <td><?php echo $data_mutasi->tglsk; ?></td>
                                    <td><?php echo $data_mutasi->tmtsk; ?></td>
                                    <td><?php echo $data_mutasi->jabatan_baru; ?></td>
                                    <td><?php echo $data_mutasi->pangkat_baru; ?></td>
                                    <td><?php echo $data_mutasi->mengetahui_nama; ?></td>
                                    <td><?php echo $data_mutasi->pimpinan_nama; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat pegawai mutasi =============================-->
            <!--==================================== View Riwayat Pegawai cuti =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaicuti">
                        <thead>
                            <tr>
                                <th colspan="10" bgcolor="white">Cuti Pegawai</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Jenis cuti</th>
                                <th>Tgl. mulai</th>
                                <th>Lama cuti</th>
                                <th>No. SK</th>
                                <th>Tgl. SK</th>
                                <th>Keperluan</th>
                                <th>Keterangan</th>
                                <th>Pejabat mengetahui</th>
                                <th>Pejabat menyetujui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPegawaicuti as $e => $data_cuti) {
                                ?>
                                <tr>
                                    <td><?php echo ($e + 1); ?></td>
                                    <td><?php echo $data_cuti->jeniscuti->jeniscuti_nama; ?></td>
                                    <td><?php echo $data_cuti->tglmulaicuti . " s/d " . $data_cuti->tglakhircuti; ?></td>
                                    <td><?php echo $data_cuti->lamacuti . " hari"; ?></td>
                                    <td><?php echo $data_cuti->noskcuti; ?></td>
                                    <td><?php echo $data_cuti->tglditetapkanskcuti; ?></td>
                                    <td><?php echo $data_cuti->keperluancuti; ?></td>
                                    <td><?php echo $data_cuti->keterangan; ?></td>
                                    <td><?php echo $data_cuti->pejabatmengetahui; ?></td>
                                    <td><?php echo $data_cuti->pejabatmenyetujui; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat pegawai cuti =============================-->
            <!--==================================== View Riwayat Izin tugas belajar =============================-->
            <fieldset id="">
                <div>
                    <div class="">    
                        <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatIjintugasbelajar">
                            <thead>
                                <tr>
                                    <th colspan="6" bgcolor="white">Izin Tugas Belajar</th>
                                </tr>
                                <tr>
                                    <th>No.</th>
                                    <th>Tgl. Mulai Belajar</th>
                                    <th>Nomor Keputusan</th>
                                    <th>Tgl. Ditetapkan</th>
                                    <th>Keterangan</th>
                                    <th>Pejabat yang Memutuskan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($modIzintugasbelajar as $f => $data_belajar) {
                                    ?>
                                    <tr>
                                        <td><?php echo ($f + 1); ?></td>
                                        <td><?php echo $data_belajar->tglmulaibelajar; ?></td>
                                        <td><?php echo $data_belajar->nomorkeputusan; ?></td>
                                        <td><?php echo $data_belajar->tglditetapkan; ?></td>
                                        <td><?php echo $data_belajar->keteranganizin; ?></td>
                                        <td><?php echo $data_belajar->pejabatmemutuskan; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat Izin tugas belajar =============================-->
            <!--==================================== View Riwayat Hukuman disiplin =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatHukdisiplin">

                        <thead>
                            <tr>
                                <th colspan="8" bgcolor="white">Hukuman Disiplin</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Jenis hukuman</th>
                                <th>Jabatan</th>
                                <th>Tgl. hukuman</th>
                                <th>Ruangan pegawai</th>
                                <th>No. SK</th>
                                <th>Lama hukuman</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modHukdisiplin as $g => $data_hukum) {
                                ?>
                                <tr>
                                    <td><?php echo ($g + 1); ?></td>
                                    <td><?php echo $data_hukum->jnshukdisiplin->jnshukdisiplin_nama; ?></td>
                                    <td><?php echo $data_hukum->jabatan->jabatan_nama; ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_tglhukuman; ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_ruangan; ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_nosk; ?></td>
                                    <td><?php echo (isset($row->hukdisiplin_lamabln) ? $row->hukdisiplin_lamabln . "bulan" : '-'); ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_keterangan; ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </fieldset>

            <!--======================================== View Riwayat Pengorganisasian Pegawai ==================================-->
            <fieldset id="">
                <div>

                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatOrganisasi">
                        <thead>
                            <tr>
                                <th colspan="6" bgcolor="white">Pengorganisasian Pegawai</th>
                            </tr>
                            <tr>
                                <th>No. Urut</th>
                                <th>Nama Organisasi</th>
                                <th>Kedudukan</th>
                                <th>Tanggal Mulai</th>
                                <th>Lama</th>
                                <th>Tempat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modOrganisasi as $h => $data_organisasi) {
                                ?>
                                <tr>
                                    <td><?php echo ($h + 1); ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_nama; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_kedudukan; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_tahun; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_lamanya; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_tempat; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--========================================== View Riwayat Susunan Keluarga ===========================================-->

            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatSusunanKeluarga">
                <thead>
                    <tr>
                        <th colspan="12" bgcolor="white">Susunan Keluarga</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>No. Urut</th>
                        <th>Hubungan Keluarga</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Pekerjaan</th>
                        <th>Pendidikan</th>
                        <th>Tanggal Pernikahan</th>
                        <th>Tempat Pernikahan</th>
                        <th>NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modSusunanKel as $j => $data_susunankel) {
                        ?>
                        <tr>
                            <td><?php echo ($j + 1); ?></td>
                            <td><?php echo $data_susunankel->nourutkel; ?></td>
                            <td><?php echo $data_susunankel->hubkeluarga; ?></td>
                            <td><?php echo $data_susunankel->susunankel_nama; ?></td>
                            <td><?php echo $data_susunankel->susunankel_jk; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tempatlahir; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tanggallahir; ?></td>
                            <td><?php echo $data_susunankel->pekerjaan_nama; ?></td>
                            <td><?php echo $data_susunankel->pendidikan_nama; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tanggalpernikahan; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tempatpernikahan; ?></td>
                            <td><?php echo $data_susunankel->susunankeluarga_nip; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--======================================= View Riwayat Prestasi Kerja =================================================-->

            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPrestasiKerja">
                        <thead>
                            <tr>
                                <th colspan="7" bgcolor="white">Prestasi Kerja</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>No. Urut</th>
                                <th>Tanggal Perolehan</th>
                                <th>Instansi Pemberi</th>
                                <th>Penjabat Pemberi</th>
                                <th>Nama Penghargaan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPrestasi as $k => $data_prestasi) {
                                ?>
                                <tr>
                                    <td><?php echo ($k + 1); ?></td>
                                    <td><?php echo $data_prestasi->nourutprestasi; ?></td>
                                    <td><?php echo $data_prestasi->tglprestasidiperoleh; ?></td>
                                    <td><?php echo $data_prestasi->instansipemberi; ?></td>
                                    <td><?php echo $data_prestasi->pejabatpemberi; ?></td>
                                    <td><?php echo $data_prestasi->namapenghargaan; ?></td>
                                    <td><?php echo $data_prestasi->keteranganprestasi; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--========================================= View Riwayat Perjalanan Dinas ================================-->

            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPerjalananDinas">
                <thead>
                    <tr>
                        <th colspan="11" bgcolor="white">Perjalanan Dinas</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>No. Urut</th>
                        <th>Tujuan Dinas</th>
                        <th>Tugas Dinas</th>
                        <th>Keterangan</th>
                        <th>Alamat Tujuan</th>
                        <th>Provinsi</th>
                        <th>Kota</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Negara Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modDinas as $o => $data_dinas) {
                        ?>
                        <tr>
                            <td><?php echo ($o + 1); ?></td>
                            <td><?php echo $data_dinas->nourutperj; ?></td>
                            <td><?php echo $data_dinas->tujuandinas; ?></td>
                            <td><?php echo $data_dinas->tugasdinas; ?></td>
                            <td><?php echo $data_dinas->descdinas; ?></td>
                            <td><?php echo $data_dinas->alamattujuan; ?></td>
                            <td><?php echo $data_dinas->propinsi_nama; ?></td>
                            <td><?php echo $data_dinas->kotakabupaten_nama; ?></td>
                            <td><?php echo $data_dinas->tglmulaidinas; ?></td>
                            <td><?php echo $data_dinas->sampaidengan; ?></td>
                            <td><?php echo $data_dinas->negaratujuan; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!--======================================== View Riwayat Penggajian Pegawai ==================================-->
            <fieldset id="">
                <div>       
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPenggajian">
                        <thead>
                            <tr>
                                <th colspan="8" bgcolor="white">Penggajian Pegawai</th>
                            </tr>
                            <tr>
                                <th>No. Urut</th>
                                <th>Periode Gaji</th>
                                <th>Pegawai</th>
                                <th>Keluarga</th>
                                <th>Tanggal Penggajian</th>
                                <th>No. Penggajian</th>
                                <th>Penerimaan Bersih</th>
                                <th>Total Pajak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPenggajian as $n => $data_penggajian) {
                                ?>
                                <tr>
                                    <td><?php echo ($n + 1); ?></td>
                                    <td><?php echo (isset($data_penggajian->periodegaji) ? $data_penggajian->periodegaji : '-'); ?></td>
                                    <td><?php echo (isset($data_penggajian->gelardepan) ? $data_penggajian->gelardepan . $data_penggajian->nama_pegawai : $data_penggajian->nama_pegawai); ?></td>
                                    <td><?php echo (isset($data_penggajian->nama_keluarga) ? $data_penggajian->nama_keluarga : '-'); ?></td>
                                    <td><?php echo MyFormatter::formatDateTimeForUser($data_penggajian->tglpenggajian); ?></td>
                                    <td><?php echo $data_penggajian->nopenggajian; ?></td>
                                    <td><?php echo $data_penggajian->penerimaanbersih; ?></td>
                                    <td><?php echo $data_penggajian->totalpajak; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaidiklat">
                <thead>
                    <tr>
                        <th colspan="11" bgcolor="white">Pendidikan Pegawai</th>
                    </tr>
                    <tr>
                        <th rowspan="2">No. urut</th>
                        <th rowspan="2">Pendidikan</th>
                        <th rowspan="2">Nama Sekolah / Universitas</th>
                        <th rowspan="2">Alamat Sekolah / Universitas</th>
                        <th rowspan="2">Tgl. masuk</th>
                        <th rowspan="2">Lama pendidikan</th>
                        <th colspan="3" style="text-align:center;">Kolom ijazah</th>
                        <th rowspan="2">Nilai lulus / grade lulus</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Tgl. Ijazah</th>
                        <th>Tanda tangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modPendidikanpegawai as $i => $data_pegawai) {
                        ?>
                        <tr>
                            <td><?php echo ($i + 1); ?></td>
                            <td><?php echo $data_pegawai->pendidikan->pendidikan_nama; ?></td>
                            <td><?php echo $data_pegawai->namasek_univ; ?></td>
                            <td><?php echo $data_pegawai->almtsek_univ; ?></td>
                            <td><?php echo $data_pegawai->tglmasuk; ?></td>
                            <td><?php echo $data_pegawai->lamapendidikan_bln . " Bulan"; ?></td>
                            <td><?php echo $data_pegawai->no_ijazah_sert; ?></td>
                            <td><?php echo $data_pegawai->tgl_ijazah_sert; ?></td>
                            <td><?php echo $data_pegawai->nilailulus . " / " . $data_pegawai->gradelulus; ?></td>										
                            <td></td>
                            <td><?php echo isset($data_pegawai->keteranganpend) ? $data_pegawai->keteranganpend : "-"; ?></td>										
                        <tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <?php
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'EXCEL') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <div>
                            <fieldset>
                                <legend>Data Pegawai</legend>
                                <table class="table-striped">
                                    <tr>
                                        <!--====================== kolom ke-1 ==============================================-->
                                        <td>
                                            NIP : <?php echo $model->nomorindukpegawai; ?></td>
                                        <td></td>
                                        <td>Jenis Kelamin :<?php echo $model->jeniskelamin; ?></td>

                                        <td rowspan="4">
                                            <?php
                                            if (!empty($model->photopasien)) {
                                                echo CHtml::image(Params::urlPasienTumbsDirectory() . 'kecil_' . $model->photopasien, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                                            } else {
                                                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                                            }
                                            ?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nama Pegawai :<?php echo $model->nama_pegawai; ?></td>
                                        <td></td>
                                        <td>Status Perkawinan :<?php echo $model->statusperkawinan; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tempat, Tgl. Lahir :<?php echo $model->tempatlahir_pegawai; ?>
                                            <?php echo MyFormatter::formatDateTimeForUser($model->tgl_lahirpegawai); ?></td>
                                        <td></td>
                                        <td>Jabatan :<?php echo isset($model->jabatan_id) ? $model->jabatan->jabatan_nama : "-"; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat Pegawai :<?php echo isset($model->alamat_pegawai) ? $model->alamat_pegawai : "-"; ?><td>
                                        <td></td>
                                        <td><td>
                                        <td><td>
                                    </tr>
                                </table>
                            </fieldset>
                        </div>
                        <div class="row">

                            <!--==================================== View Riwayat diklat =============================-->
                            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaidiklat">
                                <thead>
                                    <tr>
                                        <th colspan="10" bgcolor="white">Pegawai Diklat</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">No. urut</th>
                                        <th rowspan="2">Jenis diklat</th>
                                        <th rowspan="2">Nama diklat</th>
                                        <th rowspan="2">Tgl. mulai diklat</th>
                                        <th rowspan="2">Lama diklat</th>
                                        <th rowspan="2">Tempat</th>
                                        <th colspan="3" style="text-align:center;">Keputusan diklat</th>
                                        <th rowspan="2">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tgl. penetapan</th>
                                        <th>Nama pimpinan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($modPegawaidiklat as $a => $data_diklat) {
                                        ?>
                                        <tr>
                                            <td><?php echo ($a + 1); ?></td>
                                            <td><?php echo $data_diklat->jenisdiklat->jenisdiklat_nama; ?></td>
                                            <td><?php echo $data_diklat->pegawaidiklat_nama; ?></td>
                                            <td><?php echo $data_diklat->pegawaidiklat_tahun; ?></td>
                                            <td><?php echo $data_diklat->pegawaidiklat_lamanya; ?></td>
                                            <td><?php echo $data_diklat->pegawaidiklat_tempat; ?></td>
                                            <td><?php echo $data_diklat->nomorkeputusandiklat; ?></td>
                                            <td><?php echo $data_diklat->tglditetapkandiklat; ?></td>
                                            <td><?php echo $data_diklat->pejabatygmemdiklat; ?></td>
                                            <td><?php echo $data_diklat->pegawaidiklat_keterangan; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!--==================================== Akhir view Riwayat diklat =============================-->
                            <!--==================================== View Riwayat pengalaman kerja =============================-->
                            <fieldset id="">
                                <div>
                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPengalamankerja">
                                        <thead>
                                            <tr>
                                                <th colspan="9" bgcolor="white">Pengalaman Kerja</th>
                                            </tr>
                                            <tr>
                                                <th>No. urut</th>
                                                <th>Nama perusahaan</th>
                                                <th>Bidang usaha</th>
                                                <th>Jabatan</th>
                                                <th>Tgl. masuk</th>
                                                <th>Tgl. keluar</th>
                                                <th>Lama kerja</th>
                                                <th>Alasan berhenti</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modPengalamankerja as $b => $data_pengalaman) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($b + 1); ?></td>
                                                    <td><?php echo $data_pengalaman->namaperusahaan; ?></td>
                                                    <td><?php echo $data_pengalaman->bidangperusahaan; ?></td>
                                                    <td><?php echo $data_pengalaman->jabatanterahkir; ?></td>
                                                    <td><?php echo $data_pengalaman->tglmasuk; ?></td>
                                                    <td><?php echo $data_pengalaman->tglkeluar; ?></td>
                                                    <td><?php echo $data_pengalaman->lama_tahun . " " . $data_pengalaman->lama_bulan . " bulan"; ?></td>
                                                    <td><?php echo $data_pengalaman->alasanberhenti; ?></td>
                                                    <td><?php echo $data_pengalaman->keterangan; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <!--==================================== Akhir view Riwayat pengalaman kerja =============================-->
                            <!--==================================== View Riwayat jabatan =============================-->
                            <fieldset id="">
                                <div>
                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatJabatan">
                                        <thead>
                                            <tr>
                                                <th colspan="7" bgcolor="white">Jabatan Pegawai</th>
                                            </tr>
                                            <tr>
                                                <th>No.</th>
                                                <th>No. SK</th>
                                                <th>Tgl. ditetapkan</th>
                                                <th>TMT jabatan</th>
                                                <th>Tgl. akhir jabatan</th>
                                                <th>Keterangan</th>
                                                <th>Pejabat yang menjabatkan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modPegawaijabatan as $b => $data_jabatan) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($b + 1); ?></td>
                                                    <td><?php echo $data_jabatan->nomorkeputusanjabatan; ?></td>
                                                    <td><?php echo $data_jabatan->tglditetapkanjabatan; ?></td>
                                                    <td><?php echo $data_jabatan->tmtjabatan; ?></td>
                                                    <td><?php echo $data_jabatan->tglakhirjabatan; ?></td>
                                                    <td><?php echo $data_jabatan->keterangan; ?></td>
                                                    <td><?php echo $data_jabatan->pejabatygmemjabatan; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <!--==================================== Akhir view Riwayat jabatan =============================-->
                            <!--==================================== View Riwayat Pegawai mutasi =============================-->
                            <fieldset id="">
                                <div>
                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegmutasi">
                                        <thead>
                                            <tr>
                                                <th colspan="11" bgcolor="white">Mutasi Pegawai</th>
                                            </tr>
                                            <tr>
                                                <th>No.</th>
                                                <th>No. Surat</th>
                                                <th>Jabatan</th>
                                                <th>Pangkat</th>
                                                <th>No. SK</th>
                                                <th>Tgl. SK</th>
                                                <th>TMT SK</th>
                                                <th>Jabatan baru</th>
                                                <th>Pangkat baru</th>
                                                <th>Mengetahui</th>
                                                <th>Pimpinan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modPegmutasi as $d => $data_mutasi) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($d + 1); ?></td>
                                                    <td><?php echo $data_mutasi->nomorsurat; ?></td>
                                                    <td><?php echo $data_mutasi->jabatan_nama; ?></td>
                                                    <td><?php echo $data_mutasi->pangkat_nama; ?></td>
                                                    <td><?php echo $data_mutasi->nosk; ?></td>
                                                    <td><?php echo $data_mutasi->tglsk; ?></td>
                                                    <td><?php echo $data_mutasi->tmtsk; ?></td>
                                                    <td><?php echo $data_mutasi->jabatan_baru; ?></td>
                                                    <td><?php echo $data_mutasi->pangkat_baru; ?></td>
                                                    <td><?php echo $data_mutasi->mengetahui_nama; ?></td>
                                                    <td><?php echo $data_mutasi->pimpinan_nama; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <!--==================================== Akhir view Riwayat pegawai mutasi =============================-->
                            <!--==================================== View Riwayat Pegawai cuti =============================-->
                            <fieldset id="">
                                <div>
                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaicuti">
                                        <thead>
                                            <tr>
                                                <th colspan="10" bgcolor="white">Cuti Pegawai</th>
                                            </tr>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jenis cuti</th>
                                                <th>Tgl. mulai</th>
                                                <th>Lama cuti</th>
                                                <th>No. SK</th>
                                                <th>Tgl. SK</th>
                                                <th>Keperluan</th>
                                                <th>Keterangan</th>
                                                <th>Pejabat mengetahui</th>
                                                <th>Pejabat menyetujui</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modPegawaicuti as $e => $data_cuti) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($e + 1); ?></td>
                                                    <td><?php echo $data_cuti->jeniscuti->jeniscuti_nama; ?></td>
                                                    <td><?php echo $data_cuti->tglmulaicuti . " s/d " . $data_cuti->tglakhircuti; ?></td>
                                                    <td><?php echo $data_cuti->lamacuti . " hari"; ?></td>
                                                    <td><?php echo $data_cuti->noskcuti; ?></td>
                                                    <td><?php echo $data_cuti->tglditetapkanskcuti; ?></td>
                                                    <td><?php echo $data_cuti->keperluancuti; ?></td>
                                                    <td><?php echo $data_cuti->keterangan; ?></td>
                                                    <td><?php echo $data_cuti->pejabatmengetahui; ?></td>
                                                    <td><?php echo $data_cuti->pejabatmenyetujui; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <!--==================================== Akhir view Riwayat pegawai cuti =============================-->
                            <!--==================================== View Riwayat Izin tugas belajar =============================-->
                            <fieldset id="">
                                <div>
                                    <div class="">    
                                        <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatIjintugasbelajar">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" bgcolor="white">Izin Tugas Belajar</th>
                                                </tr>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Tgl. Mulai Belajar</th>
                                                    <th>Nomor Keputusan</th>
                                                    <th>Tgl. Ditetapkan</th>
                                                    <th>Keterangan</th>
                                                    <th>Pejabat yang Memutuskan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($modIzintugasbelajar as $f => $data_belajar) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo ($f + 1); ?></td>
                                                        <td><?php echo $data_belajar->tglmulaibelajar; ?></td>
                                                        <td><?php echo $data_belajar->nomorkeputusan; ?></td>
                                                        <td><?php echo $data_belajar->tglditetapkan; ?></td>
                                                        <td><?php echo $data_belajar->keteranganizin; ?></td>
                                                        <td><?php echo $data_belajar->pejabatmemutuskan; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>
                            <!--==================================== Akhir view Riwayat Izin tugas belajar =============================-->
                            <!--==================================== View Riwayat Hukuman disiplin =============================-->
                            <fieldset id="">
                                <div>
                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatHukdisiplin">

                                        <thead>
                                            <tr>
                                                <th colspan="8" bgcolor="white">Hukuman Disiplin</th>
                                            </tr>
                                            <tr>
                                                <th>No.</th>
                                                <th>Jenis hukuman</th>
                                                <th>Jabatan</th>
                                                <th>Tgl. hukuman</th>
                                                <th>Ruangan pegawai</th>
                                                <th>No. SK</th>
                                                <th>Lama hukuman</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modHukdisiplin as $g => $data_hukum) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($g + 1); ?></td>
                                                    <td><?php echo $data_hukum->jnshukdisiplin->jnshukdisiplin_nama; ?></td>
                                                    <td><?php echo $data_hukum->jabatan->jabatan_nama; ?></td>
                                                    <td><?php echo $data_hukum->hukdisiplin_tglhukuman; ?></td>
                                                    <td><?php echo $data_hukum->hukdisiplin_ruangan; ?></td>
                                                    <td><?php echo $data_hukum->hukdisiplin_nosk; ?></td>
                                                    <td><?php echo (isset($row->hukdisiplin_lamabln) ? $row->hukdisiplin_lamabln . "bulan" : '-'); ?></td>
                                                    <td><?php echo $data_hukum->hukdisiplin_keterangan; ?></td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>

                            <!--======================================== View Riwayat Pengorganisasian Pegawai ==================================-->
                            <fieldset id="">
                                <div>

                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatOrganisasi">
                                        <thead>
                                            <tr>
                                                <th colspan="6" bgcolor="white">Pengorganisasian Pegawai</th>
                                            </tr>
                                            <tr>
                                                <th>No. Urut</th>
                                                <th>Nama Organisasi</th>
                                                <th>Kedudukan</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Lama</th>
                                                <th>Tempat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modOrganisasi as $h => $data_organisasi) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($h + 1); ?></td>
                                                    <td><?php echo $data_organisasi->pengorganisasi_nama; ?></td>
                                                    <td><?php echo $data_organisasi->pengorganisasi_kedudukan; ?></td>
                                                    <td><?php echo $data_organisasi->pengorganisasi_tahun; ?></td>
                                                    <td><?php echo $data_organisasi->pengorganisasi_lamanya; ?></td>
                                                    <td><?php echo $data_organisasi->pengorganisasi_tempat; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <!--========================================== View Riwayat Susunan Keluarga ===========================================-->

                            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatSusunanKeluarga">
                                <thead>
                                    <tr>
                                        <th colspan="12" bgcolor="white">Susunan Keluarga</th>
                                    </tr>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Urut</th>
                                        <th>Hubungan Keluarga</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tempat Lahir</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Pekerjaan</th>
                                        <th>Pendidikan</th>
                                        <th>Tanggal Pernikahan</th>
                                        <th>Tempat Pernikahan</th>
                                        <th>NIP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($modSusunanKel as $j => $data_susunankel) {
                                        ?>
                                        <tr>
                                            <td><?php echo ($j + 1); ?></td>
                                            <td><?php echo $data_susunankel->nourutkel; ?></td>
                                            <td><?php echo $data_susunankel->hubkeluarga; ?></td>
                                            <td><?php echo $data_susunankel->susunankel_nama; ?></td>
                                            <td><?php echo $data_susunankel->susunankel_jk; ?></td>
                                            <td><?php echo $data_susunankel->susunankel_tempatlahir; ?></td>
                                            <td><?php echo $data_susunankel->susunankel_tanggallahir; ?></td>
                                            <td><?php echo $data_susunankel->pekerjaan_nama; ?></td>
                                            <td><?php echo $data_susunankel->pendidikan_nama; ?></td>
                                            <td><?php echo $data_susunankel->susunankel_tanggalpernikahan; ?></td>
                                            <td><?php echo $data_susunankel->susunankel_tempatpernikahan; ?></td>
                                            <td><?php echo $data_susunankel->susunankeluarga_nip; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <!--======================================= View Riwayat Prestasi Kerja =================================================-->

                            <fieldset id="">
                                <div>
                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPrestasiKerja">
                                        <thead>
                                            <tr>
                                                <th colspan="7" bgcolor="white">Prestasi Kerja</th>
                                            </tr>
                                            <tr>
                                                <th>No.</th>
                                                <th>No. Urut</th>
                                                <th>Tanggal Perolehan</th>
                                                <th>Instansi Pemberi</th>
                                                <th>Penjabat Pemberi</th>
                                                <th>Nama Penghargaan</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modPrestasi as $k => $data_prestasi) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($k + 1); ?></td>
                                                    <td><?php echo $data_prestasi->nourutprestasi; ?></td>
                                                    <td><?php echo $data_prestasi->tglprestasidiperoleh; ?></td>
                                                    <td><?php echo $data_prestasi->instansipemberi; ?></td>
                                                    <td><?php echo $data_prestasi->pejabatpemberi; ?></td>
                                                    <td><?php echo $data_prestasi->namapenghargaan; ?></td>
                                                    <td><?php echo $data_prestasi->keteranganprestasi; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <!--========================================= View Riwayat Perjalanan Dinas ================================-->

                            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPerjalananDinas">
                                <thead>
                                    <tr>
                                        <th colspan="11" bgcolor="white">Perjalanan Dinas</th>
                                    </tr>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Urut</th>
                                        <th>Tujuan Dinas</th>
                                        <th>Tugas Dinas</th>
                                        <th>Keterangan</th>
                                        <th>Alamat Tujuan</th>
                                        <th>Provinsi</th>
                                        <th>Kota</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Negara Tujuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($modDinas as $o => $data_dinas) {
                                        ?>
                                        <tr>
                                            <td><?php echo ($o + 1); ?></td>
                                            <td><?php echo $data_dinas->nourutperj; ?></td>
                                            <td><?php echo $data_dinas->tujuandinas; ?></td>
                                            <td><?php echo $data_dinas->tugasdinas; ?></td>
                                            <td><?php echo $data_dinas->descdinas; ?></td>
                                            <td><?php echo $data_dinas->alamattujuan; ?></td>
                                            <td><?php echo $data_dinas->propinsi_nama; ?></td>
                                            <td><?php echo $data_dinas->kotakabupaten_nama; ?></td>
                                            <td><?php echo $data_dinas->tglmulaidinas; ?></td>
                                            <td><?php echo $data_dinas->sampaidengan; ?></td>
                                            <td><?php echo $data_dinas->negaratujuan; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <!--======================================== View Riwayat Penggajian Pegawai ==================================-->
                            <fieldset id="">
                                <div>       
                                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPenggajian">
                                        <thead>
                                            <tr>
                                                <th colspan="8" bgcolor="white">Penggajian Pegawai</th>
                                            </tr>
                                            <tr>
                                                <th>No. Urut</th>
                                                <th>Periode Gaji</th>
                                                <th>Pegawai</th>
                                                <th>Keluarga</th>
                                                <th>Tanggal Penggajian</th>
                                                <th>No. Penggajian</th>
                                                <th>Penerimaan Bersih</th>
                                                <th>Total Pajak</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($modPenggajian as $n => $data_penggajian) {
                                                ?>
                                                <tr>
                                                    <td><?php echo ($n + 1); ?></td>
                                                    <td><?php echo (isset($data_penggajian->periodegaji) ? $data_penggajian->periodegaji : '-'); ?></td>
                                                    <td><?php echo (isset($data_penggajian->gelardepan) ? $data_penggajian->gelardepan . $data_penggajian->nama_pegawai : $data_penggajian->nama_pegawai); ?></td>
                                                    <td><?php echo (isset($data_penggajian->nama_keluarga) ? $data_penggajian->nama_keluarga : '-'); ?></td>
                                                    <td><?php echo MyFormatter::formatDateTimeForUser($data_penggajian->tglpenggajian); ?></td>
                                                    <td><?php echo $data_penggajian->nopenggajian; ?></td>
                                                    <td><?php echo $data_penggajian->penerimaanbersih; ?></td>
                                                    <td><?php echo $data_penggajian->totalpajak; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaidiklat">
                                <thead>
                                    <tr>
                                        <th colspan="11" bgcolor="white">Pendidikan Pegawai</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2">No. urut</th>
                                        <th rowspan="2">Pendidikan</th>
                                        <th rowspan="2">Nama Sekolah / Universitas</th>
                                        <th rowspan="2">Alamat Sekolah / Universitas</th>
                                        <th rowspan="2">Tgl. masuk</th>
                                        <th rowspan="2">Lama pendidikan</th>
                                        <th colspan="3" style="text-align:center;">Kolom ijazah</th>
                                        <th rowspan="2">Nilai lulus / grade lulus</th>
                                        <th rowspan="2">Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tgl. Ijazah</th>
                                        <th>Tanda tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($modPendidikanpegawai as $i => $data_pegawai) {
                                        ?>
                                        <tr>
                                            <td><?php echo ($i + 1); ?></td>
                                            <td><?php echo $data_pegawai->pendidikan->pendidikan_nama; ?></td>
                                            <td><?php echo $data_pegawai->namasek_univ; ?></td>
                                            <td><?php echo $data_pegawai->almtsek_univ; ?></td>
                                            <td><?php echo $data_pegawai->tglmasuk; ?></td>
                                            <td><?php echo $data_pegawai->lamapendidikan_bln . " Bulan"; ?></td>
                                            <td><?php echo $data_pegawai->no_ijazah_sert; ?></td>
                                            <td><?php echo $data_pegawai->tgl_ijazah_sert; ?></td>
                                            <td><?php echo $data_pegawai->nilailulus . " / " . $data_pegawai->gradelulus; ?></td>										
                                            <td></td>
                                            <td><?php echo isset($data_pegawai->keteranganpend) ? $data_pegawai->keteranganpend : "-"; ?></td>										
                                        <tr>
                                        <?php } ?>
                                </tbody>
                            </table>
                        </div>

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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <div>
            <fieldset>
                <legend>Data Pegawai</legend>
                <table class="table-striped">
                    <tr>
                        <!--====================== kolom ke-1 ==============================================-->
                        <td>
                            NIP : <?php echo $model->nomorindukpegawai; ?></td>
                        <td></td>
                        <td>Jenis Kelamin :<?php echo $model->jeniskelamin; ?></td>

                        <td rowspan="4">
                            <?php
                            if (!empty($model->photopasien)) {
                                echo CHtml::image(Params::urlPasienTumbsDirectory() . 'kecil_' . $model->photopasien, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                            } else {
                                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                            }
                            ?> 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nama Pegawai :<?php echo $model->nama_pegawai; ?></td>
                        <td></td>
                        <td>Status Perkawinan :<?php echo $model->statusperkawinan; ?></td>
                    </tr>
                    <tr>
                        <td>Tempat, Tgl. Lahir :<?php echo $model->tempatlahir_pegawai; ?>
                            <?php echo MyFormatter::formatDateTimeForUser($model->tgl_lahirpegawai); ?></td>
                        <td></td>
                        <td>Jabatan :<?php echo isset($model->jabatan_id) ? $model->jabatan->jabatan_nama : "-"; ?></td>
                    </tr>
                    <tr>
                        <td>Alamat Pegawai :<?php echo isset($model->alamat_pegawai) ? $model->alamat_pegawai : "-"; ?><td>
                        <td></td>
                        <td><td>
                        <td><td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <div class="row">

            <!--==================================== View Riwayat diklat =============================-->
            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaidiklat">
                <thead>
                    <tr>
                        <th colspan="10" bgcolor="white">Pegawai Diklat</th>
                    </tr>
                    <tr>
                        <th rowspan="2">No. urut</th>
                        <th rowspan="2">Jenis diklat</th>
                        <th rowspan="2">Nama diklat</th>
                        <th rowspan="2">Tgl. mulai diklat</th>
                        <th rowspan="2">Lama diklat</th>
                        <th rowspan="2">Tempat</th>
                        <th colspan="3" style="text-align:center;">Keputusan diklat</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Tgl. penetapan</th>
                        <th>Nama pimpinan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modPegawaidiklat as $a => $data_diklat) {
                        ?>
                        <tr>
                            <td><?php echo ($a + 1); ?></td>
                            <td><?php echo $data_diklat->jenisdiklat->jenisdiklat_nama; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_nama; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_tahun; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_lamanya; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_tempat; ?></td>
                            <td><?php echo $data_diklat->nomorkeputusandiklat; ?></td>
                            <td><?php echo $data_diklat->tglditetapkandiklat; ?></td>
                            <td><?php echo $data_diklat->pejabatygmemdiklat; ?></td>
                            <td><?php echo $data_diklat->pegawaidiklat_keterangan; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--==================================== Akhir view Riwayat diklat =============================-->
            <!--==================================== View Riwayat pengalaman kerja =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPengalamankerja">
                        <thead>
                            <tr>
                                <th colspan="9" bgcolor="white">Pengalaman Kerja</th>
                            </tr>
                            <tr>
                                <th>No. urut</th>
                                <th>Nama perusahaan</th>
                                <th>Bidang usaha</th>
                                <th>Jabatan</th>
                                <th>Tgl. masuk</th>
                                <th>Tgl. keluar</th>
                                <th>Lama kerja</th>
                                <th>Alasan berhenti</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPengalamankerja as $b => $data_pengalaman) {
                                ?>
                                <tr>
                                    <td><?php echo ($b + 1); ?></td>
                                    <td><?php echo $data_pengalaman->namaperusahaan; ?></td>
                                    <td><?php echo $data_pengalaman->bidangperusahaan; ?></td>
                                    <td><?php echo $data_pengalaman->jabatanterahkir; ?></td>
                                    <td><?php echo $data_pengalaman->tglmasuk; ?></td>
                                    <td><?php echo $data_pengalaman->tglkeluar; ?></td>
                                    <td><?php echo $data_pengalaman->lama_tahun . " " . $data_pengalaman->lama_bulan . " bulan"; ?></td>
                                    <td><?php echo $data_pengalaman->alasanberhenti; ?></td>
                                    <td><?php echo $data_pengalaman->keterangan; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat pengalaman kerja =============================-->
            <!--==================================== View Riwayat jabatan =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatJabatan">
                        <thead>
                            <tr>
                                <th colspan="7" bgcolor="white">Jabatan Pegawai</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>No. SK</th>
                                <th>Tgl. ditetapkan</th>
                                <th>TMT jabatan</th>
                                <th>Tgl. akhir jabatan</th>
                                <th>Keterangan</th>
                                <th>Pejabat yang menjabatkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPegawaijabatan as $b => $data_jabatan) {
                                ?>
                                <tr>
                                    <td><?php echo ($b + 1); ?></td>
                                    <td><?php echo $data_jabatan->nomorkeputusanjabatan; ?></td>
                                    <td><?php echo $data_jabatan->tglditetapkanjabatan; ?></td>
                                    <td><?php echo $data_jabatan->tmtjabatan; ?></td>
                                    <td><?php echo $data_jabatan->tglakhirjabatan; ?></td>
                                    <td><?php echo $data_jabatan->keterangan; ?></td>
                                    <td><?php echo $data_jabatan->pejabatygmemjabatan; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat jabatan =============================-->
            <!--==================================== View Riwayat Pegawai mutasi =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegmutasi">
                        <thead>
                            <tr>
                                <th colspan="11" bgcolor="white">Mutasi Pegawai</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>No. Surat</th>
                                <th>Jabatan</th>
                                <th>Pangkat</th>
                                <th>No. SK</th>
                                <th>Tgl. SK</th>
                                <th>TMT SK</th>
                                <th>Jabatan baru</th>
                                <th>Pangkat baru</th>
                                <th>Mengetahui</th>
                                <th>Pimpinan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPegmutasi as $d => $data_mutasi) {
                                ?>
                                <tr>
                                    <td><?php echo ($d + 1); ?></td>
                                    <td><?php echo $data_mutasi->nomorsurat; ?></td>
                                    <td><?php echo $data_mutasi->jabatan_nama; ?></td>
                                    <td><?php echo $data_mutasi->pangkat_nama; ?></td>
                                    <td><?php echo $data_mutasi->nosk; ?></td>
                                    <td><?php echo $data_mutasi->tglsk; ?></td>
                                    <td><?php echo $data_mutasi->tmtsk; ?></td>
                                    <td><?php echo $data_mutasi->jabatan_baru; ?></td>
                                    <td><?php echo $data_mutasi->pangkat_baru; ?></td>
                                    <td><?php echo $data_mutasi->mengetahui_nama; ?></td>
                                    <td><?php echo $data_mutasi->pimpinan_nama; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat pegawai mutasi =============================-->
            <!--==================================== View Riwayat Pegawai cuti =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaicuti">
                        <thead>
                            <tr>
                                <th colspan="10" bgcolor="white">Cuti Pegawai</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Jenis cuti</th>
                                <th>Tgl. mulai</th>
                                <th>Lama cuti</th>
                                <th>No. SK</th>
                                <th>Tgl. SK</th>
                                <th>Keperluan</th>
                                <th>Keterangan</th>
                                <th>Pejabat mengetahui</th>
                                <th>Pejabat menyetujui</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPegawaicuti as $e => $data_cuti) {
                                ?>
                                <tr>
                                    <td><?php echo ($e + 1); ?></td>
                                    <td><?php echo $data_cuti->jeniscuti->jeniscuti_nama; ?></td>
                                    <td><?php echo $data_cuti->tglmulaicuti . " s/d " . $data_cuti->tglakhircuti; ?></td>
                                    <td><?php echo $data_cuti->lamacuti . " hari"; ?></td>
                                    <td><?php echo $data_cuti->noskcuti; ?></td>
                                    <td><?php echo $data_cuti->tglditetapkanskcuti; ?></td>
                                    <td><?php echo $data_cuti->keperluancuti; ?></td>
                                    <td><?php echo $data_cuti->keterangan; ?></td>
                                    <td><?php echo $data_cuti->pejabatmengetahui; ?></td>
                                    <td><?php echo $data_cuti->pejabatmenyetujui; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat pegawai cuti =============================-->
            <!--==================================== View Riwayat Izin tugas belajar =============================-->
            <fieldset id="">
                <div>
                    <div class="">    
                        <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatIjintugasbelajar">
                            <thead>
                                <tr>
                                    <th colspan="6" bgcolor="white">Izin Tugas Belajar</th>
                                </tr>
                                <tr>
                                    <th>No.</th>
                                    <th>Tgl. Mulai Belajar</th>
                                    <th>Nomor Keputusan</th>
                                    <th>Tgl. Ditetapkan</th>
                                    <th>Keterangan</th>
                                    <th>Pejabat yang Memutuskan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($modIzintugasbelajar as $f => $data_belajar) {
                                    ?>
                                    <tr>
                                        <td><?php echo ($f + 1); ?></td>
                                        <td><?php echo $data_belajar->tglmulaibelajar; ?></td>
                                        <td><?php echo $data_belajar->nomorkeputusan; ?></td>
                                        <td><?php echo $data_belajar->tglditetapkan; ?></td>
                                        <td><?php echo $data_belajar->keteranganizin; ?></td>
                                        <td><?php echo $data_belajar->pejabatmemutuskan; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
            <!--==================================== Akhir view Riwayat Izin tugas belajar =============================-->
            <!--==================================== View Riwayat Hukuman disiplin =============================-->
            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatHukdisiplin">

                        <thead>
                            <tr>
                                <th colspan="8" bgcolor="white">Hukuman Disiplin</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>Jenis hukuman</th>
                                <th>Jabatan</th>
                                <th>Tgl. hukuman</th>
                                <th>Ruangan pegawai</th>
                                <th>No. SK</th>
                                <th>Lama hukuman</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modHukdisiplin as $g => $data_hukum) {
                                ?>
                                <tr>
                                    <td><?php echo ($g + 1); ?></td>
                                    <td><?php echo $data_hukum->jnshukdisiplin->jnshukdisiplin_nama; ?></td>
                                    <td><?php echo $data_hukum->jabatan->jabatan_nama; ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_tglhukuman; ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_ruangan; ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_nosk; ?></td>
                                    <td><?php echo (isset($row->hukdisiplin_lamabln) ? $row->hukdisiplin_lamabln . "bulan" : '-'); ?></td>
                                    <td><?php echo $data_hukum->hukdisiplin_keterangan; ?></td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </fieldset>

            <!--======================================== View Riwayat Pengorganisasian Pegawai ==================================-->
            <fieldset id="">
                <div>

                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatOrganisasi">
                        <thead>
                            <tr>
                                <th colspan="6" bgcolor="white">Pengorganisasian Pegawai</th>
                            </tr>
                            <tr>
                                <th>No. Urut</th>
                                <th>Nama Organisasi</th>
                                <th>Kedudukan</th>
                                <th>Tanggal Mulai</th>
                                <th>Lama</th>
                                <th>Tempat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modOrganisasi as $h => $data_organisasi) {
                                ?>
                                <tr>
                                    <td><?php echo ($h + 1); ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_nama; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_kedudukan; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_tahun; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_lamanya; ?></td>
                                    <td><?php echo $data_organisasi->pengorganisasi_tempat; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--========================================== View Riwayat Susunan Keluarga ===========================================-->

            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatSusunanKeluarga">
                <thead>
                    <tr>
                        <th colspan="12" bgcolor="white">Susunan Keluarga</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>No. Urut</th>
                        <th>Hubungan Keluarga</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Pekerjaan</th>
                        <th>Pendidikan</th>
                        <th>Tanggal Pernikahan</th>
                        <th>Tempat Pernikahan</th>
                        <th>NIP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modSusunanKel as $j => $data_susunankel) {
                        ?>
                        <tr>
                            <td><?php echo ($j + 1); ?></td>
                            <td><?php echo $data_susunankel->nourutkel; ?></td>
                            <td><?php echo $data_susunankel->hubkeluarga; ?></td>
                            <td><?php echo $data_susunankel->susunankel_nama; ?></td>
                            <td><?php echo $data_susunankel->susunankel_jk; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tempatlahir; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tanggallahir; ?></td>
                            <td><?php echo $data_susunankel->pekerjaan_nama; ?></td>
                            <td><?php echo $data_susunankel->pendidikan_nama; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tanggalpernikahan; ?></td>
                            <td><?php echo $data_susunankel->susunankel_tempatpernikahan; ?></td>
                            <td><?php echo $data_susunankel->susunankeluarga_nip; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--======================================= View Riwayat Prestasi Kerja =================================================-->

            <fieldset id="">
                <div>
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPrestasiKerja">
                        <thead>
                            <tr>
                                <th colspan="7" bgcolor="white">Prestasi Kerja</th>
                            </tr>
                            <tr>
                                <th>No.</th>
                                <th>No. Urut</th>
                                <th>Tanggal Perolehan</th>
                                <th>Instansi Pemberi</th>
                                <th>Penjabat Pemberi</th>
                                <th>Nama Penghargaan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPrestasi as $k => $data_prestasi) {
                                ?>
                                <tr>
                                    <td><?php echo ($k + 1); ?></td>
                                    <td><?php echo $data_prestasi->nourutprestasi; ?></td>
                                    <td><?php echo $data_prestasi->tglprestasidiperoleh; ?></td>
                                    <td><?php echo $data_prestasi->instansipemberi; ?></td>
                                    <td><?php echo $data_prestasi->pejabatpemberi; ?></td>
                                    <td><?php echo $data_prestasi->namapenghargaan; ?></td>
                                    <td><?php echo $data_prestasi->keteranganprestasi; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <!--========================================= View Riwayat Perjalanan Dinas ================================-->

            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPerjalananDinas">
                <thead>
                    <tr>
                        <th colspan="11" bgcolor="white">Perjalanan Dinas</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>No. Urut</th>
                        <th>Tujuan Dinas</th>
                        <th>Tugas Dinas</th>
                        <th>Keterangan</th>
                        <th>Alamat Tujuan</th>
                        <th>Provinsi</th>
                        <th>Kota</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Negara Tujuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modDinas as $o => $data_dinas) {
                        ?>
                        <tr>
                            <td><?php echo ($o + 1); ?></td>
                            <td><?php echo $data_dinas->nourutperj; ?></td>
                            <td><?php echo $data_dinas->tujuandinas; ?></td>
                            <td><?php echo $data_dinas->tugasdinas; ?></td>
                            <td><?php echo $data_dinas->descdinas; ?></td>
                            <td><?php echo $data_dinas->alamattujuan; ?></td>
                            <td><?php echo $data_dinas->propinsi_nama; ?></td>
                            <td><?php echo $data_dinas->kotakabupaten_nama; ?></td>
                            <td><?php echo $data_dinas->tglmulaidinas; ?></td>
                            <td><?php echo $data_dinas->sampaidengan; ?></td>
                            <td><?php echo $data_dinas->negaratujuan; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!--======================================== View Riwayat Penggajian Pegawai ==================================-->
            <fieldset id="">
                <div>       
                    <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPenggajian">
                        <thead>
                            <tr>
                                <th colspan="8" bgcolor="white">Penggajian Pegawai</th>
                            </tr>
                            <tr>
                                <th>No. Urut</th>
                                <th>Periode Gaji</th>
                                <th>Pegawai</th>
                                <th>Keluarga</th>
                                <th>Tanggal Penggajian</th>
                                <th>No. Penggajian</th>
                                <th>Penerimaan Bersih</th>
                                <th>Total Pajak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($modPenggajian as $n => $data_penggajian) {
                                ?>
                                <tr>
                                    <td><?php echo ($n + 1); ?></td>
                                    <td><?php echo (isset($data_penggajian->periodegaji) ? $data_penggajian->periodegaji : '-'); ?></td>
                                    <td><?php echo (isset($data_penggajian->gelardepan) ? $data_penggajian->gelardepan . $data_penggajian->nama_pegawai : $data_penggajian->nama_pegawai); ?></td>
                                    <td><?php echo (isset($data_penggajian->nama_keluarga) ? $data_penggajian->nama_keluarga : '-'); ?></td>
                                    <td><?php echo MyFormatter::formatDateTimeForUser($data_penggajian->tglpenggajian); ?></td>
                                    <td><?php echo $data_penggajian->nopenggajian; ?></td>
                                    <td><?php echo $data_penggajian->penerimaanbersih; ?></td>
                                    <td><?php echo $data_penggajian->totalpajak; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </fieldset>
            <table width="100%" align="center" border="1" class="table table-striped" style="display:block;" id="tableRiwayatPegawaidiklat">
                <thead>
                    <tr>
                        <th colspan="11" bgcolor="white">Pendidikan Pegawai</th>
                    </tr>
                    <tr>
                        <th rowspan="2">No. urut</th>
                        <th rowspan="2">Pendidikan</th>
                        <th rowspan="2">Nama Sekolah / Universitas</th>
                        <th rowspan="2">Alamat Sekolah / Universitas</th>
                        <th rowspan="2">Tgl. masuk</th>
                        <th rowspan="2">Lama pendidikan</th>
                        <th colspan="3" style="text-align:center;">Kolom ijazah</th>
                        <th rowspan="2">Nilai lulus / grade lulus</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>No.</th>
                        <th>Tgl. Ijazah</th>
                        <th>Tanda tangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($modPendidikanpegawai as $i => $data_pegawai) {
                        ?>
                        <tr>
                            <td><?php echo ($i + 1); ?></td>
                            <td><?php echo $data_pegawai->pendidikan->pendidikan_nama; ?></td>
                            <td><?php echo $data_pegawai->namasek_univ; ?></td>
                            <td><?php echo $data_pegawai->almtsek_univ; ?></td>
                            <td><?php echo $data_pegawai->tglmasuk; ?></td>
                            <td><?php echo $data_pegawai->lamapendidikan_bln . " Bulan"; ?></td>
                            <td><?php echo $data_pegawai->no_ijazah_sert; ?></td>
                            <td><?php echo $data_pegawai->tgl_ijazah_sert; ?></td>
                            <td><?php echo $data_pegawai->nilailulus . " / " . $data_pegawai->gradelulus; ?></td>										
                            <td></td>
                            <td><?php echo isset($data_pegawai->keteranganpend) ? $data_pegawai->keteranganpend : "-"; ?></td>										
                        <tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <?php
}
?>