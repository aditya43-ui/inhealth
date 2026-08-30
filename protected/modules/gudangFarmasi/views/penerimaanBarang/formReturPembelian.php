<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Retur Penerimaan Persediaan Farmasi</div>
            </div>
            <div class="panel-body">
				<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
					'id'=>'retur-pembelian-m-form',
					'enableAjaxValidation'=>false,
					'type'=>'horizontal',
					'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)', 'onsubmit'=>'return cekValidasi(this);'),
					'focus'=>'#GFReturPembelianT_ruangan_id',
				)); ?>

				<?php 
					if(isset($_GET['sukses'])){
						Yii::app()->user->setFlash('success',"Data Pembelian berhasil diretur !");
					}
				?>
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
				<div class="row-fluid">
					<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
					<?php echo $form->errorSummary($modPembelian); ?>
					<?php echo $form->hiddenField($modPenerimaan,'penerimaanbarang_id'); ?>
					<?php echo $form->hiddenField($modPenerimaan,'fakturpembelian_id'); ?>
					<div class="col-sm-6">
						<?php echo $form->textFieldRow($modPembelian,'tglretur',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
						<?php echo $form->dropDownListRow($modPembelian, 'ruangan_id', CHtml::listData(RuanganM::model()->getRuanganByInstalasi(!empty($modPenerimaan->gudangpenerima_id)?$modPenerimaan->gudangpenerima->instalasi_id:null), 'ruangan_id', 'ruangan_nama'),
							array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
							'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
						<?php echo $form->dropDownListRow($modPembelian,'supplier_id', CHtml::listData(SupplierM::model()->getSupplierItems(),'supplier_id','supplier_nama'),
							array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",
							'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
					</div>
					<div class="col-sm-6">
						<?php echo $form->textAreaRow($modPembelian,'alasanretur',array('cols'=>5, 'rows'=>3, 'onkeypress'=>'return $(this).focusNextInputField(event)')); ?>					
						<?php echo $form->textAreaRow($modPembelian,'keteranganretur',array('cols'=>5, 'rows'=>3, 'onkeypress'=>'return $(this).focusNextInputField(event)')); ?>
					</div>
				</div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Retur Penerimaan</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div id="divTabelRetur">
							<?php echo $form->errorSummary($modPenerimaanDet); ?>
							<?php $this->renderPartial('_tblReturPembelianFaktur',array('modPenerimaanDet'=>$modPenerimaanDet,'modFakturPembelian'=>$modFakturPembelian)); ?>
						</div>
                    </div>
                </div>	
				
				<?php // echo $this->renderPartial('_formReturFakturPembelian',array('form'=>$form,'modFakturPembelian'=>$modFakturPembelian),true); ?>
				<?php // echo $this->renderPartial('_formReturFakturPenerimaanKas',array('form'=>$form,'modFakturPembelian'=>$modFakturPembelian, 'modTandabukti'=>$modTandabukti, 'modPenUmum'=>$modPenUmum),true); ?>
				
				<div class="form-actions">		
					<?php
						if(!isset($_GET['sukses'])){
							echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
						}else{
							echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);','disabled'=>true)); 
							echo "&nbsp;";
						}
					?>
					<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
						Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/returPembelianOA'), 
						array('class'=>'btn btn-danger',
						'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
					<?php	
						$content = $this->renderPartial('../tips/tipsadd',array(),true);
						$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
				</div>
				<?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->renderPartial('_jsRetur', array(), true); ?>
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogJenisPenerimaan',
    'options'=>array(
        'title'=>'Daftar Jenis Penerimaan',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modJenisPenerimaan = new JenispenerimaanM();
$modJenisPenerimaan->unsetAttributes();
if(isset($_GET['JenispenerimaanM'])) {
    $modJenisPenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'jenispenerimaan-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modJenisPenerimaan->searchJenisPenerimaanRek(),
	'filter'=>$modJenisPenerimaan,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No',
			'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
		),
		array(
			'header'=>'Jenis Penerimaan',
			'name'=>'jenispenerimaan_nama',
			'value'=>'$data->jenispenerimaan_nama',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'jenispenerimaan_namalain',
			'value'=>'$data->jenispenerimaan_namalain',
		),
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					getDataRekening($data->jenispenerimaan_id);
					$(\"#KUPenerimaanUmumT_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
					$(\"#KUPenerimaanUmumT_jenisKodeNama\").val(\"$data->jenispenerimaan_nama\");
					$(\"#dialogJenisPenerimaan\").dialog(\"close\");    
					return false;
			"))',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

