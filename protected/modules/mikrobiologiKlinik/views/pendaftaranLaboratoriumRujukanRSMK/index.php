<style>
.tbl-visual {
    width: 100%l
}

.tbl-visual tr,
.tbl-visual td {
    border: 1px solid black;
}
</style>

<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan' => array('rujukanPenunjang/index'),
    'Rujukan Rumah Sakit',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pendaftaran Mikrobiologi Klinik <b>Rujukan Rumah Sakit</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemeriksaanlaboratorium-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {

            $this->widget('bootstrap.widgets.BootAlert');
        }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Rujukan</b>
                    <span class='tombol'
                        style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <!--fieldset class="box"-->
                <div class="row">
                    <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
                <!--</fieldset>-->
            </div>
        </div>

        <div class="row" style="margin-top: 17px;">
            <div class="col-md-5 col-sm-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan Laboratorium</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->renderPartial($this->path_view.'_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>

                        <?php /*
                            <div class="block-tabel">
                                <h6>Kirim <b>SMS</b></h6>
                                <div>
                                    <?php 
                                    if(Yii::app()->user->getState('issmsgateway')){
                                       $this->renderPartial($this->path_view.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
                                    }
                                    ?>
                    </div>
                </div>
                *if($instalasi !== Params::INSTALASI_ID_LAB) {echo 'hidden';}
                */ ?>

            </div>
        </div>
        <?php // if (!isset($_GET['sukses'])) { 
            $instalasi = Yii::app()->user->getState('instalasi_id');            
            ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Permintaan ke Penunjang</b>
                </div>
            </div>
            <div class="panel-body">
                <div id="form-permintaankepenunjang" style="margin-bottom: 17px;" class="table-responsive">
                    <table class="table table-bordered table-condensed table-striped">
                        <thead>
                            <th>No.</th>
                            <th hidden>Jenis Permintaan</th>
                            <th hidden>Sub Jenis Pemeriksaan</th>
                            <th>Jenis Pemeriksaan</th>
                            <th width="80%">Pemeriksaan</th>
                            <th>Sample Lab</th>
                            <th>Cara Ambil Sample</th>
                            <th>Kode Tarif</th>
                            <th>Harga</th>
                            <th>Kelas</th>
                            <!-- <th>Tarif</th> -->
                            <th>Status</th>
                            <th>Tambah</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <?php
                     $kirim = PasienkirimkeunitlainT::model()->findByPk($modKunjungan->pasienkirimkeunitlain_id);
                     $permintaan = PermintaankepenunjangT::model()->find("pasienkirimkeunitlain_id = " . $modKunjungan->pasienkirimkeunitlain_id . " order by pasienkirimkeunitlain_id desc");
                ?>

                <?php
                

                    if($kirim->is_nonprogram || $kirim->is_nonprogram == null && !($kirim->is_programtbc) && !($kirim->is_programhiv)) {


                
                ?>

                <div class="control-group">
                    <?php echo CHtml::label("Waktu Pengambilan", 'waktu_pengambilan', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('waktu_pengambilan', empty($kirim->waktuambilspesimen) ? "" : MyFormatter::formatDateTimeForUser($kirim->waktuambilspesimen) , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Temp. Aksiler", 'temp_aksiler', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('temp_aksiler', $kirim->temp_aksiler , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Antibiotik yang diberikan", 'antibiotikygdiberi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('antibiotikygdiberi', $kirim->antibiotikygdiberi , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Tindakan Medik", 'tindakan_medik', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php 

                        $str = "";

                        if (!empty($kirim->klinis_penunjang_infeksi)) {
                            $klinis_penunjang = CJSON::decode($kirim->klinis_penunjang_infeksi);
                            
                            if ($klinis_penunjang !== false) {
                                $kirim->klinis_penunjang_infeksi = implode(", ", $klinis_penunjang);
                            }
                        }

                        $str = $kirim->klinis_penunjang_infeksi." (".($kirim->keteranganklinislain ?? "-").")";
                        
                        echo CHtml::textField('tindakan_medik', $str , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
                        ?>
                    </div>
                </div>
                <?php if($instalasi !== Params::INSTALASI_ID_LAB_PA) { ?>
                <div class="control-group hide">
                    <?php echo CHtml::label("Waktu ambil sample", 'waktuambilspesimen', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php 
        // $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForUser($modPasienMasukPenunjang->tgl_tindakan);
                        $this->widget('MyDateTimePicker',array(
                                            'model' => $kirim,
                                            'attribute' => 'waktuambilspesimen',
                                            'mode'=>'time',
                                            'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                        ),
                                            'htmlOptions'=>array('class'=>'span3', 'readonly' => true,
                                            'onkeypress'=>"return $(this).focusNextInputField(event)"),
                        )); 
                    ?>
                    </div>
                </div>
                <?php } ?>

                <div class="control-group">
                    <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('pegawai_id', $modKunjungan->pegawai_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('nama_pegawai', $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("PPDS Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::hiddenField('ppds_id', $modKunjungan->ppds_id, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo CHtml::textField('ppds_nama', $modKunjungan->ppds_nama , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <?php if($instalasi !== Params::INSTALASI_ID_LAB_PA) { ?>

                <div class="control-group" hidden>
                    <?php echo CHtml::label("No. Telepon PPDS", 'pegawai_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('no_ppds', $modKunjungan->no_ppds , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Catatan Dokter Perujuk", 'catatandokterpengirim', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textArea('catatandokterpengirim', $modKunjungan->catatandokterpengirim, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <?php } ?>
                <?php }  else if($kirim->is_programtbc) {//end nonprogram ?>

                <div class="control-group">
                    <label class="control-label">No. Identitas Sediaan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('no_sediaan', $permintaan->no_sediaan, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label("Jenis Terduga Pasien TBC", 'jenis_pasientbc', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('jenis_pasientbc', $permintaan->jenis_pasientbc, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tanggal Pengambilan Contoh Uji</label>
                    <div class="controls">
                        <?php echo CHtml::textField('waktuambilspesimen', $kirim->waktuambilspesimen , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tanggal Pengiriman Contoh Uji</label>
                    <div class="controls">
                        <?php echo CHtml::textField('tglpengirimanspesimen', $kirim->tglpengirimanspesimen , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Contoh Uji</label>
                    <div class="controls">
                        <?php
                            $sample = !empty($permintaan->samplelab_id) ? $permintaan->samplelab->samplelab_nama : null;
                        ?>

                        <?php echo CHtml::textField('samplelab', $sample , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

                    </div>
                </div>
                <center>
                    <label>
                        <span style="font-weight: bold; text-align: center;">Secara Visual Dahak Tampak (Checklist pada
                            kotak)</span>
                    </label>
                </center>
                <table class="tbl-visual" style="width: 700px;" ;>
                    <tr>
                        <td style="">
                            <b><br><br>&emsp;&emsp;&emsp;&emsp;Sewaktu/Pagi<br><br>&emsp;&emsp;&emsp;&emsp;Sewaktu/Pagi</br>
                        </td>
                        <td style=""><b>&emsp;&emsp;&emsp;&emsp;Nanah Lendir<br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                <?php echo $form->checkBox($permintaan, 'is_visual_lendirnanah1', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                                <br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                <?php echo $form->checkBox($permintaan, 'is_visual_lendirnanah2', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                                </br></td>
                        <td style=""><b>&emsp;&emsp;&emsp;&emsp;Bercak Darah<br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                <?php echo $form->checkBox($permintaan, 'is_visual_bercakdarah1', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                                <br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                <?php echo $form->checkBox($permintaan, 'is_visual_bercakdarah2', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                                </br></td>
                        </td>
                        <td style=""><b>&emsp;&emsp;&emsp;&emsp;&emsp;Air
                                Liur<br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                <?php echo $form->checkBox($permintaan, 'is_visual_airliur1', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                                <br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                                <?php echo $form->checkBox($permintaan, 'is_visual_airliur2', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                                </br></td>
                    </tr>
                </table>
                <div class="control-group">
                    <label class="control-label">Lokasi Anatomi</label>
                    <div class="controls">
                        <?php echo CHtml::textField('lokasianatomi', $permintaan->lokasianatomi , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Alasan Pemeriksaan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('alasanpemeriksaan', $permintaan->alasanpemeriksaan , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pemantauan Kemajuan </label>
                    <div class="controls">
                        <?php echo CHtml::textField('pemantauan_kemajuan', $permintaan->pemantauan_kemajuan , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pemeriksaan Ulang </label>
                    <div class="controls">
                        <?php echo CHtml::textField('pemeriksaan_ulang', $permintaan->pemeriksaan_ulang , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Pemeriksaan Setelah Selesai Pengobatan </label>
                    <div class="controls">
                        <?php echo CHtml::textField('pemeriksaan_selesai', $permintaan->pemeriksaan_selesai , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Reg. TBC/TBC RO Fasyankes</label>
                    <div class="controls">
                        <?php echo CHtml::textField('no_reg_fasyankes', $permintaan->no_reg_fasyankes , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Reg. TBC/TBC RO Kab./Kota</label>
                    <div class="controls">
                        <?php echo CHtml::textField('no_reg_kabkota', $permintaan->no_reg_kabkota , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter Perujuk</label>
                    <div class="controls">
                        <?php echo CHtml::textField('pegawai', $kirim->pegawai->namaLengkap , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">PPDS Perujuk</label>
                    <div class="controls">
                        <?php echo CHtml::textField('ppds', !empty($kirim->ppds) ? $kirim->ppds->ppds_nama : null, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

                <?php }  else if($kirim->is_programhiv) { ?>

                <div class="control-group">
                    <label class="control-label">Waktu Pengambilan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('waktuambilspesimen', $kirim->waktuambilspesimen, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Sampel</label>
                    <div class="controls">
                        <?php $sample = !empty($permintaan->samplelab_id) ? $permintaan->samplelab->samplelab_nama : null; ?>
                        <?php echo CHtml::textField('samplelab', $sample , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Dokter Perujuk</label>
                    <div class="controls">
                        <?php echo CHtml::textField('pegawai', $kirim->pegawai->namaLengkap , array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">PPDS Perujuk</label>
                    <div class="controls">
                        <?php echo CHtml::textField('ppds', !empty($kirim->ppds) ? $kirim->ppds->ppds_nama : null, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('catatandokterpengirim', $kirim->catatandokterpengirim, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls">
                        <?php echo CHtml::textField('is_cito', ($kirim->is_cito == 1 ? "Cyto" : "Biasa"), array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

                <?php } // end if hiv ?>

                <div class="control-group">
                    <?php echo CHtml::label("Cyto", 'is_cyto', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php 
                                    
                            if($modKunjungan->is_cyto == 1){
                                $modKunjungan->is_cyto = 'Cyto';
                                echo CHtml::textField('is_cyto', $modKunjungan->is_cyto, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                            }else{
                                $modKunjungan->is_cyto = 'Biasa';
                                echo CHtml::textField('is_cyto', $modKunjungan->is_cyto, array('readonly' => true, 'class' => 'span4', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                            }
                                
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <?php echo $form->hiddenField($modPasienMasukPenunjang, 'is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-karcis',
                    'content' => array(
                        'content-karcis' => array(
                            'header' => '<b>Karcis</b>',
                            'isi' => '<div id="content-karcis-html">'
                                . $this->renderPartial($this->path_view . '_formKarcis', array(
                                    'form' => $form,
                                    'model' => $modPasienMasukPenunjang,
                                    'modTindakan' => $modTindakan,
                                    'modKarcisV' => $modKarcisV
                                ), true)
                                . '</div>',
                            'active' => $modPasienMasukPenunjang->is_adakarcis,
                        ),
                    ),
                )); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemakaian Bahan
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                            if (isset($_GET['sukses'])) {
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'riwayat-obatalkespasien-t',
                                    'content' => array(
                                        'content-riwayat-obatalkespasien-t' => array(
                                            'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                                            'isi' => '
													<table class="table table-condensed table-bordered">
														<thead>
															<th>No.</th>
															<th>Tgl. Pelayanan</th>
															<th>Obat / Alat Kesehatan</th>
															<th>Satuan Kecil</th>
															<th>Jumlah</th>
															<th>Hapus</th>
														</thead>
														<tbody>
															<tr><td colspan=7>Data tidak ditemukan</td></tr>
														</tbody>
													</table>',
                                            'active' => true,
                                        ),
                                    ),
                                ));
                            } else {
                            ?>
                    <div class="col-sm-12">
                        <!--fieldset class="box2"-->
                        <div id="form-tambahobatalkes">
                            <!--<div class="row box">-->
                            <?php $this->renderPartial($this->path_view.'_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
                            <!--</div>-->
                        </div>
                        <!--</fieldset>-->
                    </div>
                    <div class="col-sm-12">
                        <div class="panel panel-default panel-primary">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <i class="entypo-credit-card"></i> Tabel <b>Obat dan Alat Kesehatan</b>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table class="items table table-bordered table-striped table-condensed"
                                    id="table-obatalkespasien">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Obat / Alat Kesehatan</th>
                                            <!--th>Satuan Kecil</th-->
                                            <!--RND-3097 <th>Harga</th>-->
                                            <!--th>Stok</th-->
                                            <th>Jumlah</th>
                                            <!--RND-3097 <th>Sub Total</th>-->
                                            <th>Batal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                            }
                            ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7">

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                    <?php 
                            // echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); 
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-mini btn-success', 'type' => 'button', "onclick" => "$('#dialogLab').dialog('open')", 'rel' => 'tooltip', 'title' => 'Klik untuk menambah pemeriksaan')); 
                            ?>
                </div>
            </div>
            <div id="form-tindakanpemeriksaan" class="panel-body table-responsive">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>No.</th>
                        <th>No. Lab</th>
                        <th>Jenis Pemeriksaan</th>
                        <th>Uraian Tindakan</th>
                        <th>Sample Lab</th>
                        <th>Cara Ambil</th>
                        <th>Kode Tindakan</th>
                        <th>Jumlah</th>
                        <th>Nominal Tarif</th>
                        <th hidden>Harga</th>
                        <th>Total Tarif</th>
                        <th>Batal</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php
            if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            }
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->module->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                    )
                );
            }
            if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));

            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Cetak Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Pemakaiaan Bahan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemakaianOa(" . $modPasienMasukPenunjang->pasienmasukpenunjang_id . ");return false"));
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcodeLab2();return false"));

                
            }
            $content = $this->renderPartial($this->path_view.'tips/tipsPendaftaranLaboratoriumRujukanRS', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            // if(Yii::app()->user->getState('modul_id') == Params::MODUL_ID_LAB){
            //     if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
            //         echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            //     } else {
            //         echo CHtml::link(Yii::t('mds', '{icon} Pembayaran Tagihan', array('{icon}' => '<i class="entypo-paypal"></i>')), Yii::app()->createUrl("billingKasir/PembayaranTagihanPasien/index", array("instalasi_id"=>$modKunjungan->instalasiasal_id,"pendaftaran_id"=>$modKunjungan->pendaftaran_id, "frame" => true, 'pelayanan' => "RLB")), array("target"=>"iframePembayaran",'class' => 'btn btn-info', 'onclick' => "$(\"#dialogBayarKarcis\").dialog(\"open\");", 'disabled' => FALSE));
            //     }
            // }
            
            // if (empty($modPasienMasukPenunjang->pasienmasukpenunjang_id)) {
            //     echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            // } else {
            //     echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$modKunjungan->pendaftaran_id.');'));
            // }
            ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan, 'modObatAlkesPasien' => $modObatAlkesPasien,)); ?>
<?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
</div>
</div>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogBayarKarcis',
    'options' => array(
        'title' => 'Pembayaran Tagihan Pasien',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1000,
        'zIndex' => 1001,
        'height' => 500,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframePembayaran" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php    

$modTindakan = new LBTindakanpelayananT; 
$modTindakan->tipepaket_id = Params::TIPEPAKET_ID_NONPAKET;
$modTindakan->kelaspelayanan_id = $modKunjungan->kelaspelayanan_id;
$modTindakan->nopelayanan = '- Terisi Otomatis -';



?>


<?php
    $this->renderPartial($this->path_view . '_dialogDaftarPemeriksaan');
?>

<script>
function pilihPemeriksaanIniDialogPaket(id) {

    var pasienkirimkeunitlain_id = '<?php echo $modKunjungan->pasienkirimkeunitlain_id; ?>';

    $.post('<?php echo $this->createUrl('tambahTarifTindakanPaket'); ?>', {
        tipepaket_id: id,
        pasienkirimkeunitlain_id: pasienkirimkeunitlain_id,
    }, function(data) {
        $("#form-tindakanpemeriksaan table > tbody").append(data.rows);
        renameInputRow($("#form-tindakanpemeriksaan"));
    }, 'json');

}

/**
 * Centang pemeriksaan rad dari checkboxlist
 */
function pilihPemeriksaanIniDialog(obj) {

    // console.log('pilih pemeriksaan dialog');

    var jenispemeriksaanlab_id = $(obj).parent().find('.jenispemeriksaanlab_id').val();
    var jenispemeriksaanlab_nama = $(obj).parent().find('.jenispemeriksaanlab_nama').val();
    var pemeriksaanlab_nama = $(obj).parent().find('.pemeriksaanlab_nama').val();
    var pemeriksaanlab_id = $(obj).parent().find('.pemeriksaanlab_id_dialog').val();
    var daftartindakan_id = $(obj).parent().find('.daftartindakan_id').val();
    var jenistarif_id = $(obj).parent().find('.jenistarif_id').val();
    var harga_tariftindakan = $(obj).parent().find('.harga_tariftindakan').val();
    var daftartindakan_kode = $(obj).parent().find('.daftartindakan_kode').val();
    var kelaspelayanan_id = $(obj).parent().find('.kelaspelayanan_id_dialog').val();
    var rowtindakan =
        '<?php echo CJSON::encode($this->renderPartial('mikrobiologiKlinik.views.pendaftaranLaboratoriumRujukanRSMK._rowTindakanPemeriksaan', array('modTindakan' => $modTindakan, "sama" => "beda"), true)); ?>';

    var ada = $('.daftartindakan_id_dialog[value="' + daftartindakan_id + '"]').length > 0;

    var jml_jenis = $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').length;

    console.log("jumlah jenis yang sama: " + jml_jenis);
    console.log("kelasnya: " + '.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]');

    // var ada_jns = 

    if (!ada) {

        if(jml_jenis > 0) {
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').after(rowtindakan);
        } else {
             $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        }

        $('.td-hapus-baru').last().addClass('td-hapus-'+jenispemeriksaanlab_id);
        $('.td-hapus-baru').last().find('a').attr('onclick', 'hapusPeriksa(this, '+jenispemeriksaanlab_id+')');

        $('.td-hapus-baru').removeClass('td-hapus-baru');

        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenispemeriksaanlab_id]"]').val(jenispemeriksaanlab_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][kelaspelayanan_id]"]').val(kelaspelayanan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
        $("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val(
            "<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(
            harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(
            harga_tariftindakan));
        $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find(".tindakan_kode").html(daftartindakan_kode);
        $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find(".td-jenis").html(jenispemeriksaanlab_nama);
        
        if(jml_jenis > 0) {

            console.log('jml_jenis2: '+jml_jenis);
            console.log('jenispemeriksaanlab_id: '+jenispemeriksaanlab_id);

            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-nourut').addClass("hide");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-nopel').addClass("hide");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-jenis').addClass("hide");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-sample').addClass("hide");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-sample').find('.row_samplelab_id').removeClass("required");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-caraambil').addClass("hide");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-hapus').addClass("hide");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.is-hide').val("hide");
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').last().closest('tr').find('.td-hapus').addClass("td-hapus-"+jenispemeriksaanlab_id);


            var rowspan = $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').first().closest('tr').find('.td-jenis').attr("rowspan");
            rowspan = parseInt(rowspan);

            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').first().closest('tr').find('.td-nourut').attr("rowspan", rowspan+1);
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').first().closest('tr').find('.td-nopel').attr("rowspan", rowspan+1);
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').first().closest('tr').find('.td-jenis').attr("rowspan", rowspan+1);
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').first().closest('tr').find('.td-sample').attr("rowspan", rowspan+1);
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').first().closest('tr').find('.td-caraambil').attr("rowspan", rowspan+1);
            $('#form-tindakanpemeriksaan').find('.jenispemeriksaanlab_id[value="' + jenispemeriksaanlab_id + '"]').first().closest('tr').find('.td-hapus').attr("rowspan", rowspan+1);
            

        }

     
    
    } else {

        myAlert('Pemeriksaan sudah dipilih');
        //     var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value="' + pemeriksaanlab_id + '"]').parents('tr');
        //     delete_row.detach();
    }

    renameInputRow($("#form-tindakanpemeriksaan"));

    var no = 0;

    $('.td-nourut').each(function () {
        if(!$(this).hasClass('hide')) {
            no++;
        }

        $(this).find('.nourut').val(no);

    });
}


/**
 * Centang pemeriksaan rad dari checkboxlist
 */
function pilihPemeriksaanIniPenunjang(pemeriksaanlab_nama, pemeriksaanlab_id, daftartindakan_id, jenistarif_id,
    harga_tariftindakan, daftartindakan_kode, kelaspelayanan_id) {

    console.log('pilih pemeriksaan dialog');

    var rowtindakan =
        '<?php echo CJSON::encode($this->renderPartial('laboratorium.views.pendaftaranLaboratoriumRujukanRS._rowTindakanPemeriksaan', array('modTindakan' => $modTindakan), true)); ?>';

    var ada = $('.daftartindakan_id_dialog[value="' + daftartindakan_id + '"]').length > 0;
    if (!ada) {
        $("#form-tindakanpemeriksaan").find('tbody').append(rowtindakan);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tindakanpelayanan_id]"]').val("");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][pemeriksaanlab_id]"]').val(pemeriksaanlab_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][daftartindakan_id]"]').val(daftartindakan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][kelaspelayanan_id]"]').val(kelaspelayanan_id);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][jenistarif_id]"]').val(jenistarif_id);
        $("#form-tindakanpemeriksaan").find('span[name$="[ii][pemeriksaanlab_nama]"]').html(pemeriksaanlab_nama);
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][satuantindakan]"]').val(
            "<?php echo Params::SATUAN_TINDAKAN_LABORATORIUM; ?>");
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_satuan]"]').val(formatInteger(
            harga_tariftindakan));
        $("#form-tindakanpemeriksaan").find('input[name$="[ii][tarif_tindakan]"]').val(formatInteger(
            harga_tariftindakan));
        $("#form-tindakanpemeriksaan tbody tr:last .tindakan_kode").html(daftartindakan_kode);
    } else {

        myAlert('Pemeriksaan sudah dipilih');
        //     var delete_row = $("#form-tindakanpemeriksaan").find('input[name$="[pemeriksaanlab_id]"][value="' + pemeriksaanlab_id + '"]').parents('tr');
        //     delete_row.detach();
    }
    renameInputRow($("#form-tindakanpemeriksaan"));
}

/**
 * rename input row yang terakhir di tambahkan
 * @param {type} obj_table
 */
function renameInputRow(obj_table) {
    var row = 0;
    $(obj_table).find("tbody > tr").each(function() {
        console.log('tes input row');
        $(this).find("#no_urut").val(row + 1);
        $(this).find('span[name*="[ii]"]').each(function() { //element <span>
            var new_name = $(this).attr("name").replace("ii", (row));
            $(this).attr("name", new_name);
        });
        $(this).find('span[name$="[pemeriksaanlab_nama]"]').each(function() { //element <input>
            var old_name = $(this).attr("name").replace(/]/g, "");
            var old_name_arr = old_name.split("[");
            if (old_name_arr.length == 2) {
                $(this).attr("name", "[" + row + "][" + old_name_arr[1] + "]");
            }
        });
        $(this).find('input,select,textarea').each(function() { //element <input>
            var old_name = $(this).attr("name").replace(/]/g, "");
            var old_name_arr = old_name.split("[");
            if (old_name_arr.length == 3) {
                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
            }
        });
        row++;
    });

}

function renameInputRowPenunjang(obj_table) {
    var row = 0;
    $(obj_table).find("tbody > tr").each(function() {
        console.log('tes input row');
        $(this).find("#no_urut_penunjang").val(row + 1);
        $(this).find('span[name*="[ii]"]').each(function() { //element <span>
            var new_name = $(this).attr("name").replace("ii", (row));
            $(this).attr("name", new_name);
        });
        $(this).find('span[name$="[pemeriksaanlab_nama]"]').each(function() { //element <input>
            var old_name = $(this).attr("name").replace(/]/g, "");
            var old_name_arr = old_name.split("[");
            if (old_name_arr.length == 2) {
                $(this).attr("name", "[" + row + "][" + old_name_arr[1] + "]");
            }
        });
        $(this).find('input,select,textarea').each(function() { //element <input>
            var old_name = $(this).attr("name").replace(/]/g, "");
            var old_name_arr = old_name.split("[");
            if (old_name_arr.length == 3) {
                $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
            }
        });
        row++;
    });

}

function hapusPeriksa(obj, jenis) {

    console.log('ke hapus ini: ' + ".td-hapus-" + jenis);

        $(".td-hapus-" + jenis).each(function() {
            $(this).parents('tr').remove();
        });
    


    var no = 0;

    $('.td-nourut').each(function () {
        if(!$(this).hasClass('hide')) {
            no++;
        }

        $(this).find('.nourut').val(no);

    });
}

function printBarcodeLab() {
    window.open(
        '<?php echo $this->createUrl('PrintBarcode', array('pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'] ?? '')); ?>',
        'printwin', 'left=100,top=100,width=700,height=640');

}

function printBarcodeLab2() {
    window.open(
        '<?php echo $this->createUrl('PrintBarcode2', array('pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id'] ?? '')); ?>',
        'printwin', 'left=100,top=100,width=700,height=640');

}
</script>