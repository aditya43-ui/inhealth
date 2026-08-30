<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Tanggal Penyimpanan</label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modCari,
                    'attribute' => 'tgl_awal',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Sampai Dengan</label>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modCari,
                    'attribute' => 'tgl_akhir',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span2'),
                ));
                ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modCari, 'penyimpanansteril_no', array('placeholder' => 'No. Penyimpanan', 'class' => 'span3', 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">

        <div class="control-group">
            <label class='control-label'>Rak Penyimpanan</label>
            <div class="controls">
                <?php echo $form->hiddenField($modCari, 'rakpenyimpanan_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modCari,
                    'attribute' => 'rakpenyimpanan_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteRakPenyimpanan') . '",
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
							$("#' . Chtml::activeId($modCari, 'rakpenyimpanan_id') . '").val(ui.item.rakpenyimpanan_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Rak Penyimpanan',
                        'class' => 'rakpenyimpanan_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modCari, 'rakpenyimpanan_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogRakPenyimpanan'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class='control-label'>Lokasi Penyimpanan</label>
            <div class="controls">
                <?php echo $form->hiddenField($modCari, 'lokasipenyimpanan_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modCari,
                    'attribute' => 'lokasipenyimpanan_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompleteLokasiPenyimpanan') . '",
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
							$("#' . Chtml::activeId($modCari, 'lokasipenyimpanan_id') . '").val(ui.item.lokasipenyimpanan_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Lokasi Penyimpanan',
                        'class' => 'lokasipenyimpanan_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modCari, 'lokasipenyimpanan_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLokasiPenyimpanan'),
                ));
                ?>
            </div>
        </div>
    </div>

</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-primary', 'type' => 'button', 'id' => 'pencarian', 'onclick' => 'cekNoPenyimpanan()', 'onkeypress' => 'cekNoPenyimpanan()')
    );
    ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/index'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>

</div>

<?php
//========= Dialog buat cari data Rak Penyimpanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRakPenyimpanan',
    'options' => array(
        'title' => 'Pencarian Rak Penyimpanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

$modRakPenyimpanan = new STRakpenyimpananM('searchRakPenyimpanan');
$modRakPenyimpanan->unsetAttributes();
if (isset($_GET['STRakpenyimpananM'])) {
    $modRakPenyimpanan->attributes = $_GET['STRakpenyimpananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rakpenyimpanan-grid',
    'dataProvider' => $modRakPenyimpanan->searchRakPenyimpanan(),
    'filter' => $modRakPenyimpanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectRakPenyimpanan",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($modCari, 'rakpenyimpanan_id') . '\").val(\"$data->rakpenyimpanan_id\");
                                                  $(\"#' . CHtml::activeId($modCari, 'rakpenyimpanan_nama') . '\").val(\"$data->rakpenyimpanan_nama\");
                                                  $(\"#dialogRakPenyimpanan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'name' => 'rakpenyimpanan_kode',
            'type' => 'raw',
            'value' => '$data->rakpenyimpanan_kode',
        ),
        array(
            'name' => 'rakpenyimpanan_nama',
            'type' => 'raw',
            'value' => '$data->rakpenyimpanan_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Rak Penyimpanan dialog =============================
?>

<?php
//========= Dialog buat cari data Lokasi Penyimpanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLokasiPenyimpanan',
    'options' => array(
        'title' => 'Pencarian Lokasi Penyimpanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

$modLokasiPenyimpanan = new STLokasipenyimpananM('searchLokasiPenyimpanan');
$modLokasiPenyimpanan->unsetAttributes();
if (isset($_GET['STLokasipenyimpananM'])) {
    $modLokasiPenyimpanan->attributes = $_GET['STLokasipenyimpananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'lokasipenyimpanan-grid',
    'dataProvider' => $modLokasiPenyimpanan->searchLokasiPenyimpanan(),
    'filter' => $modLokasiPenyimpanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectLokasiPenyimpanan",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($modCari, 'lokasipenyimpanan_id') . '\").val(\"$data->lokasipenyimpanan_id\");
                                                  $(\"#' . CHtml::activeId($modCari, 'lokasipenyimpanan_nama') . '\").val(\"$data->lokasipenyimpanan_nama\");
                                                  $(\"#dialogLokasiPenyimpanan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'name' => 'lokasipenyimpanan_kode',
            'type' => 'raw',
            'value' => '$data->lokasipenyimpanan_kode',
        ),
        array(
            'name' => 'lokasipenyimpanan_nama',
            'type' => 'raw',
            'value' => '$data->lokasipenyimpanan_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Lokasi Penyimpanan dialog =============================
?>