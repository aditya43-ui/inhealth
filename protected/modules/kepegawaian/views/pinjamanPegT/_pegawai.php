<fieldset class="box" id="form-pegawai">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-user"></i> Data <b>Pegawai</b>
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPegawaiReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pegawai')); ?>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('NIP <span style="color:red;">*</span>', 'nomorindukpegawai', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php

                            $modul = ModulK::model()->findByAttributes(
                                array('modul_key' => $this->module->id)
                            );
                            $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '');
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'nomorindukpegawai',
                                'value' => $model->nomorindukpegawai,
                                'sourceUrl' => $this->createUrl('pegawaiNip'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 4,
                                    'focus' => 'js:function( event, ui ) {
                                            $("#pegawai_id").val( ui.item.value );
                                            $("#namapegawai").val( ui.item.nama_pegawai );
                                            return false;
                                        }',
                                    'select' => 'js:function( event, ui ) {
                                            $("#pegawai_id").val( ui.item.value );
                                            setDataPegawai(ui.item.value);
                                            return false;
                                        }',

                                ),
                                'htmlOptions' => array('placeholder' => 'NIP', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required numbers-only', 'maxlength' => 18),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Pegawai <span style="color:red;">*</span>', 'namapegawai', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                            <?php

                            $modul = ModulK::model()->findByAttributes(
                                array('modul_key' => $this->module->id)
                            );
                            $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '');
                            $this->widget('MyJuiAutoComplete', array(
                                'name' => 'namapegawai',
                                'value' => $model->nama_pegawai,
                                'sourceUrl' => $this->createUrl('pegawai'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 4,
                                    'focus' => 'js:function( event, ui ) {
                                                $("#pegawai_id").val( ui.item.value );
                                                $("#namapegawai").val( ui.item.nama_pegawai );
                                                return false;
                                            }',
                                    'select' => 'js:function( event, ui ) {
                                                $("#pegawai_id").val( ui.item.value );
                                                setDataPegawai(ui.item.value);
                                                return false;
                                            }',

                                ),
                                'htmlOptions' => array('placeholder' => 'Nama Pegawai', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4 required hurufs-only'),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                            )); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tempatlahir_pegawai')); ?>
                    <?php echo $form->textFieldRow($model, 'tgl_lahirpegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tgl_lahirpegawai')); ?>
                    <?php echo $form->textFieldRow($model, 'jeniskelamin', array('class' => 'span4', 'readonly' => true, 'id' => 'jeniskelamin')); ?>
                    <?php echo $form->textFieldRow($model, 'statusperkawinan', array('class' => 'span4', 'readonly' => true, 'id' => 'statusperkawinan')); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->textFieldRow($model, 'jabatan_id', array('class' => 'span4', 'readonly' => true, 'id' => 'jabatan')); ?>
                    <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'alamat_pegawai')); ?>
                    <?php
                    if (file_exists(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
                        echo CHtml::image(Params::pathPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</fieldset>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new PegawaiM;
if (isset($_GET['PegawaiM']))
    $modPegawai->attributes = $_GET['PegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->searchPegawai(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "
                                          setDataPegawai(\"$data->pegawai_id\");
                                          $(\"#dialogPegawai\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only')),
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
            setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>

<script type="text/javascript">
    function setDataPegawai(params) {
        $("#form-pegawai > div").addClass("animation-loading");
        $.ajax({
            type: 'POST',
            url: "<?php echo $this->createUrl('getDataPegawai'); ?>",
            data: {
                idPegawai: params
            },
            dataType: "json",
            success: function(data) {
                $("#nomorindukpegawai").val(data.nomorindukpegawai);
                $("#pegawai_id").val(data.pegawai_id);
                $("#namapegawai").val(data.nama_pegawai);
                $("#tempatlahir_pegawai").val(data.tempatlahir_pegawai);
                $("#tgl_lahirpegawai").val(data.tgl_lahirpegawai);
                $("#jabatan").val(data.jabatan_nama);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#statusperkawinan").val(data.statusperkawinan);
                $("#alamat_pegawai").val(data.alamat_pegawai);
                if (data.photopegawai != "") {
                    var url = "<?php echo Params::urlPegawaiTumbsDirectory() . 'kecil_'; ?>" + data.photopegawai;
                    $("#photo_pasien").attr('src', url);
                } else {
                    var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
                    $("#photo_pasien").attr('src', url);
                }

                $("#form-pegawai > legend > .judul").html('Data Pegawai ' + data.nomorindukpegawai);
                $("#form-pegawai > legend > .tombol").attr('style', 'display:true;');
                $("#form-pegawai > .box").addClass("well").removeClass("box");

                $("#form-pegawai > div").removeClass("animation-loading");
                $("#nomorindukpegawai").focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                myAlert("Data pegawai tidak ditemukan!");
                console.log(errorThrown);
                setPegawaiReset();
                $("#form-pegawai > div").removeClass("animation-loading");
                $("#nomorindukpegawai").focus();
            }
        });
    }

    function setPegawaiReset() {
        $("#nomorindukpegawai").val("");
        $("#pegawai_id").val("");
        $("#namapegawai").val("");
        $("#tempatlahir_pegawai").val("");
        $("#tgl_lahirpegawai").val("");
        $("#jabatan").val("");
        $("#jeniskelamin").val("");
        $("#statusperkawinan").val("");
        $("#alamat_pegawai").val("");
        var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
        $("#photo_pasien").attr('src', url);
        $("#form-pegawai > legend > .judul").html('Data Pegawai');
        $("#form-pegawai > legend > .tombol").attr('style', 'display:none;');
        $("#form-pegawai > .well").addClass("box").removeClass("well");
        $("#form-pegawai > div").removeClass("animation-loading");
        $("#nomorindukpegawai").focus();
    }
</script>