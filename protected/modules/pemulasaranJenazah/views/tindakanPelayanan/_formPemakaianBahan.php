<?php echo CHtml::hiddenField("obatalkes_kode", '', array('readonly' => true, 'class' => 'inputFormTabel span1')); ?>
<?php echo CHtml::hiddenField('obatalkes_id', ''); ?>
<!--<legend>-->
<?php echo CHtml::dropDownList('daftartindakanPemakaianBahan', '', array(), array('class' => 'span3', 'empty' => 'Uraian Tindakan')) ?>
<!--</legend>-->
&nbsp;&nbsp;
<?php echo CHtml::radioButton('pilihAlkes', true, array('id' => 'bahan', 'value' => 'bahan', 'onclick' => 'pilihAlkesMedis(this);')); ?>
<label for="bahan">Pemakaian BMHP</label>
<?php echo CHtml::radioButton('pilihAlkes', false, array('id' => 'medis', 'value' => 'medis', 'onclick' => 'pilihAlkesMedis(this);')); ?>
<label for="medis">Alat Medis</label>
<div style="margin: 8px 0;">
    <?php $this->widget('MyJuiAutoComplete', array(
        'name' => 'pakaiBahan',
        'value' => '',
        'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('AutocompletePemakaianBahan') . '",
                                   dataType: "json",
                                   data: {
                                       term: request.term,
                                       tipepaket_id: $("#PJTindakanPelayananT_0_tipepaket_id").val(),
                                       kelaspelayanan_id: $("#PJPendaftaranT_kelaspelayanan_id").val(),
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
                        $(this).val( ui.item.label);
                        return false;
                    }',
            'select' => 'js:function( event, ui ) {
                        inputPemakaianBahan(ui.item.obatalkes_id);
                        return false;
                    }',
        ),
        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Pemakaian BMHP'),
        //                'tombolDialog'=>array('idDialog'=>'dialogObatAlkes','jsFunction'=>"setDialogObatAlkes(this);"),
        'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
    )); ?>
    <?php $this->widget('MyJuiAutoComplete', array(
        'name' => 'alatMedis',
        'value' => '',
        'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('AutocompletePemakaianAlatMedis') . '",
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
                        $(this).val( ui.item.label);
                        return false;
                    }',
            'select' => 'js:function( event, ui ) {
                        inputAlatmedis(ui.item.alatmedis_id);
                        return false;
                    }',

        ),
        'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Alat Medis'),
        'tombolDialog' => array('idDialog' => 'dialogAlatmedis'),
    )); ?>
    <table class="items table table-striped table-bordered table-condensed" id="tblInputPemakaianBahan" style="margin: 8px 0 !important;">
        <thead>
            <tr>
                <th>Uraian Tindakan</th>
                <th>Nama Alkes</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Sub Total</th>
                <th>Batal</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <div class="control-group">
        <label class="control-label"><b>Total Pemakaian BMHP</b></label>
        <div class="controls">
            <?php echo CHtml::textField("totPemakaianBahan", 0, array('readonly' => true, 'class' => 'inputFormTabel currency')); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Obat dan Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 400,
        'resizable' => false,
    ),
));
//$modObatAlkes = new PJInformasistokobatalkesV('searchDialog');
$modObatAlkes = new PJObatAlkesM('searchObatFarmasiDialog');
$modObatAlkes->unsetAttributes();
if (isset($_GET['PJObatAlkesM'])) {
    $modObatAlkes->attributes = $_GET['PJObatAlkesM'];
    $modObatAlkes->sumberdana_nama = isset($_GET['PJObatAlkesM']['sumberdana_nama']) ? $_GET['PJObatAlkesM']['sumberdana_nama'] : null;
    $modObatAlkes->satuankecilNama = isset($_GET['PJObatAlkesM']['satuankecilNama']) ? $_GET['PJObatAlkesM']['satuankecilNama'] : null;
    //$modObatAlkes->ruangan_id = $_GET['PJInformasistokobatalkesV']['ruangan_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchObatFarmasiDialog(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_kode\').val(\"$data->obatalkes_kode\");
                                        $(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
                                        $(\'#satuankecil_id\').val($data->satuankecil_id);
                                        $(\'#satuankecil_nama\').val(\'$data->satuankecil_nama\');
                                        $(\'#hargajual\').val($data->hargajual);
                                        $(\'#harganetto\').val($data->harganetto);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
                                        inputPemakaianBahan(this);
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        'obatalkes_kategori',
        'obatalkes_nama',
        'obatalkes_golongan',
        array(
            'name' => 'satuankecilNama',
            'value' => '$data->satuankecil->satuankecil_nama',
        ),
        array(
            'name' => 'sumberdana_nama',
            'value' => '$data->sumberdana->sumberdana_nama',
        ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => 'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogAlatmedis',
    'options' => array(
        'title' => 'Alat Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 400,
        'resizable' => false,
    ),
));

$modAlat = new PJAlatmedisM('searchDialog');
$modAlat->unsetAttributes();
if (isset($_GET['PJAlatmedisM']))
    $modAlat->attributes = $_GET['PJAlatmedisM'];
$modAlat->jenisalatmedis_nama = isset($_GET['PJAlatmedisM']['jenisalatmedis_nama']) ? $_GET['PJAlatmedisM']['jenisalatmedis_nama'] : null;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'almes-m-grid',
    'dataProvider' => $modAlat->searchDialog(),
    'filter' => $modAlat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectObat",
				"onClick" => "inputAlatmedis($data->alatmedis_id);return false;"))',
        ),
        array(
            'header' => 'Jenis Alat Medis',
            'name' => 'jenisalatmedis_nama',
            'value' => '$data->jenisalatmedis->jenisalatmedis_nama',
            'type' => 'raw',
        ),
        'alatmedis_nama',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>