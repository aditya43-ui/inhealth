<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew');  
        ?>
    </div>
    <div class="content">

        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        $row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
        if (isset($caraPrint)) {
            $row = '$row+1';
            $data = $model->searchPrintSuplier();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL") {
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
            }
            if ($caraPrint == 'PDF') {
                $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
            $itemCssClass = "table border";
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                ////'supplier_id',
                array(
                    'header' => 'No.',
                    'value' => $row,
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'supplier_kode',
                'supplier_nama',
                'supplier_alamat',
                array(
                    'header' => 'No. Telepon',
                    'name' => 'supplier_cp',
                    'value' => '$data->supplier_cp',
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
            ),
        ));
        ?>
    </div>

<?php
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'EXCEL') {
?>

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
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $sort = true;
                        $row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
                        if (isset($caraPrint)) {
                            $row = '$row+1';
                            $data = $model->searchPrintSuplier();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL") {
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                            }
                            if ($caraPrint == 'PDF') {
                                $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
                            $itemCssClass = "table border";
                        } else {
                            $data = $model->searchPrint();
                            $template = "{summary}\n{items}\n{pager}";
                        }

                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => $sort,
                            'dataProvider' => $data,
                            'template' => $template,
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                ////'supplier_id',
                                array(
                                    'header' => 'No.',
                                    'value' => $row,
                                ),
                                'supplier_kode',
                                'supplier_nama',
                                'supplier_alamat',
                                array(
                                    'header' => 'No. Telepon',
                                    'name' => 'supplier_cp',
                                    'value' => '$data->supplier_cp',
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                ),
                            ),
                        ));
                        ?>
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>

<?php
}
if ($caraPrint == 'PDF') {
?>
    <div class="header">
        <?php $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); 
        ?>
    </div>
    <div class="content">

        <div class="judulcontent"> <?php //echo $judulLaporan     
                                    ?> </div>
        <br>

        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        $row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
        if (isset($caraPrint)) {
            $row = '$row+1';
            $data = $model->searchPrintSuplier();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL") {
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
            }
            if ($caraPrint == 'PDF') {
                $table = 'ext.bootstrap.widgets.BootGroupGridViewPDF';
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
            $itemCssClass = "table border";
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                ////'supplier_id',
                array(
                    'header' => 'No.',
                    'value' => $row,
                ),
                'supplier_kode',
                'supplier_nama',
                'supplier_alamat',
                array(
                    'header' => 'No. Telepon',
                    'name' => 'supplier_cp',
                    'value' => '$data->supplier_cp',
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
            ),
        ));
        ?>
    </div>

<?php
}
?>