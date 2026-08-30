<style>
    th,
    td,
    div {
        font-family: Arial;
        font-size: 10pt;
    }

    .tandatangan {
        vertical-align: bottom;
        text-align: center;
    }

    body {
        width: 100%;
        /* height: 11cm; */
    }

    .identitas {
        line-height: 12px;
    }

    .rincian thead th {
        /*, .rincian td */
        /*border: 1px solid black;*/
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
    }

    .rincian tfoot tr td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .rincian tfoot td {
        font-weight: bold;
    }

    TABLE,
    TBODY,
    TFOOT,
    TR,
    TH,
    TD {
        font-family: "Arial";
        font-size: 10px;
        color: #333;
    }
</style>
<?php
$format = new MyFormatter;
?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header"><?php
                                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                    ?></div>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <?php
                    $pasien = $modPendaftaran->pasien;
                    $admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
                    $asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                    $masukkamar = MasukkamarT::model()->findByAttributes(array(
                        'pasienadmisi_id' => $modPendaftaran->pasienadmisi_id,
                    ), array(
                        'order' => 'masukkamar_id desc',
                    ));
                    $verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
                        'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
                    ), array(
                        'order' => 'verifikasitagihan_id desc',
                    ));
                    $str_lama = "";
                    if (!empty($admisi)) {
                        $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
                        $admisiTgl = date('Y-m-d', strtotime($admisi->tgladmisi));
                        $pulang = empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;
                        $pulang = empty($pulang) ? date('Y-m-d') : $pulang;
                        $vpulang = date('Y-m-d', strtotime($pulang));
                        $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
                        $tgl_amds = MyFormatter::formatDateTimeForUser($admisiTgl);
                        $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);
                        $val_daftar = strtotime($daftar);
                        $val_adms = strtotime($admisiTgl);
                        $val_pulang = strtotime($vpulang);
                        //$res_lama = (($val_pulang - $val_adms)/ (3600 * 24)) + 1;
                        $res_lama = CustomFunction::hitungHariRawat(MyFormatter::formatDateTimeForDb($vpulang), MyFormatter::formatDateTimeForDb($admisiTgl));
                        $str_lama = $tgl_amds . " - " . $tgl_pulang;
                    }
                    // var_dump($masukkamar->attributes); die;
                    // var_dump($masukkamar->attributes, $modPendaftaran->attributes, $admisi->attributes); die;
                    ?>
                    <div class="judulcontent" style="text-align: center; font-weight: bold;">INVOICE</div>
                    <div style="text-align: center;font-weight: bold;"> <?php echo $nopembayaran == NULL ? '-':$nopembayaran ; ?></div>
                    <table class="identitas" width="100%">
                        <tr>
                            <td>Atas Nama</td>
                            <td>: <?php echo $pasien->nama_pasien; ?></td>
                            <td>No MR</td>
                            <td>: <?php echo $pasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: <?php echo $pasien->alamat_pasien; ?></td>
                            <td>No Registrasi</td>
                            <td>: <?php echo $modPendaftaran->no_pendaftaran; ?> </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Tanggal</td>
                            <td>: <?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
                        </tr>
                        <tr>
                            <td>Penanggung</td>
                            <td>:<?php echo $modPenanggungjawab == NULL ? '-': $modPenanggungjawab->nama_pj; ?></td>
                            <td>No Polis</td>
                            <td>: <?php echo $noasuransi == null ? '-': $noasuransi; ?></td>
                        </tr>
                        <tr>
                            <td>Penjamin</td>
                            <td>: <?php echo $penjamin_nama == null ? '-': $penjamin_nama; ?></td>
                            <td>Asal Perusahaan</td>
                            <td>: <?php echo $nama_perusahaan == null ? '-': $nama_perusahaan; ?></td>
                        </tr>
                        
                    </table>
                    <table class="identitas" width="100%" hidden>
                        <tr>
                            <td>Jenis Penjamin</td>
                            <td>:</td>
                            <td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
                            <td nowrap>Kelas Pelayanan</td>
                            <td>:</td>
                            <td><?php echo !empty($modPendaftaran->pasienadmisi_id) ? $admisi->kelaspelayanan->kelaspelayanan_nama : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Penjamin</td>
                            <td>:</td>
                            <td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
                            <?php if (!empty($asuransi)) : ?><td nowrap>Kelas Tanggungan</td>
                                <td>:</td>
                                <td><?php echo $asuransi->kelastanggunganasuransi->kelaspelayanan_nama; ?></td><?php endif; ?>
                        </tr>
                        <tr>
                            <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
                        </tr>
                        <tr>
                            <td nowrap>No. Rekam Medik</td>
                            <td>:</td>
                            <td width="100%"><?php echo $pasien->no_rekam_medik; ?></td>
                            <td>Tgl. Pendaftaran</td>
                            <td>:</td>
                            <td nowrap></td>
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
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td nowrap><?php echo date('d / F /Y', strtotime($pasien->tanggal_lahir)); ?></td>
                            <td>Ruangan</td>
                            <td>:</td>
                            <td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->ruangan->ruangan_nama : $admisi->ruangan->ruangan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td nowrap><?php echo $pasien->alamat_pasien; ?></td>
                            <?php if (!empty($modPendaftaran->pasienadmisi_id)) : ?>
                                <td nowrap>Kamar / No. Bed</td>
                                <td>:</td>
                                <td nowrap><?php echo (empty($masukkamar) || empty($masukkamar->kamarruangan_id)) ? "-" : ($masukkamar->kamarruangan->kamarruangan_nokamar . " / " . $masukkamar->kamarruangan->kamarruangan_nobed); ?></td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td>Dokter</td>
                            <td>:</td>
                            <td nowrap><?php echo empty($modPendaftaran->pegawai_id) ? "-" : $modPendaftaran->pegawai->namaLengkap; ?></td>
                            <?php if (!empty($modPendaftaran->pasienadmisi_id)) : ?>
                                <td>Dokter PJP</td>
                                <td>:</td>
                                <td nowrap><?php echo empty($admisi->pegawai_id) ? "-" : $admisi->pegawai->namaLengkap; ?></td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>Tanggal Masuk Kamar</td>
                            <td>:</td>
                            <td nowrap><?php echo (isset($admisi) ? MyFormatter::formatDateTimeForUser($admisi->tgladmisi) : ""); ?></td>
                        </tr>
                        <tr>
                            <?php if ($str_lama != "") : ?>
                                <td colspan="3"></td>
                                <td>Lama Rawat</td>
                                <td>:</td>
                                <td nowrap><?php echo $res_lama . " Hari (" . $str_lama . ")"; ?></td>
                            <?php endif; ?>
                        </tr>
                    </table><br>
                    <?php
                    $grp = array();
                    $suba = 0;
                    $subp = 0;
                    $subr = 0;
                    $subtotal = 0;
                    $subtotalKotor = 0;
                    $admin = 0;
                    $modTanggungan = null;
                    if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
                        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modPendaftaran->kelaspelayanan_id, 'penjamin_id' => $modPendaftaran->penjamin_id));
                    } else if (isset($modPendaftaran->asuransipasien_id)) {
                        $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
                        if (isset($modAsuransiPasien->kelastanggunganasuransi_id) && isset($penjamin_id)) {
                            $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id' => $modAsuransiPasien->kelastanggunganasuransi_id, 'penjamin_id' => $penjamin_id));
                        }
                    }
                    $subsidiasuransitind = 0;
                    $subsidipemerintahtind = 0;
                    $subsidirstind = 0;
                    if (!empty($modTanggungan->tanggunganpenjamin_id)) {
                        $subsidiasuransitind = $modTanggungan->subsidiasuransitind;
                        $subsidipemerintahtind = $modTanggungan->subsidipemerintahtind;
                        $subsidirstind = $modTanggungan->subsidirumahsakittind;
                    } else {
                        if (count((array)$modRincians) > 0) {
                            $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
                            $cb = CarabayarM::model()->findByPk($penjamin->carabayar_id);
                            if ($cb->issubsidiasuransi) $subsidiasuransitind = 100;
                            if ($cb->issubsidipemerintah) $subsidipemerintahtind = 100;
                            if ($cb->issubsidirs) $subsidirstind = 100;
                        }
                    }
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
                        // var_dump($item->attributes);
                        $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
                        $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        if (empty($grp[$item->ruangan_id])) {
                            $grp[$item->ruangan_id] = array(
                                'nama' => $item->ruangan_nama,
                                'content' => array(),
                            );
                        }
                        //$item->tarif_satuan = $item->cyto_tindakan ? $item->tarifcyto_tindakan : $item->tarif_satuan;
                        $item->tarif_satuan = round($item->tarif_hargajual / $item->qty_tindakan, 2);
                        $item->tarif_hargajual = $item->tarif_satuan * $item->qty_tindakan;
                        if (empty($item->tindakansudahbayar_id)) {
                            $item->subsidiasuransi_tindakan = $item->tarif_hargajual * $subsidiasuransitind / 100;
                            $item->subsidipemerintah_tindakan = $item->tarif_hargajual * $subsidipemerintahtind / 100;
                            $item->subsisidirumahsakit_tindakan = $item->tarif_hargajual * $subsidirstind / 100;
                        } else continue;
                        if ($item->qty_tindakan == 0) {
                            $item->subsidiasuransi_tindakan = 0;
                            $item->subsidipemerintah_tindakan = 0;
                            $item->subsisidirumahsakit_tindakan = 0;
                        }
                        $suba += $item->subsidiasuransi_tindakan;
                        $subp += $item->subsidipemerintah_tindakan;
                        $subr += $item->subsisidirumahsakit_tindakan;
                        if ($item->is_alkes) {
                            // $item->tarif_satuan = $item->tarif_hargajual;
                        }
                        // $item->tarif_satuan = round($item->tarif_satuan);
                        $subtotal += $item->tarif_hargajual - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
                        $item->tgl_tindakan = MyFormatter::formatDateTimeForDb($item->tgl_tindakan);
                        $detail_ambulans = null;
                        if ($item->komponenunit_id == Params::KOMPONENUNIT_ID_AMBULANS && !$item->is_alkes) {
                            $pemakaian = PemakaianambulansT::model()->findByAttributes(array('tindakanpelayanan_id' => $item->tindakanpelayanan_id));
                            if (!empty($pemakaian)) {
                                $item->daftartindakan_nama .= " - " . $pemakaian->alamattujuan;
                                $detail_ambulans = empty($pemakaian->jasasarana_ambulans) ? array() : array(
                                    array('nama' => "Jasa Sarana", 'biaya' => $pemakaian->jasasarana_ambulans),
                                    array('nama' => "BHP", 'biaya' => $pemakaian->bhp),
                                    array('nama' => "Jasa Pengemudi", 'biaya' => $pemakaian->jasapengemudi),
                                    array('nama' => "Jasa Pendamping", 'biaya' => $pemakaian->jasapendamping),
                                    array('nama' => "Jasa Dokter", 'biaya' => $pemakaian->jasadokter),
                                    array('nama' => "Biaya Tol", 'biaya' => $pemakaian->biayatol),
                                );
                            } else {
                                $detail_ambulans = array();
                            }
                        }
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
                        //gruping daftar item
                        $tarifsatuanHarga = ($item->tarif_satuan);
                        $tarifSubtota = (($tarifsatuanHarga * $item->qty_tindakan) - $item->subsidiasuransi_tindakan - $item->subsisidirumahsakit_tindakan);
                        // if (empty($grp[$item->ruangan_id]['content'][$idx_line])) {
                        //     $grp[$item->ruangan_id]['content'][$idx_line] = array(
                        //         'visite' => $item->daftartindakan_visite,
                        //         'konsul' => $item->daftartindakan_konsul,
                        //         'uraian' => $item->daftartindakan_nama,
                        //         'dokter' => $dokter,
                        //         'tgl' =>  date('d/m/Y H:i:s', strtotime($item->tgl_tindakan)), //MyFormatter::formatDateTimeForUser($item->tgl_tindakan),
                        //         'jml' => $item->qty_tindakan,
                        //         'harga' => $tarifsatuanHarga,
                        //         'suba' => ($item->subsidiasuransi_tindakan),
                        //         'subp' => ($item->subsidipemerintah_tindakan),
                        //         'subr' => ($item->subsisidirumahsakit_tindakan),
                        //         'subtotal' => ($item->tarif_hargajual - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
                        //         'subtotalKotor' => $tarifSubtota,
                        //         'detail_ambulans' => $detail_ambulans,
                        //     );
                        // } else {
                        //     $grp[$item->ruangan_id]['content'][$idx_line]['jml'] += $item->qty_tindakan;
                        //     $grp[$item->ruangan_id]['content'][$idx_line]['suba'] += ($item->subsidiasuransi_tindakan);
                        //     $grp[$item->ruangan_id]['content'][$idx_line]['subp'] += ($item->subsidipemerintah_tindakan);
                        //     $grp[$item->ruangan_id]['content'][$idx_line]['subr'] += ($item->subsisidirumahsakit_tindakan);
                        //     $grp[$item->ruangan_id]['content'][$idx_line]['subtotal'] += ($item->tarif_hargajual - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan));
                        //     $grp[$item->ruangan_id]['content'][$idx_line]['subtotalKotor'] += $tarifSubtota;
                        //     if (count((array)$detail_ambulans) > 0) {
                        //         foreach ($detail_ambulans as $det_ambulans) {
                        //             $ada_detail = false;
                        //             foreach ($grp[$item->ruangan_id]['content'][$idx_line]['detail_ambulans'] as $det_ambulans2) {
                        //                 if ($det_ambulans['nama'] == $det_ambulans2['nama']) {
                        //                     $ada_detail = true;
                        //                     $det_ambulans2['biaya'] += $det_ambulans['biaya'];
                        //                 }
                        //             }
                        //             if (!$ada_detail) {
                        //                 $grp[$item->ruangan_id]['content'][$idx_line]['detail_ambulans'][] = $det_ambulans;
                        //             }
                        //         }
                        //     }
                        // }
                        //$subtotalKotor += $tarifSubtota;
                        
    // array_push($grp[$item->ruangan_id]['content'], array(
    //     'visite'=>$item->daftartindakan_visite,
    //     'konsul'=>$item->daftartindakan_konsul,
    //     'uraian'=>$item->daftartindakan_nama,
    //     'dokter'=>$dokter,
    //     'tgl'=>  date('d/m/Y', strtotime($item->tgl_tindakan)),//MyFormatter::formatDateTimeForUser($item->tgl_tindakan),
    //     'jml'=> $item->qty_tindakan,
    //     'harga'=> MyFormatter::formatNumberForPrint($item->tarif_satuan),
    //     'suba'=>MyFormatter::formatNumberForPrint($item->subsidiasuransi_tindakan),
    //     'subp'=>MyFormatter::formatNumberForPrint($item->subsidipemerintah_tindakan),
    //     'subr'=>MyFormatter::formatNumberForPrint($item->subsisidirumahsakit_tindakan),
    //     'subtotal'=>MyFormatter::formatNumberForPrint(($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
    //     'subtotalKotor'=>MyFormatter::formatNumberForPrint($item->qty_tindakan * $item->tarif_satuan),
    //     'detail_ambulans'=>$detail_ambulans,
    // ));
    array_push($grp[$item->ruangan_id]['content'], array(
        'visite'=>$item->daftartindakan_visite,
        'konsul'=>$item->daftartindakan_konsul,
        'uraian'=>$item->daftartindakan_nama,
        'dokter'=>$dokter,
        'tgl'=>  date('d/m/Y', strtotime($item->tgl_tindakan)),//MyFormatter::formatDateTimeForUser($item->tgl_tindakan),
        'jml'=> $item->qty_tindakan,
        'harga'=>$item->tarif_satuan,
        'suba'=>$item->subsidiasuransi_tindakan,
        'subp'=>$item->subsidipemerintah_tindakan,
        'subr'=>$item->subsisidirumahsakit_tindakan,
        'subtotal'=>($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan),
        'subtotalKotor'=>$item->qty_tindakan * $item->tarif_satuan,
        //'harga'=> MyFormatter::formatNumberForPrint($item->tarif_satuan),
        //'suba'=>MyFormatter::formatNumberForPrint($item->subsidiasuransi_tindakan),
        //'subp'=>MyFormatter::formatNumberForPrint($item->subsidipemerintah_tindakan),
        //'subr'=>MyFormatter::formatNumberForPrint($item->subsisidirumahsakit_tindakan),
        // 'subtotal'=>MyFormatter::formatNumberForPrint(($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
        // 'subtotalKotor'=>MyFormatter::formatNumberForPrint($item->qty_tindakan * $item->tarif_satuan),
        'detail_ambulans'=>$detail_ambulans,
    ));
    $subtotalKotor += $tarifSubtota;
    $total_a = 0;
    
                    }
                    if (!empty($admisi)) {
                        if (!empty($verifikasi) && $verifikasi->biaya_administrasi != 0) {
                            $admin = $verifikasi->biaya_administrasi;
                        } else {
                            $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
                            $admin = $subtotalKotor * $penjamin->biaya_administrasi / 100;
                        }
                    }
                    $grand_totals = $subtotalKotor + $admin;
                    ?>
                    <table width="100%" class="rincian">
                        <thead>
                            <th style='text-align: center;' hidden>No.</th>
                            <th style='text-align: center;'>Tanggal</th>
                            <th style='text-align: center;'>Deskripsi</th>
                            <th style='text-align: center;'>Qty</th>
                            <th style='text-align: center;'>Biaya(Rp)</th>
                            <th style='text-align: center;'>Keringanan(Rp)</th>
                            <th style='text-align: center;' hidden>Dokter</th>
                            <th style='text-align: center;'>Jumlah</th>
                            
                            <th style='text-align: center;'hidden>Tanggungan Asuransi</th>
                            <th style='text-align: center;' hidden>Jaminan Pemerintah</th>
                            <th style='text-align: center;'hidden>Tanggungan Rumah SakitS</th>
                            <th style='text-align: center;' hidden>Iur Biaya</th>
                            <th style='text-align: center;'hidden>Jumlah Yang Harus Dibayar</th>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($grp as $item) :
                                $subtotals = 0;
                                ?>
                                <tr>
                                    <td colspan="10"><b><?php echo $item['nama']; ?></b></td>
                                </tr>
                                <?php
                                $cnt = 0;
                                foreach ($item['content'] as $item2) :
                                    $cnt++;
                                    // var_dump($item2);die;
                                ?>
                                    <tr>
                                        <td hidden>*. </td>
                                        <td><?php echo $item2['tgl']; ?></td>
                                        <td><?php echo $item2['uraian'].'('.$item2['dokter'].')'; ?></td>
                                        <td hidden><?php
                                            //if ($item2['visite'] || $item2['konsul']){
                                            echo $item2['dokter'];
                                            //}
                                            ?></td>
                                        
                                        <td style="text-align: right;"><?php echo str_replace(".", ",", $item2['jml']); ?></td>
                                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['harga']); ?></td>
                                        <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($item2['suba'], 2, true); ?></td>
                                        <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subp'], 2); ?></td>
                                        <td style="text-align: right;" ><?php echo MyFormatter::formatNumberForPrint($item2['subr'], 2); ?></td>
                                        <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subtotal'], 2); ?></td>
                                        <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($item2['subtotalKotor']); ?></td>
                                    </tr>
                                    <?php if (!empty($item2['detail_ambulans'])) :
                                        foreach ($item2['detail_ambulans'] as $list_biaya) :
                                            if ($list_biaya['biaya'] == 0) {
                                                continue;
                                            }
                                    ?>
                                            <tr>
                                                <td>&emsp;&emsp;<?php echo $list_biaya['nama']; ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($list_biaya['biaya'], 2); ?></td>
                                            </tr>
                                    <?php
                                        endforeach;
                                    endif; ?>
                                   <?php 
                                   $subtotals = $subtotals + $item2['subtotalKotor']; 
                                   ?>
                                   
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="4" style="text-align: right;">subtotal:</td>
                                    <td></td>
                                    <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($subtotals); ?></td>
                                </tr>
                            <?php 
                            //$total_a += $subtotals;
                            endforeach;
                            ?>
                            <tr style="height: 50px;"></tr>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="4" style = "border-bottom: 1px solid"></td>
                            </tr>
                            <tr>
                                <td>Terbilang</td>
                                <td >: # <?php //echo MyFormatter::kataTerbilang($total_a);?> #</td>
                                <td colspan="2"style="text-align: right;"> Total(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;"><?php //echo MyFormatter::formatNumberForPrint($total_a) ; ?></td>
                            </tr>
                            <tr style="height: 50px;"></tr>
                            <tr>
                                <td></td>
                                <td ></td>
                                <td colspan="2"style="text-align: right;"> Keringanan. Akhir(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;" ><?php echo MyFormatter::formatNumberForPrint($item2['subr'], 2); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="4" style = "border-top: 1px solid"></td>
                            </tr>
                            <tr>
                                <td>Dibayar Tunai: 0 </td>
                                <td >Jaminan : <?php echo $subsidiasuransi_tindakan; ?></td>
                                <td colspan="2"style="text-align: right;"> Grand Total(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;" ><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
                            </tr>

                        </tbody>
                        <tfoot hidden>
                            <tr>
                                <td colspan="5">Total Tagihan</td>
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($suba, 2); ?></td>
                                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($subp, 2); ?></td>
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr, 2); ?></td>
                                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($subtotal, 2); ?></td>
                                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalKotor, 2); ?></td>
                            </tr>
                            <?php if ($admin > 0) :
                            ?>
                                <tr class="closing footee">
                                    <td colspan="7">Administrasi</td>
                                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($admin, 2); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php
                            $round_total = round($grand_totals / 100) * 100;
                            if ($admin > 0 || $round_total <> $grand_totals) :
                            ?>
                                <tr class="closing footee">
                                    <td colspan="7">Total Tanggungan Pasien</td>
                                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($round_total, 2); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                    <table width = "40%">
                        <tr style="height: 100px; border:1px solid;">
                            <td>
                                Jenis Penjamin : <?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
                            </td>
                            <td>0</td>

                        </tr>
                    </table>
                    <br><br><br>
                    <table width='100%'>
                        <tr hidden>
                            <td></td>
                            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
                        </tr>
                        <tr>
                            <td align='center'>Penerima</td>
                            <td align='center'>RS. Sari Asih Ciputat,</td>
                        </tr>
                        <tr height='150px'>
                            <td align='center'>(.........................................)</td>
                            <td align='center'>(.........................................)</td>
                        </tr>
                        <tr>
                            <td><?php echo $format->formatDateTimeId(date('Y-m-d')); ?></td>
                            <td align='right'>Kasir <?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
                        </tr>
                        <tr>
                            <td>
                            <p>- INVOICE INI BERLAKU SEBAGAI KWITANSI</p>
                            </td>
                            
                        </tr>
                    </table>
                    <?php /*
<table style="width: 100%; border: none;">
    <tr align="right">
         <td class="tandatangan">Petugas</td>
         <td width="80%"></td>
         <td class="tandatangan">Pasien</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr align="right">
        <td class="tandatangan"></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr align="right">
         <td class="tandatangan" style="height: 50px;" nowrap>
             <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>
                <b><?php echo empty($pegawai)?"-":$pegawai->nama_pegawai; ?></b>
         </td>
         <td>&nbsp;</td>
         <td class="tandatangan" style="height: 50px;" nowrap>
             <?php echo $pasien->nama_pasien ?>
         </td>
    </tr>
    <tr align="right">
        <td class="tandatangan" style = "border-top: 2px solid #000;" nowrap>
                <b>NIP. <?php echo empty($pegawai)?"-":$pegawai->nomorindukpegawai; ?></b>
         </td>
         <td>&nbsp;</td>
         <td style = "border-top: 2px solid #000;" nowrap>&nbsp;</td>
    </tr>
</table>
 *
 */ ?>
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
<div class="">
</div>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php
if (isset($_GET['frame'])){
    $loginpeg = PegawaiM::model()->findByAttributes(array('pegawai_id'=>Yii::app()->user->getState('pegawai_id'), 'kelompokpegawai_id'=>Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN));
    if(empty($loginpeg) || $this->id != 'pembayaranTagihanKarcis'){
        echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
    }
?>
    <script type='text/javascript'>
        /**
         * print
         */
        function print() {
            window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianBelumBayar", array("instalasi_id" => $_GET['instalasi_id'], "pendaftaran_id" => $_GET['pendaftaran_id'], "pasienadmisi_id" => (isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>", "", 'location=_new, width=1024px');
        }
    </script>
    <?php //echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); 
    ?>
<?php
}
?>