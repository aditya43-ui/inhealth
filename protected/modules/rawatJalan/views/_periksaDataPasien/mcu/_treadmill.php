
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
$format = new MyFormatter
?>
    <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
        <tr>
            <td width="100">TANGGAL</td>
            <td width="10">:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modTreadmill->tgltreadmill); ?></td>
            
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
				<th style="text-align: center;" rowspan="2">EST. 02 RATE <br>1/Min</th>
				<th style="text-align: center;" rowspan="2">MAX. 02 INTAKE <br>ml/kg/Min</th>
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
