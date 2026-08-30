<style>
    th, td, div{
        font-family: Arial;
        font-size: 10pt;
    }
    .belumLunas{
        position: absolute;
        bottom: 0;
        left: 30%;
        background-color:rgba(0, 0, 0, 0);
        
    }
    .tandatangan{
        vertical-align: bottom;
        text-align: center;
    }
    body{
        width: 100%;
        /* height: 11cm; */
    }
    .identitas{
        line-height: 12px;
    }

    .rincian thead th{ /*, .rincian td */
        /*border: 1px solid black;*/
		border-top: 1px solid black;
		border-bottom: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
    }

	.rincian tfoot tr td{
		border-top: 1px solid black;
		border-bottom: 1px solid black;
	}

    .rincian tfoot td {
        font-weight: bold;
    }

	TABLE, TBODY, TFOOT, TR, TH, TD{
		font-family: "Arial";
		font-size: 10px;
		color:#333;
	}
</style>
<?php
$format = new MyFormatter;
?>

<table width="100%">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew1', array());
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
    'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id,
), array(
    'order'=>'masukkamar_id desc',
));

$verifikasi = VerifikasitagihanT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
), array(
    'order'=>'verifikasitagihan_id desc',
));

$str_lama = "";
$masukKamarPasien = null;
if (!empty($admisi)) {
  $masukKamarPasien = MasukkamarT::model()->findByAttributes(array(
      'pasienadmisi_id'=>$admisi->pasienadmisi_id,
      // 'pindahkamar_id'=>null
  ), array(
      'order'=>'create_time asc',
  ));

$daftar = date('Y-m-d', strtotime($modPendaftaran->tgl_pendaftaran));
$admisiTgl = date('Y-m-d', strtotime($admisi->tgladmisi));
$masukkamarTgl = (!empty($masukKamarPasien)?date('Y-m-d', strtotime($masukKamarPasien->tglmasukkamar)):$admisiTgl);
$pulang = empty($admisi->tglpulang) ? $admisi->rencanapulang : $admisi->tglpulang;
$pulang = empty($pulang) ? date('Y-m-d') : $pulang;

$vpulang = date('Y-m-d', strtotime($pulang));

$tgl_daftar = MyFormatter::formatDateTimeForUser($daftar);
$tgl_amds = MyFormatter::formatDateTimeForUser($admisiTgl);
$tgl_pulang = MyFormatter::formatDateTimeForUser($vpulang);
$tgl_mskkamar = MyFormatter::formatDateTimeForUser($masukkamarTgl);


$val_daftar = strtotime($daftar);
$val_adms = strtotime($admisiTgl);
$val_pulang = strtotime($vpulang);
$val_mskkamar = strtotime($masukkamarTgl);

//$res_lama = (($val_pulang - $val_adms)/ (3600 * 24)) + 1;
$res_lama = CustomFunction::hitungHariRawat(MyFormatter::formatDateTimeForDb($masukkamarTgl),MyFormatter::formatDateTimeForDb($vpulang));

$str_lama = $tgl_mskkamar." - ".$tgl_pulang;

}


// var_dump($masukkamar->attributes); die;

// var_dump($masukkamar->attributes, $modPendaftaran->attributes, $admisi->attributes); die;

?>
<div class="judulcontent" style="text-align: center; font-weight: bold;" hidden>Rincian Tagihan Sementara</div>
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
                        
            </table><br>
