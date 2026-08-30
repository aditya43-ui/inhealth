<?php
/**
 * digunakan untuk modul portal rs post berita
 * RSST-2443
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */
?>
<?php

$itemCssClass = 'table table-striped table-bordered table-condensed';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}
if ($caraPrint != "PDF") {
    echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
}
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchNew();
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }if ($caraPrint == "PDF") {
        $itemCssClass = 'table border';
    }
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}

$this->widget($table, array(
    'id' => 'sajenis-kelas-m-grid',
    'enableSorting' => false,
    'dataProvider' => $data,
    'template' => $template,
    'enableSorting' => $sort,
    'itemsCssClass' => $itemCssClass,
    'columns' => array(
        array(
                            'header' => 'No',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Kategori',
                            'name' => 'kategoripost_nama',
                            'value' => function($data) {

                                if (!empty($data->kategoripost_id)) {
                                    return $data->kategoripost_nama;
                                }
                            },
                        ),
                        array(
                            'header' => 'Nama Lainnya',
                            'name' => 'kategoripost_namalain',
                            'type' => 'raw',
                            'value' => function($data) {

                                if (!empty($data->kategoripost_id)) {
                                    return $data->kategoripost_namalain;
                                }
                            },
                        ),
                        
                        array(
                            'name' => 'Gambar Kategori Berita',
                            'type' => 'raw',
                            'value' => 'CHtml::image(Params::urlKategoriBeritaGambar().$data->kategoripost_gambar,"", array("width"=>"120px","height"=>"110px"))',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                            'headerHtmlOptions' => array('style' => 'color:#373e4a;vertical-align:top;text-align:center;'),
                            'filter' => false,
                        ),
                       
                        array(
                            'header' => 'Status',
                            'value' => '($data->kategoripost_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align:center;'),
                        ),
    ),
));
?>