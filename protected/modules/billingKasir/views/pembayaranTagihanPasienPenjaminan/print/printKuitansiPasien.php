<?php $data = ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<!--KUITANSI -->
<style>
    body {
        letter-spacing: 2px;
    }

    table,
    td,
    div {
        font-size: 8pt;
        font-family: Arial;
    }

    .catatan {
        font-size: 8pt;
        text-align: left;
    }

    .uang {
        font-size: 12pt;
        font-weight: bold;
    }

    .terbilang {
        font-style: italic;
    }

    .tandatangan {
        text-align: center;
        vertical-align: top;
    }
</style>

<table width="100%">
    <thead>
        <tr>
            <td>
                <div class="header">
                    <?php
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">

                    <table width="100%">
                        <?php
                        $format = new MyFormatter();

                        $jmlpembulatan = $modTandaBukti->jmlpembulatan;

                        $slippage = "No Kuitansi : " . $modTandaBukti->nobuktibayar;
                        $ru = "";
                        if (!empty($modPendaftaran->pasienadmisi_id)) $ru = " RAWAT INAP";
                        else if (!empty($modPendaftaran->instalasi)) $ru = " " . strtoupper($modPendaftaran->instalasi->instalasi_nama);
                        else $ru = empty($modBayar->ruanganpelakhir) ? " " : (" " . strtoupper($modBayar->ruanganpelakhir->instalasi->instalasi_nama));

                        $jenis = "";
                        if (!empty($modAngsuran)) {
                            $jenis = " ANGSURAN ";
                        } ?>
                        <TR>
                            <TD colspan="3" style="border-bottom: 1px solid #000000; text-align: right !important;">
                                <right>
                                    <?php echo ((isset($slippage)) ? $slippage : null); ?>
                                </right>
                            </TD>
                        </TR>
                        <tr>
                            <td valig="middle" colspan="3">
                                <table cellspacing=0 width="100%">
                                    <tbody>
                                        <tr>
                                            <td colspan="3" align="center">
                                                <div align="center" class="judulcontent" style="font-size:15pt;text-decoration: underline; font-family: Arial, Helvetica, sans-serif !important"><b>KUITANSI<?php echo $jenis . $ru; ?></b></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sudah Terima Dari</td>
                                            <td>:</td>
                                            <td><?php echo $modBayar->pendaftaran->pasien->nama_pasien; ?></td>
                                        </tr>
                                        <tr>
                                            <td>No.Rekam Medis/Nama Pasien</td>
                                            <td>:</td>
                                            <td><?php echo $modBayar->pendaftaran->pasien->no_rekam_medik . ' / ' . $modBayar->pendaftaran->pasien->nama_pasien; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Uang Sejumlah</td>
                                            <td>:</td>
                                            <td class="terbilang">
                                                <?php
                                                echo strtoupper($format->formatNumberTerbilang($rincianpembayaran)) . ' RUPIAH';
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Untuk Pembayaran</td>
                                            <td>:</td>
                                            <td><?php echo $modTandaBukti->sebagaipembayaran_bkm; ?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));
                                                                                                    ?></td>
                                        </tr>
                                        <tr>
                                            <td>Poliklinik/Ruangan</td>
                                            <td>:</td>
                                            <td><?php echo $modTandaBukti->getRuanganNama($modTandaBukti->pembayaranpelayanan_id); ?><?php //echo date('d/m/Y',  strtotime($modPendaftaran->tgl_pendaftaran));
                                                                                                                                        ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div align="center" style="border:1px solid #000000;width:200px;padding:5px;" class="uang">
                                                    Rp. <?php echo MyFormatter::formatNumberForPrint($rincianpembayaran, 2); ?>,-
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php $konfig = KonfigsystemK::model()->find(); ?>
                    <table frame=void align=left cellspacing=0 cols=11 rules=none border=0 width="100%">
                        <tr>
                            <td width="60%" align="center" valign="top">
                                <div colspan="2" class="catatan">


                                </div>
                            </td>
                            <td class="tandatangan">

                                <?php //echo Yii::app()->user->getState('kabupaten_nama') 
                                ?>,
                                <?php
                                $format = new MyFormatter();
                                $tgl = $modTandaBukti->tglbuktibayar;
                                $tglBayar = explode(" ", $tgl);
                                $tanggal = date('Y-m-d'); //$tglBayar[0];
                                $tgls = Myformatter::formatDateTimeId($tanggal);
                                // echo $tgls . " " . date("H:i:s", strtotime($modTandaBukti->tglbuktibayar));
                                ?>

                                <br>
                                Petugas Kasir,
                                <br>

                                <?php
                                $modPegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                $modCari = PegawaiM::statusTTDDigital($modPegawai->pegawai_id);
                                $url = '';
                                if ($modCari == 1) {
                                    if (!empty($modPegawai->ttd_pegawai)) {
                                        $url = Params::urlPegawaiDirectory() . $modPegawai->ttd_pegawai;
                                ?>
                                        <img src="<?= $url ?>" width="100mm" height="100mm">
                                    <?php
                                    }
                                } else { ?>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                <?php }
                                ?>
                                <br>
                                <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                                <b><?php echo empty($pegawai) ? "-" : $pegawai->nama_pegawai; ?></b>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="" style="text-align:left; font-size: 7.5pt !important">
                    Printed <?= ($modTandaBukti->printed_by == 1) ? "" : $modTandaBukti->printed_by ?> by : <b><?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?> <?php echo date("d/m/Y H:i:s"); ?> </b>
                </div>
            </td>
        </tr>
    </tbody>
</table>