<style>
    .btn-status {
        width: 150px;
    }
</style>
<?php
/**
 * view utama menampilkan menu informasi daftar pasien
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$modul = $this->module->name;
$control = $this->id;
Yii::app()->clientScript->registerScript('cari wew', "
$('#daftarPasien-form').submit(function(){
	$.fn.yiiGridView.update('daftarpasien-v-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Daftar Pasien</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Daftar Pasien</b> <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon}', array(
                                '{icon}' => '<i class="icon-volume-up icon-white"></i>')), array('title' => 'Klik untuk memanggil antrian terakhir',
                        'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'ambilAntrianTerakhir();',
                        'style' => 'font-size:10px;'));
                    ?></div>
            </div>
            <div class="panel-body overflow-x">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                    'id' => 'daftarpasien-v-grid',
                    'dataProvider' => $modPasienMasukPenunjang->searchRM(),
                    'template' => "{summary}\n{items}\n{pager}",
                    //'mergeColumns'		 => array('rincian'),
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'replaceUrl'=>true,
                    'columns' => array(
                        array(
                            'name' => 'no_urutperiksa',
                            'type' => 'raw',
                            'header' => 'No. Antrian <br>/ Panggil Antrian',
                            'value' => function($data) {

                                $str = $data->ruangan_singkatan . "-" . $data->no_urutperiksa . "<br/>";
                                if ($data->panggilantrian == TRUE || (date('Y-m-d', strtotime(MyFormatter::formatDateTimeForDb($data->tglmasukpenunjang))) != date('Y-m-d'))) {
                                    $str .= "Sudah Dipanggil";
                                } else {
                                    $str .= CHtml::htmlButton(Yii::t("mds", "{icon}", array("{icon}" => '<i class="icon-volume-up icon-white"></i>')), array("class" => "btn btn-primary", "onclick" => "panggilAntrian('" . $data->pasienmasukpenunjang_id . "'); setSuaraPanggilanSingle('" . $data->ruangan_singkatan . "','" . $data->no_urutperiksa . "','" . $data->ruangan_id . "')", "rel" => "tooltip", "title" => "Klik untuk memanggil pasien ini"));
                                }

                                return $str;
                            },
                        ),
                        'tglmasukpenunjang',
                        array(
                            'header' => 'Instalasi / Ruangan Asal',
                            'value' => '$data->insatalasiRuanganAsal'
                        ),
                        //            'no_pendaftaran',
                        array(
                            'name' => 'no_pendaftaran',
                            'header' => 'No. Pendaftaran',
                            'type' => 'raw',
                            'value' => function($data) {
                                if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    return CHtml::link("<i class=\"icon-form-ubah\"></i>$data->no_pendaftaran", "#", array("rel" => "tooltip", "title" => "Klik untuk mengubah pemeriksaan", 'onclick' => 'myAlert("Pasien sudah dipulangkan");return false;'));
                                } else {
                                    return CHtml::link("<i class=\"icon-form-ubah\"></i>$data->no_pendaftaran", Yii::app()->controller->createUrl("pemeriksaanRehabilitasiMedis/index", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip", "title" => "Klik untuk mengubah pemeriksaan"));
                                }
                            },
                            'htmlOptions' => array('width' => '100px'),
                        ),
                        'no_rekam_medik',
                        array(
                            'header' => 'Nama Pasien / Alias',
                            'type' => 'raw',
                            'value' => function($data) {
                                return CHtml::link($data->NamaNamaBin, Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/getRiwayatPasien", array("id" => $data->pasien_id)),
                                        array(
                                            "rel" => "tooltip",
                                            "title" => "Klik untuk melihat riwayat pemeriksaan pasien",
                                            "target" => "frameRiwayatPasien",
                                            "onclick" => "$('#dialogRiwayatPasien').dialog('open');"
                                ));
                            },
                        ),
                        array(
                            'header' => 'Kasus Penyakit / <br> Kelas Pelayanan',
                            'type' => 'raw',
                            'value' => '"$data->jeniskasuspenyakit_nama"."<br/>"."$data->kelaspelayanan_nama"',
                        ),
                        'umur',
                        'alamat_pasien',
                        array(
                            'header' => 'Jenis Penjamin / Penjamin',
                            'value' => '$data->caraBayarPenjamin',
                        ),
                        'nama_pegawai',
                        //            'kelaspelayanan_nama',
                        array(
                            'name' => 'Pemeriksaan Pasien',
                            'type' => 'raw',
                            'value' => function($data) {
                                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id
                                ));

                                if ($pendaftaran->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                    // return CHtml::link("<i class='icon-form-periksa'></i> ", "#", array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien", 'onclick' => 'myAlert("Pasien sudah dipulangkan");return false;'));
                                    echo "-";
                                } else {
                                    return CHtml::link("<i class='icon-form-periksa'></i> ", Yii::app()->controller->createUrl("/rehabMedis/pemeriksaanPasienTRM/index", array("pendaftaran_id" => $data->pendaftaran_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("id" => "$data->no_pendaftaran", "rel" => "tooltip", "title" => "Klik untuk Pemeriksaan Pasien"));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Buat Jadwal',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-buatjadwal></i>",Yii::app()->controller->createUrl("/' . $module . '/' . $controller . '/buatJadwal",array("id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Membuat Jadwal Rehab Medis"))',
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'name' => 'masukanHasil',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=icon-form-input></i>",Yii::app()->controller->createUrl("/' . $module . '/' . $controller . '/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik Untuk Memasukkan hasil"))',
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Lihat Hasil',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<icon class=\'icon-form-lihat\'></idcon>", Yii::app()->createUrl("' . $modul . '/' . $controller . '/lihatHasil", array("id"=>$data->pasienmasukpenunjang_id)), array("target"=>"frameLihatHasil", "onclick"=>"$(\'#dialogLihatHasil\').dialog(\'open\');"))',
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                        ),
//				array(
//                                    'header'			 => 'Rincian Tagihan',
//                                    'name'				 => 'rincian',
//                                    'type'				 => 'raw',
//                                    'headerHtmlOptions'	 => array('style' => 'vertical-align:middle;text-align:center;'),
//                                    'value'				 => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/rehabMedis/daftarPasien/RincianTagihanPenunjang",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>$data->instalasi_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"pasienadmisi_id"=>"","frame"=>true)),
//                                            array("class"=>"",
//                                                  "target"=>"iframeRincianTagihan",
//                                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
//                                                  "rel"=>"tooltip",
//                                                  "title"=>"Klik untuk melihat Rincian Tagihan",
//                                            ))',
//                                    'htmlOptions'		 => array('style' => 'text-align: center; width:40px')
//				),
                        array(
                            'header' => 'Status Periksa',
                            //'value' => '$data->getStatusPeriksa($data->statusperiksa, $data->pendaftaran_id)',
                            // 'value' => '$data->getPemeriksaanRehab($data->statusperiksa, $data->pendaftaran_id, $data->pasienmasukpenunjang_id)',
                            'value' => function($data){
                                $pendaftaran = PendaftaranT::model()->findByAttributes(array(
                                    'pendaftaran_id' => $data->pendaftaran_id
                                ));

                                echo $pendaftaran->statusperiksa;
                            },
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center;'),
                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                        ),
                        array(
                            'header' => 'Catatan Edukasi',
                            'type' => 'raw',
                            'value' => function($data) {
                                return CHtml::link('<i class="icon-form-detail"></i>', $this->createUrl('catatanEdukasiRM/create', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                                    'rel'=>'tooltip',
                                    'title'=>'Catatan Edukasi Pasien',
                                ));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                        ),
                        array(
                            'name'=>'Catatan Perkembangan Pasien Terintegrasi (CPPT)',
                            'type'=>'raw',
                            'value'=>function($data) {
                                return CHtml::link('<i class="icon-form-detail"></i> ', Yii::app()->createUrl("/rehabMedis/CPPTRM/index",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Catatan Perkembangan Pasien Terintegrasi (CPPT)"));
                            },
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        ),
                        array(
                            'header' => 'Status Dokumen',
                            'type' => 'raw',
                            'value' => function($data) {
                                $ruangan_id = Yii::app()->user->getState('ruangan_id');
                                $status_dokumen = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                                /*  $kirimrm = PengirimanrmT::model()->findAllByAttributes(array(
                                  'pendaftaran_id'=>$data->pendaftaran_id,
                                  ), array(
                                  'condition'=>"(ruangan_id = ${ruangan_id} or ruanganpengirim_id = ${ruangan_id})",
                                  'order'=>'pengirimanrm_id desc',
                                  'limit'=>1,
                                  ));

                                  if (count($kirimrm) == 0) {
                                  return '<button id="red" class="btn btn-green" name="yt1">BELUM DI TERIMA</button>';
                                  } else if (count($kirimrm) == 1) {
                                  if (empty($kirimrm[0]->tglterimadokrm)) {
                                  $r = RuanganM::model()->findByPk($kirimrm[0]->ruanganpengirim_id);
                                  return '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$data->pendaftaran_id.','.$kirimrm[0]->pengirimanrm_id.')">SUDAH DIKIRIM DARI '.strtoupper($r->ruangan_nama).'</button>';
                                  } else {
                                  return CHtml::link("<i></i> SUDAH DITERIMA", Yii::app()->createUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/statusDokumenKirim', array("pengirimanrm_id"=>$kirimrm->pengirimanrm_id,"pendaftaran_id"=>$data->pendaftaran_id)),
                                  array("class"=>"btn btn-primary",
                                  "target"=>"frameStatusDokumen",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk mengirim dokumen ke ruangan lain",
                                  "onclick"=>'$("#dialogStatusDokumen").dialog("open");'));
                                  //return '<button id="red" class="btn btn-primary" name="yt1" onclick="kirimRM('.$data->pendaftaran_id.')">SUDAH DI TERIMA</button>';
                                  }
                                  }

                                  if (empty($kirimrm)) return '<button id="red" class="btn btn-primary" name="yt1">BELUM DI TERIMA</button>';
                                  else if (empty($kirimrm->tglterimadokrm)) return '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$data->pendaftaran_id.','.$kirimrm->pengirimanrm_id.')">BELUM DI VERIFIKASI</button>';
                                  return '<button id="red" class="btn btn-primary" name="yt1" onclick="verifikasiKirimanRM('.$data->pendaftaran_id.', '.$kirimrm->pengirimanrm_id.')">SUDAH DI VERIFIKASI</button>';
                                  }, */
                                if ($status_dokumen->statusdokrm == "SUDAH DITERIMA") {
                                    if ($status_dokumen->pengirimanrm->ruanganpenerima_id == Yii::app()->user->getState('ruangan_id')) {
                                        return CHtml::link("<i></i> $status_dokumen->statusdokrm", Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim', array("pengirimanrm_id" => $status_dokumen->pengirimanrm_id, "pendaftaran_id" => $data->pendaftaran_id)), array("class" => "btn btn-primary",
                                                    "target" => "frameStatusDokumen",
                                                    "rel" => "tooltip",
                                                    "title" => "Klik untuk mengirim dokumen ke ruangan lain",
                                                    "onclick" => '$("#dialogStatusDokumen").dialog("open");'));
                                    } else {
                                        return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id);
                                    }
                                } else {
                                    return $data->getStatusDokumen($status_dokumen->pengirimanrm_id, $status_dokumen->statusdokrm, $data->pendaftaran_id);
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                        ),
                        array(
                            'header' => 'Pemindahan Pasien',
                            'type' => 'raw',
                            'value' => function($data) {
                              $htmlLink = CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->createUrl('/rehabMedis/pemindahanPasienRM/index', array('pendaftaran_id'=>$data->pendaftaran_id)), array(
                                  'rel'=>'tooltip',
                                  'title'=>'Pemindahan Pasien',
                              ));

                              $modFormTransfer = PemindahanpasienT::model()->findAllByAttributes(array('ruangantujuan_id'=>Yii::app()->user->getState("ruangan_id"),'pendaftaran_id'=>$data->pendaftaran_id),array('condition'=>'(ispasienditerima IS NULL OR ispasienditerima = false)'));
                              $linkPenerima = "";
                              if(isset($modFormTransfer) && count($modFormTransfer) > 0){
                                  $linkPenerima = CHtml::link('<i class="icon-form-check"></i> ', Yii::app()->createUrl("/rehabMedis/pemindahanPasienRM/index",array("pendaftaran_id"=>$data->pendaftaran_id,'pasienditerima'=>'diterima')),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Penerimaan Pemindahaan Pasien"));
                              }

                              return $htmlLink .'<br/>'.$linkPenerima;
                            },
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                        ),
                        array(
                            'header' => 'Batal Periksa',
                            'type' => 'raw',
                            'value' => '($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH && $data->statusperiksa != Params::STATUSPERIKSA_SUDAH_PULANG) ? CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienmasukpenunjang_id\',\'$data->statusperiksa\',\'$data->nama_pasien\')",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan")) : null',
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                            'headerHtmlOptions' => array('style' => 'text-align: center;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
        <iframe id="suarapanggilan" style="display: none;"></iframe>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
            'id' => 'dialogLihatHasil',
            'options' => array(
                'title' => 'Detail Hasil Pemeriksaan',
                'autoOpen' => false,
                'modal' => true,
                'width' => 900,
                'height' => 550,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe name='frameLihatHasil' width="100%" height="100%"></iframe>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogRincianTagihan',
            'options' => array(
                'title' => 'Rincian Tagihan',
                'autoOpen' => false,
                'modal' => true,
                'zIndex' => 1001,
                'minWidth' => 1024,
                'minHeight' => 400,
                'resizable' => true,
            ),
        ));
        ?>
        <iframe src="" name="iframeRincianTagihan" width="100%" height="550" >
        </iframe>
        <?php
        $this->endWidget();
        ?>

        <?php
        //CHtml::link($text, $url, $htmlOptions)
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'daftarPasien-form',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($modPasienMasukPenunjang, 'no_pendaftaran'),
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="icon-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <table width="100%" class="table-condensed">
                    <tr>
                        <td width="50%">
                            <div class="col-sm-6">
                                <div class="control-group ">
                                    <label for="namaPasien" class="control-label">
<?php echo CHtml::activecheckBox($modPasienMasukPenunjang, 'ceklis', array(
    'uncheckValue' => 0, 'rel' => 'tooltip', 'onClick' => 'cekTanggal()', 'data-original-title' => 'Cek untuk pencarian berdasarkan tanggal'));
?>
                                        Tanggal Masuk
                                    </label>
                                    <div class="controls">
                                        <?php
                                        $format = new MyFormatter;
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPasienMasukPenunjang,
                                            'attribute' => 'tgl_awal',
                                            'mode' => 'date',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                                        ));
                                        ?>

                                    </div>

                                </div>


                                <div class="control-group">
                                        <?php echo CHtml::label(' Sampai Dengan', ' s/d', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPasienMasukPenunjang,
                                            'attribute' => 'tgl_akhir',
                                            'mode' => 'date',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                                        ));
                                        ?>
                                    </div>
                                </div>
