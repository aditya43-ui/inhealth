<?php
$url = Yii::app()->createUrl($this->route);
$urlModule = Yii::app()->createUrl($this->module->id);
$urlGrafik = Yii::app()->createUrl($this->module->id."/".$this->id."/UpdateGrafik");
$js = <<< JS
    var params = $('#search-laporan :input').serialize();
    function refreshGrafikGaris(ruangan_nama){
        $('#garis').addClass("animation-loading");
        $('#speedo').addClass("animation-loading");
        $.ajax({
            type: "POST",
            url: "${urlGrafik}",
            data: params+"&ruangan_nama="+ruangan_nama,
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
                myAlert('Update Grafik Garis dan Speedo Gagal !');
                console.log(error);
                $('#garis').removeClass("animation-loading");
                $('#speedo').removeClass("animation-loading");
            }
        });
    }
    $('#batang').bind('jqplotClick', function (ev, seriesIndex, pointIndex, data,jqplot) {
        $(".jqplot-target").attr("style","position:relative;width:100%;");
        var ruangan_nama = "";
        if(data != null){
            ruangan_nama = jqplot.data[0][[data.data[0]][0]-1][0];
        }
        refreshGrafikGaris(ruangan_nama);
    });
    $('#pie').bind('jqplotClick', function (ev, seriesIndex, pointIndex, data,jqplot) {
        $(".jqplot-target").attr("style","position:relative;width:100%;");
        var ruangan_nama = "";
        if(data != null){
            ruangan_nama = data.data[0];
        }
        refreshGrafikGaris(ruangan_nama);
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
        myConfirm("Apakah anda akan membatalkan ini?","Perhatian!",function(r) {
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
    
</script>