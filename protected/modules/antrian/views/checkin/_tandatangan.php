<div class="col-sm-12">
    <?php echo CHtml::hiddenField('no_sep', ''); ?>
    <div class="panel panel-primary" style="height: 150px;">
        <div class="panel-heading">
            <div class="panel-title">
                &nbsp;
            </div>

            <div class="panel-options" style="float:left;">
                <a href="javascript:void(0);"><label>Tools :</label></a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk menyimpam file gambar yang sudah dibuat" href="javascript:void(0);" id="open-image" data-rel="reload"><i class="glyphicon glyphicon-floppy-save"></i></a>
                <a class="nohref">||</a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk membuat garis pada bidang gambar" href="javascript:void(0);" id="tool-pencil"><i class="glyphicon glyphicon-pencil"></i></a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk menghapus pada bidang gambar" href="javascript:void(0);" id="tool-eraser"><i class="glyphicon glyphicon-trash"></i></a>
                <a class="nohref">||</a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 1" href="javascript:void(0);" class='tool' id="sizeTool-1" style="border: 1px solid;">
                    <svg width="10" height="10" version="1.1" data-reactid=".1.$1.0.0">
                        <circle cx="5" cy="5" r="0.5" data-reactid=".1.$1.0.0.0"></circle>
                    </svg>
                </a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 5" href="javascript:void(0);" class='tool' id="sizeTool-2" style="border: 1px solid;">
                    <svg width="10" height="10" version="1.1" data-reactid=".1.$5.0.0">
                        <circle cx="5" cy="5" r="2.5" data-reactid=".1.$5.0.0.0"></circle>
                    </svg>
                </a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 10" href="javascript:void(0);" class='tool' id="sizeTool-3" style="border: 1px solid;">
                    <svg width="10" height="10" version="1.1" data-reactid=".1.$10.0.0">
                        <circle cx="5" cy="5" r="3.5" data-reactid=".1.$10.0.0.0"></circle>
                    </svg>
                </a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengubah ukuran stroke = 15" href="javascript:void(0);" class='tool' id="sizeTool-4" style="border: 1px solid;">
                    <svg width="10" height="10" version="1.1" data-reactid=".1.$15.0.0">
                        <circle cx="5" cy="5" r="4.5" data-reactid=".1.$15.0.0.0"></circle>
                    </svg>
                </a>
                <a class="nohover"><label>||</label></a>
                <a class="tooltip-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengembalikan perubahan bidang gambar ke awal" href="javascript:void(0);" id="clear-lc" data-rel="reload"><i class="glyphicon glyphicon-refresh"></i></a>
            </div>
        </div>

        <div class="panel-body" style="height: 150px;">
            <div class="literally core" style="height: 150px;"></div>
            <div class="controls" style="height: 150px;">
            </div>
        </div>
    </div>
</div>
<script>

var lc = null;
    function beforeSubmit() {
        // convert gambar ke SVG
        var svgString = lc.getSVGString();
        $("#ttd_link").val(btoa(svgString));
            
        return true;
    }

    function hapusRow(obj){
        myConfirm("Apakah Anda yakin akan menghapus tanda tangan ini?","Perhatian!",function(r){
            if (r){
                $(obj).parents('tr').remove();    
            }
        });                    
    }

    function lihatImage(obj){
        var text = $(obj).parents('tr').find('.text_resep').val();
        
        $("#imageeResep").attr('src',text);
        $("#dialogLihatImg").dialog('open');
        
    }

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

    $(document).ready(function() {
        
        var lc = LC.init(document.getElementsByClassName('literally core')[0],
        {
            defaultStrokeWidth: 1,
        });
        
        $("#clear-lc").click(function() {
            lc.clear();
        });
        
        $("#open-image").click(function() {        
            
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('SimpanImage'); ?>',
                data: {
                    no_surat: $('#no_surat').val(),
                    image_text:lc.getImage({scale: 1, margin: {top: 10, right: 10, bottom: 10, left: 10}}).toDataURL()
                },
                dataType: "json",
                success:function(data){
                    if (data.pesan == ''){
                        $("#tampung_gambar2").append(data.html);
                        renameInput($("#tampung_gambar2"));

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
        });

        $("#open-image").click(function() {        
            
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('SimpanImage'); ?>',
                data: {
                    no_surat: $('#no_surat').val(),
                    image_text:lc.getImage({scale: 1, margin: {top: 10, right: 10, bottom: 10, left: 10}}).toDataURL()
                },
                dataType: "json",
                success:function(data){
                    if (data.pesan == ''){
                        $("#tampung_gambar2").append(data.html);
                        renameInput($("#tampung_gambar2"));

                        $("#tampung_gambar").append(data.html);
                        renameInput($("#tampung_gambar"));
                        lc.clear();

                        cekTandaTangan();
                    }else{
                        myAlert(data.pesan);
                    }
                    $("#iter").change();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });	
        });

        $("#btn-lanjutkan").click(function() {        
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('SimpanImage'); ?>',
                data: {
                    no_surat: $('#no_surat').val(),
                    image_text:lc.getImage({scale: 1, margin: {top: 10, right: 10, bottom: 10, left: 10}}).toDataURL()
                },
                dataType: "json",
                success:function(data){
                    if (data.pesan == ''){
                        $("#tampung_gambar2").append(data.html);
                        renameInput($("#tampung_gambar2"));

                        $("#tampung_gambar").append(data.html);
                        renameInput($("#tampung_gambar"));
                        lc.clear();

                        setTimeout(function(){
                            cekTandaTangan();
                        },500);
                    }else{
                        myAlert(data.pesan);
                    }
                    $("#iter").change();
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });	
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
    
        // setValidasiCekDisabled($("#daftar-mandiri-form"), function() {
        //     if ($("#tampung_gambar tr").length == 0){
        //         return false;
        //     }

        //     return true;
        // });
    });
</script>