<?php $linkHalaman = CustomFunction::getUrlByMenuID(2480); ?>
<?php
$this->breadcrumbs = array(
    'Transaksi Pengambilan Jenazah',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0) {
    Yii::app()->user->setFlash('success', "Transaksi Pengambilan Jenazah berhasil disimpan!");
}
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengambilan Jenazah</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'ambiljenazah-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
            'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
        )); ?>
        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php //echo $form->errorSummary(array($model,$modPenyBarangs[0])); 
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->hiddenField($model, 'pasien_id', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'no_rekam_medik', array('class' => 'control-label required')); ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => $this->createUrl('AutocompletePasienJenazah'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 3,
                                'focus' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label);
                                        return false;
                                    }',
                                'select' => 'js:function( event, ui ) {
                                          $("#' . CHtml::activeId($model, 'pasien_id') . '").val(ui.item.nama_pasien);
                                          $("#' . CHtml::activeId($model, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);
                                          $("#' . CHtml::activeId($model, 'no_pendaftaran') . '").val(ui.item.nama_bin);
                                      }',
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPasien'),
                            'htmlOptions' => array(
                                'class' => 'span4',
                                'placeholder' => 'No. Rekam Medik',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglmeninggal', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglmeninggal',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker2 span4'),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglpengambilan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpengambilan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker2 span4'),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model, 'keterangan_pengambilan', array('placeholder' => 'Keterangan Pengambilan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'ruanganmeninggal_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList(
                            $model,
                            'instalasi_id',
                            $instalasi,
                            array(
                                'class' => 'span4', 'empty' => '-- Instalasi --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($model))),
                                    'update' => "#" . CHtml::activeId($model, 'ruanganmeninggal_id'),
                                )
                            )
                        ); ?><br>
                        <?php echo $form->dropDownList($model, 'ruanganmeninggal_id', $ruanganMeninggal, array('class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);", 'empty' => '-- Ruangan --')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'nama_pengambiljenazah', array('placeholder' => 'Nama Pengambil Jenazah', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'hubungan_pengjenazah', array('class' => 'control-label refreshable')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'hubungan_pengjenazah', LookupM::getItems('hubungankeluarga'), array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'noidentitas_pengjenazah', array('placeholder' => 'No. Identitas Pengambil', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($model, 'alamat_pengjenazah', array('placeholder' => 'Alamat Pengambil', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'notelepon_pengjenazah', array('placeholder' => 'No. Telepon Pengambil', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penyerahan Jenazah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table id="tblPenyBarang" class="table table-striped table-condensed table-responsive">
                    <thead>
                        <tr>
                            <th>No. Urut <span class="required">*</span></th>
                            <th>Jenis Jenazah</th>
                            <th>Nama Jenazah <span class="required">*</span></th>
                            <th>Keadaan Jenazah</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $this->renderPartial('_formPenyBarang', array('modPenyBarang' => $modPenyBarang, 'modPenyBarangs' => $modPenyBarangs, 'removeButton' => false)); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-actions">
            <?php echo
            CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'button', 'onclick' => 'cekDetail();', 'onkeypress' => 'cekDetail();', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('Index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('Index') . '";}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../pemakaianMobil/tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script type="text/javascript">
    var trPenyBarang = new String(<?php echo CJSON::encode($this->renderPartial('_formPenyBarang', array('modPenyBarang' => $modPenyBarang, 'removeButton' => true), true)); ?>);
    var trPenyBarangFirst = new String(<?php echo CJSON::encode($this->renderPartial('_formPenyBarang', array('modPenyBarang' => $modPenyBarang, 'removeButton' => false), true)); ?>);

    function addPenyBarang(obj) {
        $(obj).parents('table').children('tbody').append(trPenyBarang.replace());
        <?php
        $attributes = $modPenyBarang->attributeNames();
        foreach ($attributes as $i => $attribute) {
            echo "renameInput('" . get_class($modPenyBarang) . "','$attribute');";
        }
        ?>
        buatNoUrut();
    }

    function buatNoUrut() {
        var i = 0;
        $('input[name$="[no_urutbrg]"]').each(function() {
            i++;
            $(this).val(i);
        });
    }

    function batalPenyBarang(obj) {
        myConfirm("Apakah Anda yakin akan membatalkan?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parents('tr').detach();
                buatNoUrut();
            }
        });
    }

    function renameInput(modelName, attributeName) {
        var i = -1;
        $('#tblPenyBarang tr').each(function() {
            if ($(this).has('input[name$="[no_urutbrg]"]').length) {
                i++;
            }
            $(this).find('input[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('input[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('name', modelName + '[' + i + '][' + attributeName + ']');
            $(this).find('select[name$="[' + attributeName + ']"]').attr('id', modelName + '_' + i + '_' + attributeName + '');
        });
    }

    function setRuanganMeninggal(instalasiasalId, ruanganasalId) {
        $("#instalasi").val(instalasiasalId);
        $("#instalasi").change();
        myAlert('Otomatis mengambil dari instalasi/ruangan/unit pasien terakhir diperiksa');
        $("#<?php echo CHtml::activeId($model, 'ruanganmeninggal_id') ?>").val(ruanganasalId);
    }

    function cekDetail() {
        if (requiredCheck($("form"))) {
            var pasien_id = $('#pasien_id').val();
            var nama_barang = '';
            $('#tblPenyBarang tr').each(function() {
                nama_barang = $(this).find('input[name$="[namabarang_pasien]"]').val();
            });
            if (nama_barang == '') {
                myAlert('Silakan isikan detail jenazah terlebih dahulu!');
                return false;
            } else {
                $('#ambiljenazah-t-form').submit();
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
    $(document).ready(function() {
        cekDisabled($('#ambiljenazah-t-form'));
        //    $("#PJAmbiljenazahT_no_rekam_medik").blur(cekDisabled($('#ambiljenazah-t-form')));
    });
</script>
<?php
//========= Dialog buat cari data Pasien=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));
$modPasien = new PJPasienmasukpenunjangV('searchJenazahDialog');
$modPasien->unsetAttributes();
if (isset($_GET['PJPasienmasukpenunjangV'])) {
    $modPasien->attributes = $_GET['PJPasienmasukpenunjangV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modPasien->searchJenazahDialog(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#PJAmbiljenazahT_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                                          $(\"#PJAmbiljenazahT_jeniskelamin\").val(\"$data->jeniskelamin\");
                                                          $(\"#PJAmbiljenazahT_nama_pasien\").val(\"$data->nama_pasien\");                                                        
                                                          $(\"#PJAmbiljenazahT_pendaftaran_id\").val(\"$data->pendaftaran_id\");                                                        
                                                          $(\"#PJAmbiljenazahT_pasien_id\").val(\"$data->pasien_id\");                                                        
                                                          $(\"#dialogPasien\").dialog(\"close\");    
                                                "))',
        ),
        'no_rekam_medik',
        'nama_pasien',
        'alamat_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Dialog Pasien =============================
?>
<?php
////========= Dialog buat cari data Pendaftaran=========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
//    'id' => 'dialogPasien',
//    'options' => array(
//        'title' => 'Pencarian Pasien',
//        'autoOpen' => false,
//        'modal' => true,
//        'width' => 900,
//        'height' => 500,
//        'resizable' => false,
//    ),
//));
//
//$modPasien = new PasienmasukpenunjangV('searchJenazah');
//$modPasien->unsetAttributes();
//if (isset($_GET['PasienmasukpenunjangV'])) {
//    $modPasien->attributes = $_GET['PasienmasukpenunjangV'];
//}
//$this->widget('ext.bootstrap.widgets.BootGridView', array(
//    'id' => 'pasien-m-grid',
//    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
//    'dataProvider' => $modPasien->searchJenazah(),
//    'filter' => $modPasien,
//    'template' => "{summary}\n{items}\n{pager}",
//    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
//    'columns' => array(
//        array(
//            'header' => 'Pilih',
//            'type' => 'raw',
//            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
//                                            "id" => "selectPasien",
//                                            "onClick" => "$(\"#PJAmbiljenazahT_no_pendaftaran\").val(\"$data->no_pendaftaran\");
//                                                          $(\"#PJAmbiljenazahT_jeniskelamin\").val(\"$data->jeniskelamin\");
//                                                          $(\"#PJAmbiljenazahT_nama_pasien\").val(\"$data->nama_pasien\");                                                        
//                                                          $(\"#dialogPasien\").dialog(\"close\");    
//                                                          
//                                                "))',
//        ),
//        'no_pendaftaran',
//        'nama_pasien',
//        'alamat_pasien',
//       
//    ),
//    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
//));
//
//$this->endWidget();
////========= end Dialog Pendaftaran =============================
//
?>