<style>
    body {
        width: 100%;
        color: black;
    }

    .identitas {
        line-height: 12px;
    }

    .identitas td {
        vertical-align: top;
    }

    .judulcontent {
        text-align: center !important;
    }

    .rincian th,
    .rincian td {
        border: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
        vertical-align: top;
    }

    .rincian tfoot td {
        font-weight: bold;
    }

    .table-rincian td,
    th {
        border-top: solid #000 1px;
        border-bottom: solid #000 1px;
        font-family: "Arial" !important;

    }

    .tab_detail thead td {
        /* border-top: solid #000 1px !important;
        vertical-align: top;
        border-bottom: solid #000 1px !important; */
        font-family: "Arial" !important;

    }

    TABLE,
    TBODY,
    TFOOT,
    TR,
    TH,
    TD {
        font-family: "Arial" !important;
        font-size: 9pt !important;
    }

    .tab_detail tfoot td,
    .footee {
        font-weight: bold;
    }

    .tab_detail .closing td {
        border-bottom: 1px solid black;
    }

    .tab_detail .upper td {
        border-top: 1px solid black;
    }

    .tab_detail .grand_total td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .hddn {
        display: none;
    }

    @page {
        font-size: 9pt !important;
        margin: 0;
        font-family: "Arial" !important;
    }

    @media print {

        html,
        body {
            margin: 0, 0.25cm, 0, 0.25cm;
            margin-top: 0.25cm;
            margin-right: 0.1cm;
            margin-left: 0.2cm;
            font-family: "Arial" !important;
            font-size: 9pt;
        }

        html,
        header {
            margin: 0, 0.25cm, 0, 0.25cm;
            margin-top: 0.25cm;
            margin-right: 0.1cm;
            font-family: "Arial" !important;
            font-size: 9pt;
        }

        TABLE,
        TBODY,
        TFOOT,
        TR,
        TH,
        TD {
            font-family: "Arial" !important;
            font-size: 9pt !important;
        }

        div.footer {
            position: fixed;
            bottom: 0;
        }
    }
