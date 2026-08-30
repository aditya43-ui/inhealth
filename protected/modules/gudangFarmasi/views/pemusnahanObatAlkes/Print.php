<style>
body{
    font-size:8pt;
}
td.uang{
    text-align:right;
}
th{
    text-align:center;
}
.border{
    border:1px solid;
}
</style>
<?php
if (isset($caraprint)){
    if($caraprint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?> 
<?php 
    if(!isset($_GET['frame'])) { 
          echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>''));
    } 
?>

    <div align="center" width="100%">
        <b><?php echo $judul_print ?></b>
    </div>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Nama Ruangan</td>
            <td>:</td>
            <td><?php echo $model->ruanganasal->ruangan_nama; ?></td>
            
            <td>Tanggal Pemusnahan</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($model->tglpemusnahan); ?></td>
        </tr>
        <tr>
            <td>Petugas Pemusnahan</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></td>
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <tr>
                <th>No.</th>
                <th>Nama Obat</th>
                <th>Keadaan</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i=>$detail){ 
        ?>
            <tr>
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $detail->obatalkes->obatalkes_nama; ?></td>
                <td style="text-align:center;"><?php echo isset($detail->kondisibarang) ? $detail->kondisibarang : "-"; ?></td>
                <td style="text-align:center;"><?php echo $detail->jmlbarang; ?></td>
                <td style="text-align:center;"><?php echo  $format->formatUang($detail->harganetto); ?></td>
                <td style="text-align:center;">
                <?php
                    $subtotal = ($detail->harganetto * $detail->jmlbarang);
                    $total += $subtotal;
                    echo $format->formatUang($subtotal); ?>
                </td>
            </tr>
        <?php } ?>
        <tr class='border'>
            <td colspan="5" align="right"><b>Total</b></td>
            <td style="text-align:center;"><?php echo $format->formatUang($total); ?></td>
        </tr>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraprint){
        var pemusnahanobatalkes_id = '<?php echo $model->pemusnahanobatalkes_id; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pemusnahanobatalkes_id='+pemusnahanobatalkes_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Pegawai Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".$format->formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Ka. Instalasi Farmasi</div>
                        <div style="margin-top:60px;"><?php echo (isset($model->pegawaimenyetujui->NamaLengkap) ? $model->pegawaimenyetujui->NamaLengkap : ""); ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
<?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
