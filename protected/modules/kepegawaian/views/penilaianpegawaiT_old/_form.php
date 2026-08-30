<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kppenilaianpegawai-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box" id="form-pegawai">
    <legend class='rim'>
        <i class="entypo-user"></i> Data <b>Pegawai</b>
        <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setPegawaiReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pegawai')); ?></span>
    </legend>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="row">
        <div class="col-sm-4">
            <?php echo $form->textFieldRow($modPegawai, 'nomorindukpegawai', array('readonly' => true, 'id' => 'nomorindukpegawai', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
            <div class="control-group">
                <?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($modPegawai, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                    <?php

                    $modul = ModulK::model()->findByAttributes(
                        array('modul_key' => $this->module->id)
                    );
                    $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '');
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'namapegawai',
                        'value' => isset($modPegawai->nama_pegawai) ? $modPegawai->nama_pegawai : "",
                        'sourceUrl' => $this->createUrl('AutocompletePegawai'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 4,
                            'focus' => 'js:function( event, ui ) {
                                            $("#pegawai_id").val( ui.item.value );
                                            $("#namapegawai").val( ui.item.nama_pegawai );
                                            return false;
                                        }',
                            'select' => 'js:function( event, ui ) {
                                            $("#pegawai_id").val( ui.item.value );
                                            $("#NIP").val( ui.item.nomorindukpegawai);
                                            $("#tempatlahir_pegawai").val( ui.item.tempatlahir_pegawai);
                                            $("#tgl_lahirpegawai").val( ui.item.tgl_lahirpegawai);
                                            $("#namapegawai").val( ui.item.nama_pegawai);
                                            $("#jeniskelamin").val( ui.item.jeniskelamin);
                                            $("#statusperkawinan").val( "ui.item.statusperkawinan");
                                            $("#alamat_pegawai").val( ui.item.alamat_pegawai);
                                            setDataPegawai(ui.item.pegawai_id);
                                            return false;
                                        }',

                        ),
                        'htmlOptions' => array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                        'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                    )); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($modPegawai, 'tempatlahir_pegawai', array('readonly' => true, 'id' => 'tempatlahir_pegawai', 'onkeyup' => "return $(this).focusNextInputField(event)", 'value' => isset($modPegawai->tempatlahir_pegawai) ? $modPegawai->tempatlahir_pegawai : "")); ?>
            <?php echo $form->textFieldRow($modPegawai, 'tgl_lahirpegawai', array('readonly' => true, 'id' => 'tgl_lahirpegawai', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
        </div>
        <div class="col-sm-4">
            <?php echo $form->textFieldRow($modPegawai, 'jeniskelamin', array('readonly' => true, 'id' => 'jeniskelamin', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
            <?php echo $form->textFieldRow($modPegawai, 'statusperkawinan', array('readonly' => true, 'id' => 'statusperkawinan', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
            <?php echo $form->textFieldRow($modPegawai, 'jabatan_id', array('readonly' => true, 'id' => 'jabatan', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
            <?php echo $form->textAreaRow($modPegawai, 'alamat_pegawai', array('readonly' => true, 'id' => 'alamat_pegawai', 'onkeyup' => "return $(this).focusNextInputField(event)",)); ?>
        </div>
        <div class="col-sm-4">
            <?php
            if (file_exists(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $modPegawai->photopegawai)) {
                echo CHtml::image(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $modPegawai->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            } else {
                echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            }
            ?>
        </div>
    </div>
</fieldset>
<fieldset class="box row">
    <legend class="rim">Data Penilaian</legend>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tglpenilaian', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tglpenilaian = (!empty($model->tglpenilaian) ? date("d/m/Y", strtotime($model->tglpenilaian)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpenilaian',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'tglpenilaian'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'periodepenilaian', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->periodepenilaian = (!empty($model->periodepenilaian) ? date("d/m/Y", strtotime($model->periodepenilaian)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'periodepenilaian',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'periodepenilaian'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'sampaidengan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->sampaidengan = (!empty($model->sampaidengan) ? date("d/m/Y", strtotime($model->sampaidengan)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'sampaidengan',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'sampaidengan'); ?>
            </div>
        </div>
        <hr>
        <?php // echo $form->textFieldRow($model, 'kesetiaan', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <?php // echo $form->textFieldRow($model, 'prestasikerja', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <?php // echo $form->textFieldRow($model, 'tanggungjawab', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <?php // echo $form->textFieldRow($model, 'ketaatan', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <?php // echo $form->textFieldRow($model, 'kejujuran', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <?php // echo $form->textFieldRow($model, 'kerjasama', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <?php // echo $form->textFieldRow($model, 'prakarsa', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <?php // echo $form->textFieldRow($model, 'kepemimpinan', array('class' => 'span3 integer pointNilai', 'onkeyup'=>"return $(this).focusNextInputField(event);",'placeholder'=>'nilai yang diberikan antara 0-10')); 
        ?>
        <hr>
        <?php echo $form->textFieldRow($model, 'jumlahpenilaian', array('class' => 'span3 integer totalNilai', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
        <?php echo $form->textFieldRow($model, 'nilairatapenilaian', array('class' => 'span3 integer rataNilai', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => True)); ?>
        <?php echo $form->textFieldRow($model, 'performanceindex', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

    </div>
    <div class="col-sm-4">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tanggapanpejabat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tanggal_tanggapanpejabat = (!empty($model->tanggal_tanggapanpejabat) ? date("d/m/Y", strtotime($model->tanggal_tanggapanpejabat)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_tanggapanpejabat',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->textArea($model, 'tanggapanpejabat', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->error($model, 'tanggal_tanggapanpejabat'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'keputusanatasan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tanggal_keputusanatasan = (!empty($model->tanggal_keputusanatasan) ? date("d/m/Y", strtotime($model->tanggal_keputusanatasan)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_keputusanatasan',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->textArea($model, 'keputusanatasan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->error($model, 'tanggal_keputusanatasan'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'keberatanpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tanggal_keberatanpegawai = (!empty($model->tanggal_keberatanpegawai) ? date("d/m/Y", strtotime($model->tanggal_keberatanpegawai)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_keberatanpegawai',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->textArea($model, 'keberatanpegawai', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->error($model, 'tanggal_keberatanpegawai'); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <?php echo $form->textAreaRow($model, 'penilaianpegawai_keterangan', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diterimatanggalpegawai', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->diterimatanggalpegawai = (!empty($model->diterimatanggalpegawai) ? date("d/m/Y", strtotime($model->diterimatanggalpegawai)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'diterimatanggalpegawai',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'diterimatanggalpegawai'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'diterimatanggalatasan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->diterimatanggalatasan = (!empty($model->diterimatanggalatasan) ? date("d/m/Y", strtotime($model->diterimatanggalatasan)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'diterimatanggalatasan',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($model, 'diterimatanggalatasan'); ?>
            </div>
        </div>
        <hr>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'penilainama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'penilainama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiPenilai') . '",
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                                    $(this).val( ui.item.label);
                                                                    return false;
                                                                }',
                        'select' => 'js:function( event, ui ) {
                                                                    getDataPenilai(ui.item.value);
                                                                    return false;
                                                                }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event);"
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPenilai'),
                ));
                ?>
                <?php echo $form->error($model, 'penilainama'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'penilainip', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php //echo $form->textFieldRow($model,'penilaipangkatgol',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); 
        ?>
        <?php echo $form->textFieldRow($model, 'penilaijabatan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'penilaiunitorganisasi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <hr>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pimpinannama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pimpinannama',
                    'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePegawaiPimpinan') . '",
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            getDataPemimpin(ui.item.value);
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeyup' => "return $(this).focusNextInputField(event);"
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPimpinan'),
                ));
                ?>
                <?php echo $form->error($model, 'pimpinannama'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'pimpinannip', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'pimpinanjabatan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'pimpinanunitorganisasi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>

    </div>
</fieldset>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = (!empty($_GET['penilaianpegawai_id'])) ? true : (($sukses > 0) ? true : false);
    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)
    );
    ?>
    <?php if (!isset($_GET['frame'])) {
        echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/create'),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        );
    } ?>
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
    ?>

    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsPenilaian', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<?php
Yii::app()->clientScript->registerScript('onreadyfunction', '
    $(".pointNilai").keypress(function(){
        var value = $(this).val();
        var jumlah = $(".pointNilai").length;
        var total = 0;
        if (value > 10){
            $(this).val(10);
        }
        $(".pointNilai").each(function(data){
            total += parseFloat($(this).val());
        });
        if (jQuery.isNumeric(total)){
            $(".totalNilai").val(total);
            $(".rataNilai").val(total/jumlah);
        }
    });
', CClientScript::POS_READY); ?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPimpinan',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new KPPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['KPPegawaiM']))
    $modPegawai->attributes = $_GET['KPPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai2-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "id" => "selectBahan",
                "href"=>"",
                "onClick" => "
                      getDataPemimpin(\"$data->pegawai_id\");
                      $(\"#dialogPimpinan\").dialog(\"close\");    
                      return false;
            "))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        array(
            'header' => 'Jabatan',
            'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "")',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenilai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new KPPegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['KPPegawaiM']))
    $modPegawai->attributes = $_GET['KPPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai3-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                    "id" => "selectBahan",
                    "href"=>"",
                    "onClick" => "
                      getDataPenilai(\"$data->pegawai_id\");
                      $(\"#dialogPenilai\").dialog(\"close\");    
                      return false;
                "))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' =>  LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),
        array(
            'header' => 'Jabatan',
            'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "")',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPegawai = new PegawaiM;

$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiM']))
    $modPegawai->attributes = $_GET['PegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                        "id" => "selectPegawai",
                        "href"=>"",
                        "onClick" => "
                              setDataPegawai(\"$data->pegawai_id\");
                              $(\"#dialogPegawai\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        array(
            'header' => 'Tanggal Lahir',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
            'filter' => false,
        ),
        'jeniskelamin',
        'statusperkawinan',
        'jabatan.jabatan_nama',
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
$url = new KPRegistrasifingerprint;
?>
<?php $this->renderPartial('kepegawaian.views.penilaianpegawaiT._jsFunctions', array('model' => $model, 'modPegawai' => $modPegawai)); ?>