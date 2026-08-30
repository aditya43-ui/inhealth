<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sadaftar-tindakan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekTindakan(this);return false;'),
    'focus' => '#SADaftarTindakanM_komponenunit_id',
)); ?>

<style>
    .row+.row {
        margin-top: 17px;
    }
</style>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'komponenunit_id',  CHtml::listData($model->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'kelompoktindakan_id',  CHtml::listData($model->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'daftartindakan_nama', array('placeholder' => 'Uraian Tindakan', 'class' => 'span3', 'onkeyup' => 'namaLain(this);', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->checkBoxRow($model, 'daftartindakan_aktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>

    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'daftartindakan_namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->dropDownListRow($model, 'kategoritindakan_id',  CHtml::listData($model->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'), array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'daftartindakan_kode', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'tindakanmedis_nama', array('placeholder' => 'Uraian Tindakan Medis', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'daftartindakan_katakunci', array('placeholder' => 'Kata Kunci', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30)); ?>
        <div class="control-group">
            <?php echo CHtml::label("Kelompok Tindakan BPJS", 'kelompoktindakanbpjs_id', array('class' => 'control-label')) ?>
            <div class="controls">
            <?php echo $form->dropDownList($model, 'kelompoktindakanbpjs_id', CHtml::listData(KelompoktindakanbpjsM::model()->findAll('kelompoktindakakanbpjs_aktif = true order by kelompoktindakanbpjs_nama asc'), 'kelompoktindakanbpjs_id', 'kelompoktindakanbpjs_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Ruangan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <div class="controls">

                        <?php
                        $arrRuangan = array();
                        foreach ($modRuangan as $Ruangan) {
                            $arrRuangan[] = $Ruangan['ruangan_id'];
                        }

                        $this->widget(
                            'application.extensions.emultiselect.EMultiSelect',
                            array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                            'ruangan_id[]',
                            $arrRuangan,
                            CHtml::listData(SARuanganM::model()->findAll(array('order' => 'ruangan_nama', 'condition' => 'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                            array('multiple' => 'multiple', 'key' => 'ruangan_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Tindakan <a class="btn btn-default" style="color:#fff;" onclick="unCheckPilihTindakan();" rel="tooltip" data-original-title="Klik untuk uncheck/membatalkan pilihan tindakan"><i class="<?php echo MyIcon::getIcons("ulang"); ?>"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <?php /*
										<div class="col-sm-3">
											<div class="control-group">
												<?php echo CHtml::label("",'daftartindakan_karcis', array('class' => 'control-label')) ?>
												<div class="controls">
													<?php echo $form->checkBox($model,'daftartindakan_karcis',array()); ?> <label>Karcis</label>
												</div>				
											</div>
										</div>
										<div class="col-sm-3">
											<div class="control-group">
												<?php echo CHtml::label("",'daftartindakan_visite', array('class' => 'control-label')) ?>
												<div class="controls">
													<?php echo $form->checkBox($model,'daftartindakan_visite',array()); ?> <label>Visite</label>
												</div>				
											</div>
										</div>
										<div class="col-sm-3">
											<div class="control-group">
												<?php echo CHtml::label("",'daftartindakan_konsul', array('class' => 'control-label')) ?>
												<div class="controls">
													<?php echo $form->checkBox($model,'daftartindakan_konsul',array()); ?> <label>Konsul</label>
												</div>				
											</div>
										</div>
										<div class="col-sm-3">
											<div class="control-group">
												<?php echo CHtml::label("",'daftartindakan_akomodasi', array('class' => 'control-label')) ?>
												<div class="controls">
													<?php echo $form->checkBox($model,'daftartindakan_akomodasi',array()); ?> <label>Akomodasi</label>
												</div>				
											</div>		
										</div>
										 * 
										 */ ?>

                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_karcis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_karcis', 'id' => 'pilih_isperiksa', 'uncheckValue' => null)); ?> <label>Karcis</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_periksa', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_periksa', 'id' => 'pilih_iskarcis', 'uncheckValue' => null)); ?> <label>Pemeriksaan</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_visite', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_visite', 'id' => 'pilih_isvisite', 'uncheckValue' => null)); ?> <label>Visite</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_tindakan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_tindakan', 'id' => 'pilih_istindakan', 'uncheckValue' => null)); ?> <label>Tindakan Medis</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_konsul', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_konsul', 'id' => 'pilih_iskonsul', 'uncheckValue' => null)); ?> <label>Konsul</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_observasi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_observasi', 'id' => 'pilih_isobservasi', 'uncheckValue' => null)); ?> <label>Observasi</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_akomodasi', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_akomodasi', 'id' => 'pilih_isakomodasi', 'uncheckValue' => null)); ?> <label>Akomodasi</label>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo CHtml::label("", 'daftartindakan_alatmedis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->radioButton($model, 'pilihTindakan', array('value' => 'is_alatmedis', 'id' => 'pilih_isalatmedis', 'uncheckValue' => null)); ?> <label>Alat Medis</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Jenis Kegiatan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo Chtml::label('Jenis Kegiatan', 'jeniskegiatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'jeniskegiatan_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'jeniskegiatan_nama',
                            'source' => 'js: function(request, response) {
																			$.ajax({
																					url: "' . $this->createUrl('/ActionAutoComplete/JenisKegiatan') . '",
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
																							$(this).val( ui.item.value);
																							return false;
																												}',
                                'select' => 'js:function( event, ui ) { 
																														$("#' . CHtml::activeId($model, 'jeniskegiatan_id') . '").val(ui.item.jeniskegiatan_id);
																														$("#' . CHtml::activeId($model, 'jeniskegiatan_nama') . '").val(ui.item.jeniskegiatan_nama);
																														return false;
																												}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Jenis Kegiatan',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'custom-only',
                                'onchange' => 'cekJenisKegiatan();'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogJenisKegiatan'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Grup Layanan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo Chtml::label('Grup Layanan', 'jeniskegiatan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'grouplayanan_id'); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'grouplayanan_nama',
                            'source' => 'js: function(request, response) {
																			$.ajax({
																					url: "' . $this->createUrl('/ActionAutoComplete/GroupLayanan') . '",
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
																							$(this).val( ui.item.value);
																							return false;
																												}',
                                'select' => 'js:function( event, ui ) { 
																														$("#' . CHtml::activeId($model, 'grouplayanan_id') . '").val(ui.item.grouplayanan_id);
																														$("#' . CHtml::activeId($model, 'grouplayanan_nama') . '").val(ui.item.grouplayanan_nama);
																														return false;
																												}',
                            ),
                            'htmlOptions' => array(
                                'placeholder' => 'Grup Layanan',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => '',
                                'onblur' => 'cekJenisGrupLayanan();'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogGroupLayanan'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php //echo $form->checkBoxRow($model,'daftartindakan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); 
?>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        '',
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Daftar Tindakan', array('{icon}' => '<i class="icon-file icon-white"></i>')),
        $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    );
    $content = $this->renderPartial('../tips/tips', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SADaftarTindakanM_daftartindakan_namalainnya').value = nama.value.toUpperCase();
        document.getElementById('SADaftarTindakanM_tindakanmedis_nama').value = nama.value;
    }
</script>
<?php
/* ====================================== Widget Dialog Jenis Kegiatan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisKegiatan',
    'options' => array(
        'title' => 'Pencarian Jenis Kegiatan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modJenisKegiatan = new SAJenisKegiatanM('search');
$modJenisKegiatan->unsetAttributes();
if (isset($_GET['SAJenisKegiatanM'])) {
    $modJenisKegiatan->attributes = $_GET['SAJenisKegiatanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jeniskegiatan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisKegiatan->searchDialog(),
    'filter' => $modJenisKegiatan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectJenisKegiatan",
                                    "onClick" => "  $(\"#SADaftarTindakanM_jeniskegiatan_id\").val(\"$data->jeniskegiatan_id\");
                                                    $(\"#SADaftarTindakanM_jeniskegiatan_nama\").val(\"$data->jeniskegiatan_nama\");
                                                    $(\"#dialogJenisKegiatan\").dialog(\"close\");
                            "))',
        ),
        /*   array(
                    'header'=>'Kode Jenis Kegiatan',
                    'name'=>'jeniskegiatan_kode',
                    'value'=>'$data->jeniskegiatan_kode',
                    'filter' => Chtml::activeTextField($modJenisKegiatan, 'jeniskegiatan_kode', array('class'=>'custom-only'))
                ),*/
        array(
            'header' => 'Jenis Kegiatan',
            'name' => 'jeniskegiatan_nama',
            'value' => '$data->jeniskegiatan_nama',
            'filter' => Chtml::activeTextField($modJenisKegiatan, 'jeniskegiatan_nama', array('class' => 'custom-only'))
        ),
        array(
            'header' => 'Ruang Jenis Kegiatan',
            'name' => 'jeniskegiatan_ruangan',
            'value' => '$data->jeniskegiatan_ruangan',
            'filter' => Chtml::activeDropDownList($modJenisKegiatan, 'jeniskegiatan_ruangan', LookupM::getItems('jeniskegiatan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".custom-only").keyup(function() {
            setCustomOnly(this);
        });'
        . '}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Jenis Kegiatan ====================================== */
?>

<?php
/* ====================================== Widget Dialog Group Layanan ====================================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogGroupLayanan',
    'options' => array(
        'title' => 'Pencarian Grup Layanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modGroupLayanan = new GrouplayananM('search');
$modGroupLayanan->unsetAttributes();
if (isset($_GET['GrouplayananM'])) {
    $modGroupLayanan->attributes = $_GET['GrouplayananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'grouplayanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modGroupLayanan->searchGrupLayanan(),
    'filter' => $modGroupLayanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) use ($model) {
                return CHtml::Link(
                    "<i class='icon-form-check'></i>",
                    "javascript:;",
                    array(
                        "class" => "btn-small",
                        "id" => "selectbarang",
                        "onclick" => '
										$("#' . CHtml::activeId($model, 'grouplayanan_nama') . '").val("' . $data->grouplayanan_nama . '");
										$("#' . CHtml::activeId($model, 'grouplayanan_id') . '").val(' . $data->grouplayanan_id . ');
										$("#dialogGroupLayanan").dialog("close");'

                    )
                );
            },
        ),
        'grouplayanan_kode',
        'grouplayanan_nama',
        array(
            'header' => 'Pengelompokkan',
            'value' => function ($data) {
                if ($data->is_oa == true) {
                    return 'Jenis Obat dan Alkes';
                } else {
                    return 'Tindakan';
                }
            },
            'filter' => CHtml::activeDropDownList($modGroupLayanan, 'is_oa', array('is_oa' => 'Jenis Obat dan Alkes', 'is_tindakan' => 'Tindakan'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Group Layanan ====================================== */
?>
<script>
    function cekJenisKegiatan() {
        var jeniskegiatan = $("#<?php echo Chtml::activeId($model, 'jeniskegiatan_nama'); ?>").val();

        if (jeniskegiatan != '') {
            return true;
        } else {
            $("#<?php echo Chtml::activeId($model, 'jeniskegiatan_id'); ?>").val('')
        }
    }

    function cekJenisGrupLayanan() {
        var gruplayanan = $("#<?php echo Chtml::activeId($model, 'grouplayanan_nama'); ?>").val();

        if (gruplayanan != '') {
            return true;
        } else {
            $("#<?php echo Chtml::activeId($model, 'grouplayanan_id'); ?>").val('');
        }
    }

    function unCheckPilihTindakan() {
        var pilih = $("#<?php echo CHtml::activeId($model, 'pilihTindakan') ?>");

        $("#pilih_iskarcis").prop("checked", false);
        $("#pilih_isvisite").prop("checked", false);
        $("#pilih_iskonsul").prop("checked", false);
        $("#pilih_isakomodasi").prop("checked", false);
        $("#pilih_istindakan").prop("checked", false);
        //$("#pilih_isobservasi").prop("checked", false);
    }

    function cekTindakan(obj) {
        var cek = false;
        //alert('asdasdasdasd');
        $("[id^=pilih_]").each(function() {
            if ($(this).prop("checked")) {
                cek = true;
            }
        });

        if (cek == true) {
            if (requiredCheck($(obj))) {
                //$(obj).submit();
                //$("#btn_submit").prop('disabled', true);;
            } else {
                return false;
            }
        } else {
            alert("Tindakan harus dipilih salah satu, tidak boleh kosong!");
            return false;
        }

        //return false;	
    }
</script>