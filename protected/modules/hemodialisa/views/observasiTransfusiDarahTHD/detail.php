<?php
$module = $this->module->id;
$this->widget('bootstrap.widgets.BootMenu', array(
    'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked' => false, // whether this is a stacked menu
    'items' => array(
        array('label' => 'Data Kantong Darah', 'url' => 'javascript:void(0);', 'itemOptions' => array('active' => true, 'onclick' => 'setTab(this);', 'tab' => $module . '/kantongDarahHdT/detail&id='.$modKantong->kantong_transfusi_darah_id)),
        array('label' => 'Observasi Transfusi Darah', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/observasiTransfusiDarahTHD/detailRow&id='.$modDetail->kantong_transfusi_darah_det_id)),
    ),
));
?>
<div>
    <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; overflow-x: scroll;" ></iframe>
</div>
<?php $baseUrl = Yii::app()->createUrl("/"); ?>
<script type='text/javascript'>
    function setTab(obj) {
        $(obj).parents("ul").find("li").each(function () {
            $(this).removeClass("active");
            $(this).attr("onclick", "setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick", "setTab(this);");
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab);
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function () {
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
</script>