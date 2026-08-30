<style>
	.button-status {
		margin-right: 8px;
	}

	.badge-status {
		position: relative;
		top: 8px;
		left: 8px;
	}

	.badge-status-jmlPanggil {
		position: relative;
		top: 8px;
		left: 10px;
		z-index: 10;
	}

	.btn-status {
		min-width: 150px;
	}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary panel-gradient">
			<div class="panel-heading">
				<div class="panel-title">Informasi <strong>Pasien Rujukan</strong></div>
			</div>
			<div class="panel-body">
				<?php
				Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('#search-penunjangrujukan-form').submit(function(){
					$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
							data: $(this).serialize()
					});
					return false;
				});
				");
				?>
				<?php if (!empty($_GET['pendaftaran_id'])) { ?>
					<div class="mds-form-message success">
						<?php echo Yii::app()->user->getFlash('success'); ?>
					</div>
				<?php } ?>

				<?php
				if (!empty($_GET['succes'])) {
				?>

					<div class="alert alert-block alert-success">
						<a class="close" data-dismiss="alert">×</a>
						<?php
						if ($_GET['succes'] == 2) {
						?>
							Pemeriksaan Pasien berhasil di batalkan
						<?php
						}
						if ($_GET['succes'] == 1) {
						?>
							Pasein Berhasil Di Rujuk
						<?php
						}
						?>
					</div>

				<?php
				}
				?>
				<div class="panel panel-success panel-shadow">
					<div class="panel-heading">
						<div class="panel-title">Tabel <strong>Pasien Rujukan</strong></div>
					</div>
					<div class="panel-body" style="overflow-x: scroll">
						<div class="block-tabel">
							<?php
							$this->widget('bootstrap.widgets.BootAlert');
							$this->widget('ext.bootstrap.widgets.BootGridView', array(
								'id' => 'pasienpenunjangrujukan-m-grid',
								'dataProvider' => $model->searchPasienRujukan(),
								'template' => "{summary}\n{items}\n{pager}",
								'itemsCssClass' => 'table table-bordered table-striped table-condensed',
								'replaceUrl' => true,
								'columns' => array(
									/*array(
                                                                            'name'=>'no_urutantri',
                                                                            'type'=>'raw',
                                                                            'header'=>'No. Antrian <br>/ Panggil Antrian',
                                                                            'value'=>function($data){
                                                                                if(empty($data->pasienmasukpenunjang_id)){
                                                                                    if(!empty($data->panggil_loginpemakai_id) && ($data->panggil_loginpemakai_id != Yii::app()->user->getState('loginpemakai_id'))){
                                                                                        return "Dipanggil loket lain";
                                                                                    }else{
                                                                                        if(!empty($data->jml_panggil)){
                                                                                            $badge = "<span class=\"badge badge-info pull-right badge-status-jmlPanggil\">".$data->jml_panggil."x</span>";
                                                                                        }else{
                                                                                            $badge = '';
                                                                                        }
                                                                                        return 
                                                                                            $badge.
                                                                                            CHtml::htmlButton(Yii::t("mds","".$data->nourut." <i class='entypo-megaphone'></i>",array()),array("class"=>"btn btn-primary btn-icon","onclick"=>"panggilAntrian('".$data->pasienkirimkeunitlain_id."','".$data->jml_panggil."');","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"));
                                                                                    }
                                                                                
                                                                                }
                                                                            },
                                                                            'htmlOptions'=>array(
                                                                               'style'=>'text-align:center;',
                                                                            ),
                                                                        ),*/
									'tgl_kirimpasien',
									array(
										'header' => 'Tgl Pendaftaran/<br/>No Pendaftaran',
										'name' => 'tgl_pendaftaran',
										'type' => 'raw',
										'value' => '$data->tgl_pendaftaran."/<br/>".$data->no_pendaftaran',
									),
									array(
										'header' => 'Instalasi/<br/>Ruangan',
										'type' => 'raw',
										'name' => 'instalasi_ruangan',
										'value' => '$data->InstalasiNamaRuanganNama',
									),
									array(
										'header' => 'Dokter Pengirim',
										'value' => '$data->namaLengkap'
									),
									'no_rekam_medik',
									array(
										'header' => 'Nama Pasien',
										'name' => 'nama_pasien_panggilan',
										'value' => '$data->nama_pasien',
									),
									array(
										'header' => 'Kasus Penyakit',
										'name' => 'kasus_pelayanan',
										'type' => 'raw',
										'value' => '"$data->jeniskasuspenyakit_nama"',
									),
									array(
										'header' => 'Jenis Penjamin / Penjamin',
										'name' => 'cara_bayar_penjamin',
										'value' => '$data->CaraBayarPenjaminNama',
									),
									//                'jeniskasuspenyakit_nama',
									//                'pendaftaran.umur',
									//                'pemeriksaanrad_nama',
									//                array(
									//                    'header'=>'Periksa',
									//                    'type'=>'raw',
									//                    'value'=>'CHtml::Link("<i class=\"icon-user\"></i>",Yii::app()->controller->createUrl("masukPenunjang/",array("idPasienKirimKeUnitLain"=>$data->pasienkirimkeunitlain_id,"pendaftaran_id"=>$data->pendaftaran_id)),
									//                                    array("class"=>"icon-user", 
									//                                          "id" => "selectPasien",
									//                                          "rel"=>"tooltip",
									//                                          "title"=>"Klik untuk periksa pasien",
									//                                    ))',
									//TRIAL BETA
									//									array(
									//										'header' => 'Status Periksa',
									//										'type'=>'raw',
									//										'value'=>function($data){
									//											return Params::getWrStatusPeriksa($data->statusperiksa);
									//										}
									//									),//myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien '.$data->statusperiksa.'","Perhatian !")'
									array(
										'header' => 'Status Periksa',
										'type' => 'raw',
										//										'value'=>function($data){
										//											return Params::getWrStatusPeriksa($data->statusperiksa);
										//										} 
										'value' => '$data->getStatusRujukan($data->statusperiksa,$data->pendaftaran_id,$data->pasienkirimkeunitlain_id)',
										'headerHtmlOptions' => array('style' => 'width:170px !important')

									),

									array(
										'header' => 'Periksa',
										'type' => 'raw',
										'value' => function ($data) {
											if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
												return CHtml::Link(
													"<i class='icon-form-periksa'></i>",
													Yii::app()->controller->createUrl("pendaftaranLaboratoriumRujukanRS/index", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id)),
													array(
														"class" => "icon-form-periksa",
														"id" => "selectPasien",
														"rel" => "tooltip",
														"title" => "Klik untuk periksa pasien",
													)
												);
											} else {
												return CHtml::Link(
													"<i class='icon-form-periksa'></i>",
													Yii::app()->controller->createUrl("pendaftaranLaboratoriumRujukanRS/index", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id)),
													array(
														"class" => "icon-form-periksa",
														"id" => "selectPasien",
														"rel" => "tooltip",
														"title" => "Klik untuk periksa pasien",
													)
												);
											}
										},
										'htmlOptions' => array('style' => 'text-align:left;'),
									),
									array(
										'header' => 'Batal Rujuk',
										'type' => 'raw',
										'value' => function ($data) {
											if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
												return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;", array('onclick' => 'myAlert("Anda tidak dapat membatalkan rujukan ini, karena status pasien ' . $data->statusperiksa . '","Perhatian !")', "id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left"));
											} else {
												return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(" . $data->pendaftaran_id . "," . $data->pasienkirimkeunitlain_id . ")", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan rujukan", "data-placement" => "left"));
												//												/dialogBatalPeriksa
												//return CHtml::link("<i class='icon-form-silang'></i>", "javascript:;",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan rujukan","data-placement"=>"left",'onclick'=>'dialogBatalPeriksa('.$data->pendaftaran_id.','.$data->pasienkirimkeunitlain_id.',"'.$data->nama_pasien.'")'));
											}
										},
										'htmlOptions' => array('style' => 'text-align: left; width:40px'),
									),
									// array(
									//    'header'=>'Batal Periksa',
									//    'type'=>'raw',
									//    'value'=>'CHtml::link("<i class=\'icon-remove\'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan"))',
									//    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
									// ),            
								),
								'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
							));
							?>
						</div>
					</div>
				</div>
				<div class="panel panel-success panel-shadow">
					<div class="panel-heading">
						<div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
					</div>
					<div class="panel-body">
						<?php $this->renderPartial('_formSearch', array('model' => $model, 'format' => $format)); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'DialogBatalperiksa',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
		'autoOpen' => false,
		'show' => 'blind',
		'hide' => 'explode',
		'zIndex' => 1002,
		'minWidth' => 500,
		'minHeight' => 100,
		'resizable' => false,
		'modal' => true,
	),
));
$this->renderPartial('_formBatalPeriksaDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================

?>

<?php echo $this->renderPartial('_jsFunctions', array()); ?>

<script type="text/javascript">
	/*
    document.getElementById('LBPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:none;");
    document.getElementById('LBPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:none;");
    function cekTanggal() {

        var checklist = $('#LBPasienKirimKeUnitLainV_cbTglMasuk');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('LBPasienKirimKeUnitLainV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }
    */


	function batalperiksa(pendaftaran_id, idKirimUnit) {
		myConfirm('Anda yakin akan membatalkan rujukan laboratorium pasien ini?', 'Perhatian!', function(r) {
			if (r) {
				$.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalRujuk') ?>', {
						pendaftaran_id: pendaftaran_id,
						idKirimUnit: idKirimUnit
					},
					function(data) {
						if (data.status == 'ok') {
							if (data.smspasien == 0) {
								var params = [];
								params = {
									instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
									modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
									judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
									isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
								}; // 16 
								insert_notifikasi(params);
							}
							myAlert(data.keterangan);
							// window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
							//                                 $('#dialogKonfirm div.divForForm').html(data.keterangan);
							$('#dialogKonfirm').dialog('open');
							//console.log('test');
							$('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
							//                        JQuery('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
						} else {
							myAlert(data.keterangan);
						}
					}, 'json'
				);
			}
		});
	}


	/**
	 * 
	 * @param {type} pendaftaran_id
	 * @param {type} statusperiksa
	 * @param {type} namaPasien
	 * @returns {undefined}
	 */
	function dialogBatalPeriksa(pendaftaran_id, pasienkirimkeunit_id, namaPasien) {
		$('#titleNamaPasienBatal').html(namaPasien);
		$('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
		$('#DialogBatalperiksa #pasienkirimkeunit_id').val(pasienkirimkeunit_id);
		$('#DialogBatalperiksa').dialog('open');
	}

	function ubahPeriksaKarenaBatal() {
		var pendaftaran_id = $('#DialogBatalperiksa #pendaftaran_id').val();
		var pasienkirimkeunit_id = $('#DialogBatalperiksa #pasienkirimkeunit_id').val();
		var tglbatal = $('#DialogBatalperiksa #tglbatal').val();
		var keterangan_batal = $('#DialogBatalperiksa #keterangan_batal').val();

		$('#DialogBatalperiksa #keterangan_batal').attr('class', '');
		if (keterangan_batal == '') {
			myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
			$('#DialogBatalperiksa #keterangan_batal').attr('class', 'error');
			return false;
		}

		$.ajax({
			type: 'POST',
			url: '<?php echo $this->createUrl('batalRujuk'); ?>',
			data: {
				pendaftaran_id: pendaftaran_id,
				tglbatal: tglbatal,
				keterangan_batal: keterangan_batal,
				idKirimUnit: pasienkirimkeunit_id
			}, //
			dataType: "json",
			success: function(data) {
				if (data.status == 'ok') {
					$('#DialogBatalperiksa').dialog('close');
					if (data.smspasien == 0) {
						var params = [];
						params = {
							instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
							modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
							judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
							isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
						}; // 16 
						insert_notifikasi(params);
					}
					myAlert(data.keterangan);
					// window.location = "<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/index&succes=2') ?>";
					//                                 $('#dialogKonfirm div.divForForm').html(data.keterangan);
					$('#dialogKonfirm').dialog('open');

					//console.log('test');
					$('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
					//                        JQuery('#pasienpenunjangrujukan-m-grid').yiiGridView('update');
				} else {
					myAlert(data.keterangan);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
			}
		});

	}
</script>