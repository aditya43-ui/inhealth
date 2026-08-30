<style>
    .tabel
    {
        border: 1px solid #000;
    }
body{
/*    font-size:8pt;*/
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

.tabel th + th, .tabel td + td
{
    border-left: 1px solid #000;
    
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
<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array());
                    ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
    <div align="center" width="100%">
        <div class="judulcontent"><b><?php echo $judul_print ?></b></div> 
    </div>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Mutasi</td>
            <td>:</td>
            <td><?php echo $model->nomutasioa; ?></td>
        </tr>
        <tr>
            <td>Tanggal Mutasi</td>
            <td>:</td>
            <td><?php echo $format->formatDateTimeForUser($model->tglmutasioa); ?></td>
        </tr>
        <tr>
            <td>Ruangan Asal</td>
            <td>:</td>
            <td><?php echo (isset($model->ruanganasal->ruangan_nama) ? $model->ruanganasal->ruangan_nama : "-"); ?></td>
        </tr>
        <tr>
            <td>Ruangan Tujuan</td>
            <td>:</td>
            <td><?php echo (isset($model->ruangantujuan->ruangan_nama) ? $model->ruangantujuan->ruangan_nama : ""); ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaimengetahui->NamaLengkap) ? $model->pegawaimengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Status Mutasi</td>
            <td>:</td>
            <td><?php echo ((!empty($model->terimamutasi_id) ? "SUDAH DITERIMA" : "BELUM DITERIMA")); ?></td>
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' class="tabel">
        <thead class="border">
            <tr>
                <th>No.</th>
                <th>Sumber Dana</th>
                <th>Kategori / Nama Obat</th>
                <th>Tanggal Kedaluwarsa </th>
                <!--<th>Satuan Kecil </th>-->
                <?php
                   $periksa = MutasioaruanganT::model()->findByAttributes(array('mutasioaruangan_id'=>$model->mutasioaruangan_id));                
                   
                   if ($periksa->pesanobatalkes_id == ''):
                       echo "";
                   else:
                       echo "<th>Jumlah Pesan</th>";
                   endif;
                ?>   
                <!--<th>Jumlah Pesan</th>-->
                <th>Jumlah Mutasi</th>
                <!--<th>HPP</th>-->
                <!--<th>Harga Jual</th>-->
                <!--<th>Sub Total Netto</th>-->
            </tr>
        </thead>
        <?php 
        $total = 0;
        $subtotal = 0;
        foreach ($modDetails as $i=>$detail){ 
        ?>
            <tr>
                <td><?php echo ($i+1)."."; ?></td>
                <td><?php echo $detail->sumberdana->sumberdana_nama; ?></td>
                <td><?php echo (!empty($detail->obatalkes->obatalkes_kategori) ? $detail->obatalkes->obatalkes_kategori."/ " : "") . $detail->obatalkes->obatalkes_nama; ?></td>
                <td><?php echo $format->formatDateTimeForUser($detail->tglkadaluarsa); ?></td>
                <!--<td><?php //echo $detail->satuankecil->satuankecil_nama; ?></td>-->
                <?php
                
                if ($periksa->pesanobatalkes_id == ''):
                       echo "";
                   else:
                       echo "<td style = 'text-align:right;'> ".MyFormatter::formatNumberForPrint($detail->jmlpesan,2)." ".$detail->satuankecil->satuankecil_nama."</th>";;
                   endif;
                ?>
                <!--<td style = "text-align:right;"><?php //echo $detail->jmlpesan.' '.$detail->satuankecil->satuankecil_nama; ?></td>-->
                <td style = "text-align:right;"><?php echo MyFormatter::formatNumberForPrint($detail->jmlmutasi,2).' '.$detail->satuankecil->satuankecil_nama; ?></td>
                <!--<td class='uang'><?php // echo $format->formatUang($detail->harganetto); ?></td>-->
                <!--<td><?php // echo $format->formatUang($detail->hargajualsatuan); ?></td>-->
                <!--<td class="uang"><?php 
//                    $subtotal = ($detail->harganetto * $detail->jmlmutasi);
//                    $total += $subtotal;
//                    echo $format->formatUang($subtotal); ?>
                </td>-->
            </tr>
        <?php } ?>
<!--<tr class='border'>
            <td colspan="7" align="right"><b>Total</b></td>
            <td class="uang"><?php // echo $format->formatUang($total); ?></td>
        </tr>-->
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
        var mutasioaruangan_id = '<?php echo $model->mutasioaruangan_id; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&mutasioaruangan_id='+mutasioaruangan_id+'&caraprint='+caraprint,'printwin','left=100,top=100,width=1000,height=640');
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
                        <div>Operator</div>
                        <div style="margin-top:60px;"><?php echo (isset($model->pegawaimutasi->NamaLengkap) ? $model->pegawaimutasi->NamaLengkap : ""); ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
<?php } ?>
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
    <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
</div>
