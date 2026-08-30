<div class='control-group' style="display: none;">
    <?php // echo CHtml::label('Rekening Debit','rekening debit',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
//            $this->widget('MyJuiAutoComplete',
//                array(
//                    'name' => 'rekDebit',
//                    'id' => 'rekDebit',
//                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
//                    'options' => array(
//                        'showAnim' => 'fold',
//                        'minLength' => 2,
//                        'focus' => 'js:function( event, ui ){
//                            return false;
//                        }',
//                        'select' => 'js:function( event, ui ){
//                            $(this).val(ui.item.value);
////RND-8713
////                            var data = {
////                                rekening5_id:ui.item.rekening5_id,
////                                rekening4_id:ui.item.rekening4_id,
////                                rekening3_id:ui.item.rekening3_id,
////                                rekening2_id:ui.item.rekening2_id,
////                                rekening1_id:ui.item.rekening1_id,
////                                status:"debit"
////                            };
////                            getDataRekeningFromGrid(data);
//							getDataRekeningFromGrid(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id, "debit");
//                            return false;
//                        }'
//                    ),
//                    'htmlOptions' => array(
//                        'onkeypress' => "return $(this).focusNextInputField(event)",
//                        'placeholder'=>'Nama Rekening',
//                        'class'=>'span3',
//                        'style'=>'width:150px;',
//                    ),
//                    'tombolDialog' => array(
//                        'idDialog' => 'dialogRekDebit'
//                    ),
//                )
//            );
        ?>
    </div>
</div>
<div class='control-group' style="display: none;">
    <?php // echo CHtml::label('Rekening Kredit','rekening kredit',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
//            $this->widget('MyJuiAutoComplete',
//                array(
//                    'name' => 'rekKredit',
//                    'id' => 'rekKredit',
//                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
//                    'options' => array(
//                        'showAnim' => 'fold',
//                        'minLength' => 2,
//                        'focus' => 'js:function( event, ui ){
//                            return false;
//                        }',
//                        'select' => 'js:function( event, ui ){
//                            $(this).val(ui.item.value);
////RND-8713
////                            var data = {
////                                rekening5_id:ui.item.rekening5_id,
////                                rekening4_id:ui.item.rekening4_id,
////                                rekening3_id:ui.item.rekening3_id,
////                                rekening2_id:ui.item.rekening2_id,
////                                rekening1_id:ui.item.rekening1_id,
////                                status:"kredit"
////                            };
////                            getDataRekeningFromGrid(data);
//							getDataRekeningFromGrid(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id, "kredit");
//                            return false;
//                        }'
//                    ),
//                    'htmlOptions' => array(
//                        'onkeypress' => "return $(this).focusNextInputField(event)",
//                        'placeholder'=>'Nama Rekening',
//                        'class'=>'span3',
//                        'style'=>'width:150px;',
//                    ),
//                    'tombolDialog' => array(
//                        'idDialog' => 'dialogRekKredit'
//                    ),
//                )
//            );
        ?>
    </div>
</div>
<table id="tblInputRekening" class="table table-bordered table-condensed" widht="450">
    <thead>
        <tr>
            <th width="100">Kode Rekening</th>
            <th>Nama Rekening</th>
            <th width="100">Debit</th>
            <th width="100">Kredit</th>
            <th width="50">Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php $this->renderPartial('_rowUraian',array('form'=>$form, 'modUraian'=>$modUraian)); ?>
    </tbody>
</table>

<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekKredit = new KURekeningakuntansiV('searchDialogAccount');
$modRekKredit->unsetAttributes();

