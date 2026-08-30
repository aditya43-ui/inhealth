<script type="text/javascript">
	function getRuangan(){
        var value = $('#<?php echo CHtml::activeId($modPengiriman, 'instalasi_id'); ?>').val();
        var pilih = '';
        if (jQuery.isNumeric(value)){
            $.post('<?php echo $this->createUrl('getRuanganPasien'); ?>', {instalasi_id:value}, function(data){
                if (data.total > 1){
                    pilih = '<option value="">-- Pilih --</option>';
                }else if(data.total == 0)
                {
                    pilih = '<option value="">-- Pilih --</option>';
                }
                $('#<?php echo CHtml::activeId($modPengiriman, 'ruangan_id'); ?>').html(pilih+data.dropDown);
            }, 'json');
        }
        else{
            
        }
    }
	
    function setUrutan(){
        noUrut = 0;
        $('.cekList').each(function(){
            $(this).parent().parent().find('input[name*="[cekList]"]').attr('name','Dokumen'+'['+noUrut+'][cekList]');
            $(this).parent().parent().find('input[name*="[dokrekammedis_id]"]').attr('name','Dokumen'+'['+noUrut+'][dokrekammedis_id]');
            $(this).parent().parent().find('input[name*="[pasien_id]"]').attr('name','Dokumen'+'['+noUrut+'][pasien_id]');
            $(this).parent().parent().find('input[name*="[pendaftaran_id]"]').attr('name','Dokumen'+'['+noUrut+'][pendaftaran_id]');
            $(this).parent().parent().find('input[name*="[ruangan_id]"]').attr('name','Dokumen'+'['+noUrut+'][ruangan_id]');
            $(this).parent().parent().find('input[name*="[peminjamanrm_id]"]').attr('name','Dokumen'+'['+noUrut+'][peminjamanrm_id]');
            $(this).parent().parent().find('select[name*="[warnadokrm_id]"]').attr('name','Dokumen'+'['+noUrut+'][warnadokrm_id]');
            $(this).parent().parent().find('input[name*="[kelengkapan]"]').attr('name','Dokumen'+'['+noUrut+'][kelengkapan]');
            $(this).parent().parent().find('input[name*="[printpengiriman]"]').attr('name','Dokumen'+'['+noUrut+'][printpengiriman]');
			
            $(this).parent().parent().find('input[name*="[cekList]"]').attr('id','Dokumen'+'_'+noUrut+'_[cekList]');
            $(this).parent().parent().find('input[name*="[dokrekammedis_id]"]').attr('id','Dokumen'+'_'+noUrut+'_[dokrekammedis_id]');
            $(this).parent().parent().find('input[name*="[pasien_id]"]').attr('id','Dokumen'+'_'+noUrut+'_[pasien_id]');
            $(this).parent().parent().find('input[name*="[pendaftaran_id]"]').attr('id','Dokumen'+'_'+noUrut+'_[pendaftaran_id]');
            $(this).parent().parent().find('input[name*="[ruangan_id]"]').attr('id','Dokumen'+'_'+noUrut+'_[ruangan_id]');
            $(this).parent().parent().find('input[name*="[peminjamanrm_id]"]').attr('id','Dokumen'+'_'+noUrut+'_[peminjamanrm_id]');
            $(this).parent().parent().find('select[name*="[warnadokrm_id]"]').attr('id','Dokumen'+'_'+noUrut+'_[warnadokrm_id]');
            $(this).parent().parent().find('input[name*="[kelengkapan]"]').attr('id','Dokumen'+'_'+noUrut+'_[kelengkapan]');
            $(this).parent().parent().find('input[name*="[printpengiriman]"]').attr('id','Dokumen'+'_'+noUrut+'_[printpengiriman]');
//            $(this).attr('id','rows['+noUrut+']');
           noUrut++;
        });
    }
    
    function setLengkap(){
        noUrut = 0;
        $('.lengkap').each(function(){
           $(this).attr('name','Dokumen['+noUrut+'][kelengkapan]');
           noUrut++;
        });
    }
	
	function cekInputan(){
		if(requiredCheck($("form"))){
			var kosong=0;
			var jumlah=0;
			
			$('.cekList').each(function(){
				if ($(this).is(':checked')){
					var warnadokumen = $(this).parents("tr").find('select[name*="[warnadokrm_id]"]').val();
					if(warnadokumen == ''){
						kosong++;
					}
					jumlah++;
				}            
			});
			
			if(kosong > 0 || jumlah < 1){
				if(jumlah < 1){
					myAlert('Silakan pilih dokumen terlebih dahulu!');
					return false;
				}else{
					myAlert('Isi Warna Dokumen Rekam Medis');
					return false;
				}				
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
        var ids = '<?php echo implode(',',isset($_GET['ids']) ? $_GET['ids'] : [])?>';

		window.open("<?php echo $this->createUrl('print'); ?>/"+$('#rkdokumenpasienrmlama-v-search').serialize()+"&caraPrint="+caraPrint+"&ids="+ids,"",'location=_new, width=900px');
	}
	setUrutan();
        
        function pilihSemua(obj) {
            if ($(obj).is(":checked")) {
                $(".cekList").prop("checked", true);
            } else {
                $(".cekList").prop("checked", false);
            }
            setUrutan();
            setLengkap();
        }
</script>