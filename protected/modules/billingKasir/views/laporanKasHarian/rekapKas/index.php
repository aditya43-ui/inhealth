<?php
$url = Yii::app()->createUrl(Yii::app()->controller->module->id . '/laporan/frameGrafikKasHarian&id=1');
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('#searchLaporan').submit(function(){
		$('#Grafik').attr('src','').css('height','0px');
		setFooterData();
		//$('#data-foter').addClass('animation-loading');
		$.fn.yiiGridView.update('laporankasharianlab-grid', {
				data: $(this).serialize()
		});
		$.fn.yiiGridView.update('detaillaporankasharianlab-grid', {
				data: $(this).serialize()
		});
		return false;
	});
	");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kas Harian</b>
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
                $this->renderPartial('rekapKas/_search', array(
                    'model' => $model, 'filter' => $filter, 'format' => $format
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kas Harian</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                /*$this->widget('bootstrap.widgets.BootMenu',array(
								'type'=>'tabs',
								'stacked'=>false,
								'htmlOptions'=>array('id'=>'tabmenu'),
								'items'=>array(
									array('label'=>'Rekap Kas Harian','url'=>'javascript:tab(0);','active'=>true),
									array('label'=>'Detail Kas Harian','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
								),
							))*/
                ?>
                <!--fieldset-->
                <?php $this->renderPartial('rekapKas/_tableBaru', array('model' => $model, 'nilaiuang' => $nilaiuang)); ?>
                <!--<iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
							</iframe>-->
                <!--</fieldset>-->
            </div>
        </div>

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKasHarian');
            //$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            //                        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'GRAFIK\')')); 

            $content = $this->renderPartial('billingKasir.views.laporanKasHarian.tips.tips2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php
$js = <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
      //  $("#rekapKas").show();
      //  $("#detailKas").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
          //  $("#filter_tab").val('rekap');
          //  $("#rekapKas").show();
          //  $("#detailKas").hide();  
        } else if (index==1){
           // $("#filter_tab").val('detail');
           // $("#rekapKas").hide();
           // $("#detailKas").show();
        } 
   }
   function onReset()
   {
        setTimeout(
            function(){
                $.fn.yiiGridView.update('laporankasharianlab-grid', {
                    data: $("#caripasien-form").serialize()
                });
                $.fn.yiiGridView.update('detaillaporankasharianlab-grid', {
                    data: $("#caripasien-form").serialize()
                });      
            }, 2000
        );
        return false;
   }   
JS;
Yii::app()->clientScript->registerScript('laporankasharian', $js, CClientScript::POS_HEAD);
?>

<script>
    function setFooterData() {
        var tgl_awal = $("#<?php echo CHtml::activeId($model, 'tgl_awal') ?>").val();
        var tgl_akhir = $("#<?php echo CHtml::activeId($model, 'tgl_akhir') ?>").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('rekapDataFooter'); ?>',
            data: {
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir
            },
            dataType: "json",
            success: function(data) {
                var total = 0;
                $("#rekapclosing-umumrj").html(data.rekapclosing.umumrj);
                $("#rekapclosing-umumri").html(data.rekapclosing.umumri);
                $("#rekapclosing-ekses").html(data.rekapclosing.ekses);
                $("#rekapclosing-piutang").html(data.rekapclosing.piutang);
                $("#rekapclosing-saldomalam").html(data.rekapclosing.saldomalam);
                $("#rekapclosing-debetbca").html(data.rekapclosing.debetbca);
                $("#rekapclosing-pelunasanpiutang").html(data.rekapclosing.pelunasanpiutang);
                $("#rekapclosing-lainlain").html(data.rekapclosing.lainlain);
                $("#rekapclosing-totalcash").html(data.rekapclosing.totalcash);

                $("#rekappendapatan-bpjs").html(data.rekappendapatan.bpjs);
                $("#rekappendapatan-asuransi").html(data.rekappendapatan.asuransi);
                $("#rekappendapatan-umum").html(data.rekappendapatan.umum);
                $("#rekappendapatan-jumlah").html(data.rekappendapatan.jumlah);
                $("#rekappendapatan-ekses").html(data.rekappendapatan.ekses);

                $.each(data.rekapuangpelayanan.nilaiuang, function(index, item) {
                    $("#rekapuangpelayanan-" + index).html(item.banyaknya);
                    $("#rekapuangpelayanan-jumlah" + index).html(item.jumlahnya);
                });

                $("#rekapuangpelayanan-total").html(data.rekapuangpelayanan.nilaiuang.total);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function() {
        setFooterData();
    });
</script>