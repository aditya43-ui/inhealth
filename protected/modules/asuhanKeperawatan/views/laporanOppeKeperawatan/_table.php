<?php

$itemCssClass='table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchPrintLaporan();
    $data2 = $model->searchPrintLaporan();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    if ($caraPrint == 'PDF') {
        $table = 'ext.bootstrap.widgets.BootGridViewPDF';
    }

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
} else {
    $data = $model->searchLaporan();
    $data2 = $model->searchPrintLaporan();
    $template = "{summary}\n{items}\n{pager}";
}
$jumlah = 0;
$skor = 0;
foreach($data->data as $item){
    if (!empty($item->skor)) {
        $jumlah += $item->skor;
    } else {
        $jumlah += 0;
    }
}
if (!empty($data->data)) {
    $skor = $jumlah / count($data->data);
}

?>
<?php

$this->widget($table, array(
    'id' => 'laporan-oppe-grid',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No.',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'htmlOptions'=>array('style'=>'text-align: center',),
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            'footer' => false,
            'footerHtmlOptions' => array('hidden' => true),
        ),
        array(
            'header' => 'Indikator Kinerja',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                $modIndikator = IndikatoroppekeperawatanM::model()->findByPk($data->indikatoroppekeperawatan_id);
                echo $modIndikator->nama_indikator;
            },
            'footerHtmlOptions' => array('colspan' => 4, 'style' => 'text-align:center;'),
            'footer' => 'Skor Kinerja',
        ),
        array(
            'header' => 'Standar (%)',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'htmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo MyFormatter::formatNumberForPrint($data->standar_nilai, 2);
            }
        ),
        array(
            'header' => 'Capaian (%)',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'htmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo MyFormatter::formatNumberForPrint($data->capaian, 2);
            }
        ),
        array(
            'header' => 'Skor (%)',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'htmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo MyFormatter::formatNumberForPrint($data->skor, 2);
            },
            'footerHtmlOptions' => array('style' => 'text-align:center;'),
            'footer' => MyFormatter::formatNumberForPrint($skor, 2), 
        ),
        array(
            'header' => 'Keterangan',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                if ($data->skor < 80) {
                    echo "Kurang";
                } else if ($data->skor >= 80 && $data->skor < 90) {
                    echo "Baik";
                } else {
                    echo "Sangat Baik"; 
                }
            
            },
        ),
        array(
            'header' => 'Rekomendasi',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                $modIndikator = IndikatoroppekeperawatanM::model()->findByPk($data->indikatoroppekeperawatan_id);
                if ($data->skor < 80) {
                    echo $modIndikator->rekomendasi;
                } else {
                    echo "-";
                }
            },
        ),        
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
            $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
));
?>