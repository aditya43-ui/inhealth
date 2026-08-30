
<?php

if (isset($caraPrint)) {
    if ($caraPrint == 'EXCEL') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
        header('Cache-Control: max-age=0');
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
//        font-size:8pt;
    }
    body{
//        font-size:8pt;
    }
    td .uang{
        text-align:right;
    }
    
    .table{
        box-shadow:none;
        border: 1px solid black;
        border-radius: 0px;
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
//     width:20cm;
//     height:12cm;
    }
');

    //echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan'=>$judulLaporan));
    
}

$grid_view = 'ext.bootstrap.widgets.BootGridView';

if (!empty($caraPrint)) {
    if ($caraPrint == 'PDF') {
        $grid_view = 'ext.bootstrap.widgets.BootGridViewPDF';
    } else if ($caraPrint == 'EXCEL') {
        $grid_view = 'ext.bootstrap.widgets.BootExcelGridView';
    }
}

$prov = $model->searchInformasi();
$prov->pagination = false;
$prov->sort = false;

?>

<?php
if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'CSV') {
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
  <?php                      
$this->widget($grid_view, array(
    'id' => 'gupembelianbarang-t-grid',
    'dataProvider' => $prov,
    //	'filter'=>$model,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        //		////'pembelianbarang_id',
        //		array(
        //                        'name'=>'pembelianbarang_id',
        //                        'value'=>'$data->pembelianbarang_id',
        //                        'filter'=>false,
        //                ), 


        array(
            'header' => 'No Permintaan',
            'value' => '$data->nopembelian',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        //		'terimapersediaan_id',                    
        array(
            'header' => 'Sumber Dana',
            'value' => '$data->sumberdana->sumberdana_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier->supplier_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Tanggal Pembelian',
            'value' => '!empty($data->tglpembelian)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tglpembelian)))):"-"',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Tanggal Dikirim',
            'value' => '!empty($data->tgldikirim)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tgldikirim)))):"-"',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
                'header' => 'Tgl. Permintaan Uang Muka Pembelian',
                'value' => '!empty($data->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tglpermintaanuangmuka)))):"-"',
                'headerHtmlOptions' => array('style' => 'text-align:center;')
        ), 
        array(
                'header' => 'Jumlah Permintaan Uang Muka Pembelian',
                'value' => '"Rp. ".(!empty($data->jmlpermintaanuangmuka)?MyFormatter::formatNumberForPrint($data->jmlpermintaanuangmuka,2):"-")',
                'headerHtmlOptions' => array('style' => 'text-align:center;')
        ), 
        array(
            'header' => 'Pegawai Pemesan',
            'value' => 'empty($data->pemesan)?"-":$data->pemesan->nama_pegawai',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'type' => 'raw',
            'value' => '(isset($data->peg_mengetahui_id)? $data->mengetahui->nama_pegawai : "-")',
        ),
        array(
            'header' => 'Pegawai Menyetujui',
            'type' => 'raw',
            'value' => '(isset($data->peg_menyetujui_id)? $data->menyetujui->nama_pegawai : "-")',
        ),
//									array(
//										'header' => 'Pegawai Mengetahui',
//										'value' => '(!empty($data->peg_mengetahui_id)?$data->mengetahui->nama_pegawai:"-").
//                                                                                    (isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmengetahui) : 
//                                                                                    (!isset($data->peg_mengetahui_id)? "" :
//                                                                                    (!isset($data->tglmenyetujui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui", array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk approvement mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
//                                                                                    ))',
//										'headerHtmlOptions' => array('style' => 'text-align:center;')
//									),                    
//									array(
//										'header' => 'Pegawai Menyetujui',
//										'value' => '(!empty($data->peg_menyetujui_id)?$data->menyetujui->nama_pegawai:"-").
//                                                                                    (isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmenyetujui) : 
//                                                                                    (!isset($data->peg_menyetujui_id) && !isset($data->peg_mengetahui_id)? "<a rel=\'tooltip\' title=\'Tombol akan aktif jika data memiliki nama mengetahui dan menyetujui\'><icon class=\'icon-form-check\' style=\'opacity: 0.3\'></icon></a> " :
//                                                                                      CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui", array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk approvement menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');"))
//                                                                                    ))',
//										'headerHtmlOptions' => array('style' => 'text-align:center;')
//									),              
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
        <?php
        
        
$this->widget($grid_view, array(
    'id' => 'gupembelianbarang-t-grid',
    'dataProvider' => $prov,
    //	'filter'=>$model,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        //		////'pembelianbarang_id',
        //		array(
        //                        'name'=>'pembelianbarang_id',
        //                        'value'=>'$data->pembelianbarang_id',
        //                        'filter'=>false,
        //                ), 


        array(
            'header' => 'No Permintaan',
            'value' => '$data->nopembelian',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        //		'terimapersediaan_id',                    
        array(
            'header' => 'Sumber Dana',
            'value' => '$data->sumberdana->sumberdana_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier->supplier_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Tanggal Pembelian',
            'value' => '!empty($data->tglpembelian)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tglpembelian)))):"-"',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Tanggal Dikirim',
            'value' => '!empty($data->tgldikirim)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tgldikirim)))):"-"',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
                'header' => 'Tgl. Permintaan Uang Muka Pembelian',
                'value' => '!empty($data->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tglpermintaanuangmuka)))):"-"',
                'headerHtmlOptions' => array('style' => 'text-align:center;')
        ), 
        array(
                'header' => 'Jumlah Permintaan Uang Muka Pembelian',
                'value' => '"Rp. ".(!empty($data->jmlpermintaanuangmuka)?MyFormatter::formatNumberForPrint($data->jmlpermintaanuangmuka,2):"-")',
                'headerHtmlOptions' => array('style' => 'text-align:center;')
        ), 
        array(
            'header' => 'Pegawai Pemesan',
            'value' => 'empty($data->pemesan)?"-":$data->pemesan->nama_pegawai',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'type' => 'raw',
            'value' => '(isset($data->peg_mengetahui_id)? $data->mengetahui->nama_pegawai : "-")',
        ),
        array(
            'header' => 'Pegawai Menyetujui',
            'type' => 'raw',
            'value' => '(isset($data->peg_menyetujui_id)? $data->menyetujui->nama_pegawai : "-")',
        ),
//									array(
//										'header' => 'Pegawai Mengetahui',
//										'value' => '(!empty($data->peg_mengetahui_id)?$data->mengetahui->nama_pegawai:"-").
//                                                                                    (isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmengetahui) : 
//                                                                                    (!isset($data->peg_mengetahui_id)? "" :
//                                                                                    (!isset($data->tglmenyetujui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui", array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk approvement mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
//                                                                                    ))',
//										'headerHtmlOptions' => array('style' => 'text-align:center;')
//									),                    
//									array(
//										'header' => 'Pegawai Menyetujui',
//										'value' => '(!empty($data->peg_menyetujui_id)?$data->menyetujui->nama_pegawai:"-").
//                                                                                    (isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmenyetujui) : 
//                                                                                    (!isset($data->peg_menyetujui_id) && !isset($data->peg_mengetahui_id)? "<a rel=\'tooltip\' title=\'Tombol akan aktif jika data memiliki nama mengetahui dan menyetujui\'><icon class=\'icon-form-check\' style=\'opacity: 0.3\'></icon></a> " :
//                                                                                      CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui", array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk approvement menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');"))
//                                                                                    ))',
//										'headerHtmlOptions' => array('style' => 'text-align:center;')
//									),              
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
        
        ?>
    </div>

    <?php
}
if ($caraPrint == 'CSV') {


$this->widget($grid_view, array(
    'id' => 'gupembelianbarang-t-grid',
    'dataProvider' => $prov,
    //	'filter'=>$model,
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-condensed',
    'columns' => array(
        //		////'pembelianbarang_id',
        //		array(
        //                        'name'=>'pembelianbarang_id',
        //                        'value'=>'$data->pembelianbarang_id',
        //                        'filter'=>false,
        //                ), 


        array(
            'header' => 'No Permintaan',
            'value' => '$data->nopembelian',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        //		'terimapersediaan_id',                    
        array(
            'header' => 'Sumber Dana',
            'value' => '$data->sumberdana->sumberdana_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier->supplier_nama',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Tanggal Pembelian',
            'value' => '!empty($data->tglpembelian)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tglpembelian)))):"-"',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Tanggal Dikirim',
            'value' => '!empty($data->tgldikirim)?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime(MyFormatter::formatDateTimeForDb($data->tgldikirim)))):"-"',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Pegawai Pemesan',
            'value' => 'empty($data->pemesan)?"-":$data->pemesan->nama_pegawai',
            'headerHtmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => 'Pegawai Mengetahui',
            'type' => 'raw',
            'value' => '(isset($data->peg_mengetahui_id)? $data->mengetahui->nama_pegawai : "-")',
        ),
        array(
            'header' => 'Pegawai Menyetujui',
            'type' => 'raw',
            'value' => '(isset($data->peg_menyetujui_id)? $data->menyetujui->nama_pegawai : "-")',
        ),
//									array(
//										'header' => 'Pegawai Mengetahui',
//										'value' => '(!empty($data->peg_mengetahui_id)?$data->mengetahui->nama_pegawai:"-").
//                                                                                    (isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmengetahui) : 
//                                                                                    (!isset($data->peg_mengetahui_id)? "" :
//                                                                                    (!isset($data->tglmenyetujui) ? "" : CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui", array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk approvement mengetahui", "onclick"=>"$(\'#dialogMengetahui\').dialog(\'open\');")))
//                                                                                    ))',
//										'headerHtmlOptions' => array('style' => 'text-align:center;')
//									),                    
//									array(
//										'header' => 'Pegawai Menyetujui',
//										'value' => '(!empty($data->peg_menyetujui_id)?$data->menyetujui->nama_pegawai:"-").
//                                                                                    (isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeId($data->tglmenyetujui) : 
//                                                                                    (!isset($data->peg_menyetujui_id) && !isset($data->peg_mengetahui_id)? "<a rel=\'tooltip\' title=\'Tombol akan aktif jika data memiliki nama mengetahui dan menyetujui\'><icon class=\'icon-form-check\' style=\'opacity: 0.3\'></icon></a> " :
//                                                                                      CHtml::link("<icon class=\'icon-form-check\'></icon> ", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui", array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk approvement menyetujui", "onclick"=>"$(\'#dialogMenyetujui\').dialog(\'open\');"))
//                                                                                    ))',
//										'headerHtmlOptions' => array('style' => 'text-align:center;')
//									),              
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
    
}
?>

