<?php

$itemCssClass = 'table table-bordered table-striped table-condensed';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$sort = true;
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
if (isset($caraPrint)) {
    $row = '$row+1';
    $data = $model->searchLaporanDitolakPrint();
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
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
    $itemCssClass = 'table border';
} else {
    $data = $model->searchLaporanDitolak();
    $template = "{summary}\n{items}\n{pager}";
}

?>
<?php

$this->widget($table, array(
    'id' => 'laporan-insidenditolak-grid',
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
            'header' => 'No',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
        ),
        array(
            'header' => 'Tanggal Pelaporan',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo MyFormatter::formatDateTimeForUser($data->insidenrs_tgllapor);
            }
        ),
        array(
            'header' => 'Tempat Insiden / Lokasi Kejadian',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo $data->namaunitkerja ." / ".$data->ruangan_nama;
            }
        ),
        array(
            'header' => 'Insiden',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo $data->insidenrs_nama;
            }
        ),
        array(
            'header' => 'Kategori Penolakan',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo $data->kategoripenolakan;
            }
        ),
        array(
            'header' => 'Keterangan',
            'headerHtmlOptions'=>array('style'=>'text-align: center',),
            'value' => function($data){
                echo $data->alasan_persetujuan;
            }
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