<?php

    $menu_list = array(
        array(
            'label'=>"Pemeriksaan Umum",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'periksaUmum')
        ),
        array(
            'label'=>"Jantung",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'jantung')
        ),
        array(
            'label'=>"Kandungan",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'kandungan')
        ),
        array(
            'label'=>"Lain-Lain",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'lainLain')
        ),
        array(
            'label'=>"Laboratorium",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'laboratorium')
        ),
        array(
            'label'=>"Radiologi",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'radiologi')
        ),
        array(
            'label'=>"Treadmill",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'treadmill')
        ),
        array(
            'label'=>"Hearing Test",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'hearingTest')
        ), /*
        array(
            'label'=>"Konsultasi Poliklinik",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'konsul')
        ),
        array(
            'label'=>"Diagnosis",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'diagnosa')
        ), */
        array(
            'label'=>"Jantung Koroner",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'koroner')
        ),
        array(
            'label'=>"Tes Spirometri",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'spirometri')
        ),
        array(
            'label'=>"Kesimpulan dan Saran",
            'url'=>'javascript:void(0);',
            'itemOptions'=>array('onclick'=>'setTab(this);', 'data-submenu'=>'kesimpulan')
        ),
    );

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$menu_list,
    'htmlOptions'=>array(
        'id'=>'tab_bayi',
    )
));
?>
<div>
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
</div>

<script type='text/javascript'>
<?php $baseUrl = $this->createUrl("detailMCUDetail"); ?>

var id = <?php echo $pendaftaran->pendaftaran_id; ?>
    
function setTab(obj){
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
        $(this).attr("onclick","setTab(this);");
    });
    $(obj).addClass("active");
    $(obj).removeAttr("onclick","setTab(this);");
    var tab = $(obj).data("submenu");
    var frameObj = document.getElementById("frame");
    resetIframe(frameObj);
    $(frameObj).attr("src","<?php echo $baseUrl;?>&id=" + id + "&submenu="+tab);
    $(frameObj).parent().addClass("animation-loading");
    $(frameObj).load(function(){
        $(frameObj).parent().removeClass("animation-loading");
        resizeIframe(frameObj);
    });
    return false;
}

function resetIframe(obj) {
    obj.style.height = 128 + 'px';
}

function resizeIframe(obj) {            
    obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
}

function resizeIframeJs(obj) {  
    var h1 = obj.height();
    var h2 = 100;
    var h3 = h2+h1;
    
    obj.attr("style",'height:'+h3+'px');
}

$(document).ready(function() {
    $("#tab_bayi li a").eq(0).click();
});

</script>