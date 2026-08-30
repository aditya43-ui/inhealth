<?php
/**
 * menampung fungsi - fungsi javascript;
 * issue RSST-2633
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 * 
*/
?>

<script type="text/javascript">    
    function generateGrafik(obj, getdata, via){
        var program = $(obj).attr('idgrafik');
        var kategori = $(obj).attr('idgrafik');
        var jenis = $(obj).attr('idgrafik');
        var statuspenelitian = $(obj).attr('idgrafik');
        
        var dtset = getdata;                
                                                                                                                 
        var pieProgram = new Chart(program,{
            type: 'pie',            
            data: dtset,
            options: {                
                responsive: true,
                title: {
                    display: true,
                    text: ''
                },
                legend: {
                    display:true,
                    position:'right'
                },
                plugins: {
                    labels: {
                      render: function (args) {
                        return args.label+'\n'+args.percentage+'%';
                      },                                            
                       fontColor: '#fff',
                       fontStyle: 'bold',
                    }
                  }
              }
        });                                                                   
    }
    
    function setIndikator(){                
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('cariData'); ?>',
            data: {tgl_awal: $("#<?php echo CHtml::activeId($model, 'tgl_awal'); ?>").val(),tgl_akhir: $("#<?php echo CHtml::activeId($model, 'tgl_akhir'); ?>").val()},
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){
                    $("#tile1").html(data.tile.aktif);
                    $("#tile2").html(data.tile.addendum);
                    $("#tile3").html(data.tile.monev);
                    $("#tile4").html(data.tile.jadwalmonevtk2);
                    $("#tile5").html(data.tile.jadwalmonevtk3);
                    
                    generateGrafik($("#link-pieprogram"),data.pie.program);
                    generateGrafik($("#link-piekategori"),data.pie.kategori);
                    generateGrafik($("#link-piegolongan"),data.pie.golongan);
                    generateGrafik($("#link-piejenis"),data.pie.jenis);
                    generateGrafik($("#link-piestatus"),data.pie.status);
                }else{
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
         
    }
    
    function callDialog(obj){
        $('#dialogDetail').dialog('open');        

        $('#frameDialog').attr('src', $(obj).attr('ases-src'));				
    }
    
    $(document).ready(function(){
        
        var dataset = <?php echo json_encode($grafik) ?>;
        
        generateGrafik($("#link-pieprogram"),dataset.pie.program);
        generateGrafik($("#link-piekategori"),dataset.pie.kategori);
        generateGrafik($("#link-piegolongan"),dataset.pie.golongan);
        generateGrafik($("#link-piejenis"),dataset.pie.jenis);
        generateGrafik($("#link-piestatus"),dataset.pie.status);
    });
            
</script>