<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 7));
?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew');  
        ?>
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
            'id' => 'ptkp-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$data->ptkp_id',
                ),
                array(
                    'header' => 'Tanggal Berlaku',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglberlaku)'
                ),
                'jmltanggunan',
                array(
                    'header' => 'Tahun Wajib Pajak Tahun (Rp)',
                    'name' => 'wajibpajak_thn',
                    'value' => 'number_format($data->wajibpajak_thn,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Wajib Pajak Bulan (Rp)',
                    'name' => 'wajibpajak_bln',
                    'value' => 'number_format($data->wajibpajak_bln,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'statusperkawinan',
                'kodeptkp',
                array(
                    'header' => 'berlaku',
                    'value' => '(($data->berlaku==1)? "Ya" : "Tidak")',
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
                            'id' => 'ptkp-kelas-m-grid',
                            'enableSorting' => $sort,
                            'dataProvider' => $data,
                            'template' => $template,
                            'itemsCssClass' => 'table border',
                            'columns' => array(
                                array(
                                    'header' => 'ID',
                                    'value' => '$data->ptkp_id',
                                ),
                                array(
                                    'header' => 'Tanggal Berlaku',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglberlaku)'
                                ),
                                'jmltanggunan',
                                array(
                                    'header' => 'Wajib Pajak Tahun (Rp)',
                                    'name' => 'wajibpajak_thn',
                                    'value' => 'number_format($data->wajibpajak_thn,0,"",".")',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Wajib Pajak Bulan (Rp)',
                                    'name' => 'wajibpajak_bln',
                                    'value' => 'number_format($data->wajibpajak_bln,0,"",".")',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                'statusperkawinan',
                                'kodeptkp',
                                array(
                                    'header' => 'berlaku',
                                    'value' => '(($data->berlaku==1)? "Ya" : "Tidak")',
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
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); 
        ?>
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
            'id' => 'ptkp-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                array(
                    'header' => 'ID',
                    'value' => '$data->ptkp_id',
                ),
                array(
                    'header' => 'Tanggal Berlaku',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglberlaku)'
                ),
                'jmltanggunan',
                array(
                    'header' => 'Wajib Pajak Tahun (Rp)',
                    'name' => 'wajibpajak_thn',
                    'value' => 'number_format($data->wajibpajak_thn,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Wajib Pajak Bulan (Rp)',
                    'name' => 'wajibpajak_bln',
                    'value' => 'number_format($data->wajibpajak_bln,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                'statusperkawinan',
                'kodeptkp',
                array(
                    'header' => 'berlaku',
                    'value' => '(($data->berlaku==1)? "Ya" : "Tidak")',
                    'htmlOptions' => array('style' => 'text-align: center;')
                ),
            ),
        ));
        ?>
    </div>

<?php
}
?>