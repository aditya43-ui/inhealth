<style>

	.is_ada_ttv td {
		background-color: #dcdcdc !important;
	}

</style>

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftarpasien-v-grid',
    'dataProvider'=>$model->searchDaftarPasienPoliklinik(),
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-condensed',
    'columns'=>array(   
		array(
			'name'=>'no_urutantri',
			'type'=>'raw',
			'header'=>'No. Antrian/<br>Panggil Antrian',
			// 'value'=>'$data->ruangan_singkatan."-".$data->no_urutantri."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : "-")'
			'value'=>'$data->ruangan_singkatan."-".$data->no_urutantri."<br>".(($data->panggilantrian == TRUE) ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pendaftaran_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutantri\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
		),
		array(
			'header'=>'Poliklinik',
			'type'=>'raw',
			'value'=>'$data->ruangan_nama',
		),
		array(
			'name'=>'tgl_pendaftaran',
			'type'=>'raw',
			'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
		),
		array(
			'name'=>'No_pendaftaran'.'/<br>'.'No_rekam_medik '.'/<br>'.'N I K',
			'type'=>'raw',
			'value'=>'"$data->no_pendaftaran"."<br>"."$data->no_rekam_medik"."<br>"."$data->no_identitas_pasien"',
		),
		array(
			'name'=>'nama_pasien'.'/<br>'.'Alias',
			'type'=>'raw',
			'value'=>'"$data->nama_pasien"."<br>"."$data->nama_bin"',
		),
		array(
			'name'=>'alamat_pasien'.'/<br>'.'RT RW',
			'type'=>'raw',
			'value'=>'"$data->alamat_pasien"."<br>"."$data->RTRW"',
		),
		array(
			'name'=>'Penjamin'.'/<br>'. 'Jenis Penjamin',
			'type'=>'raw',
			'value'=>'"$data->penjamin_nama"."<br>"."$data->carabayar_nama"',
		),
		array(
            'header'=>'Dokter/<br>Kelas Pelayanan',
            'type'=>'raw',
            'value'=>'"<div style=\'width:80px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama," ",array("onclick"=>"ubahDokterPeriksa(\'$data->pendaftaran_id\');$(\'#editDokterPeriksa\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Dokter Periksa")) . "</div>"."/"."$data->kelaspelayanan_nama"',
            'htmlOptions'=>array(
               'style'=>'text-align:center;',
               'class'=>'rajal'
           )
        ),                
// 		array(
// 			'header'=>'Kasus Penyakit ',
// 			'type'=>'raw',
// //			'value'=>'CHtml::hiddenField("RJInfokunjunganrV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3")).$data->jeniskasuspenyakit_nama',
// 			'value'=>'CHtml::hiddenField("RJInfokunjunganrV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3")).CHtml::link("<i class=icon-form-ubah></i> ".$data->jeniskasuspenyakit_nama,"javascript:void(0)",array("onclick"=>"ubahKasusPenyakit(this,$data->pendaftaran_id,$data->jeniskasuspenyakit_id);return false;","class"=>"kasus_penyakit","rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Kasus Penyakit"))',
// 			'htmlOptions'=>array(
// 				'style'=>'text-align: center',
// 				'class'=>'list_kasus_penyakit'
// 			)
// 		),
		array(
			'header'=>'Status Periksa',
			'type'=>'raw',
			'value'=>function($data) {
				$str = $data->getStatus($data->statusperiksa,$data->pendaftaran_id);

				$periksaFisik = PemeriksaanfisikT::model()->findByAttributes(array(
					'pendaftaran_id'=>$data->pendaftaran_id,
                    'is_ns'=>true,
				), array('order' => 'create_time DESC'));
				$anamnesa = AnamnesaT::model()->findByAttributes(array(
					'pendaftaran_id'=>$data->pendaftaran_id,
                    'is_ns'=>true,
				), array('order' => 'create_time DESC'));

				if (!empty($anamnesa) && !empty($periksaFisik)) {
					$str .= '<div class="is_ttv">Pasien Sudah Melakukan Pemeriksaan Tanda Vital di NS</div>';
				}

				return $str;
			},
		),
		array(
			'header' => 'Status Dokumen',
			'type' => 'raw',
			'value' => function ($data) {
				$kirim = PengirimanrmT::model()->findByPk($data->pengirimanrm_id);
				// $crit = new CDbCriteria();
				// $crit->addCondition('pasien_id ='. $data->pasien_id);
				// $modDokfilerm = DokfilermR::model()->findAll($crit);
				// $modDokfilerms =[];
				// foreach ($modDokfilerm as $dok) {
				//     // var_dump((array)$dok->instalasi_ids);die;
				//     if (in_array( Yii::app()->user->getState('instalasi_id'), (array)$dok->instalasi_ids)) {
				//        $modDokfilerms[]=$dok; 
				//     }
				// }
				$dok = CHtml::link("<i class='icon-file' style='margin: 7px;'></i><br>File Rekam Medis", Yii::app()->controller->createUrl('InformasiDaftarPasienPoliklinik/riwayatDokfilerm', array('pendaftaran_id' => $data->pendaftaran_id)), array("target" => "frameRiwayatDokfilerm", "rel" => "tooltip", "title" => "Klik untuk melihat File Rekam Medis", "onclick" => "$('#dialogDokFilerm').dialog('open');"));
				// if (!empty($kirim)) {
				// 	if ($data->statusdokrm == "SUDAH DITERIMA") {
				// 		if ($kirim->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')) {
				// 			if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
				// 				return CHtml::link(
				// 					$data->statusdokrm,
				// 					Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $data->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
				// 					array(
				// 						"class" => "btn btn-primary",
				// 						"target" => "frameStatusDokumen",
				// 						"rel" => "tooltip",
				// 						"title" => "Klik untuk mengirim dokumen ke ruangan lain",
				// 						"onclick" => 'myConfirm("Pasien Masih Dalam Status Menunggu Admisi. Apakah Anda akan melanjutkan transaksi?","Perhatian",function(r){if(r){$("#dialogStatusDokumen").dialog("open")}});'
				// 					)
				// 				)
				// 					. '<br><br>' .
				// 					$dok;
				// 			} else {
				// 				return CHtml::link(
				// 					$data->statusdokrm,
				// 					Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $data->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)),
				// 					array(
				// 						"class" => "btn btn-primary",
				// 						"target" => "frameStatusDokumen",
				// 						"rel" => "tooltip",
				// 						"title" => "Klik untuk mengirim dokumen ke ruangan lain",
				// 						"onclick" => "$('#dialogStatusDokumen').dialog('open');"
				// 					)
				// 				) . '<br><br>' .
				// 					$dok;
				// 			}
				// 		} else {
				// 			return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
				// 				$dok;
				// 		}
				// 	} else {
				// 		return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
				// 			$dok;
				// 	}
				// } else {
				// 	return $data->getStatusDokumen($data->pengirimanrm_id, $data->statusdokrm, $data->pendaftaran_id) . '<br><br>' .
				// 		$dok;
				// }
				return $dok;
			},
			'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
		),
		array(
			'name'=>'Periksa Pasien',
			'type'=>'raw',
			// 'value'=>'CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanPasien",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien"))',
			'value' => function ($data) {
                echo '<div class="small-container">';
                echo CHtml::link("<i class='icon-form-rj'></i><br>Asesmen Pasien", Yii::app()->controller->createUrl("/rawatJalan/pemeriksaanAsesmenPasienRJ", array("pendaftaran_id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Asesmen Pasien Rawat Jalan"));
                echo '</div>';
                echo '<div class="small-container">';
                echo $data->linkPeriksaPasien;
                echo '</div>';
            },
			'htmlOptions'=>array('style'=>'text-align:left;')
		),
		array(
            'name' => 'Rekam Medis Elektronik',
            'type' => 'raw',
            // 'value' => '',
            'value' => function ($data) {
                $link = '<div class="small-container">';
                // $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/doctor.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Dokter ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienRJ/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Dokter')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh dokter"));
                // $link .= '</div>';
                $link .= '<div class="small-container">';
                $link .= CHtml::link('<i style="background: url(' . Yii::app()->getBaseUrl('webroot') . '/images/icon/nurse.png) center center no-repeat; display: inline-block; background-size: contain; width: 26px; height: 26px;"></i><br>Perawat / Bidan ', Yii::app()->controller->createUrl("RekamMedikElektronikPasienRJ/index", array("pendaftaran_id" => $data->pendaftaran_id, 'type' => 'Perawat')), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk pembuatan rekam medik elektronik oleh perawat"));
                $link .= '</div>';
                return $link;
            },
            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
        ),
		array(
			'name' => 'Tanda Vital Pasien',
			'type' => 'raw',
			'value' => function ($data) {
					return '<div class="small-container">' . CHtml::link('<i class="icon-pencil-brown"></i><br>', Yii::app()->controller->createUrl('pemeriksaanFisik/PeriksaTandaVital', array(
							'pendaftaran_id' => $data->pendaftaran_id,
					)), array(
							'target' => 'framePeriksaTandaVital',
							'onclick' => "$('#dialogPeriksaTandaVital').dialog('open');",
					)) . '</div>';
			},
			'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
		),

		array(
			'name'=>'Tindak Lanjut<br>ke Rawat Inap',
			'type'=>'raw',
			'value'=>'(!empty($data->pendaftaran->pasienpulang_id) ) ?  "Pasien di Rawat Inap".
				CHtml::link("<i class=\'icon-form-sampah\'></i>", Yii::app()->controller->createUrl("/rawatJalan/DaftarPasien/BatalRawatInap",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)) , array("title"=>"Klik untuk Batal Proses Tindak Lanjut Pasien","target"=>"iframeBatalRawatInap", "onclick"=>"$(\"#dialogBatalRawatInap\").dialog(\"open\");", "rel"=>"tooltip"))  :  
				(($data->statusperiksa==Params::STATUSPERIKSA_BATAL_PERIKSA) ? "" : CHtml::link("<i class=\'icon-form-ri\'></i>", Yii::app()->createUrl("/rawatJalan/DaftarPasien/tindakLanjutRI", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)),
				array("class"=>"",
				"rel"=>"tooltip",
				"title"=>"Klik untuk Proses Tindak Lanjut Pasien",
				"onclick"=>"setFrameTindakLanjut(this); $(\'#dialogTindakLanjut\').dialog(\'open\'); return false;")))',
			'htmlOptions'=>array('style'=>'text-align:left; width:60px')
		),
		array(
			'header'=>'Rencana Kontrol',
			'type'=>'raw',
			'value'=>'((!empty($data->tglrenkontrol)) ? $data->tglrenkontrol.CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
					Yii::app()->controller->createUrl("daftarPasien/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)) ,
					array("title"=>"Klik untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"cekRenControl(event)", "rel"=>"tooltip")) : CHtml::link("<i class=\'icon-form-rkontrol\'></i> ",
					Yii::app()->controller->createUrl("daftarPasien/RencanaKontrolPasienRJ",array("pendaftaran_id"=>$data->pendaftaran_id,"ruangan_id"=>$data->ruangan_id)) ,
					array("title"=>"Klik untuk Rencana Kontrol Pasien","target"=>"iframeRencanaKontrol", "onclick"=>"$(\"#dialogRencanaKontrol\").dialog(\"open\");", "rel"=>"tooltip")))',
			'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
		),
		array(
                    'header'=>'Detail Rincian Tagihan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->createUrl("/billingKasir/pembayaranTagihanPasien/printDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat detail rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align:left; width:40px ')                  
                ),   
