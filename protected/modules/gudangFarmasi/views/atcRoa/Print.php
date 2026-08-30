<?php
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
        $table = 'ext.bootstrap.widgets.BootGridView';
        $template = "{summary}\n{items}\n{pager}";
        if (isset($caraPrint)) {
            $template = "{items}";
            if ($caraPrint == 'EXCEL') {
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
                header('Cache-Control: max-age=0');
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
        }

//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Route of Adm ATC',
                    'value' => '$data->lookup_name',
                ),
                array(
                    'header' => 'Route of Adm ATC Lainnya',
                    'value' => '$data->lookup_value',
                ),
                array(
                    'header' => 'Urutan',
                    'value' => '$data->lookup_urutan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                        $template = "{summary}\n{items}\n{pager}";
                        if (isset($caraPrint)) {
                            $template = "{items}";
                            if ($caraPrint == 'EXCEL') {
                                header('Content-Type: application/vnd.ms-excel');
                                header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
                                header('Cache-Control: max-age=0');
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
                        }

//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $model->searchPrint(),
                            'template' => $template,
                            'itemsCssClass' => 'table border',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Route of Adm ATC',
                                    'value' => '$data->lookup_name',
                                ),
                                array(
                                    'header' => 'Route of Adm ATC Lainnya',
                                    'value' => '$data->lookup_value',
                                ),
                                array(
                                    'header' => 'Urutan',
                                    'value' => '$data->lookup_urutan',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $template = "{summary}\n{items}\n{pager}";
        if (isset($caraPrint)) {
            $template = "{items}";
            if ($caraPrint == 'EXCEL') {
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
                header('Cache-Control: max-age=0');
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
        }

//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>''));  

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
					($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
					: ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Route of Adm ATC',
                    'value' => '$data->lookup_name',
                ),
                array(
                    'header' => 'Route of Adm ATC Lainnya',
                    'value' => '$data->lookup_value',
                ),
                array(
                    'header' => 'Urutan',
                    'value' => '$data->lookup_urutan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->lookup_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
            ),
        ));
        ?>
    </div>

    <?php
}
?>