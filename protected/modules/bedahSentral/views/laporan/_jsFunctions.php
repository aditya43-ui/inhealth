<?php
$url = Yii::app()->createUrl($this->route);
$urlModule = Yii::app()->createUrl($this->module->id);
$urlGrafik = Yii::app()->createUrl($this->module->id."/".$this->id."/UpdateGrafik");
$js = <<< JS
    ubahJnsPeriode();
JS;

Yii::app()->clientScript->registerScript('diagram',$js, CClientScript::POS_READY)
?>
<script type="text/javascript">
    function refreshForm(){
        window.location.href = "<?php echo $url;?>";
    }
    function konfirmasiBatal(){
        myConfirm("Apakah Anda akan membatalkan ini?","Perhatian!",function(r) {
            if(r){
                window.location.href = "<?php echo $urlModule;?>&modul_id=39";
            }
        });
    }
    function ubahJnsPeriode(){
        var obj = $("#<?php echo CHtml::activeId($model, 'jns_periode')?>");
        if(obj.val() == 'hari'){
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        }else if(obj.val() == 'bulan'){
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        }else if(obj.val() == 'tahun'){
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }

    $(document).ready(function(){
        var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');		
        var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');		
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');		
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');	
        var daftartindakan = jQuery('#<?php echo CHtml::activeId($model, 'daftartindakan_id') ?>');	

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {				
                var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand){
                        selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type:'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                    dataType: "json",
                    data: {instalasi_id:selected},
                    success: function(data){	

                        if (data.sukses != '1'){

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        }else{							
                            //alert(data.ruangan);
                            ru.html(data.ruangan);								
                            ru.multiselect('rebuild');																
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 					
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function() {
                var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function(index, brand){
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');

                jQuery.ajax({
                    type:'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                    dataType: "json",
                    data: {instalasi_id:selected},
                    success: function(data){	

                        if (data.sukses != '1'){

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        }else{							
                                //alert(data.ruangan);
                            ru.html(data.ruangan);								
                            ru.multiselect('rebuild');																
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { 					
                        console.log(errorThrown);

                    }
                });

            },
                onDeselectAll: function() {		
                        var ins  = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                        var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                        var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                        var brands = ins_all;
                        var selected = '';


                        ru.addClass('animation-loading');

                        jQuery.ajax({
                                type:'POST',
                                url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                                dataType: "json",
                                data: {instalasi_id:selected},
                                success: function(data){	

                                        if (data.sukses != '1'){

                                                //toastr.error(data.pesan);
                                                ru.addClass('animation-loading');
                                        }else{							
                                                //alert(data.ruangan);
                                                ru.html(data.ruangan);								
                                                ru.multiselect('rebuild');															
                                                ru.removeClass('animation-loading');
                                        }
                                },
                                error: function (jqXHR, textStatus, errorThrown) { 					
                                        console.log(errorThrown);

                                }
                        });

                }
        }).hide();

        jQuery(ru).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
                onChange: function(element, checked) {				
                    var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
                    var ru_all = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>   option:selected');
                    var daftartindakan  = jQuery('#<?php echo CHtml::activeId($model, 'daftartindakan_id') ?>');

                    var brands = ru_all;
                    var selected = [];

                    $(brands).each(function(index, brand){
                        selected.push($(this).val());
                    });

                    daftartindakan.addClass('animation-loading');
                    //alert(selected);

                    jQuery.ajax({
                        type:'POST',
                        url: '<?php echo $this->createUrl('/ActionDynamic/getTindakanDariRuanganByMultiSelect') ?>',					
                        dataType: "json",
                        data: {ruangan_id:selected},
                        success: function(data){	

                            if (data.sukses != '1'){

                                //toastr.error(data.pesan);
                                daftartindakan.addClass('animation-loading');
                            }else{							
                                //alert(data.ruangan);
                                daftartindakan.html(data.daftartindakan);								
                                daftartindakan.multiselect('rebuild');																
                                daftartindakan.removeClass('animation-loading');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 					
                            console.log(errorThrown);

                        }
                    });

                },
                onSelectAll: function() {
                    var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
                    var ru_all = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>   option:selected');
                    var daftartindakan  = jQuery('#<?php echo CHtml::activeId($model, 'daftartindakan_id') ?>');

                    var brands = ru_all;
                    var selected = [];

                    $(brands).each(function(index, brand){
                        selected.push($(this).val());
                    });

                    daftartindakan.addClass('animation-loading');
                    //alert(selected);

                    jQuery.ajax({
                        type:'POST',
                        url: '<?php echo $this->createUrl('/ActionDynamic/getTindakanDariRuanganByMultiSelect') ?>',					
                        dataType: "json",
                        data: {ruangan_id:selected},
                        success: function(data){	

                            if (data.sukses != '1'){

                                //toastr.error(data.pesan);
                                daftartindakan.addClass('animation-loading');
                            }else{							
                                //alert(data.ruangan);
                                daftartindakan.html(data.daftartindakan);								
                                daftartindakan.multiselect('rebuild');																
                                daftartindakan.removeClass('animation-loading');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 					
                            console.log(errorThrown);

                        }
                    });

                },
                onDeselectAll: function() {		
                    var ru  = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
                    var ru_all = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>   option:selected');
                    var daftartindakan  = jQuery('#<?php echo CHtml::activeId($model, 'daftartindakan_id') ?>');

                    var brands = ru_all;
                    var selected = [];

                    $(brands).each(function(index, brand){
                        selected.push($(this).val());
                    });

                    daftartindakan.addClass('animation-loading');
                    //alert(selected);

                    jQuery.ajax({
                        type:'POST',
                        url: '<?php echo $this->createUrl('/ActionDynamic/getTindakanDariRuanganByMultiSelect') ?>',					
                        dataType: "json",
                        data: {ruangan_id:selected},
                        success: function(data){	

                            if (data.sukses != '1'){

                                //toastr.error(data.pesan);
                                daftartindakan.addClass('animation-loading');
                            }else{							
                                //alert(data.ruangan);
                                daftartindakan.html(data.daftartindakan);								
                                daftartindakan.multiselect('rebuild');																
                                daftartindakan.removeClass('animation-loading');
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) { 					
                            console.log(errorThrown);

                        }
                    });

                }
        }).hide();

        jQuery(daftartindakan).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();

        /**
        * multi select cara bayar dan penjamin
         */

        jQuery(cara).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true,
                onChange: function(element, checked) {				
                                var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                                var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                                var brands = cara_all;
                                var selected = [];

                                $(brands).each(function(index, brand){
                                        selected.push($(this).val());
                                });

                                penj.addClass('animation-loading');
                                //alert(selected);

                                jQuery.ajax({
                                        type:'POST',
                                        url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',					
                                        dataType: "json",
                                        data: {carabayar_id:selected},
                                        success: function(data){	

                                                if (data.sukses != '1'){

                                                        //toastr.error(data.pesan);
                                                        penj.addClass('animation-loading');
                                                }else{							
                                                        //alert(data.ruangan);
                                                        penj.html(data.penjamin);								
                                                        penj.multiselect('rebuild');																
                                                        penj.removeClass('animation-loading');
                                                }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) { 					
                                                console.log(errorThrown);

                                        }
                                });

                },
                onSelectAll: function() {
                                var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                                var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                                var brands = ins_all;
                                var selected = [];

                                $(brands).each(function(index, brand){
                                        selected.push($(this).val());
                                });

                                penj.addClass('animation-loading');

                                jQuery.ajax({
                                        type:'POST',
                                        url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                                        dataType: "json",
                                        data: {carabayar_id:selected},
                                        success: function(data){	

                                                if (data.sukses != '1'){

                                                        //toastr.error(data.pesan);
                                                        penj.addClass('animation-loading');
                                                }else{							
                                                        //alert(data.ruangan);
                                                        penj.html(data.penjaminan);								
                                                        penj.multiselect('rebuild');																
                                                        penj.removeClass('animation-loading');
                                                }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) { 					
                                                console.log(errorThrown);

                                        }
                                });

                },
                onDeselectAll: function() {		
                        var cara  = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                        var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                        var penj  = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                        var brands = ins_all;
                        var selected = '';


                        penj.addClass('animation-loading');

                        jQuery.ajax({
                                type:'POST',
                                url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',					
                                dataType: "json",
                                data: {carabayar_id:selected},
                                success: function(data){	

                                        if (data.sukses != '1'){

                                                //toastr.error(data.pesan);
                                                penj.addClass('animation-loading');
                                        }else{							
                                                //alert(data.ruangan);
                                                penj.html(data.penjamin);								
                                                penj.multiselect('rebuild');															
                                                penj.removeClass('animation-loading');
                                        }
                                },
                                error: function (jqXHR, textStatus, errorThrown) { 					
                                        console.log(errorThrown);

                                }
                        });

                }
        }).hide();

        jQuery(penj).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '182px',
                enableCaseInsensitiveFiltering: true
        }).hide();


    });
    
</script>