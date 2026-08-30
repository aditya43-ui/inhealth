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

    .tab_detail .footee {
        font-weight: bold;
    }

    .num {
        text-align: right;
    }
</style>
<?php
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
<h3 style="text-align: center;">BATAL VERIFIKASI TAGIHAN</h3>
<br>
<table class="tab_header">
    <tr>
        
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?php echo $pasien->namadepan . " " . $pasien->nama_pasien; ?></td>
        <td>Tgl. Pendaftaran</td>
        <td nowrap>: <?php echo MyFormatter::formatDateTimeForuser($pendaftaran->tgl_pendaftaran); ?></td>
        
    </tr>
    <tr>
        <td nowrap>Umur / Tanggal Lahir</td>
        <td>: <?php echo $pendaftaran->umur . " / " . $pasien->tanggal_lahir; ?></td>
        <td>No. Rekam Medik</td>
        <td nowrap>: <?php echo $pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>: <?php echo $pendaftaran->no_pendaftaran; ?></td>
        <td nowrap>Jenis Penjamin / Penjamin</td>
        <td nowrap>: <?php echo $carabayar . " / " . $penjamin; ?></td>
        
    </tr>
    <tr>
        <td>Ruangan</td>
        <td>: <?php echo $ruangan; ?></td>
        <td>Instalasi</td>
        <td nowrap>: <?php echo !empty($admisi) ? "Rawat Inap" : $pendaftaran->instalasi->instalasi_nama; ?></td>
    </tr>
    <tr>
        <td nowrap>Jenis Kasus Penyakit</td>
        <td>: <?php echo $pendaftaran->kasuspenyakit->jeniskasuspenyakit_nama; ?></td>
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
    <tr>
        <td>Petugas Pembatalan</td>
        <td>: <?php echo $petugas->namaLengkap ?? "-"; ?></td>
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
    <tr class="underline">
        <td></td>
        <td></td>
        <?php if (!empty($admisi) && !empty($admisi->dpjp3_id)) :
            $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id); ?>
            <td>Dokter PJP 3</td>
            <td>: <?php echo $peg->namaLengkap; ?></td>
        <?php else: ?>
        <td></td>
        <td></td>
        <?php endif; ?>
    </tr>
</table>
<br>
<table class="tab_detail">
    <thead>
        <tr>
            <th width="100">Tgl Transaksi</th>
            <th>No Nota</th>
            <th>Kode Tarif</th>
            <th>Uraian Tarif</th>
            <th width="50">Jumlah</th>
            <th width="100">Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $qty_total = 0;
        $tarif_total = 0;
        foreach ($model as $item): 
            $qty_total += $item->qty_tindakan;
            $tarif_total += $item->tarif_tindakan;
        ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_tindakan); ?></td>
            <td><?php echo $item->no_pendaftaran.$item->nopelayanan; ?></td>
            <td><?php echo $item->daftartindakan_kode; ?></td>
            <td><?php echo $item->daftartindakan_nama; ?></td>
            <td class="num"><?php echo $item->qty_tindakan; ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($item->tarif_tindakan, 2); ?></td>
        </tr>
        <tr class="footee">
            <td colspan="4">Total keseluruhan</td>
            <td class="num"><?php echo $qty_total; ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($tarif_total, 2); ?></td>
        </tr>

        <?php endforeach; ?>
    </tbody>
    <tfoot>
        
    </tfoot>
</table>