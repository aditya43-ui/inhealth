<style>
	 @page {
        margin-top: 12mm;
    }
	
	@media print {
        #headers {
            position: fixed;
            top: 0;
        }
        
        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;
            padding-left: 1mm;
            height:auto;
			width:100%;
        }
    }
</style>
<?php 
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');

if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
	
    $periode = $model->periodegaji;
    
    if (empty($model->periodegaji)) {
        $periode = $model->tglpenggajian;
    } 
    $date = MyFormatter::getMonthId(date('m', strtotime($periode)))." ".date('Y', strtotime($periode));
    
    //echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>"SLIP GAJI - ".strtoupper($date)));  
	if ($caraPrint != 'PDF'){
		echo "<div id='headers'>";
		echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>"<b>SLIP GAJI - ".strtoupper($date).'</b>',  'periode'=> '', 'colspan'=>10));  
		echo '</div>';
	}else{
		//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> ucwords($period), 'colspan'=>10));  
	}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
     .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
	
	.row_total td {
		font-weight: bold;
		border-top: 1px solid black;
	}
	
	.tab_detail {
		border-top: 1px solid black;
	}
');
?>
<table class="tabel-akun">
   <tbody>
                <tr>
                    <td ><b> NIP </b> </td><td style="padding-right:10px;padding-left:10px;">: </td>
                    <td width="100%"><?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?></td>
                    <td nowrap><b>Tgl. Penggajian</b></td><td style="padding-right:10px;padding-left:10px;">: </td>
                    <td nowrap>
                        <?php
                            echo CHtml::encode(MyFormatter::formatDateTimeForUser($model->tglpenggajian));
                        ?>
                    </td>
                </tr>
				<tr>
					<td ><b> Nama </b> </td><td style="padding-right:10px;padding-left:10px;">: </td>
                    <td width="100%">
						<?php
                            echo CHtml::encode($modelpegawai->namaLengkap);
                        ?>
					</td>
                    <td ><b>No. Slip Gaji</b></td><td style="padding-right:10px;padding-left:10px;">: </td>
                    <td>
                        <?php
                            echo CHtml::encode($model->nopenggajian);
                        ?>
                    </td>
				</tr>
                <tr>
                    <td></td><td></td>
                    <td></td>
                    <td ><b> Periode Gaji </b> </td><td style="padding-right:10px;padding-left:10px;">: </td>
                    <td><?php
                    if (!empty($model->periodegaji)) {
                        echo MyFormatter::formatMonthForUser($model->periodegaji);
                    } else {
                        echo MyFormatter::formatMonthForUser($model->tglpenggajian);
                    }
                    ?></td>
                </tr>
				</tbody>
</table>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='tabel-akun tab_detail'>
    
    <tbody>
    <?php
        foreach ($modDetail as $i => $detail){
            if ($detail->komponen->ispotongan) continue;
    ?>
        <tr>
            <td><?php echo $detail->komponen->komponengaji_nama; ?></td>
            <td style="text-align:right;"><?php 
            echo $detail->jumlah == 0 ? "-" : MyFormatter::formatNumberForPrint($detail->jumlah); 
            ?></td>
			<td></td>
		</tr>
    <?php
        }
    ?>
		<tr class="row_total">
            <td style="text-align: right">Total</td>
			<td></td>
            <td style="text-align: right">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalterima)); ?>
            </td>
        </tr>
    <?php
        foreach ($modDetail as $i => $detail){
            if (!$detail->komponen->ispotongan) continue;
    ?>
        <tr>
            <td><?php echo $detail->komponen->komponengaji_nama; ?></td>
            <td style="text-align:right;"><?php 
            echo $detail->jumlah == 0 ? "-" : "(".MyFormatter::formatNumberForPrint($detail->jumlah).")"; 
            ?></td>
		</tr>
    <?php
        }
    ?>
        <tr>
			<td>Total Pajak</td>
			<td style="text-align: right">
				(<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalpajak)); ?>)
			</td>
		</tr>
		<tr>
			<td>Potongan Lain-Lain</td>
			<td style="text-align: right">
				(<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->potongan_lainlain)); ?>)
			</td>
		</tr>
    
        
    
		
		<tr class="row_total">
            <td style="text-align: right">Total</td>
			<td></td>
            <td style="text-align: right">
                (<?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->totalpotongan + $model->totalpajak + $model->potongan_lainlain)); ?>)
            </td>
        </tr>
		<tr class="row_total">
            <td style="text-align: right">Jumlah Terima</td><td></td>
            <td style="text-align: right; text-decoration: underline;">
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->penerimaanbersih)); ?>
            </td>
        </tr>
	
		
    </tbody>
</table>
<table width="100%" style="margin-top:20px;" class="tabel-akun">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">                
				 <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        
                    </td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Menyetujui</div>                        
                    </td>
                </tr>
				 <tr>
                    <td width="35%" align="center">
                        &nbsp;
                    </td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
                    <td width="35%" align="center">
                       &nbsp;
                    </td>
                </tr>
				 <tr>
                    <td width="35%" align="center">
                        &nbsp;
                    </td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
                    <td width="35%" align="center">
                       &nbsp;
                    </td>
					
                </tr>
				 <tr>
                    <td width="35%" align="center">
                        &nbsp;
                    </td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
                    <td width="35%" align="center">
                       &nbsp;
                    </td>
                </tr>
				 <tr>
                    <td width="35%" align="center">                       
                        <div><?php echo $model->mengetahui; ?></div>
                    </td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
                    <td width="35%" align="center">                        
                        <div><?php echo $model->menyetujui; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<?php 
	if (!isset($_GET['caraPrint'])){
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),
							array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'print("PRINT")')); 
		echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),
							array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'print("EXCEL")')); 
		echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),
							array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'print("PDF")')); 
?>

<?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print',array('id'=>$model->penggajianpeg_id,'pegawai_id'=>$model->pegawai_id,'jenis'=>'rincianlaporan')); 

$js = <<< JSCRIPT
    
	function print(caraPrint){
        window.open("${urlPrint}"+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
	}
?>
