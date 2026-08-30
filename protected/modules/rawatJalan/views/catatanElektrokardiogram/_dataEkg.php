<style type="text/css">
    .hapus {
        color: red;
        font-style: bolder;
        font-size: 40px;
        vertical-align: middle;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Lembar Catatan Hasil Elektrokardiogram</div>
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-6">
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tanggal',
                            'value' => null,
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => false,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span4 htpd',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class='control-group'>
                    <?php echo $form->labelEx($model, 'nama_pegawai', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pegawai_id', array('class' => 'span4', 'maxlength' => 50)); ?>
                        <?php
                                  $this->widget('MyJuiAutoComplete', array(
                                        'model' => $model,
                                        'attribute' => 'nama_pegawai',
                                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/pegawaiRuangan'),
                                        'options' => array(
                                        'showAnim' => 'fold',
                                        'minLength' => 2,
                                        'focus' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.namaLengkap);
                                                        return false;
                                                    }',
                                        'select' => 'js:function( event, ui ) {
                                                        $(this).val(ui.item.namaLengkap);
                                                        $("#CatatanelektrokardiogramT_pegawai_id").val(ui.item.value);
                                                        return false;
                                                    }'
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => '',
                        'class' => 'span4',
                        'style' => 'width:150px;',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai', 'idTombol' => 'tombolPegawai'),
                ));
                ?>
                    </div>
                </div>
            </div>
        </div>
        <hr><br>
        <div class="row-fluid">
            <div class="col-sm-12">
                <div id="divCaraAmbilPhotoFile" style="display: block;">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'gambar_path', array('class' => 'control-label', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?>
                            <div class="controls" style="margin-top: -10px;">
                                <?php echo Chtml::activeFileField($model, 'gambar_path', array('maxlength' => 254, 'Hint' => 'Isi jika akan menambahkan file elektrokardiogram', 'class' => 'fileupload-new')); ?>
                                &emsp;  
                                <?php
                                     echo CHtml::link("<b class='hapus'>&times;</b><br>", "javascript:void(0);",array("onclick"=>"hapusGambar();return false;","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menghapus Gambar", "style" => "color: red;"));
                                ?>
                            </div>
                        </div>
                        <!-- sdfetsrygdtun -->
                        <?php $url_gambar = (!empty($model->gambar_path) ? $model->gambar_path : ""); ?>

                        <div class="control-group" style="text-align: center;">
                            <?php echo CHtml::label('&nbsp;','',array('class'=>'control-label')); ?>
                            <div class="controls">
                                <div class="fileupload-preview fileupload-exists thumbnail"
                                    style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                    <img src="<?php echo $url_gambar; ?>" id="prev-gambar"/>
                                    
                                </div>

                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'iramajantung', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'frekuensijantung', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'atrium', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'ventrikel', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'pr_interval', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'qrs_interval', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'qt_interval', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'seksumbulistrik_qrs', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'sekbidangfrontal', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textFieldRow($model, 'sekbidanghorizontal', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                <?php echo $form->textAreaRow($model, 'interpretasi', array('rows' => 6, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);"));  ?>
                <?php echo $form->textAreaRow($model, 'kesimpulan', array('rows' => 6, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);"));  ?>
            </div>
        </div>
    </div>
</div>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPegawai',
        'options' => array(
            'title' => 'Nama Pegawai',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
// echo CHtml::hiddenField('dokter_untuk',"",array('readonly'=>true));
$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();

$modPegawai->pegawai_aktif = true;
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$prov = $modPegawai->search();
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'edukator-grid',
        'dataProvider' => $prov,
        'filter' => $modPegawai,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                . '"onClick" => "
                    $(\'#CatatanelektrokardiogramT_pegawai_id\').val(\'".$data->pegawai_id."\');
                    $(\'#CatatanelektrokardiogramT_nama_pegawai\').val(\'".$data->namaLengkap."\');
                    $(\'#dialogPegawai\').dialog(\'close\');
                    return false;"))',
            ),
            //'gelardepan',
            array(
                'name' => 'nama_pegawai',
                'value' => '$data->namaLengkap',
            ),
            array(
                'name' => 'jabatan_id',
                'type' => 'raw',
                'value' => function($data) {
                    if (empty($data->jabatan_id))
                        return "-";
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    return $j->jabatan_nama;
                },
                'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id',
                    CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                    array('empty' => '-- Pilih --')),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>

    function hapusGambar() {
        $('#CatatanelektrokardiogramT_gambar_path').val('');
        $('.fileupload-preview img').attr('src', '');
    }

</script>