<fieldset class="box" id='fieldsetProgramKerja'>
    <legend class="rim">Tambah Program Kerja</legend>
    <span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'form-program-kerja',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)'
        ),
        'focus' => '#' . CHtml::activeId($programKerja, 'programkerja_nama'),
            )
    );
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <?php echo $form->hiddenField($programKerja, 'programkerja_id', array('class' => 'span3')); ?>
    <?php echo $form->textFieldRow($programKerja, 'programkerja_kode', array('class' => 'span1 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 5, 'readonly' => false)); ?>
    <?php echo $form->textFieldRow($programKerja, 'programkerja_nama', array('class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 255, 'readonly' => false)); ?>
    <?php echo $form->textFieldRow($programKerja, 'programkerja_namalain', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 255, 'readonly' => false)); ?>
    <?php echo $form->textAreaRow($programKerja, 'programkerja_ket', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); ?>
	<?php //if(isset($aktif) && ($aktif == true)){
		echo $form->radioButtonListInlineRow($programKerja, 'programkerja_aktif', array('Tidak', 'Aktif'), array('onkeypress'=>"return $(this).focusNextInputField(event)"));
///		echo $form->checkBoxRow($programKerja,'programkerja_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);"));
	//}
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
        $('#form-program-kerja').submit(function () {
            var kosong = "";
            var jumlahKosong = $("#fieldsetProgramKerja").find(".reqForm[value=" + kosong + "]");
            if (jumlahKosong.length > 0) {
                if(requiredCheck($("#form-program-kerja"))){
                    myAlert('Inputan bertanda <span style = "color:red;">*</span> harap di isi !!');
                }
            } else {

                $.post("<?php echo $urlPostData; ?>", {data: $(this).serialize()},
                function (data) {
                    if (data.pesan == 'exist') {
                        myAlert('Program Kerja telah terdaftar');
                    }

                    if (data.status == 'ok') {                         
                        myAlert('Program Kerja berhasil disimpan');                                                                                                     
                                                
                        if (data.pesan == 'insert') {                            
                             tambahProgramKerja(this);
                            $("#reseter").click();
                            $('#fieldsetProgramKerja').find("input[name$='[programkerja_kode]']").val(data.id_parent.programkerja_kode);
                            
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
            var namaProgramKerja = $('#SAProgramkerjaM_programkerja_nama').val();

            $('#SAProgramkerjaM_programkerja_namalain').val(namaProgramKerja);
        }
		
    </script>

    <?php $this->endWidget(); ?>