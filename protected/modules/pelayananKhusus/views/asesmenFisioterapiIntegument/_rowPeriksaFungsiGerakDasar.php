<div class="panel panel-success rowPeriksaFungsiGerak">
  <div class="panel-heading">
      <div class="panel-title">
          <span id="namaTitlePemeriksaan"><?php echo $namaPemeriksaan; ?></span>
      </div>
      <div class="pull-right" style="margin-right: 5px;">
          <?php echo CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array(
              'class'=>'btn btn-danger', 'onclick'=>'hapusFungsiGerak(this);',
          ))?>
      </div>
  </div>
  <div class="panel-body">
    <?php echo CHtml::hiddenField('periksafungsigerakdasar_id',$pemeriksaan_id,array('class'=>'periksafungsigerakdasar_id')); ?>
    <br/>
    <div class="row">
      <div class="col-sm-12">
        <table class="items table table-bordered table-striped table-condensed" id="tblDextra">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center;">Dextra</th>
              <th width="80px" style="text-align: center;">
                <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                        array('onclick'=>'tambahDextra(this); return false;',
                        'class'=>'btn btn-primary btnDextra',
                        'rel'=>"tooltip",
                        'title'=>"Klik untuk menambahkan Dextra")); ?>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
              if(isset($oriExtra) && isset($oriPeriksaDextra)){
                foreach ($oriPeriksaDextra as $j => $oriDextra) {
                  if($oriDextra->periksafungsigerakdasar_id == $oriExtra->periksafungsigerakdasar_id){
                    $this->renderPartial($this->path_view.'_rowDextra',array(
                      'pemeriksaan_id'=>$oriDextra->periksafungsigerakdasar->periksafungsigerakdasar_id,
                      'oriDextra'=>$oriDextra,
                      'dextraIndex'=>$j,
                      'extraIndex'=>$urutIndex
                    ));
                  }
                }
              }
             ?>
          </tbody>
        </table>
        <table class="items table table-bordered table-striped table-condensed" id="tblSinistra">
          <thead>
            <tr>
              <th colspan="4" style="text-align: center;">Sinistra</th>
              <th width="80px" style="text-align: center;">
                <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                        array('onclick'=>'tambahSinistra(this); return false;',
                        'class'=>'btn btn-primary btnSinistra',
                        'rel'=>"tooltip",
                        'title'=>"Klik untuk menambahkan Sinistra")); ?>
              </th>
            </tr>
          </thead>
          <tbody>
            <?php
              if(isset($oriExtra) && isset($oriPeriksaSinistra)){
                foreach ($oriPeriksaSinistra as $j => $oriSinistra) {
                  if($oriSinistra->periksafungsigerakdasar_id == $oriExtra->periksafungsigerakdasar_id){
                    $this->renderPartial($this->path_view.'_rowSinistrasi',array(
                      'pemeriksaan_id'=>$oriSinistra->periksafungsigerakdasar->periksafungsigerakdasar_id,
                      'oriSinistra'=>$oriSinistra,
                      'sinistraIndex'=>$j,
                      'extraIndex'=>$urutIndex
                    ));
                  }
                }
              }
             ?>
          </tbody>
        </table>


      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function tambahSinistra(obj){
    var index = $(obj).attr('btn_index');
  var periksafungsigerakdasar_id = $('#PeriksagerakdasardextraT_'+index+'_periksafungsigerakdasar_id').val();
  if(periksafungsigerakdasar_id != ''){
    $.ajax({
      type: "POST",
      url: "<?php echo $this->createUrl('tambahSinistra')?>",
      data: {periksafungsigerakdasar_id:periksafungsigerakdasar_id},
      dataType: "json",
      success: function(data){
        if(data != null){
          $('#rowPeriksaFungsiGerak_'+index).find('#tblSinistra').find('tbody').append(data.form);
          getRenameSinistra($('#rowPeriksaFungsiGerak_'+index).find('#tblSinistra').find('tbody'),index);
        }else{
          myAlert(data.pesan);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
  }else{
    myAlert('Silakan Pilih Pemeriksaan !!');
  }
}

function tambahDextra(obj){
    var index = $(obj).attr('btn_index');
  var periksafungsigerakdasar_id = $('#PeriksagerakdasardextraT_'+index+'_periksafungsigerakdasar_id').val();
  console.log("ID", periksafungsigerakdasar_id);
  if(periksafungsigerakdasar_id != ''){
    $.ajax({
      type: "POST",
      url: "<?php echo $this->createUrl('tambahDextra')?>",
      data: {periksafungsigerakdasar_id:periksafungsigerakdasar_id},
      dataType: "json",
      success: function(data){
        if(data != null){
          $('#rowPeriksaFungsiGerak_'+index).find('#tblDextra').find('tbody').append(data.form);
          getRenameDextra($('#rowPeriksaFungsiGerak_'+index).find('#tblDextra').find('tbody'),index);
        }else{
          myAlert(data.pesan);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
  }else{
    myAlert('Silakan Pilih Pemeriksaan !!');
  }
}

function getRenameDextra(obj,index){

  for(var i=0; i<$(obj).find('.fungsigerakdasarsinistra_id').length; i++){
    var tr = $(obj).find('.fungsigerakdasarsinistra_id').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+index+'_'+i+'_fungsigerakdasarsinistra_id');
      tr.attr('name','PeriksagerakdasardextraT['+index+']['+i+'][fungsigerakdasarsinistra_id]');
  }

  for(var i=0; i<$(obj).find('.aktif_gerakan_dextra').length; i++){
    var tr = $(obj).find('.aktif_gerakan_dextra').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+index+'_'+i+'_aktif_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+index+']['+i+'][aktif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.aktif_rom_dextra').length; i++){
    var tr = $(obj).find('.aktif_rom_dextra').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+index+'_'+i+'_aktif_rom');
      tr.attr('name','PeriksagerakdasardextraT['+index+']['+i+'][aktif_rom]');
  }

  for(var i=0; i<$(obj).find('.pasif_gerakan_dextra').length; i++){
    var tr = $(obj).find('.pasif_gerakan_dextra').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+index+'_'+i+'_pasif_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+index+']['+i+'][pasif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.pasif_rom_dextra').length; i++){
    var tr = $(obj).find('.pasif_rom_dextra').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+index+'_'+i+'_pasif_rom');
      tr.attr('name','PeriksagerakdasardextraT['+index+']['+i+'][pasif_rom]');
  }

  for(var i=0; i<$(obj).find('.isometrik_gerakan_dextra').length; i++){
    var tr = $(obj).find('.isometrik_gerakan_dextra').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+index+'_'+i+'_isometrik_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+index+']['+i+'][isometrik_gerakan]');
  }
  for(var i=0; i<$(obj).find('.isometrik_rom_dextra').length; i++){
    var tr = $(obj).find('.isometrik_rom_dextra').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+index+'_'+i+'_isometrik_rom');
      tr.attr('name','PeriksagerakdasardextraT['+index+']['+i+'][isometrik_rom]');
  }

}


function getRenameSinistra(obj,index){

  for(var i=0; i<$(obj).find('.fungsigerakdasarsinistra_id').length; i++){
    var tr = $(obj).find('.fungsigerakdasarsinistra_id').eq(i);
      tr.attr('id','PeriksagerakdasarsinistraT_'+index+'_'+i+'_fungsigerakdasarsinistra_id');
      tr.attr('name','PeriksagerakdasarsinistraT['+index+']['+i+'][fungsigerakdasarsinistra_id]');
  }

  for(var i=0; i<$(obj).find('.aktif_gerakan_sinistra').length; i++){
    var tr = $(obj).find('.aktif_gerakan_sinistra').eq(i);
      tr.attr('id','PeriksagerakdasarsinistraT_'+index+'_'+i+'_aktif_gerakan');
      tr.attr('name','PeriksagerakdasarsinistraT['+index+']['+i+'][aktif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.aktif_rom_sinistra').length; i++){
    var tr = $(obj).find('.aktif_rom_sinistra').eq(i);
      tr.attr('id','PeriksagerakdasarsinistraT_'+index+'_'+i+'_aktif_rom');
      tr.attr('name','PeriksagerakdasarsinistraT['+index+']['+i+'][aktif_rom]');
  }

  for(var i=0; i<$(obj).find('.pasif_gerakan_sinistra').length; i++){
    var tr = $(obj).find('.pasif_gerakan_sinistra').eq(i);
      tr.attr('id','PeriksagerakdasarsinistraT_'+index+'_'+i+'_pasif_gerakan');
      tr.attr('name','PeriksagerakdasarsinistraT['+index+']['+i+'][pasif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.pasif_rom_sinistra').length; i++){
    var tr = $(obj).find('.pasif_rom_sinistra').eq(i);
      tr.attr('id','PeriksagerakdasarsinistraT_'+index+'_'+i+'_pasif_rom');
      tr.attr('name','PeriksagerakdasarsinistraT['+index+']['+i+'][pasif_rom]');
  }

  for(var i=0; i<$(obj).find('.isometrik_gerakan_sinistra').length; i++){
    var tr = $(obj).find('.isometrik_gerakan_sinistra').eq(i);
      tr.attr('id','PeriksagerakdasarsinistraT_'+index+'_'+i+'_isometrik_gerakan');
      tr.attr('name','PeriksagerakdasarsinistraT['+index+']['+i+'][isometrik_gerakan]');
  }
  for(var i=0; i<$(obj).find('.isometrik_rom_sinistra').length; i++){
    var tr = $(obj).find('.isometrik_rom_sinistra').eq(i);
      tr.attr('id','PeriksagerakdasarsinistraT_'+index+'_'+i+'_isometrik_rom');
      tr.attr('name','PeriksagerakdasarsinistraT['+index+']['+i+'][isometrik_rom]');
  }

}

function batalSinistrasi(obj){
  var index = $(obj).attr('btnremove_index');
  $(obj).parents('tr').detach();
  getRenameSinistra($('#rowPeriksaFungsiGerak_'+index).find('#tblSinistra').find('tbody'), index);
}

function batalDextrasi(obj){
  var index = $(obj).attr('btnremove_index');
  $(obj).parents('tr').detach();
  getRenameDextra($('#rowPeriksaFungsiGerak_'+index).find('#tblDextra').find('tbody'), index);
}

function hapusFungsiGerak(obj) {
    $(obj).parents(".rowPeriksaFungsiGerak").remove();
    $(".rowPeriksaFungsiGerak").each(function() {
        getRenamePeriksaGerakDasar(this);
        getRenameSinistra($(this).find('#tblSinistra').find('tbody'), $(this).find(".btnSinistra").attr("btn_index"));
        getRenameDextra($(this).find('#tblDextra').find('tbody'), $(this).find(".btnDextra").attr("btn_index"));
    });
}

$(document).ready(function(){

    <?php if(isset($oriExtra)){ ?>
      setTimeout(function(){
        var indexUrut = parseInt('<?php echo (isset($urutIndex)?$urutIndex:0); ?>');
        getRenameSinistra($('#rowPeriksaFungsiGerak_'+indexUrut).find('#tblSinistra').find('tbody'), indexUrut);
        getRenameDextra($('#rowPeriksaFungsiGerak_'+indexUrut).find('#tblDextra').find('tbody'), indexUrut);
      },500);

    <?php } ?>
});
</script>
