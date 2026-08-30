<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Transaksi <b>Pendaftaran Rehabilitasi Medis Rujukan Rumah Sakit</b></div>
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
            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien rehabilitasi medis berhasil disimpan !");
            $this->widget('bootstrap.widgets.BootAlert');
        }
        ?>
        <div class="row-fluid">
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
                    <i class="glyphicon glyphicon-file"></i> Data Rujukan
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <div class="row-fluid">
                    <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="col-sm-6">
                <fieldset class="">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">Daftar Pemeriksaan Rehabilitasi Medis</div>
                        </div>
                        <div class="panel-body" id='content-pemeriksaan-rehab'>
                            <?php
                            $this->renderPartial($this->path_view_pendaftaran . '_formCariPemeriksaan', array(
                                'modPemeriksaanRm' => $modPemeriksaanRm,
                            )); ?>
                            <div class='checklists'></div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-6">
                <fieldset class="">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">Data Kunjungan Rehabilitasi Medis</div>
                        </div>
                        <div class="panel-body">
                            <?php echo $this->renderPartial('_formMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>
                        </div>
                    </div>
                </fieldset>
                <?php if (!isset($_GET['sukses'])) { ?>
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="panel-title">Tabel Permintaan <b>Ke Penunjang</b></div>
                        </div>
                        <div class="panel-body overflow-x" id="form-permintaankepenunjang">
                            <table class="table table-condensed table-bordered">
                                <thead>
                                    <th>No.</th>
                                    <th width="90%">Nama Pemeriksaan Permintaan</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="control-group">
                                <?php echo CHtml::label("Dokter Perujuk", 'pegawai_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::hiddenField('pegawai_id', $modKunjungan->pegawai_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                    <?php echo CHtml::textField('nama_pegawai', $modKunjungan->gelardepan . " " . $modKunjungan->nama_pegawai . " " . $modKunjungan->gelarbelakang_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo CHtml::label("Catatan Dokter Perujuk", 'catatandokterpengirim', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::textArea('catatandokterpengirim', $modKunjungan->catatandokterpengirim, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                                </div>
                            </div>
                        </div><br />
                    </div>
                <?php } ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <b>Pemeriksaan</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-arrow-down icon-white"></i>')), array('class' => 'btn btn-mini btn-primary', 'type' => 'button', "onclick" => "setCheckedPemeriksaanDariPermintaan();", 'rel' => 'tooltip', 'title' => 'Klik untuk menyalin dari tabel permintaan')); ?></h6>
                        </div>
                    </div>
                    <div class="panel-body overflow-x" id="form-tindakanpemeriksaan">
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
            </div>
        </div>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                //                    if($modPasienMasukPenunjang->isNewRecord){
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => (isset($_GET['sukses'])) ? true : false));
                echo "&nbsp;";
                //                    }else{
                //                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','disabled'=>true, 'style'=>'cursor:not-allowed;')); 
                //                        echo "&nbsp;";
                //                    }
                if (!isset($_GET['frame'])) {
                    echo CHtml::link(
                        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'class' => 'btn btn-danger',
                            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    );
                    echo "&nbsp;";
                }
                if ($modPasienMasukPenunjang->isNewRecord) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
                    echo "&nbsp;";
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printStatus();return false"));
                    echo "&nbsp;";
                }
                $content = $this->renderPartial('tips/tipsPendaftaranRehabilitasiMedisRujukanRS', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang, 'modTindakan' => $modTindakan)); ?>
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