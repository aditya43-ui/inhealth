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
        width:1%;
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
');
?>  
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerPrint'); 
}
?>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>Tanggal Rekonsiliasi Bank</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($model->rekonsiliasibank_tgl); ?></td>
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>No. Rekonsiliasi Bank</td>
            <td>:</td>
            <td><?php echo isset($model->rekonsiliasibank_no) ? $model->rekonsiliasibank_no : ""; ?></td>
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Bank</td>
            <td>:</td>
            <td><?php echo isset($model->bank_id) ? $model->bank->namabank : ""; ?></td>
			
			<td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Saldo pada Bank</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatNumberForPrint(isset($model->rekonsiliasibank_saldobank) ? $model->rekonsiliasibank_saldobank : 0); ?></td>
			
			<td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Saldo Kas pada Pembukuan</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatNumberForPrint(isset($model->rekonsiliasibank_saldokas) ? $model->rekonsiliasibank_saldokas : 0); ?></td>
			
			<td></td>
            <td></td>
            <td></td>
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' border="1">
        <thead class="border">
			<tr>
				<th rowspan="2">Uraian Jurnal</th>
				<th rowspan="2">Kode Rekening</th>
				<th rowspan="2">Nama Rekening</th>
				<th colspan="2">Saldo</th>
				<th rowspan="2">Keterangan</th>
			</tr>
			<tr>
				<th>Debit</th>
				<th>Kredit</th>
			</tr>
		</thead>
        <?php 
		$style = '';
		$jmlRow = count((array)$modelDetail);
        foreach ($modelDetail as $i=>$detail){ 
			if($i+1 == $jmlRow){
				$style = 'background-color:#999999;';
			}
        ?>
            <tr>
				<td>
					<span id="isi-r" name="[ii][uraian]"><?php echo isset($detail->jenisrekonsiliasibank_id) ? $detail->jenisrekonsiliasibank->jenisrekonsiliasibank_nama : ""; ?></span>
				</td>
				<td><span name="[ii][kode_rekening]"><?php echo $detail->getKodeRekening(); ?></span></td>
				<td><span name="[ii][nama_rekening]"><?php echo $detail->getNamaRekening(); ?></span></td>
				<td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint(isset($detail->saldodebit) ? $detail->saldodebit : 0); ?></td>
				<td style="text-align: right;"><?php echo MyFormatter::formatNumberForPrint(isset($detail->saldokredit) ? $detail->saldokredit : 0);?></td>
				<td><span name="[ii][keterangan]"><?php echo $detail->keterangan; ?></span></td>
			</tr>
        <?php } ?>
    </table>
<?php
if (isset($_GET['frame'])){
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); 
?>
    <script type='text/javascript'>
    /**
     * print
     */    
    function print(caraPrint){
        var rekonsiliasibank_id = '<?php echo isset($model->rekonsiliasibank_id) ? $model->rekonsiliasibank_id : null ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&rekonsiliasibank_id='+rekonsiliasibank_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
    
    </table>
<?php } ?>
