<style>
    body {
        width: 100%;
        padding-right: 10mm;
        color: black;
        /* height: 11cm; */
    }

    .identitas {
        line-height: 12px;
        font-family: "Arial Narrow" !important;
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
        display: none;
    }

    .data tr td {
        text-align: right;
        padding-left: 300px;
        font-size: 17px;
        font-family: "Arial Narrow";
    }

    .font th {
        font-size: 15px;
    }
</style>
<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
$format = new MyFormatter;
// if (!isset($_GET['frame'])){
?>
<table width="100%">
    <thead class="data">
        <tr>
            <td>
                <?php echo $data->nama_rumahsakit; ?>
                <!-- <div align="right" class="header">
                    
                    <?php
                    //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div> -->
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $data->alamatlokasi_rumahsakit; ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo "Telp. 0" . $data->no_telp_profilrs . " (Hunting) Fax. 0" . $data->no_telp_profilrs; ?>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <?php
                    // }
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
                    $grand_totals = 0;




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
                    // echo "<pre>";
                    // print_r($modRincians2);die;

                    foreach ($modRincians2 as $item) {

                        if ($item->qty_tindakan * $item->tarif_satuan == 0) continue;
                        if (!empty($item->pegawai_id)) {
                            $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
                            $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        } else if (isset($modTindakan->perawat_id)) {
                            $dokter = PegawaiM::model()->findByPk($modTindakan->perawat_id);
                            $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        } else if (!empty($modTindakan->dokterpemeriksa1_id)) {
                            $dokter = PegawaiM::model()->findByPk($modTindakan->dokterpemeriksa1_id);
                            $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        } else if (!empty($modTindakan->okupasiterapi_id)) {
                            $dokter = PegawaiM::model()->findByPk($modTindakan->okupasiterapi_id);
                            $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        } else if (!empty($modTindakan->terapiwicara_id)) {
                            $dokter = PegawaiM::model()->findByPk($modTindakan->terapiwicara_id);
                            $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        } else if (!empty($modTindakan->fisioterapi_id)) {
                            $dokter = PegawaiM::model()->findByPk($modTindakan->fisioterapi_id);
                            $dokter = empty($dokter) ? "-" : $dokter->namaLengkap;
                        } else {
                            $dokter = "-";
                        }

                        // echo '<pre>';
                        // var_dump($modTindakan);die;

                        $is_paket = $item->is_paketbmhp && !empty($item->paketbmhp_id);

                        if ($is_paket) {
                            $item->ruangan_id = "PKT_01";
                            $item->ruangan_nama = "PAKET";
                        }

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


                        $item->tarif_satuan = (round($item->tarif_satuan * 100) / 100);
                        $subtotalkotor += (round($item->qty_tindakan * $item->tarif_satuan * 100) / 100) - $item->discount_tindakan;
                        $subtotal += (round($item->qty_tindakan * $item->tarif_satuan * 100) / 100) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);

                        $tanggal = date('d/m/Y', strtotime($item->tgl_tindakan));
                        $daftartindakan_id = $item->daftartindakan_id . "_" . ($item->is_alkes ? "0" : "1");
                        $harga = $item->tarif_satuan;

                        $dt = DaftartindakanM::model()->findByPk($item->daftartindakan_id, array(
                            'select' => 'daftartindakan_akomodasi'
                        ));
                        $datatindakan = DaftartindakanM::model()->findByPk($item->daftartindakan_id);
                        //  
                        $tindakan =TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
                        // var_dump($tindakan);die;
                        if ($is_paket) {
                            $idx_line = "BMHP_" . $item->paketbmhp_id . "_" . date('YmdHi', strtotime($item->tgl_tindakan));
                        } else {
                            if (!$item->is_alkes && !empty($dt) && $dt->daftartindakan_akomodasi) {
                                $idx_line = $daftartindakan_id . "::" . $harga;
                            }else if(!empty($tindakan->tindakanluar_nama)) {
                                $idx_line = $tindakan->tindakanpelayanan_id . "::" . $harga;
                            } else {
                                // $idx_line = $daftartindakan_id."::".$tanggal."::".$harga;
                                $idx_line = $daftartindakan_id . "::" . $harga;
                            }
                        }   
                        $dataTin = !empty($tindakan->tindakanluar_nama) ? $tindakan->tindakanluar_nama : $item->daftartindakan_nama; 
                        // $daftartindakan = !empty($datatindakan->daftartindakan_namalainnya) ? $datatindakan->daftartindakan_namalainnya : $item->daftartindakan_nama ;
                        if (empty($grp[$item->ruangan_id]['content'][$idx_line])) {
                            $grp[$item->ruangan_id]['content'][$idx_line] = array(
                                'visite' => $item->daftartindakan_visite,
                                'konsul' => $item->daftartindakan_konsul,
                                'uraian_lainnya' => $item->daftartindakan_nama,
                                'uraian' => $dataTin,
                                'dokter' => $dokter,
                                'tgl' =>  date("d/m/Y H:i", strtotime($item->tgl_tindakan)),
                                'jml' => $item->qty_tindakan,
                                'harga' => ($item->tarif_satuan),
                                'diskon' => ($item->discount_tindakan),
                                'suba' => ($item->subsidiasuransi_tindakan),
                                'subp' => ($item->subsidipemerintah_tindakan),
                                'subr' => ($item->subsisidirumahsakit_tindakan),
                                'subtotal' => (($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
                                'subtotalkotor' => (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan),
                                'pendaftaran_id'=> $item->pendaftaran_id,
                                'daftartindakan_id' =>$item->daftartindakan_id,
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
        if (count((array)$detail_ambulans) > 0) {
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
                        if ($is_paket) {
                            $grp[$item->ruangan_id]['content'][$idx_line]['uraian'] = $item->paketbmhp_nama;
                            $grp[$item->ruangan_id]['content'][$idx_line]['jml'] = 1;
                            $grp[$item->ruangan_id]['content'][$idx_line]['harga'] = $grp[$item->ruangan_id]['content'][$idx_line]['subtotalkotor'];
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


                        //$grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount) + $modPembayaran->jasapelayanan_farmasi  + $modPembayaran->total_embalase);
                    }
                    // var_dump($grp);die;
                    $subr = $modPembayaran->totalsubsidirs;
                    $masukKamarPasien = null;
                    if (!empty($admisi->pasienadmisi_id)) {
                        $masukKamarPasien = MasukkamarT::model()->findByAttributes(array(
                            'pasienadmisi_id' => $admisi->pasienadmisi_id,
                            // 'pindahkamar_id'=>null
                        ), array(
                            'order' => 'create_time asc',
                        ));
                    }

                    $uangmuka = !empty($modUangMuka->uangmukadipakai) ? $modUangMuka->uangmukadipakai : 0;

                    ?>

                    <div class="judulcontent" style="text-align: center;">INVOICE</div>
                    <p style="text-align: center;"><?php $str = $modPembayaran->nopembayaran;
                                                    $c = explode('-', $str);
                                                    echo $c[0] . "-" . $c[1] . "SA" . $c[2]; ?></p>
                    <br />
                    <table class="identitas" width="100%">
                        <tr>
                            <td>Atas Nama</td>
                            <td></td>
                            <td>: <?php echo $pasien->namadepan . $pasien->nama_pasien; ?></td>
                            <td>No. MR</td>
                            <td></td>
                            <td>: <?php echo $pasien->no_rekam_medik; ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td></td>
                            <td>: <?php echo $pasien->alamat_pasien; ?></td>
                            <td>No. Registrasi</td>
                            <td></td>
                            <td>: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Tanggal</td>
                            <td></td>
                            <td>: <?php echo  date('d/m/Y G:i', strtotime($modPendaftaran->tgl_pendaftaran)); ?></td>
                        </tr>
                        <tr>
                            <td>Penanggung</td>
                            <td></td>
                            <td>: <?php if (!empty($modPenanggungjawab)) {
                                        echo $modPenanggungjawab->nama_pj;
                                    } ?></td>
                            <td>No. Polis</td>
                            <td></td>
                            <td>:<?php echo $noasuransi; ?></td>
                        </tr>
                        <tr>
                            <td>Penjamin</td>
                            <td></td>
                            <td>: <?php echo empty($penjamin->penjamin_nama) ? '-' : $penjamin->penjamin_nama; ?></td>
                            <td>Asal Perusahaan</td>
                            <td></td>
                            <td>: <?php echo empty($modAsuransi) ? '-' :  $modAsuransi->namaperusahaan; ?></td>
                        </tr>
                        <!-- <tr>
        <td>Tanggal Pembayaran</td>
        <td></td>
        <td>: <?php //echo empty($modPembayaran->tglpembayaran)? '-':  MyFormatter::formatDateTimeForUser($modPembayaran->tglpembayaran); 
                ?></td>
    </tr> -->

                        <?php if (!empty($admisi)) : ?>

                            <?php


                            $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
                            $admisiTgl = date('Y-m-d', strtotime($admisi->tgladmisi));
                            $masukkamarTgl = (!empty($masukKamarPasien) ? date('Y-m-d', strtotime($masukKamarPasien->tglmasukkamar)) : $admisiTgl);
                            $pulang = $admisi->rencanapulang; //empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;

                            if (empty($pulang) || trim($pulang) == "") {
                                $dataPulang = PasienpulangT::model()->findByPk($admisi->pasienpulang_id);

                                if (!empty($dataPulang)) {
                                    $pulang = $dataPulang->tglpasienpulang;
                                }
                            }


                            $vpulang = date('Y-m-d G:i:s', strtotime($pulang));

                            $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
                            $tgl_amds = MyFormatter::formatDateTimeForUser($admisiTgl);
                            $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);
                            $tgl_mskkamar = MyFormatter::formatDateTimeForUser($masukkamarTgl);

                            $val_daftar = strtotime($daftar);
                            $val_adms = strtotime($admisiTgl);
                            $val_pulang = strtotime($vpulang);
                            $val_mskkamar = strtotime($masukkamarTgl);

                            //        $res = (($val_pulang - $val_adms)/ (3600 * 24)) + 1;
                            $res = CustomFunction::hitungHariRawat(MyFormatter::formatDateTimeForDb($masukkamarTgl), MyFormatter::formatDateTimeForDb($vpulang));

                            $str = $tgl_mskkamar . " - " . $tgl_pulang;

                            if ($admisi->penjamin_id == Params::PENJAMIN_ID_UMUM) :

                            ?>

                                <tr hidden>
                                    <td hidden>Dokter</td>
                                    <td>:</td>
                                    <td nowrap><?php //echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; 
                                                ?></td>
                                    <tdhidden>Lama Rawat
            </td>
            <td>:</td>
            <td nowrap><?php //echo $res." Hari (".$str.")"; 
                        ?></td>
        </tr>
    <?php else : ?>
        <tr hidden>
            <td>Dokter</td>
            <td>:</td>
            <td nowrap><?php //echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; 
                        ?></td>
            <td>Tgl Masuk</td>
            <td>:</td>
            <td nowrap><?php //echo $tgl_daftar; 
                        ?></td>
        </tr>
        <tr hidden>
            <td colspan="3">&nbsp;</td>
            <td>Tgl Keluar</td>
            <td>:</td>
            <td nowrap><?php echo $tgl_pulang; ?></td>
        </tr>
    <?php endif; ?>


<?php endif; ?>
</table>
<table class="identitas" width="100%" hidden>
    <tr>
        <td>No Pembayaran</td>
        <td>:</td>
        <td><?php echo $modPembayaran->nopembayaran; ?></td>
        <td nowrap>Kelas Pelayanan</td>
        <td>:</td>
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
        <td><?php echo ($tandabukti->uangditerima + $tandabukti->bank_nominal) == 0 ? "NOL RUPIAH" : strtoupper(MyFormatter::formatNumberTerbilang(($tandabukti->uangditerima + $tandabukti->bank_nominal))) . " RUPIAH"; ?></td>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td>
        <td>:</td>
        <td width="100%"><?php echo $pasien->no_rekam_medik; ?></td>
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
        <td nowrap><?php echo MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
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
        <td nowrap><?php echo (!empty($masukKamarPasien) ? MyFormatter::formatDateTimeForUser($masukKamarPasien->tglmasukkamar) : ""); ?></td>
    </tr>
    <tr hidden>

        <?php /*if (!empty($modPendaftaran->pasienadmisi_id)): ?>
        <?php /*
        <td>Dokter PJP</td><td>:</td><td nowrap><?php echo $admisi->pegawai->namaLengkap; ?></td>
        <?php endif; ?>
         *
         */ ?>
    </tr>
    <?php if (!empty($admisi)) : ?>

        <?php


        $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
        $admisiTgl = date('Y-m-d', strtotime($admisi->tgladmisi));
        $masukkamarTgl = (!empty($masukKamarPasien) ? date('Y-m-d', strtotime($masukKamarPasien->tglmasukkamar)) : $admisiTgl);
        $pulang = $admisi->rencanapulang; //empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;

        if (empty($pulang) || trim($pulang) == "") {
            $dataPulang = PasienpulangT::model()->findByPk($admisi->pasienpulang_id);

            if (!empty($dataPulang)) {
                $pulang = $dataPulang->tglpasienpulang;
            }
        }


        $vpulang = date('Y-m-d G:i:s', strtotime($pulang));

        $tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
        $tgl_amds = MyFormatter::formatDateTimeForUser($admisiTgl);
        $tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);
        $tgl_mskkamar = MyFormatter::formatDateTimeForUser($masukkamarTgl);

        $val_daftar = strtotime($daftar);
        $val_adms = strtotime($admisiTgl);
        $val_pulang = strtotime($vpulang);
        $val_mskkamar = strtotime($masukkamarTgl);

        //        $res = (($val_pulang - $val_adms)/ (3600 * 24)) + 1;
        $res = CustomFunction::hitungHariRawat(MyFormatter::formatDateTimeForDb($masukkamarTgl), MyFormatter::formatDateTimeForDb($vpulang));

        $str = $tgl_mskkamar . " - " . $tgl_pulang;

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
                <td>Tgl Masuk</td>
                <td>:</td>
                <td nowrap><?php echo $tgl_daftar; ?></td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td>
                <td>Tgl Keluar</td>
                <td>:</td>
                <td nowrap><?php echo $tgl_pulang; ?></td>
            </tr>
        <?php endif; ?>


    <?php endif; ?>
</table>
<br />

<table width="100%" class="tab_detail">
    <thead class="font">
        <th style='border: 1px solid;text-align: center;' hidden>No.</th>
        <th style='border-right: 1px solid;text-align: center;'>Tanggal</th>
        <th style='border-right: 1px solid;text-align: center;'>Deskripsi</th>
        <th style='text-align: center;' hidden>Dokter</th>
        <th style='border-right: 1px solid;text-align: center;'>Qty</th>
        <th style='border-right: 1px solid;text-align: center;'>Harga</th>
        <th style='border-right: 1px solid;text-align: center;'>Keringanan</th>
        <th style='text-align: center;' hidden>Tanggungan Asuransi</th>
        <th style='text-align: center;' hidden>Jaminan Pemerintah</th>
        <th style='text-align: center;' hidden>Tanggungan Rumah Sakit</th>
        <th style='text-align: center;' hidden>Iur Biaya</th>
        <th style='text-align: center;'>Jumlah</th>
    </thead>
    <tbody>
        <?php foreach ($grp as $item) : ?>
            <tr style="height: 10px;"></tr>
            <tr>
                <td colspan="11"><strong><?php echo $item['nama']; ?></strong></td>
            </tr>
            <?php
            $cnt = 0;
            $total = 0;
            foreach ($item['content'] as $item2) :
                $cnt++;
                $total += $item2['subtotalkotor'];
            ?>
                <tr>
                    <td hidden><?php echo "*."; ?></td>
                    <td style="padding-left: 5mm; padding-right: 5mm;"><?php echo $item2['tgl']; ?></td>
                    <td><?php 
                        if (str_contains($item2['uraian_lainnya'], 'Kamar (')) {
                            $modPendaftaran = PendaftaranT::model()->findByPk($item2['pendaftaran_id']);
                            $modAdmisi = MasukkamarT::model()->findAllByAttributes(array("pasienadmisi_id" => $modPendaftaran->pasienadmisi_id));
                            // echo "<pre>";
                            // var_dump($modAdmisi);
                            $tanggal_masuk = $modAdmisi[0]->tglmasukkamar;
                            $tanggal_keluar = $modAdmisi[count($modAdmisi)-1]->tglkeluarkamar;
                            $kamar = KamarruanganM::model()->findByAttributes(array("kamarruangan_id" => $modAdmisi[0]->kamarruangan_id));
                            echo "Kamar ( " . $kamar->kamarruangan_nokamar . " Bed " . $kamar->kamarruangan_nobed ." ".substr($item2['uraian'],7,) . " " . "(" . $tanggal_masuk . " s/d  " . $tanggal_keluar . ")";
                            // $modPendaftaran = PendaftaranT::model()->findByPk($item2['pendaftaran_id']);
                            // $modAdmisi = MasukkamarT::model()->findByAttributes(array("pasienadmisi_id" => $modPendaftaran->pasienadmisi_id));
                            // $kamar = KamarruanganM::model()->findByAttributes(array("kamarruangan_id" => $modAdmisi->kamarruangan_id));
                            // echo "Kamar ( " . $kamar->kamarruangan_nokamar . " Bed " . $kamar->kamarruangan_nobed ." ".substr($item2['uraian'],7,) . " " . "(" . $modAdmisi->tglmasukkamar . " s/d  " . $modAdmisi->tglkeluarkamar . ")";
                        } else if ($item2['daftartindakan_id'] == '5853'){
                            echo $item2['uraian'];
                        } 
                        else {
                            echo $item2['uraian'] . "(" . $item2['dokter'] . ")";
                        }; ?></td>

                    <td style="padding-left: 8mm;" hidden><?php
                                                            // if ($item2['visite'] || $item2['konsul']) {
                                                            echo $item2['dokter'];
                                                            // }
                                                            ?></td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['jml']); ?></td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['harga'], 2); ?></td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['diskon']); ?></td>
                    <td style="text-align: right;" class="" hidden><?php echo MyFormatter::formatNumberForPrint($item2['suba'], 0); ?></td>
                    <td style="text-align: right;" class="hddn" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subp'], 2); ?></td>
                    <td style="text-align: right;" class="" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subr'], 2); ?></td>
                    <td style="text-align: right;" class="hddn" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subtotal'], 2); ?></td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['subtotalkotor'], 0); ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td style="text-align:right; font-weight:bold; font-style:italic" colspan="4">Subtotal</td>
                <td style="text-align:right; font-weight:bold; font-style:italic" colspan="2"><?php echo MyFormatter::formatNumberForPrint($total, 2); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr style="height: 50px;"></tr>
        <?php
        $modJenis = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id' => $tandabukti->tandabuktibayar_id));
        // var_dump($modJenis);die;
        $totalcredit = 0;
        $totaldebit = 0;
        $bankdebit = '';
        $bankcredit = '';
        $total_pembayaran = 0;
        // var_dump($modJenis->bankpenerima_id);die;
        // 
        // var_dump($bank);die;
        if (!empty($modJenis)) {
            foreach ($modJenis as $items) {
                if ($items->jnspembayar_id == 2) {
                    $totaldebit += $items->jumlahpembayaran;
                    $bank = BankM::model()->findByPk($items->bankpenerima_id);
                    $bankdebit = $bank->namabank;
                }
                if ($items->jnspembayar_id == 1) {
                    $totalcredit += $items->jumlahpembayaran;
                    $bank = BankM::model()->findByPk($items->bankpenerima_id);
                    $bankcredit = $bank->namabank;
                }
            }
        }
        $total_pembayaran = (($subtotalkotor - $modPembayaran->totaldiscount) - $modPembayaran->totalpembebasan) + $tandabukti->biayaadministrasi + $tandabukti->jmlpembulatan;
        // var_dump( $modPembayaran->totalpembebasan);die;
        ?>
        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="4" style="border-bottom: 1px solid"></td>
        </tr>

        <tr>
            <td>Terbilang</td>
            <td>: # <?php echo ucwords(MyFormatter::kataTerbilang($total_pembayaran)); ?> #</td>
            <td colspan="2" style="text-align: right;"> Total(Rp)</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor); ?></td>
        </tr>
        <tr style="height: 30px;"></tr>
        <?php //if ($modPembayaran->totaldiscount != 0): 
        ?>
        <!-- <tr>
                                    <td></td>
                                    <td ></td>
                                    <td colspan="2"style="text-align: right;"> Disc. Akhir(Rp)</td>
                                    <td style="text-align: left;">:</td>
                                   <td style="text-align: center;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount,2); 
                                                                    ?></td>
                                </tr> -->
        <?php //endif; 
        ?>
        <?php //if ($modPembayaran->totaldiscount == 0): 
        ?>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right;">Biaya Admin:</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi, 2); ?></td>
        </tr>
        <tr hidden>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right;">Pembebasan:</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalpembebasan, 2); ?></td>
        </tr>
        <tr hidden>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right;">Pembulatan:</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 2); ?></td>
        </tr>
        <?php //endif; 
        ?>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right;"> Keringanan Akhir(Rp)</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount, 2); ?></td>
        </tr>

        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="4" style="border-top: 1px solid"></td>
        </tr>
        <!-- <?php //if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : 
                ?>
                                <tr>
                                    <td></td>
                                    <td > <?php //echo $subsidiasuransi_tindakan; 
                                            ?></td>
                                    <td colspan="2"style="text-align: right;"> Grand Total(Rp)</td>
                                    <td style="text-align: left;">:</td>
                                    <td style="text-align: center;"><?php //echo MyFormatter::formatNumberForPrint($grand_totals); 
                                                                    ?></td>
                                </tr>
                            <?php //endif; 
                            ?> -->
        <?php //if ($modPembayaran->totaldiscount == 0 || $tandabukti->biayaadministrasi == 0) { 
        ?>
        <tr>
            <td></td>
            <td> <?php //echo $subsidiasuransi_tindakan; 
                    ?></td>
            <td colspan="2" style="text-align: right;"> Grand Total(Rp)</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($total_pembayaran); ?></td>
        </tr>
        <?php //endif; 
        ?>

        <tr style="border-top:1px solid #333;" class="footee" hidden>
            <td colspan="6">Total Biaya Pelayanan</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($diskon, 2); ?></td>
            <td style="text-align: right;" class=""><?php echo MyFormatter::formatNumberForPrint($suba, 0); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subp, 2); ?></td>
            <td style="text-align: right;" class=""><?php echo MyFormatter::formatNumberForPrint($subr, 2); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subtotal, 2); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor, 0); ?></td>
        </tr>
        <?php if ($tandabukti->biayaadministrasi != 0) : ?>
            <tr class="closing footee" hidden>
                <td colspan="9">Administrasi</td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi, 2); ?></td>
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



            <?php if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
                <tr class="grand_total footee" hidden>
                    <td colspan="9">Total Tagihan</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals, 2); ?></td>
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
                <td colspan="9">INA <?php echo $kelas->kelaspelayanan_nama; ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modSubsidi->subsidiasuransi, 2); ?></td>
            </tr>
            <?php //}

            // var_dump($bkelas, $kelas_master); die;

            ?>

            <?php if ($modPembayaran->total_inacbg != 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total INACBG</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg, 2); ?></td>
                </tr>
            <?php

                $dibayar = $modPembayaran->total_inacbg;

            /*
        ?>
        <tr class="closing footee">
            <td colspan="9">Dibayar Oleh Pasien</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr) + $tandabukti->jmlpembulatan); ?></td>
        </tr>

        <?php */
            endif; ?>


            <?php // if ($suba < ($subtotalkotor + $tandabukti->biayaadministrasi)) {

            $ekses = $modSubsidi->subsidiasuransi - $modPembayaran->total_inacbg;

            /*
            $bcount = count((array)$bkelas);




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


            if ($ekses > 0) : ?>

                <?php if ($tandabukti->jmlpembulatan != 0) : ?>
                    <tr class="closing footee" hidden>
                        <td colspan="9">Jumlah Pembulatan</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, true); ?></td>
                    </tr>
                <?php endif; ?>


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
                    <tr class="closing footee" hidden>
                        <td colspan="9">Total Uang Muka</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka, 2); ?></td>
                    </tr>
                    <tr class="closing footee" hidden>
                        <td colspan="9">Pemakaian Uang Muka</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka, 2); ?></td>
                    </tr>
                    <tr class="closing footee" hidden>
                        <td colspan="9">Sisa Uang Muka</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka, 2); ?></td>
                    </tr>

                <?php endif; ?>

                <!-- <tr class="closing footee">
                <td colspan="9">Dibayar Oleh Pasien</td>
                <td style="text-align: right;"><?php
                                                //echo MyFormatter::formatNumberForPrint($ekses,2); 
                                                ?></td>
            </tr> -->

                <?php if ($tandabukti->bank_nominal > 0) : ?>
                    <tr class="closing footee" hidden>
                        <td colspan="9">Pembayaran Non-Tunai</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal, 2); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if ($ekses - $tandabukti->bank_nominal > 0) : ?>
                    <tr class="closing footee" hidden>
                        <td colspan="9">Pembayaran Tunai</td>
                        <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal, 2); ?></td>
                    </tr>
                <?php endif; ?>



                <?php if ($ekses - $tandabukti->bank_nominal > 0) : ?>
                    <!-- <tr class="closing footee">
                <td colspan="9">Diterima Kasir</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal,2); 
                                                                                    ?></td>
            </tr> -->
                <?php endif; ?>



            <?php endif; ?>



        <?php

            //    }
        } else {

        ?>
            <?php if ($modPembayaran->totaldiscount != 0) : ?>
                <tr class="footee" hidden>
                    <td colspan="9">Total Diskon</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount, 2); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ($modPembayaran->jasapelayanan_farmasi != 0) : ?>
                <tr class="grand_total footee" hidden>
                    <td colspan="9">Jasa Pelayanan Farmasi</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->jasapelayanan_farmasi, 2); ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($modPembayaran->total_embalase != 0) : ?>
                <tr class="grand_total footee" hidden>
                    <td colspan="9">Total Embalase</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_embalase, 2); ?></td>
                </tr>
            <?php endif; ?>


            <?php if ($grand_totals != 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total Tagihan</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals, 2); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ($modPembayaran->totalpembebasan != 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total Pembebasan</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalpembebasan, 2); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ($modPembayaran->total_inacbg != 0 || $modPembayaran->totalsubsidiasuransi != 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total Tanggungan Asuransi</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint((!empty($modPembayaran->total_inacbg) ? $modPembayaran->total_inacbg : $modPembayaran->totalsubsidiasuransi), 0); ?></td>
                </tr>
            <?php endif; ?>
            <?php if ($modPembayaran->totalsubsidirs > 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total Tanggungan Rumah Sakit</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsubsidirs, 2); ?></td>
                </tr>
            <?php endif; ?>

            <?php
            $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                'pembayaranpelayanan_id' => $modPembayaran->pembayaranpelayanan_id
            ));

            $jml_uangmuka = 0;

            if (!empty($bayaruangmuka)) :

                $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

            ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total Uang Muka</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka, 2); ?></td>
                </tr>
                <tr class="closing footee" hidden>
                    <td colspan="9">Pemakaian Uang Muka</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka, 2); ?></td>
                </tr>
                <tr class="closing footee" hidden>
                    <td colspan="9">Sisa Uang Muka</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
                </tr>

            <?php endif; ?>

            <tr class="closing footee" hidden>
                <td colspan="9">Dibayar Oleh Pasien</td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaliurbiaya, 0); ?></td>
            </tr>

            <?php if ($tandabukti->jmlpembulatan != 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Pembulatan</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0, true); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ($tandabukti->uangditerima > 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Pembayaran Tunai</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima, 0); ?></td>
                </tr>
            <?php endif; ?>



            <?php if ($modPembayaran->selisihuntungrugibpjs > 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total Selisih Tanggungan BPJS</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->selisihuntungrugibpjs, 2); ?></td>
                </tr>
            <?php endif; ?>

            <?php if ($modPembayaran->totalsisatagihan > 0) : ?>
                <tr class="closing footee" hidden>
                    <td colspan="9">Total Sisa Tagihan</td>
                    <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsisatagihan, 2); ?></td>
                </tr>
            <?php endif; ?>


        <?php } ?>
    </tbody>

</table>
<!-- <table width = "50%">
    <tr style="height: 20px; border-top:1px solid;border-right:1px solid; border-left:1px solid;">
        <td colspan="2"style="text-align: left;">Tagihan</td>
        <td style="text-align: right;" ><?php //echo MyFormatter::formatNumberForPrint($total_pembayaran); 
                                        ?></td>
    </tr>
    <tr style="height: 20px; border-right:1px solid; border-left:1px solid;">
        <td colspan="2"style="text-align: left;">Deposit</td>
        <td style="text-align: right;" ><?php //echo MyFormatter::formatNumberForPrint($jml_uangmuka); 
                                        ?></td>
    </tr>
    <tr style="height: 20px; border-bottom:1px solid;border-right:1px solid; border-left:1px solid;">
        <td colspan="2"style="text-align: left;">Kurang Bayar</td>
        <td style="text-align: right;" ><?php //echo MyFormatter::formatNumberForPrint($total_pembayaran - $jml_uangmuka); 
                                        ?></td>
    </tr>
</table> -->
<br /><br />

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
		if (count((array)$modRincians) > 0) {
			echo date("d-m-Y",strtotime($modRincians[count((array)$modRincians)-1]->tgl_tindakan));
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
<table width="50%">
    <tr>
        <td></td>
        <?php if ($modPembayaran->total_inacbg != 0) : ?>
            <td>Jaminan : <?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg + $tandabukti->biayaadministrasi); ?></td>
        <?php endif; ?>
        <?php if ($modPembayaran->total_inacbg == 0 && $modPembayaran->totalsubsidiasuransi != 0) { ?>
            <td>Jaminan : <?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsubsidiasuransi); ?></td>
        <?php } else { ?>

        <?php } ?>
    </tr>
    <tr style="height: 100px; border:1px solid;">
        <td>
            Jenis Penjamin
        </td>
        <td>
            <?php if (!empty($jml_uangmuka)) { ?>
                <p><?php echo "Deposit" . ":" . MyFormatter::formatNumberForPrint($jml_uangmuka); ?></p>
            <?php } else { ?>

            <?php } ?>
            <?php if (!empty($tandabukti->uangditerima)) { ?>
                <p><?php echo "Tunai" . ":" . MyFormatter::formatNumberForPrint($tandabukti->uangditerima - $tandabukti->uangkembalian); ?></p>
            <?php } else { ?>

            <?php } ?>
            <?php if ($totalcredit != 0) { ?>
                <p> <?php echo "Credit Card " . " " . $bankcredit . " " . MyFormatter::formatNumberForPrint($totalcredit); ?></p>
            <?php } else { ?>

            <?php } ?>
            <?php if ($totaldebit != 0) { ?>
                <p> <?php echo "Debit Card " . " " . $bankdebit . " " . MyFormatter::formatNumberForPrint($totaldebit); ?></p>
            <?php } else { ?>

            <?php } ?>
        </td>
    </tr>
</table>
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
            // var pegawai_id = '<?php echo Yii::app()->user->getState('pegawai_id') ?>';
            window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar2&caraPrint=EXCEL", array("pembayaranpelayanan_id" => $_GET['pembayaranpelayanan_id'])) ?>", "", 'location=_new, width=1024px');

            <?php
            // if (!empty(Params::getPegawaiAksesRincianExcel(Yii::app()->user->getState('pegawai_id')))){
            ?>
            // window.open("<?php //echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar2&caraPrint=EXCEL", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) 
                            ?>","",'location=_new, width=1024px');
            <?php
            // }else{
            ?>
            // myAlert("Anda tidak berhak untuk mengakses fungsi ini","Perhatian!");
            <?php
            // }
            ?>


        }
    </script>
<?php
} else {
?>
    <table width='100%'>
        <tr hidden>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td align='center'>Penerima</td>
            <td align='center'><?php echo $data->nama_rumahsakit; ?></td>
        </tr>
        <tr height='150px'>
            <td align='center'>(.........................................)</td>
            <td align='center'>(.........................................)</td>
        </tr>
        <tr>
            <td><?php echo $format->formatDateTimeId($modPembayaran->tglpembayaran); ?></td>
            <td align='right'>Kasir <?php
                                    $log = LoginpemakaiK::model()->findByPk($modPembayaran->create_loginpemakai_id);
                                    if (!empty($log)) {
                                        $peg = PegawaiM::model()->findByPk($log->pegawai_id);
                                        echo empty($peg) ? "-" : $peg->namaLengkap;
                                    }

                                    //echo $petugas->petugasadministrasi_gelardepan." ".$petugas->petugasadministrasi_nama." ".$petugas->petugasadministrasi_gelarbelakang; 
                                    ?></td>
        </tr>
        <tr>
            <td>
                <p>- INVOICE INI BERLAKU SEBAGAI KWITANSI</p>
            </td>

        </tr>
    </table>
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
    <div class="">
    </div>
    <div class="footer">
        <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); 
        ?>
    </div>
<?php
}
?>