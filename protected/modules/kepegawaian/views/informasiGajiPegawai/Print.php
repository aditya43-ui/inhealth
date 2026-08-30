<?php 
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
    
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>"SLIP GAJI - ".strtoupper($date)));  
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
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="text-align:right;"><b> NIP </b> </td><td>:</td>
                    <td width="100%"><?php echo CHtml::encode($modelpegawai->nomorindukpegawai); ?></td>
                    <td style="text-align:right;" nowrap><b>Tgl. Penggajian</b></td><td>:</td>
                    <td nowrap>
                        <?php
                            echo CHtml::encode(MyFormatter::formatDateTimeForUser($model->tglpenggajian));
                        ?>
                    </td>
                </tr>
				<tr>
					<td style="text-align:right;"><b> Nama </b> </td><td>:</td>
                    <td width="100%">
						<?php
                            echo CHtml::encode($modelpegawai->namaLengkap);
                        ?>
					</td>
                    <td style="text-align:right;"><b>No. Slip Gaji</b></td><td>:</td>
                    <td>
                        <?php
                            echo CHtml::encode($model->nopenggajian);
                        ?>
                    </td>
				</tr>
                <tr>
                    <td></td><td></td>
                    <td></td>
                    <td style="text-align:right;"><b> Periode Gaji </b> </td><td>:</td>
                    <td><?php
                    if (!empty($model->periodegaji)) {
                        echo MyFormatter::formatMonthForUser($model->periodegaji);
                    } else {
                        echo MyFormatter::formatMonthForUser($model->tglpenggajian);
                    }
                    ?></td>
                </tr>
            </table>            
        </td>
    </tr>
</table><br>
<table width="100%" style='margin-left:auto; margin-right:auto;' class='tab_detail'>
    <thead>
	<tr>
	<th></th>
	<th width="100"></th>
	<th width="100"></th>
	</tr>
	</thead>
    <tbody>
    <?php
        foreach ($modDetail as $i => $detail){
            if ($detail->komponen->ispotongan) continue;
    ?>
        <tr>
            <td><?php 
            echo $detail->komponen->komponengaji_nama; 
            
            if ($detail->qty > 1) {
                echo " (".$detail->qty;
                
                if (trim($detail->unit) != "") echo " ".$detail->unit;
                
                echo ")";
            }
            
            ?></td>
            <td style="text-align:right;"><?php 
            echo $detail->jumlah == 0 ? "-" : MyFormatter::formatNumberForPrint($detail->jumlah); 
            ?></td>
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
                <?php echo CHtml::encode(MyFormatter::formatNumberForPrint($model->penerimaanbersih - $model->totalpajak)); ?>
            </td>
        </tr>
	
		
    </tbody>
</table>
<table width="100%" style="margin-top:20px;">
    <tr>
        <td width="100%" align="left" align="top">
            <table style="width: 100%; border: none;">
                <tr>
                    <td width="35%" align="center">
                        <div>Mengetahui</div>
                        <div style="margin-top:60px;"><?php echo $model->mengetahui; ?></div>
                    </td>
                    <td width="35%" align="center">
                        <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
                        <div>Menyetujui</div>
                        <div style="margin-top:60px;"><?php echo $model->menyetujui; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>