<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/suara.antrian.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/howler.min.js', CClientScript::POS_END); ?>
<?php

$urlLoadLoket = $this->createUrl('loadLoketByModelAntrian');
$urlPanggilNoAntrian = $this->createUrl('panggilNoAntrian');
$urlStatusBarcodeAntrian = $this->createUrl('statusBarcodeAntrian');
$nodeJsAktif = (Yii::app()->user->getState('is_nodejsaktif'))?'ya':'tidak';
$konfig = KonfigsystemK::model()->find();

$paramsCallOutside = ParamsConst::STATUSPANGGIL_ANTRIAN_CALLOUTSIDE;

$jscript = <<< JS
        
      
        const loadListLoket = function(){
            $.ajax({
                type: 'GET',
                url: '${urlLoadLoket}',
                data: {id:this.value},
                success: function (data) {                                    
                    $("#loket").html(data);
                
                    refreshGridAntrian();
                },
                error: function (jqXHR, textStatus, errorThrown) {                                    
                }
            });
        }
                
        const statusBarcodeAntrian = (antrianId, no) => {
            $.ajax({
                type: 'POST',
                url: '${urlStatusBarcodeAntrian}',
                data: {
                    antrianId,
                    no
                },
                dataType:'json',
                success: function (data) {             
                    if ('${nodeJsAktif}' == 'ya'){
                        socket.emit('send',{conversationID:'infoAntrian',panggil:3,arr:{status:'panggil',antrianId:data.antrianId}});
                    }
                    refreshGridAntrian();                    
                },
                error: function (jqXHR, textStatus, errorThrown) {                                    
                }
            });
        }
                
        const panggilNoAntrian = function(antrianId, statuspanggil = ''){
            const jenisAntrian = $("#jenisAntrian").val();
            const loket = $("#loket").val();
            const jumlahPanggil = $("#jumlahPanggil").val();
            let formPanggil = $(".form-panggil-antrian");
            if (antrianId != ''){
                formPanggil = $(".skip");
            }
                    
            if (requiredCheck(formPanggil)){                            
                $.ajax({
                    type: 'POST',
                    url: '${urlPanggilNoAntrian}',
                    data: {
                        jenisAntrian,
                        loket,
                        jumlahPanggil,
                        antrianId,
                        statuspanggil
                    },
                    dataType:'json',
                    success: function (data) {             
                        // $("#tampil-no-antrian").html(data.html);
                    
                        if (typeof data.noantrian !== 'undefined' && '${nodeJsAktif}' == 'ya'){                            
                            if (statuspanggil == '${paramsCallOutside}'){
                                socket.emit('send',{conversationID:'infoAntrian',panggil:1,arr:{status:'panggil',antrianId:data.noantrian}});
                            }else{
                                socket.emit('send',{conversationID:'infoAntrian',panggil:4,arr:{status:'panggil',antrianId:data.noantrian,loketId:loket}});                            
                                socket.emit('send',{conversationID:'infoAntrian',panggil:2,arr:{status:'panggil',antrianId:data.noantrian,loketId:loket}});
                                socket.emit('send',{conversationID:'infoAntrian',panggil:1,arr:{status:'panggil',antrianId:data.noantrian}});
                            }
                                                    
                            refreshGridAntrian();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {                                    
                    }
                });
            }
            return false;
        }
                    
        const refreshGridAntrian = function(jenis = ''){
            let loketId = $("#loket").val();                                        
            let modelId = $("#jenisAntrian").val();
            let def = 'kosong';
            let def2 ='';
            let objCari = {};
                    
            if (loketId != '' && modelId != ''){
                def = '';
                def2 ='';

            }
                            
            if (jenis == 'awal'){
                def = '';
             
                
                loketId = '';
                modelId = '';
            }
                                                      
            if (jenis == "panel-pencarian"){
                objCari = $("#search-form").find("input,select").serialize();                                                        
                objCari += '&AntrianT[default]='+def;  
                objCari += '&AntrianT[katakunci]='+def2;  
                                        
            }else{
                objCari = {
                    'AntrianT[loket_id]':loketId,                    
                    'AntrianT[modelantrian_id]':modelId, 
                    'AntrianT[default]':def,
                    'AntrianT[katakunci]':def2,
                };
            }
            
            $.fn.yiiGridView.update('daftar-antrian-grid',{
                data: objCari
            });
        }
                    
        const setStatus = () => {
            let jeniskunjungan = '';
            $("#daftar-antrian-grid").find(".status-kunjungan").each(function(){
                jeniskunjungan = $(this).attr('data-jenis-kunjungan');
                if ( (jeniskunjungan).toLowerCase() == 'reservasi'){
                    $(this).parents("tr").addClass("status-reservasi");
                }else if ( (jeniskunjungan).toLowerCase() == 'fast track'){
                    $(this).parents("tr").addClass("status-fasttrack");
                }else{
                    $(this).parents("tr").addClass("status-sekarang");
                }
            });
        }
                     
                        
        function detailFastTrack(obj){
            const formfasttrack = $("#form-fast-track");
            const nama_pj = $(obj).attr("data-nama-pj");
            const no_rm = $(obj).attr("data-no-rm");
            const nama_pasien = $(obj).attr("data-nama-pasien");
            const alasan = $(obj).attr("data-alasan");
                        
            formfasttrack.find(".nama_pj").val(nama_pj);
            formfasttrack.find(".no_rm").val(no_rm);
            formfasttrack.find(".nama_pasien").val(nama_pasien);
            formfasttrack.find(".alasan").val(alasan);
                        
            $("#dialogDetailFastTrack").dialog("open");                                    
        }
           
        document.addEventListener("DOMContentLoaded", function(){
            var jenisAntrian = document.getElementById("jenisAntrian");
            var panggilAntrian = document.getElementById("panggilAntrian");
            var loket = document.getElementById("loket");

            jenisAntrian.addEventListener("change", loadListLoket);     
//            panggilAntrian.addEventListener("click", panggilNoAntrian);  
            loket.addEventListener("change", refreshGridAntrian); 
                   
            setStatus();
        });                                                           
                          
JS;

Yii::app()->clientScript->registerScript('pemanggilan-antrian-js-head',$jscript, CClientScript::POS_HEAD);
?>

<script type="text/javascript">
    $(document).ready(function(){             
     <?php if($konfig->is_nodejsaktif){ ?>
        var chatServer='<?php echo $konfig->nodejs_host ?>';
        if (chatServer == ''){
         chatServer='http://localhost';
        }
        var chatPort='<?php echo $konfig->nodejs_port ?>';
        socket = io.connect(chatServer+':'+chatPort);
        socket.emit('subscribe', 'infoAntrian');
        socket.on('infoAntrian',  (data) => {           
            if (data.panggil == 3){
                refreshGridAntrian();
            }
            if(data.panggil == 1) {
                showNoAntrian(data);
            }
       });
        <?php } ?>
            
        setTimeout(function(){
            refreshGridAntrian('awal');
        }, 500);
        
    });
    
    
    var ubahPoliklinik = (id, setform = '') => {
        const ruanganId = $("#ruanganpoli_pilih").val();        
        let form = $("#form-jenis-kunjungan");
        let method = 'POST';
        if (setform == 'generate'){
            form = $(".skip");
            method = 'GET';
        }
                   
        
        if (requiredCheck(form)){                    
            $.ajax({
                type: method,
                url: '<?= $this->createUrl('formUbahPoliklinik') ?>',
                data: {
                    formdata: form.find("input,textarea,select").serialize(),  
                    id
                }, 
                dataType: "json",
                success: function(data) {
                    if (setform != 'simpan'){
                        $("#form-jenis-kunjungan").html(data);
                        $("#dialogUbahPoliklinik").dialog("open");
                    }else{
                        if (data.sukses){
                            myAlert("Data sukses disimpan","Perhatian!");
                            refreshGridAntrian();
                            $("#dialogUbahPoliklinik").dialog("close");
                        }else{
                            Notiflix.Report.Failure("Perhatian!","Data gagal disimpan",'OK');
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });            
        }
    }
    
    const setRuanganPolik = (value) => {
        if (value != ''){
            
            $.ajax({
                type: 'GET',
                url: '<?= $this->createUrl('SetDropdownRuanganByJenisAntrian', array('encode' => false, 'namaModel' => get_class($model))) ?>',
                data: {
                    modelantrian_id: value
                }, 
                success: function(data) {
                    $("#form-jenis-kunjungan").find(".ruangan_id").html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }else{
            $("#<?= CHtml::activeId($model,'ruangan_id') ?>").html("");
        }
    }

    let isCalledFunction = false;
    let idAntrian = '';
    let listAntrianYangDipanggil = {};

    function showNoAntrian(data){
        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('/antrian/tampilAntrianKeLantai2/listAntrianDipanggil'); ?>',
            data: {
                antrianId:data.arr.antrianId,
                sisanAntrian: listAntrianYangDipanggil.length
            },
            dataType: "json",
            success:function(data){
                
                $("#tampil-no-antrian").append(data.html);
                           
                console.log('is here');
                
                for (const key in data.listantrian) {
                    listAntrianYangDipanggil[key] = data.listantrian[key];                    
                }
                
                var sisaBelumDipanggil= Object.keys(listAntrianYangDipanggil).length;

                const form = $(".box-antrian[data-antrian-id]:first");
                const adaYangDipanggil = $(".container-dipanggil").html();                
                // console.log(sisaBelumDipanggil);
                console.log(adaYangDipanggil.trim() == '');

                if (sisaBelumDipanggil > 0 && adaYangDipanggil.trim() == ''){   
                    console.log('here');
                    panggilsuara(listAntrianYangDipanggil[form.attr("data-antrian-id")]);
                    $(".container-dipanggil").html(form.clone());
                    form.detach();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { 
                console.log(errorThrown);
                var html = $("#tampil-no-antrian");

                html.append('<span class="required untukdihapus"><b>No Antrian Habis</b></span>');
                
                setTimeout(function(){
                    $('.untukdihapus').detach();
                },2000);
            }
        });
    }

    function panggilsuara(data){
        const soundDat = [            
            {name: "bell panggil pendaftaran"},
            // {name: "nomer"},
            {name: "noantrian"},            
        ];
        
        //set nama ruangan singkatan
        const split_ruanganSingkatan = ((data.ruangan_singkatan).toLowerCase()).split("");
        split_ruanganSingkatan.forEach(function(value, index){
            soundDat.push({name:value});
        });
        
        //set nomor antrian 
        const split_noantrian = ((data.noantrian).toLowerCase()).split(" ");
        split_noantrian.forEach(function(value, index){
            soundDat.push({name:value});
        });
                
        soundDat.push({name: "diloket"});
        
        //set nama loket
        const split_loket = ((data.loket_singkatan).toLowerCase()).split(" ");
        split_loket.forEach(function(value, index){
            soundDat.push({name:value});
        });

        setJenisSuaraAntrian("<?php echo Yii::app()->request->baseUrl;?>/data/sounds/antrian/mp3/PEREMPUAN_2/");        
        registerSuaraAntrianSilent(soundDat);
        
        isCalledFunction = true;
        idAntrian = data.antrianId;
    }

    function doSomethingAfterBeingCalled(){  
        console.log(idAntrian + 'inhere');

        const form = $(".box-antrian[data-antrian-id='"+idAntrian+"']");
        const parent = form.parents(".container-dipanggil");
        form.detach();  
        
        const cekSisaAntrian = $(".box-antrian:first");
        if (cekSisaAntrian.length > 0){
                
            if (typeof listAntrianYangDipanggil[cekSisaAntrian.attr("data-antrian-id")] !== 'undefined'){
                $(listAntrianYangDipanggil[cekSisaAntrian.attr("data-antrian-id")]).each(function(index, value){                    
                    panggilsuara(value);                                    
                });   
                parent.html(cekSisaAntrian.clone());
                cekSisaAntrian.detach();
                
                delete listAntrianYangDipanggil[cekSisaAntrian.attr("data-antrian-id")];                
            }
        }else{
            listAntrianYangDipanggil = [];
        }
    }
    
    
</script>