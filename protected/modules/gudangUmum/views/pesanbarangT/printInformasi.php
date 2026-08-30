
<?php

if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
        echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => '', 'colspan' => 5));
    }
}
?>
<?php

if (!empty($caraPrint) && $caraPrint != 'CSV') {

    echo CHtml::css('.control-label{
        float:left; 
        text-align: right; 
        width:50%;
        color:black;
        padding-right:10px;
        font-size:8pt;
    }
    body{
        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    
    .table{
        box-shadow:none;
        border: 1px solid black;
        border-radius: 0;
    }
    
    .table-bordered {
        border-collapse: collapse;
    }
        
    .table th, .table td {
        border: 1px solid black;
        color: black !important;    
    }
    
    .table-bordered th + th {
        border-left: none;
    }
    
    .table-bordered td + td {
        border-left: none;
    }

    .kertas{
     width:20cm;
     height:12cm;
    }
');

    
}

$grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}


$prov = $model->searchInformasiGudang();
$prov->pagination = false;
$prov->sort = false;

?>
<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'CSV') {
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
                        <br>
                        <div class="judulcontent"> <?php //echo $judulLaporan ?></div>
                        <br>
                        <?php
                            
$this->widget($grid_view, array(
    'id' => 'gupesanbarang-t-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Pemesan',
            'name' => 'tglpesanbarang',
            'value' => '$data->tglpesanbarang',
        ),
        array(
            'header' => 'No. Pemesan',
            'type' => 'raw',
            'name' => 'nopemesanan',
            'value' => function($data) {
                return CHtml::link('<u>' . $data->nopemesanan . '</u>', Yii::app()->controller->createUrl("/gudangUmum/PesanbarangT/detailPesanBarang", array('id' => $data->pesanbarang_id)), array(
                            "id" => $data->pesanbarang_id, "target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pemesanan Barang", "onclick" => "window.parent.$('#dialogDetail').dialog('open');"
                ));
            },
        ),
        array(
            'header' => 'Ruangan/<br>Pegawai Pemesan',
            'value' => '$data->ruanganpemesan->ruangan_nama." \ ".$data->pegawaipemesan->nama_pegawai'
        ),
        'keterangan_pesan',
        array(
            'header' => 'Tgl. Kirim',
            'value' => '$data->tglmintadikirim',
        ),
        array(
            'header' => 'Pegawai Pengirim',
            'value' => function($data) use (&$mutasi) {

                $mutasi = MutasibrgT::model()->findAllByAttributes(array(
                    'pesanbarang_id' => $data->pesanbarang_id
                ));

                if (empty($data->mutasibrg_id)) {
                    return '-';
                } else {
                    $p = GUMutasibrgT::model()->findByPk($data->mutasibrg_id);

                    return $p->pegawaipengirim->nama_pegawai;
                }
            }
        ),
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
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan ?></div>
        <br>
        <?php
        
$this->widget($grid_view, array(
    'id' => 'gupesanbarang-t-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Pemesan',
            'name' => 'tglpesanbarang',
            'value' => '$data->tglpesanbarang',
        ),
        array(
            'header' => 'No. Pemesan',
            'type' => 'raw',
            'name' => 'nopemesanan',
            'value' => function($data) {
                return CHtml::link('<u>' . $data->nopemesanan . '</u>', Yii::app()->controller->createUrl("/gudangUmum/PesanbarangT/detailPesanBarang", array('id' => $data->pesanbarang_id)), array(
                            "id" => $data->pesanbarang_id, "target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pemesanan Barang", "onclick" => "window.parent.$('#dialogDetail').dialog('open');"
                ));
            },
        ),
        array(
            'header' => 'Ruangan/<br>Pegawai Pemesan',
            'value' => '$data->ruanganpemesan->ruangan_nama." \ ".$data->pegawaipemesan->nama_pegawai'
        ),
        'keterangan_pesan',
        array(
            'header' => 'Tgl. Kirim',
            'value' => '$data->tglmintadikirim',
        ),
        array(
            'header' => 'Pegawai Pengirim',
            'value' => function($data) use (&$mutasi) {

                $mutasi = MutasibrgT::model()->findAllByAttributes(array(
                    'pesanbarang_id' => $data->pesanbarang_id
                ));

                if (empty($data->mutasibrg_id)) {
                    return '-';
                } else {
                    $p = GUMutasibrgT::model()->findByPk($data->mutasibrg_id);

                    return $p->pegawaipengirim->nama_pegawai;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
        
        ?>
    </div>

    <?php
}
if ($caraPrint == 'CSV') {

$this->widget($grid_view, array(
    'id' => 'gupesanbarang-t-grid',
    'dataProvider' => $prov,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Tgl. Pemesan',
            'name' => 'tglpesanbarang',
            'value' => '$data->tglpesanbarang',
        ),
        array(
            'header' => 'No. Pemesan',
            'type' => 'raw',
            'name' => 'nopemesanan',
            'value' => function($data) {
                return CHtml::link('<u>' . $data->nopemesanan . '</u>', Yii::app()->controller->createUrl("/gudangUmum/PesanbarangT/detailPesanBarang", array('id' => $data->pesanbarang_id)), array(
                            "id" => $data->pesanbarang_id, "target" => "frameDetail", "rel" => "tooltip", "title" => "Klik untuk Detail Pemesanan Barang", "onclick" => "window.parent.$('#dialogDetail').dialog('open');"
                ));
            },
        ),
        array(
            'header' => 'Ruangan/<br>Pegawai Pemesan',
            'value' => '$data->ruanganpemesan->ruangan_nama." \ ".$data->pegawaipemesan->nama_pegawai'
        ),
        'keterangan_pesan',
        array(
            'header' => 'Tgl. Kirim',
            'value' => '$data->tglmintadikirim',
        ),
        array(
            'header' => 'Pegawai Pengirim',
            'value' => function($data) use (&$mutasi) {

                $mutasi = MutasibrgT::model()->findAllByAttributes(array(
                    'pesanbarang_id' => $data->pesanbarang_id
                ));

                if (empty($data->mutasibrg_id)) {
                    return '-';
                } else {
                    $p = GUMutasibrgT::model()->findByPk($data->mutasibrg_id);

                    return $p->pegawaipengirim->nama_pegawai;
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
}
?>

