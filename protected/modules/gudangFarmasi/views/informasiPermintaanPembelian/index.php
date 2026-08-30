<?php
 $this->breadcrumbs=array(
    'Informasi Permintaan Pembelian Obat & Alkes',
);
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="row">
    <div class="col-md-12">
        <!-- <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div> -->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Permintaan Pembelian Obat dan Alkes</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Permintaan Pembelian Obat & Alkes</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
								'id'=>'rencana-m-grid',
								'dataProvider'=>$model->searchInformasi(),
								'template'=>"{summary}\n{items}\n{pager}",
								'itemsCssClass'=>'table table-bordered table-striped table-condensed',
								'columns'=>array(
									array(
										'name'=>'tglpermintaanpembelian',
										'type'=>'raw',
										'value'=>'MyFormatter::formatDateTimeForUser($data->tglpermintaanpembelian)',
									),
                                    array(
                                        'header'=>'No. Permintaan',
                                        'type'=>'raw',
                                        'value'=>function($data) {
                                            $link_update = (isset($data->tglmenyetujui))?
											'<a rel="tooltip" title="Tidak dapat diubah karena sudah disetujui oleh Direktur Menyetujui"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
											:
												(($data->statuspembelian != "DITOLAK")?
													CHtml::link('<icon class=\'icon-form-ubah\'></icon> ', Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id.'/'.$this->path_permintaan.'/index', array("permintaanpembelian_id"=>$data->permintaanpembelian_id,"ubah"=>true)), array("target"=>"BLANK","rel"=>"tooltip", "title"=>"Klik untuk mengubah data"))
												:
													'<a rel="tooltip" title="Tidak dapat diubah karena sudah ditolak"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
												);
                                            return $data->nopermintaan;
                                        },
                                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
                                    array(
                                        'header'=>'Sumber Dana',
                                        'type'=>'raw',
                                        'value'=>'$data->sumberdana_nama',
                                    ),
									//'nopermintaan',
                                    array(
                                        'name'=>'ruangan_id',
                                        'type'=>'raw',
                                        'value'=>'$data->ruangan_nama',
                                    ),
                                    array(
                                        'name'=>'supplier_id',
                                        'type'=>'raw',
                                        'value'=>'$data->supplier_nama',
                                    ),
                                    array(
                                        'header'=>'Tanggal Dikirim',
                                        'type'=>'raw',
                                        'value'=>'(!empty($data->tgldikirim)? MyFormatter::formatDateTimeForUser($data->tgldikirim):"-")',
                                    ),
                                    array(
                                        'header'=>'Tgl. Permintaan Uang Muka Pembelian',
                                        'type'=>'raw',
                                        'value'=>'(!empty($data->tglpermintaanuangmuka)? MyFormatter::formatDateTimeForUser($data->tglpermintaanuangmuka):"-")',
                                    ),
                                    array(
                                        'header'=>'Jumlah Permintaan Uang Muka Pembelian',
                                        'type'=>'raw',
                                        'value'=>'"Rp. ".(!empty($data->tglpermintaanuangmuka)? MyFormatter::formatNumberForPrint($data->jmlpermintaanuangmuka, 2):"-")',
                                    ),
                                    array(
                                        'header'=>'Jenis PPh',
                                        'type'=>'raw',
                                        'value'=>'$data->pajak_nama',
                                    ),
                                    array(
                                        'header'=>'Manager Umum Mengetahui',
                                        'type'=>'raw',
                                        'value'=>function($data){
                                            $dataDialog = 'myAlert("Hanya '.(isset($data->pegawaimengetahuiumum_id)? $data->getPegawaimengetahuiumumLengkap($data->pegawaimengetahuiumum_id) : "-").' yang bisa mengakses");';
                                           if($data->pegawaimengetahuiumum_id==Yii::app()->user->getState('pegawai_id')){
                                               $dataDialog = "$('#dialogMengetahuiUmum').dialog('open');";
                                           }
                                            $html = (isset($data->pegawaimengetahuiumum_id)? $data->getPegawaimengetahuiumumLengkap($data->pegawaimengetahuiumum_id) : "-").(isset($data->tglmengetahuiumum) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmengetahuiumum) :(isset($data->pegawaimengetahuiumum_id) ? CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/MengetahuiUmum', array("permintaanpembelian_id"=>$data->permintaanpembelian_id,"frame"=>true)), array("target"=>"frameMengetahuiUmum","rel"=>"tooltip", "title"=>"Klik Untuk Approve Manager Umum", "onclick"=>$dataDialog)) : ""));
                                            return $html;
                                        },
                                    ),
                                    array(
                                        'header'=>'Manager Keuangan Mengetahui',
                                        'type'=>'raw',
                                        'value'=>function($data){
                                            $dataDialog = 'myAlert("Hanya '.(isset($data->pegawaimengetahui_id)? $data->PegawaimengetahuiLengkap : "-").' yang bisa mengakses");';
                                           if($data->pegawaimengetahui_id==Yii::app()->user->getState('pegawai_id')){
                                               $dataDialog = "$('#dialogMengetahui').dialog('open');";
                                           }
                                           $html = (isset($data->pegawaimengetahui_id)? $data->PegawaimengetahuiLengkap : "-").(isset($data->tglmengetahui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmengetahui) : (!isset($data->pegawaimengetahui_id)? "" : ((empty($data->tglmengetahuiumum)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Mengetahui', array("permintaanpembelian_id"=>$data->permintaanpembelian_id,"frame"=>true)), array("target"=>"frameMengetahui","rel"=>"tooltip", "title"=>"Klik Untuk Approve Manager Keuangan", "onclick"=>$dataDialog)))));
                                            return $html;
                                        },
                                    ),
                                    array(
                                            'header'=>'Direktur Menyetujui',
                                            'type'=>'raw',
                                            'value'=>function($data){
                                            if ($data->statuspembelian != "DITOLAK"){
                                                $dataDialog = 'myAlert("Hanya '.(isset($data->pegawaimenyetujui_id)? $data->PegawaimenyetujuiLengkap : "-").' yang bisa mengakses");';
                                               if($data->pegawaimenyetujui_id==Yii::app()->user->getState('pegawai_id')){
                                                   $dataDialog = "$('#dialogMenyetujui').dialog('open');";
                                               }
                                                $check = "";
                                                if(!empty($data->tglmengetahuiumum) && !empty($data->tglmengetahui)){
                                                    $check = "kosong"; 
                                                }
                                                $html = (isset($data->pegawaimenyetujui_id)? $data->PegawaimenyetujuiLengkap : "-").(isset($data->tglmenyetujui) ? "<br>".MyFormatter::formatDateTimeForUser($data->tglmenyetujui) : (!isset($data->pegawaimenyetujui_id)? "" : ((empty($check)) ? "" : CHtml::link("<icon class='icon-form-check'></icon> ", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Menyetujui', array("permintaanpembelian_id"=>$data->permintaanpembelian_id,"frame"=>true)), array("target"=>"frameMenyetujui","rel"=>"tooltip", "title"=>"Klik untuk Approve Direktur", "onclick"=>$dataDialog)))));
                                                    return $html;
                                            }else{
                                                return "<a rel='tooltip' title='Rencana ini sudah ditolak'><icon class='icon-form-check' style='opacity: 0.3'></icon></a> ";
                                            }
                                        },
                                    ),
                                    
									array(
										'name'=>'statuspembelian',
										'type'=>'raw',
										'value'=>'$data->statuspembelian',
									),
                                                    array(
                                        'header'=>'Ubah Permintaan',
                                        'type'=>'raw',
                                        'value'=>function($data) {
                                            $link_update = (!empty($data->tglmenyetujui))?
											'<a rel="tooltip" title="Tidak dapat diubah karena sudah disetujui oleh Direktur Menyetujui"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
											:
												(($data->statuspembelian != "DITOLAK")?
                                                                                                ((!empty($data->tglmengetahui))? 
                                                                                                '<a rel="tooltip" title="Tidak dapat diubah karena sudah diketahui oleh Manager Keuangan"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
                                                                                        :
													((($data->pegawai_id == Yii::app()->user->getState('pegawai_id')) || ($data->pegawaimengetahuiumum_id == Yii::app()->user->getState('pegawai_id'))?
                                                                                                        CHtml::link('<icon class=\'icon-form-ubah\'></icon> ', Yii::app()->controller->createUrl('/'.Yii::app()->controller->module->id.'/'.$this->path_permintaan.'/index', array("permintaanpembelian_id"=>$data->permintaanpembelian_id,"ubah"=>true)), array("target"=>"BLANK","rel"=>"tooltip", "title"=>"Klik untuk mengubah data"))
                                                    :"<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh ".($data->getPegawaimengetahuiumumLengkap($data->pegawai_id) ." atau ". $data->getPegawaimengetahuiumumLengkap($data->pegawaimengetahuiumum_id))." '><icon class='icon-form-ubah' style='opacity: 0.3'></icon></a>")))
												:
													'<a rel="tooltip" title="Tidak dapat diubah karena sudah ditolak"><icon class="icon-form-ubah" style="opacity: 0.3"></icon></a> '
												);
                                
                                
                                            return $link_update;
                                        },
                                        'htmlOptions'=>array('style'=>'text-align:center;'),
                                    ),
									array(
										'header'=>'Penerimaan Obat Alkes',
										'type'=>'raw',
										'value'=> function ($data){
											$cek = GFPenerimaanBarangT::model()->find('permintaanpembelian_id = '.$data->permintaanpembelian_id);
											 if ((isset($data->tglmenyetujui))){
												 if (!empty($data->penerimaanbarang_id)){
													return  CHtml::Link("<i class='icon-form-terimaobalkes'></i>",'', array('disabled'=>true,'style'=>'opacity: 0.3',"class"=>"", "rel"=>"tooltip","title"=>"Barang Sudah ".$cek->statuspenerimaan));
												 }else{
                                                                                                     $modUangMukaBeli = UangmukabeliT::model()->findByAttributes(array('permintaanpembelian_id'=>$data->permintaanpembelian_id));
                                                                                                     $checkuangmuka = true;
                                                                                                     if(!empty($data->jmlpermintaanuangmuka)){
                                                                                                         if(!isset($modUangMukaBeli)){
                                                                                                             $checkuangmuka = false; 
                                                                                                         }
                                                                                                     }
                                                                                                     
                                                                                                     if($checkuangmuka){
                                                                                                         return ((Yii::app()->user->getState("instalasi_id") == Params::INSTALASI_ID_FARMASI) ? CHtml::Link("<i class='icon-form-terimaobalkes'></i>",$this->createUrl("/gudangFarmasi/PenerimaanBarang/Index").'&permintaanpembelian_id='.$data->permintaanpembelian_id,array("class"=>"", "rel"=>"tooltip","title"=>"Klik Melakukan Ke Penerimaan Obat Alkes",)) : "Belum Diterima");                                                                                
                                                                                                     }else{
                                                                                                         return "Permintaan ini belum dilakukan pembayaran uang muka";
                                                                                                     }
                                                                                                     
                                                                                                     
													
												 }
											 }else{                                    
													return CHtml::Link("<i class='icon-form-terimaobalkes'></i>",'', array('disabled'=>true,'style'=>'opacity: 0.3',"class"=>"", "rel"=>"tooltip","title"=>"Tombol akan aktif jika permintaan sudah disetujui dan diketahui"));
											 }

										},				
										'htmlOptions'=>array('style'=>'text-align:center;'),
									), 
									array(
										'header'=>'Rincian',
										'type'=>'raw',
										'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Rincian", array("permintaanpembelian_id"=>$data->permintaanpembelian_id)),
											array("class"=>"", 
												  "target"=>"rencana",
												  "onclick"=>"$(\"#dialogRencana\").dialog(\"open\");",
												  "rel"=>"tooltip",
												  "title"=>"Klik untuk melihat rincian Permintaan Pembelian",
											))',
                        ),
                        array(
                            'header' => 'Batal',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => function ($data) {
                                $modApprovalotorisasiM = ApprovalotorisasiM::model()->find();
                                if (!empty($data->penerimaanbarang_id)) {
                                    return "Telah Diterima";
                                } else {
                                    if (empty($data->tglmengetahuiumum) || empty($data->tglmengetahui) || empty($data->tglmenyetujui)) {
                                        if (($data->pegawai_id == Yii::app()->user->getState('pegawai_id')) || ($data->pegawaimengetahuiumum_id == Yii::app()->user->getState('pegawai_id')) || ($data->pegawaimengetahui_id == Yii::app()->user->getState('pegawai_id')) || ($data->pegawaimenyetujui_id == Yii::app()->user->getState('pegawai_id'))) {
                                            //                                                                                    if(Yii::app()->user->getState('pegawai_id') == $modApprovalotorisasiM->kepalafarmasi_id){
                                            return CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPermintaan(' . $data->permintaanpembelian_id . ')', array("id" => $data->permintaanpembelian_id, "rel" => "tooltip", "title" => "Klik untuk membatalkan permintaan pembelian obat alkes", "data-placement" => "left"));
                                        } else {
                                            return "<a rel='tooltip' title='Tidak dapat diubah karena hanya bisa diakses oleh " . ($data->getPegawaimengetahuiumumLengkap($data->pegawai_id) . " atau " . $data->getPegawaimengetahuiumumLengkap($data->pegawaimengetahuiumum_id) . " atau " . $data->getPegawaimengetahuiumumLengkap($data->pegawaimengetahui_id) . " atau " . $data->getPegawaimengetahuiumumLengkap($data->pegawaimenyetujui_id)) . " '><icon class='icon-form-silang' style='opacity: 0.3'></icon></a>";
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
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogRencana',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Surat Pesanan',
                        'autoOpen'=>false,
                        'minWidth'=>900,
                        'minHeight'=>100,
                        'resizable'=>false,
                        'position'=>array('my'=>'bottom','at'=>'bottom'),
                         ),
                    ));
?>
<iframe src="" name="rencana" width="100%" height="550" style="border: none;">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================

?>


<!-- Dialog untuk mengetahui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahui',
        'options' => array(
            'title' => 'Approvement Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'minHeight' => 500,
            'resizable' => false,
            'position'=>array('my'=>'bottom','at'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMengetahui' width="100%" height="550px" style="border: none;"></iframe>
<?php $this->endWidget(); ?>

<!-- Dialog untuk mengetahui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMengetahuiUmum',
        'options' => array(
            'title' => 'Approvement Pegawai Mengetahui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'minHeight' => 500,
            'resizable' => false,
            'position'=>array('my'=>'bottom','at'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMengetahuiUmum' width="100%" height="550px" style="border: none;"></iframe>
<?php $this->endWidget(); ?>

<!-- Dialog untuk menyetujui -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenyetujui',
        'options' => array(
            'title' => 'Approvement Pegawai Menyetujui',
            'autoOpen' => false,
            'modal' => true,
            'width' => 1000,
            'minHeight' => 500,
            'resizable' => false,
            'position'=>array('my'=>'bottom','at'=>'bottom'),
			'close'=>"js:function(){ $.fn.yiiGridView.update('rencana-m-grid', {
					data: $(this).serialize()
				}); }",
        ),
));
?>
<iframe name='frameMenyetujui' width="100%" height="550px" style="border: none;"></iframe>
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
                        'maxHeight'=>600,
                        'resizable'=>false,
                        'modal'=>true,    
                         ),
                    ));
$this->renderPartial($this->path_view.'_formBatalPermintaanDialog');                    

$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================

?>


<script>
function dialogBatalPermintaan(permintaanpembelian_id)
   {
	   $('#DialogBatalPermintaan #permintaanpembelian_id').val(permintaanpembelian_id);
	   $('#DialogBatalPermintaan').dialog('open');
   }
   
   function ubahPeriksaKarenaBatal(){				
		var permintaanpembelian_id=$('#DialogBatalPermintaan #permintaanpembelian_id').val(); 
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
			data: {permintaanpembelian_id: permintaanpembelian_id,tglbatal:tglbatal,keterangan_batal:keterangan_batal,pegawaipembatalan:pegawaipembatalan},//
			dataType: "json",
			success:function(data){
				if(data.status == 'ok'){
					if (data.pesan == 'exist') {
						myAlert(data.keterangan);
					} else {
                                            myAlert('Pembatalan Pemintaan Pembelian Berhasil !!!');
						$.fn.yiiGridView.update('rencana-m-grid', {
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