//		array(
//			'header'=>'Rincian Tagihan',
//			'type'=>'raw',
//			'value'=>'"-"',
//		),
		array(
			'header'=>'Batal Periksa',
			'type'=>'raw',
			'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id,$data->ruangan_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
			'htmlOptions'=>array('style'=>'text-align:left; width:40px'),
		),
    ),
	'afterAjaxUpdate' => 'function(id, data){
		jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
		setPunyaTTV(); }',
)); ?>
<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokFilerm',
    'options' => array(
        'title' => 'Riwayat Dokumen File Rekam Medis',
        'autoOpen' => false,
        'modal' => true,
        'width' => 950,
        'height' => 550,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarPasien-grid', {
                        data: $('#daftarPasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe name='frameRiwayatDokfilerm' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>
<!-- END DOKUMEN -->


<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogPeriksaTandaVital',
        'options' => array(
            'title' => 'Detail Pemeriksaan Fisik | Data Pemeriksaan dan Tanda Vital',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 800,
            'height' => 550,
            'resizable' => true
        ),
    )
);
echo '<iframe name="framePeriksaTandaVital" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
{

	function cektindaklanjut() {
            myAlert("Pasien sudah ditindak lanjut ke Rawat Inap!");
        }

	function setPunyaTTV() {
		$("#daftarpasien-v-grid tbody tr").each(function() {
			if ($(this).find(".is_ttv").length != 0) {
				$(this).addClass("is_ada_ttv");
			}
		});
	}

    function setFrameTindakLanjut(obj) {
        // console.log("Link", $(obj).prop("href"));
        
        $("#frameTindakLanjut").prop("src", $(obj).prop("href"));
    }
    
    
   function batalperiksa(pendaftaran_id,ruangan_id)
   {
        myConfirm("Anda yakin akan membatalkan pemeriksaan rawat jalan pasien ini?","Perhatian!",function(r) {
            if(r){
				 $.ajax({
					type:'POST',
					url:'<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/DaftarPasien/batalPeriksa'); ?>',
					data: {pendaftaran_id : pendaftaran_id,ruangan_id:ruangan_id},//
					dataType: "json",
					success:function(data){
						if(data.status == true){
							myAlert(data.pesan);
							$.fn.yiiGridView.update('daftarpasien-v-grid', {
								data: $(this).serialize() });
						}else if(data.pesan == 'exist'){
							myAlert('Pasien telah melakukan pemeriksaan');
						}else{
							myAlert(data.pesan);
						}
					},
					error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
				});
            }
        });
   }

    $(document).ready(function() {
		setPunyaTTV();
	});

}
</script>