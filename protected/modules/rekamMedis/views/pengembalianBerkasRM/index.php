<?php
$this->breadcrumbs = array(
    'Transaksi Pengembalian Dokumen Rekam Medis',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Pengembalian Dokumen Rekam Medis</b>
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
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data Pengembalian Dokumen Rekam Medis berhasil disimpan!");
                }
                ?>
                <?php
                Yii::app()->clientScript->registerScript('search', "
                            $('.search-button').click(function(){
                                $('.search-form').toggle();
                                return false;
                            });
                            $('#search').submit(function(){
                                $.fn.yiiGridView.update('rkpeminjamandokumenrm-v-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                            });
                        ");
                ?>
                <div class='hide'>
                    <?php
                    $warnadokrm_id = 1;
                    $this->widget(
                        'ext.colorpicker.ColorPicker',
                        array(
                            'name' => 'Dokumen[warnadokrm_id][]',
                            'value' => WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id), // string hexa decimal contoh 000000 atau 0000ff
                            'height' => '30px', // tinggi
                            'width' => '83px',
                            //'swatch'=>true, // default false jika ingin swatch
                            'colors' =>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
                            'colorOptions' => array(
                                'transparency' => true,
                            ),
                        )
                    );
                    ?>
                </div>
                <?php
                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <div class="search-form">
                    <!--fieldset class="box"-->
                    <?php $this->renderPartial('_searchPengembalian', array(
                        'model' => $modPengiriman,
                    )); ?>
                    <!--</fieldset>-->
                </div>
                <!--search-form-->
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pengembalian Dokumen Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'rkkembalirm-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
                    'focus' => '#',
                ));
                ?>

                <div class="block-tabel">
                    <?php $this->renderPartial('_tabelPengembalian', array('modPengiriman' => $modPengiriman)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pengembalian <b>Dokumen Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_formPengembalian', array('model' => $model, 'form' => $form)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'cekInputan();', 'onclick' => 'cekInputan();')
                );
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'disabled' => true, 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'cekInputan();', 'onclick' => 'cekInputan();')
                );
            }
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('tips/tipsPengembalianRM', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<!--======================== Begin Widget Dialog Petugas Penerima =============================-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPetugasPenerima',
    'options' => array(
        'title' => 'Petugas Penerima',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));
?>
<?php
$modPetugasPenerima = new RKPegawaiV('searchDialog');
$modPetugasPenerima->unsetAttributes();
if (isset($_GET['RKPegawaiV'])) {
    $modPetugasPenerima->attributes = $_GET['RKPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugaspenerima-grid',
    'dataProvider' => $modPetugasPenerima->searchDialog(),
    'filter' => $modPetugasPenerima,
    'template' => "{summary}{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectPetugasPenerima",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'petugaspenerima') . '\").val(\"$data->nama_pegawai\");
                                                  $(\"#dialogPetugasPenerima\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPetugasPenerima, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPetugasPenerima, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget(); ?>
<!--=============================== endWidget Dialog Petugas Penerima ============================-->
<?php $this->renderPartial('_jsFunctions', array('model' => $model, 'modPengiriman' => $modPengiriman)); ?>