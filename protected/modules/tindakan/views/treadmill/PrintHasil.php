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
    echo $this->renderPartial('_headerPrint'); 
}
?>
    <table width="74%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td>TANGGAL</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modTreadmill->tgltreadmill); ?></td>
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td><?php echo isset($modTreadmill->pasien->nama_pasien) ? $modTreadmill->pasien->nama_pasien : ""; ?></td>
            
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>UMUR</td>
            <td>:</td>
            <td><?php echo isset($modPendaftaran->umur) ? $modPendaftaran->umur : ""; ?></td>
			
			<td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>PEGAWAI</td>
            <td>:</td>
            <td><?php echo isset($modTreadmill->pegawai->NamaLengkap) ? $modTreadmill->pegawai->NamaLengkap : ""; ?></td>
			
			<td></td>
            <td></td>
            <td></td>
        </tr>
    </table><br>
    <table width="100%" style='margin-left:auto; margin-right:auto;' border="1">
        <thead class="border">
			<tr>
				<th style="text-align: center;" rowspan="2">AGE ELEV</th>
				<th style="text-align: center;" rowspan="2">DURATION <br> (Min.)</th>
				<th style="text-align: center;" rowspan="2">WORK LOAD <br> (Kph)</th>
				<th style="text-align: center;" rowspan="2">EST. 02 RATE <br>1/min</th>
				<th style="text-align: center;" rowspan="2">MAX. 02 INTAKE <br>ml/kg/min</th>
				<th style="text-align: center;" rowspan="2">METS</th>
				<th style="text-align: center;" colspan="5">FITNESS CLASSIFICATION <br> AGE (YEARS)</th>
				<th style="text-align: center;" rowspan="2">FUNCTIONAL CLASS</th>
				<th style="text-align: center;" colspan="4">RECOMMENDED EXERCISE</th>
			</tr>
			<tr>
				<th>20-29</th>
				<th>30-39</th>
				<th>40-49</th>
				<th>50-59</th>
				<th>60-69</th>
				<th>WALKING <br> km/hr</th>
				<th>JOGGING <br> km/hr</th>
				<th>BICYCLING <br> km/hr</th>
				<th>OTHERS SPORT</th>
			</tr>
            
        </thead>
        <?php 
		$style = '';
		$jmlRow = count((array)$modTreadmillDetail);
        foreach ($modTreadmillDetail as $i=>$detail){ 
			if($i+1 == $jmlRow){
				$style = 'background-color:#999999;';
			}
        ?>
            <tr>
                <td align="center"><?php echo $detail->age_elev; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo $detail->duration_treadmill; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo $detail->workload_kph; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo $detail->est02_rate_min; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo $detail->max02_intake; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo $detail->mets_treadmill; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo (substr($modPendaftaran->umur, 0,2) >= 20 && substr($modPendaftaran->umur, 0,2) <= 29) ? $detail->fitnessclassification : ""; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo (substr($modPendaftaran->umur, 0,2) >= 30 && substr($modPendaftaran->umur, 0,2) <= 39) ? $detail->fitnessclassification : ""; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo (substr($modPendaftaran->umur, 0,2) >= 40 && substr($modPendaftaran->umur, 0,2) <= 49) ? $detail->fitnessclassification : ""; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo (substr($modPendaftaran->umur, 0,2) >= 50 && substr($modPendaftaran->umur, 0,2) <= 59) ? $detail->fitnessclassification : "";; ?></td>
                <td align="center" style="<?php echo $style;?>"><?php echo (substr($modPendaftaran->umur, 0,2) >= 60 && substr($modPendaftaran->umur, 0,2) <= 69) ? $detail->fitnessclassification : "";; ?></td>
                <td align="center"><?php echo $detail->functional_class_treadmill; ?></td>
                <td align="center"><?php echo $detail->walking_kmhr_treadmill; ?></td>
                <td align="center"><?php echo $detail->jogging_kmhr_treadmill; ?></td>
                <td align="center"><?php echo $detail->bicycling_kmhr_treadmill; ?></td>
                <td align="center"><?php echo $detail->sports_kmhr_treadmill; ?></td>
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
        var treadmill_id = '<?php echo isset($modTreadmill->treadmill_id) ? $modTreadmill->treadmill_id : null ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&treadmill_id='+treadmill_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
    <table width="100%" style="margin-top:20px;">
    <tr>
        <td><i>Committee on exercise American Heart Association 1972 Mono : Use a rule you'll fixed everything right away</i></td>
        <td></td>
        <td width="30%" align="center" align="top">
            <div><?php echo Yii::app()->user->getState("kabupaten_nama").", ".MyFormatter::formatDateTimeId(date('Y-m-d')); ?></div>
            <div>Operator</div>
            <div style="margin-top:60px;"><?php echo Yii::app()->user->getState('nama_pegawai'); ?></div>
        </td>
    </tr>
    
    </table>
<?php } ?>
