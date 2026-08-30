<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">
                &nbsp;
          </label>
            <div class="controls">
                <?php echo CHtml::checkBox('is_pasienrs', false, array('rel' => 'tooltip', 'title' => 'Pilih untuk pasien Rumah Sakit', 'onkeyup' => "return $(this).focusNextInputField(event);")) . ' <label for="is_pasienrs">Pilih untuk pasien Rumah Sakit</label>'; ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">
                <span class="tombol" style="display:none;"> <?php echo CHtml::htmlButton("<i class='entypo-arrows-ccw'></i>", array("class" => "btn btn-danger btn-mini", "id" => 'tombolpasien', 'onclick' => 'setInfoPasienReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", "rel" => "tooltip", "title" => "Klik untuk mengulang data pasien")); ?></span> No. Rekam Medik
          </label>
            <div class="controls">
                <?php echo $form->hiddenField($modPasien, 'pasien_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'no_rekam_medik',
                    'value' => $modPasien->no_rekam_medik,
                    'sourceUrl' => $this->createUrl('AutocompletePasien'),
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'select' => 'js:function( event, ui ) {
                            $("#no_rekam_medik").val( ui.item.value );
                            setInfoPasien(ui.item.no_rekam_medik, ui.item.pasien_id);
                            setJenisKelaminPasien(ui.item.jeniskelamin);
                            return false;
                        }',

                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasienAmbulan', 'idTombol' => 'tombolPasienDialog', 'jsFunction' => 'setDialogPasien()'),
                    'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. RM'),
                ));
                ?>
            </div>
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setInfoPasienReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pasien')); ?></span>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'No. Identitas Pasien', array('class' => 'span1 control-label')) ?>
            <div class="controls">
                <?php
                echo $form->dropDownList(
                    $modPasien,
                    'jenisidentitas',
                    LookupM::getItems('jenisidentitas'),
                    array(
                        'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
                    )
                ); ?><br>
                <?php echo $form->textField($modPasien, 'no_identitas_pasien', array('placeholder' => 'No. Identitas', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
            <div class="controls inline">
                <?php echo $form->textField($modPasien, 'nama_pasien', array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
                <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modPasien->tanggal_lahir = (!empty($modPasien->tanggal_lahir) ? date("d/m/Y", strtotime($modPasien->tanggal_lahir)) : null);
                $this->widget('MyDateTimePicker', array(
                    'model' => $modPasien,
                    'attribute' => 'tanggal_lahir',
                    'mode' => 'date',
                    'options' => array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'onkeyup' => "js:function(){setUmur(this.value);}",
                        'onSelect' => 'js:function(){setUmur(this.value);}',
                        'yearRange' => "-150:+0",
                    ),
                    'htmlOptions' => array(
                        'placeholder' => '00/00/0000', 'class' => 'span3 dtPicker2 datemask', 'onblur' => 'setUmur(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)"
                    ),
                )); ?>
                <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">Umur</div>
            <div class="controls">
                <?php echo CHtml::textField('umur', '', array('placeholder' => '00 Thn 00 Bln 00 Hr', 'class' => 'span3 umur', 'onblur' => 'setTglLahir(this);', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
            </div>
        </div>

        <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress' => "return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textAreaRow(
            $modPasien,
            'alamat_pasien',
            array(
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'placeholder' => 'Alamat Pasien'
            )
        ); ?>
        <div class="control-group">
            <?php echo $form->labelEx(
                $modPasien,
                'rt',
                array('class' => 'control-label inline')
            ) ?>

            <div class="controls">
                <?php echo $form->textField(
                    $modPasien,
                    'rt',
                    array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 ', 'maxlength' => 3, 'placeholder' => 'RT')
                ); ?> /
                <?php echo $form->textField(
                    $modPasien,
                    'rw',
                    array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span1 ', 'maxlength' => 3, 'placeholder' => 'RW')
                ); ?>
                <?php echo $form->error($modPasien, 'rt'); ?>
                <?php echo $form->error($modPasien, 'rw'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'no_telepon_pasien', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPasien, 'no_telepon_pasien', array('class' => 'numberOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Telepon yang dapat dihubungi')); ?>
                <?php echo $form->error($modPasien, 'no_telepon_pasien'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($modPasien, 'No. Handphone <span class="required">*</span>', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('class' => 'numberOnly required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. HP yang dapat dihubungi')); ?>
                <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modPasien, 'alamatemail', array('onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Alamat E-mail')); ?>
    </div>
</div>
<?php
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasienAmbulan',
    'options' => array(
        'title' => 'Pencarian Data Pasien Ambulans',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDataPasien = new AMPasienM('searchPasienAmbulan');
$modDataPasien->unsetAttributes();
if (isset($_GET['AMPasienM'])) {
    $modDataPasien->attributes = $_GET['AMPasienM'];
    $modDataPasien->propinsiNama = isset($_GET['AMPasienM']['propinsiNama']) ? $_GET['AMPasienM']['propinsiNama'] : null;
    $modDataPasien->kabupatenNama = isset($_GET['AMPasienM']['kabupatenNama']) ? $_GET['AMPasienM']['kabupatenNama'] : null;
    $modDataPasien->kecamatanNama = isset($_GET['AMPasienM']['kecamatanNama']) ? $_GET['AMPasienM']['kecamatanNama'] : null;
    $modDataPasien->kelurahanNama = isset($_GET['AMPasienM']['kelurahanNama']) ? $_GET['AMPasienM']['kelurahanNama'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-ambulan-m-grid',
    'dataProvider' => $modDataPasien->searchPasienAmbulan(),
    'filter' => $modDataPasien,
    'template' => "{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPasien",
                "onClick" => "
                    $(\"#dialogPasienAmbulan\").dialog(\"close\");
                    $(\"#no_rekam_medik\").val(\"$data->no_rekam_medik\");
                    setInfoPasien(\"$data->no_rekam_medik\",$data->pasien_id);
                    setJenisKelaminPasien(\"$data->jeniskelamin\");
                "))',
        ),
        array(
            'name' => 'no_rekam_medik',
            'header' => 'No. Rekam Medik',
            'value' => '$data->no_rekam_medik',
        ),
        'nama_pasien',
        array(
            'name' => 'nama_bin',
            'header' => 'Alias',
            'value' => '$data->nama_bin',
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'name' => 'propinsiNama',
            'value' => '$data->propinsi->propinsi_nama',
        ),
        array(
            'name' => 'kabupatenNama',
            'value' => '$data->kabupaten->kabupaten_nama',
        ),
        array(
            'name' => 'kecamatanNama',
            'value' => '$data->kecamatan->kecamatan_nama',
        ),
        array(
            'name' => 'kelurahanNama',
            'value' => 'isset($data->kelurahan->kelurahan_nama)?($data->kelurahan->kelurahan_nama):""',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end pasien dialog =============================
?>
<script type="text/javascript">
    function setDialogPasien() {
        if ($($('#is_pasienrs')).attr('checked')) {
            $.fn.yiiGridView.update('pasien-ambulan-m-grid', {
                data: {
                    "AMPasienM[ispasienluar]": 0,
                    "AMPasienM[create_ruangan]": '',
                }
            });
        } else {
            $.fn.yiiGridView.update('pasien-ambulan-m-grid', {
                data: {
                    "AMPasienM[ispasienluar]": 1,
                }
            });
        }
        $('#dialogPasienAmbulan').dialog('open');
        return false;
    }

    /**
     * untuk set value jenis kelamin
     * @returns {undefined}
     */
    function setJenisKelaminPasien(jeniskelamin) {
        $('input[name="AMPasienM[jeniskelamin]"]').each(function() {
            if (this.value == jeniskelamin)
                $(this).attr('checked', true);
        });
    }

    /** control accordion data pasien */
    $('#form-pasien > div > .accordion-heading').click(function() {
        var is_pasien = $("#<?php echo CHtml::activeId($modPemakaian, "is_pasien"); ?>");
        if (is_pasien.val() > 0) { //hide
            is_pasien.val(0);
        } else { //show
            is_pasien.val(1);
            $("input, select, textarea").attr("disabled", false);
        }
    });

    /**
     * set nilai tanggal_lahir dari umur 
     * @param {type} obj
     * @returns {undefined} */
    function setTglLahir(obj) {
        var str = obj.value;
        obj.value = str.replace(/_/gi, "0");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetTanggalLahir'); ?>',
            data: {
                umur: obj.value
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasien, "tanggal_lahir"); ?>").val(data.tanggal_lahir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * set nilai umur dari tanggal_lahir 
     * @param {type} tanggal_lahir
     * @returns {undefined} */
    function setUmur(tanggal_lahir) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetUmur'); ?>',
            data: {
                tanggal_lahir: tanggal_lahir
            }, //
            dataType: "json",
            success: function(data) {
                $("#umur").val(data.umur);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * set form info pasien
     * @returns {undefined}
     */
    function setInfoPasien(no_rekam_medik, pasien_id) {
        $("#form-infopasien > div").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
            data: {
                no_rekam_medik: no_rekam_medik,
                pasien_id: pasien_id
            },
            dataType: "json",
            success: function(data) {
                $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val(data.pasien_id);
                $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>").val(data.jenisidentitas);
                $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>").val(data.no_identitas_pasien);
                $("#<?php echo CHtml::activeId($modPasien, 'namadepan'); ?>").val(data.nama_depan);
                $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val(data.nama_pasien);
                $("#<?php echo CHtml::activeId($modPasien, 'nama_bin'); ?>").val(data.nama_bin);
                $("#<?php echo CHtml::activeId($modPasien, 'tempat_lahir'); ?>").val(data.tempat_lahir);
                $("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir'); ?>").val(data.tanggal_lahir);
                $("#<?php echo CHtml::activeId($modPasien, 'kelompokumur_id'); ?>").val(data.kelompokumur_id);
                $("#<?php echo CHtml::activeId($modPasien, 'jeniskelamin'); ?>").val(data.jeniskelamin);
                $("#<?php echo CHtml::activeId($modPasien, 'alamat_pasien'); ?>").val(data.alamat_pasien);
                $("#<?php echo CHtml::activeId($modPasien, 'alamatemail'); ?>").val(data.alamatemail);
                $("#<?php echo CHtml::activeId($modPasien, 'no_mobile_pasien'); ?>").val(data.no_mobile_pasien);
                $("#<?php echo CHtml::activeId($modPemakaian, 'nomobile'); ?>").val(data.no_mobile_pasien);
                $("#<?php echo CHtml::activeId($modPasien, 'no_telepon_pasien'); ?>").val(data.no_telepon_pasien);
                $("#<?php echo CHtml::activeId($modPasien, 'rt'); ?>").val(data.rt);
                $("#<?php echo CHtml::activeId($modPasien, 'rw'); ?>").val(data.rw);

                if (data.jeniskelamin == 'LAKI-LAKI') {
                    $("#PasienM_jeniskelamin_0").prop("checked", true);
                    $("#PasienM_jeniskelamin_1").prop("checked", false);
                } else {
                    $("#PasienM_jeniskelamin_0").prop("checked", false);
                    $("#PasienM_jeniskelamin_1").prop("checked", true);
                }

                $("#form-infopasien .tombol").attr('style', 'display:true;');

                $("#form-infopasien div").removeClass("animation-loading");
                setUmur(data.tanggal_lahir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data kunjungan tidak ditemukan!");
                console.log(errorThrown);
                setInfoPasienReset();
                $("#form-infopasien > div").removeClass("animation-loading");
            }
        });
    }
    /*
     * reset form info pasien
     * @returns {undefined}
     */
    function setInfoPasienReset() {
        $("#<?php echo CHtml::activeId($modPasien, 'pasien_id'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'jenisidentitas'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'no_identitas_pasien'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'namadepan'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'nama_pasien'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'nama_bin'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'tempat_lahir'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'tanggal_lahir'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'kelompokumur_id'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'jeniskelamin'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'alamat_pasien'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'alamatemail'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'no_mobile_pasien'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPemakaian, 'nomobile'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'no_telepon_pasien'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'rt'); ?>").val("");
        $("#<?php echo CHtml::activeId($modPasien, 'rw'); ?>").val("");
        $("#no_rekam_medik").val("");
        $("#umur").val("");

        $("#form-infopasien .tombol").attr('style', 'display:none;');
    }
</script>