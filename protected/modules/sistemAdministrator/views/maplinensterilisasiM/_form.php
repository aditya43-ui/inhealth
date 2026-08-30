<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenis-anastesi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class='control-label'>Linen</label>
            <div class="controls">
                <?php

                $linen = new LinenM;
                if (!empty($model->linen_id)) {
                    $linen = LinenM::model()->findByPk($model->linen_id);
                }

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namalinen',
                    'value' => $linen->namalinen,
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
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'No. Register Linen',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#linen_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogLinen'),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'linen_id', array('id' => 'linen_id')); ?>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'peralatansterilisasi_id', array('id' => 'peralatansterilisasi_id')); ?>
        <div class="control-group">
            <label class='control-label'>Peralatan Sterilisasi</label>
            <div class="controls">
                <?php
                $alat = new PeralatansterilisasiM;
                if (!empty($model->peralatansterilisasi_id)) {
                    $alat = PeralatansterilisasiM::model()->findByPk($model->peralatansterilisasi_id);
                }

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaPeralatan',
                    'value' => $alat->peralatansterilisasi_nama,
                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutoCompletePeralatansterilisasi') . '",
							
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
								$("#peralatansterilisasi_id").val(ui.item.peralatansterilisasi_id);  
                                                                $("#namaPeralatan").val(ui.item.peralatansterilisasi_nama); 
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Peralatan Linen',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 custom-only',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogSterilisasi'),
                ));
                ?>
            </div>

        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Sterilisasi Linen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'transaksi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari Nama Linen =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogLinen',
    'options' => array(
        'title' => 'Daftar Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => true,
    ),
));

$modLinen = new SALinenM('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['SALinenM'])) {
    $modLinen->attributes = $_GET['SALinenM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'linen-m-grid',
    'dataProvider' => $modLinen->searchDialog(),
    'filter' => $modLinen,
    'template' => "{pager}{summary}\n{items}",
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
            'value' => 'isset($data->barang_kode)?$data->barang->barang_nama:""'
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

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSterilisasi',
    'options' => array(
        'title' => 'Daftar Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));

$modSterilisasi = new SAPeralatansterilisasiM('searchDialogLinen');
$modSterilisasi->unsetAttributes();
if (isset($_GET['SAPeralatansterilisasiM']))
    $modBarang->attributes = $_GET['SAPeralatansterilisasiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modSterilisasi->searchDialogLinen(),
    'filter' => $modSterilisasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'barang_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#peralatansterilisasi_id\').val(\'$data->peralatansterilisasi_id\');
                                        $(\'#namaPeralatan\').val(\'$data->peralatansterilisasi_nama\');
                                        $(\'#dialogSterilisasi\').dialog(\'close\');
                                        return false;"))',
        ),

        'peralatansterilisasi_nama',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>