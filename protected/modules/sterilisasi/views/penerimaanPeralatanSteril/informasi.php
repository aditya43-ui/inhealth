<?php $linkHalaman = CustomFunction::getUrlByMenuID(3029); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Penerimaan Sterilisasi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Penerimaan Sterilisasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
            $('#sterilisasi-info-search').submit(function(){
                $('#informasisterilisasi-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('informasisterilisasi-grid', {
                        data: $(this).serialize()
                });
                return false;
            });
        "); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Penerimaan Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasisterilisasi-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No. Penerimaan',
                            'type' => 'raw',
                            'value' => '$data->penerimaansterilisasi_no',
                        ),
                        array(
                            'header' => 'Tanggal Penerimaan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->penerimaansterilisasi_tgl)',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'type' => 'raw',
                            'value' => '$data->ruangan->instalasi->instalasi_nama',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'name' => 'penerimaansterilisasi_ket',
                            'type' => 'raw',
                            'value' => '$data->penerimaansterilisasi_ket',
                        ),
                        array(
                            'header' => 'Pegawai Pengirim',
                            'type' => 'raw',
                            'value' => 'isset($data->pegmenerima_id) ? $data->pegawaiMenerima->nama_pegawai : ""',
                        ),
                        array(
                            'header' => 'Dekontaminasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $modPenerimaanSterilisasiDetail = PenerimaansterilisasidetT::model()->findByAttributes(array('penerimaansterilisasi_id' => $data->penerimaansterilisasi_id));
                                if ($modPenerimaanSterilisasiDetail != NULL) {
                                    if ($modPenerimaanSterilisasiDetail->keadaanperalatan == "KOTOR") {
                                        return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->controller->createUrl("/sterilisasi/DekontaminasiT/index", array('penerimaansterilisasi_id' => $data->penerimaansterilisasi_id)), array("rel" => "tooltip", "title" => "Klik untuk Dekontaminasi"));
                                    } else {
                                        //return'';
                                        $modDekontaminasiDetail = DekontaminasidetailT::model()->findByAttributes(array('penerimaansterilisasi_id' => $data->penerimaansterilisasi_id));
                                        if ($modDekontaminasiDetail != NULL) {
                                            $modDekontaminasi = DekontaminasiT::model()->findByAttributes(array('dekontaminasi_id' => $modDekontaminasiDetail->dekontaminasi_id));
                                            if ($modDekontaminasiDetail != NULL) {
                                                $no = $modDekontaminasi->dekontaminasi_no;
                                                $tgl = MyFormatter::formatDateTimeforUser($modDekontaminasi->dekontaminasi_tgl);
                                                return CHtml::link($no . '/' . $tgl, Yii::app()->createUrl('sterilisasi/PenerimaanPeralatanSterilT/detailDekontaminasi&id=' . $data->penerimaansterilisasi_id), array("rel" => "tooltip", "title" => "Klik untuk Rincian Dekontaminasi", "target" => "frameDetailDekontaminasi", "onclick" => "$(\"#dialogDetailsDekontaminasi\").dialog(\"open\");",));
                                            } else {
                                                return '-';
                                            }
                                        } else {
                                            return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->controller->createUrl("/sterilisasi/DekontaminasiT/index", array(
                                                'penerimaansterilisasi_id' => $data->penerimaansterilisasi_id,
                                            )), array("rel" => "tooltip", "title" => "Klik untuk Dekontaminasi"));
                                        }
                                    }
                                } else {
                                    return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->controller->createUrl("/sterilisasi/DekontaminasiT/index"), array("rel" => "tooltip", "title" => "Klik untuk Dekontaminasi"));
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ), /*
                array(
                        'header'=>'Sterilisasi',
                        'type'=>'raw',
                         'value'=>function($data) {
                          $modPenerimaanSterilisasiDetail = PenerimaansterilisasidetT::model()->findByAttributes(array('penerimaansterilisasi_id'=>$data->penerimaansterilisasi_id));
                          if($modPenerimaanSterilisasiDetail != NULL){
                            if($modPenerimaanSterilisasiDetail->keadaanperalatan == "BERSIH") {
                                return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->controller->createUrl("/sterilisasi/SterilisasiT/index"),array("rel"=>"tooltip","title"=>"Klik untuk Sterilisasi"));
                            }else{
                               $modPenerimaanSterilisasiDetail = PenerimaansterilisasidetT::model()->findByAttributes(array('penerimaansterilisasi_id'=>$data->penerimaansterilisasi_id));
                                   if($modPenerimaanSterilisasiDetail->keadaanperalatan == "BERSIH") {
                                     return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->controller->createUrl("/sterilisasi/DekontaminasiT/index"),array("rel"=>"tooltip","title"=>"Klik untuk Sterilisasi"));
                                   }else{
                                     //return'';
                                       $modSterilisasiDetail = SterilisasidetailT::model()->findByAttributes(array('penerimaansterilisasi_id'=>$data->penerimaansterilisasi_id));
                                       if($modSterilisasiDetail != NULL){
                                           $modSterilisasi= SterilisasiT::model()->findByAttributes(array('sterilisasi_id'=>$modSterilisasiDetail->sterilisasi_id));
                                           if($modSterilisasi != NULL){
                                               $no = $modSterilisasi->sterilisasi_no;
                                               $tgl = MyFormatter::formatDateTimeforUser($modSterilisasi->sterilisasi_tgl);
                                               return CHtml::link($no.'/'.$tgl,Yii::app()->createUrl('sterilisasi/PenerimaanPeralatanSterilT/detailSterilisasi&id='.$data->penerimaansterilisasi_id),array("rel"=>"tooltip","title"=>"Klik untuk Rincian Sterilisasi","target"=>"frameDetailSterilisasi", "onclick"=>"$(\"#dialogDetailsSterilisasi\").dialog(\"open\");", ));
                                           }else{
                                               return '-';
                                           }
                                       }
                                 }
                            }
                           }else{
                               return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->controller->createUrl("/sterilisasi/SterilisasiT/index"),array("rel"=>"tooltip","title"=>"Klik untuk Sterilisasi"));
                           } 
                         },
                        'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                ),
                 * 
                 */
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/PenerimaanPeralatanSterilT/detail",array("penerimaansterilisasi_id"=>$data->penerimaansterilisasi_id, "frame"=>1)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Sterilisasi", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => Yii::t('zii', 'Batal'),
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'template' => '{remove}',
                            'buttons' => array(
                                'remove' => array(
                                    'label' => "<i class='icon-form-silang'></i>",
                                    'options' => array('title' => Yii::t('mds', 'Remove Temporary')),
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/batalPenerimaan",array("id"=>$data->penerimaansterilisasi_id))',
                                    'click' => 'function(){batalPenerimaan(this);return false;}',
                                ),
                            ),
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctionsInformasi', array()); ?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Penerimaan Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailsDekontaminasi',
    'options' => array(
        'title' => 'Detail Dekontaminasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetailDekontaminasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetailsSterilisasi',
    'options' => array(
        'title' => 'Detail Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetailSterilisasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>