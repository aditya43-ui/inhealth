


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Data Pengkajian & Informasi Umum</div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Data Pengkajian</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'setting_pengakajian', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <div class="radio_panel">
                                    <div class="radio">
                                        <?php echo $form->radioButton($model, 'setting_pengakajian', array('value' => 'Rumah Sakit', 'class' => 'setting_pengakajian', 'uncheckValue'=>null)); ?>
                                        <label>Rumah Sakit</label>
                                    </div>
                                    <div class="radio_detail">
                                        <?php
                                        if (empty($model->ruangan_id)) {
                                            $model->instalasi_id = $pendaftaran->instalasi_id;
                                        } else {
                                            $model->instalasi_id = $model->ruangan->instalasi_id;
                                        }

                                        echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAllByAttributes(array(
                                                    'instalasi_aktif' => true, 'revenuecenter' => true,
                                                    ), array(
                                                    'order' => 'instalasi_nama',
                                                )), 'instalasi_id', 'instalasi_nama'), array(
                                            'empty' => '-- Pilih --', 'class' => 'span3', 'onchange' => 'getRuangan();'
                                        ));
                                        ?>
                                        <?php
                                        $list = array();
                                        if (!empty($model->instalasi_id)) {
                                            $list = CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                                        'ruangan_aktif' => true,
                                                        'instalasi_id' => $model->instalasi_id,
                                                        ), array(
                                                        'order' => 'ruangan_nama'
                                                    )), 'ruangan_id', 'ruangan_nama');
                                        }

                                        echo $form->dropDownListRow($model, 'ruangan_id', $list, array(
                                            'empty' => '-- Pilih --', 'class' => 'span3'
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="radio_panel">
                                    <div class="radio">
                                        <?php echo $form->radioButton($model, 'setting_pengakajian', array('value' => 'Masyarakat', 'class' => 'setting_pengakajian', 'uncheckValue'=>null)); ?>
                                        <label>Masyarakat</label>

                                    </div>
                                    <div class="radio_detail">
                                        <?php echo $form->textFieldRow($model, 'puskesmas_nama', array('class'=>'span3')); ?>
                                        <?php echo $form->textFieldRow($model, 'puskesmas_register', array('class'=>'span3')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php
                            echo $form->labelEx($model, 'tgl_pengkajian', array(
                                'class' => 'control-label'
                            ));
                            ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'tgl_pengkajian',
                                    'value' => null,
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php
                            echo $form->labelEx($model, 'jam_pengkajian', array(
                                'class' => 'control-label'
                            ));
                            ?>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $model,
                                    'attribute' => 'jam_pengkajian',
                                    'value' => null,
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3',
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php
                            echo $form->labelEx($model, 'perawatpengkaji_id', array(
                                'class' => 'control-label'
                            ));
                            ?>
                            <div class="controls">
                                <?php
                                echo $form->hiddenField($model, 'perawatpengkaji_id', array('class' => 'perawatpengkaji_id'));

                                $this->widget('MyJuiAutoComplete', array(
                                    'name' => 'perawatpengkaji_nama',
                                    'value' => empty($model->perawatpengkaji) ? "" : $model->perawatpengkaji->namaLengkap,
                                    'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . $this->createUrl('autocompletePerawatPengkaji') . '",
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
                                                $(this).val( ui.item.label);
                                                return false;
                                            }',
                                        'select' => 'js:function( event, ui ) {
                                                $(".perawatpengkaji_id").val(ui.item.pegawai_id); 
                                                $(".perawatpengkaji_nama").val(ui.item.nama_pegawai); 
                                                return false;
                                            }',
                                    ),
                                    'htmlOptions' => array(
                                        'class' => 'perawatpengkaji_nama span3',
                                        'onkeyup' => "return $(this).focusNextInputField(event)",
                                        'onblur' => 'if(this.value === "") $(".perawatpengkaji_nama").val(""); '
                                    ),
                                    'tombolDialog' => array('idDialog' => 'dialogPerawatPengkaji'),
                                ));
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Informasi Umum</div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <br/>
                        <div class="panel panel-darkk">
                            <span class="group-title">
                                Pasien
                            </span>
                            <div class="panel-body">
                                <?php echo $form->textFieldRow($pasien, 'nama_pasien', array('disabled' => true, 'class' => 'span3')); ?>
                                <?php echo $form->textFieldRow($pasien, 'jeniskelamin', array('disabled' => true, 'class' => 'span3')); ?>
                                <?php echo $form->textFieldRow($pendaftaran, 'umur', array('disabled' => true, 'class' => 'span3')); ?>
                                <?php echo $form->textFieldRow($pasien, 'statusperkawinan', array('disabled' => true, 'class' => 'span3')); ?>
                                <div class="control-group">
                                    <label class="control-label">Alamat</label>
                                    <div class="controls">
                                        <?php echo $form->textArea($pasien, 'alamat_pasien', array('disabled' => true, 'class' => 'span3')); ?>
                                        <div style="margin-top: 10px;">
                                            <label>RT</label>
                                            <?php echo $form->textField($pasien, 'rt', array('class' => 'span1', 'disabled' => true)); ?>
                                            <label>RW</label>
                                            <?php echo $form->textField($pasien, 'rw', array('class' => 'span1', 'disabled' => true)); ?>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Desa/Kelurahan</label>
                                            <div class="controls">
                                                <?php echo $form->textField(empty($pasien->kelurahan) ? new KelurahanM : $pasien->kelurahan, 'kelurahan_nama', array('disabled' => true, 'class' => 'span2')); ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Kecamatan</label>
                                            <div class="controls">
                                                <?php echo $form->textField(empty($pasien->kelurahan) ? new KecamatanM : $pasien->kelurahan->kecamatan, 'kecamatan_nama', array('disabled' => true, 'class' => 'span2')); ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Kabupaten/Kota</label>
                                            <div class="controls">
                                                <?php echo $form->textField(empty($pasien->kelurahan) ? new KabupatenM : $pasien->kelurahan->kecamatan->kabupaten, 'kabupaten_nama', array('disabled' => true, 'class' => 'span2')); ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Provinsi</label>
                                            <div class="controls">
                                                <?php echo $form->textField(empty($pasien->kelurahan) ? new PropinsiM : $pasien->kelurahan->kecamatan->kabupaten->propinsi, 'propinsi_nama', array('disabled' => true, 'class' => 'span2')); ?>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <?php echo $form->textFieldRow($pasien, 'no_telepon_pasien', array('disabled' => true, 'class' => 'span3')); ?>
                                <?php echo $form->textFieldRow($pasien, 'no_mobile_pasien', array('disabled' => true, 'class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <br/>
                        <div class="panel panel-darkk">
                            <span class="group-title">
                                Informan
                            </span>
                            <div class="panel-body">
                                <?php echo $form->textFieldRow($model, 'informan_nama', array('class' => 'span3')); ?>
                                <?php
                                echo $form->radioButtonListRow($model, 'informan_jeniskelamin', LookupM::getItemsUrutan('jeniskelamin'), array(
                                    'template' => '<div class="radio inline">{input}{label} </div>'
                                ));
                                ?>
                                <?php echo $form->textFieldRow($model, 'informan_umur', array('class' => 'span3')); ?>
                                <?php echo $form->dropDownListRow($model, 'informan_pekerjaan_id', CHtml::listData(PekerjaanM::model()->findAll('pekerjaan_aktif = true order by pekerjaan_nama'), 'pekerjaan_id', 'pekerjaan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                                <?php echo $form->dropDownListRow($model, 'informan_hubungandenganpasien', LookupM::getItemsUrutan('hubungankeluarga'), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
                                <?php
                                echo $form->radioButtonListRow($model, 'informan_istinggalserumah', array('Ya' => 'Ya', 'Tidak' => 'Tidak'), array(
                                    'template' => '<div class="radio inline">{input}{label} </div>', 'uncheckValue'=>null,
                                ));
                                ?>

                                <div class="control-group">
                                    <label class="control-label">Alamat</label>
                                    <div class="controls">
                                        <?php echo $form->textArea($model, 'informan_alamat', array('class' => 'span3')); ?>
                                        <div style="margin-top: 10px;">
                                            <label>RT</label>
                                            <?php echo $form->textField($model, 'informan_rt', array('class' => 'span1')); ?>
                                            <label>RW</label>
                                            <?php echo $form->textField($model, 'informan_rw', array('class' => 'span1')); ?>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Provinsi</label>
                                            <div class="controls">
                                                <?php
                                                echo $form->dropDownList($model, 'informan_propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                                                    array('class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                                        'ajax' => array('type' => 'POST',
                                                            'url' => $this->createUrl('SetDropdownKabupaten', array('encode' => false, 'model_nama' => get_class($model))),
                                                            'update' => "#" . CHtml::activeId($model, 'informan_kabupaten_id'),
                                                        ),
                                                        'onchange' => "setClearDropdownKelurahan();setClearDropdownKecamatan();",
                                                        'style' => 'width:170px;'));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Kabupaten/Kota</label>
                                            <div class="controls">
                                                <?php
                                                echo $form->dropDownList($model, 'informan_kabupaten_id', empty($model->informan_kecamatan_id) ? array() : CHtml::listData($model->getKabupatenItems($model->informan_propinsi_id), 'kabupaten_id', 'kabupaten_nama'),
                                                    array('class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                                        'ajax' => array('type' => 'POST',
                                                            'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
                                                            'update' => "#" . CHtml::activeId($model, 'informan_kecamatan_id'),
                                                        ),
                                                        'onchange' => "setClearDropdownKelurahan();",
                                                        'style' => 'width:170px;'));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Kecamatan</label>
                                            <div class="controls">
                                                <?php
                                                echo $form->dropDownList($model, 'informan_kecamatan_id', empty($model->informan_kabupaten_id) ? array() : CHtml::listData($model->getKecamatanItems($model->informan_kabupaten_id), 'kecamatan_id', 'kecamatan_nama'),
                                                    array('class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                                        'ajax' => array('type' => 'POST',
                                                            'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
                                                            'update' => "#" . CHtml::activeId($model, 'informan_kelurahan_id'),
                                                        ),
                                                        'onchange' => "",
                                                        'style' => 'width:170px;'));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Desa/Kelurahan</label>
                                            <div class="controls">
                                                <?php
                                                echo $form->dropDownList($model, 'informan_kelurahan_id', empty($model->informan_kecamatan_id) ? array() : CHtml::listData($model->getKelurahanItems($model->informan_kecamatan_id), 'kelurahan_id', 'kelurahan_nama'),
                                                    array('empty' => '-- Pilih --', 'class' => 'form-control span3', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                                        'style' => 'width:170px;'));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php echo $form->textFieldRow($model, 'informan_notelp', array('class' => 'span3')); ?>
                                <?php echo $form->textFieldRow($model, 'informan_nomobile', array('class' => 'span3')); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<?php
//========= Dialog buat cari data Pegawai Triase =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPerawatPengkaji',
    'options' => array(
        'title' => 'Perawat Pengkaji',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modPerawat = new RKPegawaiM();
$modPerawat->unsetAttributes();
$modPerawat->kelompokpegawai_id = Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN;
if (isset($_GET['RKPegawaiM'])) {
    $modPerawat->attributes = $_GET['RKPegawaiM'];
    $modPerawat->nama_pegawai = $_GET['RKPegawaiM']['nama_pegawai'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'perawat-pengkaji-m-grid',
    'dataProvider' => $modPerawat->searchDialog2(),
    'filter' => $modPerawat,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectObat",
					"onClick" => "$(\".perawatpengkaji_id\").val(\"$data->pegawai_id\");  
								  $(\".perawatpengkaji_nama\").val(\"$data->namaLengkap\");
									$(\'#dialogPerawatPengkaji\').dialog(\'close\');return false;"))',
        ),
        array(
            'name' => 'nama_pegawai',
            'header' => 'Nama Dokter',
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>

    function cekCeklisPanelSetting() {
        $(".radio_panel").each(function () {
            if ($(this).find(".setting_pengakajian").is(":checked")) {
                $(this).find(".radio_detail").find("input[type=text]").attr("readonly", false);
                $(this).find(".radio_detail").find("select").attr("disabled", false);
            } else {
                $(this).find(".radio_detail").find("input[type=text]").attr("readonly", true).val("");
                $(this).find(".radio_detail").find("select").attr("disabled", true);
            }
        });
    }

    function getRuangan() {
        var value = $('#<?php echo CHtml::activeId($model, 'instalasi_id'); ?>').val();
        if (jQuery.isNumeric(value)) {
            $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {instalasi_id: value}, function (data) {
                $('#<?php echo CHtml::activeId($model, 'ruangan_id'); ?>').html('<option value="">-- Pilih --</option>' + data.dropDown);
            }, 'json');
        } else {

        }
    }

    /** bersihkan dropdown kecamatan */
    function setClearDropdownKecamatan()
    {
        $("#<?php echo CHtml::activeId($model, "informan_kecamatan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }
    /** bersihkan dropdown kelurahan */
    function setClearDropdownKelurahan()
    {
        $("#<?php echo CHtml::activeId($model, "informan_kelurahan_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    }

    $(document).ready(function () {
        $(".radio_panel .setting_pengakajian").on("click", cekCeklisPanelSetting);
        cekCeklisPanelSetting();
    });

</script>