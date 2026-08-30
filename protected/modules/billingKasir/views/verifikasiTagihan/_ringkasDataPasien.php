<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <div class=" control-label"><?php echo CHtml::Label("Sub System <span style='color:red'>*</span>", 'instalasi_id', array('class' => '')); ?></div>
            <div class="controls">
                <?php
                if (!empty($modPendaftaran->instalasi_id)) {
                    echo CHtml::textField('BKPendaftaranT[instalasi_nama]', $modPendaftaran->instalasi->instalasi_nama, array('readonly' => true));
                } else {
                    echo CHtml::dropDownList(
                        'BKPendaftaranT[instalasi_id]',
                        NULL,
                        CHtml::listData(BKInstalasiM::model()->getInstalasiPelayananRawat(), 'instalasi_id', 'instalasi_nama'),
                        array('id' => 'instalasi_id', 'class' => 'required span3', 'onchange' => 'resetDataPasien(); refreshDialogPendaftaran();', 'onkeypress' => "return $(this).focusNextInputField(event)")
                    );
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label', 'label' => 'No. Pendaftaran')); ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'FAPendaftaranT[no_pendaftaran]',
                    'value' => $modPendaftaran->no_pendaftaran,
                    'source' => 'js: function(request, response) {
                               $.ajax({
                                   url: "' . $this->createUrl('AutocompleteKunjungan') . '",
                                   dataType: "json",
                                   data: {
                                       no_pendaftaran: request.term,
                                       instalasi_id: $("#instalasi_id").val(),
                                   },
                                   success: function (data) {
                                           response(data);
                                   }
                               })
                            }',
                    'options' => array(
                        'minLength' => 4,
                        'focus' => 'js:function( event, ui ) {
                             $(this).val( "");
                             return false;
                         }',
                        'select' => 'js:function( event, ui ) {
                            // $(this).val( ui.item.value);
                            cekValidasiPJADanAkomodasi(ui.item);
                            loadPembayaran(ui.item.pendaftaran_id);
                            return false;
                        }',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPasien', 'idTombol' => 'tombolPasienDialog'),
                    'htmlOptions' => array(
                        'placeholder' => 'No. Pendaftaran', 'class' => 'all-caps span3', 'rel' => 'tooltip', 'title' => 'No. pendaftaran / klik icon untuk mencari data kunjungan',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                ));


                // echo CHtml::textField('FAPendaftaranT[no_pendaftaran]', $modPendaftaran->no_pendaftaran, array('readonly'=>true)); 
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label', 'label' => 'Tgl. Pendaftaran')); ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPendaftaranT[tgl_pendaftaran]', $modPendaftaran->tgl_pendaftaran, array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'ruangan_id', array('class' => 'control-label', 'label' => 'Poliklinik / Ruangan')); ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPendaftaranT[ruangan_nama]', ((isset($modPendaftaran->ruangan->ruangan_nama)) ? $modPendaftaran->ruangan->ruangan_nama : null), array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'kelaspelayanan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php $kelas = empty($modPendaftaran->kelaspelayanan) ? '' : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; ?>
                <?php echo CHtml::textField('FAPendaftaranT[kelaspelayanan_id]', $kelas, array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group" id="grup_kelas_tanggungan" hidden>
            <?php echo CHtml::label('Kelas Tanggungan', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php // $kelas = empty($modPendaftaran->kelaspelayanan) ? '' : $modPendaftaran->kelaspelayanan->kelaspelayanan_nama; 
                ?>
                <?php echo CHtml::textField('FAPendaftaranT[kelastanggungan_nama]', $kelas, array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPendaftaranT[jeniskasuspenyakit_nama]', ((isset($modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama)) ? $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama : null), array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'carabayar_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPendaftaranT[carabayar_nama]', (isset($modPendaftaran->carabayar->carabayar_nama) ? $modPendaftaran->carabayar->carabayar_nama : ""), array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[carabayar_id]', $modPendaftaran->carabayar_id, array('readonly' => true)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'penjamin_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('FAPendaftaranT[pendaftaran_id]', $modPendaftaran->pendaftaran_id, array('readonly' => true)); ?>
                <?php echo CHtml::textField('FAPendaftaranT[penjamin_nama]', (isset($modPendaftaran->penjamin->penjamin_nama) ? $modPendaftaran->penjamin->penjamin_nama : ""), array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[penjamin_id]', $modPendaftaran->penjamin_id, array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo CHtml::hiddenField('FAPendaftaranT[kelaspelayanan_id]', ((isset($modPendaftaran->kelaspelayanan_id)) ? $modPendaftaran->kelaspelayanan_id : ''), array('readonly' => true)); ?>
            </div>
        </div>

        <div class="control-group dpjp" hidden>
            <?php echo CHtml::label("Dokter Penerima", 'dokterpenerima', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php echo CHtml::textField('dokterpenerima', null, array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group dpjp" hidden>
            <?php echo CHtml::label("Dokter PJP 1", 'dpjp1_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php echo CHtml::textField('dpjp1', null, array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group dpjp" hidden>
            <?php echo CHtml::label("Dokter PJP 2", 'dpjp2_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php echo CHtml::textField('dpjp2', null, array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group dpjp" hidden>
            <?php echo CHtml::label("Dokter PJP 3", 'dpjp3_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo CHtml::hiddenField('penjamin_id',$modKunjungan->penjamin_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php echo CHtml::textField('dpjp3', null, array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event);", 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">No. Rekam Medik <span style="color:red">*</span></label>
            <div class="controls">
                <?php //echo CHtml::textField('FAPasienM[no_rekam_medik]', $modPasien->no_rekam_medik, array('readonly'=>true)); 
                ?>
                <?php
                if (Yii::app()->controller->module->id == 'billingKasir') {
                    $pasien = 'daftarPasien';
                } else {
                    $pasien = 'daftarPasienRuangan';
                }
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'FAPasienM[no_rekam_medik]',
                    'value' => $modPasien->no_rekam_medik,
                    'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/' . $pasien . '') . '",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           instalasiId: $("#BKPendaftaranT_instalasi_id").val(),
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                        'select' => 'js:function( event, ui ) {
                                                cekValidasiPJADanAkomodasi(ui.item);
                                                loadPembayaran(ui.item.pendaftaran_id);
                                                return false;
                                            }',
                    ),
                    'htmlOptions' => array(
                        'maxlength' => 6, 'onfocus' => 'return cekInstalasi();', 'class' => 'span3 required numbers-only',
                        'placeholder' => 'No. Rekam Medik', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::Label("Nama Pasien <span style='color:red'>*</span>", 'nama_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php //echo CHtml::textField('FAPasienM[nama_pasien]', $modPasien->nama_pasien, array('readonly'=>true)); 
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'FAPasienM[nama_pasien]',
                    'value' => $modPasien->nama_pasien,
                    'source' => 'js: function(request, response) {
                                                          $.ajax({
                                                              url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/daftarPasienberdasarkanNama') . '",
                                                              dataType: "json",
                                                              data: {
                                                                  ' . strtolower($pasien) . ':true,
                                                                  term: request.term,
                                                              },
                                                              success: function (data) {
                                                                      response(data);
                                                              }
                                                          })
                                                       }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                                       $(this).val(ui.item.value);
                                                       return false;
                                                   }',
                        'select' => 'js:function( event, ui ) {
                                                        cekValidasiPJADanAkomodasi(ui.item);
                                                       loadPembayaran(ui.item.pendaftaran_id);
                                                       return false;
                                                   }',
                    ), 'htmlOptions' => array(
                        'class' => 'required hurufs-only span3',
                        'placeholder' => 'Nama Pasien',
                        'onfocus' => 'return cekInstalasi();',
                    )
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPasien, 'nama_bin', array('class' => 'control-label', 'label' => 'Alias')); ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPasienM[nama_bin]', '', array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Tgl. Lahir', 'tanggal_lahir', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPasienM[tanggal_lahir]', '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPendaftaranT[umur]', $modPendaftaran->umur, array('readonly' => true, 'class' => 'span3')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Jenis Kelamin", 'jeniskelamin', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('FAPasienM[jeniskelamin]', '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Penanggung Jawab", 'nama_pj', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php // echo CHtml::hiddenField('penanggungjawab_id',$modKunjungan->penanggungjawab_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php echo CHtml::textField('FAPendaftaranT[nama_pj]', '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Alamat Pasien", 'alamat_pasien', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textArea('FAPasienM[alamat_pasien]', '', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="control">
                <?php echo CHtml::activeHiddenField($modPasien, 'photopasien', array('readonly' => true)); ?>
                <?php
                $url_photopasien = (!empty($modPasien->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasien->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
                ?>
                <img id="photo-preview" src="<?php echo $url_photopasien ?>" style="width: 160px;">
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Data Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 540,
        'resizable' => false,
    ),
));
$modDialogPasien = new BKInformasikasirrawatjalanV('searchDialogKunjungan');
$modDialogPasien->unsetAttributes();
$modDialogPasien->instalasi_id = Params::INSTALASI_ID_RJ;
if (isset($_GET['BKInformasikasirrawatjalanV'])) {
    $modDialogPasien->attributes = $_GET['BKInformasikasirrawatjalanV'];
    $modDialogPasien->instalasi_id = $_GET['BKInformasikasirrawatjalanV']['instalasi_id'];
    $modDialogPasien->no_pendaftaran = (isset($_GET['BKInformasikasirrawatjalanV']['no_pendaftaran']) ? $_GET['BKInformasikasirrawatjalanV']['no_pendaftaran'] : "");
    $modDialogPasien->no_rekam_medik = (isset($_GET['BKInformasikasirrawatjalanV']['no_rekam_medik']) ? $_GET['BKInformasikasirrawatjalanV']['no_rekam_medik'] : "");
    $modDialogPasien->nama_pasien = (isset($_GET['BKInformasikasirrawatjalanV']['nama_pasien']) ? $_GET['BKInformasikasirrawatjalanV']['nama_pasien'] : "");
    $modDialogPasien->carabayar_nama = (isset($_GET['BKInformasikasirrawatjalanV']['carabayar_nama']) ? $_GET['BKInformasikasirrawatjalanV']['carabayar_nama'] : "");
    $modDialogPasien->ruangan_nama = (isset($_GET['BKInformasikasirrawatjalanV']['ruangan_nama']) ? $_GET['BKInformasikasirrawatjalanV']['ruangan_nama'] : "");
}

$cr = new CDbCriteria();
if (!empty($modDialogPasien->instalasi_id)) {
    $cr->addCondition("instalasi_id = $modDialogPasien->instalasi_id");
}
$cr->order = 'ruangan_nama';
$r1 = BKRuanganM::model()->findAll($cr);


$instalasi_id_pilih = $modDialogPasien->instalasi_id;
if ($instalasi_id_pilih == Params::INSTALASI_ID_RI) {
    $instalasi_id_pilih = Params::grupInstalasiRIID();
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pendaftaran-t-grid',
    'dataProvider' => $modDialogPasien->searchDialogKunjungan(),
    'filter' => $modDialogPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {

                $res = CJSON::encode(Yii::app()->controller->getJsonKunjungan($data));


                return CHtml::Link('<i class="icon-form-check"></i>', 'javascript:void(0);', array(
                    'class' => 'btn-small',
                    'id' => 'selectPendaftaran',
                    'onClick' => 'cekValidasiPJADanAkomodasi(' . $res . '); $("#dialogPasien").dialog("close"); return false;'
                ));
            },
        ),
        array(
            'name' => 'no_pendaftaran',
            'type' => 'raw',
            'value' => '$data->no_pendaftaran',
            'filter' => Chtml::activeTextField($modDialogPasien, 'no_pendaftaran', array('class' => 'angkahuruf-only'))
        ),
        array(
            'name' => 'no_rekam_medik',
            'type' => 'raw',
            'value' => '$data->no_rekam_medik',
            'filter' => Chtml::activeTextField($modDialogPasien, 'no_rekam_medik', array('class' => 'numbers-only'))
        ),
        array(
            'name' => 'nama_pasien',
            'type' => 'raw',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'filter' => Chtml::activeTextField($modDialogPasien, 'nama_pasien', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jenis Kelamin',
            'name' => 'jeniskelamin',
            'value' => '$data->jeniskelamin',
            'filter' => CHtml::dropDownList('BKInformasikasirrawatjalanV[jeniskelamin]', $modDialogPasien->jeniskelamin, LookupM::getItems('jeniskelamin'), array('empty' => '-- Pilih --')) .
                CHtml::activeHiddenField($modDialogPasien, 'instalasi_id'),
        ),
        array(
            'name' => 'tgl_pendaftaran',

            'filter' => false,
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);'
            //CHtml::activeTextField($modDialogPasien, 'tgl_pendaftaran_cari', array('placeholder'=>'contoh: 15 Jan 2013')),
        ),
        array(
            'header' => 'Ruangan',
            'name' => 'ruangan_nama',
            'type' => 'raw',
            'filter' => CHtml::activeDropDownList($modDialogPasien, 'ruangan_id', CHtml::listData(
                RuanganM::model()->findAllByAttributes(array(
                    'instalasi_id' => $instalasi_id_pilih,
                    'ruangan_aktif' => true,
                ), array('order' => 'ruangan_nama')),
                'ruangan_id',
                'ruangan_nama'
            ), array(
                'empty' => '-- Pilih --',
            )),
        ),
        array(
            'header' => 'Jenis Penjamin',
            'name' => 'carabayar_id',
            'type' => 'raw',
            'value' => '$data->carabayar_nama',
            'filter' =>  CHtml::dropDownList('BKInformasikasirrawatjalanV[carabayar_id]', $modDialogPasien->carabayar_id, CHtml::listData(CarabayarM::model()->findAll("carabayar_aktif = TRUE ORDER BY carabayar_nama ASC"), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --'))
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
                setAngkaHurufOnly(this);
            });'
        . '}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
<script type="text/javascript">
    var carabayar_id = null;

    function resetDataPasien() {

        $('#FAPendaftaranT_tgl_pendaftaran').val("");
        $('#FAPendaftaranT_no_pendaftaran').val("");
        $('#FAPendaftaranT_umur').val("");
        $('#FAPendaftaranT_jeniskasuspenyakit_nama').val("");
        $('#FAPendaftaranT_instalasi_nama').val("");
        $('#FAPendaftaranT_ruangan_nama').val("");
        $('#FAPendaftaranT_pendaftaran_id').val("");
        $('#FAPendaftaranT_pasien_id').val("");
        $('#FAPendaftaranT_carabayar_id').val("");
        $('#FAPendaftaranT_penjamin_id').val("");
        $('#FAPendaftaranT_kelaspelayanan_id').val("");
        $('#FAPendaftaranT_kelastanggungan_nama').val("");
        $('#FAPasienM_no_rekam_medik').val("");
        $('#FAPasienM_jeniskelamin').val("");
        $('#FAPasienM_nama_pasien').val("");
        $('#FAPasienM_nama_bin').val("");
        $('#FAPasienM_tanggal_lahir').val("");
        $('#FAPasienM_jeniskelamin').val("");
        $('#FAPasienM_alamat_pasien').val("");
        $('#FAPendaftaranT_carabayar_nama').val("");
        $('#FAPendaftaranT_penjamin_nama').val("");
        $('#FAPendaftaranT_nama_pj').val("");

        $("#grup_kelas_tanggungan").hide();

        $(".dpjp :input").val("");
        $(".dpjp").hide();

        $("#tblBayarTind tbody, #tblBayarOA tbody").empty();

        hitungTotalSemuaTind();
        hitungTotalSemuaOa();
    }

   
    function cekValidasiPJADanAkomodasi(data) {
        var instalasi_yangdipilih = $('#instalasi_id').val();
        // cek validasi pja sudah dilakukan apa belum
        $.post('<?= $this->createUrl('cekValidasiPJADanAkomodasi') ?>', {
            pendaftaran_id:data.pendaftaran_id
        }, function(res){
            
            if (instalasi_yangdipilih != 4) {
                if (res.statusPJA == 1) {
                    isiDataPasien(data);
                    loadPembayaran(data.pendaftaran_id);
                } else {
                    myAlert('Belum dilakukan validasi PJA');
                    return false;
                }
            } else {
                if (res.statusPJA == 1){
                    // jika instalasi rawat inap dan status pja sudah validasi dan akomodasi sudah simpan
                    if (res.statusAkomodasi == 1) {
                        isiDataPasien(data);
                        loadPembayaran(data.pendaftaran_id);
                    } else {
                        myAlert('Belum verifikasi akomodasi');
                    }
                } else {
                    if (res.statusAkomodasi == 0) {
                        myAlert('Belum verifikasi PJA dan Belum verifikasi akomodasi');
                        return false;
                    } else {
                        myAlert('Belum dilakukan validasi PJA');
                        return false;
                    }
                }
            }

        }, 'json');
    }
    

    function isiDataPasien(data) {

        console.log('sini verif');
        console.log(data);

        $('#FAPendaftaranT_tgl_pendaftaran').val(data.tgl_pendaftaran);
        $('#FAPendaftaranT_no_pendaftaran').val(data.no_pendaftaran);
        $('#FAPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#FAPendaftaranT_umur').val(data.umur);
        $('#FAPendaftaranT_jeniskasuspenyakit_nama').val(data.jeniskasuspenyakit);
        $('#FAPendaftaranT_instalasi_nama').val(data.namainstalasi);
        $('#FAPendaftaranT_ruangan_nama').val(data.namaruangan);
        $('#FAPendaftaranT_pendaftaran_id').val(data.pendaftaran_id);
        $('#FAPendaftaranT_pasien_id').val(data.pasien_id);
        $('#FAPendaftaranT_carabayar_id').val(data.carabayar_id);
        $('#FAPendaftaranT_penjamin_id').val(data.penjamin_id);
        $('#FAPendaftaranT_kelaspelayanan_id').val(data.kelaspelayanan_id);
        if (typeof data.norekammedik != 'undefined') {
            $('#FAPasienM_no_rekam_medik').val(data.norekammedik);
        }
        $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#FAPasienM_nama_pasien').val(data.namapasien);
        $('#FAPasienM_nama_bin').val(data.namabin);
        $('#FAPasienM_tanggal_lahir').val(data.tanggal_lahir);
        $('#FAPasienM_jeniskelamin').val(data.jeniskelamin);
        $('#FAPasienM_alamat_pasien').val(data.alamat_pasien);
        $('#FAPendaftaranT_carabayar_nama').val(data.carabayar_nama);
        $('#FAPendaftaranT_penjamin_nama').val(data.penjamin_nama);
        $('#FAPendaftaranT_nama_pj').val(data.nama_pj);

        carabayar_id = data.carabayar_id;

        if (data.kelastanggungan != '') {
            $("#grup_kelas_tanggungan").show();
            $('#FAPendaftaranT_kelastanggungan_nama').val(data.kelastanggungan);
        } else {
            $("#grup_kelas_tanggungan").hide();
        }

        if (data.dokterpenerima != '' || data.dpjp1 != '' || data.dpjp2 != '' || data.dpjp3 != '') {
            if (data.dokterpenerima != '') $("#dokterpenerima").val(data.dokterpenerima);
            if (data.dpjp1 != '') $("#dpjp1").val(data.dpjp1);
            if (data.dpjp2 != '') $("#dpjp2").val(data.dpjp2);
            if (data.dpjp3 != '') $("#dpjp3").val(data.dpjp3);
            $(".dpjp").show();
        } else {
            $(".dpjp :input").val("");
            $(".dpjp").hide();
        }

        renameInputRow('#tblBayarTind');

    }

    /**
     * rename input row yang terakhir di tambahkan
     * @param {type} obj_table
     */
    function renameInputRow(obj_table){

        console.log('masuk rename');
        console.log('panjang tabel: ' + $(obj_table).length);
        console.log($(obj_table).find("tbody").length);

        var row = 0;
        $(obj_table).find("tbody tr").each(function(){

            console.log('masuk rename tr');

            $(this).find("#no_urut").val(row+1);
            $(this).find(".nomor").html(row+1);
            $(this).find("#row").val(row);
            $(this).find('span[name*="[ii]"]').each(function(){ //element <span>
                var new_name = $(this).attr("name").replace("ii",(row));
                $(this).attr("name",new_name);
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }
            });
            row++;
            if($(this).find("#row").length){ //untuk index tr baris ke-2 dianggap 1 baris dengan atasnya (karena berisi keterangan lanjutan)
                row--; 
            }
        }); 
    }

    function loadPembayaran(pendaftaran_id, penjualanresep) {

        var instalasi_id = $("#instalasi_id").val();

        <?php $tindakanParam = ',tindakan : 1'; ?>
        $.post('<?php echo Yii::app()->createUrl('billingKasir/ActionAjax/loadPembayaranVerifikasi&is_verif=1'); ?>', {
            pendaftaran_id: pendaftaran_id, instalasi_id: instalasi_id,
            penjualanResep: penjualanresep<?php echo $tindakanParam; ?>
        }, function(data) {

            setTimeout(function() {
                if (is_load) {
                    hitungLoadAdmin(persen_admin);
                    is_load = false;
                }
            }, 750);
            $('#tblBayarTind tbody').html(data.formBayarTindakan);
            $('#tblBayarOA tbody').html(data.formBayarOa);
            $('#totTagihan').val(formatInteger(data.tottagihan));

            $('#TandabuktibayarT_jmlpembayaran').val(formatInteger(data.jmlpembayaran));
            $('#TandabuktibayarT_jmlpembulatan').val(formatInteger(data.jmlpembulatan));
            $('#TandabuktibayarT_uangditerima').val(formatInteger(data.uangditerima));
            $('#TandabuktibayarT_uangkembalian').val(formatInteger(data.uangkembalian));
            $('#TandabuktibayarT_biayamaterai').val(formatInteger(data.biayamaterai));
            $('#TandabuktibayarT_biayaadministrasi').val(formatInteger(data.biayaadministrasi));
            if (data.photopasien != "") { //set photo
                $("#<?php echo CHtml::activeId($modPasien, "photopasien"); ?>").val(data.photopasien);
                $('#photo-preview').attr('src', '<?php echo Params::urlPasienTumbsDirectory() . "kecil_" ?>' + data.photopasien);
            } else {
                $('#photo-preview').attr('src', '<?php echo Params::urlPhotoPasienDirectory() . "no_photo.jpeg" ?>');
            }
            var norekammedik = $('#FAPasienM_no_rekam_medik').val();
            var no_pendaftaran = $('#FAPendaftaranT_no_pendaftaran').val();
            var nama_pembayar = norekammedik + '-' + no_pendaftaran + '-' + data.namapasien;

            if (penjualanresep != undefined) {
                var no_resep = $('#no_resep').val();
                nama_pembayar = norekammedik + '-' + no_resep + '-' + data.namapasien;
            }
            //        $('#TandabuktibayarT_darinama_bkm').val(data.namapasien);
            $('#TandabuktibayarT_darinama_bkm').val(nama_pembayar);
            $('#TandabuktibayarT_alamat_bkm').val(data.alamatpasien);

            var discount = 0;
            discount = unformatNumber($('#totaldiscount_tindakan').val()) + unformatNumber($('#totaldiscount_oa').val());
            $('#disc').val(0);
            $('#discount').val(0);
            $('#tblBayarTind').find('input.integer2:text').each(function() {
                $(this).maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0
                });
            });
            $('#tblBayarOA').find('input.integer2:text').each(function() {
                $(this).maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 0
                });
            });
            $('.qty_tindakan').each(function() {
                $(this).maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": "",
                    "precision": 0
                });
            });
            $('.currency').each(function() {
                this.value = formatInteger(this.value)
            });
            //Load Deposit
            $('#deposit').val(formatInteger(data.deposit));
            $('#TandabuktibayarT_uangditerima').focus();


            hitungTotalSemuaTind();
            hitungTotalSemuaOa();

            persen_admin = data.persen_admin;
            is_load = true;

            setTimeout(function() {
                $(".tindakanpelayanan_id").each(function() {
                    hitungTarifTindakan(this, $(this).val());
                });
                hitungTotalSemuaTind();

                $(".obatalkespasien_id").each(function() {
                    hitungTarifObat(this, $(this).val());
                });
                hitungTotalSemuaOa();
            }, 600);

            console.log('----------ke sini -----------------');
            console.log('panjang tabel --- : ' + $('#tblBayarTind').find("tbody tr").length);

            renameInputRow('#tblBayarTind');

        }, 'json');

    }

    function hitungLoadAdmin(persen_admin) {
        var total_biaya = parseFloat(unformatNumber($("#total_pembayaran").val()));
        var instalasi_id = $("#instalasi_id").val();
        $("#biaya_administrasi").val(0);
        if (instalasi_id != <?php echo Params::INSTALASI_ID_RI; ?>) return false;
        $("#biaya_administrasi").val(formatNumber(total_biaya * persen_admin / 100));
    }

    function refreshDialogPendaftaran() {
        var instalasiId = $("#instalasi_id").val();
        var instalasiNama = $("#instalasi_id option:selected").text();
        $.fn.yiiGridView.update('pendaftaran-t-grid', {
            data: {
                "BKInformasikasirrawatjalanV[instalasi_id]": instalasiId,
            }
        });
    }

    function cekInstalasi() {
        var instalasiId = $("#BKPendaftaranT_instalasi_id").val();
        if (instalasiId.length > 0) {
            return true;
        } else {
            myAlert("Silakan pilih instalasi ! ");
            $("#BKPendaftaranT_instalasi_id").focus();
            return false;
        }
    }
</script>