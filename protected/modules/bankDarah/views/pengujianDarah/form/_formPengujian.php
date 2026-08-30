<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan sebagai form inputan observasi donor darah
* RSST-1515
*/
?>
<div class="panel panel-success pengujianke-" id="pengujianke-">
    <div class="panel-heading">
        <div class="panel-title">
        Pengujian Konfirmasi Golongan Darah <span id="jumlah-pengujian"><?php //echo isset($i)?$i+1:'1'; ?></span><span class="required">*</span>
        </div>
    </div>
    <?php echo $form->hiddenField($model,'pengujian_ke',array());?>
    <?php echo $form->hiddenField($model,'goldar1',array());?>
    <?php echo $form->hiddenField($model,'rhesus1',array());?>
    <div class="panel-body pilih-pengujiankonfirmasi" id="pilih-pengujiankonfirmasi" id-data="1">        
        <div class="col-sm-6">
            <div class="control-group anti-a">
                <label class="control-label">Anti A :</label>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_a',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_a',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Negatif (-)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->textField($model,'[det]['.(isset($i)?$i:0).']lot_anti_a',array('class'=>'span3','placeholder'=> 'Masukkan LOT')); ?>
                </div>
            </div>
            
            <div class="control-group anti-b">
                <label class="control-label">Anti B :</label>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_b',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_b',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Negatif (-)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->textField($model,'[det]['.(isset($i)?$i:0).']lot_anti_b',array('class'=>'span3','placeholder'=> 'Masukkan LOT')); ?>
                </div>
            </div>
            
            <div class="control-group anti-d">
                <label class="control-label">Anti D :</label>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_d',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_d',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Negatif (-)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->textField($model,'[det]['.(isset($i)?$i:0).']lot_anti_d',array('class'=>'span3','placeholder'=> 'Masukkan LOT')); ?>
                </div>
            </div>
            
            <div class="control-group anti-ab">
                <label class="control-label">Anti AB :</label>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_ab',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']anti_ab',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Negatif (-)</label>
                </div>
            </div>
           
        </div>
        
        <div class="col-sm-6">
            <div class="control-group sel-a">
                <label class="control-label">Sel A :</label>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']sel_a',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']sel_a',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Negatif (-)</label>
                </div>
            </div>
            
            <div class="control-group sel-b">
                <label class="control-label">Sel B :</label>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']sel_b',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']sel_b',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Negatif (-)</label>
                </div>
            </div>                        
            
            <div class="control-group sel-o">
                <label class="control-label">Sel O :</label>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']sel_o',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_POSITIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Positif (+)</label>
                </div>
                <div class="controls">                    
                     <?php echo $form->radioButton($model,'[det]['.(isset($i)?$i:0).']sel_o',array('class'=>'pilihData','uncheckValue'=> null,'value'=>Params::PENGUJIAN_GOLDARAH_NEGATIF, 'onclick'=>'hasilKesimpulan(this);')); ?> <label>Negatif (-)</label>
                </div>
            </div>
        </div>
        
        <div class="clear"></div>
        
        <?php echo $this->renderPartial($this->path_view.'form._formHasil',array('form'=>$form, 'model'=>$model,'i'=>isset($i)?$i+1:'0')); ?>
    </div>
</div>

