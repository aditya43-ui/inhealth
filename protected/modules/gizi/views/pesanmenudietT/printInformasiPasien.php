<?php
if ($caraPrint == 'EXCEL') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $judulLaporan . '-' . date("Y/m/d") . '.xls"');
    header('Cache-Control: max-age=0');
    echo $this->renderPartial('application.views.headerReport.headerDefaultNewExcel', array('judulLaporan' => $judulLaporan, 'periode' => $periode, 'colspan' => 14));
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
<?php  $grid_view = 'ext.bootstrap.widgets.BootGridView';

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
//				'name'=>'tglpesanmenu',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
			),
                        array(
                            'header' => 'No. Pesan',
                            'type'=>'raw',
                            'value'=>'$data->nopesanmenu'
//                            'name' => 'nopesanmenu',                            
                        ),
                    );
                 if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
			array_push($artab, array(
				'header'=>'Instalasi / Ruangan',
				'type'=>'raw',
				'value'=>'$data->ruangan->instalasi->instalasi_nama." / ".$data->ruangan->ruangan_nama',
				'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:left;')
			));
                    }
                        array_push($artab, array(
                            'header' => 'No. Rekam Medik / No. Pendaftaran',
//                            'name' => 'jenispesanmenu',    
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik . " / " . $data->no_pendaftaran'
                        ),
                                array(
                            'header' => 'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien'
                        ),
                                 array(
                            'header' => 'Nama Pemesan',
                            'type'=>'raw',
                            'value'=>'$data->nama_pemesan'
//                            'name' => 'nopesanmenu',                            
                        ),
//			'nama_pemesan',
                        array(
                            'header' => 'Jenis Diet',
                            'type'=>'raw',
                            'value'=>'isset($data->jenisdiet_id)?$data->jenisdiet->jenisdiet_nama:""'
//                            'name' => 'jenisdiet.jenisdiet_nama',
                        ),
                        array(
                            'header' => 'Bahan Diet',
                            'type'=>'raw',
//                            'value'=>'$data->jenisdiet_nama'
                             'value'=>'isset($data->bahandiet_id)?$data->bahandiet->bahandiet_nama:""'
//                            'name' => 'bahandiet.bahandiet_nama',
                        )			
//			'adaalergimakanan',
//			'keterangan_pesan',
//			array(
//				'header'=>'Rincian',
//				'type'=>'raw',
//				'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/PesanmenudietT/detailPesanMenuDiet",array("id"=>$data->pesanmenudiet_id)),array("id"=>"$data->pesanmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pemesanan menu diet pasien", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));','htmlOptions'=>array('style'=>'text-align: left')
//			)
                        );
               
		 foreach (JeniswaktuM::getJenisWaktu() as $row) {
                    
                    array_push($artab, array(
                            'header' => $row->jeniswaktu_nama,
                             'type'=>'raw',
                            'value'=>'$data->getMenuDiet($data->pesanmenudiet_id, $data->pendaftaran_id, '.$row->jeniswaktu_id.', "'.Params::JENISPESANMENU_PASIEN.'")'
                        ));
//                
            }
            array_push($artab, array(
                            'header' =>"Jumlah",
                             'type'=>'raw',
                            'value'=>'$data->getJumlahPorsiSatuan($data->pesanmenudiet_id, $data->pendaftaran_id, "jumlah", "'.Params::JENISPESANMENU_PASIEN.'")'
                        ),array(
                            'header' => "Satuan",
                             'type'=>'raw',
                            'value'=>'$data->getJumlahPorsiSatuan($data->pesanmenudiet_id, $data->pendaftaran_id, "satuan", "'.Params::JENISPESANMENU_PASIEN.'")'
                        ));
            
//            array_push($artab, array(
//                            'header'=>'Etiket',
//				'type'=>'raw',
//                            'value'=>function($data){
//                                 return CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl('/gizi/PesanmenudietT/PrintGizi', array(
//														'pesanmenudiet_id'=>$data->pesanmenudiet_id, 'caraPrint'=>'dialog'
//													)), array(
//														'target'=>'iframeDetailPenjualan',
//														'rel'=>'tooltip',
//														'title'=>'Klik untuk print etiket',
//														'onclick'=>'$("#dialogDetailPenjualan").dialog("open")'
//                            									)); 
//                            }
//                        ));
//		if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
//			array_push($artab, array(
//				'header'=>'Kirim Menu Diet',
//				'type'=>'raw',
//				//'value'=>'(($data->jenispesanmenu == "'.Params::JENISPESANMENU_PASIEN.'") ? CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")) : CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")))','htmlOptions'=>array('style'=>'text-align: left')
//                                'value'=> function ($data){
//                                if (empty($data->kirimmenudiet_id)){
////                                    if ($data->jenispesanmenu == Params::JENISPESANMENU_PASIEN){
//                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
////                                    }else{
////                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
////                                    }                                    
//                                }else{
//                                    if ($data->status_terima == TRUE){
//                                        echo "Sudah Dikirim";
//                                    }else{
//                                        echo "Sedang Dikirim";
//                                    }
//                                }                            
//                        }
//                        ));
//                
//            
//		}
		
