<legend class="rim2">Data Tabular List</legend><?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<table>
    <tr>
        <td width="30%">
            <div style="height: 100%;"> 
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'tabular-grid',
            'dataProvider'=>$modTabularList->searchRJ(),
            'filter'=>$modTabularList,    
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
               array(
               'name'=>'tabularlist_chapter',
               'type'=>'raw',
               'value'=>'CHtml::link($data->tabularlist_chapter, "javascript:cariDtd(this,\'$data->tabularlist_id\');",array("id"=>"$data->tabularlist_id","rel"=>"tooltip","title"=>"Klik untuk Melihat DTD"))',
               'htmlOptions'=>array('style'=>'text-align: left; width:120px'),
                ),
                    	
             ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
             </div>   
        </td>
        <td>
            <div id="dtd-div" style="display: block;">
                 <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'dtd-grid',
                'dataProvider'=>$modDTDM->searchRJ(),
                'filter'=>$modDTDM, 
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(	
                        array(
                           'name'=>'dtd_kode',
                           'type'=>'raw',
                           'value'=>'CHtml::link($data->dtd_kode, "javascript:cariDiagnosa(\'$data->dtd_id\');",array("id"=>"$data->dtd_id","rel"=>"tooltip","title"=>"Klik untuk Melihat Diagnosa"))',
                           'htmlOptions'=>array('style'=>'text-align: left; width:120px')
                        ),
                        'dtd_kode',	
                        'dtd_nama',
                 ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>
            </div>
            
            <div id="diagnosa-div" style="display: none;">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'diagnosa-grid',
                'dataProvider'=>$modDiagnosa->searchRJ(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(	
                        'diagnosa_kode',	
                        'diagnosa_nama',
                 ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>
            </div>
        </td>
    </tr>
</table>
<legend class="rim">Pencarian</legend>
<div class="search-form">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'diagnosa-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#',
    )); ?>

    <table>
        <tr>
            <td>
                 <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_kode',array('class'=>'span3','maxlength'=>10)); ?>
                 <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_nama',array('class'=>'span3','maxlength'=>50)); ?>
                 <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
            </td>
            <td>
                 <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_katakunci',array('class'=>'span3','maxlength'=>50)); ?>
                 <?php echo $form->textFieldRow($modDiagnosa,'diagnosa_nourut',array('class'=>'span3')); ?>
                 <?php echo $form->checkBoxRow($modDiagnosa,'diagnosa_imunisasi'); ?>
            </td>
        </tr>
    </table>
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                    array('class' => 'btn btn-danger', 'type'=>'submit','id'=>'btn_simpan'));
         ?>
			<?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.informasiTabularis.'/index'), 
                        array('class' => 'btn btn-default',
                              'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
							  <?php 
$content = $this->renderPartial('../tips/informasi',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>
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
            data: { RKDtdM_tabularlist_id : tabularlist_id}
    });

}
   
function cariDiagnosa(dtd_id)
{
     $('#diagnosa-div').attr("style","display:block");
     $('#dtd-div').attr("style","display:none");
     $.fn.yiiGridView.update('diagnosa-grid', {
            data: { RKDDiagnosaM_dtd_id : dtd_id}
    });
}

JSCRIPT;
Yii::app()->clientScript->registerScript('search',$js,CClientScript::POS_HEAD);                        

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
Yii::app()->clientScript->registerScript('search-form',$js,CClientScript::POS_READY);                        

?>

