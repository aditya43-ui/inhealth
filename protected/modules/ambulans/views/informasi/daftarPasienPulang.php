<?php
$this->breadcrumbs = array(
    'Daftar Pasien Pulang',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Daftar <b>Pasien Pulang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Daftar Pasien Pulang',
        );
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
        <?php $this->renderPartial('_searchPasienPulang', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Pulang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'daftarPasien-grid',
                    'dataProvider' => $model->searchPasienPulang(),
                    //        'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'Instalasi / Ruangan',
                            //'value'=>'$data->instalasi_nama." / ".$data->ruangan_nama',
                            'value' => '(isset($data->instalasi_id)?$data->instalasi_nama:"-")." / ".(isset($data->ruangan_id)?$data->ruangan_nama:"-")',
                        ),
                        array(
                            'header' => 'Cara Pulang / Kondisi Pulang',
                            'value' => '(isset($data->carakeluar_id)?$data->carakeluar:"-")." / ".(isset($data->kondisikeluar_id)?$data->kondisipulang:"-")',
                        ),
                        array(
                            'header' => 'No. RM / No. Pendaftaran',
                            'value' => '$data->no_rekam_medik." / ".$data->no_pendaftaran',
                        ),
                        array(
                            'header' => 'Nama Pasien',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Umur',
                            'value' => '$data->umur',
                        ),
                        array(
                            'header' => 'Jenis Kelamin',
                            'value' => '$data->jeniskelamin',
                        ),
                        array(
                            'header' => 'Alamat',
                            'value' => '$data->alamat_pasien',
                        ),
                        array(
                            'header' => 'Kelurahan',
                            'value' => '$data->kelurahan_nama',
                        ),
                        array(
                            'header' => 'Penerima Pasien',
                            'value' => '',
                        ),
                        array(
                            'header' => 'Lama Dirawat',
                            'value' => '$data->lamarawat." ".$data->satuanlamarawat',
                        ),
                        array(
                            'header' => 'Kasus Penyakit',
                            'value' => '$data->jeniskasuspenyakit_nama',
                        ),
                        array(
                            'header' => 'Dirujuk Ke',
                            'type' => 'raw',
                            'value' => '(!empty($data->rujukankeluar_id)) ? CHtml::link("<i class=\"icon-eye-open\"></i>", "javascript:void(0);", 
														array("rel"=>"tooltip",
															  "title"=>"Klik untuk melihat detail",
															  "onclick"=>"detailRujukan(\'$data->rumahsakitrujukan\',
																						\'$data->alamatrsrujukan\',
																						\'$data->telp_fax\',
																						\'$data->tgldirujuk\',
																						\'$data->kepadayth\',
																						\'$data->dirujukkebagian\',
																						\'$data->alasandirujuk\',
																						\'$data->hasilpemeriksaan_ruj\',
																						\'$data->diagnosasementara_ruj\',
																						\'$data->pengobatan_ruj\',
																						\'$data->lainlain_ruj\',
																						\'$data->catatandokterperujuk\');return false;"))." ".$data->rumahsakitrujukan : " " ',
                        ),
                        array(
                            'header' => 'Pemakaian Ambulans',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            //                    'value'=>'(empty($data->pemakaianambulans_id)) ? CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
                            //                                           Yii::app()->controller->createUrl("transaksi/pemakaian",array("pendaftaran_id"=>$data->pendaftaran_id,
                            //                                                                                                         "modul_id"=>Yii::app()->session["modul_id"])),
                            //                                           array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk pemakaian Ambulans")) : ""',
                            'value' => '(empty($data->pemakaianambulans_id)) ? CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
													   Yii::app()->controller->createUrl("pemakaianAmbulanPasienRS/index",array("pendaftaran_id"=>$data->pendaftaran_id,
																													 "modul_id"=>Yii::app()->session["modul_id"])),
													   array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk pemakaian Ambulans")) : ""',
                        )
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    //document.getElementById('AMPasienpulangrddanriV_tgl_awal_date').setAttribute("style","display:none;");
    //document.getElementById('AMPasienpulangrddanriV_tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal() {
        var checklist = $('#AMPasienpulangrddanriV_ceklis');
        var pilih = checklist.attr('checked');
        if (pilih) {
            document.getElementById('AMPasienpulangrddanriV_tgl_awal_date').setAttribute("style", "display:block;");
            document.getElementById('AMPasienpulangrddanriV_tgl_akhir_date').setAttribute("style", "display:block;");
        } else {
            document.getElementById('AMPasienpulangrddanriV_tgl_awal_date').setAttribute("style", "display:none;");
            document.getElementById('AMPasienpulangrddanriV_tgl_akhir_date').setAttribute("style", "display:none;");
        }
    }

    function detailRujukan(rumahsakitrujukan, alamatrsrujukan, telp_fax, tgldirujuk, kepadayth, dirujukkebagian, alasandirujuk, hasilpemeriksaan_ruj, diagnosasementara_ruj, pengobatan_ruj, lainlain_ruj, catatandokterperujuk) {
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'rumahsakitrujukan') ?>').val(rumahsakitrujukan);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'alamatrsrujukan') ?>').val(alamatrsrujukan);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'telp_fax') ?>').val(telp_fax);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'tgldirujuk') ?>').val(tgldirujuk);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'kepadayth') ?>').val(kepadayth);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'dirujukkebagian') ?>').val(dirujukkebagian);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'alasandirujuk') ?>').val(alasandirujuk);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'hasilpemeriksaan_ruj') ?>').val(hasilpemeriksaan_ruj);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'diagnosasementara_ruj') ?>').val(diagnosasementara_ruj);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'pengobatan_ruj') ?>').val(pengobatan_ruj);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'lainlain_ruj') ?>').val(lainlain_ruj);
        $('#dialogDetailRujukan #<?php echo CHtml::activeId($model, 'catatandokterperujuk') ?>').val(catatandokterperujuk);
        $('#dialogDetailRujukan').dialog('open');
    }
</script>
<?php
//========== Dialog untuk detail rujukan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailRujukan',
    'options' => array(
        'title' => 'Detail Rujukan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 300,
        'resizable' => false,
    ),
));
$this->renderPartial('_detailRujukan', array('model' => $model));
$this->endWidget();
//========= end pasienpulang_t dialog =============================
?>