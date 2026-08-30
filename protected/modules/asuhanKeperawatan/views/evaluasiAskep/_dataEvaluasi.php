<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php // echo CHtml::activeHiddenField($model, 'anamesa_id',array('readonly'=>true, 'class'=>'span1')); ?>
            <?php // echo CHtml::activeHiddenField($model, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); ?>
            <?php echo CHtml::activeLabel($model, 'no_evaluasi', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'no_evaluasi', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'evaluasiaskep_tgl', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'evaluasiaskep_tgl',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Nama Perawat <span class="required">*</span>', 'nama_pegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('required' => true, 'readonly' => true)) ?>
                <?php
                $modul = ModulK::model()->findByAttributes(
                        array('modul_key' => $this->module->id)
                );
                $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
                echo $form->textField($model, 'nama_pegawai', array('required' => true, 'readonly' => true));
                /*
                  $this->widget('MyJuiAutoComplete', array(
                  'model' => $model,
                  'name' => 'ASEvaluasiaskepT[nama_pegawai]',
                  'value' => !empty($model->pegawai_id) ? $model->pegawai->nama_pegawai : "",
                  'source' => 'js: function(request, response) {
                  $.ajax({
                  url: "' . $this->createUrl('Pegawairiwayat') . '",
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
                  $("#ASEvaluasiaskepT_pegawai_id").val(ui.item.pegawai_id);
                  $("#ASEvaluasiaskepT_nama_pegawai").val( ui.item.nama_pegawai );
                  return false;
                  }',
                  ),
                  'tombolDialog' => array("idDialog" => 'dialogPegawai'),
                  'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required'),
                  ));
                 */
                ?>
            </div>
        </div>
    </div>

</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));

$modPegawai = new ASPegawaiM;
if (isset($_GET['ASPegawaiM'])) {
    $modPegawai->attributes = $_GET['ASPegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->searchPerawat(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
								$(\"#ASEvaluasiaskepT_pegawai_id\").val(\"$data->pegawai_id\");
								$(\"#ASEvaluasiaskepT_nama_pegawai\").val(\"$data->nama_pegawai\");
								$(\"#dialogPegawai\").dialog(\"close\");    
                                return false;
                                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            }
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeDropDownList($modPegawai, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tgl_lahirpegawai\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tgl_lahirpegawai_date\').on(\'click\', function(){jQuery(\'#tgl_lahirpegawai\').datepicker(\'show\');});
                
            
            }',
));

$this->endWidget();
?>