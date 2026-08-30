<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                ////'komponengaji_id',
                array(
                    'header' => 'ID',
                    'value' => '$data->komponengaji_id',
                ),
                'nourutgaji',
                'komponengaji_kode',
                'komponengaji_nama',
                'komponengaji_singkt',
                array(
                    'header' => 'Potongan',
                    'value' => '(($data->ispotongan==1)? "Ya" : "Tidak")',
                ),
                array(
                    'header' => 'Tipe Komponen Gaji',
                    'value' => '$data->tipekomponengaji',
                ),
                array(
                    'header' => 'Aktif',
                    'value' => '(($data->komponengaji_aktif==1)? "Ya" : "Tidak")',
                )
            /*
              'komponengaji_aktif',
             */
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
                        if (isset($caraPrint)) {
                            $data = $model->searchPrint();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL")
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                        } else {
                            $data = $model->searchPrint();
                            $template = "{summary}\n{items}\n{pager}";
                        }

                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => $sort,
                            'dataProvider' => $data,
                            'template' => $template,
                            'itemsCssClass' => 'table border',
                            'columns' => array(
                                ////'komponengaji_id',
                                array(
                                    'header' => 'ID',
                                    'value' => '$data->komponengaji_id',
                                ),
                                'nourutgaji',
                                'komponengaji_kode',
                                'komponengaji_nama',
                                'komponengaji_singkt',
                                array(
                                    'header' => 'Potongan',
                                    'value' => '(($data->ispotongan==1)? "Ya" : "Tidak")',
                                ),
                                array(
                                    'header' => 'Tipe Komponen Gaji',
                                    'value' => '$data->tipekomponengaji',
                                ),
                                array(
                                    'header' => 'Aktif',
                                    'value' => '(($data->komponengaji_aktif==1)? "Ya" : "Tidak")',
                                )
                            /*
                              'komponengaji_aktif',
                             */
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
        $sort = true;
        if (isset($caraPrint)) {
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                ////'komponengaji_id',
                array(
                    'header' => 'ID',
                    'value' => '$data->komponengaji_id',
                ),
                'nourutgaji',
                'komponengaji_kode',
                'komponengaji_nama',
                'komponengaji_singkt',
                array(
                    'header' => 'Potongan',
                    'value' => '(($data->ispotongan==1)? "Ya" : "Tidak")',
                ),
                array(
                    'header' => 'Tipe Komponen Gaji',
                    'value' => '$data->tipekomponengaji',
                ),
                array(
                    'header' => 'Aktif',
                    'value' => '(($data->komponengaji_aktif==1)? "Ya" : "Tidak")',
                )
            /*
              'komponengaji_aktif',
             */
            ),
        ));
        ?>
    </div>

    <?php
}
?>