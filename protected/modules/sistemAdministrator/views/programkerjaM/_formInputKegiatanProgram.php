<fieldset class="box" id='fieldsetKegiatanProgram'>
    <legend class="rim">Tambah Kegiatan Program</legend>
    <span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
    <?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'form-kegiatan-program',
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
    <?php echo $form->hiddenField($kegiatanProgram, 'programkerja_id', array('class' => 'span1')); ?>
    <?php echo $form->hiddenField($kegiatanProgram, 'subprogramkerja_id', array('class' => 'span1')); ?>
    <?php echo $form->hiddenField($kegiatanProgram, 'kegiatanprogram_id', array('class' => 'span1')); ?>
    <div class="control-group">
        <label class="control-label required" for="SASubprogramkerjaM_kegiatanprogram_kode">Kode&nbsp; <span class="required">*</span></label>
        <div class="controls">
            <?php echo $form->textField($kegiatanProgram, 'programkerja_kode', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => true)); ?>
            <?php echo $form->textField($kegiatanProgram, 'subprogramkerja_kode', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => true)); ?>
            <?php echo $form->textField($kegiatanProgram, 'kegiatanprogram_kode', array('class' => 'span1 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 5, 'readonly' => false)); ?>
        </div>
    </div>	
    <?php echo $form->textFieldRow($kegiatanProgram, 'kegiatanprogram_nama', array('class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 255, 'readonly' => false)); ?>
    <?php echo $form->textFieldRow($kegiatanProgram, 'kegiatanprogram_namalain', array('class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 255, 'readonly' => false)); ?>
    <?php echo $form->textAreaRow($kegiatanProgram, 'kegiatanprogram_ket', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); ?>
	<?php //if(isset($aktif) && ($aktif == true)){
		echo $form->radioButtonListInlineRow($kegiatanProgram, 'kegiatanprogram_aktif', array('Tidak', 'Aktif'), array('onkeypress'=>"return $(this).focusNextInputField(event)"));
//		echo $form->checkBoxRow($kegiatanProgram,'kegiatanprogram_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);"));
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
        $('#form-kegiatan-program').submit(function () {
            var kosong = "";
            var jumlahKosong = $("#fieldsetKegiatanProgram").find(".reqForm[value=" + kosong + "]");
            if (jumlahKosong.length > 0) {
                if(requiredCheck($("#form-kegiatan-program")))
                {    
                    myAlert('Inputan yang bertanda bintang harus diisi, silakan cek kembali!');
                }
            } else {

                $.post("<?php echo $urlPostData; ?>", {data: $(this).serialize()},
                function (data) {
                    if (data.pesan == 'exist') {
                        myAlert('Kode Kegiatan Program telah terdaftar');
                    }

                    if (data.status == 'ok') {
                        //if (requiredCheck($("#")){
                            myAlert('Kegiatan Program berhasil disimpan');
                        //}
                        if (data.pesan == 'insert') {
                            $("#reseter").click();
                            $('#fieldsetKegiatanProgram').find("input[name$='[programkerja_kode]']").val(data.id_parent.programkerja_kode);
                            $('#fieldsetKegiatanProgram').find("input[name$='[subprogramkerja_kode]']").val(data.id_parent.subprogramkerja_kode);
                            $('#fieldsetKegiatanProgram').find("input[name$='[kegiatanprogram_kode]']").val(data.id_parent.kegiatanprogram_kode);
                            
                            $( ".control-group" ).removeClass( "error" );                              
                            $('#SAKegiatanprogramM_kegiatanprogram_nama').removeClass("error");
                            $('#SAKegiatanprogramM_kegiatanprogram_namalain').removeClass("error");                                                        
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
            var namaKegiatanProgram = $('#SAKegiatanprogramM_kegiatanprogram_nama').val();

            $('#SAKegiatanprogramM_kegiatanprogram_namalain').val(namaKegiatanProgram);
        }
    </script>

    <?php $this->endWidget(); ?>