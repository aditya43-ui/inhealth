<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> <span id="pnl_judul">Tambah</span> <b>Akun</b>
        </div>
    </div>
    <div class="panel-body" id="fieldsetDetailObyekRekening">
        <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js');
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'id' => 'form-detail-obyek-rekening',
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
            <div class="col-sm-12">
                <?php //echo $form->hiddenField($model, 'rekening4_id', array('class' => 'span1')); 
                ?>
                <?php echo $form->hiddenField($model, 'rekening5_id', array('class' => 'span1')); ?>
                <?php echo $form->hiddenField($model, 'parent_id', array('class' => 'span3', 'readonly' => true)); ?>
                <?php //echo $form->textFieldRow($model, 'parent_nmrekening5', array('class' => 'span3','readonly'=>true)); 
                ?>
                <div class="control-group">
                    <label class="control-label">Rekening Induk</label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'parent_nmrekening5', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required" for="AKRekening5M_levelrek">Level Rekening <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'levelrek', array('class' => 'span3 reqForm integer numbers-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => true)); ?><a href="#" data-toggle="tooltip" title="Level diisikan berdasarkan posisi induk dan anak pada COA"><i class="fa fa-info-circle"></i></a>
                    </div>
                </div>
                <?php echo $form->dropDownListRow($model, 'kelrekening_id', CHtml::listData(KelrekeningM::model()->findAll("kelrekening_aktif =  TRUE ORDER BY kelrekening_id ASC"), 'kelrekening_id', 'namakelrekening'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
                <div class="control-group">
                    <label class="control-label required" for="AKRekening5M_kdrekening5">Kode Akun <span class="required">*</span></label>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kdrekening5', array('placeholder' => 'Kode AKun', 'class' => 'numbers-only integer span3', 'onkeypress integer numbers-only' => "return $(this).focusNextInputField(event)", 'maxlength' => 50, 'readonly' => false)); ?>
                    </div>
                </div>

                <?php echo $form->textFieldRow($model, 'nmrekening5', array('placeholder' => 'Nama Akun', 'class' => 'span3 reqForm', 'onkeyup' => 'autoInput();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 500, 'readonly' => false)); ?>
                <?php //echo $form->textFieldRow($model, 'nourutrek', array('placeholder' => 'No. Urut', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 6, 'readonly' => false)); 
                ?>

                <?php echo $form->textFieldRow($model, 'nmrekeninglain5', array('placeholder' => 'Nama Lain', 'class' => 'span3 reqForm', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 500, 'readonly' => false)); ?>

                <?php echo $form->hiddenField($model, 'rekening5_nb',  array('class' => 'rekening5_nb_hidden rekening5_nb', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($model, 'rekening5_nb', LookupM::getItems('jenis_rekening'), array('class' => 'rekening5_nb_select rekening5_nb span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                if (strtolower($model->keterangan) == 'null') {
                    $model->keterangan = null;
                }
                echo $form->textAreaRow($model, 'keterangan', array('placeholder' => 'Keterangan', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); ?>
                <?php echo $form->dropDownListRow($model, 'tiperekening_id', TiperekeningM::items(), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->radioButtonListInlineRow($model, 'rekening5_aktif', array('Tidak', 'Aktif'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
            <!-- <div class="col-sm-6">







            </div> -->
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
            $('#form-detail-obyek-rekening').submit(function() {
                var kosong = "";

                var jumlahKosong = $("#fieldsetDetailObyekRekening").find(".reqForm[value='']");

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
                                myAlert('Kode rekening harus 10 Karakter');
                            }

                            if (data.status == 'ok') {
                                myAlert('Rekening berhasil disimpan!');
                                refreshTree();
                                if (data.pesan == 'insert') {
                                    $("#reseter").click();
                                    $('#fieldsetDetailObyekRekening').find("input[name$='[kdrekening5]']").val(data.id_parent.kdrekening5);
                                    $('#fieldsetDetailObyekRekening').find("select[name$='[rekening5_nb]']").val(data.id_parent.saldonormal);
                                }
                                //getTreeMenu();
                                window.location.reload();

                                $.fn.yiiGridView.update('AKRekeningakuntansi-v', {});

                            }
                        }, "json"
                    );
                }
                return false;
            });

            function autoInput() {
                var namaRekening = $('#AKRekening5M_nmrekening5').val();

                $('#AKRekening5M_nmrekeninglain5').val(namaRekening);
            }
        </script>

        <?php $this->endWidget(); ?>
    </div>
</div>