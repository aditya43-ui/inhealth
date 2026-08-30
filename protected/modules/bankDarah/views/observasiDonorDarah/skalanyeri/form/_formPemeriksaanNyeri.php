<?php
/**
* - digunakan untuk menginput data asesmen nyeri
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*/
?>

<table class="table noborder paddingtext">                    	
    <tr>
        <td>
            <div class="control-group">
                <?php echo $form->labelEx($model,'frekuensinyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'frekuensinyeri', LookupM::getItemsUrutan('frekuensinyeri'),array('empty' => '-- Pilih --','readonly'=>true,'disabled'=>true)); ?>
                </div>
            </div>
               
            <div class="control-group">
                <?php echo $form->labelEx($model,'lamanyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lamanyeri',array('empty' => '-- Pilih --','class'=>'span1')); ?>
                </div>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'satuanlamanyeri',LookupM::getItemsUrutan('satuanlamanyeri'),array('empty' => '-- Pilih --','readonly'=>true,'disabled'=>true)); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'is_nyerimenjalar',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">                   
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->radioButton($model,'is_nyerimenjalar',array('uncheckValue'=>null,'onclick'=>'cekNyeriMenjalar();','id'=>'menjalarNo','value'=>0,'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,'disabled'=>true)); ?> <label>Tidak</label>  
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php echo $form->radioButton($model,'is_nyerimenjalar',array('uncheckValue'=>null,'onclick'=>'cekNyeriMenjalar();','id'=>'menjalarYes','value'=>1,'onkeypress'=>"return $(this).focusNextInputField(event);",'readonly'=>true,'disabled'=>true)); ?>  <label>Ya</label>   
                             				                      
                        
                   
                </div>                
                <div class="controls">
                    <?php echo $form->textField($model,'nyerimenjalarke',array('empty' => '-- Pilih --','class'=>'','disabled'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'kualitasnyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'kualitasnyeri',LookupM::getItemsUrutan('kualitasnyeri'),array('empty' => '-- Pilih --','readonly'=>true,'disabled'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'pemicu_memperberat',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'pemicu_memperberat',array('empty' => '-- Pilih --','class'=>'','readonly'=>true,'disabled'=>true)); ?>
                </div>
                
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'pemicu_meringankan',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'pemicu_meringankan',array('empty' => '-- Pilih --','class'=>'','readonly'=>true,'disabled'=>true)); ?>
                </div>
                
            </div>
                      
        </td>
    </tr>
</table>
