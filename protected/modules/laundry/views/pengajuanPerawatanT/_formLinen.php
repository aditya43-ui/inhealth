<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>No. Register Linen</label>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'noregisterlinen',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompleteRegisterLinen') . '",
                                           dataType: "json",
                                           data: {
                                               noregisterlinen: request.term,
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
                                    $(this).val("");
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    $("#linen_id").val(ui.item.linen_id);
                                    $("#noregisterlinen").val(ui.item.noregisterlinen);
                                    $("#namalinen").val(ui.item.namalinen);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span2',
                        'placeholder' => 'No. Register Linen',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#linen_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLinen'),
                ));
                ?>

            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jenis Perawatan</label>
            <div class="controls">
                <?php echo Chtml::dropDownList('jenisperawatan', '', LookupM::getItems('jenisperawatan'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Nama Linen</label>
            <div class="controls">
                <?php echo CHtml::hiddenField('linen_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namalinen',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompleteRegisterLinen') . '",
                                           dataType: "json",
                                           data: {
                                               namalinen: request.term,
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
                                    $(this).val("");
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    $("#linen_id").val(ui.item.linen_id);
                                    $("#namalinen").val(ui.item.namalinen);
									$("#noregisterlinen").val(ui.item.noregisterlinen);
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span2',
                        'placeholder' => 'Nama Linen',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#linen_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLinen'),
                ));
                ?>

            </div>
        </div>

    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Keterangan</label>
            <div class="controls">
                <?php echo Chtml::textField('keterangan_pengperawatan', '', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                &nbsp;&nbsp;&nbsp;
                <?php
                /*echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', 
					array('onclick' => 'inputLinen();return false;',
						'class' => 'btn btn-danger',
						'onkeypress' => "inputLinen();return $(this).focusNextInputField(event)",
						'rel' => "tooltip",
						'title' => "Klik untuk menambahkan Linen",));*/
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Jumlah</label>
            <div class="controls">
                <?php echo Chtml::textField('jumlah', '1', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <?php
                echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'inputLinen();return false;',
                        'class' => 'btn btn-primary',
                        'onkeypress' => "inputLinen();return $(this).focusNextInputField(event)",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Linen",
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari Nama Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLinen',
    'options' => array(
        'title' => 'Daftar Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => true,
    ),
));

$modLinen = new LALinenM('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['LALinenM'])) {
    $modLinen->attributes = $_GET['LALinenM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'linen-m-grid',
    'dataProvider' => $modLinen->searchDialog(),
    'filter' => $modLinen,
    'template' => "{summary}{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectLinen",
				"onClick" => "
					$(\'#linen_id\').val(\'$data->linen_id\');
					$(\'#namalinen\').val(\'$data->namalinen\');
					$(\'#noregisterlinen\').val(\'$data->noregisterlinen\');
					$(\'#dialogLinen\').dialog(\'close\');
					return false;"))',
        ),

        array(
            'name' => 'namalinen',
            'type' => 'raw',
            'value' => '$data->namalinen'
        ),
        array(
            'name' => 'kodelinen',
            'type' => 'raw',
            'value' => '$data->kodelinen'
        ),
        array(
            'name' => 'noregisterlinen',
            'type' => 'raw',
            'value' => '$data->noregisterlinen'
        ),
        //              RSSP-689
        //		array(
        //			'name'=>'tglregisterlinen',
        //			'header'=>'Tanggal Register',
        //			'type'=>'raw',
        //			'value'=>'MyFormatter::formatDateTimeForUser($data->tglregisterlinen)
        //					.(isset($data->tglregisterlinen) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglregisterlinen) : "")',
        //			'filter'=>$this->widget('MyDateTimePicker', array(
        //					'model' => $modLinen,
        //					'attribute' => 'tglregisterlinen',
        //					'mode' => 'date', //date / datetime
        //					'gridFilter' => true,
        //					'options' => array(
        //					'dateFormat' => Params::DATE_FORMAT,
        //					'maxDate'=>'d',
        //				),
        //					'htmlOptions' => array('readonly' => true, 'class' => "span2",
        //					'onkeypress' => "return $(this).focusNextInputField(event)"),
        //				),true),
        //		),
        array(
            'name' => 'tglregisterlinen',
            'header' => 'Tanggal Register',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tglregisterlinen)
					.(isset($data->tglregisterlinen) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglregisterlinen) : "")',
            'filter' => false,
        ),
        array(
            'header' => 'Barang',
            'name' => 'barang_nama',
            'type' => 'raw',
            'value' => 'isset($data->barang)?$data->barang->barang_nama:""'
        ),
        array(
            'header' => 'Bahan',
            'name' => 'bahanlinen_nama',
            'type' => 'raw',
            'value' => 'isset($data->bahan)?$data->bahan->bahanlinen_nama:""'
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenislinen_nama',
            'type' => 'raw',
            'value' => 'isset($data->jenis)?$data->jenis->jenislinen_nama:""'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
		jQuery("#' . CHtml::activeId($modLinen, 'tglregisterlinen') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
		jQuery("#' . CHtml::activeId($modLinen, 'tglregisterlinen') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modLinen, 'tglregisterlinen') . '").datepicker("show");});
	}',
));
$this->endWidget();
?>