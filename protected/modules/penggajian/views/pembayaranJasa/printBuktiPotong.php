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
    
    .num {
        text-align: right !important;
    }
</style>
<?php
echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel',array('judulLaporan'=>$judulLaporan, 'colspan'=>13)); 
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

?>

<table id="tableObatAlkes" class="table border">
    <thead>
        <tr>
            <th>Tahun</th>
            <th>Masa</th>
            <th>Jenis BP</th>
            <th>Tgl. Bukti Potong</th>
            <th>Kode Objek Pajak</th>
            <th>Apakah dibayar Bulanan</th>
            <th>Jml Hari Kerja</th>
            <th>Status PTKP</th>
            <th>NIK</th>
            <th>Nama Pegawai</th>
            <th>Bruto</th>
            <th>Tarif</th>
            <th>No. Ref</th>
            <th>Keterangan</th>
        </tr>
    </thead>
     <tbody>
         <?php

            if(count((array)$model)>0){
                $no = 1;
                
                foreach ($model as $data){
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    $ptkp = PtkpM::model()->findByPk($peg->ptkp_id);
                
            ?>

                <tr>
                    <td><?php echo date('Y', strtotime($data->periodejasa)); ?></td>
                    <td><?php echo date('m', strtotime($data->periodejasa)); ?></td>
                    <td><?php echo $peg->jenisBuktiPotong; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($data->tglbayarjasa)); ?></td>
                    <td><?php echo $data->kode_objekpajak; ?></td>
                    <td><?php echo /*$data->is_bayarbulanan ? "Ya" :*/ "Tidak"; ?></td>
                    <td><?php echo  ""; ?></td>
                    <td><?php echo (isset($ptkp) ? $ptkp->kodeptkp : ""); ?></td>
                    <td><?php echo (!empty($peg->nomorindukpegawai)? '="'.preg_replace('/[^A-Za-z0-9]/s',"",$peg->nomorindukpegawai).'"' : ""); ?></td>
                    <td><?php echo empty($peg) ? "-" : $peg->namaLengkap; ?></td>
                    <td><?php echo (!empty($data->totalbayarjasa)? '="'.number_format($data->totalbayarjasa, 0, ",", ".").'"' :"0"); ?></td>
                    <td><?php echo (!empty($data->totaltarif)? '="'.number_format($data->totaltarif, 0, ",", ".").'"' :"0"); ?></td>
                    <td><?php echo $data->nobayarjasa; ?></td>
                    <td><?php echo ""; ?></td>

                </tr>
             <?php   
             }
            }else{
             ?>
         <tr>
             <td colspan="12">Tidak Ditemukan</td>
         </tr>
             <?php    
            }
         ?>
     </tbody>
</table>