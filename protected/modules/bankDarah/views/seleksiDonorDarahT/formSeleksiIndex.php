<?php
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan !");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'seleksidonordarah-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '',
        ));
?>
<div class="panel-body">
<?php echo CHtml::activeHiddenField($modPendonor, 'pendonor_id', array('readonly' => true)); ?>
<?php echo CHtml::activeHiddenField($modDaftarDonasi, 'daftardonasi_id', array('readonly' => true)); ?>

    <div class="panel panel-success panel-shadow">
        <div class="panel-heading">
            <div class="panel-title"><span class='judul'>Kuesioner Donor Darah</span></div>
        </div>
        <div class="panel-body">
            <fieldset  id="form-kuesioner">
                <div class="row-fluid">
                    <?php
                    $this->renderPartial('_tabelKuesioner', array('form' => $form,
                        'model' => $model,
                        'modKuesioner' => $modKuesioner,
                        'modPendonor' => $modPendonor,
                        'modDaftarDonasi' => $modDaftarDonasi,
                        'getSioner' => $getSioner,
                        'cekSeleksi' => $cekSeleksi
                            
                        ));
                    ?>
                </div>
            </fieldset>
            <span class="span12" style="text-align: center" id="label_status"></span>
            <?php echo $form->hiddenField($model, 'is_gagalseleksiawal', array('readony' => true)) ?>
            <?php echo $form->hiddenField($model, 'gagal_seleksi_wanita', array('readony' => true)) ?>
            <table>
                <tr>
                    <td hidden><?php echo $form->checkBox($model, 'is_gagalseleksi', array('onclick' => 'gagalSeleksi(this)', 'data-toggle' => 'tooltip', 'title' => 'Klik jika pendonor gagal seleksi')); ?> <label>Cek jika pendonor darah ditolak atau gagal</label></td>
                </tr>
            </table>
        </div>

    </div> 
    <div class="col-sm-6">
        <div class="control-group">
                <?php echo CHtml::label("Tanggal <span class='required'>*</span>", 'detaknadi', array('class' => 'control-label')); ?>
            <div class="controls">
                    <div id="tanggal">
                        <?php
                            echo Chtml::textField('tgl',$model->tglseleksikuesioner, array('readonly' => true));
                        ?>
                    </div>
                        <div id="tanggal_edit">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglseleksikuesioner',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        </div>
            </div>
        </div>  
        <div class="control-group">
                <?php echo CHtml::label('Nama Petugas kuesioner', 'Nama Petugas', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $modLogin = LoginpemakaiK::model()->findByPk(Yii::app()->user->id); ?>
                <?php $modPegawai = PegawaiM::model()->findByPk($modLogin->pegawai_id); ?>
                <?php echo CHtml::textField('nama_petugas', isset($modPegawai) ? $modPegawai->nama_pegawai : " ", array('readonly' => true)) ?>
                <?php echo $form->hiddenField($model, 'petugaskuesioner_id', array('readonly' => true, 'value' => $modPegawai->pegawai_id)) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">

        <div class="control-group">
                <?php echo CHtml::label('Petugas Koreksi <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                if (empty($model->seleksidonor_id)) {
                    echo CHtml::checkBox('cek_ppds', '', array('onclick' => 'ubahDialog();'));
                } else {
                    if (!empty($model->ppds_id)) {
                        echo CHtml::checkBox('cek_ppds', true, array('disabled' => true, 'readonly' => true,'onclick' => 'ubahDialog();'));
                    } else {
                        echo CHtml::checkBox('cek_ppds', false, array('disabled' => true, 'readonly' => true,'onclick' => 'ubahDialog();'));
                    }
                }
                ?> <label>PPDS</label>
            </div>
            <div class="controls" id="petugaskoreksi">
                <?php echo $form->hiddenField($model, 'petugaskoreksi_id', array('class' => 'required')) ?>
                <div id="panelpetugaskoreksi_edit" hidden>
                <?php
                   $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'petugaskoreksi_nama',
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('/actionAutoComplete/getPegawaiRuanganLogin') . '",
                                               dataType: "json",
                                               data: {
                                                   term: request.term,
                                                   ruangan_id:' . Yii::app()->user->getState('ruangan_id') . '
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
                                                    $(this).val("");
                                                    return false;
                                                }',
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.label);
                                            $("#' . CHtml::activeId($model, 'petugaskoreksi_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span2 ',
                            'onblur' => 'if(this.value == "") $("#' . CHtml::activeId($model, 'petugaskoreksi_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPetugas'),
                    ));
                   ?>
                </div>
                <div id="panelpetugaskoreksi" hidden>
                    <?php
                        echo $form->textField($model, 'petugaskoreksi_nama', array('readonly' => true));
                    ?>
                </div>
            </div>
            <div class="controls" id="ppds" hidden>
                <?php echo $form->hiddenField($model, 'ppds_id', array('class' => '')) ?>
                <div id="panelppds_edit" hidden>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'ppds_nama',
                        'source' => 'js: function(request, response) {
                                           $.ajax({
                                               url: "' . $this->createUrl('AutocompletePPDS') . '",
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
                                                    $(this).val("");
                                                    return false;
                                                }',
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.label);
                                            $("#' . CHtml::activeId($model, 'ppds_id') . '").val(ui.item.ppds_id);
                                            return false;
                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span2 ',
                            'onblur' => 'if(this.value == "") $("#' . CHtml::activeId($model, 'ppds_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPPDS'),
                    ));
                    ?>
                </div>
                <div id="panelppds" hidden>
                <?php
                    echo $form->textField($model, 'ppds_nama', array('readonly' => true));
                ?>
                </div>
            </div>

        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama DPJP <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'dpjpkuesioner_id', array('class' => 'required')) ?>
                <div id="dpjp_edit" hidden>
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'dpjpkuesioner_nama',
                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('AutocompleteDpjp') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                ruangan_id:' . Yii::app()->user->getState('ruangan_id') . '
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
                                                    $(this).val("");
                                                    return false;
                                                }',
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.label);
                                            $("#' . CHtml::activeId($model, 'dpjpkuesioner_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 required',
                            'onblur' => 'if(this.value == "") $("#' . CHtml::activeId($model, 'dpjpkuesioner_id') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogDPJP'),
                    ));?>
                </div>
                <div id="dpjp" hidden>
                    <?php
                        echo Chtml::textField('dpjpkuesioner_nama',$model->dpjpkuesioner_nama, array('readonly' => true));
                    ?>
                </div>
            </div>

        </div>
    </div>
    <div class="clear"></div>
    <?php
    $cek = SeleksikuesionerT::model()->findByAttributes(array('daftardonasi_id' => $modDaftarDonasi->daftardonasi_id));
    ?>
    <div class="row-fluid">
        <div class="form-actions">
            <?php
            if(empty($cekSeleksi)){
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('id' => 'btn_submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);'));
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('disabled' => true, 'id' => 'btn_submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);'));
                    echo "&nbsp;";
                }
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('disabled' => true, 'id' => 'btn_submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event);'));
                echo "&nbsp;";
            }
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), '#', array('class' => 'btn btn-danger',
                'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index', array('pendonor_id' => $model->pendonor_id, 'daftardonasi_id' => $model->daftardonasi_id)) . '";} ); return false;'));
            echo "&nbsp;";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-edit icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button','onclick'=>'ubahForm();', 'onkeypress' => 'formSubmit(this,event);'));
                echo "&nbsp;";
            $content = $this->renderPartial('laboratorium.views.pemakaianBahan.tips.tipsPemakaianBahan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

</div>


<?php $this->endWidget(); ?>


<?php
$this->renderPartial('_jsFunctionTransaksi', array('form' => $form,
    'model' => $model,
    'modKuesioner' => $modKuesioner,
    'modPendonor' => $modPendonor,
    'modDaftarDonasi' => $modDaftarDonasi,
    'cekSeleksi'=>$cekSeleksi
    ));

//========= Dialog buat cari Petugas ==========
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugas',
    'options' => array(
        'title' => 'Daftar Petugas Koreksi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();
if (isset($_GET['PegawairuanganV']))
    $modPegawai->attributes = $_GET['PegawairuanganV'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugassample-m-grid',
    'dataProvider' => $modPegawai->searchPegawaiBankDarah(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
    //    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectBahan",
					"onClick" => "
						$(\'#' . Chtml::activeId($model, 'petugaskoreksi_id') . '\').val(\'$data->pegawai_id\');	
						$(\'#' . Chtml::activeId($model, 'petugaskoreksi_nama') . '\').val(\'$data->NamaLengkap\');
						$(\'#dialogPetugas\').dialog(\'close\');
						return false;"))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function($data) {
                $hasil = '';
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    $hasil = $j->jabatan_nama;
                }
                return $hasil;
            },
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= Dialog buat cari Petugas ==========
?>
<?php
/* ====================================== Widget Dialog PPDS ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPPDS',
    'options' => array(
        'title' => 'Daftar PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));
$modPPDS = new PpdsM();
$modPPDS->unsetAttributes();
$modPPDS->ppds_aktif = true;
if (isset($_GET['PpdsM'])) {
    $modPPDS->attributes = $_GET['PpdsM'];
    $modPPDS->programstudi_nama = $_GET['PpdsM']['programstudi_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPPDS->searchDialog(),
    'filter' => $modPPDS,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                        "id" => "selectBahan",
                        "onClick" => "
                                $(\'#' . Chtml::activeId($model, 'ppds_id') . '\').val(\'$data->ppds_id\');	
                                $(\'#' . Chtml::activeId($model, 'ppds_nama') . '\').val(\'$data->ppds_nama\');
                                $(\'#dialogPPDS\').dialog(\'close\');
                                return false;"))',
        ),
        array(
            'header' => 'NIM',
            'name' => 'ppds_nim'
        ),
        array(
            'header' => 'Nama PPDS',
            'name' => 'ppds_nama'
        ),
        array(
            'header' => 'Program Studi',
            'value' => '$data->programstudi->programstudi_nama',
            'filter' => Chtml::activeTextField($modPPDS, 'programstudi_nama')
        ),
        array(
            'header' => 'Tahap',
            'name' => 'ppds_tahap',
            'filter' => Chtml::activeTextField($modPPDS, 'ppds_tahap')
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Pegawai ====================================== */
?>
<?php
//========= Dialog buat cari data Keperawatan =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDPJP',
    'options' => array(
        'title' => 'Pencarian Data DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$pegawai = new PegawairuanganV();
$pegawai->unsetAttributes();
$pegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');
$pegawai->kelompokpegawai_id = 1;
if (isset($_GET['PegawairuanganV'])) {
    $pegawai->attributes = $_GET['PegawairuanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'timmedik-t-grid',
    'dataProvider' => $pegawai->search(),
    'filter' => $pegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPendaftaran",
                                        "onClick" => "
                                            $(\"#BDSeleksipendonorT_dpjpkuesioner_id\").val(\"$data->pegawai_id\"); 
                                            $(\"#BDSeleksipendonorT_dpjpkuesioner_nama\").val(\"$data->nama_pegawai\");
                                            $(\"#dialogDPJP\").dialog(\"close\");
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'filter' => Chtml::activeTextField($pegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama DPJP',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($pegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>