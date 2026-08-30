<style>
    .table-rincian td, th{
        border: solid #000 1px;
    }
</style>
<?php
if(!$modRincians){
    echo "Data tidak ditemukan"; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
<div style='width:100%; text-align: center; font-weight: bold;'>  BUKTI PEMBAYARAN </div>
<table width="100%">
    <tr>
        <td>No. Urut</td><td>: <?php echo "-"?></td>
        <td>No. D.M.K</td><td>: <?php echo $modRincians[0]->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>No. Reg</td><td>: <?php echo $modRincians[0]->no_pendaftaran; ?></td>
        <td>Tanggal Masuk RS</td><td>: <?php echo date("d-m-Y",strtotime($modRincians[0]->tgl_pendaftaran));?></td>
    </tr>
    <tr>
        <td>Nama/Umur</td><td>: <?php echo $modRincians[0]->namadepan." ".$modRincians[0]->nama_pasien."/".$modRincians[0]->umur;?></td>
        <td>Tanggal Keluar</td><td>: <?php echo date("d-m-Y",strtotime($modRincians[count((array)$modRincians)-1]->tgl_tindakan));?></td>
    </tr>
    <tr>
        <td>Alamat</td><td>: <?php echo $modRincians[0]->alamat_pasien;?></td>
        <td></td><td></td>
    </tr>
</table>
<table width='100%' cellpadding='2px' class='table-rincian'>
    <thead>
        <th>No.</th>
        <th>Uraian</th>
        <th>Jasa RSU</th>
        <th>Jasa Pelayanan</th>
        <th>RFS</th>
        <th>Gizi</th>
        <th>DMK</th>
        <th>Jumlah</th>
    </thead>
    <tbody>
        <?php 
        $totalbiaya = 0;
        $totaljasarsu = 0;
        $totaljasapelayanan = 0;
        $totalrfs = 0;
        $totalgizi = 0;
        $totaldmk = 0;
        foreach($modRincians AS $i => $rincian) {
            $jasarsu = 0;
            $jasapelayanan = 0;
            $rfs = 0;
            $gizi = 0;
            $dmk = 0;
            $jumlah = $rincian->qty_tindakan*$rincian->tarif_satuan;
            if(!$rincian->is_alkes){
                $jasarsu = $rincian->JasaRumahSakit;
                $jasapelayanan = $rincian->JasaPelayanan;
                $rfs = $rincian->JasaRFS;
                $dmk = $rincian->JasaDMK;
            }else{
                $rfs = $jumlah;                
            }
            $totaljasarsu += $jasarsu;
            $totaljasapelayanan += $jasapelayanan;
            $totalrfs += $rfs;
            $totalgizi += $gizi;
            $totaldmk += $dmk;
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
                    <td colspan='7'><b><?php echo $rincian->instalasi_nama." - ".$rincian->ruangan_nama; ?></b></td>
                </tr>
        <?php 
            }
        ?>
            <tr>
                <td align='right'><?php echo ($i+1); ?></td>
                <td><?php echo $rincian->daftartindakan_nama; ?></td>
                <td align='right'><?php echo $format->formatNumberForPrint($jasarsu); ?></td>
                <td align='right'><?php echo $format->formatNumberForPrint($jasapelayanan); ?></td>
                <td align='right'><?php echo $format->formatNumberForPrint($rfs); ?></td>
                <td align='right'><?php echo $format->formatNumberForPrint($gizi); ?></td>
                <td align='right'><?php echo $format->formatNumberForPrint($dmk); ?></td>
                <td align='right'><?php echo $format->formatNumberForPrint($jumlah); ?></td>
            </tr>
        <?php 
        } 
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan='2' align='right' style="font-weight:bold;">Jumlah Biaya</td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totaljasarsu); ?></td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totaljasapelayanan); ?></td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalrfs); ?></td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalgizi); ?></td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totaldmk); ?></td>
            <td align='right' style="font-weight:bold;"><?php echo $format->formatNumberForPrint($totalbiaya); ?></td>
        </tr>
        <tr>
            <td colspan='8' style="font-style:italic;">(<?php echo $format->formatNumberTerbilang($totalbiaya); ?> rupiah)</td>
        </tr>
    </tfoot>
</table>

<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print Rincian', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();"));
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(){
        window.open("<?php echo Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/PrintRincianRSSudahBayar", array("pembayaranpelayanan_id"=>$_GET['pembayaranpelayanan_id'])) ?>","",'location=_new, width=1024px');
    }
    </script>
<?php
}else{
?>    
    <table width='100%'>
        <tr>
            <td></td>
            <td align="center"><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
        </tr>
        <tr>
            <td align="center">Verifikasi</td>
            <td align="center">Kasir</td>
        </tr>
        <tr height='100px'>
            <td align="center">__________________</td>
            <td align="center"><?php echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
        </tr>
    </table>
<?php
}
?>

