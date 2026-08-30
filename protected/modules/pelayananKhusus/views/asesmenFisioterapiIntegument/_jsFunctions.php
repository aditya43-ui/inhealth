<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function getTekananDarah(){
  var sys = parseInt($('#<?php echo CHtml::activeId($model, 'td_systolic'); ?>').val());
  var dys = parseInt($('#<?php echo CHtml::activeId($model, 'td_dyastolic'); ?>').val());

  if(isNaN(sys)){
    sys = 0;
  }
  if(isNaN(dys)){
    dys = 0;
  }
  $('#tekanandarah').val(sys+'/'+dys);
}

function setStatik(){
  var index = 0;
  var indexLainnya = 0;
  $('.statik').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('#<?php echo CHtml::activeId($model, 'static_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 4 && indexLainnya == 0){
    $('#<?php echo CHtml::activeId($model, 'static_lainnya'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'static_lainnya'); ?>').attr('readonly',true);
  }
}

function setDinamis(){
  var index = 0;
  var indexLainnya = 0;
  $('.dinamis').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('#<?php echo CHtml::activeId($model, 'dinamis_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 4 && indexLainnya == 0){
    $('#<?php echo CHtml::activeId($model, 'dinamis_lainnya'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'dinamis_lainnya'); ?>').attr('readonly',true);
  }
}

function setPalpasi(){
  var index = 0;
  var indexLainnya = 0;
  $('.palpasi').each(function(){
    if($(this).val()=='Lainnya' &&  $(this).prop('checked')==true){
      $('#<?php echo CHtml::activeId($model, 'palpasi_lainnya'); ?>').attr('readonly',false);
      indexLainnya = 1;
    }else{
      index++;
    }
  });

  if(index <= 5 && indexLainnya == 0){
    $('#<?php echo CHtml::activeId($model, 'palpasi_lainnya'); ?>').val('');
    $('#<?php echo CHtml::activeId($model, 'palpasi_lainnya'); ?>').attr('readonly',true);
  }
}

