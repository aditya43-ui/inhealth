<fieldset class="box" id='fieldsetSubProgramKerja'>
    <legend class="rim">Tambah Sub Program Kerja</legend>
    <span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'form-subprogram-kerja',
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
    <?php echo $form->hiddenField($subProgramKerja, 'programkerja_id', array('class' => 'span3')); ?>
    <?php echo $form->hiddenField($subProgramKerja, 'subprogramkerja_id', array('class' => 'span3')); ?>
    <div class="control-group">
        <label class="control-label required" for="SASubprogramkerjaM_subprogramkerja_kode">Kode&nbsp; <span class="required">*</span></label>
        <div class="controls">
            <?php echo $form->textField($subProgramKerja, 'programkerja_kode', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => true)); ?>
            <?php echo $form->textField($subProgramKerja, 'subprogramkerja_kode', array('class' => 'span1 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => false)); ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($subProgramKerja, 'subprogramkerja_nama', array('class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 255, 'readonly' => false)); ?>
    <?php echo $form->textFieldRow($subProgramKerja, 'subprogramkerja_namalain', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 255, 'readonly' => false)); ?>
    <?php echo $form->textAreaRow($subProgramKerja, 'subprogramkerja_ket', array('class' => 'span4 ', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); ?>
	<?php //if(isset($aktif) && ($aktif == true)){
		echo $form->radioButtonListInlineRow($subProgramKerja, 'subprogramkerja_aktif', array('Tidak', 'Aktif'), array('onkeypress'=>"return $(this).focusNextInputField(event)"));
//		echo $form->checkBoxRow($subProgramKerja,'subprogramkerja_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);"));
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
        $('#form-subprogram-kerja').submit(function () {
            var kosong = "";
            var jumlahKosong = $("#fieldsetSubProgramKerja").find(".reqForm[value=" + kosong + "]");
            if (jumlahKosong.length > 0) {
                if(requiredCheck($("#form-subprogram-kerja"))){
                    myAlert('Inputan bertanda <span style = "color:red;">*</span> harap di isi !!');
                }
            } else {
                $.post("<?php echo $urlPostData; ?>", {data: $(this).serialize()},
                function (data) {
                    if (data.pesan == 'exist') {                        
                        myAlert('Kode Sub Program Kerja telah terdaftar');                        
                    }

                    if (data.status == 'ok') {
                        
                        myAlert('Sub Program Kerja berhasil disimpan');                        
                        if (data.pesan == 'insert') {                           
                            $("#reseter").click();
                            $('#fieldsetSubProgramKerja').find("input[name$='[programkerja_kode]']").val(data.id_parent.programkerja_kode);
                            $('#fieldsetSubProgramKerja').find("input[name$='[subprogramkerja_kode]']").val(data.id_parent.subprogramkerja_kode);                            
                            
                            $( ".control-group" ).removeClass( "error" );                              
                            $('#SASubprogramkerjaM_subprogramkerja_nama').removeClass("error");
                            $('#SASubprogramkerjaM_subprogramkerja_namalain').removeClass("error");                                                        
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
            var namaSubProgramKerja = $('#SASubprogramkerjaM_subprogramkerja_nama').val();

            $('#SASubprogramkerjaM_subprogramkerja_namalain').val(namaSubProgramKerja);
        }
    </script>

    <?php $this->endWidget(); ?>