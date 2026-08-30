<?php
$nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps" : "");
$alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps" : "");

$konSys = KonfigsystemK::model()->find();

$drop_lookjeniskelamin = LookupM::getItems('jeniskelamin');
//if ($this->id == "pendaftaranPersalinan") {
//    unset($drop_lookjeniskelamin[Params::JENIS_KELAMIN_LAKI_LAKI]);
//}
?>
<div class="box" id='fieldsetPasien'>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-user"></i> Data <b>Pasien</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-sm-6">
                    <label class="control-label" style="width:150px">
                        <div class="label_no">
                        <?php echo $form->labelEx($modPasien, 'no_rekam_medik', array('class' => 'control-label')) ?>
                            <div class="cek-pl hide"><i class="entypo-user"></i> <?php echo CHtml::checkBox('isPasienLama', $modPasien->isPasienLama, array('rel' => 'tooltip', 'title' => 'Pilih jika pasien lama', 'onclick' => 'pilihNoRm()', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?></div>
                        </div>
                    </label>
                    <div class="controls" id="controlNoRekamMedik" style="margin-left: -10px; margin-top: 10px;">
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'no_rekam_medik',
                            'value' => isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : "",
                            'sourceUrl' => $this->createUrl('PasienLama'),
                            'options' => array(
                                'showAnim' => 'fold',
                                'style' => 'height:20px;',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
						$("#noRekamMedik").val( ui.item.value );
						return false;
					}',
                                'select' => 'js:function( event, ui ) {
						$(\'#PPBuatJanjiPoliT_pasien_id\').val(ui.item.pasien_id);
						$(\'#no_rekam_medik\').val(ui.item.no_rekam_medik);
						$("#' . CHtml::activeId($modPasien, 'jenisidentitas') . '").val(ui.item.jenisidentitas);
						$("#' . CHtml::activeId($modPasien, 'no_identitas_pasien') . '").val(ui.item.no_identitas_pasien);
						$("#' . CHtml::activeId($modPasien, 'namadepan') . '").val(ui.item.namadepan);
						$("#' . CHtml::activeId($modPasien, 'nama_pasien') . '").val(ui.item.nama_pasien);
						$("#' . CHtml::activeId($modPasien, 'nama_bin') . '").val(ui.item.nama_bin);
						$("#' . CHtml::activeId($modPasien, 'tempat_lahir') . '").val(ui.item.tempat_lahir);
						$("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").val(ui.item.tanggal_lahir);
						$("#' . CHtml::activeId($modPasien, 'kelompokumur_id') . '").val(ui.item.kelompokumur_id);
						$("#' . CHtml::activeId($modPasien, 'jeniskelamin') . '").val(ui.item.jeniskelamin);
						setJenisKelaminPasien(ui.item.jeniskelamin);
						setRhesusPasien(ui.item.rhesus);
                                                setAsuransiPasienLama(ui.item.pasien_id);
						loadDaerahPasien(ui.item.propinsi_id, ui.item.kabupaten_id, ui.item.kecamatan_id, ui.item.kelurahan_id);
						$("#' . CHtml::activeId($modPasien, 'statusperkawinan') . '").val(ui.item.statusperkawinan);
						$("#' . CHtml::activeId($modPasien, 'golongandarah') . '").val(ui.item.golongandarah);
						$("#' . CHtml::activeId($modPasien, 'rhesus') . '").val(ui.item.rhesus);
						$("#' . CHtml::activeId($modPasien, 'alamat_pasien') . '").val(ui.item.alamat_pasien);
						$("#' . CHtml::activeId($modPasien, 'rt') . '").val(ui.item.rt);
						$("#' . CHtml::activeId($modPasien, 'rw') . '").val(ui.item.rw);
						$("#' . CHtml::activeId($modPasien, 'propinsi_id') . '").val(ui.item.propinsi_id);
						$("#' . CHtml::activeId($modPasien, 'kabupaten_id') . '").val(ui.item.kabupaten_id);
						$("#' . CHtml::activeId($modPasien, 'kecamatan_id') . '").val(ui.item.kecamatan_id);
						$("#' . CHtml::activeId($modPasien, 'kelurahan_id') . '").val(ui.item.kelurahan_id);
						$("#' . CHtml::activeId($modPasien, 'no_telepon_pasien') . '").val(ui.item.no_telepon_pasien);
						$("#' . CHtml::activeId($modPasien, 'no_mobile_pasien') . '").val(ui.item.no_mobile_pasien);
						$("#' . CHtml::activeId($modPasien, 'suku_id') . '").val(ui.item.suku_id);
						$("#' . CHtml::activeId($modPasien, 'alamatemail') . '").val(ui.item.alamatemail);
						$("#' . CHtml::activeId($modPasien, 'anakke') . '").val(ui.item.anakke);
						$("#' . CHtml::activeId($modPasien, 'jumlah_bersaudara') . '").val(ui.item.jumlah_bersaudara);
						$("#' . CHtml::activeId($modPasien, 'pendidikan_id') . '").val(ui.item.pendidikan_id);
						$("#' . CHtml::activeId($modPasien, 'pekerjaan_id') . '").val(ui.item.pekerjaan_id);
						$("#' . CHtml::activeId($modPasien, 'agama') . '").val(ui.item.agama);
						$("#' . CHtml::activeId($modPasien, 'warga_negara') . '").val(ui.item.warga_negara);
						loadUmur(ui.item.tanggal_lahir);
						return false;
					}',
                            ),
                            'htmlOptions' => array('placeholder' => 'No. Rekam Medik', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 numbers-only'),
                            // 'tombolDialog' => array('idDialog' => 'dialogPasien', 'idTombol' => 'tombolPasienDialog'),
                        ));
                        ?>
                    </div><br><br><br>
                    <?php //$this->renderPartial('_formNoRM', array('form' => $form, 'model' => $model, 'modPasien' => $modPasien, 'modPegawai' => $modPegawai)) 
                    ?>
                    <!--<div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'no_identitas_pasien', array('class' => 'control-label')) ?>
                                            <div class="controls">
                    <?php
                    echo $form->dropDownList($modPasien, 'jenisidentitas', LookupM::getItems('jenisidentitas'), array(
                        'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'
                    ));
                    ?>   
                    <?php echo $form->textField($modPasien, 'no_identitas_pasien', array('placeholder' => 'No. Identitas', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>            
                    <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
                                            </div>
                                            </div>-->
                    <span hidden>
                        <?php
                        echo $form->dropDownList($modPasien, 'namadepan', LookupM::getItems('namadepan'), array(
                            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1'
                        ));
                        ?>
                    </span>
                    <div class="control-group" style="margin-bottom: 0;">
                        <?php echo $form->labelEx($modPasien, 'nama_pasien', array('class' => 'control-label')) ?>
                        <div class="controls">

                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPasien,
                                'attribute' => 'nama_pasien',
                                'source' => 'js: function(request, response) {
                                                    $.ajax({
                                                        url: "' . $this->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/AutocompletePasienLama') . '",
                                                        dataType: "json",
                                                        data: {
                                                            nama_pasien: request.term,
                                                            tanggal_lahir: $("#' . CHtml::activeId($modPasien, 'tanggal_lahir') . '").val(),
                                                        },
                                                        success: function (data) {
                                                                response(data);
                                                        }
                                                    })
                                                    }',
                                'options' => array(
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
                                                    $(this).val( "");
                                                    return false;
                                                }',
                                    'select' => 'js:function( event, ui ) {
                                                    $(this).val( ui.item.nama_pasien);
                                                    setPasienLama(ui.item.pasien_id);
                                                    return false;
                                                }',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Nama Lengkap Pasien',
                                    'rel' => 'tooltip',
                                    // 'title' => 'Ketik Nama untuk masukan data / mencari pasien',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'class' => 'nama_pasien form-control hurufkomatitik-only span3 ' . $nama_kapital,
                                    // 'onblur' => 'cekJamkespa(); $("#pemilikasuransisesuai").change();',
                                ),
                            ));
                            ?>
                            <?php //echo $form->error($modPasien,'namadepan');
                            ?>
                            <?php //echo $form->error($modPasien,'nama_pasien');
                            ?>
                            <p style="color:red;font-size:11px;">Keterangan : Sesuai Identitas Diri (tanpa tanda baca dan gelar)</p>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modPasien,'nama_bin', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Alias'));  
                    ?>
                    <?php //echo $form->textFieldRow($modPasien,'tempat_lahir', array('class'=>'span4','onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Tempat Lahir')); 
                    ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien, 'tanggal_lahir', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('CMaskedTextField', array(
                                'model' => $modPasien,
                                'attribute' => 'tanggal_lahir',
                                'mask' => '99/99/9999',
                                'htmlOptions' => array(
                                    'placeholder' => '00/00/000',
                                    'class' => 'span3 dtPicker4 datemask',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    'onblur' => 'getUmur(this);'
                                ),
                            ));
                            ?>
                            <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien, 'umur', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('CMaskedTextField', array(
                                'model' => $modPasien,
                                'attribute' => 'umur',
                                'mask' => '99 Thn 99 Bln 99 Hr',
                                'htmlOptions' => array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onblur' => 'getTglLahir(this)', 'placeholder' => 'Umur Pasien')
                            ));
                            ?>
                            <?php echo $form->error($modPasien, 'umur', array('placeholder' => 'Umur Pasien')); ?>                            
                        </div>

                    </div>
                    <?php echo $form->radioButtonListInlineRow($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>

                </div>
                <div class="col-sm-6">
                    <?php //echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)")); 
                    ?>
                    <!--<div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'golongandarah', array('class' => 'control-label')) ?>
                    <div class="controls">
                    <?php echo $form->dropDownList($modPasien, 'golongandarah', LookupM::getItems('golongandarah'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span4'));
                    ?>   
                    <div class="radio inline">
                    <div class="form-inline">
                    <?php echo $form->radioButtonList($modPasien, 'rhesus', LookupM::getItems('rhesus'), array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>            
            </div>
            </div>
                    <?php echo $form->error($modPasien, 'golongandarah'); ?>
                    <?php echo $form->error($modPasien, 'rhesus'); ?>
            </div>
            </div>-->
                    <?php echo $form->textAreaRow($modPasien, 'alamat_pasien', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Alamat Lengkap Pasien',)); ?>
                    <!--<div class="control-group">
                    <?php echo $form->labelEx($modPasien, 'rt', array('class' => 'control-label inline ')) ?>

                                    <div class="controls">
                    <?php echo $form->textField($modPasien, 'rt', array('placeholder' => 'RT', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbersOnly', 'maxlength' => 3)); ?>   / 
                    <?php echo $form->textField($modPasien, 'rw', array('placeholder' => 'RW', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 numbersOnly', 'maxlength' => 3)); ?>            
                    <?php echo $form->error($modPasien, 'rt'); ?>
                    <?php echo $form->error($modPasien, 'rw'); ?>
                                    </div>
                    </div>-->
                    <?php //echo $form->textFieldRow($modPasien,'no_telepon_pasien', array('onkeyup'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Telepon Pasien ','class'=>'span4 numbersOnly'));  
                    ?>
                    <?php //echo $form->textFieldRow($modPasien, 'no_mobile_pasien', array('onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Hp Pasien', 'class' => 'span3')); ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPasien, 'no_mobile_pasien', array('class' => 'control-label')) ?>
                        <div class="controls inline">
                            <?php echo $form->textField($modPasien, 'no_mobile_pasien', array('onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Hp Pasien', 'class' => 'span3')); ?>
                            <?php //echo $form->error($modPasien, 'namadepan');  
                            ?>
                            <span style="color: grey;">*Contoh Format No. Hp 08123456789<span>
                            
                            <?php echo $form->error($modPasien, 'no_mobile_pasien'); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Penjamin', CHtml::activeId($modPasien, 'carabayar_id'), array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPasien, 'carabayar_id', CHtml::listData($modPasien->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                                'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($modPasien))),
                                    'success' => 'function(data){$("#' . CHtml::activeId($modPasien, "penjamin_id") . '").html(data); }',
                                ),
                                //                                    'onchange' => 'setFormAsuransi(this.value);',
                                'class' => 'span3 form-control ',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("Penjamin", CHtml::activeId($modPasien, 'penjamin_id'), array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($modPasien, 'penjamin_id', CHtml::listData($modPasien->getPenjaminItems($modPasien->carabayar_id), 'penjamin_id', 'penjamin_nama'), array(
                                'empty' => '-- Pilih --',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetNoKartu', array('encode' => false, 'namaModel' => get_class($modPasien))),
                                    'success' => 'function(data){$("#AsuransipasienM_nopeserta").html(data); }',
                                ),
                                //                            'onchange' => 'setKarcis(); setNamaAsuransiDariPenjamin(this); setAsuransiBadak(this.value); cekValiditasPenjamin(this.value);',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 form-control'
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label("No. Peserta BPJS/Asuransi ", CHtml::activeId($modPenjamin, 'nopeserta'), array('class' => 'control-label')) ?>
                        <div class="controls">
                         <?php echo $form->textField($modPenjamin, 'nopeserta', array('onkeyup' => "return $(this).focusNextInputField(event)", 'placeholder' => 'No. Peserta BPJS', 'class' => 'span3 numbers-only')); ?>

                        </div>
                    </div>

                </div>

                <!--<div class="col-sm-6">
                             <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'propinsi_id', array('class' => 'control-label')) ?>
                                     <div class="controls">
                <?php $modPasien->propinsi_id = (!empty($modPasien->propinsi_id)) ? $modPasien->propinsi_id : Yii::app()->user->getState('propinsi_id'); ?>
                <?php
                echo $form->dropDownList($modPasien, 'propinsi_id', CHtml::listData($modPasien->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('GetKabupaten', array('encode' => false, 'namaModel' => 'PPPasienM')),
                        'update' => '#PPPasienM_kabupaten_id',
                    ),
                    'onchange' => "clearKecamatan();clearKelurahan();",
                ));
                ?>
                <?php echo $form->error($modPasien, 'propinsi_id'); ?>
                                     </div>
                             </div>
 
                             <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kabupaten_id', array('class' => 'control-label')) ?>
                                     <div class="controls">
                <?php $modPasien->kabupaten_id = (!empty($modPasien->kabupaten_id)) ? $modPasien->kabupaten_id : Yii::app()->user->getState('kabupaten_id'); ?>
                <?php
                echo $form->dropDownList($modPasien, 'kabupaten_id', CHtml::listData($modPasien->getKabupatenItems($modPasien->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('GetKecamatan', array('encode' => false, 'namaModel' => 'PPPasienM')),
                        'update' => '#PPPasienM_kecamatan_id'
                    ),
                    'onchange' => "clearKelurahan();",
                ));
                ?>
                <?php echo $form->error($modPasien, 'kabupaten_id'); ?>
                                     </div>
                             </div>
 
                             <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kecamatan_id', array('class' => 'control-label')) ?>
                                     <div class="controls">
                <?php $modPasien->kecamatan_id = (!empty($modPasien->kecamatan_id)) ? $modPasien->propinsi_id : Yii::app()->user->getState('kecamatan_id'); ?>
                <?php
                echo $form->dropDownList($modPasien, 'kecamatan_id', CHtml::listData($modPasien->getKecamatanItems($modPasien->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('GetKelurahan', array('encode' => false, 'namaModel' => 'PPPasienM')),
                        'update' => '#PPPasienM_kelurahan_id'
                    )
                ));
                ?>
                <?php echo $form->error($modPasien, 'kecamatan_id'); ?>
                                     </div>
                             </div>
 
                              <div class="control-group">
                <?php echo $form->labelEx($modPasien, 'kelurahan_id', array('class' => 'control-label')) ?>
                                                                                 <div class="controls">
                <?php $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id)) ? $modPasien->propinsi_id : Yii::app()->user->getState('kelurahan_id'); ?>
                <?php echo $form->dropDownList($modPasien, 'kelurahan_id', CHtml::listData($modPasien->getKelurahanItems($modPasien->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                ?>
                <?php echo $form->error($modPasien, 'kelurahan_id'); ?>
         </div>
                                                                 </div>
                <?php echo $form->dropDownListRow($modPasien, 'agama', LookupM::getItems('agama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($modPasien, 'pendidikan_id', CHtml::listData($modPasien->getPendidikanItems(), 'pendidikan_id', 'pendidikan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($modPasien, 'pekerjaan_id', CHtml::listData($modPasien->getPekerjaanItems(), 'pekerjaan_id', 'pekerjaan_nama'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->dropDownListRow($modPasien, 'warga_negara', LookupM::getItems('warganegara'), array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
 
                     </div>-->
            </div>
        </div>
    </div>
</div>