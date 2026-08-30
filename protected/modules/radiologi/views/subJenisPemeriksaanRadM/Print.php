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
        $template = "{summary}\n{items}\n{pager}";
        $this->widget($table, array(
            'id' => 'sapemeriksaan-rad-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                array(
                    'header' => 'No. ',
                    'value' => '($this->grid->dataProvider->pagination) ? 
                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1): ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align:center; width:5px;'),
                ),
                array(
                    'name' => 'subjenis_pr_nama',
                    'value' => '$data->subjenis_pr_nama',
                ),
                array(
                    'name' => 'subjenis_pr_namalainnya',
                    'value' => '$data->subjenis_pr_nama',
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->subjenis_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                        $this->widget($table, array(
                            'id' => 'sapemeriksaan-rad-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $model->searchPrint(),
                            'template' => $template,
                            'itemsCssClass' => 'table border',
                            'columns' => array(
                                ////'pemeriksaanrad_id',
                                array(
                                    'name' => 'pemeriksaanrad_id',
                                    'value' => '$data->pemeriksaanrad_id',
                                    'filter' => false,
                                ),
                                array(
                                    'name' => 'daftartindakan_id',
                                    //  'filter'=>  CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
                                    'filter' => CHtml::listData(DaftartindakanM::model()->findAll(array('order' => 'daftartindakan_nama')), 'daftartindakan_id', 'daftartindakan_nama'),
                                    'value' => '$data->daftartindakan->daftartindakan_nama',
                                ),
                                array(
                                    'header' => 'Jenis Pemeriksaan',
                                    'name' => 'jenispemeriksaanrad_nama',
                                    'filter' => CHtml::listData(JenispemeriksaanradM::model()->findAll(array('order' => 'jenispemeriksaanrad_nama')), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'),
                                    'value' => '$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',
                                ),
                                'pemeriksaanrad_nama',
                                'pemeriksaanrad_namalainnya',
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->pemeriksaanrad_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                                ),
                                //                array(
                                //                        'header'=>'Aktif',
                                //                        'class'=>'CCheckBoxColumn',     
                                //                        'selectableRows'=>0,
                                //                        'id'=>'rows',
                                //                        'checked'=>'$data->pemeriksaanrad_aktif',
                                //                ), 
                                //                    array(
                                //                            'header'=>Yii::t('zii','View'),
                                //                            'class'=>'bootstrap.widgets.BootButtonColumn',
                                //                            'template'=>'{view}',
                                //                            'buttons'=>array(
                                //                                'view'=>array(
                                //                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Sub-Jenis Pemeriksaan Radiologi'),
                                //                                ),
                                //                            ),
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
        $template = "{summary}\n{items}\n{pager}";
        $this->widget($table, array(
            'id' => 'sapemeriksaan-rad-m-grid',
            'enableSorting' => false,
            'dataProvider' => $model->searchPrint(),
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                ////'pemeriksaanrad_id',
                array(
                    'name' => 'pemeriksaanrad_id',
                    'value' => '$data->pemeriksaanrad_id',
                    'filter' => false,
                ),
                array(
                    'name' => 'daftartindakan_id',
                    //  'filter'=>  CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
                    'filter' => CHtml::listData(DaftartindakanM::model()->findAll(array('order' => 'daftartindakan_nama')), 'daftartindakan_id', 'daftartindakan_nama'),
                    'value' => '$data->daftartindakan->daftartindakan_nama',
                ),
                array(
                    'header' => 'Jenis Pemeriksaan',
                    'name' => 'jenispemeriksaanrad_nama',
                    'filter' => CHtml::listData(JenispemeriksaanradM::model()->findAll(array('order' => 'jenispemeriksaanrad_nama')), 'jenispemeriksaanrad_nama', 'jenispemeriksaanrad_nama'),
                    'value' => '$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',
                ),
                'pemeriksaanrad_nama',
                'pemeriksaanrad_namalainnya',
                array(
                    'header' => 'Status',
                    'value' => '($data->pemeriksaanrad_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                //                array(
                //                        'header'=>'Aktif',
                //                        'class'=>'CCheckBoxColumn',     
                //                        'selectableRows'=>0,
                //                        'id'=>'rows',
                //                        'checked'=>'$data->pemeriksaanrad_aktif',
                //                ), 
                //                    array(
                //                            'header'=>Yii::t('zii','View'),
                //                            'class'=>'bootstrap.widgets.BootButtonColumn',
                //                            'template'=>'{view}',
                //                            'buttons'=>array(
                //                                'view'=>array(
                //                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Sub-Jenis Pemeriksaan Radiologi'),
                //                                ),
                //                            ),
            ),
        ));
        ?>
    </div>

<?php
}
?>