//		array_push($artab, array(
//			'header'=>'Batal <br> Pesan',
//			'type'=>'raw',
//			//'value'=>'CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Batal Pesan Menu Diet","onclick"=>"batalPesan(\'$data->pesanmenudiet_id\'); return false;"))',
//                        'value'=> function ($data){
//                            if (empty($data->kirimmenudiet_id)){
//                                echo CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Batal Pesan Menu Diet","onclick"=>"batalPesan('".$data->pesanmenudiet_id."'); return false;"));
//                            }else{
//                                echo "Sudah Diproses";
//                            }                            
//                        }
//		));
                
                 array_push($artab, array(
                        'header'=>'Status Terima',
                        'type'=>'raw',
                        'value'=> function ($data){
                            if (empty($data->kirimmenudiet_id)){
                                echo "Pemesanan Belum Diproses";
                            }else{
                                if ($data->status_terima == TRUE){
                                    echo "Sudah Diterima";
                                }else{
//                                    if ($data->ruangan_id == Yii::app()->user->getState('ruangan_id')){
//                                        echo Chtml::link("<button class='btn btn-danger'><i class='entypo-check'></i> Konfirmasi</button>", '#', array("onclick"=>"terimaKonfirmasi('".$data->pesanmenudiet_id."')"));
//                                    }else{
                                        echo "Belum Diterima";
//                                    }
                                }
                            }
                        }
                    ));
		
		$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'gzpesanmenudietpasien-v-grid',
            'dataProvider'=>$model->searchInformasiMenuPasienPrint(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
                    'mergeHeaders'=>array(
                    array(
                        'name'=>'<p style="margin: 0; text-align: center;">Menu Diet</p>',
                        'start'=>7, //indeks kolom 3
                        'end'=>11, //indeks kolom 4
                    ),
              ),
            'columns'=>$artab,
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
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
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => $periode)); ?>
    </div>
    <div class="content">
<?php  $grid_view = 'ext.bootstrap.widgets.BootGridView';

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
//				'name'=>'tglpesanmenu',
				'type'=>'raw',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglpesanmenu)'
			),
                        array(
                            'header' => 'No. Pesan',
                            'type'=>'raw',
                            'value'=>'$data->nopesanmenu'
//                            'name' => 'nopesanmenu',                            
                        ),
                    );
                 if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
			array_push($artab, array(
				'header'=>'Instalasi / Ruangan',
				'type'=>'raw',
				'value'=>'$data->ruangan->instalasi->instalasi_nama." / ".$data->ruangan->ruangan_nama',
				'headerHtmlOptions'=>array('style'=>'vertical-align: middle;text-align:left;')
			));
                    }
                        array_push($artab, array(
                            'header' => 'No. Rekam Medik / No. Pendaftaran',
//                            'name' => 'jenispesanmenu',    
                            'type'=>'raw',
                            'value'=>'$data->no_rekam_medik . " / " . $data->no_pendaftaran'
                        ),
                                array(
                            'header' => 'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->nama_pasien'
                        ),
                                 array(
                            'header' => 'Nama Pemesan',
                            'type'=>'raw',
                            'value'=>'$data->nama_pemesan'
//                            'name' => 'nopesanmenu',                            
                        ),
//			'nama_pemesan',
                        array(
                            'header' => 'Jenis Diet',
                            'type'=>'raw',
                            'value'=>'isset($data->jenisdiet_id)?$data->jenisdiet->jenisdiet_nama:""'
//                            'name' => 'jenisdiet.jenisdiet_nama',
                        ),
                        array(
                            'header' => 'Bahan Diet',
                            'type'=>'raw',
//                            'value'=>'$data->jenisdiet_nama'
                             'value'=>'isset($data->bahandiet_id)?$data->bahandiet->bahandiet_nama:""'
//                            'name' => 'bahandiet.bahandiet_nama',
                        )			
//			'adaalergimakanan',
//			'keterangan_pesan',
//			array(
//				'header'=>'Rincian',
//				'type'=>'raw',
//				'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gizi/PesanmenudietT/detailPesanMenuDiet",array("id"=>$data->pesanmenudiet_id)),array("id"=>"$data->pesanmenudiet_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk rincian pemesanan menu diet pasien", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));','htmlOptions'=>array('style'=>'text-align: left')
//			)
                        );
               
		 foreach (JeniswaktuM::getJenisWaktu() as $row) {
                    
                    array_push($artab, array(
                            'header' => $row->jeniswaktu_nama,
                             'type'=>'raw',
                            'value'=>'$data->getMenuDiet($data->pesanmenudiet_id, $data->pendaftaran_id, '.$row->jeniswaktu_id.', "'.Params::JENISPESANMENU_PASIEN.'")'
                        ));
//                
            }
            array_push($artab, array(
                            'header' =>"Jumlah",
                             'type'=>'raw',
                            'value'=>'$data->getJumlahPorsiSatuan($data->pesanmenudiet_id, $data->pendaftaran_id, "jumlah", "'.Params::JENISPESANMENU_PASIEN.'")'
                        ),array(
                            'header' => "Satuan",
                             'type'=>'raw',
                            'value'=>'$data->getJumlahPorsiSatuan($data->pesanmenudiet_id, $data->pendaftaran_id, "satuan", "'.Params::JENISPESANMENU_PASIEN.'")'
                        ));
            
