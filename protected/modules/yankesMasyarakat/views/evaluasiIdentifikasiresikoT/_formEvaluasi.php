<div class="row-fluid lookdisable">
    <div class="col-md-6">

        <div class="control-group">
            <?php echo CHtml::label('Evaluasi Resiko <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modEvaluasi, 'evaluasi_risiko', LookupM::getItems("evaluasi_risiko"), array('class' => 'span3 required', 'empty' => '-- Pilih --')); ?>
                <?php echo $form->hiddenField($modEvaluasi, 'evaluasiidentifikasirisiko_id', array('class' => '', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Risk Response And Action Plan <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($modEvaluasi, 'riskrespon', array('class' => 'span3 required')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::label('Penanggung Jawab <span class="required">*</span>', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modEvaluasi, 'pegawai_id', array('class' => 'required', 'readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'pegawai_nama',
                    'value' => $modEvaluasi->pegawai_nama,
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
                        'class' => 'required',
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                        'select' => 'js:function( event, ui ) {
                                    $("#' . Chtml::activeId($modEvaluasi, 'pegawai_id') . '").val(ui.item.pegawai_id); 
                                    return false;
                                }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Ketik Penanggung Jawab',
                        'class' => 'span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modEvaluasi, 'pegawai_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                ));
                ?>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Mulai', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modEvaluasi,
                    'attribute' => 'tgl_mulai',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'changeYear' => false,
                        'onSelect' => 'js:function( visitedDate ) {
                                          
                                    }',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
                ));
                ?> 

            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Tinjauan', '', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $modEvaluasi,
                    'attribute' => 'tgl_tinjauan',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'changeYear' => false,
                        'onSelect' => 'js:function( visitedDate ){
                                      
                                    }',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker2 span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
                ));
                ?>
            </div>
        </div>
    </div>
</div>


<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Penilai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new PegawaiV('search');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($modEvaluasi, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#pegawai_nama\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
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
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --')),
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
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
