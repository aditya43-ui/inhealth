<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'colspan' => 2));
    ?>
    <div class="header">
        <?php //echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <?php
        $modTipePaket = new SATipePaketM('search');
        if (isset($_GET['SAPaketpelayananM'])) {
            $modTipePaket->tipepaket_nama = $_GET['SAPaketpelayananM']['tipepaketNama'];
        }
        ?>
        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $modTipePaket->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $modTipePaket->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'satipe-paket-m-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            //'filter'=>$modTipePaket, 
            'template' => $template,
            'itemsCssClass' => 'table table-striped table-bordered table-condensed',
            'columns' => array(
                ////'tipepaket_id',
//        array( 
//                        'name'=>'tipepaket_id', 
//                        'value'=>'$data->tipepaket_id', 
//                        'filter'=>false, 
//                ),
//        'kelaspelayanan_id',
//        'penjamin_id',
//        'carabayar_id',
                array(
                    'header' => 'No.',
                    'value' => '$row+1'
                ),
                'tipepaket_nama',
                array(
                    'header' => 'Uraian Tindakan',
                    'type' => 'raw',
                    'value' => '$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.paketpelayananM._daftarTindakan\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
                ),
            //'tipepaket_singkatan',
            /*
              'tipepaket_namalainnya',
              'tglkesepakatantarif',
              'nokesepakatantarif',
              'tarifpaket',
              'paketsubsidiasuransi',
              'paketsubsidipemerintah',
              'paketsubsidirs',
              'paketiurbiaya',
              'nourut_tipepaket',
              'keterangan_tipepaket',
              'tipepaket_aktif',
             */
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
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
                        $modTipePaket = new SATipePaketM('search');
                        if (isset($_GET['SAPaketpelayananM'])) {
                            $modTipePaket->tipepaket_nama = $_GET['SAPaketpelayananM']['tipepaketNama'];
                        }
                        ?>
                        <?php
                        $table = 'ext.bootstrap.widgets.BootGridView';
                        $sort = true;
                        if (isset($caraPrint)) {
                            $data = $modTipePaket->searchPrint();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL")
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                        } else {
                            $data = $modTipePaket->searchPrint();
                            $template = "{summary}\n{items}\n{pager}";
                        }

                        $this->widget($table, array(
                            'id' => 'satipe-paket-m-grid',
                            'dataProvider' => $data,
                            'enableSorting' => $sort,
                            //'filter'=>$modTipePaket, 
                            'template' => $template,
                           'itemsCssClass' => 'table border',
                            'columns' => array(
                                ////'tipepaket_id',
//        array( 
//                        'name'=>'tipepaket_id', 
//                        'value'=>'$data->tipepaket_id', 
//                        'filter'=>false, 
//                ),
//        'kelaspelayanan_id',
//        'penjamin_id',
//        'carabayar_id',
                                array(
                                    'header' => 'No.',
                                    'value' => '$row+1'
                                ),
                                'tipepaket_nama',
                                array(
                                    'header' => 'Uraian Tindakan',
                                    'type' => 'raw',
                                    'value' => '$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.paketpelayananM._daftarTindakan\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
                                ),
                            //'tipepaket_singkatan',
                            /*
                              'tipepaket_namalainnya',
                              'tglkesepakatantarif',
                              'nokesepakatantarif',
                              'tarifpaket',
                              'paketsubsidiasuransi',
                              'paketsubsidipemerintah',
                              'paketsubsidirs',
                              'paketiurbiaya',
                              'nourut_tipepaket',
                              'keterangan_tipepaket',
                              'tipepaket_aktif',
                             */
                            ),
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
        <?php //$this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => '')); ?>
    </div>
    <div class="content">
        <?php
        $modTipePaket = new SATipePaketM('search');
        if (isset($_GET['SAPaketpelayananM'])) {
            $modTipePaket->tipepaket_nama = $_GET['SAPaketpelayananM']['tipepaketNama'];
        }
        ?>
        <?php
        $table = 'ext.bootstrap.widgets.BootGridView';
        $sort = true;
        if (isset($caraPrint)) {
            $data = $modTipePaket->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL")
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
        } else {
            $data = $modTipePaket->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        $this->widget($table, array(
            'id' => 'satipe-paket-m-grid',
            'dataProvider' => $data,
            'enableSorting' => $sort,
            //'filter'=>$modTipePaket, 
            'template' => $template,
            'itemsCssClass' => 'table border',
            'columns' => array(
                ////'tipepaket_id',
//        array( 
//                        'name'=>'tipepaket_id', 
//                        'value'=>'$data->tipepaket_id', 
//                        'filter'=>false, 
//                ),
//        'kelaspelayanan_id',
//        'penjamin_id',
//        'carabayar_id',
                array(
                    'header' => 'No.',
                    'value' => '$row+1'
                ),
                'tipepaket_nama',
                array(
                    'header' => 'Uraian Tindakan',
                    'type' => 'raw',
                    'value' => '$this->grid->getOwner()->renderPartial(\'sistemAdministrator.views.paketpelayananM._daftarTindakan\',array(\'tipepaket_id\'=>$data->tipepaket_id),true)',
                ),
            //'tipepaket_singkatan',
            /*
              'tipepaket_namalainnya',
              'tglkesepakatantarif',
              'nokesepakatantarif',
              'tarifpaket',
              'paketsubsidiasuransi',
              'paketsubsidipemerintah',
              'paketsubsidirs',
              'paketiurbiaya',
              'nourut_tipepaket',
              'keterangan_tipepaket',
              'tipepaket_aktif',
             */
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));
        ?> 
    </div>

    <?php
}
?>