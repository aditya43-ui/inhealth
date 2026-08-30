 <?php
    $this->breadcrumbs = array(
        'Informasi Pasien Rawat Darurat',
    );
    $arrMenu = array();
    $this->menu = $arrMenu;
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
 <div class='panel panel-gradient'>
     <div class="panel-heading">
         <div class="panel-title">
             <i class="entypo-info-circled"></i> Informasi <b>Pasien Rawat Darurat</b>
         </div>
     </div>
     <div class="panel-body">
         <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            Yii::app()->clientScript->registerScript('cari', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
            ?>
         <?php $this->renderPartial('_searchPasienRD', array('model' => $model, 'format' => $format)); ?>
         <div class='panel panel-success'>
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="entypo-credit-card"></i> Tabel <b>Pasien Rawat Darurat</b>
                 </div>
             </div>
             <div class="panel-body table-responsive">
                 <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'daftarPasien-grid',
                        'dataProvider' => $model->searchRD(),
                        //        'filter'=>$model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                        'columns' => array(
                            array(
                                'name' => 'tgl_pendaftaran',
                                'type' => 'raw',
                                'value' => '$data->tgl_pendaftaran'
                            ),
                            //                    array(
                            //                        'header'=>'Instalasi / Poliklinik',
                            //                        'value'=>'$data->insatalasiRuangan'
                            //                    ),
                            array(
                                'name' => 'no_pendaftaran',
                                'type' => 'raw',
                                'value' => '$data->no_pendaftaran',
                            ),
                            array(
                                'name' => 'no_rekam_medik',
                                'type' => 'raw',
                                'value' => '$data->no_rekam_medik',
                            ),
                            array(
                                'header' => 'Nama Pasien / Panggilan',
                                'value' => '$data->namaNamaBin'
                            ),
                            array(
                                'header' => 'Jenis Penjamin / Penjamin',
                                'value' => '$data->caraBayarPenjamin',
                            ),
                            array(
                                'name' => 'Dokter',
                                'type' => 'raw',
                                'value' => '$data->nama_pegawai',
                            ),
                            array(
                                'name' => 'Transportasi',
                                'type' => 'raw',
                                'value' => '(!empty($data->transportasi))? $data->transportasi : "-"',
                            ),
                            array(
                                'name' => 'Cara Masuk',
                                'type' => 'raw',
                                'value' => '(!empty($data->caramasuk_nama))? $data->caramasuk_nama : "-"',
                            ),
                            array(
                                'name' => 'Rujukan',
                                'type' => 'raw',
                                'value' => '(!empty($data->asalrujukan_nama))? $data->asalrujukan_nama : "-"',
                            ),
                            //                    array(
                            //                       'name'=>'kelaspelayanan_nama',
                            //                        'type'=>'raw',
                            //                        'value'=>'$data->kelaspelayanan_nama',
                            //                    ),
                            array(
                                'name' => 'jeniskasuspenyakit_nama',
                                'type' => 'raw',
                                'value' => '$data->jeniskasuspenyakit_nama',
                            ),
                            //                    array(
                            //                       'name'=>'umur',
                            //                        'type'=>'raw',
                            //                        'value'=>'$data->umur',
                            //                    ),
                            array(
                                'name' => 'alamat_pasien',
                                'type' => 'raw',
                                'value' => '$data->alamat_pasien',
                            ),
                            array(
                                'name' => 'statusperiksa',
                                'type' => 'raw',
                                'value' => '$data->statusperiksa',
                            ),
                            array(
                                'header' => 'Masuk Kamar Jenazah',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                'value' => 'CHtml::Link("<i class=\"icon-form-mkjenazah\"></i>",Yii::app()->controller->createUrl("masukPenunjangJenazah/index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>Params::INSTALASI_ID_RD)),
                                        array("class"=>"", 
                                              "target"=>"iframeMasukKamar",
                                              "onclick"=>"$(\"#dialogMasukKamar\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk masuk kamar",
                                        ))'
                            )
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
             </div>
         </div>
     </div>
 </div>
 <?php
    // Dialog untuk masuk kamar jenazah =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogMasukKamar',
        'options' => array(
            'title' => 'Masuk Kamar Jenazah',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 950,
            'height' => 450,
            'resizable' => true,
        ),
    ));
    ?>
 <iframe src="" name="iframeMasukKamar" style="width: 100%; height: 98%;">
 </iframe>
 <?php
    $this->endWidget();
    //========= end masuk kamar jenazah =============================
    ?>
 <script>
     //document.getElementById('PJInfoKunjunganRDV_tgl_awal_date').setAttribute("style","display:none;");
     //document.getElementById('PJInfoKunjunganRDV_tgl_akhir_date').setAttribute("style","display:none;");
     function cekTanggal() {
         var checklist = $('#PJInfoKunjunganRDV_ceklis');
         var pilih = checklist.attr('checked');
         if (pilih) {
             document.getElementById('PJInfoKunjunganRDV_tgl_awal_date').setAttribute("style", "display:block;");
             document.getElementById('PJInfoKunjunganRDV_tgl_akhir_date').setAttribute("style", "display:block;");
         } else {
             document.getElementById('PJInfoKunjunganRDV_tgl_awal_date').setAttribute("style", "display:none;");
             document.getElementById('PJInfoKunjunganRDV_tgl_akhir_date').setAttribute("style", "display:none;");
         }
     }
 </script>