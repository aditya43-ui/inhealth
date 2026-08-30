<?php $linkHalaman = CustomFunction::getUrlByMenuID(947); ?>
<style type="text/css">
    .td_date input {
        float: left !important;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Pencatatan Pelamar',
);
$sukses = null;
if (isset($_GET['id'])) {
    $sukses = $_GET['id'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', 'Data Pelamar ' . $model->nama_pelamar . ' Berhasil Disimpan.');
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pelamar-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#' . CHtml::activeId($model, 'noidentitas'),
)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pencatatan <b>Pelamar</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pelamar</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->errorSummary(array($model, $modBahasa, $modLingkunganKerja)); ?>
                <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <fieldset class='box row'>
                    <?php echo $this->renderPartial('_formPelamar', array('model' => $model, 'form' => $form)); ?>
                </fieldset>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kemampuan / Skill Pelamar</b>
                </div>
            </div>
            <div class="panel-body">
                <!--================================================================================== INPUT KEMAMPUAN SKILL PELAMAR ===============================-->
                <div class="block-tabel">
                    <table class="items table table-bordered table-striped table-condensed" id="tblInputSkill">
                        <thead>
                            <th>No.</th>
                            <th>Kemampuan / Skill</th>
                            <th>Tingkat / Level</th>
                            <th>Jenis Sertifikasi</th>
                            <th>Masa Berlaku Sertifikasi</th>
                            <th>&nbsp;</th>
                        </thead>
                        <?php
                        echo $this->renderPartial('_addSkill', array('modKemampuanPelamars' => $modKemampuanPelamars, 'modKemampuanPelamar' => $modKemampuanPelamar, 'form' => $form, 'btnHapus' => false), true);
                        ?>
                    </table>
                </div>
                <!--================================================================================== AKHIR KEMAMPUAN SKILL BAHASA===============================-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pengalaman Kerja</b>
                </div>
            </div>
            <div class="panel-body">
                <!--================================================================================== INPUT PENGALAMAN KERJA ===============================-->
                <div class="block-tabel">
                    <table class="table table-bordered table-striped table-condensed" id="tblInputPengalamankerja">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama perusahaan</th>
                                <th>Bidang usaha</th>
                                <th>Jabatan</th>
                                <th>Tgl. masuk</th>
                                <th>Tgl. keluar</th>
                                <th>Lama kerja</th>
                                <th>Alasan berhenti</th>
                                <th>Keterangan</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($modPengalamankerjas)) {
                                foreach ($modPengalamankerjas as $i => $modPengalamankerja) {
                                    echo $this->renderPartial('_addPengalamankerja', array('modPengalamankerja' => $modPengalamankerja, 'i' => $i, 'form' => $form), true);
                                }
                            } else {
                                echo $this->renderPartial('_addPengalamankerja', array('modPengalamankerja' => $modPengalamankerja, 'form' => $form), true);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!--================================================================================== AKHIR PENGALAMAN KERJA===============================-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Referensi Kerja</b>
                </div>
            </div>
            <div class="panel-body">
                <!--================================================================================== INPUT REFERENSI KERJA ===============================-->
                <div class="block-tabel">
                    <table class="table table-bordered table-striped table-condensed" id="tblInputReferensikerja">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Instansi</th>
                                <th>Jabatan</th>
                                <th>No. Telepon</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($modReferensiKerjas)) {
                                foreach ($modReferensiKerjas as $i => $modReferensiKerja) {
                                    echo $this->renderPartial('_addReferensikerja', array('modReferensiKerja' => $modReferensiKerja, 'i' => $i, 'form' => $form), true);
                                }
                            } else {
                                echo $this->renderPartial('_addReferensikerja', array('modReferensiKerja' => $modReferensiKerja, 'form' => $form), true);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!--================================================================================== AKHIR REFERENSI KERJA===============================-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kemampuan Bahasa Pelamar</b>
                </div>
            </div>
            <div class="panel-body">
                <!--================================================================================== INPUT KEMAMPUAN BAHASA PELAMAR ===============================-->
                <div class="block-tabel">
                    <table class="items table table-bordered table-striped table-condensed" id="tblInputBahasa">
                        <thead>
                            <th>No.</th>
                            <th>Bahasa</th>
                            <th>Mengerti</th>
                            <th>Berbicara</th>
                            <th>Menulis</th>
                            <th>&nbsp;</th>
                        </thead>
                        <?php
                        echo $this->renderPartial('_addBahasa', array('modBahasa' => $modBahasa, 'modBahasas' => $modBahasas, 'form' => $form, 'btnHapus' => false), true);
                        ?>
                    </table>
                </div>
                <!--================================================================================== AKHIR INPUT KEMAMPUAN BAHASA===============================-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Lingkungan Kerja Pelamar</b>
                </div>
            </div>
            <div class="panel-body">
                <!--================================================================================== INPUT LINGKUNGAN KERJA PELAMAR ===============================-->
                <div class="block-tabel">
                    <table class="items table table-bordered table-striped table-condensed" id="tblInputLingkunganKerja">
                        <thead>
                            <th>No.</th>
                            <th>Dengan Lingkungan</th>
                            <th>Keterangan</th>
                            <th>&nbsp;</th>
                        </thead>
                        <?php
                        echo $this->renderPartial('_addLingkunganKerja', array('modLingkunganKerja' => $modLingkunganKerja, 'modLingkunganKerjas' => $modLingkunganKerjas, 'form' => $form, 'btnHapus' => false), true);
                        ?>
                    </table>
                </div>
                <!--================================================================================== AKHIR INPUT LINGKUNGAN KERJA===============================-->
            </div>
        </div>
        <div class="row" style="margin-top: 17px;">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Menyetujui <span class='required'>*</span>", 'menyetujui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model, 'menyetujui_id'); ?>
                        <div style="float:left;">
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'menyetujui_nama',
                                'sourceUrl' => Yii::app()->createUrl('kepegawaian/PelamarT/pegawaiMenyetujui'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'select' => 'js:function( event, ui ) {
                                                $("#KPPelamarT_menyetujui_id").val(ui.item.pegawai_id);   
                                                $("#KPPelamarT_menyetujui_nama").val(ui.item.NamaLengkap);
                                            }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogMenyetujui'),
                                'htmlOptions' => array(
                                    'placeholder' => 'Menyetujui',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'menyetujui_id') . '").val(""); ',
                                    'class' => 'span3 required', 'style' => 'float:left;'
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Mengetahui <span class='required'>*</span>", 'mengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeHiddenField($model, 'mengetahui_id'); ?>
                        <div style="float:left;">
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'mengetahui_nama',
                                'sourceUrl' => Yii::app()->createUrl('kepegawaian/PelamarT/pegawaiMenyetujui'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'select' => 'js:function( event, ui ) {
                                                $("#KPPelamarT_mengetahui_id").val(ui.item.pegawai_id);   
                                                $("#KPPelamarT_mengetahui_nama").val(ui.item.NamaLengkap);
                                            }',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogMengetahui'),
                                'htmlOptions' => array(
                                    'placeholder' => 'Mengetahui',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'mengetahui_id') . '").val(""); ',
                                    'class' => 'span3 required', 'style' => 'float:left;'
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'validasiPelamar();', 'onkeypress' => 'validasiPelamar();', 'disabled' => $disableSave)
            ); //formSubmit(this,event)        
            //  jika tanpa validasiPelamar 
            /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
                                        array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
             * 
             */
            ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/create'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $content = $this->renderPartial('tips/tipsPelamar', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
