<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB  ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Pencatatan Hasil <strong>Pemeriksaan</strong></div>
                <?php if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)): ?>
                    <div class="panel-options">
                        <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>	
                    </div>
                <?php endif; ?>
            </div>
            <div class="panel-body">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'pemeriksaanlaboratorium-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#no_pendaftaran',
                ));
                ?>
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data hasil pemeriksaan laboratorium berhasil disimpan !");
                }
                ?>
                <div class="hidden">
                <?php
                    $this->widget('MyDateTimePicker', array(
                        'name'=>'tset',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker1 tglperiksapa', 'onkeypress' => "return $(this).focusNextInputField(event)"
                        ,'width'=>'140px;'),
                    ));
                    ?>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title rim"><span class='judul'>Data <b> Kunjungan </b> </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span></div>
                    </div>
                    <div class="panel-body" id="form-datakunjungan">
                        <!--fieldset class="box" id="form-datakunjungan"-->
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                        </div>
                        <!--/fieldset-->
                        <div class="row-fluid">
                            <div class="col-sm-6">
                                <?php
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'riwayat-diagnosa',
                                    'content' => array(
                                        'content-riwayat-diagnosa' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat diagnosa')) . '<b> Riwayat Diagnosa</b>',
                                            'isi' => '<div class="content"></div>',
                                            'active' => false,
                                        ),
                                    ),
                                ));
                                ?>  
                            </div>
                            <div class="col-sm-6">
                                <?php /* $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'riwayat-anamnesa',
                                    'content' => array(
                                        'content-riwayat-anamnesa' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat anamnesa')) . '<b> Riwayat Anamnesa</b>',
                                            'isi' => '<div class="content"></div>',
                                            'active' => false,
                                        ),
                                    ),
                                ));
                                ?>
                                <?php
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'riwayat-pemeriksaan-fisik',
                                    'content' => array(
                                        'content-riwayat-pemeriksaan-fisik' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat pemeriksaan fisik')) . '<b> Riwayat Pemeriksaan Fisik</b>',
                                            'isi' => '<div class="content"></div>',
                                            'active' => false,
                                        ),
                                    ),
                                )); */
                                ?>  
                            </div>

                        </div>
                    </div>
                </div>								
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Hasil Pemeriksaan <b> Laboratorium Klinik </b></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="row-fluid">
                            <div class="col-sm-12">
                                <?php
                                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                                    'id' => 'form-tindakanpemeriksaan',
                                    'content' => array(
                                        'content-tindakan' => array(
                                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan tindakan pemeriksaan laboratorium')) . '<b> Tabel Pemeriksaan</b>',
                                            'isi' => '
                                                        <table class="table table-bordered table-condensed table-striped">
                                                            <thead>
                                                                <th>No.</th>
                                                                <th>Nama Pemeriksaan</th>
                                                                <th>Jumlah</th>
                                                                <th>Satuan</th>
                                                                <th ' . Params::HIDDEN_HARGA . '>Tarif</th>
                                                                <th ' . Params::HIDDEN_HARGA . '>Total</th>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>',
                                            'active' => false,
                                        ),
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                        <?php                        
                            echo $this->renderPartial('_formHasilPemeriksaanPA', array('format' => $format));                        
                        ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="form-actions">
                        <?php
//			if (isset($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => TRUE));
                            echo "&nbsp;";
//			}else{
//			    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);'));
//			    echo "&nbsp;";
//			}
                        echo LBPasienMasukPenunjangV::getVerifikasiPA($modKunjungan->pasienmasukpenunjang_id);
                        if (!isset($_GET['frame'])) {
                            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="' . MyIcon::getIcons('ulang') . '"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                                //                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                            echo "&nbsp;";
                        }

                        if (isset($_GET['sukses'])) {
                            echo CHtml::link(Yii::t('mds', '{icon} Cetak Hasil', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false", 'disabled' => false));
                            echo "&nbsp;";
                        } else {
                            echo CHtml::link(Yii::t('mds', '{icon} Cetak Hasil', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                            echo "&nbsp;";
                        }

                        $content = $this->renderPartial('tips/tipsPencatatanHasilPemeriksaan', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        
                        if (!empty($_GET['pasienmasukpenunjang_id'])) {
                            echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-red', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;'));
                        }
                        ?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
                <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan, 'dariHasil' => 1)); ?>
                <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'modHasilPemeriksaan' => $modHasilPemeriksaan, 'modTindakan' => $modTindakan)); ?>
            </div>
        </div>
    </div>
</div>           