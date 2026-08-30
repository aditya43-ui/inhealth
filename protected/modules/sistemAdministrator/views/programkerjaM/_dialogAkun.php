<?php 
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekDebit',
    'options'=>array(
        'title'=>'Daftar Rekening Debit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));

$modRekDebit = new RekeningakuntansiV('search');
$modRekDebit->unsetAttributes();
$modRekDebit->rekening5_aktif = true;
// $modRekDebit->rekening5_nb = "D";
$account = "";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();

$c2->compare('rekening1_id', $modRekDebit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekDebit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekDebit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->searchAccounts($account),
	'filter'=>$modRekDebit,
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
					$(\"#SASubkegiatanprogramM_rekeningdebit_id\").val(\"$data->rekening5_id\");
					$(\"#SASubkegiatanprogramM_rekeningdebit_nama\").val(\"$data->nmrekening5\");                                                
					$(\"#dialogRekDebit\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
                        'header' => 'Kelompok Akun',
                        'name' => 'rekening1_id',
                        'value' => '$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening1_id', 
                                CHtml::listData(Rekening1M::model()->findAll(array(
                                    'condition'=>'rekening1_aktif = true',
                                    'order'=>'kdrekening1 asc',
                                )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Golongan Akun',
                        'name' => 'rekening2_id',
                        'value' => '$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Sub Golongan Akun',
                        'name' => 'rekening3_id',
                        'value' => '$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Jenis Akun',
                        'name' => 'rekening4_id',
                        'value' => '$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening4_id', 
                                CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
		array(
			'header'=>'Nama Akun',
			'name'=>'nmrekening5',
			'value'=>'$data->nmrekening5',
		), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
		array(
			'header'=>'Saldo Normal',
			'name'=>'rekening5_nb',
			'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit') ,array('empty'=>"-- Pilih --")),
		),
		
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
        
<?php 
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRekKredit',
    'options'=>array(
        'title'=>'Daftar Rekening Kredit',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));

$modRekKredit = new RekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
$modRekKredit->rekening5_aktif = true;
// $modRekKredit->rekening5_nb = "K";
//$account = "K";

$account = "";
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['RekeningakuntansiV'];
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();

$c2->compare('rekening1_id', $modRekKredit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekKredit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekKredit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts($account),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//        'mergeHeaders'=>array(
//            array(
//                'name'=>'<p style="margin: 0; text-align: center;">Kode Rekening</p>',
//                'start'=>1, //indeks kolom 3
//                'end'=>4, //indeks kolom 4
//            ),
//        ),
	'columns'=>array(
                array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
					$(\"#SASubkegiatanprogramM_rekeningkredit_id\").val(\"$data->rekening5_id\");
					$(\"#SASubkegiatanprogramM_rekeningkredit_nama\").val(\"$data->nmrekening5\");
					$(\"#dialogRekKredit\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
			'header'=>'No. Urut',
			'name'=>'nourutrek',
			'value'=>'$data->nourutrek',
		),
		array(
                        'header' => 'Kelompok Akun',
                        'name' => 'rekening1_id',
                        'value' => '$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening1_id', 
                                CHtml::listData(Rekening1M::model()->findAll(array(
                                    'condition'=>'rekening1_aktif = true',
                                    'order'=>'kdrekening1 asc',
                                )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Golongan Akun',
                        'name' => 'rekening2_id',
                        'value' => '$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Sub Golongan Akun',
                        'name' => 'rekening3_id',
                        'value' => '$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Jenis Akun',
                        'name' => 'rekening4_id',
                        'value' => '$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening4_id', 
                                CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
		array(
			'header'=>'Nama Akun',
			'name'=>'nmrekening5',
			'value'=>'$data->nmrekening5',
		), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
		array(
			'header'=>'Saldo Normal',
			'name'=>'rekening5_nb',
			'value'=>'($data->rekening5_nb == "K") ? "Kredit" : "Debit"',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
		),
		
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>