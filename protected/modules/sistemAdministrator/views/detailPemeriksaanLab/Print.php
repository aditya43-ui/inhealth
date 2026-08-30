<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 9));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $template = "{summary}\n{items}\n{pager}";
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
                    'header' => 'Nama Pemeriksaan',
                    'type' => 'raw',
                    'value' => '$data->pemeriksaanlab->pemeriksaanlab_nama',
                    'filter' => CHtml::activeTextField($model, 'pemeriksaanlab_nama'),
                ),
                array(
                    'header' => 'Kelompok Detail',
                    'type' => 'raw',
                    'value' => '$data->getNamaPemeriksaanDet($data->pemeriksaanlabdet_id)',
                    'filter' => CHtml::activeTextField($model, 'kelompokdet'),
                ),
                array(
                    'header' => 'Nama Pemeriksaan Detail',
                    'type' => 'raw',
                    'value' => '$data->getKelompokDet($data->pemeriksaanlabdet_id)',
                    'filter' => CHtml::activeTextField($model, 'namapemeriksaandet'),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_jeniskelamin',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_jeniskelamin'),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_nama',
                    'type' => 'raw',
                    'value' => '$data->NilaiRujukan',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_nama'),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_min',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_min', array('class' => 'numbers-only')),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_max',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_max', array('class' => 'numbers-only')),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_satuan',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_satuan', array('class' => 'numbers-only')),
                ),
                'pemeriksaanlabdet_nourut',
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
                                    'header' => 'Nama Pemeriksaan',
                                    'type' => 'raw',
                                    'value' => '$data->pemeriksaanlab->pemeriksaanlab_nama',
                                    'filter' => CHtml::activeTextField($model, 'pemeriksaanlab_nama'),
                                ),
                                array(
                                    'header' => 'Kelompok Detail',
                                    'type' => 'raw',
                                    'value' => '$data->getNamaPemeriksaanDet($data->pemeriksaanlabdet_id)',
                                    'filter' => CHtml::activeTextField($model, 'kelompokdet'),
                                ),
                                array(
                                    'header' => 'Nama Pemeriksaan Detail',
                                    'type' => 'raw',
                                    'value' => '$data->getKelompokDet($data->pemeriksaanlabdet_id)',
                                    'filter' => CHtml::activeTextField($model, 'namapemeriksaandet'),
                                ),
                                array(
                                    'name' => 'nilairujukan.nilairujukan_jeniskelamin',
                                    'type' => 'raw',
                                    'filter' => CHtml::activeTextField($model, 'nilairujukan_jeniskelamin'),
                                ),
                                array(
                                    'name' => 'nilairujukan.nilairujukan_nama',
                                    'type' => 'raw',
                                    'value' => '$data->NilaiRujukan',
                                    'filter' => CHtml::activeTextField($model, 'nilairujukan_nama'),
                                ),
                                array(
                                    'name' => 'nilairujukan.nilairujukan_min',
                                    'type' => 'raw',
                                    'filter' => CHtml::activeTextField($model, 'nilairujukan_min', array('class' => 'numbers-only')),
                                ),
                                array(
                                    'name' => 'nilairujukan.nilairujukan_max',
                                    'type' => 'raw',
                                    'filter' => CHtml::activeTextField($model, 'nilairujukan_max', array('class' => 'numbers-only')),
                                ),
                                array(
                                    'name' => 'nilairujukan.nilairujukan_satuan',
                                    'type' => 'raw',
                                    'filter' => CHtml::activeTextField($model, 'nilairujukan_satuan', array('class' => 'numbers-only')),
                                ),
                                'pemeriksaanlabdet_nourut',
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
                    'header' => 'Nama Pemeriksaan',
                    'type' => 'raw',
                    'value' => '$data->pemeriksaanlab->pemeriksaanlab_nama',
                    'filter' => CHtml::activeTextField($model, 'pemeriksaanlab_nama'),
                ),
                array(
                    'header' => 'Kelompok Detail',
                    'type' => 'raw',
                    'value' => '$data->getNamaPemeriksaanDet($data->pemeriksaanlabdet_id)',
                    'filter' => CHtml::activeTextField($model, 'kelompokdet'),
                ),
                array(
                    'header' => 'Nama Pemeriksaan Detail',
                    'type' => 'raw',
                    'value' => '$data->getKelompokDet($data->pemeriksaanlabdet_id)',
                    'filter' => CHtml::activeTextField($model, 'namapemeriksaandet'),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_jeniskelamin',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_jeniskelamin'),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_nama',
                    'type' => 'raw',
                    'value' => '$data->NilaiRujukan',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_nama'),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_min',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_min', array('class' => 'numbers-only')),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_max',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_max', array('class' => 'numbers-only')),
                ),
                array(
                    'name' => 'nilairujukan.nilairujukan_satuan',
                    'type' => 'raw',
                    'filter' => CHtml::activeTextField($model, 'nilairujukan_satuan', array('class' => 'numbers-only')),
                ),
                'pemeriksaanlabdet_nourut',
            ),
        ));
        ?>
    </div>

    <?php
}
?>