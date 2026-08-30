<?php
/**
 * Halaman ini digunakan untuk menampilkan informasi SIP
 * @author Aida Rahmawati <aidarahmawati@.com>
 */

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#daftarpasien-t-search').submit(function(){
            $.fn.yiiGridView.update('daftarpasien-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Daftar Pasien</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Daftar Pasien</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: auto; max-width: 100%">
                        <?php
                        $this->widget('ext.bootstrap.widgets.BootGridView', array(
                            'id' => 'daftarpasien-t-grid',
                            'dataProvider' => $model->searchPasienMikrobiologi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'columns' => array(
                                array(
                                    'header' => 'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align:left;'),
                                ),
                                array(
                                    'header' => 'Tgl. Pendaftaran<br/>No. Pendaftaran',
                                    'name' => 'tgl_pendaftaran',
                                    'type' => 'raw',
                                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br/>".$data->no_pendaftaran',
                                ),
                                array(
                                    'header' => 'Tgl. Masuk Penunjang<br/>No. Penunjang',
                                    'name' => 'no_masukpenunjang',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        return MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) . "<br/>" . $data->no_masukpenunjang;
                                    }
                                ),
                                array(
                                    'header' => 'Ruangan/<br/>Dokter Perujuk',
                                    'name' => 'ruanganasal_nama',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        $pegawai = PegawaiM::model()->findByAttributes(array(
                                            'nama_pegawai' => $data->nama_dokterasal,
                                        ));
                                        return $data->ruanganasal_nama . "/<br/>" . (empty($pegawai) ? "-" : $pegawai->namaLengkap);
                                    },
                                ),
                                array(
                                    'name' => 'no_rekam_medik',
                                    'type' => 'raw',
                                    'header' => 'No. RM',
                                    'value' => '$data->no_rekam_medik',
                                ),
                                array(
                                    'header' => 'Nama Pasien',
                                    'type' => 'raw',
                                    'value' => '(($data->instalasiasal_id == ' . PARAMS::INSTALASI_ID_MIKROBIOLOGI . ') ? CHtml::link("<i class=\"icon-form-ubah\"></i> ".$data->namadepan.$data->nama_pasien, Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ubahPasien",array("id"=>"$data->pasien_id","pendaftaran_id"=>"$data->pendaftaran_id","modul_id"=>"' . Yii::app()->session['modul_id'] . '")), array("rel"=>"tooltip","title"=>"Klik untuk mengubah data pasien")) : $data->namadepan.$data->nama_pasien )',
                                ),
                                array(
                                    'header' => 'Jenis Kelamin/<br/>Umur',
                                    'type' => 'raw',
                                    'value' => '$data->jeniskelamin."/<br/>".$data->umur',
                                ),
                                'alamat_pasien',
                                array(
                                    'header' => 'Jenis Penjamin /<br/> Penjamin',
                                    'name' => 'CaraBayarPenjamin',
                                    'type' => 'raw',
                                    'value' => '$data->caraBayarPenjamin',
                                    'htmlOptions' => array('style' => 'text-align: left; width:40px')
                                ),
                                array(
                                    'header' => 'DPJP',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        if (isset($data->pegawai_id)) {
                                            return CHtml::link(
                                                            $data->gelardokterasal.$data->nama_pegawai.$data->gelarbelakang_nama, Yii::app()->controller->createUrl("daftarPasien/UbahDokterDPJTM", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip",
                                                        "title" => "Klik untuk mengubah DPJTM",
                                                        "target" => "iframeUbahDokterDPJTM",
                                                        "onclick" => "$(\"#dialogDokterDPJTM\").dialog(\"open\");",
                                                            )
                                            );
                                        } else {
                                            return CHtml::link(
                                                            '<i style="font-size:20px" class="entypo-pencil"></i>', Yii::app()->controller->createUrl("daftarPasien/UbahDokterDPJTM", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip",
                                                        "title" => "Klik untuk menambahkan DPJTM",
                                                        "target" => "iframeUbahDokterDPJTM",
                                                        "onclick" => "$(\"#dialogDokterDPJTM\").dialog(\"open\");",
                                                            )
                                            );
                                        }
                                    }
                                ),

                                array(
                                    'header' => 'Analis',
                                    'type' => 'raw',
                                    'value' => function($data) {

                                        $analis = ' - ';
                                        if(!empty($data->pasienmasukpenunjang_id)) {
                                            $penunjang = PasienmasukpenunjangT::model()->findByPk($data->pasienmasukpenunjang_id);
                                            if(!empty($penunjang->perawat_id)) {

                                                $perawat = PegawaiM::model()->findByPk($penunjang->perawat_id);
                                            
                                                $analis = $perawat->namaLengkap;

                                            }
                                        }

                                        return $analis;
                                    }
                                ),

                                array(
                                    'header' => 'No. Lab',
                                    'type' => 'raw',
                                    'value' => function($data) {

                                        $no_lab = '';
                                        $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
                                            'pasienmasukpenunjang_id'=>$data->pasienmasukpenunjang_id
                                        ), array(
                                            'condition'=>'no_lab is not null'
                                        ));

                                        $sbl = '';
                                        foreach ($tindakan as $item) {

                                            $skr = $item->no_lab;

                                            if($sbl !== $skr) {
                                                $no_lab .= $item->no_lab."<br/>";
                                            }

                                            $sbl = $skr;
                                        }

                                        echo $no_lab;
                                        // echo '<br>';

                                        $ambil = PengambilansampleT::model()->find("pasienmasukpenunjang_id = " . intval($data->pasienmasukpenunjang_id)+2);

                                        if(!empty($ambil)) {
                                            echo CHtml::link(Yii::t('mds', 'Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeLabMikro(" . intval($data->pasienmasukpenunjang_id)+2 . ");return false;"));
                                        } else {
                                            echo CHtml::link(Yii::t('mds', 'Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                                        }

                                        // echo $data->pasienmasukpenunjang_id;
                                    }
                                ),

                                array(
                                    'header' => 'Status',
                                    'type' => 'raw',
                                    'value' => function($data) {

                                        $kel = KelompokpemeriksaanmikroT::model()->find('pasienmasukpenunjang_id = ' . $data->pasienmasukpenunjang_id);

                                        return !empty($kel) ? "Sudah Diperiksa" : "Belum Diperiksa";
                                    }
                                ),

                                array(
                                    'header' => 'Hasil Analis',
                                    'type' => 'raw',
                                    'value' => function($data) {

                                        if(empty($data->pasienmasukpenunjang_id)) {
                                            return  CHtml::Link(
                                                "<i class='icon-form-input'></i>", 'javascript:void(0)',
                                                array(
                                                    "class" => "", "onclick" => 'myAlert("Tidak ada pasien penunjang")',
                                                    "rel" => "tooltip", "title" => "Klik untuk merubah Hasil Analis",
                                                ));
                                        } else {
                                            return CHtml::link(
                                                "<icon class='icon-form-input'></icon>", Yii::app()->controller->createUrl("daftarPasien/hasilAnalis", array("penilaian_kelayakan_spesimen_id" => $data->penilaian_kelayakan_spesimen_id, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)), array("rel" => "tooltip",
                                                "title" => "Klik untuk mengisi hasil analis" 
                                                )
                                            );
                                        }

                                    }
                                ),
                                /*
                                array(
                                    'header' => 'Nota Tindakan',
                                    'type' => 'raw',
                                    'value' => function ($data) {

                                        $pendaftaran = '';

                                        if(!empty($data->pasienmasukpenunjang_id)) {
                                            $pendaftaran = $data->pendaftaran_id;
                                        }

                                        return CHtml::link("<icon class='icon-form-detail'></icon>", Yii::app()->controller->createUrl("/rehabMedis/daftarPasien/RincianTagihanPenunjang", array("pendaftaran_id" => $pendaftaran, "pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id, "instalasi_id" => "", "pasienadmisi_id" => "", 'is_mikrobiologi' => 1, "frame" => true)), array("target"=>"frameRincian", "onclick"=>"$('#dialogRincian').dialog('open');"));
                                    },
                                     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),

                                ),
                                */
                                array(
                                    'header' => 'Cetak Ulang Nota Tindakan',
                                    'type' => 'raw',
                                    'value' => function($data) {
                                        /*
                                        return CHtml::link("<i class='icon-form-print'></i>",'javascript:void(0);', array(
                                            'onclick'=>"printUlangNotaTindakan(". $data->pendaftaran_id .");return false",
                                            'disabled'=>FALSE,
                                            "rel"=>"tooltip",
                                            "title"=>"Klik untuk Cetak Ulang Nota Tindakan",  ));
                                        */
                                        return  CHtml::link(
                                                Yii::t(
                                                    'mds',
                                                    '{icon}',
                                                    array('{icon}' => '<i class="icon-form-print"></i>')
                                                ),
                                                Yii::app()->controller->createUrl("/rawatJalan/tindakan/printUlangTindakanPenunjangDialog", array("pasienmasukpenunjang_id" => $data->pasienmasukpenunjang_id)),
                                                array(
                                                    "title" => "Klik untuk Cetak Ulang Nota Tindakan", 
                                                    "target" => "iframeCetakUlang", 
                                                    "onclick" => '$("#dialogCetakUlang").dialog("open");', 
                                                    "rel" => "tooltip", 
                                                ));
                                    }
                                ),


                                array(
                                    'header' => 'CPPT',
                                    'type' => 'raw',
                                    'value' => function ($data) {

                                        if($data->ruanganasal_id != 1131) {
                                          echo CHtml::link("<i class='icon-bayarklaim'></i> ",  Yii::app()->controller->createUrl(
                                                "/rekamMedis/CPPTRK/index",
                                                array("pendaftaran_id" => $data->pendaftaran_id)
                                            ), array("target" => "detailDialog", "rel" => "tooltip", "title" => "Klik untuk Detail CPPT", "onclick" => "var text = $(this).attr('dialog-text'); window.parent.$('#ui-dialog-title-dialogDetailData').text(text);window.parent.$('#dialogDetailData').dialog('open');", "dialog-text" => "Riwayat CPPT"));                        
                                          
                                        }else{
                                           echo ""; 
                                        }
                                    
                                       },
                                ),



                               
                                // array(
                                //     'header' => 'Penilaian Kelayakan Spesimen',
                                //     'type' => 'raw',
                                //     'htmlOptions' => array('style' => 'text-align:center;'),
                                //     'value' => function($data) {
                                //         if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                                //             return CHtml::Link("<i class='icon-form-periksa'></i>", 'javascript:;', array("class" => "icon-form-periksa",
                                //                         "id" => "selectPasien",
                                //                         "rel" => "tooltip",
                                //                         "title" => "Klik untuk periksa pasien",
                                //                         'onclick' => 'toastr.warning("Anda tidak dapat menginput pemeriksan, karena status pasien ' . $data->statusperiksa . '","Perhatian !")'
                                //             ));
                                //         } else {
                                //             return CHtml::Link("<i class='icon-form-periksa'></i>", Yii::app()->controller->createUrl("PenilaianKelayakanSpesimen/index", array("pasienkirimkeunitlain_id" => $data->pasienkirimkeunitlain_id)), array("class" => "icon-form-periksa",
                                //                         "id" => "selectPasien",
                                //                         "rel" => "tooltip",
                                //                         "title" => "Klik untuk penilaian spesimen",
                                //             ));
                                //         }
                                //     },
                                // ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        ));
                        ?>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> <b> Pencarian </b> </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
    function cekForm(obj){
            $("#suratsponsor-r-search :input[name='"+ obj.name +"']").val(obj.value);
    }
    function print(caraPrint){
            window.open("${urlPrint}/"+$('#suratsponsor-r-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogCetakUlang',
    'options' => array(
        'title' => '<span style="width: 100%"> <span style="float: left !important; width:80% !important;">Cetak Ulang</span>',
        'autoOpen' => false,
        'modal' => true,
        'width' => 400,
        'height' => 400,
        'resizable' => true
    ),
));
?>
<iframe name='iframeCetakUlang' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

    <?php
// Dialog dokter DPJTM =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDokterDPJTM',
    'options' => array(
        'title' => 'Ubah DPJTM',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 950,
        'minHeight' => 450,
        'resizable' => true,
        'close' => "js:function(){ $.fn.yiiGridView.update('daftarpasien-v-grid'); }",
    ),
));
?>
    <iframe src="" name="iframeUbahDokterDPJTM" width="100%" height="500">
    </iframe>

    <?php
$this->endWidget();
//========= end Ubah Dokter =============================
?>

    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
                    'id' => 'dialogRincian',
                    'options' => array(
                        'title' => 'Rincian Tagihan Pasien',
                        'autoOpen' => false,
                        'modal' => true,
                        'width' => 900,
                        'height' => 600,
                        'resizable' => false,
                    ),
                ));
                ?>
    <iframe name='frameRincian' style="width: 100%; height: 98%;"></iframe>
    <?php $this->endWidget(); ?>

    <script>

function printBarcodeLabMikro(pasienmasukpenunjang_id) {
    console.log('penunjang: '+pasienmasukpenunjang_id);
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/pendaftaranLaboratoriumRujukanRSMK/PrintBarcode2', array()); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,
        'printwin', 'left=100,top=100,width=700,height=640');

}

    </script>