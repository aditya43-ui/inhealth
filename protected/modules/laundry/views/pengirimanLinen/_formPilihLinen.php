<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Kode Penyimpanan', 'kodeinventaris', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('penyimpananlinen_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'kodelinen',
                    'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('AutocompleteLinenView') . '",
									   dataType: "json",
									   data: {
										   kodelinen: request.term,
										   ruangan_id: $("#LAPengirimanlinenT_ruangantujuan_id").val(),
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
								$(this).val("");
								return false;
							}',
                        'select' => 'js:function( event, ui ) {
								$(this).val(ui.item.value);
								$("#penyimpananlinen_id").val(ui.item.penyimpananlinen_id);
								$("#linen_id").val(ui.item.linen_id);
								$("#kodelinen").val(ui.item.nopenyimpananlinen);
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Kode Penyimpanan',
                        'onkeypress' => 'if(this.value === "") $("#linen_id").val("");',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPenyimpananLinen'),
                    //					'tombolDialog'=>array("idDialog"=>'dialogPenyimpananLinen','jsFunction'=>"setDialog(this);"),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Keterangan', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('keterangan', '', array('placeholder' => 'Keterangan', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                    'onclick' => 'tambahLinen();return false;',
                    'class' => 'btn btn-primary',
                    'onkeyup' => "tambahLinen();",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan resep",
                ));
                ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPenyimpananLinen',
    'options' => array(
        'title' => 'Penyimpanan Linen',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 400,
        'resizable' => false,
    ),
));
$modLinen = new LAPenyimpananlinenV('searchDialog');
$modLinen->unsetAttributes();
if (isset($_GET['LAPenyimpananlinenV'])) {
    $modLinen->attributes = $_GET['LAPenyimpananlinenV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogPenyimpananLinen-m-grid',
    'dataProvider' => $modLinen->searchDialog(),
    'filter' => $modLinen,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>"," ",array("class"=>"btn-small", 
						"id" => "selectObat",
						"onClick" => "
							$(\'#penyimpananlinen_id\').val($data->penyimpananlinen_id);
							$(\'#kodelinen\').val(\'$data->nopenyimpananlinen\');
							$(\'#keterangan\').val(\'$data->keterangan_penyimpanan\');
							$(\'#linen_id\').val($data->linen_id);
							$(\'#dialogPenyimpananLinen\').dialog(\'close\');
//							tambahLinen();
							return false;"
					))',
        ),
        'nopenyimpananlinen',
        'tglpenyimpananlinen',
        array(
            'header' => 'Ruangan',
            'filter' => false,
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
        ),
        array(
            'header' => 'Keterangan',
            'filter' => false,
            'type' => 'raw',
            'value' => '$data->keterangan_penyimpanan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//    'id'=>'dialogLinen',
//    'options'=>array(
//        'title'=>'Linen',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>980,
//        'height'=>400,
//        'resizable'=>false,
//    ),
//));
//$modLinen = new LALinenM('searchDialog');
//$modLinen->unsetAttributes();
//if(isset($_GET['LALinenM'])){
//    $modLinen->attributes = $_GET['LALinenM'];
//}
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'obatalkes-m-grid',
//	'dataProvider'=>$modLinen->searchDialog(),
//	'filter'=>$modLinen,
//	'template'=>"{items}\n{pager}",
//	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//		array(
//			'header'=>'Pilih',
//			'type'=>'raw',
//			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
//						"id" => "selectObat",
//						"onClick" => "
//							$(\'#linen_id\').val($data->linen_id);
//							$(\'#namalinen\').val(\'$data->namalinen\');
//							$(\'#kodelinen\').val(\'$data->kodelinen\');
//							$(\'#dialogLinen\').dialog(\'close\');
////							tambahLinen();
//							return false;"
//					))',
//		),
//		'linen_id',
//		'kodelinen',
//		'namalinen',
//	),
//	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//)); 
//
//$this->endWidget();
?>