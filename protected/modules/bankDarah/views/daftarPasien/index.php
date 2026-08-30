<div class="white-container">
    <legend class="rim2">Informasi <b>Daftar Pasien</b></legend>

    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] > 0) { // Jika berhasil disimpan
            Yii::app()->user->setFlash('success', "Data pemeriksaan lab berhasil disimpan!");
        }
    }
    ?>
    <?php
    //============= PRINT LABEL sebelumnya ==============
    // if(isset($_GET['caraPrint'])){
    // $pendaftaran_id = $_GET['id'];
    // $urlPrint=  Yii::app()->createAbsoluteUrl('bankDarah/pendaftaranPasienLuar/print', array('id_pendaftaran'=>$pendaftaran_id));
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
    if (isset($_GET['caraPrint'])) {
        $pendaftaran_id = $_GET['id'];
        $id_pasienpenunjang = $_GET['idPasienPenunjang'];
        $labelOnly = 1;
        $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/pendaftaranPasienLuar/print', array(
            'id_pendaftaran' => $pendaftaran_id, 'id_pasienpenunjang' => $id_pasienpenunjang,
            'labelOnly' => $labelOnly
        ));
        $urlPrintTindakan = Yii::app()->createAbsoluteUrl($this->module->id . '/pendaftaranLab/print', array(
            'id_pendaftaran' => $pendaftaran_id, 'labelOnly' => $labelOnly
        ));
        $js = <<< JSCRIPT
function printLabel(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=980px');
    window.open("${urlPrintTindakan}&caraPrint="+caraPrint,"",'location=_new, width=980px');
}
    printLabel('PRINT');
