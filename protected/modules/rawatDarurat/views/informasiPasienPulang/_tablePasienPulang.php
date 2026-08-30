<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftarPasienPulang-grid',
	'dataProvider'=>$modPasienYangPulang->searchRD(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(	
//                'tglpasienpulang',
		array(
                    'header'=>'Tgl. Pasien Pulang',
                    'value'=>'$data->tglpasienpulang',
                ),
                array(
                    'header'=>'Tgl. Pendaftaran/<br> No. Pendaftaran',
                    'type'=>'raw',
                    'value'=>'$data->tgl_pendaftaran."/<br>".$data->no_pendaftaran',
                ),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik'
                ),  
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan.$data->nama_pasien'
                ),
                array(
                    'header'=>'Jenis Kasus Penyakit',
                    'value'=>'$data->jeniskasuspenyakit_nama',
                ), 
                array(
                    'header'=>'Jenis Penjamin /Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->CaraBayardanPenjamin'
                ),
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        return $p->pegawai->namaLengkap;
                    },
                ),
                array(
                    'header'=>'Cara/Kondisi Pulang',
                    'type'=>'raw',
                    'value'=>'$data->CaradanKondisiPulang'
				),
				/* array(
                        'header'=>'Status Dokumen',
                        'type'=>'raw',
                        'value'=> function($data) {
                            $ruangan_id = Yii::app()->user->getState('ruangan_id');
                            $status_dokumen = RDPendaftaranT::model()->findByPk($data->pendaftaran_id);
                        
                            if  ($status_dokumen->statusdokrm == "SUDAH DITERIMA"){
								if (Yii::app()->user->getState('ruangan_id') == $status_dokumen->pengirimanrm->ruanganpenerima_id){
									//var_dump($data->statusperiksa);
									if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO){
										return CHtml::link("<i></i> $status_dokumen->statusdokrm", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/statusDokumenKirim', array("pengirimanrm_id"=>$status_dokumen->pengirimanrm_id,"pendaftaran_id"=>$data->pendaftaran_id)),
											array("class"=>"btn btn-primary",
											"target"=>"frameStatusDokumen",
											"rel"=>"tooltip",
											"title"=>"Klik untuk mengirim dokumen ke ruangan lain",
											"onclick"=>'myConfirm("Pasien Masih Dalam Status Menunggu Admisi. Apakah Anda akan melanjutkan transaksi?","Perhatian",function(r){if(r){$("#dialogStatusDokumen").dialog("open")}});'));
									}else{
										return CHtml::link("<i></i> $status_dokumen->statusdokrm", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/statusDokumenKirim', array("pengirimanrm_id"=>$status_dokumen->pengirimanrm_id,"pendaftaran_id"=>$data->pendaftaran_id)),
											array("class"=>"btn btn-primary",
											"target"=>"frameStatusDokumen",
											"rel"=>"tooltip",
											"title"=>"Klik untuk mengirim dokumen ke ruangan lain",
											"onclick"=>'$("#dialogStatusDokumen").dialog("open");'));
									}
								}else{
									return $data->getStatusDokumen($status_dokumen->pengirimanrm_id,$status_dokumen->statusdokrm,$data->pendaftaran_id);
								}								
							}else{								
								return $data->getStatusDokumen($status_dokumen->pengirimanrm_id,$status_dokumen->statusdokrm,$data->pendaftaran_id);								
							}
                        },
                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                ),*/
                
//                'tgladmisi',
                
//                'umur',
//                
                /*
                array(
                    'header'=>'Kelas Pelayanan',
                    'type'=>'raw',
                    'value'=>'$data->KelasPelayanan'
                ),
                 * 
                 */ 
//                'jeniskasuspenyakit_nama',

//                array(
//                       'header'=>'Batal Pulang',
//                       'type'=>'raw',
//                       'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ","javascript:cekHakAkses($data->pasienpulang_id,$data->pasienadmisi_id,$data->pasien_id,$data->pendaftaran_id)" ,array("title"=>"Klik untuk Membatalkan Kepulangan"))',
//                    ),
                array(
                       'header'=>'Batal Pulang',
                       'type'=>'raw',
                       'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", 
                           Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/batalPulang",array("pendaftaran_id"=>$data->pendaftaran_id)),
                               array("title"=>"Klik untuk Batal Pulang", "target"=>"iframeBatalPulang", "onclick"=>"$(\"#dialogBatalPulang\").dialog(\"open\");", "rel"=>"tooltip"))',
                       'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
              
	),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
echo CHtml::hiddenField('pasien_id','',array('readonly'=>TRUE));
echo CHtml::hiddenField('pendaftaran_id','',array('readonly'=>TRUE));
?>

<?php 
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogStatusDokumen',
        'options' => array(
            'title' => 'Pengiriman Dokumen Ke-Ruangan Lain',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 400,
            'resizable' => true,
            'close'=>"js:function(){ $.fn.yiiGridView.update('daftarPasienPulang-grid', {
                    data: $('#daftarPasienPulang-form').serialize()
                }); }",
        ),
    ));
    ?>
    <iframe name='frameStatusDokumen' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>

	
	<script>
	function verifikasiKirimanRM(id, kirimrm) {
		myConfirm('Yakin untuk Menerima Dokumen Rekam Medis Pasien? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('/rawatDarurat/DaftarPasien/terimaDokumen');?>', {
					pendaftaran_id:id, pengirimanrm_id:kirimrm
				}, function(data){
					if(data.status == 'proses_form'){
							//$('#dialogStatusDokumen div.divForForm').html(data.div);
							$.fn.yiiGridView.update('daftarPasien-grid');
							//setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
						}
				}, 'json');
			}else{
				 preventDefault();
			}
		});
	}
	</script>
