<style type="text/css">
    .text-center{
        text-align: center !important;
    }
    .font-bold{
        font-weight: bold;
        color: black;
    }
</style>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'evaluasiawal-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    ));
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php echo $form->hiddenField($model, 'pasien_id'); ?>
<?php echo $form->hiddenField($model, 'ruangan_id'); ?>
<?php echo $form->hiddenField($model, 'kelaspelayanan_id'); ?>
<?php echo $form->hiddenField($model, 'diagnosa_id'); ?>
<div class="row-fluid">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Catatan Evaluasi Awal</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php 
                            
                            $resiko_item = LookupM::getItems('kelompokresiko');
                            if (!in_array($model->kelompok_resiko, $resiko_item)) {
                                $model->kelompok_resikolainnya = $model->kelompok_resiko;
                                $model->kelompok_resiko = "LAINNYA";
                            }
                            
                            echo CHtml::label("Identifikasi/Skrining Pasien <span class='required'>*</span>", 'kelompok_resiko', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($model, 'kelompok_resiko', $resiko_item, array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'span3', 'onchange' => 'changeKelompokResiko(this);')); ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Lainnya <span class='required'>*</span>", '', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($model, 'kelompok_resikolainnya', array('disabled' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>

                    </div>
                </div>
                <br/>
                <div class="panel panel-darkk">
                    <span class="group-title">
                        Asesmen - Informasi Klinis
                    </span>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <div class = "col-sm-6">
                                <?php echo $form->textFieldRow($model, 'psikososial', array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                            <div class = "col-sm-6">
                                <?php echo $form->textFieldRow($model, 'sosioekonomi', array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="row-fluid">
                    <div class = "col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::activeLabelEx($model, 'identifikasi_masalah', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->textArea($model, 'identifikasi_masalah', array('rows' => 5, 'class' => 'span4'));
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class = "col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::activeLabelEx($model, 'perencanaan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->textArea($model, 'perencanaan', array('rows' => 5, 'class' => 'span4'));
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row-fliud">
                    <div class = "col-sm-12">
                        <div class="control-group ">
                            <?php echo CHtml::activeLabelEx($model, 'assesmen', array('class' => 'control-label', 'label' => 'Edukasi Pasien dalam Pengambilan Keputusan')); ?>
                            <div class="controls">
                                <?php
                                echo $form->textArea($model, 'assesmen', array('rows' => 5, 'class' => 'span7'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>


                <!--                        <div class="control-group ">
                <?php // echo CHtml::activeLabelEx($model, 'identifikasi_skriningpasien', array('class' => 'control-label')); ?>
                                <div class="controls">
                <?php
                // echo $form->textArea($model, 'identifikasi_skriningpasien', array('rows' => 5, 'style' => 'width: 700px;'));
                ?>
                                </div>
                            </div>-->



            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Pengisi</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::activeLabelEx($model, 'tgl_evaluasi', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_evaluasi',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <?php echo CHtml::label("Manager Pelayanan Pasien <font style='color:red;'>*</font>", 'petugaspengisi_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'petugaspengisi_id', array('class' => 'required')); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'petugaspengisi_nama',
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
                                            $("#' . Chtml::activeId($model, 'petugaspengisi_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder' => 'Ketikan Petugas Pengisi',
                                        'class' => 'col-sm-8 pegawaimengetahui_nama required hurufs-only',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'petugaspengisi_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                                ));
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if (isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'disabled' => true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
                }
                echo "&nbsp;";

                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl('index', array(
                        'pendaftaran_id'=>(isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null),
                        'pasien_id'=>(isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null),
                        'typeinstalasi'=>(isset($_GET['typeinstalasi']) ? $_GET['typeinstalasi'] : null),
                        'pasien_id'=>!empty($model->pasien_id) ? $model->pasien_id : null,
                    )),
                    array('class' => 'btn btn-danger',
                        'onclick' => 'return refreshForm(this);'));
                echo "&nbsp;";

                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Petugas Pengisi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV('searchPegawaiRuangan');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState("ruangan_id");
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiRuangan(),
    'filter' => $modPegawaiMengetahui,
//        'template'=>"{items}\n{pager}",
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
                                                  $(\"#' . CHtml::activeId($model, 'petugaspengisi_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'petugaspengisi_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\");
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only')),
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only')),
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'name' => 'jabatan_id',
            'value' => function($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".numbers-only").keyup(function(){'
    . 'setNumbersOnly(this);'
    . '});'
    . '$(".hurufs-only").keyup(function(){'
    . 'setHurufsOnly(this);'
    . '});'
    . '}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
