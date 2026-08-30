<div class="col-sm-4">
    <?php echo $form->textFieldRow($model, 'tglstoreed', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
    <?php if ($disabled) { ?>
        <?php echo $form->textFieldRow($model, 'nostoreed', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
    <?php
    } else {
        echo $form->textFieldRow($model, 'nostoreed', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100));
    }
    ?>
</div>

<div class="col-sm-4">
    <div class="control-group">
        <label class="control-label" for="supplier_nama">Supplier</label>
        <div class="controls">
            <?php echo CHTML::textField('supplier_nama', '', array('class' => 'span3', 'placeholder' => 'Supplier Otomatis', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
            <?php echo CHtml::hiddenField('satuankecil_id'); ?>
        </div>
    </div>	
    <div class="control-group">
        <label class="control-label" for="tglkadaluarsa">Tanggal Kadaluarsa</label>
        <div class="controls">
            <?php echo CHTML::textField('tglkadaluarsa', '', array('class' => 'span3', 'placeholder' => 'Tgl Kadaluarsa Otomatis', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => true)); ?>
        </div>
    </div>
</div>

<div class="col-sm-4">
    <div class="control-group">
        <?php echo CHtml::label('Sumber Dana', 'Sumber Dana', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($model, 'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true'), 'sumberdana_id', 'sumberdana_nama'), array('class' => 'span3', 'maxlength' => 50, 'onkeyup' => "return $(this).focusNextInputField(event);"));
            ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::hiddenField('obatalkes_id'); ?>
        <label class="control-label" for="namaObat">Nama Obat</label>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'obatalkes_nama',
                'source' => 'js: function(request, response) {
														   $.ajax({
															   url: "' . $this->createUrl('AutocompleteObatExpiredDate') . '",
															   dataType: "json",
															   data: {
																   term: request.term,
                                                                                                                                sumberdana: $("#GFStoreedT_sumberdana_id").val(),
															   },
															   success: function (data) {
																	   response(data);
															   }
														   })
														}',
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 2,
                    'select' => 'js:function( event, ui ) {
													   $(this).val( ui.item.label);
													   $("#obatalkes_nama").val(ui.item.obatalkes_nama);
													   $("#obatalkes_id").val(ui.item.obatalkes_id);
													   $("#supplier_nama").val(ui.item.supplier_nama);
													   $("#tglkadaluarsa").val(ui.item.tglkadaluarsa);
													   $("#satuankecil_id").val(ui.item.satuankecil_id);
														return false;
													}',
                ),
                'tombolDialog' => array('idDialog' => 'dialogObat', 'idTombol' => 'tombolDialogOa'),
                'htmlOptions' => array("placeholder" => "Ketik nama obat alkes", "rel" => "tooltip", "title" => "Pencarian Data Obat/Alkes", 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>
    <div class="control-group ">
        <label class="control-label" for="qty">Jumlah</label>
        <div class="controls">
            <?php echo CHtml::textField('qtystoked', '1', array('class' => 'span3', 'readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'inputFormTabel span1 numbers-only')); ?>
            <?php
            echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'tambahObat();return false;',
                'class' => 'btn btn-primary',
                'onkeypress' => "tambahObat();return false;",
                'rel' => "tooltip",
                'title' => "Klik untuk menambahkan obat",));
            ?>
        </div>
    </div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Daftar Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 900,
        'minHeight' => 400,
        'resizable' => false,
    ),
));
$modObatDialog = new GFObatSupplierM('searchObatED');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['GFObatSupplierM'])) {
    $modObatDialog->attributes = $_GET['GFObatSupplierM'];
    $modObatDialog->tglkadaluarsa = isset($_GET['GFObatSupplierM']['tglkadaluarsa']) ? $_GET['GFObatSupplierM']['tglkadaluarsa'] : null;
    $modObatDialog->obatalkes_nama = isset($_GET['GFObatSupplierM']['obatalkes_nama']) ? $_GET['GFObatSupplierM']['obatalkes_nama'] : null;
    $modObatDialog->supplier_nama = isset($_GET['GFObatSupplierM']['supplier_nama']) ? $_GET['GFObatSupplierM']['supplier_nama'] : null;
    $modObatDialog->satuankecil_nama = isset($_GET['GFObatSupplierM']['satuankecil_nama']) ? $_GET['GFObatSupplierM']['satuankecil_nama'] : null;
    $modObatDialog->sumberdana_id = isset($_GET['GFObatSupplierM']['sumberdana_id']) ? $_GET['GFObatSupplierM']['sumberdana_id'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkesDialog-m-grid',
    'dataProvider' => $modObatDialog->searchObatED(),
    'filter' => $modObatDialog,
    'template' => "{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
				"id"=>"selectObat",
				"onClick"=>"
							$(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
							$(\"#obatalkes_nama\").val(\"$data->obatalkes_nama\");
							$(\"#supplier_nama\").val(\"$data->supplier_nama\");
							$(\"#tglkadaluarsa\").val(\"$data->tglkadaluarsa\");
							$(\"#satuankecil_id\").val(\"$data->satuankecil_id\");
							$(\"#dialogObat\").dialog(\"close\");
                                                        $(\'#GFStoreedT_sumberdana_id\').val(' . $modObatDialog->sumberdana_id . ');
							return false;
				",
			   ))'
        ),
        array(
            'header' => 'Nama Obat',
            'type' => 'raw',
            'value' => '$data->obatalkes_nama',
            'name' => 'obatalkes_nama',
        ),
        array(
            'header' => 'Supplier',
            'type' => 'raw',
            'value' => '$data->supplier_nama',
            'name' => 'supplier_nama',
        ),
        array(
            'header' => 'Tanggal Kadaluarsa',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
            'filter' => $this->widget('MyDateTimePicker', array(
                'model' => $modObatDialog,
                'attribute' => 'tglkadaluarsa',
                'mode' => 'date', //date / datetime
                'gridFilter' => true,
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('readonly' => false, 'class' => "span2",
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ), true),
        ),
        array(
            'header' => 'Satuan Kecil',
            'type' => 'raw',
            'value' => '$data->satuankecil_nama',
            'name' => 'satuankecil_nama',
        ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'name' => 'sumberdana_id',
            'value' => '$data->getStokObatRuangan(' . $modObatDialog->sumberdana_id . ')',
            'filter' => CHtml::listData(SumberdanaM::model()->findAll(' sumberdana_aktif IS TRUE'), 'sumberdana_id', 'sumberdana_nama'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
		jQuery("#' . CHtml::activeId($modObatDialog, 'tglkadaluarsa') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+30y"}));
		jQuery("#' . CHtml::activeId($modObatDialog, 'tglkadaluarsa') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modObatDialog, 'tglkadaluarsa') . '").datepicker("show");});
	}',
));

$this->endWidget();
?>


