<?php
$jenis = !empty($jenis)?$jenis:'';
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
$this->breadcrumbs = array(
    'Transaksi Pindah Kamar'
);
$this->widget('bootstrap.widgets.BootAlert');
echo $form->errorSummary(array($modPindahKamar));
echo $form->errorSummary(array($modMasukKamar)); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-person-booth"></i> Transaksi <b>Pindah Kamar</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td><?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3')); ?></td>
                <td>
                    <div class="control-label"> <?php echo CHtml::label('No. Rekam Medik <span style = "color:red">*</span>', 'no_rekam_medik', array('class' => '')); ?> </div>
                </td>
                <td> <?php echo CHtml::activeTextField($modPasienRIV, 'no_rekam_medik', array('readonly' => true)); ?>
                    <?php /*$this->widget('MyJuiAutoComplete',array(
                                            'model'=>$modPasienRIV,
                                            'attribute'=>'no_rekam_medik',
                                            'value'=>'',
                                            'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/PasienRawatInap'),
                                            'options'=>array(
                                               'showAnim'=>'fold',
                                               'minLength' => 2,
                                               'focus'=> 'js:function( event, ui ) {
                                                    $(this).val( ui.item.label);
                                                    return false;
                                                }',
                                                'select'=>'js:function( event, ui ) {
                                                      $("#'.CHtml::activeId($modPasienRIV,'tgl_pendaftaran').'").val(ui.item.tgl_pendaftaran);
                                                      $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);   
                                                      $("#'.CHtml::activeId($modPasienRIV,'umur').'").val(ui.item.umur);     
                                                      $("#'.CHtml::activeId($modPasienRIV,'jeniskasuspenyakit_nama').'").val(ui.item.jeniskasuspenyakit_nama);
                                                      $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);   
                                                      $("#'.CHtml::activeId($modPasienRIV,'nama_pasien').'").val(ui.item.nama_pasien);     
                                                      $("#'.CHtml::activeId($modPasienRIV,'jeniskelamin').'").val(ui.item.jeniskelamin);  
                                                      $("#'.CHtml::activeId($modPasienRIV,'no_pendaftaran').'").val(ui.item.no_pendaftaran);  
                                                      $("#'.CHtml::activeId($modPasienRIV,'nama_bin').'").val(ui.item.nama_bin);
                                                      $("#'.CHtml::activeId($modPindahKamar,'pasien_id').'").val(ui.item.pasien_id);     
                                                      $("#'.CHtml::activeId($modPindahKamar,'pendaftaran_id').'").val(ui.item.pendaftaran_id);    
                                                      $("#'.CHtml::activeId($modPindahKamar,'masukkamar_id').'").val(ui.item.masukkamar_id);    
                                                      $("#'.CHtml::activeId($modPindahKamar,'pasienadmisi_id').'").val(ui.item.pasienadmisi_id);
                                                      $("#'.CHtml::activeId($modPindahKamar,'ruangan_id').'").val(ui.item.ruangan_id);
                                                      updateKelasRuangan(ui.item.ruangan_id,"f");
                                                      updateKamarRuangan(ui.item.kelaspelayanan_id, true);
                                                      setTimeout(
                                                        function(){
                                                            $("#'.CHtml::activeId($modPindahKamar,'kelaspelayanan_id').'").val(ui.item.kelaspelayanan_id);
                                                            $("#'.CHtml::activeId($modPindahKamar,'kamarruangan_id').'").val(ui.item.kamarruangan_id);
                                                        }, 500
                                                      );
                                                      $("#'.CHtml::activeId($modMasukKamar,'carabayar_id').'").val(ui.item.carabayar_nama);   
                                                      $("#'.CHtml::activeId($modMasukKamar,'penjamin_id').'").val(ui.item.penjamin_nama);     
                                                      $("#'.CHtml::activeId($modMasukKamar,'pegawai_id').'").val(ui.item.nama_pegawai);    
                                                      $("#'.CHtml::activeId($modMasukKamar,'kelaspelayanan_id').'").val(ui.item.kelaspelayanan_nama);        
                                                }'
                                            ),
                                            'htmlOptions'=>array(
                                                'readonly'=>false,
                                                'placeholder'=>'No. Rekam Medik',
                                                'size'=>20,
                                                'class'=>'span3 numbers-only',
                                                'onkeypress'=>"return $(this).focusNextInputField(event);",
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogDaftarPasien','idTombol'=>'tombolPasienDialog'),
                                     ));*/ ?>
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::label('Tgl. Admisi', 'tgl_admisi', array('class' => 'control-label')); ?></td>
                <td>
                    <?php echo CHtml::activeHiddenField($modPasienRIV, 'pasienadmisi_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeTextField($modPasienRIV, 'tgladmisi', array('readonly' => true, 'class' => 'span3')); ?>
                </td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'umur', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::label('Tgl. Masuk Kamar', 'tgl_masuk_kamar', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'tglmasukkamar', array('readonly' => true, 'class' => 'span3')); ?></td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'jeniskelamin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><label class="control-label">No. Pendaftaran</label></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'no_pendaftaran', array('readonly' => true, 'class' => 'span3')); ?></td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><?php echo CHtml::activeLabel($modPasienRIV, 'Alias', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienRIV, 'nama_bin', array('readonly' => true)); ?></td>
            </tr>
        </table>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-file-alt"></i> Data <b>Pindah Kamar</b>
                </div>
            </div>
            <div class="panel-body">
                <!--fieldset class="box"-->
                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->
                <div class="col-sm-6">
                    <?php echo  CHtml::hiddenField('ruanganlama_id', $modPasienRIV->ruangan_id, array('id' => 'ruanganlama_id')); ?>
                    <?php echo  $form->textFieldRow($modMasukKamar, 'carabayar_id', array('class' => 'span3', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->carabayar->carabayar_nama)) ? $modMasukKamar->carabayar->carabayar_nama : null))); ?>
                    <?php echo  $form->textFieldRow($modMasukKamar, 'penjamin_id', array('class' => 'span3', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->penjamin->penjamin_nama)) ? $modMasukKamar->penjamin->penjamin_nama : null))); ?>
                    <?php echo  $form->textFieldRow($modMasukKamar, 'kelaspelayanan_id', array('class' => 'span3', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->kelaspelayanan->kelaspelayanan_nama)) ? $modMasukKamar->kelaspelayanan->kelaspelayanan_nama : null))); ?>
                    <?php echo  $form->textFieldRow($modMasukKamar, 'pegawai_id', array('class' => 'span3', 'readonly' => TRUE, 'value' => ((isset($modMasukKamar->pegawai->namaLengkap)) ? $modMasukKamar->pegawai->namaLengkap : null))); ?>
                    <?php
                    echo  $form->textFieldRow(
                        $modMasukKamar,
                        'kamarruangan_id',
                        array(
                            'class' => 'span3',
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
                    <?php
                            // echo $form->dropDownListRow(
                            //     $modPindahKamar,
                            //     'ruangan_id',
                            //     CHtml::listData($modPindahKamar->getRuanganItems(array($modPindahKamar->instalasi_id)), 'ruangan_id', 'ruangan_nama'),
                            //     array(
                            //         'empty' => '-- Pilih --',
                            //         'onkeypress' => "return $(this).focusNextInputField(event)",
                            //         'onChange' => 'cekRuanganUntukAlert(this); updateKelasRuangan(this.value, "t")',
                            //         'class' => 'span3'
                            //     )
                            // );
                            ?>
                            <div class="control-group">
                                <label class="control-label required">Instalasi <span class="required">*</span></label>
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
                                <div class="controls">
                                    <?= $form->checkBox($modPindahKamar, 'is_titipan') . ' <b>Pasien Titipan</b>' ?>
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
                                    echo $form->dropDownList(
                                        $modPindahKamar,
                                        'kelaspelayanan_id',
                                        CHtml::listData($modPindahKamar->getKelasItems(Yii::app()->user->getState('ruangan_id')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
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
                                        'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
                                        'kelaspelayanan_id' => $modPasienRIV->kelaspelayanan_id,
                                        'kamarruangan_status' => true
                                    ),
                                    array('order' => 'kamarruangan_id asc')
                                );
                                $listData = CHtml::listData($kamarKosong, 'kamarruangan_id', 'KamarDanTempatTidur');
                            }
                            ?>
                            <div class="control-group">
                                <?php echo CHtml::label('Kamar Ruangan <span style= "color:red">*</span>', 'kamarruangan_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList(
                                        $modPindahKamar,
                                        'kamarruangan_id',
                                        $listData,
                                        array(
                                            'empty' => '-- Pilih --',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span3 required',
                                            'onchange' => 'cekStKamar(this);'
                                        )
                                    );
                                    ?>
                                </div>
                            </div>
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
                                            'class' => 'span3 dtPicker2',
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
                                            'class' => 'span3 dtPicker2',
                                            'onkeypress' => "return $(this).focusNextInputField(event);",
                                        ),
                                    )); ?>
                                    <?php echo $form->error($modPindahKamar, 'jampindahkamar'); ?>
                                </div>
                            </div>
                </div>
                <div class="clear"></div>
                <div class="alert alert-block alert-warning" id="alert_rm" hidden><b>Peringatan!</b> Dokumen Rekam Medis juga akan dikirimkan ke ruangan tujuan ketika pasien dipindahkan.</div>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                $modPindahKamar->isNewRecord ?
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array(
                    'title' => 'Simpan',
                    'class' => 'btn btn-danger',
                    'type' => 'submit',
                    'onKeypress' => 'return formSubmit(this,event)'
                )
            );
            ?>
            <?php
            if (isset($_GET['pendaftaran_id'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-block"></i>')),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default', 'onclick' => 'konfirmasi()'
                    )
                );
                $ulang = 'batalDialog';
            } else {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    '',
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
                $ulang = 'ulang';
            }
            ?>
            <?php
            $tips = array(
                '0' => 'autocomplete-search',
                '1' => 'tanggal',
                '2' => 'time',
                '3' => 'simpan',
                '4' => $ulang
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php
$this->endWidget();
$url = $this->createUrl('GetKamarKosong', array('encode' => false, 'namaModel' => 'PindahkamarT'));
$urlKelas = $this->createUrl('GetKelasPelayanan', array('encode' => false));
//var_dump($modPindahKamar->masukkamar->create_time);die;
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
                    isinotifikasi: 'Pasien <?php echo $modPasienRIV->nama_pasien; ?> tidak memiliki nomor mobile'
                }; // 16 
                insert_notifikasi(params);
        <?php
            }
        }
        ?>
        <?php
        if (isset($modPindahKamar->pindahkamar_id)) {
        ?>
            //  var params = [];
            //  params = {
            //             instalasi_id:[<?php //echo Yii::app()->user->getState("instalasi_id"); 
                                            ?>]
            //          ,   modul_id:<?php //echo Yii::app()->session['modul_id']; 
                                        ?>, 
            //              judulnotifikasi:'PASIEN PINDAH KAMAR', isinotifikasi:'<?php //echo $modPasienRIV->no_rekam_medik.' '.$modPasienRIV->namadepan.' '.$modPasienRIV->nama_pasien; 
                                                                                    ?>, <?php //echo $modMasukKamar->kamarruangan->kamarruangan_nokamar.' '.$modMasukKamar->kamarruangan->kamarruangan_nobed.' - '.$modPindahKamar->kamarruangan->kamarruangan_nokamar.' '.$modPindahKamar->kamarruangan->kamarruangan_nobed; 
                                                                                        ?>  <br>\n\
            //              <?php //echo MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($modPindahKamar->masukkamar->create_time))).' '.LoginpemakaiK::model()->findByPk($modPindahKamar->masukkamar->create_loginpemakai_id)->nama_pemakai 
                            ?>'}; // 16         
            // insert_notifikasi(params);
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
            //parent.location.reload();
        </script>
    <?php
    } else {
//        $urlReloade = Yii::app()->createUrl('/rawatInap/PasienRawatInap/PindahKamarDariTransaksi');
    ?>
        
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
    //        myAlert("Data pasien masih kosong, silakan cek kembali!");
    //        is_simpan = false;
    //    }
    //    
    //    var kelaspelayanan_id = $(obj).find('select[name$="[kelaspelayanan_id]"]').val();
    //    if(kelaspelayanan_id == '')
    //    {
    //        myAlert("Kelas masih kosong, silakan cek kembali!");
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
                jQuery("#RIPindahkamarT_kelaspelayanan_id").html(html)
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
                is_status: status,
                all_kamar: true
            },
            'success': function(html) {
                jQuery("#RIPindahkamarT_kamarruangan_id").html(html)
            }
        });
    }

    function konfirmasi() {
        myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?') ?>", "Perhatian!", function(r) {
            if (r) {
                window.parent.$('#dialogPindahKamar').dialog('close');
            }
        });
    }

    function cekStKamar(obj) {
        var kamarruangan = $(obj).find("option:selected").text();
        var split = kamarruangan.split(" --- ");
        if (typeof split[1] !== "undefined") {
            alert(split[0] + ' Masih Digunakan oleh ' + split[1]);
            $(obj).val('');
            return false;
        }
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
$modPasienDialog = new RIInfopasienmasukkamarV('searchRI');
$modPasienDialog->unsetAttributes();
if (isset($_GET['RIInfopasienmasukkamarV'])) {
    $modPasienDialog->attributes = $_GET['RIInfopasienmasukkamarV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarpasien-v-grid',
    'dataProvider' => $modPasienDialog->searchRI(),
    'template' => "{summary}\n{items}\n{pager}",
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
                                        $(\"#RIPasienrawatinapV_tgl_pendaftaran\").val(\"$data->FormatTanggalPendaftaran\");
                                        $(\"#RIPasienrawatinapV_no_pendaftaran\").val(\"$data->no_pendaftaran\");
                                        $(\"#RIPasienrawatinapV_umur\").val(\"$data->umur\");
                                        $(\"#RIPasienrawatinapV_tgladmisi\").val(\"$data->FormatTanggalAdmisi \");
                                        $(\"#RIPasienrawatinapV_tglmasukkamar\").val(\"$data->FormatTanggalMasukKamar \");
                                        $(\"#RIPasienrawatinapV_jeniskasuspenyakit_nama\").val(\"$data->jeniskasuspenyakit_nama\");
                                        $(\"#RIPasienrawatinapV_jeniskelamin\").val(\"$data->jeniskelamin\");
                                        $(\"#RIPasienrawatinapV_no_rekam_medik\").val(\"$data->no_rekam_medik\");
                                        $(\"#RIPasienrawatinapV_nama_pasien\").val(\"$data->nama_pasien\"); 
                                        $(\"#RIPasienrawatinapV_nama_bin\").val(\"$data->nama_bin\");
                                       // $(\"#RIPindahkamarT_tglpindahkamar\").val(\"$data->tglmasukkamar\");
                                        $(\"#RIPindahkamarT_masukkamar_id\").val(\"$data->masukkamar_id \");
                                        $(\"#RIPindahkamarT_pendaftaran_id\").val(\"$data->pendaftaran_id \");                                        
                                        $(\"#RIPindahkamarT_pasien_id\").val(\"$data->pasien_id \");
                                        $(\"#RIPindahkamarT_pasienadmisi_id\").val(\"$data->pasienadmisi_id \");
                                        //$(\"#RIPindahkamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_id \");
                                        $(\"#RIPindahkamarT_ruangan_id\").val(\"$data->ruangan_nama \");
                                        $(\"#RIMasukKamarT_pasienadmisi_id\").val(\"$data->tgladmisi \");
                                        $(\"#RIMasukKamarT_carabayar_id\").val(\"$data->carabayar_nama \");
                                        $(\"#RIMasukKamarT_penjamin_id\").val(\"$data->penjamin_nama \");
                                        $(\"#RIMasukKamarT_kelaspelayanan_id\").val(\"$data->kelaspelayanan_nama \");
                                        $(\"#RIMasukKamarT_pegawai_id\").val(\"$data->nama_pegawai \");                                        
                                        $(\"#RIMasukKamarT_kamarruangan_id\").val(\"$data->NoKamarRuangan \");
                                    "))',
        ),
        array(
            'header' => 'Tgl. Pendaftaran',
            'name' => 'tgl_pendaftaran',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modPasienDialog,
                    'attribute' => 'tgl_pendaftaran',
                    'mode' => 'date',
                    //'language' => 'ja',
                    // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_due_date',
                        'size' => '10',
                        'style' => 'width:80%'
                    ),
                    'options' => array(  // (#3)                    
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                ),
                true
            ),
        ),
        array(
            'header' => 'No. Pendaftaran',
            'name' => 'no_pendaftaran',
            'filter' => Chtml::activeTextField($modPasienDialog, 'no_pendaftaran', array('class' => 'angkahuruf-only'))
        ),
        array(
            'header' => 'No. Rekam Medik',
            'name' => 'no_rekam_medik',
            'filter' => Chtml::activeTextField($modPasienDialog, 'no_rekam_medik', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'filter' => Chtml::activeTextField($modPasienDialog, 'nama_pasien', array('class' => 'hurufs-only'))
        ),
        /*array(
                    'header'=>'Nama Alias',
                    'type'=>'raw',
                    'value'=>'"$data->nama_bin"',
                ),*/
        array(
            'header' => 'Jenis Penjamin ' . ' / <br>' . ' Penjamin',
            'type' => 'raw',
            'value' => '"$data->carabayar_nama"." / <br>"."$data->penjamin_nama"',
            'filter' => Chtml::activeDropDownList($modPasienDialog, 'carabayar_id', Chtml::listData(CarabayarM::model()->findAll(" carabayar_aktif = TRUE ORDER BY carabayar_nama ASC "), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Dokter',
            'type' => 'raw',
            'name' => 'nama_pegawai',
            'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
            'filter' => Chtml::activeTextField($modPasienDialog, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kasus Penyakit',
            'name' => 'jeniskasuspenyakit_nama',
            'filter' => Chtml::activeTextField($modPasienDialog, 'jeniskasuspenyakit_nama', array('class' => 'hurufs-only'))
        ),
        // 'ruangan_nama',
        //'jeniskasuspenyakit_nama',
        // 'statusperiksa',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
                setAngkaHurufsOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
            reinstallDatePicker();'
        . '}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'" . Params::DATE_FORMAT . "','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
?>