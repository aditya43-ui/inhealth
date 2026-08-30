<script type="text/javascript">
const cekForm = () => {
    if (requiredCheck($("#laporanoperasi-frm"))){
        const jumlahIcdXUtama = $("#tbl_diagnosax > tbody > tr").find("select option:selected[value='<?= Params::KELOMPOKDIAGNOSA_UTAMA ?>']").length;
        const jumlahIcdIx = $("#tbl_diagnosaix > tbody > tr:not('#is_kosong')").length;

        if (jumlahIcdIx > 0){               
            if (jumlahIcdXUtama == 0){
                window.parent.myAlert("Diagnosa (ICD X) untuk kelompok diagnosa utama belum ditambahkan","Perhatian");
                return false;
            }             
        }

        $("#laporanoperasi-frm").submit();
        disableOnSubmit($("#btn-simpan"));
    }
    return false;
}

const loadDataPenunjang = (obj) => {
    $.get("<?php echo $this->createUrl('loadDataPenunjang'); ?>", {
        id: $(obj).val(),
    }, function(data) {
        
        $(".asistenbedah").val(data.asistenbedah);
        $(".asistenbedah_2").val(data.asistenbedah2);
        $(".dokteranestesi").val(data.dokteranestesi);
        $(".perawat_instrumen").val(data.perawatinstrumen);
        $(".tglrencanoeprasi").val(data.tglrencanoeprasi);
                
    }, 'json');
}
    
    
const set_action = (obj,jenis) => {
    var id_attr = $(obj).parents(".form-utama").attr('id');
    var set_obj = $("#"+id_attr);             

    if (jenis == 'tambah'){                    

        tambah_data_baris($(obj));                                                 

        renameInputRow(set_obj);

        $("#"+id_attr).find(".baris:last").find('input,select').val("");
        $("#"+id_attr).find(".baris:last").find('span.lbl').html("");                                             

    }else if (jenis == 'hapus'){
        hapus_data_baris($(obj),function(){
            renameInputRow(set_obj);
        });
    }                                                
}

const cekKelompokDiagnosa = (obj) => {
    
}

var renameInputRow = (obj_table) => {
    var row = 0;

    $(obj_table).find(".baris").each(function(){            

        $(this).find(".nomor").html(row+1);
        $(this).attr("row-data",row);
        $(this).find('input,select,textarea').each(function(){ //element <input>
            if (typeof $(this).attr("name") !== 'undefined'){
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                var attr_id = $(this).data("attr");
                if(old_name_arr.length == 3){
                    if (attr_id != '' && typeof attr_id !== 'undefined'){
                        $(this).attr("id",old_name_arr[0]+"_"+attr_id+"_"+row+"_"+old_name_arr[2]);
                    }else{
                        $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    }
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }               
            }
        });
        
        row++;
    });

}

function setChangeKirim(){
  var index = 0;
  var indexLainnya = 0;
  $('.is_dikirimpemeriksaan').each(function(){
    if($(this).val()==1 &&  $(this).prop('checked')==true){
      $('.kirimpemeriksaanket').each(function(){
        $(this).attr('disabled',false);
      });
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 2 && indexLainnya == 0){
    $('.kirimpemeriksaanket').each(function(){
      $(this).attr('disabled',true);
      $(this).attr('checked',false);
    });
  }
}

function print(id)
{
    window.open('<?php echo $this->createUrl('print'); ?>&id=' + id, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
}

function hapusRiwayat(id) {
    myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
        if (r) {
            $.post("<?php echo $this->createUrl('hapusRiwayat'); ?>", {
                id: id,
            }, function(data) {
                if (data.ok == 1) {
                    $.fn.yiiGridView.update('riwayatlaporanoperasi-grid');
                }
                myAlert(data.msg);
            }, 'json');
        }
    });
}

$(document).ready(function(){
  setChangeKirim();
});
</script>
