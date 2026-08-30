
    <div class="col-sm-6">
        <div class="control-group ">
        <?php echo CHtml::label('Periode Akuntansi','', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('rekperiod_id','',array('readonly'=>true)); ?>
                <?php
                    $this->widget('MyJuiAutoComplete', array(
//					'model'=>$modRekPeriod,
                        'name'=>'deskripsi',
                        'attribute' => 'deskripsi',
                        'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteRekeningPeriode') . '",
                                dataType: "json",
                                data: {
                                    deskripsi: request.term,
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
                                $("#rekperiod_id").val(ui.item.rekperiod_id);
                                $("#perideawal").val(ui.item.perideawal); 
                                $("#sampaidgn").val(ui.item.sampaidgn); 
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'class'=>'deskripsi',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#rekperiod_id").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogRekeningPeriode'),
                    ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Periode Awal','', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('perideawal','',array('readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Sampai dengan','', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('sampaidgn','',array('readonly'=>true)); ?>
            </div>
        </div>
    </div>
<div class="clear"></div>
<div class="form-action">
    <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
        'class'=>'btn btn-green',
        'type'=>'button',
        'onclick'=>'cekPeriodeLama();',
    )); ?>
</div>
<?php 
//========= Dialog buat cari data Rekening Periode =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekeningPeriode',
    'options'=>array(
        'title'=>'Pencarian Rekening Periode',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'zIndex'=>1002,
        'resizable'=>false,
    ),
));

$modRekening = new AKRekperiodM('search');
$modRekening->unsetAttributes();
if(isset($_GET['AKRekperiodM'])) {
    $modRekening->attributes = $_GET['AKRekperiodM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekeningperiode-grid',
	'dataProvider'=>$modRekening->searchDialog(),
//	'filter'=>$modRekening,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
							"href"=>"",
							"id" => "selectRekening",
							"onClick" => "
										  $(\"#rekperiod_id\").val(\"$data->rekperiod_id\");
										  $(\"#deskripsi\").val(\"$data->deskripsi\");
										  $(\"#perideawal\").val(\"".MyFormatter::formatDateTimeForUser($data->perideawal)."\");
										  $(\"#sampaidgn\").val(\"".MyFormatter::formatDateTimeForUser($data->sampaidgn)."\");
										  $(\"#dialogRekeningPeriode\").dialog(\"close\"); 
										  return false;
								"))',
		),
		array(
			'header'=>'Periode Awal',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->perideawal)',
		),
		array(
			'header'=>'Sampai Dengan',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->sampaidgn)',
		),
		array(
			'header'=>'Deskripsi',
			'type'=>'raw',
			'value'=>'$data->deskripsi',
		),
        array(
            'header'=>'Status',
            'type'=>'raw',
            'value'=>function($data) {
                if (!$data->isclosing) return "Belum Closing";
                return "Closing";
            }
        ),
	),
		'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
$this->endWidget();
//========= end Sumber Anggaran dialog =============================
?>
