<?php 
// ============ DIALOG UNTUK CARI DATA OBAR DARI RESPON API ==================////
$ObatAPI = new ObatAPI;
// var_dump($ObatAPI->searchObat()->data);die;
$ObatAPI->unsetAttributes();
$ObatAPI->ruangan_id = $this->ruangan_apotek_tujuan_id;
if (isset($_GET['ObatAPI'])) {
    $ObatAPI->attributes = $_GET['ObatAPI'];
    $ObatAPI->is_search = true;
    $ObatAPI->ruanganapotektujuan_id = isset($_GET['ObatAPI']['ruangan_id']) ? $_GET['ObatAPI']['ruangan_id'] : null;
    $ObatAPI->ruangan_id = isset($_GET['ObatAPI']['ruangan_id']) ? $_GET['ObatAPI']['ruangan_id'] : null;
}
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRacikanObatDariApi',
    'options' => array(
        'title' => 'Data Obat',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>

<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatracikan-api-grid',
    'dataProvider' => $ObatAPI->searchObatRuangan($this->ruangan_apotek_tujuan_id),
    'filter' => $ObatAPI,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $btnCheck = CHtml::link('<i class="icon-form-check"></i>', '', [
                    'onclick' => '
                    $("#form-racikan #namaObatRacikDariApi").val("' . str_replace('"', '', $data['Nama']) . '");
                    setObatRacikanDariApi("'. $data['Kode'].'", "'. $data['jenis']. '", "' . $data['StFornas']. '", "' . $data['satuan']. '", "' . str_replace('"', '', $data['Nama']) . '", "' . $data['HJual'] . '", "' . $data['HPP'] . '");
                    '
                ]);
                
                echo $btnCheck;
            },
            'filter' => Chtml::activehiddenField($ObatAPI, 'ruangan_id')
        ),
        array(
            'header'=>'Nama Obat',
            'name'=>'Nama',
            // 'filter' => Chtml::activeTextField($ObatAPI, 'Nama', ['onkeyup' => 'searchOA(this, "obatracikan-api-grid")'])
        ),
        array(
            'header'=>'Jenis Fornas',
            // 'name'=>'Nama',
            'value' => function($data) {
                if($data['StFornas'] == 0) {
                    echo 'Non Fornas';
                } else {
                    echo 'Fornas';
                }
            }
        ),
        array(
            'header'=>'Jenis',
            'value' => function($data) {
                echo $data['jenis'];
            }
        ),
        array(
            'header'=>'Jumlah Stok',
            'value' => function($data) {
                echo $data['jmlStok'];
            }
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});


            }',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');