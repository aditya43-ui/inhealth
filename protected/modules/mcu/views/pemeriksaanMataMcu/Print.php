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
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' border="1">
        <thead class="border">
			<tr>
				<th></th>
				<th style='text-align:center;'>Vitrum Spher</th>
				<th style='text-align:center;'>Vitrum Cylindr</th>
				<th style='text-align:center;'>Axis</th>
				<th style='text-align:center;'>Prisma Basis</th>
				<th style='text-align:center;'>Vitrum Spher</th>
				<th style='text-align:center;'>Vitrum Cylindr</th>
				<th style='text-align:center;'>Axis</th>
				<th style='text-align:center;'>Prisma Basis</th>
				<th style='text-align:center;'>Forma Vitror</th>
				<th style='text-align:center;'>Color Vitror</th>
				<th style='text-align:center;'>Distant Vitror</th>
				<th style='text-align:center;'>Forma Jugi</th>
			</tr>
        </thead>
        <?php 
        foreach ($modUkuranKacamata as $i=>$detail){ 
        ?>
            <tr>
                <td><?php echo $detail->jenis_ukuran; ?></td>
                <td align="center"><?php echo $detail->vitrum_spher_right; ?></td>
                <td align="center"><?php echo $detail->vitrum_cylindr_right; ?></td>
                <td align="center"><?php echo $detail->axis_right; ?></td>
                <td align="center"><?php echo $detail->prisma_basis_right; ?></td>
                <td align="center"><?php echo $detail->vitrum_spher_left; ?></td>
                <td align="center"><?php echo $detail->vitrum_cylindr_left; ?></td>
                <td align="center"><?php echo $detail->axis_left; ?></td>
                <td align="center"><?php echo $detail->prisma_basis_left; ?></td>
                <td align="center"><?php echo $detail->forma_vitror; ?></td>
                <td align="center"><?php echo $detail->color_vitror; ?></td>
                <td align="center"><?php echo $detail->distant_vitror; ?></td>
                <td align="center"><?php echo $detail->forma_jugi; ?></td>
            </tr>
        <?php } ?>
    </table>
	<br>
	<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td>Pro </td>
            <td>:</td>
            <td><?php echo $modPeriksaKacamata->pro_kacamata; ?></td>
            
			<td>Umur</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->umur; ?></td>
		</tr>
		<tr>
            <td>No. Pegawai</td>
            <td>:</td>
            <td><?php echo $modPeriksaKacamata->pegawai->nomorindukpegawai; ?></td>
			
			<td></td>
            <td></td>
            <td></td>
		</tr>
		<tr>
			<td>Permintaan Ke</td>
            <td>:</td>
            <td><?php echo $modPeriksaKacamata->permintaanke_kacamata; ?></td>
			
			<td></td>
            <td></td>
            <td></td>
		</tr>
		<tr>
			<td>Jatuh Tempo</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeId($modPeriksaKacamata->jatuhtempo_kacamata); ?></td>
			
			<td></td>
            <td></td>
            <td></td>
        </tr>
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
        var periksakacamata_id = '<?php echo isset($modPeriksaKacamata->periksakacamata_id) ? $modPeriksaKacamata->periksakacamata_id : null ?>';
		var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&periksakacamata_id='+periksakacamata_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
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
