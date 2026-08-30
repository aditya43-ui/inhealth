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
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
    </table><br>
	<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Tgl. Pemanggilan MCU </td>
            <td>:</td>
            <td><?php echo isset($modPemanggilan->tglpemanggilanmcu) ? MyFormatter::formatDateTimeForUser($modPemanggilan->tglpemanggilanmcu) : ""; ?></td>
            
			<td>No. Pemanggilan</td>
            <td>:</td>
            <td><?php echo isset($modPemanggilan->no_pemanggilan) ? $modPemanggilan->no_pemanggilan : ""; ?></td>
		</tr>
		<tr>
            <td>Tgl. Akan Periksa MCU </td>
            <td>:</td>
            <td><?php echo isset($modPemanggilan->tglakanperiksamcu) ? MyFormatter::formatDateTimeForUser($modPemanggilan->tglakanperiksamcu) : ""; ?></td>
			
			<td>Keterangan Pemanggilan</td>
            <td>:</td>
            <td><?php echo isset($modPemanggilan->keterangan_pemanggilan) ? $modPemanggilan->keterangan_pemanggilan : ""; ?></td>
		</tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' border="1">
        <thead class="border">
			<tr>
				<th style='text-align:center;'>No.</th>
				<th style='text-align:center;'>Tgl. Rencana MCU</th>
				<th style='text-align:center;'>Tgl. Pemanggilan MCU</th>
				<th style='text-align:center;'>Tgl. Akan Diperiksa</th>
				<th style='text-align:center;'>No. Rekam Medik</th>
				<th style='text-align:center;'>Nama Pasien</th>
				<th style='text-align:center;'>Pemanggilan Pasien Ke-</th>
			</tr>
        </thead>
        <?php 
        foreach ($modPemanggilanDetail as $i=>$detail){ 
        ?>
            <tr>
                <td align="center"><?php echo ($i+1); ?></td>
                <td align="center"><?php echo isset($detail->pendaftaran->tglrenkontrol) ? MyFormatter::formatDateTimeForUser($detail->pendaftaran->tglrenkontrol) : ""; ?></td>
                <td align="center"><?php echo isset($detail->tglpemanggilanmcu) ? MyFormatter::formatDateTimeForUser($detail->tglpemanggilanmcu) : ""; ?></td>
                <td align="center"><?php echo isset($detail->tglakanperiksamcu) ? MyFormatter::formatDateTimeForUser($detail->tglakanperiksamcu) : ""; ?></td>
                <td align="center"><?php echo isset($detail->pasien->no_rekam_medik) ? $detail->pasien->no_rekam_medik : ""; ?></td>
                <td align="left"><?php echo isset($detail->pasien->nama_pasien) ? $detail->pasien->nama_pasien : ""; ?></td>
                <td align="center"><?php echo isset($detail->pemanggilanke) ? $detail->pemanggilanke : ""; ?></td>
            </tr>
        <?php } ?>
    </table>
	<br>
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
		var no_pemanggilan = '<?php echo isset($_GET['no_pemanggilan']) ? $_GET['no_pemanggilan'] : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&no_pemanggilan='+no_pemanggilan+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
    
    </table>
<?php } ?>
