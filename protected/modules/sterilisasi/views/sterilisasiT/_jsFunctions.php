<script type="text/javascript">
function setNol(obj){
    if($(obj).is(":checked")){
        obj.value = 1;
    }else{
        obj.value = 0;
    }
}

function checkAll(){
    $("#tabel-penerimaansterilisasi > tbody > tr").find('input[type="checkbox"]').each(
    function(){
        if($("#check_semua").is(":checked")){
            $(this).attr('checked','checked');
        }else{
            $(this).removeAttr('checked');
        }
    });
}

function validasiCek(){
    if(requiredCheck($("form"))){
        var jumlah_bahan = $('#tabel-penerimaansterilisasi tbody tr').length;
        if(jumlah_bahan <= 0){
                myAlert('Silakan isikan bahan penerimaan terlebih dahulu!');
            return false;
        }else{
            $('#sterilisasi-t-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;    
}

/**
* untuk print sterilisasi linen
 */
function print(caraPrint)
{
    var sterilisasi_id = '<?php echo $modSterilisasi->sterilisasi_id; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&sterilisasi_id='+sterilisasi_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function searchPenerimaan(){
	$('#form-penerimaanlinen').addClass('animation-loading');
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pencarianPenerimaanView'); ?>',
		data: {data:$('#pencarian-form').serialize()},//
		dataType: "json",
		success:function(data){
			$('#tabel-penerimaansterilisasi > tbody').html("");
			if(data.pesan !== ""){
				myAlert(data.pesan);
				$('#form-penerimaanlinen').removeClass('animation-loading');
				return false;
			}
			$('#tabel-penerimaansterilisasi > tbody').append(data.form);
			
			renameInputRow($("#tabel-penerimaansterilisasi"));
			$('#tabel-penerimaansterilisasi > tbody > tr .fcbkcomplete').fcbkcomplete({
				'json_url':'<?php echo $this->createUrl('MasterBahanSterilisasi'); ?>',
				'addontab': true, 
				'maxitems': 10,
				'input_min_size': 0,
				'cache': true,
				'newel': false,
				'addoncomma':true,
				'select_all_text': "", 
				'autoFocus':true,
				'width':'200px',
			});
			jQuery('input[name$="[waktukadaluarsa]"]').datepicker(
				jQuery.extend(
					{showMonthAfterYear:true},
					jQuery.datepicker.regional['id'],
					{
						'dateFormat':'dd M yy',
						'changeYear':true,
						'changeMonth':true,
						'showAnim':'fold',
						'yearRange':'-0y:+10y'
					}
				)
			);
			jQuery('#tabel-penerimaansterilisasi > tbody input[name*="[maininput]"]').hide();
			$('#form-penerimaanlinen').removeClass('animation-loading');
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

/**
* rename input grid
*/ 
function renameInputRow(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){		
        $(this).find("#no_urut").val(row+1);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        $(this).find('input[name$="[maininput]"]').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
            if(old_name_arr.length == 4){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]+"_"+row);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]["+row+"]");
            }
        });
        row++;
    });	
}
/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

/**
 * function ini harus tetap berada di bawah
 */
$(document).ready(function(){
    var sterilisasi_id = '<?php echo $modSterilisasi->sterilisasi_id; ?>';
    if(sterilisasi_id != ""){
        $("input, textarea, checkbox, select").attr("readonly",true);
        $(".add-on").remove();
        $(".dtPicker3").remove();
        $(".icon-remove").remove();
        renameInputRow($("#tabel-penerimaansterilisasi"));
    }
    
    <?php if ($modSterilisasi->isNewRecord && isset($_GET['pembersihan_id'])) { ?>
        searchPenerimaan();
    <?php } ?>
    
	
	$(".jsTagEditor:not(.jsTagEditorInit)").fcbkcomplete({
		'json_url':'<?php echo $this->createUrl('MasterBahanSterilisasi'); ?>',
		'preset_update': true, //don't set this if json_url is set
		'data': false,
		'newel': true,
		'first_selected': true,
		'filter_case': true,
		'filter_hide': true,
		'filter_selected': true,
		'complete_text': 'No tag',
		'choose_on_comma': false, //Bug-do not set to true: can not input a '?' on french keyboards
		'choose_on_tab': false, //Bug-do not set to true: normal keyboard navigation using tab/shift-tab stops working
		'choose_on_enter': true,
		'php_mode': false, //Set this to true if json_url is a real url of a php service
		//maxshownitems: 30,
		//maxitems: 10,
		'delay': 300, //Good value when your service is online
		class_names: {
			'complete': 'softline'
		},
		'connect_with':'Array',
		onremove: function(val){ console.log([this, {'val':val}, 'remove'])},
		onselect: function(val){ console.log([this, {'val':val}, 'select'])},
	})
	.addClass('jsTagEditorInit');
            $('form').bind('click keyup select change', function(event) { 
                cekDisabled(this); 
            }); 
            $(document).on('click keyup select change',function(){ 
                cekDisabled('form'); 
            }); 
            cekDisabled('form');
});
</script>