<?php
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 4));
}else{
    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'colspan' => 4));

} 
?>
    <div class="header">
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); 
        ?>
    </div>
    <div class="content">
        <?php
        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                ////'rakobat_id',
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                                ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                : ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),

array(
                            'name' => 'ruangan_nama',
                        //    'value' => '($data->lokasiobat_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                        'value' => '$data->ruangan->ruangan_nama',

                        ), 
                  // 'rakobat_id',
                  array(
                    'name'=>'rakobat_nama',
                    'value'=>'$data->rakobat->rakobat_nama'
                ),
                array(
                    'name' => 'obatalkes_nama',
                //    'value' => '($data->lokasiobat_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
                'value' => '$data->obatalkes->obatalkes_nama',

            ),
            array(
                'header' => 'Status',
                'value' => '($data->penyimpananobat_aktif == true ) ? "Aktif" : "Tidak Aktif"',
                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
            ),
            ),
        ));
        ?>
    </div>