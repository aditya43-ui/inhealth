<?php  ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'id' => 'jenispengeluaran-m-form',
	'enableAjaxValidation' => false,
	'type' => 'horizontal',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onSubmit' => 'verifikasi();'),
	'focus' => '#',
		));
?>
<div class='divForForm'>
</div>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table>
	<tr>
		<td>
			<div class='control-group'>
				<?php echo CHtml::label('Penjamin', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($modBank, 'penjamin_id', array()); ?>
				</div>
			</div>
			<div class='control-group'>
				<?php echo CHtml::label('Rekening Debit', '', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('debit', $model->rekeningkredit->nmrekening5, array()); ?>
					<?php echo CHtml::hiddenField('rekening5_id', $model->rekening5_id, array()); ?>
					<?php // echo CHtml::hiddenField('rekening4_id',$model->rekening4_id,array()); ?>
					<?php // echo CHtml::hiddenField('rekening3_id',$model->rekening3_id,array()); ?>
					<?php // echo CHtml::hiddenField('rekening2_id',$model->rekening2_id,array()); ?>
					<?php // echo CHtml::hiddenField('rekening1_id',$model->rekening1_id,array()); ?>
					<?php echo CHtml::hiddenField('penjamin_id', $model->penjamin_id, array()); ?>
					<?php echo CHtml::hiddenField('penjaminrek_id', $model->penjaminrek_id, array()); ?>
					<?php // echo CHtml::hiddenField('saldonormal',$model->saldonormal,array());  ?>
				</div>
			</div>
		</td>
	</tr>
</table>
<?php $this->endWidget(); ?>

</div>
<legend class="rim">Checklist Untuk Ubah Rekening Debit</legend>
<div style="width:100%;">
	<?php
	$modRekKredit = new RekeningakuntansiV('search');
	$modRekKredit->unsetAttributes();
//        $account = "D";
	if (isset($_GET['RekeningakuntansiV'])) {
		$modRekKredit->attributes = $_GET['RekeningakuntansiV'];
		$modRekKredit->rekening5_nb = $_GET['rekening5_nb'];
	}
//        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	$this->widget('ext.bootstrap.widgets.BootGridView', array(
		'id' => 'rekkredit-m-grid',
		//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
		'dataProvider' => $modRekKredit->searchAccounts(),
		'filter' => $modRekKredit,
		'template' => "{summary}\n{items}\n{pager}",
		'itemsCssClass' => 'table table-striped table-bordered table-condensed',
//        JIKA INI DI AKTIFKAN MAKA FILTER AKAN HILANG
//                'mergeHeaders'=>array(
//                    array(
//                        'name'=>'<center>Kode Rekening</center>',
//                        'start'=>1, //indeks kolom 3
//                        'end'=>5, //indeks kolom 4
//                    ),
//                ),
		'columns' => array(
			array(
				'header' => 'Pilih',
				'type' => 'raw',
				'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
						"id" => "selectRekKredit",
						"onClick" =>"
							$(\"#rekening5_id\").val(\"$data->rekening5_id\");
							$(\"#kredit\").val(\"$data->namaRekening\");  
							saveDebit();							
							return false;
					"))',
			),
			array(
				'header' => 'No. Urut',
				'name' => 'nourutrek',
				'value' => '$data->nourutrek',
			),
			array(
				'header' => 'Rek. 1',
				'name' => 'kdrekening1',
				'value' => '$data->kdrekening1',
			),
			array(
				'header' => 'Rek. 2',
				'name' => 'kdrekening2',
				'value' => '$data->kdrekening2',
			),
			array(
				'header' => 'Rek. 3',
				'name' => 'kdrekening3',
				'value' => '$data->kdrekening3',
			),
			array(
				'header' => 'Rek. 4',
				'name' => 'kdrekening4',
				'value' => '$data->kdrekening4',
			),
			array(
				'header' => 'Rek. 5',
				'name' => 'kdrekening5',
				'value' => '$data->kdrekening5',
			),
			array(
				'header' => 'Nama Rekening',
				'type' => 'raw',
				'name' => 'nmrekening5',
				'value' => '($data->nmrekening5 == "" ? $data->nmrekening4 : ($data->nmrekening4 == "" ? $data->nmrekening3 : ($data->nmrekening3 == "" ? $data->nmrekening2 : ($data->nmrekening2 == "" ? $data->nmrekening1 : ($data->nmrekening1 == "" ? "-" : $data->nmrekening5)))))',
			),
			array(
				'header' => 'Nama Lain',
				'name' => 'nmrekeninglain5',
				'value' => '($data->nmrekeninglain5 == "" ? $data->nmrekeninglain4 : ($data->nmrekeninglain4 == "" ? $data->nmrekeninglain3 : ($data->nmrekeninglain3 == "" ? $data->nmrekeninglain2 : ($data->nmrekeninglain2 == "" ? $data->nmrekeninglain1 : ($data->nmrekeninglain1 == "" ? "-" : $data->nmrekeninglain5)))))',
			),
			array(
				'header' => 'Saldo Normal',
				'value' => '($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
				'filter' => CHtml::dropDownList(
						'rekening5_nb', $modRekKredit->rekening5_nb, array('D' => 'Debit',
					'K' => 'Kredit',), array('empty' => '--Pilih--'))
			),
		),
		'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
	));
	?>
</div>
<script>
	function verifikasi() {
		myConfirm("<?php echo Yii::t('mds', 'Yakin Anda akan Ubah Data Rekening?') ?>", 'Perhatian!', function (r) {
			if (r)
			{
				$('#dialogUbahRekeningDebitKredit').dialog('close');
			}
			else
			{
				$('#submit').submit();
				return false;
			}
		});
	}
</script>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlEditKredit = Yii::app()->createUrl($module . '/' . $controller . '/getRekeningEditDebitKredit'); //MAsukan Dengan memilih Rekening
$mds = Yii::t('mds', 'Anda yakin akan ubah data rekening debit ?');
$jscript = <<< JS

function saveDebit()
{
    
    rekening5_id = $('#rekening5_id').val();
    penjamin_id = $('#penjamin_id').val();
    penjaminrek_id = $('#penjaminrek_id').val();

    myConfirm("${mds}",'Perhatian!',function(r){
        if(r)
        {
            $.post("${urlEditKredit}", {rekening5_id:rekening5_id, penjamin_id:penjamin_id,penjaminrek_id:penjaminrek_id},
                function(data){
                    $('.divForForm').html(data.pesan);
                    setTimeout(function(){
                        $("#iframeEditRekeningDebitKredit").attr("src",$(this).attr("href"));window.parent.$("#dialogUbahRekeningDebitKredit").dialog("close");
                        return true;
                    },500);
            }, "json");
        }
    });
}
    
JS;
Yii::app()->clientScript->registerScript('ubahDebit', $jscript, CClientScript::POS_HEAD);
?>