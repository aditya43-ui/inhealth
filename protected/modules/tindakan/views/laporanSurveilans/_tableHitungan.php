<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
$itemCssClass='table table-striped table-condensed';
    if (isset($caraPrint)){
        $data = $model->searchPrintRekap(false);
        $template = "{items}";
        $sort = false;
        echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }

                thead th{
                    background:none;
                    color:#333;
                }

                .border {
                    box-shadow:none;
                    border-spacing: 0;
                    padding: 0;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
          $itemCssClass='table border';
           if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
           }
    } else{
        $data = $model->searchPrintRekap(false);
         $template = "{items}";
    }
    

$arr_infeksi = array(array(
    'jenis_infeksi'=>'IDO',
    'jumlah_surgery'=>0,
    'jumlah_infeksi'=>0
));    

$arr_alat = array(
    array(
        'jenis_infeksi'=>'VAP',
        'jumlah_pemasangan'=>0,
        'lama_pemasangan'=>0,
        'jumlah_infeksi'=>0,
    ),
    array(
        'jenis_infeksi'=>'IADP',
        'jumlah_pemasangan'=>0,
        'lama_pemasangan'=>0,
        'jumlah_infeksi'=>0,
    ),
    array(
        'jenis_infeksi'=>'ISK',
        'jumlah_pemasangan'=>0,
        'lama_pemasangan'=>0,
        'jumlah_infeksi'=>0,
    ),
    array(
        'jenis_infeksi'=>'Phlebitis',
        'jumlah_pemasangan'=>0,
        'lama_pemasangan'=>0,
        'jumlah_infeksi'=>0,
    ),
);

$arr_dek = array(
    array(
        'jenis_infeksi'=>'Dekubitus',
        'jumlah_infeksi'=>0,
    )
);

foreach ($data->data as $item) {
    
    $tgl_awal = new DateTime($item->surveilans_tgl);
    $tgl_akhir = new DateTime($item->pelepasan_tgl);
    
    $hari = $tgl_awal->diff($tgl_akhir)->d;
    
    $arr_infeksi[0]['jumlah_infeksi'] += $item->ido;
    $arr_infeksi[0]['jumlah_surgery'] += $item->surgery;
    
    // vap
    if ($item->ett > 0) {
        $arr_alat[0]['jumlah_pemasangan'] += $item->ett;
        $arr_alat[0]['lama_pemasangan'] += $hari;
        $arr_alat[0]['jumlah_infeksi'] += $item->ido;
    }
    
    if ($item->cvp > 0 || $item->cvc > 0 || $item->cdl > 0) {
        $arr_alat[1]['jumlah_pemasangan'] += $item->cvp;
        $arr_alat[1]['jumlah_pemasangan'] += $item->cvc;
        $arr_alat[1]['jumlah_pemasangan'] += $item->cdl;
        $arr_alat[1]['lama_pemasangan'] += $hari;
        $arr_alat[1]['lama_pemasangan'] += $hari;
        $arr_alat[1]['lama_pemasangan'] += $hari;
        $arr_alat[1]['jumlah_infeksi'] += $item->ido;
    }
    
    if ($item->uc > 0) {
        $arr_alat[2]['jumlah_pemasangan'] += $item->uc;
        $arr_alat[2]['lama_pemasangan'] += $hari;
        $arr_alat[2]['jumlah_infeksi'] += $item->ido;
    }
    
    if ($item->cdl > 0) {
        $arr_alat[3]['jumlah_pemasangan'] += $item->cdl;
        $arr_alat[3]['lama_pemasangan'] += $hari;
        $arr_alat[3]['jumlah_infeksi'] += $item->ido;
    }
    
    $arr_dek[0]['jumlah_infeksi'] += $item->deku;
}   

$prov_infeksi = new CArrayDataProvider($arr_infeksi, array(
    'id'=>'tab_infeksi',
    'keyField'=>'jenis_infeksi'
));


$prov_infeksi_alat = new CArrayDataProvider($arr_alat, array(
    'id'=>'tab_infeksi_alat',
    'keyField'=>'jenis_infeksi'
));
$prov_infeksi_dek = new CArrayDataProvider($arr_dek, array(
    'id'=>'tab_infeksi_dek',
    'keyField'=>'jenis_infeksi'
));
$this->widget($table,array(
	'id'=>'tableHitungInfeksi',
	'dataProvider'=>$prov_infeksi,
    'template'=>$template,
    'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
        array(
            'header'=>'Jenis Infeksi',
            'name'=>'jenis_infeksi'
        ),
        array(
            'header'=>'Jumlah Pemasangan',
            'name'=>'jumlah_surgery'
        ),
        array(
            'header'=>'Jumlah Infeksi',
            'name'=>'jumlah_infeksi'
        ),
        array(
            'header'=>'Rate (%)',
            'type'=>'raw',
            'value'=>function($data) {
                if ($data['jumlah_surgery'] == 0) {
                    return 0;
                }
                
                return number_format(($data['jumlah_infeksi'] * 100 / $data['jumlah_surgery']), 2, ",", "");
            }
        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->widget($table,array(
	'id'=>'tableHitungInfeksiAlat',
	'dataProvider'=>$prov_infeksi_alat,
    'template'=>$template,
    'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
        array(
            'header'=>'Jenis Infeksi',
            'name'=>'jenis_infeksi'
        ),
        array(
            'header'=>'Jumlah Pemasangan',
            'name'=>'jumlah_pemasangan'
        ),
        array(
            'header'=>'Lama Pemasangan',
            'name'=>'lama_pemasangan'
        ),
        array(
            'header'=>'Jumlah Infeksi',
            'name'=>'jumlah_infeksi'
        ),
        array(
            'header'=>'Rate (&permil;)',
            'type'=>'raw',
            'value'=>function($data) {
                if ($data['lama_pemasangan'] == 0) {
                    return 0;
                }
                
                return number_format(($data['jumlah_infeksi'] * 1000 / $data['lama_pemasangan']), 2, ",", "");
            }
        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->widget($table,array(
	'id'=>'tableHitungInfeksiDekubitus',
	'dataProvider'=>$prov_infeksi_dek,
    'template'=>$template,
    'itemsCssClass'=>$itemCssClass,
	'columns'=>array(
        array(
            'header'=>'Jenis Infeksi',
            'name'=>'jenis_infeksi'
        ),
        array(
            'header'=>'Jumlah Infeksi',
            'name'=>'jumlah_infeksi'
        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));


    
?>

