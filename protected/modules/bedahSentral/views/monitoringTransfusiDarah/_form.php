<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<style>
    .numbers-only {
        text-align: right;
    }
</style>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-monitor"></i> Monitoring <b>Transfusi Darah</b>
        </div>
    </div>
    <div class="panel-body">

        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'monitoringtransfusidarah-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#',
        ));
        ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>
        <?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>


        <div class="row">

            <div class="col-sm-6">
                <?php echo $form->dropDownListRow($model, 'monitoring_jeniswaktu', LookupM::getItemsUrutan('jenismonitoring_transfusidarah'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'monitoring_tanggal', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'monitoring_tanggal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'monitoring_jam', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'monitoring_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'onclick' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </div>
                </div>
                <?php
                echo $form->dropDownListRow(
                    $model,
                    'petugasmonitoring_id',
                    CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                        'kelompokpegawai_id' => array(Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_BIDAN),
                    ), array(
                        'order' => 'nama_pegawai',
                    )), 'pegawai_id', 'namaLengkap'),
                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")
                );
                ?>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'stokkantongdarah_id', array('class' => 'control-label')); ?>

                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'stokkantongdarah_id', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'nama_kantong',
                            'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('AutocompleteKantongDarah') . '",
                                   dataType: "json",
                                   data: {
                                       nomorbarcode: request.term,
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                            'options' => array(
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                         $(this).val("");
                                         return false;
                                     }',
                                'select' => 'js:function( event, ui ) {
                                        return false;
                                    }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKantongDarah', 'idTombol' => 'tombolDaftarTindakan'),
                            'htmlOptions' => array(
                                'class' => 'span3 required', 'placeholder' => 'Pilih Kantong Darah', 'rel' => 'tooltip', 'title' => 'Ketik Nomor Barcode Sampel',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'no_kantongdarah', array('class' => 'span3', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'isi_kantongdarah', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'isi_kantongdarah', array('class' => 'span2 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListRow($model, 'reaksi_transfusi', array('-' => '-', '+' => '+'), array(
                    'template' => '<div class="radio-inline">{input}{label}</div>',
                    'onkeyup' => "return $(this).focusNextInputField(event);"
                )); ?>
                <?php echo $form->textAreaRow($model, 'reaksidetail_transfusi', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

                <?php // echo $form->textFieldRow($model, 'ruanganmonitoring_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                ?>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="panel panel-dark">
                <span class="group-title">
                    Tanda-tanda Vital (TTV)
                </span>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'ttv_tdsystolic', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'ttv_tdsystolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    <label>/</label>
                                    <?php echo $form->textField($model, 'ttv_tddiastolic', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    <label>mmHg</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'ttv_nadi', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'ttv_nadi', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    <label>x/Menit</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'ttv_respirasi', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'ttv_respirasi', array('class' => 'span1 numbers-only', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    <label>x/Menit</label>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'ttv_suhutubuh', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'ttv_suhutubuh', array('class' => 'span1 float2', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    <label>&deg;C</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            ); ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('create', array('pendaftaran_id' => $model->pendaftaran_id, 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
            ?>
            <?php // echo CHtml::link(Yii::t('mds','{icon} Pengaturan MonitoringtransfusidarahT',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));  
            ?>
            <?php // $this->widget('UserTips',array('content'=>'')); 
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>



<?php
/* ========= Dialog buat cari Kantong Darah ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKantongDarah',
    'options' => array(
        'title' => 'Daftar Jenis Darah Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 500,
        'resizable' => false,
    ),
));

$modKantong = new InfostokkantongdarahV('searchDialogPengujianKompatibilitas');
$modKantong->unsetAttributes();
$modKantong->pendaftaran_id = $model->pendaftaran_id;
$modKantong->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['InfostokkantongdarahV'])) {
    $modKantong->attributes = $_GET['InfostokkantongdarahV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kantong-m-grid',
    'dataProvider' => $modKantong->searchDialogKantongDarahMonitoringTransfusi(),
    'filter' => $modKantong,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $arr = $data->attributes;
                $arr['jenis_lengkap'] = $data->nama_jenis . " - " . $data->namakomponendrh . " (" . $data->singkatan_komp . ") - " . $data->gol_darah . " " . $data->rhesus;

                $res = CJSON::encode($arr);

                return CHtml::Link("<i class='icon-form-check'></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "selectBahan",
                    "onClick" => "
                                    setKantong(" . $res . ");
                                    $('#dialogKantongDarah').dialog('close');
                                    return false;"
                ));
            },
        ),
        array(
            'header' => 'Nomor Kantong Darah',
            'name' => 'no_kantongdarah',
            'value' => '$data->no_kantongdarah',
        ),
        array(
            'header' => 'Golongan Darah',
            'name' => 'gol_darah',
            'value' => '$data->gol_darah',
            'filter' => CHtml::activeHiddenField($modKantong, 'singkatan_komp') . "" . CHtml::activeDropDownList($modKantong, 'gol_darah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Rhesus',
            'name' => 'rhesus',
            'value' => '$data->rhesus',
        ),
        array(
            'header' => 'Jenis Kantong',
            'name' => 'nama_jenis',
            'value' => '$data->nama_jenis',
        ),
        array(
            'header' => 'Komponen Darah',
            'name' => 'namakomponendrh',
            'value' => '$data->namakomponendrh." (".$data->singkatan_komp.")"',
            'filter' => CHtml::activeDropDownList($modKantong, 'komponendarah_id', CHtml::listData(KomponendarahM::model()->findAll('komponendarah_aktif = true order by namakomponendrh'), 'komponendarah_id', 'namaKomponenLengkap'), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Jumlah',
            'name' => 'jmlkantongdarah',
            'value' => '$data->jmlkantongdarah',
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekStok();}',
));

echo "<div id='note-stok' style='color:red;' ></div>";

$this->endWidget();
?>

<script>
    function setKantong(data) {
        $("#MonitoringtransfusidarahT_stokkantongdarah_id").val(data.stokkantongdarah_id);
        $("#MonitoringtransfusidarahT_nama_kantong").val(data.jenis_lengkap);
        $("#MonitoringtransfusidarahT_no_kantongdarah").val(data.no_kantongdarah);
    }
</script>