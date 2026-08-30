<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    <i></i> Check List Kelengkapan Pre Operasi
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <label class="control-label">Tanggal</label>
                            <div class="controls">
                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modCeklist,
                                        'attribute' => 'tanggal',
                                        'value' => null,
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            // 'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span4 htpd',
                                        ),
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Petugas Kamar Operasi<span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                    echo $form->hiddenField($modCeklist, 'petugasok_id',['class'=>'petugasok_id required']);
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modCeklist,
                                        'attribute' => 'petugasok_nama',
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
                                                $(".petugasok_id").val(ui.item.petugasok_id);
                                                $(".petugasok_nama").val(ui.item.namaLengkap);                                
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'class'=>'span4 petugasok_nama',
                                            'disabled' => $jenis == 'lihat',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPetugasOK'),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Petugas Rawat Inap<span class="required">*</span></label>
                            <div class="controls">
                                <?php
                                    echo $form->hiddenField($modCeklist, 'pertugasrawatinap_id',['class'=>'pertugasrawatinap_id required']);
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modCeklist,
                                        'attribute' => 'pertugasrawatinap_nama',
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
                                                $(".pertugasrawatinap_id").val(ui.item.pertugasrawatinap_id);
                                                $(".pertugasrawatinap_nama").val(ui.item.namaLengkap);                                
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'class'=>'span4 pertugasrawatinap_nama',
                                            'disabled' => $jenis == 'lihat',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPetugasRI'),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <table class="items table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tindakan</th>
                                <th>Ya</th>
                                <th>Tidak</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <th>Memberi penjelasan pada pasien</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_penjelasanpadapasien', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_penjelasanpadapasien_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_penjelasanpadapasien', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_penjelasanpadapasien_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_penjelasanpadapasien', array('disabled' => false, 'class' => 'span4 ket_penjelasanpadapasien', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>Surat persetujuan operasi dan pembiusan</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_suratpersetujuanoperasi', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_suratpersetujuanoperasi_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_suratpersetujuanoperasi', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_suratpersetujuanoperasi_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_suratpersetujuanoeprasi', array('disabled' => false, 'class' => 'span4 ket_suratpersetujuanoeprasi', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>3</th>
                                <th>Surat persetujuan biaya</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_suratpersetujuanbiaya', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_suratpersetujuanbiaya_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_suratpersetujuanbiaya', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_suratpersetujuanbiaya_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_suratpersetujuanbiaya', array('disabled' => false, 'class' => 'span4 ket_suratpersetujuanbiaya', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>4</th>
                                <th>Lembar hasil pemeriksaan :</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>- Laboratorium</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_hasillaboratorium', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_hasillaboratorium_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_hasillaboratorium', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_hasillaboratorium_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_hasillaboratorium', array('disabled' => false, 'class' => 'span4 ket_hasillaboratorium', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>- ECG</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_hasilecg', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_hasilecg_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_hasilecg', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_hasilecg_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_hasilecg', array('disabled' => false, 'class' => 'span4 ket_hasilecg', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>- Rontgent</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_hasilrontgen', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_hasilrontgen_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_hasilrontgen', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_hasilrontgen_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_hasilrontgen', array('disabled' => false, 'class' => 'span4 ket_hasilrontgen', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>5</th>
                                <th>Alat bantu ( gigi palsu - mata palsu - kaca mata - kaki palsu - tangan palsu ) sudah di lepas</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_alatbantu', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_alatbantu_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_alatbantu', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_alatbantu_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_alatbantu', array('disabled' => false, 'class' => 'span4 ket_alatbantu', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>6</th>
                                <th>Perhiasan sudah dilepas</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_perhiasandilepas', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_perhiasandilepas_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_perhiasandilepas', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_perhiasandilepas_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_perhiasandilepas', array('disabled' => false, 'class' => 'span4 ket_perhiasandilepas', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>7</th>
                                <th>Mandi / Kebersihan badan</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_kebersihanbadan', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_kebersihanbadan_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_kebersihanbadan', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_kebersihanbadan_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_kebersihanbadan', array('disabled' => false, 'class' => 'span4 ket_kebersihanbadan', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>8</th>
                                <th>Puasa</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_puasa', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_puasa_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_puasa', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_puasa_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_puasa', array('disabled' => false, 'class' => 'span4 ket_puasa', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>9</th>
                                <th>Cukur daerah sekitar operasi</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_cukurdaerahoperasi', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_cukurdaerahoperasi_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_cukurdaerahoperasi', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_cukurdaerahoperasi_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_cukurdaerahoeprasi', array('disabled' => false, 'class' => 'span4 ket_cukurdaerahoeprasi', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>10</th>
                                <th>Beri savion daerah sekitar operasi</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_berisavlondaerahoperasi', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_berisavlondaerahoperasi_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_berisavlondaerahoperasi', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_berisavlondaerahoperasi_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_berisavlondaerahoperasi', array('disabled' => false, 'class' => 'span4 ket_berisavlondaerahoperasi', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>11</th>
                                <th>Lavement 1</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lavement1', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_lavement1_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lavement1', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_lavement1_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ekt_lavement1', array('disabled' => false, 'class' => 'span4 ekt_lavement1', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>12</th>
                                <th>Lavement 2</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lavement2', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_lavement2_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lavement2', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_lavement2_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_lavement2', array('disabled' => false, 'class' => 'span4 ket_lavement2', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>13</th>
                                <th>Terpasang cairan</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_terpasangcairan', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_terpasangcairan_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_terpasangcairan', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_terpasangcairan_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_terpasangcarian', array('disabled' => false, 'class' => 'span4 ket_terpasangcarian', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>14</th>
                                <th>Terpasang maagslag</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_terpasangmaagslag', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_terpasangmaagslag_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_terpasangmaagslag', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_terpasangmaagslag_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_terpasangmaagslag', array('disabled' => false, 'class' => 'span4 ket_terpasangmaagslag', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>15</th>
                                <th>Terpasang kateter</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_terpasangkateter', ['onclick' => '', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_terpasangkateter_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_terpasangkateter', ['onclick' => '', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_terpasangkateter_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_terpasangkateter', array('disabled' => false, 'class' => 'span4 ket_terpasangkateter', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>16</th>
                                <th>Tanda - Tanda Vital</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Tensi <?php echo $form->textField($modCeklist, 'tensi_sistolik', array('disabled' => true, 'class' => 'span2 tensi_sistolik', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?> / <?php echo $form->textField($modCeklist, 'tensi_diastolik', array('disabled' => true, 'class' => 'span2 tensi_diastolik', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?> mmHg</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_tensi_sistolik', ['onclick' => 'cek18()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_tensi_sistolik_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_tensi_sistolik', ['onclick' => 'cek18()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_tensi_sistolik_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_tensi_sistolik', array('disabled' => false, 'class' => 'span4 ket_tensi_sistolik', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Nadi <?php echo $form->textField($modCeklist, 'nadi', array('disabled' => true, 'class' => 'span4 nadi', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?> x/mnt</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_nadi', ['onclick' => 'cek19()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_nadi_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_nadi', ['onclick' => 'cek19()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_nadi_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_nadi', array('disabled' => false, 'class' => 'span4 ket_nadi', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Suhu <?php echo $form->textField($modCeklist, 'suhu', array('disabled' => true, 'class' => 'span4 suhu', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?> &#176;C</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_suhu', ['onclick' => 'cek20()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_suhu_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_suhu', ['onclick' => 'cek20()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_suhu_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_suhu', array('disabled' => false, 'class' => 'span4 ket_suhu', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>RR <?php echo $form->textField($modCeklist, 'rr', array('disabled' => true, 'class' => 'span4 rr', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?> x/mnt</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_rr', ['onclick' => 'cek21()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_rr_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_rr', ['onclick' => 'cek21()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_rr_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_rr', array('disabled' => false, 'class' => 'span4 ket_rr', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>BB <?php echo $form->textField($modCeklist, 'bb', array('disabled' => true, 'class' => 'span4 bb', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?> kg</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_bb', ['onclick' => 'cek22()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_bb_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_bb', ['onclick' => 'cek22()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_bb_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_bb', array('disabled' => false, 'class' => 'span4 ket_bb', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>TB <?php echo $form->textField($modCeklist, 'tb', array('disabled' => true, 'class' => 'span4 tb', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?> cm</th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_tb', ['onclick' => 'cek23()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_tb_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_tb', ['onclick' => 'cek23()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_tb_tidak']) ?></th>
                                <th><?php echo $form->textField($modCeklist, 'ket_tb', array('disabled' => false, 'class' => 'span4 ket_tb', 'onkeypress' => 'return $(this).focusNextInputField(event);')); ?></th>
                            </tr>
                            <tr>
                                <th>17</th>
                                <th>Lain - lain</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Terapi <br> <?php echo $form->textArea($modCeklist, 'lainlainterapi', array('disabled' => true, 'class' => 'span4 lainlainterapi', 'onkeypress' => 'return $(this).focusNextInputField(event);', 'rows'=>4)); ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lainlainterapi', ['onclick' => 'cek24()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_lainlainterapi_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lainlainterapi', ['onclick' => 'cek24()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_lainlainterapi_tidak']) ?></th>
                                <th><?php echo $form->textArea($modCeklist, 'ket_lainlainterapi', array('disabled' => false, 'class' => 'span4 ket_lainlainterapi', 'onkeypress' => 'return $(this).focusNextInputField(event);', 'rows'=>5)); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Premedikasi <br> <?php echo $form->textArea($modCeklist, 'lainlainpremedikasi', array('disabled' => true, 'class' => 'span4 lainlainpremedikasi', 'onkeypress' => 'return $(this).focusNextInputField(event);', 'rows'=>4)); ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lainlainpremedikasi', ['onclick' => 'cek25()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_lainlainpremedikasi_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lainlainpremedikasi', ['onclick' => 'cek25()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_lainlainpremedikasi_tidak']) ?></th>
                                <th><?php echo $form->textArea($modCeklist, 'ket_lainlainpremedikasi', array('disabled' => false, 'class' => 'span4 ket_lainlainpremedikasi', 'onkeypress' => 'return $(this).focusNextInputField(event);', 'rows'=>5)); ?></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Riwayat Pengobatan <br> <?php echo $form->textArea($modCeklist, 'lainlainriwayatpengobatan', array('disabled' => true, 'class' => 'span4 lainlainriwayatpengobatan', 'onkeypress' => 'return $(this).focusNextInputField(event);', 'rows'=>4)); ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lainlainriwayatpengobatan', ['onclick' => 'cek26()', 'value' => 1, 'uncheckValue' => null, 'id' => 'is_lainlainriwayatpengobatan_ya']) ?></th>
                                <th><?php echo $form->radioButton($modCeklist, 'is_lainlainriwayatpengobatan', ['onclick' => 'cek26()', 'value' => 0, 'uncheckValue' => null, 'id' => 'is_lainlainriwayatpengobatan_tidak']) ?></th>
                                <th><?php echo $form->textArea($modCeklist, 'ket_lainlainriwayatpengobatan', array('disabled' => false, 'class' => 'span4 ket_lainlainriwayatpengobatan', 'onkeypress' => 'return $(this).focusNextInputField(event);', 'rows'=>5)); ?></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function cek1()
    {
        if ($('#is_penjelasanpadapasien_ya').is(":checked")) {
            $('.ket_penjelasanpadapasien').attr('disabled', false);
        } else {
            $('.ket_penjelasanpadapasien').attr('disabled', true);
            $('.ket_penjelasanpadapasien').val('');
        }
    }
    function cek2()
    {
        if ($('#is_suratpersetujuanoperasi_ya').is(":checked")) {
            $('.ket_suratpersetujuanoeprasi').attr('disabled', false);
        } else {
            $('.ket_suratpersetujuanoeprasi').attr('disabled', true);
            $('.ket_suratpersetujuanoeprasi').val('');
        }
    }
    function cek3()
    {
        if ($('#is_suratpersetujuanbiaya_ya').is(":checked")) {
            $('.ket_suratpersetujuanbiaya').attr('disabled', false);
        } else {
            $('.ket_suratpersetujuanbiaya').attr('disabled', true);
            $('.ket_suratpersetujuanbiaya').val('');
        }
    }
    function cek4()
    {
        if ($('#is_hasillaboratorium_ya').is(":checked")) {
            $('.ket_hasillaboratorium').attr('disabled', false);
        } else {
            $('.ket_hasillaboratorium').attr('disabled', true);
            $('.ket_hasillaboratorium').val('');
        }
    }
    function cek5()
    {
        if ($('#is_hasilecg_ya').is(":checked")) {
            $('.ket_hasilecg').attr('disabled', false);
        } else {
            $('.ket_hasilecg').attr('disabled', true);
            $('.ket_hasilecg').val('');
        }
    }
    function cek6()
    {
        if ($('#is_hasilrontgen_ya').is(":checked")) {
            $('.ket_hasilrontgen').attr('disabled', false);
        } else {
            $('.ket_hasilrontgen').attr('disabled', true);
            $('.ket_hasilrontgen').val('');
        }
    }
    function cek7()
    {
        if ($('#is_alatbantu_ya').is(":checked")) {
            $('.ket_alatbantu').attr('disabled', false);
        } else {
            $('.ket_alatbantu').attr('disabled', true);
            $('.ket_alatbantu').val('');
        }
    }
    function cek8()
    {
        if ($('#is_perhiasandilepas_ya').is(":checked")) {
            $('.ket_perhiasandilepas').attr('disabled', false);
        } else {
            $('.ket_perhiasandilepas').attr('disabled', true);
            $('.ket_perhiasandilepas').val('');
        }
    }
    function cek9()
    {
        if ($('#is_kebersihanbadan_ya').is(":checked")) {
            $('.ket_kebersihanbadan').attr('disabled', false);
        } else {
            $('.ket_kebersihanbadan').attr('disabled', true);
            $('.ket_kebersihanbadan').val('');
        }
    }
    function cek10()
    {
        if ($('#is_puasa_ya').is(":checked")) {
            $('.ket_puasa').attr('disabled', false);
        } else {
            $('.ket_puasa').attr('disabled', true);
            $('.ket_puasa').val('');
        }
    }
    function cek11()
    {
        if ($('#is_cukurdaerahoperasi_ya').is(":checked")) {
            $('.ket_cukurdaerahoeprasi').attr('disabled', false);
        } else {
            $('.ket_cukurdaerahoeprasi').attr('disabled', true);
            $('.ket_cukurdaerahoeprasi').val('');
        }
    }
    function cek12()
    {
        if ($('#is_berisavlondaerahoperasi_ya').is(":checked")) {
            $('.ket_berisavlondaerahoperasi').attr('disabled', false);
        } else {
            $('.ket_berisavlondaerahoperasi').attr('disabled', true);
            $('.ket_berisavlondaerahoperasi').val('');
        }
    }
    function cek13()
    {
        if ($('#is_lavement1_ya').is(":checked")) {
            $('.ekt_lavement1').attr('disabled', false);
        } else {
            $('.ekt_lavement1').attr('disabled', true);
            $('.ekt_lavement1').val('');
        }
    }
    function cek14()
    {
        if ($('#is_lavement2_ya').is(":checked")) {
            $('.ket_lavement2').attr('disabled', false);
        } else {
            $('.ket_lavement2').attr('disabled', true);
            $('.ket_lavement2').val('');
        }
    }
    function cek15()
    {
        if ($('#is_terpasangcairan_ya').is(":checked")) {
            $('.ket_terpasangcarian').attr('disabled', false);
        } else {
            $('.ket_terpasangcarian').attr('disabled', true);
            $('.ket_terpasangcarian').val('');
        }
    }
    function cek16()
    {
        if ($('#is_terpasangmaagslag_ya').is(":checked")) {
            $('.ket_terpasangmaagslag').attr('disabled', false);
        } else {
            $('.ket_terpasangmaagslag').attr('disabled', true);
            $('.ket_terpasangmaagslag').val('');
        }
    }
    function cek17()
    {
        if ($('#is_terpasangkateter_ya').is(":checked")) {
            $('.ket_terpasangkateter').attr('disabled', false);
        } else {
            $('.ket_terpasangkateter').attr('disabled', true);
            $('.ket_terpasangkateter').val('');
        }
    }
    function cek18()
    {
        if ($('#is_tensi_sistolik_ya').is(":checked")) {
            $('.tensi_sistolik').attr('disabled', false);
            $('.tensi_diastolik').attr('disabled', false);
        } else {
            $('.tensi_sistolik').attr('disabled', true);
            $('.tensi_sistolik').val('');
            $('.tensi_diastolik').attr('disabled', true);
            $('.tensi_diastolik').val('');
        }
    }
    function cek19()
    {
        if ($('#is_nadi_ya').is(":checked")) {
            $('.nadi').attr('disabled', false);
        } else {
            $('.nadi').attr('disabled', true);
            $('.nadi').val('');
        }
    }
    function cek20()
    {
        if ($('#is_suhu_ya').is(":checked")) {
            $('.suhu').attr('disabled', false);
        } else {
            $('.suhu').attr('disabled', true);
            $('.suhu').val('');
        }
    }
    function cek21()
    {
        if ($('#is_rr_ya').is(":checked")) {
            $('.rr').attr('disabled', false);
        } else {
            $('.rr').attr('disabled', true);
            $('.rr').val('');
        }
    }
    function cek22()
    {
        if ($('#is_bb_ya').is(":checked")) {
            $('.bb').attr('disabled', false);
        } else {
            $('.bb').attr('disabled', true);
            $('.bb').val('');
        }
    }
    function cek23()
    {
        if ($('#is_tb_ya').is(":checked")) {
            $('.tb').attr('disabled', false);
        } else {
            $('.tb').attr('disabled', true);
            $('.tb').val('');
        }
    }
    function cek24()
    {
        if ($('#is_lainlainterapi_ya').is(":checked")) {
            $('.lainlainterapi').attr('disabled', false);
        } else {
            $('.lainlainterapi').attr('disabled', true);
            $('.lainlainterapi').val('');
        }
    }
    function cek25()
    {
        if ($('#is_lainlainpremedikasi_ya').is(":checked")) {
            $('.lainlainpremedikasi').attr('disabled', false);
        } else {
            $('.lainlainpremedikasi').attr('disabled', true);
            $('.lainlainpremedikasi').val('');
        }
    }
    function cek26()
    {
        if ($('#is_lainlainriwayatpengobatan_ya').is(":checked")) {
            $('.lainlainriwayatpengobatan').attr('disabled', false);
        } else {
            $('.lainlainriwayatpengobatan').attr('disabled', true);
            $('.lainlainriwayatpengobatan').val('');
        }
    }

     $(document).ready(function () {
        // cek1();
        // cek2();
        // cek3();
        // cek4();
        // cek5();
        // cek6();
        // cek7();
        // cek8();
        // cek9();
        // cek10();
        // cek11();
        // cek12();
        // cek13();
        // cek14();
        // cek15();
        // cek16();
        // cek17();
        cek18();
        cek19();
        cek20();
        cek21();
        cek22();
        cek23();
        cek24();
        cek25();
        cek26();
        <?php if(isset($_GET['jenis'])){ ?>
            <?php if($_GET['jenis'] == 'lihat'){ ?>
            $("input, select, textarea").attr("disabled",true); 
            <?php } ?>
        <?php } ?>
    });
</script>