<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Unsur</b>
        </div>
    </div>
    <div class="panel-body" id="fieldsetRekeningDua">
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'id' => 'form-rekening-dua',
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
                <?php echo $form->hiddenField($rekeningDua, 'rekening1_id', array('class' => 'span3')); ?>
                <?php echo $form->hiddenField($rekeningDua, 'rekening2_id', array('class' => 'span3')); ?>
                <div class="control-group">
                    <label class="control-label required" for="AKRekening2M_kdrekening2">Kode Akun&nbsp; <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo $form->textField($rekeningDua, 'kdrekening2', array('placeholder' => 'Kode Akun', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => false)); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($rekeningDua, 'nmrekening2', array('placeholder' => 'Nama AKun', 'class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200, 'readonly' => false)); ?>
                <?php echo $form->textFieldRow($rekeningDua, 'nmrekeninglain2', array('placeholder' => 'Nama Lain', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 200, 'readonly' => false)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->hiddenField($rekeningDua, 'rekening2_nb', array('class' => 'rekening2_nb_hidden rekening2_nb', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($rekeningDua, 'rekening2_nb', LookupM::getItems('jenis_rekening'), array('class' => 'rekening2_nb_select rekening2_nb span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->radioButtonListInlineRow($rekeningDua, 'rekening2_aktif', array('Tidak', 'Aktif'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
        </fieldset>
        <script type="text/javascript">
            $('#form-rekening-dua').submit(function() {
                var kosong = "";
                var jumlahKosong = $("#fieldsetRekeningDua").find(".reqForm[value=" + kosong + "]");
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
                                myAlert('Kode rekening harus 4 Karakter');
                            }

                            if (data.status == 'ok') {
                                myAlert('Rekening berhasil disimpan!');
                                refreshTree();
                                if (data.pesan == 'insert') {
                                    $("#reseter").click();
                                    $('#fieldsetRekeningDua').find("input[name$='[kdrekening2]']").val(data.id_parent.kdrekening2);
                                }

                                //if (typeof getTreeMenu == 'function')
                                //{
                                //    getTreeMenu();
                                $.fn.yiiGridView.update('AKRekeningakuntansi-v', {});
                                //}

                            }
                        }, "json"
                    );
                }
                return false;
            });

            function autoInput() {
                var namaRekening = $('#AKRekening2M_nmrekening2').val();

                $('#AKRekening2M_nmrekeninglain2').val(namaRekening);
            }
        </script>

        <?php $this->endWidget(); ?>
    </div>
</div>