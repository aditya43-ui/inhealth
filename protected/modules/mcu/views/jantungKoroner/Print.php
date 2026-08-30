<?php
/**
 * view untuk mengenerate prinout
 * issue RSST-2812
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 21.7cm;
    }
    .content td{
        height: 48px;
    }
	.break { page-break-before: always; }
/*	table { page-break-inside:auto }
	tr    { page-break-inside:avoid; page-break-after:auto }*/
</style>
<?php
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial($this->path_view.'_headerMcu'); 
}
?>
<table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" valign="middle" colspan="3">
			<b><?php echo $judul_print ?></b>
		</td>
	</tr>
</table><br>

<table class="table-condensed" width="100%">
	<tr>
		<td width="100%">
			<b>Analisa ini mengidentifikasi resiko terjadinya Penyakit Jantung Koroner selama 10 tahun kedepan</b>
		</td>
	</tr>
</table>
<div class="row">
	<div class="span12">
		<!--<fieldset class="well">-->
			<table class="table-condensed" width="100%">	
			<tr>            
				<td width="100%">
					<table width="100%" id="form-riwayatpekerjaan-mcu" border="1">
						<thead>
							<tr>
								<th style='text-align:center;'>Faktor Risiko</th>
								<th style='text-align:center;'>Hasil</th>
								<th style='text-align:center;'>Level</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><b>Total Kolesterol</b></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->total_kolesterol; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->total_kolesterol_level; ?></td>
							</tr>
							<tr>
								<td><b>Triglyceride</b></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->triglycerida; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->triglycerida_level; ?></td>
							</tr>
							<tr>
								<td><b>HDL Kolesterol</b></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->hdl_kolesterol; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->hdl_kolesterol_level; ?></td>
							</tr>
							<tr>
								<td><b>LDL Kolesterol</b></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->ldl_kolesterol; ?></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->ldl_kolesterol_level; ?></td>
							</tr>
							<tr>
								<td><b>Tekanan Darah</b></td>
								<td style="text-align: center;"><?php echo $modJantungKoroner->tekanandarah; ?></td>
								<td style="text-align: center;"><?php
                                                                    if($modJantungKoroner->tekanandarah < 120){
                                                                        echo '< 120';
                                                                    }else if($modJantungKoroner->tekanandarah == 120 || $modJantungKoroner->tekanandarah <= 129){
                                                                        echo '120 - 129';
                                                                    }else if($modJantungKoroner->tekanandarah == 130 || $modJantungKoroner->tekanandarah <= 139){
                                                                        echo '130 - 139';
                                                                    }else if($modJantungKoroner->tekanandarah == 140 || $modJantungKoroner->tekanandarah <= 149){
                                                                        echo '140 - 149';
                                                                    }else if($modJantungKoroner->tekanandarah == 150 || $modJantungKoroner->tekanandarah <= 159){
                                                                        echo '150 - 159';
                                                                    }else if($modJantungKoroner->tekanandarah > 160){
                                                                        echo '> 160';
                                                                    }
                                                                ?></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td width="100%">
					Resiko Serangan Jantung dalam 10 tahun &nbsp;&nbsp;&nbsp; (Hasil Presentase <?php echo !empty($modJantungKoroner->hasil_resiko_persen)? ": ".$modJantungKoroner->hasil_resiko_persen.'%':'<i> - </i>'; ?>)
				</td>
			</tr>
			<tr>
				<td width="100%">
					Hasil dari review faktor Resiko Jantung Koroner Lainnya
				</td>
			</tr>
		</table>
		<table class="table-condensed" width="100%">
			<tr>            
				<td>
					<b>Hasil Review</b>
				</td>
				<td>
					<div style="border:2px solid black;">
						<p align="justify"><?php echo $modJantungKoroner->hasil_review_ab; ?></p>
					</div>
				</td>
			</tr>
			<tr>            
				<td>
					<b>Gangguan Metabolisme</b>
				</td>
				<td>
					<?php
						if(empty($modJantungKoroner->gangguan_metabolisme)){
							$style = 'style="border:2px solid black;padding-bottom: 50px;"';
						}else{
							$style='style="border:2px solid black;"';
						}
					?>
					<div <?php echo $style; ?>>
						<p align="justify"><?php echo $modJantungKoroner->gangguan_metabolisme; ?></p>
					</div>
				</td>
			</tr>
		</table>
		<!--</fieldset>-->
	</div>
</div>
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
        var jantungkoroner_id = '<?php echo isset($modJantungKoroner->jantungkoroner_id) ? $modJantungKoroner->jantungkoroner_id : null ?>';
		var pendaftaran_id = '<?php echo isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null; ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&jantungkoroner_id='+jantungkoroner_id+'&pendaftaran_id='+pendaftaran_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
    }
    </script>
<?php
}else{ ?>
<?php } ?>
<?php 
$profil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
        $alamat=!empty($profil->alamatlokasi_rumahsakit)?$profil->alamatlokasi_rumahsakit:"";
	$motto=!empty($profil->motto)?$profil->motto:"";
        $telp=!empty($profil->no_telp_profilrs)?$profil->no_telp_profilrs:"";
        $email=!empty($profil->email)?$profil->email:"";
        $website=!empty($profil->website)?$profil->website:"";
        $layoutkiri=$alamat."<br>"."Telp:".$telp." Email:".$email." Website:".$website;
?>
<table width="100%" class="footer">
    <tr><td width="70%" style="text-align:left" align="left" class="alamatfooter"><?php echo  $layoutkiri ?></td><td class="mottofooter" style="text-align:right"  width="30%" align="right"><?php echo $motto ?></td></tr>
        
</table>