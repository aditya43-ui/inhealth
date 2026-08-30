<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Laporan <b>Pasien Komplikasi</b></div>
    </div>
    <div class="panel-body">
        
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Pencarian</div>
            </div>
            <div class="panel-body">
                <?php
		$url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/FramePengkajianAskep&id=1');
		Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('#laporan-search').submit(function(){
                    $.fn.yiiGridView.update('intra-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
			 $('#laporan-search').submit(function(){
                    $.fn.yiiGridView.update('pasca-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
		?>        
		<?php $this->renderPartial($this->path_view . 'search', array('model'	 => $model,
			'format' => $format));
		?>
            </div>
        </div>

    <div class="tab">
		<?php
		$this->widget('bootstrap.widgets.BootMenu', array(
			'type'			 => 'tabs',
			'stacked'		 => false,
			'htmlOptions'	 => array('id' => 'tabmenu'),
			'items'			 => array(
				array('label'			 => 'Intra Anestesi', 'url'			 => 'javascript:tab(0);', 'itemOptions'	 => array(
						"index" => 1), 'active'		 => true),
				array('label'			 => 'Pasca Anestesi', 'url'			 => 'javascript:tab(1);', 'itemOptions'	 => array(
						"index" => 1)),
			),
		))
		?>
        <div class="biru" id="div_intra">
            <!--<legend class="rim">Laporan Jenis Penjamin</legend>-->
            <div class="white"> 
				<?php
				$this->renderPartial('_tableIntra', array(
					'model' => $model
						)
				);
				?>
            </div>
        </div>
        <div class="biru" id="div_pasca">
            <!--<legend class="rim">Rekap Jenis Penjamin</legend>-->
            <div class="white"> 
				<?php
				$this->renderPartial('_tablePasca', array(
					'model' => $model
						)
				);
				?>
            </div>
        </div>
    </div>
	<?php
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print');
	?>
<?php $this->renderPartial($this->path_view . '_footer_pisah', array('urlPrint'	 => $urlPrint,
	'url'		 => $url));
?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>
</div>
</div>
<script>
	function konfirmasi() {
		location.reload();
	}
</script>