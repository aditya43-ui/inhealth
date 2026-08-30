<style>
    .border{
        border:1px solid #000;
    }
</style>
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');   
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $template = "{items}";
}

?>
<?php
if(!$model){
    echo "Data tidak ditemukan."; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
<table style="width: 100%; border: none;">
    <tr>
        <td width="20%"> <?php echo "Tanggal Pengajuan "; ?></td>
        <td><?php echo ': '.MyFormatter::formatDateTimeForUser($model->tglpengajuan) ?></td>
        <td>&nbsp;</td>
        <td rowspan="2" width="40%" style = "text-align:left;vertical-align:top;"> <?php echo "Keterangan :".$model->keterangan; ?></td>
    </tr>   
    <tr>
        <td><?php echo "No. Pengajuan "; ?></td>
        <td><?php echo ': '.$model->nopengajuan?></td>
    </tr>
</table>
<br><br>
<table style="width: 100%; border: none;">
    <thead>
            <tr>
                <th class="border">No. Urut</th>
               <!--<th>Jabatan/ Pekerjaan</th>-->
                <th class="border">Jumlah Orang</th>
                <th class="border">Untuk Keperluan</th>
                <th class="border">Keterangan</th>
            </tr>
        </thead>
    <?php
    foreach($modPengpegdets as $i=>$modDetailPengcal) {
//        $id_occupation = $modDetailPengcal->occupation_id;
//        $occopation = OccupationM::model()->findByPk($id_occupation);
    ?>

        <tr>
            <td class="border" style = "text-align:center;"><?php echo $modDetailPengcal->nourut;?></td>
            <!--<td>-<?php //echo $occopation->occupation_nama;?>-->
            <!--</td>-->
            <td class="border"  style = "text-align:center;"><?php echo $modDetailPengcal->jmlorang;?></td>
            <td class="border" style = "padding-left:5px;padding-right:5px"><?php echo $modDetailPengcal->untukkeperluan; ?></td>
            <td class="border" style = "padding-left:5px;padding-right:5px"><?php echo $modDetailPengcal->keterangan; ?></td>

        </tr>

    <?php }  ?>
</table>
<br><br>
<table width='100%'>
	<tr>
		<td></td>
		<td></td>
		<td align='center'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d')); ?></td>
	</tr>
	<tr>		
		<td align='center'>Mengajukan</td>
		<td></td>
		<td align='center'>Mengetahui</td>
	</tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
	<tr height='100px'>		
		<td align='center'><?php echo (!empty($model->mengajukan_id)?$model->mengajukan->namaLengkap:'-'); ?></td>
		<td><?php //var_dump($model->mengetahui_id);die; ?></td>
		<td align='center'><?php echo (!empty($model->mengetahui_id)?$model->mengetahuii->namaLengkap:'-'); ?></td>
	</tr>
</table>  