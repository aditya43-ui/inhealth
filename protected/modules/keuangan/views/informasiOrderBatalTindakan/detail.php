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

$tindakan = TindakanpelayananT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id, 'isverifbataltindakan' => true), array('order' => 'daftartindakan_id asc, dokterpemeriksa1_id asc, tgl_tindakan asc')); 

if(isset($_GET['nopelayanan'])) {
    $ct = new CDbCriteria;
    $ct->addCondition("pendaftaran_id = $pendaftaran->pendaftaran_id and nopelayanan = :nopelayanan and verifrenctindakan_id is not null");
    $ct->params[':nopelayanan'] = $_GET['nopelayanan'];
    $ct->order = 'daftartindakan_id asc, dokterpemeriksa1_id asc, tgl_tindakan asc';

    $tindakan = TindakanpelayananT::model()->findAll($ct); 
}
//$model->tindakanpelayananTs;
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
<h3 style="text-align: center;">Detail Order Batal Tindakan</h3>
<br>
<table class="tab_header">
    <tr>
        <td>&nbsp;</td>
        <td width="100%"></td>
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
            <th width="100">Tgl Transaksi</th>
            <th>No Nota</th>
            <th>Kode Tarif</th>
            <th>Uraian Tarif</th>
            <th width="50">Jumlah</th>

            <th width="300" hidden>Nominal Tarif</th>
            <th width="100" hidden>Keringanan (Rp)</th>
            <th width="100" hidden>Tanggungan Asuransi</th>
            <th width="100" hidden>Tanggungan Rumah Sakit</th>
            <th width="100" hidden>Tanggunan Pasien</th>
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
        $total = 0;
        foreach ($model as $item) :
            $tgl = "";
            $tindakan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
            $daftar = DaftartindakanM::model()->findByPk($item->daftartindakan_id);
            if (!empty($tindakan)) {
                $tgl = MyFormatter::formatDateTimeForUser($tindakan->tgl_tindakan);
            }
            $subtotal = $tindakan->tarif_tindakan - ($tindakan->discount_tindakan + $tindakan->subsidiasuransi_tindakan + $tindakan->subsisidirumahsakit_tindakan);
            $tot_diskon += $tindakan->discount_tindakan;
            $tot_asuransi += $tindakan->subsidiasuransi_tindakan;
            $tot_rs += $tindakan->subsisidirumahsakit_tindakan;
            $tot_iur += $subtotal;
            $tot_subtotal += $tindakan->tarif_tindakan;
            $total += $tindakan->qty_tindakan;
        ?>
            <tr>
                <td><?php echo $tgl; ?></td>
                <td>
                    <?= $tindakan->pendaftaran->no_pendaftaran . $tindakan->nopelayanan ?>
                </td>
                <td>
                    <?= $daftar->daftartindakan_kode ?>
                </td>
                <td><?php echo $daftar->daftartindakan_nama; ?></td>
                <td style="text-align: right;"><?php echo $tindakan->qty_tindakan; ?></td>
                <td hidden>
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

                            // var_dump($pendaftaran->kelaspelayanan_id); die;
                            $komtotal = 0;
                            $komtotalsebelum = 0;


                            // echo '<pre>';
                            foreach ($tindakan->komponenTindakan as $komponen) :

                                // var_dump($komponen->daftartindakan_id);
                                $komponen->kelaspelayanan_id = $pendaftaran->kelaspelayanan_id;
                                $kom = KomponentarifM::model()->findByPk($komponen->komponentarif_id);

                                //tarif tindakan

                                $crit = new CDbCriteria;
		                        $crit->select = "kt.komponentarif_id, t.tarif_tindakan, t.daftartindakan_id, tt.harga_tariftindakan";
		                        $crit->join = "JOIN daftartindakan_m dt on dt.daftartindakan_id = t.daftartindakan_id
		                        				JOIN tariftindakan_m tt on tt.daftartindakan_id = dt.daftartindakan_id
		                        				JOIN komponentarif_m kt on kt.komponentarif_id = tt.komponentarif_id";

		                        $crit->addCondition("t.tindakanpelayanan_id = $komponen->tindakanpelayanan_id");
		                        // $crit->addCondition("tt.kelaspelayanan_id = $pendaftaran->kelaspelayanan_id");
                                $crit->addCondition("kt.komponentarif_id = $komponen->komponentarif_id");

		                        $tarif = TindakanpelayananT::model()->find($crit);

                                $komtotal += $tarif->harga_tariftindakan;
                                $komtotalsebelum += $tarif->harga_tariftindakan;
                            ?>
                                <tr>
                                    <td style="width: 150px;"><?php echo $kom->komponentarif_nama; ?></td>
                                    <td style="width: 150px; text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tarif->harga_tariftindakan); ?></td>
                                    <td style="width: 150px; text-align: right;">
                                        <?php
                                        echo MyFormatter::formatNumberForPrint($tarif->harga_tariftindakan);
                                        $selisih = 0;
                                        $col = 'white';
                                        if ($selisih != 0) {
                                            $col = 'green';
                                            if ($selisih < 0) $col = 'red';
                                            echo '<br><span style="color:' . $col . '">(' . MyFormatter::formatNumberForPrint($selisih) . ')</span> ';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($tindakan->discount_tindakan); ?></td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($tindakan->subsidiasuransi_tindakan); ?></td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($tindakan->subsisidirumahsakit_tindakan); ?></td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>

                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tindakan->tarif_tindakan); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4">Total Keseluruhan Tindakan</td>
            <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($tot_diskon); ?></td>
            <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($tot_asuransi); ?></td>
            <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($tot_rs); ?></td>
            <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($tot_iur); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tot_subtotal); ?></td>
        </tr>
    </tfoot>
</table>