<style>
    body {
        color: black;
        /*font-size: 10px;*/
    }
    
    .border{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .tab_header, .tab_detail {
        width:100%;
    }
    
    .tab_detail th {
        text-align: center;
    }
    
    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 2px;
    }
</style>
<?php  echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>'RINCIAN FAKTUR PEMBELIAN BAHAN MAKANAN', 'deskripsi'=>"", 'colspan'=>10)); ?>
<?php // echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>'',  'periode'=> '', 'colspan'=>10)); ?>
<?php 
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success',"Status Mengetahui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<table  class="tab_header" style = "box-shadow:none;">
     <tr>
        <td width="50%">
            <table  class="tab_header" style = "box-shadow:none;" style="width:100%;">
                <tr>
                    <td width="200px">No Permintaan</td>
                    <td>: <?php echo $modTerima->pengajuanbahanmkn->nopengajuan; ?></td>
                </tr>
                <tr>
                    <td>No Penerimaan</td>
                    <td>: <?php echo $modTerima->nopenerimaanbahan; ?></td>
                </tr>
                <tr>
                    <td>Tgl. Terima</td>
                    <td>: <?php echo MyFormatter::formatDateTimeForUser($modTerima->tglterimabahan); ?></td>
                </tr>
                <tr>
                    <td>No Faktur</td>
                    <td>: <?php echo $modTerima->nofaktur; ?></td>
                </tr>
                <tr>
                    <td>Tgl. Faktur</td>
                    <td>: <?php echo (isset($modTerima->tglfaktur)? MyFormatter::formatDateTimeForUser($modTerima->tglfaktur):"-"); ?></td>
                </tr>
                <tr>
                    <td>Tgl. Jatuh Tempo</td>
                    <td>: <?php echo (isset($modTerima->tgljatuhtempo)? MyFormatter::formatDateTimeForUser($modTerima->tgljatuhtempo):"-"); ?></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: <?php echo $modTerima->keteranganfaktur; ?></td>
                </tr>
                <tr>
                    <td>Jenis PPh</td>
                    <td>: <?php echo (isset($modTerima->pajak)?$modTerima->pajak->pajak_nama:""); ?></td>
                </tr>
            </table>
        </td>
        <td width="50%">
            <table  class="tab_header" style = "box-shadow:none;" style="width:100%;">
                <tr>
                    <td width="200px">Total Harga</td>
                    <td>: Rp <?php echo (!empty($modTerima->totalharganetto)?MyFormatter::formatNumberForPrint($modTerima->totalharganetto,2): 0); ?></td>
                </tr>
                <tr>
                    <td>Total Keringanan</td>
                    <td>: Rp <?php echo (!empty($modTerima->totaldiscount)?MyFormatter::formatNumberForPrint($modTerima->totaldiscount,2): 0); ?></td>
                </tr>
                <tr>
                    <td>Total PPN</td>
                    <td>: Rp <?php echo (!empty($modTerima->biayapajak)?MyFormatter::formatNumberForPrint($modTerima->biayapajak,2): 0); ?></td>
                </tr>
                <tr>
                    <td>Total PPh</td>
                    <td>: Rp <?php echo (!empty($modTerima->biayapajakpph)?MyFormatter::formatNumberForPrint($modTerima->biayapajakpph,2): 0); ?></td>
                </tr>
                <tr>
                    <td>Total Keseluruhan</td>
                    <td>: Rp <?php echo (!empty($modTerima->totalkeseluruhan)?MyFormatter::formatNumberForPrint($modTerima->totalkeseluruhan,2): 0); ?></td>
                </tr>
                <tr>
                    <td>Jumlah Uang Muka</td>
                    <td>: Rp <?php echo (!empty($modTerima->jmluangmukabeli)?MyFormatter::formatNumberForPrint($modTerima->jmluangmukabeli,2): 0); ?></td>
                </tr>
                <tr>
                    <td>Total Harga Netto</td>
                    <td>: Rp <?php echo (!empty($modTerima->totalhutangusaha)?MyFormatter::formatNumberForPrint($modTerima->totalhutangusaha,2): 0); ?></td>
                </tr>
            </table>
        </td>
    </tr>  