</style>
<?php
$format = new MyFormatter;
?>
<?php
if (isset($_GET['caraPrint'])) {
    if ($_GET['caraPrint'] == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincianbiayaperawatanpasien-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}

$pasien = $modPendaftaran->pasien;
$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
$asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
$masukkamar = empty($admisi) ? null : MasukkamarT::model()->findByAttributes(array(
    'pasienadmisi_id' => $admisi->pasienadmisi_id,
), array(
    'order' => 'masukkamar_id desc',
));
$tandabukti = TandabuktibayarT::model()->findByAttributes(array(
    'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id,
));

$carabayar_id = empty($admisi) ? $modPendaftaran->carabayar_id : $admisi->carabayar_id;
?>

<table style="width: 100%; border: none !important; text-align: center">
    <thead>
        <tr>
            <td>
                <?php
                echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="judulcontent" style="text-align: center !important; font-size: 11pt; font-weight: bold; font-family: 'Arial' !important;">
                    KUITANSI RINCIAN TAGIHAN
                </div>
            </td>
        </tr>
    </thead>
</table>
<table width="100%">
    <tr>
        <td>

            <table class="identitas" width="100%">
                <tr>
                    <td>Terima Dari </td>
                    <td> : <?= $tandabukti->darinama_bkm ?></td>
                    <td> </td>
                    <td width="20%">Perawatan</td>
                    <td width="30%"> : <?php echo !empty($modPendaftaran->pasienadmisi_id) ? $admisi->ruangan->instalasi->instalasi_nama : $modPendaftaran->instalasi->instalasi_nama; ?></td>
                </tr>
                <tr>
                    <td width="20%">No Pembayaran</td>
                    <td width="30%"> : <?= $modPembayaran->nopembayaran;  ?> </td>
                    <td> </td>
                    <td> <?php echo !empty($asuransi) ? "Kelas Hak" : '' ?> </td>
                    <td> <?php echo !empty($asuransi) ? ": " . $asuransi->kelastanggunganasuransi->kelaspelayanan_nama : ''; ?> </td>
                </tr>
                <tr>
                    <td>Jenis Penjamin</td>
                    <td> : <?= $modPendaftaran->carabayar->carabayar_nama . " / " . $modPendaftaran->penjamin->penjamin_nama;  ?> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td colspan="5" style="padding-top: 0.2rem; border-bottom: 1px solid black;"> </td>
                </tr>
                <tr>
                    <td style="padding-top: 0.2rem;">No. Rekam Medik</td>
                    <td style="padding-top: 0.2rem;"> : <?= $pasien->no_rekam_medik; ?></td>
                    <td style="padding-top: 0.2rem;"> </td>
                    <td style="padding-top: 0.2rem;">Tgl. Pendaftaran</td>
                    <td style="padding-top: 0.2rem;">: <?= MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td> : <?= $pasien->nama_pasien; ?></td>
                    <td> </td>
                    <td>Ruangan</td>
                    <td> : <?= empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->ruangan->ruangan_nama : $admisi->kelaspelayanan->kelaspelayanan_nama; ?></td>
                <tr>
                    <td>Alamat</td>
                    <td> : <?php echo $pasien->alamat_pasien; ?> </td>
                    <td></td>
                    <td> <?php echo (!empty($admisi) ? "Tanggal MRS" : "") ?> </td>
                    <td> <?php echo (isset($admisi) ? ": " . $admisi->tgladmisi : ""); ?></td>
                </tr>
                <?php if (!empty($admisi)) : ?>

                    <?php
                    $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
                    $admisiTgl = date('Y-m-d', strtotime($admisi->tgladmisi));
                    $pulang = $admisi->rencanapulang; //empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;

                    $vpulang = date('Y-m-d', strtotime($pulang));

                    $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
                    $tgl_amds = MyFormatter::formatDateTimeForUser($admisiTgl);
                    $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);

                    $val_daftar = strtotime($daftar);
                    $val_adms = strtotime($admisiTgl);
                    $val_pulang = strtotime($vpulang);

                    $res = CustomFunction::hitungHariRawat(MyFormatter::formatDateTimeForDb($admisiTgl), MyFormatter::formatDateTimeForDb($vpulang));

                    $str = date("d-m-Y", strtotime($admisiTgl)) . " - " . date("d-m-Y", strtotime($tgl_pulang));

                    if ($admisi->penjamin_id == Params::PENJAMIN_ID_UMUM) :
                    ?>

                        <tr>
                            <td>Dokter</td>
                            <td> : <?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
                            <td> </td>
                            <td>Lama Rawat</td>
                            <td> : <?php echo $res . " Hari (" . $str . ")"; ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td>Dokter</td>
                            <td> : <?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
                            <td> </td>
                            <td>Lama Rawat</td>
                            <td> : <?php echo $res . " Hari (" . $str . ")"; ?></td>
                        </tr>
                    <?php endif; ?>

                <?php endif; ?>
            </table>

            <table width="96%" class="tab_detail" style="margin-bottom: 0.5rem;" cellspacing="0" cellpadding="0">
                <thead style="font-family: 'Arial' !important;">
                    <tr class="closing footee">
                        <td colspan="9"> </td>
                    </tr>
                    <tr class="closing footee">
                        <td colspan="2" style="max-width: 5cm;">Uraian</td>
                        <td>Dokter</td>
                        <td>Tanggal</td>
                        <td align="center">Jml</td>
                        <td align="right">Harga</td>
                        <!-- <td align="right">Diskon</td> -->
                        <td align="right" class="">Tanggungan <br> Asuransi</td>
                        <td> </td>
                        <!-- <td class="hddn">Subsidi Pemerintah</td> -->
                        <!-- <td class="">Subsidi RS</td> -->
                        <!-- <td class="hddn">Iur Biaya</td> -->
                        <td align="right">Sub Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($loadData)) {
                        foreach ($loadData as $key => $det) { ?>
                            <tr>
                                <td colspan="7"> <?= $det['ruangan_nama'] ?></td>
                                <td align="right"> <b> [<?= $det['total'] ?>]</b></td>
                                <td> </td>
                            </tr>
                            <?php
                            if (!empty($det['det'])) {
                                foreach ($det['det'] as $key2 => $det2) {
                            ?>
                                    <tr>
                                        <td> *. </td>
                                        <td> <?= $det2['obatalkes_nama'] ?> </td>
                                        <td> <?= $det2['dokter'] ?> </td>
                                        <td> <?= $det2['tgl'] ?> </td>
                                        <td align="center"> <?= $det2['jml'] ?> </td>
                                        <td align="right"> <?= $det2['harga'] ?> </td>
                                        <td align="right"> <?= $det2['subtotal'] ?> </td>
                                        <td> </td>
                                        <td align="right"> <?= $det2['subtotal'] ?> </td>
                                    </tr>
                    <?php }
                            }
                        }
                    }
                    ?>

                    <tr class="upper">
                        <td colspan="8"> Total Tagihan </td>
                        <td align="right"> <?= $loadData[$modPembayaran->pembayaranpelayanan_id]['total'] ?> </td>
                    </tr>
                    <tr class="">
                        <td colspan="8"> Total INACBG </td>
                        <td align="right"> <?= $loadData[$modPembayaran->pembayaranpelayanan_id]['total'] ?> </td>
                    </tr>
                    <tr class="upper">
                        <td colspan="8"> Dibayar oleh Pasien </td>
                        <td align="right"> <?= MyFormatter::formatNumberForPrint(0, 2) ?> </td>
                    </tr>
                    <tr class="closing footee">
                        <td colspan="2"> Terbilang </td>
                        <td align="left" colspan="8"> <?= $loadData[$modPembayaran->pembayaranpelayanan_id]['terbilang'] ?> </td>
                    </tr>
                </tbody>
                <tfoot>
                </tfoot>

            </table>
        </td>
    </tr>
</table>