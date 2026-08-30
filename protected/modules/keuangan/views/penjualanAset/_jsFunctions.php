<script type="text/javascript">
	function maskMoneyAll()
    {
        $('#tblInputRekening tbody tr, #tblInputUraian tbody tr').each(function(){
            $(this).find(".integer2").maskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );            
        });
    }
    
    function unMaskMoneyAll()
    {
        $('#tblInputRekening tbody tr, #tblInputUraian tbody tr').each(function(){
            $(this).find(".integer2").unmaskMoney(
                {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
            );            
        });
    } 
    function ambilDataPenghapusan()
    {
        ambilDataPenghapusanBase("peralatan");
    }
	
	function ambilDataPenghapusanPeralatanNonMedis() {
		ambilDataPenghapusanBase("peralatan_non_medis");
	}
	
	function ambilDataPenghapusanGedung() {
		ambilDataPenghapusanBase("gedung");
	}
	
	function ambilDataPenghapusanTanah() {
		ambilDataPenghapusanBase("tanah");
	}
	
	function ambilDataPenghapusanKendaraan() {
		ambilDataPenghapusanBase("kendaraan");
	}
	
	function ambilDataPenghapusanBase(jenisInven)
    {
        $('#JenispengeluaranrekeningV_1_saldodebit').val(0);
        $('#JenispengeluaranrekeningV_2_saldokredit').val(0);
        
        var periode = $('.tglpenghapusan').val();
        $.post('<?php echo $this->createUrl('GetDataPenghapusan');?>', {periode:periode, jenis:jenisInven}, function(data){
				if(data !== null){
	                $("#tblInputUraian > tbody").empty();
					$("#tblInputUraian > tbody").append(data.replace());
				}
                hitungRekening();

                maskMoneyAll();
        }, 'json');
    }

    function checkAll()
    {
        if ($("#checkAllAset").is(":checked"))
        {
            var jumlah = 0;
            var hargabeli = 0;
            var untung = 0;
            var rugi = 0;
            var penyusutan = 0;
            $('#tblInputUraian input[name*="is_checked"]').each(
                function(){
                    $(this).attr('checked',true);
                    $(this).val(1);
                    
                }
            );
            hitungRekening();
        } else {
            $('#tblInputUraian input[name*="is_checked"]').each(
                function(){
                    $(this).removeAttr('checked');
                    $(this).val(0);
                }
            );
            $('#JenispengeluaranrekeningV_0_saldodebit').val(0);
            $('#JenispengeluaranrekeningV_0_saldokredit').val(0);
            $('#JenispengeluaranrekeningV_1_saldodebit').val(0);
            $('#JenispengeluaranrekeningV_1_saldokredit').val(0);
            $('#JenispengeluaranrekeningV_2_saldodebit').val(0);
            $('#JenispengeluaranrekeningV_2_saldokredit').val(0);
            $('#JenispengeluaranrekeningV_3_saldodebit').val(0);
            $('#JenispengeluaranrekeningV_3_saldokredit').val(0);
            $('#JenispengeluaranrekeningV_4_saldodebit').val(0);
            $('#JenispengeluaranrekeningV_4_saldokredit').val(0);
        }
    }

    function checkRekening(obj)
    {
        var index = $(obj).parents("tr").find("input[name$='[invperalatan_id]']").val();  
        if($(obj).is(":checked"))
        {    
            $('#tblInputUraian').find('input[name$="[invperalatan_id]"][value="'+ index +'"]').each(
                function(){
                    $(obj).parents("tr").find("input[name$='[is_checked]']").attr('checked',true);
                    $(obj).parents("tr").find("input[name$='[is_checked]']").val(1);
                }
            );
        }else{
            $('#tblInputUraian').find('input[name$="[invperalatan_id]"][value="'+ index +'"]').each(
                function(){
                    $(obj).parents("tr").find("input[name$='[is_checked]']").attr('checked',false);
                    $(obj).parents("tr").find("input[name$='[is_checked]']").val(0);
                }
            );            
        }
        hitungRekening();

    }

    function hitungRekening()
    {
        var jumlah = 0;
        var hargabeli = 0;
        var untung = 0;
        var rugi = 0;
        var penyusutan = 0;
        $('#tblInputUraian input[name*="is_checked"]').each(
            function(){
                var ceklis = $(this).parents("tr").find("input[name$='[is_checked]']").val();

                if(ceklis=="1"){
                    var a = $(this).parents("tr").find("input[name$='[hargajualaktiva]']").val();
                    jumlah = parseFloat(jumlah) + parseFloat(a);

                    var hb = $(this).parents("tr").find("input[name$='[invperalatan_harga]']").val();
                    hargabeli = parseFloat(hargabeli) + parseFloat(hb);

                    var kerugian = $(this).parents("tr").find("input[name$='[kerugian]']").val();
                    rugi = parseFloat(rugi) + (parseFloat(kerugian)*-1);

                    var keuntungan = $(this).parents("tr").find("input[name$='[keuntungan]']").val();
                    untung = parseFloat(untung) + parseFloat(keuntungan);

                    var susut = $(this).parents("tr").find("input[name$='[invperalatan_akumsusut]']").val();
                    penyusutan = parseFloat(penyusutan) + parseFloat(susut);
                }
            }
        );
        var laba = parseFloat(jumlah) + parseFloat(penyusutan) - parseFloat(hargabeli);
        if(laba>=0){
            untung = laba;
            rugi = 0;
            $('#JenispengeluaranrekeningV_4_saldokredit').val(untung);
            $('#JenispengeluaranrekeningV_2_saldodebit').val(rugi);
        }else{
            untung = 0;
            rugi = laba*-1;
            $('#JenispengeluaranrekeningV_4_saldokredit').val(untung);
            $('#JenispengeluaranrekeningV_2_saldodebit').val(rugi);
        }
        $('#JenispengeluaranrekeningV_0_saldodebit').val(jumlah);
        $('#JenispengeluaranrekeningV_1_saldodebit').val(penyusutan);
        $('#JenispengeluaranrekeningV_3_saldokredit').val(hargabeli);
    }
	
	function cekSimpanGedung(){
		if(requiredCheck($("form"))){
			var jmltr = $('#tblInputUraian tbody tr').length;
			if(jmltr > 0){
				disableOnSubmit('.btn-primary');
				$('#akpenjualanaset-t-form').submit();
			}else{
				myAlert('Tabel gedung dan Bangunan tidak boleh kosong');
			}
		}
	}
	
        function cekSimpanPeralatanMedis(){
		if(requiredCheck($("form"))){
			var jmltr = 0;
			$('#tblInputUraian tbody tr').find('input[name*="invperalatan_id"]').each(function(){ jmltr++; });
			if(jmltr > 0){
				disableOnSubmit('.btn-primary');
				$('#akpenjualanaset-t-form').submit();
			}else{
				myAlert('Tabel Peralatan Medis tidak boleh kosong');
			}
		}
	}
        
	function cekSimpanPeralatanNonMedis(){
		if(requiredCheck($("form"))){
			var jmltr = 0;
			$('#tblInputUraian tbody tr').find('input[name*="invperalatan_id"]').each(function(){ jmltr++; });
			if(jmltr > 0){
				disableOnSubmit('.btn-primary');
				$('#akpenjualanaset-t-form').submit();
			}else{
				myAlert('Tabel Peralatan Non-Medis tidak boleh kosong');
			}
		}
	}
	
	function cekSimpanKendaraan(){
		if(requiredCheck($("form"))){
			var jmltr = 0;
			$('#tblInputUraian tbody tr').find('input[name*="invperalatan_id"]').each(function(){ jmltr++; });
			if(jmltr > 0){
				disableOnSubmit('.btn-primary');
				$('#akpenjualanaset-t-form').submit();
			}else{
				myAlert('Tabel Kendaraan tidak boleh kosong');
			}
		}
	}
	
	function cekSimpanTanah(){
		if(requiredCheck($("form"))){
			var jmltr = 0;
			jmltr = $('#tblInputUraian tbody tr').length;
			if(jmltr > 0){
				disableOnSubmit('.btn-primary');
				$('#akpenjualanaset-t-form').submit();
			}else{
				myAlert('Tabel Tanah tidak boleh kosong');
			}
		}
	}
	
</script>