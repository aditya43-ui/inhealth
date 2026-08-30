<?php echo $form->errorSummary($modDekontaminasi); ?>

<div class="col-sm-6">
	<div class="control-group">
		<?php echo $form->labelEx($modDekontaminasi, 'dekontaminasi_tgl', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php // echo $form->hiddenField($modDekontaminasi, 'dekontaminasi_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
			<?php
			$modDekontaminasi->dekontaminasi_tgl = (!empty($modDekontaminasi->dekontaminasi_tgl) ? date("d/m/Y H:i:s", strtotime($modDekontaminasi->dekontaminasi_tgl)) : null);
			$this->widget('MyDateTimePicker', array(
				'model' => $modDekontaminasi,
				'attribute' => 'dekontaminasi_tgl',
				'mode' => 'datetime',
				'options' => array(
					'showOn' => false,
//                                'maxDate' => 'd',
					'yearRange' => "-150:+0",
				),
				'htmlOptions' => array('placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
				),
			));
			?>

		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($modDekontaminasi, 'dekontaminasi_no', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php
			echo $form->textField($modDekontaminasi, 'dekontaminasi_no', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'readonly' => true));
			?>

		</div>
	</div>
</div>
<div class="col-sm-6">
	<div class="control-group">
		<?php echo $form->labelEx($modDekontaminasi, 'pegpetugas_id', array('class' => 'control-label', 'label'=>'Petugas')); ?>
		<div class="controls">
			<?php echo $form->hiddenField($modDekontaminasi, 'pegpetugas_id'); ?>
			<?php
			$this->widget('MyJuiAutoComplete', array(
				'model' => $modDekontaminasi,
				'attribute' => 'pegpetugas_nama',
				'source' => 'js: function(request, response) {
										   $.ajax({
												   url: "' . $this->createUrl('AutocompletePegawai') . '",
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
						$("#' . Chtml::activeId($modDekontaminasi, 'pegpetugas_id') . '").val(ui.item.pegawai_id); 
						$("#STDekontaminasiT_dekontaminasi_no").blur();

						return false;
					}',
				),
				'htmlOptions' => array(
					'placeholder' => 'Petugas Dekontaminasi',
					'class' => 'pegpetugas_nama span3',
					'onkeyup' => "return $(this).focusNextInputField(event)",
					'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modDekontaminasi, 'pegpetugas_id') . '").val(""); '
				),
				'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
			));
			?>

		</div>
	</div>
	<div class="control-group">
		<?php echo $form->labelEx($modDekontaminasi, 'dekontaminasi_ket', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php
			echo $form->textArea($modDekontaminasi, 'dekontaminasi_ket', array('rows' => 3, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'placeholder' => 'Keterangan Dekontaminasi'));
			?>

		</div>
	</div>

</div>
<div class="clear"></div>

        <?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogPegawaiMengetahui',
            'options' => array(
                'title' => 'Pencarian Petugas Dokentaminasi',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 400,
                'resizable' => true,
            ),
        ));

        $modPegawaiMengetahui = new STPegawaiV('searchDialog');
        $modPegawaiMengetahui->unsetAttributes();
        if (isset($_GET['STPegawaiV'])) {
            $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'pegawaimengetahui-grid',
            'dataProvider' => $modPegawaiMengetahui->searchDialog(),
            'filter' => $modPegawaiMengetahui,
            'template' => "{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectObat",
							"onClick" => "
											$(\"#' . CHtml::activeId($modDekontaminasi, 'pegpetugas_id') . '\").val(\"$data->pegawai_id\");
											$(\"#' . CHtml::activeId($modDekontaminasi, 'pegpetugas_nama') . '\").val(\"$data->NamaLengkap\");
											$(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
											$(\"#STDekontaminasiT_dekontaminasi_no\").blur();
										  
											return false;
								"))',
                ),
                array(
                    'header' => 'NIP',
                    'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
                    'value' => '$data->nomorindukpegawai',
                ),
                array(
                    'header' => 'Gelar Depan',
                    'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value' => '$data->gelardepan',
                ),
                array(
                    'header' => 'Nama Pegawai',
                    'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value' => '$data->nama_pegawai',
                ),
                array(
                    'header' => 'Gelar Belakang',
                    'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value' => '$data->gelarbelakang_nama',
                ),
                array(
                    'header' => 'Alamat Pegawai',
                    'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value' => '$data->alamat_pegawai',
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
	jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        $this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
        ?>