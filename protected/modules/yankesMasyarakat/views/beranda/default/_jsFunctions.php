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
    var randomScalingFactor = function() {
            return Math.round(Math.random() * 100);
    };

    
    function generateGrafik(id,tipe, getdata, jenis, datalabel,legend_cek){        
        var det_datalabel = {                
                formatter: function(value, context) {                            
                    return '';
                }
            };
        var dtset = getdata;    
        var display_tick_xaxes = true;  
        var display_tick_yaxes = true;
        var legend_display = true;
        var ticks_load = {
            min: 0,
        };     
        if (datalabel == true){
            det_datalabel = {
                anchor: 'start',	
                align : 'bottom',
                color: '#333',                        
                font: {
                    weight: 'bold',
                    family: 'arial',
                    size:'13'
                },
                formatter: function(value, context) {                            
                    return context.dataset.label;
                }
            };
        }
        if (tipe == 'pie'){
            display_tick_xaxes = false;
        }else if(tipe == 'area'){            
            tipe = 'line';
        }else if(tipe == 'doughnut'){
            display_tick_yaxes =false;
            display_tick_xaxes = false;                        
        }
        if (legend_cek == 'custom' || legend_cek == 'nolegend'){
            legend_display = false;
        }
        
        if (jenis == 'tigagrafik'){
            ticks_load = {
                min: 0
            };  
        }                
        var grafikTiga = new Chart(id,{
            type: tipe,            
            data: dtset,
            options: {                
                responsive: true,
                title: {
                    display: true,
                    text: ''
                },
                legend: {
                    display:legend_display,
                    position:'right'
                },                
//                legendCallback: function(chart) {                    
//                    var ul = document.createElement('table');                    
//                    if (chart.data.labels.length > 0) {                        
//                        var color = chart.data.color;  
//                        chart.data.labels.forEach(function(label, index) {                              
//                           //ul.innerHTML += "<li  class=''  onclick='cekLegend($(\"#"+$(obj).attr('id')+"\"),"+index+",\"capaiankompetensi\",this)'><span style='background-color:"+backgroundColor[index]+";'></span><label index='"+index+"' value='"+dataChart[index]+"' bgcolor='"+backgroundColor[index]+"'>"+label+"</label></li>"; 
//                           ul.innerHTML += "<tr><td><span class='legend-ul-span' style='background-color:"+color[index]+";'></span></td><td><label index='"+index+"' value='"+label+"' bgcolor='"+color[index]+"'>"+label+"</label></td></tr>"; 
//                        });
//                    }                    
//                    return ul.outerHTML;
//                    
//                 },
                tooltips: {
                        mode: 'index',
                        intersect: false,
                },
                plugins: {
                    labels: {
                      render: function (args) {
                          
                        if (tipe == 'pie' || tipe == 'doughnut'){                            
                            return args.label+'\n'+args.percentage+'%';
                        }else{
                            return args.value;
                        }                        
                      },                                            
                       fontColor: '#333',
                       fontStyle: 'bold',
                    },
                    datalabels: det_datalabel
                },                
                scales: {
                    type:'linear',
                    xAxes: [{
                        ticks: {
                            display: display_tick_xaxes,     
                            fontColor: "#333",
                            userCallback: function(value, index) {                                
                                return value;
                            },                            
                        }                        
                    }],
                    yAxes: [{
                        stacked: false,
                        ticks: ticks_load,
                        display:display_tick_yaxes
                    }]
                },
              }
        });    
        
        if (legend_cek == 'custom'){                    
            //$("#legend-"+$(id).attr('id')).html(grafikTiga.generateLegend());
        }
    }
    
//    function setIndikator(){                
//        $.ajax({
//            type:'POST',
//            url:'<?php echo $this->createUrl('cariData'); ?>',
//            data: {tgl_awal: $("#<?php echo CHtml::activeId($model, 'tgl_awal'); ?>").val(),tgl_akhir: $("#<?php echo CHtml::activeId($model, 'tgl_akhir'); ?>").val()},
//            dataType: "json",
//            success:function(data){
//                if (data.sukses == 1){
//                    $("#tile1").html(data.tile.aktif);
//                    $("#tile2").html(data.tile.addendum);
//                    $("#tile3").html(data.tile.monev);
//                    $("#tile4").html(data.tile.jadwalmonevtk2);
//                    $("#tile5").html(data.tile.jadwalmonevtk3);
//                    
//                    generateGrafik($("#link-pieprogram"),data.pie.program);
//                    generateGrafik($("#link-piekategori"),data.pie.kategori);
//                    generateGrafik($("#link-piegolongan"),data.pie.golongan);
//                    generateGrafik($("#link-piejenis"),data.pie.jenis);
//                    generateGrafik($("#link-piestatus"),data.pie.status);
//                }else{
//                    myAlert(data.pesan);
//                }
//            },
//            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
//        });
//         
//    }
    
//    function callDialog(obj){
//        $('#dialogDetail').dialog('open');        
//
//        $('#frameDialog').attr('src', $(obj).attr('ases-src'));				
//    }
    
    $(document).ready(function(){
        
        var dataset = <?php echo json_encode($grafik) ?>;
        
        generateGrafik($("#duagrafik-tingkatresiko-bulanini"),'bar',dataset.tingkatresiko_bulanini,'',true,'nolegend');        
        generateGrafik($("#duagrafik-tingkatresiko-triwulan"),'bar',dataset.tingkatresiko_triwulan,'',true,'custom');        
        
        generateGrafik($("#duagrafik-tiperesiko-triwulan"),'bar',dataset.tiperesiko_triwulan,'',true,'custom');        
        generateGrafik($("#duagrafik-statusregister-triwulan"),'bar',dataset.statusregister_triwulan,'',true,'custom');        
                
        generateGrafik($("#tigagrafik-line"),'line',dataset.tigagrafik.garis, 'tigagrafik');
        generateGrafik($("#tigagrafik-doughnut"),'doughnut',dataset.tigagrafik.doughnut, 'tigagrafik');
        generateGrafik($("#tigagrafik-area"),'area',dataset.tigagrafik.area, 'tigagrafik');
        
    });
            
</script>