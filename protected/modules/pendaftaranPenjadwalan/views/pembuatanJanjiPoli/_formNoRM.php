<div class="box" id='fieldsetNoRM'>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Rekam Medis</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <?php /*
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label("Cari No. Badge", 'nomorindukpegawai', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPegawai,
                                'attribute' => 'nomorindukpegawai',
                                'name' => 'nomorindukpegawai',
                                'value' => isset($modPegawai->nomorindukpegawai) ? $modPegawai->nomorindukpegawai : "",
                                // RND-9167						
                                'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutocompletePasienLama') . '",
								dataType: "json",
								data: {
									nomorindukpegawai: request.term,
								},
								success: function (data) {
									response(data);
								}
							})
						}',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
								$(this).val( "");
								return false;
							}',
                                    'select' => 'js:function( event, ui ) {
								$(this).val( ui.item.value);
                                                                
								return false;
							}',
                                ),
                                'tombolDialog' => array('idDialog' => 'dialogPasienBadak'),
                                'htmlOptions' => array(
                                    'placeholder' => 'No. Badge', 'rel' => 'tooltip', 'title' => 'No. Badge untuk mencari pasien',
                                    'onkeyup' => "return $(this).focusNextInputField(event)",
                                    //                                    'onblur'=>"if($(this).val()=='') setPasienBaru(); else setPasienLama('',this.value)",
                                    'class' => 'span3'
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                */ ?>
                <div class="col-sm-6">
                    <label class="control-label" style="width:150px">
                        <div class="label_no">
                            <i class="entypo-user"></i> <?php echo CHtml::checkBox('isPasienLama', $modPasien->isPasienLama, array('rel' => 'tooltip', 'title' => 'Pilih jika pasien lama', 'onclick' => 'pilihNoRm()', 'onkeyup' => "return $(this).focusNextInputField(event)")) ?> No. Rekam Medik
                        </div>
                    </label>
                    <div class="controls" id="controlNoRekamMedik">
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
                            'tombolDialog' => array('idDialog' => 'dialogPasien', 'idTombol' => 'tombolPasienDialog'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>