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
    'Informasi Pasien Master Pasien'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi Pasien <b>Master Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body search-form">
                <!--fieldset class="box search-form"-->
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
            </div>
        </div>
        <!--/fieldset-->
        <div class="tab">
            <?php
            $this->widget('bootstrap.widgets.BootMenu', array(
                'type' => 'tabs',
                'stacked' => false,
                'htmlOptions' => array('id' => 'tabmenu'),
                'items' => array(
                    array('label' => 'Usia dan Jenis Kelamin', 'url' => 'javascript:tab(0);', 'itemOptions' => array("index" => 0), 'active' => true),
                    array('label' => 'Pekerjaan', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
                    array('label' => 'Pendidikan', 'url' => 'javascript:tab(2);', 'itemOptions' => array("index" => 2))
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
                            'dataBarChartUmur' => $dataBarChartUmur,
                            'dataTableUmur' => $dataTableUmur,
                            'dataPieChartUmur' => $dataPieChartUmur,
                            'dataPieChartJk' => $dataPieChartJk,
                            'graphsStackUmur' => $graphsStackUmur,
                            'dataStackChartUmur' => $dataStackChartUmur,
                            'dataStackChartJk' => $dataStackChartJk,
                            'dataPieChartKerja' => $dataPieChartKerja,
                            'dataTableKerja' => $dataTableKerja,
                            'dataStackChartKerja' => $dataStackChartKerja,
                            'graphsStackKerja' => $graphsStackKerja,
                            'dataPieChartPdk' => $dataPieChartPdk,
                            'dataStackChartPdk' => $dataStackChartPdk,
                            'dataTablePdk' => $dataTablePdk,
                            'graphsStackPdk' => $graphsStackPdk
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
$js = <<< JSCRIPT
	$(document).ready(function () {
		$("#tabmenu").children("li").children("a").click(function () {
			$("#tabmenu").children("li").attr('class', '');
			$(this).parents("li").attr('class', 'active');
			$(".icon-pencil").remove();
			$(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
		});
		$("#div_ujk").show();
		$("#div_kerja").hide();
		$("#div_pdk").hide();
	});
	function tab(index) {
		$(this).hide();
		if (index == 0) {
			$("#SEPasienujkR_pilihan_tab").val("ujk");
			$("#div_ujk").show();
			$("#div_kerja").hide();
			$("#div_pdk").hide();
		} else if (index == 1) {
			$("#SEPasienujkR_pilihan_tab").val("kerja");
			$("#div_ujk").hide();
			$("#div_kerja").show();
			$("#div_pdk").hide();
		} else if (index == 2) {
			$("#SEPasienujkR_pilihan_tab").val("pdk");
			$("#div_ujk").hide();
			$("#div_kerja").hide();
			$("#div_pdk").show();
		}
	}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>