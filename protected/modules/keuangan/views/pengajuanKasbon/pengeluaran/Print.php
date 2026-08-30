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
<h4 style="text-align: center">DETAIL PENGELUARAN KAS / UMUM</h4>

<table width="100%">
    <tbody>
        <tr>
            <td width="120"></td>
            <td width="10"></td>
            <td></td>
            <td width="100" style="text-align: right">No. BKK</td>
            <td width="10">:</td>
            <td width="150"><?php echo $modTandaBukti->nokaskeluar?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right">Tanggal BKK</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modTandaBukti->tglkaskeluar); ?></td>
        </tr>
        <tr>
            <td>Telah Bayar Kepada</td>
            <td>:</td>
            <td><?php echo $model->nopengeluaran." / ".trim($model->keterangankeluar)." / ".$kasbon->pegawaimengajukan->namaLengkap; ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Dalam Jumlah Angka</td>
            <td>:</td>
            <td><?php echo "Rp ".MyFormatter::formatNumberForPrint($model->totalharga); ?></td>
            <td></td>
            <td></td>
            <td></td>
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

