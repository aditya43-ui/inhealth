<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 5));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <?php
        $itemCssClass='table table-striped table-bordered table-condensed';
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL") {
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
            }if ($caraPrint == "PDF") {
                $itemCssClass='table border';
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
                ////'asalrujukan_id',
                array(
                    'header' => 'No.',
                    'value' => '$row+1',
                ),
                'asalrujukan.asalrujukan_nama',
                'namaperujuk',
                'spesialis',
                'alamatlengkap',
                'notelp',
            //'asalrujukan_aktif',
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
                        $itemCssClass='table table-striped table-bordered table-condensed';
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $sort = true;
                        if (isset($caraPrint)) {
                            $data = $model->searchPrint();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL") {
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                            }if ($caraPrint == "PDF") {
                                $itemCssClass='table border';
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
                                ////'asalrujukan_id',
                                array(
                                    'header' => 'No.',
                                    'value' => '$row+1',
                                ),
                                'asalrujukan.asalrujukan_nama',
                                'namaperujuk',
                                'spesialis',
                                'alamatlengkap',
                                'notelp',
                            //'asalrujukan_aktif',
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
        $itemCssClass='table border';
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL") {
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
            }if ($caraPrint == "PDF") {
                $itemCssClass='table border';
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
                ////'asalrujukan_id',
                array(
                    'header' => 'No.',
                    'value' => '$row+1',
                ),
                'asalrujukan.asalrujukan_nama',
                'namaperujuk',
                'spesialis',
                'alamatlengkap',
                'notelp',
            //'asalrujukan_aktif',
            ),
        ));
        ?>

    </div>

    <?php
}
?>