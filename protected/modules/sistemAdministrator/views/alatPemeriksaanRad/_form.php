<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapemeriksaanmapalatrad-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php if (isset($modDetails)) {
    echo $form->errorSummary($modDetails);
} else {
    echo $form->errorSummary($model);
} ?>

<div class="control-group">
    <?php echo CHtml::label('Alat Pemeriksaan Radiologi', 'pemeriksaanalatrad_id', array('class' => 'span3')); ?>
    <div class="col-sm-4">
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pemeriksaanalatrad_id'); ?>
            <?php
            $pemeriksaanalatrad_nama = (isset($model->pemeriksaanalatrad->pemeriksaanalatrad_nama) ? $model->pemeriksaanalatrad->pemeriksaanalatrad_nama : "");
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'pemeriksaanalatrad_nama',
                'value' => $pemeriksaanalatrad_nama,
                'source' => 'js: function(request, response) {
$.ajax({
url: "' . $this->createUrl('AutocompletePemeriksaanAlatRad') . '",
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
$(this).val(ui.item.pemeriksaanalatrad_nama);
$("#pemeriksaanalatrad_id").val(ui.item.pemeriksaanalatrad_id);
return false;
}',
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => "Nama Alat Pemeriksaan Rad.",
                    'class' => "span3",

                ),
                'tombolDialog' => array('idDialog' => 'dialogPemeriksaanAlatRad'),
            ));
            ?>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Pilih <b>Detail Pemeriksaan Radiologi</b>
        </div>
    </div>
    <div class="panel-body">

        <?php echo CHtml::hiddenField('pemeriksaanrad_id', '', array('readonly' => true)); ?>
        <div>
            <?php
            $modPemeriksaanRad = new SAPemeriksaanRadM('search');
            $modPemeriksaanRad->unsetAttributes();  // clear any default values
            if (isset($_GET['SAPemeriksaanRadM'])) {
                $modPemeriksaanRad->attributes = $_GET['SAPemeriksaanRadM'];
            }
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'pemeriksaanrad-m-grid',
                'dataProvider' => $modPemeriksaanRad->searchPilih(),
                'filter' => $modPemeriksaanRad,
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'Pilih',
                        'type' => 'raw',
                        'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
array(
"class"=>"btn-small",
"id" => "selectPemeriksaanRad",
"onClick" => "\$(\"#pemeriksaanrad_id\").val($data->pemeriksaanrad_id);
\$(\"#pemeriksaanrad_nama\").val(\"$data->pemeriksaanrad_nama\");
submitpemeriksaanrad();"
))',
                    ),
                    array(
                        'header' => 'No.',
                        'value' => '($this->grid->dataProvider->pagination) ? 
($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
: ($row+1)',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'header' => 'Nama Pemeriksaan',
                        'name' => 'pemeriksaanrad_id',
                        'type' => 'raw',
                        'value' => '$data->pemeriksaanrad_nama',
                        'filter' => CHtml::listData(PemeriksaanradM::model()->findAll(array('order' => 'pemeriksaanrad_id'), 'pemeriksaanrad_aktif = true'), 'pemeriksaanrad_id', 'pemeriksaanrad_nama'),
                    ),
                    array(
                        'header' => 'Jenis Pemeriksaan',
                        'name' => 'pemeriksaanrad_id',
                        'type' => 'raw',
                        'value' => '$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',
                        'filter' => false,
                    ),
                    'pemeriksaanrad_namalainnya',
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            )); ?>

        </div>
    </div>

