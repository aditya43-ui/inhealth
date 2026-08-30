<style type="text/css">
	.integer-decimal{
		text-align: right;
	}
</style>

<?php $linkHalaman = CustomFunction::getUrlByMenuID(261); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'bkbayaruangmuka-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
	'focus'=>'#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modKunjungan); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modTandabukti); ?>
<?php echo $form->errorSummary($modPemakaianuangmuka); ?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-gradient">
			<div class="panel-heading">
				<div class="panel-title">Pembayaran Uang <strong>Muka Pasien</strong></div>
			</div>
			<div class="panel-body">
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Data Kunjungan <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></div>
					</div>
					<div class="panel-body" id="form-datakunjungan">
						<!--fieldset class="box" id="form-datakunjungan"-->
							<div class="row-fluid">
								<?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
							</div>
						<!--/fieldset-->
					</div>
				</div>
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Data Pembayaran</div>
					</div>
					<div class="panel-body" id="">
						<?php
						if(isset($_GET['sukses'])){
							Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan!");
							$this->widget('bootstrap.widgets.BootAlert');
						}?>
						<?php $this->renderPartial('_formPembayaran', array('form'=>$form,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
					</div>
				</div>
				<div class="form-actions">
					<?php
						if($model->isNewRecord){
							echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); //formSubmit(this,event)
						}else{
							echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;'));
						}
					?>
					<?php
						if(!isset($_GET['frame'])){
							echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
								$this->createUrl($this->id.'/index'),
								array('class'=>'btn btn-danger',
									  'onclick'=>'return refreshForm(this);'));
						}
					?>
					<?php
						echo CHtml::link(Yii::t('mds', '{icon} Print Print Rincian Tagihan', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincianBelumBayar();return false",'disabled'=>FALSE  ));
						echo "&nbsp;";
						if(!isset($_GET['sukses'])){
							echo CHtml::link(Yii::t('mds', '{icon} Print Rincian Pembayaran', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
							// echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
							echo "&nbsp;";
							echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
							// echo "&nbsp;";
						}else{
							echo CHtml::link(Yii::t('mds', '{icon} Print Rincian Pembayaran', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincian();return false",'disabled'=>FALSE  ));
							// echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printBuktiKasMasuk();return false",'disabled'=>FALSE  ));
							echo "&nbsp;";
							echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKuitansi();return false",'disabled'=>FALSE  ));
							// echo "&nbsp;";
						}
					?>
					<?php
						$content = $this->renderPartial($this->path_view.'tips/tipsPembayaranTagihanPasien',array(),true);
						$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
					?>
				</div>
				<?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
				<?php $this->endWidget(); ?>
				<?php
				$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id'=>'dialog-verifikasi',
					'options'=>array(
						'title'=>'Verifikasi Pembayaran',
						'autoOpen'=>false,
						'modal'=>true,
						'minWidth'=>960,
						'minHeight'=>550,
						'resizable'=>false,
					),
				));

				echo '<div class="dialog-content"></div>';
				?>
				<div class="row-fluid">
					<div class="form-actions">
						<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'simpanUangMukaPasien(this);')); ?>
						<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
