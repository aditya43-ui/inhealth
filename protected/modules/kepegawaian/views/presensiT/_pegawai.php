<style>
    tr td .add-on {
        margin: 0 !important;
    }
</style>

<table style="width: 100%; border: none;">
    <tr>
        <!--====================== kolom ke-1 ==============================================-->
        <td>
            <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'NIP', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->hiddenField($model, 'nofingerprint', array('readonly' => true, 'id' => 'nofingerprint', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <div class="control-group">
                <?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                    <?php

                    $modul = ModulK::model()->findByAttributes(
                        array('modul_key' => $this->module->id)
                    );
                    $modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '');
                    $this->widget('MyJuiAutoComplete', array(
                        'attribute' => 'nama_pegawai',
                        'model' => $model,
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 4,
                            'focus' => 'js:function( event, ui ) {
                                                $("#pegawai_id").val( ui.item.value );
                                                $("#namapegawai").val( ui.item.nama_pegawai );
                                                return false;
                                            }',
                            'select' => 'js:function( event, ui ) {
                                                getDataPegawai(ui.item.pegawai_id);
                                                return false;
                                            }',

                        ),
                        'htmlOptions' => array('placeholder' => 'Nama Pegawai', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4'),
                        'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                    )); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tempatlahir_pegawai', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model, 'tgl_lahirpegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tgl_lahirpegawai', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </td>
        <!--=========================== kolom ke 2 ======================================-->
        <td>
            <?php echo $form->textFieldRow($model, 'jeniskelamin', array('class' => 'span4', 'readonly' => true, 'id' => 'jeniskelamin', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model, 'statusperkawinan', array('class' => 'span4', 'readonly' => true, 'id' => 'statusperkawinan', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textFieldRow($model, 'jabatan_id', array('class' => 'span4', 'readonly' => true, 'id' => 'jabatan', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'alamat_pegawai', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </td>
        <td>
            <?php
            if (file_exists(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai)) {
                echo CHtml::image(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $model->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            } else {
                echo CHtml::image(Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
            }
            ?>
        </td>
    </tr>
</table>

<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPegawai = new KPRegistrasifingerprint;
if (isset($_GET['KPRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['KPRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
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
                                getDataPegawai(\"$data->pegawai_id\");
                                $(\"#dialogPegawai\").dialog(\"close\");    
                                return false;
                            "))',
        ),
        'nofingerprint',
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        array(
            'header' => 'Tanggal Lahir',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
        ),
        //'jeniskelamin',
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'filter' => CHtml::dropDownList('KPRegistrasifingerprint[jeniskelamin]', $modPegawai->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')),
        ),
        'statusperkawinan',
        'jabatan.jabatan_nama',
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$urlNip = Yii::app()->createUrl('actionAjax/getPegawaiFromNoFinger');
Yii::app()->clientScript->registerScript('onhead2', '
    function setNofinger(obj){
        var value = $(obj).val();
        $.post("' . $urlNip . '",{nofinger:value},function(hasil){
            $("#pegawai_id").val(hasil.pegawai_id);
            $("#NIP").val(hasil.nomorindukpegawai);
            $("#tempatlahir_pegawai").val(hasil.tempatlahir_pegawai);
            $("#tgl_lahirpegawai").val(hasil.tgl_lahirpegawai);
            $("#namapegawai").val(hasil.nama_pegawai);
            $("#' . CHtml::activeId($model, 'jabatan') . '").val(hasil.jabatan_nama);
            $("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(hasil.nama_pegawai);
            $("#jeniskelamin").val(hasil.jeniskelamin);
            $("#statusperkawinan").val(hasil.statusperkawinan);
            $("#jabatan").val(hasil.jabatan_nama);
            $("#pangkat").val(hasil.pangkat_nama);
            $("#alamat_pegawai").val(hasil.alamat_pegawai);
            if(hasil.photopegawai != null){
                $("#photo_pasien").attr(\'src\',\'' . Params::urlPegawaiTumbsDirectory() . 'kecil_$data->photopegawai\');
            } else {
                $("#photo_pasien").attr(\'src\',\'' . Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg\');
            }
        }, "json");
    }
',  CClientScript::POS_HEAD); ?>

<?php
$urlNIP = Yii::app()->createUrl('actionAjax/getPegawaiFromNip');
Yii::app()->clientScript->registerScript('nip', '
    function setNip(obj){
        var value = $(obj).val();
        $.post("' . $urlNIP . '",{nip:value},function(hasil){
            $("#pegawai_id").val(hasil.pegawai_id);
            $("#nofingerprint").val(hasil.nofingerprint);
            $("#tempatlahir_pegawai").val(hasil.tempatlahir_pegawai);
            $("#tgl_lahirpegawai").val(hasil.tgl_lahirpegawai);
            $("#namapegawai").val(hasil.nama_pegawai);
            $("#' . CHtml::activeId($model, 'jabatan') . '").val(hasil.jabatan_nama);
            $("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(hasil.nama_pegawai);
            $("#' . CHtml::activeId($model, 'nofingerprint') . '").val(hasil.nofingerprint);
            $("#jeniskelamin").val(hasil.jeniskelamin);
            $("#statusperkawinan").val(hasil.statusperkawinan);
            $("#jabatan").val(hasil.jabatan_nama);
            $("#pangkat").val(hasil.pangkat_nama);
            $("#alamat_pegawai").val(hasil.alamat_pegawai);
            if(hasil.photopegawai != null){
                $("#photo_pasien").attr(\'src\',\'' . Params::urlPegawaiTumbsDirectory() . 'kecil_\'+hasil.photopegawai);
            } else {
                $("#photo_pasien").attr(\'src\',\'' . Params::urlPegawaiTumbsDirectory() . 'no_photo.jpeg\');
            }
        }, "json");
    }
',  CClientScript::POS_HEAD); ?>

<script>
    function getDataPegawai(params) {
        $.post("<?php echo $this->createUrl('getDataPegawai'); ?>", {
                idPegawai: params
            },
            function(data) {
                $("#NIP").val(data.nomorindukpegawai);
                $("#nofingerprint").val(data.nofingerprint);
                $("#pegawai_id").val(data.pegawai_id);
                $("#KPRegistrasifingerprint_nama_pegawai").val(data.nama_pegawai);
                $("#KPPresensiT_shift_id").html(data.shiftpegawai);
                $("#tempatlahir_pegawai").val(data.tempatlahir_pegawai);
                $("#tgl_lahirpegawai").val(data.tgl_lahirpegawai);
                $("#jabatan").val(data.jabatan_nama);
                $("#jeniskelamin").val(data.jeniskelamin);
                $("#statusperkawinan").val(data.statusperkawinan);
                $("#alamat_pegawai").val(data.alamat_pegawai);
                if (data.photopegawai != "") {
                    var url = data.photopegawai;
                    $("#photo_pasien").attr('src', url);
                } else {
                    var url = "<?php echo Params::urlPegawaiDirectory() . 'no_photo.jpeg'; ?>";
                    $("#photo_pasien").attr('src', url);
                }
                //generatePerhitungan();
                <?php if(!empty($_GET['abnormalabsen_id']) && !empty($modPresensi->pegawai_id)){ ?>
                    cekStatusKehadiran($('#<?php echo CHtml::activeId($modPresensi, 'statuskehadiran_id'); ?>'));
                <?php } ?>
            }, "json");

    }
</script>