<?php
echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array(
    'placeholder' => 'Ketik No. Pendaftaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
    'maxlength' => 50));
?>
                            </div>

                            <div class="col-sm-6">

                                <?php
                                echo $form->textFieldRow($modPasienMasukPenunjang, 'no_rekam_medik', array(
                                    'placeholder' => 'Ketik No. Rekam Medik', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'maxlength' => 50));
                                ?>
<?php
echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array(
    'placeholder' => 'Ketik Nama Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
    'maxlength' => 50));
?>

<?php
echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_bin', array(
    'placeholder' => 'Ketik Nama Panggilan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
    'maxlength' => 50));
?>



                            </div>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array(
            'class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
        ?>
        &nbsp;
<?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('daftarPasien/index'), array(
    'class' => 'btn btn-danger'));
?>
        &nbsp;
<?php
$content = $this->renderPartial('../tips/informasi', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>
        </fieldset>
<?php $this->endWidget(); ?>
    </div>
</div>


<?php
// Dialog untuk Melihat pemeriksaan pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRiwayatPasien',
    'options' => array(
        'title' => 'Riwayat Pemeriksaan Pasien',
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
<iframe name='frameRiwayatPasien' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>
<script type="text/javascript">

//	document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:none;");
//	document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:none;");
    function cekTanggal() {

        var checklist = $('#RMMasukPenunjangV_ceklis');
        var pilih = checklist.attr('checked');
        // var tgl_masuk = $(document)
        if (pilih) {
            // document.getElementById('RMMasukPenunjangV_tgl_awal').disabled = false;
            // document.getElementById('RMMasukPenunjangV_tgl_akhir').disabled = false;
            document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            // document.getElementById('RMMasukPenunjangV_tgl_awal').disabled = true;
            // document.getElementById('RMMasukPenunjangV_tgl_akhir').disabled = true;
            document.getElementById('RMMasukPenunjangV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('RMMasukPenunjangV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }


    function ambilAntrianTerakhir() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
            dataType: "json",
            success: function (data) {
                if (data.pesan == "") {
                    panggilAntrian(data.pasienmasukpenunjang_id);
                    // setSuaraPanggilanSingle(data.ruangan_singkatan, data.no_urutperiksa, data.ruangan_id);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    /**
     * memanggil antrian ke poliklinik
     * @param {type} pendaftaran_id
     * @returns {undefined} */
    function panggilAntrian(pasienmasukpenunjang_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('Panggil'); ?>',
            data: {pasienmasukpenunjang_id: pasienmasukpenunjang_id},
            dataType: "json",
            success: function (data) {
                if (data.pesan !== "") {
                    myAlert(data.pesan);
                }
                if (data.smspasien == 0) {
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi: 'GAGAL KIRIM SMS PASIEN', isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'}; // 16
                    simpanNotifikasi(params);
                }
<?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                    socket.emit('send', {conversationID: 'antrian', panggil: 3, antrian_id: pasienmasukpenunjang_id});
<?php } ?>
                $.fn.yiiGridView.update('daftarpasien-v-grid');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function verifikasiKirimanRM(id, kirimrm) {
        myConfirm('Apakah Anda yakin akan menerima dokumen rekam medis pasien? ', 'Perhatian!', function (r) {
            if (r) {
                $.post('<?php echo $this->createUrl('terimaDokumen'); ?>', {
                    pendaftaran_id: id, pengirimanrm_id: kirimrm
                }, function (data) {
                    if (data.status == 'proses_form') {
                        //$('#dialogStatusDokumen div.divForForm').html(data.div);
                        $.fn.yiiGridView.update('daftarpasien-v-grid');
                        //setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
                    }
                }, 'json');
            } else {
                preventDefault();
            }
        });
    }

    function setPenerimaan(obj,pengirimanrm_id,ruanganpenerimaan_id,status,pendaftaran_id){
    var status = status;
    var pendaftaran_id = pendaftaran_id;
	var pengirimanrm_id = pengirimanrm_id;
    var ruanganpenerimaan_id = ruanganpenerimaan_id;

	if(ruanganpenerimaan_id == '' || ruanganpenerimaan_id == 99){
		myConfirm('Apakah anda akan membatalkan pengiriman? ', 'Perhatian!', function(r){
			if(r){
				$.post('<?php echo $this->createUrl('HapusDokumenPengiriman');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id}, function(data){
					if(data.status == 'proses_form'){
						$('#dialogStatusDokumen div.divForForm').html(data.div);
						$.fn.yiiGridView.update('daftarpasien-v-grid');
						setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
					}else{
						$('#alertDiv').show();
					}
				}, 'json');
			}else{
				 preventDefault();
			}
		});
	}else{
		$.post('<?php echo $this->createUrl('getStatusPenerimaan');?>', {status:status ,pendaftaran_id:pendaftaran_id, pengirimanrm_id:pengirimanrm_id,ruanganpenerimaan_id:ruanganpenerimaan_id}, function(data){
			$('#dialogStatusDokumen div.divForForm').html(data.div);
			$.fn.yiiGridView.update('daftarpasien-v-grid');
			setTimeout("$('#dialogStatusDokumen').dialog('close')",1000);
		}, 'json');
	}
}



    /**
     * suara panggilan per ruangan
     * @param {type} param
     * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
     */
    function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id) {
        return false;
        // $("#suarapanggilan").attr("src", "<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian=" + kodeantrian + "&noantrian=" + noantrian + "&ruangan_id=" + ruangan_id);
    }

</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
//		'show'=>'blind',
//		'hide'=>'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'resizable' => false,
        'modal' => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php echo $this->renderPartial('_jsFunctions', array()); ?>


<?php
// Dialog untuk kirim dokumen RM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogStatusDokumen',
    'options' => array(
        'title' => 'Pengiriman Dokumen Ke-Ruangan Lain',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 1000,
        'height' => 400,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
        data: $('#daftarPasien-form').serialize()
    }); }",
    ),
));
echo '<div class="divForForm"></div>';
?>
<iframe name='frameStatusDokumen' width="100%" height="100%"></iframe>
<?php $this->endWidget();
// end ==============
?>
