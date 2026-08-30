<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabahanmakanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));

$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
); 

$dataPegawai = PegawaiM::model()->findAll(array('condition' => 'pegawai_aktif = TRUE', 'order' => 'nama_pegawai'));
?>

<?php $modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> <?php echo $modProfilRs->nama_rumahsakit; ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label("Direktur", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'direkturrs_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_direktur_rs = "";
                        if (isset($model->direkturrs_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->direkturrs_id);
                            $pegawai_direktur_rs = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'direktur_rs',
                            'value' => $pegawai_direktur_rs,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'direktur_rs') . '").val(ui.item.value)
                                                        $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'direktur_rs') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDirekturRS'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Manager Accounting", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'manageraccountingrs_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_manageraccountingrs = "";
                        if (isset($model->manageraccountingrs_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->manageraccountingrs_id);
                            $pegawai_manageraccountingrs = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'manageraccountingrs',
                            'value' => $pegawai_manageraccountingrs,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'manageraccountingrs_id') . '").val(ui.item.value)
                                                        $("#manageraccountingrs").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'manageraccountingrs_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogManagerAccountRS'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Manager Keuangan", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'managerkeuangan_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_manager_keuangan = "";
                        if (isset($model->managerkeuangan_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->managerkeuangan_id);
                            $pegawai_manager_keuangan = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'manager_keuangan',
                            'value' => $pegawai_manager_keuangan,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'manager_keuangan') . '").val(ui.item.value)
                                                        $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'manager_keuangan') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogManagerKeuangan'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Manager Umum", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'managerumum_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_manager_umum = "";
                        if (isset($model->managerumum_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->managerumum_id);
                            $pegawai_manager_umum = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'manager_umum',
                            'value' => $pegawai_manager_umum,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'manager_umum') . '").val(ui.item.value)
                                                        $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'manager_umum') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogManagerUmum'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Bagian Kepegawaian", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'bagiankepegawaian_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_bagiankepegawaian = "";
                        if (isset($model->bagiankepegawaian_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->bagiankepegawaian_id);
                            $pegawai_bagiankepegawaian = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'bagiankepegawaian_nama',
                            'value' => $pegawai_bagiankepegawaian,
                            'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompletePegawai') . '",
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
                                                    $(this).val("");
                                                    return false;
                                                }',
                                'select' => 'js:function( event, ui ) {
                                                    $("#' . CHtml::activeId($model, 'bagiankepegawaian_id') . '").val(ui.item.value)
                                                    $("#bagiankepegawaian_nama").val(ui.item.label);
                                                    return false;
                                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'bagiankepegawaian_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogBagianKepegawaian'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Kepala Instalasi Gizi", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kepalagizi_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_gizi = "";
                        if (isset($model->kepalagizi_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->kepalagizi_id);
                            $pegawai_gizi = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'instalasi_gizi',
                            'value' => $pegawai_gizi,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'instalasi_gizi') . '").val(ui.item.value)
                                                        $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'instalasi_gizi') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiGizi'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Kepala Gudang Farmasi", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kepalafarmasi_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_farmasi = "";
                        if (isset($model->kepalafarmasi_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->kepalafarmasi_id);
                            $pegawai_farmasi = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'penanggungjawab_apoterker_nama',
                            'value' => $pegawai_farmasi,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'penanggungjawab_apoterker_nama') . '").val(ui.item.value)
                                                        $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'penanggungjawab_apoterker_nama') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiFarmasi'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Kepala Gudang Umum", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kepalaumum_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_gudang_umum = "";
                        if (isset($model->kepalaumum_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->kepalaumum_id);
                            $pegawai_gudang_umum = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'instalasi_gudang_umum',
                            'value' => $pegawai_gudang_umum,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'instalasi_gudang_umum') . '").val(ui.item.value)
                                                        $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'instalasi_gudang_umum') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKepalaInstalasiGudangUmum'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> PT. SHB
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label("Direktur", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'direkturpt_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_direktur_pt = "";
                        if (isset($model->direkturpt_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->direkturpt_id);
                            $pegawai_direktur_pt = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'direktur_pt',
                            'value' => $pegawai_direktur_pt,
                            'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                    $(this).val("");
                                                    return false;
                                                }',
                                'select' => 'js:function( event, ui ) {
                                                    $("#' . CHtml::activeId($model, 'direktur_pt') . '").val(ui.item.value)
                                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                    return false;
                                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'direktur_pt') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDirekturPT'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Manager Keuangan", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'managerkeuanganpt_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_manager_keuanganpt = "";
                        if (!empty($model->managerkeuanganpt_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->managerkeuanganpt_id);
                            $pegawai_manager_keuanganpt = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'manager_keuanganpt',
                            'value' => $pegawai_manager_keuanganpt,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'managerkeuanganpt_id') . '").val(ui.item.value)
                                                        $("#manager_keuangan").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'managerkeuanganpt_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogManagerKeuanganPt'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Manager Umum", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'managerumumpt_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_manager_umumpt = "";
                        if (!empty($model->managerumumpt_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->managerumumpt_id);
                            $pegawai_manager_umumpt = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'manager_umumpt',
                            'value' => $pegawai_manager_umumpt,
                            'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                        $(this).val("");
                                                        return false;
                                                    }',
                                'select' => 'js:function( event, ui ) {
                                                        $("#' . CHtml::activeId($model, 'managerumumpt_id') . '").val(ui.item.value)
                                                        $("#manager_umumpt").val(ui.item.label);
                                                        return false;
                                                    }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'managerumumpt_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogManagerUmumPt'),
                        ));
                        ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label("Bagian Kepegawaian", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'kasipersonalia_id', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $pegawai_kasi_personalia = "";
                        if (isset($model->kasipersonalia_id)) {
                            $modPegRuangan = PegawaiM::model()->findByPk($model->kasipersonalia_id);
                            $pegawai_kasi_personalia = isset($modPegRuangan) ? $modPegRuangan->namaLengkap : "";
                        }
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'kasi_personalia',
                            'value' => $pegawai_kasi_personalia,
                            'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . $this->createUrl('AutocompletePenanggungjawabApoteker') . '",
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
                                                    $(this).val("");
                                                    return false;
                                                }',
                                'select' => 'js:function( event, ui ) {
                                                    $("#' . CHtml::activeId($model, 'kasi_personalia') . '").val(ui.item.value)
                                                    $("#kepala_fnstalasi_farmasi").val(ui.item.label);
                                                    return false;
                                                }',
                            ),
                            'htmlOptions' => array(
                                'class' => 'custom-only',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "")  $("#' . CHtml::activeId($model, 'kasi_personalia') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogKasiPersonalia'),
                        ));
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Approval Keuangan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <label for="" class="control-label">Approval Batal Tindakan</label>
                    <div class="controls">
                        <?php
            
                        $this->widget(
                            'application.extensions.emultiselect.EMultiSelect',
                            array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                            'pegawai_id_bataltindakan[]',
                            $dataApprovalBatalTindakan,
                            CHtml::listData($dataPegawai, 'pegawai_id', 'namaLengkap'),
                            array('multiple' => 'multiple', 'key' => 'pegawai_id_bataltindakan', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Approval Batal Verifikasi</label>
                    <div class="controls">
                        <?php
            
                        $this->widget(
                            'application.extensions.emultiselect.EMultiSelect',
                            array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                            'pegawai_id_batalverifikasi[]',
                            $dataApprovalBatalVerifikasi,
                            CHtml::listData($dataPegawai, 'pegawai_id', 'namaLengkap'),
                            array('multiple' => 'multiple', 'key' => 'pegawai_id_batalverifikasi', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Approval Batal Alokasi Biaya</label>
                    <div class="controls">
                        <?php
            
                        $this->widget(
                            'application.extensions.emultiselect.EMultiSelect',
                            array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                            'pegawai_id_batalalokasi[]',
                            $dataApprovalBatalAlokasi,
                            CHtml::listData($dataPegawai, 'pegawai_id', 'namaLengkap'),
                            array('multiple' => 'multiple', 'key' => 'pegawai_id_batalalokasi', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="" class="control-label">Approval Batal Pembayaran</label>
                    <div class="controls">
                        <?php
            
                        $this->widget(
                            'application.extensions.emultiselect.EMultiSelect',
                            array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                            'pegawai_id_batalpembayaran[]',
                            $dataApprovalBatalPembayaran,
                            CHtml::listData($dataPegawai, 'pegawai_id', 'namaLengkap'),
                            array('multiple' => 'multiple', 'key' => 'pegawai_id_batalpembayaran', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/approvalotorisasiM/create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('gudangFarmasi.views.tips.tipsaddedit4b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
/**
 * Dialog Kepala Instalasi Gizi
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepalaInstalasiGizi',
    'options' => array(
        'title' => 'Kepala Instalasi Gizi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiGizi = new SAPegawaiM();
$PegawaiGizi->unsetAttributes();
$PegawaiGizi->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiGizi->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaigizi-m-grid',
    'dataProvider' => $PegawaiGizi->searchDialog(),
    'filter' => $PegawaiGizi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#instalasi_gizi\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kepalagizi_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogKepalaInstalasiGizi\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiGizi, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiGizi, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiGizi, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiGizi, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Dialog Kepala Instalasi Farmasi
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepalaInstalasiFarmasi',
    'options' => array(
        'title' => 'Kepala Instalasi Farmasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiFarmasi = new SAPegawaiM();
$PegawaiFarmasi->unsetAttributes();
$PegawaiFarmasi->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiFarmasi->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaifarmasi-m-grid',
    'dataProvider' => $PegawaiFarmasi->searchDialog(),
    'filter' => $PegawaiFarmasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#penanggungjawab_apoterker_nama\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kepalafarmasi_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogKepalaInstalasiFarmasi\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiFarmasi, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiFarmasi, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiFarmasi, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiFarmasi, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Dialog Kepala Instalasi Gudang Umum
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKepalaInstalasiGudangUmum',
    'options' => array(
        'title' => 'Kepala Instalasi Gudang Umum',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiGudangUmum = new SAPegawaiM();
$PegawaiGudangUmum->unsetAttributes();
$PegawaiGudangUmum->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiGudangUmum->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaigudangumum-m-grid',
    'dataProvider' => $PegawaiGudangUmum->searchDialog(),
    'filter' => $PegawaiGudangUmum,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#instalasi_gudang_umum\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kepalaumum_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogKepalaInstalasiGudangUmum\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiGudangUmum, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiGudangUmum, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiGudangUmum, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiGudangUmum, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Kasi Personalia
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogKasiPersonalia',
    'options' => array(
        'title' => 'Kasi Personalia',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiKasiProsonalia = new SAPegawaiM();
$PegawaiKasiProsonalia->unsetAttributes();
$PegawaiKasiProsonalia->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiKasiProsonalia->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kasipersonalia-m-grid',
    'dataProvider' => $PegawaiKasiProsonalia->searchDialog(),
    'filter' => $PegawaiKasiProsonalia,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#kasi_personalia\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'kasipersonalia_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogKasiPersonalia\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiKasiProsonalia, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiKasiProsonalia, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiKasiProsonalia, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiKasiProsonalia, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Manager Umum
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogManagerUmum',
    'options' => array(
        'title' => 'Manager Umum',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiManagerUmum = new SAPegawaiM();
$PegawaiManagerUmum->unsetAttributes();
$PegawaiManagerUmum->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiManagerUmum->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'managerumum-m-grid',
    'dataProvider' => $PegawaiManagerUmum->searchDialog(),
    'filter' => $PegawaiManagerUmum,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#manager_umum\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'managerumum_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogManagerUmum\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiManagerUmum, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiManagerUmum, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiManagerUmum, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiManagerUmum, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>


<?php
/**
 * Manager Keuangan
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogManagerKeuangan',
    'options' => array(
        'title' => 'Manager Keuangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiManagerKeuangan = new SAPegawaiM();
$PegawaiManagerKeuangan->unsetAttributes();
$PegawaiManagerKeuangan->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiManagerKeuangan->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'managerkeuangan-m-grid',
    'dataProvider' => $PegawaiManagerKeuangan->searchDialog(),
    'filter' => $PegawaiManagerKeuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#manager_keuangan\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'managerkeuangan_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogManagerKeuangan\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiManagerKeuangan, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiManagerKeuangan, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiManagerKeuangan, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiManagerKeuangan, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Direktur RS
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDirekturRS',
    'options' => array(
        'title' => 'Direktur RS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiDirekturRS = new SAPegawaiM();
$PegawaiDirekturRS->unsetAttributes();
$PegawaiDirekturRS->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiDirekturRS->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'direkturrs-m-grid',
    'dataProvider' => $PegawaiDirekturRS->searchDialog(),
    'filter' => $PegawaiDirekturRS,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#direktur_rs\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'direkturrs_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogDirekturRS\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiDirekturRS, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiDirekturRS, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiDirekturRS, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiDirekturRS, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
/**
 * Direktur PT
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDirekturPT',
    'options' => array(
        'title' => 'Direktur PT',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiDirekturPT = new SAPegawaiM();
$PegawaiDirekturPT->unsetAttributes();
$PegawaiDirekturPT->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiDirekturPT->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'direkturpt-m-grid',
    'dataProvider' => $PegawaiDirekturPT->searchDialog(),
    'filter' => $PegawaiDirekturPT,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#direktur_pt\").val(\"$data->nama_pegawai\");
                      $(\"#' . CHtml::activeId($model, 'direkturpt_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogDirekturPT\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiDirekturPT, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiDirekturPT, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiDirekturPT, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiDirekturPT, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBagianKepegawaian',
    'options' => array(
        'title' => 'Bagian Kepergawaian',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiBgnKepegawaian = new SAPegawaiM();
$PegawaiBgnKepegawaian->unsetAttributes();
$PegawaiBgnKepegawaian->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiBgnKepegawaian->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'bagiankepergawaian-m-grid',
    'dataProvider' => $PegawaiBgnKepegawaian->searchDialog(),
    'filter' => $PegawaiBgnKepegawaian,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#bagiankepegawaian_nama\").val(\"$data->namaLengkap\");
                      $(\"#' . CHtml::activeId($model, 'bagiankepegawaian_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogBagianKepegawaian\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiBgnKepegawaian, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiBgnKepegawaian, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiBgnKepegawaian, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiBgnKepegawaian, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogManagerUmumPt',
    'options' => array(
        'title' => 'Manager Umum PT',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiManagerUmumPT = new SAPegawaiM();
$PegawaiManagerUmumPT->unsetAttributes();
$PegawaiManagerUmumPT->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiManagerUmumPT->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegmanagerumumpt-m-grid',
    'dataProvider' => $PegawaiManagerUmumPT->searchDialog(),
    'filter' => $PegawaiManagerUmumPT,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#manager_umumpt\").val(\"$data->namaLengkap\");
                      $(\"#' . CHtml::activeId($model, 'managerumumpt_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogManagerUmumPt\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiManagerUmumPT, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiManagerUmumPT, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiManagerUmumPT, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiManagerUmumPT, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogManagerKeuanganPt',
    'options' => array(
        'title' => 'Manager Keuangan PT',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiManagerKeuanganPT = new SAPegawaiM();
$PegawaiManagerKeuanganPT->unsetAttributes();
$PegawaiManagerKeuanganPT->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiManagerKeuanganPT->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegmanagerkeuanganpt-m-grid',
    'dataProvider' => $PegawaiManagerKeuanganPT->searchDialog(),
    'filter' => $PegawaiManagerKeuanganPT,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#manager_keuanganpt\").val(\"$data->namaLengkap\");
                      $(\"#' . CHtml::activeId($model, 'managerkeuanganpt_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogManagerKeuanganPt\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiManagerKeuanganPT, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiManagerKeuanganPT, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiManagerKeuanganPT, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiManagerKeuanganPT, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogManagerAccountRS',
    'options' => array(
        'title' => 'Manager Accounting RS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$PegawaiManagerAccRS = new SAPegawaiM();
$PegawaiManagerAccRS->unsetAttributes();
$PegawaiManagerAccRS->pegawai_aktif = true;
if (isset($_GET['SAPegawaiM']))
    $PegawaiManagerAccRS->attributes = $_GET['SAPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegmanageraccountingrs-m-grid',
    'dataProvider' => $PegawaiManagerAccRS->searchDialog(),
    'filter' => $PegawaiManagerAccRS,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                    "id" => "selectPegawai",
                    "href"=>"",
                    "onClick" => "
                      $(\"#manageraccountingrs\").val(\"$data->namaLengkap\");
                      $(\"#' . CHtml::activeId($model, 'manageraccountingrs_id') . '\").val(\"$data->pegawai_id\");

                      $(\"#dialogManagerAccountRS\").dialog(\"close\");
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($PegawaiManagerAccRS, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($PegawaiManagerAccRS, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::activeDropDownList($PegawaiManagerAccRS, 'jeniskelamin', LookupM::model()->getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($PegawaiManagerAccRS, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '}',
));

$this->endWidget();
?>