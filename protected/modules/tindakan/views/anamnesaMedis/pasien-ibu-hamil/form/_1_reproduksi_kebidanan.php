<?php
$reproduksikblain = $model->reproduksi_kb;
?>
<div class="control-group">
    <label class="controls"><b>Reproduksi kebidanan/kandungan</b></label>
</div>
<div class="control-group">
    <label class="controls">1.</label>
    <label class="controls col-sm-2">Mamae</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->radioButtonList($model, 'reproduksi_mamae', [
            'Normal' => 'Normal',
            'Benjolan/Nyeri' => 'Benjolan/Nyeri',
            'Bekas Operasi' => 'Bekas Operasi',
            'Bengkok' => 'Bengkok',
        ])
        ?>
    </div>
</div>       

<div class="control-group kelompok">
    <label class="controls">2.</label>
    <label class="controls col-sm-2">KB</label>
    <label class="controls">:</label>
    <div class="controls">
        <?php
            $reproduksilain = 'bebas';
            if (!empty($model->reproduksi_kb)){    
                $reproduksilain = '';
                if (!in_array($model->reproduksi_kb,[
                    'Tidak','IUD','Pil','Suntik'
                ])){
                    $reproduksilain = $model->reproduksi_kb;
                }
            }
                
            
        ?>
        <label class="radio">
            <?= $form->radioButton($model, 'reproduksi_kb',['id'=>'reproduksi_kb_tidak','value'=>'Tidak','uncheckValue'=>null]) ?>
            <label for="reproduksi_kb_tidak">Tidak</label>
        </label>
        <label class="radio">
            <?= $form->radioButton($model, 'reproduksi_kb',['id'=>'reproduksi_kb_iud','value'=>'IUD','uncheckValue'=>null]) ?>
            <label for="reproduksi_kb_iud">IUD</label>
        </label>
        <label class="radio">
            <?= $form->radioButton($model, 'reproduksi_kb',['id'=>'reproduksi_kb_pil','value'=>'Pil','uncheckValue'=>null]) ?>
            <label for="reproduksi_kb_pil">Pil</label>
        </label>
        <label class="radio">
            <?= $form->radioButton($model, 'reproduksi_kb',['id'=>'reproduksi_kb_suntik','value'=>'Suntik','uncheckValue'=>null]) ?>
            <label for="reproduksi_kb_suntik">Suntik</label>
        </label>
        <label class="radio">
            <?= $form->radioButton($model, 'reproduksi_kb',['class'=>'open-ket-dis','id'=>'reproduksi_kb_bebas','value'=>$reproduksilain,'uncheckValue'=>null]) ?>
            <label for="reproduksi_kb_bebas"></label>
            <?= CHtml::textField('reproduksilain',(($reproduksilain=='bebas')?'':$reproduksilain),['class'=>'span2 ket-dis','onblur'=>'setReproduksi(this)', 'onkeypress' => "return $(this).focusNextInputField(event)"]) ?>
        </label>
    </div>
</div>  

<div class="control-group">
    <label class="controls">3.</label>
    <label class="controls col-sm-2">HPHT</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->textField($model, 'reproduksi_hpht', ['class' => 'span2', 'maxlength' => 50, 'onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>
    <label class="controls">Tafsiran persalinan</label>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $model,
            'attribute' => 'reproduksi_tafsirpersalinan',
            'mode' => 'datetime',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
                'maxDate' => 'd',
            ),
            'htmlOptions' => array(
                'readonly' => true,
                'class' => 'span3',
                'onkeypress' => "return $(this).focusNextInputField(event)"
            ),
        ));
        ?>
    </div>
</div>    

<div class="control-group">
    <label class="controls">4.</label>
    <label class="controls col-sm-2">Riwayat Persalinan</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->textField($model, 'reproduksi_riwayatpersalinan', ['class' => 'span4', 'maxlength' => 100, 'onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>    
</div>

<div class="control-group">
    <label class="controls">5.</label>
    <label class="controls col-sm-2">Riwayat Menstruasi</label>
    <label class="controls">:</label>
    <div class="controls">
        <?=
        $form->textField($model, 'reproduksi_riwayat_menstruasi', ['class' => 'span4', 'maxlength' => 100, 'onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>    
</div>

<div class="control-group kelompok">
    <label class="controls">6.</label>
    <label class="controls col-sm-2">Keputihan</label>
    <label class="controls">:</label>
    <div class="controls">        
        <label class="radio">
            <?= $form->radioButton($model, 'is_keputihan',['id'=>'is_keputihan_tidak','value'=>0,'uncheckValue'=>null]) ?>
            <label for="is_keputihan_tidak">Tidak</label>
        </label>        
        <label class="radio">
            <?= $form->radioButton($model, 'is_keputihan',['class'=>'open-ket-dis','id'=>'is_keputihan_ada','value'=>1,'uncheckValue'=>null]) ?>
            <label for="is_keputihan_ada">Ada</label>
        </label>
    </div>    
    <label class="controls">Warna</label>
    <div class="controls">
        <?=
        $form->textField($model, 'reproduksi_warnakeputihan', ['class' => 'ket-dis span2', 'maxlength' => 50, 'onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>  
    <label class="controls">Bau</label>
    <div class="controls">
        <?=
        $form->textField($model, 'reproduksi_baukeputihan', ['class' => 'ket-dis  span2', 'maxlength' => 50, 'onkeypress' => "return $(this).focusNextInputField(event)"])
        ?>
    </div>  
</div>