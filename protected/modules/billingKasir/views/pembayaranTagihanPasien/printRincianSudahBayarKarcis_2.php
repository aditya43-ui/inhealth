<style>
    body{
        width: 100%;
        padding-right: 10mm;
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

    .hddn {
        display: none;
    }
</style>
<?php

$pj = PenanggungjawabM::model()->findByPk($modPendaftaran->penanggungjawab_id);

$format = new MyFormatter;
// if (!isset($_GET['frame'])){
   ?>
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
<?php
// }
?>
                    <?php

$pasien = $modPendaftaran->pasien;
$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
$asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
$masukkamar = empty($admisi) ? null : MasukkamarT::model()->findByAttributes(array(
    'pasienadmisi_id'=>$admisi->pasienadmisi_id,
), array(
    'order'=>'masukkamar_id desc',
));
$tandabukti = TandabuktibayarT::model()->findByAttributes(array(
    'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
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
        'select'=>'daftartindakan_akomodasi'
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
    $dokter = empty($dokter)?"-":$dokter->namaLengkap;

    if (empty($grp[$item->ruangan_id])) {
        $grp[$item->ruangan_id] = array(
            'nama'=>$item->ruangan_nama,
            'content'=>array(),
            'total'=>0,
        );
    }

    $diskon += $item->discount_tindakan;


    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;


    $item->tarif_satuan = (round($item->tarif_satuan * 100) / 100);
    $subtotalkotor += (round($item->qty_tindakan * $item->tarif_satuan * 100)/100) - $item->discount_tindakan;
    $subtotal += (round($item->qty_tindakan * $item->tarif_satuan * 100)/100) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);

    $tanggal = date('d/m/Y', strtotime($item->tgl_tindakan));
    $daftartindakan_id = $item->daftartindakan_id."_".($item->is_alkes ? "0" : "1");
    $harga = $item->tarif_satuan;

    $dt = DaftartindakanM::model()->findByPk($item->daftartindakan_id, array(
        'select'=>'daftartindakan_akomodasi'
    ));
    if (!$item->is_alkes && !empty($dt) && $dt->daftartindakan_akomodasi) {
        $idx_line = $daftartindakan_id."::".$harga;
    } else {
        // $idx_line = $daftartindakan_id."::".$tanggal."::".$harga;
        $idx_line = $daftartindakan_id."::".$harga;
    }

    if (empty($grp[$item->ruangan_id]['content'][$idx_line])) {
        $grp[$item->ruangan_id]['content'][$idx_line] = array(
            'visite'=>$item->daftartindakan_visite,
            'konsul'=>$item->daftartindakan_konsul,
            'uraian'=>$item->daftartindakan_nama,
            'dokter'=>$dokter,
            'tgl'=>  date("d/m/Y H:i", strtotime($item->tgl_tindakan)),
            'jml'=> $item->qty_tindakan,
            'harga'=> ($item->tarif_satuan),
            'diskon'=>($item->discount_tindakan),
            'suba'=>($item->subsidiasuransi_tindakan),
            'subp'=>($item->subsidipemerintah_tindakan),
            'subr'=>($item->subsisidirumahsakit_tindakan),
            'subtotal'=>(($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
            'subtotalkotor'=>(($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan),
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
    $grp[$item->ruangan_id]['total'] += (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan);



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


    $grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount) + $modPembayaran->jasapelayanan_farmasi);
}

$subr = $modPembayaran->totalsubsidirs;
$masukKamarPasien = null;
if(!empty($admisi->pasienadmisi_id)){
  $masukKamarPasien = MasukkamarT::model()->findByAttributes(array(
      'pasienadmisi_id'=>$admisi->pasienadmisi_id,
      // 'pindahkamar_id'=>null
  ), array(
      'order'=>'create_time asc',
  ));
}
// var_dump($grp); die;
?>

<div class="judulcontent" style="text-align: center;">RINCIAN TAGIHAN SUDAH BAYAR</div>
<br/>

<table class="identitas" width="100%">
    <tr>
        <td>No Pembayaran</td><td>:</td><td><?php echo $modPembayaran->nopembayaran; ?></td>
        <td nowrap>Kelas Pelayanan</td><td>:</td><td><?php echo !empty($modPendaftaran->pasienadmisi_id)?$admisi->kelaspelayanan->kelaspelayanan_nama:$modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Jenis Penjamin</td><td>:</td><td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
        <?php if (!empty($asuransi)): ?><td nowrap>Kelas Tanggungan</td><td>:</td><td><?php echo $asuransi->kelastanggunganasuransi->kelaspelayanan_nama; ?></td><?php endif; ?>
    </tr>
    <tr>
        <td>Penjamin</td><td>:</td><td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        <td>Banyaknya</td><td>:</td><td><?php echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima + $tandabukti->bank_nominal,2); ?></td>
    </tr>
    <tr>
        <td>Terbilang</td><td>:</td><td><?php echo ($tandabukti->uangditerima + $tandabukti->bank_nominal)==0?"NOL RUPIAH":strtoupper(MyFormatter::formatNumberTerbilang(($tandabukti->uangditerima + $tandabukti->bank_nominal)))." RUPIAH"; ?></td>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td><td>:</td><td width="100%"><?php echo $pasien->no_rekam_medik; ?></td>
        <td nowrap>Tgl. Pendaftaran</td><td>:</td><td nowrap><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td nowrap><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
        <td>No. Pendaftaran</td><td>:</td><td nowrap><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <!--<td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php //echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>-->
        <td>Tanggal Lahir</td><td>:</td><td nowrap><?php echo MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
        <td>Ruangan</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->ruangan->ruangan_nama:$admisi->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td nowrap><?php echo $pasien->alamat_pasien; ?></td>

        <?php if (!empty($modPendaftaran->pasienadmisi_id)):
            $kamarruangan = KamarruanganM::model()->findByPk($masukkamar->kamarruangan_id);
?>
        <?php endif; ?>
        <td>Tanggal Masuk Kamar</td><td>:</td><td nowrap><?php echo (!empty($masukKamarPasien)? MyFormatter::formatDateTimeForUser($masukKamarPasien->tglmasukkamar) : ""); ?></td>
    </tr>
    <tr hidden>

        <?php /*if (!empty($modPendaftaran->pasienadmisi_id)): ?>
        <?php /*
        <td>Dokter PJP</td><td>:</td><td nowrap><?php echo $admisi->pegawai->namaLengkap; ?></td>
        <?php endif; ?>
         *
         */ ?>
    </tr>
    <?php if (!empty($admisi)): ?>

    <?php


        $daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
        $admisiTgl = date('Y-m-d', strtotime($admisi->tgladmisi));
        $masukkamarTgl = (!empty($masukKamarPasien)?date('Y-m-d', strtotime($masukKamarPasien->tglmasukkamar)):$admisiTgl);
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
        $res = CustomFunction::hitungHariRawat(MyFormatter::formatDateTimeForDb($masukkamarTgl),MyFormatter::formatDateTimeForDb($vpulang));

        $str = $tgl_mskkamar." - ".$tgl_pulang;

        if ($admisi->penjamin_id == Params::PENJAMIN_ID_UMUM):

        ?>

    <tr>
        <td>Dokter</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pegawai->namaLengkap : $admisi->pegawai->namaLengkap; ?></td>
        <td>Lama Rawat</td><td>:</td><td nowrap><?php echo $res." Hari (".$str.")"; ?></td>
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

<table width="100%" class="tab_detail">
    <thead>
        <th style='text-align: center;'></th>
        <th width='150' style='text-align: center;'>Tgl Transaksi</th>
        <th style='text-align: center;'>Uraian</th>
        <th width='70' style='text-align: center;'>Jml</th>
        <th width='150' style='text-align: center;'>Biaya (Rp)</th>
        <th width='150' style='text-align: center;'>Keringanan (Rp)</th>
        <th style='text-align: center;' class="hddn">Tanggungan Asuransi</th>
        <th style='text-align: center;' class="hddn">Tanggungan Pemerintah</th>
        <th style='text-align: center;' class="hddn">Tanggungan Rumah Sakit</th>
        <th style='text-align: center;' class="hddn">Iur Biaya</th>
        <th width='150' style='text-align: center;'>Jumlah</th>
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
                <td style="padding-left: 5mm; padding-right: 5mm;"><?php echo $item2['tgl']; ?></td>
                <td><?php echo $item2['uraian']." - (".$item2['dokter'].")"; ?></td>
                
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['jml'],2); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['harga'],0); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['diskon'],2); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($item2['suba'],0); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($item2['subp'],2); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($item2['subr'],2); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($item2['subtotal'],2); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['subtotalkotor'],0); ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="5"></td>
                <td style="text-align: right;">Subtotal : </td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item['total']); ?></td>
            </tr>
        <?php endforeach; ?>
        <tr style="border-top:1px solid #333;" class="footee">
            <td></td>
            <td colspan="3">Terbilang : # <?php echo ucwords($format->formatNumberTerbilang($subtotalkotor)) . ' Rupiah'; ?></td>
            <td colspan="2" style="text-align: right">Total Biaya Pelayanan</td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($diskon,2); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($suba,0); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subp,2); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subr,2); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subtotal,2); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor,0); ?></td>
        </tr>
        <?php if ($tandabukti->biayaadministrasi != 0): ?>
            <tr class="closing footee">
                <td colspan="6">Administrasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi,2); ?></td>
            </tr>
        <?php endif; ?>

        <?php



        $modSubsidi = SubsidikelasT::model()->findByAttributes(array(
            'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
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
                <td colspan="6">Total Diskon</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount,0); ?></td>
            </tr>
            <?php endif; ?>

        <?php if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
        <tr class="grand_total footee">
            <td colspan="6">Total Tagihan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals,0); ?></td>
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
            <td colspan="6">INA <?php echo $kelas->kelaspelayanan_nama; ?></td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modSubsidi->subsidiasuransi,2); ?></td>
        </tr>
        <?php //}

        // var_dump($bkelas, $kelas_master); die;

        ?>

        <?php if ($modPembayaran->total_inacbg != 0): ?>
            <tr class="closing footee">
                <td colspan="6">Total INACBG</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg,2); ?></td>
            </tr>
        <?php

        $dibayar = $modPembayaran->total_inacbg;

        /*
        ?>
        <tr class="closing footee">
            <td colspan="9">Dibayar Oleh Pasien</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr) + $tandabukti->jmlpembulatan); ?></td>
        </tr>

        <?php */ endif; ?>


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

            <?php if ($tandabukti->jmlpembulatan != 0): ?>
            <tr class="closing footee">
                <td colspan="6">Jumlah Pembulatan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 2, true); ?></td>
            </tr>
            <?php endif; ?>


            <?php
            $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id
            ));

            $jml_uangmuka = 0;

            if (!empty($bayaruangmuka)):

            $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

            $ekses -= $jml_uangmuka;
            $ekses += $tandabukti->jmlpembulatan;

            ?>
            <tr class="closing footee">
                <td colspan="6">Total Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka,2); ?></td>
            </tr>
            <tr class="closing footee">
                <td colspan="6">Pemakaian Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka,2); ?></td>
            </tr>
            <tr class="closing footee">
                <td colspan="6">Sisa Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka,2); ?></td>
            </tr>

            <?php endif; ?>

            <!-- <tr class="closing footee">
                <td colspan="9">Dibayar Oleh Pasien</td>
                <td style="text-align: right;"><?php
                //echo MyFormatter::formatNumberForPrint($ekses,2); ?></td>
            </tr> -->

            <?php if ($tandabukti->bank_nominal > 0): ?>
            <tr class="closing footee">
                <td colspan="6">Pembayaran Non-Tunai</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal,2); ?></td>
            </tr>
            <?php endif; ?>

            <?php if ($ekses - $tandabukti->bank_nominal > 0): ?>
            <tr class="closing footee">
                <td colspan="6">Pembayaran Tunai</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal,2); ?></td>
            </tr>
            <?php endif; ?>



            <?php if ($ekses - $tandabukti->bank_nominal > 0): ?>
            <!-- <tr class="closing footee">
                <td colspan="6">Diterima Kasir</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal,2); ?></td>
            </tr> -->
            <?php endif; ?>



        <?php endif; ?>



        <?php

        //    }
        } else {

        ?>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <?php // if ($modPembayaran->totaldiscount != 0): ?>
            <tr class="closing footee">
                <td colspan="6" style="text-align: right">Keringanan Akhir</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount,0); ?></td>
            </tr>
            <?php // endif; ?>
            
            <?php if ($modPembayaran->jasapelayanan_farmasi != 0): ?>
            <tr class="grand_total footee">
                <td colspan="6" style="text-align: right">Jasa Pelayanan Farmasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->jasapelayanan_farmasi,0); ?></td>
            </tr>
            <?php endif; ?>
            

            <tr class="closing footee">
                <?php $jaminan_total = 0; ?>
                <td></td>
                <td colspan="4" style="text-align: left">Dibayar Tunai: <?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaliurbiaya, 0); ?>
                    <?php if ($modPembayaran->totalpembebasan != 0): ?>
                        Pembebasan: <?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalpembebasan,0); ?>
                    <?php 
                        echo "&nbsp&nbsp&nbsp&nbsp";
                    endif; ?>
                    <?php if ($modPembayaran->total_inacbg != 0 || $modPembayaran->totalsubsidiasuransi != 0): 
                        $jaminan_total += !empty($modPembayaran->total_inacbg)? $modPembayaran->total_inacbg : $modPembayaran->totalsubsidiasuransi;
                    endif; 
                    echo "&nbsp&nbsp&nbsp&nbsp";?>
                    <?php if ($modPembayaran->totalsubsidirs > 0): 
                        $jaminan_total += $modPembayaran->totalsubsidirs; 
                    endif; 
                    echo "&nbsp&nbsp&nbsp&nbsp";?>
                    <?php if ($jaminan_total > 0) {
                        echo " Jaminan : ".MyFormatter::formatNumberForPrint($jaminan_total);
                    }
                    ?>
                </td>
                
                <?php // if ($grand_totals != 0) : ?>
                <td colspan="1" style="text-align: right">Grand Total</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals,0); ?></td>
                <?php // endif; ?>
            </tr>



            <?php /*
            $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id
            ));

            $jml_uangmuka = 0;

            if (!empty($bayaruangmuka)):

            $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

            ?>
            <tr class="closing footee" hidden>
                <td colspan="6" style="text-align: right">Total Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka,2); ?></td>
            </tr>
            <tr class="closing footee">
                <td colspan="6" style="text-align: right">Pemakaian Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka,2); ?></td>
            </tr>
            <tr class="closing footee" hidden>
                <td colspan="6" style="text-align: right">Sisa Uang Muka</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
            </tr>

            <?php endif; */ ?>    

            
            
            <?php if ($tandabukti->jmlpembulatan != 0): ?>
            <tr class="closing footee">
                <td colspan="6" style="text-align: right">Pembulatan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, 0,true); ?></td>
            </tr>
            <?php endif; ?>


            <?php /* if ($tandabukti->uangditerima > 0): ?>
            <tr class="closing footee">
                <td colspan="6" style="text-align: right">Pembayaran Tunai</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->uangditerima,0); ?></td>
            </tr>
            <?php endif; ?>

            <?php if ($tandabukti->bank_nominal > 0): ?>
            <tr class="closing footee">
                <td colspan="6" style="text-align: right">Pembayaran Non-Tunai</td><td style="text-align: right;">(<?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal,2); ?>)</td>
            </tr>
            <?php endif; ?>

            <?php if ($modPembayaran->selisihuntungrugibpjs > 0): ?>
            <tr class="closing footee">
                <td colspan="6" style="text-align: right">Total Selisih Tanggungan BPJS</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->selisihuntungrugibpjs, 2); ?></td>
            </tr>
            <?php endif; ?>

            <?php if ($modPembayaran->totalsisatagihan > 0): ?>
            <tr class="closing footee">
                <td colspan="6" style="text-align: right">Total Sisa Tagihan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsisatagihan,2); ?></td>
            </tr>
            <?php endif; */ ?>


        <?php } ?>
    </tbody>

