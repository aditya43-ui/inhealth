<div class="white-container">
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <style>
        label.checkbox{display:inline-block;width:150px;}
        ul.classInline{display:inline-block; list-style: none;}
        ul.classInline li{display:inline-block;margin-right:5px;}
		.beds{
			margin-top: -30px;
		}
		.icon-minus{
			margin-top: -15px;
			margin-left: 10px;
		}
		table .spans2 {
			float: none;
			margin-left: 0;
			width: 90px;
		}
		table .spans3 {
			float: none;
			margin-left: 0;
			width: 110px;
		}
		.lfloat{ float: left;}
		.lclear{ float: none; clear: both;}
		#batalForm { margin-left: 15px;}
		table .spanBed {
    float: none;
    margin-left: 0;
    width: 70px;
}
    </style>
<?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', "Data jadwal berhasil disimpan!");
    }
?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penjadwalan-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
    )); ?>
	<legend class="rim2">Buat Jadwal Hemodialisa</legend>
    <table>
        <tr>
            <td colspan="5"><div class='errorTable2'></div></td>
        </tr>
		
		<tr>
			<td width='100px'>Jadwal Hari</td>
			<td width="100px">
				<?php
                    echo CHtml::dropDownList('jadwalRH[IdHari]', '', CHtml::listData(PPJadwalhariM::model()->findAllByAttributes(array('jadwalhari_aktif'=>true)), 'jadwalhari_id', 'jadwalhari_nama'), 
                                            array('empty'=>'-- Pilih --',
                                                  'id'=>'IdHari',
                                                  'onchange'=>'$("#inputForm").html("");',
                                                  'ajax'=>array('url'=>$this->createUrl('ajaxListHari'),
                                                                'type'=>'POST',
                                                                'update'=>'#inputHari')
												));
                ?>
			</td>
			<td colspan="3">
				<div id="inputHari"></div>
			</td>
		</tr>
		<tr>
			<td>Shift</td>
			<td>
				<?php
				$type_list=CHtml::listData(ShiftM::model()->findAllByAttributes(array('shift_aktif'=>true),array('order'=>'shift_urutan ASC')),'shift_id','shift_nama');
				echo CHtml::checkBoxList('jadwalRH[shift]',$selected_Array=array(),$type_list);
				?>
			</td>
			<td width="60px">Ruangan</td>
			<td width="250px">
				<?php
				$type_list2=CHtml::listData(PPRuanganhemodialisaV::model()->findAll(),'ruangan_id','ruangan_nama');
				echo CHtml::checkBoxList('jadwalRH[ruangan]',$selected_Array2=array(),$type_list2);
                ?>
			</td>
			<td>
				<div class="form-actions" style='width:230px;margin-left:-40px;'>
                    <table style="width: 100%; border: none;">
                      <tr>
                           <td><div style='margin-left:20px;'><?php echo CHtml::htmlButton(Yii::t('mds','{icon} Buat Jadwal',array('{icon}'=>'<i class="icon-list-alt icon-white"></i>')),
                                                    array('class'=>'btn btn-info', 'type'=>'button', 'onClick'=>'generateInput();'));?></div>
						   </td>
						   <td></td>
                           <td>
                                   <?php
                                        echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                                            $this->createUrl('penjadwalanHD'), 
                                                array('class'=>'btn btn-danger'));
                                   ?>
						   </td>
                      </tr>
                    </table>
                </div>
			</td>
			
		</tr>
