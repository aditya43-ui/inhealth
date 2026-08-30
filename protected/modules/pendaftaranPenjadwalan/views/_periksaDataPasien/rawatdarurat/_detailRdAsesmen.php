<?php
/**
* - digunakan untuk menampilkan prinout asesmen triage
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/themes/neon18/assets/css/custom.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutInput.css');

$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
));

?>

<table class="table border paddingtext">       
	<tr>
		<td colspan="4">
			<table class="table noborder paddingtext">
				<tr>		
					<td colspan="2" style="text-align: center;border-right: 1px solid !important;" width="25%">
						 <img src="<?php echo Params::urlProfilRSDirectory().$data->logo_rumahsakit ?> " style="float:left; max-width: 170px; width:170px;" class='image_report'/>
					</td>

					<td style="text-align: center;border-right: 1px solid !important;">
						<span color="black"><h4  style="padding-top:20px;"><?php echo ((isset($judulLaporan)) ? $judulLaporan : null); ?></h4></span>			
						Primary Survey
					</td>
					<td style="text-align: left;"  width="30%" colspan="">
						<table class="table noborder paddingtext">
							<tr>
								<td>No. RM</td>
								<td>: <?php echo $modPasien->no_rekam_medik; ?></td>
							</tr>
							<tr>
								<td>Nama Pasien</td>
								<td>: <?php echo $modPasien->namadepan.' '.$modPasien->nama_pasien; ?> </td>
							</tr>
							<tr>
								<td>Ttl</td>
								<td>:  <?php echo $modPasien->tempat_lahir.', '.date('d/m/Y', strtotime($modPasien->tanggal_lahir)); ?></td>
							</tr>
							<tr>
								<td>Jenis Kelamin</td>
								<td>: <?php echo $modPasien->jeniskelamin; ?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td colspan="4">
			<table class="table noborder paddingtext">	
				<tr>
					<td>
						Tanggal Kedatangan : <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modPendaftaran->tgl_pendaftaran))); ?>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</u>
						Pukul : <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<?php echo date("H:i:s", strtotime($modPendaftaran->tgl_pendaftaran)); ?>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</u> WIB
						</u>
					</td>
				</tr>
				<tr>
					<td>
						Dibawa ke IGD oleh : 
						<?php 
							$sendiri = false;
							$keluarga = false;
							$polisi = false;
							$lain = false;
							if (!empty($modPendaftaran->penanggungjawab_id)){
								if ($modPendaftaran->penanggungjawab->pengantar == Params::PENGANTAR_DIRI_SENDIRI){
									$sendiri = true;
								}elseif ($modPendaftaran->penanggungjawab->pengantar == Params::PENGANTAR_DIRI_SENDIRI){
									$keluarga = true;
								}elseif ($modPendaftaran->penanggungjawab->pengantar == Params::PENGANTAR_ORANG_POLISI){
									$polisi = true;
								}else{
									$lain = true;
								}
							}
						?>
						<?php echo CHtml::checkBox("tanggungjawab",$sendiri).' <label> Sendiri</label>' ?>
						<?php echo CHtml::checkBox("tanggungjawab",$keluarga).' <label> Keluarga</label>' ?>
						<?php echo CHtml::checkBox("tanggungjawab",$polisi).' <label> Polisi</label>' ?>
						<?php echo CHtml::checkBox("tanggungjawab",$lain).' <label> Lainnya</label>' ?> <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <?php echo ($lain)?$modPendaftaran->penanggungjawab->pengantar:'' ?> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u>
					</td>
				</tr>
				<tr>
					<td>
						Rujukan Dari : <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<?php echo (!empty($modPendaftaran->rujukan_id)?$modPendaftaran->rujukan->nama_perujuk:'') ?>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</u>
						Tanggal Rujukan : <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<?php echo (!empty($modPendaftaran->rujukan_id)?  MyFormatter::formatDateTimeForUser($modPendaftaran->rujukan->tanggal_rujukan):'') ?>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</u>
						</u>
					</td>
				</tr>
				<tr>
					<td>
						Orang yang dapat dihubungi : <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<?php echo (!empty($modPendaftaran->penanggungjawab_id)?$modPendaftaran->penanggungjawab->nama_pj:'') ?>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</u>
						Telepon/Hp : <u>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							<?php echo (!empty($modPendaftaran->penanggungjawab_id)?$modPendaftaran->penanggungjawab->no_teleponpj.'/'.$modPendaftaran->penanggungjawab->no_mobilepj:'') ?>
							&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</u>
						</u>
					</td>
				</tr>
				<tr>
					<td>
						Sosial ekonomi
					</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>		
        <td colspan="4">
			<table class="table noborder paddingtext">				
				<tr>
					<td>
						Pekerjaan : <u>&nbsp; &nbsp; &nbsp; &nbsp; <?php echo (!empty($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:'') ?>
						&nbsp; &nbsp; &nbsp; &nbsp;</u>
						Agama : <u>&nbsp; &nbsp; &nbsp; &nbsp; <?php echo (!empty($modPasien->agama)?$modPasien->agama:'') ?>
						&nbsp; &nbsp; &nbsp; &nbsp;</u>
						No. Telp/Hp Pasien : <u>&nbsp; &nbsp; &nbsp; &nbsp; <?php echo $modPasien->no_telepon_pasien.'/'.$modPasien->no_mobile_pasien; ?>
						&nbsp; &nbsp; &nbsp; &nbsp;</u>
					</td>
				</tr>
				<tr>
					<td>
						<div class="control-group">
							<label class="control-label" style="text-align:left">Pembiayaan</label>
							<div class="controls">
								<?php
									$bpjs = false;
									$asuransi = false;
									$umum = false;
									if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS){
										$bpjs = true;
									}elseif ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_ASURANSI){
										$asuransi = true;
									}elseif ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR){
										$umum = true;
									}
								?>
								<?php echo CHtml::checkBox("pembayaran",$bpjs).' <label> BPJS</label>' ?>
								<?php echo CHtml::checkBox("pembayaran",$asuransi).' <label> ASURANSI</label>' ?>
								<?php echo CHtml::checkBox("pembayaran",$umum).'<label>  Umum</label>' ?>
							</div>
						</div> 
						<div class="clear"></div>
						<div class="control-group">

								<label class="control-label" style="width:100%;text-align: left;">
									<?php echo $form->checkBox($modAsesTriase,'trauma',array('onchange'=>'cekTrauma(this);','val'=>'trauma')) ?> <label> Trauma</label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
									<?php echo $form->checkBox($modAsesTriase,'nontrauma',array('onchange'=>'cekTrauma(this);','val'=>'nontrauma')) ?> <label> Non Trauma</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<?php echo $form->checkBox($modAsesTriase,'isobstetri') ?> <label> Obstetri</label>
								</label>
						</div>     
					</td>
				</tr>
			</table>
        </td>
    </tr>  	
	<?php echo $this->renderPartial($this->path_viewRd.'print._printformTriase',array('modLookup'=>$modLookup,'dataTriase'=>$dataTriase,'form'=>$form,'modAsesTriase'=>$modAsesTriase,'modAsesTriDet'=>$modAsesTriDet,'getTriase'=>$getTriase),true); ?>
	
	<?php echo $this->renderPartial($this->path_viewRd.'print._printGCS',array('form'=>$form,'modAsesTriase'=>$modAsesTriase,'modAsesTriDet'=>$modAsesTriDet,'getTriase'=>$getTriase),true); ?>
</table>
<?php echo $this->renderPartial($this->path_view_pencarian.'rawatdarurat._printformNyeriV2',array('modFlaCcs'=>$modFlaCcs,'modAsesTriase'=>$modAsesTriase,'getFlaCcs'=>$getFlaCcs,'dataFlaCcs'=>$dataFlaCcs,'modFisik'=>$modFisik,'form'=>$form),true); ?>                                                    

<?php $this->endWidget(); ?>

