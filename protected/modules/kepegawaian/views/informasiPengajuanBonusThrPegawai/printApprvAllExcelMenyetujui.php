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
           <th>Pegawai</th>
          <th>Periode</th>
          <th>Tgl. Pengajuan</th>
           <th>No. Pengajuan</th>
           <th>Jenis Transaksi</th>
        </tr>
    </thead>
     <tbody>
         <?php

            if(count((array)$model)>0){
                $no = 1;

                $nama = $model[0]->pegawai_mengetahuirs;
                $tgl = $model[0]->tgl_mengetahui;

                $namapt = $model[0]->pegawai_mengetahuipt;
                $tglpt = $model[0]->tgl_mengetahuipt;

                $namaSetuju = $model[0]->pegawai_menyetujui;
                $tglSetuju = $model[0]->tgl_menyetujui;

                foreach ($model as $data){
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    $id[] = $data->pengbonusthr_id;

            ?>

            <tr>
              <td><?php echo $no++; ?></td>
              <td><?php echo empty($peg) ? "-" : $peg->namaLengkap; ?></td>
              <td><?php echo MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->periodebonusthr))); ?></td>
              <td><?php echo MyFormatter::formatDateTimeForUser($data->tglpengajuan); ?></td>
              <td><?php echo $data->nopengajuan; ?></td>
              <td><?php echo $data->jenisgaji; ?></td>
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
