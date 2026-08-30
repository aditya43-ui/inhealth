            <div class="panel-heading">
                <div class="panel-title">Rujukan</div>
            </div>
            <div class="panel-body">
                <!--- MULAI RUJUKAN --->


                <p class="help-block">
                    <?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

                <div class="control-group">
                    <?php echo CHtml::label("Sample Lab <span class='required'>*</span> ", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                    echo $form->dropDownList($modKirimKeUnitLain, 'samplelab_id', CHtml::listData(SamplelabM::model()->findAll("samplelab_aktif = TRUE AND jenispemeriksaanlab_kelompok = 'MIKROBIOLOGI KLINIK' ORDER BY samplelab_nama ASC"), 'samplelab_id', 'samplelab_nama'), array('class' => 'span3 samplelab', 'empty' => '-- Pilih --', 'onchange' => 'setBahan(this, ' . (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null) . ');'));
                ?>
                    </div>
                </div>

                <?php echo $form->dropDownListRow($modKirimKeUnitLain,'caraambilsampel_id', CHtml::listData(CaraambilsampelM::model()->findAllByAttributes(array('caraambilsampel_aktif' => true)), 'caraambilsampel_id', 'caraambilsampel_nama') ,array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'caraambilsample', 'empty' => '-- Pilih --')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($modKirimKeUnitLain, 'catatandokterpengirim', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($modKirimKeUnitLain, 'catatandokterpengirim', array('class' => 'catatan')); ?>
                    </div>
                    <div class="controls">
                        <?php
                    // echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', array(
                    //     'class' => 'btn btn-primary', 'onclick' => "inputperiksanew()",
                    //     'id' => 'btnAddPengobatanYgSudahDilakukan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    //     'rel' => 'tooltip', 'title' => 'Klik'
                    // ))
                ?>
                    </div>

                </div>
                <label>
                    <p style="font-weight: bold"> Data Dokter Pengirim </p>
                </label>
                <div class="control-group">
                    <?php echo CHtml::label("Nama DPJP <span class='required'>*</span> ", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modKirimKeUnitLain, 'pegawai_id', array('class' => 'span3 required')) ?>
                        <?php
                // var_dump($modKirimKeUnitLain->dpjp_nama);die;
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'dpjp_nama',
                        'value' => isset($modKirimKeUnitLain->pegawai_id) ? $modKirimKeUnitLain->pegawai->nama_pegawai : '-',
                        'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompletePetugas') . '",
                                           dataType: "json",
                                           data: {
                                               term: request.term,
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
                                                    $(this).val("");
                                                    return false;
                                                }',
                            'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#dpjp_nama").val(ui.item.nama_pegawai);
                                            $("#' . CHtml::activeId($modKirimKeUnitLain, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 dpjp_id',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogDokter'),
                    ));
                    ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nama PPDS</label>
                    <div class="controls">
                        <?php echo $form->hiddenField($modKirimKeUnitLain, 'ppds_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modKirimKeUnitLain,
                                'attribute' => 'ppds_nama',
                                'source' => 'js: function(request, response) {
                                        $.ajax({
                                                url: "' . $this->createUrl('/actionAutoComplete/PPDS') . '",
                                                dataType: "json",
                                                data: {
                                                    term: request.term,
                                                },
                                                success: function (data) {
                                                    response(data);
                                                }
                                        })
                                     }',
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 3,
                                    'select' => 'js:function( event, ui ) {
                                                $(this).val( ui.item.ppds_nama );
                                                $("#RJPasienKirimKeUnitLainT_ppds_id").val( ui.item.ppds_id);
                                                setPpds(ui.item.ppds_id);
                                                return false;
                                    }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3', 'placeholder' => 'Ketikkan Nama PPDS  '),
                                'tombolDialog' => array('idDialog' => 'dialogPpds', 'idTombol' => 'tombolPpds'),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group" hidden>
                    <label class="control-label">NIM</label>
                    <div class="controls">
                        <?PHP //echo CHtml::textField('nim','',array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group" hidden>
                    <label class="control-label">Nama Prodi</label>
                    <div class="controls">
                        <?PHP //echo CHtml::textField('nama_prodi', '', array('readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group" hidden>
                    <label class="control-label">No. HP</label>
                    <div class="controls">
                        <?PHP //echo CHtml::textField('no_hp', '', array('readonly' => true)); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label><b>Data Pelengkap Diagnosis</b></label>
                    <div class="controls">

                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Diagnosis</label>
                    <div class="controls">
                        <?php echo $form->textField($modKirimKeUnitLain,'diagnosis',array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>

                        <?php //echo CHtml::textField($modKirimKeUnitLain,'diagnosis',array('readonly'=>true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label"> Tindakan Medik </label>
                    <div class="controls">

                        <?php 
            echo $form->checkBoxList(
                $modKirimKeUnitLain,
                'klinis_penunjang_infeksi',
                array(
                    'injeksi' => 'Injeksi',
                    'kateter' => 'Kateter',
                    'infus' => 'Infus',
                    'lain-lain' => 'Lain-lain'
                ),
                array(
                    //'template' => '{input} {label}',
                    'separator' => '<br>',
                )
            );
            //echo $form->textField($modKirimKeUnitLain,'klinis_penunjang_infeksi',array('onkeypress'=>"return $(this).focusNextInputField(event);", 'class' => 'required'))
             ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Keterangan</label>
                    <div class="controls">
                        <?php echo $form->textArea($modKirimKeUnitLain,'keteranganklinislain',array('onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>

                <div class="control-group">
                    <label><b>Permintaan Pemeriksaan Mikrobiologi</b></label>
                    <div class="controls">

                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                        Tanggal Permintaan
                        <span class="required">*</span>
                    </label>
                    <?php $modKirimKeUnitLain->tgl_kirimpasien = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->tgl_kirimpasien, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                        <?php   
					$this->widget('MyDateTimePicker',array(
						'model'=>$modKirimKeUnitLain,
						'attribute'=>'tgl_kirimpasien',
						'mode'=>'datetime',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true, 'class'=>'realtime'),
				)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label required" for="RJPasienKirimKeUnitLainT_tgl_kirimpasien">
                        Waktu Ambil Spesimen
                        <span class="required">*</span>
                    </label>
                    <?php $modKirimKeUnitLain->waktuambilspesimen = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modKirimKeUnitLain->waktuambilspesimen, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
                    <div class="controls">
                        <?php   
					$this->widget('MyDateTimePicker',array(
						'model'=>$modKirimKeUnitLain,
						'attribute'=>'waktuambilspesimen',
						'mode'=>'datetime',
						'options'=> array(
							'dateFormat'=>Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions'=>array('readonly'=>true, 'class'=>''),
				)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">No. Permintaan</label>
                    <div class="controls">
                        <?php echo $form->textField($modKirimKeUnitLain,'no_permintaan',array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Antibiotik yang sudah diberikan</label>
                    <div class="controls">
                        <?php echo $form->textArea($modKirimKeUnitLain,'antibiotikygdiberi',array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                    </div>
                    <div class="controls">
                        <?php
                        echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i> <i class="icon-white icon-chevron-right"></i>', array(
                            'class' => 'btn btn-primary', 'onclick' => "$('#dialogAntibiotik').dialog('open');",
                            'id' => 'btnAddPengobatanYgSudahDilakukan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'rel' => 'tooltip', 'title' => 'Klik' . $modKirimKeUnitLain->getAttributeLabel('antibiotikygdiberi')
                        ))
                        ?>
                    </div>
                    <div class="controls">
                        <?php echo $form->checkBox($modKirimKeUnitLain, 'antibiotikygdiberi_tidakada', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => 'cekAntibiotik()')); ?>
                        <label> Tidak Ada </label> <br>
                    </div>

                </div>
                <div class="control-group">
                    <label class="control-label">Berapa lama</label>
                    <div class="controls">
                        <?php echo $form->textField($modKirimKeUnitLain,'antibiotik_hari',array('class'=>'numbers-only','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        <label>hari</label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Temperatur Aksiler</label>
                    <div class="controls">
                        <?php echo $form->textField($modKirimKeUnitLain,'temp_aksiler',array('class'=>'numbers-only','readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event);")) ?>
                        <label>&deg;C</label>
                    </div>
                </div>
                <div class='control-group'>
                    <?php echo CHtml::label("Cyto", CHtml::activeId($modKirimKeUnitLain, 'is_cito'), array('class' => 'control-label')) ?>
                    <div class='controls'>
                        <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
                    </div>
                </div>

                <!--- END RUJUKAN --->
            </div>