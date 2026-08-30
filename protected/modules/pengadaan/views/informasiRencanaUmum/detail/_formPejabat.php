
<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'pegawaipa_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $pegawaipa_id = '';
                $cekPegawai = PegawaiM::model()->findByPk($model->pegawaipa_id);
                if(!empty($cekPegawai)){
                    $pegawaipa_id = $cekPegawai->namaLengkap;
                }
                $model->pegawaipa_nama = $pegawaipa_id;
                echo $form->hiddenField($model, 'pegawaipa_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'pegawaipa_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'pegawaikpa_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $pegawaikpa_id = '';
                $cekPegawai = PegawaiM::model()->findByPk($model->pegawaikpa_id);
                if(!empty($cekPegawai)){
                    $pegawaikpa_id = $cekPegawai->namaLengkap;
                }
                $model->pegawaikpa_nama = $pegawaikpa_id;
                echo $form->hiddenField($model, 'pegawaikpa_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'pegawaikpa_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'pegawaippk_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $pegawaippk_id = '';
                $cekPegawai = PegawaiM::model()->findByPk($model->pegawaippk_id);
                if(!empty($cekPegawai)){
                    $pegawaippk_id = $cekPegawai->namaLengkap;
                }
                $model->pegawaippk_nama = $pegawaippk_id;
                echo $form->hiddenField($model, 'pegawaippk_id', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                echo $form->textField($model, 'pegawaippk_nama', array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
            </div>
        </div>
    </div>
</div>