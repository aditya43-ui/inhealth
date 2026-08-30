<?php echo CHtml::hiddenField('url',$this->createUrl('',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)),array('readonly'=>TRUE));?>
<?php echo CHtml::hiddenField('berubah','',array('readonly'=>TRUE));?> 

<div class="col-sm-12">
	<div class="control-group ">
	<?php $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
	<?php echo $form->labelEx($modReseptur,'tglreseptur', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php   
				$this->widget('MyDateTimePicker',array(
					'model'=>$modReseptur,
					'attribute'=>'tglreseptur',
					'mode'=>'datetime',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
						'yearRange'=> "-60:+0",
					),
					'htmlOptions'=>array('readonly'=>true,'class'=>'span3 dtPicker3 realtime', 'onkeypress'=>"return $(this).focusNextInputField(event)"
					),
				)); 
			?>
			<?php echo $form->error($modReseptur, 'tglreseptur'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($modReseptur,'noresep', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->textField($modReseptur,'noresep',array('readonly'=>true, 'style'=>'width:170px;', )); ?><br>
		</div>
	</div>
	<div class="control-group" id="field-paketobat">
		<?php echo $form->labelEx($modReseptur, 'paketobat_id', array('class'=>'control-label','label'=>'Paket Obat')); ?>
        <div class="controls">
			<?php echo $form->hiddenField($modReseptur, 'paketobat_id', array('id'=>'paketobat_id'));?>
			<?php 
				$this->widget('MyJuiAutoComplete', array(
					'name'=>'nama_paket',
					'source'=>'js: function(request, response) {
						$.ajax({
							url: "'.$this->createUrl('getPaketObat').'",
							dataType: "json",
							data: {
								term: request.term,
							},
							success: function (data) {
									response(data);
							}
						})
					}',
					'options'=>array(
						'showAnim'=>'fold',
						'minLength' => 2,
						'select'=>'js:function( event, ui ) {
							$(this).val( ui.item.label);
							$("#paketobat_id").val(ui.item.paketobat_id);
							tambahDetailObat(this);
							return false;
						}',
					),
					'tombolDialog'=>array('idDialog'=>'dialogPaketObat'),
					'htmlOptions'=>array('class'=>'span3'),
				)); 
			?>
        </div>
    </div>
	<div class="control-group">
		<?php echo CHtml::label('Jenis Resep','Jenis Resep', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php
			echo CHtml::dropDownList('jenisresep','',
				array(0=>'Non Racikan',1=>'Racikan'),
				array('key'=>'jenisresep', 'class'=>'span3','onchange'=>'formjenisresep(this.value); setDropDownRke();')
			);
			?><br>
		</div>
	</div>
	
	<?php echo $form->dropDownListRow($modReseptur,'pegawai_id',CHtml::listData($modReseptur->getDokterItems(), 'pegawai_id', 'NamaLengkap'),array('class' => 'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'disabled' => true));?>
	<?php echo $form->dropDownListRow($modReseptur,'ppds_id',CHtml::listData($modReseptur->getPPDS(), 'ppds_id', 'ppds_nama'),array('empty'=>'-- Pilih --','class' => 'span3','onkeypress'=>"return $(this).focusNextInputField(event)"));?>

	<?php 
        
        echo $form->dropDownListRow($modReseptur,'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
            'ruangan_aktif'=>true,
            'instalasi_id'=>Params::INSTALASI_ID_FARMASI,
        )), 'ruangan_id', 'ruangan_nama'), array(
            'onchange'=>'setOaByRuangTujuan(this)',
        ));
        echo $form->hiddenField($modReseptur,'penjamin_id');
    ?>
    
    
        
    <?php // echo $form->dropDownListRow($modReseptur,'ruangan_id',CHtml::listData($modReseptur->ApotekRawatJalan, 'ruangan_id', 'ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'options'=>array('Params::RUANGAN_ID_APOTEK_1'=>'selected'),'onchange'=>'setOaByRuangTujuan(this)'));?>
	<div class="control-group hide">
		<label class="control-label" for="iter">Iter</label>
		<div class="controls">
			<?php echo CHtml::textField('iter', '0', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 integer2', 'maxlength'=>1)) ?>
		</div>
	</div>
	<?php $ins_id = Yii::app()->user->getState('instalasi_id'); ?>
    <?php if (in_array($ins_id, [4, 20, 38])): ?>
		<div class="control-group">
			<?php echo CHtml::label('', '&nbsp;', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo $form->checkBox($modReseptur, 'isterapipulang', array('onclick' => 'set_this(this)')); ?>
				<label for="RJResepturT_isterapipulang">Terapi Pulang</label>
			</div>
		</div>
		<?php if(!empty($modRiwayatResepPertama[0]->reseptur_id)){?>
		<?php }else{?>
			<div class="control-group">
				<?php echo CHtml::label('', '&nbsp;', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->checkBox($modReseptur, 'ispasienbaru', array('onclick' => 'set_this2(this)')); ?>
					<label for="RJResepturT_ispasienbaru">Pasien Baru</label>
				</div>
			</div>
			
		<?php }?>	
	<?php endif; ?>
	<div class="col-md-4">
	<table width="100%"  cellpadding="0" cellspacing="0">
		<tr>
			<td>
			<?php echo $form->labelEx($modReseptur, 'isterapipulang', array('class' => 'control-label')); ?>

			</td>
			<td>
			<?php echo $form->checkBox($modReseptur, 'isterapipulang', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Ceklis jika resep perawatan')); ?>

			</td>
		</tr>
		<tr>
			<td>
			<?php echo $form->labelEx($modReseptur, 'is_cito', array('class' => 'control-label')); ?>

			</td>
			<td>
			<?php echo $form->checkBox($modReseptur, 'is_cito', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rel' => 'tooltip', 'title' => 'Ceklis jika resep CITO')); ?>

			</td>
		</tr>
	</table>
</div>


	

</div>

<?php 
//========= Dialog paket obat  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPaketObat',
    'options'=>array(
        'title'=>'Paket Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>550,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modPaketObat = new PaketobatM('search');
$modPaketObat->unsetAttributes();
if(isset($_GET['PaketobatM'])){
    $modPaketObat->attributes=$_GET['PaketobatM'];
    if ($dokter == true) {
        $modPaketObat->dokter_id = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai_id;
    }
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'dialog-paket-obat-m-grid',
	'dataProvider'=>$modPaketObat->search(),
	'filter'=>$modPaketObat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'Pilih',
				'type'=>'raw',
				'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
								"id" => "selectObat",
								"onClick" => "
									$(\"#paketobat_id\").val(\"$data->paketobat_id\"); 
									$(\"#nama_paket\").val(\"$data->nama_paket\"); 
									$(\'#dialogPaketObat\').dialog(\'close\');
									tambahDetailObat();
								return false;"))',
			),
			'nama_paket',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
<script>
	const set_this = (obj) => {
        if ($(obj).is(':checked')) {
			$('#RJResepturT_ispasienbaru').hide();
		}else{
			$('#RJResepturT_ispasienbaru').show();
		}
	}

	const set_this2 = (obj) => {
        if ($(obj).is(':checked')) {
			$('#RJResepturT_isterapipulang').hide();
		}else{
			$('#RJResepturT_isterapipulang').show();
		}
	}



    $(document).ready(function() {
           var pegawai = jQuery('#<?php echo CHtml::activeId($modReseptur, 'pegawai_id') ?>');
		 
				// jQuery(pegawai).multiselect({
				// 		includeSelectAllOption: false,
				// 		buttonClass: "form-control",
				// 		maxHeight: 300,
				// 		buttonWidth: '182px',
				// 		enableCaseInsensitiveFiltering: true
				// }).hide();
			
       });


    function searchPegawai() {
            $('#rjreseptur-t-form input[name*="pegawai_id"]').each(function() {
            });
    }



    $(document).ready(function() {
           var ppds = jQuery('#<?php echo CHtml::activeId($modReseptur, 'ppds_id') ?>');	
           jQuery(ppds).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();
       });


    function searchPegawai() {
            $('#rjreseptur-t-form input[name*="ppds_id"]').each(function() {
            });
    }
    
</script>