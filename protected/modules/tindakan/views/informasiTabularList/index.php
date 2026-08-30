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
                        <div>
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'tabular-grid',
                                'dataProvider' => $modTabularList->searchRJ(),
                                'filter' => $modTabularList,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-striped table-condensed',
                                'columns' => array(
                                    array(
                                        'name' => 'tabularlist_chapter',
                                        'type' => 'raw',
                                        'value' => 'CHtml::link($data->tabularlist_chapter, "javascript:cariDtd(this,\'$data->tabularlist_id\');",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Klik untuk Melihat DTD"))',
                                        'htmlOptions' => array('style' => 'text-align: left; width:120px'),
                                        'filter' => CHtml::activeTextField($modTabularList, 'tabularlist_chapter', array('class' => 'all-caps angkahuruf-only'))
                                    ),
                                    //array(
                                    //	'name' => 'tabularlist_title2',
                                    //	'filter' => CHtml::activeTextField($modTabularList, 'tabularlist_title2', array('class' => 'hurufs-only'))
                                    //),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                                    .  '$(".all-caps").keyup(function() {
											var allcaps = $(this).val().toUpperCase();
											$(this).val(allcaps);
										});
										$(".angkahuruf-only").keyup(function() {
											setAngkaHurufsOnly(this);
										});
										$(".hurufs-only").keyup(function() {
											setHurufsOnly(this);
										});'
                                    . '}',
                            )); ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $this->renderPartial('_table', array('modDTDM' => $modDTDM)); ?>
                        <div id="diagnosa-div" style="display: none;">
                            <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                                'id' => 'diagnosa-grid',
                                'dataProvider' => $modDiagnosa->searchRJ(),
                                'filter' => $modDiagnosa,
                                'template' => "{summary}\n{items}\n{pager}",
                                'itemsCssClass' => 'table table-striped table-condensed',
                                'columns' => array(
                                    array(
                                        'name' => 'diagnosa_kode',
                                        'filter' => CHtml::activeTextField($modDiagnosa, 'diagnosa_kode', array('class' => '')) . CHtml::activeHiddenField($modDiagnosa, 'dtd_id', array('id' => 'diagnosa_dtd')),
                                    ),
                                    array(
                                        'name' => 'diagnosa_nama',
                                        'filter' => Chtml::activeTextField($modDiagnosa, 'diagnosa_nama', array('class' => 'custom-only'))
                                    ),
                                ),
                                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});diagnosahideshow();'
                                    . '$(".kode-icd").keyup(function() {
										setKodeICD(this);
									});
									$(".custom-only").keyup(function() {
										setCustomOnly(this);
									});
									$(".all-caps").keyup(function() {
										var allcaps = $(this).val().toUpperCase();
										$(this).val(allcaps);
									});}',
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$js = <<< JSCRIPT
function cariDtd(obj,tabularlist_id)
{
    $("#dtd_tabularlist_id").val(tabularlist_id);
    $('#diagnosa-div').attr("style","display:none");
    $('#dtd-div').attr("style","display:block");
    $.fn.yiiGridView.update('dtd-grid', {
            data: $("#dtd-grid :input").serialize()
    });
}
function cariDiagnosa(dtd_id)
{
    $("#diagnosa_dtd").val(dtd_id);    
    $.fn.yiiGridView.update('diagnosa-grid', {
            data: $("#diagnosa-grid :input").serialize()
    });
}
function diagnosahideshow()
{
     $('#diagnosa-div').attr("style","display:block");
   //  $('#dtd-div').attr("style","display:none");
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