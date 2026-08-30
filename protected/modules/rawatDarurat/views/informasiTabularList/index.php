<?php
$this->breadcrumbs = array(
    'Informasi Diagnosa ICD X'
);
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Diagnosa ICD X</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa ICD X</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="row">
                    <div class="col-sm-6">
                        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'tabular-grid',
                            'dataProvider' => $modTabularList->searchRJ(),
                            'filter' => $modTabularList,
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                array(
                                    'name' => 'tabularlist_chapter',
                                    'type' => 'raw',
                                    'value' => 'CHtml::link($data->tabularlist_chapter, "javascript:cariDtd(this,\'$data->tabularlist_id\');",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Klik untuk Melihat DTD"))',
                                    'htmlOptions' => array('style' => 'text-align: left; width:120px'),
                                    'filter' => CHtml::activeTextField($modTabularList, 'tabularlist_chapter', array('class' => 'all-caps angkahuruf-only'))
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                                .  '$(".all-caps").keyup(function() {
                                            var allcaps = $(this).val().toUpperCase();
                                            $(this).val(allcaps);
                                        });
                                        $(".angkahuruf-only").keyup(function() {
                                            setAngkaHurufsOnly(this);
                                        });'
                                . '}',
                        )); ?>
                    </div>
                    <div class="col-sm-6">
                        <div id="dtd-div" style="display: block;">
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
                                        'htmlOptions' => array('style' => 'text-align: left; width:120px'),
                                    ),
                                    array(
                                        'name' => 'dtd_kode',
                                        'filter' => Chtml::activeTextField($modDTDM, 'dtd_kode', array('class' => 'kode-dtd all-caps')) . CHtml::activeHiddenField($modDTDM, 'tabularlist_id', array('id' => 'dtd_tabularlist_id'))
                                    ),
                                    array(
                                        'name' => 'dtd_nama',
                                        'filter' => Chtml::activeTextField($modDTDM, 'dtd_nama', array('class' => 'custom-only'))
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                                    .  '$(".kode-dtd").keyup(function(){'
                                    . 'setKodeDTD(this);'
                                    . '});'
                                    . '$(".custom-only").keyup(function(){'
                                    . 'setCustomOnly(this);'
                                    . '});'
                                    . '$(".all-caps").keyup(function() {
                                            var allcaps = $(this).val().toUpperCase();
                                            $(this).val(allcaps);
                                        });'
                                    . '}',
                            )); ?>
                        </div>
                        <div id="diagnosa-div" style="display: none;">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'diagnosa-grid',
                                'dataProvider' => $modDiagnosa->searchRJ(),
                                'filter' => $modDiagnosa,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                                'columns' => array(
                                    // 'diagnosa_kode',	
                                    array(
                                        'name' => 'diagnosa_kode',
                                        'filter' => Chtml::activeTextField($modDiagnosa, 'diagnosa_kode', array('class' => 'kode-icd all-caps')) . CHtml::activeHiddenField($modDiagnosa, 'dtd_id', array('id' => 'diagnosa_dtd'))
                                    ),
                                    array(
                                        'name' => 'diagnosa_nama',
                                        'filter' => Chtml::activeTextField($modDiagnosa, 'diagnosa_nama', array('class' => 'custom-only'))
                                    ),
                                    // 'diagnosa_nama',
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                                    . '$(".kode-icd").keyup(function() {
                                        setKodeICD(this);
                                    });
                                        $(".custom-only").keyup(function() {
                                            setCustomOnly(this);
                                        });
                                        $(".all-caps").keyup(function() {
                                            var allcaps = $(this).val().toUpperCase();
                                            $(this).val(allcaps);
                                        });
                                    }',
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<legend class="rim">Pencarian</legend>-->
<div class="search-form">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'diagnosa-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        'focus' => '#',
    )); ?>
</div>
<?php $this->endWidget(); ?>
<?php
$js = <<< JSCRIPT
function cariDtd(obj,tabularlist_id)
{
    $(obj).parent().find("div").html("rizky");
    $('#diagnosa-div').attr("style","display:none");
     $('#dtd-div').attr("style","display:block");
    $.fn.yiiGridView.update('dtd-grid', {
            data: { RDDtdM_tabularlist_id : tabularlist_id}
    });
}
function cariDiagnosa(dtd_id)
{
     $('#diagnosa-div').attr("style","display:block");
	$("#diagnosa_dtd").val(dtd_id); 
//     $('#dtd-div').attr("style","display:none");
     $.fn.yiiGridView.update('diagnosa-grid', {
//            data: { RDDiagnosaM_dtd_id : dtd_id}
	data: $("#diagnosa-grid :input").serialize()
    });
}
JSCRIPT;
Yii::app()->clientScript->registerScript('search', $js, CClientScript::POS_HEAD);
$js = <<< JSCRIPT
$('.search-form form').submit(function(){
        $('#diagnosa-div').attr("style","display:block");
     $('#dtd-div').attr("style","display:none");
	$.fn.yiiGridView.update('diagnosa-grid', {
		data: $(this).serialize()
	});
	return false;
});
JSCRIPT;
Yii::app()->clientScript->registerScript('search-form', $js, CClientScript::POS_READY);
?>