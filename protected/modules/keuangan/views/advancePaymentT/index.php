<style type="text/css">
    .integer-decimal{
        text-align: right;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->breadcrumbs=array(
	'Advance Payment Dan Request Of Payment',
);?>
<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'advancepayment-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'focus'=>'#',
		'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
						),
						// 'onsubmit'=>'return cekInputan();'
	));

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                    <div class="panel-title">Transaksi <strong><span id="jenis_transaksi">Advance Payment</span></strong></div>
            </div>            
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Pengajuan</div>
                    </div>
                    <div class="panel-body">
					<?php //$this->widget('bootstrap.widgets.BootAlert'); ?>
					<?php

// exit('asdasd');
					// 
                        if(isset($_GET['sukses'])){
							// exit('asdasd');
							Yii::app()->user->setFlash('success', "Transaksi berhasil disimpan !");
							$this->widget('bootstrap.widgets.BootAlert');
						}?>
						<?php 
								$this->renderPartial($this->path_view.'_dataPengajuan',array(
                                   'form' => $form,
								   'model' => $model,
								   'modTandaBuktiKeluar'=>$modTandaBuktiKeluar

                                ));
						?>

						<?php //echo $form->errorSummary(array($modelBayar,$modBuktiKeluar)); ?>
                    </div>
                </div>			
				
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Data Pengeluaran Kas</div>
					</div>
					<div class="panel-body">
					<?php 
								$this->renderPartial('_dataPengeluaranKas',array(
                                   'form'=>$form,
								   'model'=>$model,
								   'modTandaBuktiKeluar'=>$modTandaBuktiKeluar
                                ));
						?>	
					</div>
				</div>
			
				<div class="form-actions">
					<?php 
						$disabled = ((isset($_GET['advancepayment_id'])) ? true : false);
						echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
								array('class'=>'btn btn-primary', 'type'=>'button', 'onclick' => 'simpanDataTransaksi();', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disabled)).'&nbsp;'; 
						echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/advancePaymentT/index'), array('class' => 'btn btn-danger',
							'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id . '/advancePaymentT/index').'";}); return false;')).'&nbsp;';
					?>
					 <?php
						if(isset($_GET['advancepayment_id'])){
							echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print('PRINT');return false",'disabled'=>FALSE  ));
						}else{							
							
						
							echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE  ));
						}
					 ?>
				</div>
				
            </div>
        </div>
    </div>
</div>
<?php echo $this->renderPartial('_jsFunctions'); ?>
	<?php $this->endWidget(); ?>
<script type="text/javascript">
 

</script>