<?php
    $konfig = KonfigsystemK::model()->find();
?>
<script type="text/javascript">
    let isCalledFunction = false;
    let idAntrian = '';
    let listAntrianYangDipanggil = {};           
    
    function panggilsuara(data){
        const soundDat = [            
            // {name: "bell panggil pendaftaran"},
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
        registerSuaraAntrian(soundDat);
        
        isCalledFunction = true;
        idAntrian = data.antrianId;
    }
    
    function showNoAntrian(data){
        $.ajax({
            type:'GET',
            url:'<?php echo $this->createUrl('listAntrianDipanggil'); ?>',
            data: {
                antrianId:data.arr.antrianId,
                sisanAntrian: listAntrianYangDipanggil.length
            },
            dataType: "json",
            success:function(data){
                
                $("#form-list-antrian").append(data.html);
                                                                                
                for (const key in data.listantrian) {
                    listAntrianYangDipanggil[key] = data.listantrian[key];                    
                }
                
                var sisaBelumDipanggil= Object.keys(listAntrianYangDipanggil).length;

                const form = $(".box-antrian[data-antrian-id]:first");
                const adaYangDipanggil = $(".container-dipanggil").html();                
                                
                
                if (sisaBelumDipanggil > 0 && adaYangDipanggil.trim() == ''){                    
                    panggilsuara(listAntrianYangDipanggil[form.attr("data-antrian-id")]);
                    
                    $(".container-dipanggil").html(form.clone());
                    form.detach();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function doSomethingAfterBeingCalled(){        
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
    
    $(document).ready(function(){
        <?php 
        if($konfig->is_nodejsaktif){ 
            if (!empty($konfig->nodejs_host)){
        ?>
                var chatServer='<?php echo 	$konfig->nodejs_host; ?>';
                var chatPort='<?php echo 	$konfig->nodejs_port; ?>';                                        
        <?php
            }else{
        ?>
                var chatServer='localhost';
                var chatPort='3000';
        <?php
            }
        }
        ?>	
                
        socket = io.connect(chatServer+':'+chatPort,{secure: true});
        socket.emit('subscribe', 'infoAntrian');
        socket.on('infoAntrian', function(data){                
            if (data.panggil == 1) {                
                showNoAntrian(data);
            }            
        });
    }); 
    
    
</script>