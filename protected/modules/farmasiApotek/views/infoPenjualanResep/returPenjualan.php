<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
        'symbol'=>'Rp ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
        'defaultZero'=>true,
        'allowZero'=>true,
        'decimal'=>',',
        'thousands'=>'.',
        'precision'=>0,
    )
));
?>
<?php
$this->widget('bootstrap.widgets.BootAlert');

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'returpenjualan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#FAReturresepT_alasanretur',
        'method'=>'post',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
            'onsubmit'=>'return cekInputan();'),
));
?>
<?php echo $form->errorSummary($modRetur);?>
<fieldset>
    <legend class="rim">Retur Penjualan</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($detailJuals[0],'no_rekam_medik',array('class'=>'span3','readonly'=>true)); ?>
                <?php //echo $form->hiddenField($obatpasiens[0],'obatalkespasien_id',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'nama_pasien',array('class'=>'span3','readonly'=>true)); ?>
                <div class="control-group">
                    <label for="FAInformasipenjualanapotikV_jeniskelamin" class="control-label">Jeniskelamin</label>
                    <div class="controls">
                        <?php //echo $form->textField($detailJuals[0],'umur',array('class'=>'span2','readonly'=>true)); ?> 
                        <?php echo $form->textField($detailJuals[0],'jeniskelamin',array('class'=>'span2','readonly'=>true)); ?>
                    </div>
                </div>
            </td>
            <td>
                <?php echo $form->textFieldRow($detailJuals[0],'tglpenjualan',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'tglresep',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->textFieldRow($detailJuals[0],'noresep',array('class'=>'span3','readonly'=>true)); ?>
            </td>
        </tr>
    </table>
</fieldset>

<table>
    <tr>
        <td>
            <div class="control-group">
                <?php //echo $form->textFieldRow($modRetur,'tglretur',array('class'=>'span3','readonly'=>true)); ?>
                <?php echo $form->labelEx($modRetur,'tglretur', array('class'=>'control-label')) ?>
                <div class="controls">  
                 <?php $this->widget('MyDateTimePicker',array(
                                     'model'=>$modRetur,
                                     'attribute'=>'tglretur',
                                     'mode'=>'datetime',
                                     'options'=> array(
                                         'maxDate'=>'d',
                                         'dateFormat'=>Params::DATE_FORMAT,
                                    ),
                                     'htmlOptions'=>array('readonly'=>true,
                                     'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                )); ?>
                </div> 
            </div>
            
            <?php echo $form->hiddenField($modRetur,'pasien_id',array('class'=>'span3','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($modRetur,'alasanretur',array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($modRetur,'noreturresep',array('class'=>'span3','readonly'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($modRetur,'keteranganretur',array('class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modRetur,'pegretur_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'))), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3','readonly'=>false, 'value'=>  Yii::app()->user->getState('pegawai_id'), 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($modRetur,'mengetahui_id', CHtml::listData(DokterpegawaiV::model()->findAll(array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'),array('empty'=>'-- Pilih --','class'=>'span3','readonly'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
</table>

<div id="divTabelRetur">
<?php echo $form->errorSummary($modDetailRetur); ?>
<?php $this->renderPartial('_tblReturPenjualan',array('detailJuals'=>$detailJuals, 'modReturDetails'=>$modDetailRetur, 'modPenjualanResep'=>$modPenjualanResep)); ?>
</div>

<div class="form-actions">
    
            <?php 
            if ($modRetur->isNewRecord){
                echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                        array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
            }else{
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
            }
            echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),Yii::app()->createUrl('farmasiApotek/'.$this->id.'/returPenjualan', array('idPenjualanResep'=>$modRetur->penjualanresep_id)),array('class' => 'btn btn-default', 'type'=>'reset'));
            ?>
    
									      <?php 
//           $content = $this->renderPartial('../tips/tips',array(),true);
//			$this->widget('UserTips',array('type'=>'admin','content'=>$content));
        ?>
			
</div>
<div id="errorMessage" class="errorSummary"></div>

<?php $this->endWidget(); ?>

<script type="text/javascript">

function cekLogin()
{
    $.post('<?php echo $this->createUrl('CekLogin',array('task'=>'Retur'));?>', $('#formLogin').serialize(), function(data){
        if(data.error != '')
            myAlert(data.error);
        $('#'+data.cssError).addClass('error');
        if(data.status=='success'){
            //myAlert(data.status);
            $('#<?php echo CHtml::activeId($modRetur, 'pegretur_id'); ?>').val(data.userid);
            $('#loginDialog').dialog('close');
            return true;
        }else{
            myAlert(data.status);
        }
    }, 'json');
}

</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'loginDialog',
    'options'=>array(
        'title'=>'Login',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>400,
        'height'=>190,
        'resizable'=>false,
    ),
));?>
<?php echo CHtml::beginForm('', 'POST', array('class'=>'form-horizontal','id'=>'formLogin')); ?>
    <div class="control-group">
        <?php echo CHtml::label('Login Pemakai','username', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('username', '', array()); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label('Password','password', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::passwordField('password', '', array()); ?>
        </div>
    </div>
    
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Login',array('{icon}'=>'<i class="icon-lock icon-white"></i>')),
                            array('class' => 'btn btn-danger', 'type'=>'submit', 'onclick'=>'cekLogin();return false;')); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}'=>'<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default','onclick'=>"$('#loginDialog').dialog('close');return false",'disabled'=>false)); ?>
    </div> 
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget();?>

<?php
$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/'.$this->id.'/PrintReturPenjualan&id='.$modRetur->returresep_id);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>