<?php 
    if(isset($_GET['totalData'])){
		$totalData = $_GET['totalData'];
        echo '<tr><td colspan="5" class="totalDataView">';
		echo $this->renderPartial($this->path_view.'PrintPdf',array('model'=>$model, 'totalData'=>$totalData));
		echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'));
		
		$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
		$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$js = <<< JSCRIPT
    
function print(caraPrint)
{
	window.open("${urlPrint}"+"&totalData="+"${totalData}"+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);     
		echo '</td></tr>';
    }
?>
		<tr>
            <td colspan="5"><div id='inputForm'></div></td>
        </tr>
		
		<tr>
			<td colspan="5">
				<div id='submitForm' class="lfloat">
                                   <?php
//                                       echo  CHtml::htmlButton(Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')),
//                                                    array('class'=>'btn btn-primary', 'type'=>'button','onsubmit'=>'return requiredCheck(this);'));
                                   ?>
                </div>
				<div id='batalForm' class="lfloat">
					
				</div>
				<div class="lclear"></div>
			</td>
		</tr>

    </table>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

function generateInput()
{
	$('.totalDataView').hide();
	var idhari = $('#IdHari').val();
	if(idhari != ''){
    $.post('<?php echo $this->createUrl('ajaxGenerateInputForm') ?>', $('#penjadwalan-form').serialize(), function(data){
        $('#inputForm').html(data.form);
//        $("#inputForm .classInline li .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
//        var test = $("#inputForm tr td .timePickerTest").val();
//		alert(test);
//        $("#inputForm tr td .timePickerTest").datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
//		$("#inputForm .classInline li .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','beforeShow':function(){customRange(this);},'dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
//        $("#div_"+idTabel+'_'+idShift+"_"+idRuangan+" ul.div_"+idTabel+'_'+jmlBaris+".classInline li .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','beforeShow':function(){customRange(this);},'dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
		$('#submitForm').html(data.submit);
		$('#batalForm').html(data.batal);
//		$('#tanggalHemodialisa_0_0').datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
		
		$('#inputForm #tabelForm_1 tr td').each(function(){
        var test = jQuery('input[name*="[jadwalrehabmedis_tgl]"]').val();
		console.log(test);
//				.datetimepicker(
//            jQuery.extend(
//                {
//                    showMonthAfterYear:false,
//                }, 
//                jQuery.datepicker.regional['id'],
//                {
//                    'dateFormat':'dd M yy',
//                    'maxDate':'d',
//                    'timeText':'Waktu',
//                    'hourText':'Jam',
//                    'minuteText':'Menit',
//                    'secondText':'Detik',
//                    'showSecond':true,
//                    'timeOnlyTitle':'Pilih Waktu',
//                    'timeFormat':'hh:mm:ss',
//                    'changeYear':true,
//                    'changeMonth':true,
//                    'showAnim':'fold',
//                    'yearRange':'-80y:+20y'
//                }
//            )
//        );
    }); 
//        
    },'json');
	}
	else{
		myAlert('Mohon pilih dulu Jadwal Hari');
	}
}

function insertInputJadwal(idTabel, idShift, idRuangan, obj)
{
	parent = $(obj).parents("#tabelForm_"+idTabel+" tr td");
    var jmlBaris = parent.find(".inputDokter").length;
    var input = '';
	input += '<li><div class="input-append"><input type="text" class="spans3" name="jadwalRehab[jadwal]['+idTabel+']['+idShift+']['+idRuangan+'][namapasien]['+jmlBaris+']" id="namaPasien_'+idTabel+'_'+idShift+'_'+idRuangan+'_'+jmlBaris+'" style="float:left;" onkeypress="return $(this).focusNextInputField(event)" class="ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true"><span class="add-on"><a href="javascript:void(0);" id="" onclick="setDialog(this);"><i class="icon-list"></i><i class="entypo-search"></i></a></span></div></li>';
    input += '<input type="hidden" class="span1" name="jadwalRehab[jadwal]['+idTabel+']['+idShift+']['+idRuangan+'][pasien_id]['+jmlBaris+']">';
	input += '<li><input type="text" class="spans2 beds" name="jadwalRehab[jadwal]['+idTabel+']['+idShift+']['+idRuangan+'][jeniskelamin]" disabled></li>';
    input += '<li><select style="display:inline-block;" name="jadwalRehab[jadwal]['+idTabel+']['+idShift+']['+idRuangan+'][bed]['+jmlBaris+']" id="jadwalRehab_'+idTabel+'_'+idShift+'_'+idRuangan+'_'+jmlBaris+'" type="text" class="inputDokter spanBed beds"></select></li>';
    input += '<li><a href="javascript:void(0)" onclick="removeThis(this)" title"Batalkan pasien"><i class="icon icon-minus"></i></a></li>';
    
    input = '<ul class="div_'+idTabel+'_'+idShift+'_'+jmlBaris+' classInline">'+input+'</ul>';
    if (parent.find(""))
    $('#div_'+idTabel+'_'+idShift+'_'+idRuangan).append(input);
    
    $.post( "<?php echo $this->createUrl('ajaxListBed') ?>", {idRuangan:idRuangan},function( data ) {
        $('#jadwalRehab_'+idTabel+'_'+idShift+'_'+idRuangan+'_'+jmlBaris).html(data.options);
    },'json');
//    $("#div_"+idTabel+'_'+idShift+"_"+idRuangan+" ul.div_"+idTabel+'_'+jmlBaris+".classInline li .numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
//    $("#div_"+idTabel+'_'+idShift+"_"+idRuangan+" ul.div_"+idTabel+'_'+jmlBaris+".classInline li .timePickerTest").timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','beforeShow':function(){customRange(this);},'dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}));
}

function setDialog(obj){
	parent = $(obj).parents(".input-append").find("input").attr("id");
//    $("#ui-dialog-title-dialogPasien").html(parent);
	dialog = "#dialogPasien";
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}
    
function clientValidationFunc(obj){
    url = $("form").attr("action");
    error = "<div class='alert alert-block alert-error blockAlert'><p>Silakan perbaiki kesalahan input berikut:</p><ul></ul></div>";
    $.ajax({
        type : 'post',
        dataType : 'json',
        data : $("form").serialize(),
        success : function(result){
            myAlert('Jadwal Berhasil dibuat!');
            if (result.error == 'no'){
                $("form").submit();
            }else{
                myAlert('Silakan isikan data yang belum lengkap dan buat jadwal terlebih dahulu!')
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
			$('#inputForm').html('');
        }
     });
}

function removeThis(obj){
    $(obj).parents(".classInline").remove();
}

function setTindakanAuto(pasien_id){
    dialog = "#dialogPasien";
    parent = $(dialog).attr("parent-dialog");
    obj = $("#"+parent);
	
	var tanggal1 = $(obj).parents('table').prev().find("input[name*='jadwalrehabmedis_tgl']").val();
	var tanggal2 = $(obj).parents('table').find("input[name*='jadwalrehabmedis_tgl']").val();
	var idpasien3 = $(obj).parents('table').prevAll().find("input[name*='pasien_id']");
	
	var idpasien = $(obj).parents('ul').prev().find("input[name*='pasien_id']").val();
	var idpasien2 = $(obj).parents('ul').prevAll().find("input[name*='pasien_id']");
	
	var datanya = 0;
    $.get('<?php echo Yii::app()->createUrl('pendaftaranPenjadwalan/jadwalrehabmedisT/infoPasien'); ?>',{pasien_id: pasien_id},function(data){
		if(data.pasien != idpasien){
			
			idpasien2.each(function() {
				if($( this ).val() == data.pasien){
					datanya = 1;
				}
			});	
			
			if(tanggal1 == tanggal2){
				idpasien3.each(function() {
					if($( this ).val() == data.pasien){
						datanya = 1;
					}
				});
			}
			
			if(datanya != 1){
				$(obj).parents('ul').find("input[name*='pasien_id']").val(data.pasien);
				$(obj).parents('ul').find("input[name*='namapasien']").val(data.namapasien);
				$(obj).parents('ul').find("input[name*='jeniskelamin']").val(data.jeniskelamin);
			}else{
				myAlert('Pasien Sudah diplih pada tanggal ini');
			}			
			
		}
		else{
			myAlert('Pasien Sudah diplih sebelumnya');
		}
		
	},"json");
    $(dialog).dialog("close");

}

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

//========= Dialog buat cari data Pasien=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 350,
        'resizable' => false,
    ),
));

$modPasien = new PPPasienM('searchDialogPasienHD');
if(isset($_GET['PPPasienM'])){
    $modPasien->attributes = $_GET['PPPasienM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-m-grid',
    'dataProvider' => $modPasien->searchDialogPasienHD(),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "
													setTindakanAuto($data->pasien_id);    
                                                "))',
        ),
         'no_rekam_medik',
         'nama_pasien', 
       
    ),
    'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        }',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

