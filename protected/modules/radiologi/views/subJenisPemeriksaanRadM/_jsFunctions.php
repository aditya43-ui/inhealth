<?php
/**
* - digunakan untuk mempermudah tracing fungsi javascript yang digunakan pada view pemeriksaanRadM
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>

<script>
	
/**
* -digunakan untuk memeriksa, apakah data pemeriksaan ada lebih dari 1 hasil pemeriksaan
* @param {type} obj
* @returns {cek data}
*/
function cekBanyak(obj){
   var cek = $(obj).prop("checked");

   if (cek == true){
	   reset(1);
   }else{
	   reset(0);
   }
}

/**
 * - digunakan untuk mereset data, atau menampilkan data jika pilihan pemeriksaannya banyak atau tidak
 * @param {type} val
 * @returns {undefined}
 */
function reset(val){
	var tr = $("#table-referensidet > tbody > tr");	
	
	if (val == 1){		
		
		$("#form-referensirad").attr("style","display:none;");
		$("#form-referensidet").attr("style","display:block;");
		 //$("#table-referensidet > tbody").html("");
		//var tr = $("#table-referensidet").find("tbody > tr");
		
		/*var row = 1;
		tr.each(function(){
			if (row == 1){
				$(this).find("input[name$='[refhasildet_id]']").val("");
				$(this).find("input[name$='[refhasildet_nama]']").val("");
				$(this).find("select[name$='[refhasildet_jk]']").val("");
				$(this).find("textarea[name$='[refhasildet_isian]']").val("");
				$(this).find("input[name$='[refhasildet_urut]']").val("");
			}else{
				$(this).detach();
			}			
		});		*/
		renameInputRow($("#table-referensidet"));
	}else{				
		$("#form-referensirad").attr("style","display:block;");
		$("#form-referensidet").attr("style","display:none;");
		
		$("#<?php echo CHtml::activeId($modReferensiHasil, 'refhasilrad_hasil'); ?>").val("");
		$("#<?php echo CHtml::activeId($modReferensiHasil, 'refhasilrad_kesimpulan'); ?>").val("");
		$("#<?php echo CHtml::activeId($modReferensiHasil, 'refhasilrad_keterangan'); ?>").val("");
	}
}

function renameInputRow(obj_table){
		var row = 0;
		$(obj_table).find("tbody > tr").each(function(){
			$(this).find('span').each(function(){ //element <input>
				var old_name = $(this).attr("name").replace(/]/g,"");
				var old_name_arr = old_name.split("[");
				if(old_name_arr.length == 3){
					$(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
				}
			});
			$(this).find('input,select,textarea').each(function(){ //element <input>
				var old_name = $(this).attr("name").replace(/]/g,"");
				var old_name_arr = old_name.split("[");
				if(old_name_arr.length == 3){
					$(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
					$(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
				}
			});
			row++;
						
			jQuery('[data-toggle="tooltip"]').each(function(i, el)
			{
				var $this = jQuery(el),
					placement = attrDefault($this, 'placement', 'top'),
					trigger = attrDefault($this, 'trigger', 'hover'),
					popover_class=$this.hasClass('tooltip-secondary') ? 'tooltip-secondary' : ($this.hasClass('tooltip-primary') ? 'tooltip-primary' : ($this.hasClass('tooltip-default') ? 'tooltip-default' : ''));

				$this.tooltip({
					placement: placement,
					trigger: trigger
				});

				$this.on('shown.bs.tooltip', function(ev)
				{
					var $tooltip = $this.next();

					$tooltip.addClass(popover_class);
				});
			});		
			
			
		});		
	}

	function hapusLookup(obj){
		var poinpegdet_id = $(obj).parents("tr").find("input[name$='[refhasildet_id]']").val();
		
		var r = confirm("Apakah Anda yakin ingin menghapus data ini?");
		if(r == true){			
			$(obj).parents('tr').detach();
			renameInputRow($("#table-referensidet"));																				
		}else{
			return false;
		}
	}
	

	function tambahLookup(){
		var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_formItems',array('model'=>$modRefDet, 'modReferensiHasil'=>$modReferensiHasil,'i'=>0),true));?>';
		//var tr = $('#table-referensidet  tbody tr:first').html();
		//$('#table-referensidet').find("tbody").append("<tr>"+tr+"</tr>");
		$('#table-referensidet').find("tbody").append(row);
		renameInputRow($("#table-referensidet"));		
	}
	
	
</script>
