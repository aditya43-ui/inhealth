<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Kelompok Pos</b>
        </div>
    </div>
    <div class="panel-body" id="fieldsetJenisRekening">
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'id' => 'form-jenis-rekening',
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

        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->hiddenField($jenisRekening, 'rekening2_id', array('class' => 'span1')); ?>
                <?php echo $form->hiddenField($jenisRekening, 'rekening3_id', array('class' => 'span1')); ?>
                <div class="control-group">
                    <label class="control-label required" for="AKRekening2M_kdrekening3">Kode Akun&nbsp; <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo $form->textField($jenisRekening, 'kdrekening3', array('placeholder' => 'Kode Akun', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => false)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($jenisRekening, 'nmrekening3', array('placeholder' => 'Nama Akun', 'class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 300, 'readonly' => false)); ?>
                <?php echo $form->textFieldRow($jenisRekening, 'nmrekeninglain3', array('placeholder' => 'Nama Lain', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 300, 'readonly' => false)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->hiddenField($jenisRekening, 'rekening3_nb', array('class' => 'rekening3_nb_hidden rekening3_nb', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($jenisRekening, 'rekening3_nb', LookupM::getItems('jenis_rekening'), array('class' => 'rekening3_nb_select rekening3_nb span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->radioButtonListInlineRow($jenisRekening, 'rekening3_aktif', array('Tidak', 'Aktif'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), array('style' => 'display:none', 'id' => 'reseter', 'class' => 'btn btn-default', 'type' => 'reset'));
            ?>
        </div>

        <?php
        $urlPostData = Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanRekening');
        ?>

        <script type="text/javascript">
            $('#form-jenis-rekening').submit(function() {
                var kosong = "";
                var jumlahKosong = $("#fieldsetJenisRekening").find(".reqForm[value=" + kosong + "]");
                if (jumlahKosong.length > 0) {
                    myAlert('Inputan yang bertanda bintang harus diisi, silakan cek kembali!');
                } else {

                    $.post("<?php echo $urlPostData; ?>", {
                            data: $(this).serialize()
                        },
                        function(data) {
                            if (data.pesan == 'exist') {
                                myAlert('Kode rekening telah terdaftar!');
                                refreshTree();
                            } else if (data.pesan == 'kode') {
                                myAlert('Kode rekening harus 6 Karakter');
                            }

                            if (data.status == 'ok') {
                                myAlert('Rekening berhasil disimpan!');
                                refreshTree();
                                if (data.pesan == 'insert') {
                                    $("#reseter").click();
                                    $('#fieldsetJenisRekening').find("input[name$='[kdrekening3]']").val(data.id_parent.kdrekening3);
                                }
                                //getTreeMenu();
                                $.fn.yiiGridView.update('AKRekeningakuntansi-v', {});
                            }
                        }, "json"
                    );
                }
                return false;
            });

            function autoInput() {
                var namaRekening = $('#AKRekening3M_nmrekening3').val();

                $('#AKRekening3M_nmrekeninglain3').val(namaRekening);
            }
        </script>

        <?php $this->endWidget(); ?>
    </div>
</div>