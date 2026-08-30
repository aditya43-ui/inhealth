<div id="divPasien"  style="display: block;">
<fieldset id='fieldsetPasien'>
<legend class="rim">Masukan Data Pasien</legend>
        <table width="1039" border="0">
          <tr>
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                    <div class="controls inline">
                        <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                                            )); ?>   
                        <?php echo $form->textField($modPasien,'nama_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            

                        <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($modPasien,'tempat_lahir', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPasien,
                                                'attribute'=>'tanggal_lahir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT_MEDIUM,
                                                    'maxDate' => 'd',
                                                    //
                                                    'onkeypress'=>"js:function(){getUmur(this);}",
                                                    'onSelect'=>'js:function(){getUmur(this);}',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPasien,'umur', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('CMaskedTextField', array(
                            'model' => $modPasien,
                            'attribute' => 'umur',
                            'mask' => '99 Thn 99 Bln 99 Hr',
                            'htmlOptions' => array('onkeypress'=>"return $(this).focusNextInputField(event)",'onblur'=>'getTglLahir(this)')
                            ));
                            ?>
                        <?php echo $form->error($modPasien, 'umur'); ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListInlineRow($modPasien,'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        	</td>
          </tr>
        </table>
    </fieldset>
</div>

<?php
$urlGetTglLahir = Yii::app()->createUrl('ActionAjax/GetTglLahir');
$urlGetUmur = Yii::app()->createUrl('ActionAjax/GetUmur');
$urlGetDaerah = Yii::app()->createUrl('ActionAjax/getListDaerahPasien');
$idTagUmur = CHtml::activeId($modPasien,'umur');
$js = <<< JS

function getTglLahir(obj)
{   
    var str = obj.value;
    obj.value = str.replace(/_/gi, "0");
    $.post("${urlGetTglLahir}",{umur: obj.value},
        function(data){
           $('#PPPasienM_tanggal_lahir').val(data.tglLahir); 
    },"json");
}
    
function getUmur(obj)
{
    //alert(obj.value);
    if(obj.value == '')
        obj.value = 0;
    $.post("${urlGetUmur}",{tglLahir: obj.value},
        function(data){

           $('#PPPasienM_umur').val(data.umur);
    },"json");
}
JS;
Yii::app()->clientScript->registerScript('formPasien',$js,CClientScript::POS_HEAD);

$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>