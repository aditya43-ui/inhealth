<?php 

$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps":"");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps":"");

?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $this->judulPendaftaranLab; ?></div>
    </div>
    <div class="panel-body">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'lkpendaftaran-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus'=>'#'.CHtml::activeId($modPasien,'jenisidentitas'),
    )); ?>
    <?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->errorSummary($modPasien); ?>
    <?php if (!isset($_GET['id'])) : ?>
	<?php $autoopen = Yii::app()->user->getState('isantrian'); 
	?>
        <?php if ($autoopen) { ?>
        <div class="span12">
            <?php echo $this->renderPartial($this->path_view . '_formAntrianPendaftaran', array('form' => $form, 'model' => $model, 'modAntrian' => $modAntrian)); ?>
        </div>
    <?php } ?>
    <?php endif; ?>
    <div class="clear"></div>
    <div class="panel panel-success" id="form-pasien">
        <div class="panel-heading">
            <div class="panel-title">
                Data Pasien Baru </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?>
            </div>
        </div>
        <div class="panel-body">  
            <?php $this->renderPartial($this->path_viewPPRJ . '_formPasien', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai, 'modPenanggungJawab' => $modPenanggungJawab)); ?>
            <div class="clear"></div>
        </div>
    </div>	
		
		
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Kunjungan</div>
        </div>
        <div class="panel-body">
            <div class="col-sm-6">
                <?php echo $this->renderPartial($this->path_view . '_formPendaftaran', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modRujukan' => $modRujukan, 'modAsuransiPasien' => $modAsuransiPasien, 'modAsuransiPasienBadak' => $modAsuransiPasienBadak, 'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen, 'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja, 'modPegawai' => $modPegawai)); ?>                
                <?php echo $form->hiddenField($model, 'is_pasienrujukan', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo CHtml::hiddenField("jenisdialog","",array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField("norow","",array('readonly'=>true)); ?>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-rujukan',
                    'content' => array(
                        'content-rujukan' => array(
                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan rujukan')) . '<b> Rujukan</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formRujukan', array(
                                'form' => $form,
                                'model' => $model,
                                'modRujukan' => $modRujukan,
                                    ), true),
                            'active' => $model->is_pasienrujukan,
                        ),
                    ),
                ));
                ?>


                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-riwayatpasien',
                    'content' => array(
                        'content-riwayatpasien' => array(
                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat kunjungan pasien')) . '<b> Riwayat Kunjungan Pasien <span id="kunjungan_ke" style="color: red"></span></b>',
                            'isi' => $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
                                'form' => $form,
                                'modPasien' => $modPasien,
                                    ), true),
                            'active' => true,
                        ),
                    ),
                ));
                ?>

            </div>
            <div class="col-sm-6">
                <?php /*
                  <!-- PENTING! : ANTARA LAB KLINIS / PATOLOGI ANATOMI HARUS ADA YANG DIPILIH, BISA SALAH SATU ATAU KEDUANYA-->
                  <?php $i = 0; //index form pasien masuk penunjang ?>
                  <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i],'['.$i.']is_pilihpenunjang', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                  <?php
                  $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                  'id'=>'form-pemeriksaan-'.$i,
                  'content'=>array(
                  'content-lab-'.$i=>array(
                  'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk memilih laboratorium klinik')).'<b> Pemeriksaan Lab Klinik</b>',
                  'isi'=>$this->renderPartial($this->path_view.'_formPenunjang', array(
                  'form'=>$form,
                  'model'=>$model,
                  'i'=>$i,
                  'modPasienMasukPenunjang'=>$modPasienMasukPenunjangs[$i],
                  'dataTindakans'=>$dataTindakans,
                  ),true),
                  'active'=>$modPasienMasukPenunjangs[$i]->is_pilihpenunjang,
                  ),
                  ),
                  )); ?>

                  <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i],'['.$i.']is_adakarcis', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                  <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                  'id'=>'form-karcis-'.$i,
                  'content'=>array(
                  'content-karcis-'.$i=>array(
                  'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk memilih karcis')).'<b> Karcis Lab Klinik</b>',
                  'isi'=>'<div id="content-karcis-html">'
                  .$this->renderPartial($this->path_view.'_formKarcis',array(
                  'form'=>$form,
                  'model'=>$model,
                  'i'=>$i,
                  'modKarcis'=>$modKarcis[$i],
                  ),true)
                  .'</div>',
                  'active'=>$modPasienMasukPenunjangs[$i]->is_adakarcis,
                  ),
                  ),
                  )); ?>

                  <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i],'['.$i.']is_adasample', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                  <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                  'id'=>'form-pengambilan-sample-'.$i,
                  'content'=>array(
                  'content-pengambilan-sample-'.$i=>array(
                  'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan sampel laboratorium')).'<b> Sampel Lab Klinik</b>',
                  'isi'=>$this->renderPartial($this->path_view.'_formPengambilanSample',array(
                  'form'=>$form,
                  'model'=>$model,
                  'i'=>$i,
                  'modPengambilanSample'=>$modPengambilanSample,
                  ),true),
                  'active'=>$modPasienMasukPenunjangs[$i]->is_adasample,
                  ),
                  ),
                  )); ?>
                 */ ?>
                <?php $i = 1; //index form pasien masuk penunjang ?>
                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_pilihpenunjang', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pemeriksaan-' . $i,
                    'content' => array(
                        'content-lab-' . $i => array(
                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk memilih laboratorium Patologi Anatomi')) . '<b> Pemeriksaan Lab Patologi Anatomi</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formPenunjang', array(
                                'form' => $form,
                                'model' => $model,
                                'i' => $i,
                                'modPasienMasukPenunjang' => $modPasienMasukPenunjangs[$i],
                                'dataTindakans' => $dataTindakans,
                                    ), true),
                            'active' => $modPasienMasukPenunjangs[$i]->is_pilihpenunjang,
                        ),
                    ),
                ));
                ?>

                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adakarcis', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-karcis-' . $i,
                    'content' => array(
                        'content-karcis-' . $i => array(
                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk memilih karcis')) . '<b> Karcis Lab Patologi Anatomi</b>',
                            'isi' => '<div id="content-karcis-html">'
                            . $this->renderPartial($this->path_view . '_formKarcis', array(
                                'form' => $form,
                                'model' => $model,
                                'i' => $i,
                                'modKarcis' => $modKarcis[$i],
                                    ), true)
                            . '</div>',
                            'active' => $modPasienMasukPenunjangs[$i]->is_adakarcis,
                        ),
                    ),
                ));*/
                ?>    

                <?php echo $form->hiddenField($modPasienMasukPenunjangs[$i], '[' . $i . ']is_adasample', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-pengambilan-sample-' . $i,
                    'content' => array(
                        'content-pengambilan-sample-' . $i => array(
                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan sampel laboratorium')) . '<b> Sampel Lab Patologi Anatomi</b>',
                            'isi' => $this->renderPartial($this->path_view . '_formPengambilanSample', array(
                                'form' => $form,
                                'model' => $model,
                                'i' => $i,
                                'modPengambilanSample' => $modPengambilanSample,
                                    ), true),
                            'active' => $modPasienMasukPenunjangs[$i]->is_adasample,
                        ),
                    ),
                ));
                ?>
            </div>
            <div class="clear"></div>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'button', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')); //jika tanpa verifikasi >> formSubmit(this,event)
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), (!empty($model->antrian_id)) ? $this->createUrl($this->id . '/index', array('antrian_id' => $model->antrian_id)) : $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'));
                ?>
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Status', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Status', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus('$model->pendaftaran_id');return false", 'disabled' => FALSE));
                }
                ?>
                <?php
                if ($model->isNewRecord) {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Label', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Cetak Label', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatusLabel('$model->pendaftaran_id');return false", 'disabled' => FALSE));
                }
                ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsPendaftaranLaboratorium', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?> 
            </div>
        </div>
    </div>
		
    <?php $this->endWidget(); ?>
    <hr />
    <?php echo $this->renderPartial($this->path_view.'_dialog',array()) ?>
    <?php $this->renderPartial($this->path_view.'_tablePendaftaranTerakhir', array()); ?>
    <?php  
    //====== dialog box pilih pemeriksaan klinik ====
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialog-pilihpemeriksaan',
        'options'=>array(
            'title'=>'Pilih Pemeriksaan',
            'autoOpen'=>false,
            'width'=>840,
            'height'=>450,
            'modal'=>true,
            'resizable'=>false,
        ),
    ));?>
    <?php echo $this->renderPartial($this->path_view.'_formCariPemeriksaan', array('modPemeriksaanLab'=>$modPemeriksaanLab));?>
    <div class="dialog-content"></div>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
    <?php 
    // Dialog buat nambah data propinsi =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-verifikasi',
        'options'=>array(
            'title'=>'Verifikasi Pendaftaran',
            'autoOpen'=>false,
            'modal'=>true,
            'minWidth'=>960,
            'minHeight'=>480,
            'resizable'=>false,
        ),
    ));

    echo '<div class="dialog-content"></div>';
    ?>
    <div class="row-fluid">
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); $("#lkpendaftaran-t-form").submit();')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    
    <?php 
    $autoopen = Yii::app()->user->getState('isantrian');
    if(!empty($model->pendaftaran_id)){
        $autoopen = false;
    }
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialog-panggilantrian',
        'options'=>array(
            'title'=>'No. Antrian',
            'autoOpen'=>false,
            'width'=>180,
            'resizable'=>false,
            'position'=>array("right",140),
        ),
    ));
    ?>
    <div class="dialog-content">
        <?php echo $this->renderPartial($this->path_viewPPRJ.'_formPanggilAntrian', array('modAntrian'=>$modAntrian)); ?>
    </div>

    <div style="text-align: center;">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-backward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian sebelumnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("prev");')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-forward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian berikutnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("next");')); ?>
            <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
            <?php // echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('title'=>'Klik untuk mengulang antrian','rel'=>'tooltip','class'=>'btn btn-mini btn-danger','onclick'=>'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
        <br>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Panggil',array('id'=>'btn-panggilantrian','{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian();}')); ?>
    </div>
    <?php $this->endWidget(); ?>

    <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
            'id'=>'dialogAsuransi',
            'options'=>array(
                'title'=>'Pencarian Asuransi Pasien',
                'autoOpen'=>false,
                'modal'=>true,
                'width'=>960,
                'height'=>480,
                'resizable'=>false,
            ),
        ));
        $modCariAsuransiPasien=new LBAsuransipasienM('search');
        $modCariAsuransiPasien->unsetAttributes();
        if(isset($_GET['LBAsuransipasienM'])) {
            $modCariAsuransiPasien->attributes = $_GET['LBAsuransipasienM'];
            isset($_GET['LBAsuransipasienM']['pasien_id'])?$modCariAsuransiPasien->pasien_id = $_GET['LBAsuransipasienM']['pasien_id']:'';
            isset($_GET['LBAsuransipasienM']['penjamin_id'])?$modCariAsuransiPasien->penjamin_id = $_GET['LBAsuransipasienM']['penjamin_id']:'';
        }
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'asuransi-m-grid',
                'dataProvider'=>$modCariAsuransiPasien->searchDialog(),
                'filter'=>$modCariAsuransiPasien,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                'columns'=>array(
                        array(
                            'header'=>'Pilih',
                            'type'=>'raw',
                            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectAsuransi",
                                            "onClick" => "
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'\").val($data->asuransipasien_id);
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'nopeserta').'\").val(\"$data->nopeserta\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'\").val(\"$data->nokartuasuransi\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'\").val(\"$data->namapemilikasuransi\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'\").val(\"$data->jenispeserta_id\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'\").val(\"$data->nomorpokokperusahaan\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'\").val(\"$data->namaperusahaan\");
                                                $(\"#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'\").val(\"$data->kelastanggunganasuransi_id\");
                                                setAsuransiLama()
                                                $(\"#dialogAsuransi\").dialog(\"close\");
                                            "))',
                        ),
                        'nokartuasuransi',
                        'nopeserta',
                                            array(
                                                    'header'=>'Nama Pemilik Asuransi',
                                                    'value'=>'$data->namapemilikasuransi',
                                                    'filter'=>CHtml::activeHiddenField($modCariAsuransiPasien, 'pasien_id',array('readonly'=>true))."".CHtml::activeHiddenField($modCariAsuransiPasien, 'penjamin_id',array('readonly'=>true))."".CHtml::activeTextField($modCariAsuransiPasien, 'namapemilikasuransi',array()),
                                                    'htmlOptions'=>array('style'=>'text-align:right;'),
                                            ),
                        'namaperusahaan',
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        $this->endWidget();
    ?>
    
    <?php 
    //========= Dialog buat cari data pendaftaran / kunjungan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogKunjungan',
        'options' => array(
            'title' => 'Pencarian Data Rujukan Ke Laboratorium',
            'autoOpen' => false,
            'modal' => true,
            'width' => 980,
            'height' => 480,
            'resizable' => false,
        ),
    ));
    $modDialogKunjungan = new LBPasienKirimKeUnitLainV('searchDialogKunjungan');
    $modDialogKunjungan->unsetAttributes();
    $modDialogKunjungan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['LBPasienKirimKeUnitLainV'])) {
        $modDialogKunjungan->attributes = $_GET['LBPasienKirimKeUnitLainV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'datakunjungan-grid',
        'dataProvider' => $modDialogKunjungan->searchDialogKunjungan(),
        'filter' => $modDialogKunjungan,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectKunjungan",
                    "onClick" => "
                        $(\"#pasienkirimkeunitlain_id\").val($data->pasienkirimkeunitlain_id);
                        $(\"#no_pendaftaran\").val(\"$data->no_pendaftaran\");
                        $(\"#dialogKunjungan\").dialog(\"close\");
                    "))',
            ),
            'no_pendaftaran',
            array(
                'name' => 'tgl_pendaftaran',
                'type' => 'raw',
                'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                'filter' => false,
            ),
            'no_rekam_medik',
            'nama_pasien',
            array(
                'name' => 'jeniskelamin',
                'type' => 'raw',
                'filter' => Chtml::dropDownList('MCPasienM[jeniskelamin]', $modDialogKunjungan->jeniskelamin, LookupM::model()->getItems('jeniskelamin'), array('empty' => '--Pilih--')),
            ),
            'instalasiasal_nama',
            'ruanganasal_nama',
            array(
                'name' => 'carabayar_id',
                'type' => 'raw',
                'value' => '$data->carabayar_nama',
                'filter' => Chtml::activeDropDownList($modDialogKunjungan, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif IS TRUE"), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --')),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));

    $this->endWidget();
    ////======= end pendaftaran dialog =============
    ?>
    
        <?php $this->renderPartial($this->path_view.'_jsFunctions', array('model'=>$model, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modPasienMasukPenunjangs'=>$modPasienMasukPenunjangs, 'modTindakan'=>$modTindakan,'modAsuransiPasien'=>$modAsuransiPasien,'modAsuransiPasienBadak'=>$modAsuransiPasienBadak,'modAsuransiPasienDepartemen'=>$modAsuransiPasienDepartemen,'modAsuransiPasienPekerja'=>$modAsuransiPasienPekerja,'modPegawai'=>$modPegawai)); ?>
        <?php echo $this->renderPartial($this->path_viewPPRJ.'_jsFunctionsAntrian', array('model'=>$model, 'modPasien'=>$modPasien, 'modPenanggungJawab'=>$modPenanggungJawab, 'modRujukan'=>$modRujukan, 'modAntrian'=>$modAntrian)); ?>
</div>
</div>

<script>
$(document).ready(function(){
    $('form').bind('click keyup select change', function(event) {
        cekDisabled(this);
    });
    $(document).on('click keyup select change',function(){
        cekDisabled('form');
    });

    cekDisabled('form');
});
</script>