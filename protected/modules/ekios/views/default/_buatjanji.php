<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<style>
* {
  box-sizing: border-box;
}

body {
  background-color: #f1f1f1;
}

#regForm {
  background-color: #ffffff;
/*  margin: 100px auto;*/
  font-family: Raleway;
  padding: 40px;
  width: 100%;
/*  min-width: 300px;*/
}

h1 {
  text-align: center;  
}

input {
  padding: 10px;
  width: 100%;
  font-size: 17px;
  font-family: Raleway;
  border: 1px solid #aaaaaa;
}

/* Mark input boxes that gets an error on validation: */
input.invalid {
  background-color: #ffdddd;
}

/* Hide all steps by default: */
.tab {
  display: none;
}

button {
  background-color: #4CAF50;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  font-size: 17px;
  font-family: Raleway;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

#prevBtn {
  background-color: #bbbbbb;
}

/* Make circles that indicate the steps of the form: */
.step {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbbbbb;
  border: none;  
  border-radius: 50%;
  display: inline-block;
  opacity: 0.5;
}

.step.active {
  opacity: 1;
}

/* Mark the steps that are finished and valid: */
.step.finish {
  background-color: #4CAF50;
}
</style>
<body>
<?php
   $this->widget('bootstrap.widgets.BootAlert'); 
 ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'action'=>Yii::app()->createUrl('ekios/Default/SimpanJanji'),
        'method'=>'post',
        'id'=>'ppbuat-janji-poli-t-form',
        'enableAjaxValidation'=>false,
