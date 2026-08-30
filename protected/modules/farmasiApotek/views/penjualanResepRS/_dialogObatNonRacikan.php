<?php
// ============ DIALOG UNTUK CARI DATA OBAR DARI RESPON API ==================////
$ObatAPI = new ObatAPI;
// var_dump($ObatAPI->searchObat()->data);die;
$ObatAPI->unsetAttributes();

if (isset($_GET['ObatAPI'])) {
    $ObatAPI->attributes = $_GET['ObatAPI'];
    $ObatAPI->is_search = true;
}
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogObatDariApi',
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
$dataProvider = $ObatAPI->searchObatRuangan(Yii::app()->user->getState('ruangan_id'));
if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RI) {
    $dataProvider = $ObatAPI->searchObat();
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatnonracikan-api-grid',
    'dataProvider' => $dataProvider,
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
                    $("#form-nonracikan #namaObatNonRacikDariApi").val("' . str_replace('"', '', $data['Nama']) . '");
                    $("#form-nonracikan #st_fornas").val("' . $data['StFornas'] . '");
                    $("#form-nonracikan #hargasatuan_reseptur").val("' . $data['HJual'] . '");
                    setObatDariApi("'. $data['Kode'].'", "'. $data['jenis']. '", "' . $data['StFornas']. '", "' . $data['HJual'] . '", "' . $data['satuan'] . '", "' . str_replace('"', '', $data['Nama']) . '", "' . $data['HPP'] . '");
                    '
                ]);
                
                echo $btnCheck;
            },
        ),
        array(
            'header'=>'Nama Obat',
            'name'=>'Nama',
            // 'filter' => Chtml::activeTextField($ObatAPI, 'Nama', ['onkeyup' => 'searchOA(this, "obatnonracikan-api-grid")'])
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