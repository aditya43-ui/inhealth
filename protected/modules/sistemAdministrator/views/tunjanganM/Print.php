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
        $template = "{items}";


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
                    'htmlOptions' => array('style' => 'text-align:center; width:10px;'),
                ),
                array(
                    'name' => 'pangkat_id',
                    'type' => 'raw',
                    'value' => 'isset($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
                ),
                array(
                    'name' => 'jabatan_id',
                    'type' => 'raw',
                    'value' => 'isset($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
                ),
                array(
                    'name' => 'komponengaji_id',
                    'type' => 'raw',
                    'value' => 'isset($data->komponengaji_id)?$data->komponengaji->komponengaji_nama:"-"',
                ),
                array(
                    'header' => 'Nominal Tunjangan (Rp)',
                    'name' => 'nominaltunjangan',
                    'type' => 'raw',
                    'value' => 'number_format($data->nominaltunjangan,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Status',
                    'type' => 'raw',
                    'value' => '(($data->tunjangan_aktif) ? "Aktif" : "Tidak Aktif")',
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
                        $template = "{items}";


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
                                    'htmlOptions' => array('style' => 'text-align:center; width:10px;'),
                                ),
                                array(
                                    'name' => 'pangkat_id',
                                    'type' => 'raw',
                                    'value' => 'isset($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
                                ),
                                array(
                                    'name' => 'jabatan_id',
                                    'type' => 'raw',
                                    'value' => 'isset($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
                                ),
                                array(
                                    'name' => 'komponengaji_id',
                                    'type' => 'raw',
                                    'value' => 'isset($data->komponengaji_id)?$data->komponengaji->komponengaji_nama:"-"',
                                ),
                                array(
                                    'header' => 'Nominal Tunjangan (Rp)',
                                    'name' => 'nominaltunjangan',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->nominaltunjangan,0,"",".")',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Status',
                                    'type' => 'raw',
                                    'value' => '(($data->tunjangan_aktif) ? "Aktif" : "Tidak Aktif")',
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
        $template = "{items}";


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
                    'htmlOptions' => array('style' => 'text-align:center; width:10px;'),
                ),
                array(
                    'name' => 'pangkat_id',
                    'type' => 'raw',
                    'value' => 'isset($data->pangkat_id)?$data->pangkat->pangkat_nama:"-"',
                ),
                array(
                    'name' => 'jabatan_id',
                    'type' => 'raw',
                    'value' => 'isset($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
                ),
                array(
                    'name' => 'komponengaji_id',
                    'type' => 'raw',
                    'value' => 'isset($data->komponengaji_id)?$data->komponengaji->komponengaji_nama:"-"',
                ),
                array(
                    'header' => 'Nominal Tunjangan (Rp)',
                    'name' => 'nominaltunjangan',
                    'type' => 'raw',
                    'value' => 'number_format($data->nominaltunjangan,0,"",".")',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Status',
                    'type' => 'raw',
                    'value' => '(($data->tunjangan_aktif) ? "Aktif" : "Tidak Aktif")',
                ),
            ),
        ));
        ?>
    </div>

<?php
}
?>