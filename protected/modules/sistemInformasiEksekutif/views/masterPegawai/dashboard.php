<?php
//Yii::app()->clientScript->registerScript('search', "
//$('.search-form form').submit(function(){
//    $.fn.yiiGridView.update('tableLaporanJmlPasienHarian', {
//        data: $(this).serialize()
//    });
//    $.fn.yiiGridView.update('tableRekapJmlPasienHarian', {
//        data: $(this).serialize()
//    });
//    return false;
//});
//");
?>
<?php
$this->breadcrumbs = array(
    'Informasi Pegawai Master Pegawai'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi Pegawai <b>Master Pegawai</b>
        </div>
    </div>
    <div class="panel-body search-form">
        <?php $this->renderPartial('_search', array('model' => $model,)); ?>
        <div class="tab">
            <?php
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type' => 'tabs',
                'stacked' => false,
                'htmlOptions' => array('id' => 'tabmenu'),
                'items' => array(
                    array('label' => 'Jenis Kelamin', 'url' => 'javascript:tab(0);', 'itemOptions' => array("index" => 0), 'active' => true),
                    array('label' => 'Kelompok Pegawai', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
                    array('label' => 'Pendidikan', 'url' => 'javascript:tab(2);', 'itemOptions' => array("index" => 2)),
                    array('label' => 'Usia', 'url' => 'javascript:tab(3);', 'itemOptions' => array("index" => 3)),
                ),
            ))
            ?>
            <div class="biru" id="tables">
                <div class="white">
                    <?php
                    $this->renderPartial(
                        '_charts',
                        array(
                            'model' => $model,
                            'modelUmur' => $modelUmur,
                            'modelKlp' => $modelKlp,
                            'dataPieChartPdk' => $dataPieChartPdk,
                            'dataStackChartPdk' => $dataStackChartPdk,
                            'graphsStackPdk' => $graphsStackPdk,
                            'dataLineChartPdk' => $dataLineChartPdk,
                            'graphsLinePdk' => $graphsLinePdk,
                            'dataTablePdk' => $dataTablePdk,
                            'dataPieChartUmur' => $dataPieChartUmur,
                            'dataPieChartUmurDet' => $dataPieChartUmurDet,
                            'dataTableUmur' => $dataTableUmur,
                            'dataBarChartUmur' => $dataBarChartUmur,
                            'dataPieChartKlp' => $dataPieChartKlp,
                            'dataStackChartKlp' => $dataStackChartKlp,
                            'graphsStackKlp' => $graphsStackKlp,
                            'dataLineChartKlp' => $dataLineChartKlp,
                            'graphsLineKlp' => $graphsLineKlp,
                            'dataTableKlp' => $dataTableKlp,
                            'dataBarLineChartJk' => $dataBarLineChartJk,
                            'dataPieChartJk' => $dataPieChartJk,
                            'dataTableJk' => $dataTableJk
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
?>
<script>
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class', '');
            $(this).parents("li").attr('class', 'active');
            $(".icon-pencil").remove();
            $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        $("#div_jk").show();
        $("#div_klp").hide();
        $("#div_pdk").hide();
        $("#div_umur").hide();
    });

    function tab(index) {
        $(this).hide();
        if (index == 0) {
            $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("jk");
            $("#div_jk").show();
            $("#div_klp").hide();
            $("#div_pdk").hide();
            $("#div_umur").hide();
        } else if (index == 1) {
            $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("klp");
            $("#div_jk").hide();
            $("#div_klp").show();
            $("#div_pdk").hide();
            $("#div_umur").hide();
        } else if (index == 2) {
            $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("pdk");
            $("#div_jk").hide();
            $("#div_klp").hide();
            $("#div_pdk").show();
            $("#div_umur").hide();
        } else if (index == 3) {
            $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("umur");
            $("#div_jk").hide();
            $("#div_klp").hide();
            $("#div_pdk").hide();
            $("#div_umur").show();
        }
    }
</script>