JSCRIPT;

        Yii::app()->clientScript->registerScript('printLabel', $js, CClientScript::POS_HEAD);
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
    <fieldset>
        <?php
        //  RND-10207   
        //      $daftar = $modPasienMasukPenunjang->searchLab();
        $daftar = $modPasienMasukPenunjang->searchLab();
        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_LAB_ANATOMI) {
            $daftar = $modPasienMasukPenunjang->searchLabAnatomi();
        }
        ?>
        <div class="block-tabel">
            <h6>Tabel <b>Daftar Pasien</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array(
                                                '{icon}' => '<i class="icon-volume-up icon-white"></i>'
                                            )), array(
                                                'title' => 'Klik untuk memanggil antrian terakhir',
                                                'rel' => 'tooltip', 'class' => 'btn  btn-mini btn-primary', 'onclick' => 'ambilAntrianTerakhir();',
                                                'style' => 'font-size:10px;'
                                            )); ?></h6>
            <?php
            $this->widget('bootstrap.widgets.BootAlert');
            $this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
                'id'                 => 'daftarpasien-v-grid',
                'dataProvider'         => $daftar,
                'template'             => "{summary}\n{items}\n{pager}",
                'itemsCssClass'         => 'table table-striped table-condensed',
                'mergeColumns'         => array('rincian'),
                'columns'             => array(
                    //            'tgl_pendaftaran',
                    array(
                        'name'     => 'no_urutperiksa',
                        'type'     => 'raw',
                        'header' => 'No. Antrian/<br>Panggil Antrian',
                        'value'     => '$data->ruangan_singkatan."-".$data->no_urutperiksa."<br>".((($data->panggilantrian == TRUE) || date("Y-m-d",strtotime($data->tglmasukpenunjang)) != "' . date('Y-m-d') . '") ? "Sudah Dipanggil" : CHtml::htmlButton(Yii::t("mds","{icon}",array("{icon}"=>"<i class=\'icon-volume-up icon-white\'></i>")),array("class"=>"btn btn-primary","onclick"=>"panggilAntrian(\"$data->pasienmasukpenunjang_id\"); setSuaraPanggilanSingle(\"$data->ruangan_singkatan\",\"$data->no_urutperiksa\",\"$data->ruangan_id\")","rel"=>"tooltip","title"=>"Klik untuk memanggil pasien ini")))'
                    ),
                    'tglmasukpenunjang',
                    'ruanganasal_nama',
                    'nama_dokterasal',
                    'nama_perujuk',
                    array(
                        'name'     => 'no_rekam_medik',
                        'type'     => 'raw',
                        'header' => 'No. Pendaftaran<br>No. RM',
                        'value'     => '(($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-ubah\"></i>$data->no_pendaftaran",Yii::app()->controller->createUrl("pemeriksaanPasienBankDarah/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Pemeriksaan")) : $data->no_pendaftaran). "\n" . $data->no_rekam_medik',
                        'htmlOptions'     => array('style' => 'text-align: center;'),
                    ),
                    array(
                        'header' => 'Nama Pasien / Panggilan',
                        'type'     => 'raw',
                        //                'value'=> '((substr($data->no_rekam_medik,0,-6)) == "BD" || (substr($data->no_rekam_medik,0,-6)) == "RD" ? CHtml::link("<i class=\"icon-pencil\"></i>", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien"))." ".CHtml::link($data->nama_pasien.\' / \'.$data->nama_bin, Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/ubahPasien",array("id"=>"$data->pasien_id")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->nama_pasien.\' / \'.$data->nama_bin )',
                        'value'     => '(($data->instalasiasal_id == ' . PARAMS::INSTALASI_ID_LAB . ') ? CHtml::link("<i class=\"icon-form-ubah\"></i> ".$data->NamaPasienNamaBin, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id","pendaftaran_id"=>"$data->pendaftaran_id","modul_id"=>"' . Yii::app()->session['modul_id'] . '")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->NamaPasienNamaBin )',
                    ),
                    array(
                        'header' => 'Jenis Kelamin',
                        'type'     => 'raw',
                        'value'     => '$data->jeniskelamin',
                    ),
                    'umur',
                    'alamat_pasien',
                    array(
                        'header'         => 'Jenis Penjamin',
                        'name'             => 'CaraBayarPenjamin',
                        'type'             => 'raw',
                        'value'             => '$data->caraBayarPenjamin',
                        'htmlOptions'     => array('style' => 'text-align: center; width:40px')
                    ),
                    array(
                        'header' => 'Status Periksa',
                        'type'     => 'raw',
                        'value'     => '$data->getStatus($data->statusperiksa,$data->pasienmasukpenunjang_id,$data->pendaftaran_id)',
                    ),
                    array(
                        'header' => 'Status Pemeriksaan Hasil',
                        'type'     => 'raw',
                        //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->statusperiksahasil,Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/CancelPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan membatalkan pemeriksaan ini?\");")) : ((empty($data->pasienbatalperiksa_id)) ? $data->statusperiksahasil : "DIBATALKAN")',
                        'value'     => '($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>".$data->statusperiksahasil, "javascript:batalstatusperiksa($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",array("rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan")) : ((empty($data->pasienbatalperiksa_id)) ? $data->statusperiksahasil : "DIBATALKAN")',
                    ),
                    array(
                        'header' => 'Dokter Pemeriksa',
                        'type'     => 'raw',
                        //                'value'=>'($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>". $data->getNamaLengkapDokter($data->pegawai_id),Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/ApprovePemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan", "onclick"=>"return confirm(\"Apakah Anda akan menyetujui pemeriksaan ini?\");")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                        'value'     => '($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>".$data->getNamaLengkapDokter($data->pegawai_id), "javascript:approveperiksa($data->pendaftaran_id, $data->pasienmasukpenunjang_id)",array("rel"=>"tooltip","title"=>"Klik untuk menyetujui pemeriksaan")) : $data->getNamaLengkapDokter($data->pegawai_id)',
                    ),
                    //            array(
                    //                'header'=>'Status Print',
                    //                'type'=>'raw',
                    //                'value'=>'($data->printhasillab == true) ? "SUDAH" : "BELUM"',
                    //            ),
                    array(
                        'name'             => 'ambilSample',
                        'type'             => 'raw',
                        'value'             => '($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-form-ambilsample\"></i>",Yii::app()->controller->createUrl("/' . $module . '/' . $controller . '/updateSample",array("pendaftaran_id"=>$data->pendaftaran_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Ambil Sampel")) : ""',
                        //dicomment RND-5771
                        //                'value'=>'($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\"icon-pencil-blue\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/updateSample",array("pendaftaran_id"=>$data->pendaftaran_id,"idPengambilanSample"=>$data->pengambilansample_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Ambil Sampel")) : ""',    
                        'htmlOptions'     => array('style' => 'text-align: center; width:40px')
                    ),
                    //             array(
                    //                'name'=>'masukanHasil',
                    //                'type'=>'raw',
                    //                'value'=>'(($data->statusperiksahasil == Params::STATUSPERIKSAHASIL_SEDANG || $data->statusperiksahasil == Params::STATUSPERIKSAHASIL_BELUM) ? CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Masukan Hasil Pemeriksaan")) 
                    //                  : 
                    //                  CHtml::link("<i class=\"icon-pencil-brown\"></i>",Yii::app()->controller->createUrl("/'.$module.'/'.$controller.'/hasilPemeriksaan",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Masukan Hasil Pemeriksaan Lab Anatomi")))',    
                    //                'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    //            ),
                    //TEST NEW
                    array(
                        'name'             => 'masukanHasil',
                        'type'             => 'raw',
                        'value'             => '(($data->statusperiksahasil != "SUDAH") ? CHtml::link("<i class=\"icon-form-input\"></i>",Yii::app()->controller->createUrl("/bankDarah/pencatatanHasilPemeriksaan/index",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id)),array("rel"=>"tooltip","title"=>"Klik untuk Masukan Hasil Pemeriksaan Lab")) : "")',
                        'htmlOptions'     => array('style' => 'text-align: center; width:40px')
                    ),
                    array(
                        'header'         => 'Lihat Hasil',
                        'type'             => 'raw',
                        'value'             => '(Yii::app()->user->getState("ruangan_id") == Params::RUANGAN_ID_LAB_KLINIK) ? 
                                    CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/print",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                                        array("class"=>"", 
                                              "target"=>"iframeLihatHasil",
                                              "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat hasil pemeriksaan", 
                                        )) : 
                                    CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("pencatatanHasilPemeriksaan/PrintPA",array("pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"frame"=>1,"popup"=>"true")),
                                        array("class"=>"", 
                                              "target"=>"iframeLihatHasil",
                                              "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk melihat hasil pemeriksaan", 
                                        ))  
                                    ',
                        'htmlOptions'     => array('style' => 'text-align: center; width:40px')

                        //                'value'=>'CHtml::Link("<i class=\"icon-file-silver\"></i>",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/Details",array("pendaftaran_id"=>$data->pendaftaran_id,"pasien_id"=>$data->pasien_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id, "popup"=>"true")),
                        //                            array("class"=>"", 
                        //                                  "target"=>"iframeLihatHasil",
                        //                                  "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                        //                                  "rel"=>"tooltip",
                        //                                  "title"=>"Klik untuk melihat hasil pemeriksaan", 
                        //                            ))','htmlOptions'=>array('style'=>'text-align: center; width:40px')
                    ),
                    array(
                        'header'         => 'Status Dokumen',
                        'type'             => 'raw',
                        'value'             => '($data->statusdokrm == "SUDAH DITERIMA") ? CHtml::link("<i></i> $data->statusdokrm", Yii::app()->createUrl("/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/statusDokumenKirim", array("pengirimanrm_id"=>$data->pengirimanrm_id,"pendaftaran_id"=>$data->pendaftaran_id)),
										array("class"=>"btn btn-primary",
										"target"=>"frameStatusDokumen",
										"rel"=>"tooltip",
										"title"=>"Klik untuk mengirim dokumen ke ruangan lain",
										"onclick"=>"$(\'#dialogStatusDokumen\').dialog(\'open\');"))
							: $data->getStatusDokumen($data->pengirimanrm_id,$data->statusdokrm,$data->pendaftaran_id)',
                        'htmlOptions'     => array('style' => 'text-align: center; width:40px'),
                    ),
                    array(
                        'header'             => 'Rincian Tagihan',
                        'name'                 => 'rincian',
                        'type'                 => 'raw',
                        'headerHtmlOptions'     => array('style' => 'vertical-align:middle;text-align:center;'),
                        'value'                 => 'CHtml::Link("<i class=\"icon-form-detailtagihan\"></i>",Yii::app()->controller->createUrl("/bankDarah/daftarPasien/RincianTagihanPenunjang",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>$data->instalasi_id,"pasienmasukpenunjang_id"=>$data->pasienmasukpenunjang_id,"pasienadmisi_id"=>"","frame"=>true)),
                                            array("class"=>"", 
                                                  "target"=>"iframeRincianTagihan",
                                                  "onclick"=>"$(\"#dialogRincianTagihan\").dialog(\"open\");",
                                                  "rel"=>"tooltip",
                                                  "title"=>"Klik untuk melihat Rincian Tagihan",
                                            ))',
                        'htmlOptions'         => array('style' => 'text-align: center; width:40px')
                    ),
                    array(
                        'header'         => 'Batal Periksa',
                        'type'             => 'raw',
                        'value'             => '($data->statusperiksahasil != Params::STATUSPERIKSAHASIL_SUDAH) ? CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:dialogBatalPeriksa(\'$data->pendaftaran_id\',\'$data->pasienmasukpenunjang_id\',\'$data->statusperiksa\',\'$data->nama_pasien\')",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","title"=>"Klik untuk membatalkan Pemeriksaan")) : null',
                        'htmlOptions'     => array('style' => 'text-align: center; width:40px'),
                    ),
                ),
                'afterAjaxUpdate'     => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        </div>
        <?php
        // Dialog untuk Lihat Hasil =========================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'         => 'dialogLihatHasil',
            'options'     => array(
                'title'         => 'Hasil Pemeriksaan Bank Darah',
                'autoOpen'     => false,
                'modal'         => true,
                'minWidth'     => 980,
                'minHeight'     => 450,
                'resizable'     => true,
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
        //CHtml::link($text, $url, $htmlOptions)
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action'         => Yii::app()->createUrl($this->route),
            'method'         => 'get',
            'id'             => 'daftarPasien-form',
            'type'             => 'horizontal',
            'focus'             => '#' . CHtml::activeId($modPasienMasukPenunjang, 'no_rekam_medik'),
            'htmlOptions'     => array(),
        ));
        ?>

        <fieldset class="box">
            <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
            <table style="width: 100%; border: none;">
                <tr>
                    <td>
                        <?php echo CHtml::label('Tgl. Masuk Penunjang', 'tglmasukpenunjang', array(
                            'class' => 'control-label'
                        )) ?>
                        <div class="controls">
                            <?php $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_awal); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model'             => $modPasienMasukPenunjang,
                                'attribute'         => 'tgl_awal',
                                'mode'             => 'date',
                                //                                          'maxDate'=>'d',
                                'options'         => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions'     => array(
                                    'readonly'     => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $modPasienMasukPenunjang->tgl_awal = $format->formatDateTimeForDb($modPasienMasukPenunjang->tgl_awal); ?>

                        </div>
                        <?php echo CHtml::label(' Sampai Dengan', ' s/d', array('class' => 'control-label')) ?>

                        <div class="controls">
                            <?php $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForUser($modPasienMasukPenunjang->tgl_akhir); ?>
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model'             => $modPasienMasukPenunjang,
                                'attribute'         => 'tgl_akhir',
                                'mode'             => 'date',
                                //                                         'maxdate'=>'d',
                                'options'         => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                ),
                                'htmlOptions'     => array(
                                    'readonly'     => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            ));
                            ?>
                            <?php $modPasienMasukPenunjang->tgl_akhir = $format->formatDateTimeForDb($modPasienMasukPenunjang->tgl_akhir); ?>
                        </div><br><br><br>
                        <div class="control-group">
                            <label class="control-label">Status Permeriksaan</label>
                            <div class="controls">
                                <?php // echo $form->textField($modPasienMasukPenunjang,'statusperiksahasil',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50));  
                                ?>
                                <?php echo $form->dropDownList($modPasienMasukPenunjang, 'statusperiksahasil', CHtml::listData(LookupM::model()->findAllByAttributes(array(
                                    'lookup_type' => 'statusperiksahasil', 'lookup_aktif' => true
                                )), 'lookup_value', 'lookup_name'), array(
                                    'empty' => 'TAMPILKAN SEMUA', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'maxlength' => 50
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">No. Rekam Medik</label>
                            <div class="controls">
                                <?php echo $form->textField($modPasienMasukPenunjang, 'no_rekam_medik', array(
                                    'placeholder' => 'No. Rekam Medik',
                                    'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'maxlength' => 50
                                )); ?>
                            </div>
                        </div>

                    </td>
                    <td>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'no_pendaftaran', array(
                            'placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'maxlength' => 50
                        )); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_pasien', array(
                            'placeholder' => 'Nama Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'maxlength' => 50
                        )); ?>
                        <?php echo $form->textFieldRow($modPasienMasukPenunjang, 'nama_bin', array(
                            'placeholder' => 'Nama Panggilan Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'maxlength' => 50
                        )); ?>
                    </td>

                </tr>
            </table>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array(
                    'autofocus' => true, 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan'
                ));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
                    'class'         => 'btn btn-danger',
                    'onclick'     => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                ));
                ?>
                <?php
                $content = $this->renderPartial('../tips/informasi', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>

            </div>
        </fieldset>
        <?php $this->endWidget(); ?>
    </fieldset>
    <iframe id="suarapanggilan" src="#" style="display: none;"></iframe>

</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'         => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options'     => array(
        'title'         => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen'     => false,
        //		'show'=>'blind',
        //		'hide'=>'explode',
        'zIndex'     => 1002,
        'minWidth'     => 500,
        'minHeight'     => 100,
        'resizable'     => false,
        'modal'         => true,
    ),
));
$this->renderPartial('_formBatalPeriksaDialog');

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1001,
        'minWidth' => 1024,
        'height' => 400,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
