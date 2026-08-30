<style>
    .button-status {
        margin-right: 8px;
    }
    .badge-status {
        position: relative;
        top: 8px;
        left: 8px;
    }
    .btn-status {
        min-width: 150px;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
$autoopen = Yii::app()->user->getState('isantrian'); 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Daftar Pasien</strong></div>
            </div>
            <div class="panel-body">
				<?php 
					if(isset($_GET['status'])){
						if($_GET['status'] > 0){ // Jika berhasil disimpan
							Yii::app()->user->setFlash('success',"Data pemeriksaan lab berhasil disimpan !");
						}
					}
				?>
				<?php
				//============= PRINT LABEL sebelumnya ==============
				// if(isset($_GET['caraPrint'])){
				// $pendaftaran_id = $_GET['id'];
				// $urlPrint=  Yii::app()->createAbsoluteUrl('laboratorium/pendaftaranPasienLuar/print', array('id_pendaftaran'=>$pendaftaran_id));
				// $js = <<< JSCRIPT
				// function printLabel(caraPrint)
				// {
				//     window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
				// }
				//     printLabel('PRINT');
				// JSCRIPT;
				// Yii::app()->clientScript->registerScript('printLabel',$js,CClientScript::POS_HEAD);     
				// }
				?>

				<?php
				//============= PRINT LABEL DAN TINDAKAN ==============
				if(isset($_GET['caraPrint'])){
				$pendaftaran_id = $_GET['id'];
				$id_pasienpenunjang = $_GET['idPasienPenunjang'];
				$labelOnly = 1;
				$urlPrint=  Yii::app()->createAbsoluteUrl($this->module->id.'/pendaftaranPasienLuar/print', array('id_pendaftaran'=>$pendaftaran_id,'id_pasienpenunjang'=>$id_pasienpenunjang, 'labelOnly'=>$labelOnly)); 
				$urlPrintTindakan=  Yii::app()->createAbsoluteUrl($this->module->id.'/pendaftaranLab/print', array('id_pendaftaran'=>$pendaftaran_id, 'labelOnly'=>$labelOnly)); 
$js = <<< JSCRIPT
				function printLabel(caraPrint)
				{
					window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
					window.open("${urlPrintTindakan}&caraPrint="+caraPrint,"",'location=_new, width=980px');
				}
				printLabel('PRINT');
JSCRIPT;

				Yii::app()->clientScript->registerScript('printLabel',$js,  CClientScript::POS_HEAD);
				}
				?>
				<?php
				 $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				 $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

				Yii::app()->clientScript->registerScript('cari cari', "
				$('#daftarPasien-form').submit(function(){
					$('#daftarpasien-v-grid').addClass('animation-loading');
					$.fn.yiiGridView.update('daftarpasien-v-grid', {
						data: $(this).serialize()
					});
					return false;
				});
				");
				?>
				<?php $this->widget('bootstrap.widgets.BootAlert'); ?> 
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Daftar Pasien</strong>&nbsp;<?php echo ($autoopen==true)?CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian terakhir','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'ambilAntrianTerakhir();','style'=>'font-size:10px;')):''; ?></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
						<?php
							$daftar = $modPasienMasukPenunjang->searchLab();
							if(Yii::app()->user->getState('ruangan_id')==Params::RUANGAN_ID_LAB_ANATOMI){
							  $daftar = $modPasienMasukPenunjang->searchLabAnatomi();
							}
						?>     
						<div class="block-tabel">
							<?php $this->widget('bootstrap.widgets.BootAlert');
							 $this->widget('ext.bootstrap.widgets.BootGridView',array(
									'id'=>'daftarpasien-v-grid',
									'dataProvider'=>$daftar,
									'template'=>"{summary}\n{items}\n{pager}",
									'itemsCssClass'=>'table table-bordered table-striped table-condensed',
									'replaceUrl'=>true,
									'columns'=>array(
							//            'tgl_pendaftaran',
//										array(
//											'name'=>'no_urutperiksa',
//											'type'=>'raw',
//											'header'=>'No. Antrian <br>/ Panggil Antrian',
//											'value'=>'$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>
//                                                                                                  <span class=\"badge badge-info pull-right badge-status\">".$data->jml_panggil."</span>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\",\"$data->jml_panggil\",\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\");","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini"))."<br>".
//                                                                                                  CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-ok icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"UpdateTglPelayanan(\"$data->pasienmasukpenunjang_id\");","rel"=>"tooltip","title"=>"Klik untuk Waktu Pelayanan"))',
//                                                                                        
//
//                                                                                        'visible'=>$autoopen
//										), 
                                                                                array(
											'name'=>'no_urutperiksa',
											'type'=>'raw',
											'header'=>'No. Antrian <br>/ Panggil Antrian',
											'value'=>'isset($data->waktumulaiperiksa) ? (empty($data->ruangan_singkatan)?Params::NO_MASUK_PENUNJANG_PA:$data->ruangan_singkatan)."-".$data->no_urutperiksa : (empty($data->ruangan_singkatan)?Params::NO_MASUK_PENUNJANG_PA:$data->ruangan_singkatan)."-".$data->no_urutperiksa."<br>
                                                                                                  <span class=\"badge badge-info pull-right badge-status\">".$data->jml_panggil."</span>".CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\",\"$data->jml_panggil\",\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\");","rel"=>"tooltip","title"=>"Klik Untuk Panggil Antrian"))."<br>".
                                                                                                  CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-ok icon-white\'></i>")),array("class"=>"btn btn-red","onclick"=>"UpdateTglPelayanan(\"$data->pasienmasukpenunjang_id\");","rel"=>"tooltip","title"=>"Klik Untuk Stop TAT"))',
                                                                                        

                                                                                        'visible'=>$autoopen
										), 
										array(
											'header'=>'Tgl. Pendaftaran<br/>No. Pendaftaran',
											'name'=>'tgl_pendaftaran',
											'type'=>'raw',
											'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br/>".$data->no_pendaftaran',
										),
                                        //hola tandai
										array(
											'header'=>'Tgl. Masuk Penunjang<br/>No. Penunjang',
											'name'=>'no_masukpenunjang',
											'type'=>'raw',
											//'value'=>'(($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-ubah\"></i><br/>".MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br/>".$data->no_masukpenunjang,Yii::app()->controller->createUrl("pemeriksaanPasienLaboratorium/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Pemeriksaan")) : MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br/>".$data->no_masukpenunjang)',
											'value' => function($data){
												if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO) {
													if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG){
                                                        //a
														return "<a href='#'>". MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang). "/<br/>" .$data->no_masukpenunjang. "</a>
                                                                <br>
                                                                <a href='javascript:;' onclick='printBukti($data->pasienmasukpenunjang_id)'><i class='entypo-print'></i>
                                                                </a>";
                                                                // ". Yii::app()->controller->createUrl('daftarPasien/buktiPelayananPenunjang', ['pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id]) ."
													}else {
                                                        // b
														return (($data->statusperiksahasil != "SUDAH") ? 
                                                            "<a href='javascript:; rel='tooltip' onclick='myAlert('Anda tidak dapat menginput hasil pemeriksan, karena status pasien'".$data->statusperiksa.", 'Perhatian !')'>
                                                                <i class='icon-form-ubah'></i>
                                                                ". MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang). "<br>".$data->no_masukpenunjang."
                                                                </a>
                                                            <br>
                                                            <a href='javascript:;' onclick='printBukti($data->pasienmasukpenunjang_id)'> <i class='entypo-print'></i> </a>
                                                            "
                                                            : 
                                                            CHtml::link(
                                                                MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "<br/>" . $data->no_masukpenunjang . "<br> <i class='entypo-print'></i>",
                                                                'javascript:;', 
                                                                ['onclick' => "printBukti($data->pasienmasukpenunjang_id)"]
                                                            )
                                                        );											
													}
												}else{
                                                    // c
													return (($data->statusperiksahasil != "SUDAH") ? 
                                                        "<a data-original-title='Klik Untuk Mengubah Pemeriksaan' href=". Yii::app()->controller->createUrl("pemeriksaanPasienLaboratorium/index", ["pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id]) .">
                                                            <i class='icon-form-ubah'></i>
                                                            <br/>
                                                            ".MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."
                                                            <br/>
                                                            ".$data->no_masukpenunjang."
                                                        </a>
                                                        <br>
                                                        <a href='javascript:;' onclick='printBukti($data->pasienmasukpenunjang_id)'> <i class='entypo-print'></i> </a>"
                                                        : 
                                                        CHtml::link(
                                                            MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "<br/>" . $data->no_masukpenunjang . "<br> <i class='entypo-print'></i>",
                                                            'javascript:;', 
                                                            ['onclick' => "printBukti($data->pasienmasukpenunjang_id)"]
                                                        )
                                                        // CHtml::link(
                                                        //     MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)."<br/>".$data->no_masukpenunjang, 
                                                        //     Yii::app()->controller->createUrl("pemeriksaanPasienLaboratorium/index"), ["pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id]
                                                        // )
                                                    );												
												}
											}
										),
										array(
											'header'=>'Ruangan/<br/>Dokter Perujuk',
											'name'=>'ruanganasal_nama',
											'type'=>'raw',
											'value'=>function($data) {
												$pegawai = PegawaiM::model()->findByAttributes(array(
													'nama_pegawai'=>$data->nama_dokterasal,
												));
												return $data->ruanganasal_nama."/<br/>".(empty($pegawai)?"-":$pegawai->namaLengkap);
											},
										),
										array(
											'name'=>'no_rekam_medik',
											'type'=>'raw',
											'header'=>'No. RM',
											'value'=>'$data->no_rekam_medik',
										),
										array(
											'header'=>'Nama Pasien',
											'type'=>'raw',
							//                'value'=> '((substr($data->no_rekam_medik,0,-6)) == "LB" || (substr($data->no_rekam_medik,0,-6)) == "RD" ? CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->nama_pasien.\' / \'.$data->nama_bin, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->nama_pasien.\' / \'.$data->nama_bin )',
											'value'=> '(($data->instalasiasal_id == '.PARAMS::INSTALASI_ID_LAB_PA.') ? CHtml::link("<i class=\"icon-form-ubah\"></i> ".$data->namadepan.$data->nama_pasien, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id","pendaftaran_id"=>"$data->pendaftaran_id","modul_id"=>"'.Yii::app()->session['modul_id'].'")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->namadepan.$data->nama_pasien )',
										),
										array(
											'header'=>'Jenis Kelamin/<br/>Umur',
											'type'=>'raw',
											'value'=>'$data->jeniskelamin."/<br/>".$data->umur',
										),
										'alamat_pasien',

										array(
											'header'=>'Jenis Penjamin /<br/> Penjamin',
											'name'=>'CaraBayarPenjamin',
											'type'=>'raw',
											'value'=>'$data->caraBayarPenjamin',    
											'htmlOptions'=>array('style'=>'text-align: left; width:40px')
										),
