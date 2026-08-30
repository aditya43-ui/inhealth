<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal Grading ', 'tgl_gradingunit', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php   
                    $this->widget('MyDateTimePicker',array(
                            'model'=>$grading,
                            'attribute'=>'tgl_gradingunit',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'changeYear' => false,
                            ),
                            'htmlOptions'=>array('disabled' => true, 'class'=>'dtPicker2 span3','onkeyup' => "return $(this).focusNextInputField(event)"),

            )); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Peluang', 'peluang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($grading,'peluang_id',
                        Chtml::listData(PeluangM::model()->findAllByAttributes(array('peluang_aktif' => true)),'peluang_id','peluang_descriptor'), array(
                                    'empty'=>'-- Pilih --',
                                    'class'=>'span3', 
                                    'disabled' => true,
                                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Konsekuensi', 'konsekuensi_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($grading,'konsekuensi_id',
                        Chtml::listData(KonsekuensiM::model()->findAllByAttributes(array('konsekuensi_aktif' => true)),'konsekuensi_id','konsekuensi_namabobot'), array(
                                    'empty'=>'-- Pilih --',
                                    'class'=>'span3', 
                                    'disabled' => true,
                                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Skor Risiko', 'skor_risiko', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($grading, 'skor_risiko', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tingkat Risiko', 'tingkatrisiko_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($grading,'tingkatrisiko_id', Chtml::listData(TingkatrisikoM::model()->findAllByAttributes(array('tingkatrisiko_aktif' => true)),'tingkatrisiko_id','tingkatrisiko_nama'), array(
                                    'empty'=>'-- Pilih --',
                                    'class'=>'span3', 
                                    'disabled' => true,
                                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Grading Risiko Kejadian','gradingrisiko',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->dropDownList($grading, 'regradingrisiko', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'tingkatwarna_risiko')), 'lookup_value', 'lookup_name'), array('class' => 'span3', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label('Tindakan', 'tindakan', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($grading,'tindakan',array('class'=>'span3', 'disabled' => true, 'rows'=>5)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tindak Lanjut', 'tindaklanjut', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($grading,'tindaklanjut',array('class'=>'span3', 'disabled' => true, 'rows'=>5)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Grader','grader2',array('class'=>'control-label'));?>
            <div class="controls">
                <?php
                    $cekPegawai = PegawaiM::model()->findByPk($grading->grader1);
                    if (!empty($grading->grader2)) {
                        $cekPegawai = PegawaiM::model()->findByPk($grading->grader2);
                    }
                    echo $form->textField($cekPegawai, 'namaLengkap', array('class' => 'span3', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
</div>