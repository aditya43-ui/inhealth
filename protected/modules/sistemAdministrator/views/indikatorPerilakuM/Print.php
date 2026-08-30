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
        $template = "{items}";
        $table = 'ext.bootstrap.widgets.BootGridView';
        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
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
                    'header' => 'Jabatan',
                    'name' => 'jabatan_id',
                    'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
                ),
                array(
                    'header' => 'Jenis Penilaian',
                    'name' => 'jenispenilaian_id',
                    'value' => '(isset($data->jenispenilaian->jenispenilaian_nama) ? $data->jenispenilaian->jenispenilaian_nama : "-")',
                ),
                array(
                    'header' => 'Kompetensi',
                    'name' => 'kompetensi_id',
                    'value' => '(isset($data->kompetensi->kompetensi_nama) ? $data->kompetensi->kompetensi_nama : "-")',
                ),
                'indikatorperilaku_nama',
                array(
                    'name' => 'indikatorperilaku_aktif',
                    'value' => '($data->indikatorperilaku_aktif == 1) ? "Aktif" : "Tidak Aktif"',
                    'filter' => array(1 => 'Aktif', 0 => 'Tidak Aktif'),
                    'htmlOptions' => array('style' => 'text-align:left;'),
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
                        $template = "{items}";
                        $table = 'ext.bootstrap.widgets.BootGridView';
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
                                    'header' => 'Jabatan',
                                    'name' => 'jabatan_id',
                                    'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
                                ),
                                array(
                                    'header' => 'Jenis Penilaian',
                                    'name' => 'jenispenilaian_id',
                                    'value' => '(isset($data->jenispenilaian->jenispenilaian_nama) ? $data->jenispenilaian->jenispenilaian_nama : "-")',
                                ),
                                array(
                                    'header' => 'Kompetensi',
                                    'name' => 'kompetensi_id',
                                    'value' => '(isset($data->kompetensi->kompetensi_nama) ? $data->kompetensi->kompetensi_nama : "-")',
                                ),
                                'indikatorperilaku_nama',
                                array(
                                    'name' => 'indikatorperilaku_aktif',
                                    'value' => '($data->indikatorperilaku_aktif == 1) ? "Aktif" : "Tidak Aktif"',
                                    'filter' => array(1 => 'Aktif', 0 => 'Tidak Aktif'),
                                    'htmlOptions' => array('style' => 'text-align:left;'),
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
        $template = "{items}";
        $table = 'ext.bootstrap.widgets.BootGridView';
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
                    'header' => 'Jabatan',
                    'name' => 'jabatan_id',
                    'value' => '(isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : "-")',
                ),
                array(
                    'header' => 'Jenis Penilaian',
                    'name' => 'jenispenilaian_id',
                    'value' => '(isset($data->jenispenilaian->jenispenilaian_nama) ? $data->jenispenilaian->jenispenilaian_nama : "-")',
                ),
                array(
                    'header' => 'Kompetensi',
                    'name' => 'kompetensi_id',
                    'value' => '(isset($data->kompetensi->kompetensi_nama) ? $data->kompetensi->kompetensi_nama : "-")',
                ),
                'indikatorperilaku_nama',
                array(
                    'name' => 'indikatorperilaku_aktif',
                    'value' => '($data->indikatorperilaku_aktif == 1) ? "Aktif" : "Tidak Aktif"',
                    'filter' => array(1 => 'Aktif', 0 => 'Tidak Aktif'),
                    'htmlOptions' => array('style' => 'text-align:left;'),
                ),
            ),
        ));
        ?>
    </div>

    <?php
}
?>