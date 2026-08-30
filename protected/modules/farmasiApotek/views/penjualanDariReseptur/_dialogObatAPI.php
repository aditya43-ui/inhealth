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
    'id' => 'dialogOaAPI',
    'options' => array(
        'title' => 'Data Obat',
        'autoOpen' => false,
        'modal' => true,
        // 'zIndex' => 1002,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
        // 'position' => 'center',
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
                $stFornas = $data['StFornas'] ?? 0;
                $btnCheck = CHtml::link('<i class="icon-form-check"></i>', '', [
                    'onclick' => '
                        setObatDariApi("'. $data['Kode'].'", "'. $data['jenis']. '", "'. $data['jmlStok'] . '", "'. $data['HJual'] . '", "'. $stFornas . '", "'. $data['satuan'] . '", "'. str_replace('"', '', $data['Nama']) . '", "'. $data['HPP'] . '");
                    '
                ]);
                
                echo $btnCheck;
            },
        ),
        array(
            'header'=>'Nama Obat',
            'name'=>'Nama',
            // 'filter' => Chtml::activeTextField($ObatAPI, 'Nama', ['onkeyup' => 'searchOA(this, "obat-api-grid")'])
        ),
        array(
            'header'=>'Jenis Fornas',
            // 'name'=>'Nama',
            'value' => function($data) {
                $stFornas = $data['StFornas'] ?? 0;
                if($stFornas == 0) {
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
        array(
            'header'=>'Satuan',
            'value' => function($data) {
                echo $data['satuan'];
            }
        ),
        array(
            'header'=>'Harga Jual',
            'value' => function($data) {
                echo $data['HJual'];
            }
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});


            }',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script>
     // untuk fungsi pencarian pada dialog obat dari api
     const debounceDelay = 600; // setel  untuk jeda

    // Inisialisasi variabel timeout
    let debounceTimeout;

    function searchOA(obj, idGrid) {
        
        clearTimeout(debounceTimeout);
        
        // Setel timeout baru
        debounceTimeout = setTimeout(function() {
            // Kode pencarian yang akan dijalankan setelah jeda
            
            var cariNama = $(obj).val();
            console.log('nama dicari', cariNama);
            
            $.fn.yiiGridView.update(idGrid, {
                'ObatAPI[Nama]': cariNama
            }); //  fungsi pencarian dengan teks yang dimasukkan
            
        }, debounceDelay);

    }
    // end
</script>