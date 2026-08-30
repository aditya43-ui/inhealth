<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapemeriksaanlabdet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<?php echo $form->errorSummary($model); ?>

<div class="control-group">
    <?php echo $form->labelEx($model, 'pemeriksaanlab_id', array('class' => 'control-label')) ?>
    <div class="controls">
        <?php
        $pemeriksaanlab_nama = (isset($model->pemeriksaanlab->pemeriksaanlab_nama) ? $model->pemeriksaanlab->pemeriksaanlab_nama : "");
        echo Chtml::hiddenField('pemeriksaanlab_id', $model->pemeriksaanlab_id, array('readonly' => true));
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'pemeriksaanlab_nama',
            'value' => $pemeriksaanlab_nama,
            'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutocompletePemeriksaanLab') . '",
								dataType: "json",
								data: {
									term: request.term,
								},
								success: function (data) {
									response(data);
								}
							})
						}',
            'options' => array(
                'minLength' => 4,
                'focus' => 'js:function( event, ui ) {
									$(this).val( "");
									return false;
							}',
                'select' => 'js:function( event, ui ) {
								$(this).val(ui.item.pemeriksaanlab_nama);
								$("#pemeriksaanlab_id").val(ui.item.pemeriksaanlab_id);
								setPemeriksaanLabDet(ui.item.pemeriksaanlab_id);
								return false;
							}',
            ),
            'tombolDialog' => array('idDialog' => 'dialogPemeriksaanLab'),
            'htmlOptions' => array('placeholder' => 'Nama Pemeriksaan Lab', 'rel' => 'tooltip', 'title' => 'Ketik Nama Pemeriksaan Lab', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3'),
        ));
        ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pilih Nilai Rujukan (Referensi)</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php echo CHtml::hiddenField('ubahpemeriksaanlabdet_id', '', array('readonly' => true)); ?>

        <?php
        $modNilaiRujukan = new SANilairujukanM('search');
        $modNilaiRujukan->unsetAttributes();  // clear any default values
        if (isset($_GET['SANilairujukanM'])) {
            $modNilaiRujukan->attributes = $_GET['SANilairujukanM'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'sanilairujukan-m-grid',
            'dataProvider' => $modNilaiRujukan->searchPilih(),
            'filter' => $modNilaiRujukan,
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'columns' => array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<i class=\'icon-form-check\'></i>","javascript:void(0);",array("onclick"=>"pilihNilaiRujukan(this, ".$data->nilairujukan_id.");", "class"=>"btn-small", "title"=>"Klik untuk <br>memilih pemeriksaan", "rel"=>"tooltip"))
											',
                ),
                array(
                    'header' => 'No.',
                    'value' => '($this->grid->dataProvider->pagination) ? 
											($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
											: ($row+1)',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: right;'),
                ),
                array(
                    'name' => 'kelkumurhasillab_id',
                    'type' => 'raw',
                    'value' => 'isset($data->kelkumurhasillab->kelkumurhasillabnama) ? $data->kelkumurhasillab->kelkumurhasillabnama : "-"',
                    'filter' => CHtml::listData(KelkumurhasillabM::model()->findAll(array('order' => 'kelkumurhasillab_urutan'), 'kelkumurhasillab_aktif = true'), 'kelkumurhasillab_id', 'kelkumurhasillabnama'),
                ),
                array(
                    'name' => 'nilairujukan_jeniskelamin',
                    'type' => 'raw',
                    'value' => '$data->nilairujukan_jeniskelamin',
                    'filter' => LookupM::getItems('jeniskelamin'),
                ),
                'kelompokdet',
                'namapemeriksaandet',
                'nilairujukan_nama',
                'nilairujukan_min',
                'nilairujukan_max',
                'nilairujukan_satuan',
                'nilairujukan_metode',
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        )); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Detail Pemeriksaan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="table-pemeriksaanlabdet" class="table table-bordered table-striped table-condensed">
            <thead>
                <th>No. Urut</th>
                <th>Kelompok Umur</th>
                <th>Jenis Kelamin</th>
                <th>Nama Detail</th>
                <th>Nilai Rujukan</th>
                <th>Nilai Minimum</th>
                <th>Nilai Maksimum</th>
                <th>Satuan</th>
                <th>Metode</th>
                <th>Geser</th>
                <th>Hapus</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'title' => 'Simpan', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('index'),
        array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Detail Pemeriksaan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_view . 'tips/tipsCreate', array(), true);
    $this->widget('UserTips', array('content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model)); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaanLab',
    'options' => array(
        'title' => 'Pilih Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => true,
    ),
));
$modPemeriksaanLab = new SAPemeriksaanlabM('search');
$modPemeriksaanLab->unsetAttributes();  // clear any default values
if (isset($_GET['SAPemeriksaanlabM'])) {
    $modPemeriksaanLab->attributes = $_GET['SAPemeriksaanlabM'];
    $modPemeriksaanLab->daftartindakan_nama = $_GET['SAPemeriksaanlabM']['daftartindakan_nama'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sapemeriksaanlab-m-grid',
    'dataProvider' => $modPemeriksaanLab->searchDialog(),
    'filter' => $modPemeriksaanLab,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::link("<i class=\'icon-form-check\'></i>","javascript:void(0);",
					array("onclick"=>"
							$(\"#pemeriksaanlab_nama\").val(\"$data->pemeriksaanlab_nama\");
							$(\"#pemeriksaanlab_id\").val(\"$data->pemeriksaanlab_id\");
							setPemeriksaanLabDet(\"$data->pemeriksaanlab_id\");
							$(\"#dialogPemeriksaanLab\").dialog(\"close\");
						", 
					"class"=>"btn-small", "title"=>"Klik untuk <br>memilih pemeriksaan", "rel"=>"tooltip"));',
        ),
        array(
            'header' => 'No.',
            'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
        array(
            'name' => 'jenispemeriksaanlab_id',
            'value' => '$data->jenispemeriksaan->jenispemeriksaanlab_nama',
            'filter' => CHtml::listData(JenispemeriksaanlabM::model()->findAll(array('order' => 'jenispemeriksaanlab_urutan'), 'jenispemeriksaanlab_aktif = true'), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'),
        ),
        'pemeriksaanlab_kode',
        'pemeriksaanlab_nama',
        array(
            'name' => 'daftartindakan_id',
            'value' => '$data->daftartindakan->daftartindakan_nama',
            'filter' => CHtml::activeTextField($modPemeriksaanLab, 'daftartindakan_nama'),
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":\'' . Params::TOOLTIP_PLACEMENT . '\'});}',
));
$this->endWidget();

?>