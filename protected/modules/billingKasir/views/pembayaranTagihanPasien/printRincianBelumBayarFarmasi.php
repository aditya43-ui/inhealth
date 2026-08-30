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
    
    .tab_detail {
        width: 100%;
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
    
    .tab_detail th {
        font-weight: bold;
    }
    
    .tab_detail th, .tab_detail td {
        border-left: 1px solid black;
        border-right: 1px solid black;
        
        padding: 2px;
    }
    
    .tab_detail tr:last-child td {
        border-bottom: 1px solid black;
    }
    
    .tab_penjualan {
        width: 100%;
    }
    
    .tab_penjualan td {
        font-weight: bold;
    }
    
    .tab_header {
        margin-bottom: 10px;
    }
    
    .tab_header td {
        padding: 2px;
        font-weight: bold;
    }
    
    .num {
        text-align: right;
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

$diskon = 0;
$suba = 0;
$subp = 0;
$subr = 0;
$subtotalkotor = 0;
$subtotal = 0;



?>

<h3 style="text-align: center; margin-bottom: 20px;">
    BUKTI PENJUALAN OBAT RAWAT INAP<br/>
    <?php echo $modPembayaran->nopembayaran; ?>
    <?php // echo !empty($admisi) ? 'RINCIAN BIAYA PERAWATAN' : 'REKAP RINCIAN BEAYA PENGOBATAN DAN PERAWATAN';?>
</h3>



<?php

$gtotal = 0;

foreach ($modPenjualan as $item):
    $cr = new CDbCriteria();
    $cr->join = 'join oasudahbayar_t sb on sb.oasudahbayar_id = t.oasudahbayar_id '
        . 'join obatalkes_m o on o.obatalkes_id = t.obatalkes_id';
    $cr->compare('t.penjualanresep_id', $item->penjualanresep_id);
    $cr->compare('sb.pembayaranpelayanan_id', $modPembayaran->pembayaranpelayanan_id);
    $cr->order = 'o.obatalkes_nama';
    
    
    $oa = ObatalkespasienT::model()->findAll($cr);
    if (count((array)$oa) == 0) continue;
    
    foreach ($oa as $item2) {
        $gtotal += $item2->qty_oa * $item2->hargasatuan_oa;
    }
    
    
    
    
endforeach;

?>


<table class="tab_header">
    <tr>
        <td>Telah Diterima Dari</td>
        <td>:</td>
        <td><?php echo $pasien->namadepan.$pasien->nama_pasien." / ".$pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>Uang Sebesar</td>
        <td>:</td>
        <td><?php echo MyFormatter::formatNumberForPrint($gtotal); ?></td>
    </tr>
</table>



<?php /* echo $this->renderPartial('_headerSudahBayarFarmasi', array(
    'modPembayaran'=>$modPembayaran,
    'modPendaftaran'=>$modPendaftaran,
    'admisi'=>$admisi,
    'grand_totals'=>$grand_totals,
    'subtotalkotor'=>$subtotalkotor,
    'pasien'=>$pasien,
    'masukkamar'=>$masukkamar,
    'asuransi'=>$asuransi,
), true);  */ ?>


<?php 
$modRetur = array();
foreach ($modPenjualan as $item): 
    $unit = "";
/*
    $kelas2 = $modPendaftaran->kelaspelayanan_id;
    if (!empty($admisi) && strtotime($item->tglpenjualan) > strtotime($admisi->tgladmisi)) {
        $kelas2 = $admisi->kelaspelayanan_id;
    }
 * 
 */
    $kelas2 = "";
    $modKelas = KelaspelayananM::model()->findByPk($kelas2);
    $unit = ""; //$modKelas->kelaspelayanan_nama;
    
    $reseptur = ResepturT::model()->findByAttributes(array(
        'penjualanresep_id' => $item->penjualanresep_id
    ));
    
    if (!empty($reseptur)) {
        $ruangan = RuanganM::model()->findByPk($reseptur->ruanganreseptur_id);
        if ($ruangan->instalasi_id != Params::INSTALASI_ID_RI) {
            $unit = $ruangan->ruangan_nama;
        } else {
            $kelas2 = $modPendaftaran->kelaspelayanan_id;
            if (!empty($admisi) && strtotime($item->tglpenjualan) > strtotime($admisi->tgladmisi)) {
                $kelas2 = $admisi->kelaspelayanan_id;
            }
            
            $modKelas = KelaspelayananM::model()->findByPk($kelas2);
            $unit = $modKelas->kelaspelayanan_nama;
        }
    } else {
        $unit = $modPendaftaran->ruangan->ruangan_nama;
        if (!empty($admisi) && strtotime($item->tglpenjualan) > strtotime($admisi->tgladmisi)) {
            $kelas2 = $admisi->kelaspelayanan_id;
            
            $modKelas = KelaspelayananM::model()->findByPk($kelas2);
            $unit = $modKelas->kelaspelayanan_nama;
        }
    }
    
    
    
    
    $cr = new CDbCriteria();
    $cr->join = 'join oasudahbayar_t sb on sb.oasudahbayar_id = t.oasudahbayar_id '
        . 'join obatalkes_m o on o.obatalkes_id = t.obatalkes_id';
    $cr->compare('t.penjualanresep_id', $item->penjualanresep_id);
    $cr->compare('sb.pembayaranpelayanan_id', $modPembayaran->pembayaranpelayanan_id);
    $cr->order = 'o.obatalkes_nama';
    
    
    
    $oa = ObatalkespasienT::model()->findAll($cr);
    
    if (count((array)$oa) == 0) continue;
    
    $retur = ReturresepT::model()->findAllByAttributes(array(
        'penjualanresep_id'=>$item->penjualanresep_id,
    ));
    
    if (count((array)$retur) > 0) {
        $modRetur = array_merge($modRetur, $retur);
    }
    
    
    ?>
<table class="tab_penjualan">
    <tr>
        <td><?php echo "Tgl. Transaksi : ".MyFormatter::formatDateTimeForUser($item->tglpenjualan); ?></td>
        <td style="text-align: right;"><?php echo "Penjualan Obat No. : ".$item->noresep; ?></td>
    </tr>
    <tr>
        <td>Unit : <?php echo $unit; ?></td>
    </tr>
</table>
<table class="tab_detail">
    <thead>
        <tr>
            <th width="40">No</th>
            <th>Nama Obat</th>
            <th width="50">Kode</th>
            <th width="50">Jml</th>
            <th width="70">Satuan</th>
            <th width="100">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $cnt = 1;
        $units = false;
        $kelas = KelaspelayananM::model()->findByPk($item->kelaspelayanan_id);  
        $total = 0;
        foreach ($oa as $item2): 
            $ret = ReturresepdetT::model()->findAllByAttributes(array(
                'obatalkespasien_id'=>$item2->obatalkespasien_id,
            ));
            
            foreach ($ret as $itemRet) {
                $item2->qty_oa += $itemRet->qty_retur;
            }
            
            $item2->hargajual_oa = $item2->qty_oa * $item2->hargasatuan_oa;
            
            $obatalkes = ObatalkesM::model()->findByPk($item2->obatalkes_id);
            $satuan = SatuankecilM::model()->findByPk($item2->satuankecil_id);
            
            $total += $item2->hargajual_oa;
            
            ?>
        <tr>
            <td class="num"><?php echo $cnt++; ?></td>
            <td><?php echo $obatalkes->obatalkes_nama; ?></td>
            <td><?php echo $obatalkes->obatalkes_kode; ?></td>
            <td class="num"><?php echo $item2->qty_oa; ?></td>
            <td style="text-align: center;"><?php echo $satuan->satuankecil_nama; ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($item2->hargajual_oa); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Total</td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
        </tr>
    </tfoot>
</table>
<br/>


<?php endforeach; ?>

<?php foreach ($modRetur as $item): 
    $cr = new CDbCriteria();
    $cr->join = 'join obatalkespasien_t oa on oa.obatalkespasien_id = t.obatalkespasien_id '
        . 'join obatalkes_m o on o.obatalkes_id = oa.obatalkes_id '
        . 'join oasudahbayar_t sb on sb.oasudahbayar_id = oa.oasudahbayar_id';
    $cr->compare('t.returresep_id', $item->returresep_id);
    $cr->compare('sb.pembayaranpelayanan_id', $modPembayaran->pembayaranpelayanan_id);
    $cr->order = 'o.obatalkes_nama';
    
    $det = ReturresepdetT::model()->findAll($cr);
    $jual = PenjualanresepT::model()->findByPk($item->penjualanresep_id);
    
    $reseptur = ResepturT::model()->findByAttributes(array(
        'penjualanresep_id' => $jual->penjualanresep_id
    ));
    
    if (!empty($reseptur)) {
        $ruangan = RuanganM::model()->findByPk($reseptur->ruanganreseptur_id);
        if ($ruangan->instalasi_id != Params::INSTALASI_ID_RI) {
            $unit = $ruangan->ruangan_nama;
        } else {
            $kelas2 = $modPendaftaran->kelaspelayanan_id;
            if (!empty($admisi) && strtotime($jual->tglpenjualan) > strtotime($admisi->tgladmisi)) {
                $kelas2 = $admisi->kelaspelayanan_id;
            }
            
            $modKelas = KelaspelayananM::model()->findByPk($kelas2);
            $unit = $modKelas->kelaspelayanan_nama;
        }
    } else {
        $unit = $modPendaftaran->ruangan->ruangan_nama;
        if (!empty($admisi) && strtotime($jual->tglpenjualan) > strtotime($admisi->tgladmisi)) {
            $kelas2 = $admisi->kelaspelayanan_id;
            
            $modKelas = KelaspelayananM::model()->findByPk($kelas2);
            $unit = $modKelas->kelaspelayanan_nama;
        }
    }
    
    ?>

<table class="tab_penjualan">
    <tr>
        <td><?php echo "Tgl. Transaksi : ".MyFormatter::formatDateTimeForUser($item->tglretur); ?></td>
        <td style="text-align: right;"><?php echo "Retur Obat No. : ".$item->noreturresep; ?></td>
    </tr>
    <tr>
        <td>Unit : <?php echo $modKelas->kelaspelayanan_nama; ?></td>
    </tr>
</table>

<table class="tab_detail">
    <thead>
        <tr>
            <th width="40">No</th>
            <th>Nama Obat</th>
            <th width="50">Kode</th>
            <th width="50">Jml</th>
            <th width="70">Satuan</th>
            <th width="100">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $cnt = 1;
        $total = 0;
        foreach ($det as $item2): 
            
            $oa = ObatalkespasienT::model()->findByPk($item2->obatalkespasien_id);
            $obatalkes = ObatalkesM::model()->findByPk($oa->obatalkes_id);
            $satuan = SatuankecilM::model()->findByPk($oa->satuankecil_id);
            $total += $item2->qty_retur * $item2->hargasatuan;
            ?>
        <tr>
            <td class="num"><?php echo $cnt++; ?></td>
            <td><?php echo $obatalkes->obatalkes_nama ?></td>
            <td><?php echo $satuan->satuankecil_nama; ?></td>
            <td class="num"><?php echo $item2->qty_retur; ?></td>
            <td style="text-align: center;"><?php echo $satuan->satuankecil_nama; ?></td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($item2->qty_retur * $item2->hargasatuan); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Total</td>
            <td class="num"><?php echo MyFormatter::formatNumberForPrint($total); ?></td>
        </tr>
    </tfoot>
</table>
<br/>

<?php endforeach; ?>



<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianSudahBayarFarmasi", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}else{
?>    
    <table width='100%'>
        <tr>
            <td width="100%"></td>
            <td></td>
            <td align='center'><?php // echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td align='center'><?php // echo $modProfilRs->nama_rumahsakit; ?></td>
        </tr>
        <tr>
            <td align='center'></td>
            <td align='center'></td>
            <td align='center' nowrap>Dibuat Oleh</td>
        </tr>
        <tr height='100px'>
            <td align='center'>&nbsp;</td>
            <td align='center'></td>
            <td align='center' nowrap>__________________</td>
        </tr>
    </table>
<?php
}
?>

