<?php
//komen buat ngepull
$this->breadcrumbs = array(
    'Anamnesa',
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END);
?>

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


<?php echo $this->renderPartial($this->path_view . 'form._listKegawatan', array(
                    'form' => $form,
                    'modAsesTriase' => $modAsesTriase,
                    'modAsesTriaseDet' => $modAsesTriaseDet,
                        ), true);
                ?>

<?php 
    if ((!in_array(Yii::app()->user->getState('pegawai_id'), array(1, 1028)) && Yii::app()->user->getState('kelompokpegawai_id') == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN)) {
        goto formEnd;
    }
    
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
//                                    'value' => null,
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
//                                    'value' => null,
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
                                 //$petugastriage_nama = $modAsesTriase->loginpemakai->nama_pemakai ?? "";
                                 $pegawai = PegawaiM::model()->findByPk($modAsesTriase->petugastriage_id);
                                 $petugastriage_nama2 = Yii::app()->user->getState('nama_pegawai'); 
                                 if(!empty($pegawai)) {
                                    $petugastriage_nama2 = $pegawai->namaLengkap;
                                 }

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
                                $no_triage = $modAsesTriase->notriagePasien->no_triage_pasien;
                                echo $form->textField($modAsesTriase, 'no_triage', array('value'=> $no_triage,'class' => 'required', 'readonly' => true));
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
                <?php echo $form->hiddenField($modAsesTriase, 'asesmentriagewpss_id', array('readonly' => true, 'value' => $_GET['asesmentriagewpss_id'])) ?>
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

    <div class="form-actions">
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

</div>
</div>
<?php formEnd: ?>
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
    
        function cekForm(){
        
        $("#RDAsesmentriagewpssT_transport_lain").removeClass('required');
        if (requiredCheck($("#rjanamnesa-t-form"))){
            $('#rjanamnesa-t-form').submit();
        }

       return false;
    }
    
</script>
