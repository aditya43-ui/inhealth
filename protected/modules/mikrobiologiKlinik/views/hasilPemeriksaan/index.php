<style>
    .button-status {
        margin-right: 8px;
    }

    .badge-status {
        position: relative;
        top: 8px;
        left: 8px;
    }

    .btn-status {
        min-width: 150px;
    }

    .badge-status-jmlPanggil {
        position: relative;
        top: 10px;
        left: 10px;
        z-index: 10;
    }
    
</style>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Informasi <strong>Hasil Pemeriksaan</strong></div>
            </div>
            <div class="panel-body">
                <?php
                Yii::app()->clientScript->registerScript('search', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
				});
				$('#search-penunjangrujukan-form').submit(function(){
					$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
							data: $(this).serialize()
					});
					return false;
				});
				");
                ?>
                <?php if (!empty($_GET['pendaftaran_id'])) { ?>
                    <div class="mds-form-message success">
                        <?php echo Yii::app()->user->getFlash('success'); ?>
                    </div>
                <?php } ?>

                <?php
                if (!empty($_GET['succes'])) {
                ?>

                    <div class="alert alert-block alert-success">
                        <a class="close" data-dismiss="alert">×</a>
                        <?php
                        if ($_GET['succes'] == 2) {
                        ?>
                            Pemeriksaan Pasien berhasil di batalkan
                        <?php
                        }
                        if ($_GET['succes'] == 1) {
                        ?>
                            Pasein Berhasil Di Rujuk
                        <?php
                        }
                        ?>
                    </div>

                <?php
                }
                ?>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Hasil Pemeriksaan</strong></div>
                    </div>
                    <div class="panel-body" style="overflow-x: scroll">
                        <div class="block-tabel">
                            <?php
                            $this->widget('bootstrap.widgets.BootAlert');
                            $this->renderPartial('_table', ['model' => $model]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial('_formSearch', array('model' => $model, 'format' => $format)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Batal Periksa=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'DialogBatalperiksa',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Batal Periksa - <span id="titleNamaPasienBatal"></span>',
        'autoOpen' => false,
        'show' => 'blind',
        'hide' => 'explode',
        'zIndex' => 1002,
        'minWidth' => 500,
        'minHeight' => 100,
        'resizable' => false,
        'modal' => true,
    ),
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Batal Periksa================================

?>

<?php $this->renderPartial('_jsFunctions', array('model' => $model, 'format' => $format)); ?>
