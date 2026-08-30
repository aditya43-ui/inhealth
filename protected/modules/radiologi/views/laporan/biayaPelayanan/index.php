<!--div class="white-container"-->
<div class="row">
	<?php
    //$this->breadcrumbs=array(
    //    'Ppinfo Kunjungan Rjvs'=>array('index'),
    //    'Manage',
    //);

    $url = Yii::app()->createUrl('radiologi/laporan/frameGrafikLaporanBiayaPelayanan&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('tableLaporan', {
			data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                <i class="entypo-newspaper"></i> Laporan <b>Biaya Pelayanan</b></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
                    </div>
                    <div class="panel-body">
						<fieldset class="box search-form">
							<?php $this->renderPartial('biayaPelayanan/_search',array(
								'model'=>$model,
							)); ?>
						 </fieldset>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Biaya Pelayanan</b></div>
                    </div>
                    <div class="panel-body table-responsive">
						<div class="block-tabel"> 
							<?php $this->renderPartial('biayaPelayanan/_table', array('model'=>$model)); ?>
						</div>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
                    </div>
                    <div class="panel-body">
						<div class="block-tabel">
							<?php $this->renderPartial('_tab'); ?>
							<iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
							</iframe>        
						</div>
                    </div>
                </div>	
				<?php 
					//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
					//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
					//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
					//        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
					//')); 
					$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
					$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
					$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanBiayaPelayanan');
					$this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
				?>
            </div>
        </div>
    </div>
</div>
    
<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); ?>          
<!--/div-->