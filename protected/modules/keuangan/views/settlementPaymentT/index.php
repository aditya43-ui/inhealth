<style type="text/css">
    .integer-decimal{
        text-align: right;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->breadcrumbs=array(
	'Advance Payment Dan Request Of Payment',
);?>
<?php
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
		'id'=>'advancepayment-t-form',
		'enableAjaxValidation'=>false,
		'type'=>'horizontal',
		'focus'=>'#',
		'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)',
						),
						// 'onsubmit'=>'return cekInputan();'
	));

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                    <div class="panel-title">Transaksi Settlement <strong><span id="jenis_transaksi">Advance Payment</span></strong></div>
            </div>            
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Data Advance Payment</div>
                    </div>
                    <div class="panel-body">
					<?php  ?>
					<?php

					
                        if(isset($_GET['sukses'])){
							// echo 'sfsfsfsdf';
                                Yii::app()->user->setFlash('success', "Transaksi berhasil disimpan !");
								$this->widget('bootstrap.widgets.BootAlert');
					   }?>
						<?php 
							$this->renderPartial('_dataAdvancePayment',array(
								'form'=>$form,
								'modAdvancePayment'=>$modAdvancePayment,
								'modTandaBuktiKeluar' => $modTandaBuktiKeluar
							 ));
						?>

						<?php //echo $form->errorSummary(array($modelBayar,$modBuktiKeluar)); ?>
                    </div>
                </div>			
				
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Uraian Settlement Advance Payment</div>
					</div>
					<div class="panel-body overflow-x" style="max-width: 100%;">
						<?php 
						if(isset($_GET['sukses']) && $_GET['sukses'] == 1){        
						?>
						<?php echo Yii::app()->user->setFlash('success',"Data berhasil disimpan !"); ?>
						<?php } ?>
						<?php
							$this->widget('bootstrap.widgets.BootAlert');
						?>

							<div class="block-tabel">
								<table class="items table table-bordered table-condensed" id="tblInputUraian">
									<thead>
										<tr>
											<th>Tgl. Transaksi</th>
											<th>Jenis Pengeluaran</th>
											<th>Deskripsi</th>
											<th>No. Referensi</th>
											<th>Volume</th>
											<th>Satuan</th>
											<th>Harga</th>
											<th>Total Harga</th>
											<th>Rekening Debit</th>
											<th colspan="2"></th>
										</tr>
									</thead>
									<tbody>
									<?php

$trTindakan = $this->renderPartial($this->path_view.'_rowUraianSettlement',array('modSettlementPaymentDetail'=>$modSettlementPaymentDetail,'modSettlementPaymentDetails'=>$modSettlementPaymentDetails),true); 
echo $trTindakan;
									?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="7">Total</td>
											<td><input type="text" class="integer-decimal span2" id="totalrow" readonly></td>
										</tr>
									</tfoot>
								</table>
							<?php //echo $form->errorSummary($modTindakan); ?>
						</div>
					</div>
				</div>

				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Lampiran Settlement Advance Payment</div>
					</div>
					<div class="panel-body overflow-x" style="max-width: 100%;">
						<?php 
						if(isset($_GET['sukses']) && $_GET['sukses'] == 1){        
						?>
						<?php echo Yii::app()->user->setFlash('success',"Data berhasil disimpan !"); ?>
						<?php } ?>
						<?php
							$this->widget('bootstrap.widgets.BootAlert');
						?>

							<div class="block-tabel">
								<table class="items table table-bordered table-condensed" id="tblInputTindakan">
									<thead>
										<tr>
											<th></th>
											<th>No.Referensi</th>
											<th>Keterangan</th>
											<th colspan="2"></th>
										</tr>
									</thead>
									<?php 
										$trLamp = $this->renderPartial($this->path_view.'_rowLampiranSettlement',array('modSettlementPaymentLamps'=>$modSettlementPaymentLamps,'modSettlementPaymentLamp'=>$modSettlementPaymentLamp),true); 
										echo $trLamp;
									?>
								</table>
							<?php //echo $form->errorSummary($modTindakan); ?>
						</div>
					</div>
				</div>			
				
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="panel-title">Data Settlement Advance Payment</div>
					</div>
					<div class="panel-body">
					<?php 
								$this->renderPartial('_dataSettlementAdvancePayment',array(
                                   'form'=>$form,
								   'model'=>$model,
								   'modAdvancePayment'=>$modAdvancePayment,
								   'modTandaBuktiBayar'=>$modTandaBuktiBayar,
								   'modBuktiKeluar'=>$modBuktiKeluar
                                ));
						?>	
					</div>
				</div>

				<div class="form-actions">
					<?php 
						$disabled = ((isset($_GET['settlementpayment_id'])) ? true : false);
						echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
								array('class'=>'btn btn-primary', 'type'=>'button', 'onclick' => 'simpanDataTransaksi();', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disabled)).'&nbsp;'; 
						echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/settlementPaymentT/index'), array('class' => 'btn btn-danger',
							'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id . '/settlementPaymentT/index').'";}); return false;')).'&nbsp;';
					?>
					 <?php
						if(isset($_GET['sukses']) && $_GET['sukses'] == 1){
							echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print('PRINT');return false",'disabled'=>FALSE  ));
						}else{							
							
						
							echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','disabled'=>TRUE  ));
						}
					 ?>
				</div>
				
            </div>
        </div>
    </div>
