<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<div class="row">
    <div class="col-sm-6">

        <div class="control-group keperawatan">
            <?php echo CHtml::label('No. Diagnosa Keperawatan', 'no_diagnosisaskep', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::activeHiddenField($model, 'diagnosisaskep_id', array('class' => 'diagnosisaskep_id'));

                if (!empty($model->diagnosisaskep_id)) {
                    echo CHtml::activeTextField($model, 'no_diagnosisaskep', array('readonly' => true));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'no_diagnosisaskep',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteDiagnosisPerawat') . '",
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
                                $(this).val(ui.item.value);
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                cekDiagnosis(ui.item);
                                return false;
                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogDiagnosis', 'idTombol' => 'tombolDiagnosisDialog'),
                        'htmlOptions' => array('class' => 'span3',
                            'placeholder' => 'No. Diagnosis', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                }
                ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'diagnosisaskep_tgl', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($model, 'diagnosisaskep_tgl', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai', 'nama_pegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true)) ?>
                <?php echo CHtml::activeTextField($model, 'nama_pegawai', array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Detail Diagnosa Keperawatan</label>
            <div class="controls">
                <?php
                echo CHtml::link("<i class=icon-form-detail></i>", 'javascript:void(0);', array("rel" => "tooltip",
                    "title" => "Klik untuk melihat detail",
                    "target" => "frameDetail",
                    "onclick" => "cekRiwayatDiagnosis(this);",
                ));
                ?>
            </div>
        </div>
    </div>

</div>
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosis',
    'options' => array(
        'title' => 'Pencarian Diagnosa Keperawatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 420,
        'resizable' => false,
    ),
));
$modDiagnosis = new DiagnosisaskepT();
$modDiagnosis->unsetAttributes();
$modDiagnosis->diagnosisaskep_tgl = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['DiagnosisaskepT'])) {
    $modDiagnosis->attributes = $_GET['DiagnosisaskepT'];
    $modDiagnosis->nama_pegawai  = isset($_GET['DiagnosisaskepT']['nama_pegawai'])?$_GET['DiagnosisaskepT']['nama_pegawai']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'keperawatan-t-grid',
    'dataProvider' => $modDiagnosis->searchDialog(),
    'filter' => $modDiagnosis,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data){
                $res = $data->attributes;
                $res['nama_lengkap'] = $data->nama_lengkap;
                $res = json_encode($res);
    
                return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPengkajian",
                    "onClick" => "
                        $(\"#dialogDiagnosis\").dialog(\"close\");
                        cekDiagnosis(".$res.");
                "));
            },
        ),
        array(
            'name' => 'no_diagnosisaskep',
            'type' => 'raw',
            'value' => '$data->no_diagnosisaskep',
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->nama_pasien',
        ),
        array(
            'name' => 'no_pendaftaran',
            'type' => 'raw',
            'value' => '$data->no_pendaftaran',
        ),
        array(
            'header' => 'Tgl. Diagnosa Keperawatan',
            'name' => 'diagnosisaskep_tgl',
            'value' => 'MyFormatter::formatDateTimeForUser($data->diagnosisaskep_tgl)',
            'filter' =>
            CHtml::activeTextField($modDiagnosis, 'diagnosisaskep_tgl', array('class' => 'span3 dlg_diagnosisaskep_tgl', 'readonly' => true)),
        /* $this->widget('MyDateTimePicker', array(
          'model' => $modPengkajianAskep,
          'attribute' => 'pengkajianaskep_tgl',
          'mode' => 'date',
          'options' => array(
          'dateFormat' => Params::DATE_FORMAT,
          ),
          'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3', 'id' => 'pengkajianaskep_tgl', 'placeholder' => '23 Jan 1993'),
          ), true
          ), */
        ),
        array(
            'header' => 'Nama Ruangan',
            'name' => 'ruangan_nama',
            'type' => 'raw',
           // 'filter' => CHtml::activeDropDownList($modDiagnosis, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif=TRUE order by '), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"))
        ),
        array(
            'header' => 'Pencatat',
            'name'=>'nama_pegawai',
            'type' => 'raw',
            'value' => '$data->nama_lengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                jQuery("#' . CHtml::activeId($modDiagnosis, 'diagnosisaskep_tgl') . '").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                });
            
            }',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script>
    $(document).ready(function () {
        $('.dlg_diagnosisaskep_tgl').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });
</script>