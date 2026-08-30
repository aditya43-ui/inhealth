<p style="margin: 0; text-align: center;">
<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<?php
echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    .border{
        border:1px solid;
    }
    .kertas{
     width:20cm;
     height:12cm;
    }
');
?>  
<?php
if(!$modDetail){
    echo "Data tidak ditemukan."; exit;
}
echo $this->renderPartial('application.views.headerReport.headerRincian');
$format = new MyFormatter;
$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
?>
<body class="kertas">
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tanggal Rencana Pengembalian</td>
            <td>:</td>
            <td><?php echo isset($model->tglrenpengembalian) ? $format->formatDateTimeId($model->tglrenpengembalian) : "-"; ?></td>
        </tr>
        <tr>
            <td>No. Rencana Pengembalian</td>
            <td>:</td>
            <td><?php echo isset($model->norenpengembalian) ? $model->norenpengembalian : "-"; ?></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo isset($model->ruangan_id) ? $model->ruangan->ruangan_nama : "-"; ?></td>
        </tr>
    </table><br><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;'>
        <thead class="border">
            <th>Obat</th>
            <th>Supplier</th>
            <th>Jumlah</th>
            <th>Satuan Kecil</th>
            <th>Tanggal Kedaluwarsa</th>
        </thead>
        <?php 
			foreach ($modDetail as $i=>$detail){ 
        ?>
            <tr>
                <td><?php echo !empty($detail['obatalkes_nama'])?$detail['obatalkes_nama']:null;  ?></td>
                <td><?php echo !empty($detail['supplier_nama'])? $detail['supplier_nama']:null; ?></td>
				<td><?php echo !empty($detail['qty_renpenged'])?$detail['qty_renpenged']:null; ?></td>
				<td><?php echo !empty($detail['satuankecil_nama'])?$detail['satuankecil_nama']:null; ?></td>
                <td><?php echo !empty($detail['tglkadaluarsa_renpeng'])? $detail['tglkadaluarsa_renpeng']:null; ?></td>
            </tr>
        <?php } ?>
    </table>
    <table class="table">
		<tr>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
				Mengetahui,
				<br><br><br><br><br><br>
				( <?php echo $model->mengetahui->NamaLengkap;?> )		
			</th>
			<th style="width:50%; text-align:center; padding-bottom: 50px;" colspan="4">
				Menyetujui,
				<br><br><br><br><br><br>
				( <?php echo $model->menyetujui->NamaLengkap;?> )
			</th>
		</tr>
	</table>
</body>