//										array(
//											'header' => 'Status Periksa',
//											'type' => 'raw',
//											'value' => function ($data){
//												return Params::getWrStatusPeriksa($data->statusperiksa);
//											}
//										), 
                                                                                                
                                                                                array(
                                                                                    'header'=>'DPJTM',
                                                                                    'type'=>'raw',
                                                                                    'value'=>function($data) {
                                                                                        if(isset($data->pegawai_id)) {
                                                                                          return CHtml::link(
                                                                                            $data->getNamaLengkapDokter($data->pegawai_id),
                                                                                            Yii::app()->controller->createUrl("daftarPasien/UbahDokterDPJTM", array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),
                                                                                            array("rel"=>"tooltip",
                                                                                                "title"=>"Klik untuk mengubah DPJTM",
                                                                                                "target"=>"iframeUbahDokterDPJTM",
                                                                                                "onclick"=>"$(\"#dialogDokterDPJTM\").dialog(\"open\");",
                                                                                            )
                                                                                        );
                                                                                        }else{
                                                                                           return CHtml::link(
                                                                                            '<i style="font-size:20px" class="entypo-pencil"></i>',
                                                                                            Yii::app()->controller->createUrl("daftarPasien/UbahDokterDPJTM", array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),
                                                                                            array("rel"=>"tooltip",
                                                                                                "title"=>"Klik untuk menambahkan DPJTM",
                                                                                                "target"=>"iframeUbahDokterDPJTM",
                                                                                                "onclick"=>"$(\"#dialogDokterDPJTM\").dialog(\"open\");",
                                                                                            )
                                                                                        ); 
                                                                                        }
                                                                                    }
                                                                                ),
                                                                                array(
											'header' => 'Status Periksa Pasien',
											'type' => 'raw',
//											'value' => function ($data){
////												return Params::getWrStatusPeriksa($data->statusperiksa); 
////                                                                                                return 
//											} 
                                                                                        'value' => '$data->getStatusLabPA($data->statusperiksa,$data->pendaftaran_id,$data->pasienmasukpenunjang_id)',
                                                                                        'headerHtmlOptions' => array('style'=>'width:170px !important')
										),
										array(
											'header'=>'Status Hasil Pemeriksaan',
											'type'=>'raw',
                                                                                        'htmlOptions' => array('style' => 'text-align: center; min-width:150px;vertical-align:middle;'),
                                                                    //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->statusperiksahasil,Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/CancelPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan", "onclick"=>"return confirm(\"Apakah anda akan membatalkan pemeriksaan ini?\");")) : ((empty($data->pasienbatalperiksa_id)) ? $data->statusperiksahasil : "DIBATALKAN")',
											'value'=>function($data){
												/*if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG){
													return Params::getWrStatusHasil($data->statusperiksahasil);
												}else{
													return ($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>".$data->statusperiksahasil, "javascript:batalstatusperiksa(".$data->pendaftaran_id.",".$data->pasienmasukpenunjang_id.")",array("rel"=>"tooltip","title"=>"Klik untuk membatalkan varifikasi hasil pemeriksaan")) : ((empty($data->pasienbatalperiksa_id)) ? Params::getWrStatusHasil($data->statusperiksahasil) : "DIBATALKAN");
												}*/
                                                                                                $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                                                                                $hasil = LBHasilPemeriksaanPAT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id));
                                                                                                $statcol = array(
                                                                                                    Params::STATUSPERIKSAHASIL_BELUM => 'red',
                                                                                                    Params::STATUSPERIKSAHASIL_SEDANG => 'gold',
                                                                                                    Params::STATUSPERIKSAHASIL_SUDAH => 'green',
                                                                                                    '' => 'red'
                                                                                                );
                                                                                                
                                                                                                $style_btn = "margin-top:-15px;";
                                                                                                        
                                                                                                if(!empty($hasil)){
                                                                                                    if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                                                                                        $btnSudah = CHtml::htmlButton($hasil->statusperiksahasil, array(
                                                                                                                    'class' => 'span2 btn btn-' . $statcol[$hasil->statusperiksahasil],
                                                                                                        ));
                                                                                                        return $btnSudah;
                                                                                                    } else {

                                                                                                        $btnSudah = CHtml::htmlButton(empty($hasil->statusperiksahasil) ? Params::STATUSPERIKSAHASIL_BELUM : $hasil->statusperiksahasil, array(
                                                                                                                    'class' => 'btn btn-' . $statcol[$hasil->statusperiksahasil],
                                                                                                                    'style' => 'width: 79px',
                                                                                                        ));
                                                                                                        if($hasil->statusperiksahasil != PARAMS::STATUSPERIKSAHASIL_SUDAH){
                                                                                                            $btnBatal = CHtml::htmlButton('<i class="entypo-cancel"></i>', array(
                                                                                                                    'class' => 'btn btn-' . $statcol[$hasil->statusperiksahasil],
                                                                                                                    'onclick' => "dialogBatalPeriksa(" . $data->pendaftaran_id . "," . $data->pasienmasukpenunjang_id . ",'" . $data->nama_pasien . "');",
                                                                                                                    "rel" => "tooltip",
                                                                                                                    "title" => "Klik untuk membatalkan pemeriksaan.",
                                                                                                                    'style' => 'width: 45px',
                                                                                                            ));
                                                                                                        }else{
                                                                                                            $btnBatal = '';
                                                                                                        }

                                                                                                        $btnStatusBatal = '<button class="btn btn-red nohover span2">DIBATALKAN</button>';

                                                                                                        return empty($data->pasienbatalperiksa_id) ? '<div class="btn-group" style="'.$style_btn.'">' . $btnSudah . $btnBatal. '</div>' : $btnStatusBatal;
                                                                                                    }
                                                                                                }else{
                                                                                                    $btnSudah = CHtml::htmlButton('BELUM', array(
                                                                                                                    'style' => 'width: 79px',
                                                                                                                    'class' => 'span2 btn btn-red',
                                                                                                        ));
                                                                                                    $btnBatal = CHtml::htmlButton('<i class="entypo-cancel"></i>', array(
                                                                                                                    'class' => 'btn btn-red',
                                                                                                                    'onclick' => "dialogBatalPeriksa(" . $data->pendaftaran_id . "," . $data->pasienmasukpenunjang_id . ",'" . $data->nama_pasien . "');",
                                                                                                                    "rel" => "tooltip",
                                                                                                                    "title" => "Klik untuk membatalkan pemeriksaan.",
                                                                                                                    'style' => 'width: 45px',
                                                                                                        ));

                                                                                                        $btnStatusBatal = '<button class="btn btn-red nohover span2">DIBATALKAN</button>';

                                                                                                        return empty($data->pasienbatalperiksa_id) ? '<div class="btn-group" style="'.$style_btn.'">' . $btnSudah . $btnBatal . '</div>' : $btnStatusBatal;
                                                                                                }
											},
										),
							//            array(
							//                'header'=>'Status Print',
							//                'type'=>'raw',
							//                'value'=>'($data->printhasillab == true) ? "SUDAH" : "BELUM"',
							                    
										 array(
											'name'=>'ambilSample',
											'type'=>'raw',
											'value'=>function($data) use ($module, $controller){
												if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO){
													if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO){
														return CHtml::link("<span style='font-size:15px;'><i class='icon-form-ambilsample'></i></span>",'javascript:;',array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Ambil Sample",'onclick'=>'myAlert("Anda tidak dapat menginput ambil sample, karena status pasien '.$data->statusperiksa.'","Perhatian !")'));    
													}elseif ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG){
														return CHtml::link("<span style='font-size:15px;'><i class='icon-form-ambilsample'></i></span>",Yii::app()->controller->createUrl('/'.$module.'/'.$controller.'/updateSample',array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Ambil Sample"));    
													}
												}else{
													return ($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<span style='font-size:15px;'><i class='icon-form-ambilsample'></i></span>",Yii::app()->controller->createUrl('/'.$module.'/'.$controller.'/updateSample',array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Ambil Sample")) : CHtml::link("<i class='icon-form-ambilsample'></i>",'javascript:;',array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Ambil Sample",'onclick'=>'myAlert("Anda tidak dapat menginput ambil sample karena status pemeriksaan hasil sudah di verifikasi ","Perhatian !")'));    ;    
												}
											},
															 //dicomment RND-5771
							//                'value'=>'($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/updateSample",array("pendaftaran_id"=>$data->pendaftaran_id,"idPengambilanSample"=>$data->pengambilansample_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Mengubah Ambil Sample")) : ""',    
											'htmlOptions'=>array('style'=>'text-align: left; width:40px')
										),
							//             array(
							//                'name'=>'masukanHasil',
							//                'type'=>'raw',
							//                'value'=>'(($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG || $data->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM) ? CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan")) 
							//                  : 
							//                  CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab Anatomi")))',    
							//                'htmlOptions'=>array('style'=>'text-align: left; width:40px')
							//            ),
										//TEST NEW
										 array(
											'name'=>'masukanHasil',
											'type'=>'raw',
											'value'=>function($data){
                                                                                                $hasil = LBHasilPemeriksaanPAT::model()->findByAttributes(array('pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id));
												if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG || $data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO){
													if ($data->statusperiksa == Params::STATUSPERIKSA_NUNGGU_DAFTAR_SO){
														return CHtml::link("<span style='font-size:15px;'><i class='icon-form-input'></i></span>","javascript:;",array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab", 'onclick'=>'myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien '.$data->statusperiksa.'","Perhatian !")'));
													}else{
														return CHtml::link("<span style='font-size:15px;'><i class='icon-form-input'></i></span>",Yii::app()->controller->createUrl("/laboratoriumPA/pencatatanHasilPemeriksaan/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab"));
													}
												}else{
                                                                                                        if(!empty($hasil)){
                                                                                                            return (($hasil->statusperiksahasil != "SUDAH") ? CHtml::link("<span style='font-size:15px;'><i class='icon-form-input'></i></span>",Yii::app()->controller->createUrl("/laboratoriumPA/pencatatanHasilPemeriksaan/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab")) : CHtml::link("<i class='icon-form-input'></i>",'javascript:;',array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab",'onclick'=>'myAlert("Anda tidak dapat input hasil pemeriksaan karena sudah di verifikasi ","Perhatian !")')));
                                                                                                        }else{
                                                                                                            return CHtml::link("<span style='font-size:15px;'><i class='icon-form-input'></i></span>",Yii::app()->controller->createUrl("/laboratoriumPA/pencatatanHasilPemeriksaan/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Masukan Hasil Pemeriksaan Lab"));
                                                                                                        }
												}
											},
											'htmlOptions'=>array('style'=>'text-align: left; width:40px')
										),
										array(
											'header'=>'Lihat Hasil',
											'type'=>'raw',
                                                                                        'value'=>function($data){
                                                                                            if (Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_LAB_KLINIK){
                                                                                                return CHtml::Link("<span style='font-size:15px'><i class='icon-form-lihat'></i></span>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/print",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
													array("class"=>"", 
														"target"=>"iframeLihatHasil",
														"onclick"=>"$('#dialogLihatHasil').dialog('open');",
														"rel"=>"tooltip",
														"title"=>"Klik untuk melihat hasil pemeriksaan", 
													));
                                                                                            }else{												  
												return CHtml::Link("<span style='font-size:15px;'><i class='icon-form-lihat'></i></span>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/PrintPA",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
													array("class"=>"", 
														"target"=>"iframeLihatHasil",
														"onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
														"rel"=>"tooltip",
														"title"=>"Klik untuk melihat hasil pemeriksaan", 
													));
                                                                                            }												
                                                                                        },
											'htmlOptions'=>array('style'=>'text-align: left; width:40px')

							//                'value'=>'CHtml::Link("<i class=\"icon-file-silver\"></i>",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/Details",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id, "popup"=>"true")),
							//                            array("class"=>"", 
							//                                  "target"=>"iframeLihatHasil",
							//                                  "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
							//                                  "rel"=>"tooltip",
							//                                  "title"=>"Klik untuk melihat hasil pemeriksaan", 
							//                            ))','htmlOptions'=>array('style'=>'text-align: left; width:40px')
										),
                                                                                array(
                                                                                    'header' => 'Verifikasi Hasil Pemeriksaan',
                                                                                    'type' => 'raw',
                                                                                    'value' => function ($data) {
                                                                                        return $data->getVerifikasiPA($data->pasienmasukpenunjang_id);
                                                                                    },
                                                                                    'htmlOptions'=>array('style'=>'text-align: center;'),
                                                                                    'headerHtmlOptions'=>array('style'=>'text-align: center;')
                                                                                ),
                                                                                array(
                                                                                    'header' => 'Pengambilan Hasil',
                                                                                    'type' => 'raw',
                                                                                    'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                                                                                    'value' => function($data) {
                                                                                        /* fungsi untuk pengambilan hasil   */
                                                                                        
                                                                                        $criteria = new CDbCriteria;
                                                                                        $criteria->addCondition("pasienmasukpenunjang_id = ".$data->pasienmasukpenunjang_id);
                                                                                        $criteria->addCondition("nama_pengambilhasil IS NOT NULL");
                                                                                                
                                                                                        $modHasilPemeriksaan = HasilpemeriksaanpaT::model()->findAll($criteria);
                                                                                        
                                                                                        $modHasilPemeriksaanLab = HasilpemeriksaanpaT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id));
                                                                                        
                                                                                        if (!empty($modHasilPemeriksaanLab)) {
                                                                                            if (count($modHasilPemeriksaan) > 0) {
                                                                                                $buttonpengambilanhasil = CHtml::Link("<span style='font-size:15px; color: #0B6623'><i class=\"fa fa-user\"></i></span>", Yii::app()->controller->createUrl("daftarPasien/PengambilanHasil", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "frame" => 1, "popup" => "true")), array("class" => "",
                                                                                                            "target" => "iframePengambilanHasil",
                                                                                                            "onclick" => "$(\"#dialogPengambilanHasil\").dialog(\"open\");",
                                                                                                            "rel" => "tooltip",
                                                                                                            "title" => "Klik untuk pengambilan hasil",
                                                                                                ));
                                                                                            } else {
                                                                                                $buttonpengambilanhasil = CHtml::Link("<span style='font-size:15px;'><i class=\"fa fa-user\"></i></span>", Yii::app()->controller->createUrl("daftarPasien/PengambilanHasil", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "frame" => 1, "popup" => "true")), array("class" => "",
                                                                                                            "target" => "iframePengambilanHasil",
                                                                                                            "onclick" => "$(\"#dialogPengambilanHasil\").dialog(\"open\");",
                                                                                                            "rel" => "tooltip",
                                                                                                            "title" => "Klik untuk pengambilan hasil",
                                                                                                ));
                                                                                            }
                                                                                        } else {
                                                                                            $buttonpengambilanhasil = CHtml::Link("<span style='font-size:15px; '><i class=\"fa fa-user\"></i></span>", Yii::app()->controller->createUrl("daftarPasien/PengambilanHasil", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "frame" => 1, "popup" => "true")), array("class" => "",
                                                                                                        "onclick" => "myAlert(\"Pasien Belum Memiliki Detail Pemeriksaan\"); return false",
                                                                                                        "rel" => "tooltip",
                                                                                                        "title" => "Klik untuk pengambilan hasil",
                                                                                            ));
                                                                                        }

                                                                                        return $buttonpengambilanhasil;
                                                                                    }
                                                                                ),
										/*array(
										   'header'=>'Batal Periksa',
										   'type'=>'raw',
										   'value'=>function($data){
													if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG){
														return CHtml::link("<i class='icon-form-silang'></i>","javascript:;",array("rel"=>"tooltip","title"=>"Klik Untuk membatalkan pasien", 'onclick'=>'myAlert("Anda tidak dapat menginput hasil pemeriksan, karena status pasien '.$data->statusperiksa.'","Perhatian !")','data-placement'=>'left'));
													}else{
														//return ($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(".$data->pendaftaran_id.",".$data->pasienmasukpenunjang_id.")",array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan","data-placement"=>"left")) : null;
														return ($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class='icon-form-silang'></i>", 'javascript:dialogBatalPeriksa('.$data->pendaftaran_id.','.$data->pasienmasukpenunjang_id.',"'.$data->nama_pasien.'")',array("id"=>$data->no_pendaftaran,"rel"=>"tooltip","title"=>"Klik untuk membatalkan pasien","data-placement"=>"left")) : CHtml::link("<i class='icon-form-silang'></i>",'javascript:;',array("rel"=>"tooltip","title"=>"Klik Untuk membatalkan pasien",'onclick'=>'myAlert("Anda tidak dapat menginput ambil sample karena status pemeriksaan hasil sudah di verifikasi ","Perhatian !")', 'data-placement'=>'left'));
													}
										   },
										   'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
										),*/

									),
									'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
							)); ?>
						</div>
						<?php 
						// Dialog untuk Lihat Hasil =========================
						$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
							'id'=>'dialogLihatHasil',
							'options'=>array(
                                                            'title'=>'Hasil Pemeriksaan Laboratorium',
                                                            'autoOpen'=>false,
                                                            'modal'=>true,
                                                            'minWidth'=>980,
                                                            'minHeight'=>450,
                                                            'resizable'=>true,
                                                            'close'=>"js:function(){ 
                                                                $.fn.yiiGridView.update('daftarpasien-v-grid');
                                                            }",
							),
						));
						?>
						<iframe src="" name="iframeLihatHasil" width="100%" height="500">
						</iframe>

						<?php
						$this->endWidget();
						//========= end Lihat Hasil =============================
						?>
                        
                                                <?php
                                                // Dialog untuk Pengambilan Hasil =========================
                                                $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                                    'id' => 'dialogPengambilanHasil',
                                                    'options' => array(
                                                        'title' => 'Pengambilan Hasil',
                                                        'autoOpen' => false,
                                                        'modal' => true,
                                                        'minWidth' => 550,
                                                        'minHeight' => 450,
                                                        'resizable' => true,
                                                        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid'); }",
                                                    ),
                                                ));
                                                ?>
                                                <iframe src="" name="iframePengambilanHasil" width="100%" height="500">
                                                </iframe>

                                                <?php
                                                $this->endWidget();
                                                //========= end Pengambilan Hasil =============================
                                                ?>
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
						<?php
						 //CHtml::link($text, $url, $htmlOptions)
						$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
								'action'=>Yii::app()->createUrl($this->route),
								'method'=>'get',
								'id'=>'daftarPasien-form',
								'type'=>'horizontal',
								'focus'=>'#'.CHtml::activeId($modPasienMasukPenunjang, 'no_rekam_medik'),
								'htmlOptions'=>array(),

						)); ?>
						<div class="row-fluid">
							<div class="col-sm-6">
								<div class="control-group">		
									<?php echo CHtml::label("Tanggal Masuk Penunjang",'tglmasukpenunjang', array('class' => 'control-label')) ?>
									<div class="controls">
										<div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?>">
											<i class="entypo-calendar"></i>
											<span ><?php echo date('F d, Y', strtotime($modPasienMasukPenunjang->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($modPasienMasukPenunjang->tgl_akhir)) ?></span>
											<?php echo $form->hiddenField($modPasienMasukPenunjang,'tgl_awal', array('class' => 'start')) ?>
											<?php echo $form->hiddenField($modPasienMasukPenunjang,'tgl_akhir', array('class' => 'end')) ?>
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Status Permeriksaan</label>
									<div class="controls">
										<?php // echo $form->textField($modPasienMasukPenunjang,'statusperiksahasil',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
										<?php echo $form->dropDownList($modPasienMasukPenunjang,'statusperiksahasil',  CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'statusperiksahasil', 'lookup_aktif'=>true)), 'lookup_value', 'lookup_name'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
									</div>
								</div>
								<div class="control-group">
								<?php echo CHtml::label('No. Pendaftaran','no_pendaftaran', array('class'=>'control-label')) ?>                        
									<div class="controls">
										<?php 
											$prefix = array(
												0 => Params::PREFIX_RAWAT_DARURAT,
												1 => Params::PREFIX_RAWAT_INAP,
												2 => Params::PREFIX_RAWAT_JALAN,
												3 => Params::PREFIX_LABORATORIUM
											);
											echo $form->dropDownList($modPasienMasukPenunjang,'prefix_pendaftaran', PendaftaranT::model()->getColumn($prefix),array('class'=>'numbers-only', 'style'=>'width:75px;')); 
										?>
										<?php echo $form->textField($modPasienMasukPenunjang, 'no_pendaftaran', array('class' => 'span2 numbers-only', 'maxlength' => 10,'placeholder'=>'Ketik No. Pendaftaran')); ?>                                                                
									</div>                                                
								</div>                    
								
								<div class="control-group">
									<label class="control-label">No. Rekam Medik</label>
									<div class="controls">
										<?php echo $form->textField($modPasienMasukPenunjang,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>8)); ?>
									</div>
								</div>
								<?php echo $form->textFieldRow($modPasienMasukPenunjang,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>								
								<?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'nama_dokterasal', DokterV::model()->getDropDokterResepByNama(),array('multiple'=>'multiple')) ?>
							</div>
							<div class="col-sm-6">
								
								
																
								
								<?php
									$instalasi = InstalasiM::model()->findAllByAttributes(array(
										'instalasi_id' => array(2,3,4),
									));
									$ruangan = RuanganM::model()->findAllByAttributes(array(
										'instalasi_id' => array(2,3,4),
										'ruangan_aktif' => true,
									), array(
										'order'=>'instalasi_id, ruangan_nama',
									));
									echo $form->dropDownListRow($modPasienMasukPenunjang,'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
										'empty'=>'-- Pilih --',
										'class'=>'span3', 
										'ajax' => array('type'=>'POST',
											'url'=> $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal',array('encode'=>false,'namaModel'=>get_class($modPasienMasukPenunjang))), 
											'success'=>'function(data){$("#'.CHtml::activeId($modPasienMasukPenunjang, "ruanganasal_id").'").html(data); }',
										),
									 ));
									echo $form->dropDownListRow($modPasienMasukPenunjang,'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

								?>
								<?php 
									$carabayar = CarabayarM::model()->findAll(array(
										'condition'=>'carabayar_aktif = true',
										'order'=>'carabayar_nourut',
									));
									foreach ($carabayar as $idx=>$item) {
										$penjamins = PenjaminpasienM::model()->findByAttributes(array(
											'carabayar_id'=>$item->carabayar_id,
											'penjamin_aktif'=>true,
									   ));
									   if (empty($penjamins)) unset($carabayar[$idx]);
									}
									$penjamin = PenjaminpasienM::model()->findAll(array(
										'condition'=>'penjamin_aktif = true',
										'order'=>'penjamin_nama',
									));
									echo $form->dropDownListRow($modPasienMasukPenunjang,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
										'empty'=>'-- Pilih --',
										'class'=>'span3', 
										'ajax' => array('type'=>'POST',
											'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($modPasienMasukPenunjang))), 
											'success'=>'function(data){$("#'.CHtml::activeId($modPasienMasukPenunjang, "penjamin_id").'").html(data); }',
										),
									 ));
									echo $form->dropDownListRow($modPasienMasukPenunjang,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));
								?>		
								<?php echo $form->dropDownListRow($modPasienMasukPenunjang, 'statusperiksa',  LookupM::getItems('statusperiksa'),array('empty' => '-- Pilih --', 'class'=>'span3')) ?>
							</div>
						</div>															
                    </div>
                </div>
				<div class="form-actions">
					<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="'.MyIcon::getIcons('cari').'"></i>')),
						array('autofocus' => true, 'class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
					?>
					<?php
                                        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                                        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai       
                                        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), Yii::app()->createUrl('/' . $module . '/' . $controller . '/index', array()), array('class' => 'btn btn-danger',
                                            'onclick' => 'if(!myConfirm("Apakah Anda yakin ingin mengulang Informasi ini ?")) return false;'));
                                        ?>
                                        <?php 
						$content = $this->renderPartial('../tips/informasi',array(),true);
						$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
				</div>
				<?php $this->endWidget();?>
				<iframe id="suarapanggilan" src="" style="display: none;"></iframe>				
            </div>
        </div>
    </div>
