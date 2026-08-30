<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Slot Bed</b>
        </div>
    </div>
    <div class="panel-body">
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penjadwalan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#instalasi',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>

                <?php
				echo '<div hidden>';

                    $this->widget('MyDateTimePicker', array(
                        'name'=>'slotBed[txtStartDate]',
                        'mode'=>'date',
						'value' => date('Y-m-d'),
                        'options'=>array(
                            'showAnim'=>'',
                            'changeMonth'=>true,
                            'numberOfMonths'=>3,
                        ),
                        'htmlOptions'=>array(
                            'id'=>'txtStartDate',
                            'class'=>'dtPicker3',
                            'readonly'=>true,
                        ),
				));

				echo '</div>';

	$model->jadwal_awal = $model->jadwal_akhir = date('Y-m-d');
	$model2 = clone $model;

	$model2->jadwal_awal = MyFormatter::formatDateTimeForUser($model->jadwal_awal);
	$model2->jadwal_akhir = MyFormatter::formatDateTimeForUser($model->jadwal_akhir);
	?>

  <style>
            label.checkbox {
                display: inline-block;
                width: 150px;
            }

            .classInline td {
                border: none !important;
            }
        </style>

	<div class="col-sm-6">

		<div class="control-group">
			<?php echo CHtml::label('Instalasi', '', array('class'=>'control-label')); ?>
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

                    echo CHtml::dropDownList('slotBed[instalasi]', '', CHtml::listData(InstalasiM::model()->findAll($cr), 'instalasi_id', 'instalasi_nama'),
                                            array('empty'=>'-- Pilih --',
                                                  'id'=>'instalasi',
                                                  'class' => 'required form-control',
                                                  'onchange'=>'$("#inputForm").html(""); getRuangan();',
												/*
                                                  'ajax'=>array('url'=>$this->createUrl('ajaxListPoli'),
                                                                'type'=>'POST',
                                                                'update'=>'#inputPoli'),
												 *
												 */
												));
                ?>
			</div>
		</div>
        <div class="control-group">
			<?php echo CHtml::label('Ruangan', '', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo CHtml::dropDownList('slotBed[poliklinik]', null, array(), array(
					'empty'=>'-- Pilih --', 'class'=>'span3', 'id'=>'inputPoli',
                    'onchange'=>'getListDokter()',
				)); ?>
			</div>
		</div>
        <div class="control-group">
            <?php echo CHtml::label('Dokter', '', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::dropDownList('slotBed[pegawai]', null, array(), array(
                    'empty'=>'-- Pilih --', 'id'=>'inputPegawai', 'class'=>'span3'
                )); ?>
            </div>
        </div>

	</div>
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

            foreach ($mingguan as $idx => $item): ?>
            <td class="col_tanggal_gen" width="200">
                <div style="text-align: center"; ?>
                    <?php echo CHtml::checkBox("gen[".$idx."][ceklis]", false, array(
                        'onclick'=>'cekJadwalGenAktif($(this)); hitungJumlahPasienDariEstimasi();',
                        'class'=>'col_ceklis_gen',
                    ))." <strong>".$item."</strong>"; ?>
                </div>
                <div class="col_tanggal_gen_content">
                    <br/>
                    <div class="col_content">
                        <div class="input-append">
                            <input style="float:left" type="text" name="gen[<?php echo $idx ?>][jawdal_mulai]" class="span2 genTimePicker jawdal_mulai" value="00:00:00" onchange="hitungJumlahPasienDariEstimasi()"><span class="add-on" style="margin-top:0px !important; height: 31px !important;"><i class="icon-time"></i></span>
                        </div> s/d
                        <div class="input-append">
                            <input style="float:left" type="text" name="gen[<?php echo $idx ?>][jawdal_tutup]" class="span2 genTimePicker jawdal_tutup" value="00:00:00" onchange="hitungJumlahPasienDariEstimasi()"><span class="add-on" style="margin-top:0px !important; height: 31px !important;"><i class="icon-time"></i></span>
                        </div>
                        <hr/>
                        <div style="width: 200px;">
                            <label style="display: inline-block; width: 140px;">Estimasi Pelayanan (menit)</label>
                            <?php echo CHtml::textField("gen[".$idx."][estimasipelayanan]", '30', array('class'=>'span1 numbersOnly estimasipelayanan', 'style'=>'text-align: right;','onblur'=>'hitungJumlahPasienDariEstimasi();')); ?>
                        </div>
                        <div style="width: 200px;">
                            <label style="display: inline-block; width: 140px;">Kuota Pendaftaran Umum</label>
                            <?php echo CHtml::textField("gen[".$idx."][maximumantrian]", '0', array('class'=>'span1 numbersOnly maximumantrian', 'style'=>'text-align: right;')); ?>
                        </div>
                        <div>
                            <label style="display: inline-block; width: 140px;">Kuota Pendaftaran BPJS</label>
                            <?php echo CHtml::textField("gen[".$idx."][maximumbpjsantrian]", '0', array('class'=>'span1 numbersOnly maximumbpjsantrian', 'style'=>'text-align: right;')); ?>
                        </div>
                        <div>
                            <label style="display: inline-block; width: 140px;">Kuota Pembuatan Janji</label>
                            <?php echo CHtml::textField("gen[".$idx."][maksbuatjanji]", '0', array('class'=>'span1 numbersOnly maksbuatjanji', 'style'=>'text-align: right;')); ?>
                        </div>
                    </div>
                    <hr/>
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
            echo  CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')),
                         array('class'=>'btn btn-primary', 'type'=>'submit'));
        ?>

                       <?php
                            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')),
                                $this->createUrl('admin'),
                                    array('class'=>'btn btn-danger',
                                            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;',
                                        ));
                       ?>
             <?php
                echo CHtml::link(Yii::t('mds','{icon} Pengaturan Jadwal Dokter',array('{icon}'=>'<i class="entypo-folder"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));
               ?>
               <?php
                $content = $this->renderPartial('../tips/tipsaddeditjadwal',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
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
            var jam_awal = timeStringToFloat($(this).find(".jawdal_mulai").val());
            var jam_akhir = timeStringToFloat($(this).find(".jawdal_tutup").val());
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
            var jam_awal = timeStringToFloat($(this).find(".jawdal_mulai").val());
            var jam_akhir = timeStringToFloat($(this).find(".jawdal_tutup").val());
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

function getListDokter() {
    var ruangan_id = $("#inputPoli").val();

    $.post('<?php echo $this->createUrl('ajaxListDokterRuangan'); ?>', {ruangan_id: ruangan_id}, function(data) {
        $("#inputPegawai").html(data.list);
    }, 'json');
}


function generateInput()
{
    $.post('<?php echo $this->createUrl('ajaxGenerateInputForm') ?>', $('#penjadwalan-form').serialize(), function(data){
        $('#inputForm').html(data.form);
        $("#inputForm .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
        $("#inputForm .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
        $(".col_ceklis").each(function() {
            cekJadwalAktif($(this));
        });
    },'json');
}

function insertInputDokter(idTabel, idRuangan, obj)
{
    //var jmlBaris = $('#div_'+idTabel+'_'+idBaris+' input').length;
    parent = $(obj).parents("#tabelForm_"+idTabel+" tr td");
    var jmlBaris = parent.find(".inputDokter").length;
    var input = '';

	input += '<table width="100%" class="div_'+idTabel+'_'+jmlBaris+' classInline" style="margin-bottom: 10px;>';
	input += '<tr><td colspan="6">';
	input += '<td><select style="display:inline-block;" name="slotBed[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][pegawai_id]" id="slotBed_'+idTabel+'_'+idRuangan+'_'+jmlBaris+'" type="text" class="inputDokter span3" ></select>';
	input += '</td></tr>';
	input += '<tr>';
    input += '<td><div style="display:inline-block;margin-bottom:-7px;" class="input-append"><input style="float:left; width:70px;" type="text" name="slotBed[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][jawdal_mulai]" class="timePickerTest"><span class="add-on"><i class="icon-time"></i></span></div>';
    input += ' s/d ';
    input += '<div style="display:inline-block;margin-bottom:-7px;" class="input-append"><input style="float:left; width:70px;" type="text" name="slotBed[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][jawdal_tutup]" class="timePickerTest"><span class="add-on"><i class="icon-time"></i></span></div></td>';
    input += '<td>max umum</td>';
    input += '<td><input style="display:inline-block;" type="text" name="slotBed[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][maximumantrian]" class="span1 numbersOnly"></td>';
    input += '<td>max bpjs</td>';
    input += '<td><input style="display:inline-block;" type="text" name="slotBed[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][maximumbpjsantrian]" class="span1 numbersOnly"></td>';
    input += '<td>max janji</td>';
    input += '<td><input style="display:inline-block;" type="text" name="slotBed[jadwal]['+idTabel+'][dokter]['+idRuangan+'][dokter]['+jmlBaris+'][maksbuatjanji]" class="span1 numbersOnly"></td>';
    input += '<td><a href="javascript:void(0)" onclick="removeThis(this)"><i class="icon icon-minus"></i></a></td>';
	input += '</tr>';
	input += '</table><hr/>';


    //input = '<ul class="div_'+idTabel+'_'+jmlBaris+' classInline">'+input+'</ul>';
    if (parent.find(""))
    $('#div_'+idTabel+'_'+idRuangan).append(input);

    $.post( "<?php echo $this->createUrl('ajaxListDokter') ?>", {idRuangan:idRuangan},function( data ) {
        $('#slotBed_'+idTabel+'_'+idRuangan+'_'+jmlBaris).html(data.options);
    },'json');
    $("#div_"+idTabel+"_"+idRuangan+" .div_"+idTabel+'_'+jmlBaris+".classInline td .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
    $("#div_"+idTabel+"_"+idRuangan+" .div_"+idTabel+'_'+jmlBaris+".classInline td .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
}

function clientValidationFunc(obj){
    url = $("form").attr("action");
    error = "<div class='alert alert-block alert-error blockAlert'><p>Silakan perbaiki kesalahan input berikut:</p><ul></ul></div>";
    $.ajax({
        type : 'post',
        dataType : 'json',
        data : $("form").serialize(),
        success : function(result){
            myAlert('Jadwal Berhasil dibuat !');
            if (result.error == 'no'){
                $("form").submit();
            }else{
                myAlert('Isikan data yg belum lengkap , dan Buat Jadwal terlebih dahulu !')
                $("form").find(".error").removeClass("error");
                $(".errorTable .blockAlert").remove();
                $(".errorTable2 .blockAlert").remove();
                for (var i in result.error){
                    $('[name="'+i+'"]').addClass("error");
                    for(var x=0;x<result.error[i].length;x++){
                        if ($('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable .blockAlert").length < 1){
                            $('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable").append(error);
                            $('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>'+result.error[i][x]+'</li>');
                        }
                        else{
                            $('[name="'+i+'"]').parents(".tableJadwal tr td").find(".errorTable ul").append('<li>'+result.error[i][x]+'</li>');
                        }
                    }
                }
                if (result.error2.length > 0){
                    for(var i=0;i<result.error2.length;i++){
                        $('[name="'+result.error2[i]+'"]').addClass("error");
                        if ($('form table tr:first').find(".errorTable2 .blockAlert").length < 1){
                            $('form table tr:first').find(".errorTable2").append(error);
                            $('form table tr:first').find(".errorTable2 ul").append('<li>'+result.error2[i]+'</li>');
                        }
                        else{
                            $('form table tr:first').find(".errorTable2 ul").append('<li>'+result.error2[i]+'</li>');
                        }
                    }
                }
            }
        }
     });
}

function removeThis(obj){
    $(obj).parents(".classInline").remove();
}

function clearTransaksi(){
    $('#txtStartDate').val('');
    $('#txtEndDate').val('');
    $('#instalasi').val('');
}
function pilihSemua(obj){
	if($(obj).is(':checked')){
		$('#slotBed_poliklinik input[name*="poliklinik"]').each(function(){
			 $(this).attr('checked',true);
		});
	 }else{
		  $('#slotBed_poliklinik input[name*="poliklinik"]').each(function(){
			 $(this).removeAttr('checked');
		});
	 }
}

function getRuangan() {
	var id = $("#instalasi").val();

	$.post('<?php echo $this->createUrl('ajaxListPoli');?>', {id: id}, function(data) {
		$("#inputPoli").html(data.list);
		// jQuery("#inputPoli").multiselect("rebuild");
	}, 'json');
}

$(document).ready(function() {
    $(".genTimePicker").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
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
