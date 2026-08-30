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
            <td align='center'>Verifikasi</td>
            <td align='center'>Yang membayar</td>
            <td align='center'>Kasir</td>
        </tr>
        <tr height='100px'>
            <td align='center'>__________________</td>
            <td align='center'>__________________</td>
            <td align='center'><?php echo Yii::app()->user->getState('gelardepan')." ".Yii::app()->user->getState('nama_pegawai')." ".Yii::app()->user->getState('gelarbelakang_nama'); ?></td>
        </tr>
    </table>
<?php
}
?>

