<?php 
    $id = $model->supplier_id; 
    $urlDokumen = $this->createUrl('loadDokumen');
?>
<script>

    function cekPBF(obj){
        var jenis = $('#SupplierM_supplier_jenis').val();

        if (jenis === "Farmasi") {
            $('.pbf').show();
            //$('.pbf_nama').attr('class', 'required');
            console.log(jenis);
        } else {
            $('.pbf').hide();
            $('#SupplierM_pbf_id').val("");
            console.log(jenis);
        }
    }
    function selectPersiapan(){
        $("#PenawaranpenyediaT_nama_pekerjaan").val($("#PenawaranpenyediaT_persiapanpengadaan_id :selected").data('nama'));
    }
    function loadDokumen(){
        jenis = "Dokumen Supplier";
        id = '<?php echo $id; ?>';
        if (jenis == '') {
            return false;
        } else {
            $.post("<?php echo $urlDokumen ?>", {jenis:jenis, id:id},
            function(data){
                $("#dokPendukung").children("tbody").append(data.dokDukung);
            }, "json");
        }
    }   
    
    function cekFile(obj){       
        
        var cek = $(obj).val();        
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                    
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           
            var fileExt = $(obj).attr('accept').split(',');        
                                                
            if($.inArray(ext, fileExt) == -1 && $.inArray(tipeFile[0]+'/*', fileExt) == -1) {
                myAlert('Tipe file yang diupload tidak diizinkan !',"Perhatian!");
                $(obj).val(""); 
                $(".fileinput-exists").trigger('click');
                return false;
            }

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 10) {
                myAlert("Ukuran file tidak boleh lebih dari 200kb/2mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents("tr").find('.labelbrowse').html('');
                $(".fileinput-exists").trigger('click');
                return false;
            }else{
                $(obj).parents("tr").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }
       
    }
    
    function fileLoad(obj){
        $(obj).parents("tr").find('input:file').trigger('click');
    }
    
    $("#baserahterima-t-form").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":",","precision":0});

    $(document).ready(function(){
        loadDokumen();
        cekPBF();
    });
</script>