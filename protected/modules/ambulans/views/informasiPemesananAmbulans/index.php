<?php
$this->breadcrumbs = array(
    'Informasi Pemesanan Ambulans',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Informasi <b>Pemesanan Ambulans</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('pesanambulans-t-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
        ?>
        <?php $this->renderPartial('_searchPemesanan', array('model' => $model, 'format' => $format)) ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemesanan Ambulans</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pesanambulans-t-grid',
                    'dataProvider' => $model->searchPemesanan(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'name' => 'pesanambulans_tgl',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return MyFormatter::formatDateTimeForUser($data->pesanambulans_tgl);
                            }
                        ),
                        'pesanambulans_no',
                        'pasien_norekammedis',
                        'pasien_nama',
                        'tempattujuan',
                        'alamattujuan',
                        array(
                            'name' => 'tglpemakaianambulans',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpemakaianambulans)',
                        ),
                        'untukkeperluan',
                        'ruangan_nama',
                        'pemesan_nama',
                        array(
                            'name' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->keteranganpesan',
                        ),
                        array(
                            'header' => 'Pemakaian Ambulans',
                            'type' => 'raw',
                            'value' => '(empty($data->pemakaianambulans_id)) ? (isset($data->pendaftaran_id)? 
                        CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
                        Yii::app()->controller->createUrl("PemakaianAmbulanPasienRS/index",array("pemesanan_id"=>$data->pesanambulans_t,"pendaftaran_id"=>$data->pendaftaran_id,
                        "modul_id"=>Yii::app()->session["modul_id"])),array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk Pemakaian Ambulans")): 
                        CHtml::Link("<i class=\"icon-form-pakaiambulans\"></i>",
                        Yii::app()->controller->createUrl("PemakaianAmbulanPasienLuar/index",array("pemesanan_id"=>$data->pesanambulans_t,
                        "modul_id"=>Yii::app()->session["modul_id"])),array("class"=>"btn-small","rel"=>"tooltip","title"=>"Klik untuk Pemakaian Ambulans"))
                        ) : ""',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Batal Pesan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                return CHtml::link("<i class=\"icon-form-silang\"></i>", "javascript:deleteRecord(" . $data->pesanambulans_t . ")", array("id" => $data->pesanambulans_t, "rel" => "tooltip", "title" => "Batalkan"));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
        ?>
    </div>
</div>
<script type="text/javascript">
    function deleteRecord(id) {
        var id = id;
        var url = '<?php echo $url . "/delete"; ?>';
        myConfirm("Apakah Anda yakin ingin menghapus data ini?", "Perhatian!",
            function(r) {
                if (r) {
                    $.post(url, {
                            id: id
                        },
                        function() {
                            $.fn.yiiGridView.update('pesanambulans-t-grid');
                        });
                }
            });
    }
</script>