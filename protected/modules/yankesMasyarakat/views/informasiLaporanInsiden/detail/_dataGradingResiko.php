<style>
    .alig{
        text-align:left !important;   
    }
</style>
<div class="span6">
    <div class="control-group">

        <?php echo CHtml::label('Tanggal Grading', 'insidenrs_tglinsiden', array('class' => ' control-label required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modGrading,
                'attribute' => 'tgl_gradingunit',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array(
                    'readonly' => true,
                    'disabled' => true,
                    'class' => 'dtPicker2-5 span3 required',
                    'placeholder' => 'Pilih Tanggal Insiden',
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Peluang', 'peluang_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modGrading, 'peluang_id', PeluangM::model()->getListPeluang(), array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'readonly' => true,
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Konsekuensi', 'konsekuensi_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modGrading, 'konsekuensi_id', KonsekuensiM::model()->getListNamaKonsekuensi(), array(
                'empty' => '-- Pilih --',
                'class' => 'span3',
                'readonly' => true,
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Skor Risiko', 'skor_risiko', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textField($modGrading, 'skor_risiko', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tingkat Risiko', 'tingkatrisiko_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->dropDownList($modGrading, 'tingkatrisiko_id', Chtml::listData(TingkatrisikoM::model()->findAllByAttributes(array('tingkatrisiko_aktif' => true)), 'tingkatrisiko_id', 'tingkatrisiko_nama'), array(
                'empty' => '-- Pilih --',
                'class' => 'span3', 'onchange' => 'setTindakan();',
                'readonly' => true,
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Grading Resiko Kejadian', 'grader2', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($modGrading, 'gradingrisiko', array('class' => 'span3 required', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        </div>
    </div>
</div>
<div class="span6">
    <div class="control-group" id="tindakanini">
        <?php echo CHtml::label('Tindakan', 'tindakan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($modGrading, 'tindakan', array('class' => 'span3', 'rows' => 5, 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Tindak Lanjut', 'tindaklanjut', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->textArea($modGrading, 'tindaklanjut', array('class' => 'span3', 'rows' => 4, 'readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Grader ', 'grader1', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $pegawai = ($modGrading->grader1);
            $cekPegawai = PegawaiM::model()->findByPk($pegawai);


            echo $form->textField($modGrading, 'grader1', array('value' => $cekPegawai->namaLengkap, 'class' => 'span3 required', 'disabled' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
            ?>
        </div>
    </div>
</div>

