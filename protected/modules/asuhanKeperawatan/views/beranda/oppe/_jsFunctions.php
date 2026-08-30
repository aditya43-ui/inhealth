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
    function setDialog(dlg){                        
        $("#"+dlg).dialog('open');
    }
    
    function setPegawai(data, obj){        
                
        $("#<?php echo CHtml::activeId($model, 'pegawai_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>").val(data.nama_pegawai);

        $("#dialogPetugas").dialog('close');

    }
    
     function setSMF(data, obj){        
                
        $("#<?php echo CHtml::activeId($model, 'smf_id') ?>").val(data.unitkerja_id);
        $("#<?php echo CHtml::activeId($model, 'smf_nama') ?>").val(data.namaunitkerja);

        $("#dialogUnitKerja").dialog('close');

    }
            
    function generateGrafik(idgrafik, getdata,title,legend, jenis, tick, custom_tooltip, legend){                
        var dtset = getdata;    
        var tips = custom_tooltip;
        
        $(".clear"+jenis).html("<canvas id='"+idgrafik+"'></canvas>");
        $(".loading-"+jenis).addClass("animation-loading");
        
        $("#"+idgrafik).html('');        
        
      
        
        var barChart = new Chart(idgrafik,{
            type: 'bar',            
            data: dtset,
            options: {                       
                responsive: true,
                title: {
                    display: true,
                    text: title,
                    fontSize: 15
                },
                legend: {
                    display:legend,
                    position:'bottom'
                }, 
                tooltips: {                    
                    mode: 'index',                    
                    intersect: false,
                    callbacks: {
                        title: function(tooltipItems, data) {                                                        
                            var kalimat = [data.labels[tooltipItems[0].index]];
                            if (tips.title[tooltipItems[0].index] == ''){
                                return kalimat;
                            }else{
                                return tips.title[tooltipItems[0].index]+' - '+kalimat+'';
                            }
                        },    
                        label: function(tooltipItem, data) {                            
                            return data.datasets[tooltipItem.datasetIndex].label+' : '+tooltipItem.yLabel.toFixed(2);
                        }
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            display: false
                        }                        
                    }],
                    yAxes: [{
                            stacked: false,
                            ticks: tick,                           
                    }]
                },
                plugins: {
                    datalabels: {
			anchor: 'start',	
                        align : 'top',
			color: '#ffff',
                        backgroundColor:'#d31313',
			font: {
                            weight: 'bold',
                            family: 'arial',
                            size:'13'
			},
                        rotation:270,
                        clip:true,
                        formatter: function(value, context) {                            
                            return context.dataset.label;
                        }
                    }
                },
                legend: false,
                legendCallback: function(chart) {                    
                    var ul = document.createElement('table');
                    console.log(chart.data.datasets);
                    if (chart.data.labels.length > 0) {
                        var backgroundColor = chart.data.datasets[0].backgroundColor;                    
                        var backgroundColor2 = chart.data.datasets[1].backgroundColor;                    
                        var dataChart = chart.data.datasets[1].data;  
                        chart.data.labels.forEach(function(label, index) {                              
                           //ul.innerHTML += "<li  class=''  onclick='cekLegend($(\"#"+$(obj).attr('id')+"\"),"+index+",\"capaiankompetensi\",this)'><span style='background-color:"+backgroundColor[index]+";'></span><label index='"+index+"' value='"+dataChart[index]+"' bgcolor='"+backgroundColor[index]+"'>"+label+"</label></li>"; 
                           ul.innerHTML += "<tr><td><span class='legend-ul-span' style='background-color:"+backgroundColor[index]+";'></span><span class='legend-ul-span' style='background-color:"+backgroundColor2[index]+";'></span></td><td><label index='"+index+"' value='"+dataChart[index]+"' bgcolor='"+backgroundColor[index]+"'>"+label+"</label></td></tr>"; 
                        });
                    }                    
                    return ul.outerHTML;
                    
                 },
              }
        });    
        
       // if (typeof skip === 'undefined'){
        
            $("#"+legend).html(barChart.generateLegend());
      //  }else{
            
     //   }
        
        $(".loading-"+jenis).removeClass("animation-loading");
    }
    
    function cekLegend(obj, index, jenis,obj_li){
        var id = $(obj).attr('id');
        var li = $(obj_li);
        var tipe = li.attr('tipegrafik');
        
        if (li.find("label").hasClass('legend-hide')){
            li.find("label").removeClass('legend-hide');
        }else{
            li.find("label").addClass('legend-hide');
        }
    
        if(jenis == 'capaiankompetensi'){            
            if (tipe == 'legenddetail'){                
                $("#cleargrafik").html("<canvas id= 'detaildatagrafik'></canvas>");
                barCapaianKompetensi($("#"+id),true,legend_detail,tipe,'skip');
            }else{                
                $("#grafik_capaian_kompetensi").html("<canvas id= 'capaian_kompetensi'></canvas>");
                barCapaianKompetensi($("#"+id),true,legend_capaian_kompetensi,tipe,'skip');
            }            
        }else if(jenis == 'publikasi'){                    
            if (tipe == 'legenddetail'){                
                $("#cleargrafik").html("<canvas id= 'detaildatagrafik'></canvas>");
                barPublikasi($("#"+id),true,legend_detail,tipe,'skip');
            }else{                
                $("#grafik_ppds_publikasi").html("<canvas id= 'ppds_publikasi'></canvas>");
                barPublikasi($("#"+id),true,legend_publikasi,tipe,'skip');
            }
        }
    }
    
    function cariData(){                
        $(".reset-grafik").addClass('animation-loading');
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('cariData'); ?>',
            data: {
                tgl_awal: $("#<?php echo CHtml::activeId($model, 'tgl_awal'); ?>").val(),
                tgl_akhir: $("#<?php echo CHtml::activeId($model, 'tgl_akhir'); ?>").val(),
                smf_nama: $("#<?php echo CHtml::activeId($model, 'smf_nama'); ?>").val(),
                dokter: $("#<?php echo CHtml::activeId($model, 'nama_pegawai'); ?>").val(),
                smf_id: $("#<?php echo CHtml::activeId($model, 'smf_id'); ?>").val(),
                pegawai_id: $("#<?php echo CHtml::activeId($model, 'pegawai_id'); ?>").val(),
            },
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){   
                    $(".reset-grafik").html();
                    $(".reset-grafik").html(data.div_grafik);                    
                    setTimeout(function(){
                        <?php 
                            foreach(LookupM::getItemsUrutan('golongan_indikator') as $k => $val){
                                $iden = strtolower(str_replace(" ","_",$k));                                                                    
                        ?>
                                if (typeof data.list['<?php echo $iden ?>'] !== 'undefined'){                                    
                                                                        
                                    $.each(data.list['<?php echo $iden ?>'],function(index,value){
                                        var dataset = data.grafik;                                        
                                        var ticks = {
                                            min: 0,
                                            max: 100,
                                            stepSize: 20,
                                            fontSize:11,            
                                        }      
                                        
                                                                                
                                        generateGrafik('bar-perilaku'+index,dataset.<?php echo $iden; ?>[index],value,true,'<?php echo $iden; ?>'+index,ticks,data.tooltip['<?php echo $iden ?>'][index],'legend_perilaku<?php echo $iden ?>'+index);      
                                    });                                        
                                }
                        <?php                                                                    
                            }
                        ?>
                    },500);
                    $(".reset-grafik").removeClass('animation-loading');
                }else{
                    myAlert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
         
    }   
    
    $(document).ready(function(){        
        <?php 
            foreach(LookupM::getItemsUrutan('golongan_indikator') as $k => $val){
                $iden = strtolower(str_replace(" ","_",$k));
                if (isset($data_grafik['list'][$iden])){
                    foreach ($data_grafik['list'][$iden] as $key => $val){
        ?>
                        var dataset = <?php echo json_encode($data_grafik) ?>;
                        var custom_tooltip = <?php echo json_encode($data_grafik['tooltip']); ?>;

                        var ticks = {
                            min: 0,
                            max: 100,
                            stepSize: 20,
                            fontSize:15,            
                        }                                                
                        
                        generateGrafik('bar-perilaku<?php echo $key; ?>',dataset.grafik.<?php echo $iden; ?>[<?php echo $key; ?>],'<?php echo $val; ?>',true,'<?php echo $iden.$key; ?>',ticks, custom_tooltip.<?php echo $iden; ?>[<?php echo $key; ?>],'legend_perilaku<?php echo $iden.$key ?>');                                                        
        <?php
                    }
                }
            }
        ?>
    });
            
</script>