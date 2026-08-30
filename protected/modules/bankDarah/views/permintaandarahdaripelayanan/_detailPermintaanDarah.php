<tr>   
    <td>    
        <?php echo $modJenisKomponenDarah->jeniskomponenedarah_nama; ?>
        <?php echo CHtml::activeHiddenField($modJenisKomponenDarah, '[ii]jeniskomponendarah_id', array('readonly'=>true, 'class' => 'jeniskomponendarah_id')); ?>   
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]permintaankepenunjang_id', array('readonly'=>true)); ?> 
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]jenispermintaan', array('readonly'=>true)); ?> 
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]kadarhb', array('readonly'=>true)); ?>  
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]plt', array('readonly'=>true)); ?>  
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]jenis_volume', array('readonly'=>true)); ?>  
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]diambil', array('readonly'=>true)); ?>  
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]dititip', array('readonly'=>true)); ?>  
        <?php echo CHtml::activeHiddenField($modPermintaanKepenunjang, '[data][ii]qtypermintaan', array('readonly'=>true)); ?>  
    </td>
    
    <td>
        <?php echo CHtml::activeTextField($modPermintaanKepenunjang, '[data][ii]indikasi_darah', array('readonly'=>true)); ?></td>    
    </td>
    <td>
        <?php
        $modPermintaanKepenunjang->tglren_transfusi = isset($modPermintaanKepenunjang->tglren_transfusi) ? MyFormatter::formatDateTimeForUser($modPermintaanKepenunjang->tglren_transfusi) : "";
			$this->widget('MyDateTimePicker', array(
				'model'=>$modPermintaanKepenunjang,
				'attribute'=>'[data][ii]tglren_transfusi',
				'mode' => 'datetime',
				'options' => array(
					'dateFormat' => Params::DATE_FORMAT,
				),
				'htmlOptions' => array('readonly' => true,'style'=>'width:150px;', 'onkeypress'=>"return $(this).focusNextInputField(event);"),
			));?>
    </td> 
    <td style="text-align: center;"><?php echo Chtml::link('<icon class="glyphicon glyphicon-remove"></icon>', '', array('onclick'=>'batal(this);', 'style'=>'cursor:pointer; color:red; ', 'class'=>'cancel')); ?></td>
</tr>        
<script>
     function generatePicker(){
         renameInputRowPemantauan($("#table-detailbarang"));
     $('#table-detailbarang > tbody').each(function(){
            jQuery('input[name$="[tglren_transfusi]"]').datetimepicker(
                jQuery.extend(
                    {
                        showMonthAfterYear:false
                    }, 
                    jQuery.datepicker.regional['id'],
                    {
    
                        'timeText':'Waktu',
                        'hourText':'Jam',
                        'minuteText':'Menit',
                        'secondText':'Detik',
                        'showSecond':true,
                        'timeOnlyTitle':'Pilih Waktu',
                        'timeFormat':'hh:mm:ss',
                        'changeYear':true,
                        'changeMonth':true,
                        'showAnim':'fold',
                        'dateFormat':'dd M yy',
                        'yearRange':'-80y:+20y',
                       
                    }
                )
            );//mask("99/99/9999 99:99:99")   
     });
 }
     $(document).ready(function(){ 
       
       setTimeout("generatePicker()",1000);
      
    });
    function renameInputRowPemantauan(obj_table){
    var row = 0;
    var mntke = 1;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('input[name$="[menitke]"]').val(mntke * 5);
		$(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
            }
        });
        row++;
        mntke++;
    });
}
    </script>