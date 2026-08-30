<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'persiapan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"> <b> Kelengkapan Dokumen Pengadaan </b> </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label("Persiapan Pengadaan <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'persiapanpengadaan_id', array('class' => 'span3 persiapan_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $model,
                            'attribute' => 'persiapanpengadaan_nomor',
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/persiapanPengadaan').'",
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
                                    'focus' => 'js:function( event, ui ) {
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        setPersiapan(ui.item);
                                        setTabReset();
                                        return false;
                                    }',
                            ),
                            'htmlOptions' => array(
                                'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Ketikkan Nomor Persiapan Pengadaan'),
                            'tombolDialog' => array('idDialog' => 'dialogPersiapan', 'idTombol' => 'tombolPegawaiPelaksana'),
                        ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tanggal Persiapan Pengadaan <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'persiapanpengadaan_tanggal', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Tahun Anggaran <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'tahunanggaran', array('class' => 'span3', 'readonly' => true)); ?>
            </div>
        </div>
        
        <div class="control-group">
            
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Program Kerja <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'programkerja_nama', array('class' => 'span6', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Kegiatan <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'kegiatanprogram_nama', array('class' => 'span6', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Sub Kegiatan <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'subkegiatanprogram_nama', array('class' => 'span6', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Pekerjaan <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'nama_pekerjaan', array('class' => 'span6', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nilai HPS <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'total_hargaseluruhnya', array('class' => 'span6 integer-decimal', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Sumber Dana <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'daftarsumberdana', array('class' => 'span6', 'readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Pengadaan <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->textField($model, 'daftarjenispengadaan', array('class' => 'span6', 'readonly' => true)); ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_tabmenu', array('model' => $model))?>
        <?php $this->renderPartial('_jsFunction', array('model' => $model))?>
        
    </div>
</div>


<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Program Studi  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPersiapan',
    'options' => array(
        'title' => 'Pencarian Persiapan Pengadaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'resizable' => false,
    ),
));

$modPersiapan = new InformasipersiapanpengadaanV('searchSuratPerjanjianKerja');
$modPersiapan->unsetAttributes();
if (isset($_GET['InformasipersiapanpengadaanV'])) {
    $modPersiapan->attributes = $_GET['InformasipersiapanpengadaanV'];
    $modPersiapan->nama_pekerjaan = isset($_GET['InformasipersiapanpengadaanV']['nama_pekerjaan'])?$_GET['InformasipersiapanpengadaanV']['nama_pekerjaan']:null;
    $modPersiapan->namaunitkerja = isset($_GET['InformasipersiapanpengadaanV']['namaunitkerja'])?$_GET['InformasipersiapanpengadaanV']['namaunitkerja']:null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'prodi-m-grid',
    'dataProvider' => $modPersiapan->searchSuratPerjanjianKerja(),
    'filter' => $modPersiapan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                    $load = $data->attributes;
                    $load['total_hargaseluruhnya'] = number_format($data->total_hargaseluruhnya, 2, ',', '.');
                    $res = json_encode($load);

                    return CHtml::Link('<i class="icon-form-check"><i>',"javascript:;",array("class"=>"btn-small", 
                            "onclick" => 'setPersiapan('.$res.');'));
                },
        ),  
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'Nomor Persiapan Pengadaan',
            'name' => 'persiapanpengadaan_nomor',
            'value' => '$data->persiapanpengadaan_nomor',
        ),
        array(
            'header' => 'Tanggal Persiapan Pengadaan',
            'value' => function($data){
                echo MyFormatter::formatDateTimeForUser(date('d M Y', strtotime($data->persiapanpengadaan_tanggal)));
            },
            
        ),
        array(
            'header' => 'Nama Pekerjaan',
            'name' => 'nama_pekerjaan',
            'value' => function($data){
                        $namapekerjaan = RencanaumumpengadaanT::model()->findByPk($data->rencanaumumpengadaan_id);
                                
                        if (!empty($namapekerjaan)){
                            return $namapekerjaan->nama_pekerjaan;
                        }else{
                            return '-';
                        }
                    },
        ),
        array(
            'header' => 'Program Kerja',
            'name' => 'programkerja_nama',
            'value' => '$data->programkerja_nama',
        ),
        array(
            'header' => 'Unit Kerja',
            'name' => 'namaunitkerja',
            'value' => function($data){
                        $rencanaumum = RencanaumumpengadaanT::model()->findByPk($data->rencanaumumpengadaan_id);
                        $namaunitkerja = UnitkerjaM::model()->findByPk($rencanaumum->unitkerja_id);
                        if (!empty($namaunitkerja)){
                            return $namaunitkerja->namaunitkerja;
                        }else{
                            return '-';
                        }
                    },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Program Studi =============================


$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPilihSSUK',
    'options' => array(
        'title' => 'Dokumen SSUK',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 200,
        'resizable' => false,
    ),
));

?>
<div class="form-horizontal">
    <div class="control-group">
        <label class="control-label">Nama Dokumen SSUK</label>
        <div class="controls">
            <?php echo CHtml::dropDownList('dokssuk', '', LookupM::getItemsUrutan('dokumenssuk','url'), array('empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="control-group">       
        <div class="controls">
            <?php echo CHtml::link("Cetak","javascript:;",array('style'=>'color:#fff;','class'=>'btn btn-primary','onclick'=>'printSSUK();')); ?>
        </div>
    </div>
</div>
<?php
$this->endWidget();
?>

<script>
    function refreshDialog(obj){
        $("#InformasipersiapanpengadaanV_dpa_pagu integer2").maskMoney(
			{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
		);
    }
    function printSSUK() {
        var url =  $("#dokssuk").val();
        
        if (url == ''){
            window.parent.toastr.warning("Dokumen SSUK belum dipilih");
            return false;
        }
        
        window.open(url, '_blank',);
    }
</script>
    
    