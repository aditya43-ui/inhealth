<div class="row">
	<div class="col-sm-4">
		<div class="control-group">
        <?php echo $form->labelEx($modDetail, 'Program Kerja <span class="required">*</span>', array('class' => 'control-label')); ?>
			<div class="controls">
			<?php echo CHtml::hiddenField('subkegiatanprogram_id','',array('readonly'=>true)); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model'=>$model,
                'attribute' => 'programkerja',
                'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('AutocompleteProgramKerja') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                        $(this).val( ui.item.label);
                        return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                        $("#subkegiatanprogram_id").val(ui.item.subkegiatanprogram_id); 
                        return false;
                    }',
                ),
                'htmlOptions' => array(
                    'class'=>'programkerja',
                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'onblur' => 'if(this.value === "") $("#subkegiatanprogram_id").val(""); '
                ),
                'tombolDialog' => array('idDialog' => 'dialogProgramKerja'),
            ));
            ?>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class="control-group">
		<?php echo $form->labelEx($model, 'Nilai Pengeluaran <span class="required">*</span> ', array('class' => 'control-label')); ?>
			<div class="controls">
            <?php echo $form->textField($model,'nilairencpengeluaran',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
			<span id="digit"></span>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
		<div class='control-group'>
			<?php echo CHtml::label('Bulan', 'tglrencana', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php $model->tglrencana = $format->formatMonthForUser($model->tglrencana); ?>
				<?php 
					$this->widget('MyMonthPicker', array(
						'model' => $model,
						'attribute' => 'tglrencana', 
						'options'=>array(
							'dateFormat' => Params::MONTH_FORMAT,
						),
						'htmlOptions' => array('readonly' => true,
							'class' => "span2",
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));  
				?>
			</div>
			<div style="margin-left:280px; margin-top: -5px;">
				<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
						array('onclick'=>'tambahRencana();return false;',
							  'class' => 'btn btn-danger',
							  'rel'=>"tooltip",
							  'title'=>"Klik untuk menambahkan rencana",)); ?>
			</div> 
		</div>
	</div>
</div>

<?php 
//========= Dialog buat cari data Program Kerja =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogProgramKerja',
    'options'=>array(
        'title'=>'Data Program Kerja',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
		'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modProgramKerja = new AGRekeninganggaranV('searchProgramKerja');
$modProgramKerja->unsetAttributes();
$modProgramKerja->subkegiatanprogram_aktif = true;
if(isset($_GET['AGRekeninganggaranV'])) {
    $modProgramKerja->attributes = $_GET['AGRekeninganggaranV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'programkerja-grid',
	'dataProvider'=>$modProgramKerja->searchProgramKerja(),
	'filter'=>$modProgramKerja,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'No. ',
					'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:center; width:5px;'),
                ),
                array(
                    'header'=>'Program Kerja',
					'type'=>'raw',
					'filter'=>  CHtml::activeTextField($modProgramKerja, 'subkegiatanprogram_nama',array('placeholder'=>'sub kegiatan kerja')),
					'value'=>'$this->grid->owner->renderPartial("_detail",array(
					"programkerja_kode"=>$data->programkerja_kode,
					"programkerja_nama"=>$data->programkerja_nama,
					"subprogramkerja_kode"=>$data->subprogramkerja_kode,
					"subprogramkerja_nama"=>$data->subprogramkerja_nama,
					"kegiatanprogram_kode"=>$data->kegiatanprogram_kode,
					"kegiatanprogram_nama"=>$data->kegiatanprogram_nama,
					"subkegiatanprogram_kode"=>$data->subkegiatanprogram_kode,
					"subkegiatanprogram_nama"=>$data->subkegiatanprogram_nama),true)',
					'headerHtmlOptions'=>array('style'=>'text-align:center;'),
                ),
                 array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectProgramKerja",
                                    "onClick" => "
                                                  $(\"#subkegiatanprogram_id\").val(\"$data->subkegiatanprogram_id\");
                                                  $(\"#'.CHtml::activeId($model,'programkerja').'\").val(\"$data->subkegiatanprogram_nama\");
                                                  $(\"#dialogProgramKerja\").dialog(\"close\"); 
                                                  return false;
                                        "))',
					'htmlOptions'=>array('style'=>'text-align:center; width:10px;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
$this->endWidget();
//========= end Program Kerja dialog =============================
?>