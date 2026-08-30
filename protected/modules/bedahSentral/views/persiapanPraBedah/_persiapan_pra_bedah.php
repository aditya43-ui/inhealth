<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tanggal',
                    'value' => null,
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'minDate' => 'd',
                    ),
                    'htmlOptions' => array(
                        'readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 htpd',
                        'placeholder' => date('d M Y H:i:s'),
                        'disabled' => $jenis == 'lihat',
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Perawat</label>
            <div class="controls">
                <?php
                    echo $form->hiddenField($model, 'perawat_id',['class'=>'perawat_id']);
                    $this->widget('MyJuiAutoComplete', array(
                        'model'=>$model,
                        'attribute' => 'perawat_nama',
                        'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                            dataType: "json",
                            data: {
                                term: request.term,
                                ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
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
                                $(this).val("");
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $(".perawat_id").val(ui.item.pegawai_id);
                                $(".perawat_nama").val(ui.item.namaLengkap);                                
                                return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class'=>'perawat_nama',
                            'disabled' => $jenis == 'lihat',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPerawat'),
                    ));
                ?>
            </div>
        </div>
    </div>
</div>
<!--=======================================================-->
<hr style="margin-bottom: 15px;" />
<!--=======================================================-->
<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label">Pilih Permintaan Bedah</label>
            <div class="controls">
                <?php
                    $criteriaRencanaOperasi = new CDbCriteria();
                    $criteriaRencanaOperasi->addCondition('ruangan_id = 57');
                    $criteriaRencanaOperasi->addCondition('pasienmasukpenunjang_id IS NULL');
                    $criteriaRencanaOperasi->addCondition('pendaftaran_id = ' . $_GET['pendaftaran_id']);
                    $criteriaRencanaOperasi->select = array("CONCAT('Permintaan Bedah Tgl',' ',tgl_kirimpasien) as tgl, pasienkirimkeunitlain_id, pendaftaran_id");
                    $rencanaOperasi = BSPasienKirimKeUnitLainT::model()->findAll($criteriaRencanaOperasi);
                    $modRiwayatKirimKeUnitLain = CHtml::listData($rencanaOperasi, 'pasienkirimkeunitlain_id', 'tgl');
                    echo $form->dropDownList($model, 'pasienkirimkeunitlain_id', $modRiwayatKirimKeUnitLain, array(
                        'empty' => '-- Pilih --', 
                        'class' => 'span3', 
                        'disabled' => $jenis == 'lihat',
                        'onkeyup' => "return $(this).focusNextInputField(event);",
                        'ajax' => array(
                            'type' => 'POST',
                            'url' => $this->createUrl('SetDropdownTindakan', array('encode' => false, 'model_nama' => get_class($model))),
                            'success' => 'function(data){$("#' . CHtml::activeId($model, "rencanaoperasi_id") . '").html(data);}',
                        ),  
                    ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
        1. Tindakan yang dilakukan
        2. Tekanan Darah
    -->
    <div class="col-sm-6">
        <?php
            // // DROPDOWN RENCANA OPERASI
            // $criteriaRencanaOperasi = new CDbCriteria();
            // $criteriaRencanaOperasi->with = array('operasi');
            // $criteriaRencanaOperasi->addCondition('pendaftaran_id = ' . $_GET['pendaftaran_id']);
            // $criteriaRencanaOperasi->select = array('rencanaoperasi_id, operasi.operasi_nama as operasi_nama');
            // $rencanaOperasi = RencanaoperasiT::model()->findAll($criteriaRencanaOperasi);
            // $dropDownrencanaOperasi = CHtml::listData($rencanaOperasi, 'rencanaoperasi_id', 'operasi_nama');
            // echo $form->dropDownListRow($model, 'rencanaoperasi_id', $dropDownrencanaOperasi, array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); 
        ?>
        <?php echo $model->rencanaoperasi_id;
            echo $form->dropDownListRow($model, 'rencanaoperasi_id', CHtml::listData($model->getPasienIcdItems($model->pendaftaran_id), 'pasienicd9cm_id', 'nama'),
                array(
                    'class' => 'span3', 
                    'empty' => '-- Pilih --', 
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'value' => 124,
                    'disabled' => $jenis == 'lihat',
                )
            ); 
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label" for="PelayananpembedahanT_tgl_skrining">Tekanan Darah</label>
            <div class="controls">
                <?php
                echo $form->textField($model, 'tensi_sistolik', array('class' => 'span3 integer2', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?> /
                <?php
                echo $form->textField($model, 'tensi_diastolik', array('class' => 'span3 integer2', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?> mmHg
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!--
        1. Ceklis Operasi
        2. Nadi
    -->
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label" for="PelayananpembedahanT_is_ceklispreoperasi">Ceklis Pre Operasi</label>
            <div class="controls">
                <?php echo CHtml::activeRadioButtonList(
                    $model,
                    'is_ceklispreoperasi',
                    array(
                        'ada' => 'Ada<span style="margin-left:30px;">&nbsp;</span>',
                        'tidak ada' => 'Tidak ada'
                    ),
                    array('labelOptions' => array('style' => 'display:inline;'), 'disabled' => $jenis == 'lihat', 'separator' => '  ')
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'nadi', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'nadi', array('class' => 'span3 integer2', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?> x/menit
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
        1. Persiapan Darah
        2. Suhu
    -->
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'persiapandarah', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'persiapandarah', array('class' => 'span3', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'suhu', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'suhu', array('class' => 'span3 float2', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?> C
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
        1. Jenis Darah
        2. RR
    -->
    <div class="col-sm-6">
        <?php
        $jenisDarah = JeniskomponendarahM::model()->findAll('jeniskantongdarah_aktif = true order by jeniskomponenedarah_nama');
        $dropDownJenisDarah = CHtml::listData($jenisDarah, 'jeniskomponendarah_id', 'jeniskomponenedarah_nama');
        echo $form->dropDownListRow($model, 'jeniskomponendarah_id', $dropDownJenisDarah, array('empty' => '-- Pilih --', 'class' => 'span3', 'disabled' => $jenis == 'lihat', 'onkeyup' => "return $(this).focusNextInputField(event);"));
        ?>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'rr', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'rr', array('class' => 'span3 integer2', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?> x/menit
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
        1. Jumlah Darah
        2. Cukur
    -->
    <div class="col-sm-6">
        <div class="control-group ">
            <?php
            echo $form->labelEx($model, 'jumlahdarah', array('class' => 'control-label'));
            ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'jumlahdarah', array('class' => 'span3', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label" for="PelayananpembedahanT_tgl_skrining">Cukur</label>
            <div class="controls">
                <?php echo CHtml::activeRadioButtonList(
                    $model,
                    'is_cukur',
                    array(
                        1 => 'Sudah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                        0 => 'Belum'
                    ),
                    array('labelOptions' => array('style' => 'display:inline;'), 'disabled' => $jenis == 'lihat', 'separator' => '  ')
                ); ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
        1. GCS
        2. Kompres disinfektan
    -->
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label" for="PelayananpembedahanT_gcs">GCS (Glasgow Coma Scale)</label>
            <div class="controls">
                <div class="row-fluid">
                    <?php
                    $gcs = MetodegcsM::model()->findAll("metodegcs_aktif = true and metodegcs_singkatan = 'E' order by metodegcs_nama");
                    $dropDownGcs = CHtml::listData($gcs, 'metodegcs_id', 'metodegcs_nama');
                    echo $form->dropDownListRow($model, 'gcs_eye_id', $dropDownGcs, array('empty' => '-- Pilih --', 'disabled' => $jenis == 'lihat', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    ?>
                </div>
                <div class="row-fluid">
                    <?php
                    $gcs = MetodegcsM::model()->findAll("metodegcs_aktif = true and metodegcs_singkatan = 'V' order by metodegcs_nama");
                    $dropDownGcs = CHtml::listData($gcs, 'metodegcs_id', 'metodegcs_nama');
                    echo $form->dropDownListRow($model, 'gcs_verbal_id', $dropDownGcs, array('empty' => '-- Pilih --', 'disabled' => $jenis == 'lihat', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    ?>
                </div>
                <div class="row-fluid">
                    <?php
                    $gcs = MetodegcsM::model()->findAll("metodegcs_aktif = true and metodegcs_singkatan = 'M' order by metodegcs_nama");
                    $dropDownGcs = CHtml::listData($gcs, 'metodegcs_id', 'metodegcs_nama');
                    echo $form->dropDownListRow($model, 'gcs_motorik_id', $dropDownGcs, array('empty' => '-- Pilih --', 'disabled' => $jenis == 'lihat', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="row-fluid">
            <div class="control-group ">
                <label class="control-label" for="PelayananpembedahanT_tgl_skrining">Kompres Diisfektan</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList(
                        $model,
                        'is_kompresdisinfektan',
                        array(
                            1 => 'Ada<span style="margin-left:30px;">&nbsp;</span>',
                            0 => 'Tidak Ada'
                        ),
                        array('labelOptions' => array('style' => 'display:inline;'), 'disabled' => $jenis == 'lihat', 'separator' => '  ')
                    ); ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="control-group ">
                <label class="control-label" for="PelayananpembedahanT_tgl_skrining">Kateter menetap</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList(
                        $model,
                        'is_katetermenetap',
                        array(
                            1 => 'Ada<span style="margin-left:30px;">&nbsp;</span>',
                            0 => 'Tidak Ada'
                        ),
                        array('labelOptions' => array('style' => 'display:inline;'), 'disabled' => $jenis == 'lihat', 'separator' => '  ')
                    ); ?>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="control-group ">
                <label class="control-label" for="PelayananpembedahanT_tgl_skrining">Gigi palsu / perhiasan</label>
                <div class="controls">
                    <?php echo CHtml::activeRadioButtonList(
                        $model,
                        'is_gigipalsu',
                        array(
                            1 => 'Ada<span style="margin-left:30px;">&nbsp;</span>',
                            0 => 'Tidak Ada'
                        ),
                        array('labelOptions' => array('style' => 'display:inline;'), 'disabled' => $jenis == 'lihat', 'separator' => '  ')
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--=======================================================-->
<hr style="margin-bottom: 15px;" />
<!--=======================================================-->
<div class="row-fluid">
    <!-- 
        1. Dekubitus
        2. Pipa Lambung
    -->
    <div class="col-sm-6">
        <label class="control-label" for="PelayananpembedahanT_is_dekubitus">
            <?php echo $form->checkBox($model, 'is_dekubitus', array('class' => 'dekubitus autoEnable', 'disabled' => $jenis == 'lihat',))
                . $form->labelEx($model, 'is_dekubitus'); ?>
        </label>
        <div class="controls">
            <?php
            echo $form->textField(
                $model,
                'dekubitus_keterangan',
                array('class' => 'span3 PelayananpembedahanT_is_dekubitus', 'rows' => 3, 'disabled' => true)
            );
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pipalambung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'pipalambung', array('class' => 'span3', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
        1. Kontraktur
        2. Infus perifer / sentral
    -->
    <div class="col-sm-6">
        <label class="control-label" for="PelayananpembedahanT_is_kontraktur">
            <?php echo $form->checkBox($model, 'is_kontraktur', array('class' => 'kontraktur autoEnable', 'disabled' => $jenis == 'lihat',))
                . $form->labelEx($model, 'is_kontraktur'); ?>
        </label>
        <div class="controls">
            <?php
            echo $form->textField(
                $model,
                'kontraktur_keterangan',
                array('class' => 'span3 PelayananpembedahanT_is_kontraktur', 'rows' => 3, 'disabled' => true)
            );
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'infusperifer', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'infusperifer', array('class' => 'span3', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
        1. Fraktur
        2. Pipa naso / orofaring
    -->
    <div class="col-sm-6">
        <label class="control-label" for="PelayananpembedahanT_is_fraktur">
            <?php echo $form->checkBox($model, 'is_fraktur', array('class' => 'fraktur autoEnable', 'disabled' => $jenis == 'lihat',))
                . $form->labelEx($model, 'is_fraktur'); ?>
        </label>
        <div class="controls">
            <?php
            echo $form->textField(
                $model,
                'fraktur_keterangan',
                array('class' => 'span3 PelayananpembedahanT_is_fraktur', 'rows' => 3, 'disabled' => true)
            );
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <label class="control-label" for="PelayananpembedahanT_pipanaso">Pipa naso / orofaring</label>
            <div class="controls">
                <?php
                echo $form->textField($model, 'pipanaso', array('class' => 'span3', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <!-- 
                1. 
                2. Pipa endotracheal
            -->
    <div class="col-sm-6">
        <label class="control-label" for="PelayananpembedahanT_is_lukaluka">
            <?php echo $form->checkBox($model, 'is_lukaluka', array('class' => 'lukaluka autoEnable', 'disabled' => $jenis == 'lihat',))
                . $form->labelEx($model, 'is_lukaluka'); ?>
        </label>
        <div class="controls">
            <?php
            echo $form->textField(
                $model,
                'lukaluka_keterangan',
                array('class' => 'span3 PelayananpembedahanT_is_lukaluka', 'rows' => 3, 'disabled' => true)
            );
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pipaendotracheal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                echo $form->textField($model, 'pipaendotracheal', array('class' => 'span3', 'disabled' => $jenis == 'lihat', 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-sm-6">
        <label class="control-label" for="PelayananpembedahanT_is_tracheostomy">
            <?php echo $form->checkBox($model, 'is_tracheostomy', array('class' => 'traccheostomy autoEnable', 'disabled' => $jenis == 'lihat',))
                . $form->labelEx($model, 'is_tracheostomy'); ?>
        </label>
        <div class="controls">
            <?php
            echo $form->textField(
                $model,
                'traccheostomy_keterangan',
                array('class' => 'span3 PelayananpembedahanT_is_tracheostomy', 'rows' => 3, 'disabled' => true)
            );
            ?>
        </div>
    </div>
</div>