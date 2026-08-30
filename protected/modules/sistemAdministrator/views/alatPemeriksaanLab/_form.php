<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapemeriksaanlabmapping-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php if (isset($modDetails)) {
    echo $form->errorSummary($modDetails);
} else {
    echo $form->errorSummary($model);
} ?>

<div class="control-group">
    <?php echo CHtml::label('Nama Alat Pemeriksaan Lab. <span class="required">*</span>', 'pemeriksaanlabalat_id', array('class' => 'span3')); ?>
    <div class="col-sm-4">
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pemeriksaanlabalat_id'); ?>
            <?php
            $pemeriksaanlabalat_nama = (isset($model->pemeriksaanlabalat->pemeriksaanlabalat_nama) ? $model->pemeriksaanlabalat->pemeriksaanlabalat_nama : "");
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'pemeriksaanlabalat_nama',
                'value' => $pemeriksaanlabalat_nama,
                'source' => 'js: function(request, response) {
												   $.ajax({
													   url: "' . $this->createUrl('AutocompletePemeriksaanLabAlat') . '",
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
													$(this).val(ui.item.pemeriksaanlabalat_nama);
													$("#pemeriksaanlabalat_id").val(ui.item.pemeriksaanlabalat_id);
													return false;
													}',
                ),
                'htmlOptions' => array(
                    'onkeypress' => "return $(this).focusNextInputField(event)",
                    'placeholder' => "Nama Alat Pemeriksaan Lab",
                    'class' => 'span3',

                ),
                'tombolDialog' => array('idDialog' => 'dialogPemeriksaanLabAlat'),
            ));
            ?>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Pilih <b>Nilai Rujukan</b>
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPegawaiReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pegawai')); ?></span>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo CHtml::hiddenField('nilairujukan_id', '', array('readonly' => true)); ?>
        <div>
            <?php
            $modNilaiRujukan = new SANilairujukanM('search');
            $modNilaiRujukan->unsetAttributes();  // clear any default values
            if (isset($_GET['SANilairujukanM'])) {
                $modNilaiRujukan->attributes = $_GET['SANilairujukanM'];
            }
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'nilairujukan-m-grid',
                'dataProvider' => $modNilaiRujukan->searchPilih(),
                'filter' => $modNilaiRujukan,
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-condensed',
                'columns' => array(
                    array(
                        'header' => 'Pilih',
                        'type' => 'raw',
                        'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                array(
                                        "class"=>"btn-small",
                                        "id" => "selectNilairujukan",
                                        "onClick" => "\$(\"#nilairujukan_id\").val($data->nilairujukan_id);
													  \$(\"#nilairujukan_nama\").val(\"$data->nilairujukan_nama\");
                                                       submitnilairujukan();"
                                ))',
                    ),
                    array(
                        'header' => 'No.',
                        'value' => '($this->grid->dataProvider->pagination) ? 
								($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
								: ($row+1)',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'name' => 'kelkumurhasillab_id',
                        'type' => 'raw',
                        'value' => 'isset($data->kelkumurhasillab->kelkumurhasillabnama) ? $data->kelkumurhasillab->kelkumurhasillabnama : "-"',
                        //'filter'=>CHtml::listData(KelkumurhasillabM::model()->findAll(array('order'=>'kelkumurhasillab_urutan'),'kelkumurhasillab_aktif = true'),'kelkumurhasillab_id','kelkumurhasillabnama'),
                        'filter' => Chtml::activeDropDownList($modNilaiRujukan, 'kelkumurhasillab_id', CHtml::listData(KelkumurhasillabM::model()->findAll(array('order' => 'kelkumurhasillab_urutan'), 'kelkumurhasillab_aktif = true'), 'kelkumurhasillab_id', 'kelkumurhasillabnama'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")),
                    ),
                    array(
                        'name' => 'nilairujukan_jeniskelamin',
                        'type' => 'raw',
                        'value' => '$data->nilairujukan_jeniskelamin',
                        //'filter'=>LookupM::getItems('jeniskelamin'),
                        'filter' => Chtml::activeDropDownList($modNilaiRujukan, 'nilairujukan_jeniskelamin', LookupM::getItems('jeniskelamin'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")),
                    ),
                    'kelompokdet',
                    'namapemeriksaandet',
                    'nilairujukan_nama',
                    'nilairujukan_min',
                    'nilairujukan_max',
                    'nilairujukan_satuan',
                    'nilairujukan_metode',
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            )); ?>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Detail <b>Alat Pemeriksaan Laboratorium</b>
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPegawaiReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data pegawai')); ?></span>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tabelPemeriksaanlabmapping" class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th>Pemriksaan Lab.</th>
                    <th>Kelompok Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Detail</th>
                    <th>Nilai Rujukan</th>
                    <th>Nilai Minimum</th>
                    <th>Nilai Maksimum</th>
                    <th>Satuan</th>
                    <th>Metode</th>
                    <th>Batal</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'title' => 'Simpan')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Pemeriksaan Alat Laboratorium', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php $this->widget('UserTips', array('type' => 'create')); ?>
</div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaanLabAlat',
    'options' => array(
        'title' => 'Pilih Alat Laboratorium',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 480,
        'resizable' => false,
    ),
));
$modPemeriksaanLabALat = new SAPemeriksaanlabalatM('search');
$modPemeriksaanLabALat->unsetAttributes();  // clear any default values
if (isset($_GET['SAPemeriksaanlabalatM'])) {
    $modPemeriksaanLabALat->attributes = $_GET['SAPemeriksaanlabalatM'];
    $modPemeriksaanLabALat->alatmedis_nama = isset($_GET['SAPemeriksaanlabalatM']['alatmedis_nama']) ? $_GET['SAPemeriksaanlabalatM']['alatmedis_nama'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapemeriksaanlabalat-m-grid',
    'dataProvider' => $modPemeriksaanLabALat->searchDialog(),
    'filter' => $modPemeriksaanLabALat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::link("<i class=\'icon-check\'></i>","javascript:void(0);",
					array("onclick"=>"
							$(\"#pemeriksaanlabalat_nama\").val(\"$data->pemeriksaanlabalat_nama\");
							$(\"#' . CHtml::activeId($model, 'pemeriksaanlabalat_id') . '\").val(\"$data->pemeriksaanlabalat_id\");
							$(\"#dialogPemeriksaanLabAlat\").dialog(\"close\");
						", 
					"class"=>"btn-small", "title"=>"Klik untuk <br>memilih Alat Pemeriksaan Radiologi", "rel"=>"tooltip"));',
        ),

        array(
            'header' => 'Alat Medis',
            'name' => 'alatmedis_id',
            'value' => '$data->alatmedis->alatmedis_nama',
            //'filter'=>CHtml::listData($modPemeriksaanLabALat->AlatmedisItems, 'alatmedis_id', 'alatmedis_nama'),
            'filter' => Chtml::activeDropDownList($modPemeriksaanLabALat, 'alatmedis_id', CHtml::listData(AlatmedisM::model()->findAll('alatmedis_aktif=TRUE ORDER BY alatmedis_nama'), 'alatmedis_id', 'alatmedis_nama'), array('style' => 'width:170px;', 'class' => 'form-control span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")),
        ),

        'pemeriksaanlabalat_nama',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":\'' . Params::TOOLTIP_PLACEMENT . '\'});}',
));
$this->endWidget();

?>

<?php
$urlGetPemeriksaanlabmapping = $this->createUrl('Pemeriksaanlabmapping');
?>

<?php
$jscript = <<< JS
function submitnilairujukan()
{
    pemeriksaanlabalat_id = $('#SAPemeriksaanlabmappingM_pemeriksaanlabalat_id').val();
    nilairujukan_id = $('#nilairujukan_id').val();
    if(nilairujukan_id==''){
        myAlert('Silakan Pilih Nilai Rujukan Terlebih dahulu');
    }else{
        $.post("${urlGetPemeriksaanlabmapping}", {pemeriksaanlabalat_id:pemeriksaanlabalat_id, nilairujukan_id:nilairujukan_id},
        function(data){
            $('#tabelPemeriksaanlabmapping').append(data.tr);
        }, "json");
    }   
}
JS;

Yii::app()->clientScript->registerScript('pemeriksaanlabmapping', $jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    function hapusBaris(obj) {
        $(obj).parents('tr').detach();
    }
</script>