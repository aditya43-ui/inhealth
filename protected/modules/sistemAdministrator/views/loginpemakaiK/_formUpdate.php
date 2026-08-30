<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'loginpemakai-k-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'nama_pemakai'),
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekSubmit();'),
));
$cs = Yii::app()->clientScript;
$cs->scriptMap = array(
    'bootstrap-multiselect.js' => false,
);

$read = (Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))) ? false : true; //dibalik jika true maka readony false dan sebaliknya


$hide = ($read) ? 'hidden' : '';
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php
echo $form->errorSummary($model);
//   echo $form->textFieldRow($model,'nama_pemakai',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_old_password','LoginpemakaiK_new_password_repeat')", 'maxlength'=>200));
?>
<!--<div class="control-group">
                <?php //echo $form->labelEx($model,'old_password',array('class'=>'control-label'));
                ?>
                <div class="controls">
                    <?php //echo $form->passwordField($model,'old_password',array('value'=>'','class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password','LoginpemakaiK_nama_pemakai')", 'maxlength'=>200));
                    ?><?php //echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array('class' => 'btn btn-danger', 'data-title'=>Yii::t('mds','Tips'), 'data-content'=>Yii::t('mds','fill this field in case to change the password'), 'rel'=>'popover'));
                        ?>
                    <?php //echo $form->error($model,'old_password');
                    ?>
                </div>
            </div>-->