</table>
<?php if (!empty($pj)) {
    echo "Penanggung Jawab : ".$pj->nama_pj;
} ?>
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

<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
	echo "&nbsp;";
	echo CHtml::link(Yii::t('mds', '{icon} Excel', array('{icon}'=>'<i class="'.MyIcon::getIcons('excel').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-success','onclick'=>"printExcel();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar2", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
    }

	function printExcel(){
		var pegawai_id = '<?php echo Yii::app()->user->getState('pegawai_id') ?>';

		<?php
			if (!empty(Params::getPegawaiAksesRincianExcel(Yii::app()->user->getState('pegawai_id')))){
		?>
				window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar2&caraPrint=EXCEL", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
		<?php
			}else{
		?>
				myAlert("Anda tidak berhak untuk mengakses fungsi ini","Perhatian!");
		<?php
			}
		?>


    }
    </script>
<?php
}else{
?>
    <table width='100%'>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td align='center'>Verifikasi</td>
            <td align='center'>Yang membayar</td>
            <td align='center'>Kasir</td>
        </tr>
        <tr height='100px'>
            <td align='center'>__________________</td>
            <td align='center'>__________________</td>
            <!-- <td align='center'><?php //echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?></td> -->
            <td align='center'><?php echo Yii::app()->user->getState('nama_pegawai'); ?></td>
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
    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php
}
?>
