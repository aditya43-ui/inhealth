<div class="col-sm-6">
    <div class="control-group ">
        <?php echo Chtml::label('Jam Selesai Operasi', '', array('class' => 'control-label')) ?>
        <div class="controls">  
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'jam_selesai_ok',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::TIME_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo Chtml::label('Jam Selesai Anastesi', '', array('class' => 'control-label')) ?>
        <div class="controls">  
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'jam_selesai_anastesi',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::TIME_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label('EBV', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'ebv', array('class'=>'numbers-only')); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo Chtml::label('Bayi Lahir Jam', '', array('class' => 'control-label')) ?>
        <div class="controls">  
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'bayi_lahir_jam',
                'mode' => 'time',
                'options' => array(
                    'dateFormat' => Params::TIME_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => 'span3',
                    'onkeypress' => "return $(this).focusNextInputField(event)"),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Kondisi Fisik", ' ', array('class' => 'control-label')); ?>
        <div class="controls" style="padding-top: 8px">
            <?php echo CHtml::activeRadioButtonList($model, 'cek_kondisi_fisik', array('Bugar' => 'Bugar', 'Tidak Bugar' => 'Tidak Bugar'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ', 'onclick' => 'setInduksi();')); ?>       
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Apgar Score', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'apgar_score', array('class'=>'numbers-only')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('BB', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'berat_badan', array('class'=>'numbers-only')); ?>
            <label>kg</label>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('TB', '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'tinggi_badan', array('class'=>'numbers-only')); ?>
            <label>cm</label>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <div class="control-group">
        <?php echo CHtml::label('Catatan', '', array('class' => 'control-label')); ?>
        <div class="controls">  
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'catatan', 'name' => 'catatan', 'toolbar' => 'mini', 'height' => '100px', 'width' => '300px', 'htmlOptions' => array('class' => 'span5', 'height' => '100', 'width' => '300'))) ?>
        </div>
    </div>
    <div class="anemia">
        <div class="control-group">
            <?php echo CHtml::label('Selesai operasi', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_esktubasi', array()); ?> <label>Ekstabusi</label> 
            </div>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_intubasi', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>Intubasi</label>
            </div>

            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_awake', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>Awake</label>
            </div>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_icu', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>ICU/ROI</label>
            </div>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_drowsy', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>Drowsy</label>
            </div>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_rr', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>RR/PACU</label>
            </div>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_stabil', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>Stabil</label>
            </div>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_tidakstabil', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>Tidak Stabil</label>
            </div>
            <div class='controls'>
                <?php echo $form->checkBox($model, 'selesaioperasi_oral', array('class' => 'selesaioperasi_intubasi-anemia')); ?> <label>Oral/Nasal Arway</label>
            </div>
        </div>
    </div>
</div>
