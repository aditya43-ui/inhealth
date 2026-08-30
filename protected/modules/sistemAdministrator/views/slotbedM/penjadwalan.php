<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Jadwal Bed</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <!--style>
				label.checkbox {
						display: inline-block;
						width: 150px;
				}

				.classInline td {
						border: none !important;
				}
                </style-->
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'penjadwalan-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'focus' => '#instalasi',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        )); ?>

        <?php
        echo '<div hidden>';

        $this->widget('MyDateTimePicker', array(
            'name' => 'jadwalSlot[txtStartDate]',
            'mode' => 'date',
            'value' => date('Y-m-d'),
            // additional javascript options for the date picker plugin
            'options' => array(
                'showAnim' => '',
                // 'beforeShow'=>'js:function(){customRange(this);}',
                //'dateFormat'=>"yy-mm-dd",
                //'changeFirstDay'=>false,
                'changeMonth' => true,
                'numberOfMonths' => 3,
            ),
            'htmlOptions' => array(
                'id' => 'txtStartDate',
                //'onclick'=>"return $(this).focusNextInputField(event);",
                'class' => 'dtPicker3',
                'readonly' => true,
            ),
        ));

        echo '</div>';

        $model->jadwal_awal = $model->jadwal_akhir = date('Y-m-d');
        $model2 = clone $model;

        $model2->jadwal_awal = MyFormatter::formatDateTimeForUser($model->jadwal_awal);
        $model2->jadwal_akhir = MyFormatter::formatDateTimeForUser($model->jadwal_akhir);
        ?>


        <div class="col-sm-6">


        <div class="control-group">
			<?php echo CHtml::label('Periode Jadwal', '', array('class'=>'control-label')); ?>
			<div class="controls">
				<div class="daterange daterange-inline input-inline" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->jadwal_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->jadwal_akhir)) ?>">
					<i class="entypo-calendar"></i>
					<span ><?php echo date('d M Y', strtotime($model->jadwal_awal)) ?> - <?php echo date('d M Y', strtotime($model->jadwal_akhir)) ?></span>
					<?php echo $form->hiddenField($model2,'jadwal_awal', array('class' => 'form-control start')) ?>
					<?php echo $form->hiddenField($model2,'jadwal_akhir', array('class' => 'form-control end')) ?>
				</div>
			</div>
		</div>

            <?php
            echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'), array(
                'class' => 'span3 inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'empty' => '-- Pilih Kelas Pelayanan --'
            ));
            ?>
            <div class="control-group">
                <?php echo CHtml::label('Instalasi', '', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php


                    $cr = new CDbCriteria();
                    $cr->addCondition("ispelayanan = true");
                    // $cr->addCondition("instalasirujukaninternal = false");
                    $cr->addCondition("instalasi_adakamar = false");
                    $cr->addCondition("isadministrasi = false");
                    // $cr->addInCondition("instalasi_id", array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_REHAB));
                    // $cr->compare('profilrs_id', Yii::app()->user->getState('profilrs_id'));
                    $cr->order = "instalasi_nama asc";

                    echo CHtml::dropDownList(
                        'jadwalSlot[instalasi]',
                        '',
                        CHtml::listData(InstalasiM::model()->findAll($cr), 'instalasi_id', 'instalasi_nama'),
                        array(
                            'empty' => '-- Pilih --',
                            'id' => 'instalasi',
                            'class' => 'required form-control span3',
                            'onchange' => '$("#inputForm").html("");',
                            /*
                                                  'ajax'=>array('url'=>$this->createUrl('ajaxListPoli'),
                                                                'type'=>'POST',
                                                                'update'=>'#inputPoli'),
												 *
												 */
                        )
                    );
                    ?>
                </div>
            </div>

        </div>
        <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'slotbed_noslot', array('placeholder' => 'Nama Bed', 'class' => 'span4',  'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        </div>
        <div class="clear"></div><br/>
        <div class="clear"></div>

        <div style="overflow-x: auto">
            <table class="table table-bordered table-condensed" id="tab_gen">

                <tbody>
                    <?php
                    $mingguan = array(
                        0 => "Minggu", // minggu
                        1 => "Senin",
                        2 => "Selasa",
                        3 => "Rabu",
                        4 => "Kamis",
                        5 => "Jumat",
                        6 => "Sabtu", // sabtu
                    );

                    foreach ($mingguan as $idx => $item) : ?>
                        <td class="col_tanggal_gen" width="200">
                            <div style="text-align: center" ; ?>
                                <?php echo CHtml::checkBox("gen[" . $idx . "][ceklis]", false, array(
                                    'onclick' => 'cekJadwalGenAktif($(this)); hitungJumlahPasienDariEstimasi();',
                                    'class' => 'col_ceklis_gen',
                                )) . " <strong>" . $item . "</strong>"; ?>
                            </div>
                            <div class="col_tanggal_gen_content">
                                <br />
                                <div class="col_content">
                                    <div class="input-append">
                                        <input style="float:left" type="text" name="gen[<?php echo $idx ?>][jadwal_mulai]" class="span2 genTimePicker jadwal_mulai" value="00:00:00" onchange="hitungJumlahPasienDariEstimasi()"><span class="add-on" style="margin-top:0px !important; height: 31px !important;"><i class="icon-time"></i></span>
                                    </div> s/d
                                    <div class="input-append">
                                        <input style="float:left" type="text" name="gen[<?php echo $idx ?>][jadwal_tutup]" class="span2 genTimePicker jadwal_tutup" value="00:00:00" onchange="hitungJumlahPasienDariEstimasi()"><span class="add-on" style="margin-top:0px !important; height: 31px !important;"><i class="icon-time"></i></span>
                                    </div>
                                    <hr />
                                    <div style="width: 200px;">
                                        <label style="display: inline-block; width: 140px;">Estimasi Pelayanan (menit)</label>
                                        <?php echo CHtml::textField("gen[" . $idx . "][estimasipelayanan]", '30', array('class' => 'span1 numbersOnly estimasipelayanan', 'style' => 'text-align: right;', 'onblur' => 'hitungJumlahPasienDariEstimasi();')); ?>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </td>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="form-action clear">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Buat Jadwal',array('{icon}'=>'<i class="icon-list-alt icon-white"></i>')),
                array('class'=>'btn btn-blue', 'type'=>'button', 'onClick'=>'generateInput();'));?>
        </div>

        <hr/>
        <div id='inputForm'></div>

        <div class="clear"></div>
        <hr/>



        <div class="form-action">
            <?php
            echo  CHtml::htmlButton(
                Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-primary', 'type' => 'submit')
            );
            ?>

            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('admin'),
                array(
                    'class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;',
                )
            );
            ?>
            <?php
            echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jadwal Bed', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success'));
            ?>
            <?php
            $content = $this->renderPartial($this->path_view_tips . '/tipsaddeditjadwal', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
<!-- </div> -->
<!-- </div> -->
<?php
$konfig = KonfigsystemK::model()->find();
?>

<script type="text/javascript">
    function hitungJumlahPasienDariEstimasi() {

        $(".col_tanggal_gen").each(function() {
            if ($(this).find(".col_ceklis_gen").is(":checked")) {
                var jam_awal = timeStringToFloat($(this).find(".jadwal_mulai").val());
                var jam_akhir = timeStringToFloat($(this).find(".jadwal_tutup").val());
                var estimasi = $(this).find(".estimasipelayanan").val();
                var selisih = 0;

                if (jam_akhir >= jam_awal) {
                    selisih = Math.ceil((jam_akhir - jam_awal) / estimasi) + 1;
                }

                $(this).find(".maximumantrian").val(selisih);
                $(this).find(".maximumbpjsantrian").val(selisih);
                $(this).find(".maksbuatjanji").val(selisih);
            }


        });

        $(".col_content").each(function() {
            if ($(this).find(".col_ceklis").is(":checked")) {
                var jam_awal = timeStringToFloat($(this).find(".jadwal_mulai").val());
                var jam_akhir = timeStringToFloat($(this).find(".jadwal_tutup").val());
                var estimasi = $(this).find(".estimasipelayanan").val();
                var selisih = 0;

                if (jam_akhir >= jam_awal) {
                    selisih = Math.ceil((jam_akhir - jam_awal) / estimasi) + 1;
                }

                $(this).find(".maximumantrian").val(selisih);
                $(this).find(".maximumbpjsantrian").val(selisih);
                $(this).find(".maksbuatjanji").val(selisih);
            }


        });
    }

    function timeStringToFloat(time) {
        var hoursMinutes = time.split(/[.:]/);
        var hours = parseInt(hoursMinutes[0], 10);
        var minutes = hoursMinutes[1] ? parseInt(hoursMinutes[1], 10) : 0;
        return (hours * 60) + minutes;
    }

    function cekJadwalGenAktif() {
        $("#tab_gen tbody td").each(function() {
            if ($(this).find(".col_ceklis_gen").is(":checked")) {
                $(this).find(".col_tanggal_gen_content :input").prop("disabled", false);
            } else {
                $(this).find(".col_tanggal_gen_content :input").prop("disabled", true);
            }
        });
    }

    function generateInput() {
        $.post('<?php echo $this->createUrl('ajaxGenerateInputForm') ?>', $('#penjadwalan-form').serialize(), function(data) {
            $('#inputForm').html(data.form);
            $("#inputForm .numbersOnly").maskMoney({
                "defaultZero": true,
                "allowZero": true,
                "decimal": ",",
                "thousands": "",
                "precision": 0,
                "symbol": null
            });
            $("#inputForm .timePickerTest").timepicker(jQuery.extend({
                showMonthAfterYear: false
            }, jQuery.datepicker.regional['id'], {
                'showAnim': '',
                'timeText': 'Waktu',
                'hourText': 'Jam',
                'minuteText': 'Menit',
                'secondText': 'Detik',
                'showSecond': true,
                'timeOnlyTitle': 'Pilih Waktu',
                'timeFormat': 'hh:mm:ss',
                'changeYear': true,
                'yearRange': '-80y:+20y'
            }));
            $(".col_ceklis").each(function() {
                cekJadwalAktif($(this));
            });
        }, 'json');
    }

    function clientValidationFunc(obj) {
        url = $("form").attr("action");
        error = "<div class='alert alert-block alert-error blockAlert'><p>Silakan perbaiki kesalahan input berikut:</p><ul></ul></div>";
        $.ajax({
            type: 'post',
            dataType: 'json',
            data: $("form").serialize(),
            success: function(result) {
                myAlert('Jadwal Berhasil dibuat !');
                if (result.error == 'no') {
                    $("form").submit();
                } else {
                    myAlert('Isikan data yg belum lengkap , dan Buat Jadwal terlebih dahulu !')
                    $("form").find(".error").removeClass("error");
                    $(".errorTable .blockAlert").remove();
                    $(".errorTable2 .blockAlert").remove();
                    for (var i in result.error) {
                        $('[name="' + i + '"]').addClass("error");
                        for (var x = 0; x < result.error[i].length; x++) {
                            if ($('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable .blockAlert").length < 1) {
                                $('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable").append(error);
                                $('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>' + result.error[i][x] + '</li>');
                            } else {
                                $('[name="' + i + '"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>' + result.error[i][x] + '</li>');
                            }
                        }
                    }
                    if (result.error2.length > 0) {
                        for (var i = 0; i < result.error2.length; i++) {
                            $('[name="' + result.error2[i] + '"]').addClass("error");
                            if ($('form table tr:first').find(".errorTable2 .blockAlert").length < 1) {
                                $('form table tr:first').find(".errorTable2").append(error);
                                $('form table tr:first').find(".errorTable2 ul").append('<li>' + result.error2[i] + '</li>');
                            } else {
                                $('form table tr:first').find(".errorTable2 ul").append('<li>' + result.error2[i] + '</li>');
                            }
                        }
                    }
                }
            }
        });
    }


    function clearTransaksi() {
        $('#txtStartDate').val('');
        $('#txtEndDate').val('');
        $('#instalasi').val('');
    }



    $(document).ready(function() {
        $(".genTimePicker").timepicker(jQuery.extend({
            showMonthAfterYear: false
        }, jQuery.datepicker.regional['id'], {
            'showAnim': '',
            'timeText': 'Waktu',
            'hourText': 'Jam',
            'minuteText': 'Menit',
            'secondText': 'Detik',
            'showSecond': true,
            'timeOnlyTitle': 'Pilih Waktu',
            'timeFormat': 'hh:mm:ss',
            'changeYear': true,
            'yearRange': '-80y:+20y'
        }));
        cekJadwalGenAktif();
    });
</script>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>