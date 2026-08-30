<div class="panel panel-gradient">
    <div class="panel-heading">    
        <div class="panel-title">Informasi Daftar <b>Pasien Anestesi</b></div>
    </div>
    <div class="panel-body">

    <?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $modul  = $this->module->name; 
    $control = $this->id;

    Yii::app()->clientScript->registerScript('search', "
		$(document).ready(function(){
		$('#caripasien-form').submit(function(){
		$('#daftarpasien-v-grid').addClass('animation-loading');
				$.fn.yiiGridView.update('daftarpasien-v-grid', {
						data: $(this).serialize()
				});
				return false;
		});
    });         
    ");
    ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Tabel Daftar <b>Pasien Anestesi</b></div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial('_tablePasien', array('model'=>$model));  ?> 
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title judul">Pencarian</div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search',array('model'=>$model)); ?>
            </div>
        </div>

</div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRincian',
        'options' => array(
            'title' => 'Rincian Tagihan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 900,
            'height' => 550,
            'resizable' => false,
        ),
    ));
?>
    <iframe name='frameRincian' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>