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

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

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

$grp = CJSON::decode($this->renderPartial('_templateAsuransi', array('grp' => &$grp), true));

$diskon = 0;
$suba = 0;
$subp = 0;
$subr = 0;
$subtotalkotor = 0;
$subtotal = 0;


// var_dump($grp); 


$sisa = array();
// var_dump($tandabukti->attributes); die;

foreach ($modRincians as $item) {
    
    
    
    $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
    $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    
    $unit_name = $item->getNamaUnitGrupRincian($modPendaftaran, $admisi);
    
    /*
    if (empty($grp[$unit_name])) {
        $grp[$unit_name] = array(
            'nama'=>$unit_name,
            'content'=>array(),
        );
    }
     * 
     */
    
    
    
    
    
    if ($item->qty_tindakan * $item->tarif_satuan == 0) continue;
    
    $diskon += $item->discount_tindakan;
    
    
    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;
    
    $itemsubtotal = ($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
    
    $subtotalkotor += ($item->qty_tindakan * $item->tarif_satuan) - $item->discount_tindakan;
    $subtotal += ($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
    
    
    $nama_tindakan = $item->daftartindakan_nama;
    $tarif_daftar = $nama_tindakan.".".$item->daftartindakan_id;
    $tarif_satuan = MyFormatter::formatNumberForPrint($item->tarif_satuan);
    
    
    
    $grand_totals = (($subtotalkotor + $tandabukti->biayaadministrasi + $tandabukti->biayamaterai - $modPembayaran->totaldiscount));
    // pendaftaran
    
    
    
    if (!$item->is_alkes) {
        
        $kode = $item->kodeJenisTindakan2;
        
        if (!empty($kode)) {
            if ($kode == "2.99") {
                $grp[14]['detail'][$kode]['value'] += $itemsubtotal;
            } else if ($kode == "1.99") {
                $grp[1]['value'] += $itemsubtotal;
            } else if ($item->instalasi_id == Params::INSTALASI_ID_RJ) {
                $sub_rj = 4;
                if ($item->ruangan_id != 23) { // klinik umum
                    $sub_rj = 2;
                }
                
                if (isset($grp[2]['detail'][$sub_rj]['detail'][$kode])) {
                    $grp[2]['detail'][$sub_rj]['detail'][$kode]['value'] += $itemsubtotal;
                } else {
                    $grp[11]['value'] += $itemsubtotal;
                    $sisa[] = $item;
                }
            } else if ($item->instalasi_id == Params::INSTALASI_ID_RD) {
                // var_dump($kode);
                if ($item->ruangan_id == Params::RUANGAN_ID_VERLOS_KAMER) {
                    if (isset($grp[13]['detail'][$kode])) {
                        $grp[13]['detail'][$kode]['value'] += $itemsubtotal;
                    } else {
                        $grp[11]['value'] += $itemsubtotal;
                        $sisa[] = $item;
                    }
                } else if (isset($grp[2]['detail'][3]['detail'][$kode])) {
                    $grp[2]['detail'][3]['detail'][$kode]['value'] += $itemsubtotal;
                } else {
                    $grp[11]['value'] += $itemsubtotal;
                    $sisa[] = $item;
                }
            } else if ($item->instalasi_id == Params::INSTALASI_ID_RI) {
                
                if ($item->ruangan_id == Params::RUANGAN_ID_BERSALIN) {
                    if (isset($grp[13]['detail'][$kode])) {
                        $grp[13]['detail'][$kode]['value'] += $itemsubtotal;
                    } else {
                        $grp[11]['value'] += $itemsubtotal;
                        $sisa[] = $item;
                    } 
                } else if (isset($grp[6]['detail'][$kode])) {
                    $grp[6]['detail'][$kode]['value'] += $itemsubtotal;
                    if (isset($grp[6]['detail'][$kode]['qty'])) {
                        $grp[6]['detail'][$kode]['qty'] += $item->qty_tindakan;
                    }
                } else if (isset($grp[12]['detail'][$kode])) {
                    $grp[12]['detail'][$kode]['value'] += $itemsubtotal;
                } else if (isset($grp[5]['detail'][$kode])) {
                    $grp[5]['detail'][$kode]['value'] += $itemsubtotal;
                    if (isset($grp[5]['detail'][$kode]['qty']))
                        $grp[5]['detail'][$kode]['qty'] += $item->qty_tindakan;
                } else {
                    $grp[11]['value'] += $itemsubtotal;
                    $sisa[] = $item;
                } 
                
            } else if ($item->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
                $det = DetailhasilpemeriksaanlabT::model()->findByAttributes(array(
                    'tindakanpelayanan_id'=>$item->tindakanpelayanan_id,
                ));
                $periksa = PemeriksaanlabM::model()->findByPk($det->pemeriksaanlab_id);
                $jenis = JenispemeriksaanlabM::model()->findByPk($periksa->jenispemeriksaanlab_id);

                if (trim(strtolower($jenis->jenispemeriksaanlab_kelompok)) == 'patologi klinik') {
                    $jenis->jenispemeriksaanlab_kelompok = 'LABORATORIUM KLINIK';
                }
                
                if (isset($grp[4]['detail']['4.'.$jenis->jenispemeriksaanlab_kelompok]['value'])) {
                    $grp[4]['detail']['4.'.$jenis->jenispemeriksaanlab_kelompok]['value'] += $itemsubtotal;
                } else if (isset($grp[4]['detail'][$kode]['value'])) {
                    $grp[4]['detail'][$kode]['value'] += $itemsubtotal;
                } else {
                    $grp[11]['value'] += $itemsubtotal;
                    $sisa[] = $item;
                }
            } else if ($item->ruangan_id == Params::RUANGAN_ID_RAD) { 
                $det = HasilpemeriksaanradT::model()->findByAttributes(array(
                    'tindakanpelayanan_id'=>$item->tindakanpelayanan_id,
                ));
                $periksa = PemeriksaanradM::model()->findByPk($det->pemeriksaanrad_id);

                // var_dump($periksa->attributes);
                
                if (isset($grp["4.1"]['detail']['5.'.$periksa->jenispemeriksaanrad_id]['value'])) {
                    $grp["4.1"]['detail']['5.'.$periksa->jenispemeriksaanrad_id]['value'] += $itemsubtotal;
                } else {
                    $grp[11]['value'] += $itemsubtotal;
                    $sisa[] = $item;
                }
            } else if ($item->ruangan_id == Params::RUANGAN_ID_BEDAH) {
            
            
                $komponen = TindakankomponenT::model()->findAllByAttributes(array(
                    'tindakanpelayanan_id'=>$item->tindakanpelayanan_id,
                ));
                $kom_tot = 0;
                $kom_tarif = $item->tarif_satuan * $item->qty_tindakan;
                $kom_diskon = $item->discount_tindakan / $kom_tarif;
                $kom_sisa = ($kom_tarif - $item->discount_tindakan) / $kom_tarif;

                foreach ($komponen as $itemkom) {
                    $kom_tot += $itemkom->tarif_tindakankomp;
                }

                foreach ($komponen as $itemkom) {
                    $subtotal = round(($itemkom->tarif_tindakankomp * $kom_tarif / $kom_tot) * $kom_sisa);
                    
                    if (in_array($itemkom->komponentarif_id, array(30, 28))) {
                        $grp[3]['detail']['3.1']['value'] += $subtotal;
                    } else if (in_array($itemkom->komponentarif_id, array(12, 53))) {
                        $grp[3]['detail']['3.2']['value'] += $subtotal;
                    } else if (in_array($itemkom->komponentarif_id, array(1, 13, 23, 60, 58, 59, 56, 55, 54, 61))) {
                        $grp[3]['detail']['3.3']['value'] += $subtotal;
                    } else {
                        $grp[11]['value'] += $subtotal;
                    }
                }
            } else if ($item->ruangan_id == Params::RUANGAN_ID_VERLOS_KAMER) {
                if (isset($grp[13]['detail'][$kode])) {
                    $grp[13]['detail'][$kode]['value'] += $itemsubtotal;
                } else {
                    $grp[11]['value'] += $itemsubtotal;
                    $sisa[] = $item;
                }
            } else if ($item->ruangan_id == Params::RUANGAN_ID_GIZI) {
                if (isset($grp[6]['detail'][$kode])) {
                    $grp[6]['detail'][$kode]['value'] += $itemsubtotal;
                } else {
                    $grp[11]['value'] += $itemsubtotal;
                    $sisa[] = $item;
                }
            } else {
                $grp[11]['value'] += $itemsubtotal;
                $sisa[] = $item;
            }
        } else {
            $grp[11]['value'] += $itemsubtotal;
            $sisa[] = $item;
        }
        
        
    } else {
        $oa = ObatalkesM::model()->findByPk($item->daftartindakan_id);
        
        if (isset($grp[14]['detail']['2.'.$oa->jenisobatalkes_id]))
            $grp[14]['detail']['2.'.$oa->jenisobatalkes_id]['value'] += $itemsubtotal;
        else {
            $grp[11]['value'] += $itemsubtotal;
            $sisa[] = $item;
        }
            // } else {
            //    if (isset($grp[2]['detail'][$modPendaftaran->instalasi_id]['detail']['2.'.$oa->jenisobatalkes_id]))
            //        $grp[2]['detail'][$modPendaftaran->instalasi_id]['detail']['2.'.$oa->jenisobatalkes_id]['value'] += $itemsubtotal;
            //    else {
            //        $grp[11]['value'] += $itemsubtotal;
            //        $sisa[] = $item;
            //    }
            // }
        
    }
}

$grp[10]['value'] = $tandabukti->biayaadministrasi;


// if (empty($admisi)) {
    // cleanup
    foreach ($grp as $idx => $item) {
        if (isset($item['detail'])) {
            foreach ($item['detail'] as $idx2 => $item2) {
                if (isset($item2['detail'])) {
                    foreach ($item2['detail'] as $idx3 => $item3) {
                        if ($item3['value'] == 0) unset($grp[$idx]['detail'][$idx2]['detail'][$idx3]);
                    } 
                } else {
                    if (isset($item2['value']) && $item2['value'] == 0)
                        unset($grp[$idx]['detail'][$idx2]);
                }
                
                
            }
        } else {
            if (isset($item['value']) && $item['value'] == 0)
                unset($grp[$idx]);
        }
    }
    
    foreach ($grp as $idx => $item) {
        if (isset($item['detail'])) {
            if (count((array)$item['detail']) == 0)
                unset ($grp[$idx]);
            else {
                foreach ($item['detail'] as $idx2 => $item2) {
                    if (isset($item2['detail'])) {
                         if (count((array)$item2['detail']) == 0)
                            unset ($grp[$idx]['detail'][$idx2]);
                    }
                }
            }
        }
    }
// }

/*
if (count((array)$sisa) > 0) {
    foreach ($sisa as $item) {
        var_dump($item->daftartindakan_nama, $item->instalasi_nama, $item->ruangan_nama);
    }
    die;
}
 * 
 */
//     die;

?>

<h3 style="text-align: center;">
    RINCIAN BIAYA PERAWATAN
    <?php // echo !empty($admisi) ? 'RINCIAN BIAYA PERAWATAN' : 'REKAP RINCIAN BEAYA PENGOBATAN DAN PERAWATAN';?>
</h3>

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
        <th style='text-align: center;' colspan='2'>GRUP TINDAKAN DAN LAYANAN</th>
        <th style='text-align: center;'>SUBTOTAL</th>
    </thead>
    <tbody>
        <?php foreach ($grp as $item) : 
            
            //  var_dump($item['value']); die;
            ?>
        <tr>
            <?php if (!isset($item['detail'])): ?>
                <td><strong><?php echo $item['name']; ?></strong></td>
                <td></td>
                <td style="text-align: right;"><strong><?php echo $item['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($item['value']); ?></strong></td>
            <?php else: ?>
                <td colspan="3"><strong><?php echo $item['name']; ?></strong></td>
            <?php endif; ?>
        </tr>
        <?php if (isset($item['detail'])) {
            foreach ($item['detail'] as $item2): ?>
        <tr>
            <?php if (!isset($item2['detail'])): ?>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php 
                echo $item2['name']; 
            ?>
            </td>
            <td>
            <?php
                if (isset($item2['qty']) && $item2['qty'] != 0) {
                    $values = round($item2['value'] / $item2['qty']);

                    echo " ".$item2['qty']." ".$item2['satuan']." @ ".MyFormatter::formatNumberForPrint($values);
                }
            ?>
            </td>
                <td style="text-align: right;"><strong><?php echo $item2['value'] == 0 ? '-' : MyFormatter::formatNumberForPrint($item2['value']); ?></strong></td>
            <?php else: ?>
                <td colspan="3">&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $item2['name']; ?></strong></td>
            <?php endif; ?>
        </tr>
        
        <?php if (isset($item2['detail'])) {
            foreach ($item2['detail'] as $item3) : ?>
        <tr>
            <?php if (!isset($item3['detail'])): ?>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $item3['name']; ?></td>
            <td></td>
                <td style="text-align: right;"><strong><?php echo $item3['value'] == 0 ? '-' :  MyFormatter::formatNumberForPrint($item3['value']); ?></strong></td>
            <?php else: ?>
                <td colspan="4"><strong><?php echo $item3['name']; ?></strong></td>
            <?php endif; ?>
        </tr>
        <?php endforeach;
        } ?>
        
        
        <?php endforeach;
        } ?>
        <?php endforeach; ?>
    
        <tr style="border-top:1px solid #333;" class="closing footee">
            <td colspan="2">JUMLAH</td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($diskon); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($suba); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
            <td style="text-align: right;" class="hddn"><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotalkotor + $tandabukti->biayaadministrasi); ?></td>
        </tr>
        <?php
        
        
        
        $modSubsidi = SubsidikelasT::model()->findAllByAttributes(array(
            'pembayaranpelayanan_id'=>$modPembayaran->pembayaranpelayanan_id,
        ));
        
        $kelas_master = array(
            Params::KELASPELAYANAN_ID_KELAS_III => 1,
            Params::KELASPELAYANAN_ID_KELAS_II => 2,
            Params::KELASPELAYANAN_ID_KELAS_I => 3
        );
        
        // var_dump($kelas); die;
        
        $bkelas = array();
        
        if (count((array)$modSubsidi) > 0) {
            $suba = 0;
            $modPembayaran->totalsubsidiasuransi = 0;
            
            
            
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
            }
            
            // var_dump($bkelas); die;
            ksort($bkelas);
                
                
            foreach ($bkelas as $item) {
                $suba += $item['value'];
                $modPembayaran->totalsubsidiasuransi += $item['value'];
                $kelas = KelaspelayananM::model()->findByPk($item['kelas']);
        ?>
        <tr class="closing footee">
            <td colspan="2">INA <?php echo $kelas->kelaspelayanan_nama; ?></td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($item['value']); ?></td>
        </tr>
        <?php } 
        
        // var_dump($bkelas, $kelas_master); die;
        
        ?>
        <?php // if ($suba < ($subtotalkotor + $tandabukti->biayaadministrasi)) { ?>
        <tr class="closing footee">
            <td colspan="2">Ekses</td>
            <td style="text-align: right;"><?php 
            
            $ekses = 0;
            $bcount = count((array)$bkelas);
            
            
            
            
            if ($bcount != 0) {
                if ($bcount == 1) {
                    if (empty($bkelas[0])) {
                        $ekses = ($subtotalkotor + $tandabukti->biayaadministrasi) - $bkelas[1]['value'];
                    } else {
                        $ekses = ($subtotalkotor + $tandabukti->biayaadministrasi) - $bkelas[0]['value'];
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
            
            echo MyFormatter::formatNumberForPrint($ekses); ?></td>
        </tr>
        <?php 
        
        //    }
        } else {
        
        ?>
            <?php if ($modPembayaran->totaldiscount != 0): ?>
            <tr class="footee">
                <td colspan="2">Potongan</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totaldiscount); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if ($modPembayaran->totalsubsidiasuransi != 0 && !empty($admisi)): ?>
            <tr class="closing footee">
                <td colspan="2">Dijamin Asuransi</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modPembayaran->totalsubsidiasuransi); ?></td>
            </tr>
            <?php endif; ?>
            <?php if ($subp > 0): ?>
            <tr class="closing footee">
                <td colspan="2">Dijamin Pemerintah</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
            </tr>
            <?php endif; ?>
            <?php if ($subr > 0): ?>
            <tr class="closing footee">
                <td colspan="2">Dijamin RS</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
            </tr>
            <?php endif; ?>
            <?php 
            if (($grand_totals - ($modPembayaran->totalsubsidiasuransi + $subp + $subr)) > 0 && $modPembayaran->penjamin_id != Params::PENJAMIN_ID_UMUM && !empty($admisi)): ?>
            <tr class="closing footee">
                <td colspan="2">Dibayar Oleh Pasien</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals - ($modPembayaran->totalsubsidiasuransi + $subp + $subr)); ?></td>
            </tr>
            <?php 
            
            endif; ?>
            
            <?php if ($modPembayaran->penjamin_id == Params::PENJAMIN_ID_UMUM) : ?>
            <tr class="grand_total footee">
                <td colspan="2">TOTAL</td><td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($grand_totals); ?></td>
            </tr>
            <?php endif; ?>
        <?php } ?>
    </tbody>
    
</table>
<br/><br/>


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
            <td></td>
            <td></td>
            <td align='center'><?php echo $modProfilRs->nama_rumahsakit; ?></td>
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

