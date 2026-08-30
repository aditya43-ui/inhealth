<?php
/**
* - digunakan untuk menampung semua script javascript, agar mudah di tracing
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/
?>
<script>
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
		var poinpegdet_id = $(obj).parents("tr").find("input[name$='[pengajuanpettydet_id]']").val();
		
		var r = confirm("Apakah Anda yakin ingin menghapus data ini?");
		if(r){			
			$(obj).parents('tr').detach();
			renameInputRow($("#table-lookup"));																							
		}else{
			return false;
		}
	}
	

	function tambahLookup(){
		var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form._formItems',array('model'=>$modDet, 'i'=>0),true));?>';
		$('#table-lookup').append(row);
		renameInputRow($("#table-lookup"));
		
	}
        
	function cekSubmit(obj){
		var tr = $("#table-lookup").find('tbody tr');
		var vItem = true;
		var vHargaSatuan = true;
		var vQty = true;

		if (tr.length == 0){
			alert("Maaf, Data pada Tabel Detail belum diisi");
			return false;
		}else{
			tr.each(function(){
			  if ($(this).find(".item").val() == '')  {
				  $(this).find(".item").attr("style","border:1px solid red");
				  vItem = false;                     
			  }else{
				  $(this).find(".item").attr("style","");
				  vItem = true;
			  }

			  if ($(this).find(".hargasatuan").val() == '')  {
				  $(this).find(".hargasatuan").attr("style","border:1px solid red;text-align:right;");
				  vHargaSatuan = false;
			  }else{
				  $(this).find(".hargasatuan").attr("style","text-align:right;");
				  vHargaSatuan = true;
			  }

			  if ($(this).find(".qty").val() == '')  {
				  $(this).find(".qty").attr("style","border:1px solid red");
				  vQty = false;                     
			  }else{
				  $(this).find(".qty").attr("style","");
				  vQty = true;
			  }
			});

			if (vQty == false && vHargaSatuan == false && vItem == false){
				myAlert("Maaf, data pada kolom qty, harga satuan dan barang pada tabel detail tidak boleh kosong!");
				return false;
			}else{
				return requiredCheck(obj);
			}

		}
	}

	function hitungTot(){
		var total = 0;            
		unformatNumberSemua();
		$('#table-lookup tbody > tr').each(function(){						  
			var harga  = $(this).find('input[name$="[pengajuanpettydet_hargasatuan]"]').val();
			var qty  = $(this).find('input[name$="[pengajuanpettydet_qty]"]').val();
			var subtotal = 0;

			if ($.isNumeric(harga) && $.isNumeric(qty)){
				total += parseInt(harga) * parseInt(qty);
				subtotal = parseInt(harga) * parseInt(qty);
			}

			$(this).find('input[name$="[pengajuanpettydet_subtotal]"]').val(subtotal);
		}); 	
		$("#<?php echo CHtml::activeId($model, 'pengajuanpetty_total') ?>").val(total);            
		formatNumberSemua();
	}           

	/**
	 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @param {type} caraPrint
	 * @returns {undefined}
	 * - digunakan untuk mencetak
	 */
	function print(caraPrint){
		var pengajuanpetty_id = '<?php echo isset($_GET['pengajuanpetty_id']) ? $_GET['pengajuanpetty_id'] : null ?>';
		window.open('<?php echo $this->createUrl('print'); ?>&pengajuanpetty_id='+pengajuanpetty_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640,scrollbars=1');
	}
	
	/**
	 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @param {type} caraPrint
	 * @returns {undefined}
	 * - digunakan menfilter antara direktur atau kabid yanmed yang akan ditampilkan berdasarkan kategorinya	 
	 */
		
	function cekKategori(obj){
		var kategori = $(obj).val();
		
		if (kategori == '<?php echo Params::KATEGORI_PETTYCASH_MEDIS ?>'){
			$("#form-kabidyanmed").show();
			$("#form-direktur").hide();
			
			$("#<?php echo CHtml::activeId($model, 'accdirektur_id') ?>").val('');
			$("#<?php echo CHtml::activeId($model, 'accdirektur_nama') ?>").val('');
			$("#<?php echo CHtml::activeId($model, 'accdirektur_id') ?>").removeClass('required error');
			$("#<?php echo CHtml::activeId($model, 'accdirektur_nama') ?>").removeClass('required error');
			
			$("#<?php echo CHtml::activeId($model, 'kabidyanmed_id') ?>").addClass('required');
			$("#<?php echo CHtml::activeId($model, 'kabidyanmed_nama') ?>").addClass('required');
		}else{
			$("#form-kabidyanmed").hide();
			$("#form-direktur").show();
			
			$("#<?php echo CHtml::activeId($model, 'kabidyanmed_id') ?>").val('');
			$("#<?php echo CHtml::activeId($model, 'kabidyanmed_nama') ?>").val('');
			$("#<?php echo CHtml::activeId($model, 'kabidyanmed_id') ?>").removeClass('required error');
			$("#<?php echo CHtml::activeId($model, 'kabidyanmed_nama') ?>").removeClass('required error');
			
			$("#<?php echo CHtml::activeId($model, 'accdirektur_id') ?>").addClass('required');
			$("#<?php echo CHtml::activeId($model, 'accdirektur_nama') ?>").addClass('required');
		}
	}
	
	$(document).ready(function(){
//		cekKategori($("#<?php // echo CHtml::activeId($model, 'pengajuanpetty_kategori') ?>"));
	});
</script>