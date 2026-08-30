<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php
            echo CHtml::label($form->checkBox($model, 'pake_tanggal', array('onchange' => 'cekTanggalAdmisi()', 'id' => 'pake_tanggal')) . " Tanggal Admisi", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div id="tgl_admisi" class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal_admisi)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir_admisi)) ?>" hidden>
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal_admisi)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir_admisi)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal_admisi', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir_admisi', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="control-group">
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="col-sm-6">
        <?php
        $carabayar = CarabayarM::model()->findAll(array(
            'condition' => 'carabayar_aktif = true',
            'order' => 'carabayar_nourut',
        ));
        $penjamin = PenjaminpasienM::model()->findAll(array(
            'condition' => 'penjamin_aktif = true',
            'order' => 'penjamin_nama',
        ));
        $pegawai = PegawaiV::model()->findAllByAttributes(array(
            'pegawai_aktif' => true,
            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
        ), array(
            'order' => 'nama_pegawai',
            'condition' => 'jabatan_id <> ' . Params::JABATAN_ID_DOKTER_UMUM
        ));
        $kelaspelayanan = CHtml::listData(
            KelaspelayananM::model()->findAllByAttributes(array(
                'kelaspelayanan_aktif' => true,
            ), array(
                'order' => 'kelaspelayanan_nama'
            )),
            'kelaspelayanan_id',
            'kelaspelayanan_nama'
        );
        $pegawaiUmum = PegawaiV::model()->findAllByAttributes(array(
            'pegawai_aktif' => true,
            'kelompokpegawai_id' => Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
            'jabatan_id' => Params::JABATAN_ID_DOKTER_UMUM,
        ), array(
            'order' => 'nama_pegawai',
        ));
        foreach ($carabayar as $idx => $item) {
            $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                'carabayar_id' => $item->carabayar_id,
                'penjamin_aktif' => true,
            ));
            if (empty($penjamins)) unset($carabayar[$idx]);
        }
        echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --',
            'class' => 'span3',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); }',
            ),
        ));
        echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 50));
        ?>
        <div class="control-group">
            <?php
            echo CHtml::label("Kelas Tanggungan", '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kelastanggungan_id', $kelaspelayanan, array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
        <?php
        echo $form->dropDownListRow($model, 'dokterpenerima_id', CHtml::listData($pegawaiUmum, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3'));
        echo $form->dropDownListRow($model, 'pegawai_id', CHtml::listData($pegawai, 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3'));
        ?>
        <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', $kelaspelayanan, array(
            'empty' => '-- Pilih --',
            'class' => 'span3',
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('/actionDynamic/getKamarKelas', array('encode' => false, 'namaModel' => get_class($model))),
                'success' => 'function(data){$("#' . CHtml::activeId($model, "kamarruangan_id") . '").html(data); }',
            ),
        )); ?>
        <div class="control-group">
            <?php echo $form->label($model, 'Kamar Ruangan', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'kamarruangan_id', array(), array('empty' => '-- Pilih --', 'class' => 'span3')); ?>
            </div>
        </div>
    </div>
</div>
<?php /*
            <div class="control-group">
                <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                <label for="namaPasien" class="control-label">
                    <?php echo CHtml::activecheckBox($model, 'ceklis', array('uncheckValue'=>0,'rel'=>'tooltip', 'onClick'=>'cekTanggal()','data-original-title'=>'Cek untuk pencarian berdasarkan tanggal')); ?>
                    Tanggal Pasien Pulang 
              </label>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div>
            </div>
            <div class="control-group">
                <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                <div class="controls">
                    <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
//                                                    'minDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('class'=>'dtPicker3', 'disabled'=>true, 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                            ),
                    )); ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
        </td>
             * 
             */ ?>
<?php // echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>20)); 
?>
<script type="text/javascript">
    // document.getElementById('BKInformasikasirinappulangV_tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('BKInformasikasirinappulangV_tgl_akhir_date').setAttribute("style","display:none;");
    /*
    function cekTanggal(){
        var checklist = $('#BKInformasikasirinappulangV_ceklis');
        var pilih = checklist.attr('checked');
        // var tgl_masuk = $(document)
        if(pilih){
            document.getElementById('BKInformasikasirinappulangV_tgl_awal').disabled = false;
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir').disabled = false;
            document.getElementById('BKInformasikasirinappulangV_tgl_awal_date').setAttribute("style","display:block;");
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir_date').setAttribute("style","display:block;");
        }else{
            document.getElementById('BKInformasikasirinappulangV_tgl_awal').disabled = true;
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir').disabled = true;
            document.getElementById('BKInformasikasirinappulangV_tgl_awal_date').setAttribute("style","display:none;");
            document.getElementById('BKInformasikasirinappulangV_tgl_akhir_date').setAttribute("style","display:none;");
        }
    }
    */
    function cekTanggalAdmisi() {
        var r = $("#pake_tanggal").is(":checked");
        console.log("Checked", r);
        if (r) {
            $("#tgl_admisi").show();
        } else {
            $("#tgl_admisi").hide();
        }
    }
</script>