'type'=>'horizontal',
'htmlOptions'=>array('id'=>'regForm','onKeyPress'=>'return disableKeyPress(event)', ''),
//'focus'=>'#',
)); ?>
<?php 
                                    $modPasien = new PPPasienM();
                                    $modPPBuatJanjiPoli = new BuatjanjipoliT();
                            ?>
  <h1>Buat Janji:</h1>
  <!-- One "tab" for each step in the form: -->
  <div class="tab form-user1">
    
    <p ><?php echo $form->textField($modPasien,'no_rekam_medik', array('placeholder'=>'Nomer Rekam Medik','onChange'=>"return cek_data()",'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'',)); ?></p>
    <p><?php   
            $this->widget('MyDateTimePicker',array(
                            'model'=>$modPasien,
                            'attribute'=>'tanggal_lahir',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //
                                'onkeypress'=>"js:function(){getUmurP(this);}",
                                'onSelect'=>'js:function(){getUmurP(this);}',
                            ),
                            'htmlOptions'=>array('placeholder'=>'tanggal lahir','readonly'=>true,'id'=>'picker','class'=>'dtPicker3 ', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                            ),
    )); ?>

    <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
        <input type="hidden" value="1" id="inisial">
    </p>
  </div>
  <div class="tab ">
    
    <p ><?php echo $form->textField($modPasien,'no_rekam_medik', array('placeholder'=>'Nomer Rekam Medik','onChange'=>"return cek_data()",'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'',)); ?></p>
    <p><?php   
            $this->widget('MyDateTimePicker',array(
                            'model'=>$modPasien,
                            'attribute'=>'tanggal_lahir',
                            'mode'=>'date',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate' => 'd',
                                //
                                'onkeypress'=>"js:function(){getUmurP(this);}",
                                'onSelect'=>'js:function(){getUmurP(this);}',
                            ),
                            'htmlOptions'=>array('placeholder'=>'tanggal lahir','readonly'=>true,'id'=>'picker','class'=>'dtPicker3 ', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                            ),
    )); ?>
    <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
        <input type="hidden" value="1" id="inisial">
    </p>
  </div>
  <div class="tab">
      <div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="panel-title">Data Pasien</div>
			</div>
			<div class="panel-body">
                                <table width="100%">
                                  <tr>
                                    <td>
                                                    <div class="control-group ">

                                                     <?php echo $form->labelEx($modPasien,'no_identitas_pasien', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php echo $form->dropDownList($modPasien,'jenisidentitas', LookupM::getItems('jenisidentitas'),  
                                                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                                                                            )); ?>   
                                                        <?php echo $form->textField($modPasien,'no_identitas_pasien', array('placeholder'=>'Nomor Identitas','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            
                                                        <?php echo $form->error($modPasien, 'jenisidentitas'); ?><?php echo $form->error($modPasien, 'no_identitas'); ?>
                                                    </div>

                                                </div>    
                                                 <div class="control-group ">
                                                    <?php echo $form->labelEx($modPasien,'nama_pasien', array('class'=>'control-label')) ?>
                                                    <div class="controls inline">

                                                        <?php echo $form->dropDownList($modPasien,'namadepan', LookupM::getItems('namadepan'),  
                                                                                      array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'
                                                                                            )); ?>   
                                                        <?php echo $form->textField($modPasien,'nama_pasien', array('placeholder'=>'Nama Pasien','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>            

                                                        <?php echo $form->error($modPasien, 'namadepan'); ?><?php echo $form->error($modPasien, 'nama_pasien'); ?>
                                                    </div>
                                                </div>

                                                <?php echo $form->textFieldRow($modPasien,'nama_bin', array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Alias')); ?>
                                                <?php echo $form->textFieldRow($modPasien,'tempat_lahir', array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Tempat Lahir')); ?>

                                                <div class="control-group ">
                                                    <?php echo $form->labelEx($modPasien,'tanggal_lahir', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php   
                                                                $this->widget('MyDateTimePicker',array(
                                                                                'model'=>$modPasien,
                                                                                'attribute'=>'tanggal_lahir',
                                                                                'mode'=>'date',
                                                                                'options'=> array(
                                                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                                                    'maxDate' => 'd',
                                                                                    //
                                                                                    'onkeypress'=>"js:function(){getUmurP(this);}",
                                                                                    'onSelect'=>'js:function(){getUmurP(this);}',
                                                                                ),
                                                                                'htmlOptions'=>array('placeholder'=>'Tanggal Lahir','readonly'=>true,'class'=>'dtPicker3 span3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                ),
                                                        )); ?>
                                                        <?php echo $form->error($modPasien, 'tanggal_lahir'); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <?php echo $form->labelEx($modPasien,'umur', array('class'=>'control-label')) ?>
                                                    <div class="controls">
                                                        <?php
                                                            $this->widget('CMaskedTextField', array(
                                                            'model' => $modPasien,
                                                            'attribute' => 'umur',
                                                            'mask' => '99 Thn 99 Bln 99 Hr',
                                                            'htmlOptions' => array('onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Umur')
                                                            ));
                                                            ?>
                                                        <?php echo $form->error($modPasien, 'umur',array('placeholder'=>'umur')); ?>
                                                    </div>
                                                </div>

                                    </td>
                                    <td>
                                        
                                        
                                       <?php //echo $form->radioButtonListInlineRow($modPasien,'jeniskelamin', LookupM::getItems('jeniskelamin'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                                            <?php echo $form->dropDownListRow($modPasien,'statusperkawinan', LookupM::getItems('statusperkawinan'),array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                        <div class="control-group ">
                                            <?php echo $form->labelEx($modPasien,'golongandarah', array('class'=>'control-label')) ?>

                                            <div class="controls">

                                                <?php echo $form->dropDownList($modPasien,'golongandarah', LookupM::getItems('golongandarah'),  
                                                    array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2')); ?>   
                                                <div class="radio inline">
                                                    <div class="form-inline">
                                                    <?php //echo $form->radioButtonList($modPasien,'rhesus',LookupM::getItems('rhesus'), array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>            
                                                    </div>
                                               </div>
                                                <?php echo $form->error($modPasien, 'golongandarah'); ?>
                                                <?php echo $form->error($modPasien, 'rhesus'); ?>
                                            </div>
                                        </div> 
                                        <?php echo $form->textAreaRow($modPasien,'alamat_pasien', array('placeholder'=>'Alamat Pasien','onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'')); ?>

                                        <div class="control-group ">
                                            <?php echo $form->labelEx($modPasien,'rt', array('class'=>'control-label inline ')) ?>

                                            <div class="controls">
                                                <?php echo $form->textField($modPasien,'rt', array('placeholder'=>'','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>   / 
                                                <?php echo $form->textField($modPasien,'rw', array('placeholder'=>'','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numbersOnly','maxlength'=>3)); ?>            
                                                <?php echo $form->error($modPasien, 'rt'); ?>
                                                <?php echo $form->error($modPasien, 'rw'); ?>
                                                 <input type="hidden" value="2" id="inisial">
                                            </div>
                                        </div>
                                    </td>
                                  </tr>
                                </table>
                        </div>
                </div>  
         </div> 
</div>    
  </div>
  <div class="tab">
    <div class="row">
                                <div class="col-md-12">
                                        <div class="panel panel-primary success">
                                                <div class="panel-heading">
                                                        <div class="panel-title">Masukan Data Janji
                                                        </div>
                                                </div>
                                                <div class="panel-body">
                                
                                                            <table width="100%">
                                                        <tr>
                                                            <td>
                                                                <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'ruangan_id', CHtml::listData($modPPBuatJanjiPoli->getRuanganItems(), 'ruangan_id', 'ruangan_nama') ,
                                                                    array('empty'=>'-- Pilih --',
                                                                        'onchange'=>"listDokterRuangan(this.value);",
                                                                        'ajax'=>array(),
                                                                        'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>    
                                                                <?php echo $form->dropDownListRow($modPPBuatJanjiPoli,'pegawai_id', array() ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                                                                <div class="control-group ">
                                                                    <?php echo $form->labelEx($modPPBuatJanjiPoli,'tgljadwal', array('class'=>'control-label')) ?>
                                                                        <div class="controls">
                                                                            <?php   
                                                                                $this->widget('MyDateTimePicker',array(
                                                                                    'model'=>$modPPBuatJanjiPoli,
                                                                                    'attribute'=>'tgljadwal',
                                                                                    'mode'=>'datetime',
                                                                                    'options'=> array(
                                                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                                                        'minDate' => 'd',
                                                                                        'onkeypress'=>"js:function(){getUmur(this);}",
                                                                                        'onSelect'=>'js:function(){hariBaru(this);}',
                                                                                    ),
                                                                                    'htmlOptions'=>array('placeholder'=>'Tanggal Jadwal','readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                                                    ),
                                                                            )); ?>
                                                                            <?php echo $form->error($modPPBuatJanjiPoli, 'tgljadwal'); ?>
                                                                        </div>
                                                                    </div>		
                                                            </td>
                                                            <td>
                                                                    
                                                                <?php echo $form->textAreaRow($modPPBuatJanjiPoli,'keteranganbuatjanji',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                                                <?php  //echo $form->checkBoxRow($modPPBuatJanjiPoli,'byphone', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                                                                 
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                         
                                                        </tr>
                                                    </table>
                                                    
                                                    
                                            </div>
                                        </div> 
                                    </div>
                                </div>
  </div>
  <div class="tab">Login Info:
    <p><input placeholder="Username..." oninput="this.className = ''" name="uname"></p>
    <p><input placeholder="Password..." oninput="this.className = ''" name="pword" type="password"></p>
  </div>
  <div style="overflow:auto;">
    <div style="float:right;">
      <button type="button" id="prevBtn" onclick="nextPrev(-1)">Kembali</button>
      <button type="button" id="nextBtn" onclick="nextPrev(1)">Lanjutkan</button>
      <button type="submit" id="btn_simpan" onclick="">Simpan</button>
     
    </div>
  </div>
  <!-- Circles which indicates the steps of the form: -->
  <div style="text-align:center;margin-top:40px;">
    <span class="step"></span>
    <span class="step"></span>
    <span class="step"></span>
    
  </div>
<?php $this->endWidget(); ?>

<script>
    
$( document ).ready(function() {
    $("#btn_simpan").hide();
     
     
});
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the crurrent tab

function showTab(n) {
  // This function will display the specified tab of the form...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  //... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
    $("#btn_simpan").hide();
  } else {
    document.getElementById("prevBtn").style.display = "inline";
    $("#btn_simpan").hide();
  }
  if (n == (x.length - 2)) {
    //document.getElementById("nextBtn").innerHTML = "Simpan";
       $("#nextBtn").hide();
       $("#btn_simpan").show();
  } else {
    document.getElementById("nextBtn").innerHTML = "Lanjutkan";
    $("#btn_simpan").hide();
  }
  //... and run a function that will display the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
 var inisial = $('#inisial').val();
 var norekam = $('#PPPasienM_no_rekam_medik').val();
 var tgllahir = $('#picker').val();
console.log(inisial);
var statusaksi=false;

		
			$.ajax({
				type: 'POST',
				url:'<?php echo Yii::app()->createUrl('/ekios/Default/ValidasiUtama')  ?>',
				data: {norekam:norekam,tgllahir:tgllahir},
                                 dataType: "json",
				success: function(data) {
					//alert(data.jenisidentitas);
                                     if(data.status!=false){ 
                                       
                                        //console.log(data.jenisidentitas);
                                        statusaksi=true;
                                        
                                            if(statusaksi==true && inisial==1){
                                                
                                                 $("#PPPasienM_jenisidentitas").val(data.jenisidentitas);
                                                $("#PPPasienM_no_identitas_pasien").val(data.no_identitas_pasien);
                                                $("#PPPasienM_namadepan").val(data.namadepan);
                                                $("#PPPasienM_nama_pasien").val(data.nama_pasien);
                                                $("#PPPasienM_nama_bin").val(data.nama_bin);
                                                $("#PPPasienM_tempat_lahir").val(data.tempat_lahir);
                                                $("#PPPasienM_tanggal_lahir").val(data.tanggal_lahir);
                                                $("#PPPasienM_umur").val(data.umur);
                                                $("#PPPasienM_statusperkawinan").val(data.statusperkawinan);
                                                $("#PPPasienM_golongandarah").val(data.golongandarah);
                                                $("textarea#PPPasienM_alamat_pasien").val(data.alamatpasien);
                                                $("#PPPasienM_rt").val(data.rt);
                                                $("#PPPasienM_rw").val(data.rw);
                                                $("#inisial").val("2");
                                                // This function will figure out which tab to display
                                                var x = document.getElementsByClassName("tab");
                                                // Exit the function if any field in the current tab is invalid:
                                                if (n == 1 && !validateForm()) return false;
                                                // Hide the current tab:
                                                x[currentTab].style.display = "none";
                                                // Increase or decrease the current tab by 1:
                                                currentTab = currentTab + n;
                                                // if you have reached the end of the form...
                                                if (currentTab >= x.length) {
                                                  // ... the form gets submitted:
                                                  document.getElementById("regForm").submit();
                                                  return false;
                                                }
                                                // Otherwise, display the correct tab:
                                                showTab(currentTab);
                                                }else if(statusaksi==true && inisial==2){
                                                       // This function will figure out which tab to display
                                                var x = document.getElementsByClassName("tab");
                                                // Exit the function if any field in the current tab is invalid:
                                                if (n == 1 && !validateForm()) return false;
                                                // Hide the current tab:
                                                x[currentTab].style.display = "none";
                                                // Increase or decrease the current tab by 1:
                                                currentTab = currentTab + n;
                                                // if you have reached the end of the form...
                                                if (currentTab >= x.length) {
                                                  // ... the form gets submitted:
                                                  document.getElementById("regForm").submit();
                                                  return false;
                                                }
                                                // Otherwise, display the correct tab:
                                                showTab(currentTab);
                                                }
                                                
                                                else{
                                                  return false;
                                                }
                                    }else{
                                        statusaksi=false;
                                    }
				}
                              });  
	
  
  console.log(statusaksi);
  
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class on the current step:
  x[n].className += " active";
}
function listDokterRuangan(idRuangan)
{
    $.post("<?php echo Yii::app()->createUrl('/ekios/Default/SetDropdownDokter'); ?>", { ruangan_id: idRuangan },
        function(data){
            $('#BuatjanjipoliT_pegawai_id').html(data.listDokter);
    }, "json");
}

</script>

</body>
</html>
