<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);
$visibility = isset($_GET['lihat']) ? 'hidden' : '';

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);

if(isset($gagalSimpanAlert['status']) && $gagalSimpanAlert['status']) {
    Yii::app()->user->setFlash('error', "Data gagal disimpan");
?>
<div class="alert alert-danger">
    <?= isset($gagalSimpanAlert['pesan']) ? $gagalSimpanAlert['pesan'] : '' ?>
</div>
<?php } ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjanamnesa-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'requiredCheck(this);'),
//    'focus' => '#RJAnamnesaT_keluhanutama_annoninput .maininput',
        ));

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
?>
<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan <b>Asesmen Triage</b>
        </div>
    </div>

    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($modAsesTriase); ?>
        <div class="panel-body">
        <?php echo $form->errorSummary($modAsesTriase); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
      
                <?php
                echo $this->renderPartial($this->path_view . 'form._listKegawatan', array(
                    'form' => $form,
                    'modAsesTriase' => $modAsesTriase,
                    'modAsesTriaseDet' => $modAsesTriaseDet,
                        ), true);
                ?>
    </div>

    <?php 
    if ((!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN)) {
        goto formEnd;
    }
    
    ?>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                </div>
            </div>
            
            <div class="panel-body table-responsive">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsesTriase, 'waktudatang', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modAsesTriase,
                                    'attribute' => 'waktudatang',
                                    //'value' => null,
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 htpd required',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsesTriase, 'waktuperiksa', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modAsesTriase,
                                    'attribute' => 'waktuperiksa',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3 htpd required',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsesTriase, 'petugastriage_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <!-- Pegawai Ruangan -->
                                <?php
                                echo $form->hiddenField($modAsesTriase, 'petugastriage_id', array('class' => 'petugastriage_id', 'onkeypress' => "return $(this).focusNextInputField(event);"));
                                $modpegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                                
                                $petugastriage_nama = $modAsesTriase->petugastriage_nama;
                                $petugastriage_nama2 = $modpegawai->namaLengkap ?? ''; 


                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'petugastriage_nama',
                                    'value' => $petugastriage_nama2,
                                    'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('autocompletePegawai') . '",
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
                                        'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);

                                                return false;
                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                $(".petugastriage_id").val(ui.item.pegawai_id);
                                                $(".petugastriage_nama").val(ui.item.nama_pegawai);
                                                return false;
                                            }',
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPegawaiRuangan', 'idTombol' => 'tombolPPA'),
                                    'htmlOptions' => array('class' => 'span3 petugastriage_nama', 'placeholder' => 'Petugas Triage', 'onkeypress' => "return $(this).focusNextInputField(event)"),
                                ));
                                ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modAsesTriase, 'notriage_pasien_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                echo $form->textField($modAsesTriase, 'no_triage', array('class' => 'required', 'readonly' => true));
                                echo $form->hiddenField($modAsesTriase, 'notriage_pasien_id');
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="panel-body">
        <?php echo $form->errorSummary($modAsesTriase); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Asesmen Triage</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $form->hiddenField($modAsesTriase, 'pendaftaran_id', array('readonly' => true, 'value' => $_GET['pendaftaran_id'])) ?>
                <?php echo $form->hiddenField($modAsesTriase, 'pasien_id', array('readonly' => true)) ?>
                <?php
                echo $this->renderPartial($this->path_view . 'form._formAsesmenTriage', array(
                    'form' => $form,
                    'modAsesTriase' => $modAsesTriase,
                        ), true);
                ?>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <?php echo $form->errorSummary($modAsesTriase); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pediatric <b>Asesmen Triage</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                echo $this->renderPartial($this->path_view . 'form._formPediatricAsesmenTriage', array(
                    'form' => $form,
                    'modAsesTriase' => $modAsesTriase,
                        ), true);
                ?>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <?php echo $form->errorSummary($modAsesTriase); ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Worthing <b>Physiological Scoring System (WPSS)</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                echo $this->renderPartial($this->path_view . 'form._formWPSS', array(
                    'form' => $form,
                    'modAsesTriase' => $modAsesTriase,
                    'modAsesTriaseDet' => $modAsesTriaseDet,
                        ), true);
                ?>
            </div>
        </div>
    </div>

    <!-- tindak lanjut pasien -->
    <div class="panel-body tindak-lanjut" hidden>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tindak Lanjut</div>
            </div>
            <div class="panel-body">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Tgl. Pasien Keluar', 'tglpasienpulang', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modelPulang,
                                'attribute' => 'tglpasienpulang',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5', 'style' => 'width:150px;'),
                            )); ?>
                            <?php echo $form->error($modelPulang, 'tglpasienpulang'); ?>
                        </div>
                    </div>

                    <?php echo $form->hiddenfield($modelPulang, 'pendaftaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <?php echo $form->hiddenfield($modelPulang, 'pasien_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modelPulang, 'carakeluar_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modelPulang,
                                'carakeluar_id',
                                CHtml::listData($modelPulang->getCarakeluarItems(), 'carakeluar_id', 'carakeluar_nama'),
                                array(
                                    'class' => 'span3 carakeluar_id', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekCaraKeluar(this);', 'disabled' => true
                                )
                            ); ?>
                            <?php echo $form->error($modelPulang, 'carakeluar_id'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kondisi Pulang <span class="required">*</span>', 'kondisikeluar_id', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList(
                                $modelPulang,
                                'kondisikeluar_id',
                                CHtml::listData($modelPulang->getKondisikeluarItems($modelPulang->carakeluar_id), 'kondisikeluar_id', 'kondisikeluar_nama'),
                                array('class' => 'span3 kondisikeluar_id', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'cekKondisiKeluar(this);')
                            ); ?>
                            <?php echo $form->error($modelPulang, 'kondisikeluar_id'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Catatan Tindak Lanjut', 'penerimapasien', array('class' => 'control-label')) ?>
                       
                        <div class="controls">
                            <?php echo $form->textField($modelPulang, 'penerimapasien', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                    </div>
                   
                    <?php if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RI) { ?>
                        <?php echo $form->textFieldRow($modMasukKamar, 'tglmasukkamar', array('readonly' => true)) ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modMasukKamar, 'lamadirawat_kamar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modMasukKamar, 'lamadirawat_kamar', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                                <?php echo $form->hiddenField($modelPulang, 'lamarawat', array('class' => 'span1', 'value' => $modMasukKamar->lamadirawat_kamar, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> Hari
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modelPulang, 'lamarawat', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modelPulang, 'lamarawat', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?> Jam
                            </div>
                        </div>
                        <?php echo $form->error($modelPulang, 'lamarawat'); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modelPulang, 'hariperawatan', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modelPulang, 'hariperawatan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?> Hari
                            </div>
                        </div>

                    <?php } ?>
                    <div class="input_kabur" style="display: none";>
                        <?php
                        if (Yii::app()->user->getState('isbridging') == true && $modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                            echo $form->textFieldRow($modSep, 'kll_nolaporan_polisi', array(
                                'class'=>'span3'
                            ));
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                   

                    <div class="panel panel-success box-meninggal">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <?php echo CHtml::checkBox('isDead', $modelPulang->isDead, array('onkeypress' => "return $(this).focusNextInputField(event)", "readonly" => true)) ?>
                                Pasien Meninggal
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="control-group">
                                <?php echo $form->labelEx($modelPulang, 'tgl_meninggal', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modelPulang,
                                        'attribute' => 'tgl_meninggal',
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                        ),
                                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5 tgl_meninggal', 'readonly' => true, 'disabled' => true),
                                    )); ?>

                                </div>
                            </div>
                            <?php
                            if (Yii::app()->user->getState('isbridging') == true && $modPendaftaran->carabayar_id == Params::CARABAYAR_ID_BPJS) {
                                echo $form->textFieldRow($modSep, 'nosurat_ketmeninggal', array(
                                    'class'=>'span3'
                                ));
                            }
                            ?>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions" <?= $visibility ?>>
        <?php
        if (isset($_GET['sukses'])) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => true)
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printAsesmen();return false", 'enabled' => 'true'));
        } else {
            echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'onclick' => 'cekForm();',  'id' => 'btn_simpan', 'enabled' => true)
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false;", 'disabled' => 'true', 'style' => 'cursor:not-allowed;'));
        }
        ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
    
    <?php formEnd: ?>
