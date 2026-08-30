<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'ubahRujukan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    )
);
$this->widget('bootstrap.widgets.BootAlert'); 
echo $form->errorSummary(array($modRujukan));
?>

<div class="control-group">
    <?php echo $form->hiddenField($modRujukan, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>

    <?php echo $form->labelEx($modRujukan, 'asalrujukan_id', array('class' => 'control-label refreshable')) ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukan,
            'asalrujukan_id',
            CHtml::listData($modRujukan->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
            array(
                'class' => 'span3 form-control delapan', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('GetRujukanDari', array('encode' => false, 'namaModel' => 'PPRujukanT')),
                    'update' => '#' . CHtml::activeId($modRujukan, 'rujukandari_id'),
                ),
                'onchange' => "clearRujukan();",
            )
        ); ?>
        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                        array('class'=>'btn btn-primary','onclick'=>"{addAsalRujukan(); $('#dialogAddAsalRujukan').dialog('open');}",
                                              'id'=>'btnAddAsalRujukan','onkeyup'=>"return $(this).focusNextInputField(event)",
                                              'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modRujukan->getAttributeLabel('asalrujukan_id'))) */ ?>
        <?php echo $form->error($modRujukan, 'asalrujukan_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukan, 'no_rujukan', array('placeholder' => 'Nomor Rujukan', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'rujukandari_id', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList(
            $modRujukan,
            'rujukandari_id',
            CHtml::listData($modRujukan->getRujukanDariItems($modRujukan->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
            array('class' => 'span3 form-control enam', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujuk();')
        ); ?>
        <?php 
        // echo CHtml::htmlButton(
        //     '<i class="entypo-plus-circled"></i>',
        //     array(
        //         'class' => 'btn btn-primary', 'onclick' => "{addRujukanDari(); $('#dialogAddRujukanDari').dialog('open');}",
        //         'id' => 'btnAddRujukanDari', 'onkeyup' => "return $(this).focusNextInputField(event)",
        //         'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $modRujukan->getAttributeLabel('nama_perujuk')
        //     )
        // ) 
        ?>
        <?php echo $form->error($modRujukan, 'rujukandari_id'); ?>
    </div>
</div>
<?php echo $form->textFieldRow($modRujukan, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3 form-control', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'tanggal_rujukan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $modRujukan,
            'attribute' => 'tanggal_rujukan',
            'mode' => 'date',
            'options' => array(
                //                                    'dateFormat'=>Params::DATE_FORMAT,
                'showOn' => false,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array('placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'position:relative; z-index:999'),
        )); ?>
        <?php echo $form->error($modRujukan, 'tanggal_rujukan'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'kddiagnosa_rujukan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $modRujukan,
            'attribute' => 'kddiagnosa_rujukan',
            'data' => explode(',', $modRujukan->kddiagnosa_rujukan),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                'addontab' => true,
                'maxitems' => 20,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
                'autoFocus' => true,
            ),
            'htmlOptions' => array('id' => 'diagnosaRujukanKode', 'class' => '',),
        ));
        ?>
        <?php echo $form->error($modRujukan, 'kddiagnosa_rujukan'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($modRujukan, 'diagnosa_rujukan', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
            'model' => $modRujukan,
            'attribute' => 'diagnosa_rujukan',
            'data' => explode(',', $modRujukan->diagnosa_rujukan),
            'debugMode' => true,
            'options' => array(
                //'bricket'=>false,
                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                'addontab' => true,
                'maxitems' => 20,
                'input_min_size' => 0,
                'cache' => true,
                'newel' => true,
                'addoncomma' => true,
                'select_all_text' => "",
                'autoFocus' => true,
            ),
            'htmlOptions' => array('id' => 'diagnosaRujukan', 'class' => '',),
        ));
        ?>
        <?php echo $form->error($modRujukan, 'diagnosa_rujukan'); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary pull-right', 'style' => 'margin: -37px 2px 0 0;', 'rel' => 'tooltip', 'title' => 'klik untuk mencari diagnosa rujukan', 'onclick' => '$(\'#dialogDiagnosa\').dialog(\'open\')')); ?>
    </div>
</div>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onClick' => 'closeDialog()', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddAsalRujukan',
    'options' => array(
        'title' => 'Menambah data Asal Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 300,
        'resizable' => false,
    ),
));

