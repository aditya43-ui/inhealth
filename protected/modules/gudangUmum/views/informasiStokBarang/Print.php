<?php

if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => '', 'colspan' => 7));
}
//echo $this->renderPartial('application.views.headerReport.headerPrint', array('judulLaporan' => "Informasi Stok Barang", 'colspan' => 10, 'caraPrint' => $caraPrint));

?>
<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {


?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php

                                        if ($caraPrint != 'EXCEL') {
                                            echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                                        }
                                        ?></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <br>
                        <div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
                        <br>
                        <?php
                        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
                        $sort = true;
                        $row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
                        if (isset($caraPrint)) {
                            $row = '$row+1';
                            $data = $model->searchPrint();
                            $template = "{items}";
                            $sort = false;
                            if ($caraPrint == "EXCEL") {
                                $table = 'ext.bootstrap.widgets.BootExcelGridView';
                            } else if ($caraPrint == "PDF") {
                                $table = 'ext.bootstrap.widgets.BootGridViewPDF';
                            }
                            echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
                        } else {
                            $data = $model->searchPrint();
                            $template = "{summary}\n{items}\n{pager}";
                        }

                        //$criteria = new CDbCriteria();
                        //$criteria->select = 'sum(case when inventarisasi_keadaan = :p1 then (inventarisasi_qty_in-inventarisasi_qty_out) else 0 end) as inventarisasi_qty_skrg';
                        ////        $criteria->select = 'sum(case when inventarisasi_keadaan = :p1 then inventarisasi_qty_skrg else 0 end) as inventarisasi_qty_skrg';
                        //$criteria->addCondition('barang_id = :p2 and ruangan_id = :p3 and inventarisasiruangan_aktif = TRUE');
                        //$keadaan = LookupM::getItems("inventariskeadaan");


                        $this->widget($table, array(
                            'id' => 'informasistokbarang-grid',
                            'dataProvider' => $data,
                            //	'filter'=>$model,
                            'itemsCssClass' => 'table border',
                            'mergeHeaders' => array(
                                array(
                                    'name' => '<p style="margin: 0; text-align: center;">Kondisi Barang</p>',
                                    'start' => 8,
                                    'end' => 10,
                                ),
                            ),
                            'template' => $template,
                            'itemsCssClass' => 'table table-bordered table-striped datatable',
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
                                    'header' => 'Kode Barang',
                                    'type' => 'raw',
                                    'value' => '$data->barang_kode',
                                ),
                                array(
                                    'header' => 'Jenis Barang',
                                    'type' => 'raw',
                                    'value' => '$data->jenisbarang_nama',
                                ),
                                array(
                                    'header' => 'Nama Barang',
                                    'type' => 'raw',
                                    'value' => '$data->barang_nama',
                                ),
                                array(
                                    'header' => 'Merk',
                                    'type' => 'raw',
                                    'value' => '$data->barang_merk',
                                ),
                                array(
                                    'header' => 'No. Seri',
                                    'type' => 'raw',
                                    'value' => '$data->barang_noseri',
                                ),
                                array(
                                    'header' => 'Tahun Beli',
                                    'type' => 'raw',
                                    'value' => '$data->barang_thnbeli',
                                ),
                                array(
                                    'header' => 'Harga Beli (Rp)',
                                    'type' => 'raw',
                                    'value' => (Params::cekHiddenHargaGudangUmum() == true) ? 'MyFormatter::formatNumberForPrint($data->inventarisasi_hargabeli_avg)' : '"Hidden"',
                                    'htmlOptions' => array('style' => (Params::cekHiddenHargaGudangUmum() == true) ? 'text-align: right;' : "text-align: center;"),
                                ),
                                array(
                                    'header' => 'Baik',
                                    'type' => 'raw',
                                    'value' => '$data->qtykeadaan_baik." ".$data->barang_satuan',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Dalam Perbaikan',
                                    'type' => 'raw',
                                    'value' => '$data->qtykeadaan_dalamperbaikan." ".$data->barang_satuan',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Rusak',
                                    'type' => 'raw',
                                    'value' => '$data->qtykeadaan_rusak." ".$data->barang_satuan',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                                array(
                                    'header' => 'Jumlah Barang',
                                    'type' => 'raw',
                                    'value' => '$data->inventarisasi_stok." ".$data->barang_satuan',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        )); ?>
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {  ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php  }  ?>
    </div>

<?php
}
if ($caraPrint == 'PDF') {
?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan   ?> </div>
        <br>
        <?php
        $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
        $sort = true;
        $row = '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1';
        if (isset($caraPrint)) {
            $row = '$row+1';
            $data = $model->searchPrint();
            $template = "{items}";
            $sort = false;
            if ($caraPrint == "EXCEL") {
                $table = 'ext.bootstrap.widgets.BootExcelGridView';
            } else if ($caraPrint == "PDF") {
                $table = 'ext.bootstrap.widgets.BootGridViewPDF';
            }


            echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing: 0;
                padding: 0;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        } else {
            $data = $model->searchPrint();
            $template = "{summary}\n{items}\n{pager}";
        }

        //$criteria = new CDbCriteria();
        //$criteria->select = 'sum(case when inventarisasi_keadaan = :p1 then (inventarisasi_qty_in-inventarisasi_qty_out) else 0 end) as inventarisasi_qty_skrg';
        ////        $criteria->select = 'sum(case when inventarisasi_keadaan = :p1 then inventarisasi_qty_skrg else 0 end) as inventarisasi_qty_skrg';
        //$criteria->addCondition('barang_id = :p2 and ruangan_id = :p3 and inventarisasiruangan_aktif = TRUE');
        //$keadaan = LookupM::getItems("inventariskeadaan");


        $this->widget($table, array(
            'id' => 'informasistokbarang-grid',
            'dataProvider' => $data,
            'itemsCssClass' => 'table border',
            'mergeHeaders' => array(
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Kondisi Barang</p>',
                    'start' => 8,
                    'end' => 10,
                ),
            ),
            'template' => $template,
            'itemsCssClass' => 'table table-bordered table-striped datatable',
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
                    'header' => 'Kode Barang',
                    'type' => 'raw',
                    'value' => '$data->barang_kode',
                ),
                array(
                    'header' => 'Jenis Barang',
                    'type' => 'raw',
                    'value' => '$data->jenisbarang_nama',
                ),
                array(
                    'header' => 'Nama Barang',
                    'type' => 'raw',
                    'value' => '$data->barang_nama',
                ),
                array(
                    'header' => 'Merk',
                    'type' => 'raw',
                    'value' => '$data->barang_merk',
                ),
                array(
                    'header' => 'No. Seri',
                    'type' => 'raw',
                    'value' => '$data->barang_noseri',
                ),
                array(
                    'header' => 'Tahun Beli',
                    'type' => 'raw',
                    'value' => '$data->barang_thnbeli',
                ),
                array(
                    'header' => 'Harga Beli (Rp)',
                    'type' => 'raw',
                    'value' => (Params::cekHiddenHargaGudangUmum() == true) ? 'MyFormatter::formatNumberForPrint($data->inventarisasi_hargabeli_avg)' : '"Hidden"',
                    'htmlOptions' => array('style' => (Params::cekHiddenHargaGudangUmum() == true) ? 'text-align: right;' : "text-align: center;"),
                ),
                array(
                    'header' => 'Baik',
                    'type' => 'raw',
                    'value' => '$data->qtykeadaan_baik." ".$data->barang_satuan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Dalam Perbaikan',
                    'type' => 'raw',
                    'value' => '$data->qtykeadaan_dalamperbaikan." ".$data->barang_satuan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Rusak',
                    'type' => 'raw',
                    'value' => '$data->qtykeadaan_rusak." ".$data->barang_satuan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'header' => 'Jumlah Barang',
                    'type' => 'raw',
                    'value' => '$data->inventarisasi_stok." ".$data->barang_satuan',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>

<?php
}

?>