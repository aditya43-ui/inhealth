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
    
    .tab_detail .grand_total td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
    
    .tab_detail .closing td {
        border-bottom: 1px solid black;
    }
    
    .hddn {
        display: none;
    }
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}

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

// var_dump($masukkamar->attributes); die;


$grp = array();

$diskon = 0;
$suba = 0;
$subp = 0;
$subr = 0;
$subtotalkotor = 0;
$subtotal = 0;




// var_dump($tandabukti->attributes); die;

foreach ($modRincians as $item) {
    
    
    $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
    $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    
    $unit_name = $item->getNamaUnitGrupRincian($modPendaftaran, $admisi);
    
    if (empty($grp[$unit_name])) {
        $grp[$unit_name] = array(
            'nama'=>$unit_name,
            'content'=>array(),
        );
    }
    
    if ($item->qty_tindakan * $item->tarif_satuan == 0) continue;
    
    $diskon += $item->discount_tindakan;
    
    
    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;
    
    
    $item->tarif_satuan = round($item->tarif_satuan);
    
    $subtotalkotor += round($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
    $subtotal += round($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
    
    
    $nama_tindakan = $item->daftartindakan_nama;
    $tarif_daftar = $nama_tindakan.".".$item->daftartindakan_id;
    $tarif_satuan = MyFormatter::formatNumberForPrint($item->tarif_satuan);
    
    
    
    if ($item->is_alkes) {
        // if ($modPendaftaran->penjamin_id != Params::PENJAMIN_ID_UMUM) {
        $nama_tindakan = "OA Lain-lain";
        $tarif_daftar = "OA.DLL";
        $tarif_satuan = "";
        $oa = ObatalkesM::model()->findByPk($item->daftartindakan_id);
        if (!empty($oa->jenisobatalkes_id)) {
            $jenis = JenisobatalkesM::model()->findByPk($oa->jenisobatalkes_id);
            $nama_tindakan = "Pemakaian ".$jenis->jenisobatalkes_nama;
            $tarif_daftar = "OA.".$nama_tindakan;
        }
        // }
    } else {
    
        
        $daftartindakan = DaftartindakanM::model()->findByPk($item->daftartindakan_id);
        // var_dump($daftartindakan->attributes);
        if ($daftartindakan->daftartindakan_konsul) {
            $nama_tindakan = "Konsultasi Dokter Spesialis";
            $tarif_daftar = "DFT.".$nama_tindakan;
        } else if ($daftartindakan->daftartindakan_tindakan) {
            $nama_tindakan = "Tindakan Paramedis";
            $tarif_daftar = "DFT.".$nama_tindakan;
        } else if ($daftartindakan->daftartindakan_akomodasi) {
            $nama_tindakan = "Pemakaian kamar";
            $tarif_daftar = "DFT.".$nama_tindakan;
        } else if ($daftartindakan->daftartindakan_visite) {
            // $nama_tindakan = "Visite";
            // $tarif_daftar = "DFT.".$nama_tindakan;
        } else if ($daftartindakan->daftartindakan_periksa) {
            $nama_tindakan = "Pemeriksaan";
            $tarif_daftar = "DFT.".$nama_tindakan;
        } else if ($daftartindakan->daftartindakan_karcis) {
            $nama_tindakan = "Pendaftaran";
            $tarif_daftar = "DFT.".$nama_tindakan;
        }


        if ($item->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
            $periksa = PemeriksaanlabtindV::model()->findByAttributes(array(
                'daftartindakan_id'=>$item->daftartindakan_id,
            ));
            $nama_tindakan = $periksa->jenispemeriksaanlab_nama;
            $tarif_daftar = "LAB.".$nama_tindakan;
            $tarif_satuan = "";
        }

        if ($item->ruangan_id == Params::RUANGAN_ID_RAD) {
            $periksa = PemeriksaanradM::model()->findByAttributes(array(
                'daftartindakan_id'=>$item->daftartindakan_id,
            ));
            $jenis = JenispemeriksaanradM::model()->findByPk($periksa->jenispemeriksaanrad_id);
            $nama_tindakan = $jenis->jenispemeriksaanrad_nama;
            $tarif_daftar = "RAD.".$nama_tindakan;
            $tarif_satuan = "";
        }
    
    }
    
    if ($item->ruangan_id == Params::RUANGAN_ID_BEDAH && !$item->is_alkes) {
        // $uraian = $grp[$unit_name]['content'][$tarif_daftar]['uraian'];
        $tindakan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
        $rencana = RencanaoperasiT::model()->findByAttributes(array(
            'tindakanpelayanan_id'=>$item->tindakanpelayanan_id,
        ));
        
        $kamarruangan = KamarruanganM::model()->findByPk($rencana->kamarruangan_id);
        $komponen = TindakankomponenT::model()->findAllByAttributes(array(
            'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id
        ));
        
        $unit_name = "Bedah Sentral - ".$kamarruangan->kamarruangan_nokamar;
        
        if (empty($grp[$unit_name])) {
            $grp[$unit_name] = array(
                'nama'=>$unit_name,
                'content'=>array(),
            );
        }
        
        $kom_tarif = $item->tarif_satuan * $item->qty_tindakan;
        $kom_diskon = $item->discount_tindakan / $kom_tarif;
        $kom_sisa = ($kom_tarif - $item->discount_tindakan) / $kom_tarif;
        
        
        $kom_tot = 0;
        foreach ($komponen as $itemkom) {
            $kom_tot += $itemkom->tarif_tindakankomp;
        }
        
        foreach ($komponen as $itemkom) {
            $tarif_daftar = "KOM.".$itemkom->komponentarif_id;
            $kom = KomponentarifM::model()->findByPk($itemkom->komponentarif_id);
            
            
            
            if (empty($grp[$unit_name]['content'][$tarif_daftar])) {
                $grp[$unit_name]['content'][$tarif_daftar] = array(
                    'uraian'=>$kom->komponentarif_nama,
                    'jml'=>"",
                    'harga'=> "",
                    'diskon'=>0,
                    'suba'=>0,
                    'subp'=>0,
                    'subr'=>0,
                    'subtotal'=>0,
                    'subtotalkotor'=>0,
                    'detail'=>array()
                );
            }
            
            $detail = $grp[$unit_name]['content'][$tarif_daftar];
            
            // var_dump($itemkom->attributes);
            
            
            $subtotal = $itemkom->tarif_tindakankomp - ($itemkom->subsidiasuransikomp + $itemkom->subsidipemerintahkomp + $itemkom->subsidirumahsakitkomp);
            
            
            $detail['diskon'] += round(($itemkom->tarif_tindakankomp * $kom_tarif / $kom_tot) * $kom_diskon);
            $detail['suba'] += ($itemkom->subsidiasuransikomp * $kom_tarif / $kom_tot); //$itemkom->subsidiasuransikomp;
            $detail['subp'] += ($itemkom->subsidipemerintahkomp * $kom_tarif / $kom_tot); //$itemkom->subsidipemerintahkomp;
            $detail['subr'] += ($itemkom->subsidirumahsakitkomp * $kom_tarif / $kom_tot); //$itemkom->subsidirumahsakitkomp;
            $detail['subtotal'] += $subtotal;
            $detail['subtotalkotor'] += round(($itemkom->tarif_tindakankomp * $kom_tarif / $kom_tot) * $kom_sisa);
            
            
            $grp[$unit_name]['content'][$tarif_daftar] = $detail;
        }
        
        
    } else {
    
        if (empty($grp[$unit_name]['content'][$tarif_daftar])) {
            $grp[$unit_name]['content'][$tarif_daftar] = array(
                'uraian'=>$nama_tindakan,
                'jml'=>0,
                'harga'=> $tarif_satuan,
                'diskon'=>0,
                'suba'=>0,
                'subp'=>0,
                'subr'=>0,
                'subtotal'=>0,
                'subtotalkotor'=>0,
                'detail'=>array(),
            );
        }
    
        $grp[$unit_name]['content'][$tarif_daftar]['jml'] += $item->qty_tindakan;
        $grp[$unit_name]['content'][$tarif_daftar]['diskon'] += $item->discount_tindakan;
        $grp[$unit_name]['content'][$tarif_daftar]['suba'] += $item->subsidiasuransi_tindakan;
        $grp[$unit_name]['content'][$tarif_daftar]['subp'] += $item->subsidipemerintah_tindakan;
        $grp[$unit_name]['content'][$tarif_daftar]['subr'] += $item->subsisidirumahsakit_tindakan;
        $grp[$unit_name]['content'][$tarif_daftar]['subtotal'] += ($item->qty_tindakan * $item->tarif_satuan) - ($item->discount_tindakan + $item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
        $grp[$unit_name]['content'][$tarif_daftar]['subtotalkotor'] += ($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
    }
    
    
    $grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
}

$subr = $modPembayaran->totalsubsidirs;

// var_dump($grp); die;
// die;
?>

<h2 style="text-align: center;">RINCIAN BIAYA PERAWATAN</h2>

<?php echo $this->renderPartial('_headerSudahBayar', array(
    'modPembayaran'=>$modPembayaran,
    'modPendaftaran'=>$modPendaftaran,
    'admisi'=>$admisi,
    'grand_totals'=>$grand_totals,
    'subtotalkotor'=>$subtotalkotor,
    'pasien'=>$pasien,
    'masukkamar'=>$masukkamar,
    'asuransi'=>$asuransi,
), true); ?>

<br/>

<table width="100%" class="tab_detail">
    <thead style=''>
        <th style='text-align: center;'></th>
        <th style='text-align: center;'>Grup Tindakan</th>
        <!--th style='text-align: center;'>Dokter</th>
        <th style='text-align: center;'>Tgl Transaksi</th-->
        <th style='text-align: center;' class="hddn">Jml</th>
        <th style='text-align: center;' class="hddn">Harga</th>
        <th style='text-align: center;' class="hddn">Diskon</th>
        <th style='text-align: center;' class="hddn">Jaminan Asuransi</th>
        <th style='text-align: center;' class="hddn">Jaminan Pemerintah</th>
        <th style='text-align: center;' class="hddn">Jaminan RS</th>
        <th style='text-align: center;' class="hddn">Iur Biaya</th>
        <th style='text-align: center;'>Sub Total</th>
    </thead>
    <tbody>
        <?php foreach ($grp as $item) : 
            if (count((array)$item['content']) == 0) continue;
            ?>
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
                <!--td><?php 
                    // if ($item2['visite'] || $item2['konsul']) {
                        // echo $item2['dokter']; 
                    // }
                ?></td>
                <td><?php // echo $item2['tgl']; ?></td-->
                <td style="text-align: right;" class="hddn"><?php echo count((array)$item2['detail']) ? "" : $item2['jml']; ?></td>
                <td style="text-align: right;" class="hddn"><?php echo count((array)$item2['detail']) ? "" : $item2['harga']; ?></td>
                <td style="text-align: right;" class="hddn"><?php echo count((array)$item2['detail']) ? "" : MyFormatter::formatNumberForPrint($item2['diskon']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo count((array)$item2['detail']) ? "" : MyFormatter::formatNumberForPrint($item2['suba']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo count((array)$item2['detail']) ? "" : MyFormatter::formatNumberForPrint($item2['subp']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo count((array)$item2['detail']) ? "" : MyFormatter::formatNumberForPrint($item2['subr']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo count((array)$item2['detail']) ? "" : MyFormatter::formatNumberForPrint($item2['subtotal']); ?></td>
                <td style="text-align: right;"><?php echo count((array)$item2['detail']) ? "" : MyFormatter::formatNumberForPrint($item2['subtotalkotor']); ?></td>
                
            </tr>
                <?php foreach ($item2['detail'] as $detail): ?>
            <tr>
                <td></td>
                <td><?php echo $detail['uraian']; ?></td>
                <!--td><?php 
                    // if ($item2['visite'] || $item2['konsul']) {
                        // echo $item2['dokter']; 
                    // }
                ?></td>
                <td><?php // echo $item2['tgl']; ?></td-->
                <td style="text-align: right;" class="hddn"><?php // echo $detail['jml']; ?></td>
                <td style="text-align: right;" class="hddn"><?php // echo $detail['harga']; ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($detail['diskon']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($detail['suba']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($detail['subp']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($detail['subr']); ?></td>
                <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($detail['subtotal']); ?></td>
                <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($detail['subtotalkotor']); ?></td>
                
            </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <tr style="border-top:1px solid #333;" class="footee">
            <td colspan="2">Jumlah</td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($diskon); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($suba); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor); ?></td>
        </tr>
        <?php if ($tandabukti->biayaadministrasi != 0): ?>
        <tr class="footee">
            <td colspan="2">Biaya Administrasi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayaadministrasi); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($tandabukti->biayamaterai != 0): ?>
        <tr class="footee">
            <td colspan="2">Biaya Materai</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->biayamaterai); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($modPembayaran->totaldiscount != 0): ?>
        <tr class="footee">
            <td colspan="2">Potongan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
        </tr>
        <?php endif; ?>
        <?php /*if ($tandabukti->jmlpembulatan != 0): ?>
        <tr>
            <td colspan="9">Pembulatan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($tandabukti->jmlpembulatan); ?></td>
        </tr>
        <?php endif;  */ ?>
        <tr class="grand_total footee">
            <td colspan="2">Total</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
        </tr>
        <?php if ($suba != 0): ?>
        <tr class="footee">
            <td colspan="2">Jaminan Asuransi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($suba); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($subp != 0): ?>
        <tr class="footee">
            <td colspan="2">Jaminan Pemerintah</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
        </tr>
        <?php endif; ?>
        <?php if ($subr != 0): ?>
        <tr class="footee">
            <td colspan="2">Jaminan RS</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
        </tr>
        <?php endif; ?>
        <tr class="closing footee">
            <td colspan="2">Tanggungan Pasien</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals - ($suba + $subp + $subr)); ?></td>
        </tr>
    </tbody>
    
</table>
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
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayar", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
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
            <td align='center'>Pasien / Keluarga Pasien</td>
            <td align='center'></td>
            <td align='center'>Bagian Keuangan</td>
        </tr>
        <tr height='100px'>
            <td align='center'>__________________</td>
            <td align='center'></td>
            <td align='center'>__________________</td>
        </tr>
    </table>
<?php
}
?>

