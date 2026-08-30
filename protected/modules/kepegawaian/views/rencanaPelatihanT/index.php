<?php $linkHalaman = CustomFunction::getUrlByMenuID(2156); ?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rencanapelatihan-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event); ',
        'onsubmit' => 'return cekValidasi(this);'
    ), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#KPRencanadiklatT_0_pegawai_nama',
)); ?>
<?php
$this->breadcrumbs = array(
    'Registrasi Pelatihan',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Rencana Pelatihan berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Rencana Pelatihan</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Form <b>Rencana Pelatihan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'tglrencanadiklat', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tglrencanadiklat',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($model, 'norencanadiklat', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                        <?php echo $form->dropDownListRow($model, 'jenisdiklat_id', $model->dropJenisDiklat(), array('onchange' => 'showJenisDiklat(this);', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->textFieldRow($model, 'namadiklat', array('placeholder' => 'Nama Pelatihan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        <?php echo $form->textFieldRow($model, 'tempat_diklat', array('placeholder' => 'Tempat Pelatihan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textAreaRow($model, 'alamat_diklat', array('placeholder' => 'Alamat Pelatihan', 'class' => 'autogrow', 'maxlength' => 500)); ?>
                        <div class="internal_pelatihan">
                            <?php echo $form->textFieldRow($model, 'pemateri', array('placeholder' => 'Pemateri', 'class' => 'span3 pemateri', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                        <div class="internal_pelatihan_anti">
                            <?php echo $form->textFieldRow($model, 'penyelenggara', array('placeholder' => 'Penyelenggara', 'class' => 'span3 penyelenggara', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Tanggal", 'tglpresensi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->rencanadiklat_periode)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->rencanadiklat_sampaidgn)) ?>">
                                    <!--data-date="11-18-2017" data-max-date="11-29-2017"-->
                                    <i class="entypo-calendar"></i>
                                    <span><?php echo date('d M Y', strtotime($model->rencanadiklat_periode)) ?> - <?php echo date('d M Y', strtotime($model->rencanadiklat_sampaidgn)) ?></span>
                                    <?php echo $form->hiddenField($model, 'rencanadiklat_periode', array('class' => 'start')) ?>
                                    <?php echo $form->hiddenField($model, 'rencanadiklat_sampaidgn', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Jam <span class='required'>*</span>", '', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'jam_mulai',
                                    'mode' => 'time',
                                    'options' => array(),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'required ', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:70px;'),
                                ));
                                ?>
                            </div>
                            <div class="controls">
                                <label>s/d</label>
                            </div>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'jam_akhir',
                                    'mode' => 'time',
                                    'options' => array(),
                                    'htmlOptions' => array('onchange' => 'jamAkhir(this);', 'readonly' => true, 'class' => 'required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:70px;'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div id="internal_pelatihan" style="display:none;">
                            <?php echo $form->textFieldRow($modBiaya, 'internal_biayapemateri', array('class' => 'integer2')); ?>
                            <?php echo $form->textFieldRow($modBiaya, 'internal_biayakonsumsi', array('class' => 'integer2')); ?>
                            <?php echo $form->textFieldRow($modBiaya, 'internal_biayaalatperaga', array('class' => 'integer2')); ?>
                            <?php echo $form->textFieldRow($modBiaya, 'internal_biayalainlain', array('class' => 'integer2', 'onblur' => 'mandatoryLainLain(this);')); ?>
                            <?php echo $form->textAreaRow($modBiaya, 'internal_keteranganlainlain', array('class' => 'autogrow', 'cols' => 6, 'rows' => 5)); ?>
                        </div>
                        <?php echo $form->hiddenField($model, 'jmlRow', array('class' => 'span2', 'style' => 'width:90px;', 'readonly' => true)) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Peserta</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="items table table-bordered table-striped table-condensed" id="table-rencanapelatihan">
                    <!--<thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No. Induk Pegawai</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jenis Pelatihan</th>
                                        <th>Nama Pelatihan</th>
                                        <th>Tanggal Pelatihan</th>
                                        <th>Lama Pelatihan</th>
                                        <th>Tempat Pelatihan</th>
                                        <th>Alamat Pelatihan</th>
                                        <th></th>
                                    </tr>
                                </thead>-->
                    <thead>
                        <tr>
                            <th rowspan="2"></th>
                            <th rowspan="2" style="vertical-align: middle;text-align: center;">No.</th>
                            <th rowspan="2" style="vertical-align: middle;text-align: center;">No. Induk Pegawai</th>
                            <th rowspan="2" style="vertical-align: middle;text-align: center;">Nama Pegawai</th>
                            <th rowspan="2" style="vertical-align: middle;text-align: center;">Jabatan</th>
                            <th colspan="6" style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Biaya</th>
                            <th rowspan="2" style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Subtotal</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Pelatihan</th>
                            <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Transportasi</th>
                            <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Penginapan</th>
                            <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Perjalanan Dinas</th>
                            <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Lain - Lain</th>
                            <th style="vertical-align: middle;text-align: center;" class="internal_pelatihan_anti">Keterangan<br>Biaya Lain - Lain</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($modDetail) && count((array)$modDetail) > 0) {
                            foreach ($modDetail as $item) {
                                echo $this->renderPartial('_rowRencanaPelatihanV2', array('format' => $format, 'model' => $item), true);
                            }
                        } else {
                            $trRencanaPelatihan = $this->renderPartial('_rowRencanaPelatihanV2', array('format' => $format, 'model' => $modDet), true);
                            echo $trRencanaPelatihan;
                        }
                        ?>
                    </tbody>
                    <tfoot class="internal_pelatihan_anti">
                        <tr>
                            <th colspan="5" style="text-align: right;">Total</th>
                            <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayapelatihan', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                            <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayatransportasi', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                            <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayapenginapan', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                            <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayaperjalanan', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                            <th><?php echo $form->textField($modBiaya, 'eksternal_totbiayalainlain', array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                            <th>&nbsp;</th>
                            <th><?php echo CHtml::textField('totalBiaya', 0, array('style' => 'text-align:right;', 'class' => 'span2 integer2', 'readonly' => true)); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Form <b>Rencana Pelatihan</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row box">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'keterangan_diklat', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($model, 'keterangan_diklat', array('placeholder' => 'Keterangan Rencana', 'rows' => 3, 'cols' => 30, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:175px;')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'pemberitugas_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'pemberitugas_id', array('readonly' => true)); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'pemberitugas_nama',
                                    'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                         url: "' . $this->createUrl('AutocompletePemberiTugas') . '",
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
                                                        $("#' . Chtml::activeId($model, 'pemberitugas_id') . '").val(ui.item.pegawai_id); 
                                                        return false;
                                                    }',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'pemberitugas_nama span4',
                                        'placeholder' => 'Pemberi Tugas',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pemberitugas_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPemberiTugas'),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'mengetahui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'mengetahui_id', array('readonly' => true)); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'pegawaimengetahui_nama',
                                    'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                         url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
                                                        $("#' . Chtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id); 
                                                        return false;
                                                    }',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'pegawaimengetahui_nama span4',
                                        'placeholder' => 'Mengetahui',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'mengetahui_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'menyetujui_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($model, 'menyetujui_id', array('readonly' => true)); ?>
                                <?php
                                $this->widget('MyJuiAutoComplete', array(
                                    'model' => $model,
                                    'attribute' => 'pegawaimenyetujui_nama',
                                    'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                         url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
                                                        $("#' . Chtml::activeId($model, 'menyetujui_id') . '").val(ui.item.pegawai_id); 
                                                        return false;
                                                    }',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'pegawaimenyetujui_nama span4',
                                        'placeholder' => 'Menyetujui',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'menyetujui_id') . '").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php //echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'verifikasiRencanaPelatihan();', 'onkeypress'=>'verifikasiRencanaPelatihan();')); 
            ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons("simpan") . '"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onkeypress' => 'verifikasiRencanaPelatihan();')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
            ); ?>
            <?php $content = $this->renderPartial('../tips/transaksi_rencanapelatihan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<div style='display:none;'>
    <?php
    $this->widget('MyDateTimePicker', array(
        'model' => $model,
        'attribute' => 'rencanadiklat_periode',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
    <?php
    $this->widget('MyDateTimePicker', array(
        'model' => $model,
        'attribute' => 'rencanadiklat_sampaidgn',
        'mode' => 'date',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
        ),
        'htmlOptions' => array(
            'readonly' => true,
            'onkeypress' => "return $(this).focusNextInputField(event)"
        ),
    ));
    ?>
</div>
<?php
//========= Dialog buat cari data Pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
echo '<div id="tablePencarianPegawai"></div>';
$this->renderPartial('_dialogPegawai');
$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end Pegawai dialog =============================
?>
<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemberiTugas',
    'options' => array(
        'title' => 'Pencarian Pemberi Tugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));
$modPemberiTugas = new KPPegawaiV();
$modPemberiTugas->unsetAttributes();
if (isset($_GET['KPPegawaiV'])) {
    $modPemberiTugas->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipemberitugas-grid',
    'dataProvider' => $modPemberiTugas->searchPegawaiPemberiTugasPelatihan(),
    'filter' => $modPemberiTugas,
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
                                                  $(\"#' . CHtml::activeId($model, 'pemberitugas_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pemberitugas_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPemberiTugas\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPemberiTugas, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPemberiTugas, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
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
//========= end Pemberi Tugas dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));
$modPegawaiMengetahui = new KPPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if (isset($_GET['KPPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['KPPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->searchPegawaiMengathuiPelatihan(),
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
                                                  $(\"#' . CHtml::activeId($model, 'mengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
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
//========= end Pegawai Mengetahui dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMenyetujui',
    'options' => array(
        'title' => 'Pencarian Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));
$modPegawaiMenyetujui = new KPPegawaiV('search');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['KPPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['KPPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchPegawaiMenyetujuiPelatihan(),
    'filter' => $modPegawaiMenyetujui,
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
                                                  $(\"#' . CHtml::activeId($model, 'menyetujui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimenyetujui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' =>  CHtml::activeDropDownList($modPegawaiMenyetujui, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
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
//========= end Pegawai Menyetujui dialog =============================
?>
<script type="text/javascript">
    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogPegawai";
        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setPegawaiAuto(pegawai_id) {
        dialog = "#dialogPegawai";
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        $.get('<?php echo $this->createUrl('AutocompletePegawai'); ?>', {
            pegawai_id: pegawai_id
        }, function(data) {
            $(obj).val(data[0].nama_pegawai);
            $(obj).val(data[0].nomorindukpegawai);
            setPegawai(obj, data[0]);
        }, "json");
        $(dialog).dialog("close");
    }

    function setPegawai(obj, item) {
        $(obj).parents('tr').find('input[name$="[pegawai_nama]"]').val(item.nama_pegawai);
        $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
        $(obj).parents('tr').find('input[name$="[nomorindukpegawai]"]').val(item.nomorindukpegawai);
        $(obj).parents('tr').find('input[name$="[jabatan_id]"]').val(item.jabatan_id);
        $(obj).parents('tr').find('input[name$="[jabatan_nama]"]').val(item.jabatan_nama);
    }

    function addRowPelatihan(obj) {
        var trRencanaPelatihan = new String(<?php echo CJSON::encode($this->renderPartial('_rowRencanaPelatihanV2', array('model' => $modDet, 'format' => $format, 'removeButton' => true), true)); ?>);
        $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style', 'display:none;');
        $("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style', 'display:true;');
        $(obj).parents('table').children('tbody').append(trRencanaPelatihan.replace());
        renameInput('#table-rencanapelatihan');
        set_internal_eksternal();
    }

    function hapusPelatihan(obj) {
        myConfirm('Apakah Anda akan menghapus peserta ini?', 'Perhatian!',
            function(r) {
                if (r) {
                    $(obj).parents('tr').detach();
                    renameInput('#table-rencanapelatihan');
                }
            });
    }

    function renameInput(obj_table) {
        var row = 0;
        var jmlRow = $('#table-rencanapelatihan tbody tr').length;
        if (jmlRow == 1) {
            $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
            $("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style', 'display:none;');
        } else {
            $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
            $("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style', 'display:true;');
        }
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span[name*="[ii]"]').each(function() { //element <span>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }

    function verifikasiRencanaPelatihan() {
        $("#table-rencanapelatihan").addClass("animation-loading");
        if (requiredCheck($("rencanapelatihan-form"))) {
            var jml_row = $('#table-rencanapelatihan tbody tr').length;
            $('#<?php echo CHtml::activeId($model, "jmlRow"); ?>').val(jml_row);
            if (validasiDetail()) {
                $('#rencanapelatihan-form').submit();
            } else {
                formatNumberSemua();
                $("#table-rencanapelatihan").removeClass("animation-loading");
                return false;
            }
            $("#table-rencanapelatihan").removeClass("animation-loading");
            $("form").find('.float').each(function() {
                $(this).val(formatFloat($(this).val()));
            });
            $("form").find('.integer').each(function() {
                $(this).val(formatInteger($(this).val()));
            });
        }
        return false;
    }

    function validasiDetail() {
        if (validasiDetailPegawai() && validasiDetailJenisDiklat() && validasiDetailNamaDiklat() && validasiDetailTanggalPelatihanDari() && validasiDetailTanggalPelatihanSD() && validasiDetailSatuanLamaDiklat() && validasiDetailLamaDiklat() && validasiDetailTempatDiklat() && validasiDetailAlamatDiklat()) {
            return true;
        } else {
            return false;
        }
    }

    function validasiDetailPegawai() {
        var detailpegawai_id = document.getElementsByClassName("pegawai_id");
        var jml = detailpegawai_id.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailpegawai_id[i].value === '') {
                myAlert('Silakan lengkapi semua Nama Pegawai!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailJenisDiklat() {
        var detailjenisdiklat_id = document.getElementsByClassName("jenisdiklat_id");
        var jml = detailjenisdiklat_id.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailjenisdiklat_id[i].value === '') {
                myAlert('Silakan lengkapi semua Jenis Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailNamaDiklat() {
        var detailnamadiklat = document.getElementsByClassName("namadiklat");
        var jml = detailnamadiklat.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailnamadiklat[i].value === '') {
                myAlert('Silakan lengkapi semua Nama Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailTanggalPelatihanDari() {
        var detailrencanadiklat_periode = document.getElementsByClassName("rencanadiklat_periode");
        var jml = detailrencanadiklat_periode.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailrencanadiklat_periode[i].value === '') {
                myAlert('Silakan lengkapi semua Tanggal Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailTanggalPelatihanSD() {
        var detailrencanadiklat_sampaidgn = document.getElementsByClassName("rencanadiklat_sampaidgn");
        var jml = detailrencanadiklat_sampaidgn.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailrencanadiklat_sampaidgn[i].value === '') {
                myAlert('Silakan lengkapi semua Tanggal Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailSatuanLamaDiklat() {
        var detailsatuan_lama = document.getElementsByClassName("satuan_lama");
        var jml = detailsatuan_lama.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailsatuan_lama[i].value === '0') {
                myAlert('Silakan lengkapi semua Satuan Lama Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailLamaDiklat() {
        var detaillamadiklat = document.getElementsByClassName("lamadiklat");
        var jml = detaillamadiklat.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detaillamadiklat[i].value === '') {
                myAlert('Silakan lengkapi semua Lama Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailTempatDiklat() {
        var detailtempat_diklat = document.getElementsByClassName("tempat_diklat");
        var jml = detailtempat_diklat.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailtempat_diklat[i].value === '') {
                myAlert('Silakan lengkapi semua Tempat Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function validasiDetailAlamatDiklat() {
        var detailalamat_diklat = document.getElementsByClassName("alamat_diklat");
        var jml = detailalamat_diklat.length;
        var kosong = false;
        for (i = 0; i < jml; i++) {
            if (detailalamat_diklat[i].value === '') {
                myAlert('Silakan lengkapi semua Alamat Pelatihan!');
                kosong = true;
                break;
            }
        }
        if (kosong)
            return false;
        else
            return true;
    }

    function tombolTambahHapus() {
        var jmlRow = parseInt($('#table-rencanapelatihan tbody tr').length);
        if (jmlRow === 1) {
            $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
        } else {
            $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
            $("#table-rencanapelatihan > tbody > tr:last .hapusRow").attr('style', 'display:true;');
        }
    }
    /**
     * - digunakan untuk menampilkan jam akhir 1 jam dari jam mulai
     * @param {type} obj
     * @returns {gene} */
    function jamMulai(obj) {
        var jam_mulai = $(obj).val();
        var pecah = jam_mulai.split(":");
        var jam = parseInt(pecah[0]);
        var jamTot = jam + 1;
        if (jamTot < 10) {
            jamTot = '0' + jamTot;
        } else if (jamTot > 22) {
            jamTot = '00';
        }
        $("#<?php echo CHtml::activeId($model, 'jam_akhir') ?>").val(jamTot + ':' + pecah[1] + ':' + pecah[2]);
        //$("#total_jam").val(1);
        //alert(pecah[0]);
    }
    /**
     * 
     * @param {type} obj
     * @returns {membuat mandatory field keterangan lain - lain}
     */
    function mandatoryLainLain(obj) {
        var lainlain = $(obj).val();
        if (lainlain != 0) {
            $("#<?php echo CHtml::activeId($modBiaya, 'internal_keteranganlainlain') ?>").addClass('required');
        } else {
            $("#<?php echo CHtml::activeId($modBiaya, 'internal_keteranganlainlain') ?>").removeClass('error required');
        }
    }
    /**
     * - digunakan untuk menampilkan field yang masuk ke jenis pelatihan eksternal atau internal
     * @param {type} obj
     * @returns {} */
    var is_internal = false;

    function set_internal_eksternal() {
        internal_pelatihan(is_internal);
        eksternal_pelatihan(is_internal);
    }

    function showJenisDiklat(obj) {
        var jenis = $(obj).val();
        if (jenis == <?php echo Params::JENIS_DIKLAT_EKSTERNAL; ?>) {
            is_internal = false;
        } else if (jenis == <?php echo Params::JENIS_DIKLAT_INTERNAL; ?>) {
            is_internal = true;
        }
        set_internal_eksternal();
        resetEksternal();
        resetInternal();
    }
    /**
     * - digunakan untuk isian jenis pelatihan internal mengembalikan untuk inputan yang berlaku untuk pelatihan internal saja dikembalikan ke semula
     * @returns {undefined} */
    function internal_pelatihan(cek) {
        if (cek == true) {
            $(".penyelenggara").prop('disabled', true);
            $(".pemateri").prop('disabled', false);
            $("#internal_pelatihan, .internal_pelatihan").show();
            $(".internal_pelatihan_anti").hide();
        } else {
            $(".penyelenggara").prop('disabled', false);
            $(".pemateri").prop('disabled', true);
            $("#internal_pelatihan, .internal_pelatihan").hide();
            $(".internal_pelatihan_anti").show();
        }
        $('#table-rencanapelatihan tbody tr').each(function() {
            $(this).find('input[name$="[biaya_pelatihan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_transportasi]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_penginapan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_perjalanandinas]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_lainlain]"]').attr('readonly', cek);
        });
    }
    /**
     * - digunakan untuk isian jenis pelatihan eksternal mengembalikan untuk inputan yang berlaku untuk pelatihan ekternal saja dikembalikan ke semula
     * @returns {} 
     * */
    function eksternal_pelatihan(cek) {
        $('#table-rencanapelatihan tbody tr').each(function() {
            /*
        $(this).find('input[name$="[biaya_pelatihan]"]').val(0);
        $(this).find('input[name$="[biaya_transportasi]"]').val(0);
        $(this).find('input[name$="[biaya_penginapan]"]').val(0);
        $(this).find('input[name$="[biaya_perjalanandinas]"]').val(0);
        $(this).find('input[name$="[biaya_lainlain]"]').val(0);
        $(this).find('input[name$="[total]"]').val(0);                
        $(this).find('input[name$="[keterangan_lainlain]"]').val('');  
		*/
            $(this).find('input[name$="[biaya_pelatihan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_transportasi]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_penginapan]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_perjalanandinas]"]').attr('readonly', cek);
            $(this).find('input[name$="[biaya_lainlain]"]').attr('readonly', cek);
            $(this).find('input[name$="[keterangan_lainlain]"]').attr('readonly', cek);
        });
    }
    /**
     * - digunakan untuk mereset field ke nilai semua
     * @returns {undefined} */
    function resetInternal() {
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayapemateri'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayakonsumsi'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayaalatperaga'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_biayalainlain'); ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'internal_keteranganlainlain'); ?>").val('');
    }
    /**
     * - digunakan untuk mereset field ke nilai semua
     * @returns {undefined}
     */
    function resetEksternal() {
        $('#table-rencanapelatihan tbody tr').each(function() {
            $(this).find('input[name$="[biaya_pelatihan]"]').val(0);
            $(this).find('input[name$="[biaya_transportasi]"]').val(0);
            $(this).find('input[name$="[biaya_penginapan]"]').val(0);
            $(this).find('input[name$="[biaya_perjalanandinas]"]').val(0);
            $(this).find('input[name$="[biaya_lainlain]"]').val(0);
            $(this).find('input[name$="[total]"]').val(0);
            $(this).find('input[name$="[keterangan_lainlain]"]').val('');
        });
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapelatihan') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayatransportasi') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapenginapan') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayaperjalanan') ?>").val(0);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayalainlain') ?>").val(0);
    }

    function hitungTotal() {
        unformatNumberSemua();
        var total = 0;
        var tot_biayapelatihan = 0;
        var tot_biayatransportasi = 0;
        var tot_biayapenginapan = 0;
        var tot_biayaperjalanandinas = 0;
        var tot_biayalainlain = 0;
        var grandtotal = 0;
        var row = 0;
        $('#table-rencanapelatihan tbody tr').each(function() {
            var biaya_pelatihan = parseInt($(this).find('input[name$="[biaya_pelatihan]"]').val());
            var biaya_transportasi = parseInt($(this).find('input[name$="[biaya_transportasi]"]').val());
            var biaya_penginapan = parseInt($(this).find('input[name$="[biaya_penginapan]"]').val());
            var biaya_perjalanandinas = parseInt($(this).find('input[name$="[biaya_perjalanandinas]"]').val());
            var biaya_lainlain = parseInt($(this).find('input[name$="[biaya_lainlain]"]').val());
            //total
            total = total + biaya_pelatihan + biaya_transportasi + biaya_penginapan + biaya_perjalanandinas + biaya_lainlain;
            //total biaya pelatihan
            tot_biayapelatihan = tot_biayapelatihan + biaya_pelatihan;
            //total biaya transportasi
            tot_biayatransportasi = tot_biayatransportasi + biaya_transportasi;
            //total biaya penginapan
            tot_biayapenginapan = tot_biayapenginapan + biaya_penginapan;
            // ttoal biaya perjalanan dinas
            tot_biayaperjalanandinas = tot_biayaperjalanandinas + biaya_perjalanandinas;
            //total biaya lain - lain
            tot_biayalainlain = tot_biayalainlain + biaya_lainlain;
            $(this).find('input[name$="[total]"]').val(total);
            //$(this).find('input[name$="[stok_akhirtot]"]').val(stokawal+jmlpermintaan);
            grandtotal = grandtotal + total;
            total = 0;
            row++;
        });
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapelatihan') ?>").val(tot_biayapelatihan);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayatransportasi') ?>").val(tot_biayatransportasi);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayapenginapan') ?>").val(tot_biayapenginapan);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayaperjalanan') ?>").val(tot_biayaperjalanandinas);
        $("#<?php echo CHtml::activeId($modBiaya, 'eksternal_totbiayalainlain') ?>").val(tot_biayalainlain);
        $("#totalBiaya").val(grandtotal);
        formatNumberSemua();
    }

    function cekValidasi(obj) {
        if ($(".penyelenggara").val().trim() == "" && $("#KPRencanadiklatT_jenisdiklat_id").val() == <?php echo Params::JENIS_DIKLAT_EKSTERNAL; ?>) {
            myAlert("Penyelenggaran harus diisi.");
            return false;
        }
        if ($(".pemateri").val().trim() == "" && $("#KPRencanadiklatT_jenisdiklat_id").val() == <?php echo Params::JENIS_DIKLAT_INTERNAL; ?>) {
            myAlert("Pemateri harus diisi.");
            return false;
        }
        return requiredCheck(obj);
    }
    $(document).ready(function() {
        $("#table-rencanapelatihan > tbody > tr:last .tambahRow").attr('style', 'display:true;');
        renameInput('#table-rencanapelatihan');
        var jenis = $("#KPRencanadiklatT_jenisdiklat_id").val();
        if (jenis == <?php echo Params::JENIS_DIKLAT_EKSTERNAL; ?>) {
            is_internal = false;
        } else if (jenis == <?php echo Params::JENIS_DIKLAT_INTERNAL; ?>) {
            is_internal = true;
        }
        set_internal_eksternal();
    });
</script>