<?php
// Dialog untuk tindak lanjut pasien ke RI=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'         => 'dialogStatusDokumen',
    'options'     => array(
        'title'         => 'Pengiriman Dokumen Ke-Ruangan Lain',
        'autoOpen'     => false,
        'modal'         => true,
        'zIndex'     => 1002,
        'width'         => 1000,
        'height'     => 400,
        'resizable'     => true,
        'close'         => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid', {
						data: $('#caripasien-form').serialize()
					}); }",
    ),
));
?>
<iframe name='frameStatusDokumen' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php echo $this->renderPartial('_jsFunctions', array()); ?>
<script type="text/javascript">
    function batalstatusperiksa(pendaftaran_id, idPenunjang) {
        myConfirm('Apakah Anda akan membatalkan status pemeriksaan ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('bankDarah/daftarPasien/CancelPemeriksaanAjax') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idPenunjang: idPenunjang
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            window.location = "<?php echo Yii::app()->createUrl('bankDarah/daftarPasien/index&status=1') ?>";
                        } else {
                            if (data.status == 'gagal') {
                                myAlert('Pembatalan pemeriksaan gagal');
                            }

                        }
                    }, 'json'
                );
            }
        });
    }

    function approveperiksa(pendaftaran_id, idPenunjang) {
        myConfirm('Apakah Anda akan menyetujui pemeriksaan ini?', 'Perhatian!', function(r) {
            if (r) {
                $.post('<?php echo Yii::app()->createUrl('bankDarah/daftarPasien/ApprovePemeriksaanAjax') ?>', {
                        pendaftaran_id: pendaftaran_id,
                        idPenunjang: idPenunjang
                    },
                    function(data) {
                        if (data.status == 'ok') {
                            window.location = "<?php echo Yii::app()->createUrl('bankDarah/daftarPasien/index&status=1') ?>";
                        } else {
                            if (data.status == 'gagal') {
                                myAlert('Pemeriksaan gagal disetujui');
                            }

                        }
                    }, 'json'
                );
            }
        });
    }
    //
    //    function batalperiksa(pendaftaran_id,idPenunjang)
    //    {
    //       myConfirm('Anda yakin akan membatalkan pemeriksaan laboratorium pasien ini?', 'Perhatian!', function(r)
    //       {
    //            if(r){
    //                $.post('<?php echo Yii::app()->createUrl('bankDarah/daftarPasien/BatalPeriksaPasienLuar') ?>',{pendaftaran_id:pendaftaran_id,idPenunjang:idPenunjang},
    //                          function(data){
    //                              if(data.status == 'ok'){
    //                                if(data.smspasien==0){
    //                                  var params = [];
    //                                  params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien '+data.nama_pasien+' tidak memiliki nomor mobile'}; // 16 
    //                                  simpanNotifikasi(params);
    //                                }
    //                                window.location = "<?php echo Yii::app()->createUrl('bankDarah/daftarPasien/index&status=1') ?>";
    //                              }else{
    //                                  if(data.status == 'exist')
    //                                  {
    //                                      myAlert('Pasien telah melakukan pemeriksaan');
    //                                  }
    //
    //                              }
    //                          },'json'
    //                      );
    //            }else{
    //         //       myAlert('tidak');
    //            }
    //       });
    //    }
    function ambilAntrianTerakhir() {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getAntrianTerakhir'); ?>',
            dataType: "json",
            success: function(data) {
                if (data.pesan == "") {
                    panggilAntrian(data.pasienmasukpenunjang_id);
                    setSuaraPanggilanSingle(data.ruangan_singkatan, data.no_urutperiksa, data.ruangan_id);
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
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
            data: {
                pasienmasukpenunjang_id: pasienmasukpenunjang_id
            },
            dataType: "json",
            success: function(data) {
                if (data.pesan !== "") {
                    myAlert(data.pesan);
                }
                if (data.smspasien == 0) {
                    var params = [];
                    params = {
                        instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                        modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                        judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                        isinotifikasi: 'Pasien ' + data.nama_pasien + ' tidak memiliki nomor mobile'
                    }; // 16 
                    simpanNotifikasi(params);
                }
                <?php if (Yii::app()->user->getState('is_nodejsaktif')) { ?>
                    socket.emit('send', {
                        conversationID: 'antrian',
                        panggil: 1,
                        antrian_id: pasienmasukpenunjang_id
                    });
                <?php } ?>
                $.fn.yiiGridView.update('daftarpasien-v-grid');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }


    /**
     * suara panggilan per ruangan
     * @param {type} param
     * copy dari: antrian.views.tampilAntrianKePoliklinik._jsFunctions
     */
    function setSuaraPanggilanSingle(kodeantrian, noantrian, ruangan_id) {
        $("#suarapanggilan").attr("src", "<?php echo $this->createUrl('/antrian/tampilAntrianKePenunjang/suaraPanggilanSingle'); ?>&kodeantrian=" + kodeantrian + "&noantrian=" + noantrian + "&ruangan_id=" + ruangan_id);
    }
    //    if(alasan==''){
    //        myAlert('Anda Belum Mengisi Alasan Pembatalan');
    //    }else{
    //        $.post('<?php //echo Yii::app()->createUrl('rawatInap/pasienRawatInap/BatalRawatInap'); 
                        ?>', $('#formAlasan').serialize(), function(data){
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
</script>