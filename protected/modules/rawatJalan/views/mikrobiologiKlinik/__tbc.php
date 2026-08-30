<style>
.tbl-visual {
    width: 100%l
}

.tbl-visual tr,
.tbl-visual td {
    border: 1px solid black;
}
</style>
<div class="panel-heading">
    <div class="panel-title">Rujukan</div>
</div>
<div class="panel-body">
    <!--- MULAI RUJUKAN --->
    <label>
        <p style="font-weight: bold"> Data Dokter Pengirim </p>
    </label>
    <div class="control-group">
        <?php echo CHtml::label("Nama DPJP <span class='required'>*</span> ", '', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modKirimKeUnitLain, 'pegawai_id', array('class' => 'span3 dokter_id2')) ?>
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
                'class' => 'span3 dokter_nama2',
            ),
            'tombolDialog' => array('idDialog' => 'dialogDokter2'),
        ));
        ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nama PPDS</label>
        <div class="controls">
            <?php echo $form->hiddenField($modKirimKeUnitLain, 'ppds_id', array('class' => 'span3 ppds_id2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
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
                                    $(".ppds_id2").val( ui.item.ppds_id);
                                    setPpds(ui.item.ppds_id);
                                    return false;
                        }',
                    ),
                    'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 ppds_nama2', 'placeholder' => 'Ketikkan Nama PPDS  '),
                    'tombolDialog' => array('idDialog' => 'dialogPpds2', 'idTombol' => 'tombolPpds'),
                ));
            ?>
        </div>
    </div>

    <label>
        <p style="font-weight: bold"> Informasi Contoh Uji </p>
    </label>
    <div class="control-group">
        <label class="control-label">No. Identitas Pasien</label>
        <div class="controls">
            <?php echo $form->textField($modPenunjang2, 'no_sediaan', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <?php echo $form->radioButtonListInlineRow($modPenunjang2, 'jenis_pasientbc', ['TBC SO' => 'TBC SO', 'TBC RO' => 'TBC RO', 'Anak' => 'Anak', 'HIV' => 'HIV', 'DM' => 'DM'], array('class' => 'reqPasien', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => '')); ?>
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
        <label class="control-label">Tanggal Pengambilan Contoh Uji</label>
        <div class="controls">
            <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modKirimKeUnitLain,
                            'attribute' => 'waktuambilspesimen',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'dtPicker1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'width' => '140px;'
                            ),
                        ));
                        ?>
            <?php echo $form->error($modKirimKeUnitLain, 'waktuambilspesimen'); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal Pengiriman Contoh Uji</label>
        <div class="controls">
            <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modKirimKeUnitLain,
                            'attribute' => 'tglpengirimanspesimen',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => 'dtPicker1', 'onkeypress' => "return $(this).focusNextInputField(event)", 'width' => '140px;'
                            ),
                        ));
                        ?>
            <?php echo $form->error($modKirimKeUnitLain, 'tglpengirimanspesimen'); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Contoh Uji <span class="required">*</span></label>
        <div class="controls">
            <?php echo CHtml::hiddenField('sample_tbc', '', array('class' => 'span2 integer', 'style' => 'text-align:right;', 'disabled' => 'disabled')); ?>

            <?php echo CHtml::checkbox('RJPermintaanPenunjangT[samplelab_id_tbc]', false, array('value' => 274, 'onclick' => 'setJenis(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'jenispas jenispas_tbc required')); ?>
            Dahak
            <?php echo CHtml::checkbox('RJPermintaanPenunjangT[samplelab_id_tbc]', false, array('value' => 269, 'onclick' => 'setJenis(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'jenispas jenispas_tbc required')); ?>
            Lainnya&emsp;
            <?php echo $form->textField($modPenunjang2, 'samplelablain', array('class' => 'span3 samplelain', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>

        </div>
    </div>
    <center>
        <label>
            <span style="font-weight: bold; text-align: center;">Secara Visual Dahak Tampak (Checklist pada
                kotak)</span>
        </label>
    </center>
    <table class="tbl-visual" style="width: 700px;" ;>
        <tr>
            <td style="">
                <b><br><br>&emsp;&emsp;&emsp;&emsp;Sewaktu/Pagi<br><br>&emsp;&emsp;&emsp;&emsp;Sewaktu/Pagi</br>
            </td>
            <td style=""><b>&emsp;&emsp;&emsp;&emsp;Nanah Lendir<br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <?php echo $form->checkBox($modPenunjang2, 'is_visual_lendirnanah1', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                    <br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <?php echo $form->checkBox($modPenunjang2, 'is_visual_lendirnanah2', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                    </br></td>
            <td style=""><b>&emsp;&emsp;&emsp;&emsp;Bercak Darah<br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <?php echo $form->checkBox($modPenunjang2, 'is_visual_bercakdarah1', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                    <br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <?php echo $form->checkBox($modPenunjang2, 'is_visual_bercakdarah2', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                    </br></td>
            </td>
            <td style=""><b>&emsp;&emsp;&emsp;&emsp;&emsp;Air Liur<br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <?php echo $form->checkBox($modPenunjang2, 'is_visual_airliur1', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                    <br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                    <?php echo $form->checkBox($modPenunjang2, 'is_visual_airliur2', array('onkeypress' => "return $(this).focusNextInputField(event)", 'onclick' => '', 'style' => 'text-align: center;')); ?>
                    </br></td>
        </tr>
    </table>
    <div class="control-group">
        <label class="control-label">Lokasi Anatomi</label>
        <div class="controls">
            <table style="line-height: 35px;">
                <tr>
                    <td><?php echo CHtml::checkbox('RJPermintaanPenunjangT[lokasianatomi]', false, array('value' => 'Paru', 'onclick' => 'setLokasi(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'lokasi-tbc')); ?>Paru
                    </td>
                </tr>
                <tr>
                    <td><?php echo CHtml::checkbox('RJPermintaanPenunjangT[lokasianatomi]', false, array('value' => 'Ekstra Paru', 'onclick' => 'setLokasi(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'lokasi-tbc')); ?>Ekstra
                        Paru&emsp;</td>
                </tr>
                <tr>
                    <td>
                        <div class="control-group">
                            <div class="controls">
                                Lokasi:&emsp;&emsp;
                                <?php echo $form->textField($modPenunjang2, 'lokasianatomi_lainnya', array('class' => 'span3 lokasi-tbc-lain', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Alasan Pemeriksaan</label>
        <div class="controls">
            <table style="line-height: 35px;">
                <tr>
                    <td><?php echo CHtml::checkbox('RJPermintaanPenunjangT[alasanpemeriksaan]', false, array('value' => 'Diagnosis TBC', 'onclick' => 'setAlasan(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'alasan-tbc')); ?>Diagnosis
                        TBC</td>
                </tr>
                <tr>
                    <td><?php echo CHtml::checkbox('RJPermintaanPenunjangT[alasanpemeriksaan]', false, array('value' => 'Diagnosis Baseline TBC', 'onclick' => 'setAlasan(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'alasan-tbc')); ?>Diagnosis
                        Baseline TBC&emsp;</td>
                </tr>
                <tr>
                    <td><?php echo CHtml::checkbox('RJPermintaanPenunjangT[alasanpemeriksaan]', false, array('value' => 'Akhir Pengobatan', 'onclick' => 'setAlasan(this);', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'alasan-tbc')); ?>Akhir
                        Pengobatan&emsp;</td>
                </tr>
            </table>

        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Pemantauan Kemajuan Pengobatan Bulan Ke : </label>
        <div class="controls">
            <?php echo $form->textField($modPenunjang2, 'pemantauan_kemajuan', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Pemeriksaan Ulang Bulan Ke : </label>
        <div class="controls">
            <?php echo $form->textField($modPenunjang2, 'pemeriksaan_ulang', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Pemeriksaan Setelah Selesai Pengobatan Bulan Ke : </label>
        <div class="controls">
            <?php echo $form->textField($modPenunjang2, 'pemeriksaan_selesai', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">No. Reg. TBC/TBC RO Fasyankes</label>
        <div class="controls">
            <?php echo $form->textField($modPenunjang2, 'no_reg_fasyankes', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">No. Reg. TBC/TBC RO Kab./Kota</label>
        <div class="controls">
            <?php echo $form->textField($modPenunjang2, 'no_reg_kabkota', array('class' => 'span3', 'readonly' => false, 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>

    <div class='control-group'>
        <?php echo CHtml::label("Cyto", CHtml::activeId($modKirimKeUnitLain, 'is_cito'), array('class' => 'control-label required')) ?>
        <div class='controls'>
            <?php echo CHtml::activeDropDownList($modKirimKeUnitLain, 'is_cito', array('0'=>'Biasa','1'=>'Cyto'), array('onchange'=>'','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span3')); ?>
        </div>
    </div>

</div>

<script>
function setJenis(obj) {
    $('.jenispas').prop('checked', false);
    $(obj).prop('checked', true);

    var val = "vv" + $(obj).val();

    $('#sample_tbc').val($(obj).val());


    if (val === 'vv269') {
        console.log('nilainya 2' + val);
        $('.samplelain').removeAttr('readonly');
        $('.samplelain').addClass('required');

    } else {
        console.log('nilainya ' + val);
        $('.samplelain').attr('readonly', true);
        $('.samplelain').removeClass('required');
        $('.samplelain').val('');

    }
}

function setLokasi(obj) {
    $('.lokasi-tbc').prop('checked', false);
    $(obj).prop('checked', true);

    var val = $(obj).val();

    if (val === 'Ekstra Paru') {
        console.log('nilainya 2 --- ' + val);
        $('.lokasi-tbc-lain').removeAttr('readonly');
    } else {
        console.log('nilainya --- ' + val);
        $('.lokasi-tbc-lain').attr('readonly', true);
        $('.lokasi-tbc-lain').val('');

    }
}

function setAlasan(obj) {
    $('.alasan-tbc').prop('checked', false);
    $(obj).prop('checked', true);
}
</script>