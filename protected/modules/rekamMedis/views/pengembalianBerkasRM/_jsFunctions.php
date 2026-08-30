<script>
    function setUrutan(obj){        
        $('.cekList').each(function(){
			if($(this).is(':checked')){
				$(this).attr('checked',true);
				$(this).val(1);
			}else{
				$(this).removeAttr('checked',true);
				$(this).val(0);
			}			
        });	
		renameInputRow();
    }
    
    function setLengkap(obj){
        noUrut = 0;
        $('.lengkap').each(function(){
			if($(this).is(':checked')){
				$(this).attr('checked',true);
				$(this).val(1);
			}else{
				$(this).removeAttr('checked',true);
				$(this).val(0);
			}
           noUrut++;
        });
    }
    
	function renameInputRow(){
		var row = 0;
		$('.no_urut').each(function(){
			$(this).parents('tr').find('[name*="KembalirmT"]').each(function(){
				var input = $(this).attr('name');
				var data = input.split('KembalirmT[0]');
				if (typeof data[1] === 'undefined'){} else{
					$(this).attr('name','KembalirmT['+row+']'+data[1]);
					$(this).attr('id','KembalirmT['+row+']'+data[1]);
				}
			});
			row++;
		});
	}
	
	function cekInputan(){
		if(requiredCheck($("form"))){
			var jumlah = 0;
            var lokasiRak = 0;
            var subRak = 0;
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    jumlah++;
                }
                if ($(this).parents('tr').find('.lokasiRak').val() == ''){
                    lokasiRak++;
                }
                if ($(this).parents('tr').find('.subRak').val() != ''){
                    subRak++;
                }
            });
			
			
			
            if (jumlah < 1){
                myAlert('Silakan pilih dokumen yang akan dikirim!');
                return false;
            }
            else if (lokasiRak > 0){
                myAlert('Isi Lokasi Rak pada dokumen yang dipilih!');
                return false;
            }
            else if (subRak < 1){
                myAlert('Isi Sub Rak pada dokumen yang dipilih!');
                return false;
            }else{
				$('#rkkembalirm-t-form').submit();
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
	
	function PrintDokumen(obj){
     parent = $(obj).parents("tr");
      if ($("#print").is(":checked")) {
           var dokrekammedis_id = parent.find("#dokrekammedis_id").val();
           alert(dokrekammedis_id);
        }else{
        
        }
        
    }
	
	/**
	* untuk print dokumen rekam medis
	 */
	function print(id,caraPrint)
	{
		var id = id;
		window.open('<?php echo $this->createUrl('printDokumen'); ?>&dokrekammedis_id='+id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');		
	}
</script>
