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

    .rincian th,
    .rincian td {
        border: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
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
        border-top: solid #000 1px;
        border-bottom: solid #000 1px;
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

    .tab_detail .grand_total td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }


    .tab_detail .upper td {
        border-top: 1px solid black;
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


$admisi = null;
if (!empty($modPenjualan->pendaftaran_id)) {
    $admisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id' => $modPenjualan->pendaftaran_id,
    ));
}
?>

<?php
echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
?>




<table width="100%">
    <tbody>
        <tr>
            <td style="text-align: center">
                <div class="judulcontent" style="text-align: center !important; font-size: 11pt; font-weight: bold; font-family: 'Arial' !important;"> RINCIAN TAGIHAN </div>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <table width="100%">
                    <tr>
                        <td width="20%">Nama </td>
                        <td>:
                            <?php
                            if (!empty($modPenjualan->pasienpegawai_id))
                                echo $modPegawaiDokter->nomorindukpegawai . " - " . $modPegawaiDokter->gelardepan . " " . $modPegawaiDokter->nama_pegawai . ", " . $modPegawaiDokter->gelarbelakang_nama;
                            else if (!empty($modPenjualan->pasieninstalasiunit_id))
                                echo $modInstalasi->instalasi_nama;
                            else
                                echo $pasien->nama_pasien;; ?>
                        </td>
                        <!-- <td hidden>Tanggal Pembayaran</td> -->
                        <!-- <td hidden>: <?php // echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?></td> -->
                        <td>No. Rekam Medik</td>
                        <td>: <?php echo $pasien->no_rekam_medik ?></td>
                    </tr>

                    <tr>
                        <td>Alamat </td>
                        <td style="vertical-align: top;">:
                            <?php
                            if (!empty($modPenjualan->pasienpegawai_id)) {
                                echo ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT)->nama_rumahsakit;
                                if (!empty($modPegawaiDokter->alamat_pegawai))
                                    echo "/" . $modPegawaiDokter->alamat_pegawai;
                            } else if (!empty($modPenjualan->pasieninstalasiunit_id)) {
                                // if($modInstalasi->instalasi_lokasi == "GRT")
                                echo ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT)->nama_rumahsakit;
                                // else{
                                //     echo "Holding PT. KAH";
                                // }
                            } else
                                echo $pasien->alamat_pasien;
                            ?>
                        </td>
                        <td width="20%">No. Pendaftaran </td>
                        <td>: <?php echo $daftar->no_pendaftaran; ?></td>
                    </tr>

                    <tr>
                        <td nowrap>Tanggal Penjualan</td>
                        <td>: <?php echo MyFormatter::formatDateTimeForUser($modPenjualan->tglpenjualan); ?></td>
                        <td width="20%">No. Pembayaran</td>
                        <td>: <?php echo (empty($modPenjualan->NoFaktur)) ? "- Belum Lunas -" : $modPenjualan->NoFaktur; ?></td>
                    </tr>
                    <tr>
                        <td>No. Resep</td>
                        <td>: <?php echo $modPenjualan->noresep; ?>
                    </tr>
                    <tr>
                        <?php if (!empty($admisi) && !empty($admisi->dokterpenerima_id)) :
                            $peg = PegawaiM::model()->findByPk($admisi->dokterpenerima_id);
                        ?>
                            <td>Dokter Penerima</td>
                            <td>: <?php echo $peg->namaLengkap; ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if (!empty($admisi) && !empty($admisi->pegawai_id)) :
                            $peg = PegawaiM::model()->findByPk($admisi->pegawai_id);
                        ?>
                            <td>Dokter PJP</td>
                            <td>: <?php echo $peg->namaLengkap; ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if (!empty($admisi) && !empty($admisi->dpjp2_id)) :
                            $peg = PegawaiM::model()->findByPk($admisi->dpjp2_id);
                        ?>
                            <td>Dokter PJP 2</td>
                            <td>: <?php echo $peg->namaLengkap; ?></td>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <?php if (!empty($admisi) && !empty($admisi->dpjp3_id)) :
                            $peg = PegawaiM::model()->findByPk($admisi->dpjp3_id);
                        ?>
                            <td>Dokter PJP 3</td>
                            <td>: <?php echo $peg->namaLengkap; ?></td>
                        <?php endif; ?>
                    </tr>
                </table>
                <br>
                <table width="96%" class="tab_detail" style="margin-bottom: 0.5rem;">
                    <thead style="font-family: 'Arial' !important;">
                        <tr class="closing footee"> 
                            <td colspan="9"> </td>
                        </tr>
                        <tr>
                            <th style='text-align: center; font-family: "Arial" !important; font-weight: bold'>No.</th>
                            <th style='text-align: center; font-family: "Arial" !important; font-weight: bold'>Kode</th>
                            <th style='text-align: center; font-family: "Arial" !important; font-weight: bold'>Nama</th>
                            <th style='text-align: center; font-family: "Arial" !important; font-weight: bold'>Jml</th>
                            <th style='text-align: center; font-family: "Arial" !important; font-weight: bold'>Harga</th>
                            <!-- <th style='text-align: center;'>PPN</th> -->
                            <th style='text-align: center; font-family: "Arial" !important; font-weight: bold'>Tanggungan <br> Asuransi</th>
                            <!-- <th style='text-align: center;'>Tanggungan <br> Pemerintah</th> -->
                            <!-- <th style='text-align: center;'>Tanggungan <br> Pasien</th> -->
                            <td> </td>
                            <th style='text-align: center; font-family: "Arial" !important; font-weight: bold'>Subtotal</th>
                        </tr>
                        <tr class="closing footee"> 
                            <td colspan="9"> </td>
                        </tr>
                    </thead>
                    <tbody style="font-family: 'Arial' !important;">

                        <?php
                        if (!empty($loadData)) {
                            $no = 1;
                            foreach ($loadData as $key => $det) { ?>
                                <tr>
                                    <td colspan="6" style="font-weight: bold"> <?= $det['ruangan_nama'] ?></td>
                                    <td align="right" style="font-weight: bold"> [<?= MyFormatter::formatNumberForPrint($det['total'], 2) ?>]</td>
                                </tr>
                                <?php
                                if (!empty($det['det'])) {
                                    foreach ($det['det'] as $key2 => $det2) { ?>
                                        <tr>
                                            <td align="center"> <?= $no++ ?> </td>
                                            <td align="center"> <?= $det2['obatalkes_kode'] ?> </td>
                                            <td> <?= $det2['obatalkes_nama'] ?> </td>
                                            <td> <?= number_format($det2['qty'], 0, "", ".") ?> </td>
                                            <td align="right"> <?= MyFormatter::formatNumberForPrint($det2['hargasatuan_oa'], 2) ?> </td>
                                            <td align="right"> <?= MyFormatter::formatNumberForPrint($det2['subsidiasuransi'], 2) ?> </td>
                                            <td> </td>
                                            <td align="right"> <?= MyFormatter::formatNumberForPrint($det2['subtotal'], 2) ?> </td>
                                        </tr>
                                <?php }
                                }
                                ?>

                        <?php }
                        }
                        ?>
                        <?php
                        $no = 1;
                        $total = 0;
                        $totalAdmin = 0;
                        $gtotal = 0;
                        $uirtotal = 0;
                        if (count((array)$obatAlkes) > 0) {
                            foreach ($obatAlkes as $tampilData) :
                                $jmlHargaQty = ($tampilData->hargasatuan_oa * $tampilData->qty_oa);
                                $jmliuran = $jmlHargaQty - $tampilData->discount + $tampilData->jumlahppn - $tampilData->subsidiasuransi - $tampilData->subsidirs - $tampilData->subsidipemerintah;
                                $jmlSubtotal = ($jmlHargaQty - $tampilData->discount + $tampilData->jumlahppn);
                        ?>

                        <?php $no++;
                                $gtotal += $jmlSubtotal;
                                $uirtotal += $jmliuran;
                                $total += ($tampilData->qty_oa * $tampilData->hargasatuan_oa);
                                $totalAdmin +=  ($tampilData->biayaservice + $tampilData->biayakonseling + $tampilData->biayaadministrasi); //$tampilData->jasadokterresep + << TIDAK DICANTUMKAN KARENA SUDAH TERMASUK KE DALAM OBAT
                            endforeach;
                        }
                        $jumlNonTunai = 0;
                        $jenispembayaranT = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id' => $tandabukti->tandabuktibayar_id));
                        if (count((array)$jenispembayaranT) > 0) {
                            foreach ($jenispembayaranT as $jnsPemb) {
                                $jumlNonTunai += $jnsPemb->jumlahpembayaran;
                            }
                        }
                        ?>
                        <tr class="closing footee"> 
                            <td colspan="9"> </td>
                        </tr>
                        <tr class="">
                            <td class="" style="text-align:left;" colspan="7">Total Tagihan</td>
                            <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->pembayaranpelayanan->totalbiayaoa, 2) ?></td>
                        </tr>
                        <tr class="closing footee"> 
                            <td colspan="9"> </td>
                        </tr>
                        <?php if ($tandabukti->pembayaranpelayanan->totaldiscount > 0) : ?>
                            <tr class="">
                                <td colspan="7">Potongan</td>
                                <td align="right"><?php echo MyFormatter::formatNumberForPrint($tandabukti->pembayaranpelayanan->totaldiscount, 2); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php
                        $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                            'pembayaranpelayanan_id' => $tandabukti->pembayaranpelayanan->pembayaranpelayanan_id
                        ));

                        $jml_uangmuka = 0;

                        if (!empty($bayaruangmuka)) :

                            $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

                            $ekses -= $jml_uangmuka;
                            $ekses += $tandabukti->jmlpembulatan;
                        ?>
                            <tr class="">
                                <td colspan="8">Total Uang Muka</td>
                                <td align="right"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka, 2); ?></td>
                            </tr>
                            <tr class="">
                                <td colspan="8">Pemakaian Uang Muka</td>
                                <td align="right"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka, 2); ?></td>
                            </tr>
                            <tr class="">
                                <td colspan="8">Sisa Uang Muka</td>
                                <td align="right"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka, 2); ?></td>
                            </tr>

                        <?php endif; ?>
                        <tr>
                            <?php
                            $jmldbyr = $tandabukti->pembayaranpelayanan->totaliurbiaya;
                            if ($tandabukti->jmlpembulatan !== 0) {
                                $jmldbyr = $jmldbyr + $tandabukti->jmlpembulatan;
                            }
                            ?>
                            <td style="text-align:left;" colspan="7"> Dibulatkan </td>
                            <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($jmldbyr, 2) ?></td>
                        </tr>
                        <?php if ($tandabukti->uangditerima > 0) : ?>
                            <tr>
                                <td style="text-align:left; font-weight: bold" colspan="7">Pembayaran Tunai</td>
                                <td style="text-align:right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima, 2) ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($tandabukti->bank_nominal > 0) : ?>
                            <tr class="">
                                <td colspan="7"> <b> Pembayaran Non-Tunai </b> </td>
                                <td align="right"><b> </b></td>
                            </tr>
                        <?php endif; ?>
                        <?php
                        $jenis = "";
                        $jenispembayaran = JenispembayaranT::model()->findAllByAttributes(['tandabuktibayar_id' => $tandabukti->tandabuktibayar_id]);

                        $bank = "";
                        if (!empty($jenispembayaran)) {
                            $i = 1;
                            $hasil = count($jenispembayaran);

                            $modKonfig = KonfigsystemK::model()->find();
                            foreach ($jenispembayaran as $key => $val_jenis) {
                                $charge = "";
                                if (!empty($modKonfig)) {
                                    if ($val_jenis->jnspembayar_id == Params::JENIS_PEMBAYARAN_ID_CREDIT_CARD) {
                                        $charge = $modKonfig->charge_creditcard;
                                    } else {
                                        $charge = $modKonfig->charge_debitcard;
                                    }

                                    $charge = $charge . "%";
                                }
                        ?>
                                <tr>
                                    <td> </td>
                                    <?php
                                    if (!empty($val_jenis->bank)) {
                                    ?>
                                        <td style="font-weight: bold;" colspan="6"> <?= $val_jenis->jnspembayar->jnspembayar_nama . " : " . $val_jenis->bank . " - " . $val_jenis->pemilikkartu; ?></td>
                                    <?php } else { ?>
                                        <td colspan="6"> <?= $val_jenis->jnspembayar->jnspembayar_nama . " : " . $val_jenis->nostruk; ?> </td>
                                    <?php } ?>
                                    <td style="font-weight: bold;" align="right"> <?= MyFormatter::formatNumberForPrint($val_jenis->jumlahpembayaran - $val_jenis->biayacharge, 2); ?> </td>
                                </tr>
                                <?php if ($val_jenis->biayacharge > 0) : ?>
                                    <tr>
                                        <td> </td>
                                        <td colspan="6"> <b> Charge <?= $val_jenis->jnspembayar->jnspembayar_nama . " " . $charge ?> </b></td>
                                        <td style="font-weight: bold;" align="right"> <?= MyFormatter::formatNumberForPrint($val_jenis->biayacharge, 2); ?> </td>
                                    </tr>
                                <?php endif; ?>
                        <?php
                                if ($i > 1) {
                                    if ($i > 1 && $hasil != $i) {
                                        $bank .= ", ";
                                    }
                                }
                                $i++;
                            }
                        }

                        $jenis = $bank;
                        ?>
                        <?php 
                        $jmldbyr = 0;
                        $jmldbyr = $tandabukti->jmlpembayaran - $tandabukti->pembayaranpelayanan->selisihuntungrugibpjs;
                        if ($tandabukti->pembayaranpelayanan->total_inacbg != 0) : ?>
                            <tr class="">
                                <td colspan="7">Ditanggung oleh BPJS </td>
                                <td align="right"><?php echo MyFormatter::formatNumberForPrint($jmldbyr, 2); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td style="font-weight: bold;"> Terbilang </td>
                            <td style="font-weight: bold;" colspan="7"> <?= ucwords(MyFormatter::kataTerbilang($jmldbyr)) ?> Rupiah </td>
                        </tr>
                        <tr class="upper">
                            <td colspan="8"> </td>
                        </tr>
                        <?php if ($tandabukti->uangkembalian > 0) : ?>
                            <tr>
                                <td style="text-align:left;">Uang Kembalian</td>
                                <td style="text-align:left;" colspan="7"> <?php echo MyFormatter::formatNumberForPrint($tandabukti->uangkembalian, 2) ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <br>
                <?php if (empty($caraPrint)) {
                } else {
                ?>
                    <table width='100%' nowrap>
                        <tr>
                            <td align='center' nowrap>Penerima</td>
                            <td align='center' nowrap>Hormat Kami,</td>
                        </tr>
                        <tr>
                            <td colspan="2"> <br> <br> </td>
                        </tr>
                        <tr>
                            <td align='center' nowrap>........................</td>
                            <td align='center' nowrap><?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div style="padding-top: 0.5rem; font-size: 5pt">
                                    <small style="font-size: 8pt">
                                        Printed <?= ($tandabukti->printed_by == 0) ? "" : $tandabukti->printed_by ?> By <b><?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?> <?php echo date("d/m/y H:i:s"); ?> </b>
                                    </small>
                                </div>

                            </td>
                        </tr>
                    </table>
                <?php } ?>
            </td>
        </tr>
    </tbody>
</table>
<?php
if (isset($_GET['frame'])) {
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => 'print(\'PRINT\')'));
    echo "&nbsp";
    echo CHtml::link(Yii::t('mds', '{icon} Print PDF', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-danger', 'onclick' => 'print(\'PDF\')'));
    echo "&nbsp";
?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print(caraPrint) {
            window.open("<?php echo Yii::app()->createUrl("billingKasir/informasipenjualanresep/fakturPembayaranApotek", array("penjualanresep_id" => $_GET['penjualanresep_id'], 'tandabuktibayar_id' => $_GET['tandabuktibayar_id'])) ?>" + "&caraPrint=" + caraPrint, "", 'location=_new, width=1024px');
        }
    </script>
<?php
} ?>