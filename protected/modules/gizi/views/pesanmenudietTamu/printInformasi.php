<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 5));
}
//echo $this->renderPartial('application.views.headerReport.headerLaporanTransaksi',array('judulLaporan'=>$judulLaporan, 'periode'=>'Periode : '.$periode , 'colspan'=>8));  

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        if ($caraPrint != 'EXCEL') {
                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode));
                        }
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">

                        <?php
                        $grid_view = 'ext.bootstrap.widgets.BootGridView';

                        if (!empty($caraPrint)) {
                            if ($caraPrint == 'PDF') {
                                $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
                            } else if ($caraPrint == 'EXCEL') {
                                $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
                            }
                        }
                        $artab = array(
                            array(
                                'header' => 'Tanggal Pesan',
                                'name' => 'tglpesanmenu',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
                            ),
                            array(
                                'header' => 'No. Pesan',
                                'name' => 'nopesanmenu',
                            ),
                        );
                        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                            array_push($artab, array(
                                'header' => 'Instalasi / Ruangan',
                                'type' => 'raw',
                                'value' => '$data->ruangan->instalasi->instalasi_nama." / ".$data->ruangan->ruangan_nama',
                                'headerHtmlOptions' => array('style' => 'vertical-align: middle;text-align:left;')
                            ));
                        }
                        array_push($artab, array(
                            'header' => 'Jenis Pesanan',
                            'name' => 'jenispesanmenu',
                                ),
//                    'nama_pemesan',
                                array(
                            'header' => 'Nama Pasien',
//                                    'name' => 'jenisdiet.jenisdiet_nama',
                            'value' => '(!empty($data->pendaftaran_id)?(!empty($data->pendaftaran->pasien_id)?$data->pendaftaran->pasien->nama_pasien:""):"")',
                                ), array(
                            'header' => 'Jenis Diet',
                            'name' => 'jenisdiet.jenisdiet_nama',
                                )
                        );

                        array_push($artab, array(
                            'header' => 'Status Terima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if (empty($data->kirimmenudiet_id)) {
                                    echo "Pemesanan Belum Diproses";
                                } else {
                                    if ($data->status_terima == TRUE) {
                                        echo "Sudah Diterima";
                                    } else {
                                        echo "Belum Diterima";
                                    }
                                }
                            }
                        ));

                        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                            'id' => 'gzpesanmenudietpasien-v-grid',
                            'dataProvider' => $model->searchInformasiPendampingPrint(),
                            //	'filter'=>$model,
                            'template' => "{items}",
                            'itemsCssClass' => 'table table-striped table-condensed',
                            'columns' => $artab,
                            'enableSorting' => false,
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?>
    </div>
    <div class="content">

        <?php
        $grid_view = 'ext.bootstrap.widgets.BootGridView';

        if (!empty($caraPrint)) {
            if ($caraPrint == 'PDF') {
                $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
            } else if ($caraPrint == 'EXCEL') {
                $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
            }
        }
        $artab = array(
            array(
                'header' => 'Tanggal Pesan',
                'name' => 'tglpesanmenu',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
            ),
            array(
                'header' => 'No. Pesan',
                'name' => 'nopesanmenu',
            ),
        );
        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
            array_push($artab, array(
                'header' => 'Instalasi / Ruangan',
                'type' => 'raw',
                'value' => '$data->ruangan->instalasi->instalasi_nama." / ".$data->ruangan->ruangan_nama',
                'headerHtmlOptions' => array('style' => 'vertical-align: middle;text-align:left;')
            ));
        }
        array_push($artab, array(
            'header' => 'Jenis Pesanan',
            'name' => 'jenispesanmenu',
                ),
//                    'nama_pemesan',
                array(
            'header' => 'Nama Pasien',
//                                    'name' => 'jenisdiet.jenisdiet_nama',
            'value' => '(!empty($data->pendaftaran_id)?(!empty($data->pendaftaran->pasien_id)?$data->pendaftaran->pasien->nama_pasien:""):"")',
                ), array(
            'header' => 'Jenis Diet',
            'name' => 'jenisdiet.jenisdiet_nama',
                )
        );

        array_push($artab, array(
            'header' => 'Status Terima',
            'type' => 'raw',
            'value' => function ($data) {
                if (empty($data->kirimmenudiet_id)) {
                    echo "Pemesanan Belum Diproses";
                } else {
                    if ($data->status_terima == TRUE) {
                        echo "Sudah Diterima";
                    } else {
                        echo "Belum Diterima";
                    }
                }
            }
        ));

        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'gzpesanmenudietpasien-v-grid',
            'dataProvider' => $model->searchInformasiPendampingPrint(),
            //	'filter'=>$model,
            'template' => "{items}",
            'itemsCssClass' => 'table border',
            'columns' => $artab,
            'enableSorting' => false,
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?>
    </div>

    <?php
}
if ($caraPrint == 'GRAFIK') {
    ?>
    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header">  <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">

                        <?php //echo $this->renderPartial($this->path_view.'_grafik', array('model'=>$model, 'data'=>$data, 'caraPrint'=>$caraPrint), true); ?>

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
        <?php
        if (isset($caraPrint) && $caraPrint != "PDF") {
            echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array());
            ?>

        <?php } ?>
    </div>

    <?php
}
?>