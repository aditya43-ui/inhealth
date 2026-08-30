<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 12));
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

                        $searchPrint = $model->searchInformasiPegawai();
                        $searchPrint->pagination = false;

                        $artab = array(
                            array(
                                'header' => 'Tanggal Pesan',
//				'name'=>'tglpesanmenu',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
                            ),
                            array(
                                'header' => 'No. Pesan',
                                'type' => 'raw',
//                            'name' => 'nopesanmenu',     
                                'value' => '$data->nopesanmenu'
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
                            'header' => 'Nama Pemesan',
                            'type' => 'raw',
//                            'name' => 'jenispesanmenu', 
                            'value' => '$data->nama_pemesan'
                                ),
//			'nama_pemesan',
                                array(
                            'header' => 'Jenis Kelamin',
                            'type' => 'raw',
//                            'name' => 'jenisdiet.jenisdiet_nama',
                            'value' => '$data->jeniskelamin'
                                ), array(
                            'header' => 'NIK',
                            'type' => 'raw',
//                            'name' => 'bahandiet.bahandiet_nama',
                            'value' => '$data->noidentitas'
                                ), array(
                            'header' => 'Keterangan Pesan',
                            'type' => 'raw',
//                            'name' => 'bahandiet.bahandiet_nama',
                            'value' => '$data->keterangan_pesan'
                                )
                        );
                        foreach (JeniswaktuM::getJenisWaktu() as $row) {

                            array_push($artab, array(
                                'header' => $row->jeniswaktu_nama,
                                'type' => 'raw',
                                'value' => '$data->getMenuDiet($data->pesanmenudiet_id, $data->pegawai_id, ' . $row->jeniswaktu_id . ', "' . Params::JENISPESANMENU_PEGAWAI . '")'
                            ));
//                
                        }

                        array_push($artab, array(
                            'header' => 'Status Terima',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $kirim = KirimmenudietT::model()->findByAttributes(array(
                                    'pesanmenudiet_id' => $data->pesanmenudiet_id,
                                ));

                                if (empty($kirim)) {
                                    return "Pemesanan Belum Diproses";
                                } else {
                                    if ($data->status_terima == TRUE) {
                                        return "Sudah Diterima";
                                    } else {
                                        return "Belum Diterima";
                                    }
                                }
                            }
                        ));

                        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                            'id' => 'gzpesanmenudietpegawai-v-grid',
                            'dataProvider' => $searchPrint,
                            //	'filter'=>$model,
                            'template' => "{items}",
                            'itemsCssClass' => 'table table-striped table-condensed',
                            'replaceUrl' => 'true',
                            'mergeHeaders' => array(
                                array(
                                    'name' => '<p style="margin: 0; text-align: center;">Menu Diet</p>',
                                    'start' => 7, //indeks kolom 3
                                    'end' => 11, //indeks kolom 4
                                ),
                            ),
                            'columns' => $artab,
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

        $searchPrint = $model->searchInformasiPegawai();
        $searchPrint->pagination = false;

        $artab = array(
            array(
                'header' => 'Tanggal Pesan',
//				'name'=>'tglpesanmenu',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
            ),
            array(
                'header' => 'No. Pesan',
                'type' => 'raw',
//                            'name' => 'nopesanmenu',     
                'value' => '$data->nopesanmenu'
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
            'header' => 'Nama Pemesan',
            'type' => 'raw',
//                            'name' => 'jenispesanmenu', 
            'value' => '$data->nama_pemesan'
                ),
//			'nama_pemesan',
                array(
            'header' => 'Jenis Kelamin',
            'type' => 'raw',
//                            'name' => 'jenisdiet.jenisdiet_nama',
            'value' => '$data->jeniskelamin'
                ), array(
            'header' => 'NIK',
            'type' => 'raw',
//                            'name' => 'bahandiet.bahandiet_nama',
            'value' => '$data->noidentitas'
                ), array(
            'header' => 'Keterangan Pesan',
            'type' => 'raw',
//                            'name' => 'bahandiet.bahandiet_nama',
            'value' => '$data->keterangan_pesan'
                )
        );
        foreach (JeniswaktuM::getJenisWaktu() as $row) {

            array_push($artab, array(
                'header' => $row->jeniswaktu_nama,
                'type' => 'raw',
                'value' => '$data->getMenuDiet($data->pesanmenudiet_id, $data->pegawai_id, ' . $row->jeniswaktu_id . ', "' . Params::JENISPESANMENU_PEGAWAI . '")'
            ));
//                
        }

        array_push($artab, array(
            'header' => 'Status Terima',
            'type' => 'raw',
            'value' => function ($data) {
                $kirim = KirimmenudietT::model()->findByAttributes(array(
                    'pesanmenudiet_id' => $data->pesanmenudiet_id,
                ));

                if (empty($kirim)) {
                    return "Pemesanan Belum Diproses";
                } else {
                    if ($data->status_terima == TRUE) {
                        return "Sudah Diterima";
                    } else {
                        return "Belum Diterima";
                    }
                }
            }
        ));

        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'gzpesanmenudietpegawai-v-grid',
            'dataProvider' => $searchPrint,
            //	'filter'=>$model,
            'template' => "{items}",
            'itemsCssClass' => 'table border',
            'replaceUrl' => 'true',
            'mergeHeaders' => array(
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Menu Diet</p>',
                    'start' => 7, //indeks kolom 3
                    'end' => 11, //indeks kolom 4
                ),
            ),
            'columns' => $artab,
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