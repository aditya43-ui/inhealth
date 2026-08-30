<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'saprofil-rumah-sakit-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#SAProfilRumahSakitM_tahunprofilrs',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<fieldset class='box'>
    <legend class="rim">Data Rumah Sakit</legend>
    <table width='100%'>
        <tr>
            <td width='33%'>
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'logo_rumahsakit', array('class' => 'control-label', 'onkeypress' => "return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
                    <div class="controls">
                        <?php echo Chtml::activeFileField($model, 'logo_rumahsakit', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Logo')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nama_rumahsakit', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'npwp', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 25)); ?>
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'kodejenisrs_profilrs', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'kodejenisrs_profilrs', LookupM::getKodeItems('jenisrumahsakit'), array('empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <?php // echo $form->textFieldRow($model,'kodejenisrs_profilrs',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>1)); 
                ?>
                <?php echo $form->textFieldRow($model, 'kelas_rumahsakit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textAreaRow($model, 'alamatlokasi_rumahsakit', array('rows' => 6, 'cols' => 50, 'class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'propinsi_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetKabupaten', array('encode' => false, 'namaModel' => 'SAProfilRumahSakitM')),
                                'update' => '#SAProfilRumahSakitM_kabupaten_id',
                            ),
                            'onchange' => "clearKecamatan();clearKelurahan();",
                        ));
                        ?>

                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-danger', 'onclick' => "{addPropinsi(); $('#dialogAddPropinsi').dialog('open');}",
                            'id' => 'btnAddPropinsi', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('propinsi_id')
                        ))
                        ?>
                        <?php echo $form->error($model, 'propinsi_id'); ?>
                    </div>
                </div>
            </td>
            <td width='33%'>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kabupaten_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetKecamatan', array('encode' => false, 'namaModel' => 'SAProfilRumahSakitM')),
                                'update' => '#SAProfilRumahSakitM_kecamatan_id'
                            ),
                            'onchange' => "clearKelurahan();",
                        ));
                        ?>

                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-danger', 'onclick' => "{addKabupaten(); $('#dialogAddKabupaten').dialog('open');}",
                            'id' => 'btnAddKabupaten', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('kabupaten_id')
                        ))
                        ?>
                        <?php echo $form->error($model, 'kabupaten_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kecamatan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array(
                            'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => Yii::app()->createUrl('ActionDynamic/GetKelurahan', array('encode' => false, 'namaModel' => 'SAProfilRumahSakitM')),
                                'update' => '#SAProfilRumahSakitM_kelurahan_id'
                            )
                        ));
                        ?>

                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-danger', 'onclick' => "{addKecamatan(); $('#dialogAddKecamatan').dialog('open');}",
                            'id' => 'btnAddKecamatan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('kecamatan_id')
                        ))
                        ?>
                        <?php echo $form->error($model, 'kecamatan_id'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kelurahan_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'kelurahan_id', CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --',
                        ));
                        ?>
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                            'class' => 'btn btn-danger', 'onclick' => "{addKelurahan(); $('#dialogAddKelurahan').dialog('open');}",
                            'id' => 'btnAddKelurahan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('kelurahan_id')
                        ))
                        ?>
                        <?php echo $form->error($model, 'kelurahan_id'); ?>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'warga_negara', LookupM::getItems('warganegara'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'website', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'no_faksimili', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15)); ?>
                <div class='control-group'>
                    <?php echo CHtml::label('Pentahapan Akreditasi', 'Pentahapan Akreditasi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('SAProfilRumahSakitM[pentahapanakreditasrs]', '', LookupM::getItems('pentahapanakreditasirs'), array('empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'pentahapanakreditasrs',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                ?>
                <div class="control-group">
                    <?php echo CHtml::label('Tahun', 'Tahun', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('SAProfilRumahSakitM[tahunprofilrs]', date('Y'), CustomFunction::getTahun(null, null), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'jenisrs_profilrs', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'jenisrs_profilrs', LookupM::getItems('jenisrumahsakit'), array('empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'jenisrs_profilrs',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>1)); 
                ?>
                <?php echo $form->textFieldRow($model, 'tahun_diresmikan', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
            </td>
            <td width='34%'>
                <?php echo $form->textFieldRow($model, 'nokode_rumahsakit', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 10)); ?>
                <div class='control-group'>
                    <?php echo CHtml::label('Status Rumah Sakit', 'Status Rumah Sakit', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('SAProfilRumahSakitM[statusrsswasta]', '', LookupM::getItems('statusrsswasta'), array('empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'statusrsswasta',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                ?>
                <?php echo $form->textAreaRow($model, 'motto', array('rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'email', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'no_telp_profilrs', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 15)); ?>
                <?php echo CHtml::label('Status Akreditasi', 'Status Akreditasi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::dropDownList('SAProfilRumahSakitM[statusakreditasrs]', '', LookupM::getItems('statusakreditasrs'), array('empty' => '-- Pilih --')); ?>
                </div>
                <?php //echo $form->textFieldRow($model,'statusakreditasrs',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                ?>
            </td>
        </tr>
    </table>
</fieldset>
<fieldset class='box'>
    <legend class="rim">Visi dan Misi</legend>
    <table width='100%'>
        <tr>
            <td>
                <?php echo $form->textAreaRow($model, 'visi', array('rows' => 6, 'cols' => 50, 'class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </td>
            <td>
                <table id="tbl-misi" class="table table-striped table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <?php echo $form->textFieldRow($modMisiRS, '[1]misi', array('class' => 'span3', 'style' => 'width:50% !important;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </td>
                            <td>
                                <?php echo CHtml::button('+', array('class' => 'btn btn-danger', 'onkeypress' => "addRow(this);return $(this).focusNextInputField(event);", 'onclick' => 'addRow(this);$(this).nextFocus()', 'id' => 'row1-plus')); ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</fieldset>
<fieldset class='box'>
    <legend class="rim">Kepemilikan</legend>
    <table width='100%'>
        <tr>
            <td width='33%'>
                <div class='control-group'>
                    <?php echo CHtml::label('Nama Kepemilikan', 'Nama Kepemilikan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('SAProfilRumahSakitM[namakepemilikanrs]', '', LookupM::getItems('namakepemilikanrs'), array('empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'namakepemilikanrs',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); 
                ?>
                <?php echo $form->textFieldRow($model, 'statuskepemilikanrs', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20)); ?>
                <?php echo $form->textFieldRow($model, 'namadirektur_rumahsakit', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'nomor_suratizin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20)); ?>
            </td>
            <td width='33%'>
                <?php echo $form->textFieldRow($model, 'oleh_suratizin', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 30)); ?>
                <?php echo $form->textFieldRow($model, 'kodestatuskepemilikanrs', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textFieldRow($model, 'khususuntukswasta', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 1)); ?>
            </td>
            <td width='34%'>
                <div class='control-group'>
                    <?php echo CHtml::label('Sifat Surat Izin', 'Sifat Surat Izin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('SAProfilRumahSakitM[sifat_suratizin]', '', LookupM::getItems('sifatsuratizin'), array('empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'sifat_suratizin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); 
                ?>
                <?php echo $form->labelEx($model, 'tgl_suratizin', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_suratizin',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                </div>
                <?php echo $form->textFieldRow($model, 'masaberlakutahun_suratizin', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 4)); ?>
            </td>
        </tr>
    </table>
</fieldset>
<?php $this->renderPartial('_profilpict', array('model' => $modProfilPict, 'form' => $form)); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/profilRumahSakitM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Profile Rumah Sakit', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('profilRumahSakitM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
// Dialog untuk menambah data provinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddPropinsi',
    'options' => array(
        'title' => 'Menambah data Provinsi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 450,
        'height' => 350,
        'resizable' => false,
    ),
));

echo '<div class="divForForm"></div>';

$this->endWidget();
//========= end propinsi dialog =============================        

// Dialog buat nambah data kabupaten =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKabupaten',
    'options' => array(
        'title' => 'Menambah data Kabupaten',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKabupaten"></div>';

$this->endWidget();
//========= end kabupaten dialog =============================

// Dialog buat nambah data kecamatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKecamatan',
    'options' => array(
        'title' => 'Menambah data Kecamatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKecamatan"></div>';

$this->endWidget();
//========= end kecamatan dialog =============================

// Dialog buat nambah data kelurahan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddKelurahan',
    'options' => array(
        'title' => 'Menambah data Kelurahan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormKelurahan"></div>';

$this->endWidget();
//========= end kelurahan dialog =============================
?>

<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class' => 'btn btn-default', 'onclick' => 'delRow(this); return false;'));
$confimMessage = Yii::t('mds', 'Do You want to remove?');
$js = <<< JSCRIPT

function clearKecamatan()
{
    $('#SAProfilRumahSakitM_kecamatan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function clearKelurahan()
{
    $('#SAProfilRumahSakitM_kelurahan_id').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}
function addRow(obj)
{
    var tableId = $(obj).parents('table').attr('id');
    var objName = $(obj).attr('name');
    var tr = $('#'+tableId+' tbody tr:first').html();
    $('#'+tableId+' tbody tr:last').after('<tr>'+tr+'</tr>');
    $('#'+tableId+' tbody tr:last td:last').append('$buttonMinus');

    if (tableId == 'tbl-misi'){
        renameInput(tableId, 'SAMisirsM','misi');
    }else if (tableId == 'tbl_profilpicture'){
        renameInput(tableId, 'SAProfilpictureM','profilpicture_nama');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_desc');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_path');
        renameInput(tableId, 'SAProfilpictureM','display_antrian');
    }
}

function renameInput(table, modelName,attributeName)
{
    var trLength = $('#'+table+' tbody tr').length;
    var i = 1;
    $('#'+table+' tbody tr').each(function(){
        $(this).find('textarea[name$="['+attributeName+']"],input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea[name$="['+attributeName+']"],input[name$="['+attributeName+']"]').attr('id',modelName+'['+i+']['+attributeName+']');
        $(this).find('textarea').html('');
        $(this).find('checkbox').attr('checked','');
        i++;
    });
}

function delRow(obj)
{
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        renameInput('SAMisirsM','misi');
    }
}

JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input', $js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
    function addPropinsi() {
        <?php echo CHtml::ajax(array(
            'url' => Yii::app()->createUrl('ActionAjax/addPropinsi'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddPropinsi div.divForForm').html(data.div);
                    $('#dialogAddPropinsi div.divForForm form').submit(addPropinsi);
                }
                else
                {
                    $('#dialogAddPropinsi div.divForForm').html(data.div);
                    $('#PPPasienM_propinsi_id').html(data.propinsi);
                    setTimeout(\"$('#dialogAddPropinsi').dialog('close') \",1000);
                }
 
            } ",
        )) ?>;
        return false;
    }

    function addKabupaten() {
        <?php echo CHtml::ajax(array(
            'url' => $this->createUrl('addKabupaten'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
                    $('#dialogAddKabupaten div.divForFormKabupaten form').submit(addKabupaten);
                }
                else
                {
                    $('#dialogAddKabupaten div.divForFormKabupaten').html(data.div);
                    $('#PPPasienM_kabupaten_id').html(data.kabupaten);
                    setTimeout(\"$('#dialogAddKabupaten').dialog('close') \",1000);
                }
 
            } ",
        )) ?>;
        return false;
    }

    function addKecamatan() {
        <?php echo CHtml::ajax(array(
            'url' => $this->createUrl('addKecamatan'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
                    $('#dialogAddKecamatan div.divForFormKecamatan form').submit(addKecamatan);
                }
                else
                {
                    $('#dialogAddKecamatan div.divForFormKecamatan').html(data.div);
                    $('#PPPasienM_kecamatan_id').html(data.kecamatan);
                    setTimeout(\"$('#dialogAddKecamatan').dialog('close') \",1000);
                }
 
            } ",
        )) ?>;
        return false;
    }

    function addKelurahan() {
        <?php echo CHtml::ajax(array(
            'url' => $this->createUrl('addKelurahan'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
            {
                if (data.status == 'create_form')
                {
                    $('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
                    $('#dialogAddKelurahan div.divForFormKelurahan form').submit(addKelurahan);
                }
                else
                {
                    $('#dialogAddKelurahan div.divForFormKelurahan').html(data.div);
                    $('#PPPasienM_kelurahan_id').html(data.kelurahan);
                    setTimeout(\"$('#dialogAddKelurahan').dialog('close') \",1000);
                }
 
            } ",
        )) ?>;
        return false;
    }
</script>