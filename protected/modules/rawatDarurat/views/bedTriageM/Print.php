<?php
if ($caraPrint == 'GRAFIK' && $caraPrint != 'PRINT') {
    echo $this->renderPartial(
        'application.views.headerReport.headerDefaultNew',
        []
    );
    echo $this->renderPartial(
        '_grafik',
        ['model' => $model, 'data' => $data, 'caraPrint' => $caraPrint],
        true
    );
} ?>

<?php
$itemCssClass = 'table border';
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header(
        'Content-Disposition: attachment;filename="' .
            $judulLaporan .
            '-' .
            date('Y/m/d') .
            '.xls"'
    );
    header('Cache-Control: max-age=0');
    echo $this->renderPartial(
        'application.views.headerReport.headerDefaultNewExcel',
        ['judulLaporan' => $judulLaporan, 'colspan' => 4]
    );
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
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->searchPrint();
    $template = '{items}';
    $sort = false;
    if ($caraPrint == 'EXCEL') {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
} else {
    $data = $model->searchPrint();
    $template = "{summary}\n{items}\n{pager}";
}
if ($caraPrint == 'PRINT' && $caraPrint != 'GRAFIK') { ?>

 <table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header"><?php if (
                    $caraPrint != 'PDF' &&
                    $caraPrint != 'EXCEL' &&
                    $caraPrint != 'GRAFIK'
                ) {
                    echo $this->renderPartial(
                        'application.views.headerReport.headerDefaultNew',
                        ['judulLaporan' => $judulLaporan, 'colspan' => 10]
                    );
                } ?></div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                
                <?php $this->widget($table, [
                    'id' => 'sajenis-kelas-m-grid',
                    'enableSorting' => $sort,
                    'dataProvider' => $model->search(),
                    'template' => $template,
                    'itemsCssClass' =>
                        'table table-striped table-bordered table-condensed',
                    'columns' => [
                        [
                            'header' => 'No',
                            'value' =>
                                '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                        ],
                        [
                            'header' => 'No. Bed Triage',
                            'name' => 'no_bed',
                            'value' => '$data->no_bed',
                        ],
                        [
                            'header' => 'Keterangan',
                            'name' => 'keterangan',
                            'value' => '$data->keterangan',
                        ],
                        [
                            'header' => 'Status',
                            'value' =>
                                '($data->is_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        ],
                    ],
                ]); ?> 

		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<div class="">
</div>
<div class="footer">

    <?php echo $this->renderPartial(
        'application.views.headerReport.footerDefaultNew',
        []
    ); ?>

</div>   

<?php }
if ($caraPrint == 'PDF') {
    echo $this->renderPartial(
        'application.views.headerReport.headerDefaultNew',
        ['judulLaporan' => $judulLaporan, 'colspan' => 10]
    );
    $this->widget($table, [
        'id' => 'sajenis-kelas-m-grid',
        'enableSorting' => $sort,
        'dataProvider' => $model->search(),
        'template' => $template,
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => [
            [
                'header' => 'No',
                'value' =>
                    '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
            ],
            [
                'header' => 'No. Bed Triage',
                'name' => 'no_bed',
                'value' => '$data->no_bed',
            ],
            [
                'header' => 'Keterangan',
                'name' => 'keterangan',
                'value' => '$data->keterangan',
            ],
            [
                'header' => 'Status',
                'value' => '($data->is_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
            ],
        ],
    ]);
}


?>