//$account = "K";
$account = "";
if(isset($_GET['KURekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchDialogAccount(),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
					"id" => "selectRekDebit",
					"onClick" =>"
//					RND-8713
//						var data = {
//							rekening5_id:$data->rekening5_id,
//							rekening4_id:$data->rekening4_id,
//							rekening3_id:$data->rekening3_id,
//							rekening2_id:$data->rekening2_id,
//							rekening1_id:$data->rekening1_id,
//							status:\"kredit\"
//						};
//						getDataRekeningFromGrid(data);
						getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekeninglast_id\', \"kredit\");
						$(\"#dialogRekKredit\").dialog(\"close\");
						return false;
			"))',
		),
    array(
        'header' => 'Kode Akun',
        'name' => 'kdrekeninglast',
        'value' => '$data->kdrekeninglast',
    ),
    array(
        'header' => 'Level 1',
        'name' => 'nmrekening1',
        'value' => '$data->nmrekening1',
    ),
    array(
        'header' => 'Level 2',
        'name' => 'nmrekening2',
        'value' => '$data->nmrekening2',
    ),
    array(
        'header' => 'Level 3',
        'name' => 'nmrekening3',
        'value' => '$data->nmrekening3',
    ),
    array(
        'header' => 'Level 4',
        'name' => 'nmrekening4',
        'value' => '$data->nmrekening4',
    ),
    array(
        'header' => 'Level 5',
        'name' => 'nmrekening5',
        'value' => '$data->nmrekening5',
    ),
    array(
        'header' => 'Level 6',
        'name' => 'kdrekening6',
        'value' => '$data->nmrekening6',
    ),
    array(
        'header' => 'Level 7',
        'name' => 'nmrekening7',
        'value' => '$data->nmrekening7',
    ),
    array(
        'header' => 'Level 8',
        'name' => 'nmrekening8',
        'value' => '$data->nmrekening8',
    ),
    array(
        'header' => 'Level 9',
        'name' => 'nmrekening9',
        'value' => '$data->nmrekening9',
    ),
    array(
        'header' => 'Level 10',
        'name' => 'nmrekening10',
        'value' => '$data->nmrekening10',
    ),
    array(
        'header' => 'Saldo Normal',
        'name' => 'rekeninglast_nb',
        'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
        'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
    ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>

<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));

$modRekKredit = new KURekeningakuntansiV('searchDialogAccount');
$modRekKredit->unsetAttributes();

//$account = "K";
$account = "";
if(isset($_GET['KURekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdedit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchDialogAccount(),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
//                'start'=>1, //indeks kolom 3
//                'end'=>5, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
					"id" => "selectRekDebit",
					"onClick" =>"
//					RND-8713
//						var data = {
//							rekening5_id:$data->rekening5_id,
//							rekening4_id:$data->rekening4_id,
//							rekening3_id:$data->rekening3_id,
//							rekening2_id:$data->rekening2_id,
//							rekening1_id:$data->rekening1_id,
//							status:\"debit\"
//						};
//						getDataRekeningFromGrid(data);
						getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekeninglast_id\', \"debit\");
						$(\"#dialogRekDebit\").dialog(\"close\");
						return false;
			"))',
		),
    array(
        'header' => 'Kode Akun',
        'name' => 'kdrekeninglast',
        'value' => '$data->kdrekeninglast',
    ),
    array(
        'header' => 'Level 1',
        'name' => 'nmrekening1',
        'value' => '$data->nmrekening1',
    ),
    array(
        'header' => 'Level 2',
        'name' => 'nmrekening2',
        'value' => '$data->nmrekening2',
    ),
    array(
        'header' => 'Level 3',
        'name' => 'nmrekening3',
        'value' => '$data->nmrekening3',
    ),
    array(
        'header' => 'Level 4',
        'name' => 'nmrekening4',
        'value' => '$data->nmrekening4',
    ),
    array(
        'header' => 'Level 5',
        'name' => 'nmrekening5',
        'value' => '$data->nmrekening5',
    ),
    array(
        'header' => 'Level 6',
        'name' => 'kdrekening6',
        'value' => '$data->nmrekening6',
    ),
    array(
        'header' => 'Level 7',
        'name' => 'nmrekening7',
        'value' => '$data->nmrekening7',
    ),
    array(
        'header' => 'Level 8',
        'name' => 'nmrekening8',
        'value' => '$data->nmrekening8',
    ),
    array(
        'header' => 'Level 9',
        'name' => 'nmrekening9',
        'value' => '$data->nmrekening9',
    ),
    array(
        'header' => 'Level 10',
        'name' => 'nmrekening10',
        'value' => '$data->nmrekening10',
    ),
    array(
        'header' => 'Saldo Normal',
        'name' => 'rekeninglast_nb',
        'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
        'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
    ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
<script>
    function getDataRekeningFromGrid(rekening1_id,rekening2_id,rekening3_id,rekening4_id,rekening5_id,status)
    {
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('AmbilDataRekening'); ?>',
			data: {rekening1_id:rekening1_id,rekening2_id:rekening2_id,rekening3_id:rekening3_id,rekening4_id:rekening4_id,rekening5_id:rekening5_id,status:status},//
			dataType: "json",
			success:function(data){
				$("#tblInputRekening > tbody").append(data.replace());
                renameRowRekening();
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
    }
</script>
