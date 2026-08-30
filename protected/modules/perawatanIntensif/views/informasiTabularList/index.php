<?php
$this->breadcrumbs = array(
    'Informasi Diagnosa ICD X'
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Data <b>Tabular List</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian</b>
                </div>
            </div>
            <div class="panel-body">
                <!--fieldset class="box"-->
                <div class="search-form">
                    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                        'id' => 'search',
                        'enableAjaxValidation' => false,
                        'type' => 'horizontal',
                        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                        'focus' => '#' . CHtml::activeId($modDTDM, 'dtd_kode'),
                    )); ?>
                    <?php echo $form->hiddenField($modDiagnosa, 'diagnosa_id', array('class' => 'span3', 'maxlength' => 50)); ?>
                    <?php echo $form->hiddenField($modDTDM, 'tabularlist_id', array('class' => 'span3', 'maxlength' => 50)); ?>
                    <div id='search-diagnosa' style="display: none;">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($modDiagnosa, 'diagnosa_kode', array('placeholder' => 'Kode', 'class' => 'span3 kode-icd', 'maxlength' => 10)); ?>
                                <?php echo $form->textFieldRow($modDiagnosa, 'diagnosa_nama', array('placeholder' => 'Nama', 'class' => 'span3  custom-only', 'maxlength' => 50)); ?>
                                <?php echo $form->textFieldRow($modDiagnosa, 'diagnosa_namalainnya', array('placeholder' => 'Nama Lain', 'class' => 'span3  custom-only', 'maxlength' => 50)); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($modDiagnosa, 'diagnosa_katakunci', array('placeholder' => 'Kata Kunci', 'class' => 'span3  custom-only', 'maxlength' => 50)); ?>
                                <?php echo $form->textFieldRow($modDiagnosa, 'diagnosa_nourut', array('class' => 'span3 numbers-only')); ?>
                                <?php echo $form->checkBoxRow($modDiagnosa, 'diagnosa_imunisasi'); ?>
                            </div>
                        </div>
                    </div>
                    <div id='search-dtd' style="display: block;">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($modDTDM, 'dtd_kode', array('placeholder' => 'Kode', 'class' => 'span3 kode-dtd', 'maxlength' => 10)); ?>
                                <?php echo $form->textFieldRow($modDTDM, 'dtd_nama', array('placeholder' => 'Nama', 'class' => 'span3 custom-only', 'maxlength' => 50)); ?>
                                <?php echo $form->textFieldRow($modDTDM, 'dtd_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3  custom-only', 'maxlength' => 50)); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php echo $form->textFieldRow($modDTDM, 'dtd_katakunci', array('placeholder' => 'Kata Kunci', 'class' => 'span3 custom-only', 'maxlength' => 50)); ?>
                                <?php echo $form->textFieldRow($modDTDM, 'dtd_nourut', array('placeholder' => 'No. Urut', 'class' => 'span3 numbers-only')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                    );
                    ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''), array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    ));
                    ?>
                    <?php
                    $content = $this->renderPartial('gudangFarmasi.views.tips.informasiStokObatAlkesRJ', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa X</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="row">
                    <div class="col-sm-6">
                        <div style="height: 100%;">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'tabular-grid',
                                'dataProvider' => $modTabularList->searchRJ(),
                                'filter' => $modTabularList,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                                'columns' => array(
                                    array(
                                        'name' => 'tabularlist_chapter',
                                        'type' => 'raw',
                                        'value' => 'CHtml::link($data->tabularlist_chapter, "javascript:cariDtd(this,\'$data->tabularlist_id\');",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Klik untuk Melihat DTD"))',
                                        'htmlOptions' => array('style' => 'text-align: left; width:120px'),
                                        'filter' => CHtml::activeTextField($modTabularList, 'tabularlist_chapter', array('class' => 'angkahuruf-only'))
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                                    . '$(".angkahuruf-only").keyup(function(){'
                                    . 'setAngkaHurufsOnly(this);'
                                    . '});'
                                    . '}',
                            )); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="block-tabel" id="dtd-div">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'dtd-grid',
                                'dataProvider' => $modDTDM->searchRJ(),
                                'filter' => $modDTDM,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                                'columns' => array(
                                    array(
                                        'header' => 'Kode',
                                        'type' => 'raw',
                                        'value' => 'CHtml::link($data->dtd_kode, "javascript:cariDiagnosa(\'$data->dtd_id\');",array("id"=>"$data->dtd_id","rel"=>"tooltip","title"=>"Klik untuk Melihat Diagnosa"))',
                                        'htmlOptions' => array('style' => 'text-align: left; width:120px')
                                    ),
                                    array(
                                        'header' => 'Kode',
                                        'name' => 'dtd_kode',
                                        'value' => '$data->dtd_kode',
                                        'filter' => Chtml::activeTextField($modDTDM, 'dtd_kode', array('class' => 'kode-dtd'))
                                    ),
                                    array(
                                        'header' => 'Nama',
                                        'name' => 'dtd_nama',
                                        'value' => '$data->dtd_nama',
                                        'filter' => Chtml::activeTextField($modDTDM, 'dtd_nama', array('class' => 'custom-only'))
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                                    . '$(".kode-dtd").keyup(function(){'
                                    . 'setKodeDTD(this);'
                                    . '});'
                                    . '$(".custom-only").keyup(function(){'
                                    . 'setCustomOnly(this);'
                                    . '});'
                                    . '}',
                            )); ?>
                        </div>
                        <div id="diagnosa-div" style="display: none;">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'diagnosa-grid',
                                'dataProvider' => $modDiagnosa->searchRJ(),
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                                'columns' => array(
                                    'diagnosa_kode',
                                    'diagnosa_nama',
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
$tabularlist_id = CHtml::activeId($modDTDM, 'tabularlist_id');
$dtd_id = CHtml::activeId($modDiagnosa, 'dtd_id');
$js = <<< JSCRIPT
function cariDtd(obj,tabularlist_id)
{
    $(obj).parent().find("div").html("rizky");
    $('#diagnosa-div').attr("style","display:none");
    $('#dtd-div').attr("style","display:block");
    $('#search-dtd').show();
    $('#search-diagnosa').hide();
    $("#${tabularlist_id}").val(tabularlist_id);    
//    $.fn.yiiGridView.update('dtd-grid', {
//            data: $(this).serialize()
//    });
    $.fn.yiiGridView.update('dtd-grid', {
            data: { RJDtdM_tabularlist_id : tabularlist_id}
    });
}
function cariDiagnosa(dtd_id)
{
    $('#diagnosa-div').attr("style","display:block");
    $('#dtd-div').attr("style","display:none");
    $('#search-dtd').hide();
    $('#search-diagnosa').show();
    $("#${dtd_id}").val(dtd_id);
//    $.fn.yiiGridView.update('diagnosa-grid', {
//            data: $(this).serialize()
//    });
     $.fn.yiiGridView.update('diagnosa-grid', {
            data: { RJDiagnosaM_dtd_id : dtd_id}
    });
}
JSCRIPT;
Yii::app()->clientScript->registerScript('search', $js, CClientScript::POS_HEAD);
$js = <<< JSCRIPT
$('#search').submit(function(){
	$.fn.yiiGridView.update('diagnosa-grid', {
		data: $(this).serialize()
	});
	$.fn.yiiGridView.update('dtd-grid', {
		data: $(this).serialize()
	});
	return false;
});
JSCRIPT;
Yii::app()->clientScript->registerScript('search-form', $js, CClientScript::POS_READY);
?>