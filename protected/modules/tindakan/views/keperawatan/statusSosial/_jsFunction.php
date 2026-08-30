<script type="text/javascript">
    function lainnya(obj, namaClass){
        if($(obj).is(':checked')){
            $('.'+namaClass).attr('readonly', false);
        }else{
            $('.'+namaClass).attr('readonly', true);
        }
    }

    function rumah(){
        if($('#RJSosialekonomispiritualT_islainlain').prop('checked') == true){
            $('.rumahlainlain').attr('readonly', false);
        }else{
            $('.rumahlainlain').attr('readonly', true);
        }
    }

    function asuransinama(){
        if($('#RJSosialekonomispiritualT_is_pembiayaanasuransi').prop('checked') == true){
            $('.asuransinama').attr('readonly', false);
        }else{
            $('.asuransinama').attr('readonly', true);
        }
    }

    function perusahaannama(){
        if($('#RJSosialekonomispiritualT_is_pembiayaanperusahaan').prop('checked') == true){
            $('.perusahaannama').attr('readonly', false);
        }else{
            $('.perusahaannama').attr('readonly', true);
        }
    }

    function checklistOnlyOne(){
        $('.rumah').click(function() {
            $('.rumah').not(this).prop('checked', false);
            rumah();
        });
    }

    function checklistPembiayaan(){
        $('.pembiayaan').click(function() {
            $('.pembiayaan').not(this).prop('checked', false);
            asuransinama();
            perusahaannama();
        });
    }

    function nilaiKepercayaan(obj){
        var nilai = $(obj).attr('data-value');
        if(nilai == 1){
            $('.kepercayaan').attr('disabled', false);
        }else{
            $('.kepercayaan').prop('checked', false);
            $('.kepercayaan').attr('disabled', true);
            $('#RJSosialekonomispiritualT_ket_nilaikepercayaanlainnya').val('');
        }
    }

    $(document).ready(function(){
        lainnya('#RJSosialekonomispiritualT_is_tinggalbersamalain', 'ispasientinggallain');
        lainnya('#RJSosialekonomispiritualT_is_bahasadaerah', 'bahasa');
        lainnya('#RJSosialekonomispiritualT_islainlain', 'rumahlainlain');
        lainnya('#RJSosialekonomispiritualT_is_pembiayaanasuransi', 'asuransinama');
        lainnya('#RJSosialekonomispiritualT_is_nilaikepercayaanlainnya', 'islainnya');
    });
</script>