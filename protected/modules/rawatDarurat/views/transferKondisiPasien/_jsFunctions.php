<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function inputPegawaiPendamping()
{
    var id = $('#pegawaipendamping_id').val();
    var nama = $('#pegawaipendamping_nama').val();
    
    var cekdata = 0;
    $('#tblpendamping').find('tbody tr').each(function(){
        if($(this).find('.pegawai_id').val() === id){
            cekdata += 1;
        }
    });
    
    if(cekdata === 0){
        var html = "<tr>" +
                "<td>" +
                    "<input type='hidden' class='pegawai_id' value='"+id+"' />"+
                    "<input type='text' class='pegawai_nama' value='"+nama+"' readonly='true' style='width:300px' />"+
                "</td>" +
                "<td>" +
                    "<a onclick='batalPegawaiPendamping(this);return false;' rel='tooltip' href='javascript:void(0);' title='Klik untuk membatalkan Petugas Pendamping'><i class='icon-remove'></i></a>" +
                "</td>" +
                "</tr>";
        $('#tblpendamping').find('tbody').append(html);
        generateRowPegawaiPendamping($('#tblpendamping').find('tbody'));

        $('#pegawaipendamping_id').val('');
        $('#pegawaipendamping_nama').val('');
    }else{
        myAlert('Petugas Pendamping '+nama+' Sudah Ada');
    }
}

function generateRowPegawaiPendamping(obj){
    for(var i=0; i<$(obj).find('.pegawai_id').length; i++){
        var trRow = $(obj).find('.pegawai_id').eq(i);
       trRow.attr('id','PegawaiPendamping_'+i+'_pegawai_id');
       trRow.attr('name','PegawaiPendamping['+i+'][pegawai_id]');
    }
    for(var i=0; i<$(obj).find('.pegawai_nama').length; i++){
        var trRow = $(obj).find('.pegawai_nama').eq(i);
       trRow.attr('id','PegawaiPendamping_'+i+'_pegawai_nama');
       trRow.attr('name','PegawaiPendamping['+i+'][pegawai_nama]');
    }
}
function batalPegawaiPendamping(obj){
    $(obj).parents('tr').remove(); 
    generateRowPegawaiPendamping($('#tblpendamping').find('tbody'));
}

$(document).ready(function(){
    <?php if(isset($_GET['prosestransferpasien_id']) && !empty($_GET['prosestransferpasien_id'])){ ?>
        generateRowPegawaiPendamping($('#tblpendamping').find('tbody'));
    <?php } ?>        
});

</script>

