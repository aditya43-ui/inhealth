<?php
$this->breadcrumbs = array(
    'Informasi Pasien Rujukan' => Yii::app()->request->getUrlReferrer(),
    'Pendaftaran Rehabilitasi Medis Rujukan Rumah Sakit',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pendaftaran Rehabilitasi Medis Rujukan Rumah Sakit</b>
        </div>
    </div>
    <div class="panel-body">
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemeriksaanrehabmedis-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>
        <?php
        if (isset($_GET['sukses'])) {
            //Yii::app()->user->setFlash('success', "Data pemeriksaan pasien rehabilitasi medis berhasil disimpan!");
            //$this->widget('bootstrap.widgets.BootAlert');
        }
        ?>
        <div class="row">
            <div class="col-sm-6">
                <?php
                if (Yii::app()->user->getState('issmsgateway')) {
                    //$this->renderPartial($this->path_view_pendaftaran.'_formSms', array('form'=>$form,'modSmsgateway'=>$modSmsgateway)); 
                }
                ?>
            </div>
        </div>


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-user"></i> Data <b>Rujukan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <div class="row">
                    <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>

    <?php //echo CHtml::hiddenField($modPemeriksaanRm, 'ruangan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php //echo CHtml::hiddenField($modPemeriksaanRm, 'penjamin_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php //echo CHtml::hiddenField($modPemeriksaanRm, 'kelaspelayanan_id', array('readonly' => true, 'class' => 'span3')); ?>
    <?php // echo CHtml::hiddenField($modPemeriksaanRm, 'jenistindakanrm_id', array('class' => 'control-label')); ?>
    <?php // echo CHtml::hiddenField($modPemeriksaanRm, 'tindakanrm_id', array('class' => 'control-label')); ?>

        <br>
        <div class="row">
        <div class="col-sm-6">
                <fieldset class="" hidden>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Daftar Pemeriksaan
                            </div>
                        </div>
                        <div class="panel-body" id='content-pemeriksaan-rehab'>
                            <div class="control-group">
                                <?php echo CHtml::label("Pemeriksaan", '', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php $this->widget('MyJuiAutoComplete',array(
                                    'name'=> 'tindakan',
                                    //'name'=>'daftartindakan_nama',
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('/rehabMedis/pendaftaranRehabilitasiMedisRujukanRS/AutocompleteDaftarTindakan').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 2,
                                       'focus'=> 'js:function( event, ui ) {
                                            $(this).val( ui.item.daftartindakan_nama);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            console.log(ui.item)
                                            setPemeriksaan(
                                                ui.item.tindakanrm_id, 
                                                ui.item.jenistindakanrm_id, 
                                                ui.item.daftartindakan_nama, 
                                                ui.item.value, 
                                                ui.item.jenistarif_id, 
                                                ui.item.hargatarif_tindakan
                                            );
                                            return false;
                                        }',
                                    
                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket'),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", ),
                        )); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); ?>
                                </h6>
                            </div>
                        </div>
                        <div class="panel-body table-responsive" id="form-tindakanpemeriksaan">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Jumlah</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
                
                <?php if (!isset($_GET['sukses'])) { ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Permintaan ke Penunjang</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="form-permintaankepenunjang">
                        <table class="table table-condensed table-bordered hide">
                            <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="control-group">
                            <?php echo CHtml::label('Ruangan Tujuan', 'ruangan_tujuan', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('ruangan_tujuan',!empty($modKirim->ruangan) ? ($modKirim->ruangan->ruangan_nama ?? '') : null,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Ruangan Asal', 'ruangan_asal', array('class'=>'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textField('ruangan_asal',!empty($modKirim->createruangan) ? $modKirim->createruangan->ruangan_nama : null,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('pegawai_id', $modKunjungan->pegawai_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::textField('nama_pegawai', $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("PPDS", 'ppds_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::hiddenField('ppds_id', $modKunjungan->ppds_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo CHtml::textField('ppds_nama',isset($modKirim->ppds_id) ? $modKirim->ppds->ppds_nama : null,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label("Catatan Dokter Perujuk", 'catatandokterpengirim', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo CHtml::textArea('catatandokterpengirim', $modKunjungan->catatandokterpengirim, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                            </div>
                        </div>
                    </div><br>
                </div>
                <?php } ?>
            </div>

            <div class="col-sm-6">
                <fieldset class="">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>
                        </div>
                    </div>
                </fieldset>
               
                
            </div>
        </div>
        </div>
<?php
    //========= Dialog buat daftar tindakan  =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDaftarTindakanPaket2',
        'options' => array(
            'title' => 'Daftar Tindakan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 880,
            'height' => 440,
            'resizable' => false,
        ),
    ));

    echo '<div id="tableDaftarTindakanPaket"></div>';
    //echo $modPendaftaran->kelaspelayanan_id;
    $this->renderPartial($this->path_view . '_daftarTindakanPaket');

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //========= end daftar tindakan =============================
    ?>
        <div class="form-actions">
            <?php
            //                    if($modPasienMasukPenunjang->isNewRecord){
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'title' => 'Simpan', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => (isset($_GET['sukses'])) ? true : false)
            );
            //                    }else{
            //                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
            //                    }
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
            }
            if ($modPasienMasukPenunjang->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
            }
            
            if ($modPasienMasukPenunjang->isNewRecord) {
                echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$modPasienMasukPenunjang->pendaftaran_id.');'));
            }
            
            $content = $this->renderPartial('tips/tipsPendaftaranRehabilitasiMedisRujukanRS', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        cekDisabled('form');

        $('form').bind('click keyup select change', function(event) {
            cekDisabled(this);
        });
        $(document).on('click keyup select change', function() {
            cekDisabled('form');
        });
    });
</script>