</table>
<br>
<table class="tab_detail" style = "box-shadow:none;">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kelompok</th>
            <th>Nama</th>
            <th>Jumlah Persediaan</th>
            <th>Jumlah Terima</th>
            <th>Tanggal Kedaluwarsa</th>
            <th>Harga Netto (Rp)</th>
            <th>Keringanan (%)</th>
            <th>Keringanan (Rp)</th>
            <th>PPN (%)</th>
            <th>PPN (Rp)</th>
            <th>PPh (%)</th>
            <th>PPh (Rp)</th>
            <th>Subtotal (Rp)</th>
        </tr>
    </thead>
    <tbody>
    <?php
     $totalSubTotal= 0;
    $totalnetto = 0;
    $totalDiskon = 0;
    $totalPpn = 0;
    $totalPph = 0;
    $no=1;
        foreach($modDetailTerima AS $tampilData):
            $modBhn = BahanmakananM::model()->findByPk($tampilData->bahanmakanan_id);
            $jmlHarga = round(($tampilData->qty_terima * $tampilData->harganettobhn),2);
            $jmlDiskon = round((($jmlHarga * $tampilData->persendiscount)/100),2);
            $jmlPpn = round(((($jmlHarga - $jmlDiskon) * $tampilData->persenppn)/100),2);
            $jmlPph = round(((($jmlHarga - $jmlDiskon) * $tampilData->persenpph)/100),2);
            
        $subTotal = ($jmlHarga - $jmlDiskon + $jmlPpn - $jmlPph);
        $totalSubTotal += $subTotal;
        $totalnetto += $tampilData->harganettobhn;
        $totalDiskon += $jmlDiskon;
        $totalPpn += $jmlPpn;
        $totalPph += $jmlPph;
        
        
        
    echo "<tr>
            <td class='border'>".$no."</td>
            <td class='border'>".$tampilData->bahanmakanan->kelbahanmakanan."</td>   
            <td class='border'>".$tampilData->bahanmakanan->namabahanmakanan."</td>       
            <td class='border' style='text-align: right;'>".number_format($modBhn->jmlpersediaan,2,",",".").' '.$tampilData->satuanbahan."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->qty_terima,2,",",".").' '.$tampilData->satuanbahan."</td>   
             <td class='border'>".MyFormatter::formatDateTimeForUser($tampilData->bahanmakanan->tglkadaluarsabahan)."</td>   
            <td class='border' style='text-align: right;'>Rp ".number_format($tampilData->harganettobhn,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->persendiscount,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>Rp ".number_format($jmlDiskon,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->persenppn,0,",",".")."</td>   
            <td class='border' style='text-align: right;'>Rp ".number_format($totalPpn,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>".number_format($tampilData->persenpph,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>Rp ".number_format($totalPph,2,",",".")."</td>   
            <td class='border' style='text-align: right;'>Rp ".  number_format($subTotal,2,",",".")."</td>     
         </tr>";   
        $no++;
        
        endforeach;
     
    ?>
         <?php
        echo "<tr>
            <td class='border' colspan='13' style='text-align:right;'> <b>Total</b></td>
            <td class='border' style='text-align: right;'>Rp ".  number_format($totalSubTotal,2,",",".")."</td>
         </tr>";
        ?>
    </tbody>
</table>

<br>
<div class="row">
    <div class="col-sm-4" style="text-align:center;">
    </div>
    <div class="span3" style="text-align:center;">
    </div>
	<div class="col-sm-4" style="text-align:center;">
        <?php 
            if(isset($_GET['sukses'])){
                    echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
                    echo "Manager Keuangan, <br> Mengetahui";
            }else{
                    echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
                    echo CHtml::link(Yii::t('mds',' Menyetujui'), 
                    $this->createUrl($this->id.'/index'), 
                    array('class' => 'btn btn-danger',
                            'onclick'=>'myConfirm("Apakah Anda yakin?","Perhatian!",
                            function(r) {if(r) window.location = "'.$this->createUrl('Menyetujui',array('terimabahanmakan_id'=>$modTerima->terimabahanmakan_id,'approve'=>true)).'";} ); return false;'));  
            }
        ?>
		</div>	
		<div class="control-group">
			( <?php
                        $modAppr = ApprovalotorisasiM::model()->find();
                        $pegawainame = "";
                                                                             
                        if(isset($modAppr)){
                            if($modTerima->sumberdanabhn == "PT. SHB"){
                                if(!empty($modAppr->managerkeuanganpt_id)){
                                   $pegawainame = $modAppr->managerkeuanganpt->namaLengkap; 
                                }
                            }else{
                               if(!empty($modAppr->managerkeuangan_id)){
                                   $pegawainame = $modAppr->managerkeuangan->namaLengkap; 
                                } 
                            }
                        } 
                        
                        echo $pegawainame; ?> )
		</div>	
	</div>
</div>
<?php 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    $urlPrint= $this->createUrl('printMenyetujui',array('terimabahanmakan_id'=>$modTerima->terimabahanmakan_id));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
    
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>