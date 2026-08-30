<style>
    body {
        width: 100%;
        color: black;
        /* height: 11cm; */
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
    }

    TABLE,
    TBODY,
    TFOOT,
    TR,
    TH,
    TD {
        font-family: "Arial";
        font-size: 10px;
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

    .hddn {
        display: none !important;
    }
</style>
<?php
$format = new MyFormatter;
?>
<?php
                                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                    ?>
                    <?php
                    // }
                    ?>
                    <?php
                    $grand_totals = 0;
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
                    // var_dump($tandabukti->attributes); die;
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
                        if ($item->qty_tindakan * $item->tarif_satuan == 0) continue;
                        $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
                        $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        $diskon += $item->discount_tindakan;
                        $suba += $item->subsidiasuransi_tindakan;
                        $subp += $item->subsidipemerintah_tindakan;
                        $subr += $item->subsisidirumahsakit_tindakan;
                        $item->tarif_satuan = (round($item->tarif_satuan * 100) / 100);
                        $subtotalkotor += (round($item->qty_tindakan * $item->tarif_satuan * 100) / 100) - $item->discount_tindakan;
                        $subtotal += (round($item->qty_tindakan * $item->tarif_satuan * 100) / 100) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
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
                        $txt_index = "";
                        $is_paket = ($item->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET ? 0 : 1);

                        if ($item->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
                            $txt_index = $item->ruangan_id;
                            if (empty($grp[$txt_index])) {
                                $grp[$txt_index] = array(
                                    'nama' => $item->ruangan_nama,
                                    'content' => array(),
                                    'total' => null,
                                );
                            }
                        } else {
                            $paket = TipepaketM::model()->findByPk($item->tipepaket_id);
                            $txt_index = $paket->tipepaket_nama . "_" . date('YmdHis', strtotime($item->tgl_tindakan));
                            if (empty($grp[$txt_index])) {
                                $grp[$txt_index] = array(
                                    'nama' => "Tipe Paket - " . $paket->tipepaket_nama,
                                    'content' => array(),
                                    'total' => 0,
                                );
                            }
                        }
                        $grp[$txt_index]['total'] += (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan);
                        if (empty($grp[$txt_index]['content'][$idx_line])) {
                            $grp[$txt_index]['content'][$idx_line] = array(
                                'visite' => $item->daftartindakan_visite,
                                'konsul' => $item->daftartindakan_konsul,
                                'uraian' => $item->daftartindakan_nama,
                                'dokter' => $dokter,
                                'tgl' =>  date("d/m/Y H:i:s", strtotime($item->tgl_tindakan)),
                                'jml' => $item->qty_tindakan,
                                'harga' => ($item->tarif_satuan),
                                'diskon' => ($item->discount_tindakan),
                                'suba' => ($item->subsidiasuransi_tindakan),
                                'subp' => ($item->subsidipemerintah_tindakan),
                                'subr' => ($item->subsisidirumahsakit_tindakan),
                                'subtotal' => (($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
                                'subtotalkotor' => (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan),
                                'is_paket' => $is_paket
                                //'detail_ambulans'=>$detail_ambulans,
                            );
                        } else {
                            $grp[$txt_index]['content'][$idx_line]['jml'] += $item->qty_tindakan;
                            $grp[$txt_index]['content'][$idx_line]['diskon'] += $item->discount_tindakan;
                            $grp[$txt_index]['content'][$idx_line]['suba'] += ($item->subsidiasuransi_tindakan);
                            $grp[$txt_index]['content'][$idx_line]['subp'] += ($item->subsidipemerintah_tindakan);
                            $grp[$txt_index]['content'][$idx_line]['subr'] += ($item->subsisidirumahsakit_tindakan);
                            $grp[$txt_index]['content'][$idx_line]['subtotal'] += (($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan));
                            $grp[$txt_index]['content'][$idx_line]['subtotalkotor'] += (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan);
     
                        }

                        $grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
                    }
                    $subr = $modPembayaran->totalsubsidirs;
                    ?>
                    <div class="judulcontent" style="text-align: center;">RINCIAN TAGIHAN SUDAH BAYAR</div>
                    <br/>
                    <table class="identitas" width="100%">
                        <tr>
                            <td>No Pembayaran</td>
                            <td width="10">:</td>
                            <td><?php echo $modPembayaran->nopembayaran; ?></td>
                            <td nowrap>Kelas Pelayanan</td>
                            <td width="10">:</td>
                            <td><?php echo !empty($modPendaftaran->pasienadmisi_id) ? $admisi->kelaspelayanan->kelaspelayanan_nama : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Penjamin</td>
                            <td>:</td>
                            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
                            <?php if (!empty($asuransi)) : ?><td nowrap>Kelas Tanggungan</td>
                                <td>:</td>
                                <td><?php echo $asuransi->kelastanggunganasuransi->kelaspelayanan_nama; ?></td><?php endif; ?>
                        </tr>
                        <tr>
                            <td>Penjamin</td>
                            <td>:</td>
                            <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
                            <td>Banyaknya</td>
                            <td>:</td>
                            <td><?php echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima + $tandabukti->bank_nominal, 2); ?></td>
                        </tr>
                        <tr>
                            <td>Terbilang</td>
                            <td>:</td>
                            <td><?php echo $subtotalkotor == 0 ? "NOL RUPIAH" : strtoupper(MyFormatter::formatNumberTerbilang($grand_totals)) . " RUPIAH"; ?></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
                        </tr>
                        <tr>
                            <td nowrap>No. Rekam Medik</td>
                            <td>:</td>
                            <td width="40%"><?php echo $pasien->no_rekam_medik; ?></td>
                            <td nowrap>Tgl. Pendaftaran</td>
                            <td>:</td>
                            <td nowrap><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>:</td>
                            <td nowrap><?php echo $pasien->namadepan . $pasien->nama_pasien; ?></td>
                            <td>No. Pendaftaran</td>
                            <td>:</td>
                            <td nowrap><?php echo $modPendaftaran->no_pendaftaran; ?></td>
                        </tr>
                        <tr>
                            <!--<td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php //echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); 
                                                                                ?></td>-->
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td nowrap><?php echo date('d / F /Y', strtotime($pasien->tanggal_lahir)); ?></td>
                            <td>Ruangan</td>
                            <td>:</td>
                            <td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->ruangan->ruangan_nama : $admisi->kelaspelayanan->kelaspelayanan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td nowrap><?php echo $pasien->alamat_pasien; ?></td>
                            <?php if (!empty($modPendaftaran->pasienadmisi_id)) :
                                $kamarruangan = KamarruanganM::model()->findByPk($masukkamar->kamarruangan_id);
                            ?>
                            <?php endif; ?>
                            <td>Tanggal Masuk Kamar</td>
                            <td>:</td>
                            <td nowrap><?php echo (isset($admisi) ? $admisi->tgladmisi : ""); ?></td>
                        </tr>
                        <tr hidden>
  
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
                            //        $res = (($val_pulang - $val_adms)/ (3600 * 24)) + 1;
                            $res = CustomFunction::hitungHariRawat(MyFormatter::formatDateTimeForDb($vpulang), MyFormatter::formatDateTimeForDb($admisiTgl));
                            $str = $admisiTgl . " - " . $tgl_pulang;
                            if ($admisi->penjamin_id == Params::PENJAMIN_ID_UMUM) :
                            ?>
                                <tr>
                                    <td>Dokter</td>
                                    <td>:</td>
                                    <td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
                                    <td>Lama Rawat</td>
                                    <td>:</td>
                                    <td nowrap><?php echo $res . " Hari (" . $str . ")"; ?></td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td>Dokter</td>
                                    <td>:</td>
                                    <td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
                                    <td>Tgl. Masuk</td>
                                    <td>:</td>
                                    <td nowrap><?php echo $tgl_daftar; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                    <td>Tgl. Keluar</td>
                                    <td>:</td>
                                    <td nowrap><?php echo $tgl_pulang; ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                    </table>
                    <br>
                    <table width="100%" class="tab_detail">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Uraian</th>
                                <th>Dokter</th>
                                <th>Tgl. Transaksi</th>
                                <th>Jml</th>
                                <th >Harga</th>
                                <th >Keringanan</th>
                                <th class="">Tanggungan Asuransi</th>
                                <!--th class="hddn">Tanggungan Pemerintah</th-->
                                <th class="">Tanggungan Rumah Sakit</th>
                                <!--th class="hddn">Iur Biaya</th-->
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($grp as $item) : ?>
                                <tr>
                                    <td colspan="10"><b><?php echo $item['nama']; ?></b></td>
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
                                            // if ($item2['visite'] || $item2['konsul']) {
                                            echo $item2['dokter'];
                                            // }
                                            ?></td>
                                        <td><?php echo $item2['tgl']; ?></td>
                                        <td style="text-align: center; padding-right:20px;"><?php echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['jml']); ?></td>
                                        <td style="text-align: right;"><?php echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['harga']); ?></td>
                                        <td style="text-align: right;"><?php echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['diskon']); ?></td>
                                        <td style="text-align: right;" class=""><?php echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['suba']); ?></td>
                                        <!--td style="text-align: right;" class="hddn"><?php // echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['subp']); ?></td-->
                                        <td style="text-align: center;" class=""><?php echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['subr']); ?></td>
                                        <!--td style="text-align: right;" class="hddn"><?php // echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['subtotal']); ?></td-->
                                        <td style="text-align: right;"><?php echo $item2['is_paket'] == 1 ? "" : MyFormatter::formatNumberForPrint($item2['subtotalkotor']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php
                                if (!empty($item['total'])) : ?>
                                    <tr>
                                        <td colspan="9"><b>Total</b></td>
                                        <td style="text-align: right; font-weight: bold;"><?php echo empty($item['total']) ? "" : MyFormatter::formatNumberForPrint($item['total']); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="10">&nbsp;</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr style="border-top:1px solid #333;" class="footee">
                                <td colspan="6">Total Tagihan</td>
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($diskon); ?></td>
                                <td style="text-align: right;" class=""><?php echo MyFormatter::formatNumberForPrint($suba); ?></td>
                                <!--td style="text-align: right;" class="hddn"><?php // echo MyFormatter::formatNumberForPrint($subp); ?></td-->
                                <td style="text-align: center;" class=""><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
                                <!--td style="text-align: right;" class="hddn"><?php // echo MyFormatter::formatNumberForPrint($subtotal); ?></td-->
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor); ?></td>
                            </tr>
                            <?php if ($tandabukti->biayaadministrasi != 0) : ?>
                                <tr class="closing footee">
                                    <td colspan="9">Administrasi</td>
                                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi); ?></td>
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
                                <?php if ($modPembayaran->totaldiscount != 0) : ?>
                                    <tr class="footee">
                                        <td colspan="9">Potongan</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
                                    <tr class="grand_total footee">
                                        <td colspan="9">TOTAL</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php
                                $suba = 0;
                                $modPembayaran->totalsubsidiasuransi = 0;
   
                                
                                $suba += $modSubsidi->subsidiasuransi;
                                $modPembayaran->totalsubsidiasuransi += $modSubsidi->subsidiasuransi;
                                $kelas = KelaspelayananM::model()->findByPk($modSubsidi->kelaspelayanan_id);
                                ?>
                                <tr class="closing footee">
                                    <td colspan="9">INA <?php echo $kelas->kelaspelayanan_nama; ?></td>
                                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modSubsidi->subsidiasuransi); ?></td>
                                </tr>
                                <?php //}
                                // var_dump($bkelas, $kelas_master); die;
                                ?>
                                <?php if ($modPembayaran->total_inacbg != 0) : ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Total INACBG</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg); ?></td>
                                    </tr>
                                <?php
                                    $dibayar = $modPembayaran->total_inacbg;
  
                                endif; ?>
                                <?php // if ($suba < ($subtotalkotor + $tandabukti->biayaadministrasi)) {
                                $ekses = $modSubsidi->subsidiasuransi - $modPembayaran->total_inacbg;
      
                                if ($ekses > 0) : ?>
                                    <?php if ((($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_ASURANSI)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_INHEALTH))) : ?>
                                    <?php else : ?>
                                        <?php if ($tandabukti->jmlpembulatan != 0) : ?>
                                            <tr class="closing footee">
                                                <td colspan="9">Pembulatan</td>
                                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
                                            </tr>
                                    <?php endif;
                                    endif; ?>
                                    <?php
                                    $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                                        'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id
                                    ));
                                    $jml_uangmuka = 0;
                                    if (!empty($bayaruangmuka)) :
                                        $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;
                                        $ekses -= $jml_uangmuka;
                                        $ekses += $tandabukti->jmlpembulatan;
                                    ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Total Uang Muka</td>
                                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka); ?></td>
                                        </tr>
                                        <tr class="closing footee">
                                            <td colspan="9">Pemakaian Uang Muka</td>
                                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka); ?></td>
                                        </tr>
                                        <tr class="closing footee">
                                            <td colspan="9">Sisa Uang Muka</td>
                                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php if ((($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_ASURANSI)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_INHEALTH))) : ?>
                                    <?php else : ?>
                                        <?php if ($tandabukti->bank_nominal > 0) : ?>
                                            <tr class="closing footee">
                                                <td colspan="9">Pembayaran Non-Tunai</td>
                                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($ekses - $tandabukti->bank_nominal > 0) : ?>
                                            <tr class="closing footee">
                                                <td colspan="9">Pembayaran Tunai</td>
                                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($ekses - $tandabukti->bank_nominal > 0) : ?>
       
                                    <?php endif;
                                    endif; ?>
                                <?php endif; ?>
                            <?php
                                //    }
                            } else {
                            ?>
                                <?php if ($modPembayaran->totaldiscount != 0) : ?>
                                    <tr class="footee">
                                        <td colspan="9">Potongan</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
                                    <tr class="grand_total footee">
                                        <td colspan="9">TOTAL</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($modPembayaran->total_inacbg != 0) : ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Total INACBG</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr class="closing footee">
                                    <td colspan="9">Dibayar Oleh Pasien</td>
                                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaliurbiaya); ?></td>
                                </tr>
                                <?php if ($modPembayaran->totalsubsidiasuransi != 0) : ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Dijamin Asuransi</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsubsidiasuransi); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($subp > 0) : ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Dijamin Pemerintah</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($subr > 0) : ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Dijamin RS</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ((($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_ASURANSI)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_INHEALTH))) : ?>
                                <?php else : ?>
                                    <?php if ($tandabukti->jmlpembulatan != 0) : ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Pembulatan</td>
                                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
                                        </tr>
                                <?php endif;
                                endif; ?>
                                <?php
                                $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                                    'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id
                                ));
                                $jml_uangmuka = 0;
                                if (!empty($bayaruangmuka)) :
                                    $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;
                                ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Total Uang Muka</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka); ?></td>
                                    </tr>
                                    <tr class="closing footee">
                                        <td colspan="9">Pemakaian Uang Muka</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka); ?></td>
                                    </tr>
                                    <tr class="closing footee">
                                        <td colspan="9">Sisa Uang Muka</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php
                                $great_total = ($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr) - $jml_uangmuka) + $tandabukti->jmlpembulatan;
                                if (($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr)) > 0 && (($modPembayaran->penjamin_id != Params::PENJAMIN_ID_UMUM && !empty($admisi)) || (!empty($bayaruangmuka) && $bayaruangmuka->pemakaianuangmuka > 0))) : ?>
                                    <tr class="closing footee" hidden>
                                        <td colspan="9">Dibayar Oleh Pasien</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($great_total); ?></td>
                                    </tr>
                                <?php
                                endif; ?>
                                <?php if ((($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_ASURANSI)) || (($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_INHEALTH))) : ?>
                                <?php else : ?>
                                    <?php if ($tandabukti->uangditerima > 0) : ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Pembayaran Tunai</td>
                                            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($tandabukti->bank_nominal > 0) : ?>
                                        <tr class="closing footee">
                                            <td colspan="9">Pembayaran Non-Tunai</td>
                                            <td style="text-align: right;">(<?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal); ?>)</td>
                                        </tr>
                                <?php endif;
                                endif; ?>
                                <?php if ($modPembayaran->selisihuntungrugibpjs > 0) : ?>
                                    <tr class="closing footee">
                                        <td colspan="9">Total Selisih Tanggungan BPJS</td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->selisihuntungrugibpjs); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($great_total - $tandabukti->bank_nominal + $tandabukti->jmlpembulatan > 0) : ?>
 
                                <?php endif; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br><br>

 
                    <?php
                    if (isset($_GET['frame'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print();"));
                        echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printExcel();"));
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
                                //                                if (!empty(Params::getPegawaiAksesRincianExcel(Yii::app()->user->getState('pegawai_id')))) {
                                ?>
                                window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar2&caraPrint=EXCEL", array("pembayaranpelayanan_id" => $_GET['pembayaranpelayanan_id'])) ?>", "", 'location=_new, width=1024px');
                                <?php
                                //                                } else {
                                ?>
                                //                                    myAlert("Anda tidak berhak untuk mengakses fungsi ini", "Perhatian!");
                                <?php
                                //                                }
                                ?>
                            }
                        </script>
                    <?php
                    } else {
                    ?>
                        <table width='100%'>
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
                            <tr>
                                <td colspan="3"><br/><br/><br/><br/></td>
                            </tr>
                            <tr height='100'>
                                <td align='center'>__________________</td>
                                <td align='center'>__________________</td>
                                <td align='center'><?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
                            </tr>
                        </table>
<?php
                    }

                    // die;
?>