</div>
</div>
<?php $this->endWidget(); ?>

<?php
//=============================== Dialog Pemeriksa Terapi =======================================
$this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id' => 'dialogPegawaiRuangan',
            'options' => array(
                'title' => 'Pilih Petugas Triage',
                'autoOpen' => false,
                'width' => 840,
                'height' => 420,
                'resizable' => true,
            ),
        )
);

$modPegawai = new PegawairuanganV('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$prov = $modPegawai->search();
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppa-grid',
    'dataProvider' => $prov,
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                $res = $data->attributes;
                $res['nama_pegawai'] = $data->namaLengkap;
                $res = CJSON::encode($res);

                return CHtml::Link('<i class="icon-form-check"></i>', "#", array("class" => "btn-small",
                    "onclick" => "$('.petugastriage_id').val(" . $data->pegawai_id . ");
                                                $('.petugastriage_nama').val('" . $data->namaLengkap . "'); "
                    . "$('#dialogPegawaiRuangan').dialog('close');"
                    . "return false; "));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'name' => 'jabatan_id',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->jabatan_id))
                    return "-";
                $model = JabatanM::model()->findByPk($data->jabatan_id);
                return $model->jabatan_nama;
            },
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', JabatanM::jabatanList(), array(
                'empty' => '--- Pilih ---',
            )),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END Pemeriksa Terapi =======================================
