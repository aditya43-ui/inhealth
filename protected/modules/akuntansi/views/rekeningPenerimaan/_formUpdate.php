<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'jenispenerimaan-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
	'focus'=>'#',
)); ?>
<?php
    if(!empty($_GET['id'])){
?>
     <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert">×</a>
        Data berhasil disimpan
    </div>
<?php } ?>
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary($model); ?>
	<table>
		<tr>
			<td>
				<div class='control-group'>
					<?php echo $form->labelEx($model,'jenispenerimaan_id', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo $form->hiddenField($model,'jenispenerimaan_id',array('class'=>'span3','maxlength'=>50)); ?>
						<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'jnsNama',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/jenisPenerimaan'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.jenispenerimaan_nama);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.jenispenerimaan_nama);
													$("#' . CHtml::activeId($model, 'jenispenerimaan_id') . '").val(ui.item.jenispenerimaan_id);
														return false;
												  }'
								),
								'htmlOptions' => array(
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'placeholder'=>'Nama Jenis Penerimaan',
									'class'=>'span3',
									'style'=>'width:150px;',
								),
								'tombolDialog' => array('idDialog' => 'dialogJenisPenerimaan',),
						   ));
						?>
					</div>
				</div>                    
				<div class='control-group'>
					<?php echo CHtml::label('Rekening Debit','rekening debit',array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][saldonormal]','D', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening5_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening4_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening3_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening2_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][1][rekening1_id]','', array('readonly'=>true)); ?>
						   <?php
							   $this->widget('MyJuiAutoComplete', array(
								   'model' => $model,
								   'attribute' => 'rekDebit',
								   'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
								   'options' => array(
									   'showAnim' => 'fold',
									   'minLength' => 2,
									   'focus' => 'js:function( event, ui ) {
											   $(this).val(ui.item.nmrekening5);
											   return false;
										   }',
									   'select' => 'js:function( event, ui ) {
													   $(this).val(ui.item.nmrekening5);
													   $("#AKJnsPenerimaanRekM_rekening_1_rekening5_id").val(ui.item.rekening5_id);
													   $("#AKJnsPenerimaanRekM_rekening_1_rekening4_id").val(ui.item.rekening4_id);
													   $("#AKJnsPenerimaanRekM_rekening_1_rekening3_id").val(ui.item.rekening3_id);
													   $("#AKJnsPenerimaanRekM_rekening_1_rekening2_id").val(ui.item.rekening2_id);
													   $("#AKJnsPenerimaanRekM_rekening_1_rekening1_id").val(ui.item.rekening1_id);
														   return false;
													 }'
								   ),
								   'htmlOptions' => array(
									   'onkeypress' => "return $(this).focusNextInputField(event)",
									   'placeholder'=>'Nama Rekening',
									   'class'=>'span3',
									   'style'=>'width:150px;',
								   ),
								   'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
							   ));
						   ?>
					</div>
				</div>

				<div class='control-group'>
					<?php echo CHtml::label('Rekening Kredit','rekening kredit',array('class'=>'control-label')) ?>
					 <div class="controls">
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][saldonormal]','K', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening5_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening4_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening3_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening2_id]','', array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('AKJnsPenerimaanRekM[rekening][2][rekening1_id]','', array('readonly'=>true)); ?>
						<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'rekKredit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.nmrekening5);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrekening5);
													 $("#AKJnsPenerimaanRekM_rekening_2_rekening5_id").val(ui.item.rekening5_id);
													 $("#AKJnsPenerimaanRekM_rekening_2_rekening4_id").val(ui.item.rekening4_id);
													 $("#AKJnsPenerimaanRekM_rekening_2_rekening3_id").val(ui.item.rekening3_id);
													 $("#AKJnsPenerimaanRekM_rekening_2_rekening2_id").val(ui.item.rekening2_id);
													 $("#AKJnsPenerimaanRekM_rekening_2_rekening1_id").val(ui.item.rekening1_id);
														return false;
												  }'
								),
								'htmlOptions' => array(
									'onkeypress' => "return $(this).focusNextInputField(event)",
									'placeholder'=>'Nama Rekening',
									'class'=>'span3',
									'style'=>'width:150px;',
								),
								'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
							));
						?>
				   </div>
				</div>
			</td>
		</tr>
	</table>
        
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
					array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); 
		?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				Yii::app()->createUrl($this->module->id.'/jurnalRekPenerimaan/admin'), 
					array('class' => 'btn btn-default',
					  'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
		?>       
		<?php $this->widget('UserTips',array('type'=>'update'));?>
	</div>

<?php $this->endWidget(); ?>
<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>700,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
$account = "";

//$account = "D";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->searchAccounts($account),
	'filter'=>$modRekDebit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Saldo Normal</p>',
//                'start'=>8, //indeks kolom 3
//                'end'=>9, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
			'header'=>'Rek. 1',
			'name'=>'kdrekening1',
			'value'=>'$data->kdrekening1',
		),
		array(
			'header'=>'Rek. 2',
			'name'=>'kdrekening2',
			'value'=>'$data->kdrekening2',
		),
		array(
			'header'=>'Rek. 3',
			'name'=>'kdrekening3',
			'value'=>'$data->kdrekening3',
		),
		array(
			'header'=>'Rek. 4',
			'name'=>'kdrekening4',
			'value'=>'$data->kdrekening4',
		),
		array(
			'header'=>'Rek. 5',
			'name'=>'kdrekening5',
			'value'=>'$data->kdrekening5',
		),
		array(
			'header'=>'Nama Rekening',
			'name'=>'nmrekening5',
			'value'=>'$data->nmrekening5',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		),
		array(
			'header'=>'Saldo Normal',
			'value'=>'$data->rekening5_nb',
			'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
		),
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectRekDebit",
					"onClick" =>"
								$(\"#AKJnsPenerimaanRekM_rekening_1_rekening5_id\").val(\"$data->rekening5_id\");
								$(\"#AKJnsPenerimaanRekM_rekening_1_rekening4_id\").val(\"$data->rekening4_id\");
								$(\"#AKJnsPenerimaanRekM_rekening_1_rekening3_id\").val(\"$data->rekening3_id\");
								$(\"#AKJnsPenerimaanRekM_rekening_1_rekening2_id\").val(\"$data->rekening2_id\");
								$(\"#AKJnsPenerimaanRekM_rekening_1_rekening1_id\").val(\"$data->rekening1_id\");
								$(\"#AKJnsPenerimaanRekM_rekDebit\").val(\"$data->nmrekening5\");                                                
								$(\"#dialogRekDebit\").dialog(\"close\");    
								return false;
			"))',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
        
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>400,
        'resizable'=>false,
    ),
));

$account = "";

$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
//$account = "K";

if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts($account),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
			'header'=>'Rek. 1',
			'name'=>'kdrekening1',
			'value'=>'$data->kdrekening1',
		),
		array(
			'header'=>'Rek. 2',
			'name'=>'kdrekening2',
			'value'=>'$data->kdrekening2',
		),
		array(
			'header'=>'Rek. 3',
			'name'=>'kdrekening3',
			'value'=>'$data->kdrekening3',
		),
		array(
			'header'=>'Rek. 4',
			'name'=>'kdrekening4',
			'value'=>'$data->kdrekening4',
		),
		array(
			'header'=>'Rek. 5',
			'name'=>'kdrekening5',
			'value'=>'$data->kdrekening5',
		),
		array(
			'header'=>'Nama Rekening',
			'name'=>'nmrekening5',
			'value'=>'$data->nmrekening5',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		),
		array(
			'header'=>'Saldo Normal',
			'value'=>'$data->rekening5_nb',
			'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
		),

		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectRekDebit",
					"onClick" =>"
						$(\"#AKJnsPenerimaanRekM_rekening_2_rekening5_id\").val(\"$data->rekening5_id\");
						$(\"#AKJnsPenerimaanRekM_rekening_2_rekening4_id\").val(\"$data->rekening4_id\");
						$(\"#AKJnsPenerimaanRekM_rekening_2_rekening3_id\").val(\"$data->rekening3_id\");
						$(\"#AKJnsPenerimaanRekM_rekening_2_rekening2_id\").val(\"$data->rekening2_id\");
						$(\"#AKJnsPenerimaanRekM_rekening_2_rekening1_id\").val(\"$data->rekening1_id\");
						$(\"#AKJnsPenerimaanRekM_rekKredit\").val(\"$data->nmrekening5\");
						$(\"#dialogRekKredit\").dialog(\"close\");    
						return false;
			"))',
		),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

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

$modJenisPenerimaan = new JenispenerimaanM('search');
$modJenisPenerimaan->unsetAttributes();
if(isset($_GET['JenispenerimaanM'])) {
    $modJenisPenerimaan->attributes = $_GET['JenispenerimaanM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modJenisPenerimaan->searchJenisPenerimaan(),
	'filter'=>$modJenisPenerimaan,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'No. Urut',
			'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
		),
		array(
			'header'=>'Kode ',
			'value'=>'$data->jenispenerimaan_kode',
		),
		array(
			'header'=>'Nama',
			'value'=>'$data->jenispenerimaan_nama',
		),
		array(
			'header'=>'Nama Lain',
			'value'=>'$data->jenispenerimaan_namalain',
		),

		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectJenisPenerimaan",
					"onClick" =>"
						$(\"#AKJnsPenerimaanRekM_jenispenerimaan_id\").val(\"$data->jenispenerimaan_id\");
						$(\"#AKJnsPenerimaanRekM_jnsNama\").val(\"$data->jenispenerimaan_nama\");
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
