<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><strong>Pemeriksaan Staining</strong></div>
            </div>
            <div class="panel-body">
                <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                
                <?php
                Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/wysihtml5/bootstrap-wysihtml5_custom2.js', CClientScript::POS_END);
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'staining-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('enctype' => 'multipart/form-data','onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#no_pendaftaran',
                ));
                ?>
                
                <div class="panel panel-success panel-shadow">
                    <div class="panel-heading">
                        <div class="panel-title"><span class='judul'><b>Data Spesimen</b></span></div>
                    </div>
                    <div class="panel-body" id="form-spesimen">
                        <div class="row-fluid">
                            <div class="hide">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'name' => 'tanggal_staining',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                    ),
                                    'htmlOptions' => array('class' => 'dtPicker3 span3 hide', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                    ),
                                ));
                                ?>
                            </div>
                            <?php $this->renderPartial('_formSpesimen', array('form' => $form, 'modSpesiman' => $modSpesiman)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel-group joined" id="accordion-riwayat">
                    <div class="panel panel-success panel-shadow">
                        <div class="panel-heading">
                            <h4 class="panel-title" style="background-color: #a6db9c"> 
                                <a data-toggle="collapse" data-parent="#accordion-riwayat" href="#form-riwayat" aria-expanded="true" class="">
                                    <b>Riwayat Staining</b>
                                </a> 
                            </h4>
                        </div>
                        <div id="form-riwayat" class="panel-collapse collapse" aria-expanded="false" style=""> 
                            <div class="panel-body">
                                <div class="row-fluid"  style="background-color: #fff; overflow: auto; max-height: 300px;">
                                    <div class="row-fluid">
                                        <?php $this->renderPartial('_formRiwayat', array('dataStaining' => $dataStaining)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo CHtml::hiddenField("norow","",array('readonly'=>true)); ?>
                <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true, 'class' => 'no_row',)); ?>

                <div class="row-fluid">
                    <div id="input-staining">
                        <div class="panel-staining">

                        </div>
                    </div>
                </div>
                
                <div class="row-fluid hide">
                    <?php $this->renderPartial('_formPersonInCharge', array('form' => $form, 'modStaining' => $model)); ?>
                </div>                
                                
                <div class="form-actions">
                    <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false));
                    ?>
                    <?php
                    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $_GET['spesimen_id'])), array('class' => 'btn btn-danger',
                        'onclick' => 'return refreshForm(this);'));
                    ?>
                    <?php                                        
                    echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="icon-arrow-left icon-white"></i>')), $this->createUrl('InformasiDaftarSpesimen/index', array()), array('class' => 'btn btn-danger'));
                    ?>
                </div>
                
                <?php $this->endWidget(); ?>
                
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('_dialog', array('modStaining' => $model)); ?>
<?php $this->renderPartial('_jsFunction', array(
    'model' => $model,
    'models' => $models,
    'modGambar' => $modGambar,
    'modDetail' => $modDetail,
    'arrGambar' => $arrGambar,
    'modStainingGambar' => $modStainingGambar
)); 
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Pencarian Pemeriksaan Lab',
        'autoOpen' => false,
        'modal' => true,
        'width' => 960,
        'height' => 600,
        'resizable' => false,
    ),
));
$tindakanLab = new MKTarifpemeriksaanlabruanganV('search');
$tindakanLab->unsetAttributes();
$tindakanLab->ruangan_id = 9999;

if (isset($_GET['MKTarifpemeriksaanlabruanganV'])) {
    $tindakanLab->attributes = $_GET['MKTarifpemeriksaanlabruanganV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tindakantariflab-m-grid',
    'dataProvider' => $tindakanLab->searchTindakanMikrobiologi(),
    'filter' => $tindakanLab,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>function($data) {
                    $load = $data->attributes;
                        
                    $res = json_encode($load);

                    return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"javascript:;",array("class"=>"btn-small", 
                            "onclick" => 'setPemeriksaan(this, '.$res.');'));
                },
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_id',
            'value' => '$data->jenispemeriksaanlab_nama',
            'filter' => CHtml::activeDropDownList($tindakanLab, 'jenispemeriksaanlab_id', CHtml::listData(JenispemeriksaanlabM::model()->findAll("jenispemeriksaanlab_id in (107, 108) and jenispemeriksaanlab_aktif = true ORDER BY jenispemeriksaanlab_nama"), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Pemeriksaan',
            'name' => 'pemeriksaanlab_nama',
            'value' => '$data->pemeriksaanlab_nama',
        )
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
