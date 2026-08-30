<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Sumber', 'sumber_riskregister', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'sumber_riskregister', LookupM::getItems("sumber_riskregister"), array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Deskripsi Risiko', 'riskregister_deskripsiresiko', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'riskregister_deskripsiresiko',array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Penyebab', 'riskregister_penyebab', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'riskregister_penyebab',array('class'=>'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tipe / Area Risiko', 'tiperesiko_id', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model,'tiperesiko_id',Chtml::listData(TiperesikoM::model()->findAllByAttributes(array('tiperesiko_aktif'=>true)),'tiperesiko_id','tiperesiko_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Existing Control', 'penelitian_nomor', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textArea($model,'riskregister_deskripsiresiko',array('class'=>'span3')); ?>
            </div>
        </div>
        
    </div>
    <div class="span6">
<!--        <div class="control-group">
            <?php /* echo CHtml::label('Domain', 'penelitian_nomor', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php
                    $criteria = new CDbCriteria();
                    $criteria->select = 'konsekuensi_domain';
                    $criteria->group = $criteria->select;
                    $modKonsekuensi = KonsekuensiM::model()->findAll($criteria);
                ?>
                <?php echo $form->dropDownList($model,'domain_id',
                        Chtml::listData($modKonsekuensi,'konsekuensi_domain','konsekuensi_domain'),
                        array(
                            'class'=>'span3',
                            'empty'=>'-- Pilih --',
                            'ajax' => array('type'=>'POST',
					'url'=> $this->createUrl('getKonsekuensi',
                                                array('encode'=>false,'namaModel'=>get_class($model))), 
					'success'=>'function(data){'
                                . '$("#'.CHtml::activeId($model, "konsekuensi_id").'").html(data);hitungRPN(); }',
				),
                            ));*/ ?>
            </div>
        </div>-->
        <div class="control-group">
            <?php echo CHtml::label('Konsekuensi', 'penelitian_nomor', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'konsekuensi_skor',array('class'=>'span3','value'=>!empty($model->konsekuensi_skor)? $model->konsekuensi_skor : 0)); ?>
                <?php // echo $form->dropDownList($model,'konsekuensi_id',Chtml::listData(KonsekuensiM::model()->findAllByAttributes(array('konsekuensi_aktif'=>true)),'konsekuensi_id','konsekuensi_namabobot'),array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihKonsekuensi(this);return false;')); ?>
                <?php echo $form->dropDownList($model,'konsekuensi_id', RiskregisterM::getDropDownKonsekuensi(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihKonsekuensi(this);loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Peluang', 'penelitian_nomor', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'peluang_skor',array('class'=>'span3','value'=>!empty($model->peluang_skor)? $model->peluang_skor : 0)); ?>
                <?php // echo $form->dropDownList($model,'peluang_id',Chtml::listData(PeluangM::model()->findAllByAttributes(array('peluang_aktif'=>true)),'peluang_id','peluang_descriptor'),array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihPeluang(this);return false;')); ?>
                <?php echo $form->dropDownList($model,'peluang_id', RiskregisterM::getDropDownPeluang(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihPeluang(this);loadTingkatRisiko();return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Detectability', 'penelitian_nomor', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'detectability_skor',array('class'=>'span3','value'=>!empty($model->detectability_skor)? $model->detectability_skor : 0)); ?>
                <?php // echo $form->dropDownList($model,'detectability_id',Chtml::listData(TiperesikoM::model()->findAllByAttributes(array('tiperesiko_aktif'=>true)),'tiperesiko_id','tiperesiko_nama'),array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihDetectability(this);return false;')); ?>
                <?php echo $form->dropDownList($model,'detectability_id', RiskregisterM::getDropDownDetectability(), array('class'=>'span3','empty'=>'-- Pilih --','onchange'=>'pilihDetectability(this);return false;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('RPN', 'riskregister_rpn', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'riskregister_rpn',array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Target RPN', 'riskregister_targetrpn', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'riskregister_targetrpn',array('class'=>'span3 numbers-only')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Risiko', 'tingkatrisiko_nama', array('class' => 'control-label ')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'tingkatrisiko_nama',array('class'=>'span3','readonly'=>true)); ?>
            </div>
        </div>
    </div>
</div>