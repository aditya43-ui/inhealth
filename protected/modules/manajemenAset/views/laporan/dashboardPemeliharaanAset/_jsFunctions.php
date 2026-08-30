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
    function generateGrafik(id,tipe, getdata, jenis, legend){        
                                                        
        var dtset = getdata;    
        var display_tick_xaxes = true;        
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;
        var attr_id = id.attr('id');
        
        if (tipe == 'pie' || tipe == 'doughnut'){
            display_tick_xaxes = false;
            display_tick_yaxes = false;
        }
        
        if (jenis == 'stacked'){
            stacked_yaxes = true;
        }
        
        if ( legend == 'off'){
            legend_display = false;
        }
           
       setTimeout(function(){
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
                tooltips: {
                    mode: 'index',
                    intersect: true
                },
                plugins: {
                    labels: {
                      render: function (args) {
                        if (tipe == 'pie'){
                            return args.label+'\n'+args.percentage+'%';
                        }else{
                            var label = args.value;
                            return label;
                        }                        
                      },                                            
                       fontColor: '#333',
                       fontStyle: 'bold',
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            display: display_tick_xaxes,
                            autoSkip: false,//                           
                        },
                        stacked: stacked_yaxes,
                    }],
                    yAxes: [{
                            display: display_tick_yaxes,
                            stacked: stacked_yaxes,                            
                            ticks: {                                
                                fontSize:13,
                                beginAtZero:true,                                                                                                
                            },                                                  
                    }]
                },
              }
        });   
       },300);  
                                                                        
    }
    
    function reset(height){
        $("#grafik-batang-10-aset-terbanyak").parents('.up').html("<canvas id='grafik-batang-10-aset-terbanyak' height='200px'></canvas>");
        $("#grafik-batang-10-aset-terbesar").parents('.up').html("<canvas id='grafik-batang-10-aset-terbesar' height='200px'></canvas>");
        $("#grafik-pie-hasil-aset-opname").parents('.up').html("<canvas id='grafik-pie-hasil-aset-opname' height='"+(parseInt(height)-95)+"px'></canvas>");
                
    }
       
    
//    function callDialog(obj){
//        $('#dialogDetail').dialog('open');        
//
//        $('#frameDialog').attr('src', $(obj).attr('ases-src'));				
//    }
    
    $(document).ready(function(){            
        var data = <?= json_encode($load['grafik']) ?>;
        generateGrafik($("#grafik-garis-corrective-preventive"),'line',data.default,'jenis');        
        generateGrafik($("#grafik-pie-level-resiko"),'pie',data.level_resiko,'jenis');        
        generateGrafik($("#grafik-pie-kondisi"),'pie',data.peralatan_kondisi,'jenis');                          
    });
            
</script>