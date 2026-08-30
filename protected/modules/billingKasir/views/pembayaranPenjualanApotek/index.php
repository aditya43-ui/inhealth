<style type="text/css">
	.integer2, .integer-decimal{
		text-align: right;
	}
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'bkpembayaranpelayanan-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
		'focus'=>'#jenispenjualan',
)); ?>
<?php echo $form->errorSummary($modPenjualan); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modTandabukti); ?>
<?php echo $form->errorSummary($modPemakaianuangmuka); ?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary panel-gradient">
			<div class="panel-heading">
				<div class="panel-title">Pembayaran <strong>Penjualan Apotek</strong></div>
			</div>
			<div class="panel-body">
				<div class="panel panel-success panel-shadow">
					<div class="panel-heading" id="form-datapenjualan">
						<div class="panel-title"><span class='judul'>Data Penjualan </span> <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setPenjualanReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data penjualan')); ?></span></div>
					</div>
					<div class="panel-body">
						<div class="row-fluid">
							<?php $this->renderPartial('_formInfoPenjualan', array('form'=>$form,'modPenjualan'=>$modPenjualan)); ?>
						</div>
					</div>
				</div>
				<div class="panel panel-success panel-shadow">
					<div class="panel-heading">
						<div class="panel-title">Rincian Tagihan <strong>Penjualan Apotek</strong> <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setRincianObatalkes();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh rincian tagihan apotek')); ?></div>
					</div>
					<div class="panel-body">
						<div class="row-fluid">
							<div style="overflow-x: auto; max-width: 100%; margin-bottom: 5px;" id="form-rincianobatalkes">
								<?php $this->renderPartial('_formRincianPenjualanApotek', array('dataOas'=>$dataOas)); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-success panel-shadow">
						<div class="panel-heading">
								<div class="panel-title"><strong>Total Rincian Pelayanan</strong></div>
						</div>
						<div class="panel-body">
								<div class="row-fluid">
									<div style="overflow-x: auto; max-width: 100%;" id="form-rinciansemua">
											<?php $this->renderPartial('_formRincianTotal', array()); ?>
									</div>
								</div>
						</div>
				</div>
				<div class="panel panel-success panel-shadow">
					<div class="panel-heading">
						<div class="panel-title">Data Pembayaran</div>
					</div>
					<div class="panel-body">
						<div class="row-fluid">
							<?php
			                if(isset($_GET['sukses'])){
								Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan !");
								$this->widget('bootstrap.widgets.BootAlert');
							}?>
							<?php
								echo $form->hiddenField($model,'noresep',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
								echo $this->renderPartial($this->path_view.'_formPembayaran', array('form'=>$form,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka), true);
							?>
						</div>
					</div>
				</div>
				<div class="form-actions">
					<?php
						if($model->isNewRecord){
							echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); //formSubmit(this,event)
						}else{
							echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;'));
						}
					?>
					<?php
						if(!isset($_GET['frame'])){
							echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
								$this->createUrl($this->id.'/index'),
								array('class'=>'btn btn-danger',
									  'onclick'=>'return refreshForm(this);'));
						}
					?>
					<?php
						if($model->isNewRecord){
							echo CHtml::link(Yii::t('mds', '{icon} Invoice', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincian(\"PRINT\");return false",'disabled'=>TRUE  ));
							echo "&nbsp;";
							echo CHtml::link(Yii::t('mds', '{icon} Print BKM', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                            echo "&nbsp;";
                            echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
						}else{
							echo CHtml::link(Yii::t('mds', '{icon} Invoice', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printRincian(\"PRINT\");return false",'disabled'=>FALSE  ));
							echo "&nbsp;";
							echo CHtml::link(Yii::t('mds', '{icon} Print BKM', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printBkm(\"PRINT\");return false",'disabled'=>FALSE  ));
                            echo "&nbsp;";
                            echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKuitansi();return false",'disabled'=>FALSE  ));
						}
					?>
					<?php
						$content = $this->renderPartial($this->path_view.'tips/tipsPembayaranTagihanPasien',array(),true);
						$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
					?>
				</div>

				<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPenjualan'=>$modPenjualan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
				<?php $this->renderPartial('_jsFunctions', array('modPenjualan'=>$modPenjualan,'model'=>$model,'modTandabukti'=>$modTandabukti,'modPemakaianuangmuka'=>$modPemakaianuangmuka)); ?>
				<?php $this->endWidget(); ?>


				<?php
				$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
					'id'=>'dialog-verifikasi',
					'options'=>array(
						'title'=>'Verifikasi Pembayaran',
						'autoOpen'=>false,
						'modal'=>true,
						'minWidth'=>960,
						'minHeight'=>480,
						'resizable'=>false,
					),
				));

				echo '<div class="dialog-content"></div>';
				?>
				<div class="row-fluid">
					<div class="form-actions">
						<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); simpanPembayaranPel();')); ?>
						<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
					</div>
				</div>
				<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
