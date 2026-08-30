<?php
$url = Yii::app()->createUrl(Yii::app()->controller->module->id . '/laporan/frameGrafikKasHarian&id=1');
Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('#searchLaporan').submit(function(){
		$('#Grafik').attr('src','').css('height','0px');
		$.fn.yiiGridView.update('laporansetorankebank-grid', {
				data: $(this).serialize()
		});
		return false;
	});
	");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Setoran ke Bank</b>
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
                <!--fieldset class="box search-form"-->
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model, 'filter' => $filter, 'format' => $format
                ));
                ?>
                <!--</fieldset>-->
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Setoran ke Bank</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tableBaru', array('model' => $model)); ?>
                <!--<iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
						</iframe>-->
            </div>
        </div>

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKasHarian');
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            //                    echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'GRAFIK\')')); 

            $content = $this->renderPartial('billingKasir.views.laporanKasHarian.tips.tips2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<?php
$js = <<< JS

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('rekap');
            $("#rekapKas").show();
            $("#detailKas").hide();  
        } else if (index==1){
            $("#filter_tab").val('detail');
            $("#rekapKas").hide();
            $("#detailKas").show();
        } 
   }
   function onReset()
   {
        setTimeout(
            function(){
                $.fn.yiiGridView.update('laporansetorankebank-grid', {
                    data: $("#caripasien-form").serialize()
                });     
            }, 2000
        );
        return false;
   }   
JS;
Yii::app()->clientScript->registerScript('laporankasharian', $js, CClientScript::POS_HEAD);
?>