</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Detail Pemeriksaan</b></b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tabelPemeriksaanmapalatrad" class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Nama Pemeriksaan Alat Radiologi</th>
                    <th>Nama Pemeriksaan Radiologi</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$modDetails) > 0) {
                    foreach ($modDetails as $i => $row) {
                        $modpemeriksaanalatrad = PemeriksaanalatradM::model()->findByPK($row->pemeriksaanalatrad_id);
                        $modpemeriksaanrad = PemeriksaanradM::model()->findByPK($row->pemeriksaanrad_id);

                        $tr = "<tr>";
                        $tr .= "<td>"
                            . CHtml::hiddenField('pemeriksaanalatrad_id[]', $row->pemeriksaanalatrad_id, array('readonly' => true))
                            . $modpemeriksaanalatrad->pemeriksaanalatrad_nama . "</td>";
                        $tr .= "<td>"
                            . CHtml::hiddenField('pemeriksaanrad_id[]', $row->pemeriksaanrad_id, array('readonly' => true))
                            . $modpemeriksaanrad->pemeriksaanrad_nama . "</td>";
                        $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'hapusBaris(this);')) . "</td>";
                        $tr .= "</tr>";
                        echo $tr;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php //echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : 
    //      Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
    // array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
    ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Detail Pemeriksaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaanAlatRad',
    'options' => array(
        'title' => 'Pilih Pemeriksaan Radiologi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));
$modPemeriksaanRad = new SAPemeriksaanalatradM('search');
$modPemeriksaanRad->unsetAttributes();  // clear any default values
if (isset($_GET['SAPemeriksaanalatradM'])) {
    $modPemeriksaanRad->attributes = $_GET['SAPemeriksaanalatradM'];
    $modPemeriksaanRad->pemeriksaanalatrad_id = !empty($_GET['SAPemeriksaanalatradM']['pemeriksaanalatrad_id']) ? $_GET['SAPemeriksaanalatradM']['pemeriksaanalatrad_id'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapemeriksaanalatrad-m-grid',
    'dataProvider' => $modPemeriksaanRad->searchDialog(),
    'filter' => $modPemeriksaanRad,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::link("<i class=\'icon-check\'></i>","javascript:void(0);",
array("onclick"=>"
$(\"#pemeriksaanalatrad_nama\").val(\"$data->pemeriksaanalatrad_nama\");
$(\"#' . CHtml::activeId($model, 'pemeriksaanalatrad_id') . '\").val(\"$data->pemeriksaanalatrad_id\");
$(\"#dialogPemeriksaanAlatRad\").dialog(\"close\");
", 
"class"=>"btn-small", "title"=>"Klik untuk <br>memilih pemeriksaan", "rel"=>"tooltip"));',
        ),
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
: ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'name' => 'pemeriksaanalatrad_id',
            'value' => '$data->pemeriksaanalatrad_nama',
            'filter' => CHtml::listData(PemeriksaanalatradM::model()->findAll(array('order' => 'pemeriksaanalatrad_id'), 'pemeriksaanalatrad_aktif = true'), 'pemeriksaanalatrad_id', 'pemeriksaanalatrad_nama'),
        ),
        array(
            'name' => 'alatmedis_id',
            'value' => '$data->alatmedis->alatmedis_nama',
            'filter' => false,
        ),
        'pemeriksaanalatrad_namalain',
        'pemeriksaanalatrad_aetitle',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":\'' . Params::TOOLTIP_PLACEMENT . '\'});}',
));
$this->endWidget();

?>

<?php
$urlGetPemeriksaanmapalatrad = $this->createUrl('Pemeriksaanmapalatrad');
?>

<?php
$jscript = <<< JS
function submitpemeriksaanrad()
{
pemeriksaanalatrad_id = $('#PemeriksaanmapalatradM_pemeriksaanalatrad_id').val();
pemeriksaanrad_id = $('#pemeriksaanrad_id').val();
if(pemeriksaanrad_id==''){
myAlert('Silakan Pilih pemeriksaan Terlebih dahulu');
}else{
$.post("${urlGetPemeriksaanmapalatrad}", {pemeriksaanalatrad_id:pemeriksaanalatrad_id, pemeriksaanrad_id:pemeriksaanrad_id},
function(data){
$('#tabelPemeriksaanmapalatrad').append(data.tr);
}, "json");
}   
}
JS;

Yii::app()->clientScript->registerScript('pemeriksaanmapalatrad', $jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parents('tr').detach();
    }
</script>