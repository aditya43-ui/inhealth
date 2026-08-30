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
    }
}

echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 52));
$nama = "";
$tgl = "";
$namapt = "";
$tglpt = "";
$namaSetuju = "";
$tglSetuju = "";
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
            <th>Masa Penghasilan Awal</th>
            <th>Masa Penghasilan Akhir</th>
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
            <th>Penghasilan Sebelumnya</th>
            <th>PPh dipotong masa sebelumnya</th>
        </tr>
    </thead>
    <tbody>
        <?php

        if (count((array)$model) > 0) {
            $no = 1;
            $totalTerima = 0;
            $totalBersih = 0;
            $nama = $model[0]->mengetahui;
            $tgl = $model[0]->tgl_mengetahui;
            $namapt = $model[0]->mengetahuipt;
            $tglpt = $model[0]->tgl_mengetahuipt;
            $namaSetuju = $model[0]->menyetujui;
            $tglSetuju = $model[0]->tgl_menyetujui;
            foreach ($model as $data) {
                $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                $id[] = $data->penggajianpeg_id;
                $totalTerima += $data->totalterima;
                $totalBersih += $data->penerimaanbersih;
        ?>

                <tr>
                    <td><?php echo (!empty($peg->nomorindukpegawai) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $peg->nomorindukpegawai) . '"' : ""); ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->namaLengkap; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->inisial; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->tempatlahir_pegawai; ?></td>
                    <td><?php echo empty($peg->tgl_lahirpegawai) ? "" : date('d/m/Y', strtotime(($peg->tgl_lahirpegawai))); ?></td>
                    <td><?php echo empty($peg) ? "" : (!empty($peg->npwp) ? '="' . $peg->npwp . '"' : ""); ?></td>
                    <td><?php echo empty($peg->tglterdaftarnpwp) ? "" : date('d/m/Y', strtotime(($peg->tglterdaftarnpwp))); ?></td>
                    <td><?php echo empty($peg->tglterdaftarnpwp) ? "" : date('d/m/Y', strtotime(($peg->tglterdaftarnpwp))); ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->alamat_pegawai; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->alamatnpwp; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->kode_negara; ?></td>
                    <td><?php echo (!empty($peg->notelp_pegawai) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $peg->notelp_pegawai) . '"' : ""); ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->alamatemail; ?></td>
                    <td><?php echo empty($peg) ? "" : (!empty($peg->noidentitas) ? '="' . preg_replace('/[^A-Za-z0-9]/s', "", $peg->noidentitas) . '"' : ""); ?></td>
                    <td><?php echo isset($peg->pendidikan) ? $peg->pendidikan->pendidikan_nama : ""; ?></td>
                    <td><?php echo isset($peg) ? $peg->agama : ""; ?></td>
                    <td><?php echo isset($peg->jabatan) ? $peg->jabatan->jabatan_nama : ""; ?></td>
                    <td><?php echo isset($peg->jabatan) ? $peg->jabatan->jabatan_nama : ""; ?></td>
                    <td><?php echo isset($peg) ? $peg->cabang_pegawai : ""; ?></td>
                    <td><?php

                        if (empty($peg) || empty($peg->unitkerja_id)) {
                            echo "";
                        } else {
                            $unit = UnitkerjaM::model()->findByPk($peg->unitkerja_id);
                            echo empty($unit) ? "" : $unit->namaunitkerja;
                        }

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

                    <td><?php echo isset($peg) ? $peg->golongan : ""; ?></td>
                    <td><?php echo isset($peg) ? $peg->grade : ""; ?></td>
                    <td><?php echo isset($peg) ? $peg->bank_no_rekening : ""; ?></td>
                    <td><?php echo isset($peg) ? $peg->cabang_bank : ""; ?></td>
                    <td><?php echo isset($peg) ? $peg->no_rekening : ""; ?></td>
                    <td><?php echo isset($peg) ? $peg->atasnama : ""; ?></td>
                    <td><?php echo empty($peg->tglditerima) ? "" : date('d/m/Y', strtotime(($peg->tglditerima))); ?></td>
                    <td>
                        <?php
                        echo empty($peg->tglberhenti) ? "" : date('d/m/Y', strtotime($peg->tglberhenti));
                        //                        $resignMod = ResignT::model()->findByAttributes(array('pegawai_id'=>$peg->pegawai_id));
                        //                        echo isset($resignMod) ? date('d/m/Y', strtotime($resignMod->tglresign)) : "";
                        ?>
                    </td>
                    <td><?php
                        $cr = new CDbCriteria();
                        $cr->compare('pegawai_id', $data->pegawai_id);
                        $cr->order = 'tglpenggajian';
                        $cr->addCondition('extract(year from periodegaji) = ' . (date('Y', strtotime($data->tglpenggajian))));
                        $gaji_awal = PenggajianpegT::model()->find($cr);

                        $crr = new CDbCriteria();
                        $crr->compare('pegawai_id', $data->pegawai_id);
                        $crr->addCondition('extract(year from tglresign) = ' . (date('Y', strtotime($data->tglpenggajian))));
                        $crr->addCondition('extract(month from tglresign) = ' . (date('m', strtotime($data->tglpenggajian))));

                        $resign = ResignT::model()->find($crr);


                        $gaji_akhir = !empty($resign) ? date('m', strtotime($resign->tglresign)) : 12;


                        echo empty($gaji_awal) ? "" : date('n', strtotime($gaji_awal->periodegaji));


                        ?></td>
                    <td><?php

                        echo $gaji_akhir;

                        ?></td>
                    <td><?php echo $data->metode_pph_21; ?></td>

                    <td><?php echo empty($peg) ? "" : $peg->jenispegawai; ?></td>
                    <td><?php echo empty($peg) ? "" : substr($peg->jeniskelamin, 0, 1); ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->warganegara_pegawai; ?></td>

                    <td><?php

                        if (empty($peg) || empty($peg->ptkp_id)) {
                            echo "";
                        } else {

                            $ptkp = PtkpM::model()->findByPk($peg->ptkp_id);

                            echo empty($ptkp) ? "" : $ptkp->kodeptkp;
                        }

                        ?></td>
                    <td>
                        <?php echo empty($ptkp) ? "" : $ptkp->jmltanggunan; ?>
                    </td>
                    <td><?php echo empty($peg) ? "" : $peg->kategoripegawai; ?></td>
                    <td><?php

                        if (empty($peg) || empty($peg->ptkp_id)) {
                            echo "";
                        } else {
                            $ptkpPeg = PtkpM::model()->findByPk($peg->ptkp_id);

                            echo empty($ptkpPeg) ? "" : $ptkpPeg->kodeptkp;
                        }

                        ?></td>
                    <td>
                        <?php echo empty($ptkpPeg) ? "" : $ptkpPeg->jmltanggunan; ?>
                    </td>
                    <td><?php echo empty($peg) ? "" : $peg->no_bpjs_kesehatan; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->no_bpjs_ketenagakerjaan; ?></td>
                    <td><?php echo empty($peg->tglmasuk_bpjs_ketenagakerjaan) ? "" : date('d/m/Y', strtotime(($peg->tglmasuk_bpjs_ketenagakerjaan))); ?></td>
                    <td><?php echo empty($peg->tglkeluar_bpjs_ketenagakerjaan) ? "" : date('d/m/Y', strtotime(($peg->tglkeluar_bpjs_ketenagakerjaan))); ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->nopeserta_asuransi; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->kodegroup_komponen; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->levelakses; ?></td>
                    <td><?php echo empty($peg->tglmasaaktifpeg) ? "" : date('d/m/Y', strtotime($peg->tglmasaaktifpeg)); ?></td>
                    <td><?php echo empty($peg->tglmasaaktifpeg_sd) ? "" : date('d/m/Y', strtotime($peg->tglmasaaktifpeg_sd)); ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->nokontrak; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->keterangankontrak; ?></td>
                    <td><?php echo $data->netto_masasebelumnya; ?></td>
                    <td><?php echo $data->pph21dipotong; ?></td>

                </tr>
            <?php
            }
        } else {
            ?>
            <tr colspan="6">
                <td>Tidak Ditemukan</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
    <?php /*
     <tfoot> 
        <tr>
            <th style="text-align: right" colspan="5">
                Total
            </th>
            <th style="text-align: right">
                <?php echo CHtml::encode(number_format($totalBersih,0,"",".")); ?>
            </th>
                <th style="text-align: right">
                 <?php echo CHtml::encode(number_format($totalTerima,0,"",".")); ?>
            </th>
        </tr>
     </tfoot>
      * 
      */ ?>
</table>