?>
<script>
    loadNoTriage();
    function loadNoTriage() {
        var pendaftaran_id = $('#RDAsesmentriagewpssT_pendaftaran_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getNoTriage'); ?>',
            data: {pendaftaran_id: pendaftaran_id},
            dataType: "json",
            success: function (data) {
                console.log(data)
                $('#RDAsesmentriagewpssT_no_triage').val(data.no_triage_pasien);
                $('#RDAsesmentriagewpssT_notriage_pasien_id').val(data.notriage_pasien_id);
                $('#RDAsesmentriagewpssT_waktudatang').val(data.tgl_masuk);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function printAsesmen()
    {
        window.open('<?php echo $this->createUrl('printAsesmen',array('pendaftaran_id'=>$modAsesTriase->pendaftaran_id)); ?>','printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
    }
    
    function cekForm(){
        
        $("#RDAsesmentriagewpssT_transport_lain").removeClass('required');
        if (requiredCheck($("#rjanamnesa-t-form"))){
            $('#rjanamnesa-t-form').submit();
        }

       return false;
    }
    function cekCaraKeluar(obj) {
        $.post('<?php echo $this->createUrl('/rawatDarurat/daftarPasien/SetDropDownKondisiKeluar'); ?>&model_nama=RDPasienPulangT', $("#rjanamnesa-t-form").serialize(), function(data) {
            
                $(".kondisikeluar_id").html(data.options);

                if (obj.value == "<?php echo Params::CARAKELUAR_ID_DIRUJUK ?>") {
                    $('#pakeRujukan').attr('checked', true);
                    $('#divRujukan input').removeAttr('disabled');
                    $('#divRujukan select').removeAttr('disabled');
                    $('#divRujukan textarea').removeAttr('disabled');
                    $('#divRujukan').show(500);
                } else {
                    $('#pakeRujukan').removeAttr('checked');
                    $('#divRujukan input').attr('disabled', 'true');
                    $('#divRujukan select').attr('disabled', 'true');
                    $('#divRujukan textarea').attr('disabled', 'true');
                    $('#divRujukan').hide(500);
                }

                if (obj.value == "<?php echo Params::CARAKELUAR_ID_RAWATINAP ?>") {
                    $('#panel_dpjp .main_form input').removeAttr('disabled');
                    $('#panel_dpjp .main_form select').removeAttr('disabled');
                    $('#panel_dpjp .main_form textarea').removeAttr('disabled');
                    $('#panel_dpjp').show(500);
                } else {
                    $('#panel_dpjp').removeAttr('checked');
                    $('#panel_dpjp .main_form input').attr('disabled', 'true');
                    $('#panel_dpjp .main_form select').attr('disabled', 'true');
                    $('#panel_dpjp .main_form textarea').attr('disabled', 'true');
                    $('#panel_dpjp').hide(500);
                }



                if ($(obj).val() == "<?php echo Params::CARAKELUAR_ID_MENINGGAL ?>") {
                    $("#isDead").prop("checked", true);
                    $(".box-meninggal").show();
                    $(".tgl_meninggal").prop("disabled", false).val("");
                    // $('.carakeluar_id').val($(obj).val());
                } else {
                    $("#isDead").prop("checked", false);
                    $(".box-meninggal").hide();
                    $(".tgl_meninggal").prop("disabled", true).val("");
                }

                if(obj.value == "<?php echo Params::CARAKELUAR_ID_MELARIKANDIRI ?>"){
                    $(".input_kabur").show();
                } else {
                    $(".input_kabur").hide();
                }

                if (data.statusdokrm == 'belum-dikembalikan') {
                    $("#formKirimDok").val('ada');
                    $(".boxkirimdokumen").show();
                    $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                        $(this).attr("disabled", false);
                    });
                } else {
                    $("#formKirimDok").val('');
                    $(".boxkirimdokumen").hide();
                    $(".boxkirimdokumen").find("input, textarea, select").each(function() {
                        $(this).attr("disabled", true);
                    });
                }
        }, 'json');


    }

    // jika halaman dibuka pada tabulasi
    <?php if(isset($_GET['tab'])) :  ?>
        $("#rjanamnesa-t-form").find('input[name$="[ruang]"]').on('change', function () { 
            if($(this).val() === 'Death on Arrival') {
                $('.tindak-lanjut').show();
            } else {
                $('.tindak-lanjut').hide();
            }
        });
    <?php endif; ?>
    
    function cekRuang() {
        $("#rjanamnesa-t-form").find('input[name$="[ruang]"]').each(function(){
            if($(this).is(':checked')) {
                if($(this).val()  === 'Death on Arrival') {
                    $('.tindak-lanjut').show();
                }
            }
            
        });
    }

    $(function(){
        // jika halaman dibuka pada tabulasi
        <?php if(isset($_GET['tab'])) :  ?>
            cekRuang();
        <?php endif; ?>
    });
</script>

<?php 
if(!empty($modPendaftaran)) {
    if($modPendaftaran->validasiRekamMedis()) {
       echo CustomFunction::alertRekamMedis();
    }
}
?>