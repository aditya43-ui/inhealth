<?php
$url = Yii::app()->createUrl($this->route);
$urlModule = Yii::app()->createUrl($this->module->id);
$urlGrafik = Yii::app()->createUrl('asuhanKeperawatan/laporanOppeKeperawatan/frameGrafikOppe&id=1');
$js = <<< JS
    var params = $('#search-laporan :input').serialize();
    function refreshGrafikGaris(diagnosa_nama){
        $('#garis').addClass("animation-loading");
        $('#speedo').addClass("animation-loading");
        $.ajax({
            type: "POST",
            url: "${urlGrafik}",
            data: params+"&diagnosa_nama="+diagnosa_nama,
            dataType: "json",
            success: function(data) {
                plot_garis.destroy();
                plot_garis.title.text = data.title;
                plot_garis.series[0].data = data.garis.result;
                plot_garis.axes.xaxis.ticks = data.garis.index;
                plot_garis.axes.xaxis.tickOptions = (data.garis.index.length > 8 ) ? {angle:-30} : {angle:-0};
                plot_garis.replot({resetAxes:['yaxis'],axes:{yaxis:{min:0, pad:5}}});
                $('#garis').removeClass("animation-loading");
                $('#speedo').removeClass("animation-loading");
                setValue_speedo(data.speedo.result);
            },
            error: function(error){
                //myAlert('Update Grafik Garis dan Speedo Gagal!');
                console.log(error);
                $('#garis').removeClass("animation-loading");
                $('#speedo').removeClass("animation-loading");
            }
        });
    }
    $('#batang').bind('jqplotClick', function (ev, seriesIndex, pointIndex, data,jqplot) {
        $(".jqplot-target").attr("style","position:relative;width:100%;");
        var diagnosa_nama = "";
        if(data != null){
            diagnosa_nama = jqplot.data[0][[data.data[0]][0]-1][0];
        }
        refreshGrafikGaris(diagnosa_nama);
    });
    $('#pie').bind('jqplotClick', function (ev, seriesIndex, pointIndex, data,jqplot) {
        $(".jqplot-target").attr("style","position:relative;width:100%;");
        var diagnosa_nama = "";
        if(data != null){
            diagnosa_nama = data.data[0];
        }
        refreshGrafikGaris(diagnosa_nama);
    });
    refreshGrafikGaris("");
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
    
    $(document).ready(function() {
        var ins  = jQuery('#<?php echo CHtml::activeId($model, 'golongan_indikator') ?>');	
		
            jQuery(ins).multiselect({
                includeSelectAllOption: true,
                buttonClass: "form-control",
                maxHeight: 300,
                buttonWidth: '150px',
                enableCaseInsensitiveFiltering: true,
                onChange: function(element, checked) {				
                    var ins  = jQuery('#<?php echo CHtml::activeId($model, 'golongan_indikator') ?>');
                    var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'golongan_indikator') ?>   option:selected');

                    var brands = ins_all;
                    var selected = [];

                    $(brands).each(function(index, brand){
                            selected.push($(this).val());
                    });

                    ru.addClass('animation-loading');
                    //alert(selected);

                    jQuery.ajax({
                        type:'POST',
                        url: '<?php echo $this->createUrl('/ActionDynamic/GetIndikatorByMultiSelect') ?>',					
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
                    var ins  = jQuery('#<?php echo CHtml::activeId($model, 'golongan_indikator') ?>');
                    var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'golongan_indikator') ?>   option:selected');

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
                    var ins  = jQuery('#<?php echo CHtml::activeId($model, 'golongan_indikator') ?>');
                    var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'golongan_indikator') ?>   option:selected');

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

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });
    
</script>