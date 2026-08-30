<?php
$url = Yii::app()->createUrl('rawatDarurat/laporan/FrameGrafikLaporanPasienDirujuk&id=1');
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

$this->breadcrumbs = array(
    'Laporan Pasien Dirujuk'
);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-newspaper"></i> Laporan <b>Pasien Dirujuk</b>
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
                        <!--fieldset class="box row"-->
                        <?php $this->renderPartial('pasienDirujuk/_search', array(
                            'model' => $model,
                        )); ?>
                        <!--</fieldset>-->
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Pasien Dirujuk</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <!--div class="block-tabel"-->
                        <?php $this->renderPartial('pasienDirujuk/_table', array('model' => $model)); ?>
                        <!--/div-->
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-chart-bar"></i> Grafik
                        </div>
                    </div>
                    <div class="panel-body">
                        <!--div class="block-tabel"-->
                        <?php $this->renderPartial('_tab'); ?>
                        <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
                        <!--/div-->
                    </div>
                </div>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanPasienDirujuk');
                $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
                ?>
            </div>
        </div>
    </div>
</div>

<?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
?>
<!--search-form-->