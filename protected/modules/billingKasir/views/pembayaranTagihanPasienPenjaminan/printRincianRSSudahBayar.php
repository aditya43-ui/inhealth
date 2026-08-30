<style>
    .table-rincian th{
        border-top: solid #000 1px;
        border-bottom: solid #000 1px;
    }

    .table-rincian  tfoot tr  td{
        border-top: solid #000 1px;
        border-bottom: solid #000 1px;
    }

    TABLE, TBODY, TFOOT, TR, TH, TD{
        /*        font-family: "Arial";
                font-size: 10px;*/
    }
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])) {

}
$jml_uangmuka = 0;
?><span style="width: 100%">

</span>
<table width="100%">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewV1', array());
                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <div class="judulcontent" style='width:100%; text-align: center; font-weight: bold;'>  BUKTI PEMBAYARAN RUMAH SAKIT  </div>
                    <br/>
                    <table width="100%">
                        <tr>
                            <!-- <td>No. Urut</td><td>: <?php echo "-" ?></td> -->
                            <td>No. Pendaftaran</td><td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
                            <td>No. Rekam Medis</td><td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Nama/Umur</td><td>: <?php echo $modPendaftaran->pasien->namadepan . " " . $modPendaftaran->pasien->nama_pasien . "/" . $modPendaftaran->umur; ?></td>
                            <td>Tanggal Masuk RS</td><td>: <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td><td>: <?php echo $modPendaftaran->pasien->alamat_pasien; ?></td>
                            <td>Tanggal Keluar</td><td>: <?php
                                $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                                $modPasienpulang = PasienpulangT::model()->findByPk($modPendaftaran->pasienpulang_id);
                                $tglKeluar = date("Y-m-d H:i:s");

                                if (isset($modAdmisi)) {
                                    $tglKeluar = $modAdmisi->rencanapulang;
                                }else{
                                    if(isset($modPasienpulang)){
                                        $tglKeluar = $modPasienpulang->tglpasienpulang;
                                    }
                                }

                                echo MyFormatter::formatDateTimeForUser($tglKeluar);
                                ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin</td><td>: <?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
                            <td>Penjamin</td><td>: <?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
                        </tr>
                    </table>
                    <table width='100%' cellpadding='2px' class='table-rincian'>
                        <thead>
                        <th>No.</th>
                        <th>Uraian</th>
                        <th>Jasa RS</th>
                        <th>Jasa Medis</th>
                        <th>Jasa Pelayanan Lainnya</th>
                        <th>Obat Alkes / BHP</th>
                        <!--<th>DMK</th>-->
                        <th>Jumlah</th>
                        </thead>
                        <tbody>
                            <?php
                            $totalbiaya = 0;
                            $totaljasarsu = 0;
                            $totaljasapelayanan = 0;
                            $totalrfs = 0;
                            $totalgizi = 0;
                            $totaldmk = 0;
                            $jmlBiaya = 0;
                            $tandabukti = TandabuktibayarT::model()->findByAttributes(array(
                                'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id,
                            ));

    //    echo '<pre>';
    //    print_r($modRincians);
    //    exit();
                            foreach ($modRincians AS $i => $rincian) {
                                $jasarsu = 0;
                                $jasapelayanan = 0;
                                $rfs = 0;
                                $gizi = 0;
                                $dmk = 0;
                                $jumlah = $rincian->tarif_tindakanpelayanan;
                                $jumlahKomponen = 0;

                                // $jumlah = $rincian->qty_tindakan * $rincian->tarif_satuan;
                                $modTindakanKomp = TindakankomponenT::model()->findAllByAttributes(array("tindakanpelayanan_id" => $rincian->tindakanpelayanan_id));
//var_dump($rincian->tindakanpelayanan_id); die;
                                if (count((array)$modTindakanKomp) > 0) {
                                    foreach ($modTindakanKomp as $tindKom) {
                                      if(isset($tindKom->komponentarif) && !empty($tindKom->komponentarif)){
                                        if ($tindKom->komponentarif->isjasars == true) {
                                         //$jasarsu += $tindKom->iurbiayakomp;
                                      //   $jasarsu += $tindKom->tarif_satuan;
                                            $jasarsu += ($tindKom->tarif_kompsatuan * $rincian->qty_tindakan);
                                        } else if ($tindKom->komponentarif->isjasamedis == true) {
                                       //   $jasapelayanan += $tindKom->iurbiayakomp;
                                         //  $jasapelayanan += $tindKom->tarif_satuan;
                                         $jasapelayanan += ($tindKom->tarif_kompsatuan * $rincian->qty_tindakan);
                                        } else if ($tindKom->komponentarif->isbhp == true) {
                                          //$gizi += $tindKom->iurbiayakomp;
                                         //  $gizi += $tindKom->tarif_satuan;
                                          
                                            $gizi += ($tindKom->tarif_kompsatuan * $rincian->qty_tindakan);
                                        } else if ($tindKom->komponentarif->isjasalayananlain == true){
                                        //  $rfs += $tindKom->iurbiayakomp;
                                         // $rfs +=  $tindKom->tarif_satuan;
                                           $rfs += ($tindKom->tarif_kompsatuan * $rincian->qty_tindakan);
                                        }
                                      }

                                    }
                                }

                                if (!$rincian->is_alkes) {
//                $jasarsu = $rincian->JasaRumahSakit;
//                $jasapelayanan = $rincian->JasaPelayanan;
//                $rfs = $rincian->JasaRFS;
//                $dmk = $rincian->JasaDMK;
                                } else {
                                    $gizi += $jumlah;
                                }
                                $jumlahKomponen = ($jasarsu + $jasapelayanan + $rfs + $gizi);
                                $jumlahKomponen2 = $gizi;

                                $totaljasarsu += $jasarsu;
                                $totaljasapelayanan += $jasapelayanan;
                                $totalrfs += $rfs;
                                $totalgizi += $gizi;
                                $totaldmk += $dmk;
                                // $totalbiaya += ($rincian->qty_tindakan * $rincian->tarif_satuan);
                                $totalbiaya += $jumlahKomponen;


                                $tampilruangan = true;
                                if ($i > 0) {
                                    if ($modRincians[$i]->ruangan_id == $modRincians[$i - 1]->ruangan_id) {
                                        $tampilruangan = false;
                                    } else {
                                        $tampilruangan = true;
                                    }
                                }
                                if ($tampilruangan) {
                                    ?>
                                    <tr>
                                        <td></td>
                                        <td colspan='7'><b><?php echo $rincian->instalasi_nama . " - " . $rincian->ruangan_nama; ?></b></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td align='center'><?php echo ($i + 1); ?></td>
                                    <td><?php echo $rincian->daftartindakan_nama; ?></td>
                                    <td align='right'><?php echo $format->formatNumberForPrint($jasarsu,2); ?></td>
                                    <td align='right'><?php echo $format->formatNumberForPrint($jasapelayanan,2); ?></td>
                                    <td align='right'><?php echo $format->formatNumberForPrint($rfs,2); ?></td>
                                    <td align='right'><?php echo $format->formatNumberForPrint($gizi,2); ?></td>
                                    <!--<td align='right'><?php // echo $format->formatNumberForPrint($dmk);     ?></td>-->
                                    <td align='right'><?php echo $format->formatNumberForPrint($rincian->tarif_tindakan,0); ?></td>
                                </tr>
                                <?php
                            }
                            $jmlBiaya = $totalbiaya;
                            $totalbiaya = (($totalbiaya + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
                            $konfigPembulatan = Yii::app()->user->getState('pembulatanhargakasir');
                            /* $jmlBulat = 0;
                              if($konfigPembulatan > 0){
                              $nilaibulat = ceil(($totalbiaya)/$konfigPembulatan)*$konfigPembulatan;
                              $jmlBulat = $nilaibulat - $totalbiaya;

                              if($konfigPembulatan == $jmlBulat){
                              $jmlBulat = 0;
                              }
                              } */
                            $totalbiaya = $totalbiaya; //+$jmlBulat;
                            
                            $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                                'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id
                            ));

                            if (!empty($bayaruangmuka)){
                              $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;
                            }

                            $great_total = ($totalbiaya - $jml_uangmuka + $tandabukti->jmlpembulatan);

                            $modSubsidi = SubsidikelasT::model()->findByAttributes(array(
                                'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id,
                            ));

                            $totalbiaya = ($tandabukti->uangditerima + $tandabukti->bank_nominal);
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <!-- <td colspan='2' align='right' style="font-weight:bold;">Total Biaya Pelayanan</td> -->
                                <td colspan='2' style="font-weight:bold;">Total Biaya Pelayanan</td>
                                <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totaljasarsu,2); ?></td>
                                <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totaljasapelayanan,2); ?></td>
                                <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalrfs,2); ?></td>
                                <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalgizi,2); ?></td>
                                <!--<td align='right' style="font-weight:bold;"><?php // echo $format->formatNumberForPrint($totaldmk);     ?></td>-->
                                <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($tandabukti->jmlpembayaran ,0); ?></td>
                            </tr>
                            <?php if ($tandabukti->biayaadministrasi > 0): ?>
                                <tr>
                                    <td colspan='2' align='left' style="font-weight:bold;">Administrasi</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($tandabukti->biayaadministrasi,2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($modPembayaran->totaldiscount > 0): ?>
                                <tr>
                                    <td colspan='2' align='right' style="font-weight:bold;">Total Keringanan</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($modPembayaran->totaldiscount,2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($modPembayaran->jasapelayanan_farmasi > 0): ?>
                                <tr>
                                    <td colspan='2' align='right' style="font-weight:bold;">Jasa Pelayanan Farmasi</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($modPembayaran->jasapelayanan_farmasi,2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($tandabukti->jmlpembayaran > 0): ?>
                                <tr>
                                    <!-- <td colspan='2' align='right' style="font-weight:bold;">Total Tagihan</td> -->
                                    <td colspan='2' style="font-weight:bold;">Total Tagihan</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($tandabukti->jmlpembayaran,0); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($modPembayaran->totalpembebasan > 0): ?>
                                <tr>
                                    <td colspan='2' align='right' style="font-weight:bold;">Total Pembebasan</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($modPembayaran->totalpembebasan,2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($modPembayaran->total_inacbg != 0 || $modPembayaran->totalsubsidiasuransi != 0): ?>
                                <tr>
                                    <td colspan='2' align='left' style="font-weight:bold;">Total Tanggungan Asuransi</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint((!empty($modPembayaran->total_inacbg)? $modPembayaran->total_inacbg : $modPembayaran->totalsubsidiasuransi),2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($modPembayaran->totalsubsidirs > 0): ?>
                                <tr>
                                    <td colspan='2' align='right' style="font-weight:bold;">Total Tanggungan Rumah Sakit</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($modPembayaran->totalsubsidirs,2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($jml_uangmuka > 0): ?>
                                <tr>
                                    <td colspan='2' align='right' style="font-weight:bold;">Pemakaian Uang Muka</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($jml_uangmuka,2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($modPembayaran->totaliurbiaya > 0): ?>
                                <tr>
                                    <!-- <td colspan='2' align='right' style="font-weight:bold;">Dibayar Oleh Pasien</td> -->
                                    <td colspan='2' style="font-weight:bold;">Dibayar Oleh Pasien</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($modPembayaran->totaliurbiaya,0); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($tandabukti->jmlpembulatan != 0): ?>
                                <tr>
                                    <!-- <td colspan='2' align='right' style="font-weight:bold;">Jumlah Pembulatan</td> -->
                                    <td colspan='2' style="font-weight:bold;">Jumlah Pembulatan</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if (($tandabukti->uangditerima) > 0): ?>
                                <tr>
                                    <!-- <td colspan='2' align='right' style="font-weight:bold;">Pembayaran Tunai</td> -->
                                    <td colspan='2' style="font-weight:bold;">Pembayaran Tunai</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint(($tandabukti->uangditerima),0); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($tandabukti->bank_nominal > 0): ?>
                                <tr>
                                    <td colspan='2' align='right' style="font-weight:bold;">Pembayaran Non Tunai</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($tandabukti->bank_nominal,2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if ($modPembayaran->totalsisatagihan > 0): ?>
                                <tr>
                                    <td colspan='2' align='right' style="font-weight:bold;">Total Sisa Tagihan</td>
                                    <!--<td></td>-->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($modPembayaran->totalsisatagihan,2); ?></td>
                                </tr>
                            <?php endif; ?>

                            
                            <tr hidden>
                                <td colspan='8' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
                            </tr>
                        </tfoot>
                    </table>

                    <?php
                    if (isset($_GET['frame'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
                        ?>
                        <script type='text/javascript'>
                            /**
                             * print
                             */
                            function print() {
                                window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianRSSudahBayar", array("pembayaranpelayanan_id" => $_GET['pembayaranpelayanan_id'])) ?>", "", 'location=_new, width=1024px');
                            }
                        </script>
                        <?php
                    } else {
                        ?>
                        <table width='100%'>
                            <tr>
                                <td></td>
                                <td align="center"><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                            </tr>
                            <tr>
                                <td align="center">Verifikasi</td>
                                <td align="center">Kasir</td>
                            </tr>
                            <tr height='100px'>
                                <td align="center">__________________</td>
                                <!-- <td align="center"><?php //echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td> -->
                                <td align='center'><?php echo Yii::app()->user->getState('nama_pegawai'); ?></td>
                            </tr>
                            <tr>
                                <td><i><?php echo Yii::app()->user->getState('pesandistruk'); ?></i></td>
                                <td></td>
                            </tr>
                        </table>
                        <?php
                    }
                    ?>
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

<div class="footer">
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
