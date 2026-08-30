<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Nomor','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($modSuratStudiLuar, 'jenis_surat', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true)); ?>
                <?php echo $form->textField($modSuratStudiLuar, 'nomorsurat', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Tgl. Checkup','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                    $this->widget('MyDateTimePicker', array(
                    'model' => $modSuratStudiLuar,
                    'attribute' => 'tgl_pemeriksaan',
                    'mode' => 'datetime',
                    'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                    ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('No Passport','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSuratStudiLuar, 'nopasport', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label('Keperluan <span class="required">*</span>','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSuratStudiLuar, 'keperluan', array('class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Koordinator Checkup <span class="required">*</span>' ,'', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($modSuratStudiLuar,'pegawai_id', PegawairuanganV::getDropPegawaiTambah(Yii::app()->user->getState('ruangan_id'), array(), array('p.kelompokpegawai_id'=> Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK)),array('empty' => '-- Pilih --', 'class' => 'span3 required'));
            ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Negara Tujuan <span class="required">*</span>','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modSuratStudiLuar, 'negaratujuan', array('class' => 'span3 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b>Medical History</b></div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_formMedicalHistory', array('form'=>$form , 'modSuratStudiLuar'=>$modSuratStudiLuar)); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b>Phisical Examination</b></div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_formPhisicalExamination', array('form'=>$form , 'modSuratStudiLuar'=>$modSuratStudiLuar)); ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><b>Laboratory Examination</b></div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial('_formLaboratory', array('form'=>$form , 'modSuratStudiLuar'=>$modSuratStudiLuar)); ?>
    </div>
</div>

<div class="row">
    <div class="span12">
        <div class="control-group">
            <?php echo Chtml::label('Check Up Leprosy','', array('class' => 'control-label')) ?>
            <div class='controls'>
                <?php echo $form->checkBox($modSuratStudiLuar, 'checkup_leprosy_positive', array(($modSuratStudiLuar->epilepsi_yes != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Normal</label> 
                <?php echo $form->checkBox($modSuratStudiLuar, 'checkup_leprosy_negative', array('class' => '')); ?> <label>Abnormal</label>                         
            </div>
        </div>
        <div class="control-group">
            <?php echo Chtml::label('Conclusion <span class="required">*</span>','', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($modSuratStudiLuar, 'conclusion', array('class' => 'col-sm-6 required', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
        <div class="span12">
                <div class="form-actions">
                        <?php
                        if(!isset($_GET['sukses'])){
                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')).'&nbsp;';
                                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        }else{
                                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')).'&nbsp;';
                                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info mcu_luar','onclick'=>"printMcuLuar();return false",'disabled'=>FALSE  )).'&nbsp;';
                        }
                        ?>
                        <?php 
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'create','content'=>$content));?>
                </div>
        </div>
</div>