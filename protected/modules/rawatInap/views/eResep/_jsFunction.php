<?php
    $controller = Yii::app()->controller->id; 
    $module = Yii::app()->controller->module->id;
?>
<script>

var lc = null;

function setDokterReseptur(nama, id) {
    $("#<?php echo CHtml::activeId($modReseptur, 'pegawai_nama') ?>").val(nama);
    $("#pegawai_reseptur").val(id);
    $("#iter").change();
    $("#dialogDokterDPJP").dialog("close");
}    

function beforeSubmit() {
    
    // convert gambar ke SVG
    var svgString = lc.getSVGString();
    
    $("#e_resep_data").val(btoa(svgString));

        
    return true;
}

function hapusRow(obj){
    myConfirm("Apakah Anda yakin akan menghapus eResep ini?","Perhatian!",function(r){
        if (r){
            $(obj).parents('tr').remove();    
        }
    });                    
}

function viewDetailResep(idReseptur,pendaftaran_id)
{
    $("#dialogGallery").dialog("open");
}

function lihatImage(obj){
    var text = $(obj).parents('tr').find('.text_resep').val();
    
    $("#imageeResep").attr('src',text);
    $("#dialogLihatImg").dialog('open');
    
}

/**
* rename input grid
*/ 
function renameInput(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        var name_img = $(this).find(".text_image").val();
        var split_img = name_img.split("_");
                        
        
        $(this).find(".text_image").val(split_img[0]+'_'+split_img[1]+'_R'+(row+1)+'_'+split_img[3]);
               
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

function printResep(caraPrint){
    alert('under construction');
}

$(document).ready(function() {
    
    <?php if ($modReseptur->isNewRecord): ?>
    
    //lc = LC.init(
            
      //  document.getElementsByClassName('literally')[0],
        //{
          //  imageURLPrefix: 'js/literallycanvas/img',
           // tools: [
             //   LC.tools.Pencil, 
               // LC.tools.Eraser
           // ],     
           // defaultStrokeWidth: 1
       // }
    //);
        
    
    var lc = LC.init(document.getElementsByClassName('literally core')[0],
    {
        defaultStrokeWidth: 1,
        /*backgroundShapes: [        
            LC.createShape(
              'Text', {
                x: 10, y: 30, text: "R1",
                font: "12px Helvetica"
              })
          ]*/

    }
    );
    
    $("#clear-lc").click(function() {
        lc.clear();
    });
    
    $("#open-image").click(function() {        
        
        var pendaftaran_id = $('#<?php echo CHtml::activeId($modKunjungan, 'pendaftaran_id') ?>').val();
        
        if (pendaftaran_id != ''){
            $.ajax({
               type:'POST',
               url:'<?php echo $this->createUrl('SimpanImage'); ?>',
               data: {
                    no_pendaftaran: $('#<?php echo CHtml::activeId($modKunjungan, 'no_pendaftaran') ?>').val(),
                    no_rekam_medik: $('#<?php echo CHtml::activeId($modKunjungan, 'no_rekam_medik') ?>').val(),
                    image_text:lc.getImage({scale: 1, margin: {top: 10, right: 10, bottom: 10, left: 10}}).toDataURL()
                },
               dataType: "json",
               success:function(data){
                   if (data.pesan == ''){
                       $("#tampung_gambar").append(data.html);
                       renameInput($("#tampung_gambar"));
                        lc.clear();
                   }else{
                       myAlert(data.pesan);
                   }
                   $("#iter").change();
               },
               error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });	
        }else{
            toastr.warning("Data pasien belum diisi!");
        }
        //window.open(lc.getImage({
          //scale: 1, margin: {top: 10, right: 10, bottom: 10, left: 10}
        //}).toDataURL());
    });
    
    
 
    var tools = [
      {
        name: 'pencil',
        el: document.getElementById('tool-pencil'),
        tool: new LC.tools.Pencil(lc)
      },
      {
        name: 'eraser',
        el: document.getElementById('tool-eraser'),
        tool: new LC.tools.Eraser(lc)
      },            
    ];
    
     var strokeWidths = [
          {
            name: 1,
            el: document.getElementById('sizeTool-1'),
            size: 1
          },{
            name: 5,
            el: document.getElementById('sizeTool-2'),
            size: 5
          },{
            name: 10,
            el: document.getElementById('sizeTool-3'),
            size: 10
          },{          
            name: 15,
            el: document.getElementById('sizeTool-4'),
            size: 15
          }
        ];

    setCurrentByName = function(ary, val) {
          ary.forEach(function(i) {
            $(i.el).toggleClass('current', (i.name == val));
          });
        };

        findByName = function(ary, val) {
          var vals;
          vals = ary.filter(function(v){
            return v.name == val;
          });
          if ( vals.length == 0 )
            return null;
          else
            return vals[0];
        };

        // Wire tools
        tools.forEach(function(t) {
          $(t.el).click(function() {
            var sw;

            lc.setTool(t.tool);
            setCurrentByName(tools, t.name);
            setCurrentByName(strokeWidths, t.tool.strokeWidth);
            $('#tools-sizes').toggleClass('disabled', (t.name == 'text'));
          });
        });
        setCurrentByName(tools, tools[0].name);

        // Wire Stroke Widths
        // NOTE: This will not work until the stroke width PR is merged...
        strokeWidths.forEach(function(sw) {
          $(sw.el).click(function() {
            lc.trigger('setStrokeWidth', sw.size);
            setCurrentByName(strokeWidths, sw.name);
          })
        })
        setCurrentByName(strokeWidths, strokeWidths[0].name);
    //setCurrentByName(strokeWidths, strokeWidths[0].name);
    
  
    <?php endif; ?>

    setValidasiCekDisabled($("#pelayananpasien-form"), function() {
            if ($("#tampung_gambar tr").length == 0){
                return false;
            }

            return true;
     });
});

</script>

