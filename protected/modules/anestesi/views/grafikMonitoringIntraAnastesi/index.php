
<?php
$hide = '';
if (!empty($_GET['frame'])) {
    $hide = 'hide';
}
?>
<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Grafik Monitoring Intra Anestesia</div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN ANESTESI ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data Grafik Monitoring Intra Anestesia berhasil disimpan");
        }
        $this->widget('bootstrap.widgets.BootAlert');
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'grafikmonitoringintraanestesi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
        ?>
        <div class="panel panel-success <?= $hide; ?>">
            <div class="panel-heading">
                <div class="panel-title judul">Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataPasien', array('modKunjungan' => $modKunjungan)); ?>
            </div>
        </div>

        <div class="panel panel-success" style="display: none">
            <div class="panel-heading">
                <div class="panel-title judul">Data Awal Anastesi/Sedasi</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_dataAwalAnastesi', array('modKunjungan' => $modKunjungan, 'modObat' => $modObat, 'modIntraAnestesi' => $modIntraAnestesi)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Table Monitoring Intra Anastesi / Sedasi</div>
            </div>
            <div class="panel-body">
                <span id='tombolTambah'>

                </span>
                <?php $this->renderPartial($this->path_view . '_tableMonitoring', array('modKunjungan' => $modKunjungan, 'getMonitoring' => $getMonitoring)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Grafik Monitoring Intra Anastesi / Sedasi</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_grafikMonitoring', array('model' => $modMonitoring)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Data Selesai Anastesi / Sedasi</div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial($this->path_view . '_formdataSelesai', array(
                    'modKunjungan' => $modKunjungan,
                    'model' => $model,
                    'form' => $form
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')); ?>
            <div class="controls">  
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal_selesai',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span4',
                        'onkeypress' => "return $(this).focusNextInputField(event)"),
                ));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::Label('Nama Dokter', 'Dokter', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pegawai',
                    'source' => 'js: function(request, response) {
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteDokter') . '",
                                                   dataType: "json",
                                                   data: {
                                                       paramedis_nama: request.term,
                                                   },
                                                   success: function (data) {
                                                           response(data);
                                                   }
                                               })
                                            }',
                    'options' => array(
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                        'select' => 'js:function( event, ui ) {
                                            $(this).val( ui.item.value);
                                            $("#AMPemakaianambulansT_paramedis1_id").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                    'htmlOptions' => array('placeholder' => 'Ketik nama dokter', 'rel' => 'tooltip', 'title' => 'Ketik nama dokter / klik icon untuk mencari data dokter',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value===""){ $("#' . CHtml::activeId($model, 'pegawai_id') . '").val(""); }', 'class' => 'span3'
                    ),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->renderPartial($this->path_view . '_jsFunctions', array(
    'modKunjungan' => $modKunjungan,
    'model' => $model,
    'form' => $form,
    'modIntraAnestesi' => $modIntraAnestesi,
    'modObat' => $modObat,
));
?>

<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => (isset($_GET['sukses'])) ? true : false)) . '&nbsp;';
    echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->module->id . '/Index'), array('class' => 'btn btn-default',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;')).'&nbsp;';
    if (!empty($_GET['pasienanastesi_id'])) {
        if(empty($_GET['frame'])){
            echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-back"></i>')), $this->createUrl('DaftarPasienAT/Index', array()), array('class' => 'btn btn-red'));
        }
    }
    ?>
    
</div>

<?php $this->endWidget(); ?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Data Petugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modDialogPetugas = new PegawairuanganV('search');
$modDialogPetugas->unsetAttributes();
$modDialogPetugas->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['PegawairuanganV'])) {
    $modDialogPetugas->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawairuangan-grid',
    'dataProvider' => $modDialogPetugas->searchDialogPegRuangan(),
    'filter' => $modDialogPetugas,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectAmbulans",
                    "onClick" => "
                        $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val($data->pegawai_id);
                        $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->nama_pegawai\");
                        $(\"#dialogPegawai\").dialog(\"close\");
                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget();
?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailObat',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Detail Input Obat',
		'autoOpen'=>false,
		'minWidth'=>600,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailObat" width="100%" height="200" style="border: none;">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailselainObat',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Detail Input Cairan',
		'autoOpen'=>false,
		'minWidth'=>600,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailselainObat" width="100%" height="440" style="border: none;">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
<?php
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id'=>'dialogDetailOutput',
		// additional javascript options for the dialog plugin
		'options'=>array(
		'title'=>'Detail Output',
		'autoOpen'=>false,
		'minWidth'=>600,
		'minHeight'=>100,
		'resizable'=>false,
		 ),
	));
?>
<iframe src="" name="frameDetailOutput" width="100%" height="270" style="border: none;">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');

?>
<script>
function hapus(obj){
    myConfirm("Apakah anda yakin akan menghapus data ini?","Perhatian!",
        function(r){
            if(r){ 
                $.ajax({
                    type:'GET',
                    url:obj.href,
                    data: {},//
                    dataType: "json",
                    success:function(data){
                        if(data.sukses > 0){
                            location.reload();
                        }else{
                            myAlert('Data gagal dinonaktifkan!');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
                });
            }
        }
    );
    return false;
}
</script>