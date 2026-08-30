<style>
    @page {
        margin-top: 12mm;
    }

    @media print {
        #headers {
            position: fixed;
            top: 0;
        }

        body {
            display:table;
            table-layout:fixed;
            padding-top:4cm;
            padding-left: 1mm;
            height:auto;
            width:100%;
        }
    }

    .btn-danger{
        background-color: #a91e1e;
        border:#981b1b 1px solid;		
    }

</style>
<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
}

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF') {
    ?>

    <table width="100%">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                        ?></div>  
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="content">
                        <br>
                        <div class="judulcontent"> <?php echo $judulLaporan ?> <br> <?php echo $periode ?></div>
                        <br>
                        <?php $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama; ?>
                        <div style="text-align: center;">
                            <!--<h2><?php //echo $judulLaporan;                 ?></h2>-->
                           <!-- <b>Periode : <?php //echo $periode;                 ?></b><br>-->
                            <b>Ruangan : <?php echo $ruanganAsal; ?></b>
                        </div>
                        <?php
                        $totalharganetto = 0;

                        $prov = $model->searchPrint();
                        $cloneProv = clone $prov;

                        foreach ($cloneProv->data as $dataClone){
                            $totalharganetto += $dataClone->totalhutangusaha;
                        }
                        $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
                            'id' => 'fakturpembelian-m-grid',
                            'dataProvider' => $model->searchPrint(),
                            'enableSorting'=>false,
                            'template' => "{items}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                 array(
                                    'header' => 'No',
                                    'value' => '$row+1'
                                            ),
                                            array(
                                                    'header' => 'Tgl Faktur/<br/>No Faktur',
                                                    'type' => 'raw',
                                                    'value'=>function($data) {
                                        return MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglfaktur))).'/<br/>'.$data->nofaktur;
                                        }
                            ),
                            array(
                                    'header'=>'Tanggal Terima',
                                    'type'=>'raw',
                                    'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
                                'footer'=>'Total :',
            'footerHtmlOptions'=>array('colspan'=>16,'style'=>'text-align:right;'),
                            ),
                            array(
                                    'header' => 'No Penerimaan',
                                    'type' => 'raw',
                                    'value' => '$data->noterima',
                            ),
                            array(
                                    'header' => 'No Permintaan',
                                    'type' => 'raw',
                                    'value' => '$data->nopermintaan',
                            ),
                            array(
                                    'header' => 'Tgl Jatuh Tempo',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
                            ),	
                            array(
                                    'header' => 'Umur Hutang',
                                    'type' => 'raw',
                                    'value' => '$data->umurHutang',
                            ),
                            array(
                                    'header' => 'Syarat Bayar',
                                    'type' => 'raw',
                                    'value' => '$data->syaratbayar_nama',
                            ),
                            array(
                                    'header' => 'Keterangan',
                                    'type' => 'raw',
                                    'value' => '$data->keteranganfaktur',
                            ),
                            array(
                                    'name' => 'supplier_id',
                                    'type' => 'raw',
                                    'value' => '$data->supplier_nama',
                            ),																											
                            array(
                                'header' => 'Total Harga',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->totharganetto,2,",",".")',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                    'header' => 'Total Keringanan',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->jmldiscount,2,",",".")',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                    'header' => 'Total PPN',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->totalpajakppn,2,",",".")',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                    'header' => 'Total PPh',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->totalpajakpph,2,",",".")',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                    'header' => 'Total Keseluruhan',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->totalhargabruto,2,",",".")',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                    'header' => 'Jumlah Uang Muka',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->jmluangmukabeli,2,",",".")',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                    'header' => 'Total Harga Netto',
                                    'type' => 'raw',
                                    'value' => 'number_format($data->totalhutangusaha,2,",",".")',
                                    'htmlOptions'=>array('style'=>'text-align: right'),
                                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                                'footer'=>number_format($totalharganetto,2,",","."),
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
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
    </div>
    <div class="content">
        <br>
        <div class="judulcontent"> <?php echo $judulLaporan ?> <br> <?php echo $periode ?></div>
        <br>
        <?php $ruanganAsal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'))->ruangan_nama; ?>
        <div style="text-align: center;">
            <!--<h2><?php //echo $judulLaporan;                 ?></h2>-->
           <!-- <b>Periode : <?php //echo $periode;                 ?></b><br>-->
            <b>Ruangan : <?php echo $ruanganAsal; ?></b>
        </div>
        <?php
        $totalharganetto = 0;
                                                        
        $prov = $model->searchPrint();
        $cloneProv = clone $prov;

        foreach ($cloneProv->data as $dataClone){
            $totalharganetto += $dataClone->totalhutangusaha;
        }
        $this->widget('ext.bootstrap.widgets.HeaderGroupGridViewNonRp', array(
            'id' => 'fakturpembelian-m-grid',
            'dataProvider' => $model->searchPrint(),
            'template' => "{items}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
               array(
                'header' => 'No',
                'value' => '$row+1'
                        ),
                        array(
                                'header' => 'Tgl Faktur/<br/>No Faktur',
                                'type' => 'raw',
                                'value'=>function($data) {
                    return MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglfaktur))).'/<br/>'.$data->nofaktur;
                    },
            'footer'=>'Total :',
            'footerHtmlOptions'=>array('colspan'=>16,'style'=>'text-align:right;'),
        ),
        array(
                'header'=>'Tanggal Terima',
                'type'=>'raw',
                'value'=>'MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($data->tglterima)))',
        ),
        array(
                'header' => 'No Penerimaan',
                'type' => 'raw',
                'value' => '$data->noterima',
        ),
        array(
                'header' => 'No Permintaan',
                'type' => 'raw',
                'value' => '$data->nopermintaan',
        ),
        array(
                'header' => 'Tgl Jatuh Tempo',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo)))',
        ),	
        array(
                'header' => 'Umur Hutang',
                'type' => 'raw',
                'value' => '$data->umurHutang',
        ),
        array(
                'header' => 'Syarat Bayar',
                'type' => 'raw',
                'value' => '$data->syaratbayar_nama',
        ),
       array(
                'header' => 'Keterangan',
                'type' => 'raw',
                'value' => '$data->keteranganfaktur',
        ),
        array(
                'header' => 'Supplier',
                'type' => 'raw',
                'value' => '$data->supplier_nama',
        ),																											
        array(
            'header' => 'Total Harga',
                'type' => 'raw',
                'value' => 'number_format($data->totharganetto,2,",",".")',
                'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
                'header' => 'Total Keringanan',
                'type' => 'raw',
                'value' => 'number_format($data->jmldiscount,2,",",".")',
                'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
                'header' => 'Total PPN',
                'type' => 'raw',
                'value' => 'number_format($data->totalpajakppn,2,",",".")',
                'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
                'header' => 'Total PPh',
                'type' => 'raw',
                'value' => 'number_format($data->totalpajakpph,2,",",".")',
                'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
                'header' => 'Total Keseluruhan',
                'type' => 'raw',
                'value' => 'number_format($data->totalhargabruto,2,",",".")',
                'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
                'header' => 'Jumlah Uang Muka',
                'type' => 'raw',
                'value' => 'number_format($data->jmluangmukabeli,2,",",".")',
                'htmlOptions'=>array('style'=>'text-align: right'),
        ),
        array(
                        'header' => 'Total Harga Netto',
                        'type' => 'raw',
                        'value' => 'number_format($data->totalhutangusaha,2,",",".")',
                        'htmlOptions'=>array('style'=>'text-align: right'),
                    'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                    'footer'=>number_format($totalharganetto,2,",","."),
                ),
            ),
        ));
        ?>

    </div>

    <?php
}
?>
