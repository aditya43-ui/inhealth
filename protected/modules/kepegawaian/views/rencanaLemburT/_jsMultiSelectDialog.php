<script>

var pl_select = {};

function ceklis_pegawai(obj) {
    pl_select[$(obj).data('id')] = $(obj).is(":checked");
}

function update_ceklis_pegawai() {
    $("#karlembur-m-grid table tbody .check_pegawai").each(function() {
        var cobj = $(this);
        cobj.prop('disabled', false);
        
        $("#tabelPegawaiLembur tbody tr .pegawai_id").each(function() {
            if (cobj.data('id') == $(this).val()) {
                cobj.prop('checked', true).prop('disabled', true);
            }
        });
        
        if (typeof pl_select[cobj.data('id')] !== 'undefined') {
            cobj.prop('checked', pl_select[cobj.data('id')]);
        }
    });
}
    
function tambahPegawaiLembur() {
    var pl_res = [];
    $.each(pl_select, function(i, v) {
        if (v) pl_res.push(i);
    });
    pl_select = {};
    
    $("#dialogPegawaiLembur").dialog('close');
    
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('getPegawaiLembur'); ?>',
        data: {pegawailembur_id: pl_res},
        dataType: "json",
        success:function(data){
            $('#tabelPegawaiLembur tbody').append(data.tr);
            $.fn.yiiGridView.update('karlembur-m-grid');
            hitungSemua();
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
</script>