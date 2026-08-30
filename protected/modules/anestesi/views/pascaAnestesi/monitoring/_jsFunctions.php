<script type='text/javascript'>

    function generateGrafik(){
        var tekanandarah = $("#chart_tekanandarah");        
        var temperature = $("#chart_temperature");        
                                
        var n = 0;//untuk nadi
        var o = 0;//untuk systolic
        var p = 0;//untuk diastolic
        
        var q = 0;//untuk temperature
        var r = 0;//untuk respiration rate
        var a = 0;   
        
        var arrTgl = [];        
                
        var arrNadi = [];//untuk pencatatan nadi 
        var arrDias = [];//untuk pencatatan diastolic
        var arrSys = [];//untuk pencatatan systolic
        
        var arrTemp = [];//untuk mengenerate tekanan darah dalam bentuk line i garis vertical
        var arrRes = [];//untuk mengenerate tekanan darah dalam bentuk line i garis vertical
        
        $("#tabel-monitoring > tbody > tr").each(function(){            
            var jam_monitoring = $(this).find(".menitke").val();                        
            //jam
            if ($(this).find(".menitke").val() != ''){
                //arrTgl[a] = newDate(jam_monitoring); 
                
                //nadi
                if ($(this).find(".nadi").val() != ''){
                    arrNadi[n] ={ 
                        x: $(this).find(".menitke").val(),
                        y: $(this).find(".nadi").val()
                    };    
                    n++;
                }    
                
                //systolic
                if ($(this).find(".sistolik").val() != ''){
                    arrSys[o] ={ 
                        x: $(this).find(".menitke").val(),
                        y: $(this).find(".sistolik").val()
                    };    
                    o++;
                }
                
                //diastolik
                if ($(this).find(".diastolik").val() != ''){
                    arrDias[p] ={ 
                        x: $(this).find(".menitke").val(),
                        y: $(this).find(".diastolik").val()
                    };    
                    p++;
                }
                
                //temperature
                if ($(this).find(".temperature").val() != ''){
                    arrTemp[q] ={ 
                        x: $(this).find(".menitke").val(),
                        y: $(this).find(".temperature").val()
                    };    
                    q++;
                }
                
                //respiration rate
                if ($(this).find(".respiration").val() != ''){
                    arrRes[r] ={ 
                        x: $(this).find(".menitke").val(),
                        y: $(this).find(".respiration").val()
                    };    
                    r++;
                }
                
                if ($(this).find(".menitke").val() != '') {
                    arrTgl[a] = $(this).find(".menitke").val();
                }
                
                a++;
            }                              
        });                       
             
        var lineTensi = new Chart(tekanandarah, {
            type: 'line',
            data: {   
                labels: arrTgl,
                datasets: [{ 
                    label: 'Nadi',
                    yAxisID: 'A',                    
                    data: arrNadi,
                    display: false,
                    fill: false,    
                    backgroundColor: '#eac804',
                    borderColor: '#eac804',
                    pointStyle: 'circle',
                    pointRadius: 5,
                    pointBorderColor: '#eac804',          
                },{ 
                    type:'line',
                    label: 'Diastolik',
                    yAxisID: 'A',
                    display: false,
                    fill: false,     
                    data: arrDias,
                    backgroundColor: '#ED3237',
                    borderColor: '#ED3237',
                    pointStyle: 'circle',
                    pointBorderColor: '#ED3237',           
                    pointRadius: 5,                        
                },{ 
                    type:'line',
                    label: 'Sistolik',
                    yAxisID: 'A',                    
                    data: arrSys,
                    display: false,
                    fill: false,    
                    backgroundColor: '#558933',
                    borderColor: '#558933',
                    pointStyle: 'circle',
                    pointBorderColor: '#558933',                     
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
                    position:'right'
                 },              
                responsive: true,
                title: {
                        display: false,
                        text: 'Tekanan Darah, Suhu dan Nadi'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Menit ke'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: .1,
                            barPercentage: 1,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Tekanan Darah',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'top',
                            ticks: {
                                min: 0,
                                max: 220,
                                stepSize: 20,
                                fontSize: 11
                            },
                        }, {
                            scaleLabel: {
                                display: true,
                                labelString: 'Nadi',
                            },
                            id: 'B',
                            type: 'linear',
                            position: 'right',
                            ticks: {
                                min: 40,
                                max: 180,
                                stepSize: 20,
                                fontSize:11
                            }
                        }],
                },               
            },

        });  
        
        var lineTemperature = new Chart(temperature, {
            type: 'line',
            data: {
                labels: arrTgl,
                datasets: [{ 
                    label: 'Respiration Rate',
                    yAxisID: 'A',
                    display: false,
                    fill: false,
                    data: arrRes,
                    backgroundColor: '#eac804',
                    borderColor: '#eac804',
                    pointStyle: 'circle',                    
                },{ 
                    type:'line',
                    label: 'Temperature',
                    yAxisID: 'A',
                    display: false,
                    fill: false,                    
                    data: arrTemp,
                    backgroundColor: '#ED3237',
                    borderColor: '#ED3237',
                    pointStyle: 'circle',                    
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
                    position:'right'
                 },              
                responsive: true,
                title: {
                        display: false,
                        text: 'Temperature dan Respiration Rate'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Menit ke'
                            },
                            ticks: {
                                fontSize: 11
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
                                max: 220,
                                stepSize: 20,
                                fontSize:11
                        },
                        gridLines: {                            
                            drawBorder: false,
                            display:true
                        },   
                        scaleLabel: {
                                display: true,
                                labelString: 'Temperature',                                
                        },                          
                    },{
                        id: 'B',
                        type: 'linear',
                        position: 'right',
                        ticks: {
                                min: 40,
                                max: 180,
                                stepSize: 20,
                                fontSize:11
                        },
                        scaleLabel: {
                                display: true,
                                labelString: 'Respiraion Rate'
                        }, 
                        gridLines: {
                            offsetGridLines: true,                                
                            drawBorder: false,
                            display:false
                        },
                    }],                    
                },                 
            },

        });
    }
                                
                           
    function ubahDataMonitor(no){
        var form_monitoring = $("#form-dialog-ubah");
        
        var time = form_monitoring.find('.field-menitke').val();
        var count = 0;
        
        $("#tabel-monitoring > tbody > tr").each(function(){
            if ($(this).attr('id-row') != no){                                       
                if ($(this).find('.menitke').val() == time){
                    count++;
                }
            }           
        });
        
        if (count > 0){
            window.parent.myAlert("Menit ke <b>"+time+"</b> sudah ditambahkan","Perhatian !");
            return false;
        }
        
        if (requiredCheck(form_monitoring)){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('generateRow'); ?>',
                data: {                                
                    formdata:form_monitoring.find('input,select,textarea').serialize()
                 },
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){
                        $("#tabel-monitoring > tbody > tr").each(function(){
                            if ($(this).attr('id-row') == no){                                       
                                $(this).replaceWith(data.tr);
                            }
                        });
                        $("#dialogUbah").dialog('close');
                        renameInputRow($("#tabel-monitoring"));
                        resetForm();
                        generateGrafik();
                        //window.parent.showToast('success',data.pesan);
                    }else{
                        window.parent.showToast('error',data.pesan);
                    }
                },
               error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });	
        }
        return false;
    }
    
    function cekForm(){
        var cek = $("#tabel-monitoring > tbody > tr").length;
        
        if (cek > 0){
            $('#monitoringpasca-anestesi').submit();
        }else{
            window.parent.myAlert("Data pada Tabel Monitoring belum ditambahkan.");
        }
        

       return false;
    }
                            
    function tambahDataMonitor(obj){
        var form_monitoring = $("#form-tambah-monitoring");
        var time = form_monitoring.find('.field-menitke').val();
        var count = 0;
        
        $("#tabel-monitoring > tbody > tr").each(function(){
           if ($(this).find('.menitke').val() == time){
               count++;
           }
        });
        
        if (count > 0){
            window.parent.myAlert("Menit ke <b>"+time+"</b> sudah ditambahkan","Perhatian !");
            return false;
        }
        
    
        if (requiredCheck(form_monitoring)){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('generateRow'); ?>',
                data: {                                
                    formdata:form_monitoring.find('input,select,textarea').serialize()
                 },
                dataType: "json",
                success:function(data){
                    if (data.sukses == 1){
                        $("#tabel-monitoring > tbody").append(data.tr);
                        renameInputRow($("#tabel-monitoring"));
                        resetForm();
                        generateGrafik();
                        //window.parent.showToast('success',data.pesan);
                    }else{
                        window.parent.showToast('error',data.pesan);
                    }
                },
               error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });	
        }
        return false;
    }
    
    function resetForm(){
        $("#form-tambah-monitoring").find('input,select,textarea').val('');
        $("#form-dialog-ubah").html('');       
    }
    
    function renameInputRow(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){		
            $(this).attr('id-row',row);
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");               
                if(old_name_arr.length == 4){                    
                    $(this).attr("id",old_name_arr[0]+"_"+old_name_arr[1]+"_"+row+"_"+old_name_arr[3]);
                    $(this).attr("name",old_name_arr[0]+"["+old_name_arr[1]+"]["+row+"]["+old_name_arr[3]+"]");
                }
            });
            
            row++;
        });	
    }
    
    function hapusBaris(obj){
        window.parent.myConfirm("Apakah Anda yakin akan menghapus data ini ?","Perhatian !",function(r){
            if (r){
                
                var id = $(obj).parents("tr").find('.id').val();
                                
                var del = '<tr><td><input type="hidden" value="'+id+'" name="delete[]"></td></tr>';
                $("#tabel-hapus > tbody").append(del);
                                                
                $(obj).parents("tr").detach();
                renameInputRow($("#tabel-monitoring"));
                generateGrafik();
            }
        });
    }
    
    function loadFormMonitor(obj){
        var form_monitoring = $(obj).parents("tr").find('input, select, textarea').serialize();
        var no  = $(obj).parents("tr").attr("id-row");
    
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('loadForm'); ?>',
            data: {                                
                formdata:form_monitoring,
                no:no
             },
            dataType: "json",
            success:function(data){
                if (data.sukses == 1){
                    $("#dialogUbah").dialog("open");
                    $("#form-dialog-ubah").html(data.tr);       
                    
                    setTimeout(generatePicker(),500);
                }else{
                    window.parent.myAlert(data.pesan);
                }
            },
           error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });	
    }
        
    function generatePicker(){
        $("#form-dialog-ubah").find('.field-menitke').timepicker(
            jQuery.extend(
                {
                    showMonthAfterYear:false
                }, 
                jQuery.datepicker.regional['id'],
                {                   
                    'timeText':'Waktu',
                    'hourText':'Jam',
                    'minuteText':'Menit',
                    'secondText':'Detik',
                    'showSecond':true,
                    'timeOnlyTitle':'Pilih Waktu',
                    'timeFormat':'hh:mm:ss',                    
                    'showAnim':'fold',                    
                }
            )
        );
    }
    
    function setDiagnosa(data){
        $("#<?php echo CHtml::activeId($model, 'diagnosa_id') ?>").val(data.diagnosa_id);
        $("#<?php echo CHtml::activeId($model, 'diagnosa_nama') ?>").val(data.diagnosa_nama);
        
        $("#dialogDiagnosa").dialog('close');
    }
    
    function setPetugas(data){
        $("#<?php echo CHtml::activeId($model, 'monitoringpeg_id') ?>").val(data.pegawai_id);
        $("#<?php echo CHtml::activeId($model, 'monitoringpeg_nama') ?>").val(data.namaLengkap);
        
        $("#dialogPegawai").dialog('close');
    }
    
    function setDialog(jenis,obj){
        if (jenis == 'diagnosa'){
            $("#dialogDiagnosa").dialog('open');
        }else if (jenis == 'pegawai'){
            $("#dialogPegawai").dialog('open');
        }
    }
    
    $(document).ready(function(){
        generateGrafik();
        resetForm();
    });
</script>
