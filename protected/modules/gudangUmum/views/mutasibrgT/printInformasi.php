
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

$prov = $model->searchInformasi();
$prov->pagination = false;
$prov->sort = false;

if ($caraPrint != 'GRAFIK' && $caraPrint != 'PDF' && $caraPrint != 'CSV') {
    ?>

    <table style="width: 100%; border: none;">
        <thead>
            <tr>
                <td>
                    <div class="header"><?php
                        if($caraPrint != 'EXCEL'){
                           echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); 
                        }else{
                            
                          echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 9));
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
                        
$this->widget($grid_view,array(
	'id'=>'gumutasibrg-t-grid',
	'dataProvider'=>$prov,
	'template'=>"{items}",
	'itemsCssClass'=>'table table-bordered datatable',
	'columns'=>array(
        array(
            'header'=>'No. Mutasi Barang',
            'type'=>'raw',
            'value'=>function($data) {
                return $data->nomutasibrg;
            }
        ),
		array(
			'name'=>'tglmutasibrg',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmutasibrg)',
		),
		array(
			'header'=>'Pengirim',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaipengirim)?$data->pegawaipengirim->nama_pegawai:"")',
		),
		array(
			'header'=>'Menyetujui',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaimenyetujui)?$data->pegawaimenyetujui->nama_pegawai:"")',
		),
		array(
			'header'=>'Mengetahui',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaimengetahui)?$data->pegawaimengetahui->nama_pegawai:"")',
		),
                array(
                        'name'=>'totalhargamutasi',
                        'value'=>'MyFormatter::formatNumberForPrint($data->totalhargamutasi)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;',
                        ),
                ),
        array(
            'header'=>'Ruangan Pengirim',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->create_ruangan)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->create_ruangan);
                
                return $ruangan->ruangan_nama;
            }
        ),
        array(
            'header'=>'Ruangan Tujuan',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->ruangantujuan_id)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->ruangantujuan_id);
                
                return $ruangan->ruangan_nama;
            }
        ),
		'keterangan_mutasi',
        array(
            'header'=>'No. Pemesanan',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->pesanbarang_id)) return "-";
                $pesan = PesanbarangT::model()->findByPk($data->pesanbarang_id);
                
                return $pesan->nopemesanan;
            }
        ),	
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
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
        <?php if (isset($caraPrint) && (($caraPrint != "PDF") || ($caraPrint != "EXCEL"))) { ?>
            <?php echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>
        <?php } ?>
    </div>   

    <?php
}
if ($caraPrint == 'PDF') {
    ?>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewest', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?>
    </div>
    <div class="content">
      
        <?php
        
$this->widget($grid_view,array(
	'id'=>'gumutasibrg-t-grid',
	'dataProvider'=>$prov,
	'template'=>"{items}",
	'itemsCssClass'=>'table table-bordered datatable',
	'columns'=>array(
        array(
            'header'=>'No. Mutasi Barang',
            'type'=>'raw',
            'value'=>function($data) {
                return $data->nomutasibrg;
            }
        ),
		array(
			'name'=>'tglmutasibrg',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmutasibrg)',
		),
		array(
			'header'=>'Pengirim',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaipengirim)?$data->pegawaipengirim->nama_pegawai:"")',
		),
		array(
			'header'=>'Menyetujui',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaimenyetujui)?$data->pegawaimenyetujui->nama_pegawai:"")',
		),
		array(
			'header'=>'Mengetahui',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaimengetahui)?$data->pegawaimengetahui->nama_pegawai:"")',
		),
                array(
                        'name'=>'totalhargamutasi',
                        'value'=>'MyFormatter::formatNumberForPrint($data->totalhargamutasi)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;',
                        ),
                ),
        array(
            'header'=>'Ruangan Pengirim',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->create_ruangan)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->create_ruangan);
                
                return $ruangan->ruangan_nama;
            }
        ),
        array(
            'header'=>'Ruangan Tujuan',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->ruangantujuan_id)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->ruangantujuan_id);
                
                return $ruangan->ruangan_nama;
            }
        ),
		'keterangan_mutasi',
        array(
            'header'=>'No. Pemesanan',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->pesanbarang_id)) return "-";
                $pesan = PesanbarangT::model()->findByPk($data->pesanbarang_id);
                
                return $pesan->nopemesanan;
                // echo $pesan->nopemesanan;
            }
        ),	
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        ?>
    </div>

    <?php
}
if ($caraPrint == 'CSV') {

$this->widget($grid_view,array(
	'id'=>'gumutasibrg-t-grid',
	'dataProvider'=>$prov,
	'template'=>"{items}",
	'itemsCssClass'=>'table table-bordered datatable',
	'columns'=>array(
        array(
            'name'=>'nomutasibrg',
            'type'=>'raw',
            'value'=>function($data) {
                return CHtml::link('<u>'.$data->nomutasibrg.'</u>',  
                    Yii::app()->controller->createUrl("detailMutasiBarang",array("id"=>$data->mutasibrg_id)),array(
                        "id"=>"$data->mutasibrg_id",
                        "target"=>"frameDetail",
                        "rel"=>"tooltip",
                        "title"=>"Klik untuk Detail Mutasi Barang", 
                        "onclick"=>'window.parent.$("#dialogDetail").dialog("open");'
                    ));
            }
        ),
		array(
			'name'=>'tglmutasibrg',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tglmutasibrg)',
		),
		array(
			'header'=>'Pengirim',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaipengirim)?$data->pegawaipengirim->nama_pegawai:"")',
		),
		array(
			'header'=>'Menyetujui',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaimenyetujui)?$data->pegawaimenyetujui->nama_pegawai:"")',
		),
		array(
			'header'=>'Mengetahui',
			'type'=>'raw',
			'value'=>'(isset($data->pegawaimengetahui)?$data->pegawaimengetahui->nama_pegawai:"")',
		),
                array(
                        'name'=>'totalhargamutasi',
                        'value'=>'MyFormatter::formatNumberForPrint($data->totalhargamutasi)',
                        'htmlOptions'=>array(
                            'style'=>'text-align: right;',
                        ),
                ),
        array(
            'header'=>'Ruangan Pengirim',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->create_ruangan)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->create_ruangan);
                
                return $ruangan->ruangan_nama;
            }
        ),
        array(
            'header'=>'Ruangan Tujuan',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->ruangantujuan_id)) return "-";
                $ruangan = RuanganM::model()->findByPk($data->ruangantujuan_id);
                
                return $ruangan->ruangan_nama;
            }
        ),
		'keterangan_mutasi',
        array(
            'name'=>'No. Pemesanan',
            'type'=>'raw',
            'value'=>function($data) {
                if (empty($data->pesanbarang_id)) return "-";
                $pesan = PesanbarangT::model()->findByPk($data->pesanbarang_id);
                
                return $pesan->nopemesanan;
            }
        ),	
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
    
}
?>
