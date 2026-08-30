<style>
    .border th, .border td {
        border:1px solid #000 !important;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }
    
    thead th{
        background:none;
        color:#333;
    }
    
    .border {
        box-shadow:none;
    }
    
    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    
    .table {
        border-collapse: collapse;
    }
    
    .textfontwight th{
            display: table-cell;
      vertical-align: inherit;
      font-weight: normal !important;
      text-align: center  !important;  
    }
    
    .num {
        text-align: right !important;
    }
</style>
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}
echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>4));  
?>
<table id="tableObatAlkes" class="table border">
    <thead>
        <tr class="textfontwight">
            <th>No.</th>
            <th>NIK</th>
            <th>Nama Pegawai</th>
            <th>No Rekening</th>
            <th>THP</th>
        </tr>
    </thead>
     <tbody>
         <?php
            $totalThp = 0;
            if(count((array)$model)>0){
                $no = 1;
                foreach ($model as $data){
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    $id[] = $data->penggajianpeg_id;
                     $totalThp += $data->penerimaanbersih;
            ?>

                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo (!empty($peg->nomorindukpegawai)? '="'.preg_replace('/[^A-Za-z0-9]/s',"",$peg->nomorindukpegawai).'"' : ""); ?></td>
                    <td><?php echo empty($peg) ? "-" : $peg->namaLengkap; ?></td>
                    <td><?php echo $peg->no_rekening; ?></td>
                    <td><?php echo (!empty($data->penerimaanbersih)? '="'.number_format($data->penerimaanbersih, 0, ",", ".").'"' :"0"); ?></td>
                </tr>
             <?php   
             }
            }else{
             ?>
         <tr colspan="6">
             <td>Tidak Ditemukan</td>
         </tr>
             <?php    
            }
         ?>
     </tbody>
     <tbody>
         <tr>
             <td colspan="4" style="text-align: right">
                 TOTAL
             </td>
             <td style="text-align: right">
                  <?php echo '="'.number_format($totalThp, 0, ",", ".").'"'; ?>
             </td>
         </tr>
     </tbody>
</table>

