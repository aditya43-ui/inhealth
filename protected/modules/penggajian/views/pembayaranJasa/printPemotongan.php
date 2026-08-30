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

// echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
$nama = "";
$tgl = "";
$namapt = "";
$tglpt = "";
$namaSetuju = "";
$tglSetuju = "";
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
                $totalTerima = 0;
                $totalBersih = 0;
                $nama = $model[0]->mengetahui;
                $tgl = $model[0]->tgl_mengetahui;
                $namapt = $model[0]->mengetahuipt;
                $tglpt = $model[0]->tgl_mengetahuipt;
                $namaSetuju = $model[0]->menyetujui;
                $tglSetuju = $model[0]->tgl_menyetujui;
                foreach ($model as $data){
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    $ptkp = PtkpM::model()->findByPk($peg->ptkp_id);
                    $id[] = $data->penggajianpeg_id;
                     $totalTerima += $data->totalterima;
                $totalBersih += $data->penerimaanbersih;
                
                
                $makan = PenggajiankompT::model()->findByAttributes(array(
                    'penggajianpeg_id'=>$data->penggajianpeg_id,
                ));
                
                
                $bruto = $data->gajipokok + $data->tunjangantetap + $data->premiasuransi + $data->tunjanganmakan + $data->tunjanganbonus;
                
            ?>

                <tr>
                    <td><?php echo date('Y', strtotime($data->periodegaji)); ?></td>
                    <td><?php echo date('m', strtotime($data->periodegaji)); ?></td>
                    <td><?php echo $peg->jenisBuktiPotong; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($data->tglpenggajian)); ?></td>
                    <td><?php echo $peg->kode_objekpajak; ?></td>
                    <td><?php echo $data->is_bayarbulanan ? "Ya" : "Tidak"; ?></td>
                    <td><?php echo $peg->kode_objekpajak == "21-100-03" ? $data->harikerja : "0"; ?></td>
                    <td><?php echo $data->kodeptkp; ?></td>
                    <td><?php echo "'".$peg->nomorindukpegawai; ?></td>
                    <td><?php echo empty($peg) ? "-" : $peg->namaLengkap; ?></td>
                    <td><?php echo number_format($bruto, 0, ".", ","); ?></td>
                    <td><?php echo number_format($data->tarif, 0, ".", ","); ?></td>
                    <td><?php echo $data->nopenggajian; ?></td>
                    <td><?php echo $data->keterangan; ?></td>

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
     <?php /*
     <tfoot> 
        <tr>
            <th style="text-align: right" colspan="5">
                Total
            </th>
            <th style="text-align: right">
                <?php echo CHtml::encode(number_format($totalBersih,0,"",".")); ?>
            </th>
                <th style="text-align: right">
                 <?php echo CHtml::encode(number_format($totalTerima,0,"",".")); ?>
            </th>
        </tr>
     </tfoot>
      * 
      */ ?>
</table>