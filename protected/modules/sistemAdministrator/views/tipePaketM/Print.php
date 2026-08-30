<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 10));
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
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                ////'tipepaket_id',
                array(
                    'name' => 'carabayar_id',
                    'filter' => CHtml::listData(SAPendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),
                    'value' => '$data->carabayar->carabayar_nama',
                ),
                array(
                    'name' => 'penjamin_id',
                    'filter' => CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = TRUE'), 'penjamin_id', 'penjamin_nama'),
                    'value' => '$data->penjamin->penjamin_nama',
                ),
                array(
                    'name' => 'kelaspelayanan_id',
                    'filter' => CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                    'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                ),
                'tipepaket_nama',
                'tipepaket_singkatan',
                //                'tarifpaket',
                //		'tipepaket_nama',
                //		'tipepaket_singkatan',
                //		'tipepaket_namalainnya',
                'tglkesepakatantarif',
                //		'nokesepakatantarif',
                //		'tarifpaket',
                array(
                    'header' => 'Tarif Paket (Rp)',
                    'name' => 'tarifpaket',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->tarifpaket)',
                ),
                array(
                    'header' => 'Paket Tanggungan Asuransi (Rp)',
                    'name' => 'paketsubsidiasuransi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidiasuransi)',
                ),
                //		'paketsubsidiasuransi',
                array(
                    'header' => 'Paket Tanggungan Pemerintah (Rp)',
                    'name' => 'paketsubsidipemerintah',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidipemerintah)',
                ),
                //		'paketsubsidipemerintah',
                array(
                    'header' => 'Paket Tanggungan Rumah Sakit (Rp)',
                    'name' => 'paketsubsidirs',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidirs)',
                ),
                //		'paketsubsidirs',
                array(
                    'header' => 'Paket Iur Biaya (Rp)',
                    'name' => 'paketiurbiaya',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketiurbiaya)',
                ),
                //		'paketiurbiaya',
                //		'nourut_tipepaket',
                //		'keterangan_tipepaket',
                //		'tipepaket_aktif',
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
                            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                            'columns' => array(
                                ////'tipepaket_id',
                                array(
                                    'name' => 'carabayar_id',
                                    'filter' => CHtml::listData(SAPendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),
                                    'value' => '$data->carabayar->carabayar_nama',
                                ),
                                array(
                                    'name' => 'penjamin_id',
                                    'filter' => CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = TRUE'), 'penjamin_id', 'penjamin_nama'),
                                    'value' => '$data->penjamin->penjamin_nama',
                                ),
                                array(
                                    'name' => 'kelaspelayanan_id',
                                    'filter' => CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                                    'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                                ),
                                'tipepaket_nama',
                                'tipepaket_singkatan',
                                //                'tarifpaket',
                                //		'tipepaket_nama',
                                //		'tipepaket_singkatan',
                                //		'tipepaket_namalainnya',
                                'tglkesepakatantarif',
                                //		'nokesepakatantarif',
                                //		'tarifpaket',
                                array(
                                    'header' => 'Tarif Paket (Rp)',
                                    'name' => 'tarifpaket',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->tarifpaket)',
                                ),
                                array(
                                    'header' => 'Paket Tanggungan Asuransi (Rp)',
                                    'name' => 'paketsubsidiasuransi',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidiasuransi)',
                                ),
                                //		'paketsubsidiasuransi',
                                array(
                                    'header' => 'Paket Tanggungan Pemerintah (Rp)',
                                    'name' => 'paketsubsidipemerintah',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidipemerintah)',
                                ),
                                //		'paketsubsidipemerintah',
                                array(
                                    'header' => 'Paket Tanggungan Rumah Sakit (Rp)',
                                    'name' => 'paketsubsidirs',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidirs)',
                                ),
                                //		'paketsubsidirs',
                                array(
                                    'header' => 'Paket Iur Biaya (Rp)',
                                    'name' => 'paketiurbiaya',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatNumberForPrint($data->paketiurbiaya)',
                                ),
                                //		'paketiurbiaya',
                                //		'nourut_tipepaket',
                                //		'keterangan_tipepaket',
                                //		'tipepaket_aktif',
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
            'id' => 'sajenis-kelas-m-grid',
            'enableSorting' => $sort,
            'dataProvider' => $data,
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                ////'tipepaket_id',
                array(
                    'name' => 'carabayar_id',
                    'filter' => CHtml::listData(SAPendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'),
                    'value' => '$data->carabayar->carabayar_nama',
                ),
                array(
                    'name' => 'penjamin_id',
                    'filter' => CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif = TRUE'), 'penjamin_id', 'penjamin_nama'),
                    'value' => '$data->penjamin->penjamin_nama',
                ),
                array(
                    'name' => 'kelaspelayanan_id',
                    'filter' => CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                    'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                ),
                'tipepaket_nama',
                'tipepaket_singkatan',
                //                'tarifpaket',
                //		'tipepaket_nama',
                //		'tipepaket_singkatan',
                //		'tipepaket_namalainnya',
                'tglkesepakatantarif',
                //		'nokesepakatantarif',
                //		'tarifpaket',
                array(
                    'header' => 'Tarif Paket (Rp)',
                    'name' => 'tarifpaket',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->tarifpaket)',
                ),
                array(
                    'header' => 'Paket Tanggungan Asuransi (Rp)',
                    'name' => 'paketsubsidiasuransi',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidiasuransi)',
                ),
                //		'paketsubsidiasuransi',
                array(
                    'header' => 'Paket Tanggungan Pemerintah (Rp)',
                    'name' => 'paketsubsidipemerintah',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidipemerintah)',
                ),
                //		'paketsubsidipemerintah',
                array(
                    'header' => 'Paket Tanggungan Rumah Sakit (Rp)',
                    'name' => 'paketsubsidirs',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketsubsidirs)',
                ),
                //		'paketsubsidirs',
                array(
                    'header' => 'Paket Iur Biaya (Rp)',
                    'name' => 'paketiurbiaya',
                    'type' => 'raw',
                    'value' => 'MyFormatter::formatNumberForPrint($data->paketiurbiaya)',
                ),
                //		'paketiurbiaya',
                //		'nourut_tipepaket',
                //		'keterangan_tipepaket',
                //		'tipepaket_aktif',
            ),
        ));
        ?>
    </div>
<?php
}
?>