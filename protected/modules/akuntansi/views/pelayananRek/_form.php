<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'reharga-jual-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
	<?php //        if (isset($modDetails)){ echo $form->errorSummary($modDetails); } ?>
	<?php echo $form->errorSummary($model); ?>
	<table>
		<tr>
			<td>
				<div class="control-group">
					<?php echo $form->labelEx($model, 'jnspelayanan', array('class'=>'control-label')); ?>
					<div class="controls">
						<?php
							echo $form->dropDownList($model, 'jnspelayanan', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'jenispelayanan')), 'lookup_value', 'lookup_name'), array('class'=>'span2','empty'=>'-- Pilih --'));
						?>
					</div>
				</div>
			</td>
			<td>
				<div class='control-group'>
					<?php echo $form->labelEx($model,'rekeningdebit_id', array('class'=>'control-label')) ?>
					<div class="controls">
						<?php echo CHtml::hiddenField('PelayananrekM[rekening][1][saldonormal]','D',array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('PelayananrekM[rekening][1][rekening_id1]','',array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('PelayananrekM[rekening][1][rekening_id2]','',array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('PelayananrekM[rekening][1][rekening_id3]','',array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('PelayananrekM[rekening][1][rekening_id4]','',array('readonly'=>true)); ?>
						<?php echo CHtml::hiddenField('PelayananrekM[rekening][1][rekening_id5]','',array('readonly'=>true)); ?>
						<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'rekDebit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiDebit'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.nmstruktur);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrincianobyek);
													$("#PelayananrekM_rekening_1_rekening_id1").val(ui.item.struktur_id);
													$("#PelayananrekM_rekening_1_rekening_id2").val(ui.item.kelompok_id);
													$("#PelayananrekM_rekening_1_rekening_id3").val(ui.item.jenis_id);
													$("#PelayananrekM_rekening_1_rekening_id4").val(ui.item.obyek_id);
													$("#PelayananrekM_rekening_1_rekening_id5").val(ui.item.rincianobyek_id);
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
			</td>
			<td>
				<div class='control-group'>
					<?php echo $form->labelEx($model,'rekeningkredit_id', array('class'=>'control-label')) ?>
					<div class="controls">
					   <?php echo CHtml::hiddenField('PelayananrekM[rekening][2][saldonormal]','K',array('readonly'=>true)); ?>
					   <?php echo CHtml::hiddenField('PelayananrekM[rekening][2][rekening_id1]','',array('readonly'=>true)); ?>
					   <?php echo CHtml::hiddenField('PelayananrekM[rekening][2][rekening_id2]','',array('readonly'=>true)); ?>
					   <?php echo CHtml::hiddenField('PelayananrekM[rekening][2][rekening_id3]','',array('readonly'=>true)); ?>
					   <?php echo CHtml::hiddenField('PelayananrekM[rekening][2][rekening_id4]','',array('readonly'=>true)); ?>
					   <?php echo CHtml::hiddenField('PelayananrekM[rekening][2][rekening_id5]','',array('readonly'=>true)); ?>
						<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'rekKredit',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansiKredit'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
											$(this).val(ui.item.nmstruktur);
											return false;
										}',
									'select' => 'js:function( event, ui ) {
													$(this).val(ui.item.nmrincianobyek);
													$("#PelayananrekM_rekening_2_rekening_id1").val(ui.item.struktur_id);
													$("#PelayananrekM_rekening_2_rekening_id2").val(ui.item.kelompok_id);
													$("#PelayananrekM_rekening_2_rekening_id3").val(ui.item.jenis_id);
													$("#PelayananrekM_rekening_2_rekening_id4").val(ui.item.obyek_id);
													$("#PelayananrekM_rekening_2_rekening_id5").val(ui.item.rincianobyek_id);
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
    
	<div style='max-height:400px;max-width:100%;overflow-y: scroll;align:center;margin-bottom:20px;'>
		<?php 
			$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'tindakanruangan-m-grid',
				'dataProvider'=>$modTindakanRuangan->searchPelRek(),
				'filter'=>$modTindakanRuangan,
				'template'=>"{pager}\n{items}",
				'itemsCssClass'=>'table table-striped table-bordered table-condensed',
				'columns'=>array(
					array(
						'header'=>'Pilih'.'<br>'.CHtml::checkBox("cekAll","",array('onclick'=>'checkAllRuangan();')),
						'type'=>'raw',
						'value'=>'CHtml::checkBox("AKTindakanRuanganM[tindakan][$data->ruangan_id][$data->daftartindakan_id][pilihRuangan]","",array("onclick"=>"setAll();","class"=>"cekList"))',
					),
					array(
						'header'=>'Ruangan',
						'name'=>'ruangan_nama',
						//'filter'=> CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),
						'value'=>'CHtml::hiddenField("AKTindakanRuanganM[$data->daftartindakan_id][ruangan_id]", $data->ruangan_id, array("id"=>"ruangan_id","onkeypress"=>"return $(this).focusNextInputField(event)")).$data->ruangan_nama',
	//                            'value'=>'$data->ruangan->ruangan_nama',
						'type'=>'raw',
					),
					array(
						'header'=>'Kategori Pelayanan',
						'name'=>'kategoritindakan_id',
						'filter'=> CHtml::textField('kategoritindakan_nama'),
						'value'=>'$data->kategoritindakan_nama',
						'type'=>'raw',
					),
					array(
						'header'=>'Kode Pelayanan',
						'name'=>'daftartindakan_kode',
						'filter'=> CHtml::textField('daftartindakan_kode'),
						'value'=>'$data->daftartindakan_kode',
						'type'=>'raw',
					),
					array(
						'header'=>'Nama Pelayanan',
						'name'=>'daftartindakan_id',
						'filter'=> CHtml::textField('nama_pelayanan'),
						'value'=>'CHtml::hiddenField("AKTindakanRuanganM[$data->daftartindakan_id][daftartindakan_id]", $data->daftartindakan_id, array("id"=>"daftartindakan_id","onkeypress"=>"return $(this).focusNextInputField(event)")).$data->daftartindakan_nama',
						// 'value'=>'$data->daftartindakan_nama',
						'type'=>'raw',
					),
				),
				'afterAjaxUpdate'=>'
					function(id, data){
						jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
				}',
			)); 
		?>
	</div>
            
	<div class="form-actions">
		<?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
				Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
					array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
		<?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
				Yii::app()->createUrl($this->module->id.'/'.$this->id.'/create'), 
					array('class' => 'btn btn-default',
						'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
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
        'width'=>820,
        'height'=>600,
        'resizable'=>false,
    ),
));

			$modRekKredit = new AKRekeningakuntansiV('search');
			$modRekKredit->unsetAttributes();
	//            $account = "D";
			$account = "";
			if(isset($_GET['AKRekeningakuntansiV'])) {
				$modRekKredit->attributes = $_GET['AKRekeningakuntansiV'];
				$modRekKredit->rekening = !empty($_GET['AKRekeningakuntansiV']['rekening'])?$_GET['AKRekeningakuntansiV']['rekening']:null;
			}
	//            $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
			$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'rekkredit-m-grid',
				//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
				'dataProvider'=>$modRekKredit->searchAccounts($account),
				'filter'=>$modRekKredit,
				'template'=>"{summary}\n{items}\n{pager}",
				'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//                    'mergeHeaders'=>array(
