<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
<p>&nbsp;</p>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rencanaanestesi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));

$myicon = new MyIcon();
?>
<style>
    .form-horizontal .control-label{
        width: 140px;
    }
</style>

<div class="panel panel-success">
    <div class ="panel-heading">
        <div class="panel-title">Data Rencana Anestesi dan Sedasi</div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <?php
            //echo $form->radioButtonListInlineRow($model, 'jenisanastesi_id', JenisAnastesiM::model()->findAll(" jenisanastesi_aktif = TRUE ORDER BY jenisanastesi_nama ASC "), array('onkeypress'=>"return $(this).focusNextInputField(event)")); 
            echo $form->dropDownListRow($model, 'jenisanastesi_id', CHtml::listData(JenisAnastesiM::model()->findAll(" jenisanastesi_aktif = TRUE ORDER BY jenisanastesi_nama ASC "), 'jenisanastesi_id', 'jenisanastesi_nama'), array('empty' => '-- Pilih --', 'class' => 'span3'));
            ?>
            <div class="control-group">
                <?php echo CHtml::label('Diagnosis Pro-Anestesi <span class="required">*</span>', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'diagnosa_praanestesi', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->hiddenField($model, 'pasienanastesi_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'diagnosa_praanestesi_nama',
                        'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('getDiagnosaM') . '",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
                                            param: "mixed",
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
                                        $("#' . CHtml::activeId($model, 'diagnosa_praanestesi') . '").val(ui.item.diagnosa_id);
                                        $("#diagnosa_praanestesi_nama").val(ui.item.diagnosa_nama);
                                        return false;
                                    }',
                        ),
                        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketik Nama Diagnosa'),
                        'tombolDialog' => array('idDialog' => 'dialogTambahDiagnosa', 'jsFunction' => 'setDialog()'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')); ?>
                <div class="controls">  
                    <?php
                    $model->tglevaluasianestesi = $format->formatDateTimeForUser($model->tglevaluasianestesi);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglevaluasianestesi',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => false, 'class' => 'span3 dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"),
                    ));
                    ?>
                </div>
            </div>
            <div class='control-group'>
                <?php
                echo CHtml::label("Ruangan <span class='required'>*</span>", '', array(
                    'class' => 'control-label'))
                ?>                                   
                <div class='controls'>
                    <?php
                    echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->getRuanganInstalasiItems(Params::INSTALASI_ID_IBS), 'ruangan_id', 'ruangan_nama'), array(
                        'empty' => '-- Pilih --',
                        'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required',
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownKamarKosong', array('encode' => false, 'namaModel' => get_class($model))),
                            'update' => '#' . CHtml::activeId($model, 'kamarruangan_id'),
                    )));
                    ?>  
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label("Kamar Ruangan", '', array('class' => 'control-label'))
                ?>      
                <div class='controls'>
                    <?php
                    echo $form->dropDownList($model, 'kamarruangan_id', !empty($model->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array(
                                                'ruangan_id' => Params::RUANGAN_ID_BEDAH, 'kamarruangan_status' => true, 'kamarruangan_aktif'=>true)), 'kamarruangan_id', 'KamarDanTempatTidur') : array(), array(
                        'empty' => '-- Pilih --',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3',
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Kru Anestesi", '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    echo CHtml::link("<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>", "javascript:;", array(
                        'class' => 'btn btn-primary',
                        'onclick' => "$('#dialogKruAnestesi').dialog('open');",
                        'rel' => 'tooltip',
                        'style'=>'padding : 8px',
                        'title' => 'Klik untuk menambah kru Anestesi yang lain '));
                    ?>
                </div>
            </div>
            <span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUANESTESI_SPESIALIS_ANESTESIOLOGI)); ?>">    
                <div class="control-group pelaksanaanestesi awal">
                    <?php echo CHtml::label('Spesialis Anestesiologi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'spesialis_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/anestesi/rencanaAnestesi/pegawaiRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                param: "mixed",
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
                                            $("#EvaluasianestesiT_spesialis_id").val( ui.item.value );	
                                            $(this).val(ui.item.label);
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'spesialis_id') . '").val(ui.item.pegawai_id);
                                            $("#EvaluasianestesiT_spesialis_nama").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Ketik Nama Pegawai'),
                            'tombolDialog' => array('idDialog' => 'dialogTambahSpesialis', 'jsFunction' => 'setDialogSpesialis()'),
                        ));
                        ?>
                        <?php echo $form->hiddenField($model, 'spesialis_id', array('class' => 'span3 kruanestesi_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php // echo $form->dropDownList($model, 'spesialis_id', CHtml::listData($model->getPegawaiItems(Params::INSTALASI_ID_ANESTESI), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 kruanestesi_id')); ?>
                    </div>
                </div>
                <?php
                $cekSpesialis = ATPelaksanaanestesiT::model()->findAllByAttributes(array('evaluasianestesi_id' => $model->evaluasianestesi_id, 'kruanestesi' => Params::KRUANESTESI_SPESIALIS_ANESTESIOLOGI));
                if (!empty($cekSpesialis)) {
                    $i = 0;
                    foreach ($cekSpesialis as $val1) {
                        $cekPegawai = PegawaiM::model()->findByPk($val1['pegawai_id']);
                        $val1['pegawai_nama'] = !empty($cekPegawai) ? $cekPegawai->nama_pegawai : '';
                        $this->renderPartial('_rowKruAnestesi', array('length' => count($cekSpesialis), 'model' => $val1, 'i' => $i));
                    }
                }
                ?>
            </span>
            <span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUANESTESI_PPDS_ANESTESIOLOGI)); ?>">    
                <div class="control-group pelaksanaanestesi awal">
                    <?php echo CHtml::label('PPDS Anastesiologi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'ppds_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/anestesi/rencanaAnestesi/ppds') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                param: "mixed",
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
                                            $("#EvaluasianestesiT_ppds_id").val( ui.item.value );	
                                            $(this).val(ui.item.label);
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'ppds_id') . '").val(ui.item.ppds_id);
                                            $("#EvaluasianestesiT_ppds_nama").val(ui.item.ppds_nama);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Ketik Nama PPDS'),
                            'tombolDialog' => array('idDialog' => 'dialogTambahPpds', 'jsFunction' => 'setDialogPpds()'),
                        ));
                        ?>
                        <?php echo $form->hiddenField($model, 'ppds_id', array('class' => 'span3 kruanestesi_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php // echo $form->dropDownList($model, 'ppds_id', CHtml::listData(PpdsM::model()->findAllByAttributes(array('ppds_aktif'=>true, 'verifikasi_status'=>'Disetujui'),array('order'=>'ppds_nama ASC')), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 kruanestesi_id')); ?>
                    </div>
                </div>
                <?php
                $cekPPDS = ATPelaksanaanestesiT::model()->findAllByAttributes(array('evaluasianestesi_id' => $model->evaluasianestesi_id, 'kruanestesi' => Params::KRUANESTESI_PPDS_ANESTESIOLOGI));
                if (!empty($cekPPDS)) {
                    $i = 0;
                    foreach ($cekPPDS as $val1) {
                        $cekPpds = PpdsM::model()->findByPk($val1['ppds_id']);
                        $val1['pegawai_nama'] = !empty($cekPpds) ? $cekPpds->ppds_nama : '';
                        $this->renderPartial('_rowKruAnestesi', array('length' => count($cekPPDS), 'model' => $val1, 'i' => $i));
                    }
                }
                ?>
            </span>
            <span id="urut-<?php echo str_replace(' ', '-', strtolower(Params::KRUANESTESI_ASISTEN_PERAWAT)); ?>">
                <div class="control-group pelaksanaanestesi awal">
                    <?php echo CHtml::label('Asisten/Perawat Anastesi', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'perawat_nama',
                            'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/anestesi/rencanaAnestesi/pegawaiRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                param: "mixed",
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
                                            $("#EvaluasianestesiT_perawat_id").val( ui.item.value );	
                                            $(this).val(ui.item.label);
                                            return false;
                                        }',
                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'perawat_id') . '").val(ui.item.pegawai_id);
                                            $("#EvaluasianestesiT_perawat_nama").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Ketik Nama Pegawai'),
                            'tombolDialog' => array('idDialog' => 'dialogTambahPerawat', 'jsFunction' => 'setDialogPerawat()'),
                        ));
                        ?>
                        <?php echo $form->hiddenField($model, 'perawat_id', array('class' => 'span3 kruanestesi_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php // echo $form->dropDownList($model, 'perawat_id', CHtml::listData($model->getPegawaiItems(Params::INSTALASI_ID_ANESTESI), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 kruanestesi_id')); ?>
                    </div>
                </div>
                <?php
                $cekAsisten = ATPelaksanaanestesiT::model()->findAllByAttributes(array('evaluasianestesi_id' => $model->evaluasianestesi_id, 'kruanestesi' => Params::KRUANESTESI_ASISTEN_PERAWAT));
                if (!empty($cekAsisten)) {
                    $i = 0;
                    foreach ($cekAsisten as $val1) {
                        $cekPegawai = PegawaiM::model()->findByPk($val1['pegawai_id']);
                        $val1['pegawai_nama'] = !empty($cekPegawai) ? $cekPegawai->nama_pegawai : '';
                        $this->renderPartial('_rowKruAnestesi', array('length' => count($cekAsisten), 'model' => $val1, 'i' => $i));
                    }
                }
                ?>
            </span>
        </div>
    </div> 
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
    echo "&nbsp;";

    if (!isset($_GET['frame'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), $this->createUrl($this->id . '/index&pendaftaran_id=' . $_GET['pendaftaran_id'] . '&pasienkirimkeunitlain_id=' . $_GET['pasienkirimkeunitlain_id']), array('class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'));
    }
    echo "&nbsp;";
    $content = $this->renderPartial($this->path_view . 'tips/tipsRencanaTindakanObat', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?> 
</div>	
<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogKruAnestesi',
    'options' => array(
        'title' => 'Tambah Kru Anestesi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 200,
        'resizable' => false,
        'position' => 'center',
    ),
));
echo $this->renderPartial($this->path_view . '_formTambahKruAnestesi', array(), true);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTambahDiagnosa',
    'options' => array(
        'title' => 'Daftar Diagnosis ICD 10',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modDiagnosa = new DiagnosaM('searchDialog');
$modDiagnosa->unsetAttributes();
if (isset($_GET['DiagnosaM'])) {
    $modDiagnosa->attributes = $_GET['DiagnosaM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'PPdiagnosa-m-grid',
    'dataProvider' => $modDiagnosa->search(),
    'filter' => $modDiagnosa,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;

                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                            "class" => "btn-small",
                            "id" => "selectProgramstudi",
                            "onClick" => "setData(" . $res . ")"));
            }
        ),
        'diagnosa_kode',
        array(
            'header' => 'Diagnosis',
            'name' => 'diagnosa_nama',
            'value' => '$data->diagnosa_nama',
        ),
        array(
            'header' => 'Catatan',
            'name' => 'diagnosa_namalainnya',
            'value' => '$data->diagnosa_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Spesialis =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTambahSpesialis',
    'options' => array(
        'title' => 'Daftar Spesialis Anestesiologi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modSpesialis = new PegawairuanganV('searchDialogPegRuangan');
$modSpesialis->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modSpesialis->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'spesialis-m-grid',
    'dataProvider' => $modSpesialis->searchDialogPegRuangan(),
    'filter' => $modSpesialis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;

                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                            "class" => "btn-small",
                            "id" => "selectProgramstudi",
                            "onClick" => "setDataSpesialis(" . $res . ")"));
            }
        ),
        'nama_pegawai',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Perawat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTambahPerawat',
    'options' => array(
        'title' => 'Daftar Asisten/Perawat Anastesi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modSpesialis = new PegawairuanganV('searchDialogPegRuangan');
$modSpesialis->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modSpesialis->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat-m-grid',
    'dataProvider' => $modSpesialis->searchDialogPegRuangan(),
    'filter' => $modSpesialis,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;

                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                            "class" => "btn-small",
                            "id" => "selectProgramstudi",
                            "onClick" => "setDataPerawat(" . $res . ")"));
            }
        ),
        'nama_pegawai',
        'nomorindukpegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>

