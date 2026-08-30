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

echo $this->renderPartial('application.views.headerReport.headerDefaultNew',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>"", 'colspan'=>10));
$nama = "";
$tgl = "";
$namapt = "";
$tglpt = "";
$namaSetuju = "";
$tglSetuju = "";
?>

<table id="tableObatAlkes" class="table border" bgcolor='white'>
    <thead>
        <tr>
            <th>No.</th>
            <th>Pegawai</th>
            <th>Periode</th>
            <th>Tgl. Pengajuan</th>
            <th>No. Pengajuan</th>
            <th>Penerimaan Bersih</th>
            <th>Total Terima</th>
        </tr>
    </thead>
     <tbody>
         <?php
         $totalTerima = 0;
                $totalBersih = 0;
                $totalPajak = 0;
            if(count((array)$model)>0){
                $no = 1;
                
                $nama = $model[0]->mengetahui;
                $tgl = $model[0]->tgl_mengetahui;
                $namapt = $model[0]->mengetahuipt;
                $tglpt = $model[0]->tgl_mengetahuipt;
                $namaSetuju = $model[0]->menyetujui;
                $tglSetuju = $model[0]->tgl_menyetujui;
                foreach ($model as $data){
                    $peg = PegawaiM::model()->findByPk($data->pegawai_id);
                    $id[] = $data->penggajianpeg_id;
                     $totalTerima += $data->totalterima;
                $totalBersih += $data->penerimaanbersih;
                 $totalPajak += $data->totalpajak; 
            ?>

                <tr bgcolor='white'>
                    <td bgcolor='white'><?php echo $no++; ?></td>
                    <td bgcolor='white'><?php echo empty($peg) ? "-" : $peg->namaLengkap; ?></td>
                    <td bgcolor='white'><?php echo MyFormatter::formatMonthForUser(date('Y-m', strtotime($data->periodegaji))); ?></td>
                    <td bgcolor='white'><?php echo MyFormatter::formatDateTimeForUser($data->tglpenggajian); ?></td>
                    <td bgcolor='white'><?php echo $data->nopenggajian; ?></td>
                    <td bgcolor='white' style="text-align: right"><?php echo number_format($data->penerimaanbersih,0,"","."); ?></td>
                    <td bgcolor='white' style="text-align: right"><?php echo number_format($data->totalterima,0,"","."); ?></td>
                </tr>
             <?php   
             }
            }else{
             ?>
         <tr bgcolor='white' colspan="6">
             <td>Tidak Ditemukan</td>
         </tr>
             <?php    
            }
         ?>
     </tbody>
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
        <?php if(!empty($tglSetuju)){ ?>
        <tr>
            <th style="text-align: right" colspan="5">
                Total Pajak
            </th>
            <th style="text-align: right" colspan="2">
                <?php echo CHtml::encode(number_format($totalPajak,0,"",".")); ?>
            </th>
        </tr>
        <?php } ?>
     </tfoot>
</table>

<table style="width: 100%; border: none;">
	<tr>
		<th style="width:30%; text-align:center; padding-bottom: 50px;">
		<?php 
		if(!empty($tgl)){ ?>
			Mengetahui (RS),
			<br><br><br><br><br><br>
			( <?php echo $nama;?> )
		<?php } ?>
		</th>
                <th style="width:40%; text-align:center; padding-bottom: 50px;">
		<?php 
		if(!empty($tglpt)){ ?>
			Mengetahui (PT),
			<br><br><br><br><br><br>
			( <?php echo $namapt;?> )
		<?php } ?>
		</th>
                <th style="width:30%; text-align:center; padding-bottom: 50px;">
		<?php 
		if(!empty($tglSetuju)){ ?>
			Menyetujui,
			<br><br><br><br><br><br>
			( <?php echo $namaSetuju;?> )
		<?php } ?>
		</th>
	</tr>
</table>

<?php // die; ?>

