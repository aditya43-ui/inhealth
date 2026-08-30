<fieldset class="box" id='fieldsetSubKegiatanProgram'>
    <legend class="rim">Tambah Sub Kegiatan Program</legend>
    <span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'form-subkegiatan-program',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)'
        ),
        'focus' => '#',
            )
    );
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <?php echo $form->hiddenField($subKegiatanProgram, 'programkerja_id', array('class' => 'span1')); ?>
    <?php echo $form->hiddenField($subKegiatanProgram, 'subprogramkerja_id', array('class' => 'span1')); ?>
    <?php echo $form->hiddenField($subKegiatanProgram, 'kegiatanprogram_id', array('class' => 'span1')); ?>
    <?php echo $form->hiddenField($subKegiatanProgram, 'subkegiatanprogram_id', array('class' => 'span1')); ?>
    <div class="control-group">
        <label class="control-label required" for="SASubkegiatanprogramM_subkegiatanprogram_kode">Kode&nbsp; <span class="required">*</span></label>
        <div class="controls">
            <?php echo $form->textField($subKegiatanProgram, 'programkerja_kode', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => true)); ?>
            <?php echo $form->textField($subKegiatanProgram, 'subprogramkerja_kode', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => true)); ?>
            <?php echo $form->textField($subKegiatanProgram, 'kegiatanprogram_kode', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => true)); ?>
            <?php echo $form->textField($subKegiatanProgram, 'subkegiatanprogram_kode', array('class' => 'span1 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => false)); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($subKegiatanProgram, 'subkegiatanprogram_nama', array('class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 255, 'readonly' => false)); ?>
    <?php echo $form->textFieldRow($subKegiatanProgram, 'subkegiatanprogram_namalain', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 255, 'readonly' => false)); ?>
    <div class="control-group">
        <label class="control-label required" for="SASubkegiatanprogramM_rekeningdebit_id">Rekening Debit Akutansi&nbsp; <span class="required">*</span></label>
        <div class="controls">
            <?php //echo $form->dropDownList($subKegiatanProgram, 'rekeningdebit_id', CHtml::listData($subKegiatanProgram->RekDebit, 'rekening5_id', 'nmrekening5'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm')); ?>
            <?php echo $form->hiddenField($subKegiatanProgram, 'rekeningdebit_id'); ?>
            <?php
                    $this->widget('MyJuiAutoComplete', array(
                            'model' => $subKegiatanProgram,
                            'attribute' => 'rekeningdebit_nama',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansi'),
                            'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                    $(this).val(ui.item.nmrekening5);
                                                    return false;
                                            }',
                                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.nmrekening5);
                                            $("#SASubkegiatanprogramM_rekeningdebit_id").val(ui.item.rekening5_id);
                                            return false;
                                    }'
                            ),
                            'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder'=>'Nama Rekening',
                                    'class'=>'span3',
                                    'style'=>'width:150px;',
                                    'readonly'=>true,
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                    ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label required" for="SASubkegiatanprogramM_rekeningkredit_id">Rekening Kredit Akutansi&nbsp; <span class="required">*</span></label>
        <div class="controls">
            <?php //echo $form->dropDownList($subKegiatanProgram, 'rekeningkredit_id', CHtml::listData($subKegiatanProgram->RekKredit, 'rekening5_id', 'nmrekening5'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'reqForm')); ?>
            <?php echo $form->hiddenField($subKegiatanProgram, 'rekeningkredit_id'); ?>
            <?php
                    $this->widget('MyJuiAutoComplete', array(
                            'model' => $subKegiatanProgram,
                            'attribute' => 'rekeningkredit_nama',
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/RekeningAkuntansi'),
                            'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                    $(this).val(ui.item.nmrekening5);
                                                    return false;
                                            }',
                                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.nmrekening5);
                                            $("#SASubkegiatanprogramM_rekeningkredit_id").val(ui.item.rekening5_id);
                                            return false;
                                    }'
                            ),
                            'htmlOptions' => array(
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'placeholder'=>'Nama Rekening',
                                    'class'=>'span3',
                                    'style'=>'width:150px;',
                                    'readonly'=>true,
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
                    ));
            ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($subKegiatanProgram, 'subkegiatanprogram_ket', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); ?>
	<?php //if(isset($aktif) && ($aktif == true)){
		echo $form->radioButtonListInlineRow($subKegiatanProgram, 'subkegiatanprogram_aktif', array('Tidak', 'Aktif'), array('onkeypress'=>"return $(this).focusNextInputField(event)"));
//		echo $form->checkBoxRow($subKegiatanProgram,'subkegiatanprogram_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);"));
//	}
	?>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('style' => 'display:none', 'id' => 'reseter', 'class' => 'btn btn-default', 'type' => 'reset'));
        ?>
    </div>

    <?php
    $urlPostData = Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanProgramKerja');
    ?>
</fieldset>
    <script type="text/javascript">
        $('#form-subkegiatan-program').submit(function () {
            var kosong = "";
            var jumlahKosong = $("#fieldsetSubKegiatanProgram").find(".reqForm[value=" + kosong + "]");
            if (jumlahKosong.length > 0) {
                if (requiredCheck($("#form-subkegiatan-program"))){
                    myAlert('Inputan yang bertanda bintang harus diisi, silakan cek kembali!');
                }
            } else {

                $.post("<?php echo $urlPostData; ?>", {data: $(this).serialize()},
                function (data) {
                    if (data.pesan == 'exist') {
                        myAlert('Sub Kegiatan Program telah terdaftar');
                    }

                    if (data.status == 'ok') {
                        myAlert('Sub Kegiatan Program berhasil disimpan');
                        if (data.pesan == 'insert') {
                            $("#reseter").click();
                            $('#fieldsetSubKegiatanProgram').find("input[name$='[programkerja_kode]']").val(data.id_parent.programkerja_kode);
                            $('#fieldsetSubKegiatanProgram').find("input[name$='[subprogramkerja_kode]']").val(data.id_parent.subprogramkerja_kode);
                            $('#fieldsetSubKegiatanProgram').find("input[name$='[kegiatanprogram_kode]']").val(data.id_parent.kegiatanprogram_kode);
                            $('#fieldsetSubKegiatanProgram').find("input[name$='[subkegiatanprogram_kode]']").val(data.id_parent.subkegiatanprogram_kode);
                            // $('#fieldsetSubKegiatanProgram').find("input[name$='[rekeningdebit_nama]']").val(data.id_parent.subkegiatanprogram_kode);
                           
                            $( ".control-group" ).removeClass( "error" );                              
                            $('#SASubkegiatanprogramM_subkegiatanprogram_nama').removeClass("error");
                            $('#SASubkegiatanprogramM_subkegiatanprogram_namalain').removeClass("error");
                            $('#SASubkegiatanprogramM_rekeningdebit_id').removeClass("error");
                            $('#SASubkegiatanprogramM_rekeningkredit_id').removeClass("error");
                        }

                        if (typeof getTreeMenuAnggaran == 'function')
                        {
                            getTreeMenuAnggaran();
                            $.fn.yiiGridView.update('AGRekeninganggaran-v', {});
                        }
                    }
                }, "json"
                        );
            }
            return false;
        });

        function autoInput() {
            var namaSubkegiatanprogram = $('#SASubkegiatanprogramM_subkegiatanprogram_nama').val();

            $('#SASubkegiatanprogramM_subkegiatanprogram_namalain').val(namaSubkegiatanprogram);
        }
    </script>

    <?php $this->endWidget(); ?>