//            array_push($artab, array(
//                            'header'=>'Etiket',
//				'type'=>'raw',
//                            'value'=>function($data){
//                                 return CHtml::link("<i class='icon-form-detail'></i>", Yii::app()->createUrl('/gizi/PesanmenudietT/PrintGizi', array(
//														'pesanmenudiet_id'=>$data->pesanmenudiet_id, 'caraPrint'=>'dialog'
//													)), array(
//														'target'=>'iframeDetailPenjualan',
//														'rel'=>'tooltip',
//														'title'=>'Klik untuk print etiket',
//														'onclick'=>'$("#dialogDetailPenjualan").dialog("open")'
//                            									)); 
//                            }
//                        ));
//		if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
//			array_push($artab, array(
//				'header'=>'Kirim Menu Diet',
//				'type'=>'raw',
//				//'value'=>'(($data->jenispesanmenu == "'.Params::JENISPESANMENU_PASIEN.'") ? CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")) : CHtml::link(\'<i class="icon-form-kmenudiet"></i>\', Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman")))','htmlOptions'=>array('style'=>'text-align: left')
//                                'value'=> function ($data){
//                                if (empty($data->kirimmenudiet_id)){
////                                    if ($data->jenispesanmenu == Params::JENISPESANMENU_PASIEN){
//                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/index",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
////                                    }else{
////                                        echo CHtml::link("<i class='icon-form-kmenudiet'></i>", Yii::app()->controller->createUrl("/gizi/KirimmenudietT/indexPegawai",array("idPesan"=>$data->pesanmenudiet_id)),array("rel"=>"tooltip","title"=>"Klik untuk Melanjutkan ke Pengiriman"));
////                                    }                                    
//                                }else{
//                                    if ($data->status_terima == TRUE){
//                                        echo "Sudah Dikirim";
//                                    }else{
//                                        echo "Sedang Dikirim";
//                                    }
//                                }                            
//                        }
//                        ));
//                
//            
//		}
		
//		array_push($artab, array(
//			'header'=>'Batal <br> Pesan',
//			'type'=>'raw',
//			//'value'=>'CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Batal Pesan Menu Diet","onclick"=>"batalPesan(\'$data->pesanmenudiet_id\'); return false;"))',
//                        'value'=> function ($data){
//                            if (empty($data->kirimmenudiet_id)){
//                                echo CHtml::link("<i class=icon-form-silang></i>","#",array("idPesanDiet"=>$data->pesanmenudiet_id,"href"=>"#","rel"=>"tooltip","title"=>"Klik untuk Batal Pesan Menu Diet","onclick"=>"batalPesan('".$data->pesanmenudiet_id."'); return false;"));
//                            }else{
//                                echo "Sudah Diproses";
//                            }                            
//                        }
//		));
                
                 array_push($artab, array(
                        'header'=>'Status Terima',
                        'type'=>'raw',
                        'value'=> function ($data){
                            if (empty($data->kirimmenudiet_id)){
                                echo "Pemesanan Belum Diproses";
                            }else{
                                if ($data->status_terima == TRUE){
                                    echo "Sudah Diterima";
                                }else{
//                                    if ($data->ruangan_id == Yii::app()->user->getState('ruangan_id')){
//                                        echo Chtml::link("<button class='btn btn-danger'><i class='entypo-check'></i> Konfirmasi</button>", '#', array("onclick"=>"terimaKonfirmasi('".$data->pesanmenudiet_id."')"));
//                                    }else{
                                        echo "Belum Diterima";
//                                    }
                                }
                            }
                        }
                    ));
		
		$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
            'id'=>'gzpesanmenudietpasien-v-grid',
            'dataProvider'=>$model->searchInformasiMenuPasienPrint(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table border',
                    'mergeHeaders'=>array(
                    array(
                        'name'=>'<p style="margin: 0; text-align: center;">Menu Diet</p>',
                        'start'=>7, //indeks kolom 3
                        'end'=>11, //indeks kolom 4
                    ),
              ),
            'columns'=>$artab,
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
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
        <?php if (isset($caraPrint) && $caraPrint != "PDF") {
           echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); 
            ?>
         
        <?php } ?>
    </div>

    <?php
}
?>