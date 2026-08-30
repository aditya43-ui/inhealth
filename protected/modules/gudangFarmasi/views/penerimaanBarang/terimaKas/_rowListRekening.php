<div class='control-group'>
    <?php echo CHtml::label('Rekening Debit','rekening debit',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'name' => 'rekDebit',
                    'id' => 'rekDebit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ){
                            return false;
                        }',
                        'select' => 'js:function( event, ui ){
                            $(this).val(ui.item.value);
//							RND-8713
//                            var data = {
//                                rekening5_id:ui.item.rekening5_id,
//                                rekening4_id:ui.item.rekening4_id,
//                                rekening3_id:ui.item.rekening3_id,
//                                rekening2_id:ui.item.rekening2_id,
//                                rekening1_id:ui.item.rekening1_id,
//                                status:"debit"
//                            };
//                            getDataRekeningFromGrid(data);
							getDataRekeningFromGrid(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id, "debit");
                            return false;
                        }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder'=>'Ketikan Nama Rekening',
                        'class'=>'span3',
                        'style'=>'width:150px;',
                    ),
                    'tombolDialog' => array(
                        'idDialog' => 'dialogRekDebit'
                    ),
                )
            );
        ?>
    </div>
</div>
<div class='control-group'>
    <?php echo CHtml::label('Rekening Kredit','rekening kredit',array('class'=>'control-label')) ?>
    <div class="controls">
        <?php
            $this->widget('MyJuiAutoComplete',
                array(
                    'name' => 'rekKredit',
                    'id' => 'rekKredit',
                    'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek'=>'Kredit')),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ){
                            return false;
                        }',
                        'select' => 'js:function( event, ui ){
                            $(this).val(ui.item.value);
//							RND-8713
//                            var data = {
//                                rekening5_id:ui.item.rekening5_id,
//                                rekening4_id:ui.item.rekening4_id,
//                                rekening3_id:ui.item.rekening3_id,
//                                rekening2_id:ui.item.rekening2_id,
//                                rekening1_id:ui.item.rekening1_id,
//                                status:"kredit"
//                            };
//                            getDataRekeningFromGrid(data);   
							getDataRekeningFromGrid(ui.item.rekening1_id,ui.item.rekening2_id,ui.item.rekening3_id,ui.item.rekening4_id,ui.item.rekening5_id, "kredit");
                            return false;
                        }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder'=>'Ketikan Nama Rekening',
                        'class'=>'span3',
                        'style'=>'width:150px;',
                    ),
                    'tombolDialog' => array(
                        'idDialog' => 'dialogRekKredit'
                    ),
                )
            );
        ?>
    </div>
</div>
<table id="tblInputRekening" class="table table-bordered table-striped table-condensed" widht="450">
    <thead>
        <tr>
            <th width="100">Kode Akun</th>
            <th>Nama Akun</th>
            <th width="100">Debit</th>
            <th width="100">Kredit</th>
            <th width="50">Batal</th>
        </tr>
    </thead>
    <tbody>
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
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));

$modRekKredit = new KURekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
$modRekKredit->rekening5_aktif = true;
//$account = "K";
$account = "";
if(isset($_GET['KURekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
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

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekkredit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekKredit->searchAccounts($account),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
        // 'mergeHeaders'=>array(
        //     array(
        //         'name'=>'<center>Kode Rekening</center>',
        //         'start'=>1, //indeks kolom 3
        //         'end'=>5, //indeks kolom 4
        //     ),
        // ),
	'columns'=>array(
		 array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectRekDebit",
				"onClick" =>"
//				RND-8713
//					var data = {
//						rekening5_id:$data->rekening5_id,
//						rekening4_id:$data->rekening4_id,
//						rekening3_id:$data->rekening3_id,
//						rekening2_id:$data->rekening2_id,
//						rekening1_id:$data->rekening1_id,
//						status:\"kredit\"
//					};
//					getDataRekeningFromGrid(data);
					getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"kredit\");
					$(\"#dialogRekKredit\").dialog(\"close\");    
					return false;
			"))',
		 ),
		 array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
                array(
                        'header'=>'Kelompok Akun',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                            $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                            return $rek2->namakelrekening;
                        },
                        'filter'=>CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
                       KelrekeningM::model()->findAll(array(
                           'condition'=>'kelrekening_aktif = true',
                           'order'=>'koderekeningkel',
                       )), 'kelrekening_id', 'namakelrekening'
                        ), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Komponen',
                        'name'=>'rekening1_id',
                        'value'=>'$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening1_id', 
                        CHtml::listData(Rekening1M::model()->findAll(array(
                            'condition'=>'rekening1_aktif = true',
                            'order'=>'kdrekening1 asc',
                        )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Unsur',
                        'name'=>'rekening2_id',
                        'value'=>'$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Kelompok Pos',
                        'name'=>'rekening3_id',
                        'value'=>'$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Pos',
                        'name'=>'rekening4_id',
                        'value'=>'$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening4_id', 
                        CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Akun',
                        'name' => 'nmrekening5',
                        'value' => '$data->nmrekening5',
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
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
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
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));

$modRekKredit = new KURekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
$modRekKredit->rekening5_aktif = true;
//$account = "D";
$account = "";
if(isset($_GET['KURekeningakuntansiV'])) {
    $modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
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

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rekdedit-m-grid',
	'dataProvider'=>$modRekKredit->searchAccounts($account),
	'filter'=>$modRekKredit,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
							"id" => "selectRekDebit",
							"onClick" =>"
//							RND-8713
//								var data = {
//									rekening5_id:$data->rekening5_id,
//									rekening4_id:$data->rekening4_id,
//									rekening3_id:$data->rekening3_id,
//									rekening2_id:$data->rekening2_id,
//									rekening1_id:$data->rekening1_id,
//									status:\"debit\"
//								};
//								getDataRekeningFromGrid(data);
								getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"debit\");
								$(\"#dialogRekDebit\").dialog(\"close\");    
								return false;
					"))',
		),
		
		 array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
                array(
                        'header'=>'Kelompok Akun',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                            $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                            return $rek2->namakelrekening;
                        },
                        'filter'=>CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
                       KelrekeningM::model()->findAll(array(
                           'condition'=>'kelrekening_aktif = true',
                           'order'=>'koderekeningkel',
                       )), 'kelrekening_id', 'namakelrekening'
                        ), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Komponen',
                        'name'=>'rekening1_id',
                        'value'=>'$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening1_id', 
                        CHtml::listData(Rekening1M::model()->findAll(array(
                            'condition'=>'rekening1_aktif = true',
                            'order'=>'kdrekening1 asc',
                        )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Unsur',
                        'name'=>'rekening2_id',
                        'value'=>'$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Kelompok Pos',
                        'name'=>'rekening3_id',
                        'value'=>'$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Pos',
                        'name'=>'rekening4_id',
                        'value'=>'$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening4_id', 
                        CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Akun',
                        'name' => 'nmrekening5',
                        'value' => '$data->nmrekening5',
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
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
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