<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('tableLaporanCaraBayar', {
            data: $(this).serialize()
        });
        $.fn.yiiGridView.update('tableRekapCaraBayar', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Jenis Penjamin</b>
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
                <?php
                $this->renderPartial(
                    $this->path_view . 'caraBayar/_searchCaraBayar',
                    array(
                        'model' => $model,
                    )
                );
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Laporan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('bootstrap.widgets.BootMenu', array(
                    'type' => 'tabs',
                    'stacked' => false,
                    'htmlOptions' => array('id' => 'tabmenu'),
                    'items' => array(
                        array('label' => 'Data Pasien Umum', 'url' => 'javascript:tab(0);', 'itemOptions' => array("index" => 1), 'active' => true),
                        array('label' => 'Rekap Umum', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
                        array('label' => 'Data Pasien P3', 'url' => 'javascript:tab(2);', 'itemOptions' => array("index" => 1)),
                        array('label' => 'Rekap P3', 'url' => 'javascript:tab(3);', 'itemOptions' => array("index" => 1)),
                        array('label' => 'Data Pasien BPJS', 'url' => 'javascript:tab(4);', 'itemOptions' => array("index" => 1)),
                        array('label' => 'Rekap BPJS', 'url' => 'javascript:tab(5);', 'itemOptions' => array("index" => 1)),
                    ),
                ))
                ?>
                <div class="biru divTabMenu" id="div_umum">
                    <div class="panel-body table-responsive" style="margin: 0 !important;">
                        <?php
                        $this->renderPartial(
                            $this->path_view . 'caraBayar/_tableCaraBayarUmum',
                            array(
                                'model' => $model
                            )
                        );
                        ?>
                    </div>
                </div>
                <div class="biru divTabMenu" id="div_rekapUmum">
                    <div class="panel-body table-responsive" style="margin: 0 !important;">
                        <?php
                        $this->renderPartial(
                            $this->path_view . 'caraBayar/_tableRekapCaraBayarUmum',
                            array(
                                'model' => $model
                            )
                        );
                        ?>
                    </div>
                </div>

                <div class="biru divTabMenu" id="div_reportCaraBayar">
                    <div class="panel-body table-responsive" style="margin: 0 !important;">
                        <?php
                        $this->renderPartial(
                            $this->path_view . 'caraBayar/_tableCaraBayarP3',
                            array(
                                'model' => $model
                            )
                        );
                        ?>
                    </div>
                </div>

                <div class="biru divTabMenu" id="div_rekapCaraBayar">
                    <div class="panel-body table-responsive" style="margin: 0 !important;">
                        <?php
                        $this->renderPartial(
                            $this->path_view . 'caraBayar/_tableRekapCaraBayarP3',
                            array(
                                'model' => $model
                            )
                        );
                        ?>
                    </div>
                </div>

                <div class="biru divTabMenu" id="div_bpjs">
                    <div class="panel-body table-responsive" style="margin: 0 !important;">
                        <?php
                        $this->renderPartial(
                            $this->path_view . 'caraBayar/_tableCaraBayarBpjs',
                            array(
                                'model' => $model
                            )
                        );
                        ?>
                    </div>
                </div>

                <div class="biru divTabMenu" id="div_rekapBpjs">
                    <div class="panel-body table-responsive" style="margin: 0 !important;">
                        <?php
                        $this->renderPartial(
                            $this->path_view . 'caraBayar/_tableRekapCaraBayarBpjs',
                            array(
                                'model' => $model
                            )
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Grafik', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'GRAFIK\')'));

            $content = $this->renderPartial('billingKasir.views.laporan.caraBayar.tips', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function checkAll() {
        if ($("#checkAllRuangan").is(':checked')) {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", false);
        }

    }
</script>
<?php

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/laporanCaraBayar');

$js = <<< JSCRIPT
				$(document).ready(function() {
					$("#tabmenu").children("li").children("a").click(function() {
						$("#tabmenu").children("li").attr('class','');
						$(this).parents("li").attr('class','active');
						$(".icon-pencil").remove();
						// $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
					});

					tab(0);
				});

				function tab(index){
					$(this).hide();
					if (index==0){
						$("#BKLaporanCaraBayar_pilihan_tab").val("umum");
            $(".divTabMenu").hide();
						$("#div_umum").show();
					}
          else if(index==1){
						$("#BKLaporanCaraBayar_pilihan_tab").val("rekapUmum");
            $(".divTabMenu").hide();
            $("#div_rekapUmum").show();
					}
          else if(index==2){
						$("#BKLaporanCaraBayar_pilihan_tab").val("report");
            $(".divTabMenu").hide();
            $("#div_reportCaraBayar").show();
					}
          else if(index==3){
						$("#BKLaporanCaraBayar_pilihan_tab").val("rekap");
            $(".divTabMenu").hide();
            $("#div_rekapCaraBayar").show();
					}
          else if(index==4){
						$("#BKLaporanCaraBayar_pilihan_tab").val("bpjs");
            $(".divTabMenu").hide();
            $("#div_bpjs").show();
					}
          else if(index==5){
						$("#BKLaporanCaraBayar_pilihan_tab").val("rekapBpjs");
            $(".divTabMenu").hide();
            $("#div_rekapBpjs").show();
					}
				}
				function print(caraPrint)
				{
					window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>