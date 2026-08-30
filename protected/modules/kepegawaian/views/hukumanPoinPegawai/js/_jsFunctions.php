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
		var poinpegdet_id = $(obj).parents("tr").find("input[name$='[poinpegdet_id]']").val();
		
		var r = confirm("Apakah Anda yakin ingin menghapus data ini?");
		if(r == true){			
			$(obj).parents('tr').detach();
			renameInputRow($("#table-lookup"));																				
		}else{
			return false;
		}
	}
	

	function tambahLookup(){
		var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'form._formItems',array('model'=>$modDet, 'i'=>0),true));?>'
		$('#table-lookup').append(row);
		renameInputRow($("#table-lookup"));
		$("#table-lookup tr:last .integer").maskMoney(
	        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0}
	    );
	}
        
        function cekSubmit(obj){
            var tr = $("#table-lookup").find('tbody tr');
            var vPoin = true;
            var vNilai = true;
            
            if (tr.length == 0){
                myAlert("Maaf, Data pada Tabel Hukuman Poin belum diisi");
                return false;
            }else{
                tr.each(function(){
                  if ($(this).find(".poin").val() == '')  {
                      $(this).find(".poin").attr("style","border:1px solid red");
                      vPoin = false;                     
                  }else{
                      $(this).find(".poin").attr("style","");
                      vPoin = true;
                  }
                  
                  if ($(this).find(".nilai").val() == '')  {
                      $(this).find(".nilai").attr("style","border:1px solid red");
                      vNilai = false;
                  }else{
                      $(this).find(".nilai").attr("style","");
                      vNilai = true;
                  }
                });
                
                
                if (vNilai == false && vPoin == false){
                    myAlert("Maaf, data Nilai atau Poin pada tabel hukuman poin tidak boleh kosong!");
                    return false;
                }else{
                    return requiredCheck(obj);
                }
                                
            }
        }
        
        function hitungTot(){
            var total = 0;            

            $('#table-lookup tbody > tr').each(function(){						  
                var poin  = $(this).find('input[name$="[poinpegdet_poin]"]').val();
                
                if ($.isNumeric(poin)){
                    total += parseInt(poin);
                }
                

            }); 	
            $("#<?php echo CHtml::activeId($model, 'poinpegawai_totpoin') ?>").val(total);            
            
        }
        
        function cekTglHukum(){
            var pegawai_id = $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val();
            var tgl= $("#<?php echo CHtml::activeId($model, 'poinpegawai_tgl') ?>").val();
            
           $.ajax({
                    type:'POST',
                    url: '<?php echo $this->createUrl('cekDataHukum') ?>',					
                    dataType: "json",
                    data: {pegawai_id:pegawai_id, tgl:tgl},
                    success: function(data){
                            if (data.sukses == 1){	                               
                                    myAlert(data.pesan);
                                    //$('#table-lookup tbody').remove();                                                                        
                            }else{
                                if (data.sukses == 0){
                                    myAlert(data.pesan);
                                }else{
                                     tambahLookup();
                                }
                            }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 					
                            console.log(errorThrown);
                    }
            });
        }
        
        function resetTgl(obj){
            var tgl= $("#tempTgl");
        
            myConfirm("Apakah Anda yakin, ingin berpindah tanggal ? karena data pada tabel hukuman poin akan dikosongkan","Perhatian!",function(r){
                if (r){
                    $('#table-lookup tbody').remove();      
                    tgl.val($(obj).val());
                }else{
                    $(obj).val(tgl.val());
                }
            });
        
            
        }
        
        function getPoin(obj){
            var cek = $(obj);
            var poin = cek.children(':selected').text();
            var get = poin.split(' - ');
            var tr = $("#table-lookup").find('tbody > tr');
            var vCek = false;
            var i = 0;
            if (tr.length > 1){
                tr.each(function(){         
                if (cek.val() != ''){
                    if ( cek.val() == $(this).find('.nilai').val()){
                        $(this).find('.nilai').attr('style','border: 1px solid red');
                        //$(this).find('.nilai').attr('style','');                        
                        i++;
                    }else{
                        $(this).find('.nilai').attr('style','');                        
                        vCek = false;
                     // //  $(this).find('.nilai').attr('style','border: 1px solid red');
                    }
                }
                });
            }
            
            if (i  > 1){
                myAlert("Maaf, Nilai Poin <b>"+poin+"</b> sudah ditambahkan");
                cek.parents("tr").find(".nilai").val('');
                cek.parents("tr").find(".nilai").attr('style','');  
            }else{
                cek.parents("tr").find("input[name$='[poinpegdet_poin]']").val(get[1]);
                cek.parents("tr").find(".nilai").attr('style','');  
                hitungTot();
            }
        }
</script>