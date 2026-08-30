<?php
/*
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'defaultZero'=>true,
        'allowZero'=>true,
        'precision'=>2,
		'decimal'=>",",
		'thousands'=>".",
    )
));*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'id'=>'form-saldo-kel-rekening',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
        'focus'=>'#',
    )
);
$this->widget('bootstrap.widgets.BootAlert');

?>

<div class="panel panel-success" id="fieldsetSaldoKelRek">
	<div class="panel-heading" >
		<div class="panel-title"><span id="jenis_input">Tambah</span> Saldo Awal Rekening</div>
	</div>
	<div class="panel-body">
		<table>
			<tr>
				<td>
					<?php echo $form->hiddenField($model,'saldoawal_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening1_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening2_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening3_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening4_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening5_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'kursrp_id', array('class'=>'span1')); ?>


					<?php echo $form->hiddenField($model,'jmlmutasid', array('value'=>0, 'class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'jmlmutasik', array('value'=>0,'class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'jmlsaldoakhird', array('value'=>0,'class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'jmlsaldoakhirk', array('value'=>0,'class'=>'span1')); ?>

					<?php echo $form->hiddenField($model,'rekening1_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening2_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening3_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening4_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'rekening5_id', array('class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'kursrp_id', array('class'=>'span1')); ?>

					<?php echo $form->hiddenField($model,'jmlmutasid', array('value'=>0, 'class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'jmlmutasik', array('value'=>0,'class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'jmlsaldoakhird', array('value'=>0,'class'=>'span1')); ?>
					<?php echo $form->hiddenField($model,'jmlsaldoakhirk', array('value'=>0,'class'=>'span1')); ?>
					<div class="control-group ">
							   <?php echo $form->labelEx($model,'Periode Posting', array('class'=>'control-label')); ?>
							   <div class="controls">
									 <?php echo $form->dropDownList($model,'periodeposting_id', PeriodepostingM::items(), array('empty'=>'-- Pilih --',
										 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 reqForm')); ?>
							   </div>
					</div>
				</td>
			</tr>
			<?php if (Yii::app()->user->getState('jabatan_id') == 9): ?>
			<tr>
				<td>
					<?php echo $form->dropDownListRow($model,'unitkerja_id',
						CHtml::listData(UnitkerjaM::model()->findAll('unitkerja_aktif = true'), 'unitkerja_id', 'namaunitkerja'),
						array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td>
					<div class="control-group ">
							   <?php echo $form->labelEx($model,'matauang_id', array('class'=>'control-label')); ?>
							   <div class="controls">
									<?php
										echo $form->dropDownList(
											$model,'matauang_id', MatauangM::items(),
											array(
												'empty'=>'-- Pilih --',
												'onkeypress'=>"return $(this).focusNextInputField(event)",
												'class'=>'reqForm',
												'onChange'=>'getKursRupiah(this)',
												'style'=>'width:140px;',
											)
										);
									/*
										echo $form->dropDownListRow($model, 'matauang_id', MatauangM::items(),
											array(
												'empty'=>'-- Pilih --',
												'ajax'=>array(
													'type'=>'POST',
													'url'=>Yii::app()->createUrl('ActionDynamic/GetKursUang',
														array(
															'encode'=>false,
															'namaModel'=>'AKSaldoawalT',
															'namaField'=>'matauang_id',
														)
													),
													'update'=>'#AKSaldoawalT_kursrp_id'
												),
												'onkeypress'=>"return $(this).focusNextInputField(event)"
											)
										);
									 * 
									 */
									?>
								   <?php echo $form->dropDownList($model,'kursrp_id', KursrpM::items(),array('empty'=>'-- Pilih --',
								'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;')); ?>
							   </div>
				 </div>
				</td>

			</tr>
			<tr>
				<td>
					<?php echo $form->textFieldRow($model,'jmlanggaran',array('class'=>'currency span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->textFieldRow($model,'jmlsaldoawald',array('class'=>'currency span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->textFieldRow($model,'jmlsaldoawalk',array('class'=>'currency span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
				</td>
			</tr>
		</table>

		<?php //echo $form->textFieldRow($model,'jmlmutasid',array('class'=>'currency span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
		<?php //echo $form->textFieldRow($model,'jmlmutasik',array('class'=>'currency span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
		<?php //echo $form->textFieldRow($model,'jmlsaldoakhird',array('class'=>'currency span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
		<?php //echo $form->textFieldRow($model,'jmlsaldoakhirk',array('class'=>'currency span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>

		<div class="form-actions">
			<?php
				echo CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)'));
				echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="'.MyIcon::getIcons('ulang').'"></i>')), array('style'=>'display:none','id' => 'reseter', 'class'=>'btn btn-danger', 'type'=>'reset'));
			?>
		</div>
			
	</div>
</div>
    
<?php
    $urlPostData = Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanSaldoRekening');
?>
    
<script type="text/javascript">    
    $('#form-saldo-kel-rekening').submit(function(){
        var kosong = "";
        var jumlahKosong = $("#fieldsetSaldoKelRek").find(".reqForm[value="+ kosong +"]");
        if(jumlahKosong.length > 0){
            myAlert('Inputan bertanda bintang harap di isi !!');
        }else{
            $('.currency').each(
                function(){
                  //  this.value = unformatNumber(this.value)
                }
            );
            $.post("<?php echo $urlPostData;?>", {data:$(this).serialize()},
                function(data){
                    if(data.pesan == 'exist'){
                        toastr.success('Saldo untuk rekening ini telah terdaftar');
						$("#dialogEditSaldoRekening").dialog("open");
                    }
                    
                    if(data.status == 'ok'){
                        toastr.success('Rekening berhasil disimpan');
                        if(data.pesan == 'insert'){
                            $("#reseter").click();
                            for (rekening in data.id_rekening)
                            {
                                if(rekening != 'rekperiod_id')
                                {
                                    $('#fieldsetSaldoKelRek').find("input[name$='["+ rekening +"]']").val(data.id_rekening[rekening]);
                                }
                            }
                            $.fn.yiiGridView.update('grid-saldo-rekening', {});
                        }
						$("#dialogEditSaldoRekening").dialog("close");
						$("#fieldsetSaldoKelRek").hide();
                    }else{
						 toastr.error(data.pesan);
					}
                }, "json"
            );
        }
        return false;
    });
    
    function getKursRupiah(obj)
    {
        var value = $(obj).val();
        $.post("<?php echo Yii::app()->createUrl('ActionDynamic/GetKurs');?>", {id:value},
            function(data){
                $('#fieldsetSaldoKelRek').find("input[name$='[kursrp_id]']").val("");
                if(typeof data.data != 'undefined')
                {
                    $('#fieldsetSaldoKelRek').find("input[name$='[kursrp_id]']").val(data.data.kursrp_id);
                }
            }, "json"
        );
    }
</script>

<?php $this->endWidget();?>