
<?php 
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$data['judulLaporan'].'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }     
}
?>
<?php $this->renderPartial('application.views.headerReport.headerDefault',array('colspan'=>10)); ?>

<table>
    <tr>
        <td>Tgl. Penjualan</td>
        <td>:</td>
        <td><?php echo $reseptur->tglpenjualan;?></td>
        
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td><?php echo $reseptur->pasien->no_rekam_medik;?></td>
    </tr> 
    <tr>
        <td>Tgl. Resep</td>
        <td>:</td>
        <td><?php echo $reseptur->tglresep;?></td>
        
        <td>Nama Pasien</td>
        <td>:</td>
        <td><?php echo $reseptur->pasien->nama_pasien;?></td>
    </tr>
    <tr>
        <td><?php echo ($reseptur->jenispenjualan == Params::JENISPENJUALAN_BEBAS) ? 'No. Nota' : "No. Resep";?></td>
        <td>:</td>
        <td><?php echo $reseptur->noresep;?></td>
        
        <td>Dokter</td>
        <td>:</td>
        <td><?php echo  ($reseptur->jenispenjualan == Params::JENISPENJUALAN_LUAR OR  $reseptur->jenispenjualan == Params::JENISPENJUALAN_RESEP_LUAR) ? '-' : $reseptur->pegawai->nama_pegawai;?></td>
    </tr>
    <tr>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td><?php echo $reseptur->pendaftaran->carabayar->carabayar_nama;?></td>
        
        <td>Penjamin</td>
        <td>:</td>
        <td><?php echo $reseptur->pendaftaran->penjamin->penjamin_nama?></td>
    </tr>
</table>
<br>
<table id="tableObatAlkes" class="table table-bordered table-condensed" style="width: 98%; margin: auto;">
    <thead>
    
        <th style='text-align: center;'>No.</th>
        <th style='text-align: center;'>Uraian</th>
        <th style='text-align: center;'>Total Keringanan</th>
        <th style='text-align: center;'>SubTotal</th>
    
    </thead>
    <?php
    $no=1;
    $lainLain = $reseptur->biayaadministrasi+$reseptur->biayakonseling+$reseptur->totaltarifservice;//INI TIDAK DI TAGIHKAN KE PASIEN KARENA SUDAH MASUK KE HARGA OBAT >>> +$reseptur->jasadokterresep
        foreach($detailreseptur AS $tampilData):
            $subTotal = ($tampilData->subtotal - $tampilData->diskon )+$lainLain;
//            $subTotal = (($tampilData['qty_oa']*$tampilData['hargasatuan_oa']) - (($tampilData['qty_oa']*$tampilData['hargasatuan_oa'])*($tampilData['discount']/100)));
//            $discount = (($subTotal*($tampilData['discount']/100)));
//            if($tampilData['oasudahbayar_id'] != null){
//                echo $status = 'Sudah Lunas';
//            }else{
//                echo $status = 'Belum Lunas';
//            }
//    echo "<tr>
//            <td>".$no."</td>
//            <td>"."Obat Alkes"."</td>
//            <td style='text-align: right;'>".$tampilData->diskon."</td>
//            <td style='text-align: right;'>".number_format(($subTotal - ($subTotal * ($reseptur->discount/100))) + $reseptur->biayaadministrasi+$reseptur->biayakonseling+$reseptur->totaltarifservice+$reseptur->jasadokterresep)."</td>
//               
//         </tr>";  
    echo "<tr>
            <td>".$no."</td>
            <td>"."Obat Alkes"."</td>
            <td style='text-align: right;'>".$tampilData->diskon."</td>
            <td style='text-align: right;'>".number_format($subTotal)."</td>
               
         </tr>";  
        $no++;
       
        $totalSubTotal=$totalSubTotal+$subTotal;
        
        endforeach;
//    echo "<tr>
//            <td colspan='3' style='text-align:right;'> Biaya Administrasi</td>
//            <td style='text-align: right;'>".$reseptur->biayaadministrasi."</td>
//         </tr>";   
//    echo "<tr>
//            <td colspan='3' style='text-align:right;'> Biaya Service</td>
//            <td style='text-align: right;'>".$reseptur->totaltarifservice."</td>
//         </tr>";   
//    echo "<tr>
//            <td colspan='3' style='text-align:right;'> Biaya Konseling</td>
//            <td style='text-align: right;'>".$reseptur->biayakonseling."</td>
//         </tr>";  
//    echo "<tr>
//            <td colspan='3' style='text-align:right;'> Jasa Dokter Resep</td>
//            <td style='text-align: right;'>".$reseptur->jasadokterresep."</td>
//         </tr>";     
//    echo "<tr>
//            <td colspan='3' style='text-align:right;'> Total</td>
//            <td style='text-align: right;'>".number_format($subTotal+$reseptur->biayaadministrasi+$reseptur->biayakonseling+$reseptur->totaltarifservice+$reseptur->jasadokterresep)."</td>
//         </tr>";    
    echo "<tr>
            <td colspan='3' style='text-align:right;'> Total</td>
            <td style='text-align: right;'>".number_format($subTotal)."</td>
         </tr>";    
    ?>
    
</table>
<br>
<table>
    <tr><td><?php echo Yii::app()->user->getState('kabupaten_nama').', '.date('d-M-Y'); ?></td></tr>
    <tr><td>Yang membuat,</td></tr>
    <tr><td>Petugas I</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td><?php echo Yii::app()->user->getState('nama_pegawai'); ?></td><td></tr>
</table>

<?php if (isset($caraPrint)) { ?>
<?php  }else{

        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//      $this->widget('UserTips',array('type'=>'admin'));
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/strukPrint');
$id = $reseptur->penjualanresep_id;
$pasien_id = $reseptur->pasien_id;
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&id=${id}&pasien_id=${pasien_id}&caraPrint="+caraPrint,"",'location=_new, width=1100px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);         
}?>