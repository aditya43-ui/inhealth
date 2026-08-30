<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'jnspembayar-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return cekValidasi() && requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jnspembayar_nama', array('placeholder' => 'Nama Jenis Pembayaran', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'jnspembayar_namalain', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'jatuhtempo', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jatuhtempo', array('placeholder' => '00', 'class' => 'span1 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <label> Hari</label>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'jnspembayar_cp', array('placeholder' => 'Pembayaran CP', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'jnspembayar_nomobile', array('placeholder' => 'Pembayaran No. Mobile', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <label class="control-label">Jenis Pembayaran</label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'jnspembayar_aktif'); ?>
                <label for="JnspembayarM_jnspembayar_aktif">Aktif</label>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ispiutangbank'); ?>
                <label for="JnspembayarM_ispiutangbank">Piutang Bank</label>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <?php echo $form->checkBox($model, 'ispembayarandigital'); ?>
                <label for="JnspembayarM_ispembayarandigital">Pembayaran Digital</label>
            </div>
        </div>

    </div>
</div>
<br>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-money-bill"></i> Bank & Rekening Jenis Pembayaran
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php
                $bank_data = BankM::model()->findAllByAttributes(array('bank_aktif' => true, 'ispenerimaan' => true));

                echo $form->dropDownListRow(
                    $rekD,
                    'bank_id',
                    CHtml::listData($bank_data, 'bank_id', 'bankDanAtasNama'),
                    array('empty' => '-- Pilih --', 'class' => 'span3 bank_id', 'onkeyup' => "return $(this).focusNextInputField(event);")
                );
                ?>
                <div class="control-group">
                    <label class="control-label"></label>
                    <div class="controls">
                        <?php echo CHtml::htmlButton('+ Tambah', array(
                            'class' => 'btn btn-primary',
                            'onclick' => 'tambahRekening();',
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group rekening_debit">
                    <?php echo $form->label($rekD, 'rekening5_id', array('class' => 'control-label', 'label' => 'Rekening Debit <span style="color: red">*</span>')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($rekD, '[D]rekening1_id', array('class' => 'rekening1_id')); ?>
                        <?php echo $form->hiddenField($rekD, '[D]rekening2_id', array('class' => 'rekening2_id')); ?>
                        <?php echo $form->hiddenField($rekD, '[D]rekening3_id', array('class' => 'rekening3_id')); ?>
                        <?php echo $form->hiddenField($rekD, '[D]rekening4_id', array('class' => 'rekening4_id')); ?>
                        <?php echo $form->hiddenField($rekD, '[D]rekening5_id', array('class' => 'rekening5_id')); ?>
                        <?php

                        $nama_rekening = "";
                        if (!empty($rekD->rekening5_id)) {
                            $rek = Rekening5M::model()->findByPk($rekD->rekening5_id);
                            if (!empty($rek)) {
                                $nama_rekening = $rek->nmrekening5;
                            }
                        }

                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'nama_debit',
                            'value' => $nama_rekening,
                            'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/RekeningAkuntansiDebit'),
                            'options' => array(
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nmrekening5);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    console.log(ui.item);
                                    $(this).val(ui.item.kdrekening5 + \'-\' + ui.item.nmrekening5);
                                    $(".rekening_debit .rekening1_id").val(ui.item.rekening1_id);
                                    $(".rekening_debit .rekening2_id").val(ui.item.rekening2_id);
                                    $(".rekening_debit .rekening3_id").val(ui.item.rekening3_id);
                                    $(".rekening_debit .rekening4_id").val(ui.item.rekening4_id);
                                    $(".rekening_debit .rekening5_id").val(ui.item.rekening5_id);
                                    return false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Nama Rekening',
                                'class' => 'span3 nama_debit',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekDebit',),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group rekening_kredit">
                    <?php echo $form->label($rekK, 'rekening5_id', array('class' => 'control-label', 'label' => 'Rekening Kredit <span style="color: red">*</span>')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($rekK, '[K]rekening1_id', array('class' => 'rekening1_id')); ?>
                        <?php echo $form->hiddenField($rekK, '[K]rekening2_id', array('class' => 'rekening2_id')); ?>
                        <?php echo $form->hiddenField($rekK, '[K]rekening3_id', array('class' => 'rekening3_id')); ?>
                        <?php echo $form->hiddenField($rekK, '[K]rekening4_id', array('class' => 'rekening4_id')); ?>
                        <?php echo $form->hiddenField($rekK, '[K]rekening5_id', array('class' => 'rekening5_id')); ?>
                        <?php

                        $nama_rekening = "";
                        if (!empty($rekK->rekening5_id)) {
                            $rek = Rekening5M::model()->findByPk($rekK->rekening5_id);
                            if (!empty($rek)) {
                                $nama_rekening = $rek->nmrekening5;
                            }
                        }

                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'nama_kredit',
                            'value' => $nama_rekening,
                            'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/RekeningAkuntansiDebit'),
                            'options' => array(
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.nmrekening5);
                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                    $(this).val(ui.item.kdrekening5 + \'-\' + ui.item.nmrekening5);
                                    $(".rekening_kredit .rekening1_id").val(ui.item.rekening1_id);
                                    $(".rekening_kredit .rekening2_id").val(ui.item.rekening2_id);
                                    $(".rekening_kredit .rekening3_id").val(ui.item.rekening3_id);
                                    $(".rekening_kredit .rekening4_id").val(ui.item.rekening4_id);
                                    $(".rekening_kredit .rekening5_id").val(ui.item.rekening5_id);
                                    return false;
                                }'
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'placeholder' => 'Nama Rekening',
                                'class' => 'span3 nama_kredit',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogRekKredit',),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Nama Bank</th>
                    <th>Rekening Debit</th>
                    <th>Rekening Kredit</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody id="tab_detail_rekening">
                <?php
                $rek = array();
                if (!$model->isNewRecord) {
                    $rek = JnspembrekM::model()->findAllByAttributes(array(
                        'jnspembayar_id' => $model->jnspembayar_id
                    ));
                }

                $rek2 = array();
                foreach ($rek as $idx => $item) {
                    if (empty($rek2["bank_" . $item->bank_id])) {
                        $rek2["bank_" . $item->bank_id] = array();
                    }
                    $rek2["bank_" . $item->bank_id][$item->debitkredit] = $item;
                }

                $idx = 0;
                foreach ($rek2 as $idx => $item) {
                    echo $this->renderPartial($this->path_view . "_rowRekening", array(
                        'rekD' => empty($item['D']) ? new JnspembrekM : $item['D'],
                        'rekK' => empty($item['K']) ? new JnspembrekM : $item['K'],
                        'i' => $idx,
                    ), true);
                    $idx++;
                } ?>
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
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jenis Pembayaran', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
$row = CJSON::encode(array('html' => $this->renderPartial($this->path_view . "_rowRekening", array(
    'rekD' => $rekD,
    'rekK' => $rekK,
    'i' => 'ii',
), true)));
?>
<script>
    var row = <?php echo $row; ?>;

    function tambahRekening() {

        var bank_id = $(".bank_id").val();
        var bank_nama = $(".bank_id :selected").html();

        if (bank_id == "") {
            bank_nama = "-";
        }

        var d_rekening1_id = $(".rekening_debit .rekening1_id").val();
        var d_rekening2_id = $(".rekening_debit .rekening2_id").val();
        var d_rekening3_id = $(".rekening_debit .rekening3_id").val();
        var d_rekening4_id = $(".rekening_debit .rekening4_id").val();
        var d_rekening5_id = $(".rekening_debit .rekening5_id").val();
        var d_rekening5_nama = $(".rekening_debit .nama_debit").val();

        var k_rekening1_id = $(".rekening_kredit .rekening1_id").val();
        var k_rekening2_id = $(".rekening_kredit .rekening2_id").val();
        var k_rekening3_id = $(".rekening_kredit .rekening3_id").val();
        var k_rekening4_id = $(".rekening_kredit .rekening4_id").val();
        var k_rekening5_id = $(".rekening_kredit .rekening5_id").val();
        var k_rekening5_nama = $(".rekening_kredit .nama_kredit").val();

        if ((d_rekening5_id == "") || (k_rekening5_id == "")) {
            myAlert("Rekening debit dan kredit harus diisi");
            return false;
        }

        $("#tab_detail_rekening").append(row.html);

        var last = $("#tab_detail_rekening tr:last");
        $(last).find(".detail_d_rekening1_id").val(d_rekening1_id);
        $(last).find(".detail_d_rekening2_id").val(d_rekening2_id);
        $(last).find(".detail_d_rekening3_id").val(d_rekening3_id);
        $(last).find(".detail_d_rekening4_id").val(d_rekening4_id);
        $(last).find(".detail_d_rekening5_id").val(d_rekening5_id);

        $(last).find(".detail_k_rekening1_id").val(k_rekening1_id);
        $(last).find(".detail_k_rekening2_id").val(k_rekening2_id);
        $(last).find(".detail_k_rekening3_id").val(k_rekening3_id);
        $(last).find(".detail_k_rekening4_id").val(k_rekening4_id);
        $(last).find(".detail_k_rekening5_id").val(k_rekening5_id);

        $(last).find(".detail_bank_id").val(bank_id);

        $(last).find(".label_bank").html(bank_nama);
        $(last).find(".label_rekening_debit").html(d_rekening5_nama);
        $(last).find(".label_rekening_kredit").html(k_rekening5_nama);

        renameInputRekening();

        $(".bank_id").val("");
        $(".rekening_debit :input").val("");
        $(".rekening_kredit :input").val("");

    }

    function renameInputRekening() {
        var cnt = 0;

        $("#tab_detail_rekening tr").each(function() {
            $(this).find(".detail_d_rekening1_id").attr("name", "JnspembrekM[detail][" + cnt + "][D][rekening1_id]");
            $(this).find(".detail_d_rekening2_id").attr("name", "JnspembrekM[detail][" + cnt + "][D][rekening2_id]");
            $(this).find(".detail_d_rekening3_id").attr("name", "JnspembrekM[detail][" + cnt + "][D][rekening3_id]");
            $(this).find(".detail_d_rekening4_id").attr("name", "JnspembrekM[detail][" + cnt + "][D][rekening4_id]");
            $(this).find(".detail_d_rekening5_id").attr("name", "JnspembrekM[detail][" + cnt + "][D][rekening5_id]");

            $(this).find(".detail_k_rekening1_id").attr("name", "JnspembrekM[detail][" + cnt + "][K][rekening1_id]");
            $(this).find(".detail_k_rekening2_id").attr("name", "JnspembrekM[detail][" + cnt + "][K][rekening2_id]");
            $(this).find(".detail_k_rekening3_id").attr("name", "JnspembrekM[detail][" + cnt + "][K][rekening3_id]");
            $(this).find(".detail_k_rekening4_id").attr("name", "JnspembrekM[detail][" + cnt + "][K][rekening4_id]");
            $(this).find(".detail_k_rekening5_id").attr("name", "JnspembrekM[detail][" + cnt + "][K][rekening5_id]");

            $(this).find(".detail_bank_id").attr("name", "JnspembrekM[detail][" + cnt + "][bank_id]");

            cnt++;
        });

    }

    function hapusItemRekeningBank(obj) {
        $(obj).parents("tr").remove();
    }

    function cekValidasi() {
        if ($("#tab_detail_rekening tr").length == 0) {
            myAlert("Data Rekening harus ada");
            return false;
        }
    }
</script>



<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekDebit',
    'options' => array(
        'title' => 'Daftar Rekening Debit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));

$modRekDebit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekDebit->unsetAttributes();
$modRekDebit->rekeninglast_nb = "D";
$account = "";
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekDebit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekDebit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekDebit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekDebit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);
}

//$this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekdebit-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modRekDebit->searchDialogAccount(),
    'filter' => $modRekDebit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
                    $(\".rekening_debit .rekening5_id\").val(\"$data->rekeninglast_id\");
					$(\"#nama_debit\").val(\"".$data->koderekeninglast." - ".$data->namarekeninglast."\");
					$(\"#dialogRekDebit\").dialog(\"close\"); 
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekDebit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekDebit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekDebit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>


<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRekKredit',
    'options' => array(
        'title' => 'Daftar Rekening Kredit',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 400,
        'resizable' => false,
    ),
));

$modRekKredit = new Rekeningakuntansi5V('searchDialogAccount');
$modRekKredit->unsetAttributes();
$modRekKredit->rekeninglast_nb = "K";
$account = "";
if (isset($_GET['Rekeningakuntansi5V'])) {
    $modRekKredit->attributes = $_GET['Rekeningakuntansi5V'];
    $modRekKredit->rekening5_id = (!empty($_GET['Rekeningakuntansi5V']['rekening5_id']) ? $_GET['Rekeningakuntansi5V']['rekening5_id']: null);
    $modRekKredit->rekening6_id = (!empty($_GET['Rekeningakuntansi5V']['rekening6_id']) ? $_GET['Rekeningakuntansi5V']['rekening6_id']: null);
    $modRekKredit->rekening7_id = (!empty($_GET['Rekeningakuntansi5V']['rekening7_id']) ? $_GET['Rekeningakuntansi5V']['rekening7_id']: null);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rekkredit-m-grid',
    'dataProvider' => $modRekKredit->searchDialogAccount(),
    'filter' => $modRekKredit,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
				"id" => "selectRekDebit",
				"onClick" =>"
                $(\".rekening_kredit .rekening5_id\").val(\"$data->rekeninglast_id\");
					$(\"#nama_kredit\").val(\"".$data->koderekeninglast." - ".$data->namarekeninglast."\");
					$(\"#dialogRekKredit\").dialog(\"close\");   
					return false;
			"))',
        ),
        array(
            'header' => 'Kode Akun',
            'type' => 'raw',
            'value' => '$data->koderekeninglast',
            'filter' => Chtml::activeTextField($modRekKredit, 'koderekeninglast', array('class' => 'numbers-only', 'maxlength' => 12))
        ),
        array(
            'header' => 'Kelompok Akun',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = KelrekeningM::model()->findByPk($data->kelompokrekeninglast_id);
                return $kel ? $kel->namakelrekening : "-";
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'kelompokrekeninglast_id', CHtml::listData(
                KelrekeningM::model()->findAll(array(
                    'condition' => 'kelrekening_aktif = true',
                    'order' => 'koderekeningkel',
                )),
                'kelrekening_id',
                'namakelrekening'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 1',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening1;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening1_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening1_id is not null',
                    'order' => 'namarekening1 ASC',
                )),
                'rekening1_id',
                'namarekening1'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 2',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening2;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening2_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening2_id is not null',
                    'order' => 'namarekening2 ASC',
                )),
                'rekening2_id',
                'namarekening2'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 3',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening3;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening3_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening3_id is not null',
                    'order' => 'namarekening3 ASC',
                )),
                'rekening3_id',
                'namarekening3'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 4',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening4;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening4_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening4_id is not null',
                    'order' => 'namarekening4 ASC',
                )),
                'rekening4_id',
                'namarekening4'
            ), array('empty' => '-- Pilih --')),
        ),
        array(
            'header' => 'Rekening Level 5',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening5;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening5_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening5_id is not null',
                    'order' => 'namarekening5 ASC',
                )),
                'rekening5_id',
                'namarekening5'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 6) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 6',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening6;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening6_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening6_id is not null',
                    'order' => 'namarekening6 ASC',
                )),
                'rekening6_id',
                'namarekening6'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 7) ? true: false)
        ),
        array(
            'header' => 'Rekening Level 7',
            'type' => 'raw',
            'value' => function ($data) {
                return $data->namarekening7;
            },
            'filter' => CHtml::activeDropDownList($modRekKredit, 'rekening7_id', CHtml::listData(
                Rekeningakuntansi8V::model()->findAll(array(
                    'condition' => 'rekening7_id is not null',
                    'order' => 'namarekening7 ASC',
                )),
                'rekening7_id',
                'namarekening7'
            ), array('empty' => '-- Pilih --')),
            'visible' => ((Yii::app()->user->getState("levelrekeninglast") >= 8) ? true: false)
        ),
        array(
            'header' => 'Nama Rekening Terakhir',
            'type' => 'raw',
            'value' => '$data->namarekeninglast',
            'filter' => Chtml::activeTextField($modRekKredit, 'namarekeninglast', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Saldo Normal',
            'type' => 'raw',
            'value' => '($data->rekeninglast_nb == "D") ? "Debit" : "Kredit"',
            'filter' =>  CHtml::activeDropDownList($modRekKredit, 'rekeninglast_nb', array('D' => 'Debit', 'K' => 'Kredit'), array('empty' => "-- Pilih --")),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });
            $(".custom-only").keyup(function() {
            setCustomOnly(this);
            });'
        . '}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>