function tambahPemeriksaan(){
  var pemeriksaangerak_id = $('#pemeriksaanFungsiGerak').val();
  if(pemeriksaangerak_id != ''){
    $.ajax({
      type: "POST",
      url: "<?php echo $this->createUrl('tambahPeriksaFungsiGerakDasar')?>",
      data: {pemeriksaangerak_id:pemeriksaangerak_id},
      dataType: "json",
      success: function(data){
        if(data != null){
          $('.rowPemeriksaanFungsiGerakDasar').append(data.form);
          getRenamePeriksaGerakDasar($('.rowPemeriksaanFungsiGerakDasar'));
          $('#pemeriksaanFungsiGerak').val('');
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

function getRenamePeriksaGerakDasar(obj){
  for(var i=0; i<$(obj).find('.rowPeriksaFungsiGerak').length; i++){
    var tr = $(obj).find('.rowPeriksaFungsiGerak').eq(i);
      tr.attr('id','rowPeriksaFungsiGerak_'+i);
  }

  for(var i=0; i<$(obj).find('.periksafungsigerakdasar_id').length; i++){
    var tr = $(obj).find('.periksafungsigerakdasar_id').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_periksafungsigerakdasar_id');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][periksafungsigerakdasar_id]');
  }

  for(var i=0; i<$(obj).find('.aktif_gerakan').length; i++){
    var tr = $(obj).find('.aktif_gerakan').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_aktif_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][aktif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.aktif_rom').length; i++){
    var tr = $(obj).find('.aktif_rom').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_aktif_rom');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][aktif_rom]');
  }

  for(var i=0; i<$(obj).find('.pasif_gerakan').length; i++){
    var tr = $(obj).find('.pasif_gerakan').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_pasif_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][pasif_gerakan]');
  }

  for(var i=0; i<$(obj).find('.pasif_rom').length; i++){
    var tr = $(obj).find('.pasif_rom').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_pasif_rom');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][pasif_rom]');
  }

  for(var i=0; i<$(obj).find('.isometrik_gerakan').length; i++){
    var tr = $(obj).find('.isometrik_gerakan').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_isometrik_gerakan');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][isometrik_gerakan]');
  }

  for(var i=0; i<$(obj).find('.isometrik_rom').length; i++){
    var tr = $(obj).find('.isometrik_rom').eq(i);
      tr.attr('id','PeriksagerakdasardextraT_'+i+'_isometrik_rom');
      tr.attr('name','PeriksagerakdasardextraT['+i+'][isometrik_rom]');
  }

  for(var i=0; i<$(obj).find('.tblSinistra').length; i++){
    var tr = $(obj).find('.tblSinistra').eq(i);
      tr.attr('table_index',i);
  }

  for(var i=0; i<$(obj).find('.btnSinistra').length; i++){
    var tr = $(obj).find('.btnSinistra').eq(i);
      tr.attr('btn_index',i);
  }

  for(var i=0; i<$(obj).find('.batalSinistrasi').length; i++){
    var tr = $(obj).find('.batalSinistrasi').eq(i);
      tr.attr('btnremove_index',i);
  }
  
  for(var i=0; i<$(obj).find('.tblDextra').length; i++){
    var tr = $(obj).find('.tblDextra').eq(i);
      tr.attr('table_index',i);
  }

  for(var i=0; i<$(obj).find('.btnDextra').length; i++){
    var tr = $(obj).find('.btnDextra').eq(i);
      tr.attr('btn_index',i);
  }

  for(var i=0; i<$(obj).find('.batalDextra').length; i++){
    var tr = $(obj).find('.batalDextra').eq(i);
      tr.attr('btnremove_index',i);
  }

}

    function batalTambahBagianTubuh(obj){
        //var conf = confirm("Apakah Anda yakin akan membatalkan pemilihan pemeriksaan ini ?");
         window.parent.myConfirm("Apakah Anda yakin akan membatalkan pemilihan pemeriksaan ini ?","Perhatian", function(r){
             if(r){
                var bagiantubuh_id = $(obj).parents('tr').find('input[name$="[bagiantubuh_id]"]').val();
                var gambartubuh_id = $(obj).parents('tr').find('input[name$="[gambartubuh_id]"]').val();
                var kordinat_tubuh_x = $(obj).parents('tr').find('.kordinat_tubuh_x').val();
                var kordinat_tubuh_y = $(obj).parents('tr').find('.kordinat_tubuh_y').val();
                var keterangan_periksa_gbr = $(obj).parents('tr').find('.keterangan_periksa_gbr').val();
                var pemeriksaangambarintegument_id = $(obj).parents('tr').find('.pemeriksaangambarintegument_id').val();
                kordinat_tubuh_x = kordinat_tubuh_x.replace(/\./g,'_');
                kordinat_tubuh_y = kordinat_tubuh_y.replace(/\./g,'_');

                $(obj).parents('tbody').find('input[name$="[bagiantubuh_id]"][value="'+bagiantubuh_id+'"]').each(function(){
                                     //$(obj).parents('tbody').find('input[name$="[gambartubuh_id]"][value="'+gambartubuh_id+'"]').each(function(){
                                             //alert($(this).attr('delete'));
                                             if ($(this).data('delete') == gambartubuh_id+'_'+kordinat_tubuh_x+'_'+kordinat_tubuh_y){
                                                     $(this).parents('tr').detach();
                                             }
                                     //})
                     //$(this).parents('tr').detach();
                 });
                $("#imgtag"+gambartubuh_id).find('#titik_'+bagiantubuh_id+'_'+kordinat_tubuh_x+'_'+kordinat_tubuh_y).detach();
                renameInput($('#table-bagtubuh'));

                if (pemeriksaangambarintegument_id != ''){
                    $("#tabel-hapus-gambar > tbody").append("<tr><td><input type='hidden' value='"+pemeriksaangambarintegument_id+"' name='deletegambar[]'></td></tr>");
                }
             }
         });

     }


     function renameInput(obj_table){
         var row = 0;
         $(obj_table).find("tbody > tr").each(function(){
             $(this).find("#no_urut").val(row+1);
             $(this).find('span').each(function(){ //element <input>
                 var old_name = $(this).attr("name").replace(/]/g,"");
                 var old_name_arr = old_name.split("[");
                 if(old_name_arr.length == 3){
                     $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                 }
             });
             $(this).find('input,select,textarea').each(function(){ //element <input>
                 var old_name = $(this).attr("name").replace(/]/g,"");
                 var old_name_arr = old_name.split("[");
                 if(old_name_arr.length == 3){
                     $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                     $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                 }
             });
             row++;
         });

     }

     function titikSebelumSimpan(ptitikX,ptitikY,bagiantubuh_id, img){
             var titikX = Math.round(ptitikX)-10;
             var titikY = Math.round(ptitikY)-10;
             var color = 'rgba(219, 50, 92, 0.9)';
             var size = '1px';

             var xtitik = ptitikX.replace(/\./g,'_');
             var ytitik = ptitikY.replace(/\./g,'_');


             $(img).append(
             $('<div id="titik_'+bagiantubuh_id+'_'+xtitik+'_'+ytitik+'"></div>')
                             .css('position', 'absolute')
                             .css('top', titikY + 'px')
                             .css('left', titikX + 'px')
                             .css('width', size)
                             .css('height', size)
                             .css('background-color', color)
                             .css('cursor', 'pointer')
                             .css('display', 'block')
                             .css('padding', '5px')
                             .css('-webkit-border-radius', '50%')
                             .css('-moz-border-radius', '50%')
                             .css('border-radius', '50%')
             );
     }

     function titikSesudahSimpan(titikX,titikY,urutan,bagiantubuh_id, img){
             var x_titik = titikX.toFixed(7);
             var y_titik = titikY.toFixed(7);

             var titikX=titikX-15;
             var titikY=titikY-15;
             var nomor = urutan+1;
             var color = 'rgba(0, 128, 255, 0.8)';
             var size = '5px';

             x_titik = x_titik.replace(/\./g,'_');
             y_titik = y_titik.replace(/\./g,'_');

             $(img).append(
                     $('<div id="titikbiru_'+bagiantubuh_id+'_'+x_titik+'_'+y_titik+'"><strong style="position:absolute;top:0;left:7px;color:#fff;">'+nomor+'</strong></div>')
                             .css('position', 'absolute')
                             .css('top', titikY + 'px')
                             .css('left', titikX + 'px')
                             .css('width', size)
                             .css('height', size)
                             .css('background-color', color)
                             .css('cursor', 'pointer')
                             .css('display', 'block')
                             .css('padding', '10px')
                             .css('-webkit-border-radius', '50%')
                             .css('-moz-border-radius', '50%')
                             .css('border-radius', '50%')
                             .css('vertical-align','middle')
             );
     }

     function loadTitikSesudahSimpan(){
             <?php if(!empty($modPemeriksaanGambar)){
                     $j = 1;
                     foreach($modPemeriksaanGambar as $i => $v){ ?>
                     titikSesudahSimpan(<?= $v->kordinat_tubuh_x; ?>, <?= $v->kordinat_tubuh_y.','.$i.','.$v->bagiantubuh_id ?>, '#imgtag<?php echo $v->gambartubuh_id; ?>');

             <?php $j++;}
             }?>
     }

     function print(pendaftaran_id, pasienmasukpenunjang_id)
     {
         window.open('<?php echo $this->createUrl('print'); ?>&pendaftaran_id='+pendaftaran_id+'&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=793,height=1122,scrollbars=yes');
     }

     $(document).ready(function(){
       setDinamis();
       setStatik();
       setPalpasi();
       getTekananDarah();

       getRenamePeriksaGerakDasar($('.rowPemeriksaanFungsiGerakDasar'));
            loadTitikSesudahSimpan();


            var counter = 0;
            var mouseX = 0;
            var mouseY = 0;

        $("[id^=imgtag] img").click(function(e) { // make sure the image is click
          var imgtag = $(this).parent(); // get the div to append the tagging list
              var no_img = $(this).attr('img-no');
              var gambartubuh_id = $(this).attr('alt');
          mouseX = ( e.pageX - $(imgtag).offset().left ); // x and y axis
          mouseY = ( e.pageY - $(imgtag).offset().top );
              //$( '#titikklik'+no_img ).remove(); // menghapus titik lain selain titik current klik
              $( '[id^=titikklik]' ).remove(); // menghapus titik lain selain titik current klik
                    $("#imgtag"+no_img).append(
                    $('<div id="titikklik'+no_img+'"></div>')
                                    .css('position', 'absolute')
                                    .css('top', Math.round(mouseY)-10 + 'px')
                                    .css('left', Math.round(mouseX)-10 + 'px')
                                    .css('width', '5px')
                                    .css('height', '5px')
                                    .css('background-color', 'rgba(219, 50, 92, 0.5)')
                                    .css('cursor', 'pointer')
                                    .css('display', 'block')
                                    .css('padding', '5px')
                                    .css('-webkit-border-radius', '50%')
                                    .css('-moz-border-radius', '50%')
                                    .css('border-radius', '50%')
                    );
                    var html = '<div id="tagit'+no_img+'">\n\
                                    <div class="name"  style="padding:10px;"><br>\n\
                                            <div class="text"><strong>Data Pemeriksaan</strong></div>\n\
                                            <table>\n\
                                                    <tr>\n\
                                                            <td>Bagian Tubuh : </td>\n\
                                                            <td>\n\
                                                                    <input type="hidden" id="gambartubuh_id'+no_img+'" value="'+gambartubuh_id+'">\n\
                                                                    <select id="bagiantubuh_id'+no_img+'" name="bagiantubuh_id" onkeypress="return $(this).focusNextInputField(event);" class="span2">\n\
                                                                    <option value="">-- Pilih --</option>\n\
                                                                    <?php foreach ($modBagianTubuh->BagianTubuh as $key => $value){ ?>\n\
                                                                            <option value="<?php echo $value->bagiantubuh_id; ?>"><?php echo $value->namabagtubuh; ?></option>\n\
                                                                    <?php } ?>\n\
                                                            </select>\n\
                                                            </td>\n\
                                                    </tr>\n\
                                                    <tr>\n\
                                                            <td>Keterangan : </td>\n\
                                                            <td><textarea id ="keterangan'+no_img+'" class="span2" onkeypress="return $(this).focusNextInputField(event);"></textarea><?php //echo CHtml::textArea('keterangan','', array('class'=>'span2 ', 'onkeypress'=>"return $(this).focusNextInputField(event);"));?><br>\n\</td>\n\
                                                    </tr>\n\
                                            </table>\n\
                                                    <input img-no="'+no_img+'" type="button" name="btnsave" value="Tambah" id="btnsave'+no_img+'" />\n\
                                                    <input img-no="'+no_img+'" type="button" name="btncancel" value="Cancel" id="btncancel'+no_img+'" /><br><br>\n\
                                            </div>\n\
                                    </div>';

          $( '[id^=tagit]' ).remove(); // menghapus titik lain selain titik current klik
          $( imgtag ).append(html);
          $( '#tagit'+no_img ).css({ top:mouseY, left:mouseX });

          $('#tagname'+no_img).focus();

          mouseY = mouseY.toFixed(7);
        mouseX = mouseX.toFixed(7);

        });


        $( document ).on( 'click',  '[id^=tagit] [id^=btnsave]', function(){
              var no_img = $(this).attr('img-no');
          var bagiantubuh_id = $('#bagiantubuh_id'+no_img).val();
          var keterangan = $('#keterangan'+no_img).val();
              var gambartubuh_id = $('#gambartubuh_id'+no_img).val();
                    var img = $('#imgtag'+no_img).find( 'img' );
                    var id = $( img ).attr( 'id' );
                    //var koorX = $( img ).attr( 'mousex' );
                    //var koorY = $( img ).attr( 'mousey' );
          $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('tambahBagianTubuh')?>",
            data: "pic_id=" + id + "&bagiantubuh_id=" + bagiantubuh_id + "&keterangan=" + keterangan + "&pic_x=" + mouseX + "&pic_y=" + mouseY + "&type=insert"+"&gambartubuh_id="+gambartubuh_id,
            dataType: "json",
            success: function(data){
                            if(data.pesan != ""){
                                    myAlert(data.pesan);
                            }else{
                                    $('#table-bagtubuh > tbody').append(data.form);
                                    renameInput($('#table-bagtubuh'));
                                    titikSebelumSimpan(data.axis['x'],data.axis['y'],data.bagiantubuh_id,'#imgtag'+no_img);
                            }
    //          viewtag( id );
              $('#tagit'+no_img).fadeOut();
                      $('#titikklik'+no_img).remove();
            },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
          });

        });

        $( document ).on( 'click', '[id^=tagit] [id^=btncancel]', function() {
              var no_img = $(this).attr('img-no');
          $('#tagit'+no_img).fadeOut();
          $('#titikklik'+no_img).remove();
        });

            // mouseover the taglist
            $('#taglist').on( 'mouseover', 'li', function( ) {
          id = $(this).attr("id");
          $('#view_' + id).css({ opacity: 1.0 });
        }).on( 'mouseout', 'li', function( ) {
            $('#view_' + id).css({ opacity: 0.0 });
        });

            // mouseover the tagboxes that is already there but opacity is 0.
            $( '#tagbox' ).on( 'mouseover', '.tagview', function( ) {
                    var pos = $( this ).position();
                    $(this).css({ opacity: 1.0 }); // div appears when opacity is set to 1.
            }).on( 'mouseout', '.tagview', function( ) {
                    $(this).css({ opacity: 0.0 }); // hide the div by setting opacity to 0.
            });

            // Remove tags.
        $( '#taglist' ).on('click', '.remove', function() {
          id = $(this).parent().attr("id");
          // Remove the tag
              $.ajax({
            type: "POST",
            url: "savetag.php",
            data: "tag_id=" + id + "&type=remove",
            success: function(data) {
                            var img = $('#imgtag').find( 'img' );
                            var id = $( img ).attr( 'id' );
                            //get tags if present
                            viewtag( id );
            }
          });
        });

            // load the tags for the image when page loads.
        var img = $('#imgtag').find( 'img' );
            var id = $( img ).attr( 'id' );

    });
</script>