</div>
<?php echo $this->renderPartial('_jsFunctions',array(
	'modSettlementPaymentDetails' =>$modSettlementPaymentDetails,
	'modSettlementPaymentDetail'=> $modSettlementPaymentDetail ,
	'modSettlementPaymentLamp'=> $modSettlementPaymentLamp ,
	'modSettlementPaymentLamps'=> $modSettlementPaymentLamps ,
	'form' => $form
	)); ?>
	<?php $this->endWidget(); ?>
<script type="text/javascript">
 

</script>

<?php
//========= Dialog jenis pengeluaran =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogJenisPengeluaran',
	'options' => array(
		'title' => 'Daftar Jenis Pengeluaran',
		'autoOpen' => false,
		'modal' => true,
		'width' => 800,
		'height' => 700,
		'resizable' => false,
	),
));


$dialogPenjamin = new JenispengeluaranM('search');
$dialogPenjamin->unsetAttributes();

if (isset($_GET['JenispengeluaranM'])) {
	$dialogPenjamin->attributes = $_GET['JenispengeluaranM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'penjaminpasien-m-grid',	
	'dataProvider' => $dialogPenjamin->searchDialog(),
	'filter' => $dialogPenjamin,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
                array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectPenjaminPasien",
				"onClick" =>"setPengeluaranAuto($data->jenispengeluaran_id);
					$(\"#dialogJenisPengeluaran\").dialog(\"close\");    
					return false;
			"))',
		),
		array(
				'header' => 'Kode',
				'name' => 'jenispengeluaran_kode',
				'value' => '$data->jenispengeluaran_kode',				
		),			
		array(
			'header' => 'Nama',
			'name' => 'jenispengeluaran_nama',
			'value' => '$data->jenispengeluaran_nama'
		)
		
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end jenis pengeluaran =============================
?>




<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRekDebit',
	'options' => array(
		'title' => 'Daftar Rekening Debit',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 700,
		'resizable' => false,
	),
));
$modRekDebit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekDebit->unsetAttributes();
$modRekDebit->rekeninglast_nb = "D";
$account = "";
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekDebit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekDebit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekDebit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekDebit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);

}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchDialogAccount(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
					setRekeningAuto($data->rekeninglast_id);
					$(\"#dialogRekDebit\").dialog(\"close\"); 
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>

<script type="text/javascript">
	function namaLain(nama)
	{
		document.getElementById('AKJenispengeluaranM_jenispengeluaran_namalain').value = nama.value.toUpperCase();
	}
	
	function changeSize()
	{            
		window.parent.document.getElementById('frame').style= 'overflow-y:scroll;height:600px;';            
	}

	$('#tombolKreditRek, #tombolDebitRek, #tombolPenjaminPasien').click(function(){
		changeSize();
	});
</script>