<?php
//========= Dialog buat cari Ppds =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTambahPpds',
    'options' => array(
        'title' => 'Daftar PPDS Anestesiologi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
$modPpds= new PpdsM('searchPPDSPelayanan');
$modPpds->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ppds-m-grid',
    'dataProvider' => $modPpds->searchPPDSPelayanan(),
    'filter' => $modPpds,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $res = $data->attributes;

                $res = json_encode($res);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                            "class" => "btn-small",
                            "id" => "selectProgramstudi",
                            "onClick" => "setDataPpds(" . $res . ")"));
            }
        ),
        'ppds_nama',
        'ppds_nim',
        'ppds_nik',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )
);
$this->endWidget();
?>
<script type="text/javascript">
    function tambahLookup() {
        var p = prompt("Tambah Kru Anestesi Baru ");

        if (p === null) {
            return false;
        } else if (p == '') {
            alert("Maaf, kru Anestesi belum diisi !");
            return false;
        } else {
            var yes = confirm("Apakah anda yakin ingin menambahkan kru Anestesi baru ? ");

            if (yes) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('AddLookupKruAnestesi'); ?>',
                    data: {kruanestesi: p},
                    dataType: "json",
                    success: function (data) {
                        if (data.sukses == 1) {
                            var lookup = data.look;
                            alert(data.pesan);
                            $("#lookupKruAnestesi").html(data.drop);
                            $(".lookupkruAnestesi:last").after("<span id='urut-" + lookup.toLowerCase().replace(/\s/g, '-') + "' class='lookupkruAnestesi'></span>");
                        } else {
                            alert(data.pesan);
                            return false;
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            } else {
                return false;
            }
        }
    }

    function simpanKruPegawai() {
        var id = $("#kruAnestesiId").val();
        var lookup = $("#lookupKruAnestesi").val();

        if (lookup == '') {
            $("#lookupKruAnestesi").attr("style", "border:1px solid red;");
        } else {
            $("#lookupKruAnestesi").attr("style", "");
        }

        if (id == '') {
            $("#kruAnestesiNama").attr("style", "border:1px solid red;");
            $("#kruAnestesiNama2").attr("style", "border:1px solid red;");
        } else {
            $("#kruAnestesiNama").attr("style", "");
            $("#kruAnestesiNama2").attr("style", "");
        }



        if (id != '' && lookup != '') {
            var length = $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaanestesi").length;

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('AddKruAnestesi'); ?>',
                data: {id: id, lookup: lookup, length: length},
                dataType: "json",
                success: function (data) {
                    if (data.sukses == 1) {
                        var cek = true;
                        $("#urut-" + lookup.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaanestesi").each(function () {
                            if ($(this).find(".kruanestesi_id").val() == data.id) {
                                myAlert("Maaf, pegawai ini sudah ditambahkan pada Kru Anestesi " + data.look);
                                cek = false;
                            }
                        });

                        if (cek == true) {
                            $("#urut-" + data.lookup).append(data.div);
                            renameInputRowPelaksanaAnestesi();
                            $("#kruAnestesiId").val('');
                            $("#kruAnestesiNama").val('');
                            $("#kruAnestesiNama2").val('');
                            $("#lookupKruAnestesi").val('');
                            $('#dialogKruAnestesi').dialog('close');
                        } else {
                            return false;
                        }

                    } else {
                        myAlert(data.pesan);
                        return false;
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        } else {
            myAlert("Maaf, Kru Bedah dan Nama Pegawai/PPDS harus diisi");
            return false;
        }
    }

    function renameInputRowPelaksanaAnestesi() {
        var row = 0;

        $(".pelaksanaanestesi").each(function () {
            $(this).find('input,select,textarea').each(function () { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            if (($(this).hasClass('awal'))) {

            } else {
                row++;
            }
        });
    }

    function removeData(obj, st) {
        $(obj).parents('.pelaksanaanestesi').attr('style', 'border:1px solid red;');

        myConfirm('Apakah anda akan menghapus data ini??', 'Perhatian!',
        function (r) {
            if (r) {
                $(obj).parents('.pelaksanaanestesi').remove();
                renameInputRowPelaksanaAnestesi();
                var row = 0;
                $("#urut-" + st.toLowerCase().replace(/\s/g, '-')).find(".pelaksanaanestesi").each(function () {
                    if (($(this).hasClass('awal'))) {

                    } else {
                        if (row == 0) {
                            $(this).find('.gantilabel').html(st);
                        }
                    }
                    row++;
                });
            }
        });

    }

    function removeDataFromDb(obj) {
        myConfirm('Apakah anda akan menghapus data ini??', 'Perhatian!',
        function (r) {
            if (r) {
                $(obj).parents('.pelaksanaanestesi').hide();
                $(obj).parents(".pelaksanaanestesi").find(".status").val(1);
            }
        });
    }
    
    function setDialog() {
        $("#dialogTambahDiagnosa").dialog("open");
    }

    function setData(data) {
        $("#<?php echo CHtml::activeId($model, 'diagnosa_praanestesi_nama') ?>").val(data.diagnosa_nama);
        $("#<?php echo CHtml::activeId($model, 'diagnosa_praanestesi') ?>").val(data.diagnosa_id);


        $("#dialogTambahDiagnosa").dialog('close');
    }
    
    //Spesialis
    function setDialogSpesialis() {
        $("#dialogTambahSpesialis").dialog("open");
    }
    
    function setDataSpesialis(data) {
        $("#<?php echo CHtml::activeId($model, 'spesialis_id') ?>").val(data.pegawai_id);
        $("#EvaluasianestesiT_spesialis_nama").val(data.nama_pegawai);


        $("#dialogTambahSpesialis").dialog('close');
    }
    
    //Perawat
    function setDialogPerawat() {
        $("#dialogTambahPerawat").dialog("open");
    }
    
    function setDataPerawat(data) {
        $("#<?php echo CHtml::activeId($model, 'perawat_id') ?>").val(data.pegawai_id);
        $("#EvaluasianestesiT_perawat_nama").val(data.nama_pegawai);


        $("#dialogTambahPerawat").dialog('close');
    }
    
    //PPDS
    function setDialogPpds() {
        $("#dialogTambahPpds").dialog("open");
    }
    
    function setDataPpds(data) {
        $("#<?php echo CHtml::activeId($model, 'ppds_id') ?>").val(data.ppds_id);
        $("#EvaluasianestesiT_ppds_nama").val(data.ppds_nama);


        $("#dialogTambahPpds").dialog('close');
    }
    
    $(document).ready(function () {

        $('form').bind('click keyup select change', function (event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function () {
            cekDisabled('form');
        });
        cekDisabled('form');
    });
</script>

