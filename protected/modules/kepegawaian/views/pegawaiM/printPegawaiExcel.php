<style>
    .border th,
    .border td {
        border: 1px solid #000 !important;
    }

    .table thead:first-child {
        border-top: 1px solid #000;
    }

    thead th {
        background: none;
        color: #333;
    }

    .border {
        box-shadow: none;
    }

    .table tbody tr:hover td,
    .table tbody tr:hover th {
        background-color: none;
    }

    .table {
        border-collapse: collapse;
    }
</style>
<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)) {
    $template = "{items}";
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 48));
    }
}
?>

<table id="tableObatAlkes" class="table border">
    <thead>
        <tr>
            <th>NIK</th>
            <th>Nama Pegawai</th>
            <th>Inisial</th>
            <th>Tempat Lahir</th>
            <th>Tgl. Lahir</th>
            <th>NPWP</th>
            <th>Tgl. NPWP Terdaftar</th>
            <th>Tgl. Hitung Mulai Punya NPWP</th>
            <th>Alamat Tinggal</th>
            <th>Alamat Pajak</th>
            <th>Kode Negara untuk WNA</th>
            <th>No. Telepon</th>
            <th>Email</th>
            <th>No KTP</th>
            <th>Pendidikan Terakhir</th>
            <th>Agama</th>
            <th>Jabatan Pajak</th>
            <th>Jabatan</th>
            <th>Cabang</th>
            <th>Departemen</th>
            <th>Section</th>
            <th>Golongan</th>
            <th>Grade</th>
            <th>Bank</th>
            <th>Cabang Bank</th>
            <th>No Rekening</th>
            <th>Atas Nama</th>
            <th>Tgl. Masuk</th>
            <th>Tgl. Berhenti</th>
            <th>Metode</th>
            <th>Jenis Pegawai Pajak</th>
            <th>Jenis Kelamin</th>
            <th>Kebangsaan</th>
            <th>Status Kawin Pajak</th>
            <th>Tanggungan Pajak</th>
            <th>Jenis Pegawai HRD</th>
            <th>Status Kawin HRD</th>
            <th>Tanggungan HRD</th>
            <th>No. BPJS Kesehatan</th>
            <th>No. BPJS Tenaga Kerja</th>
            <th>Tgl. Masuk BPJS Tenaga Kerja</th>
            <th>Tgl. Keluar BPJS Tenaga Kerja</th>
            <th>No Peserta Asuransi</th>
            <th>Kode Group Komponen</th>
            <th>Level Akses</th>
            <th>Tgl. Awal Kontrak</th>
            <th>Tgl. Akhir Kontrak</th>
            <th>Nomor Kontrak</th>
            <th>Keterangan Kontrak</th>
        </tr>
    </thead>
    <tbody>
        <?php

        if (count((array)$model) > 0) {
            foreach ($model as $data) {
        ?>

                <tr>
                    <td><?php echo (!empty($data->nomorindukpegawai) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $data->nomorindukpegawai) . '"' : ""); ?></td>
                    <td><?php echo $data->namaLengkap; ?></td>
                    <td><?php echo $data->inisial; ?></td>
                    <td><?php echo $data->tempatlahir_pegawai; ?></td>
                    <td><?php echo date('d/m/Y', strtotime(($data->tgl_lahirpegawai))); ?></td>
                    <td><?php echo (!empty($data->npwp) ? '="' . $data->npwp . '"' : ""); ?></td>
                    <td><?php echo empty($data->tglterdaftarnpwp) ? "" : date('d/m/Y', strtotime(($data->tglterdaftarnpwp))); ?></td>
                    <td><?php echo empty($data->tglterdaftarnpwp) ? "" : date('d/m/Y', strtotime(($data->tglterdaftarnpwp))); ?></td>
                    <td><?php echo $data->alamat_pegawai; ?></td>
                    <td><?php echo $data->alamatnpwp; ?></td>
                    <td><?php echo $data->kode_negara; ?></td>
                    <td><?php echo (!empty($data->notelp_pegawai) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $data->notelp_pegawai) . '"' : ""); ?></td>
                    <td><?php echo $data->alamatemail; ?></td>
                    <td><?php echo (!empty($data->noidentitas) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $data->noidentitas) . '"' : ""); ?></td>
                    <td><?php echo isset($data->pendidikan) ? $data->pendidikan->pendidikan_nama : ""; ?></td>
                    <td><?php echo $data->agama; ?></td>
                    <td><?php echo isset($data->jabatan) ? $data->jabatan->jabatan_nama : ""; ?></td>
                    <td><?php echo isset($data->jabatan) ? $data->jabatan->jabatan_nama : ""; ?></td>
                    <td><?php echo isset($data) ? $data->cabang_pegawai : ""; ?></td>
                    <td><?php
                        $unit = UnitkerjaM::model()->findByPk($data->unitkerja_id);
                        echo empty($unit) ? "" : $unit->namaunitkerja;
                        ?></td>
                    <td nowrap><?php
                                $ruangan = PegawairuanganV::model()->findAllByAttributes(array(
                                    'pegawai_id' => $data->pegawai_id,
                                ), array(
                                    'order' => 'ruangan_nama',
                                    'limit' => 1
                                ));

                                foreach ($ruangan as $item) {
                                    echo $item->ruangan_nama;
                                }
                                ?></td>

                    <td><?php echo isset($data) ? $data->golongan : ""; ?></td>
                    <td><?php echo isset($data) ? $data->grade : ""; ?></td>
                    <td><?php echo isset($data) ? $data->bank_no_rekening : ""; ?></td>
                    <td><?php echo isset($data) ? $data->cabang_bank : ""; ?></td>
                    <td><?php echo isset($data) ? $data->no_rekening : ""; ?></td>
                    <td><?php echo isset($data) ? $data->atasnama : ""; ?></td>
                    <td><?php echo empty($data->tglditerima) ? "" : date('d/m/Y', strtotime(($data->tglditerima))); ?></td>
                    <td>
                        <?php
                        echo empty($data->tglberhenti) ? "" : date('d/m/Y', strtotime(($data->tglberhenti)));
                        //                        $resignMod = ResignT::model()->findByAttributes(array('pegawai_id'=>$data->pegawai_id));
                        //                        echo isset($resignMod) ? date('d/m/Y', strtotime(MyFormatter::formatDateTimeForDb($resignMod->tglresign))) : "";
                        ?>
                    </td>
                    <td><?php echo $data->metode_pph_21; ?></td>
                    <td><?php echo empty($data) ? "" : $data->jenispegawai; ?></td>
                    <td><?php echo empty($data) ? "" : substr($data->jeniskelamin, 0, 1); ?></td>
                    <td><?php echo empty($data) ? "" : $data->warganegara_pegawai; ?></td>

                    <td><?php
                        $ptkp = PtkpM::model()->findByPk($data->ptkp_id);
                        echo empty($ptkp) ? "" : $ptkp->kodeptkp;

                        ?></td>
                    <td>
                        <?php echo empty($ptkp) ? "" : $ptkp->jmltanggunan; ?>
                    </td>
                    <td><?php echo $data->kategoripegawai; ?></td>
                    <td><?php
                        $ptkpPeg = PtkpM::model()->findByPk($data->ptkp_id);
                        echo empty($ptkpPeg) ? "" : $ptkpPeg->kodeptkp;

                        ?></td>
                    <td>
                        <?php echo empty($ptkpPeg) ? "" : $ptkpPeg->jmltanggunan; ?>
                    </td>
                    <td><?php echo $data->no_bpjs_kesehatan; ?></td>
                    <td><?php echo $data->no_bpjs_ketenagakerjaan; ?></td>
                    <td><?php echo empty($data->tglmasuk_bpjs_ketenagakerjaan) ? "" : date('d/m/Y', strtotime(($data->tglmasuk_bpjs_ketenagakerjaan))); ?></td>
                    <td><?php echo empty($data->tglkeluar_bpjs_ketenagakerjaan) ? "" : date('d/m/Y', strtotime(($data->tglkeluar_bpjs_ketenagakerjaan))); ?></td>
                    <td><?php echo $data->nopeserta_asuransi; ?></td>
                    <td><?php echo $data->kodegroup_komponen; ?></td>
                    <td><?php echo $data->levelakses; ?></td>
                    <td><?php echo empty($data->tglmasaaktifpeg) ? "" : date('d/m/Y', strtotime($data->tglmasaaktifpeg)); ?></td>
                    <td><?php echo empty($data->tglmasaaktifpeg_sd) ? "" : date('d/m/Y', strtotime($data->tglmasaaktifpeg_sd)); ?></td>
                    <td><?php echo $data->nokontrak; ?></td>
                    <td><?php echo $data->keterangankontrak; ?></td>

                </tr>
            <?php
            }
        } else {
            ?>
            <tr colspan="50">
                <td>Tidak Ditemukan</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>