<?php
$this->breadcrumbs = array(
    'Informasi Permintaan Darah Pasien' => Yii::app()->request->getUrlReferrer(),
    'Verifikasi Permintaan Darah Pasien',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Verifikasi Permintaan Darah Pasien</b>
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
            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert');
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
                    <i class="entypo-user"></i> Data <b>Pasien</b>
                    <span class='tombol'
                        style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <div class="row">
                    <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
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
                <br>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Permintaan ke Penunjang</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive" id="form-permintaankepenunjang">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Diambil</th>
                                <th>Dititip</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                <?php if (!isset($_GET['sukses'])) { 
                                    if(count($rowPermintaan) > 0) {
                                        foreach($rowPermintaan as $ii => $row) {
                                            $this->renderPartial('_rowPermintaanKePenunjang', [
                                                'ii' => $ii,
                                                'row' => $row,
                                                'modKirim' => $modKirim
                                            ]);
                                        }
                                    }
                                ?>

                                <?php } ?>
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="control-group">
                                    <?php echo CHtml::label("Dokter", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?= $form->hiddenField($modKunjungan, 'pegawai_id', ['readonly' => 'true']) ?>
                                        <?= $form->textField($modKunjungan, 'nama_pegawai', ['readonly' => 'true']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Golongan Darah", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?= $form->textField($modKunjungan, 'golongandarah', ['readonly' => 'true']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Diagnosa", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?= $form->textField($modKunjungan, 'diagnosa_nama', ['readonly' => 'true']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Kadar HB", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?= $form->textField($modKunjungan, 'kadarhb', ['readonly' => 'true']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("PLT", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?= $form->textField($modKunjungan, 'plt', ['readonly' => 'true']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Catatan Dokter Pengirim", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?= $form->textArea($modKunjungan, 'catatandokterpengirim', ['readonly' => 'true']) ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("Jenis Permintaan", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?= $form->textField($modKunjungan, 'jenis_permintaan', ['readonly' => 'true']) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                
            </div>

            <div class="col-sm-6">
                <fieldset class="">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">
                                Daftar Pencatatan Stok
                            </div>
                        </div>
                        <div class="panel-body" id='content-pencatatan-stok'>
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <th>No.</th>
                                    <th>Nama Pemeriksaan</th>
                                    <th>Jumlah</th>
                                    <th>Diambil</th>
                                    <th>Dititip</th>
                                    <th>Aksi</th>
                                </thead>
                                <tbody>
                                    <?php 
                                        if (!isset($_GET['sukses'])) { 
                                            if(count($rowPermintaan) > 0) {
                                                foreach($rowPermintaan as $ii => $row) {
                                                    $this->renderPartial('_rowPencatatanStok', [
                                                        'ii' => $ii,
                                                        'row' => $row,
                                                        'modKirim' => $modKirim
                                                    ]);
                                                }
                                            }
                                        } 
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                                                        url: "'.Yii::app()->createUrl('rawatInap/tindakanTRI/DaftarTindakan').'",
                                                        dataType: "json",
                                                        data: {
                                                            term: request.term,
                                                            tipepaket_id: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                                            kelaspelayanan_id: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                                                            penjamin_id: $("#RJPendaftaranT_penjamin_id").val(),
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
                                                $(this).val( ui.item.label);
                                                return false;
                                            }',
                                        'select'=>'js:function( event, ui ) {
                                                setTindakan($(this), ui.item);
                                                return false;
                                            }',
                                        
                                        ),
                                        'tombolDialog'=>array("idDialog"=>'dialogDaftarTindakanPaket'),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", ),
                                    )); ?>
                                </div>
                            </div>


                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                        <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                                        <?php
                                        // CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); ?>
                                        </h6>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive" id="form-tindakanpemeriksaan">
                                    <table class="table table-condensed table-bordered">
                                        <thead>
                                            <th>No.</th>
                                            <th>Nama Pemeriksaan</th>
                                            <th>Jumlah</th>
                                            <th>Tarif</th>
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
                </fieldset>

                
            </div>
        </div>

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
            if (!isset($_GET['sukses'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                // echo CHtml::link(Yii::t('mds', '{icon} Print Ulang Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printTindakan();return false"));
                /*echo CHtml::link(Yii::t('mds', '{icon} Print Ulang Nota Tindakan', array('{icon}' => '<i class="entypo-print"></i>')),
                Yii::app()->controller->createUrl("/rawatJalan/tindakan/printUlangTindakanPenunjangDialog", array("pasienmasukpenunjang_id" => $modKirim->pasienmasukpenunjang_id)), 
                array(
                    "title" => "Klik untuk Cetak Ulang Nota Tindakan", 
                    "target" => "iframeCetakUlang", 
                    "onclick" => '$("#dialogCetakUlang").dialog("open");', 
                    "rel" => "tooltip", 
                    'class' => 'btn btn-info',
                ));
                */
            }
            
            // if (isset($_GET['sukses'])) {
            //     echo CHtml::link(Yii::t('mds', '{icon} DPJP', array('{icon}' => '<i class="entypo-paypal"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            // } else {
            //     echo CHtml::htmlButton(Yii::t('mds','{icon} DPJP',array('{icon}'=>'<i class="entypo-user"></i>')),array('class'=>'btn btn-info', 'type'=>'button', 'onclick'=>'setSuratPeryataan('.$modPasienMasukPenunjang->pendaftaran_id.');'));
            // }
            
            $content = $this->renderPartial('tips/tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
        <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._dialogSuratPernyataan', array()); ?>
    </div>
</div>

<?php
    //========= Dialog buat daftar tindakan  =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDaftarTindakanPaket',
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
    $this->renderPartial('_daftarTindakanPaket');

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    //========= end daftar tindakan =============================
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

function printStatusTindakan()
{
    var pasienmasukpenunjang_id = "<?php echo $modKirim->pasienmasukpenunjang_id; ?>";
    if(pasienmasukpenunjang_id != ""){
        window.open('<?php echo Yii::app()->createUrl('/rawatJalan/tindakan/printTindakanPenunjang'); ?>&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=640,height=640');
    }else{
        myAlert("Silakan pilih data rujukan pasien!");
    }
}

function printTindakan(){
    var pendaftaran_id = '<?= isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null ?>';
    var nopelayanan = '<?= isset($_GET['nopelayanan']) ? $_GET['nopelayanan'] : null ?>';
    if(pendaftaran_id != ""){
        window.open('<?php echo Yii::app()->createUrl('bankDarah/verifikasiPermintaanDarahPasien/printTindakan'); ?>&id='+pendaftaran_id + '&nopelayanan='+nopelayanan,'printwin','left=100,top=100,width=640,height=640');
    }else{
        myAlert("Silakan pilih data rujukan pasien!");
    }
}

</script>