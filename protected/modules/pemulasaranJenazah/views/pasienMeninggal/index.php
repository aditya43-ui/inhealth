 <?php
    $this->breadcrumbs = array(
        'Informasi Pasien Meninggal',
    );
    $arrMenu = array();
    $this->menu = $arrMenu;
    $this->widget('bootstrap.widgets.BootAlert');
    ?>
 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="entypo-info-circled"></i> Informasi <b>Pasien Meninggal</b>
         </div>
     </div>
     <div class="panel-body">
         <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
            ?>
         <?php $this->renderPartial('_searchPasienMeninggal', array('model' => $model, 'format' => $format)); ?>
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="entypo-credit-card"></i> Tabel <b>Pasien Meninggal</b>
                 </div>
             </div>
             <div class="panel-body table-responsive">
                 <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'daftarPasien-grid',
                        'dataProvider' => $model->searchPasienMeninggal(),
                        //        'filter'=>$model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                        'columns' => array(
                            array(
                                'name' => 'tgl_pendaftaran',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                            ),
                            'no_pendaftaran',
                            array(
                                'header' => 'Tanggal Meninggal',
                                'value' => '$data->tanggalMeninggal'
                            ),
                            'no_rekam_medik',
                            array(
                                'header' => 'Nama Pasien / Panggilan',
                                'value' => '$data->namaPasienNamaBin'
                            ),
                            array(
                                'header' => 'Cara Masuk',
                                'value' => '$data->caramasuk_nama'
                            ),
                            array(
                                'header' => 'Instalasi',
                                'value' => '$data->instalasi_nama'
                            ),
                            'alamat_pasien',
                            array(
                                'header' => 'Jenis Penjamin',
                                'value' => '$data->carabayar_nama'
                            ),
                            array(
                                'header' => 'Penjamin',
                                'value' => '$data->penjamin_nama'
                            ),
                            array(
                                'header' => 'Kondisi Pulang',
                                'value' => '$data->kondisipulang'
                            ),
                            //                        array(
                            //                            'header'=>'Masuk Kamar Jenazah',
                            //                            'type'=>'raw',
                            //                            'htmlOptions'=>array('style'=>'text-align:left;'),
                            //                            'value'=>'($data->pasienmasukpenunjang_id!=null)?"Sudah Masuk":CHtml::Link("<i class=\"icon-form-mkjenazah\"></i>",Yii::app()->controller->createUrl("masukKamarJenazah/index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>Params::INSTALASI_ID_RD)),
                            //                                        array("class"=>"", 
                            //                                              "target"=>"iframeMasukKamar",
                            //                                              "onclick"=>"$(\"#dialogMasukKamar\").dialog(\"open\");",
                            //                                              "rel"=>"tooltip",
                            //                                              "title"=>"Klik untuk masuk kamar",
                            //                                        ))'
                            //                        )
                            array(
                                'header' => 'Masuk Kamar Jenazah',
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align:left;'),
                                'value' => '($data->getStatusPasienMeninggalMasuk($data->pendaftaran_id) == 1)?"Sudah Masuk":CHtml::Link("<i class=\"icon-form-mkjenazah\"></i>",Yii::app()->controller->createUrl("masukKamarJenazah/index",array("pendaftaran_id"=>$data->pendaftaran_id,"instalasi_id"=>Params::INSTALASI_ID_RD)),
                                        array("class"=>"", 
                                              "target"=>"iframeMasukKamar",
                                              "onclick"=>"$(\"#dialogMasukKamar\").dialog(\"open\");",
                                              "rel"=>"tooltip",
                                              "title"=>"Klik untuk masuk kamar",
                                        ))'
                            ),
                            array(
                                'header' => 'Batal',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return CHtml::link("<i class='icon-form-silang'></i>", "javascript:batalperiksa(" . $data->pendaftaran_id . ")", array("id" => $data->no_pendaftaran, "rel" => "tooltip", "title" => "Klik untuk membatalkan pasien meninggal", "data-placement" => "left"));
                                },
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
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
 <iframe src="" name="iframeMasukKamar" width="100%" height="450"></iframe>
 <?php
    $this->endWidget();
    //========= end masuk kamar jenazah =============================
    ?>
 <script type="text/javascript">
     //document.getElementById('PJDaftarpasienmeninggalV_tgl_awal_date').setAttribute("style","display:none;");
     //document.getElementById('PJDaftarpasienmeninggalV_tgl_akhir_date').setAttribute("style","display:none;");
     function cekTanggal() {
         var checklist = $('#PJDaftarpasienmeninggalV_ceklis');
         var pilih = checklist.attr('checked');
         if (pilih) {
             document.getElementById('PJDaftarpasienmeninggalV_tgl_awal_date').setAttribute("style", "display:block;");
             document.getElementById('PJDaftarpasienmeninggalV_tgl_akhir_date').setAttribute("style", "display:block;");
         } else {
             document.getElementById('PJDaftarpasienmeninggalV_tgl_awal_date').setAttribute("style", "display:none;");
             document.getElementById('PJDaftarpasienmeninggalV_tgl_akhir_date').setAttribute("style", "display:none;");
         }
     }

     function batalperiksa(pendaftaran_id) {
         myConfirm('Anda yakin akan membatalkan Pasien Meninggal ini?', 'Perhatian!', function(r) {
             if (r) {
                 $.post('<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalMeninggal') ?>', {
                         pendaftaran_id: pendaftaran_id
                     },
                     function(data) {
                         if (data.status == 'ok') {
                             myAlert(data.keterangan);
                             $('#daftarPasien-grid').yiiGridView('update');
                         } else {
                             myAlert(data.keterangan);
                         }
                     }, 'json'
                 );
             }
         });
     }
 </script>