<table class="identitas" width="100%" hidden>
    <tr>
        <td>Jenis Penjamin</td><td>:</td><td><?php echo $modPendaftaran->carabayar->carabayar_nama; ?></td>
        <td nowrap>Kelas Pelayanan</td><td>:</td><td><?php echo !empty($modPendaftaran->pasienadmisi_id)?$admisi->kelaspelayanan->kelaspelayanan_nama:$modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?></td>
    </tr>
    <tr>
        <td>Penjamin</td><td>:</td><td><?php echo $modPendaftaran->penjamin->penjamin_nama; ?></td>
        <?php if (!empty($asuransi)): ?><td nowrap>Kelas Tanggungan</td><td>:</td><td><?php echo $asuransi->kelastanggunganasuransi->kelaspelayanan_nama; ?></td><?php endif; ?>
    </tr>
    <tr>
        <td colspan="6" style="border-bottom: 1px solid black">&nbsp;</td>
    </tr>
    <tr>
        <td nowrap>No. Rekam Medik</td><td>:</td><td width="100%"><?php echo $pasien->no_rekam_medik; ?></td>
        <td>Tgl. Pendaftaran</td><td>:</td><td nowrap><?php echo MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran); ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td><td>:</td><td nowrap><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
        <td>No. Pendaftaran</td><td>:</td><td nowrap><?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td><td>:</td><td nowrap><?php echo date('d / F /Y', strtotime($pasien->tanggal_lahir)); ?></td>
        <td>Ruangan</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->ruangan->ruangan_nama:$admisi->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td nowrap><?php echo $pasien->alamat_pasien; ?></td>

        <?php if (!empty($modPendaftaran->pasienadmisi_id)): ?>
        <td nowrap>Kamar / No. Bed</td><td>:</td><td nowrap><?php echo (empty($masukkamar) || empty($masukkamar->kamarruangan_id))?"-":($masukkamar->kamarruangan->kamarruangan_nokamar." / ".$masukkamar->kamarruangan->kamarruangan_nobed); ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Dokter</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pegawai_id) ? "-" : $modPendaftaran->pegawai->namaLengkap; ?></td>
        <?php if (!empty($modPendaftaran->pasienadmisi_id)): ?>
        <td>Dokter PJP</td><td>:</td><td nowrap><?php echo empty($admisi->pegawai_id) ? "-" : $admisi->pegawai->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td>Tanggal Masuk Kamar</td><td>:</td><td nowrap><?php echo (!empty($masukKamarPasien)? MyFormatter::formatDateTimeForUser($masukKamarPasien->tglmasukkamar) :""); ?></td>
    </tr>
    <tr>
        <?php if ($str_lama != ""): ?>
        <td colspan="3"></td>
        <td>Lama Rawat</td><td>:</td><td nowrap><?php echo $res_lama." Hari (".$str_lama.")"; ?></td>
        <?php endif; ?>
    </tr>
    
</table><br/>


<?php

$grp = array();

$suba = 0;
$subp = 0;
$subr = 0;
$subtotal = 0;
$subtotalKotor = 0;
$admin = 0;
$jasafarmasi = 0;
$totalembalase = 0;




$modTanggungan = null;
if ($modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) {
    $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modPendaftaran->kelaspelayanan_id,'penjamin_id'=>$modPendaftaran->penjamin_id));
} else if(isset($modPendaftaran->asuransipasien_id)){
    $modAsuransiPasien = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
    if(isset($modAsuransiPasien->kelastanggunganasuransi_id)&&isset($penjamin_id)){
        $modTanggungan = TanggunganpenjaminM::model()->findByAttributes(array('kelaspelayanan_id'=>$modAsuransiPasien->kelastanggunganasuransi_id,'penjamin_id'=>$penjamin_id));
    }
}

$subsidiasuransitind = 0;
$subsidipemerintahtind = 0;
$subsidirstind = 0;

