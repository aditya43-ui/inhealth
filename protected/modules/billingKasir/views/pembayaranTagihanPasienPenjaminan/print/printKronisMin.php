<style>
    body{
        width: 100%;
        padding-right: 10mm;
        color: black;
        /* height: 11cm; */
    }
    .identitas{
        line-height: 12px;
        font-family: "Arial Narrow" !important;
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
    .data tr td{
        text-align:right;
        padding-left:300px;
        font-size: 17px;
        font-family: "Arial Narrow";
    }

    .font th{
        font-size:15px;
    }
</style>
<?php
if (isset($_GET['caraPrint'])) {
    if ($_GET['caraPrint'] == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincianbiayaperawatanpasien-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
    }
}
?>
<?php
$format = new MyFormatter;
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>

<table style="width: 100%; border: none !important; text-align: center">
    <thead class="data">
        <tr>
             <td>
                <?php echo $data->nama_rumahsakit;?>
                <!-- <div align="right" class="header">
                    
                    <?php
                    //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?></div> -->
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $data->alamatlokasi_rumahsakit;?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo "Telp. 0".$data->no_telp_profilrs." (Hunting) Fax. 0".$data->no_telp_profilrs;?>
            </td>
        </tr>
    </thead>
</table>
<?php
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
$carabayar_id = empty($admisi) ? $modPendaftaran->carabayar_id : $admisi->carabayar_id;
$grp = array();
$diskon = 0;
$suba = 0;
$subp = 0;
$subr = 0;
$subtotalkotor = 0;
$subtotal = 0;
$is_ada_obat = 0;
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
    if (!empty($item->pegawai_id)){
        $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
        $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    }else if(isset($modTindakan->perawat_id)){
        $dokter = PegawaiM::model()->findByPk($modTindakan->perawat_id);
        $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    }else if(!empty($modTindakan->dokterpemeriksa1_id)){
        $dokter = PegawaiM::model()->findByPk($modTindakan->dokterpemeriksa1_id);
        $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    }else if(!empty($modTindakan->okupasiterapi_id)){
        $dokter = PegawaiM::model()->findByPk($modTindakan->okupasiterapi_id);
        $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    }else if(!empty($modTindakan->terapiwicara_id)){
        $dokter = PegawaiM::model()->findByPk($modTindakan->terapiwicara_id);
        $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    }else if(!empty($modTindakan->fisioterapi_id)){
        $dokter = PegawaiM::model()->findByPk($modTindakan->fisioterapi_id);
        $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    }else{
       $dokter = "-"; 
    }
    $length = strlen($dokter);
    if ($length > 19) {
        $dokter = substr($dokter, 0, 19) . "..";
    }
    $diskon += $item->discount_tindakan;
    $item->tarif_satuan = (round($item->tarif_satuan * 100) / 100);
    $tanggal = date('d/m/Y H:i', strtotime($item->tgl_tindakan));
    $daftartindakan_id = $item->daftartindakan_id . "_" . ($item->is_alkes ? "0" : "1");
    $kelaspelayanan_id = !empty($modPendaftaran->pasienadmisi_id) ? $admisi->kelaspelayanan_id : $modPendaftaran->kelaspelayanan_id;
    if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {
        $jenistarif_id = Params::JENISTARIF_ID_BPJS;
    } else {
        $jenistarif_id = Params::JENISTARIF_ID_NONBPJS;
    }
    $tindakan_komponen = TindakankomponenT::model()->findByAttributes(['tindakanpelayanan_id' => $item->tindakanpelayanan_id]);
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
    $is_paket = $item->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET ? 0 : 1;
    $modObat = ObatalkesM::model()->findByPk($item->daftartindakan_id);
    if ($item->is_alkes == 1) {
        if ($modObat->jenisobatalkes_id == Params::JENIS_OBATALKES_ID_OBAT) {
            $is_ada_obat++;
        }
        $modOA = ObatalkespasienT::model()->findByPk($item['tindakanpelayanan_id']);
        if ($modOA->is_obatkronis == true) {
            $modFormularium = FormulaobatkronisM::model()->findByPk($modOA->formulaobatkronis_id);
            $item->qty_tindakan = $modFormularium->jumlahobat_minimal;
            $item->subsidiasuransi_tindakan = $item->qty_tindakan * $item->tarif_satuan;
        }
    }
    if ($item->qty_tindakan >= 1) {
        if ($item->tipepaket_id == Params::TIPEPAKET_ID_NONPAKET) {
            $txt_index = $item->ruangan_id;
            if (empty($grp[$txt_index])) {
                $grp[$txt_index] = array(
                    'nama' => strtoupper($item->ruangan_nama),
                    'content' => array(),
                    'total' => null,
                );
            }
            if ($item->is_alkes == false) {
                if (!empty($tindakan_komponen)) {
                    if (in_array($tindakan_komponen->komponentarif_id, Params::getJasaMedis())) {
                        $txt_index = $tindakan_komponen->komponentarif_id;
                        if (empty($grp[$txt_index])) {
                            $grp[$txt_index] = array(
                                'nama' => "JASA DOKTER",
                                'content' => array(),
                                'total' => null,
                            );
                        }
                    }
                }
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
    }
    
    if ($item->qty_tindakan >= 1) {
        $grp[$txt_index]['total'] += (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan);
        if (empty($grp[$txt_index]['content'][$idx_line])) {
            $grp[$txt_index]['content'][$idx_line] = array(
                'visite' => $item->daftartindakan_visite,
                'konsul' => $item->daftartindakan_konsul,
                'uraian' => $item->daftartindakan_nama,
                'dokter' => $dokter,
                'tgl'=>  date("d/m/Y H:i", strtotime($item->tgl_tindakan)),
                'jml' => $item->qty_tindakan,
                'harga' => ($item->tarif_satuan),
                'diskon'=>($item->discount_tindakan),
                'suba' => ($item->subsidiasuransi_tindakan),
                'subp' => ($item->subsidipemerintah_tindakan),
                'subr' => ($item->subsisidirumahsakit_tindakan),
                'subtotal' => (($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
                'subtotalkotor' => (($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan),
                'is_paket' => $is_paket,
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
    }
    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;
    $subtotalkotor += (round($item->qty_tindakan * $item->tarif_satuan * 100) / 100) - $item->discount_tindakan;
    $subtotal += (round($item->qty_tindakan * $item->tarif_satuan * 100) / 100) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
    $grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
}
$suba =  $suba + $modPembayaran->jasaembalase;
$subr = $modPembayaran->totalsubsidirs;
?>

<div class="judulcontent" style="text-align: center; font-size:12pt;">INVOICE</div>
<p style="text-align: center; font-size:10pt; font-family:Arial Narrow"><?php $str=$modPembayaran->nopembayaran;
$c = explode('-', $str);
echo $c[0]."-".$c[1]."SA".$c[2]; ?></p>
<br />
<table class="identitas" width="100%">
    <tr>
        <td>Atas Nama</td>
        <td></td>
        <td>: <?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
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
        <td>: <?php if (!empty($pj)) { echo $pj->nama_pj;
} ?></td>
        <td>No. Polis</td>
        <td></td>
        <td>:<?php echo $noasuransi;?></td>
    </tr>
    <tr>
        <td>Penjamin</td>
        <td></td>
        <td>: <?php echo empty($penjamin->penjamin_nama)? '-': $penjamin->penjamin_nama; ?></td>
        <td>Asal Perusahaan</td>
        <td></td>
        <td>: <?php echo empty($modAsuransi) ? '-':  $modAsuransi->namaperusahaan; ?></td>
    </tr>
    <!-- <tr>
        <td>Tanggal Pembayaran</td>
        <td></td>
        <td>: <?php //echo empty($modPembayaran->tglpembayaran)? '-':  MyFormatter::formatDateTimeForUser($modPembayaran->tglpembayaran); ?></td>
    </tr> -->

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
    <?php endif; ?>


    <?php endif; ?>
</table>

<table width="100%" class="tab_detail">
    <thead style="font-family: 'Arial' !important;">
        <tr class="closing footee">
            <td colspan="6"> </td>
        </tr>
        <tr class="closing footee">
            <td style='border-right: 1px solid;text-align: center;'>Tanggal</td>
            <td style='border-right: 1px solid;text-align: center;'>Deskripsi</td>
            <td style='border-right: 1px solid;text-align: center;'>Qty</td>
            <td style='border-right: 1px solid;text-align: center;'>Harga</td>
            <td style='border-right: 1px solid;text-align: center;'>Keringanan</td>
            <td style='text-align: center;'>Jumlah</td>
        </tr>
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
            <td style="padding-left: 5mm; padding-right: 5mm;"><?php echo $item2['tgl']; ?></td>
            <td><?php echo $item2['uraian']."(".$item2['dokter'].")"; ?></td>
            <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($item2['jml']); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['harga'],2); ?></td>
            <td style="text-align: center;"><?php echo MyFormatter::formatNumberForPrint($item2['diskon']); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item2['subtotalkotor'],0); ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td style="text-align:right; font-weight:bold; font-style:italic" colspan="4">Subtotal</td>
            <td style="text-align:right; font-weight:bold; font-style:italic" colspan="2">
                <?php echo MyFormatter::formatNumberForPrint($total,2); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr style="height: 50px;"></tr>
        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="4" style="border-bottom: 1px solid"></td>
        </tr>

        <tr>
            <td>Terbilang</td>
            <td>: # <?php echo ucwords(MyFormatter::kataTerbilang($subtotalkotor));?> #</td>
            <td colspan="2" style="text-align: right;"> Total(Rp)</td><br><br><br><br>
            <td style="text-align: left;">:</td><br><br><br><br>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor) ; ?></td><br><br><br><br>
        </tr>
        <tr style="height: 30px;"></tr>
        <?php //if ($modPembayaran->totaldiscount != 0): ?>
        <!-- <tr>
                <td></td>
                <td ></td>
                <td colspan="2"style="text-align: right;"> Disc. Akhir(Rp)</td>
                <td style="text-align: left;">:</td>
               <td style="text-align: center;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount,2); ?></td>
            </tr> -->
        <?php //endif; ?>
        <?php //if ($modPembayaran->totaldiscount == 0): ?>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right;">Biaya Admin:</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi,2); ?></td>
        </tr>
        <!-- <tr hidden>
            <td></td>
            <td ></td>
            <td colspan="2"style="text-align: right;">Pembebasan:</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: center;" ><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->totalpembebasan,2); ?></td>
        </tr>
        <tr hidden>
            <td></td>
            <td ></td>
            <td colspan="2"style="text-align: right;">Pembulatan:</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: center;" ><?php //echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan,2); ?></td>
        </tr> -->
        <?php //endif; ?>
        <tr>
            <td></td>
            <td></td>
            <td colspan="2" style="text-align: right;"> Keringanan Akhir(Rp)</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount,2); ?></td>
        </tr>

        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="4" style="border-top: 1px solid"></td>
        </tr>
        <!-- <?php //if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
            <tr>
                <td></td>
                <td > <?php //echo $subsidiasuransi_tindakan; ?></td>
                <td colspan="2"style="text-align: right;"> Grand Total(Rp)</td>
                <td style="text-align: left;">:</td>
                <td style="text-align: center;"><?php //echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
            </tr>
        <?php //endif; ?> -->
        <?php //if ($modPembayaran->totaldiscount == 0 || $tandabukti->biayaadministrasi == 0) { ?>
        <?php 
            $modJenis = JenispembayaranT::model()->findAllByAttributes(array('tandabuktibayar_id'=>$tandabukti->tandabuktibayar_id));
            // var_dump($modJenis);die;
            $totalcredit = 0;
            $totaldebit = 0;
            $bankdebit = '';
            $bankcredit = '';
            $total_pembayaran = 0;
            // var_dump($modJenis->bankpenerima_id);die;
            // 
            // var_dump($bank);die;
            if (!empty($modJenis)){
                foreach($modJenis as $items){
                    if ($items->jnspembayar_id == 2){
                        $totaldebit += $items->jumlahpembayaran;
                        $bank = BankM::model()->findByPk($items->bankpenerima_id);
                        $bankdebit = $bank->namabank;
                        
                        
                    }
                    if ($items->jnspembayar_id == 1){
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
            <td> <?php //echo $subsidiasuransi_tindakan; ?></td>
            <td colspan="2" style="text-align: right;"> Grand Total(Rp)</td>
            <td style="text-align: left;">:</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($total_pembayaran); ?></td>
        </tr>
        <?php //endif; ?>

        <!-- <tr style="border-top:1px solid #333;" class="footee" hidden>
            <td colspan="6">Total Biaya Pelayanan</td>
            <td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($diskon,2); ?></td>
            <td style="text-align: right;" class=""><?php //echo MyFormatter::formatNumberForPrint($suba,0); ?></td>
            <td style="text-align: right;" class="hddn"><?php //echo MyFormatter::formatNumberForPrint($subp,2); ?></td>
            <td style="text-align: right;" class=""><?php //echo MyFormatter::formatNumberForPrint($subr,2); ?></td>
            <td style="text-align: right;" class="hddn"><?php //echo MyFormatter::formatNumberForPrint($subtotal,2); ?></td>
            <td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($subtotalkotor,0); ?></td>
        </tr> -->
        <?php if ($tandabukti->biayaadministrasi != 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Administrasi</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi,2); ?></td>
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



        <?php if ($modPembayaran->totaldiscount != 0 || $tandabukti->biayaadministrasi != 0) : ?>
        <tr class="grand_total footee" hidden>
            <td colspan="9">Total Tagihan</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals,2); ?></td>
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
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modSubsidi->subsidiasuransi,2); ?></td>
        </tr>
        <?php //}

        // var_dump($bkelas, $kelas_master); die;

        ?>

        <?php if ($modPembayaran->total_inacbg != 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Total INACBG</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_inacbg,2); ?></td>
        </tr>
        <?php

        $dibayar = $modPembayaran->total_inacbg;

        /*
        ?>
        <tr class="closing footee">
            <td colspan="9">Dibayar Oleh Pasien</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($grand_totals - ($modPembayaran->total_inacbg + $modPembayaran->totalsubsidiasuransi + $subp + $subr) + $tandabukti->jmlpembulatan); ?>
            </td>
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
        <tr class="closing footee" hidden>
            <td colspan="9">Jumlah Pembulatan</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan, true); ?></td>
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
        <tr class="closing footee" hidden>
            <td colspan="9">Total Uang Muka</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka,2); ?></td>
        </tr>
        <tr class="closing footee" hidden>
            <td colspan="9">Pemakaian Uang Muka</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka,2); ?></td>
        </tr>
        <tr class="closing footee" hidden>
            <td colspan="9">Sisa Uang Muka</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka,2); ?></td>
        </tr>

        <?php endif; ?>

        <!-- <tr class="closing footee">
                <td colspan="9">Dibayar Oleh Pasien</td>
                <td style="text-align: right;"><?php
                //echo MyFormatter::formatNumberForPrint($ekses,2); ?></td>
            </tr> -->

        <?php if ($tandabukti->bank_nominal > 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Pembayaran Non-Tunai</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->bank_nominal,2); ?>
            </td>
        </tr>
        <?php endif; ?>

        <?php if ($ekses - $tandabukti->bank_nominal > 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Pembayaran Tunai</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal,2); ?></td>
        </tr>
        <?php endif; ?>



        <?php if ($ekses - $tandabukti->bank_nominal > 0): ?>
        <!-- <tr class="closing footee">
                <td colspan="9">Diterima Kasir</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($ekses - $tandabukti->bank_nominal,2); ?></td>
            </tr> -->
        <?php endif; ?>



        <?php endif; ?>



        <?php

        //    }
        } else {

        ?>

        <?php if ($modPembayaran->jasapelayanan_farmasi != 0): ?>
        <tr class="grand_total footee" hidden>
            <td colspan="9">Jasa Pelayanan Farmasi</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->jasapelayanan_farmasi,2); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($modPembayaran->total_embalase != 0): ?>
        <tr class="grand_total footee" hidden>
            <td colspan="9">Total Embalase</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->total_embalase,2); ?></td>
        </tr>
        <?php endif; ?>


        <!-- <?php //if ($grand_totals != 0) : ?>
            <tr class="closing footee" hidden>
                <td colspan="9">Total Tagihan</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($grand_totals,2); ?></td>
            </tr> -->
        <?php //endif; ?>

        <?php if ($modPembayaran->totalpembebasan != 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Total Pembebasan</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalpembebasan,2); ?></td>
        </tr>
        <?php endif; ?>

        <?php if ($modPembayaran->total_inacbg != 0 || $modPembayaran->totalsubsidiasuransi != 0): ?>
        <!-- <tr class="closing footee" hidden>
                    <td colspan="9">Total Tanggungan Asuransi</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint((!empty($modPembayaran->total_inacbg)? $modPembayaran->total_inacbg : $modPembayaran->totalsubsidiasuransi),0); ?></td>
                </tr> -->
        <?php endif; ?>
        <?php if ($modPembayaran->totalsubsidirs > 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Total Tanggungan Rumah Sakit</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsubsidirs,2); ?></td>
        </tr>
        <?php endif; ?>

        <?php
            $bayaruangmuka = PemakaianuangmukaT::model()->findByAttributes(array(
                'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id
            ));

            $jml_uangmuka = 0;

            if (!empty($bayaruangmuka)):

            $jml_uangmuka = $bayaruangmuka->pemakaianuangmuka;

            ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Total Uang Muka</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->totaluangmuka,2); ?></td>
        </tr>
        <tr class="closing footee" hidden>
            <td colspan="9">Pemakaian Uang Muka</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($jml_uangmuka,2); ?></td>
        </tr>
        <tr class="closing footee" hidden>
            <td colspan="9">Sisa Uang Muka</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($bayaruangmuka->sisauangmuka); ?></td>
        </tr>

        <?php endif; ?>

        <!-- <tr class="closing footee" hidden>
                <td colspan="9">Dibayar Oleh Pasien</td><td style="text-align: right;"><?php //echo MyFormatter::formatNumberForPrint($modPembayaran->totaliurbiaya, 0); ?></td>
            </tr> -->

        <?php if ($modPembayaran->selisihuntungrugibpjs > 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Total Selisih Tanggungan BPJS</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->selisihuntungrugibpjs, 2); ?></td>
        </tr>
        <?php endif; ?>

        <?php if ($modPembayaran->totalsisatagihan > 0): ?>
        <tr class="closing footee" hidden>
            <td colspan="9">Total Sisa Tagihan</td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsisatagihan,2); ?></td>
        </tr>
        <?php endif; ?>


        <?php } ?>
    </tbody>
</table>
<br /><br />
<table width="50%">
    <tr>
        <td></td>
        <?php if ($suba) { ?>
            <td style="border-bottom:1px solid #333;" align="left">Jaminan : <?php echo MyFormatter::formatNumberForPrint($suba, 2); ?></td>
        <?php }else{ ?>

        <?php }?>
    </tr>
    <tr style="height: 100px; border:1px solid;">
        <td>
            Jenis Penjamin
        </td>
        <td>
            <?php //if(!empty($tindakan->uangditerima)){?>
            <p><?php echo "Tunai" .":".MyFormatter::formatNumberForPrint($tandabukti->uangditerima - $tandabukti->uangkembalian);?>
            </p>
            <?php //}else{?>

            <?php //}?>
            <?php if($totalcredit != 0){?>
            <p> <?php echo "Credit Card "." ".$bankcredit." ".MyFormatter::formatNumberForPrint($totalcredit); ?></p>
            <?php }else{?>

            <?php }?>
            <?php if($totaldebit != 0){?>
            <p> <?php echo "Debit Card "." ".$bankdebit." ".MyFormatter::formatNumberForPrint($totaldebit); ?></p>
            <?php }else{?>

            <?php }?>
        </td>
    </tr>
</table>
<table width='100%'>
    <tr hidden>
        <td></td>
        <td align='center'>
            <?php echo Yii::app()->user->getState('kabupaten_nama') . ", " . $format->formatDateTimeId(date('Y-m-d')); ?>
        </td>
    </tr>
    <tr>
        <td align='center'>Penerima</td><br><br><br><br><br><br>
        <td align='center'>RS. Sari Asih Ciputat,</td></td><br><br><br><br><br><br>
    </tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
    <tr></tr>
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
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <p>- INVOICE INI BERLAKU SEBAGAI KWITANSI</p>
        </td>

    </tr>
</table>
