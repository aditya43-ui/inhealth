<script>
 function tambahKantong() {
     stokkantongdarah_id = $('#stokkantongdarah_id').val();
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getKantong'); ?>',
        data: {stokkantongdarah_id:stokkantongdarah_id},
        dataType: "json",
        success:function(data){
            $('#table-detailbarang > tbody').append(data);
            $('#table-detailbarang').removeClass("animation-loading");
            renameInputRowBarang($("#table-detailbarang"));
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }
    
    function inputKantong(){
     stokkantongdarah_id = $('#stokkantongdarah_id').val();
	if (!jQuery.isNumeric(stokkantongdarah_id)){
		myAlert('Isi Kantong yang akan dipesan');
		return false;
	}
	else{
		$('#table-detailbarang').addClass("animation-loading");
		cekList(stokkantongdarah_id);
	}        
    }
    
    function cekList(id){
	x = true;
	$('.kantongdarah').each(function(){
		if ($(this).val() == id){
			myAlert('Kantong telah ada d List');
			x = false;
                        $('#table-detailbarang').removeClass("animation-loading");    
		}else{

		}
	});

	if(x==true){
                    tambahKantong();
	return x;
        }
    }   
    function renameInputRowBarang(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).attr('data-row',row);
        $(this).find('span').each(function(){ //element <input>
            if (typeof  $(this).attr("name") !== 'undefined' ){
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");            
                if(old_name_arr.length == 3){
                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                }
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
    });
    }
    
    function batal(obj){
	if(!confirm('Apakah Anda akan membatalkan data ini ?')) {
	return false;
	}else{
	$(obj).parents('tr').remove();
	rename();
	}
    }    
    
    function getDataPermintaan(permintaandarah_id) {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getDataPermintaan'); ?>',
            data:{permintaandarah_id:permintaandarah_id},
            dataType:"json",
            success:function(data) {
                $('#tgl_pendaftaran').val(data.tgl_pendaftaran);
                $('#no_pendaftaran').val(data.no_pendaftaran);
                $('#umur').val(data.umur);
                $('#alamat_pasien').val(data.alamat_pasien);
                $('#nama-pasien').val(data.nama_pasien);
                $('#tgl_lahir').val(data.tanggal_lahir);
                $('#no_rekam_medik').val(data.no_rekam_medik);
                $('#jenis_kelamin').val(data.jeniskelamin);                
                $('#gol_darah_hide').val(data.gol_darah_hide);
                $('#gol_darah').val(data.gol_darah);
                $('#BDUjidarahpasienT_pasien_id').val(data.pasien_id);
                $('#BDUjidarahpasienT_pendaftaran_id').val(data.pendaftaran_id);
                $('#BDUjidarahpasienT_permintaandarah_id').val(data.permintaandarah_id);
                $('#ruangan_nama').val(data.ruangan_nama);
                $('#kelas_pelayanan').val(data.kelaspelayanan_nama);
                $('#penjamin').val(data.penjamin_nama);
                $('#Dokter').val(data.nama_pegawai);
                $('#tgl_pengujian').val(data.tgl_pengujian); 
                $('#anti_a').val(data.anti_a);
                $('#anti_b').val(data.anti_b);
                $('#anti_d').val(data.anti_d);
                $('#kesimpulan').val(data.kesimpulan);
                $('#diagnosis').val(data.diagnosis);
                
                $('#table-detailbarang > tbody').html(data.tr);                
                if (data.tube != ''){
                    $("#form-pemeriksaan-goldarah-tubetest").html(data.tube);
                }
                renameInputRowBarang($("#table-detailbarang"));        
                
                $('#table-detailbarang > tbody > tr').each(function(){                                        
                    cekKomponen($(this));                    
                });
                
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}

        })
    }
    function cariGolongan() {
    $("#no_kantongdarah").removeClass('animation-loading-1');
        setTimeout(function(){          
            $("#no_kantongdarah").removeClass('animation-loading-1');
            golongandarah = $('#gol_darah_hide').val();
            $.fn.yiiGridView.update('kantong-m-grid', {
                data: {
//                           "BDInfostokkantongdarahV[gol_darah]":golongandarah,			
                    }
            });
            },500);
    }
    
    /**
    * digunakan untuk table detail 
    */
    var row_no = 0;
    function setDialog(obj) {
        setKantongDarah(obj);
        row_no = $(obj).parents("tr").data('row');
        $("#no_row").val(parseInt(row_no));  
        $("#nama_komponen").val($(obj).parents("tr").find('.singkatan_komp').val());  
        $("#dialogKantongDarah").dialog("open");
    }
    
    function setKantong(data) {
        var row_no = $("#no_row").val();

        $("#table-detailbarang tbody tr").each(function() {
            var caristokkantong = $(this).find(".stokkantongdarah_id").val();
            var stokkantong = data.stokkantongdarah_id;
            if(stokkantong != caristokkantong) {
                if ($(this).data('row') == row_no) {
                        $(this).find("#no_kantongdarah").val(data.no_kantongdarah);
                        getKantong($(this).find(".nomorbarcode"), data);                                
                    }
            }else{
                    myAlert('Kantong darah sudah dipilih !!');
                    return false;
            }
        });    
    }
    
    /**
    * digunakan untuk set dialog kantong darah berdasarkan singkatan komponen
    **/
    function setKantongDarah(obj) {        
        var singkatan_komp_tampung = $(obj).parents("tr").find('.singkatan_komp').val();                
        $("#note-stok").html("");
        
        setTimeout(function(){          
        
                $.fn.yiiGridView.update('kantong-m-grid', {
                    data: {
                           "BDInfostokkantongdarahV[singkatan_komp]":singkatan_komp_tampung,			
                    }
                });                                   
        },200);                   
    }

    function cekStok(){
        var tr = $("#kantong-m-grid > table > tbody > tr").length;    
        var komp = $("#nama_komponen").val()
                
        if (tr == 0){
            $("#note-stok").html("Stok Kantong untuk komponen <b>"+komp+"</b> tidak ada ");
        }else if(tr == 1){
            var ket = $("#kantong-m-grid > table > tbody > tr > td > span").html();
            
            if (ket == 'Tidak ditemukan hasil.'){
                $("#note-stok").html("Stok Kantong untuk komponen <b>"+komp+"</b> tidak ada ");
            }            
        }
    }
    
    function setGrouping(obj,ini){
        var count = 0;
        var no_row = '';
        var anti_a = '';
        var anti_b = '';
        var anti_ab = '';
        var anti_d = '';        
        
        if ($(obj).prop("checked") == true){
            $("#table-detailbarang > tbody > tr").each(function(){
                if ($(this).find('.sel_group').attr("disabled") != 'disabled'){                    
                    if (count == 0){
                        anti_a = $(this).find('.anti_a').val();
                        anti_b = $(this).find('.anti_b').val();
                        anti_ab = $(this).find('.anti_ab').val();
                        anti_d = $(this).find('.anti_d').val();                        
                        no_row = $(this).attr('data-row');
                        
                        count++;
                    }else{                              
                        if (no_row == $(ini).parents("tr").attr('data-row')){
                            $(this).find('.anti_a').val(anti_a);
                            $(this).find('.anti_b').val(anti_b);
                            $(this).find('.anti_ab').val(anti_ab);
                            $(this).find('.anti_d').val(anti_d);
                        }else{
                            if (typeof ini === 'undefined'){
                                $(this).find('.anti_a').val(anti_a);
                                $(this).find('.anti_b').val(anti_b);
                                $(this).find('.anti_ab').val(anti_ab);
                                $(this).find('.anti_d').val(anti_d);
                            }
                        }
                    }                                
                }
            });
        }
    }
    
    function setTyping(obj,ini){
        var count = 0;
        var sel_a = '';
        var sel_b = '';
        var sel_o = '';
        var no_row = '';        
        if ($(obj).prop("checked") == true){
            $("#table-detailbarang > tbody > tr").each(function(){
                if ($(this).find('.serum_typing').attr("disabled") != 'disabled'){
                    if (count == 0){
                        sel_a = $(this).find('.sel_a').val();
                        sel_b = $(this).find('.sel_b').val();
                        sel_o = $(this).find('.sel_o').val();    
                        no_row = $(this).attr('data-row');

                        count++;
                    }else{                                                
                        if (no_row == $(ini).parents("tr").attr('data-row')){
                            $(this).find('.sel_a').val(sel_a);
                            $(this).find('.sel_b').val(sel_b);
                            $(this).find('.sel_o').val(sel_o);                    
                        }else{
                            if (typeof ini === 'undefined'){
                                $(this).find('.sel_a').val(sel_a);
                                $(this).find('.sel_b').val(sel_b);
                                $(this).find('.sel_o').val(sel_o);                    
                            }
                        }
                        
                    }                                
                }
            });
        }
    }
    
    function setAutoKontrol(obj,ini){
        var count = 0;
        var ujikomp_autokontrol = '';
         var no_row = '';  
         
        if ($(obj).prop("checked") == true){
            $("#table-detailbarang > tbody > tr").each(function(){                
                if (count == 0){
                    ujikomp_autokontrol = $(this).find('.ujikomp_autokontrol').val();   
                    no_row = $(this).attr('data-row');
                                        
                    count++;
                }else{                                                
                    if (no_row == $(ini).parents("tr").attr('data-row')){
                        $(this).find('.ujikomp_autokontrol').val(ujikomp_autokontrol);                                      
                    }else{
                        if (typeof ini === 'undefined'){
                            $(this).find('.ujikomp_autokontrol').val(ujikomp_autokontrol);                            
                        }
                    }
                }                                                
            });
        }        
    }

    function getKantong(obj, data) {   
        $(obj).parents("tr").find(".nomorbarcode").val(data.nomorbarcode);
        hasil =  $(obj).parents("tr").find(".singkatan_komp").val();
        if(hasil == '') {
            $(obj).parents("tr").find(".singkatan_komp").val(data.singkatan_komp);            
            cekKomponen($(obj).parents("tr"));                            
        }
        $(obj).parents("tr").find(".stokkantongdarah_id").val(data.stokkantongdarah_id);
    }
    <?php
     $modPengujianDarah = new BDPengujiandarahT();
     $modUjiKompatibilitas = new BDUjikompatibilitasT();
    ?>
    var row = <?php echo CJSON::encode(array('html'=>$this->renderPartial('ajaxLoadAset', array('modPengujianDarah'=>$modPengujianDarah,'modUjiKompatibilitas'=>$modUjiKompatibilitas), true))); ?>;
