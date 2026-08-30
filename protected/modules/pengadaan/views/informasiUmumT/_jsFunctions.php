<?php
$konfig = KonfigsystemK::model()->find();
$hps = number_format(!empty($modInformasi)?$modInformasi->total_hargaseluruhnya:0,2,",",".");
?>
<script> 
    
    var cek_simplikasi = () => {
        let simplikasi = '<?= ($konfig->is_simplifikasipengadaan)?'ya':'tidak' ?>';
        let hps = '<?= $hps ?>';
        
        $(".form-penawaran").removeClass('hide');
        $(".harga_ditawarkan").val((0))        
        if (simplikasi == 'ya'){
            $(".form-penawaran").addClass('hide');
            $(".harga_ditawarkan").val((hps))
        }
    }
    
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
    
    function setDataSupplier(data){
        $("#SupplierM_supplier_npwp").val(data.supplier_npwp);
        $("#<?php echo CHtml::activeId($modSupplier, 'supplier_nama') ?>").attr('disabled', true);
        $("#SupplierM_supplier_id").val(data.supplier_id);
        $("#SupplierM_supplier_nama").val(data.supplier_nama);
        $("#SupplierM_supplier_alamat").val(data.supplier_alamat);
        $("#SupplierM_direktursupplier").val(data.direktursupplier);
        $("#SupplierM_supplier_telp").val(data.supplier_telp);
        $("#SupplierM_supplier_email").val(data.supplier_email);
        $("#SupplierM_supplier_cp").val(data.supplier_cp);
        $("#SupplierM_supplier_cp_jabatan").val(data.supplier_cp_jabatan);
        $("#SupplierM_supplier_cp_hp").val(data.supplier_cp_hp);
        $("#SupplierM_supplier_jenis").val(data.supplier_jenis);
        $("#SupplierM_supplier_propinsi").val(data.supplier_propinsi);
        $("#SupplierM_supplier_kabupaten").val(data.supplier_kabupaten);
        $("#SupplierM_pbf_id").val(data.pbf_id);
        cekPBF();        
    }
    
    document.getElementById("PenawaranpenyediaT_penawaranpenyedia_file").onchange = function () {
        if(this.files[0].size>3000000){
            myAlert("ukuran maks : 3Mb");
            $("#PenawaranpenyediaT_penawaranpenyedia_file").attr("src","blank");
            $('#PenawaranpenyediaT_penawaranpenyedia_file').wrap('<form>').closest('form').get(0).reset();
            $('#PenawaranpenyediaT_penawaranpenyedia_file').unwrap();     
            return false;
        }
        if(this.files[0].type.indexOf("pdf")==-1){
            myAlert("Tipe file harus PDF");
            $("#PenawaranpenyediaT_penawaranpenyedia_file").attr("src","blank");
            $('#PenawaranpenyediaT_penawaranpenyedia_file').wrap('<form>').closest('form').get(0).reset();
            $('#PenawaranpenyediaT_penawaranpenyedia_file').unwrap();         
            return false;
        }   
    };
    
    $("#baserahterima-t-form").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2});
    
    $(document).ready(function(){
        cekPBF();
        cek_simplikasi();
    });
</script>