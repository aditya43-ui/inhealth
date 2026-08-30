<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'satugaspengguna-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php // echo $form->dropDownListRow($model,'peranpengguna_id',CHtml::listData($model->getPeranPengguna(), 'peranpengguna_id', 'peranpenggunanama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --','onchange'=>'cekPengguna(this.value)')); 
        ?>
        <?php echo $form->dropDownListRow($model, 'peranpengguna_id', CHtml::listData($model->getPeranPengguna(), 'peranpengguna_id', 'peranpenggunanama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'tugas_nama', array('placeholder' => 'Nama Tugas', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'tugas_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>

        <div class="control-group">
            <?php echo CHtml::label("", 'tugaspengguna_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'tugaspengguna_aktif', array()); ?>
                <label for="SATugaspenggunaK_tugaspengguna_aktif">Aktif</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow($model, 'keterangan_tugas', array('placeholder' => 'Keterangan Tugas', 'rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Tugas Pemakai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class='table table-bordered table-striped datatable' id="tugasPengguna">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Modul</th>
                    <th>Nama Controller</th>
                    <th>Nama Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->getModul() as $i => $modul) { ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo CHtml::CheckBox('modul', '', array(
                                'value' => $modul->url_modul,
                                'modul_id' => $modul->modul_id,
                                'onclick' => 'tambahController(this)',
                                'id' => $modul->url_modul,
                            )); ?>
                            <?php echo $modul->modul_nama; ?></td>
                        <td id="<?php echo 'row_controller_' . $modul->url_modul; ?>"></td>
                        <td id="<?php echo 'row_action_' . $modul->url_modul; ?>">
                            <?php
                            echo CHtml::CheckBox('checkAllaction_' . $modul->url_modul, '', array(
                                'value' => $modul->modul_nama,
                                'onclick' => 'checkAllActionModule(this)',
                                'class' => 'check_all_action_module',
                            )) . " Pilih Semua";
                            echo "<br>";
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Tugas Pemakai', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>

<?php $this->endWidget(); ?>