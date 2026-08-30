<link rel="stylesheet" type="text/css" href="css/font.css" />
<style>
    .contentKamar {
        margin: 10px;
    }

    .bed {
        display: inline-block;
        width: 100%;
        margin: 10px;
    }

    .popover-inner {
        width: 1000px;
    }

    .popover-title {
        width: 100%;
        border: none;
    }

    .image_ruangan {
        width: 20%;
    }

    .pintu {
        background-image: url(images/pintu.png);
        width: 16px;
        height: 75px;
        margin-top: 80px;
        float: right;
        margin-right: -2px;
    }

    .datakosong {
        margin: 10px;
        padding: 5px;
        font-style: italic;
        color: red;
    }

    .foricon {
        border: 1px solid #eee;
        text-align: center;
        font-weight: bold;
        margin: 5px 5px;
        min-height: 60px;
        display: block;
        cursor: pointer;
        border-radius: 15px;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.2);
    }

    .foricon img {
        border-radius: 10px;
    }

    .foricon:hover {
        background-color: #ffb366;
    }

    .active {
        background-color: #b3d1ff;
    }

    .info_nama .row {
        margin-left: 0;
    }

    .info_nama .span3 {
        width: 100px;
    }

    ul,
    li {
        vertical-align: top;
    }

    .textKecil {
        font-size: 8pt;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kamar
                <?php
                $modelins = InstalasiM::model()->findAll("instalasi_id ='" . $instalasi_id . "'");
                foreach ($modelins as $key) {
                    echo $key->instalasi_nama;
                } ?></b>
        </div>
    </div>
    <div class="panel-body" style="overflow-y:auto">
        <div class="isi">
            <?php //echo $row; 
            ?>
        </div>
        <?php
        //    echo CHtml::dropDownList('ruangan', '', CHtml::listData(
        //        RuanganM::model()->findAllByAttributes(
        //            array(
        //                'instalasi_id'=>Params::INSTALASI_ID_RI,
        //                'ruangan_aktif'=>true
        //            ),
        //            array('order'=>'ruangan_nama')
        //        ), 'ruangan_id', 'ruangan_nama'),
        //        array('empty'=>'-- Pilih --', 'onchange'=>'getListRuangan();')
        //    ); 
        ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        getListRuangan(<?php echo $ruangan_id ?>, <?php echo $ruangananak_id ?>);
    });
</script>
<?php
$url = Yii::app()->createUrl($this->route);
Yii::app()->clientScript->registerScript('list', '
    function getListRuangan(ruangan_id,ruangananak_id){
//        ruangan = $("#ruangan").val();
        $(".contentKamar").addClass("animation-loading");
        $.post("' . $url . '", {ajax:true,ruangan_id:ruangan_id,ruangananak_id:ruangananak_id},function(data){
            $(".isi").html(data);
            $(".contentKamar").removeClass("animation-loading");
            jQuery(\'a[rel="popover"]\').popover();
            jQuery(\'.poping\').popover({placement:"bottom"});
        },"json");
    }
',  CClientScript::POS_HEAD); ?>
<?php Yii::app()->clientScript->registerScript('readyFunction', '
    jQuery(\'.poping\').popover({placement:"bottom"});
//    $(".bed").mousemove(function(e){
//        $(".popover").show();
//        tinggi = $(".popover").height()/2;
//        $(".popover").css("left",e.clientX);        
//        $(".popover").css("top",($(document).scrollTop())+e.clientY-tinggi);   
//    });
//    
//    $(".bed").click(function(e){
//        $(".popover").slideToggle();
//    });
    ',  CClientScript::POS_READY); ?>
<script>
    $(".foricon").click(function() {
        $(".active").removeClass("active");
        $(this).addClass("active");
    });
</script>