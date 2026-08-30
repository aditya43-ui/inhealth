<script type="text/javascript">
    function setUrutan(){
        noUrut = 0;
        $('.cekList').each(function(){
           $(this).attr('name','cekList['+noUrut+']');
           noUrut++;
        });
    }
    
    function setLengkap(){
        noUrut = 0;
        $('.lengkap').each(function(){
           $(this).attr('name','Dokumen[kelengkapan]['+noUrut+']');
           noUrut++;
        });
    }
	
	function cekInputan(){
		if(requiredCheck($("form"))){
			var kosong=0;
			$('.cekList').each(function(){
				if ($(this).is(':checked')){
					var warnadokumen = $(this).parents("tr").find('select[name*="[warnadokrm_id]"]').val();
					if(warnadokumen == ''){
						kosong++;
					}
				}            
			});
			
			if(kosong > 0){
				myAlert('Isi Warna Dokumen Rekam Medis');
				return false;
			}else{
				$('#rkpengirimanrm-t-form').submit();
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
	
	function print(caraPrint)
	{
		window.open("<?php echo $this->createUrl('print'); ?>/"+$('#rkdokumenpasienrmlama-v-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
	}

	$(document).ready(function(){
        $('form#rkpengirimanrm-t-form').submit(function(){
            var jumlah = 0;
            $('.cekList').each(function(){
                if ($(this).is(':checked')){
                    jumlah++;
                }
            });
            if (jumlah < 1){
                myAlert('Silakan pilih dokumen yang akan dikirim!');
                return false;
            }
        });
    });

	//penambahan refresh pada data otomatis
	setInterval(   
		function(){
			$.fn.yiiGridView.update('informasipengiriman-t-grid', { 
			data: $(this).serialize()
			
		});
		return false;
		}, 
	60000  
	);
</script>