</div> 

 <?php 
 // ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'DialogBatalperiksa',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
                        'autoOpen'=>false,
                        'show'=>'blind',
                        'hide'=>'explode',
                        'zIndex'=>1002,
                        'minWidth'=>500,
                        'minHeight'=>100,
                        'resizable'=>false,
                        'modal'=>true,    
                         ),
                    ));
$this->renderPartial('_formBatalPeriksaDialog');                    

$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================

?>

<?php
   // Dialog dokter DPJTM =========================
   $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogDokterDPJTM',
                'options'=>array(
                    'title'=>'Ubah DPJTM',
                    'autoOpen'=>false,
                    'modal'=>true,
                    'minWidth'=>950,
                    'minHeight'=>450,
                    'resizable'=>true,
                    'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid'); }",

                    ),
   ));
    ?>
    <iframe src="" name="iframeUbahDokterDPJTM" width="100%" height="500">
    </iframe>

    <?php
    $this->endWidget();
    //========= end Ubah Dokter =============================
    ?>
<script type="text/javascript">
    
    //print bukti 
    function printBukti(pasienmasukpenunjang_id) {
        window.open('<?php echo $this->createUrl('/laboratorium/PemakaianBahan/PrintBukti'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=480,height=640');
    }

    function batalstatusperiksa(pendaftaran_id,idPenunjang)
    {
       myConfirm('Apakah anda akan membatalkan status pemeriksaan ini?', 'Perhatian!', function(r)
       {
           if(r){
                $.post('<?php echo Yii::app()->createUrl('laboratoriumPA/daftarPasien/CancelPemeriksaanAjax')?>',{pendaftaran_id:pendaftaran_id,idPenunjang:idPenunjang},
                          function(data){
                              if(data.status == 'ok'){
                                  window.location = "<?php echo Yii::app()->createUrl('laboratoriumPA/daftarPasien/index&status=1')?>";
                              }else{
                                  if(data.status == 'gagal')
                                  {
                                      myAlert('Pembatalan pemeriksaan gagal');
                                  }

                              }
                          },'json'
                      );
            }
       });
    }

    function approveperiksa(pendaftaran_id,idPenunjang)
    {
       myConfirm('Apakah Anda akan menyetujui pemeriksaan ini?', 'Perhatian!', function(r)
       {
           if(r){
                $.post('<?php echo Yii::app()->createUrl('laboratoriumPA/daftarPasien/ApprovePemeriksaanAjax')?>',{pendaftaran_id:pendaftaran_id,idPenunjang:idPenunjang},
                          function(data){
                              if(data.status == 'ok'){
                                  window.location = "<?php echo Yii::app()->createUrl('laboratoriumPA/daftarPasien/index&status=1')?>";
                              }else{
                                  if(data.status == 'gagal')
                                  {
                                      myAlert('Pemeriksaan gagal disetujui');
                                  }

                              }
                          },'json'
                      );
            }
       });
    }

    function batalperiksa(pendaftaran_id,idPenunjang)
    {
       myConfirm('Anda yakin akan membatalkan pemeriksaan laboratorium pasien ini?', 'Perhatian!', function(r)
       {
            if(r){
                $.post('<?php echo Yii::app()->createUrl('laboratoriumPA/daftarPasien/batalPenunjang')?>',{pendaftaran_id:pendaftaran_id,idPenunjang:idPenunjang},
                          function(data){
                              if(data.status == 'ok'){
                                /*
                                if(data.smspasien==0){
                                  var params = [];
                                  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                                  insert_notifikasi(params);
                                }
                                */
                                if (data.pesan == 'exist') {
                                    myAlert(data.keterangan);
                                } else {
                                    //window.location = "<?php //echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')?>";
									$.fn.yiiGridView.update('daftarpasien-v-grid', {
										data: $(this).serialize()
									});									
                                }
                              }else{
                                  if(data.status == 'exist')
                                  {
                                      myAlert('Pasien telah melakukan pemeriksaan');
                                  }

                              }
                          },'json'
                      );
            }else{
         //       myAlert('tidak');
            }
       });
    }
    function ambilAntrianTerakhir(){
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
            dataType: "json",
            success:function(data){
                if(data.pesan == ""){
                    panggilAntrian(data.pasienmasukpenunjang_id);
                    setSuaraPanggilanSingle(data.ruangan_singkatan,data.no_urutperiksa,data.ruangan_id);
                }else{
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    } 

 /**
     * memanggil antrian ke poliklinik
     * @param {type} pendaftaran_id
     * @returns {undefined} */
    function panggilAntrian(pasienmasukpenunjang_id,jml_panggil,kodeantrian,noantrian,ruangan_id){ 

        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('Panggil'); ?>',
            data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id,jml_panggil:jml_panggil},
            dataType: "json",
            success:function(data){
//                if(data.sukses == true ){
//                    setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id)
//                }else{
//                    myAlert(data.pesan);
//                } 
                if (data.pesan !== "") {
		     myAlert(data.pesan); 
//                     setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id)
		}
                if(data.smspasien==0){
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
                    insert_notifikasi(params);
                } 
                <?php if(Yii::app()->user->getState('is_nodejsaktif')){ ?>
                socket.emit('send',{conversationID:'antrianSpecimenLab',panggil:1,antrian_id:pasienmasukpenunjang_id,loket_id:ruangan_id});
                <?php } ?>
                $.fn.yiiGridView.update('daftarpasien-v-grid'); 
                
               
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    } 
    



    /**
     * suara panggilan per ruangan
     * @param {type} param
     * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
     */
    function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id){
        $("#suarapanggilan").attr("src","<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian="+kodeantrian+"&noantrian="+noantrian+"&ruangan_id="+ruangan_id);
    }
    //    if(alasan==''){
    //        myAlert('Anda Belum Mengisi Alasan Pembatalan');
    //    }else{
    //        $.post('<?php //echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap');?>', $('#formAlasan').serialize(), function(data){
    ////            if(data.error != '')
    ////                myAlert(data.error);
    ////            $('#'+data.cssError).addClass('error');
    //            if(data.status=='success'){
    //                batal();
    //                myAlert('Data Berhasil Disimpan');
    //                location.reload();
    //            }else{
    //                myAlert(data.status);
    //            }
    //        }, 'json');
    //   }     

	$(document).ready(function(){
		jQuery($("#<?php echo CHtml::activeId($modPasienMasukPenunjang, 'nama_dokterasal') ?>")).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '150px',
                enableCaseInsensitiveFiltering: true
        }).hide();	
	});
	
	/**
	* 
	* @param {type} pendaftaran_id
	* @param {type} statusperiksa
	* @param {type} namaPasien
	* @returns {undefined}
	*/
   function dialogBatalPeriksa(pendaftaran_id,penunjang_id,namaPasien)
   {
	   $('#titleNamaPasienBatal').html(namaPasien);
	   $('#DialogBatalperiksa #pendaftaran_id').val(pendaftaran_id);
	   $('#DialogBatalperiksa #penunjang_id').val(penunjang_id);
	   $('#DialogBatalperiksa').dialog('open');
   } 
   
   function ubahPeriksaKarenaBatal(){				
		var pendaftaran_id=$('#DialogBatalperiksa #pendaftaran_id').val(); 
		var penunjang_id=$('#DialogBatalperiksa #penunjang_id').val(); 
		var tglbatal=$('#DialogBatalperiksa #tglbatal').val();
		var keterangan_batal=$('#DialogBatalperiksa #keterangan_batal').val();
		  
		$('#DialogBatalperiksa #keterangan_batal').attr('class','');
		if (keterangan_batal == ''){
			myAlert("Alasan Pembatalan Pasien Ini, wajib diisi");
			$('#DialogBatalperiksa #keterangan_batal').attr('class','error');
			return false;
		}
		  
		$.ajax({
			type:'POST',
			url:'<?php echo $this->createUrl('batalPenunjang'); ?>',
			data: {pendaftaran_id: pendaftaran_id,tglbatal:tglbatal,keterangan_batal:keterangan_batal,idPenunjang:penunjang_id},//
			dataType: "json",
			success:function(data){
				if(data.status == 'ok'){
					/*
					if(data.smspasien==0){
					  var params = [];
					  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
					  insert_notifikasi(params);
					}
					*/
					if (data.pesan == 'exist') {
						myAlert(data.keterangan);
					} else {
						//window.location = "<?php echo Yii::app()->createUrl('laboratorium/daftarPasien/index&status=1')?>";
						$.fn.yiiGridView.update('daftarpasien-v-grid', {
							data: $(this).serialize()
						});
						$('#DialogBatalperiksa #keterangan_batal').val('');
						$('#DialogBatalperiksa').dialog('close');
					}
				  }else{
					  if(data.status == 'exist')
					  {
						  myAlert('Pasien telah melakukan pemeriksaan');
					  }

				  }
			},
			error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
		});
		  
   } 
   
    function UpdateTglPelayanan(pasienmasukpenunjang_id) {
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('UpdateTglPelayanan'); ?>',
                data: {pasienmasukpenunjang_id:pasienmasukpenunjang_id},
                dataType: "json",
                    success:function(data){
                        if(data.status == true){
                             $.fn.yiiGridView.update('daftarpasien-v-grid');
                        }else{
                            myAlert(data.pesan);	
                        }	
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	}); 
    }
    
    function verifikasi(pasienmasukpenunjang_id, jenis_verifikasi) {
        myConfirm('Apakah anda menyetujui pemeriksaan pasien ini?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('cekVerifikasi'); ?>',
                    data: {pasienmasukpenunjang_id: pasienmasukpenunjang_id, jenis_verifikasi: jenis_verifikasi},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == true) {
                            $.fn.yiiGridView.update('daftarpasien-v-grid');
                        } else {
                            myAlert(data.pesan);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        myAlert("Terjadi kesalahan");
                    }
                });
            }
        });
    }

    function batalVerifikasi(pasienmasukpenunjang_id, jenis_verifikasi) {
        myConfirm('Apakah anda yakin untuk membatalkan verifikasi pasien ini?', 'Perhatian!', function (r) {
            if (r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('BatalVerifikasi'); ?>',
                    data: {pasienmasukpenunjang_id: pasienmasukpenunjang_id, jenis_verifikasi: jenis_verifikasi},
                    dataType: "json",
                    success: function (data) {
                        if (data.status == true) {
                            $.fn.yiiGridView.update('daftarpasien-v-grid');
                        } else {
                            myAlert(data.pesan);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                        myAlert("Terjadi kesalahan");
                    }
                });
            }
        });
    }

    </script>
