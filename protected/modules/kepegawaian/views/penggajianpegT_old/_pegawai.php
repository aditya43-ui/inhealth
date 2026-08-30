<fieldset class="box">
    <legend class="rim">Data Pegawai</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <!--====================== kolom ke-1 ==============================================-->
            <td>
                <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('id' => 'NIP', 'onkeypress' => "if (event.keyCode == 13){setNip(this);}return $(this).focusNextInputField(event)", 'class' => 'span3', 'autofocus' => true)); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                        <?php // echo $form->hiddenField($model, 'alamatemail', array('readonly' => true, 'id' => 'alamatemail')) ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
//                                        'name'=>'namapegawai',
                            'attribute' => 'nama_pegawai',
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
                                                setPinjamanKoperasi(ui.item.value);
                                                setPtkp(ui.item.value);
                                                $("#pegawai_id").val( ui.item.value );
                                                $("#alamatemail").val( ui.item.alamatemail );
                                                $("#NIP").val( ui.item.nomorindukpegawai);
                                                $("#tempatlahir_pegawai").val( ui.item.tempatlahir_pegawai);
                                                $("#tgl_lahirpegawai").val( ui.item.tgl_lahirpegawai);
                                                $("#namapegawai").val( ui.item.nama_pegawai);
                                                $("#' . CHtml::activeId($model, 'jabatan') . '").val(ui.item.jabatan_nama)
                                                $("#jeniskelamin").val( ui.item.jeniskelamin);
                                                $("#statusperkawinan").val( ui.item.statusperkawinan);
                                                $("#jabatan").val( ui.item.jabatan_nama);
                                                $("#alamat_pegawai").val( ui.item.alamat_pegawai);
                                                if(ui.item.photopegawai != null){
                                                    $("#photo_pasien").attr(\'src\',\'' . Params::urlPegawaiTumbsDirectory() . 'kecil_\'+ui.item.photopegawai);
                                                } else {
                                                    $("#photo_pasien").attr(\'src\',\'' . Yii::app()->getBaseUrl('webroot') . '/data/images/pegawai/no_photo.jpeg' . '\');
                                                }
                                                return false;
                                            }',
                            ),
                            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                        ));
                        ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'alamatemail', array('readonly' => true, 'id' => 'alamatemail')); ?>
                <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('readonly' => true, 'id' => 'tempatlahir_pegawai')); ?>
                <?php echo $form->textFieldRow($model, 'tgl_lahirpegawai', array('readonly' => true, 'id' => 'tgl_lahirpegawai')); ?>
                <?php echo $form->textFieldRow($model, 'jeniskelamin', array('readonly' => true, 'id' => 'jeniskelamin')); ?>
                <?php echo $form->textFieldRow($model, 'jabatan_id', array('readonly' => true, 'id' => 'jabatan')); ?>
            </td>
            <!--=========================== kolom ke 2 ======================================-->
            <td>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'norekening', array('readonly' => true, 'class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'norekening', array('readonly' => true, 'class' => 'span2', 'id' => 'norek')); ?>
                        <?php echo $form->textField($model, 'banknorekening', array('readonly' => true, 'class' => 'span1', 'id' => 'banknorek', 'style' => 'width:70px;')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'npwp', array('readonly' => true, 'id' => 'npwp')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'notelp_pegawai', array('readonly' => true, 'class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'notelp_pegawai', array('readonly' => true, 'id' => 'notelp', 'class' => 'span2')); ?>
                        <?php echo $form->textField($model, 'nomobile_pegawai', array('readonly' => true, 'id' => 'nomobile', 'class' => 'span1', 'style' => 'width:70px;')); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'agama', array('readonly' => true, 'id' => 'agama')); ?>
                <?php echo $form->textAreaRow($model, 'alamat_pegawai', array('readonly' => true, 'id' => 'alamat_pegawai')); ?>
				<?php echo $form->textFieldRow($model, 'jml_tanggungan', array('value' => 0, 'class' => 'span2 integer','readonly' => false, 'id' => 'jml_tanggungan')); ?>
            </td>
            <td>
                <?php
                if (!empty($model->photopasien)) {
                    echo CHtml::image(Params::urlPasienTumbsDirectory() . 'kecil_' . $model->photopasien, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                } else {
                    echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                }
                ?> 
            </td>
        </tr>
    </table>
</fieldset>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
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

$modPegawai = new KPRegistrasifingerprint();
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
                      setPinjamanKoperasi($data->pegawai_id);
                      setPtkp($data->pegawai_id);
                      $(\"#NIP\").val(\"$data->nomorindukpegawai\");
                      $(\"#pegawai_id\").val(\"$data->pegawai_id\");
                      $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->nama_pegawai\");
                      $(\"#alamatemail\").val(\"$data->alamatemail\");    
                      $(\"#tempatlahir_pegawai\").val(\"$data->tempatlahir_pegawai\");
                      $(\"#tgl_lahirpegawai\").val(\"$data->tgl_lahirpegawai\");
                      $(\"#jeniskelamin\").val(\"$data->jeniskelamin\");
                      $(\"#jabatan\").val(\"". (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "") ."\");
                      $(\"#norek\").val(\"$data->norekening\");
                      $(\"#banknorek\").val(\"$data->banknorekening\");
                      $(\"#npwp\").val(\"$data->npwp\");
                      $(\"#notelp\").val(\"$data->notelp_pegawai\");
                      $(\"#nomobile\").val(\"$data->nomobile_pegawai\");
                      $(\"#agama\").val(\"$data->agama\");
                      $(\"#statusperkawinan\").val(\"$data->statusperkawinan\");
					  $(\"#jml_tanggungan\").val(1);
                      $(\"#alamat_pegawai\").val(\"$data->alamat_pegawai\");
                      if(\"$data->photopegawai\" != \"\"){
                            $(\"#photo_pasien\").attr(\'src\',\"' . Params::urlPegawaiTumbsDirectory() . 'kecil_$data->photopegawai\");
                      } else {
                            $(\"#photo_pasien\").attr(\'src\',\"' . Yii::app()->getBaseUrl('webroot') . '/data/images/pegawai/no_photo.jpeg' . '\");
                      }
                      $(\"#dialogPegawai\").dialog(\"close\");    
                      return false;
                    "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai',
        'tempatlahir_pegawai',
        'tgl_lahirpegawai',
        'jeniskelamin',
        'statusperkawinan',
        'jabatan.jabatan_nama',
        'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
$urlNip = Yii::app()->createUrl('actionAjax/getPegawaiFromNip');
Yii::app()->clientScript->registerScript('onhead2', '
    function setNip(obj){
        var value = $(obj).val();
        $.post("' . $urlNip . '",{nip:value},function(hasil){
            $("#pegawai_id").val(hasil.pegawai_id);
            $("#NIP").val(hasil.nomorindukpegawai);
            $("#tempatlahir_pegawai").val(hasil.tempatlahir_pegawai);
            $("#tgl_lahirpegawai").val(hasil.tgl_lahirpegawai);
            $("#namapegawai").val(hasil.nama_pegawai);
            $("#' . CHtml::activeId($model, 'jabatan') . '").val(hasil.jabatan_nama)
            $("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(hasil.nama_pegawai)
            $("#jeniskelamin").val(hasil.jeniskelamin);
            $("#statusperkawinan").val(hasil.statusperkawinan);
            $("#jabatan").val(hasil.jabatan_nama);
            $("#alamat_pegawai").val(hasil.alamat_pegawai);
            if(hasil.photopegawai != null){
                $("#photo_pasien").attr(\'src\',\'' . Params::urlPegawaiTumbsDirectory() . 'kecil_\'+hasil.photopegawai);
            } else {
                $("#photo_pasien").attr(\'src\',\'' . Yii::app()->getBaseUrl('webroot') . '/data/images/pegawai/no_photo.jpeg' . '\');
            }
        }, "json");
    }
', CClientScript::POS_HEAD);
?>

