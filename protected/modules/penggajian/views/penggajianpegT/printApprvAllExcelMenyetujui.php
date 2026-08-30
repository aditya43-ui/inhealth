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
            <th>No.</th>
            <th>Nama Pegawai</th>
            <th>Periode</th>
            <th>Tgl. Pengajuan</th>
            <th>Nomor Pengajuan</th>
            <th>Jabatan</th>
            <th>Departemen</th>
            <th>Hari Kerja</th>
            <th>PPh 21</th>
            <th>Take Home Pay</th>
        </tr>
    </thead>
     <tbody>
         <?php

            if(count((array)$model)>0){
                $no = 1;
                $totalPajak = 0;
                $totalBersih = 0;
                $nama = $model[0]->mengetahui;
                $tgl = $model[0]->tgl_mengetahui;
                $namapt = $model[0]->mengetahuipt;
                $tglpt = $model[0]->tgl_mengetahuipt;
                $namaSetuju = $model[0]->menyetujui;
                $tglSetuju = $model[0]->tgl_menyetujui;
                foreach ($model as $data){
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    $id[] = $data->penggajianpeg_id;
                    $totalPajak += $data->totalpajak;
                    $totalBersih += $data->penerimaanbersih;
            ?>

                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo empty($peg) ? "" : $peg->namaLengkap; ?></td>
                    <td><?php echo MyFormatter::getMonthId(date('m', strtotime($data->periodegaji))); ?></td>
                    <td><?php echo date('d', strtotime($data->tglpenggajian))." ".MyFormatter::getMonthId(date('m', strtotime($data->tglpenggajian)))." ".date('Y', strtotime($data->tglpenggajian)); ?></td>
                    <td><?php echo $data->nopenggajian; ?></td>
                    <td><?php echo isset($peg->jabatan) ? $peg->jabatan->jabatan_nama : ""; ?></td>
                    <td><?php echo isset($peg->unitkerja) ? $peg->unitkerja->namaunitkerja : ""; ?></td>
                    <td><?php echo $data->harihadir; ?></td>
                    <td><?php echo $data->totalpajak; ?></td>
                    <td><?php echo $data->penerimaanbersih; ?></td>
                </tr>
            <?php
                $no++;
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
</table>