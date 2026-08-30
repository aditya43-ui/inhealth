<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pesananpascaanastesi-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));

$myicon = new MyIcon();
?>
<?php

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI  ?>	
    <div class="panel-body">


        <div class="row-fluid">
            <?php
            $this->renderPartial($this->path_view . '_form', array(
                'format' => $format,
                'model' => $model,
                'modTerapi' => $modTerapi,
                'form' => $form,
                'diagnosis' => $diagnosis,
                'arrTerapi'=>$arrTerapi,
            ));
            ?>	
        </div>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Ahli Anastesi', '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        /*echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('instalasi_id' => Yii::app()->user->getState('instalasi_id'))), 'pegawai_id', 'NamaLengkap'), array(
            'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",
            'maxlength' => 100));*/
        ?>
        <?php
        echo $form->hiddenField($model, 'pegawai_id');
        $this->widget('MyJuiAutoComplete', array(
            'model' => $model,
            'attribute' => 'pegawai_nama',
            'source' => 'js: function(request, response) {
                $.ajax({
                    url: "' . $this->createUrl('AutocompletePegawai') . '",
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
                'minLength' => 3,
                'focus' => 'js:function(event, ui ) {
                    return false;
                }',
                'select' => 'js:function( event, ui ) {
                    $(this).val(ui.item.nama_pegawai);
                    $("#ATPesananpascaanastesiT_pegawai_id").val(ui.item.pegawai_id);
                    return false;
                }',
            ),
            'htmlOptions' => array(
                'onkeypress' => "return $(this).focusNextInputField(event)",
                'placeholder' => 'Ketikan Nama Pegawai',
                'class' => 'span3 required'
            ),
            'tombolDialog' => array('idDialog' => 'dialogPegawai'),
        ));
        ?>
    </div>  
</div>

<div class="form-actions">
    <?php
    $disabled = (isset($_GET['sukses'])) ? true : false;
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="'.$myicon::getIcons('simpan').'"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'disabled' => $disabled)); ?>
    &nbsp;
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.$myicon::getIcons('ulang').'"></i>')), array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) location.reload();}); return false;'
    ));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'width' => 760,
        'height' => 600,
        'resizable' => true,
    ),
        )
);

$format = new MyFormatter();
$modPeg = new PegawaiV('search');
$modPeg->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawaiV'])) {
    $modPeg->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-pengirim-m-grid',
    'dataProvider' => $modPeg->searchPegawaiRuangan(),
    'filter' => $modPeg,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) use ($model) {
                return CHtml::Link("<i class='icon-form-check'></i>", "javascript:;", array("class" => "btn-small",
                    "id" => "selectBahan",
                    "onClick" => '
                        $("#ATPesananpascaanastesiT_pegawai_id").val('.$data->pegawai_id.');
                        $("#ATPesananpascaanastesiT_pegawai_nama").val("'.$data->nama_pegawai.'");
                        $("#dialogPegawai").dialog("close");
                    '));
            },
        ),
        array(
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '$data->jabatan_nama',
            'filter' => CHtml::activeDropDownList($modPeg, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'unitkerja_id',
            'value' => '$data->namaunitkerja',
            'filter' => CHtml::activeDropDownList($modPeg, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
            
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
