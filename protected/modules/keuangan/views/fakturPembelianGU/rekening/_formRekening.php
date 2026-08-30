<?php
/**
 * form ini digunakan di:
 * - akuntansi/fakturPembelianGU
 */
?>
<legend class="rim">Jurnal Rekening Faktur</legend>
<div id="formJurnalRekeningKasir" class="grid-view">
<table id="tblInputRekening" class="table table-bordered table-condensed"  width="100%">
    <thead>
        <tr>
            <!--<th width="10">No.</th>-->
            <th colspan="5" width="50">Kode Rekening</th>
            <th>Nama Rekening</th>
            <th width="50">Debit</th>
            <th width="50">Kredit</th>
            <th width="10">Tindakan</th>
        </tr>
    </thead>
    <tbody>
    <?php
//        $modRekenings[0]=new RekeningpembayarankasirV(); //<<untuk menampilkan baris pertama blank
        $this->renderPartial('akuntansi.views.fakturPembelianGU.rekening._rowRekening',array('form'=>$form, 'modRekenings'=>$modRekenings)); ?>
    </tbody>
</table>
</div>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebitKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit dan Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'height'=>400,
        'resizable'=>false,
    ),
));
echo CHtml::hiddenField('row',0,array('readonly'=>true)); //untuk mencatat asal baris di klik
$modRekKredit = new RekeningakuntansiV('searchDialogAccount');
$modRekKredit->unsetAttributes();
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
//    $modRekKredit->rincianobyek_nb = $_GET['RekeningakuntansiV']['rincianobyek_nb'];
}
//$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkreditdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchDialogAccount(),
	'filter'=>$modRekKredit,
	'template'=>"{pager}{summary}\n{items}",
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
				"id" => "selectRekDebitKredit",
				"onClick" =>"
					var data = {
						rincianobyek_id:$data->rekeninglast_id,
						obyek_id:$data->rekening4_id,
						jenis_id:$data->rekening3_id,
						kelompok_id:$data->rekening2_id,
						struktur_id:$data->rekening1_id,
						nmrincianobyek:\"$data->nmrekeninglast\",
						kdstruktur:\"$data->kdrekening4\",
						kdkelompok:\"$data->kdrekening3\",
						kdjenis:\"$data->kdrekening2\",
						kdobyek:\"$data->kdrekening1\",
						kdrincianobyek:\"$data->kdrekeninglast\",
						saldodebit:\"$data->saldodebit\",
						saldokredit:\"$data->saldokredit\",
						status:\"debit\"
					};
					var row = $(\"#dialogRekDebitKredit #row\").val();
					editDataRekeningFromGrid(data, row);
					$(\"#dialogRekDebitKredit\").dialog(\"close\");
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
<?php $this->renderPartial('akuntansi.views.fakturPembelianGU.rekening._jsFunctions',array('form'=>$form, 'modRekenings'=>$modRekenings)); ?>
