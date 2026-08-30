<script>
   var genGrafik = (id,tipe, getdata, jenis, legend, is_print=false) => {
        var dtset = getdata;    
        var display_tick_xaxes = true;        
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;
        var print = {}
        if (is_print){
            print = function(){
                window.print();
                window.close();
            }
        }

        if (tipe == 'pie'){
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
                animation: {
                    onComplete: print
                },
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
                        intersect: false,
                },
                plugins: {
                    labels: {
                      render: function (args) {
//                        if (tipe == 'pie'){
//                            return args.label+'\n'+args.percentage+'%';
//                        }else{
//                            return args.value;
//                        }                        
                      },                                            
                       fontColor: '#333',
                       fontStyle: 'bold',
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            display: false
                        } ,
                    }],
                    yAxes: [{
                            display: display_tick_yaxes,
                            stacked: stacked_yaxes,                                                       
                    }]
                },
              }
        });   
       },300);  
   }
   
   var cariData = () => {    
       var tipe = $("#type").val();
       
       $(".form-data").addClass('animation-loading');
       $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('cariGrafikRekapitulasiPemeliharaanAset'); ?>',
            data: {
                tgl_awal: $("#<?php echo CHtml::activeId($model, 'tgl_awal'); ?>").val(),
                tgl_akhir: $("#<?php echo CHtml::activeId($model, 'tgl_akhir'); ?>").val(),
                gedung_id: $(".gedung_id").val(),
                lokasi_id: $(".lokasi_id").val(),
                ruangan_id: $(".ruangan_id").val(),
                tipe: tipe
            },
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){                                                            
                    
                    $("#satugrafik-batang").parents(".form-data").html("<canvas id='satugrafik-batang' width='1000px'></canvas>");
                    
                    genGrafik($("#satugrafik-batang"),tipe,data.grafik);    
                                        
                    $(".form-data").removeClass('animation-loading');
                }else{
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
   }
   
   
   
   
   var setType = (obj) => {
        let tipe = $(obj).attr('type');
        $("#type").val(tipe);
        $(obj).parents("ul").find("li").each(function(){
            $(this).removeClass("active");
        });
        $(obj).addClass("active");
       
       cariData(tipe);
   }
</script>