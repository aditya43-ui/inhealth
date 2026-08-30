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
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obat-api-grid',
    'dataProvider' => $ObatAPI->searchObatRuangan(Yii::app()->user->getState('ruangan_id')),
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
						$("#obatalkes_id_nama").val("' . str_replace('"', '', $data['Nama']) . '");
					
						setObatDariApi("'. $data['Kode'].'", "'. $data['jenis']. '", "' . $data['StFornas']. '", "' . $data['HJual']. '", "' . $data['satuan']. '", "' . $data['HPP'] . '", "' . str_replace('"', '', $data['Nama']) . '");
                    '
                ]);
                
                echo $btnCheck;
            },
        ),
        array(
            'header'=>'Nama Obat',
            'name'=>'Nama',
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
?>