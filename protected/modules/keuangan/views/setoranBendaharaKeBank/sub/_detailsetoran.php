<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Detail Setoran ke Bank</b>
        </div>
    </div>
    <div class="panel-body table-responsive">

        <table class="table table-bordered table-condensed table-striped" id="tab_setoran">
            <thead>
                <tr>
                    <th class="span4">Kode Akun</th>
                    <th>Uraian Rincian</th>
                    <th class="span2">Jumlah Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // foreach ($detail as $idx=>$item) {
                echo $this->renderPartial($this->path_view . 'sub/_tabdetail', array('detail' => $detail), true);
                // } 
                ?>
            </tbody>
            <tfoot>
                <?php echo $this->renderPartial($this->path_view . 'sub/_tabtotal', array('total' => $detailTotal), true); ?>
            </tfoot>
        </table>
    </div>
</div>

<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekening',
    'options' => array(
        'title' => 'Daftar Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
$account = "";
if (isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}


//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchAccounts($account),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    //        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
    //        'mergeHeaders'=>array(
    //            array(
    //                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
    //                'start'=>1, //indeks kolom 3
    //                'end'=>5, //indeks kolom 4
    //            ),
    //        ),
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(objdetid).val(\"$data->rekeninglast_id\");
					$(objdetnama).val(\"$data->nmrekeninglast\");                                            
					$(\"#dialogRekening\").dialog(\"close\");    
					return false;
			"))',
        ),
        'kdrekening1',
        'kdrekening2',
        'kdrekening3',
        'kdrekening4',
        'kdrekening5',
        'kdrekening6',
        'kdrekening7',
        'kdrekening8',
        'kdrekening9',
        'kdrekening10',
        array(
            'header' => 'Kode Akun',
            'name' => 'kdrekening5',
            'value' => '$data->kdrekening5',
        ),
        array(
            'header' => 'Nama Akun',
            'name' => 'nmrekening5',
            'value' => '$data->nmrekening5',
        ), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
        array(
            'header' => 'Saldo Normal',
            'name' => 'rekening5_nb',
            'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>