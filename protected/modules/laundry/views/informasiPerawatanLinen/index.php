<?php $linkHalaman = CustomFunction::getUrlByMenuID(2543); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Perawatan Linen',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#perawatanlinen-info-search').submit(function(){
	$('#informasiperawatanlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasiperawatanlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Perawatan Linen</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
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
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Perawatan Linen</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasiperawatanlinen-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No. Perawatan',
                            'type' => 'raw',
                            'value' => '$data->noperawatan',
                        ),
                        array(
                            'header' => 'Tanggal Perawatan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglperawatanlinen)',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'type' => 'raw',
                            //					'value'=>'$data->ruangan->instalasi->instalasi_nama',
                            'value' => '$data->getRuanganIns($data->perawatanlinen_id, "instalasi")',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            //					'value'=>'$data->ruangan->ruangan_nama',
                            'value' => '$data->getRuanganIns($data->perawatanlinen_id, "ruangan")',
                        ),
                        array(
                            'name' => 'keterangan_perawatan',
                            'type' => 'raw',
                            'value' => '$data->keterangan_perawatan',
                        ),
                        array(
                            'header' => 'Perawatan Diluar RS',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->iskirimkeluar == false) {
                                    return "";
                                }
                                $str = CHtml::link('<i class="glyphicon glyphicon-home"></i>', '#', array(
                                    'onclick' => "kembaliPerawatanRS(" . CJSON::encode($data->attributes) . "); return false;",
                                    'rel' => 'tooltip',
                                    'title' => 'Klik jika Perawatan Sudah Kembali di luar RS.',
                                ));
                                if (isset($data->tgl_kembali)) {
                                    return MyFormatter::formatDateTimeForUser($data->tgl_kembali);
                                } else {
                                    return $str;
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Lihat Detail/Status',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPerawatanLinen/detail",array("id"=>$data->perawatanlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Perawatan Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'name' => 'Penyimpanan Linen',
                            'type' => 'raw',
                            'value' => '(($data->iskirimkeluar==1)?(($data->checkstatusLinenRS($data->perawatanlinen_id)==0)?"":(($data->checkpenyimpananLinen($data->perawatanlinen_id)==1)?"Sudah Disimpan":CHtml::Link("<i class=\'icon-simpanlinen\'></i>",Yii::app()->controller->createUrl("/laundry/PenyimpananLinen/Index",array("perawatanlinen_id"=>$data->perawatanlinen_id)),array("class"=>"", "rel"=>"tooltip","title"=>"Klik Melakukan Ke Penyimpanan Linen")))):(($data->checkpenyimpananLinen($data->perawatanlinen_id)==1)?"Sudah Disimpan":CHtml::Link("<i class=\'icon-simpanlinen\'></i>",Yii::app()->controller->createUrl("/laundry/PenyimpananLinen/Index",array("perawatanlinen_id"=>$data->perawatanlinen_id)),array("class"=>"", "rel"=>"tooltip","title"=>"Klik Melakukan Ke Penyimpanan Linen"))))',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function kembaliPerawatanRS(data) {
        $("#dialogperawatanrs-kembali #LAPerawatanlinenT_perawatanlinen_id").val(data.perawatanlinen_id);
        $("#dialogperawatanrs-kembali #LAPerawatanlinenT_noperawatan").val(data.noperawatan);
        $("#dialogperawatanrs-kembali #LAPerawatanlinenT_tglperawatanlinen").val(data.tglperawatanlinen);
        $("#dialogperawatanrs-kembali #LAPerawatanlinenT_tglkirimkeluar").val(data.tglkirimkeluar);
        $("#dialogperawatanrs-kembali #LAPerawatanlinenT_alasankirimkeluar").val(data.alasankirimkeluar);
        $("#dialogperawatanrs-kembali #LAPerawatanlinenT_ketkirimkeluar").val(data.ketkirimkeluar);
        <?php
        $namaPegawaiLogin = "";
        if (!empty(Yii::app()->user->getState('pegawai_id'))) {
            $modPegawaiLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
            if (isset($modPegawaiLogin)) {
                $namaPegawaiLogin = $modPegawaiLogin->namaLengkap;
            }
        }
        ?>
        $("#dialogperawatanrs-kembali #petugaspenerima").val("<?php echo $namaPegawaiLogin; ?>");
        $("#dialogperawatanrs-kembali #LAPerawatanlinenT_tgl_kembali").val("");
        $("#dialogperawatanrs-kembali").dialog("open");
    }

    function submitUpdateTanggalKembali() {
        var tgl_kembali = $("#dialogperawatanrs-kembali #LAPerawatanlinenT_tgl_kembali").val();
        if (tgl_kembali == "") {
            myAlert("Tanggal Kembali harus diisi");
            return false;
        }
        $("#btn-update-tanggal").prop("disabled", true);
        $.post('<?php echo $this->createUrl('updateTglKembali'); ?>', $("#formperawatanrs-kembali").serialize(), function(data) {
            if (data.ok == 1) {
                $("#dialogperawatanrs-kembali").dialog("close");
                myAlert("Tanggal kembali berhasil disimpan.");
                $.fn.yiiGridView.update("informasiperawatanlinen-grid");
            } else {
                myAlert("Tanggal kembali gagal disimpan.");
            }
            $("#btn-update-tanggal").prop("disabled", false);
        }, 'json');
    }

    function resetTanggalKembali() {
        $("#dialogperawatanrs-kembali").dialog("close");
    }
</script>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Perawatan Linen',
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
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogperawatanrs-kembali',
    'options' => array(
        'title' => 'Tanggal Kembali Linen Perawatan RS',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 400,
        'height' => 400,
        'resizable' => false,
    ),
)); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'formperawatanrs-kembali',
    'type' => 'horizontal',
    //            'focus'=>'#'.CHtml::activeId($model,'nopolisi'),
)); ?>
<?php
$modelPerawatanLinen = new LAPerawatanlinenT;
$modelPerawatanLinen->unsetAttributes();
echo $form->hiddenField($modelPerawatanLinen, 'perawatanlinen_id', array('readonly' => true));
echo $form->textFieldRow($modelPerawatanLinen, 'noperawatan', array('readonly' => true));
echo $form->textFieldRow($modelPerawatanLinen, 'tglperawatanlinen', array('readonly' => true));
echo $form->textFieldRow($modelPerawatanLinen, 'tglkirimkeluar', array('readonly' => true));
echo $form->textFieldRow($modelPerawatanLinen, 'alasankirimkeluar', array('readonly' => true));
echo $form->textFieldRow($modelPerawatanLinen, 'ketkirimkeluar', array('readonly' => true));
//echo CHtml::textField($model, 'kmawal', array('readonly'=>true, 'class'=>'span2', 'style'=>'text-align: right;'));//
//echo $form->textFieldRow($model, 'kmakhir', array('readonly'=>false, 'class'=>'span2 numbers-only', 'style'=>'text-align: right;'));
?>
<div class="control-group">
    <?php echo CHtml::label("Petugas yang Menerima", '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php echo CHtml::textField("petugaspenerima", '', array('readonly' => true, 'class' => '')); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label("Tgl. Kembali", '', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php $this->widget('MyDateTimePicker', array(
            'model' => $modelPerawatanLinen,
            'attribute' => 'tgl_kembali',
            'mode' => 'date',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
            ),
            'htmlOptions' => array('readonly' => false, 'class' => 'span3'),
        ));
        ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton('<i class="entypo-check"></i> Simpan', array(
        'class' => 'btn btn-danger',
        'type' => 'button',
        'onclick' => 'submitUpdateTanggalKembali();',
        'id' => 'btn-update-tanggal'
    )); ?>
    <?php echo CHtml::htmlButton('<i class="entypo-cancel"></i> Batal', array(
        'class' => 'btn btn-default',
        'type' => 'button',
        'onclick' => 'resetTanggalKembali();',
    )); ?>
</div>
<?php $this->endWidget('ext.bootstrap.widgets.BootActiveForm'); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>