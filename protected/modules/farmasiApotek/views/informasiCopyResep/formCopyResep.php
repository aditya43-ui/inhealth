<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'facopyresep-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
));
$this->widget('bootstrap.widgets.BootAlert');?>

<legend class="rim2">Copy Resep</legend> 
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
                                 echo CHtml::textField($modDetailPenjualan->nama_pegawai,$modDetailPenjualan[0]->nama_pegawai,array('class'=>'span3','readonly'=>true));
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
        
        <table id="tableObat" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode Obat</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Aturan Pakai</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($modDetailPenjualan as $key=>$detail){
                ?>
                <tr>
                    <td><?php echo ($key+1); ?></td>
                    <td><?php echo $detail->obatalkes_kode; ?></td>
                    <td><?php echo $detail->obatalkes_nama;?></td>
                    <td><?php echo $detail->qty_oa; ?></td>
                    <td><?php echo $detail->signa_oa; ?> </td>
                </tr>
                <?php } ?>
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
         <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Copy Resep',array('{icon}'=>'<i class="entypo-check"></i>')),
                                                                array('class' => 'btn btn-danger', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), $this->createUrl('informasiPenjualanResep/CopyResep&idPenjualanResep='.$modelPenjualanResep->penjualanresep_id), array('class'=>'btn btn-danger')); ?>
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
