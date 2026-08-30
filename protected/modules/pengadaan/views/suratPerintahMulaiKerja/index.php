<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Data Surat Perintah Mulai Kerja
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'suratperintahmulaikerja-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array(
                'onKeyPress' => 'return disableKeyPress(event);',
                'onsubmit' => 'return requiredCheck(this);',
            ),
            'focus' => '#ADPerintahmulaikerjaT_konfigtemplatesurat_id'
        ));
        ?>
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php $jenissurat_id = JenisSuratM::model()->findByPk(24)->jenissurat_id;
                ?>
                <?php echo $form->dropDownListRow($model, 'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAllByAttributes(array('jenissurat_id' => $jenissurat_id)), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'), array('class' => 'span3 jenisform', 'onkeyup' => "return $(this).focusNextInputField(event)", 'return false;')); ?>

            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'perintahmulaikerja_nomor', array('readonly' => true, 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class = "control-group">
                    <?php echo CHtml::label('Nomor Surat <span class="required">*</span>', 'nomor_dokumen', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'nomor_dokumen', array('class' => 'span3 required', 'maxlength' => 100)); ?>
                        <?php echo $form->hiddenField($model, 'persiapanpengadaan_id', array('class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label("Tanggal Surat <i style='color: red'> * </i>", 'dasar_tanggal', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'perintahmulaikerja_tanggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Nama Penyedia <i style='color: red'> * </i>", "", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'supplier_id', array('class' => 'span3 supplier_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        echo $form->textField($model, 'supplier_nama', array('readonly' => true, 'class' => ' span3', 'maxlength' => 100));
                        ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('Alamat Penyedia', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textArea($model, 'supplier_alamat', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('Direktur', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'nama_direktur', array('readonly' => false, 'false' => 'span3', 'maxlength' => 100, 'readonly' => true)); ?>
                    </div>
                </div>

                <div class = "control-group">
                    <?php echo CHtml::label("Tangal Mulai Kerja ", 'dasar_tanggal', array('class' => 'control-label')) ?>

                    <div class = "controls">
                        <?php echo $form->textField($modsurat, 'tglawal_pekerjaan', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label("Tangal Akhir Kerja ", 'dasar_tanggal', array('class' => 'control-label')) ?>

                    <div class = "controls">
                        <?php echo $form->textField($modsurat, 'tglakhir_pekerjaan', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>



            </div>
            <div class="col-md-6">
                <div class="control-group">
                    <?php echo CHtml::label("No SPK <i style='color: red'> * </i>", "", array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($model, 'suratperjanjiankerja_id', array('class' => ' span3 suratperjanjiankerja_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modsurat,
                            'attribute' => 'nosuratperjanjiankerja',
                            'source' => 'js: function(request, response) {
                                    $.ajax({
                                            url: "' . $this->createUrl('autoCompleteGetSpk') . '",
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
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                       $("#' . Chtml::activeId($model, 'suratperjanjiankerja_id') . '").val(ui.item.value); 
					loadPerintah(ui.item.value);
					return false;
                                        
                                    }',
                                'select' => 'js:function( event, ui ) {
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onblur' => 'if(this.value==""){$(".prodi_id").val("");refreshDialog(); }',
                                'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikkan NO SPK  '),
                            'tombolDialog' => array('idDialog' => 'dialogPerjanjian', 'idTombol' => 'tombolPegawaiPelaksana'),
                        ));
                        ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label("Tanggal SPK <span class='required'>*</span>", '', array('class' => 'control-label')) ?>

                    <div class = "controls">
                        <?php echo $form->textField($modsurat, 'tglsuratperjanjian', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo $form->hiddenField($model, 'pegppk_id', array('class' => 'required')) ?> 
                    <?php echo CHtml::label('Pejabat Pembuat Komitmen', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($modsurat, 'namapembuatkomitmen', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('NIP', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($modsurat, 'noindukpegawai', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('Alamat', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($modsurat, 'alamat', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class = "control-group">
                    <?php echo CHtml::label('Waktu Penyelesaian', '', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($modsurat, 'waktuselesai', array('readonly' => true, 'class' => 'span3', 'maxlength' => 100)) . " Hari"; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">

            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'id' => 'btn_simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('index&id=' . $model->persiapanpengadaan_id), array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);'));
            ?>
            <?php
            $content = $this->renderPartial('pengadaan.views.tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
            <?php
            if (!$model->isNewRecord) {

                echo "&nbsp;";
                echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-succes', 'onclick' => 'print();'));
                echo "&nbsp;";
            }
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div></div>




<?php
//========= Dialog buat cari data SPK  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerjanjian',
    'options' => array(
        'title' => 'Pencarian SPK',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modperjanjian = new SuratperjanjiankerjaT('searchSPK');
$modperjanjian->unsetAttributes();
if (!empty($model->persiapanpengadaan_id)) {
    $modperjanjian->persiapanpengadaan_id = $model->persiapanpengadaan_id;
}
if (isset($_GET['SuratperjanjiankerjaT'])) {
    $modPenyedia->attributes = $_GET['SuratperjanjiankerjaT'];
    if (!empty($model->persiapanpengadaan_id)) {
        $modPenyedia->persiapanpengadaan_id = $model->persiapanpengadaan_id;
    }
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'prodi-m-grid',
    'dataProvider' => $modperjanjian->searchSPK(),
    'filter' => $modperjanjian,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->supplier_id\");
                              $(\"#' . CHtml::activeId($model, 'supplier_nama') . '\").val(\"$data->supplier_nama\");
                              $(\"#' . CHtml::activeId($model, 'supplier_alamat') . '\").val(\"$data->supplier_alamat\");
                              $(\"#' . CHtml::activeId($model, 'nama_direktur') . '\").val(\"$data->direktursupplier\");
                              $(\"#' . CHtml::activeId($modsurat, 'tglsuratperjanjian') . '\").val(\"$data->tglsuratperjanjian\");
                              $(\"#' . CHtml::activeId($modsurat, 'tglawal_pekerjaan') . '\").val(\"$data->tglawal_pekerjaan\");
                              $(\"#' . CHtml::activeId($modsurat, 'tglakhir_pekerjaan') . '\").val(\"$data->tglakhir_pekerjaan\");
                              $(\"#' . CHtml::activeId($modsurat, 'namapembuatkomitmen') . '\").val(\"$data->namapembuatkomitmen\");
                              $(\"#' . CHtml::activeId($modsurat, 'noindukpegawai') . '\").val(\"$data->noindukpegawai\");
                              $(\"#' . CHtml::activeId($modsurat, 'alamat') . '\").val(\"$data->alamat\");
                              $(\"#' . CHtml::activeId($modsurat, 'waktuselesai') . '\").val(\"$data->waktuselesai\");
                              $(\"#' . CHtml::activeId($model, 'suratperjanjiankerja_id') . '\").val(\"$data->suratperjanjiankerja_id\");
                              $(\"#' . CHtml::activeId($modsurat, 'namapekerjaan') . '\").val(\"$data->namapekerjaan\");
                              $(\"#' . CHtml::activeId($model, 'pegppk_id') . '\").val(\"$data->pejabatpembuatkomitmen_id\");
                              $(\"#dialogPerjanjian\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'No SPK',
            'name' => 'nosuratperjanjiankerja',
            'value' => '$data->nosuratperjanjiankerja',
        ),
        array(
            'header' => 'Pekerjaan',
            'name' => 'namapekerjaan',
            'value' => '$data->namapekerjaan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end SPK =============================
?>

<script>
    function setHarga(obj) {
        $("#<?php echo CHtml::activeId($model, 'harga_negosiasi') ?>").attr('disabled', true);
    }

    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->perintahmulaikerja_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }
    function loadPerintah(id)
    {

        $.post('<?php echo $this->createUrl("loadPerintah") ?>', {
            id: id,
        }, function (data) {

            $("#ADPerintahmulaikerjaT_supplier_nama").val(data.supplier_nama);
            $("#ADPerintahmulaikerjaT_supplier_alamat").val(data.supplier_alamat);
            $("#ADPerintahmulaikerjaT_nama_direktur").val(data.direktursupplier);
            $("#SuratperjanjiankerjaT_tglawal_pekerjaan").val(data.perintah.tglawal_pekerjaan);
            $("#SuratperjanjiankerjaT_tglakhir_pekerjaan").val(data.perintah.tglakhir_pekerjaan);
            $("#SuratperjanjiankerjaT_tglsuratperjanjian").val(data.tglsuratperjanjian);


            $("#SuratperjanjiankerjaT_namapembuatkomitmen").val(data.perintah.namapembuatkomitmen);
            $("#SuratperjanjiankerjaT_noindukpegawai").val(data.perintah.noindukpegawai);
            $("#SuratperjanjiankerjaT_namapekerjaan").val(data.perintah.namapekerjaan);
            $("#SuratperjanjiankerjaT_alamat").val(data.perintah.alamat);
            $("#ADPerintahmulaikerjaT_supplier_id").val(data.perintah.supplier_id);
            $("#ADPerintahmulaikerjaT_suratperjanjiankerja_id").val(data.perintah.suratperjanjiankerja_id);
            $("#SuratperjanjiankerjaT_waktuselesai").val(data.waktuselesai);

        }, "json");
    }
</script>
<script>
    function print() {
        window.open('<?php echo $this->createUrl('print', array('id' => $model->perintahmulaikerja_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }

    $(document).ready(function () {
        $(".add-on").hide();
    });
</script>