
<?php
$itemCssClass = 'table table-striped table-condensed';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 4));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <?php
        $data = $model->searchPrint();
        $itemCssClass='table border';
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        $template = "{items}";
        $this->widget($table, array(
            'id' => 'sadiagnosakep-m-grid',
            'enableSorting' => false,
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$data->diagnosakep_id',
                ),
                array(
                    'header' => 'Kode Diagnosa',
                    'value' => '$data->diagnosakep_kode',
                ),
                array(
                    'header' => 'Diagnosa Keperawatan',
                    'value' => '$data->diagnosakep_nama',
                ),
                array(
                    'header' => 'Deskripsi',
                    'value' => '$data->diagnosakep_deskripsi',
                ),
                array(
                    'header' => 'Aktif',
                    'value' => '($data->diagnosakep_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                ),
            ),
        ));
        ?>

    </div>

    <?php
}
echo $this->renderPartial('application.views.headerReport.headerDefault', array('judulLaporan' => $judulLaporan, 'colspan' => 10));

$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
	$data = $model->searchPrint();
	$template = "{items}";
	$sort = false;
	if ($caraPrint == "EXCEL"){
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
            echo "
            <style>
                .border th, .border td{
                    border:1px solid #000;
                }
                .table thead:first-child{
                    border-top:1px solid #000;        
                }
           " ?>
    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => ''));
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <?php
                        $data = $model->searchPrint();
                        $itemCssClass='table border';
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $sort = true;
                        $template = "{items}";
                        $this->widget($table, array(
                            'id' => 'sadiagnosakep-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $data,
                            'template' => $template,
                            'enableSorting' => $sort,
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                array(
                                    'header' => 'ID',
                                    'value' => '$data->diagnosakep_id',
                                ),
                                array(
                                    'header' => 'Kode Diagnosa',
                                    'value' => '$data->diagnosakep_kode',
                                ),
                                array(
                                    'header' => 'Diagnosa Keperawatan',
                                    'value' => '$data->diagnosakep_nama',
                                ),
                                array(
                                    'header' => 'Deskripsi',
                                    'value' => '$data->diagnosakep_deskripsi',
                                ),
                                array(
                                    'header' => 'Aktif',
                                    'value' => '($data->diagnosakep_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                                ),
                            ),
                        ));
                        ?>

             <?php 
             
             echo ".border {
                    box-shadow:none;
                }

                .table tbody tr:hover td, .table tbody tr:hover th {
                    background-color: none;
                }
            </style>";
        $itemCssClass = 'table border';
            
        
} else {
	$data = $model->searchPrint();
	$template = "{summary}\n{items}\n{pager}";
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <?php
        $data = $model->searchPrint();
        $itemCssClass='table border';
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        $template = "{items}";
        $this->widget($table, array(
            'id' => 'sadiagnosakep-m-grid',
            'enableSorting' => false,
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$data->diagnosakep_id',
                ),
                array(
                    'header' => 'Kode Diagnosa',
                    'value' => '$data->diagnosakep_kode',
                ),
                array(
                    'header' => 'Diagnosa Keperawatan',
                    'value' => '$data->diagnosakep_nama',
                ),
                array(
                    'header' => 'Deskripsi',
                    'value' => '$data->diagnosakep_deskripsi',
                ),
                array(
                        'header'=>'No.',
                        'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                        : ($row+1)',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                ),
                array(
                    'header' => 'Kode Diagnosa',
                    'value' => '$data->diagnosakep_kode',
                ),
                array(
                    'header' => 'Diagnosa Keperawatan',
                    'value' => '$data->diagnosakep_nama',
                ),
                array(
                    'header' => 'Deskripsi',
                    'value' => '$data->diagnosakep_deskripsi',
                ),
                array(
                    'header' => 'Aktif',
                    'value' => '($data->diagnosakep_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                ),
	        ),
        ));
};
?>