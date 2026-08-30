<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - digunakan menampilkan monitoring partograf
* RSST-1603
*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);

?>
<p>&nbsp;</p>
      
<div class="col-sm-11">
   <canvas id="chart_djj"> </canvas>
</div>

<div class="clear"></div>

<div class="col-sm-11">
   <canvas id="chart_serviks"> </canvas>
</div>

<div class="clear"></div>

<div class="col-sm-11">
    <div id="js-legend" class="chart-legend" style="text-align:center;"></div>
   <canvas id="chart_kontraksi"> </canvas>
</div>

<div class="clear"></div>

<div class="col-sm-11">
   <canvas id="chart_tensi"> </canvas>
</div>                  
        

<script>
    function newDate(hour) {
            return moment('<?php echo date("Y-m-d 08:00:00", strtotime($model->tglperiksa)); ?>').add(hour, 'hours').toDate();
    }     

    
  function generateGrafik(){
        var djj = $("#chart_djj");        
        var serviks = $("#chart_serviks");
        var kontraksi = $("#chart_kontraksi");        
        var tensi = $("#chart_tensi"); 
                
        var i = 0;//untuk djj
        var j = 0;//untuk serviks
        var k = 0;//untuk turunya kepala
        var l = 0;//untuk kontraksi jumlah
        var m = 0;//untuk kontraksi lama      
        var n = 0;//untuk suhu
        var o = 0;//untuk nadi
        var p = 0;//untuk diastolic
        var q = 0;//untuk systolic
        var r = 0;//untuk garis tekanand darah
        var w = 0;//untuk counter waktu
        var arr = [];//untuk djj
        var arrServiks = [];//untuk pembukaan serviks
        var arrTurun = [];//untuk turunya kepala
        var arrKontraksi = [];//untuk jumlah kontraksi        
        var arrKontraksiCol = [];//untuk warna kontraksi                
        var arrSuhu = [];//untuk pencatatan suhu
        var arrNadi = [];//untuk pencatatan nadi 
        var arrDias = [];//untuk pencatatan diastolic
        var arrSys = [];//untuk pencatatan systolic
        var arrAnno = [];//untuk mengenerate tekanan darah dalam bentuk line i garis vertical
        var arrTgl = [];//default tanggal yang ditampilkan per 1 jam dari jam 08:00 sampai 23:00
        var arrWaktu = [];//untuk menangkap waktu jam
        
        $("#tabel-partograf-detail > tbody > tr.periksaCatatWaktu > td:not(.label-periksa)").each(function(){
            //waktu            
            if ($(this).find(".waktucatat").val() != ''){                
                arrWaktu[w] = $(this).find(".waktucatat").val();    
                w++;
            }                                           
        });
                
        
        $("#tabel-partograf-detail > tbody > tr.periksaKepala > td:not(.label-periksa)").each(function(){
            //turunya kepala
            if (typeof arrWaktu[k] != 'undefined' && $(this).find(".turunkepala").val() != ''){            
                arrTurun[k] ={ 
                    x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[k],
                    y: $(this).find(".turunkepala").val()
                    };    
                k++;
            }  
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaServiks > td:not(.label-periksa)").each(function(){               
            //serviks
            if (typeof arrWaktu[j] != 'undefined' && $(this).find(".serviks").val() != ''){
                arrServiks[j] ={ 
                    x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[j],
                    y: $(this).find(".serviks").val()

                    };    
                j++;
            }                            
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaDjj > td:not(.label-periksa)").each(function(){
            if (typeof arrWaktu[i] != 'undefined' && $(this).find(".djj").val() != ''){
                arr[i] ={ 
                        x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[i],
                        y: $(this).find(".djj").val()
                };    
                i++;
            }
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaKontraksiJumlah > td:not(.label-periksa)").each(function(){
            if (typeof arrWaktu[l] != 'undefined' && $(this).find(".kontraksijumlah").val() != ''){
                arrKontraksi[l] ={ 
                        x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[l],
                        y: $(this).find(".kontraksijumlah").val()
                };    
                l++;
            }
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaKontraksiDetik > td:not(.label-periksa)").each(function(){
            if (typeof arrWaktu[m] != 'undefined' && $(this).find(".kontraksidetik").val() != ''){
                if ($(this).find(".kontraksidetik").val() == '<?php echo Params::PARTOGRAF_KONTRAK_KURANG ?>'){
                    var color = 'blue';
                }else if ($(this).find(".kontraksidetik").val() == '<?php echo Params::PARTOGRAF_KONTRAK_SD ?>'){
                    var color = 'red';
                }else if ($(this).find(".kontraksidetik").val() == '<?php echo Params::PARTOGRAF_KONTRAK_LEBIH ?>'){
                    var color = '#b7b7b7';
                }
                
                arrKontraksiCol[m] =color;
                m++;
            }
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaSuhu > td:not(.label-periksa)").each(function(){
            if (typeof arrWaktu[n] != 'undefined' && $(this).find(".suhu").val() != ''){
                arrSuhu[n] ={ 
                        x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[n],
                        y: $(this).find(".suhu").val()
                };    
                n++;
            }
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaNadi > td:not(.label-periksa)").each(function(){
            //nadi
            if (typeof arrWaktu[o] != 'undefined'&& $(this).find(".p6nadi").val() != ''){            
                arrNadi[o] ={ 
                    x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[o],
                    y: $(this).find(".p6nadi").val(),                    
                    };    
                o++;
            }
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaTekananDarah > td:not(.label-periksa)").each(function(){
            //nadi
            if (typeof arrWaktu[p] != 'undefined'&& $(this).find(".diastolic").val() != ''){            
                arrDias[p] ={ 
                    x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[p],
                    y: $(this).find(".diastolic").val(),                    
                    };    
                p++;
            }
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaTekananDarah > td:not(.label-periksa)").each(function(){
            //nadi
            if (typeof arrWaktu[q] != 'undefined'&& $(this).find(".systolic").val() != ''){            
                arrSys[q] ={ 
                    x: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[q],
                    y: $(this).find(".systolic").val(),                    
                    };    
                q++;
            }
        });
        
        $("#tabel-partograf-detail > tbody > tr.periksaTekananDarah > td:not(.label-periksa)").each(function(){
             //garis tekanan darah
            if (typeof arrWaktu[r] != 'undefined' && $(this).find(".systolic").val() != '' && $(this).find(".diastolic").val() != ''){            
                arrAnno[r] ={ 
                    type: 'box',
                    drawTime: 'beforeDatasetsDraw',                            
                    xScaleID: 'x-axis-0',
                    yScaleID: 'A',
                    xMin: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[r],
                    xMax: '<?php echo date("Y-m-d", strtotime($model->tglperiksa)); ?> '+arrWaktu[r],
                    yMax: parseInt($(this).find(".diastolic").val()),
                    yMin:  parseInt($(this).find(".systolic").val()),
                    borderColor: '#ED3237',
                    borderWidth: 4,
                    backgroundColor: '#ED3237',
                    };       
                r++;
            }
        });                
        
        for(var a=0;a <= 15;a++){
            arrTgl[a] = newDate(a);            
        }
                    
            var lineChart = new Chart(djj, {
                type: 'line',
                data: {
                    labels: arrTgl,
                    datasets: [{
                        display: false,
                        fill: false,
                        data: arr,
                        backgroundColor: 'blue',
                        //pointStyle: 'rectRot',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',                    
                        fill: false,
                        borderColor: "blue",                    
                        backgroundColor: "blue",                                                       
                    }]
                },			
                options: {
                     layout: {
                        padding: {
                            left: 50,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    tooltips: {
                            mode: 'nearest',
                            intersect: false,
                    },
                    legend: {
                        display: false,                   
                    },
                    responsive: true,
                    title: {
                            display: true,
                            text: 'Denyut Jantung Janin'
                    },
                    scales: {
                        xAxes: [{
                            type: "time",
                            time: {                                 
                                displayFormats: {
                                  hour: 'HH:mm',
                                  minute: 'HH:mm'
                                },           
                                tooltipFormat: 'MMM D - HH:mm'
                            },
                            scaleLabel: {
                                    display: true,
                                    labelString: 'Jam'
                            },                           
                            ticks: {                                                       
                                fontSize:11
                            },
                            gridLines: {
                                offsetGridLines: true
                            }
                        }],  
                         yAxes: [{
                            ticks: {
                                    min: 100,
                                    max: 180,
                                    stepSize: 10,
                                    fontSize:11
                            },

                        }],                    
                    },
                 
                }
            }); 
                                                      
                       
            //$(serviks).parents('div').attr('style','display:block;');
            var imgX = new Image();
            imgX.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/x2.png'; ?>';
            
            var imgO = new Image();
            imgO.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/02.png'; ?>';
            
            var imgPA = new Image();
            imgPA.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/pa2.png'; ?>';
            
            var imgDA = new Image();
            imgDA.src ='<?php echo Yii::app()->getBaseUrl('webroot').'/images/da2.png'; ?>';
                        
            
            var lineServiks = new Chart(serviks, {
                type: 'line',
                data: {
                    labels: arrTgl,
                    datasets: [{
                        label: 'Pembukaan Serviks',
                        display: false,
                        fill: false,
                        data: arrServiks,
                        backgroundColor: 'blue',                    
                        //pointStyle: 'circle',
                        pointStyle:imgX,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',                    
                        fill: false,
                        borderColor: "blue",                    
                        backgroundColor: "blue",                                                       
                    },{
                        label: 'Turunnya Kepala Janin',
                        display: false,
                        fill: false,
                        data: arrTurun,
                        backgroundColor: 'red',                    
                        //pointStyle: 'circle',
                        pointStyle: imgO,
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',                    
                        fill: false,
                        borderColor: "red",                    
                        backgroundColor: "red",                                                       
                    }]
                },			
                options: {
                     layout: {
                        padding: {
                            left: 50,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    tooltips: {
                            mode: 'nearest',
                            intersect: false,
                    },
                    legend: {
                        labels: {
                           usePointStyle: true
                        }
                     },
                    responsive: true,
                    title: {
                            display: true,
                            text: 'Pembukaan Serviks dan Penurunan Kepala'
                    },
                    scales: {
                        xAxes: [{
                            type: "time",
                            time: {                                 
                                displayFormats: {
                                  hour: 'HH:mm',
                                  minute: 'HH:mm'
                                },           
                                tooltipFormat: 'MMM D - HH:mm'
                            },
                            scaleLabel: {
                                    display: true,
                                    labelString: 'Jam'
                            },                           
                            ticks: {                                                       
                                fontSize:11
                            },
                            gridLines: {
                                offsetGridLines: true
                            }
                        }],  
                         yAxes: [{
                            ticks: {
                                    min: 0,
                                    max: 9,
                                    stepSize: 1,
                                    fontSize:11
                            },

                        }],                    
                    }
                }
            }); 
        
                
            var barKontraksi = new Chart(kontraksi, {
                type: 'bar',
                data: {
                    labels: arrTgl,
                    datasets: [{                        
                        display: false,
                        fill: false,
                        data: arrKontraksi,
                        backgroundColor: arrKontraksiCol,                                     
                        borderColor:arrKontraksiCol,                                                                    
                    }],			
                },
                options: {
                     layout: {
                        padding: {
                            left: 50,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    tooltips: {
                            mode: 'nearest',
                            intersect: false,
                    },      
                    legend:
                             {
                                       display: false,
                             },
                    legendCallback: function (chart) {
                            var text = '';
                            
                            text += '<h5><b>Kontraksi Uterus</b></h5>';
                            text += '<span style="background:blue;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <label><?php echo Params::PARTOGRAF_KONTRAK_KURANG; ?></label>';
                            text += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            text += '<span style="background:red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <label><?php echo Params::PARTOGRAF_KONTRAK_SD; ?></label>';
                            text += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            text += '<span style="background:#b7b7b7;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> <label><?php echo Params::PARTOGRAF_KONTRAK_LEBIH; ?></label>';
                            return text;
                          },
                    responsive: true,
                    title: {
                            display: false,
                            text: 'Kontraksi Uterus'
                    },
                    scales: {
                        xAxes: [{
                            type: "time",
                            time: {                                 
                                displayFormats: {
                                  hour: 'HH:mm',
                                  minute: 'HH:mm'
                                },           
                                tooltipFormat: 'MMM D - HH:mm',
                                distribution: 'linear'
                            },
                            scaleLabel: {
                                    display: true,
                                    labelString: 'Jam'
                            },                           
                            ticks: {                                                       
                                fontSize:11
                            },        
                            categoryPercentage: .1,
                            barPercentage: 1,
                            gridLines: {
                                offsetGridLines: true,                                
                            }
                        }],  
                         yAxes: [{
                            ticks: {
                                    min: 0,
                                    max: 9,
                                    stepSize: 1,
                                    fontSize:11
                            },

                        }],                    
                    }
                }
            }); 
            
            document.getElementById('js-legend').innerHTML = barKontraksi.generateLegend();        
                
            var lineTensi = new Chart(tensi, {
                type: 'line',
                data: {
                    labels: arrTgl,
                    datasets: [{      
                        label: 'Nadi',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: arrNadi,
                        backgroundColor: '#e5e5e5',
                        borderColor: '#e5e5e5',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',          
                    },{ 
                        label: 'Suhu',
                        yAxisID: 'B',
                        display: false,
                        fill: false,
                        data: arrSuhu,
                        backgroundColor: '#eac804',
                        borderColor: '#eac804',
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointBorderColor: 'rgb(0, 0, 0)',          
                    },{ 
                        type:'line',
                        label: 'Diastolic',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        showLine: false,
                        data: arrDias,
                        backgroundColor: '#ED3237',
                        borderColor: '#ED3237',
                        //pointStyle: 'circle',
                        pointStyle: imgPA,               
                        pointRadius: 5,                        
                    },{ 
                        type:'line',
                        label: 'Systolic',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        showLine: false,
                        data: arrSys,
                        backgroundColor: '#ED3237',
                        borderColor: '#ED3237',
                        //pointStyle: 'circle',
                        pointStyle: imgDA,                        
                        pointRadius: 5,                        
                    }],			
                },
                options: {
                     layout: {
                        padding: {
                            left: 50,
                            right: 0,
                            top: 0,
                            bottom: 0
                        }
                    },
                    tooltips: {
                            mode: 'nearest',
                            intersect: false,
                    },      
                   legend: {
                        labels: {
                           usePointStyle: true
                        }
                     },              
                    responsive: true,
                    title: {
                            display: true,
                            text: 'Tekanan Darah, Suhu dan Nadi'
                    },
                    scales: {
                        xAxes: [{
                            type: "time",
                            time: {                                 
                                displayFormats: {
                                  hour: 'HH:mm',
                                  minute: 'HH:mm'
                                },           
                                tooltipFormat: 'MMM D - HH:mm',
                                distribution: 'linear'
                            },
                            scaleLabel: {
                                    display: true,
                                    labelString: 'Jam'
                            },                           
                            ticks: {                                                       
                                fontSize:11
                            },        
                            categoryPercentage: .1,
                            barPercentage: 1,
                            gridLines: {
                                offsetGridLines: true,                                
                            }
                        }],  
                         yAxes: [{
                            id: 'A',
                            type: 'linear',
                            position: 'left',
                            ticks: {
                                    min: 0,
                                    max: 200,
                                    stepSize: 20,
                                    fontSize:11
                            },
                        },{
                            id: 'B',
                            type: 'linear',
                            position: 'right',
                            ticks: {
                                    min: 33,
                                    max: 43,
                                    stepSize: 1,
                                    fontSize:11
                            }
                        }],                    
                    },
                      annotation: {        
                        drawTime: 'afterDatasetsDraw', 
                        events: ['click'],
                        dblClickSpeed: 350, // ms (default)
                        annotations: arrAnno
                    }
                },
                
            });  
}

$(document).ready(function(){
    setTimeout(function(){
        generateGrafik();
    },500);
    
});

</script>