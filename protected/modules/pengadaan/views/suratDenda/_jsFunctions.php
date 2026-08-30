<script type='text/javascript'>
    /**
     * Fungsi cek form
     * @returns {Boolean}
     */
    function cekForm(){                                          
        if (requiredCheck($("#notadinasppk-t-form"))){
            
            $('#notadinasppk-t-form').submit();
            disableOnSubmit($("#btn_submit"));
        }

       return false;
    }        
        
    /**
     * Membuka dialog
     * @param {type} jenis
     * @param {type} dlg
     * @returns {undefined}
     */
    function setDialog(jenis,dlg){        
        $("#jenisdialog").val(jenis);
        
        if (jenis == 'ketuapphp'){
            $(".judul-dialog-petugas").html('Ketua PPHP/PjPHP');
        }
        
        $("#"+dlg).dialog('open');
    }
    
    /**
     * Set data pegawai
     * @param {type} data
     * @param {type} jenis
     * @returns {undefined}
     */
    function setPegawai(data,jenis){            
        if (typeof jenis === 'undefined'){
            var jenis = $("#jenisdialog").val();
        }
        
        if (jenis == 'ketuapphp'){
            $("#<?php echo CHtml::activeId($model, 'ketuapphp_id') ?>").val(data.pegawai_id);
            $("#<?php echo CHtml::activeId($model, 'ketuapphp_nama') ?>").val(data.namaLengkap);            
        }
        
        $("#dialogPetugas").dialog('close');
    }
      
    /**
     * Load data rincian
     * @param {type} suratperjanjiankerja_id
     * @param {type} suratdenda_id
     * @returns {undefined}     
     */
    function loadRincian(suratperjanjiankerja_id, suratdenda_id){            
        $(".formbarangjasa").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadRincian'); ?>',
            data:{                
                suratperjanjiankerja_id:suratperjanjiankerja_id,
                suratdenda_id:suratdenda_id
            },
            dataType:"json",
            success:function(data) {
                if (data.sukses == 1){                   
                    $("#rincian-surat-denda > tbody ").html(data.tr);                    
                }else{
                    window.parent.toastr.error(data.pesan);
                }
                $(".formbarangjasa").removeClass("animation-loading");
                
                renameInputRow($('#rincian-surat-denda'));            
                genExt();
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                 console.log(errorThrown);
            }
        });                   
    }
    
    /**
     * Load data detail rincian
     * @param {type} suratperjanjiankerja_id
     * @param {type} suratdenda_id
     * @returns {undefined}     
     */
    function loadDetailRincian(suratperjanjiankerja_id, suratdenda_id){            
        $(".formbarangjasa").addClass("animation-loading");
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadDetailRincian'); ?>',
            data:{                
                suratperjanjiankerja_id:suratperjanjiankerja_id,
                suratdenda_id:suratdenda_id
            },
            dataType:"json",
            success:function(data) {
                if (data.sukses == 1){                   
                    $("#rincian-surat-denda > tbody ").html(data.tr);                    
                }else{
                    window.parent.toastr.error(data.pesan);
                }
                $(".formbarangjasa").removeClass("animation-loading");
                
                renameInputRow($('#rincian-surat-denda'));            
                genExt();
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                 console.log(errorThrown);
            }
        });                   
    }
    
    /**
     * Rename input
     * @param {type} obj_table
     * @returns {undefined}     
     */
    function renameInputRow(obj_table){
        var row = 0;    
        var count = $(obj_table).find('tbody > tr').length;
        $(obj_table).find('tbody > tr').each(function(){        
            $(this).attr('no-row',row);
            $(this).find('.nourut').html(row+1);
            $(this).find('input,select,textarea').each(function(){ //element <input>
                    var old_name = $(this).attr("name").replace(/]/g,"");
                    var old_name_arr = old_name.split("[");
                    if(old_name_arr.length == 3){
                            $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                            $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                    }

                    if(old_name_arr.length == 4){
                        $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                        $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
                    }
            });

//            if (count == 1){
//                $(this).find('.btntambah').removeClass('hide');
//                $(this).find('.btnhapus').addClass('hide');
//            }else{       
//                if (count == (row+1)){
//                    $(this).find('.btntambah').removeClass('hide');
//                    $(this).find('.btnhapus').addClass('hide');
//                }else{
//                    $(this).find('.btnhapus').removeClass('hide');
//                    $(this).find('.btntambah').addClass('hide');                        
//                }
//            }

            row++;
        });           
      
       jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
    }
    
    /**
     * Generate extension
     * @returns {undefined}
     */
    function genExt(){
        jQuery('.tanggal_pengiriman').datepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false,                    
                }, 
                jQuery.datepicker.regional['id'],
                {
//                    'minDate':'d',                    
                    'changeYear':true,
                    'changeMonth':true,
                    'showAnim':'fold',
                    'yearRange':'-80y:+20y',
                    'dateFormat':'<?php echo Params::DATE_FORMATV2 ?>',
                    'onSelect':function(){
                        setKeterlambatan(this);
                    },
                }
            )
        );
    }
    
    /**
     * Set keterlambatan
     * @param {type} obj
     * @returns {undefined}     
     */
    function setKeterlambatan(obj){
        var tgl_kirim = $(obj).val();
        var tgl_akhir = $("#<?php echo CHtml::activeId($model, 'tanggal_akhir') ?>").val();
    
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setKeterlambatan'); ?>',
            data:{                
                tgl_kirim:tgl_kirim,
                tgl_akhir:tgl_akhir
            },
            dataType:"json",
            success:function(data) {
                if (data.sukses == 1){    
                    $(obj).parents("tr").find('.keterlambatan').val(data.keterlambatan);
                    if (data.keterlambatan != ''){
                        $(obj).parents("tr").find('.lbl_keterlambatan').html(data.keterlambatan+' hari');
                    }else{
                        $(obj).parents("tr").find('.lbl_keterlambatan').html(data.keterlambatan);
                    }
                    setTanggalTerlambat();
                }else{
                    window.parent.toastr.error(data.pesan);
                }
                
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                 console.log(errorThrown);
            }
        });
    }
    
    /**
     * Set tanggal terlambat
     * @returns {undefined}     
     */
    function setTanggalTerlambat(){
        var tgl = [];
        var total = $('#rincian-surat-denda > tbody > tr ').find('.tanggal_pengiriman').length;
        
        var i = 0;
        var tgl_sebelum = '';
        $('#rincian-surat-denda > tbody > tr ').find('.tanggal_pengiriman').each(function(){        
            
            var arraycontainstgl = (tgl.indexOf($(this).val()) > -1);
            console.log(arraycontainstgl);   
            
            if (arraycontainstgl == false){
                tgl[i] = $(this).val();
                i++;
            }            
        });  
        
        $("#<?php echo CHtml::activeId($model, 'tanggal_keterlambatan') ?>").val(tgl.join(', '));
    }
    
    /**
     * Fungsi menghitung total
     * @returns {undefined}
     */
    function hitungTotal(){
        var totalharga = 0;
        $('#rincian-surat-denda > tbody > tr ').find('.jumlah_harga').each(function(){            
            totalharga += parseInt($(this).val());
        }); 
        
        $('#rincian-surat-denda > tbody > tr ').find('.total_harga').val(totalharga);
    }
    
    /**
     * Fungsi menghapus baris
     * @param {type} obj
     * @returns {undefined}
     */
    function hapusBaris(obj) {
        var id = $(obj).parents("tr").find('.suratdendadet_id').val();
        
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
            if (r) {
                if (id != ''){
                    $("#hapus-rincian > tbody").append("<tr><td><input type='hidden' name='delete[]' value ='"+id+"'></td></tr>");
                }
                
                $(obj).parents("tr").detach();        
                renameInputRow($('#rincian-surat-denda'));     
                genExt();
                hitungTotal();
                setTanggalTerlambat();
            }
        });
        
    }
</script>
