<style>
	.tr_pilih {
		background-color: yellow !important;
	}
</style>
<?php 
$pendaftaran = PendaftaranT::model()->findByPk($modKunjungan->pendaftaran_id);
if(!empty($pendaftaran)) {
    if($pendaftaran->validasiRekamMedis()) {
       echo CustomFunction::alertRekamMedis();
    }
}
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Transaksi <b>Resume Medis</b></div>
	</div>
	<div class="panel-body">
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

		<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
				'id'=>'pemakaianbahp-form',
				'enableAjaxValidation'=>false,
				'type'=>'horizontal',
				'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
				'focus'=>'#no_pendaftaran',
		)); ?>

		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title" id="judul-form-datakunjungan">
					<span class='judul'><b>Data Kunjungan </b></span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span>
				</div>
			</div>
			<div class="panel-body" id="form-datakunjungan">
				<div class="row-fluid">
					<?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
				</div>
			</div>
		</div>

                <div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Riwayat Resume Medis</div>
			</div>
			<div  class="panel-body" id="form-dataresume">
					<?php $this->renderPartial($this->path_view.'grid/_daftarRiwayat',array('model'=>$modResume)); ?>
			</div>
		</div>
            
            
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="panel-title">Resume Medis</div>
			</div>
			<div  class="panel-body" id="form-dataresume">
					<?php $this->renderPartial($this->path_view.'_formResumeMedis',array('modKunjungan'=>$modKunjungan,'modResume'=>$modResume,'form'=>$form,  'riwayatDiagnosaICDX' => $riwayatDiagnosaICDX, 'riwayatDiagnosaICD9' => $riwayatDiagnosaICD9, 'riwayatDiagnosaKematian' => $riwayatDiagnosaKematian, 'riwayatObatAlkesPasien' => $riwayatObatAlkesPasien)); ?>
			</div>
		</div>

		<div class="row-fluid">
			<div class="form-actions">
				<?php if (isset($_GET['lihat'])) { ?>
					<?php echo ""; ?>
				<?php }else{ ?>
					<?php
						$disabledtombol = (isset($_GET['sukses'])? true: false);
						echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('id' => 'btn_simpan','class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekValidasi()', 'onkeypress'=>'formSubmit(this,event);', 'disabled'=>$disabledtombol));
						echo "&nbsp;";
						echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
								$this->createUrl($this->module->id.'/index'),
								array('class'=>'btn btn-danger',
									'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
						echo "&nbsp;";
						echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false", 'disabled'=> (($disabledtombol==true)?false:true)));
						echo "&nbsp;";
					
						$content = $this->renderPartial($this->path_view.'tips/tipsPemakaianBahan',array(),true);
						$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
					?>
				<?php }?>
			</div>
		</div>
    <?php $this->endWidget(); ?>
	</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'modResume'=>$modResume,'dataDiagnosa'=>$dataDiagnosa)); ?>
</div>
