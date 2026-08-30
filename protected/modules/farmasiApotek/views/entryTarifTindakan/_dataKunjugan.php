<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Data <b>Kunjungan </b>
        </div>
    </div>
    <div class="panel-body">
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
                                'FAPasienM[idInstalasi]',
                                NULL,
                                CHtml::listData($modPendaftaran->getInstalasiRawatDanRI(), 'instalasi_id', 'instalasi_nama'),
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
                                    isiDataPasien(ui.item);
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
                                                        isiDataPasien(ui.item);
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
                                                            isiDataPasien(ui.item);
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
    </div>
</div>


<?php $this->renderPartial('_dialogPasien', [

]) ?>

