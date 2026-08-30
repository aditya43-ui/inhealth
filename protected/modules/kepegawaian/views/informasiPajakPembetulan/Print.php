<?php 
if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
          header('Cache-Control: max-age=0');     
    }
	
//    $periode = $model->periodegaji;
//    
//    if (empty($model->periodegaji)) {
//        $periode = $model->tglpenggajian;
//    } 
//    $date = MyFormatter::getMonthId(date('m', strtotime($periode)))." ".date('Y', strtotime($periode));
    echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
//    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>"SLIP GAJI - ".strtoupper($date)));  
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
<table id="tableObatAlkes" class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
        <th>Masa Pajak</th>
        <th>Tahun Pajak</th>
        <th>Perbaikan Ke</th>
        <th>NPWP</th>
        <th>Nama</th>
        <th>Kode Objek Pajak</th>
        <th>Jumlah Bruto</th>
        <th>Jumlah PPh</th>
         <th>Jumlah Perbaikan</th>
        <th>Kode Negara</th>
        </tr>
    </thead>
    <tbody>

        <tr>
           <td><?php echo !empty($model->tglpajak)?date("n", strtotime(MyFormatter::formatDateTimeForDb($model->tglpajak))):"-" ?></td>
           <td><?php echo !empty($model->tglpajak)?date("Y", strtotime(MyFormatter::formatDateTimeForDb($model->tglpajak))):"-" ?></td>
           <td><?php echo $model->pembetulanke; ?></td>
           <td><?php echo isset($modelpeg->pegawai_id)?$modelpeg->pegawai->npwp:""; ?></td>
           <td><?php echo isset($modelpeg->pegawai_id)?$modelpeg->pegawai->namaLengkap:""; ?></td>
           <td><?php echo isset($modelpeg->pegawai_id) ? $modelpeg->pegawai->kode_objekpajak : ""; //$modelpeg->kodeptkp; ?></td>
            <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modelpeg->totalterima); ?></td>
           <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($modelpeg->pph21perbulan); ?></td>
           <td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint($model->jmlpembetulan); ?></td>
           <td></td>
        </tr> 
    </tbody>
</table>
