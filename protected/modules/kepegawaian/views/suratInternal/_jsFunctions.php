<script type='text/javascript'>
function changeJenisSurat(){
    var jenissurat = $('#<?php echo CHtml::activeId($model,'jenissurat') ?>').val();

    if(jenissurat == 'Surat Masuk'){
        $('.pnl_jenissuratkeluar').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratkeluar').find('input, textarea, select').val('');
        $('.pnl_jenissuratkeluar').hide();

        $('.pnl_jenissuratizin').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratizin').find('input, textarea, select').val('');
        $('.pnl_jenissuratizin').hide();

        $('.pnl_jenissuratmou').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratmou').find('input, textarea, select').val('');
        $('.pnl_jenissuratmou').hide();

        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').val('');
        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').attr('readonly',false);
        
        $('.pnl_jenissuratmasuk').find('input, textarea, select').attr('disabled',false);
        $('.pnl_jenissuratmasuk').show();
        $('#tbl_tujuandisposisi').find('tbody').html('');
        tambahPegawai();

    }else if(jenissurat == 'MoU'){
        $('.pnl_jenissuratkeluar').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratkeluar').find('input, textarea, select').val('');
        $('.pnl_jenissuratkeluar').hide();

        $('.pnl_jenissuratizin').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratizin').find('input, textarea, select').val('');
        $('.pnl_jenissuratizin').hide();

        $('.pnl_jenissuratmasuk').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratmasuk').find('input, textarea, select').val('');
        $('.pnl_jenissuratmasuk').hide();
        $('#tbl_tujuandisposisi').find('tbody').html('');

        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').val('');
        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').attr('readonly',false);
        $('.pnl_jenissuratmou').find('input, textarea, select').attr('disabled',false);
        $('.pnl_jenissuratmou').show();
    }else if(jenissurat == 'Perizinan'){
        $('.pnl_jenissuratkeluar').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratkeluar').find('input, textarea, select').val('');
        $('.pnl_jenissuratkeluar').hide();

        $('.pnl_jenissuratmou').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratmou').find('input, textarea, select').val('');
        $('.pnl_jenissuratmou').show();

        $('.pnl_jenissuratmasuk').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratmasuk').find('input, textarea, select').val('');
        $('.pnl_jenissuratmasuk').hide();
        $('#tbl_tujuandisposisi').find('tbody').html('');

        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').val('');
        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').attr('readonly',false);
        $('.pnl_jenissuratizin').find('input, textarea, select').attr('disabled',false);
        $('.pnl_jenissuratizin').show();
    }else{
        $('.pnl_jenissuratmasuk').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratmasuk').find('input, textarea, select').val('');
        $('.pnl_jenissuratmasuk').hide();

        $('.pnl_jenissuratizin').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratizin').find('input, textarea, select').val('');
        $('.pnl_jenissuratizin').hide();

        $('.pnl_jenissuratmou').find('input, textarea, select').attr('disabled',true);
        $('.pnl_jenissuratmou').find('input, textarea, select').val('');
        $('.pnl_jenissuratmou').hide();
        
        $('#tbl_tujuandisposisi').find('tbody').html('');
        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').val('-Otomatis-');
        $('#<?php echo CHtml::activeId($model, 'nomorsurat') ?>').attr('readonly',true);
        
        $('.pnl_jenissuratkeluar').find('input, textarea, select').attr('disabled',false);
        $('.pnl_jenissuratkeluar').show();
    }
}

function setDialogPegawai(obj){
    var parent = $(obj).parents(".input-append").find("input").attr("id");
    var dialog = "#dialogPegawai";
    
    $(dialog).attr("parent-dialog",parent);
    $(dialog).dialog("open");
}

function setPegawai(obj,item)
{
    $(obj).parents('.tr_pegawai').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
    $(obj).parents('.tr_pegawai').find('input[name$="[pegawai_nama]"]').val(item.namaLengkap);
}

function setPegawaiAuto(pegawai_id, pegawai_nama){
    var is_ada_pegawai = false;
    $("#tbl_tujuandisposisi .pegawai_id").each(function() {
        if ($(this).val() == pegawai_id) is_ada_pegawai = true;
    });
    
    if (is_ada_pegawai) {
        myAlert("Tujuan Disposisi Sudah ada silahkan pilih yang lain.");
        return false;
    }
    var dialog_pegawai = "#dialogPegawai";
    var parent_pegawai = $(dialog_pegawai).attr("parent-dialog");
    var obj_pegawai = $("#"+parent_pegawai);
    
    $(obj_pegawai).parents('.tr_pegawai').find('input[name$="[pegawai_id]"]').val(pegawai_id);
    $(obj_pegawai).parents('.tr_pegawai').find('input[name$="[pegawai_nama]"]').val(pegawai_nama);
    $(dialog_pegawai).dialog("close");
}

function tambahPegawai(){
    var trPegawai = <?php echo json_encode($this->renderPartial($this->path_view.'_rowTujuanDisposisi', array(), true)); ?>;

    $('#tbl_tujuandisposisi').find('tbody').append(trPegawai.replace());
    generateRowPegawai($('#tbl_tujuandisposisi').find('tbody'));
}

function generateRowPegawai(obj){
  for(var i=0; i<$(obj).find('.pegawai_id').length; i++){
      var trRow = $(obj).find('.pegawai_id').eq(i);
      trRow.attr('id','PihaksuratinternalT_'+i+'_pegawai_id');
      trRow.attr('name','PihaksuratinternalT['+i+'][pegawai_id]');
  }
  for(var i=0; i<$(obj).find('.pegawai_nama').length; i++){
      var trRow = $(obj).find('.pegawai_nama').eq(i);
      trRow.attr('id','PihaksuratinternalT_'+i+'_pegawai_nama');
      trRow.attr('name','PihaksuratinternalT['+i+'][pegawai_nama]');
  }

}

function hapusPegawai(obj){
    $(obj).parents('.tr_pegawai').remove();
    if($('#tbl_tujuandisposisi').find('tbody').find('tr').length == 0){
        tambahPegawai();
    }else{
        generateRowPegawai($('#tbl_tujuandisposisi').find('tbody'));
    }   
}

$(document).ready(function(){
    changeJenisSurat();

});
</script>