echo '<div class="divForFormAsalRujukan"></div>';
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogAddRujukanDari',
    'options' => array(
        'title' => 'Menambah data Nama Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 450,
        'height' => 440,
        'resizable' => false,
    ),
));

echo '<div class="divForFormRujukanDari"></div>';
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosa',
    'options' => array(
        'title' => 'Pencarian Diagnosa Rujukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 380,
        'resizable' => false,
    ),
));
$modDiagnosa = new PPDiagnosaM('search');
$modDiagnosa->unsetAttributes();
if (isset($_GET['PPDiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'diagnosa-m-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "
                                        if($(\"#content-bpjs\").hasClass(\"in\")){
                                            setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                        }else{
                                            setDataDiagnosa(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                        }
                                        $(\"#dialogDiagnosa\").dialog(\"close\");
                                    "))',
        ),
        'diagnosa_kode',
        //'diagnosa_nama',
        array(
            'header' => 'Nama',
            'name' => 'diagnosa_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();

?>
<script>
    function setDataDiagnosa(kode_diagnosa, nama_diagnosa) {

var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
var randomId = '';
for (var i = 0; i < 32; i++) {
	var rnum = Math.floor(Math.random() * chars.length);
	randomId += chars.substring(rnum, rnum + 1);
}

var op = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + nama_diagnosa + '">' + nama_diagnosa + '</option>';
var list = '<li id="pt_' + randomId + '" class="bit-box" rel="' + nama_diagnosa + '">' + nama_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var opKode = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + kode_diagnosa + '">' + kode_diagnosa + '</option>';
var listKode = '<li id="pt_' + randomId + '" class="bit-box" rel="' + kode_diagnosa + '">' + kode_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var objSelect = $('select#diagnosaRujukan').parent().find('select');
var objList = $('select#diagnosaRujukan').parent().find('ul li.bit-input');
var objSelectKode = $('select#diagnosaRujukanKode').parent().find('select');
var objListKode = $('select#diagnosaRujukanKode').parent().find('ul li.bit-input');

objSelect.append(op);
objList.before(list);
objSelectKode.append(opKode);
objListKode.before(listKode);

}

function setDiagnosaBpjs(kode_diagnosa, nama_diagnosa) {

var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
var randomId = '';
for (var i = 0; i < 32; i++) {
	var rnum = Math.floor(Math.random() * chars.length);
	randomId += chars.substring(rnum, rnum + 1);
}

var op = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + nama_diagnosa + '">' + nama_diagnosa + '</option>';
var list = '<li id="pt_' + randomId + '" class="bit-box" rel="' + nama_diagnosa + '">' + nama_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var opKode = '<option id="opt_' + randomId + '" class="selected" selected="selected" value="' + kode_diagnosa + '">' + kode_diagnosa + '</option>';
var listKode = '<li id="pt_' + randomId + '" class="bit-box" rel="' + kode_diagnosa + '">' + kode_diagnosa + '<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
var objSelect = $('select#diagnosaRujukanBpjs').parent().find('select');
var objList = $('select#diagnosaRujukanBpjs').parent().find('ul li.bit-input');
var objSelectKode = $('select#diagnosaRujukanKodeBpjs').parent().find('select');
var objListKode = $('select#diagnosaRujukanKodeBpjs').parent().find('ul li.bit-input');

objSelect.append(op);
objList.before(list);
objSelectKode.append(opKode);
objListKode.before(listKode);

}


</script>