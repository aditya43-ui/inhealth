<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Komponen</b>
        </div>
    </div>
    <div class="panel-body" id="fieldsetRekeningSatu">
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'id' => 'form-rekening-satu',
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
                <?php echo $form->hiddenField($rekeningSatu, 'rekening1_id', array('class' => 'span3')); ?>
                <?php //echo $form->textField($rekeningSatu, 'parent_id', array('class' => 'span3','disabled'=>true)); 
                ?>
                <?php echo $form->dropDownListRow($rekeningSatu, 'kelrekening_id', CHtml::listData(KelrekeningM::model()->findAll("kelrekening_aktif =  TRUE ORDER BY namakelrekening ASC"), 'kelrekening_id', 'namakelrekening'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <?php echo $form->textFieldRow($rekeningSatu, 'kdrekening1', array('placeholder' => 'Kode Akun', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 6, 'readonly' => false)); ?>
                <?php echo $form->textFieldRow($rekeningSatu, 'nmrekening1', array('placeholder' => 'Nama Akun', 'class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => false)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($rekeningSatu, 'nmrekeninglain1', array('placeholder' => 'Nama Lain', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'readonly' => false)); ?>
                <?php echo $form->hiddenField($rekeningSatu, 'rekening1_nb', array('class' => 'rekening1_nb_hidden rekening1_nb', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($rekeningSatu, 'rekening1_nb', LookupM::getItems('jenis_rekening'), array('class' => 'rekening1_nb_select rekening1_nb span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->radioButtonListInlineRow($rekeningSatu, 'rekening1_aktif', array('Tidak', 'Aktif'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
            $('#form-rekening-satu').submit(function() {
                var kosong = "";
                var jumlahKosong = $("#fieldsetRekeningSatu").find(".reqForm[value=" + kosong + "]");
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
                                myAlert('Kode rekening harus 2 Karakter');
                            }

                            if (data.status == 'ok') {
                                myAlert('Rekening berhasil disimpan!');
                                refreshTree();
                                if (data.pesan == 'insert') {
                                    $("#reseter").click();
                                    $('#fieldsetRekeningSatu').find("input[name$='[kdrekening1]']").val(data.id_parent.kdrekening1);
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
                var namaRekening = $('#AKRekening1M_nmrekening1').val();

                $('#AKRekening1M_nmrekeninglain1').val(namaRekening);
            }
        </script>

        <?php $this->endWidget(); ?>
    </div>
</div>