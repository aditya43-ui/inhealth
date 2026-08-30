<?php 
    /**
     * @author Aida Rahmawati <aidarahmawati@.com>
     */
?>
<script>
    function getDataPermintaan(nomorbarcode) {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getDataPermintaan'); ?>',
            data:{nomorbarcode:nomorbarcode},
            dataType:"json",
            success:function(data) {
                $('#LuluskomponendarahT_pendonor_id').val(data.pendonor_id);
                $('#kantongdarah_id').val(data.kantongdarah_id);
                $('#nomorbarcode').val(data.nomorbarcode);
                $('#komponendarah_id').val(data.komponendarah_id);
                $('#jeniskantongdarah_id').val(data.jeniskantongdarah_id);
                $('#jeniskantong_nama').val(data.jeniskantong_nama);
                $('#tglpencatatan').val(data.tglpencatatan);
                $('#gol_darah').val(data.gol_darah);
                $('#rhesus').val(data.rhesus);
                $('#ruangandaftar_nama').val(data.ruangandaftar_nama);
                $('#ruangandaftar_id').val(data.ruangandaftar_id);
                $('#hasil_uji').val(data.hasil_uji);
                $('#hbsag').val(data.hbsag);
                $('#sifilis').val(data.sifilis);
                $('#antihvc').val(data.antihvc);
                $('#antihiv').val(data.antihiv);
                $('#singkatan_komp').val(data.singkatan_komp);
                $('#skriningimltd_id').val(data.skriningimltd_id);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    

        })
    }
    
    function setLulus(){
        var status_pelulusan = '';
        var hemolisis = parseInt($('#LuluskomponendarahT_is_hemolisis input:checked').val());
        var lipemik = parseInt($('#LuluskomponendarahT_is_lipemik input:checked').val());
        var icterik = parseInt($('#LuluskomponendarahT_is_icetrik input:checked').val());
        var plasmahijau = parseInt($('#LuluskomponendarahT_is_plasmahijau input:checked').val());
        var bekuan = parseInt($('#LuluskomponendarahT_is_bekuan input:checked').val());
        var pelabelan = parseInt($('#LuluskomponendarahT_is_pelabelan input:checked').val());
        var identitas = parseInt($('#LuluskomponendarahT_is_identitas input:checked').val());
        var kebocoran = parseInt($('#LuluskomponendarahT_is_kebocoran input:checked').val());
        var total = hemolisis + lipemik+icterik+plasmahijau+bekuan+pelabelan+identitas+kebocoran;
        if(total === 'NaN'){
            status_pelulusan = '';
        }else{
            if(total > 0){
                status_pelulusan = 'TIDAK LULUS';
            }else if ( total == 0 ){
                status_pelulusan = 'LULUS';
            }
        }
        $('#LuluskomponendarahT_statuspelulusan').val(status_pelulusan);
    }
</script>
    