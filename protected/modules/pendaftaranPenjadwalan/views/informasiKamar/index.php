<?php
$this->breadcrumbs = array(
    'Informasi Kamar'
);
?>
<script>
    $(document).ready(
        function() {
            var idRuangan = 207;
            getDataKamar(idRuangan);
        }
    );

    function getKelasPelayanan(obj) {
        $.post('<?php echo $this->createUrl('GetRuanganKamarRuangan'); ?>', {
                idRuangan: idRuangan
            },
            function(data) {
                $("#infoRuangan").find('legend[id="photo"]').text('Foto Ruangan ' + data.data_ruangan.nama);
                $("#infoRuangan").find('img').attr('src', data.data_ruangan.foto);
                $("#infoRuangan").find('div[id="fasilitasRuangan"]').text(data.data_ruangan.fasilitas);
            },
            'json');
    }

    function getDataKamar(obj) {
        var idRuangan = null;
        if (typeof obj == 'obj') {
            idRuangan = $(obj).val();
        } else {
            idRuangan = obj;
        }
        $.post('<?php echo Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getInfoKamar'); ?>', {
                idRuangan: idRuangan
            },
            function(data) {
                $("#infoRuangan").find('legend[id="photo"]').text('Foto Ruangan ' + data.data_ruangan.nama);
                $("#infoRuangan").find('img').attr('src', data.data_ruangan.foto);
                $("#infoRuangan").find('div[id="fasilitasRuangan"]').text(data.data_ruangan.fasilitas);
            },
            'json');
    }

    function getInfoKamar(obj) {
        // var is_kosong = 0;
        // $(obj).find('label.required').each(
        //     function()
        //     {
        //         if($(this).parent('.control-group').find().val('select') == "")
        //         {
        //             is_kosong++;
        //         }
        //     }
        // );
        // if(is_kosong > 0)
        // {
        //     myAlert('pilihan belum lengkap, silakan cek kembali!');
        // }else{
        var idRuangan = 207;
        var data = {
            ruangan_id: $(obj).find('select[name$="[ruangan_id]"]').val(),
            kelaspelayanan_id: $(obj).find('select[name$="[kelaspelayanan_id]"]').val(),
            kamarruangan_nokamar: $(obj).find('select[name$="[kamarruangan_nokamar]"]').val()
        };
        $("#form_kasur").empty();
        $.post('<?php echo Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDetailKamar'); ?>', data,
            function(data) {
                if (data.form != "") {
                    $("#form_kasur").append(data.form);
                }
                $(obj).find("button[type='submit']").removeAttr("disabled");
            },
            'json');
        // }
        return false;
    }
</script>
<style>
    .popover {
        border: none;
    }

    .contentKamar,
    .bed {
        box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        -o-box-shadow: 0 5px 10px rgba(0, 0, 0, .6);
        border-radius: 3px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        -o-border-radius: 3px;
    }

    .contentKamar {
        margin: 15px;
    }

    .bed {
        display: inline-block;
        margin-right: 10px;
        margin-top: 10px;
        box-shadow: none;
        max-width: calc(100% - 40px);
    }

    .detail_bed {
        width: 200px;
        height: 180px;
        margin-right: 5px;
    }

    .detail_bed>a {
        height: 180px;
        position: relative;
    }

    .detail_bed>a>img {
        width:80px;
        height:80px;
        position: absolute;
        top: 35px;
        left: 60px;
    }

    .detail_bed>a>.no_kamar {
        position: absolute;
        right: 10px;
        top: 10px;
    }
    .detail_bed>a>.dataPas{
        word-wrap: break-word;
        position: absolute;
        bottom: 10px;
        font-size: 8px;
    }


    .panel-custom {
        display: inline-block;
        min-width: 150px;
    }

    .popover-inner {
        width: 100%;
    }

    .image_ruangan {
        height: 100px;
        width: 100px;
    }

    .pintu {
        background-image: url(images/pintu.png);
        width: 16px;
        height: 75px;
        margin-top: 80px;
        float: right;
        margin-right: -2px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Kamar</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo CHtml::label('Ruangan', 'ruangan_nama', array('class' => 'control-label')) ?>
                    <?php
                    echo CHtml::dropDownList(
                        'ruangan',
                        '',
                        CHtml::listData(
                            RuanganM::model()->findAll(" ruangan_aktif = TRUE AND instalasi_id IN ('" . Params::INSTALASI_ID_RI . "','" . Params::INSTALASI_ID_ICU . "','" . Params::INSTALASI_ID_IBS . "') ORDER BY ruangan_nama "),
                            'ruangan_id',
                            'ruangan_nama'
                        ),
                        array('empty' => '-- Pilih --', 'onchange' => 'getListRuangan();')
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="isi">
        <?php echo $row; ?>
    </div>
</div>
<?php
$url = Yii::app()->createUrl($this->route);
Yii::app()->clientScript->registerScript('list', '
    function getListRuangan(){
        ruangan = $("#ruangan").val();
        $(".contentKamar").addClass("animation-loading");
        $.post("' . $url . '", {ajax:true,ruangan:ruangan},function(data){
            $(".isi").html(data);
            $(".contentKamar").removeClass("animation-loading");
            jQuery(\'a[data-toggle="popover"]\').popover();
            jQuery(\'.poping\').popover({placement:"bottom"});
        },"json");
    }
', CClientScript::POS_HEAD);
?>
<?php Yii::app()->clientScript->registerScript('readyFunction', '
    jQuery(\'.poping\').popover({placement:"bottom"});
//    $(".bed").mousemove(function(e){
//        $(".popover").show();
//        tinggi = $(".popover").height()/2;
//        $(".popover").css("left",e.clientX);        
//        $(".popover").css("top",($(document).scrollTop())+e.clientY-tinggi);   
//    });
//    
   $(".bed").click(function(e){
        $(".popover").slideToggle();
    });
    ', CClientScript::POS_READY); ?>