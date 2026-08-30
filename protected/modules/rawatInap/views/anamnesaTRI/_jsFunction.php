<?php $pemeriksaanFisik = Yii::app()->createUrl('rawatInap/pemeriksaanFisikTRI2/index&pendaftaran_id=' . $modPendaftaran->pendaftaran_id); ?>
<?php $laboratorium = Yii::app()->createUrl('rawatJalan/laboratorium/index&pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '&pasienadmisi_id=' . $modPendaftaran->pasienadmisi_id); ?>
<?php $laboratoriumPA = Yii::app()->createUrl('rawatInap/patologiAnatomiTRI/index&pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '&pasienadmisi_id=' . $modPendaftaran->pasienadmisi_id); ?>
<?php //$radiologi = Yii::app()->createUrl('rawatInap/radiologiTRINew/index&pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '&pasienadmisi_id=' . $modPendaftaran->pasienadmisi_id); ?>
<?php $radiologi = Yii::app()->createUrl('rawatJalan/radiologiNew/index&pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '&pasienadmisi_id=' . $modPendaftaran->pasienadmisi_id); ?>

<?php $diagnosis = Yii::app()->createUrl('rawatInap/diagnosaTRINew/index&pendaftaran_id=' . $modPendaftaran->pendaftaran_id . '&pasienadmisi_id=' . $modPendaftaran->pasienadmisi_id); ?>

<?php

$daftar = $modPendaftaran;
$count = count((array)$daftar) * 90;
$default = 100 + $count;

?>
<script>
function cekCeklisRadio() {
    $(".panel_radio_group").each(function() {
        var obj = $(this);

        console.log("Kick");

        var v = $(obj).find(".panel_radio_ceklis:checked").val();
        if ($(obj).find(".panel_radio_text").data("ceklis") != v) {
            $(obj).find(".panel_radio_text").val("").prop("disabled", true);
        } else {
            $(obj).find(".panel_radio_text").prop("disabled", false);
        }
    });
}

function setPemeriksaanFisik() {

    var frameObj = document.getElementById("pemeriksaanFisik");
    var jsframe = $("#pemeriksaanFisik");


    jsframe.attr("src", "<?php echo $pemeriksaanFisik; ?>");
    jsframe.parent().addClass("animation-loading");
    jsframe.on('load', function() {
        resizeIframeJs(jsframe, 2000);
        jsframe.parent().removeClass("animation-loading");
    });
    return false;
}

function setLaboatorium() {

    var frameObj = document.getElementById("laboratorium");
    var jsframe = $("#laboratorium");


    jsframe.attr("src", "<?php echo $laboratorium; ?>");
    jsframe.parent().addClass("animation-loading");
    jsframe.on('load', function() {
        resizeIframeJs(jsframe, 4000);
        jsframe.parent().removeClass("animation-loading");
    });
    return false;
}

function setLaboatoriumPA() {

var frameObj = document.getElementById("laboratoriumPA");
var jsframe = $("#laboratoriumPA");


jsframe.attr("src", "<?php echo $laboratoriumPA; ?>");
jsframe.parent().addClass("animation-loading");
jsframe.on('load', function() {
    resizeIframeJs(jsframe, 800);
    jsframe.parent().removeClass("animation-loading");
});
return false;
}

function setRadiologi() {

var frameObj = document.getElementById("radiologi");
var jsframe = $("#radiologi");

console.log('klik rad');

jsframe.attr("src", "<?php echo $radiologi; ?>");
jsframe.parent().addClass("animation-loading");
jsframe.on('load', function() {
    resizeIframeJs(jsframe, 3000);
    jsframe.parent().removeClass("animation-loading");
});
return false;
}

function setDiagnosis() {

var frameObj = document.getElementById("diagnosis");
var jsframe = $("#diagnosis");


jsframe.attr("src", "<?php echo $diagnosis; ?>");
jsframe.parent().addClass("animation-loading");
jsframe.on('load', function() {
    resizeIframeJs(jsframe, 700);
    jsframe.parent().removeClass("animation-loading");
});
return false;
}


function resizeIframeJs(obj, height = 100) {
    var h1 = obj.height();
    var h2 = 100;
    var h3 = h2 + h1;

    obj.attr("style", 'height: ' + height + 'px; width: 100%');
}

$('#form-pemeriksaanfisik').click(function () {
    setPemeriksaanFisik();
});

$('#form-laboratorium').click(function () {
    setRadiologi();
});

$('#form-laboratoriumPA').click(function () {
    setLaboatoriumPA();
});

$('#form-radiologi').click(function () {
    setRadiologi();
});

$('#form-diagnosis').click(function () {
    setDiagnosis();
});

$(document).ready(function() {
    $(".panel_radio_ceklis").on('click', cekCeklisRadio);

    cekCeklisRadio();

    // setPemeriksaanFisik();
    // setLaboatorium();
    // setLaboatoriumPA();
    // setRadiologi();
    // setDiagnosis();
});
</script>