if(!empty($modTanggungan->tanggunganpenjamin_id)){
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
    $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
    $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    
    $is_paket = $item->is_paketbmhp && !empty($item->paketbmhp_id);

    if ($is_paket) {
        $item->ruangan_id = "PKT_01";
        $item->ruangan_nama = "PAKET";
    }

    if (empty($grp[$item->ruangan_id])) {
        $grp[$item->ruangan_id] = array(
            'nama'=>$item->ruangan_nama,
            'content'=>array(),
            'total'=>0,
        );
    }

    if (empty($item->tindakansudahbayar_id)) {
        $item->subsidiasuransi_tindakan = $item->tarif_hargajual * $subsidiasuransitind / 100;
        $item->subsidipemerintah_tindakan = $item->tarif_hargajual * $subsidipemerintahtind / 100;
        $item->subsisidirumahsakit_tindakan = $item->tarif_hargajual * $subsidirstind / 100;
    } else continue;

    if($item->is_alkes){
        if($item->qty_tindakan <= 0){
            continue;
        }
    }

    if ($item->qty_tindakan == 0) {
        $item->subsidiasuransi_tindakan = 0;
        $item->subsidipemerintah_tindakan = 0;
        $item->subsisidirumahsakit_tindakan = 0;
    }



    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;

    if($item->is_alkes){
      // $item->tarif_satuan = $item->tarif_hargajual;

    }
    // $item->tarif_satuan = round($item->tarif_satuan);

    $subtotal += $item->tarif_hargajual - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);

    $item->tgl_tindakan = MyFormatter::formatDateTimeForDb($item->tgl_tindakan);


    $detail_ambulans = null;

    if ($item->komponenunit_id == Params::KOMPONENUNIT_ID_AMBULANS && !$item->is_alkes) {
        $pemakaian = PemakaianambulansT::model()->findByAttributes(array('tindakanpelayanan_id'=>$item->tindakanpelayanan_id));
        if (!empty($pemakaian)) {
            $item->daftartindakan_nama .= " - ".$pemakaian->alamattujuan;
            $detail_ambulans = empty($pemakaian->jasasarana_ambulans) ? array() : array(
                array('nama'=>"Jasa Sarana", 'biaya'=>$pemakaian->jasasarana_ambulans),
                array('nama'=>"BHP", 'biaya'=>$pemakaian->bhp),
                array('nama'=>"Jasa Pengemudi", 'biaya'=>$pemakaian->jasapengemudi),
                array('nama'=>"Jasa Pendamping", 'biaya'=>$pemakaian->jasapendamping),
                array('nama'=>"Jasa Dokter", 'biaya'=>$pemakaian->jasadokter),
                array('nama'=>"Biaya Tol", 'biaya'=>$pemakaian->biayatol),
            );
        } else {
            $detail_ambulans = array();
        }
    }
    

    $tanggal = date('d/m/Y', strtotime($item->tgl_tindakan));
    $daftartindakan_id = $item->daftartindakan_id."_".($item->is_alkes ? "0" : "1");
    if($item->cyto_tindakan == true){
        $harga = $item->tarifcyto_tindakan;
    }else{
        $harga = $item->tarif_satuan;
    }
    $dt = DaftartindakanM::model()->findByPk($item->daftartindakan_id, array(
        'select'=>'daftartindakan_akomodasi'
    ));

    $tindakan =TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
    if ($is_paket) {
        $idx_line = "BMHP_".$item->paketbmhp_id."_".date('YmdHi', strtotime($item->tgl_tindakan));
    } else {
        if (!$item->is_alkes && !empty($dt) && $dt->daftartindakan_akomodasi) {
            $idx_line = $daftartindakan_id."::".$item->pegawai_id."::".$harga;
        } else if(!empty($tindakan->tindakanluar_nama)) {
            $idx_line = $tindakan->tindakanpelayanan_id . "::" . $harga;
        } else {
            $idx_line =  $daftartindakan_id."::".$item->pegawai_id."::".$tanggal."::".$harga;
        }
    }
    $item->tarif_satuan = (($item->cyto_tindakan == true)? $item->tarifcyto_tindakan :$item->tarif_satuan);
    $tarifsatuanHarga = ($item->tarif_satuan + $item->biayaadministrasi +  ($item->qty_tindakan == 0 ? 0 : ($item->jumlahppn/$item->qty_tindakan)));
    // $tarifSubtota = (($tarifsatuanHarga * $item->qty_tindakan)- $item->discount_tindakan - $item->subsidiasuransi_tindakan -$item->subsisidirumahsakit_tindakan);
    $tarifSubtota = ($tarifsatuanHarga * $item->qty_tindakan) - $item->discount_tindakan - $item->subsisidirumahsakit_tindakan;
    $dataTin = !empty($tindakan->tindakanluar_nama) ? $tindakan->tindakanluar_nama : $item->daftartindakan_nama; 
    if (empty($grp[$item->ruangan_id]['content'][$idx_line])) {
        $grp[$item->ruangan_id]['content'][$idx_line] = array(
            'visite'=>$item->daftartindakan_visite,
            'konsul'=>$item->daftartindakan_konsul,
            'uraian'=>$dataTin,
            'dokter'=>$dokter,
            'tgl'=>  date('d/m/Y H:i:s', strtotime($item->tgl_tindakan)),//MyFormatter::formatDateTimeForUser($item->tgl_tindakan),
            'jml'=> $item->qty_tindakan,
            'harga'=> $tarifsatuanHarga,
            'suba'=>($item->subsidiasuransi_tindakan),
            'subp'=>($item->subsidipemerintah_tindakan),
            'subr'=>($item->subsisidirumahsakit_tindakan),
            'subtotal'=>($item->tarif_hargajual - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
            'subtotalKotor'=>$tarifSubtota,
            'detail_ambulans'=>$detail_ambulans,
            'jmldiskon'=>$item->discount_tindakan,
        );
    } else {
        $grp[$item->ruangan_id]['content'][$idx_line]['jml'] += $item->qty_tindakan;
        $grp[$item->ruangan_id]['content'][$idx_line]['suba'] += ($item->subsidiasuransi_tindakan);
        $grp[$item->ruangan_id]['content'][$idx_line]['subp'] += ($item->subsidipemerintah_tindakan);
        $grp[$item->ruangan_id]['content'][$idx_line]['subr'] += ($item->subsisidirumahsakit_tindakan);
        $grp[$item->ruangan_id]['content'][$idx_line]['subtotal'] += ($item->tarif_hargajual - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan));
        $grp[$item->ruangan_id]['content'][$idx_line]['subtotalKotor'] += $tarifSubtota;

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

    }
    if ($is_paket) {
        $grp[$item->ruangan_id]['content'][$idx_line]['uraian'] = $item->paketbmhp_nama;
        $grp[$item->ruangan_id]['content'][$idx_line]['jml'] = 1;
        $grp[$item->ruangan_id]['content'][$idx_line]['harga'] = $grp[$item->ruangan_id]['content'][$idx_line]['subtotalKotor'];
    }
    $grp[$item->ruangan_id]['total'] += $tarifSubtota;
    $subtotalKotor += $tarifSubtota;
    $jasafarmasi += $item->jasapelayanan_farmasi;
    $totalembalase += $item->total_embalase;

    /*
    array_push($grp[$item->ruangan_id]['content'], array(
        'visite'=>$item->daftartindakan_visite,
        'konsul'=>$item->daftartindakan_konsul,
        'uraian'=>$item->daftartindakan_nama,
        'dokter'=>$dokter,
        'tgl'=>  date('d/m/Y', strtotime($item->tgl_tindakan)),//MyFormatter::formatDateTimeForUser($item->tgl_tindakan),
        'jml'=> $item->qty_tindakan,
        'harga'=> MyFormatter::formatNumberForPrint($item->tarif_satuan),
        'suba'=>MyFormatter::formatNumberForPrint($item->subsidiasuransi_tindakan),
        'subp'=>MyFormatter::formatNumberForPrint($item->subsidipemerintah_tindakan),
        'subr'=>MyFormatter::formatNumberForPrint($item->subsisidirumahsakit_tindakan),
        'subtotal'=>MyFormatter::formatNumberForPrint(($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
        'subtotalKotor'=>MyFormatter::formatNumberForPrint($item->qty_tindakan * $item->tarif_satuan),
        'detail_ambulans'=>$detail_ambulans,
    ));
     *
     */
}