<?php
//                        echo $form->PasswordFieldRow($model,'new_password',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password_repeat','LoginpemakaiK_old_password')", 'maxlength'=>200));
//                        echo $form->PasswordFieldRow($model,'new_password_repeat',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_loginpemakai_aktif','LoginpemakaiK_new_password')", 'maxlength'=>50));
?>
<div class="row">
    <div class="col-sm-6">
        <?php
        echo $form->hiddenField($model, 'is_email');
        echo $form->hiddenField($model, 'is_phonenumber');
        echo CHtml::hiddenField('st', '');
        ?>
        <?php echo $form->radioButtonListInlineRow($model, 'jenispemakai', array('pegawai' => 'Pegawai', 'pasien' => 'Pasien', 'ppds' => 'PPDS'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'onclick' => 'pilihPemakai(this);')); ?>
        <div class="pegawai">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'pegawai_id');
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'nama_pegawai',
                        //                                            'name'=>'SAPegawaiM[nama_pegawai]',
                        //                                            'value'=>isset($model->pegawai_id) ? $model->pegawai->pegawai_nama  : null,
                        'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('autoCompletePegawai') . '",
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
                                                        $(this).val(ui.item.label);
                                                        return false;
                                                    }',
                            'select' => 'js:function( event, ui ) {
                                                        //$("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id)
														openVerifikasi(ui.item.pegawai_id,ui.item.label,"Pegawai");
                                                        return false;
                                                    }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                        'htmlOptions' => array(
                            'placeholder' => 'Pegawai',
                            "onblur" => 'if (this.value==""){$("#' . CHtml::activeId($model, 'pegawai_id') . '").val("")}',
                            "rel" => "tooltip", "title" => "Klik untuk mencari pegawai", 'onkeyup' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>

                </div>
            </div>
        </div>
        <div class="ppds">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'ppds_id', array('class' => 'control-label ppds_id')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'ppds_id');
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'PpdsM[ppds_nama]',
                        'value' => !empty($model->ppds_id) ? $model->ppds->ppds_nama : null,
                        'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('autoCompletePpds') . '",
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
                                                $(this).val(ui.item.label);
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
                                                $("#' . CHtml::activeId($model, 'ppds_id') . '").val(ui.item.ppds_id)
                                                return false;
                                            }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPpds'),
                        'htmlOptions' => array('placeholder' => 'PPDS', "rel" => "tooltip", "title" => "Klik untuk mencari PPDS", 'onkeyup' => "return $(this).focusNextInputField(event)"),
                    )); ?>

                </div>
            </div>
        </div>
        <div class="pasien">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pasien_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::activeHiddenField($model, 'pasien_id');
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'nama_pasien',
                        //                                            'name'=>'SAPegawaiM[nama_pasien]',
                        //                                            'value'=>isset($model->pasien_id) ? $model->pasien->nama_pasien  : null,
                        'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . $this->createUrl('AutocompletePasien') . '",
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
                                                        //$("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.pasien_id)
															openVerifikasi(ui.item.pasien_id,ui.item.label,"Pasien");
                                                        return false;
                                                    }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPasien'),
                        'htmlOptions' => array('placeholder' => 'Pasien', "rel" => "tooltip", "title" => "Klik untuk mencari pasien", 'onkeyup' => "return $(this).focusNextInputField(event)"),
                    )); ?>
                </div>
            </div>
        </div>
        <?php
        echo $form->errorSummary($model);
        echo $form->textFieldRow($model, 'nama_pemakai', array('onblur' => 'nospaces(this);', 'hint' => $model->getAttributeLabel('nama_pemakai') . ' tidak boleh menggunakan "spasi"', 'class' => 'span3  username-only', 'onkeypress' => "return $(this).focusNextInputField(event)", 'maxlength' => 20, 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true));

        if ($model->is_email) {
            echo '<div class="control-group">
      <label class="control-label"></label><div class="controls"><div class="informasi-dikirim">Informasi Tentang User Akun dikirim ke Email</div></div></div>';
        } elseif ($model->is_phonenumber) {
            echo '<div class="control-group"><label class="control-label"></label><div class="controls"><div class="informasi-dikirim">Informasi Tentang User Akun dikirim ke Nomor Handphone</div></div></div>';
        } else {
            echo '<div class="control-group"><label class="control-label"></label><div class="controls"><div class="informasi-dikirim"></div></div></div>';
        }
        ?>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'new_password', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->PasswordField($model, 'new_password', array('placeholder' => 'Kata Kunci Baru', 'readonly' => $read, 'class' => 'span3', 'maxlength' => 200, 'onchange' => 'checkPass(this,8)'));
                echo CHtml::link('<i class="entypo-info-circled"></i>', '#', array(
                    'class' => 'btn btn-primary', "data-toggle" => "tooltip", "data-placement" => "top", "title" => "",
                    "data-original-title" => "<span style='text-align:left;'>Cara Pengisian Password<br>"
                        . "1. minimal terdiri dari 8 karakter,<br> "
                        . "2. minimal mengandung satu huruf kecil,<br> "
                        . "3. minimal mengandung satu huruf kapital,<br> "
                        . "4. minimal mengandung satu angka,<br> "
                        . "5. minimal mengandung satu simbol dash (-),<br>"
                        . "Contoh : <b>AxY12-092Nnsb</b></span> ", "data-html" => true
                )); ?>
                <br>
                <span id="reset_password-error2" style="color:#cc2424" hidden></span>
            </div>
        </div>
        <?php
        //echo $form->PasswordFieldRow($model,'new_password',array('readonly' => $read,'class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'LoginpemakaiK_new_password_repeat','LoginpemakaiK_old_password')", 'maxlength'=>200));
        echo $form->PasswordFieldRow($model, 'new_password_repeat', array('placeholder' => 'Ulangi Kata Kunci', 'readonly' => $read, 'class' => 'span3', 'onkeypress' => "return nextFocus(this,event,'LoginpemakaiK_loginpemakai_aktif','LoginpemakaiK_new_password')", 'maxlength' => 50));
        ?>
        <div class="control-group">
            <?php echo CHtml::label('Coder Nik', 'coder_nik', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo CHtml::activeTextField($model, 'coder_nik', array('class'=>'span3', 'maxlength'=>50));
                ?>
            </div>
        </div>

        <div <?php echo $hide; ?>>
            <div class="control-group">
                <?php echo CHtml::label("", 'loginpemakai_aktif', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'loginpemakai_aktif', array()); ?>
                    <label for="LoginpemakaiK_loginpemakai_aktif">Aktif</label>
                </div>
            </div>
            <?php //echo $form->checkBoxRow($model,'loginpemakai_aktif', array('onkeypress'=>"return nextFocus(this,event,'submitButton','LoginpemakaiK_new_password_repeat')"));
            ?>
        </div>
    </div>
</div>

<div class="ruangan" <?php echo $hide; ?>>
    <div class="control-group">
        <?php echo $form->labelex($model, 'ruangan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php

            $arrRuangan = array();
            foreach ($modRuanganPemakai as $ruanganPemakai) {
                $arrRuangan[] = $ruanganPemakai['ruangan_id'];
            }

            $this->widget(
                'application.extensions.emultiselect.EMultiSelect',
                array('sortable' => true, 'searchable' => true)
            );
            echo CHtml::dropDownList(
                'ruangan_id[]',
                $arrRuangan,
                CHtml::listData(RuanganM::model()->findAll(array('condition' => 'ruangan_aktif = TRUE', 'order' => 'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
            );
            ?>
            <?php echo $form->error($model, 'ruangan') ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo $form->labelex($model, 'modul', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php

            $arrModul = array();
            foreach ($modModulPemakai as $modulPemakai) {
                $arrModul[] = $modulPemakai['modul_id'];
            }

            $this->widget(
                'application.extensions.emultiselect.EMultiSelect',
                array('sortable' => true, 'searchable' => true)
            );
            echo CHtml::dropDownList(
                'modul_id[]',
                $arrModul,
                CHtml::listData(ModulK::model()->findAll(array('condition' => 'modul_aktif = TRUE', 'order' => 'modul_nama')), 'modul_id', 'modul_nama'),
                array('multiple' => 'multiple', 'key' => 'modul_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
            );
            ?>
            <?php echo $form->error($model, 'modul') ?>
        </div>
    </div>
</div>

<!--<div class="control-group">
                <?php // echo $form->labelex($model,'ruangan',array('class'=>'control-label required'))
                ?>
                <div class="controls">
                    <?php
                    //                             $arrRuangan = array();
                    //                             foreach($modRuanganPemakai as $ruanganPemakai){
                    //                                $arrRuangan[] = $ruanganPemakai['ruangan_id'];
                    //                            }
                    //
                    //                            $this->widget('application.extensions.emultiselect.EMultiSelect',
                    //                                  array('sortable'=>true, 'searchable'=>true)
                    //                            );
                    //                            echo CHtml::dropDownList(
                    //                                'ruangan_id[]',
                    //                                $arrRuangan,
                    //                                CHtml::listData(RuanganM::model()->findAll(array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                    //                                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                    //                            );
                    ?>
                </div>
            </div>-->
<!--<div class="control-group">
                <?php // echo $form->labelex($model,'modul',array('class'=>'control-label required'))
                ?>
                <div class="controls">
                    <?php
                    //                             $arrModul = array();
                    //                             foreach($modModulPemakai as $modulPemakai){
                    //                                $arrModul[] = $modulPemakai['modul_id'];
                    //                            }
                    //
                    //                            $this->widget('application.extensions.emultiselect.EMultiSelect',
                    //                                  array('sortable'=>true, 'searchable'=>true)
                    //                            );
                    //                            echo CHtml::dropDownList(
                    //                                'modul_id[]',
                    //                                $arrModul,
                    //                                CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama')), 'modul_id', 'modul_nama'),
                    //                                array('multiple'=>'multiple','key'=>'modul_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                    //                            );
                    ?>
                    <?php // echo $form->error($model,'modul')
                    ?>
                </div>

            </div>-->

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'submitButton')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/loginpemakaiK/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Login Pemakai', array('{icon}' => '<i class="entypo-folder"></i>')),
        $this->createUrl('/sistemAdministrator/loginpemakaiK/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php
$js = <<< JSCRIPT
   kosongkanPassword();

   function kosongkanPassword(){
        $('#LoginpemakaiK_new_password').val('');
        $('#LoginpemakaiK_old_password').val('');
        $('#LoginpemakaiK_new_password_repeat').val('');
   }

JSCRIPT;
Yii::app()->clientScript->registerScript('kosongkanPassword', $js, CClientScript::POS_READY);
?>
<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new SAPegawaiM();
$modPegawai->attributes = isset($_GET['SAPegawaiM']) ? $_GET['SAPegawaiM'] : null;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapegawai-m-grid',
    'dataProvider' => $modPegawai->searchPegawaiNoUser(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',

            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                          "onClick"=>"
                                           // $(\"#idPegawai\").val(\"$data->pegawai_id\");
                                           // $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                           //  $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->NamaLengkap\");
											 openVerifikasi(\"$data->pegawai_id\",\"$data->NamaLengkap\",\"Pegawai\");
                                            $(\"#dialogPegawai\").dialog(\"close\");
                                            "
                                     ))',
        ),
        'nomorindukpegawai',
        array(
            'header' => 'Gelar Depan',
            'name' => 'gelardepan',
            'value' => '$data->gelardepan',
            'filter' => CHtml::dropDownList('SAPegawaiM[gelardepan]', $modPegawai->gelardepan,  LookupM::getItems('gelardepan'), array('empty' => '-- Pilih --'))
        ),
        'nama_pegawai',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::dropDownList('SAPegawaiM[jeniskelamin]', $modPegawai->jeniskelamin,  LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        'tempatlahir_pegawai',
        array(
            'header' => 'Tanggal Lahir',
            'value' => '$data->tgl_lahirpegawai',

        ),
        array(
            'header' => 'Jabatan',
            'value' => 'isset($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            'filter' => CHtml::dropDownList('SAPegawaiM[jabatan_id]', $modPegawai->jabatan_id, CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = true ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php $this->endWidget(); ?>
<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPasien = new SAPasienM('searchDialog');
if (isset($_GET['SAPasienM'])) {
    $modPasien->attributes = $_GET['SAPasienM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapasien-m-grid',
    'dataProvider' => $modPasien->searchPasienNoUser(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',

            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                "onClick"=>"
                                 // $(\"#pasien_id\").val(\"$data->pasien_id\");
                                 // $(\"#' . CHtml::activeId($model, 'pasien_id') . '\").val(\"$data->pasien_id\");
                                //   $(\"#' . CHtml::activeId($model, 'nama_pasien') . '\").val(\"$data->nama_pasien\");

								openVerifikasi(\"$data->pasien_id\",\"$data->nama_pasien\",\"Pasien\");
								  $(\"#dialogPasien\").dialog(\"close\");
                                  "
                           ))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::dropDownList('SAPasienM[jeniskelamin]', $modPegawai->jeniskelamin,  LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Tanggal Lahir',
            'value' => '$data->tanggal_lahir',

        ),
        'alamat_pasien',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php $this->endWidget(); ?>

<?php
// Dialog buat nambah data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPpds',
    'options' => array(
        'title' => 'Data PPDS',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPpds = new PpdsM();
$modPpds->attributes = isset($_GET['PpdsM']) ? $_GET['PpdsM'] : null;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sappds-m-grid',
    'dataProvider' => $modPpds->searchDialogPPDS(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => '',

            'value' => 'CHtml::link("<i class=\"icon-form-check\"></i>","#", array("id" => "selectPegawai",
                                          "onClick"=>"
                                            $(\"#' . CHtml::activeId($model, 'ppds_id') . '\").val(\"$data->ppds_id\");
                                            $(\"#PpdsM_ppds_nama\").val(\"$data->ppds_nama\");
                                            $(\"#dialogPpds\").dialog(\"close\");
                                            "
                                     ))',
        ),
        
        'ppds_nik',
        'ppds_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>
<?php $this->endWidget(); ?>

<?php

/** digunakan untuk memilih email atau nomor telpon/hanphone (sebagai alat penerima informasi user akun)
 *  created by M Iqbal Laksana
 */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogVerifikasi',
    'options' => array(
        'title' => 'Sinkronisasi <span id="status"></span>',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 400,
        'height' => 300,
        'resizable' => false,
        'closeOnEscape' => true,
        'close' => 'js:function(){ $("#dialog"+$("#st").val()).dialog("open") }',

    ),
));
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Verifikasi User
        </div>
    </div>
    <div class="panel-body">
        <label>Pilih salah satu untuk memilih informasi user akun akan dikirim</label>
        <br>
        <?php echo CHtml::radioButtonList('verifikasi', '1', array('0' => 'Nomor Telpon', '1' => 'Email'), array('labelOptions' => array('style' => 'display:inline'))); ?>
        <br>
        <br>
        <br>
        <button verif_nama='' verif_id='' id='btn-verifikasi' class="btn btn-primary" onclick="getVerifikasi(this);"><i class="entypo-check"></i> Verifikasi</button>
    </div>
</div>
<?php

$this->endWidget();
?>
<script>
    function nospaces(t) {
        if (t.value.match(/\s/g)) {
            alert('Maaf, inputan tidak diperbolehkan menggunakan spasi');
            t.value = t.value.replace(/\s/g, '');
        }
    }

    function pilihPemakai(obj) {
        var jenis_pemakai = $('#<?php CHtml::activeId($model, 'jenispemakai'); ?>').val();
        $('input[name$="[jenispemakai]"][type="radio"]').each(function() {
            if ($(obj).is(':checked')) {
                if (obj.value == 'pegawai') {
                    $('.pegawai').show();
                    $('.pasien').hide();
                    $('.ruangan').show();
                    $('.ppds').hide();
                } else if (obj.value == 'ppds') {
                    $('.pegawai').hide();
                    $('.pasien').hide();
                    $('.ruangan').show();
                    $('.ppds').show();
                } else {
                    $('.pegawai').hide();
                    $('.pasien').show();
                    $('.ruangan').hide();
                    $('.hide').hide();
                }
            }
        });
    }

    function openVerifikasi(pegawai_id, nama_pegawai, status) {

        $("#btn-verifikasi").attr('verif_id', pegawai_id);
        $("#btn-verifikasi").attr('verif_nama', nama_pegawai);
        $("#<?php echo CHtml::activeId($model, 'nama_pegawai'); ?>").val('');
        $("#dialogVerifikasi").dialog('open');
        $("#status").html(status);

        $("#st").val(status);
    }

    function getVerifikasi(obj) {
        var pegawai_id = $(obj).attr('verif_id');
        var nama_pegawai = $(obj).attr('verif_nama');
        var pasien_id = $(obj).attr('verif_id');
        var nama_pasien = $(obj).attr('verif_nama');
        var verif = $("[name=verifikasi]:checked").val();
        var cek = $("#st").val();

        $("#<?php echo CHtml::activeId($model, 'is_email') ?>").val(0);
        $("#<?php echo CHtml::activeId($model, 'is_phonenumber') ?>").val(0);
        $(".informasi-dikirim").html('');

        if (cek == 'Pegawai') {
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('CekVerifikasiPeg') ?>',
                dataType: "json",
                data: {
                    verif: verif,
                    pegawai_id: pegawai_id,
                    status: 'pegawai'
                },
                success: function(data) {
                    if (data.sukses == 1) {

                        if (data.status == 1) {
                            if (data.verif_e == 0) {
                                myAlert("Maaf, pegawai <b>" + nama_pegawai + "</b> belum memiliki data email di data pegawainya.")
                            } else {
                                $("#<?php echo CHtml::activeId($model, 'is_email') ?>").val(data.verif_e);
                                myAlert("Sinkronisasi menggunakan email dipilih!");

                                $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val(pegawai_id);
                                $("#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>").val(nama_pegawai);

                                $("#dialogVerifikasi").dialog('close');
                                $("#dialogPegawai").dialog('close');

                                $(".informasi-dikirim").html("data user akan diinformasi ke email");
                            }
                        } else if (data.status == 0) {
                            if (data.verif_p == 0) {
                                myAlert("Maaf, pegawai <b>" + nama_pegawai + "</b> belum memiliki data nomor mobile/handphone di data pegawainya.")
                            } else {
                                $("#<?php echo CHtml::activeId($model, 'is_phonenumber') ?>").val(data.verif_p);
                                myAlert("Sinkronisasi menggunakan nomor mobile/handphone dipilih!");

                                $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val(pegawai_id);
                                $("#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>").val(nama_pegawai);
                                $("#dialogVerifikasi").dialog('close');
                                $("#dialogPegawai").dialog('close');

                                $(".informasi-dikirim").html("data user akan diinformasikan ke nomor mobile/handphone");
                            }
                        }

                    } else {
                        toastr.error(data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else if (cek == 'Pasien') {
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('CekVerifikasiPeg') ?>',
                dataType: "json",
                data: {
                    verif: verif,
                    pasien_id: pasien_id,
                    status: 'pasien'
                },
                success: function(data) {
                    if (data.sukses == 1) {

                        if (data.status == 1) {
                            if (data.verif_e == 0) {
                                myAlert("Maaf, pasien <b>" + nama_pasien + "</b> belum memiliki data email di data pasiennya.")
                            } else {
                                $("#<?php echo CHtml::activeId($model, 'pasien_id') ?>").val(pasien_id);
                                $("#<?php echo CHtml::activeId($model, 'nama_pasien') ?>").val(nama_pasien);
                                $("#<?php echo CHtml::activeId($model, 'is_email') ?>").val(data.verif_e);
                                myAlert("Sinkronisasi menggunakan email dipilih!");

                                $("#dialogVerifikasi").dialog('close');
                                $("#dialogPasien").dialog('close');

                                $(".informasi-dikirim").html("data user akan diinformasi ke email");
                            }
                        } else if (data.status == 0) {
                            if (data.verif_p == 0) {
                                myAlert("Maaf, pasien <b>" + nama_pasien + "</b> belum memiliki data nomor mobile/handphone di data pasiennya.")
                            } else {
                                $("#<?php echo CHtml::activeId($model, 'pasien_id') ?>").val(pasien_id);
                                $("#<?php echo CHtml::activeId($model, 'nama_pasien') ?>").val(nama_pasien);
                                $("#<?php echo CHtml::activeId($model, 'is_phonenumber') ?>").val(data.verif_p);
                                myAlert("Sinkronisasi menggunakan nomor mobile/handphone dipilih!");

                                $("#dialogVerifikasi").dialog('close');
                                $("#dialogPasien").dialog('close');

                                $(".informasi-dikirim").html("data user akan diinformasikan ke nomor mobile/handphone");
                            }
                        }

                    } else {
                        toastr.error(data.pesan);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }

    }

    function cekSubmit() {
        var confirm = $("#<?php echo CHtml::activeId($model, 'new_password') ?>");
        var reconfirm = $("#<?php echo CHtml::activeId($model, 'new_password_repeat') ?>");
        //alert(confirm);

        confirm.attr("style", '');
        reconfirm.attr("style", '');
        if (confirm.val() == '') {
            return requiredCheck($("#loginpemakai-k-form"));
        } else {
            if (checkPass(confirm, 8)) {
                if (reconfirm.val() == confirm.val()) {
                    return requiredCheck($("#loginpemakai-k-form"));
                } else {
                    confirm.attr("style", 'border:1px solid red;');
                    reconfirm.attr("style", 'border:1px solid red;');
                    myAlert("Maaf, Ulangi Kata Kunci tidak sama dengan password baru");
                    return false;
                }
            } else {
                confirm.attr("style", 'border:1px solid red;');
                myAlert("Maaf, inputan password tidak sesuai cara pengisian password");
                return false;
            }
        }
    }

    $(document).ready(function() {
        var jenis_pemakai = $('#<?php echo CHtml::activeId($model, 'jenispemakai'); ?>').val();
        var pegawai_id = $('#<?php echo CHtml::activeId($model, 'pegawai_id'); ?>').val();
        var pasien_id = $('#<?php echo CHtml::activeId($model, 'pasien_id'); ?>').val();
        $('.pasien').hide();
        $('.ruangan').show();
    });
</script>