
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
$format = new MyFormatter;
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  
$print = ReevaluasiasetT::model()->findByAttributes(array('reevaluasiaset_id'=>$_GET['id']));
$sql = "select reevaluasiaset_t.*,reevaluasiasetdetail_t.* from reevaluasiaset_t  join reevaluasiasetdetail_t on
		(reevaluasiasetdetail_t.reevaluasiaset_id=reevaluasiaset_t.reevaluasiaset_id)
		where reevaluasiaset_t.reevaluasiaset_id='".$_GET['id']."' ";
$query = Yii::app()->db->createCommand($sql)->queryAll();

?>

<table>
	<tr>
		<td>No. Reevaluasi</td>
		<td>:</td>
		<td><?php echo $print->reevaluasiaset_no;?></td>
	</tr>
	<tr>
		<td>Tanggal Reevaluasi</td>
		<td>:</td>
		<td><?php echo $print->reevaluasiaset_tgl;?></td>
	</tr>	
</table>
<br />
<?php
	$row="";
	$no = 0;
	foreach($query as $data):
		$row.="
        <tr>
			<td>$no</td>
            <td>".$data['reevaluasiaset_no']."<strong></strong></td>
            <td>".$data['barang_id']."</td>
            <td>".$data['reevaluasiaset_umurekonomis']."</td>
            <td>".$data['reevaluasiaset_nilaibuku']."</td>
			<td>".$data['reevaluasiaset_hargaperolehan']."</td>
			<td>".$data['reevaluasiaset_selisihreevaluasi']."</td>
        </tr>
		";
		$no++;
	endforeach;
?>
<table width="100%">
        <tr>
           <td>No</td>
           <td>No. Registrasi</td>
           <td>Nama Aset</td>
           <td>Umur Ekonomis</td>
           <td>Nilai Buku</td>
           <td>Harga Pasar</td>
           <td>Selisih Reevaluasi</td>		   
        </tr>
		<tr>
			<?php echo $row;?>
		</tr>
</table>

<table width="80%" style="margin-top:20px;">
    <tr>
        <td width="50%" align="center">
			Pegawai Mengetahui,
            <div style="margin-top:50px;"></div><?php echo (isset($print->pegawaimengetahui_id) ? $print->pegawaimengetahui_id : ""); ?>
		</td>
        <td width="50%" align="center">
            <?php echo Yii::app()->user->getState('kabupaten_nama'); ?>, <?php echo $format->formatDateTimeForUser(date('Y-m-d')); ?><br>
            Pegawai Menyetujui,
            <div style="margin-top:50px;"></div><?php echo (isset($print->pegawaimenyetujui_id) ? $print->pegawaimenyetujui_id : Yii::app()->user->getState('nama_pegawai')); ?>
        </td>
    </tr>
</table>
