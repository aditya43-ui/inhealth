<style>
    .tab_header {
        width: 100%;
    }

    .underline td {
        border-bottom: 1px solid black;
    }

    body {
        color: black;
    }

    .tab_detail {
        width: 100%
    }

    .tab_detail th,
    .tab_detail td {
        border: 1px solid black;
        padding: 2px;
        vertical-align: top;
    }

    .tab_detail th,
    .tab_detail tfoot td {
        font-weight: bold;
    }
</style>
<?php
$pendaftaran = $model->tindakanpelayananTs[0]->pendaftaran;
$pasien = $model->tindakanpelayananTs[0]->pendaftaran->pasien;
$tindakan = TindakanpelayananT::model()->findAllByAttributes(array('verifikasitagihan_id' => $model->verifikasitagihan_id), array('order' => 'daftartindakan_id asc, dokterpemeriksa1_id asc, tgl_tindakan asc')); //$model->tindakanpelayananTs;
if (!empty($pendaftaran->pasienadmisi_id)) $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
if (!empty($admisi)) {
    $carabayar = $admisi->carabayar->carabayar_nama;
    $penjamin = $admisi->penjamin->penjamin_nama;
    $ruangan = $admisi->ruangan->ruangan_nama . " (Kamar " . $admisi->kamarruangan->kamarruangan_nokamar . " / Bed " . $admisi->kamarruangan->kamarruangan_nobed . ")";
} else {
    $carabayar = $pendaftaran->carabayar->carabayar_nama;
    $penjamin = $pendaftaran->penjamin->penjamin_nama;
    $ruangan = $pendaftaran->ruangan->ruangan_nama;
}
?>
<?php echo $this->renderPartial('application.views.headerReport.headerLaporan'); ?>
<h3 style="text-align: center;">VERIFIKASI TAGIHAN</h3>
<br>
<table class="tab_header">
    <tr>
        <td>No. Verifikasi</td>
        <td width="100%">: <?php echo $model->noverifikasi; ?></td>
        <td>Tgl. Pendaftaran</td>
        <td nowrap>: <?php echo MyFormatter::formatDateTimeForuser($pendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo $pasien->namadepan . " " . $pasien->nama_pasien; ?></td>
        <td>No. Rekam Medik</td>
        <td nowrap>: <?php echo $pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td nowrap>Umur / Tanggal Lahir</td>
        <td>: <?php echo $pendaftaran->umur . " / " . $pasien->tanggal_lahir; ?></td>
        <td nowrap>Jenis Penjamin / Penjamin</td>
        <td nowrap>: <?php echo $carabayar . " / " . $penjamin; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>: <?php echo $pendaftaran->no_pendaftaran; ?></td>
        <td>Instalasi</td>
        <td nowrap>: <?php echo !empty($admisi) ? "Rawat Inap" : $pendaftaran->instalasi->instalasi_nama; ?></td>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>: <?php echo $ruangan; ?></td>
        <?php if (!empty($admisi)) : ?>
            <td>Dokter Penerima</td>
            <td>: <?php
                    if (!empty($admisi->dokterpenerima_id)) {
                        $peg = PegawaiM::model()->findBypk($admisi->dokterpenerima_id);
                        echo $peg->namaLengkap;
                    } else echo "-";
                    ?></td>
        <?php else : ?>
            <td>Dokter Pemeriksa</td>
            <td>: <?php
                    if (!empty($pendaftaran->pegawai_id)) {
                        $peg = PegawaiM::model()->findBypk($pendaftaran->pegawai_id);
                        echo $peg->namaLengkap;
                    } else echo "-";
                    ?></td>
        <?php endif; ?>
    </tr>
    <tr class="underline">
        <td nowrap>Jenis Kasus Penyakit</td>
        <td>: <?php echo $pendaftaran->kasuspenyakit->jeniskasuspenyakit_nama; ?></td>
        <?php if (!empty($admisi) && !empty($admisi->pegawai_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->pegawai_id); ?>
            <td>Dokter PJP</td>
            <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <?php if (!empty($admisi) && !empty($admisi->dpjp2_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id); ?>
            <td>Dokter PJP 2</td>
            <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <?php if (!empty($admisi) && !empty($admisi->dpjp3_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id); ?>
            <td>Dokter PJP 3</td>
            <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
</table>
<br>
<table class="tab_detail">
    <thead>
        <tr>
            <th width="100">Tgl</th>
            <th>Uraian Tindakan</th>
            <th width="50">Jumlah</th>
            <th width="300">Nominal Tarif</th>
            <th width="100">Keringanan (Rp)</th>
            <th width="100">Tanggungan Asuransi</th>
            <th width="100">Tanggungan Rumah Sakit</th>
            <th width="100">Tanggunan Pasien</th>
            <th width="100">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $tot_diskon = 0;
        $tot_asuransi = 0;
        $tot_rs = 0;
        $tot_iur = 0;
        $tot_subtotal = 0;
        foreach ($model->detail as $item) :
            $tgl = "";
            $tindakan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
            $daftar = DaftartindakanM::model()->findByPk($item->daftartindakan_id);
            if (!empty($tindakan)) {
                $tgl = MyFormatter::formatDateTimeForUser($tindakan->tgl_tindakan);
            }
            $subtotal = $item->tarif_tindakan_sesudah - ($item->discount_tindakan_sesudah + $item->subsidiasuransi_tindakan_sesudah + $item->subsisidirumahsakit_tindakan_sesudah);
            $tot_diskon += $item->discount_tindakan_sesudah;
            $tot_asuransi += $item->subsidiasuransi_tindakan_sesudah;
            $tot_rs += $item->subsisidirumahsakit_tindakan_sesudah;
            $tot_iur += $subtotal;
            $tot_subtotal += $item->tarif_tindakan_sesudah;
        ?>
            <tr>
                <td><?php echo $tgl; ?></td>
                <td><?php echo $daftar->daftartindakan_nama; ?></td>
                <td style="text-align: right;"><?php echo $item->qty_tindakan_sesudah; ?></td>
                <td>
                    <table>
                        <thead>
                            <tr>
                                <th>Komponen</th>
                                <th>Sebelum</th>
                                <th>Sesudah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $komtotal = 0;
                            $komtotalsebelum = 0;
                            foreach ($item->komponen as $komponen) :
                                $kom = KomponentarifM::model()->findByPk($komponen->komponentarif_id);
                                $komtotal += $komponen->tariftindakankomp_sesudah;
                                $komtotalsebelum += $komponen->tariftindakankomp_sebelum;
                            ?>
                                <tr>
                                    <td style="width: 150px;"><?php echo $kom->komponentarif_nama; ?></td>
                                    <td style="width: 150px; text-align: right;"><?php echo MyFormatter::formatNumberForPrint($komponen->tariftindakankomp_sebelum); ?></td>
                                    <td style="width: 150px; text-align: right;">
                                        <?php
                                        echo MyFormatter::formatNumberForPrint($komponen->tariftindakankomp_sesudah);
                                        $selisih = $komponen->tariftindakankomp_sesudah - $komponen->tariftindakankomp_sebelum;
                                        if ($selisih != 0) {
                                            $col = 'green';
                                            if ($selisih < 0) $col = 'red';
                                            echo '<br><span style="color:' . $col . '">(' . MyFormatter::formatNumberForPrint($selisih) . ')</span> ';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th>Total</th>
                                <th style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($komtotalsebelum); ?></th>
                                <th style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($komtotal); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->discount_tindakan_sesudah); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->subsidiasuransi_tindakan_sesudah); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->subsisidirumahsakit_tindakan_sesudah); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item->tarif_tindakan_sesudah); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Total Keseluruhan Tindakan</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tot_diskon); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tot_asuransi); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tot_rs); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tot_iur); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tot_subtotal); ?></td>
        </tr>
    </tfoot>
</table>