function tambahRowBarang(obj) {
    var last = "";
    if (obj != null) {
        $(obj).parents("tr").after(row.html);
        renameInputRowBarang($("#table-detailbarang"));        
        last = $("#table-detailbarang tbody tr").eq($(obj).parents("tr").index() + 1);
                
        setAutoKontrol($("#autoKontrol"));
        //console.log($(obj).parents("tr").index());
    } else {
        $("#table-detailbarang tbody").append(row.html);
        renameInputRowBarang($("#table-detailbarang"));
        last = $("#table-detailbarang tbody tr:last-child");
    }
    
    cekKomponen(last);    
    
    jQuery(last).find('.no_kantongdarah').autocomplete(
        {
            'showAnim':'fold',
            'minLength':3,
            'focus':function(event, ui )
            {
                $(this).val( ui.item.label);
            },
            'select':function( event, ui )
            {
                $(this).parents("tr").find(".stokkantongdarah_id").val(ui.item.stokkantongdarah_id);
                getKantong($(this), ui.item);
                return false;
            },
            'source':function(request, response)
            {
                $.ajax({
                    url: "<?php echo $this->createUrl('ajaxGetPeralatan'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function (data) {
                        response(data);
                    }
                })
            }
        }
    );
        
}

    function renameInput() {
        var cnt = 0;
        $("#table-detailbarang tbody tr").each(function() {
        $(this).find(".stokkantongdarah_id").prop("name", "BDUjikompatibilitasT[" + cnt + "][stokkantongdarah_id]");
        $(this).find(".nomorbarcode").prop("name", "BDUjikompatibilitasT[" + cnt + "][nomorbarcode]");
        $(this).find(".rilis").prop("name", "BDUjikompatibilitasT[" + cnt + "][rilis]");
        $(this).find(".ujikomp_kesimpulan").prop("name", "BDUjikompatibilitasT[" + cnt + "][ujikomp_kesimpulan]");
        $(this).find(".ujikomp_dct").prop("name", "BDUjikompatibilitasT[" + cnt + "][ujikomp_dct]");
        $(this).find(".ujikomp_autokontrol").prop("name", "BDUjikompatibilitasT[" + cnt + "][ujikomp_autokontrol]");
        $(this).find(".ujikomp_minor").prop("name", "BDUjikompatibilitasT[" + cnt + "][ujikomp_minor]");
        $(this).find(".ujikomp_mayor").prop("name", "BDUjikompatibilitasT[" + cnt + "][ujikomp_mayor]");
        $(this).find(".permintaandarahdet_id").prop("name", "BDUjikompatibilitasT[" + cnt + "][permintaandarahdet_id]");
        $(this).find(".singkatan_komp").prop("name", "BDUjikompatibilitasT[" + cnt + "][singkatan_komp]");
        
        $(this).find(".anti_a").prop("name", "BDPengujiandarahT[" + cnt + "][anti_a]");
        $(this).find(".anti_b").prop("name", "BDPengujiandarahT[" + cnt + "][anti_b]");
        $(this).find(".anti_ab").prop("name", "BDPengujiandarahT[" + cnt + "][anti_ab]");
        $(this).find(".anti_d").prop("name", "BDPengujiandarahT[" + cnt + "][anti_d]");
        $(this).find(".sel_a").prop("name", "BDPengujiandarahT[" + cnt + "][sel_a]");
        $(this).find(".sel_b").prop("name", "BDPengujiandarahT[" + cnt + "][sel_b]");
        $(this).find(".sel_o").prop("name", "BDPengujiandarahT[" + cnt + "][sel_o]");
        $(this).find(".ket_hasiluji").prop("name", "BDPengujiandarahT[" + cnt + "][ket_hasiluji]");
        $(this).data('row', cnt);
        cnt++;
        });
    }   

    function batalRowBarang(obj) {
        $(obj).parents("tr").remove();
        renameInput();
    }
    
    function hasilKesimpulan(obj,metode,attr){        
        var anti_a = $(obj).parents(attr).find(".anti-a").find("input:radio:checked").attr('value');
        var anti_b = $(obj).parents(attr).find(".anti-b").find("input:radio:checked").attr('value');
        var anti_ab = $(obj).parents(attr).find(".anti-ab").find("input:radio:checked").attr('value');
        var anti_d = $(obj).parents(attr).find(".anti-d").find("input:radio:checked").attr('value');
        
        var sel_a = $(obj).parents(attr).find(".sel-a").find("input:radio:checked").attr('value');
        var sel_b = $(obj).parents(attr).find(".sel-b").find("input:radio:checked").attr('value');
        var sel_o = $(obj).parents(attr).find(".sel-o").find("input:radio:checked").attr('value');
        
        var metode_untuk = $(obj).parents(attr).attr('metode');   
                        
        var kesimpulan_slide = $("#kesimpulan").val();
        
        if (    typeof anti_a == 'undefined' || 
                typeof anti_b == 'undefined' || 
                typeof anti_d == 'undefined' || 
                typeof anti_ab == 'undefined' ||  
                typeof sel_a == 'undefined' || 
                typeof sel_b == 'undefined' || 
                typeof sel_o == 'undefined'){            
            return false;
        }

        if (anti_a != '' && anti_b != '' && anti_d != '' && anti_ab != '' && sel_a != '' && sel_b != '' && sel_o != ''){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hasilKesimpulan'); ?>',
                data: {anti_a:anti_a,anti_b:anti_b,anti_d:anti_d,anti_ab:anti_ab,sel_a:sel_a,sel_b:sel_b,sel_o:sel_o,metode:metode,metode_untuk:metode_untuk},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                        
                        var pesan = '';
                        $("#<?php echo CHtml::activeId($modUjiDarahPasien, 'kesimpulan_uji') ?>").val(data.kesimpulan);
                        
                        $(".pesantertulis").parents(".control-group").addClass("hide");
                        $(".pesantertulis").parents(".control-group").find('.pesantertulis').html('');
                                                
                        if (data.kesimpulan.toLowerCase() != kesimpulan_slide.toLowerCase()){                            
                            pesan += "1. Hasil pemeriksaan metode slide test dan tube test berbeda";                            
                        }
                        
                        if (data.kesimpulan.toLowerCase() == '<?php echo strtolower(Params::KESIMPULAN_GOLDARAH_TIDAK); ?>'){
                            if (pesan != ''){
                                pesan += '<br> 2. ';
                            }
                            pesan += 'Hasil kesimpulan diskrepansi, pasien harus melakukan konsultasi DPJP';
                        }
                        
                        if (pesan != ''){
                            $(".pesantertulis").parents(".control-group").removeClass("hide");
                            $(".pesantertulis").parents(".control-group").find('.pesantertulis').html(pesan);                                                                                                                
                        }
                        
                        setTimeout(function(){
                                $("#<?php echo CHtml::activeId($modUjiDarahPasien, 'kesimpulan_uji') ?>").blur();
                        },500);            
                    }else{
                        myAlert(data.pesan);
                    }
                    $("#form-kirimpesan").removeClass('animation-loading');
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            }); 
        }
    }
    
    function pengujianKompatibilitas(obj){        
        var anti_a = $(obj).parents("tr").find(".anti_a").val();
        var anti_b = $(obj).parents("tr").find(".anti_b").val();
        var anti_ab = $(obj).parents("tr").find(".anti_ab").val();
        var anti_d = $(obj).parents("tr").find(".anti_d").val();
        
        var sel_a = $(obj).parents("tr").find(".sel_a").val();
        var sel_b = $(obj).parents("tr").find(".sel_b").val();
        var sel_o = $(obj).parents("tr").find(".sel_o").val();

        var metode_untuk = 'komponen';

        var komp = $(obj).parents("tr").find(".singkatan_komp").val();
        
        var jenis = false;
         
        
        if (komp == '<?php echo Params::KOMPONEN_DARAH_PCR ?>' || komp == '<?php echo Params::KOMPONEN_DARAH_PRC ?>' || komp == '<?php echo Params::KOMPONEN_DARAH_WB ?>'){                            
            if (anti_a != '' && anti_b != '' && anti_d != '' && anti_ab != ''){
                jenis = true;
            }           
        }else if (komp == '<?php echo Params::KOMPONEN_DARAH_FFP ?>' || komp == '<?php echo Params::KOMPONEN_DARAH_TC ?>'){                            
            if(sel_a != '' && sel_b != '' && sel_o != ''){
                jenis = true;
            }
        }     
        
        if (jenis == true){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hasilKesimpulan'); ?>',
                data: {anti_a:anti_a,anti_b:anti_b,anti_d:anti_d,anti_ab:anti_ab,sel_a:sel_a,sel_b:sel_b,sel_o:sel_o,metode_untuk:metode_untuk},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                        
                        $(obj).parents("tr").find('.ket_hasiluji').val(data.kesimpulan);

                        setTimeout(function(){
                                $("#peg_pemeriksa_nama").blur();
                        },500)            
                    }else{
                        myAlert(data.pesan);
                    }
                    $("#form-kirimpesan").removeClass('animation-loading');
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            }); 
        }
        
    }
    
    function ujiSilang(obj){        
        var mayor = $(obj).parents("tr").find(".ujikomp_mayor").val();
        var minor = $(obj).parents("tr").find(".ujikomp_minor").val();
        var autocontrol = $(obj).parents("tr").find(".ujikomp_autokontrol").val();
        var dct = $(obj).parents("tr").find(".ujikomp_dct").val();                

        if (mayor != '' && minor != '' && autocontrol != ''){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hasilUjiKompatibilitas'); ?>',
                data: {mayor:mayor,minor:minor,autocontrol:autocontrol,dct:dct},
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){                        
                        $(obj).parents("tr").find('.ujikomp_kesimpulan').val(data.kesimpulan);
                        $(obj).parents("tr").find('.rilis').html(data.pilihan);
                        
                        setTimeout($("#peg_pemeriksa_nama").blur(),500);            
                    }else{
                        myAlert(data.pesan);
                    }
                    $("#form-kirimpesan").removeClass('animation-loading');
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            }); 
        }
    }
    
    function cekKomponen(obj){                
        var komp = $(obj).find(".singkatan_komp").val();                
        $(obj).find('.sel_group, .serum_typing').attr("disabled",true);
        $(obj).find('.sel_group, .serum_typing').addClass("required");

        if (komp == '<?php echo Params::KOMPONEN_DARAH_PCR ?>' || komp == '<?php echo Params::KOMPONEN_DARAH_PRC ?>' || komp == '<?php echo Params::KOMPONEN_DARAH_WB ?>'){                            
            $(obj).find('.sel_group').removeAttr("disabled");            
            $(obj).find('.serum_typing').removeClass("required");  
        }else if (komp == '<?php echo Params::KOMPONEN_DARAH_FFP ?>' || komp == '<?php echo Params::KOMPONEN_DARAH_TC ?>'){                            
            $(obj).find('.serum_typing').removeAttr("disabled");            
            $(obj).find('.sel_group').removeClass("required");  
        }                                               
    }
        
    $(document).ready(function(){                 
        $("#form-pemeriksaan-goldarah-tubetest").find('input:radio').click(function() {
            hasilKesimpulan(this,<?php echo Params::METODE_DARAH_ID_TUBE_TEST; ?>,'#form-pemeriksaan-goldarah-tubetest');                        
        });  
        
        <?php if (isset($_GET['permintaandarah_id'])){ ?>
                renameInputRowBarang($("#table-detailbarang"));
                $('#table-detailbarang > tbody > tr').each(function(){                                        
                    cekKomponen($(this));                    
                });
        <?php } ?>
    });
</script>
