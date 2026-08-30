<?php
$this->breadcrumbs = array(
    'Pindah Kamar'
);

$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'pindahkamar-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' =>
        array(
            'onKeyPress' => 'return disableKeyPress(event)',
            'onSubmit' => 'return requiredCheck(this)'
        ),
        'focus' => '#',
    )
);
$this->widget('bootstrap.widgets.BootAlert');
echo $form->errorSummary(array($modPindahKamar));
echo $form->errorSummary(array($modMasukKamar)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pindah Kamar</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'tgl_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Admisi', 'tgl_admisi', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'pasienadmisi_id', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Masuk Kamar', 'tgl_masuk_kamar', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'tglmasukkamar', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">No. Pendaftaran</label>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'no_pendaftaran', array('readonly' => true)); ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="control-group">
                    <div class="control-label"> <?php echo CHtml::activeLabel($modPasienPIV, 'no_rekam_medik', array('class' => 'no_rek')); ?> </div>
                    <div class="controls">
                        <?php $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPasienPIV,
                            'attribute' => 'no_rekam_medik',
                            'value' => '',
                            'sourceUrl' => $this->createUrl('AutocompletePasien'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);

                                    return false;
                                }',
                                'select' => 'js:function( event, ui ) {
                                      $("#' . CHtml::activeId($modPasienPIV, 'tgl_pendaftaran') . '").val(ui.item.tgl_pendaftaran);
                                      $("#' . CHtml::activeId($modPasienPIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                      $("#' . CHtml::activeId($modPasienPIV, 'umur') . '").val(ui.item.umur);     
                                      $("#' . CHtml::activeId($modPasienPIV, 'jeniskasuspenyakit_nama') . '").val(ui.item.jeniskasuspenyakit_nama);
                                      $("#' . CHtml::activeId($modPasienPIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);   
                                      $("#' . CHtml::activeId($modPasienPIV, 'nama_pasien') . '").val(ui.item.nama_pasien);     
                                      $("#' . CHtml::activeId($modPasienPIV, 'jeniskelamin') . '").val(ui.item.jeniskelamin);  
                                      $("#' . CHtml::activeId($modPasienPIV, 'no_pendaftaran') . '").val(ui.item.no_pendaftaran);  
                                      $("#' . CHtml::activeId($modPasienPIV, 'nama_bin') . '").val(ui.item.nama_bin);

                                      $("#' . CHtml::activeId($modPindahKamar, 'pasien_id') . '").val(ui.item.pasien_id);     
                                      $("#' . CHtml::activeId($modPindahKamar, 'pendaftaran_id') . '").val(ui.item.pendaftaran_id);    
                                      $("#' . CHtml::activeId($modPindahKamar, 'masukkamar_id') . '").val(ui.item.masukkamar_id);    
                                      $("#' . CHtml::activeId($modPindahKamar, 'pasienadmisi_id') . '").val(ui.item.pasienadmisi_id);
                                      $("#' . CHtml::activeId($modPindahKamar, 'ruangan_id') . '").val(ui.item.ruangan_id);

                                      updateKelasRuangan(ui.item.ruangan_id,"f");
                                      updateKamarRuangan(ui.item.kelaspelayanan_id, true);

                                      setTimeout(
                                        function(){
                                            $("#' . CHtml::activeId($modPindahKamar, 'kelaspelayanan_id') . '").val(ui.item.kelaspelayanan_id);
                                            $("#' . CHtml::activeId($modPindahKamar, 'kamarruangan_id') . '").val(ui.item.kamarruangan_id);
                                        }, 500
                                      );

                                      $("#' . CHtml::activeId($modMasukKamar, 'carabayar_id') . '").val(ui.item.carabayar_nama);   
                                      $("#' . CHtml::activeId($modMasukKamar, 'penjamin_id') . '").val(ui.item.penjamin_nama);     
                                      $("#' . CHtml::activeId($modMasukKamar, 'pegawai_id') . '").val(ui.item.nama_pegawai);    
                                      $("#' . CHtml::activeId($modMasukKamar, 'kelaspelayanan_id') . '").val(ui.item.kelaspelayanan_nama);        
                                }'

                            ),

                            'htmlOptions' => array(
                                'readonly' => false,
                                'placeholder' => 'No. Rekam Medik',
                                'size' => 20,
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event);",
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogDaftarPasien', 'idTombol' => 'tombolPasienDialog'),
                        )); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasienPIV, 'umur', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'umur', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasienPIV, 'jeniskelamin', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'jeniskelamin', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasienPIV, 'nama_pasien', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'nama_pasien', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPasienPIV, 'Alias', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeTextField($modPasienPIV, 'nama_bin', array('readonly' => true)); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pindah Kamar</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php echo  $form->textFieldRow($modMasukKamar, 'carabayar_id', array('class' => 'span4', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->carabayar->carabayar_nama)) ? $modMasukKamar->carabayar->carabayar_nama : null))); ?>
                        <?php echo  $form->textFieldRow($modMasukKamar, 'penjamin_id', array('class' => 'span4', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->penjamin->penjamin_nama)) ? $modMasukKamar->penjamin->penjamin_nama : null))); ?>
                        <?php echo  $form->textFieldRow($modMasukKamar, 'kelaspelayanan_id', array('class' => 'span4', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->kelaspelayanan->kelaspelayanan_nama)) ? $modMasukKamar->kelaspelayanan->kelaspelayanan_nama : null))); ?>
                        <div class="control-group">
                            <label class="control-label required">Pegawai <span class="required">*</span></label>
                            <div class="controls">
                        <?php
                            if(!empty($modPendaftaran->pasienadmisi_id)) {
                                echo  $form->textField($modPendaftaran->pasienadmisi, 'pegawai_id', array('class' => 'span4', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->pegawai->namaLengkap)) ? $modMasukKamar->pegawai->namaLengkap : null)));
                            } else {
                                echo  $form->textField($modMasukKamar, 'pegawai_id', array('class' => 'span4', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->pegawai->namaLengkap)) ? $modMasukKamar->pegawai->namaLengkap : null)));
                            }
                        
                        ?>
                        </div>
                    </div>
                        <?php
                        echo  $form->textFieldRow(
                            $modMasukKamar,
                            'kamarruangan_id',
                            array(
                                'class' => 'span4',
                                'readonly' => TRUE,
                                'value' => $modMasukKamar->getNoKamarRuangan($modMasukKamar->kamarruangan_id)
                            )
                        );
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->hiddenField($modPindahKamar, 'pasien_id'); ?>
                        <?php echo $form->hiddenField($modPindahKamar, 'pendaftaran_id'); ?>
                        <?php echo $form->hiddenField($modPindahKamar, 'pasienadmisi_id'); ?>
                        <?php echo $form->hiddenField($modPindahKamar, 'masukkamar_id'); ?>
                        <div class="control-group">
                            <label class="control-label required">Instalasi Tujuan <span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList(
                                    $modPindahKamar,
                                    'instalasi_id',
                                    CHtml::listData($modPindahKamar->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
                                    array(
                                        'empty' => '-- Pilih --',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'class' => 'span3',
                                        'ajax' => array(
                                            'type' => 'POST',
                                            'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modPindahKamar))),
                                            'update' => "#" . CHtml::activeId($modPindahKamar, 'ruangan_id'),
                                        )
                                    )
                                );
                                ?>
                            </div>
                        </div>

                        <div class="control-group">
                                <?php echo $form->labelEx($modPindahKamar, 'ruangan_id', array('class'=>'control-label', 'label'=>'Ruangan Tujuan')); ?>
                                <div class="controls">
                            <?php
                                    
                                    $list_ruangan = CHtml::listData($modPindahKamar->getRuanganItems(array($modPindahKamar->instalasi_id)), 'ruangan_id', 'ruangan_nama');
                                    $list_ruangan_res = array();
                                    foreach ($list_ruangan as $id => $nama) {
                                        if ($id != $modPindahKamar->ruangan_id) {
                                            $list_ruangan_res[$id] = $nama;
                                        }
                                    }
                                
                                    echo $form->dropDownList(
                                        $modPindahKamar,
                                        'ruangan_id',
                                        $list_ruangan_res,
                                        array(
                                            'empty'=>'-- Pilih --',
                                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                                            'onChange'=>'cekRuanganUntukAlert(this); updateKelasRuangan(this.value, "t")',
                                            'class'=>'span2'
                                        )
                                    );
                            ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <!--Karena kelaspelayanan_id di masukkamar_t wajib diisi-->
                            <label class="control-label required">Kelas Pelayanan <span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                //									echo $form->dropDownList($modPindahKamar,'kelaspelayanan_id', CHtml::listData($modPindahKamar->getKelasItems(Yii::app()->user->getState('ruangan_id')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),                          
                                echo $form->dropDownList(
                                    $modPindahKamar,
                                    'kelaspelayanan_id',
                                    CHtml::listData($modPindahKamar->getKelasItems($modPasienPIV->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                                    array(
                                        'empty' => '-- Pilih --',
                                        'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'onChange' => 'updateKamarRuangan(this.value, true)',
                                        'class' => 'span3'
                                    )
                                );
                                ?>
                            </div>
                        </div>

                        <?php
                        $listData = array();
                        if (!empty($modPindahKamar->ruangan_id)) {
                            $kamarKosong = KamarruanganM::model()->findAllByAttributes(
                                array(
                                    //                                        'ruangan_id'=>Yii::app()->user->getState('ruangan_id'),
                                    'ruangan_id' => $modPasienPIV->ruangan_id,
                                    'kelaspelayanan_id' => $modPasienPIV->kelaspelayanan_id,
                                    'kamarruangan_status' => true
                                ),
                                array('order' => 'kamarruangan_id asc')
                            );
                            $listData = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
                        }
                        ?>
                        <?php
                        echo $form->dropDownListRow(
                            $modPindahKamar,
                            'kamarruangan_id',
                            $listData,
                            array(
                                'empty' => '-- Pilih --',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3'
                            )
                        );
                        ?>

                        <div class="control-group">
                            <?php echo CHtml::label('Tgl. Pindah Kamar <span class=required>*</span>', 'tglpindahkamar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPindahKamar,
                                    'attribute' => 'tglpindahkamar',
                                    'mode' => 'date',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'dtPicker2 span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                )); ?>
                                <?php echo $form->error($modPindahKamar, 'tglpindahkamar'); ?>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php echo $form->labelEx($modPindahKamar, 'jampindahkamar', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $this->widget('MyDateTimePicker', array(
                                    'model' => $modPindahKamar,
                                    'attribute' => 'jampindahkamar',
                                    'mode' => 'time',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array(
                                        'readonly' => true,
                                        'class' => 'dtPicker2 span2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                    ),
                                )); ?>
                                <?php echo $form->error($modPindahKamar, 'jampindahkamar'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                $modPindahKamar->isNewRecord ?
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger',
                    'title' => 'Simpan',
                    'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)',
                    'disabled' => (isset($_GET['sukses'])) ? true : false
                )
            );
            ?>
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default', 'onclick' => 'konfirmasi()'
                )
            );
            ?>
            <?php
            $content = $this->renderPartial('../tips/transaksi', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php
$this->endWidget();
$url = $this->createUrl('GetKamarKosong', array('encode' => false, 'namaModel' => 'PindahkamarT'));
$urlKelas = $this->createUrl('GetKelasPelayanan', array('encode' => false));
?>

<script type="text/javascript">
    $(document).ready(function() {
        // Notifikasi Pasien
        <?php
        if (isset($smspasien)) {
            if ($smspasien == 0) {
        ?>
                var params = [];
                params = {
                    instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                    modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                    judulnotifikasi: 'GAGAL KIRIM SMS PASIEN',
                    isinotifikasi: 'Pasien <?php echo $modPasienPIV->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                simpanNotifikasi(params);
        <?php
            }
        }
        ?>

        <?php
        if (isset($modPindahKamar->pindahkamar_id)) {
        ?>
            var params = [];
            params = {
                instalasi_id: <?php echo Yii::app()->user->getState("instalasi_id"); ?>,
                modul_id: <?php echo Yii::app()->session['modul_id']; ?>,
                judulnotifikasi: 'Pindah Kamar',
                isinotifikasi: '<?php echo $modPasienPIV->nama_pasien; ?> dengan <?php echo $modPasienPIV->no_rekam_medik; ?> telah pindah kamar pada <?php echo $modPindahKamar->tglpindahkamar ?> dari <?php echo $modPindahKamar->ruangan->ruangan_nama ?>'
            }; // 16 
            simpanNotifikasi(params);
        <?php
        }
        ?>
    })
</script>

<?php
if ($tersimpan == 'Ya') {
    if (isset($is_grid)) {
?>
        <script>
            parent.location.reload();
        </script>
    <?php
    } else {
        $urlReloade = Yii::app()->createUrl('/perawatanIntensif/PasienRawatIntensif/PindahKamarDariTransaksi');
    ?>
        <script>
            parent.location.href = '<?php echo $urlReloade; ?>';
        </script>
<?php
    }
}
?>

<script>
    //function cekValidasi(obj)
    //{
    //    var is_simpan = true;
    //    var no_pendaftaran = $(obj).find('input[name$="[no_pendaftaran]"]').val();
    //    
    //    if(no_pendaftaran == '')
    //    {
    //        window.parent.myAlert("Data pasien masih kosong, silakan cek kembali!");
    //        is_simpan = false;
    //    }
    //    
    //    var kelaspelayanan_id = $(obj).find('select[name$="[kelaspelayanan_id]"]').val();
    //    if(kelaspelayanan_id == '')
    //    {
    //        window.parent.myAlert("Kelas masih kosong, silakan cek kembali!");
    //        is_simpan = false;
    //    }
    //
    //	return is_simpan;
    //}

    function cekRuanganUntukAlert(obj) {
        var ruangan_lama = $("#ruanganlama_id").val();
        var ruangan_baru = $(obj).val();

        if (ruangan_lama != ruangan_baru) {
            $("#alert_rm").show();
        } else {
            $("#alert_rm").hide();
        }
    }

    function updateKelasRuangan(idRuangan, is_status) {
        jQuery.ajax({
            'type': 'POST',
            'url': '<?php echo $urlKelas ?>',
            'cache': false,
            'data': {
                ruangan_id: idRuangan,
                is_status: is_status
            },
            'success': function(html) {
                jQuery("#PIPindahkamarT_kelaspelayanan_id").html(html)
            }
        });
    }

    function updateKamarRuangan(idKelas, status) {
        var idRuangan = $('#pindahkamar-t-form').find('select[name$="[ruangan_id]"]').val();
        jQuery.ajax({
            'type': 'POST',
            'url': '<?php echo $url ?>',
            'cache': false,
            'data': {
                ruangan_id: idRuangan,
                kelaspelayanan_id: idKelas,
                is_status: status
            },
            'success': function(html) {
                jQuery("#PIPindahkamarT_kamarruangan_id").html(html)
            }
        });
    }

    function konfirmasi() {
        window.parent.myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function(r) {
            if (r) {
                window.parent.$('#dialogPindahKamar').dialog('close');
            }
        });
    }

    function setDropdownruanganNurse(obj) {
        var nursestation_id = $(obj).val();
        $("#PIPindahkamarT_ruangan_id").addClass("animation-loading");
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('SetDropdownRuanganNurse') ?>',
            'data': 'nursestation_id=' + nursestation_id,
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                $("#PIPindahkamarT_ruangan_id").removeClass("animation-loading");
                $('#PIPindahkamarT_ruangan_id').html(data.ruangan);
            },
            'cache': false
        });
    }
</script>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDaftarPasien',
    'options' => array(
        'title' => 'Daftar Pasien',
        'autoOpen' => false,
        'resizable' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
    ),
));
$modPasienDialog = new PIInfopasienmasukkamarV('searchPIDialog');
$modPasienDialog->unsetAttributes();
$modPasienDialog->tgl_pendaftaran = date('m/d/Y') . ' - ' . date('m/d/Y');
if (isset($_GET['PIInfopasienmasukkamarV'])) {
    $modPasienDialog->attributes = $_GET['PIInfopasienmasukkamarV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienDialog->searchPIDialog(),
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'filter' => $modPasienDialog,
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
			"id" => "selectPendaftaran",
			"onClick" => "
				$(\"#dialogDaftarPasien\").dialog(\"close\");

				$(\"#PIPasienrawatinapV_tgl_pendaftaran\").val(\"$data->tgl_pendaftaran\");
				$(\"#PIPasienrawatinapV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
				$(\"#PIPasienrawatinapV_umur\").val(\"$data->umur\");
				$(\"#PIPasienrawatinapV_pasienadmisi_id\").val(\"$data->tgladmisi \");
				$(\"#PIPasienrawatinapV_tglmasukkamar\").val(\"$data->tglmasukkamar \");
				$(\"#PIPasienrawatinapV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");

				$(\"#PIPasienrawatinapV_jeniskelamin\").val(\"$data->jeniskelamin\");
				$(\"#PIPasienrawatinapV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
				$(\"#PIPasienrawatinapV_nama_pasien\").val(\"$data->nama_pasien\"); 
				$(\"#PIPasienrawatinapV_nama_bin\").val(\"$data->nama_bin\");
				$(\"#PIPindahkamarT_tglpindahkamar\").val(\"$data->tglmasukkamar\");
				$(\"#PIPindahkamarT_masukkamar_id\").val(\"$data->masukkamar_id \");
				$(\"#PIPindahkamarT_pendaftaran_id\").val(\"$data->pendaftaran_id \");

				$(\"#PIPindahkamarT_pasien_id\").val(\"$data->pasien_id \");
				$(\"#PIPindahkamarT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");

				$(\"#PIPindahkamarT_ruangan_id\").val(\"$data->ruangan_nama \");

				$(\"#PIMasukKamarT_pasienadmisi_id\").val(\"$data->tgladmisi \");
				$(\"#PIMasukKamarT_carabayar_id\").val(\"$data->carabayar_nama \");
				$(\"#PIMasukKamarT_penjamin_id\").val(\"$data->penjamin_nama \");
				$(\"#PIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");
				$(\"#PIMasukKamarT_pegawai_id\").val(\"$data->nama_pegawai \");
				$(\"#PIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");

			"))',

        ),
        'no_rekam_medik',
        array(
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' =>
            CHtml::activeTextField($modPasienDialog, 'tgl_pendaftaran', array('class' => 'span3', 'readonly' => true)),
            /*$this->widget('MyDateTimePicker', array(
				'model' => $modPasienDialog,
				'attribute' => 'tgl_pendaftaran',
				'mode' => 'date', //date / datetime
				'gridFilter' => true,
				'options' => array(
				'dateFormat' => Params::DATE_FORMAT,
				'maxDate'=>'d',
				),
				'htmlOptions' => array('readonly' => true, 'class' => "span3",
				'onkeypress' => "return $(this).focusNextInputField(event)"),
				),true),*/
        ),
        'no_pendaftaran',
        'nama_pasien',
        array(
            'header' => 'Nama Alias',
            'type' => 'raw',
            'name' => 'nama_bin',
            'value' => '"$data->nama_bin"',
        ),
        array(
            'header' => 'Penjamin',
            'type' => 'raw',
            'name' => 'penjamin_nama',
            'value' => '$data->penjamin_nama',
        ),
        array(
            'header' => 'Jenis Penjamin',
            'type' => 'raw',
            'name' => 'carabayar_nama',
            'value' => '$data->carabayar_nama',
        ),
        array(
            'header' => 'Nama Dokter',
            'type' => 'raw',
            'name' => 'nama_pegawai',
            'value' => '"$data->nama_pegawai"',
        ),
        // 'ruangan_nama',
        'jeniskasuspenyakit_nama',
        // 'statusperiksa',                
    ),
    'afterAjaxUpdate' => 'function(id, data){
			jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//			jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","maxDate":"d","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
//			jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '_date").on("click", function(){jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '").datepicker("show");});
                        jQuery("#' . CHtml::activeId($modPasienDialog, 'tgl_pendaftaran') . '").daterangepicker({
                            "maxDate": "' . date('m/d/Y') . '",
                            "showDropdowns": true,
                        });
		}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    $(document).ready(function() {
        $('input[name="PIInfopasienmasukkamarV[tgl_pendaftaran]"]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        });
    });

    $('form').bind('click keyup select change', function(event) {
        cekDisabled(this);
    });
    $(document).on('click keyup select change', function() {
        cekDisabled('form');
    });
    cekDisabled('form');
</script>