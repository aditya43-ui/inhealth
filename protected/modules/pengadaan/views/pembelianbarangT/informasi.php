
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Pembelian Barang</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel Permintaan <strong>Pembelian Barang</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php
							$this->breadcrumbs=array(
								'Informasi Permintaan Pembelian Barang',
							);
							//
							//$arrMenu = array();
							//                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' GUPembelianbarangT ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
							//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUPembelianbarangT', 'icon'=>'list', 'url'=>array('index'))) ;
							//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' GUPembelianbarangT', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
							//
							//$this->menu=$arrMenu;

							Yii::app()->clientScript->registerScript('search', "
							$('.search-button').click(function(){
									$('.search-form').toggle();
									return false;
							});
							$('.search-form form').submit(function(){
									$.fn.yiiGridView.update('gupembelianbarang-t-grid', {
											data: $(this).serialize()
									});
									return false;
							});
							");

							$this->widget('bootstrap.widgets.BootAlert'); ?>
							<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
								'id'=>'gupembelianbarang-t-grid',
								'dataProvider'=>$model->searchInformasi(),
						//	'filter'=>$model,
								'template'=>"{summary}\n{items}\n{pager}",
								'itemsCssClass'=>'table table-bordered table-striped table-condensed',
								'columns'=>array(
						//		////'pembelianbarang_id',
						//		array(
						//                        'name'=>'pembelianbarang_id',
						//                        'value'=>'$data->pembelianbarang_id',
						//                        'filter'=>false,
						//                ),

                                                                    array(
										'header' => 'Tanggal Permintaan',
										'value' => '!empty($data->tglpembelian)?MyFormatter::formatDateTimeForUser($data->tglpembelian):"-"',
										'headerHtmlOptions' => array('style' => 'text-align:center;')
									),
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
										'header' => 'Tanggal Dikirim',
										'value' => '!empty($data->tgldikirim)?MyFormatter::formatDateTimeForUser($data->tgldikirim):"-"',
										'headerHtmlOptions' => array('style' => 'text-align:center;')
									),
                                                                        array(
										'header' => 'Tgl. Permintaan Uang Muka Pembelian',
										'value' => '!empty($data->tglpermintaanuangmuka)?MyFormatter::formatDateTimeForUser($data->tglpermintaanuangmuka):"-"',
										'headerHtmlOptions' => array('style' => 'text-align:center;')
									),
                                                                        array(
										'header' => 'Jumlah Permintaan Uang Muka Pembelian',
										'value' => '"Rp. ".(!empty($data->jmlpermintaanuangmuka)?MyFormatter::formatNumberForPrint($data->jmlpermintaanuangmuka,2):"-")',
										'headerHtmlOptions' => array('style' => 'text-align:center;')
									),
                                                                        array(
										'header' => 'Jenis PPh',
										'value' => '(isset($data->pajak)?$data->pajak->pajak_nama:"-")',
										'headerHtmlOptions' => array('style' => 'text-align:center;')
									),
                                                                        array(
										'header'=>'Keterangan',
										'type'=>'raw',
										'value'=>'$data->keterangan',
									),
									array(
										'header' => 'Pegawai Pemesan',
										'value' => 'empty($data->pemesan)?"-":$data->pemesan->nama_pegawai',
										'headerHtmlOptions' => array('style' => 'text-align:center;')
									),
                                                                    array(
								'header'=>'Manajer Umum Mengetahui',
								'type'=>'raw',
                                                                        'value' => function($data){
                                                                            $dataDialog = 'myAlert("Hanya '.(isset($data->peg_mengetahui_umum_id)? $data->mengetahuiumum->namaLengkap : "-").' yang bisa mengakses");';
                                                                            if($data->peg_mengetahui_umum_id==Yii::app()->user->getState('pegawai_id')){
                                                                               $dataDialog = "$('#dialogMengetahuiUmum').dialog('open');";
                                                                            }
                                                                            $html = (isset($data->peg_mengetahui_umum_id)? $data->mengetahuiumum->namaLengkap : "-").(isset($data->tglmengetahui_umum) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmengetahui_umum) :(isset($data->peg_mengetahui_umum_id) ? CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/MengetahuiUmum', array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMengetahuiUmum","rel"=>"tooltip", "title"=>"Klik untuk Approve Manager Umum", "onclick"=>$dataDialog)) : ""));
                                                                                return $html;
                                                                                }
							),
                                                                array(
								'header'=>'Manajer Keuangan Mengetahui',
								'type'=>'raw',
                                                                        'value' => function($data){
                                                                            $dataDialog = 'myAlert("Hanya '.(isset($data->peg_mengetahui_id)? $data->mengetahui->namaLengkap : "-").' yang bisa mengakses");';
                                                                            if($data->peg_mengetahui_id==Yii::app()->user->getState('pegawai_id')){
                                                                               $dataDialog = "$('#dialogMengetahui').dialog('open');";
                                                                            }
                                                                            $html = (isset($data->peg_mengetahui_id)? $data->mengetahui->namaLengkap : "-").(isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmengetahui) : (!isset($data->peg_mengetahui_id)? "" : ((empty($data->tglmengetahui_umum)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui', array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik untuk Approve Manager Keuangan", "onclick"=>$dataDialog)))));
                                                                                return $html;
                                                                                }
							),
                                                                array(
								'header'=>'Direktur Menyetujui',
								'type'=>'raw',
                                                            'value' => function($data){
                                                                            $dataDialog = 'myAlert("Hanya '.(isset($data->peg_menyetujui_id)? $data->menyetujui->namaLengkap : "-").' yang bisa mengakses");';
                                                                if($data->peg_menyetujui_id==Yii::app()->user->getState('pegawai_id')){
                                                                   $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                                                }
                                                                $check = "";
                                                                if(!empty($data->tglmengetahui_umum) && !empty($data->tglmengetahui)){
                                                                    $check = "kosong";
                                                                }
                                                                $html = (isset($data->peg_menyetujui_id)? $data->menyetujui->namaLengkap : "-").(isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmenyetujui) : (!isset($data->peg_menyetujui_id)? "" : ((empty($check)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui', array("pembelianbarang_id"=>$data->pembelianbarang_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve Direktur", "onclick"=>$dataDialog)))));
                                                                    return $html;
                                                            }
							),
                                                                array(
                                        'header'=>'Ubah Permintaan',
                                        'type'=>'raw',
                                        'value'=>function($data) {
                                            $link_update = (!empty($data->tglmenyetujui))?
											'<a rel="tooltip" title="Tidak dapat diubah karena sudah disetujui oleh Direktur Menyetujui"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
											: (!empty($data->tglmengetahui)?
                                                    '<a rel="tooltip" title="Tidak dapat diubah karena sudah diketahui oleh Manager Keuangan"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
                                                                                        :
												(($data->peg_pemesanan_id == Yii::app()->user->getState('pegawai_id')) || ($data->peg_mengetahui_umum_id == Yii::app()->user->getState('pegawai_id'))?
													CHtml::link('<icon class=\'icon-form-ubah\'></icon> ', Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id.'/'.$this->path_permintaan.'/index', array("id"=>$data->pembelianbarang_id,"rencana_id"=>$data->renkebbarang_id,"ubah"=>true)), array("target"=>"BLANK","rel"=>"tooltip", "title"=>"Klik untuk mengubah Permintaan"))
												:
													"<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh ".($data->pemesan->namaLengkap ." atau ". $data->mengetahuiumum->namaLengkap)." '><icon class='icon-form-ubah' style='opacity: 0.3'></icon></a>"
												));
												if(!empty($data->batalpermintaanpembelian_id)){
													$link_update = "";
												}

                                            return $link_update;
                                        },
                                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
                                                array(
                                                            'header'=>'Rincian',
                                                            'type'=>'raw',
                                                            'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/PembelianbarangTGU/detailPembelianBarang",array("id"=>$data->pembelianbarang_id,"frame"=>true)),array("id"=>"$data->pembelianbarang_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pembelian Barang", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                                                            'headerHtmlOptions' => array('style' => 'text-align:center;')
                                                    ),
									array(
										'header'=>'Terima Barang',
										'type'=>'raw',
										'htmlOptions'=>array('style'=>'text-align:left;'),
                                                                            'value'=> function ($data){
																				
                                                                                    $modUangMukaBeli = UangmukabeliT::model()->findByAttributes(array('pembelianbarang_id'=>$data->pembelianbarang_id));
                                                                                    $checkuangmuka = true;
                                                                                    if(!empty($data->jmlpermintaanuangmuka)){
                                                                                        if(!isset($modUangMukaBeli)){
                                                                                            $checkuangmuka = false;
                                                                                        }
                                                                                    }
                                                                                return ((empty($data->terimapersediaan_id)) ? ((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_LOGISTIK) ? (empty($data->tglmenyetujui) ? "Belum diapprove" : (($checkuangmuka==true)?CHtml::link("<i class='icon-form-terimabrg'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/TerimapersediaanT/index",array("id"=>$data->pembelianbarang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Persediaan Barang")): "Permintaan ini belum dilakukan pembayaran uang muka")) : "Belum Diterima") : "Sudah Diterima");

										},
//										'value'=>'(empty($data->terimapersediaan_id)) ? ((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_LOGISTIK) ? (empty($data->tglmenyetujui) ? "Belum diapprove" : CHtml::link("<i class=\'icon-form-terimabrg\'></i> ",  Yii::app()->controller->createUrl("/gudangUmum/TerimapersediaanT/index",array("id"=>$data->pembelianbarang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Persediaan Barang"))) : "Belum Diterima") : "Sudah Diterima"',
										'headerHtmlOptions' => array('style' => 'text-align:center;')
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
									/*
										'create_time',
										'update_time',
										'create_loginpemakai_id',
										'update_loginpemakai_id',
										'create_ruangan',
										*/
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                if (!empty($data->terimapersediaan_id)) {
                                    return "Telah Diterima";
                                } else {
                                    if (empty($data->tglmengetahui) || empty($data->tglmengetahui_umum) || empty($data->tglmenyetujui)) {
                                        if ((Yii::app()->user->getState('pegawai_id') == $data->peg_pemesanan_id) || (Yii::app()->user->getState('pegawai_id') == $data->peg_mengetahui_umum_id) || (Yii::app()->user->getState('pegawai_id') == $data->peg_mengetahui_id) || (Yii::app()->user->getState('pegawai_id') == $data->peg_menyetujui_id)) {
                                            return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPermintaan(' . $data->pembelianbarang_id . ')', array("id" => $data->pembelianbarang_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan permintaan pembelian barang", "data-placement" => "left"));
                                        } else {
                                            if (!empty($data->peg_mengetahui_umum_id)) {
                                                $nama_mengetahui_umum = PegawaiM::model()->findByPK($data->peg_mengetahui_umum_id)->namaLengkap;
                                            } else {
                                                $nama_mengetahui_umum = "";
                                            }
                                            return "<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh " . ((isset($data->peg_pemesanan_id) ? $data->pemesan->namaLengkap : "-")  . " atau " . $nama_mengetahui_umum . " atau " . (isset($data->peg_mengetahui_id) ? $data->mengetahui->namaLengkap : "-") . " atau " . (isset($data->peg_menyetujui_id) ? $data->menyetujui->namaLengkap : "-")) . " '><icon class='icon-form-silang' style='opacity: 0.3'></icon></a>";
                                        }
                                    } else {
                                        return "";
                                    }
                                }
                            },
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php

//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp";
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
//        $this->widget('UserTips',array('type'=>'admin'));
//        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
//
//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#gupembelianbarang-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);
?>

<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pembelian Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'maxHeight' => 600,
        'resizable' => false,
		'position'=>array('at'=>'bottom','my'=>'bottom'),
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="550">
</iframe>';

$this->endWidget();
?>

<!-- Dialog untuk mengetahui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahui',
        'options' => array(
            'title' => 'Approvement Manager Keuangan Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'maxHeight' => 600,
            'resizable' => false,
			'position'=>array('at'=>'bottom','my'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('gupembelianbarang-t-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMengetahui' width="100%" height="550"></iframe>
<?php $this->endWidget(); ?>
<!-- Dialog untuk menyetujui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Direktur RS Menyetujui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'maxHeight' => 600,
            'resizable' => false,
			'position'=>array('at'=>'bottom','my'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('gupembelianbarang-t-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMenyetujui' width="100%" height="550"></iframe>
<?php $this->endWidget(); ?>
<!-- Dialog untuk mengetahui umum -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahuiUmum',
        'options' => array(
            'title' => 'Approvement Manager Umum Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'maxHeight' => 600,
            'resizable' => false,
			'position'=>array('at'=>'bottom','my'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('gupembelianbarang-t-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMengetahuiUmum' width="100%" height="550"></iframe>
<?php $this->endWidget(); ?>

<?php
 // ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'DialogBatalPermintaan',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Pembatalan Permintaan Pembelian',
                        'autoOpen'=>false,
                        'show'=>'blind',
                        'hide'=>'explode',
                        'zIndex'=>1002,
                        'minWidth'=>600,
                        'minHeight'=>300,
                        'resizable'=>false,
                        'modal'=>true,
                         ),
                    ));
$this->renderPartial($this->path_view.'_formBatalPermintaanDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================

?>

<script>
function dialogBatalPermintaan(terimapersediaan_id)
   {
	   $('#DialogBatalPermintaan #terimapersediaan_id').val(terimapersediaan_id);
	   $('#DialogBatalPermintaan').dialog('open');
   }

   function ubahPeriksaKarenaBatal(){
		var terimapersediaan_id=$('#DialogBatalPermintaan #terimapersediaan_id').val();
		var pegawaipembatalan=$('#DialogBatalPermintaan #pegawaipembatalan').val();
		var tglbatal=$('#DialogBatalPermintaan #tglbatal').val();
		var keterangan_batal=$('#DialogBatalPermintaan #keterangan_batal').val();

		$('#DialogBatalperiksa #keterangan_batal').attr('class','');
		if (keterangan_batal == ''){
			myAlert("Alasan Pembatalan Permintaan Pembelian, wajib diisi");
			$('#DialogBatalPermintaan #keterangan_batal').attr('class','error');
			return false;
		}

		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('BatalPermintaanPembelian'); ?>',
			data: {terimapersediaan_id: terimapersediaan_id,tglbatal:tglbatal,keterangan_batal:keterangan_batal,pegawaipembatalan:pegawaipembatalan},//
			dataType: "json",
			success:function(data){
				if(data.status == 'ok'){
					if (data.pesan == 'exist') {
						myAlert(data.keterangan);
					} else {
                                            myAlert('Pembatalan Pemintaan Pembelian Berhasil !!!');
						$.fn.yiiGridView.update('gupembelianbarang-t-grid', {
							data: $(this).serialize()
						});
						$('#DialogBatalPermintaan #keterangan_batal').val('');
						$('#DialogBatalPermintaan').dialog('close');
					}
				  }else{
					  if(data.status == 'exist')
					  {
						  myAlert('Permintaan Tidak Bisa dibatalkan');
					  }

				  }
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});

   }
</script>
