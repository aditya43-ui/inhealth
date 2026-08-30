<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'daftartilikanestesipasien-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<?php echo $form->hiddenField($model, 'pasien_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pendaftaran_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienadmisi_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'pasienmasukpenunjang_id', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model, 'rencanaoperasi_id', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<?php echo $form->errorSummary($model); ?>
<br>
<div class="panel panel-dark">
    <span class="group-title">
        Daftar Tilik Keselamatan Pasien
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tanggal_pengkajian', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggal_pengkajian',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->radioButtonListRow($model, 'isizinoperasi', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'issuplaisilinderoksigen', array('Cukup' => 'Cukup', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'isekgterpasang', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'iskateterurine', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'isperhiasandilepas', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'isrambutditutup', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'isgigipalsu_dilepas', array('Ya' => 'Ya', 'Tidak Ada' => 'Tidak Ada'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'kanulaiv_ukuran', array(16 => '16', 18 => '18', 20 => '20', 22 => '22', 24 => '24'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kanulaiv_lokasi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'kanulaiv_lokasi', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'kanulaiv_pegawaipemasang', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kanulaiv_pegawaipemasang', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php

                        $nama_pegawai = "";
                        if (!empty($model->kanulaiv_pegawaipemasang)) {
                            $peg = PegawaiM::model()->findByPk($model->kanulaiv_pegawaipemasang);
                            $nama_pegawai = $peg->namaLengkap;
                        }

                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'kanulaiv_pegawaipemasang_nama',
                            'value' => $nama_pegawai,
                            'attribute' => 'pegmengetahui_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/ActionAutoComplete/PegawaiRuangan/') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                            },
                                            success: function (data) {
                                                    response(data);
                                            }
                                        })
                                    }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'select' => 'js:function( event, ui ) {                                                 
                                            $("#' . CHtml::activeId($model, 'kanulaiv_pegawaipemasang') . '").val(ui.item.value);
                                            $("#kanulaiv_pegawaipemasang_nama").val(ui.item.namaLengkap);                    
                                            return false;
                                        }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                            'htmlOptions' => array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')
                        ));
                        ?>

                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Jenis Cairan</th>
                            <th>Volume</th>
                            <td width="50"><?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                                                'class' => 'btn btn-danger', 'onclick' => 'tambahJenisCairan();'
                                            )); ?></td>
                        </tr>
                    </thead>
                    <tbody id="tab_jeniscairan">
                        <?php
                        $det = CairanpasienanestesiT::model()->findAllByAttributes(array(
                            'daftartilikanestesipasien_id' => $model->daftartilikanestesipasien_id,
                        ));

                        foreach ($det as $idx => $item) {
                            echo $this->renderPartial($this->path_view . "_rowJenisCairan", array('row' => $item, 'i' => $idx), true);
                        }

                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<br>
<div class="panel panel-dark">
    <span class="group-title">
        Cek Mesin Anesthesia
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->radioButtonListRow($model, 'mesinanestesi_supplailistrik', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinanestesi_breathyngsystem', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->radioButtonListRow($model, 'mesinanestesi_co2absorbent', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinanestesi_ventilator', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            </div>
        </div>
    </div>
</div>
<br>
<div class="panel panel-dark">
    <span class="group-title">
        Status Akhir Mesin
    </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_vaporizeroff', array('Ada' => 'Ada', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_aplvalveopen', array('Ada' => 'Ada', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_bagmode', array('Ada' => 'Ada', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_flowmeter', array('Ada' => 'Ada', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_suctionunit', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_laringoskop', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>


            </div>
            <div class="col-sm-6">
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_ettlmaigel', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_orophairway', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_plester', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'mesinstatusakhir_introducer', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'persiapanobat', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
                <?php echo $form->radioButtonListRow($model, 'cekmonitor', array('Baik' => 'Baik', 'Tidak' => 'Tidak'), array('uncheckValue' => null, 'template' => '<div class="radio-inline">{input}{label} </div>', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

            </div>
        </div>
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
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'print();', 'disabled' => $model->isNewRecord)); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>

<?php $this->endWidget(); ?>

<?php
//===============Dialog buat pegawai
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => false,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV('searchPegawaiMenyetujui');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modPegawaiMengetahui->pegawai_aktif = true;
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn_small",
                "id"=>"selectPegawai",
                "onClick"=>"$(\"#' . CHtml::activeId($model, 'kanulaiv_pegawaipemasang') . '\").val(\"$data->pegawai_id\");
                            $(\"#kanulaiv_pegawaipemasang_nama\").val(\"$data->gelardepan  $data->nama_pegawai\");
                            $(\"#dialogPegawai\").dialog(\"close\");
                            return false;"
                ))'
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($jabatan)) {
                    echo $jabatan->jabatan_nama;
                } else {
                    echo "-";
                }
            },
            'filter' => Chtml::dropDownList('BSPegawairuanganV[jabatan_id]', $modPegawaiMengetahui->jabatan_id, Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>


<script>
    var row = <?php echo CJSON::encode(array('html' => $this->renderPartial($this->path_view . "_rowJenisCairan", array('i' => 'ii'), true))); ?>;

    function tambahJenisCairan() {
        $("#tab_jeniscairan").append(row.html);

        renameTableCairan();

        var last = $("#tab_jeniscairan tr:last");

        $(last).find(".numbers-only").keyup(function() {
            setNumbersOnly(this);
        });
    }

    function hapusJenisCairan(obj) {
        $(obj).parents("tr").remove();
        renameTableCairan();
    }

    function renameTableCairan() {

        var idx = 0;

        $("#tab_jeniscairan tr").each(function() {

            $(this).find(".cairan_jenis").attr('name', 'CairanpasienanestesiT[' + idx + '][cairan_jenis]');
            $(this).find(".cairan_volume").attr('name', 'CairanpasienanestesiT[' + idx + '][cairan_volume]');

            idx++;
        });
    }

    function print() {
        window.open("<?php echo $this->createUrl('print', array(
                            'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id
                        )); ?>&caraPrint=PRINT", "", 'location=_new, width=900px');
    }
</script>