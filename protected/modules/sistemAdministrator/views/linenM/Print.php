<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 6));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <?php
        $itemCssClass='table border';
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        $table = 'ext.bootstrap.widgets.BootGridView';
        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                array(
                    'header' => 'ID',
                    // 'value'=>'$data->linen_id',
                    'value' => '(!empty($data->linen_id) ? $data->linen_id : "-")',
                ),
                array(
                    'header' => 'Ruangan',
                    'type' => 'raw',
                    'name' => 'ruangan_id',
                    // 'value'=>'$data->ruangan->ruangan_nama',
                    'value' => '(!empty($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-")',
                    'filter' => CHtml::activeDropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                        'ruangan_aktif' => true,
                                            ), array(
                                        'order' => 'ruangan_nama',
                                    )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Rak Penyimpanan',
                    'type' => 'raw',
                    'value' => function($data) {
                        $rak = RakpenyimpananM::model()->findByPk($data->rakpenyimpanan_id);
                        return empty($rak) ? "-" : $rak->rakpenyimpanan_nama;
                    },
                    'filter' => CHtml::activeDropDownList($model, 'rakpenyimpanan_id', CHtml::listData(RakpenyimpananM::model()->findAllByAttributes(array(
                                        'rakpenyimpanan_aktif' => true,
                                            ), array(
                                        'order' => 'rakpenyimpanan_nama',
                                    )), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Jenis',
                    'name' => 'jenislinen_id',
                    'type' => 'raw',
                    'value' => '$data->jenis->jenislinen_nama',
                    'value' => '(!empty($data->jenis->jenislinen_nama) ? $data->jenis->jenislinen_nama : "-")',
                    'filter' => CHtml::activeDropDownList($model, 'jenislinen_id', CHtml::listData(JenislinenM::model()->findAll(array(
                                        'order' => 'jenislinen_nama',
                                    )), 'jenislinen_id', 'jenislinen_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Bahan',
                    'type' => 'raw',
                    'name' => 'bahanlinen_id',
                    // 'value'=>'$data->bahan->bahanlinen_nama',
                    'value' => '(!empty($data->bahan->bahanlinen_nama) ? $data->bahan->bahanlinen_nama : "-")',
                    'filter' => CHtml::activeDropDownList($model, 'bahanlinen_id', CHtml::listData(BahanlinenM::model()->findAllByAttributes(array(
                                        'bahanlinen_aktif' => true,
                                            ), array(
                                        'order' => 'bahanlinen_nama',
                                    )), 'bahanlinen_id', 'bahanlinen_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Nama Linen',
                    'type' => 'raw',
                    'name' => 'barang_nama',
                    'value' => 'isset($data->barang->barang_nama)?$data->barang->barang_nama:"-"'
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->linen_aktif)?"Aktif":"Tidak Aktif"',
                ),
//		
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
                        $itemCssClass='table border';
                        $data = $model->searchPrint();
                        $template = "{items}";
                        $sort = false;
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $this->widget($table, array(
                            'id' => 'sajenis-kelas-m-grid',
                            'enableSorting' => false,
                            'dataProvider' => $data,
                            'template' => $template,
                            'enableSorting' => $sort,
                            'itemsCssClass' => $itemCssClass,
                            'columns' => array(
                                array(
                                    'header' => 'ID',
                                    // 'value'=>'$data->linen_id',
                                    'value' => '(!empty($data->linen_id) ? $data->linen_id : "-")',
                                ),
                                array(
                                    'header' => 'Ruangan',
                                    'type' => 'raw',
                                    'name' => 'ruangan_id',
                                    // 'value'=>'$data->ruangan->ruangan_nama',
                                    'value' => '(!empty($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-")',
                                    'filter' => CHtml::activeDropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                                        'ruangan_aktif' => true,
                                                            ), array(
                                                        'order' => 'ruangan_nama',
                                                    )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                                ),
                                array(
                                    'header' => 'Rak Penyimpanan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $rak = RakpenyimpananM::model()->findByPk($data->rakpenyimpanan_id);
                                        return empty($rak) ? "-" : $rak->rakpenyimpanan_nama;
                                    },
                                    'filter' => CHtml::activeDropDownList($model, 'rakpenyimpanan_id', CHtml::listData(RakpenyimpananM::model()->findAllByAttributes(array(
                                                        'rakpenyimpanan_aktif' => true,
                                                            ), array(
                                                        'order' => 'rakpenyimpanan_nama',
                                                    )), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'), array('empty' => '-- Pilih --')),
                                ),
                                array(
                                    'header' => 'Jenis',
                                    'name' => 'jenislinen_id',
                                    'type' => 'raw',
                                    'value' => '$data->jenis->jenislinen_nama',
                                    'value' => '(!empty($data->jenis->jenislinen_nama) ? $data->jenis->jenislinen_nama : "-")',
                                    'filter' => CHtml::activeDropDownList($model, 'jenislinen_id', CHtml::listData(JenislinenM::model()->findAll(array(
                                                        'order' => 'jenislinen_nama',
                                                    )), 'jenislinen_id', 'jenislinen_nama'), array('empty' => '-- Pilih --')),
                                ),
                                array(
                                    'header' => 'Bahan',
                                    'type' => 'raw',
                                    'name' => 'bahanlinen_id',
                                    // 'value'=>'$data->bahan->bahanlinen_nama',
                                    'value' => '(!empty($data->bahan->bahanlinen_nama) ? $data->bahan->bahanlinen_nama : "-")',
                                    'filter' => CHtml::activeDropDownList($model, 'bahanlinen_id', CHtml::listData(BahanlinenM::model()->findAllByAttributes(array(
                                                        'bahanlinen_aktif' => true,
                                                            ), array(
                                                        'order' => 'bahanlinen_nama',
                                                    )), 'bahanlinen_id', 'bahanlinen_nama'), array('empty' => '-- Pilih --')),
                                ),
                                array(
                                    'header' => 'Nama Linen',
                                    'type' => 'raw',
                                    'name' => 'barang_nama',
                                    'value' => 'isset($data->barang->barang_nama)?$data->barang->barang_nama:"-"'
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '($data->linen_aktif)?"Aktif":"Tidak Aktif"',
                                ),
//		
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
        $data = $model->searchPrint();
        $template = "{items}";
        $sort = false;
        $table = 'ext.bootstrap.widgets.BootGridView';
        $this->widget($table, array(
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => false,
            'dataProvider' => $data,
            'template' => $template,
            'enableSorting' => $sort,
            'itemsCssClass' => $itemCssClass,
            'columns' => array(
                array(
                    'header' => 'ID',
                    // 'value'=>'$data->linen_id',
                    'value' => '(!empty($data->linen_id) ? $data->linen_id : "-")',
                ),
                array(
                    'header' => 'Ruangan',
                    'type' => 'raw',
                    'name' => 'ruangan_id',
                    // 'value'=>'$data->ruangan->ruangan_nama',
                    'value' => '(!empty($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-")',
                    'filter' => CHtml::activeDropDownList($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                                        'ruangan_aktif' => true,
                                            ), array(
                                        'order' => 'ruangan_nama',
                                    )), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Rak Penyimpanan',
                    'type' => 'raw',
                    'value' => function($data) {
                        $rak = RakpenyimpananM::model()->findByPk($data->rakpenyimpanan_id);
                        return empty($rak) ? "-" : $rak->rakpenyimpanan_nama;
                    },
                    'filter' => CHtml::activeDropDownList($model, 'rakpenyimpanan_id', CHtml::listData(RakpenyimpananM::model()->findAllByAttributes(array(
                                        'rakpenyimpanan_aktif' => true,
                                            ), array(
                                        'order' => 'rakpenyimpanan_nama',
                                    )), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Jenis',
                    'name' => 'jenislinen_id',
                    'type' => 'raw',
                    'value' => '$data->jenis->jenislinen_nama',
                    'value' => '(!empty($data->jenis->jenislinen_nama) ? $data->jenis->jenislinen_nama : "-")',
                    'filter' => CHtml::activeDropDownList($model, 'jenislinen_id', CHtml::listData(JenislinenM::model()->findAll(array(
                                        'order' => 'jenislinen_nama',
                                    )), 'jenislinen_id', 'jenislinen_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Bahan',
                    'type' => 'raw',
                    'name' => 'bahanlinen_id',
                    // 'value'=>'$data->bahan->bahanlinen_nama',
                    'value' => '(!empty($data->bahan->bahanlinen_nama) ? $data->bahan->bahanlinen_nama : "-")',
                    'filter' => CHtml::activeDropDownList($model, 'bahanlinen_id', CHtml::listData(BahanlinenM::model()->findAllByAttributes(array(
                                        'bahanlinen_aktif' => true,
                                            ), array(
                                        'order' => 'bahanlinen_nama',
                                    )), 'bahanlinen_id', 'bahanlinen_nama'), array('empty' => '-- Pilih --')),
                ),
                array(
                    'header' => 'Nama Linen',
                    'type' => 'raw',
                    'name' => 'barang_nama',
                    'value' => 'isset($data->barang->barang_nama)?$data->barang->barang_nama:"-"'
                ),
                array(
                    'header' => 'Status',
                    'value' => '($data->linen_aktif)?"Aktif":"Tidak Aktif"',
                ),
//		
            ),
        ));
        ?>

    </div>

    <?php
}
?>
