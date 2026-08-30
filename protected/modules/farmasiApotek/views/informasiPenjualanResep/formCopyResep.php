<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'facopyresep-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert');?>

<legend class="rim2">Salin Resep</legend> 
	<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
	<?php echo $form->errorSummary(array($model)); ?>
<fieldset>    
        <table>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPenjualanResep,'noresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modelPenjualanResep,'noresep',array('class'=>'span3','readonly'=>true));
                                 echo $form->hiddenField($modelPenjualanResep,'penjualanresep_id',array('class'=>'span2','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien,'no_rekam_medik', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modPasien,'no_rekam_medik',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                 <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPenjualanResep,'tglresep', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modelPenjualanResep,'tglresep',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textField($modPasien,'nama_pasien',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Dokter','dokter', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo CHtml::textField($modelPenjualanResep->pegawai_id,isset($modelPenjualanResep->pegawai->NamaLengkap)?$modelPenjualanResep->pegawai->NamaLengkap:'-',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien,'alamat_pasien', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                 echo $form->textArea($modPasien,'alamat_pasien',array('class'=>'span3','readonly'=>true));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        
        <table id="table-obatalkespasien" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <!--<th>Pilih <br><?php //echo CHtml::checkBox('is_pilihsemuaoa',true,array('onchange'=>'setPilihOaChecked();','rel'=>'tooltip','title'=>'Centang untuk pilih semua obat dan alkes','onkeyup'=>"return $(this).focusNextInputField(event);")) ?></th>-->
                    <!--<th>No.</th>-->
                    <th>R</th>
                    <th>R Ke</th>
                    <th>Kode Obat / Nama Obat</th>
					<th>Sumber Dana</th>
					<th>Satuan Kecil</th>
                    <th>Jumlah</th>
                    <th>Aturan Pakai</th>                    
                    <th>Etiket</th>
                    <th>Harga Netto</th>
					<th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count((array)$modObatAlkesPasien) > 0){
                    foreach($modObatAlkesPasien AS $i=> $modDetail){
                        echo $this->renderPartial('_rowDetailCopyResep',array('modObatAlkesPasien'=> $modDetail));
                    }
                }
                ?>
            </tbody>
        </table>
        <table>
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo $form->labelEx($model,'keterangancopy', array()) ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                     <div class="control-group">
                            <?php   
                                 echo $form->textArea($model,'keterangancopy',array('class'=>'span3','readonly'=>false));
                            ?>
                    </div>
                </td>
            </tr>
        </table>
</fieldset>
    <div class="form-actions">
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Salin Resep',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>

        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), array('class' => 'btn btn-default','onclick'=>'ulang(this.id)')); ?>
        <?php if(($tersimpan == 'Ya')){ ?>
            <script>
                print(<?php echo $modelPenjualanResep->penjualanresep_id?>);
            </script>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"print('$modelPenjualanResep->penjualanresep_id');return false",'disabled'=>FALSE  )); 
               }else{
                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','disabled'=>TRUE  )); 
               } 
        ?>
    </div>

<?php $this->endWidget(); ?>
<?php
if($tersimpan=='Ya'){
?>
<script>
parent.location.reload();
</script>
<?php
}
?>
<?php
$urlPrintCopyResep = Yii::app()->createUrl('farmasiApotek/informasiPenjualanResep/PrintCopyResep',array('idPenjualanResep'=>''));
$jscript = <<< JS
function print(idPenjualanResep)
{
             window.open('${urlPrintCopyResep}'+idPenjualanResep,'printwin','left=100,top=100,width=400,height=400');
			 
}
JS;
Yii::app()->clientScript->registerScript('jsCopyResep',$jscript, CClientScript::POS_BEGIN);
?>
<script type="text/javascript">
function ulang(id){
    $('#<?php echo CHtml::activeId($model,"keterangancopy"); ?>').val('');
}
</script>
<?php $this->renderPartial('_jsFunctions', array('model'=>$model,'modDetailPenjualan'=>$modDetail)); ?>