//                        array(
//                            'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
//                            'start'=>1, //indeks kolom 3
//                            'end'=>5, //indeks kolom 4
//                        ),
//                    ),
				'columns'=>array(
					array(
						'header'=>'No. Urut',
						'name'=>'nourutrek',
						'value'=>'$data->nourutrek',
						'htmlOptions' => array(
							'style'=>'width:50px;',
						),
					),
					array(
						'header'=>'No. Rekening',
						'name'=>'rekening',
						'value'=>'$data->rekening',
					),
					 array(
						'header'=>'Nama Rekening',
						'name'=>'nmrincianobyek',
						'type'=>'raw',
						'value'=>'($data->nmrincianobyek == "" ? $data->nmobyek : ($data->nmobyek == "" ? $data->nmjenis : ($data->nmjenis == "" ? $data->nmkelompok : ($data->nmkelompok == "" ? $data->nmstruktur : ($data->nmstruktur == "" ? "-" : $data->nmrincianobyek)))))',
					),  
					array(
						'header'=>'Nama Lain',
						'name'=>'nmrincianobyeklain',
						'value'=>'($data->nmrincianobyeklain == "" ? $data->nmobyeklain : ($data->nmobyeklain == "" ? $data->nmjenislain : ($data->nmjenislain == "" ? $data->nmkelompoklain : ($data->nmkelompoklain == "" ? $data->nmstrukturlain : ($data->nmstrukturlain == "" ? "-" : $data->nmrincianobyeklain)))))',
					),
					array(
						'header'=>'Saldo Normal',
						'name'=>'rincianobyek_nb',
						'value'=>'($data->rincianobyek_nb == "D") ? "Debit" : "Kredit"',
					),

					array(
						'header'=>'Pilih',
						'type'=>'raw',
						'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
								"id" => "selectRekDebit",
								"onClick" =>"
									$(\"#PelayananrekM_rekening_1_rekening_id1\").val(\"$data->struktur_id\");
									$(\"#PelayananrekM_rekening_1_rekening_id2\").val(\"$data->kelompok_id\");
									$(\"#PelayananrekM_rekening_1_rekening_id3\").val(\"$data->jenis_id\");
									$(\"#PelayananrekM_rekening_1_rekening_id4\").val(\"$data->obyek_id\");
									$(\"#PelayananrekM_rekening_1_rekening_id5\").val(\"$data->rincianobyek_id\");
									$(\"#PelayananrekM_rekDebit\").val(\"$data->nmrincianobyek\");                                                
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
        'width'=>820,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modRekKredit = new AKRekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
//$account = "K";
$account = "";
if(isset($_GET['AKRekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['AKRekeningakuntansiV'];
	$modRekKredit->rekening = !empty($_GET['AKRekeningakuntansiV']['rekening'])?$_GET['AKRekeningakuntansiV']['rekening']:null;
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
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
			'htmlOptions' => array(
				'style'=>'width:50px;',
			),
		),
		array(
			'header'=>'No. Rekening',
			'name'=>'rekening',
			'value'=>'$data->rekening',
		),
		array(
			'header'=>'Nama Rekening',
			'name'=>'nmrincianobyek',
			'value'=>'$data->nmrincianobyek',
		),
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrincianobyeklain',
			'value'=>'$data->nmrincianobyeklain',
		),
		array(
			'header'=>'Saldo Normal',
			'name'=>'rincianobyek_nb',
			'value'=>'($data->rincianobyek_nb == "K" ) ? "Kredit" : "Debit"',
		),

		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#PelayananrekM_rekening_2_rekening_id1\").val(\"$data->struktur_id\");
					$(\"#PelayananrekM_rekening_2_rekening_id2\").val(\"$data->kelompok_id\");
					$(\"#PelayananrekM_rekening_2_rekening_id3\").val(\"$data->jenis_id\");
					$(\"#PelayananrekM_rekening_2_rekening_id4\").val(\"$data->obyek_id\");
					$(\"#PelayananrekM_rekening_2_rekening_id5\").val(\"$data->rincianobyek_id\");

					$(\"#PelayananrekM_rekKredit\").val(\"$data->nmrincianobyek\");
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

<script>
	function checkAllRuangan() {
		if ($("#cekAll").is(":checked")) {
			$('#tindakanruangan-m-grid input[name*="pilihRuangan"]').each(function(){
			   $(this).attr('checked',true);
			})
		} else {
		   $('#tindakanruangan-m-grid input[name*="pilihRuangan"]').each(function(){
			   $(this).removeAttr('checked');
			})
		}
		setAll();
	}

	function setAll(obj){
		$('.cekList').each(function(){
		   if ($(this).is(':checked')){

				$(this).parents('tr').find('.cekList').val(1);
			}else{
				$(this).parents('tr').find('.cekList').val(0);
			}
		});
	}
</script>