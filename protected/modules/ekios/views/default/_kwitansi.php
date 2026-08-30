<style>
    body{
        width: 100%;
        color: black;
        /* height: 11cm; */
    }
    .identitas{
        line-height: 12px;
    }

    .identitas td {
        vertical-align: top;
    }

    .rincian th, .rincian td {
        border: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
    }

    .rincian tfoot td {
        font-weight: bold;
    }


    .table-rincian td, th{
        border-top: solid #000 1px;
        border-bottom: solid #000 1px;
    }

    TABLE, TBODY, TFOOT, TR, TH, TD{
        font-family: "Arial";
        font-size: 10px;
    }

    .tab_detail tfoot td, .footee {
        font-weight: bold;
    }

    .tab_detail .closing td {
        border-bottom: 1px solid black;
    }

    .tab_detail .grand_total td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
    table td{
        text-align:left;
        font-size:10px;
    }
    p{
        font-size:10px;

    }
    .hddn {
        display: none;
    }
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])) {
    ?>
    <table width="100%">
        <thead>
            <tr>
                <td>
                    <div class="header">
                    <?php if(isset($caraPrint)) {?>
                        <?php
                            echo $this->renderPartial('application.views.headerReport.headerDefaultA5', array('table_width' => '80%'));
                            ?>
                    
                        <?php }else{?>
                            <?php
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                            ?>

                        <?php } ?>
                   
                        </div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                    <?php }
                    ?>
                    <?php
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


                    $grp = array();

                    $diskon = 0;
                    $suba = 0;
                    $subp = 0;
                    $subr = 0;
                    $subtotalkotor = 0;
                    $subtotal = 0;




                        $modRincians2 = array();

                        foreach ($modRincians as $item) {
                            $dt = DaftartindakanM::model()->findByPk($item->daftartindakan_id, array(
                                'select' => 'daftartindakan_akomodasi'
                            ));
                            if (!$item->is_alkes && !empty($dt) && $dt->daftartindakan_akomodasi) {
                                array_unshift($modRincians2, $item);
                            } else {
                                $modRincians2[] = $item;
                            }
                        }

                        unset($modRincians);


                        foreach ($modRincians2 as $item) {

                        if ($item->qty_tindakan * $item->tarif_satuan == 0)
                            continue;

                        $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
                        $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;

                        if (empty($grp[$item->ruangan_id])) {
                            $grp[$item->ruangan_id] = array(
                                'nama' => $item->ruangan_nama,
                                'content' => array(),
                            );
                        }

                        $diskon += $item->discount_tindakan;


                        $suba += $item->subsidiasuransi_tindakan;
                        $subp += $item->subsidipemerintah_tindakan;
                        $subr += $item->subsisidirumahsakit_tindakan;


                        $item->tarif_satuan = round($item->tarif_satuan);
                        $subtotalkotor += round($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
                        $subtotal += round($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);

                        $tanggal = date('d/m/Y', strtotime($item->tgl_tindakan));
                        $daftartindakan_id = $item->daftartindakan_id . "_" . ($item->is_alkes ? "0" : "1");
                        $harga = $item->tarif_satuan;

                        $dt = DaftartindakanM::model()->findByPk($item->daftartindakan_id, array(
                            'select' => 'daftartindakan_akomodasi'
                        ));
                        if (!$item->is_alkes && !empty($dt) && $dt->daftartindakan_akomodasi) {
                            $idx_line = $daftartindakan_id . "::" . $harga;
                        } else {
                            $idx_line = $daftartindakan_id . "::" . $tanggal . "::" . $harga;
                        }

                        if (empty($grp[$item->ruangan_id]['content'][$idx_line])) {
                            $grp[$item->ruangan_id]['content'][$idx_line] = array(
                                'visite' => $item->daftartindakan_visite,
                                'konsul' => $item->daftartindakan_konsul,
                                'uraian' => $item->daftartindakan_nama,
                                'dokter' => $dokter,
                                'tgl' => date("d/m/Y", strtotime($item->tgl_tindakan)),
                                'jml' => $item->qty_tindakan,
                                'harga' => ($item->tarif_satuan),
                                'diskon' => ($item->discount_tindakan),
                                'suba' => ($item->subsidiasuransi_tindakan),
                                'subp' => ($item->subsidipemerintah_tindakan),
                                'subr' => ($item->subsisidirumahsakit_tindakan),
                                'subtotal' => (($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
                                'subtotalkotor' => (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan),
                                    //'detail_ambulans'=>$detail_ambulans,
                            );
                        } else {
                            $grp[$item->ruangan_id]['content'][$idx_line]['jml'] += $item->qty_tindakan;
                            $grp[$item->ruangan_id]['content'][$idx_line]['diskon'] += $item->discount_tindakan;
                            $grp[$item->ruangan_id]['content'][$idx_line]['suba'] += ($item->subsidiasuransi_tindakan);
                            $grp[$item->ruangan_id]['content'][$idx_line]['subp'] += ($item->subsidipemerintah_tindakan);
                            $grp[$item->ruangan_id]['content'][$idx_line]['subr'] += ($item->subsisidirumahsakit_tindakan);
                            $grp[$item->ruangan_id]['content'][$idx_line]['subtotal'] += (($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan));
                            $grp[$item->ruangan_id]['content'][$idx_line]['subtotalkotor'] += (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan);
                            /*
                              if (count($detail_ambulans) > 0) {
                              foreach ($detail_ambulans as $det_ambulans) {
                              $ada_detail = false;
                              foreach ($grp[$item->ruangan_id]['content'][$idx_line]['detail_ambulans'] as $det_ambulans2) {
                              if ($det_ambulans['nama'] == $det_ambulans2['nama']) {
                              $ada_detail = true;
                              $det_ambulans2['biaya'] += $det_ambulans['biaya'];
                              }
                              }
                              if (!$ada_detail) {
                              $grp[$item->ruangan_id]['content'][$idx_line]['detail_ambulans'][] = $det_ambulans;
                              }
                              }
                              }
                             * 
                             */
                        }



                        /*
                          array_push($grp[$item->ruangan_id]['content'], array(
                          'visite'=>$item->daftartindakan_visite,
                          'konsul'=>$item->daftartindakan_konsul,
                          'uraian'=>$item->daftartindakan_nama,
                          'dokter'=>$dokter,
                          'tgl'=>  date("d/m/Y", strtotime($item->tgl_tindakan)),
                          'jml'=> $item->qty_tindakan,
                          'harga'=> MyFormatter::formatNumberForPrint($item->tarif_satuan),
                          'diskon'=>MyFormatter::formatNumberForPrint($item->discount_tindakan),
                          'suba'=>MyFormatter::formatNumberForPrint($item->subsidiasuransi_tindakan),
                          'subp'=>MyFormatter::formatNumberForPrint($item->subsidipemerintah_tindakan),
                          'subr'=>MyFormatter::formatNumberForPrint($item->subsisidirumahsakit_tindakan),
                          'subtotal'=>MyFormatter::formatNumberForPrint(($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
                          'subtotalkotor'=>MyFormatter::formatNumberForPrint(($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan),
                          ));
                         * 
                         */


                                $grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
                            }

                            $subr = $modPembayaran->totalsubsidirs;
                            ?>

                        <div class="judulcontent" style="text-align: center;"></div>
                        <table class="identitas" width="100%">
                            <tr>
                                <td>Tagihan Pasien</td><td></td><td></td>
                                <td nowrap>Kelas Pelayanan</td><td>:</td><td><?php echo!empty($modPendaftaran->pasienadmisi_id) ? $admisi->kelaspelayanan->kelaspelayanan_nama : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
                            </tr>
                            <tr>
                                <td>TANGGAL / WAKTU DICETAK</td><td>:</td><td><?php echo date('d-m-Y / H:i:s', strtotime(date('Y-m-d  H:i:s'))); ?></td>
                                <td>No.</td><td>:</td><td><?php echo $modPembayaran->nopembayaran; ?></td>
                            </tr>

                            <tr>
                                <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
                            </tr>
                            <tr>

                                <td nowrap>NO. REG / NO. MR </td><td>:</td><td width="100%">
                                    <?php
                                    $modpasien = PasienM::model()->findByPk($modPembayaran->pasien_id);
                                    ?>
                                    <?php echo $modPendaftaran->no_pendaftaran . " / " . $modpasien->no_rekam_medik; ?></td>
                                <td nowrap>Poliklinik</td><td>:</td><td nowrap>
                                    <?php
                                    $modruangan = RuanganM::model()->findByPk($modPembayaran->ruangan_id);
                                    ?>
                                    <?php echo $modruangan->ruangan_nama ?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Masuk</td><td>:</td><td nowrap><?php echo date('d/m/Y', strtotime($modPendaftaran->tgl_pendaftaran)); ?> </td>
                                <td>Tanggal Keluar</td><td>:</td><td nowrap><?php echo date('d/m/Y', strtotime($modPembayaran->tglpembayaran)); ?></td>
                            </tr>
                            <tr>
                                <!--<td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php //echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir);     ?></td>-->
                                <td>Nama Pasien</td><td>:</td><td nowrap><?php echo $modpasien->namadepan . $modpasien->nama_pasien; ?></td>
                                <td>Penjamin Bayar</td><td>:</td><td nowrap>
                                    <?php
                                    $modpenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
                                    ?>
                                    <?php echo $modpenjamin->penjamin_nama ?></td>
                            </tr>
                            <tr>
                                <td>Dokter Utama</td><td>:</td><td nowrap>
                                    <?php
                                    $moddokter = PegawaiM::model()->findByPk($modPendaftaran->pegawai_id);
                                    ?>
                                    <?php echo $moddokter->namaLengkap; ?></td>
                                <td>Instalasi</td><td>:</td><td nowrap>
                                    <?php
                                    $modInstalasi = InstalasiM::model()->findByPk($modPendaftaran->instalasi_id);
                                    ?>
                                    <?php echo $modInstalasi->instalasi_nama; ?></td>
                            </tr>
                            <tr hidden>
                            </tr>
                            <?php if (!empty($admisi)): ?>

                                <?php
                                $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
                                $pulang = empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;

                                $vpulang = date('Y-m-d', strtotime($pulang));

                                $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
                                $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);

                                $val_daftar = strtotime($daftar);
                                $val_pulang = strtotime($vpulang);

                                $res = (($val_pulang - $val_daftar) / (3600 * 24)) + 1;


                                $str = $tgl_daftar . " - " . $tgl_pulang;

                                if ($admisi->penjamin_id == Params::PENJAMIN_ID_UMUM):
                                    ?>

                                    <tr>
                                        <td>Dokter</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
                                        <td>Selama</td><td>:</td><td nowrap><?php echo $res . " Hari - " . $str; ?></td>
                                    </tr>
                                <?php else : ?>
                                    <tr>
                                        <td>Dokter</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
                                        <td>Tgl Masuk</td><td>:</td><td nowrap><?php echo $tgl_daftar; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">&nbsp;</td>
                                        <td>Tgl Keluar</td><td>:</td><td nowrap><?php echo $tgl_pulang; ?></td>
                                    </tr>
                                <?php endif; ?>


                            <?php endif; ?>
                        </table>
                        <br/>

                        <br/><br/>

                        <?php /*
                      <div style='width:100%; text-align: center; font-weight: bold;'>  BUKTI PEMBAYARAN </div>
                      <table width="100%">
                      <tr>
                      <td>No. Urut</td><td>: <?php echo "-"?></td>
                      <td>No. Rekam Medis</td><td>: <?php echo $modPendaftaran->pasien->no_rekam_medik; ?></td>
                      </tr>
                      <tr>
                      <td>No. Pendaftaran</td><td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
                      <td>Tanggal Masuk RS</td><td>: <?php echo date("d-m-Y",strtotime($modPendaftaran->tgl_pendaftaran));?></td>
                      </tr>
                      <tr>
                      <td>Nama/Umur</td><td>: <?php echo $modPendaftaran->pasien->namadepan." ".$modPendaftaran->pasien->nama_pasien."/".$modPendaftaran->umur;?></td>
                      <td>Tanggal Keluar</td><td>: <?php
                      if (count($modRincians) > 0) {
                      echo date("d-m-Y",strtotime($modRincians[count($modRincians)-1]->tgl_tindakan));
                      }else{
                      echo "-";
                      } ?></td>
                      </tr>
                      <tr>
                      <td>Alamat</td><td>: <?php echo $modPendaftaran->pasien->alamat_pasien;?></td>
                      <td></td><td></td>
                      </tr>
                      <tr>
                      <td>Jenis Penjamin</td><td>: <?php echo $modPendaftaran->carabayar->carabayar_nama;?></td>
                      <td>Penjamin</td><td>: <?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
                      </tr>
                      </table>
                     * 
                     */ ?>
                     <?php /*
                      <table width='100%' cellpadding='2px' class='table-rincian'>
                      <thead>
                      <th>Tanggal</th>
                      <th>Uraian</th>
                      <th>Banyaknya</th>
                      <th>Harga Satuan</th>
                      <th>Jumlah</th>
                      </thead>
                      <tbody>
                      <?php
                      $totalbiaya = 0;
                      foreach($modRincians AS $i => $rincian) {
                      $totalbiaya += ($rincian->qty_tindakan*$rincian->tarif_satuan);
                      $tampilruangan = true;
                      if($i > 0){
                      if($modRincians[$i]->ruangan_id == $modRincians[$i-1]->ruangan_id){
                      $tampilruangan = false;
                      }else{
                      $tampilruangan = true;
                      }
                      }
                      if($tampilruangan){
                      ?>
                      <tr>
                      <td></td>
                      <td colspan='4'><b><?php echo $rincian->instalasi_nama." - ".$rincian->ruangan_nama; ?></b></td>
                      </tr>
                      <?php
                      }
                      ?>
                      <tr>
                      <td align='right'><?php echo date("d-m-Y",strtotime($rincian->tgl_tindakan)); ?></td>
                      <td><?php echo $rincian->daftartindakan_nama; ?></td>
                      <td align='right'><?php echo $rincian->qty_tindakan; ?></td>
                      <td align='right'><?php echo $format->formatNumberForPrint($rincian->tarif_satuan); ?></td>
                      <td align='right'><?php echo $format->formatNumberForPrint($rincian->qty_tindakan*$rincian->tarif_satuan); ?></td>
                      </tr>
                      <?php } ?>
                      </tbody>
                      <tfoot>
                      <tr>
                      <td colspan='4' align='left' style="font-weight:bold;">Jumlah Biaya</td>
                      <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
                      </tr>
                      <tr>
                      <td colspan='4' align='left' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
                      <td></td>
                      </tr>
                      </tfoot>

                      </table>
                     */ ?>

                        <?php
                        if (isset($_GET['frame'])) {
                            echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
                            echo "&nbsp;";
                            echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="' . MyIcon::getIcons('excel') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success', 'onclick' => "printExcel();"));
                            ?>
                        <script type='text/javascript'>
                            /**
                             * print
                             */
                            function print() {
                                window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar2", array("pembayaranpelayanan_id" => $_GET['pembayaranpelayanan_id'])) ?>", "", 'location=_new, width=1024px');
                            }

                            function printExcel() {
                                var pegawai_id = '<?php echo Yii::app()->user->getState('pegawai_id') ?>';

                                    <?php
                                    if (!empty(Params::getPegawaiAksesRincianExcel(Yii::app()->user->getState('pegawai_id')))) {
                                        ?>
                                                                    window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar2&caraPrint=EXCEL", array("pembayaranpelayanan_id" => $_GET['pembayaranpelayanan_id'])) ?>", "", 'location=_new, width=1024px');
                                        <?php
                                    } else {
                                        ?>
                                                                    myAlert("Anda tidak berhak untuk mengakses fungsi ini", "Perhatian!");
                                        <?php
                                    }
                                    ?>


                            }
                        </script>
                        <?php
                         } else {
                        ?>    
                        <!-- <table width='100%'>
                            <tr>
                                <td></td>
                                <td></td>
                                <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                            </tr>
                            <tr>
                                <td align='center'>Verifikasi</td>
                                <td align='center'>Yang membayar</td>
                                <td align='center'>Kasir</td>
                            </tr>
                            <tr height='100px'>
                                <td align='center'>__________________</td>
                                <td align='center'>__________________</td>
                                <td align='center'><?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
                            </tr>
                        </table> -->
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    
                <table width="100%" class="tab_detail" >
                        <thead style=''>
                        <th style='text-align: center;'></th>
                        <th style='text-align: center;'>Uraian</th>
                        <th style='text-align: center;'>Dokter</th>
                        <th style='text-align: center;'>Tgl Transaksi</th>
                        <th style='text-align: center;'>Jml</th>
                        <th style='text-align: center;'>Harga</th>
                        <th style='text-align: center;'>Keringanan</th>
                        <th style='text-align: center;' class="">Jaminan Asuransi</th>
                        <th style='text-align: center;' class="hddn">Jaminan Pemerintah</th>
                        <th style='text-align: center;' class="">Jaminan RS</th>
                        <th style='text-align: center;' class="hddn">Iur Biaya</th>
                        <th style='text-align: center;'>Sub Total</th>
                        </thead>
                        <tbody>
                            <?php foreach ($grp as $item) : ?>
                                <tr>
                                    <td colspan="11"><strong><?php echo $item['nama']; ?></strong></td>
                                </tr>
                                <?php
                                $cnt = 0;
                                foreach ($item['content'] as $item2) :
                                    $cnt++;
                                    ?>
                                    <tr>
                                        <td><?php echo "*."; ?></td>
                                        <td><?php echo $item2['uraian']; ?></td>
                                        <td><?php
                                             //if ($item2['visite'] || $item2['konsul']) {
                                            echo $item2['dokter'];
                                              //   }
                                            ?></td>
                                        <td><?php echo $item2['tgl']; ?></td>
                                        <td style="text-align: right;"><?php echo str_replace(".", ",", $item2['jml']); ?></td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['harga']); ?></td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['diskon']); ?></td>
                                        <td style="text-align: right;" class=""><?php echo MyFormatter::formatNumberForPrint($item2['suba']); ?></td>
                                        <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($item2['subp']); ?></td>
                                        <td style="text-align: right;" class=""><?php echo MyFormatter::formatNumberForPrint($item2['subr']); ?></td>
                                        <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($item2['subtotal']); ?></td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['subtotalkotor']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <tr style="border-top:1px solid #333;" class="footee">
                                <td colspan="6">Total Tagihan</td>
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($diskon); ?></td>
                                <td style="text-align: right;" class=""><?php echo MyFormatter::formatNumberForPrint($suba); ?></td>
                                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
                                <td style="text-align: right;" class=""><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
                                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor); ?></td>
                            </tr>
                            <?php if ($tandabukti->biayaadministrasi != 0): ?>
                                <tr class="closing footee">
                                    <td colspan="9">Administrasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi); ?></td>
                                </tr>
                            <?php endif; ?>

                            <?php
                            $modSubsidi = SubsidikelasT::model()->findByAttributes(array(
                                'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id,
                            ));

                            $kelas_master = array(
                                Params::KELASPELAYANAN_ID_KELAS_III => 1,
                                Params::KELASPELAYANAN_ID_KELAS_II => 2,
                                Params::KELASPELAYANAN_ID_KELAS_I => 3
                            );

                            // var_dump($kelas); die;

                            $bkelas = array();

                            if (!empty($modSubsidi)) {
                                ?>

                                <?php if ($modPembayaran->totaldiscount != 0): ?>
                                    <tr class="footee">
                                        <td colspan="9">Potongan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
                                    </tr>
                                <?php endif; ?>    

                                <?php if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
                                    <tr class="grand_total footee">
                                        <td colspan="9">TOTAL</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php
                                $suba = 0;
                                $modPembayaran->totalsubsidiasuransi = 0;


                                /*
                                  foreach ($modSubsidi as $item) {

                                  if (!empty($admisi) && $item->kelaspelayanan_id == $admisi->kelaspelayanan_id) {
                                  $bkelas[0] = array(
                                  'kelas'=>$item->kelaspelayanan_id,
                                  'value'=>$item->subsidiasuransi,

                                  );
                                  }

                                  if (!empty($asuransi) && $item->kelaspelayanan_id == $asuransi->kelastanggunganasuransi_id) {
                                  $bkelas[1] = array(
                                  'kelas'=>$item->kelaspelayanan_id,
                                  'value'=>$item->subsidiasuransi,
                                  );
                                  }
                                  //}
                                 * 
                                 */

                                // var_dump($bkelas); die;
                                //ksort($bkelas);
                                //foreach ($bkelas as $item) {
                                $suba += $modSubsidi->subsidiasuransi;
                                $modPembayaran->totalsubsidiasuransi += $modSubsidi->subsidiasuransi;
                                $kelas = KelaspelayananM::model()->findByPk($modSubsidi->kelaspelayanan_id);
                                ?>
                                <tr class="closing footee">
                                    <td colspan="9">INA <?php echo $kelas->kelaspelayanan_nama; ?></td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modSubsidi->subsidiasuransi); ?></td>
                                </tr>
                                <?php
                                //} 
                                // var_dump($bkelas, $kelas_master); die;
                                ?>

                                <?php if ($modPembayaran->total_inacbg != 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Total INACBG</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg); ?></td>
                                    </tr>
                                    <?php
                                    $dibayar = $modPembayaran->total_inacbg;

                                /*
                                  ?>
                                  <tr class="closing footee">
                                  <td colspan="9">Dibayar Oleh Pasien</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr) + $tandabukti->jmlpembulatan); ?></td>
                                  </tr>

                                  <?php */ endif;
                                ?>


                                <?php
                                // if ($suba < ($subtotalkotor + $tandabukti->biayaadministrasi)) { 

                                $ekses = $modSubsidi->subsidiasuransi - $modPembayaran->total_inacbg;

                                /*
                                  $bcount = count($bkelas);




                                  if ($bcount != 0) {
                                  if ($bcount == 1) {
                                  if (empty($bkelas[0])) {
                                  $ekses = ($subtotalkotor + $tandabukti->biayaadministrasi - $modPembayaran->totaldiscount) - $bkelas[1]['value'];
                                  } else {
                                  $ekses = ($subtotalkotor + $tandabukti->biayaadministrasi - $modPembayaran->totaldiscount) - $bkelas[0]['value'];
                                  }
                                  } else {
                                  $kelas_a = $bkelas[0];
                                  $kelas_b = $bkelas[1];

                                  if ($kelas_master[$kelas_a['kelas']] > $kelas_master[$kelas_b['kelas']]) {
                                  $ekses = $kelas_a['value'] - $kelas_b['value'];
                                  } else {
                                  $ekses = $kelas_b['value'] - $kelas_a['value'];
                                  }
                                  }
                                  }
                                  if ($ekses < 0) $ekses = 0;
                                 * 
                                 */


                                if ($ekses > 0) :
                                    ?>

                                    <?php if ($tandabukti->jmlpembulatan != 0): ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Pembulatan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
                                        </tr>
                                    <?php endif; ?>


                                    <?php
                                    $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                                        'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id
                                    ));

                                    $jml_uangmuka = 0;

                                    if (!empty($bayaruangmuka)):

                                        $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

                                        $ekses -= $jml_uangmuka;
                                        $ekses += $tandabukti->jmlpembulatan;
                                        ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Total Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka); ?></td>
                                        </tr>
                                        <tr class="closing footee">
                                            <td colspan="9">Pemakaian Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka); ?></td>
                                        </tr>
                                        <tr class="closing footee">
                                            <td colspan="9">Sisa Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
                                        </tr>

                                    <?php endif; ?>

                                    <tr class="closing footee">
                                        <td colspan="9">Dibayar Oleh Pasien</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($ekses); ?></td>
                                    </tr>
                                    <?php if ($tandabukti->bank_nominal > 0): ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Pembayaran Non-Tunai</td><td style="text-align: right;">(<?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal); ?>)</td>
                                        </tr>
                                    <?php endif; ?>


                                    <?php if ($ekses - $tandabukti->bank_nominal > 0): ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Pembayaran Tunai</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal); ?></td>
                                        </tr>
                                    <?php endif; ?>



                                    <?php if ($ekses - $tandabukti->bank_nominal > 0): ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Diterima Kasir</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ($modPembayaran->selisihuntungrugibpjs != 0): ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Selisih Keuntungan/Kerugian BPJS</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->selisihuntungrugibpjs, 0, true); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                <?php endif; ?>



                                <?php
                                //    }
                            } else {
                                ?>
                                <?php if ($modPembayaran->totaldiscount != 0): ?>
                                    <tr class="footee">
                                        <td colspan="9">Potongan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
                                    </tr>
                                <?php endif; ?>


                                <?php if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
                                    <tr class="grand_total footee">
                                        <td colspan="9">TOTAL</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($modPembayaran->total_inacbg != 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Total INACBG</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($modPembayaran->totalsubsidiasuransi != 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Dijamin Asuransi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsubsidiasuransi); ?></td>
                                    </tr>

                                <?php endif; ?>
                                <?php if ($subp > 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Dijamin Pemerintah</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($subr > 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Dijamin RS</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
                                    </tr>
                                <?php endif; ?>


                                <?php if ($tandabukti->jmlpembulatan != 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Pembulatan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
                                    </tr>
                                <?php endif; ?>

                                <?php
                                $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                                    'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id
                                ));

                                $jml_uangmuka = 0;

                                if (!empty($bayaruangmuka)):

                                    $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;
                                    ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Total Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka); ?></td>
                                    </tr>
                                    <tr class="closing footee">
                                        <td colspan="9">Pemakaian Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka); ?></td>
                                    </tr>
                                    <tr class="closing footee">
                                        <td colspan="9">Sisa Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
                                    </tr>

                                <?php endif; ?>


                                <?php
                                $great_total = ($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr) - $jml_uangmuka) + $tandabukti->jmlpembulatan;

                                if (($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr)) > 0 && (($modPembayaran->penjamin_id != Params::PENJAMIN_ID_UMUM && !empty($admisi)) || (!empty($bayaruangmuka) && $bayaruangmuka->pemakaianuangmuka > 0))):
                                    ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Dibayar Oleh Pasien</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($great_total); ?></td>
                                    </tr>
                                <?php endif;
                                ?>

                                <?php if ($tandabukti->bank_nominal > 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Pembayaran Non-Tunai</td><td style="text-align: right;">(<?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal); ?>)</td>
                                    </tr>
                                <?php endif; ?>


                                <?php if ($great_total - $tandabukti->bank_nominal > 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Pembayaran Tunai</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($great_total - $tandabukti->bank_nominal); ?></td>
                                    </tr>
                                <?php endif; ?>



                                <?php if ($great_total - $tandabukti->bank_nominal + $tandabukti->jmlpembulatan > 0): ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Diterima Kasir</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($great_total - $tandabukti->bank_nominal); ?></td>
                                    </tr>
                                <?php endif; ?>


                            <?php } ?>
                        </tbody>

                        </table>
                </td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table width='100%;'>
                        <tr>
                            <td></td>
                            <td></td>
                            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                        </tr>
                        <tr>
                            <td align='center'>Verifikasi</td>
                            <td align='center'>Yang membayar</td>
                            <td align='center'>Kasir</td>
                        </tr>
                        <tr height='100px'>
                            <td align='center'>__________________</td>
                            <td align='center'>__________________</td>
                            <td align='center'><?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
                        </tr>
                    </table>   
                </td>
            </tr>
        </tbody>
        <tfoot hidden>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <!-- <div class="footer">
        <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
    </div> -->
    <?php
}
?>
<?php
if (empty($caraPrint)) {
    if (!empty($modPembayaran->pembayaranpelayanan_id)) {
        $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintKwitansi&pembayaranpelayanan_id=' . $modPembayaran->pembayaranpelayanan_id);
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
    } else {
        $urlPrint = '';
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
    }
    ?>
    <script>
        function print(caraPrint)
        {
            window.open("<?php echo $urlPrint ?>&caraPrint=" + caraPrint, "", 'location=_new, width=980px');
        }
    </script>
    <?php
}
?>
   
