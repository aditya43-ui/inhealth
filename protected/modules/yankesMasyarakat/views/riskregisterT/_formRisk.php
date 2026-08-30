<div class="row-fluid">
    <div class="span6">
        <h6>&nbsp;</h6>
<!--        <div class="control-group">
            <?php /*echo CHtml::label('Risiko Diterima', 'penelitian_nomor', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                    echo $form->radioButtonList($model, 'riskregister_resikoditerima',
                                       array(  1 => 'Ya',
                                               0 => 'Tidak', ),
                                      array(
                       'labelOptions'=>array('style'=>'display:inline'), // add this code
                       'separator'=>'',
                   ) );*/
                ?> 
            </div>
        </div>-->
        <div class="control-group">
            <?php echo CHtml::label('Evaluasi Risiko', 'evaluasi_risiko', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'evaluasi_risiko', LookupM::getItems("evaluasi_risiko"), array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penanggungjawab Risiko', 'jabatan_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php // echo $form->dropDownList($model,'jabatan_id',Chtml::listData(JabatanM::model()->findAllByAttributes(array('jabatan_aktif'=>true)),'jabatan_id','jabatan_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
                <?php echo $form->textField($model,'penanggungjawab',array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Mulai', 'riskregister_tanggalmulai', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'riskregister_tanggalmulai',
                            'mode'=>'date',
                            'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'changeYear' => false,
                            ),
                            'htmlOptions'=>array('class'=>'dtPicker2 span3','onkeyup' => "return $(this).focusNextInputField(event)",'readonly'=>true),

            )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Tinjauan', 'riskregister_tanggaltinjauan', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'riskregister_tanggaltinjauan',
                            'mode'=>'date',
                            'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'changeYear' => false,
                            ),
                            'htmlOptions'=>array('class'=>'dtPicker2 span3','onkeyup' => "return $(this).focusNextInputField(event)",'readonly'=>true),

            )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Risk Response and Action Plan', 'riskregister_riskresponse', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'riskregister_riskresponse',array('class'=>'span3')); ?>
            </div>
        </div>
        
    </div>
    <div class="span6">
        <h6><b>Progress-Laporan Monev</b></h6>
        <div class="control-group">
            <?php echo CHtml::label('Konsekuensi', 'konsekuensi_rpnsisa_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'konsekuensi_skor_rpnsisa',array('class'=>'span3','value'=>!empty($model->konsekuensi_skor_rpnsisa)? $model->konsekuensi_skor_rpnsisa : 0)); ?>
                <?php echo $form->dropDownList($model,'konsekuensi_rpnsisa_id', RiskregisterM::getDropDownKonsekuensi(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihKonsekuensiSisa(this);return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Peluang', 'peluang_rpnsisa_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'peluang_skor_rpnsisa',array('class'=>'span3','value'=>!empty($model->peluang_skor_rpnsisa)? $model->peluang_skor_rpnsisa : 0)); ?>
                <?php echo $form->dropDownList($model,'peluang_rpnsisa_id', RiskregisterM::getDropDownPeluang(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihPeluangSisa(this);return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Detectability', 'detectability_rpnsisa_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'detectability_skor_rpnsisa',array('class'=>'span3','value'=>!empty($model->detectability_skor_rpnsisa)? $model->detectability_skor_rpnsisa : 0)); ?>
                <?php echo $form->dropDownList($model,'detectability_rpnsisa_id', RiskregisterM::getDropDownDetectability(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihDetectabilitySisa(this);return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('RPN Sisa', 'riskregister_rpnsisa', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'riskregister_rpnsisa',array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Laporan Singkat', 'laporansingkat', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'laporansingkat',array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status', 'status_riskregister', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'status_riskregister', LookupM::getItems("status_riskregister"), array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>