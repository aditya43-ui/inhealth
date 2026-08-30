<style>
    th, td, div{
        font-family: Arial;
        font-size: 10pt;
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
    
    .rincian th, .rincian td {
        border: 1px solid black;
        background-color: white;
        color: black;
        padding: 5px;
    }
    
    .rincian tfoot td {
        font-weight: bold;
    }
</style>
<?php
$format = new MyFormatter;
echo $this->renderPartial('application.views.headerReport.headerRincian');
 
$pasien = $modPendaftaran->pasien;
$admisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
$asuransi = AsuransipasienM::model()->findByPk($modPendaftaran->asuransipasien_id);
$masukkamar = MasukkamarT::model()->findByAttributes(array(
    'pasienadmisi_id'=>$modPendaftaran->pasienadmisi_id,
), array(
    'order'=>'masukkamar_id desc',
));

// var_dump($masukkamar->attributes); die;

// var_dump($masukkamar->attributes, $modPendaftaran->attributes, $admisi->attributes); die;

?>
<table class="identitas" width="100%">
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
        <td>Umur / Tgl. Lahir</td><td>:</td><td nowrap><?php echo $modPendaftaran->umur." / ".MyFormatter::formatDateTimeForUser($pasien->tanggal_lahir); ?></td>
        <td>Ruangan</td><td>:</td><td nowrap><?php echo empty($modPendaftaran->pasienadmisi_id)?$modPendaftaran->ruangan->ruangan_nama:$admisi->ruangan->ruangan_nama; ?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>:</td><td nowrap><?php echo $pasien->alamat_pasien; ?></td>
        
        <?php if (!empty($modPendaftaran->pasienadmisi_id)): ?> 
        <td nowrap>Kamar / No. Bed</td><td>:</td><td nowrap><?php echo (empty($masukkamar) || empty($masukkamar->kamarruangan_id))?"-":($masukkamar->kamarruangan->kamarruangan_nokamar." / ".$masukkamar->kamarruangan->kamarruangan_nobed); ?></td>
        <?php endif; ?>
    </tr>
    <tr>
        <td>Dokter</td><td>:</td><td nowrap><?php echo $modPendaftaran->pegawai->namaLengkap; ?></td>
        <?php if (!empty($modPendaftaran->pasienadmisi_id)): ?> 
        <td>Dokter PJP</td><td>:</td><td nowrap><?php echo $admisi->pegawai->namaLengkap; ?></td>
        <?php endif; ?>
    </tr>
</table><br/>

<?php

$grp = array();

$suba = 0;
$subp = 0;
$subr = 0;
$subtotal = 0;

foreach ($modRincians as $item) {
    $dokter = PegawaiM::model()->findByPk($item->pegawai_id);
    $dokter = empty($dokter)?"-":$dokter->namaLengkap;
    
    if (empty($grp[$item->ruangan_id])) {
        $grp[$item->ruangan_id] = array(
            'nama'=>$item->ruangan_nama,
            'content'=>array(),
        );
    }
    
    
    $suba += $item->subsidiasuransi_tindakan;
    $subp += $item->subsidipemerintah_tindakan;
    $subr += $item->subsisidirumahsakit_tindakan;
    
    $subtotal += ($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan);
    
    array_push($grp[$item->ruangan_id]['content'], array(
        'uraian'=>$item->daftartindakan_nama,
        'dokter'=>$dokter,
        'tgl'=>  MyFormatter::formatDateTimeForUser($item->tgl_tindakan),
        'jml'=> $item->qty_tindakan,
        'harga'=> MyFormatter::formatNumberForPrint($item->tarif_satuan),
        'suba'=>MyFormatter::formatNumberForPrint($item->subsidiasuransi_tindakan),
        'subp'=>MyFormatter::formatNumberForPrint($item->subsidipemerintah_tindakan),
        'subr'=>MyFormatter::formatNumberForPrint($item->subsisidirumahsakit_tindakan),
        'subtotal'=>MyFormatter::formatNumberForPrint(($item->qty_tindakan * $item->tarif_satuan) - ($item->subsidiasuransi_tindakan + $item->subsidipemerintah_tindakan + $item->subsisidirumahsakit_tindakan)),
    ));
}

?>

<table width="100%" class="rincian">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Uraian</th>
        <th style='text-align: center;'>Dokter</th>
        <th style='text-align: center;'>Tgl Transaksi</th>
        <th style='text-align: center;'>Jml</th>
        <th style='text-align: center;'>Harga</th>
        <th style='text-align: center;'>Tanggungan Asuransi</th>
        <th style='text-align: center;'>Tanggungan Pemerintah</th>
        <th style='text-align: center;'>Tanggungan Rumah Sakit</th>
        <th style='text-align: center;'>Subtotal</th>
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
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $item2['uraian']; ?></td>
                <td><?php echo $item2['dokter']; ?></td>
                <td><?php echo $item2['tgl']; ?></td>
                <td style="text-align: right;"><?php echo $item2['jml']; ?></td>
                <td style="text-align: right;"><?php echo $item2['harga']; ?></td>
                <td style="text-align: right;"><?php echo $item2['suba']; ?></td>
                <td style="text-align: right;"><?php echo $item2['subp']; ?></td>
                <td style="text-align: right;"><?php echo $item2['subr']; ?></td>
                <td style="text-align: right;"><?php echo $item2['subtotal']; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">Total Keseluruhan</td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($suba); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subp); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subr); ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($subtotal); ?></td>
        </tr>
    </tfoot>
    
</table>

<br/><br/><br/>

<table>
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan">Petugas</td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan"></td>
    </tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <?php $pegawai = LoginpemakaiK::pegawaiLoginPemakai(); ?>      
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan" style="height: 50px;">
                <b><?php echo empty($pegawai)?"-":$pegawai->nama_pegawai; ?></b>                
         </td>         
    </tr>
    <tr align="right">
         <td colspan="5"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td colspan="2"></td>
         <td class="tandatangan" style = "border-top: 2px solid #000;">                              
                <b>NIP. <?php echo empty($pegawai)?"-":$pegawai->nomorindukpegawai; ?></b>
         </td>         
    </tr>
</table>
<?php /*
<table width="100%">
    <thead style='border:1px solid;'>
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Tanggal Tindakan</th>
        <th style='text-align: center;'>Jenis Pelayanan</th>
        <th style='text-align: center;'>Jumlah</th>
        <th style='text-align: center;'>Harga Satuan</th>
        <th style='text-align: center;'>Total</th>

    </thead>
    <tbody>
        <?php
        $no=1;
        $totalbiaya = 0;
        $subasuransi = 0;
        $subrs = 0;
        $subpemerintah = 0;
        
		if (count((array)$modRincians) > 0 ){
			foreach($modRincians AS $i => $rincian):
				$totalbiaya += ($rincian->qty_tindakan*$rincian->tarif_satuan);
                                $subasuransi += $rincian->subsidiasuransi_tindakan;
                                $subrs += $rincian->subsisidirumahsakit_tindakan;
                                $subpemerintah += $rincian->subsidipemerintah_tindakan;
                        
				$tampilruangan = true;
					if((($rincian->tm)=='AP') or (($rincian->tm)=='OA')){
						$jenisPelayanan = $rincian->daftartindakan_nama;
					}else{
	//                   dicomment karena issue  RND-6042 $jenisPelayanan = $rincian->kategoritindakan_nama;
						$jenisPelayanan = $rincian->daftartindakan_nama;
					}
				echo "<tr style='border:1px solid;''>
				<td style='text-align:center;'>".$no."</td>
				<td style='text-align:left;'>".(MyFormatter::formatDateTimeForUser($rincian->tgl_tindakan))."</td>
				<td>".$jenisPelayanan."</td>
				<td style='text-align: center;'>".$rincian->qty_tindakan."</td>
				<td style='text-align: right;'>".(MyFormatter::formatNumberForPrint($rincian->tarif_satuan))."</td>
				<td style='text-align: right;'>".(MyFormatter::formatNumberForPrint($rincian->qty_tindakan*$rincian->tarif_satuan))."</td>      
			 </tr>";  
			$no++;
			endforeach;
		?>
		<?php } 
                
                $res = $totalbiaya - ($subasuransi + $subrs + $subpemerintah);
                
                ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Jumlah Biaya</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Tanggungan Asuransi</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($subasuransi); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Tanggungan Rumah Sakit</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($subrs); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Tanggungan Pemerintah</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($subpemerintah); ?></td>
        </tr>
        <tr>
            <td colspan='5' align='right' style="font-weight:bold; border: 1px solid black;">Tanggungan Pasien</td>
            <td align='right' style="font-weight:bold; text-align: right; border: 1px solid black;"><?php echo $format->formatNumberForPrint($res); ?></td>
        </tr>
        <tr>
            <td colspan='6' align='center' style="font-style:italic; border: 1px solid black;">(<?php echo $format->formatNumberTerbilang($res); ?> rupiah)</td>
        </tr>
        <tr><td></td></tr>
        <tr><td colspan="2">
        <?php echo MyFormatter::formatDateTimeForUser(date("d-m-Y")); ?>&nbsp;&nbsp;<?php echo $modPendaftaran->carabayar->carabayar_nama;?></td>
        </tr>    
    </tfoot>
</table>

 * 
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
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianBelumBayar", array("instalasi_id"=>$_GET['instalasi_id'], "pendaftaran_id"=>$_GET['pendaftaran_id'], "pasienadmisi_id"=>(isset($_GET['pasienadmisi_id']) ? $_GET['pasienadmisi_id'] : null))) ?>","",'location=_new, width=1024px');
    }
    </script>

    
           <?php //echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?>

<?php
}
?>

