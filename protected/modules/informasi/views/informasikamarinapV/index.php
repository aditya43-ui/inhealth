<?php
$this->breadcrumbs = array(
    'Informasi Kamar Rawat Inap',
);
?>
<link rel="stylesheet" type="text/css" href="css/font.css" />
<style>
    .contentKamar {
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -o-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
    }

    .contentKamar {
        border: 1px solid black;
        margin: 10px;
    }

    .bed {
        display: inline-block;
        margin-right: 10px;
        margin-top: 10px;
        box-shadow: none;
        max-width: calc(100% - 40px);
    }

    .detail_bed {
        width: 110px;
        margin-right: 5px;
    }

    .detail_bed>a {
        height: 120px;
        position: relative;
    }

    .detail_bed>a>img {
        position: absolute;
        bottom: 0;
    }

    .detail_bed>a>.no_kamar {
        position: absolute;
        right: 10px;
        top: 10px;
    }

    .detail_bed>a>.jk {
        position: absolute;
        left: 10px;
        top: 10px;
    }

    .panel-custom {
        display: inline-block;
        min-width: 150px;
    }

    .popover-inner {
        width: 1000px;
    }

    .popover-title {
        width: 100%;
        border: none;
    }

    .image_ruangan {
        width: 90%;
        margin-bottom: 15px;
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
        margin: 5px 0px;
        /*
        min-height: 60px;*/
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

    .info_nama .span3 {
        width: 100px;
    }

    ul,
    li {
        vertical-align: top;
    }

    .textKecil {
        padding: 15px;
        font-size: 10pt;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kamar
                <?php
                if (empty($instalasi_id)) {
                    $cri = new CDbCriteria();
                    $cri->addCondition(" instalasi_aktif = TRUE ");
                    $cri->addInCondition("instalasi_id", Params::getArrayInstalasiInap());
                    $cri->order = " instalasi_nama ASC ";
                    $modelins = InstalasiM::model()->findAll($cri);
                } else {
                    $modelins = InstalasiM::model()->findAll("instalasi_id ='" . $instalasi_id . "'");
                }
                foreach ($modelins as $key) {
                    echo $key->instalasi_nama;
                } ?></b>
        </div>
    </div>
    <div class="panel-body" style="overflow-y:auto">
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
        <div class="info_nama">
            <div class="testclick">
                <?php
                $cri = new CDbCriteria();
                if (empty($instalasi_id)) {
                    $cri->addInCondition("instalasi_id", Params::getArrayInstalasiInap());
                } else {
                    $cri->addCondition("instalasi_id ='" . $instalasi_id . "'");
                }
                $cri->addCondition(" ruangan_aktif = TRUE ");
                $cri->order = " ruangan_nama ASC ";
                $ruanganM = RuanganM::model()->findAll($cri);
                if (!empty($ruanganM)) {
                    foreach ($ruanganM as $key => $val) {
                        echo '<div class="col-md-2 col-xs-4">';
                        echo '<div class="foricon" onclick="getListRuangan(' . $val->ruangan_id . ')" title="Klik untuk melihat informasi">';
                        echo '<div class="textKecil">' . $val->ruangan_nama . '</div>';
                        if (!empty($val->ruangan_image)) {
                            if (file_exists(Yii::app()->baseUrl . '/data/images/ruangan/tumbs/kecil_' . $val->ruangan_image)) {
                                echo '<img src=\'' . Yii::app()->baseUrl . '/data/images/ruangan/tumbs/kecil_' . $val->ruangan_image . '\' class=\'image_ruangan\'>';
                            } else {
                                echo '<img src=\'' . Yii::app()->baseUrl . '/data/images/ruangan/tumbs/no_photo.jpeg\' class=\'image_ruangan\'>';
                            }
                        } else {
                            echo '<img src=\'' . Yii::app()->baseUrl . '/data/images/ruangan/tumbs/no_photo.jpeg\' class=\'image_ruangan\'>';
                        }
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="clear"></div>
        <div class="isi" style="margin-top: 17px;">
            <?php echo $row; ?>
        </div>
    </div>
</div>
<?php
$url = Yii::app()->createUrl($this->route);
Yii::app()->clientScript->registerScript('list', '
    function getListRuangan(ruangan){
//        ruangan = $("#ruangan").val();
        $(".contentKamar").addClass("animation-loading");
        $.post("' . $url . '", {ajax:true,ruangan:ruangan},function(data){
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

    function kiriminfo(no, keterangankamar, kelas_pelayanan) {
        $('#infokamar').dialog('open');
        $('#nourut').text(no);
        $('#ketkamar').text(keterangankamar);
        $('#kelpelayanan').text(kelas_pelayanan);
        //alert(keterangankamar+jml+kelas_pelayanan);
    }

    function ubahDokterPeriksa(pendaftaran_id, pasienadmisi_id) {
        $('#temp_idPendaftaranDP').val(pendaftaran_id);
        $('#temp_idPasienadmisiDP').val(pasienadmisi_id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('ubahDokterPeriksa') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                } else {
                    $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                    $.fn.yiiGridView.update('daftarpasien-v-grid', {
                        data: $('form').serialize()
                    });
                    setTimeout("$('#editDokterPeriksa').dialog('close') ", 500);
                }
            },
            'cache': false
        });
        return false;
    }
</script>