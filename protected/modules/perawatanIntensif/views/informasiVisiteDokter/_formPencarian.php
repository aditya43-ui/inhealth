<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'daftarvisitedokter-form',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pegawai'),
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <label class="control-label">
                        <?php //$model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal); ?>
                        <?php $model->tgl_awal = date('d M Y', strtotime($model->tgl_awal)); ?>
                        Tanggal Visite
                  </label>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                        ));
                        ?> </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">
                        Sampai dengan
                  </label>
                    <div class="controls">
                        <?php //$model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php $model->tgl_akhir = date('d M Y', strtotime($model->tgl_akhir)); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2 dtPicker3'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelaspelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'dokter_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'dokter_id', array()); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'nama_pegawai',
                            'source' => 'js: function(request, response) {
											   $.ajax({
												   url: "' . $this->createUrl('AutocompleteDokter') . '",
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
                                'select' => 'js:function( event, ui ) {
										   $(this).val( ui.item.label);
										   $("#' . CHtml::activeId($model, 'dokter_id') . '").val( ui.item.pegawai_id);
											return false;
										}',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDokter'),
                            'htmlOptions' => array(
                                'placeholder' => 'Dokter',
                                "rel" => "tooltip", "title" => "Data Dokter", 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($model, 'dokter_id') . '").val(""); '
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-ac">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'));
            echo CHtml::hiddenField('pendaftaran_id');
            echo CHtml::hiddenField('pasien_id');
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
                'class' => 'btn btn-default',
                'onclick' => 'window.parent.myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
            ));
            ?>
            <?php
            $content = $this->renderPartial('tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokter',
    'options' => array(
        'title' => 'Daftar Dokter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modDokter = new PIDokterV('searchDialogDokter');
$modDokter->unsetAttributes();
if (isset($_GET['PIDokterV'])) {
    $modDokter->attributes = $_GET['PIDokterV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaiYangMengajukan-m-grid',
    'dataProvider' => $modDokter->searchDialogDokter(),
    'filter' => $modDokter,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Pegawai","class"=>"btn_small",
					"id"=>"selectPegawai",
					"onClick"=>"$(\"#' . CHtml::activeId($model, 'dokter_id') . '\").val(\"$data->pegawai_id\");
							$(\"#nama_pegawai\").val(\"$data->NamaLengkap\");
							$(\"#dialogDokter\").dialog(\"close\");
							return false;"
					))'
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter Resep',
            'type' => 'raw',
            'value' => '$data->NamaLengkap',
        ),
        'jeniskelamin',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>