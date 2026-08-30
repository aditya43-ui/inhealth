<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
    // echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));  
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:120px;
        color:black;
        padding-right:10px;
    }
    table{
        font-size:11px;
    }

    td .tengah{
       text-align: center;  
    }
');
?>
<?php // var_dump($model->attributes, $modTandaBukti->attributes, $kasbon->pegawaimengajukan); die; ?>

<table width="100%">
    <tbody>
        <tr>
            <td width="120">Telah Bayar Kepada</td>
            <td width="10">:</td>
            <td><?php echo $model->nopenerimaan." / ".trim($model->keterangan_penerimaan)." / ".$kasbon->pegawaimengajukan->namaLengkap; ?></td>
            <td width="100" style="text-align: right">No. BKM</td>
            <td width="10">:</td>
            <td width="150"><?php echo $modTandaBukti->nobuktibayar?></td>
        </tr>
        <tr>
            <td>Dalam Jumlah Angka</td>
            <td>:</td>
            <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($model->totalharga); ?></td>
            <td style="text-align: right">Tanggal BKM</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modTandaBukti->tglbuktibayar); ?></td>
        </tr>
        <tr>
            <td>Dalam Jumlah Huruf</td>
            <td>:</td>
            <td><em><?php echo MyFormatter::formatNumberTerbilang($model->totalharga); ?> Rupiah</em></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>

