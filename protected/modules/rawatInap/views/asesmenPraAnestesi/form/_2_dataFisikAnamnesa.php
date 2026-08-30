<div class="col-sm-6">
    <div class="control-group">
        <label class="control-label"><b>Tanda Vital</b></label>        
    </div>
    
    <div class="control-group">
        <label class="control-label">GCS </label>
        <div class="controls">
            <?= 'E '.$form->dropDownList($model, 'gcs_eye_id', CHtml::listData(MetodegcsM::model()->findAll(" LOWER(metodegcs_singkatan) = 'e' AND metodegcs_aktif = true AND metodegcs_nilai is not null "),'metodegcs_id','TextMetodeGCSM'),['style' => 'margin: 5px 0;', 'class'=>'span4', 'empty'=>'-- Pilih --']) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?= 'V '.$form->dropDownList($model, 'gcs_verbal_id', CHtml::listData(MetodegcsM::model()->findAll(" LOWER(metodegcs_singkatan) = 'v' AND metodegcs_aktif = true AND metodegcs_nilai is not null "),'metodegcs_id','TextMetodeGCSM'),['style' => 'margin: 5px 0;', 'class'=>'span4', 'empty'=>'-- Pilih --']) ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?= 'M '.$form->dropDownList($model, 'gcs_motorik_id', CHtml::listData(MetodegcsM::model()->findAll(" LOWER(metodegcs_singkatan) = 'm' AND metodegcs_aktif = true AND metodegcs_nilai is not null "),'metodegcs_id','TextMetodeGCSM'),['style' => 'margin: 5px 0;', 'class'=>'span4', 'empty'=>'-- Pilih --']) ?>
        </div>
    </div>
    
    <?= $form->radioButtonListRow($model, 'kesadaran', [
        'Cosmos mentis' => 'Cosmos mentis',
        'Apathis' => 'Apathis',
        'Somnolent' => 'Somnolent',
        'Supor' => 'Supor',
        'Soporocoma' => 'Soporocoma',
        'Coma' => 'Coma',
    ]) ?>
    <div class="control-group">
        <label class="control-label">Tekanan Darah</label>
        <div class="controls">
            <?= $form->textField($model, 'tensi_sistolik',['class'=>'integer2 span2']); ?>
        </div>
        <label class="controls">/</label>
        <div class="controls">
            <?= $form->textField($model, 'tensi_diastolik',['class'=>'integer2 span2']); ?>
        </div>
        <label class="controls">mmHg</label>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nadi</label>
        <div class="controls">
            <?= $form->textField($model, 'nadi',['class'=>'integer2 span4']); ?>
        </div>
        <label class="controls">x/menit</label>        
    </div>
    
    <div class="control-group">
        <label class="control-label">Suhu</label>
        <div class="controls">
            <?= $form->textField($model, 'suhu',['class'=>'float2 span4']); ?>
        </div>
        <label class="controls"><sup>o</sup>C</label>        
    </div>
    
    <div class="control-group">
        <label class="control-label">RR</label>
        <div class="controls">
            <?= $form->textField($model, 'rr',['class'=>'integer2 span4']); ?>
        </div>
        <label class="controls">x/menit</label>        
    </div>
    
    <div class="control-group">
        <label class="control-label">SpO2</label>
        <div class="controls">
            <?= $form->textField($model, 'spo2',['class'=>'integer2 span4']); ?>
        </div>
        <label class="controls">%</label>        
    </div>
    
    <div class="control-group">
        <label class="control-label">Berat Badan</label>
        <div class="controls">
            <?= $form->textField($model, 'beratbadan_kg',['class'=>'float2 span4']); ?>
        </div>
        <label class="controls">kg</label>        
    </div>
    
    <div class="control-group">
        <label class="control-label">Tinggi Badan</label>
        <div class="controls">
            <?= $form->textField($model, 'tinggibadan_cm',['class'=>'float2 span4']); ?>
        </div>
        <label class="controls">cm</label>        
    </div>
</div>

<div class="col-sm-6">
    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'riwayatpenyakit', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'riwayatpenyakit', array('placeholder' => 'Riwayat Penyakit', 'class' => 'span3 riwayatpenyakit', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php
            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                'class' => 'btn btn-primary', 'onclick' => "$('#dialogDiagnosa').dialog('open');refreshGridDiagnosa();",
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('riwayatpenyakit')
            ))
            ?>            
        </div>
    </div>
    
    <div class="control-group">
        <?php echo $form->labelEx($model, 'riwayatpengobatan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($model, 'riwayatpengobatan', array('placeholder' => 'Riwayat Pengobatan', 'class' => 'span3 riwayatpengobatan', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            <?php
            echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                'class' => 'btn btn-primary', 'onclick' => "$('#dialogObat').dialog('open');refreshGridObat();",
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'rel' => 'tooltip', 'title' => 'Klik untuk menambah ' . $model->getAttributeLabel('riwayatpengobatan')
            ))
            ?>            
        </div>
    </div>
    
    <?= $form->textAreaRow($model,'riwayatalergimakanan') ?>
    <?= $form->textAreaRow($model,'riwayatalergiobat') ?>
       
    <div class="control-group">
        <?php echo $form->labelEx($model, 'keluhanutama', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'model' => $model,
                'attribute' => 'keluhanutama',
                'data' => explode(',', $model->keluhanutama),
                'debugMode' => true,
                'options' => array(
                    'json_url' => $this->createUrl('MasterKeluhan'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                ),
            ));
            ?>
        </div>
    </div>
</div>
<div class='clear'></div>