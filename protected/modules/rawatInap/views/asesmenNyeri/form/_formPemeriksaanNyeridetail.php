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
                     <?php  echo $form->textField($model,'frekuensinyeri',array('readonly'=>'true','class' => 'span3')); ?>
                    <?php //echo $form->dropDownList($model,'frekuensinyeri', LookupM::getItemsUrutan('frekuensinyeri'),array('empty' => '-- Pilih --')); ?>
                </div>
            </div>
               
            <div class="control-group">
                <?php echo $form->labelEx($model,'lamanyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'lamanyeri',array('readonly'=>'true','empty' => '-- Pilih --','class'=>'span1')); ?>
                </div>
                <div class="controls">
                     <?php  echo $form->textField($model,'satuanlamanyeri',array('readonly'=>'true','class' => 'span3')); ?>
                    <?php //echo $form->dropDownList($model,'satuanlamanyeri',LookupM::getItemsUrutan('satuanlamanyeri'),array('empty' => '-- Pilih --')); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model,'is_nyerimenjalar',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">                   
                        
                        <?php 
                             
 
                             if($model->is_nyerimenjalar==true){
                                 $model->is_nyerimenjalardet="Ada";
                                  
                             }else{
                                //var_dump($model->is_nyerimenjalar);die;
                                $model->is_nyerimenjalardet="Tidak Ada";
                             }
                         echo $form->textField($model,'is_nyerimenjalardet',array('readonly'=>'true','class' => 'span3')); ?>   
                             				                      
                        
                   
                </div>                
                <div class="controls">
                    <?php echo $form->textField($model,'nyerimenjalarke',array('empty' => '-- Pilih --','class'=>'','disabled'=>true,'readonly'=>'true')); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'kualitasnyeri',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php 
                     echo $form->textField($model,'kualitasnyeri',array('readonly'=>'true','class' => 'span3')); ?>
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'pemicu_memperberat',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'pemicu_memperberat',array('readonly'=>'true','empty' => '-- Pilih --','class'=>'')); ?>
                </div>
                
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'pemicu_meringankan',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'pemicu_meringankan',array('readonly'=>'true','empty' => '-- Pilih --','class'=>'span3')); ?>
                </div>
                
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model,'tindaklanjut',array('class' => 'control-label', 'style'=>'width:30%;text-align:left;')) ?>
                <div class="controls">
                    <?php echo $form->textField($model,'tindaklanjut',array('readonly'=>'true','empty' => '-- Pilih --','class'=>'span3')); ?>
                    
                </div>
            </div>
        </td>
    </tr>
</table>
