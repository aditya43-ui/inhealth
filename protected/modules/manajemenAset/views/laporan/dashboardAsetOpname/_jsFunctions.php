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
                    intersect: true,     
                    callbacks: {
                        label: function(tooltipItem, chart) {   
                            if (tipe != 'doughnut'){
                                return tooltipItem.xLabel+" : "+tooltipItem.yLabel;
                            }else{                                
                                var label = chart.datasets[0].label[tooltipItem.index];
                                var value = chart.datasets[0].data[tooltipItem.index];
                                return label+' : '+value;
                            }
                        },
                        labelColor: function(tooltipItem, chart) {
                            var color = chart.config.data.datasets[0].backgroundColor[tooltipItem.index];
                            return {
                                backgroundColor: color
                            }
                        },                        
                    }
                },
                plugins: {
                    labels: {
                      render: function (args) {
                        if (tipe == 'doughnut'){
                            return args.label+'\n'+args.percentage+'%';
                        }else{
                            var label = args.value;
                            if (attr_id != 'grafik-batang-10-aset-terbanyak'){
                                    var jt = parseInt(label)/1000000;                                    
                                    if (label > 0){
                                        if (label>1000000){
                                            return jt.toFixed(0)+' jt';
                                        }else{
                                            return jt.toFixed(2)+' jt';
                                        }
                                    }else{
                                        return 0;
                                    }
                                }else{
                                    return label;
                                }
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
                            autoSkip: false,
//                            maxRotation: 90,
//                            minRotation: 90
                        },
                        stacked: stacked_yaxes,
                    }],
                    yAxes: [{
                            display: display_tick_yaxes,
                            stacked: stacked_yaxes,                            
                            ticks: {                                
                                fontSize:13,
                                beginAtZero:true,                                                                
                                callback: function(label, index, labels) {   
                                    
                                    if (attr_id != 'grafik-batang-10-aset-terbanyak'){
                                        var jt = parseInt(label)/1000000;                                    
                                        if (label > 0){
                                            if (label>1000000){
                                                return jt.toFixed(0)+' jt';
                                            }else{
                                                return jt.toFixed(2)+' jt';
                                            }
                                        }else{
                                            return 0;
                                        }
                                    }else{
                                        return label;
                                    }
                                  
                                }
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
    
    function cariData(){      
        
        
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('CariDashboardAsetOpname'); ?>',
            data: {
                periodeasetopname_id: $("#<?php echo CHtml::activeId($model, 'periodeasetopname_id'); ?>").val()                
            },            
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){
                                                                                                     
                    $.fn.yiiGridView.update('invperalatan-grid', {
                        data: {
                            'MAInvperalatanT[tgl_awal]':data.tgl_awal,
                            'MAInvperalatanT[tgl_akhir]':data.tgl_akhir,
                        }
                    });      
                    
                    
                    setTimeout(function(){
                        var clientHeight = document.getElementById("invperalatan-grid").clientHeight;
                        reset(clientHeight);
                        
                        setGrafik(data);
                    },1000);
                    
                }else{
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
         
    }
    
    var setGrafik = (data) => {
        $("#tile-inven").html(data.tile.teriventarisasi);
        $("#tile-sudah").html(data.tile.sudah_opname);
        $("#tile-belum").html(data.tile.belum_opname);
        $("#tile-inven-baru").html(data.tile.teriventarisasi_baru);
        
        generateGrafik($("#grafik-batang-10-aset-terbanyak"),'bar',data.grafik.jumlah_aset_terbanyak,'jenis','off');        
        generateGrafik($("#grafik-batang-10-aset-terbesar"),'bar',data.grafik.aset_terbanyak,'jenis','off');        
        generateGrafik($("#grafik-pie-hasil-aset-opname"),'doughnut',data.grafik.hasil_aset,'jenis','off');                        
    }
    
//    function callDialog(obj){
//        $('#dialogDetail').dialog('open');        
//
//        $('#frameDialog').attr('src', $(obj).attr('ases-src'));				
//    }
    
    $(document).ready(function(){        
        setTimeout(function(){
            cariData();
        },500);        
    });
            
</script>