if (!empty($admisi)) {
    if (!empty($verifikasi) && $verifikasi->biaya_administrasi != 0) {
        $admin = $verifikasi->biaya_administrasi;
    } else {
        $penjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
        $admin = $subtotalKotor * $penjamin->biaya_administrasi / 100;
    }
}

// $grand_totals = $subtotalKotor + $admin + $jasafarmasi + $totalembalase;
$admin1 = ($subtotalKotor * 5) / 100;
if($modInstalasi->instalasi_id == Params::INSTALASI_ID_RI || $modInstalasi->instalasi_id == Params::INSTALASI_ID_PERSALINAN || $modInstalasi->instalasi_id == Params::INSTALASI_ID_PI ){
    $grand_totals = $subtotalKotor + $admin1 + $jasafarmasi + $totalembalase;
}else{
    $grand_totals = $subtotalKotor + $jasafarmasi + $totalembalase;
}

// var_dump($admin, $jasafarmasi, $totalembalase);


// var_dump($grp); die;

?>
<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$konfig = KonfigsystemK::model()->find();
$format = new MyFormatter;
// if (!isset($_GET['frame'])){
?>
<table width="100%" class="rincian" >
    <thead >
        <th style='border: 1px solid;text-align: center;' hidden>No.</th>
        <th style='border-right: 1px solid;text-align: center;'>Tanggal</th>
        <th style='border-right: 1px solid;text-align: center;'>Deskripsi</th>
        <th style='text-align: center;'hidden>Dokter</th>
        <th style='border-right: 1px solid;text-align: center;'>qty</th>
        <th style='border-right: 1px solid;text-align: center;'>Harga</th>
        <th style='border-right: 1px solid;text-align: center;'>Keringanan</th>
        <th style='text-align: center;'hidden>Tanggungan Asuransi</th>
        <th style='text-align: center;' hidden>Jaminan Pemerintah</th>
        <th style='text-align: center;'hidden>Tanggungan Rumah Sakit</th>
        <th style='text-align: center;' hidden>Iur Biaya</th>
        <th style='text-align: center;'>Jumlah</th>
    </thead>
    <tbody>
        <?php foreach ($grp as $item) : ?>
        <tr>
            <td colspan="10"><strong><?php echo $item['nama']; ?></strong></td>
        </tr>
            <?php
            $cnt = 0;
            foreach ($item['content'] as $item2) :
                $cnt++;
            ?>
            <tr >
                <td hidden>*. </td>
                <td><?php echo $item2['tgl']; ?></td>
                <td><?php echo $item2['uraian']."(".$item2['dokter'].")"; ?></td>
                <td hidden><?php
                //if ($item2['visite'] || $item2['konsul']){
                    echo $item2['dokter'];
                //}
                    ?></td>
                <td style="text-align: right;"><?php echo str_replace(".",",",$item2['jml']); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['harga'],2); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['jmldiskon'],2); ?></td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($item2['suba'],2); ?></td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subp'],2); ?></td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subr'],2); ?></td>
                <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($item2['subtotal'],2); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['subtotalKotor'],2); ?></td>
            </tr>

            <?php if (!empty($item2['detail_ambulans'])):
                foreach ($item2['detail_ambulans'] as $list_biaya):
                    if ($list_biaya['biaya'] == 0) {
                        continue;
                    }
                ?>
            <tr>
                <td>&emsp;&emsp;<?php echo $list_biaya['nama']; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($list_biaya['biaya'],2); ?></td>
            </tr>
            <?php
                endforeach;
            endif; ?>

            <?php endforeach; ?>
            <tr>
            <td colspan="5" style="text-align: right;"><b>Subtotal <?php //echo $item['nama']; ?></b></td>
            <td style="text-align: right;"><b><?php echo MyFormatter::formatNumberForPrint($item['total'], 2); ?></b></td>
        </tr>
        <?php endforeach;
        ?>
                        <tr style="height: 50px;"></tr>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="4" style = "border-bottom: 1px solid"></td>
                            </tr>
                            <tr>
                                <td>Terbilang</td>
                                <td >: # <?php echo MyFormatter::kataTerbilang($grand_totals);?> #</td>
                                <td colspan="2"style="text-align: right;"> Total(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($subtotalKotor) ; ?></td>
                            </tr>
                            <tr style="height: 50px;"></tr>
                            <tr>
                                <td></td>
                                <td ></td>
                                <td colspan="2"style="text-align: right;"> Keringanan Akhir(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;" ><?php echo MyFormatter::formatNumberForPrint($subr, 2); ?></td>
                            </tr>
                            <?php if($modInstalasi->instalasi_id == Params::INSTALASI_ID_RI || $modInstalasi->instalasi_id == Params::INSTALASI_ID_PERSALINAN || $modInstalasi->instalasi_id == Params::INSTALASI_ID_PI ){?>
                                <tr>
                                    <td></td>
                                    <td ></td>
                                    <td colspan="2"style="text-align: right;"> Biaya Adm(Rp)</td>
                                    <td style="text-align: left;">:</td>
                                    <td style="text-align: center;" ><?php echo MyFormatter::formatNumberForPrint($admin1); ?></td>
                                </tr>
                            <?php }?>
                            <tr>
                                <td></td>
                                <td colspan="2"></td>
                                <td colspan="4" style = "border-top: 1px solid"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td > <?php //echo $subsidiasuransi_tindakan; ?></td>
                                <td colspan="2"style="text-align: right;"> Grand Total(Rp)</td>
                                <td style="text-align: left;">:</td>
                                <td style="text-align: center;" ><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
                            </tr>
    </tbody>
    <tfoot hidden>
        <tr>
            <td colspan="6">Total Tagihan</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($suba,2); ?></td>
            <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($subp,2); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr,2); ?></td>
            <td style="text-align: right;" hidden><?php echo MyFormatter::formatNumberForPrint($subtotal,2); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalKotor,2); ?></td>
        </tr>
        <?php if ($admin > 0):
            ?>
            <tr class="closing footee">
                <td colspan="8">Administrasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($admin,2); ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($jasafarmasi > 0):
            ?>
            <tr class="closing footee">
                <td colspan="8">Jasa Pelayanan Farmasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jasafarmasi,2); ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($totalembalase > 0):
            ?>
            <tr class="closing footee">
                <td colspan="8">Total Embalase</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($totalembalase,2); ?></td>
            </tr>
        <?php endif; ?>
        <?php
        $konfig_pembulatan = Yii::app()->user->getState('pembulatanhargakasir');
        // $round_total = (round($grand_totals/100)*100);
        $round_total = (round($grand_totals/$konfig_pembulatan)*$konfig_pembulatan);
        // $round_total = $grand_totals;

        if ($admin > 0 || $round_total <> $grand_totals) :

        ?>
            <tr class="closing footee">
                <td colspan="8">Total Tanggungan Pasien</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($round_total,2); ?></td>
            </tr>
        <?php endif; ?>
    </tfoot>