//========= Dialog  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
$modApproval = ApprovalotorisasiM::model()->find();
$classPegawai = 'PegawaiV';
$modPemberiTugas = new $classPegawai('search');
$modPemberiTugas->unsetAttributes();
if (isset($_GET[$classPegawai])) {
    $modPemberiTugas->attributes = $_GET[$classPegawai];
}
$modPemberiTugas->pegawai_id = $modApproval->direkturrs_id;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menyetujui-grid',
    'dataProvider' => $modPemberiTugas->searchPegawaiRuangan(),
    'filter' => $modPemberiTugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                "id" => "selectPemberiTugas",
                                "onClick" => "$(\"#KPPelamarT_menyetujui_id\").val(\"$data->pegawai_id\");
                                              $(\"#' . CHtml::activeId($model, 'menyetujui_nama') . '\").val(\"$data->nama_pegawai\");
                                              $(\"#dialogMenyetujui\").dialog(\"close\");    
                                              return false;
                                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => false,
            //				'filter' => CHtml::activeDropDownList($modPemberiTugas, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end dialog =============================
?>
<?php
//========= Dialog  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMengetahui',
    'options' => array(
        'title' => 'Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 400,
        'resizable' => false,
    ),
));
$classPegawai = 'PegawaiV';
$modPemberiTugas = new $classPegawai('search');
$modPemberiTugas->unsetAttributes();
$modApproval = ApprovalotorisasiM::model()->find();
if (isset($_GET[$classPegawai])) {
    $modPemberiTugas->attributes = $_GET[$classPegawai];
}
$modPemberiTugas->pegawai_id = $modApproval->bagiankepegawaian_id;
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'mengetahui-grid',
    'dataProvider' => $modPemberiTugas->searchPegawaiRuangan(),
    'filter' => $modPemberiTugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                "id" => "selectPemberiTugas",
                                "onClick" => "$(\"#KPPelamarT_mengetahui_id\").val(\"$data->pegawai_id\");
                                              $(\"#' . CHtml::activeId($model, 'mengetahui_nama') . '\").val(\"$data->nama_pegawai\");
                                              $(\"#dialogMengetahui\").dialog(\"close\");    
                                              return false;
                                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => false,
            //				'filter' => CHtml::activeDropDownList($modPemberiTugas, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);
                if (!empty($j)) {
                    return $j->jabatan_nama;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end dialog =============================
?>
<!--/div-->
<script type="text/javascript">
    //========================================================== ADD ROW KEMAMPUAN
    function addRowSkill(obj) {
        if (validasiDetailSkill()) {
            var trAddSkill = new String(<?php echo CJSON::encode($this->renderPartial('_addSkill', array('modKemampuanPelamar' => $modKemampuanPelamar, 'form' => $form, 'btnHapus' => true), true)); ?>);
            $(obj).parents('table').children('tbody').append(trAddSkill.replace());
            renameInput($("#tblInputSkill"));
        }
    }

    function batalSkill(obj) {
        myConfirm("Apakah Anda akan membatalkan data ini?",
            "Perhatian!",
            function(r) {
                if (r) {
                    $(obj).parents('tr').detach();
                    renameInput($("#tblInputSkill"));
                }
            });
    }

    function renameInput(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                if ($(this).attr("name") != undefined) {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
        $(obj_table).find('input[name$="[masaberlaku_sertifikasi]"]').datepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'showSecond': false,
                    'timeOnlyTitle': 'Pilih Waktu',
                    'timeFormat': 'hh:mm:ss',
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'yearRange': '-80y:+20y',
                }
            )
        );
        $(obj_table).find('input[name$="[masaberlaku_sertifikasi]"]').each(function() {
            var obj = $(this);
            $(this).parent().find(".add-on").click(function() {
                $(obj).focus();
            });
        });
    }

    function tambahPengalamankerja() {
        if (validasiDetailPengalamanKerja()) {
            var trAdd = new String(<?php echo CJSON::encode($this->renderPartial('_addPengalamankerja', array('modPengalamankerja' => $modPengalamankerja, 'form' => $form), true)); ?>);
            $("#tblInputPengalamankerja").find('tbody').append(trAdd.replace());
            renameInputPengalamanKerja($("#tblInputPengalamankerja"));
        }
    }

    function hapusPengalamankerja(obj) {
        myConfirm("Apakah Anda akan membatalkan data ini?",
            "Perhatian!",
            function(r) {
                if (r) {
                    $(obj).parents('tr').detach();
                    if ($("#tblInputPengalamankerja").find('tbody tr').length == 0) {
                        tambahPengalamankerja();
                    } else {
                        renameInputPengalamanKerja($("#tblInputPengalamankerja"));
                    }
                }
            });
    }

    function renameInputPengalamanKerja(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('span').each(function() { //element <input>
                if ($(this).attr("name") != undefined) {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                    if (old_name_arr[2] == 'pengalamankerja_nourut') {
                        $(this).val(row + 1);
                    }
                }
            });
            row++;
        });
        $(obj_table).find('input[name$="[tglmasuk]"]').datepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'showSecond': false,
                    'timeOnlyTitle': 'Pilih Waktu',
                    'timeFormat': 'hh:mm:ss',
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'yearRange': '-80y:+20y',
                }
            )
        );
        $(obj_table).find('input[name$="[tglmasuk]"]').each(function() {
            var obj = $(this);
            $(this).parent().find(".add-on").click(function() {
                $(obj).focus();
            });
        });
        $(obj_table).find('input[name$="[tglkeluar]"]').datepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'showSecond': false,
                    'timeOnlyTitle': 'Pilih Waktu',
                    'timeFormat': 'hh:mm:ss',
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'yearRange': '-80y:+20y',
                }
            )
        );
        $(obj_table).find('input[name$="[tglkeluar]"]').each(function() {
            var obj = $(this);
            $(this).parent().find(".add-on").click(function() {
                $(obj).focus();
            });
        });
    }

    function tambahReferensikerja() {
        if (validasiDetailReferensikerja()) {
            var trAdd = new String(<?php echo CJSON::encode($this->renderPartial('_addReferensikerja', array('modReferensiKerja' => $modReferensiKerja, 'form' => $form), true)); ?>);
            $("#tblInputReferensikerja").find('tbody').append(trAdd.replace());
            renameInputReferensikerja($("#tblInputReferensikerja"));
        }
    }

    function hapusReferensikerja(obj) {
        myConfirm("Apakah Anda akan membatalkan data ini?",
            "Perhatian!",
            function(r) {
                if (r) {
                    $(obj).parents('tr').detach();
                    if ($("#tblInputReferensikerja").find('tbody tr').length == 0) {
                        tambahReferensikerja();
                    } else {
                        renameInputReferensikerja($("#tblInputReferensikerja"));
                    }
                }
            });
    }

    function renameInputReferensikerja(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                if ($(this).attr("name") != undefined) {
                    var old_name = $(this).attr("name").replace(/]/g, "");
                    var old_name_arr = old_name.split("[");
                    if (old_name_arr.length == 3) {
                        $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }

    function addRowBahasa(obj) {
        if (validasiDetailBahasa()) {
            var trAddBahasa = new String(<?php echo CJSON::encode($this->renderPartial('_addBahasa', array('modBahasa' => $modBahasa, 'modBahasas' => $modBahasas, 'form' => $form, 'btnHapus' => true), true)); ?>);
            $(obj).parents('table').children('tbody').append(trAddBahasa.replace());
            <?php
            $attributes = $modBahasa->attributeNames();
            foreach ($attributes as $i => $attribute) {
                echo "renameInputBahasa('KPKemampuanBahasaR','$attribute');";
            }
            ?>
            renameInputBahasa('KPKemampuanBahasaR', 'no_urut');
            renameInputBahasa('KPKemampuanBahasaR', 'bahasa');
            renameInputBahasa('KPKemampuanBahasaR', 'mengerti_l');
            renameInputBahasa('KPKemampuanBahasaR', 'berbicara_l');
            renameInputBahasa('KPKemampuanBahasaR', 'menulis_l');
        }
    }

    function batalBahasa(obj) {
        if (confirm('Apakah Anda yakin akan membatalkan data ini?')) {
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
        }
    }

    function renameInputBahasa(modelName, attributeName) {
        var trLength = $('#tblInputBahasa tr').length;
        var i = -1;
        $('#tblInputBahasa tr').each(function() {
            if ($(this).has('input[name$="[bahasa]"]').length) {
                i++;
                $("#KPKemampuanBahasaR_" + i + "_no_urut").val((i + 1));
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }
    //INI UNTUK LINGKUNGAN KERJA
    function addRowLingkunganKerja(obj) {
        if (validasiDetailLingker()) {
            var trAddLingkunganKerja = new String(<?php echo CJSON::encode($this->renderPartial('_addLingkunganKerja', array('modLingkunganKerja' => $modLingkunganKerja, 'modLingkunganKerjas' => $modLingkunganKerjas, 'form' => $form, 'btnHapus' => true), true)); ?>);
            $(obj).parents('table').children('tbody').append(trAddLingkunganKerja.replace());
            <?php
            $attributes = $modLingkunganKerja->attributeNames();
            foreach ($attributes as $i => $attribute) {
                echo "renameInputLingkunganKerja('LingkungankerjaR','$attribute');";
            }
            ?>
            renameInputLingkunganKerja('LingkungankerjaR', 'dgnlingkungan_l');
            renameInputLingkunganKerja('LingkungankerjaR', 'keterangan');
            renameInputLingkunganKerja('LingkungankerjaR', 'nourut');
        }
    }

    function batalLingkunganKerja(obj) {
        if (confirm('Apakah Anda yakin akan membatalkan data ini?')) {
            $(obj).parents('tr').next('tr').detach();
            $(obj).parents('tr').detach();
        }
    }

    function renameInputLingkunganKerja(modelName, attributeName) {
        var trLength = $('#tblInputLingkunganKerja tr').length;
        var i = -1;
        $('#tblInputLingkunganKerja tr').each(function() {
            if ($(this).has('select[name$="[dgnlingkungan_l]"]').length) {
                i++;
                $("#LingkungankerjaR_" + i + "_nourut").val((i + 1));
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('textarea[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(130)
                    .height(150);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function validasiPelamar() {
        var notelp_pelamar = $('#<?php echo  CHtml::activeId($model, 'notelp_pelamar'); ?>').val();
        var nomobile_pelamar = $('#<?php echo  CHtml::activeId($model, 'nomobile_pelamar'); ?>').val();
        $('#<?php echo  CHtml::activeId($model, 'notelp_pelamar'); ?>').removeClass("error");
        $('#<?php echo  CHtml::activeId($model, 'nomobile_pelamar'); ?>').removeClass("error");
        if (notelp_pelamar == '' && nomobile_pelamar == '') {
            myAlert("Silakan isi yang bertanda bintang &lt;span class='required'&gt;*&lt;/span&gt; !");
            $('#<?php echo  CHtml::activeId($model, 'notelp_pelamar'); ?>').addClass("error");
            $('#<?php echo  CHtml::activeId($model, 'nomobile_pelamar'); ?>').addClass("error");
            return false;
        }
        if (requiredCheck($("form"))) {
            if (validasiDetail()) {
                $('#pelamar-t-form').submit();
            } else {
                return false;
            }
            $(".animation-loading").removeClass("animation-loading");
            $("form").find('.float').each(function() {
                $(this).val(formatFloat($(this).val()));
            });
            $("form").find('.integer').each(function() {
                $(this).val(formatInteger($(this).val()));
            });
        }
        return false;
    }

    function validasiDetail() {
        if (validasiDetailBahasa() && validasiDetailLingker())
            return true;
        else
            return false
    }

    function validasiDetailBahasa() {
        var detailReq = document.getElementsByClassName("isDetailReq");
        var jml = detailReq.length;
        var adaKosong = false;
        for (i = 0; i < jml; i++) {
            if (detailReq[i].value == "") {
                myAlert('Silakan lengkapi semua Data Kemampuan Bahasa!');
                adaKosong = true;
                break;
            }
        }
        if (adaKosong)
            return false;
        else
            return true;
    }

    function validasiDetailSkill() {
        $('#tblInputSkill').find('.isDetailReq3');
        var adaKosong = false;
        for (i = 0; i < $('#tblInputSkill').find('.isDetailReq3').length; i++) {
            if ($('#tblInputSkill').find('.isDetailReq3').eq(i).val() == "") {
                myAlert('Silakan lengkapi semua Data Kemampuan Skill!');
                adaKosong = true;
                break;
            }
        }
        if (adaKosong)
            return false;
        else
            return true;
    }

    function validasiDetailPengalamanKerja() {
        $('#tblInputPengalamankerja').find('.isDetailReq3');
        var adaKosong = false;
        for (i = 0; i < $('#tblInputPengalamankerja').find('.isDetailReq3').length; i++) {
            if ($('#tblInputPengalamankerja').find('.isDetailReq3').eq(i).val() == "") {
                myAlert('Silakan lengkapi semua Data Pengalaman Kerja!');
                adaKosong = true;
                break;
            }
        }
        if (adaKosong)
            return false;
        else
            return true;
    }

    function validasiDetailReferensikerja() {
        $('#tblInputReferensikerja').find('.isDetailReq3');
        var adaKosong = false;
        for (i = 0; i < $('#tblInputReferensikerja').find('.isDetailReq3').length; i++) {
            if ($('#tblInputReferensikerja').find('.isDetailReq3').eq(i).val() == "") {
                myAlert('Silakan lengkapi semua Data Referensi Kerja!');
                adaKosong = true;
                break;
            }
        }
        if (adaKosong)
            return false;
        else
            return true;
    }

    function validasiDetailLingker() {
        var detailReq = document.getElementsByClassName("isDetailReq2");
        var jml = detailReq.length;
        var adaKosong = false;
        for (i = 0; i < jml; i++) {
            if (detailReq[i].value == "") {
                myAlert('Silakan Isi Field \'Dengan Lingkungan\' ! ');
                adaKosong = true;
                break;
            }
        }
        if (adaKosong)
            return false;
        else
            return true;
    }

    function konfirmasi() {
        location.reload();
    }

    function print(caraPrint) {
        var pelamar_id = '<?php echo isset($model->pelamar_id) ? $model->pelamar_id : null ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&pelamar_id=' + pelamar_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }
    $(document).ready(function() {
        renameInput($("#tblInputSkill"));
        renameInputPengalamanKerja($("#tblInputPengalamankerja"));
        renameInputReferensikerja($("#tblInputReferensikerja"));
    });
</script>