<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nomorindukpegawai', array('placeholder' => 'NIP', 'id' => 'NIP', 'onkeypress' => "if (event.keyCode == 13){setNip(this);}return $(this).focusNextInputField(event)", 'class' => 'span4 numbers-only', 'autofocus' => true)); ?>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai', 'namapegawai', array('class' => 'control-label hurufs-only')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                <?php // echo $form->hiddenField($model, 'alamatemail', array('readonly' => true, 'id' => 'alamatemail')) 
                ?>
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
							$("#agama").val( ui.item.agama);
							$("#alamat_pegawai").val( ui.item.alamat_pegawai);
                                                        $("#kategoripegawai").val( ui.item.kategoripegawai);
                                                        $("#kode_objekpajak").val( ui.item.kode_objekpajak);
                                                        $("#jml_tanggungan").val( ui.item.jmlTanggungan);
							if(ui.item.photopegawai != null){
								$("#photo_pasien").attr(\'src\',\'' . Params::urlPegawaiTumbsDirectory() . 'kecil_\'+ui.item.photopegawai);
							} else {
								$("#photo_pasien").attr(\'src\',\'' . Yii::app()->getBaseUrl('webroot') . '/data/images/pegawai/no_photo.jpeg' . '\');
							}
                            setKomponenGaji(ui.item.value);
							return false;
						}',
                    ),
                    'htmlOptions' => array('placeholder' => 'Nama Pegawai', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4'),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPasienDialog'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Email', 'alamatemail', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'alamatemail', array('class' => 'span4', 'readonly' => true, 'id' => 'alamatemail')); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'tempatlahir_pegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tempatlahir_pegawai')); ?>
        <?php echo $form->textFieldRow($model, 'tgl_lahirpegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'tgl_lahirpegawai')); ?>
        <?php echo $form->textFieldRow($model, 'jeniskelamin', array('class' => 'span4', 'readonly' => true, 'id' => 'jeniskelamin')); ?>

        <div class="control-group">
            <?php echo CHtml::label('Jabatan', 'jabatan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'jabatan_id', array('class' => 'span4', 'readonly' => true, 'id' => 'jabatan')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kategori Pegawai', 'kategoripegawai', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kategoripegawai', array('class' => 'span4', 'readonly' => true, 'id' => 'kategoripegawai')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Kode Objek Pajak', 'kode_objekpajak', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'kode_objekpajak', array('class' => 'span4', 'readonly' => true, 'id' => 'kode_objekpajak')); ?>
            </div>
        </div>
        <?php // echo $form->textFieldRow($model, 'jabatan_id', array('readonly' => true, 'id' => 'jabatan')); 
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo Chtml::label("No Rekening", 'norekening', array('readonly' => true, 'class' => 'control-label')); ?>
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
        <?php echo $form->textFieldRow($model, 'jml_tanggungan', array('readonly' => true, 'value' => 0, 'class' => 'span2 integer', 'id' => 'jml_tanggungan')); ?>
        <?php
        if (!empty($model->photopasien)) {
            echo CHtml::image(Params::urlPasienTumbsDirectory() . 'kecil_' . $model->photopasien, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
        } else {
            echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
        }
        ?>
    </div>
</div>

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
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
$modPegawai->unsetAttributes();
//$modPegawai->pegawai_aktif = true;
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

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
                      $(\"#NIP\").val(\"$data->nomorindukpegawai\");
                      $(\"#pegawai_id\").val(\"$data->pegawai_id\");
                      $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->nama_pegawai\");
                      $(\"#alamatemail\").val(\"$data->alamatemail\");    
                      $(\"#tempatlahir_pegawai\").val(\"$data->tempatlahir_pegawai\");
                      $(\"#tgl_lahirpegawai\").val(\"".MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)."\");
                      $(\"#jeniskelamin\").val(\"$data->jeniskelamin\");
                      $(\"#jabatan\").val(\"". (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "") ."\");
                      $(\"#norek\").val(\"$data->norekening\");
                      $(\"#banknorek\").val(\"$data->banknorekening\");
                      $(\"#npwp\").val(\"$data->npwp\");
                      $(\"#notelp\").val(\"$data->notelp_pegawai\");
                      $(\"#nomobile\").val(\"$data->nomobile_pegawai\");
                      $(\"#agama\").val(\"$data->agama\");
                      $(\"#statusperkawinan\").val(\"$data->statusperkawinan\");
					  $(\"#jml_tanggungan\").val(\"$data->jmlTanggungan\");
                      $(\"#alamat_pegawai\").val(\"$data->alamatJson\");
                      $(\"#kategoripegawai\").val(\"$data->kategoripegawai\");
                      $(\"#kode_objekpajak\").val(\"$data->kode_objekpajak\");
                      $(\"#jenis_bukti_potong\").val(\"$data->jenisBuktiPotong\");
                      $(\"#GJPenggajianpegT_metode_pph_21\").val(\"$data->metode_pph_21\");
                      if(\"$data->photopegawai\" != \"\"){
                            $(\"#photo_pasien\").attr(\'src\',\"' . Params::urlPegawaiTumbsDirectory() . 'kecil_$data->photopegawai\");
                      } else {
                            $(\"#photo_pasien\").attr(\'src\',\"' . Yii::app()->getBaseUrl('webroot') . '/data/images/pegawai/no_photo.jpeg' . '\");
                      }
                      $(\"#dialogPegawai\").dialog(\"close\");    
                      setKomponenGaji($data->pegawai_id);
                      return false;
                    "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        //'tempatlahir_pegawai',
        // 'tgl_lahirpegawai',
        // 'statusperkawinan',
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan->jabatan_nama)?$data->jabatan->jabatan_nama:"-"',
            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))

        ),
        array(
            'header' => 'Pegawai Aktif',
            'name' => 'jabatan_id',
            'value' => '(($data->pegawai_aktif)?"Aktif":"Tidak Aktif")',
            'filter' => Chtml::activeDropDownList($modPegawai, 'pegawai_aktif', array('aktif' => 'Aktif', 'tidak aktif' => 'Tidak Aktif'), array('empty' => '-- Pilih --'))

        ),
        // 'jabatan.jabatan_nama',
        // 'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
        setNumbersOnly(this);
    });
    $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
    });'
        . '}',
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