</table>
<?php
if($modBayarUangMuka > 1){
    $total = 0;
    foreach($modBayarUangMuka as $i){
        $total += $i->jumlahuangmuka - $i->uangmukadipakai; 
    }
}
?>
<table width = "40%">
    <tr style="height: 20px; border-top:1px solid;border-right:1px solid; border-left:1px solid;">
        <td colspan="2"style="text-align: left;">Tagihan</td>
        <td style="text-align: right;" ><?php echo MyFormatter::formatNumberForUser($grand_totals); ?></td>
    </tr>
    <tr style="height: 20px; border-right:1px solid; border-left:1px solid;">
        <td colspan="2"style="text-align: left;">Deposit</td>
        <td style="text-align: right;" ><?php echo MyFormatter::formatNumberForUser($total); ?></td>
    </tr>
    <tr style="height: 20px; border-bottom:1px solid;border-right:1px solid; border-left:1px solid;">
        <td colspan="2"style="text-align: left;">Kurang Bayar</td>
        <td style="text-align: right;" ><?php echo MyFormatter::formatNumberForUser($grand_totals - $total); ?></td>
    </tr>
</table>
<br/><br/><br/>
<table width = "40%">
    <tr style="height: 100px; border:1px solid;">
        <td>
            Jenis Penjamin 
        </td>
        <td>
            <p>Tunai: -  </p>
            <p>Debit Card: - </p>
            <p>Credit Card: - </p>
        </td>
    </tr>
</table>
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
                            <td><?php echo $format->formatDateTimeId(date('Y-m-d')); ?></td>
                            <td align='right'>Kasir <?php echo Yii::app()->user->getState('gelardepan') . " " . Yii::app()->user->getState('nama_pegawai') . " " . Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
                        </tr>
                        <tr>
                            <td>
                            <p>- Rincian Tagihan Ini Bukan Bukti Pembayaran Yang Sah</p>
                            </td>
                            
                        </tr>
                    </table>
<?php /*
<table width="100%">
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
<table width = "50%" class="belumLunas">
    <tr>
        <td>
            <div style="padding:50px 50px; border:5px solid; border-color: red;transform: rotate(-20deg); text-align: center; ">
            <h1 style="font-size:60px; font-weight:bold; color:red;">Belum Lunas</h1>
    </div>
        </td>
    </tr>
    
</table>
<div class="footer">
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianBelumBayar", array("instalasi_id"=>$_GET['instalasi_id'], "pendaftaran_id"=>$_GET['pendaftaran_id'], "pasienadmisi_id"=>(isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>","",'location=_new, width=1024px');
    }
    </script>


           <?php //echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?>

<?php
}
?>
