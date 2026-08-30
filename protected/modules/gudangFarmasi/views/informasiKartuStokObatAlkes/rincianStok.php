<?php
$this->breadcrumbs = array(
    'Informasi Kartu Stok Obat dan Alat Kesehatan',
);
?>
<?php
$format = new MyFormatter;
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route, array('frame' => 1)),
    'method' => 'get',
    'id' => 'informasi-search',
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'obatalkes_nama'),
)); ?>
<div class="panel panel-gradient" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kartu Stok Obat dan Alat Kesehatan</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td width="100px">
                    <?php
                    echo ((!empty($prev)) ? CHtml::link('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', $this->createUrl('index', array('obatalkes_id' => $prev)), array('class' => 'btn btn-primary', 'style' => 'float:left;')) : "");
                    ?>
                </td>
                <td style="text-align:center;">
                    <?php
                    // auto complete pencarian berdasarkan obat alkes
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'obatalkes_nama',
                        'htmlStyle' => true,
                        'source' => 'js: function(request, response) {
													   $.ajax({
														   url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
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
                            'showAnim' => 'fold',
                            'minLength' => 3,
                            'focus' => 'js:function( event, ui ) {
											$(this).val( ui.item.label);
											return false;
										}',
                            'select' => 'js:function( event, ui ) {
											redirectObat(ui.item.obatalkes_id);
											return false;
										}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3',
                            'style' => '',
                            //'onkeydown'=>'if (event.keyCode == 13) { this.form.submit(); return false; }',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'obatalkes_nama') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                    ));
                    echo $form->hiddenField($model, 'obatalkes_id', array('readonly' => false, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                    ?>
                </td>
                <td width="100px">
                    <?php
                    echo ((!empty($next)) ? CHtml::link('Lanjut <i class="glyphicon glyphicon-arrow-right"></i>', $this->createUrl('index', array('obatalkes_id' => $next)), array('class' => 'btn btn-primary', 'style' => 'float:right')) : "");
                    ?>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td width="10%">Kode</td>
                <td width="15%">: <?php echo $model->obatalkes_kode; ?></td>
                <td width="10%">Satuan Besar</td>
                <td width="15%">: <?php echo $model->satuanbesar_nama; ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: <?php echo $model->obatalkes_nama; ?></td>
                <td>Satuan Kecil</td>
                <td>: <?php echo $model->satuankecil_nama; ?></td>
            </tr>
            <tr>
                <td>Jenis Obat Alkes</td>
                <td>: <?php echo $model->jenisobatalkes_nama; ?></td>
                <td>Isi Kemasan</td>
                <td>: <?php echo $model->isikemasan; ?></td>
            </tr>
        </table>
        <br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'searchBaru', array('form' => $form, 'model' => $model, 'format' => $format, 'instalasiAsals' => $instalasiAsals, 'ruanganAsals' => $ruanganAsals, 'disabled' => $disabled)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kartu Stok Obat dan Alat Kesehatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_tableBaru', array('model2' => $model2, 'pilihTgl' => $pilihTgl)) ?>
            </div>
        </div>
        <?php
        if (!isset($_GET['caraPrint']) || empty($_GET['caraPrint'])) {
            //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PRINT')"));
            //echo CHtml::link(Yii::t('mds', '{icon} PDF', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('PDF')"));
            //echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));
        ?>
            <script type='text/javascript'>
                /**
                 * print
                 */
                function print(caraPrint) {
                    obatalkes_id = '<?php echo isset($model->obatalkes_id) ? $model->obatalkes_id : ''; ?>';
                    if ($("#GFInformasikartustokobatalkesV_instalasi_id").val() == '') {
                        var instalasi_id = 'kosong';
                    } else {
                        var instalasi_id = $("#GFInformasikartustokobatalkesV_instalasi_id").val();
                    }
                    if ($("#GFInformasikartustokobatalkesV_ruangan_id").val() == '') {
                        var ruangan_id = 'kosong';
                    } else {
                        var ruangan_id = $("#GFInformasikartustokobatalkesV_ruangan_id").val();
                    }
                    window.open('<?php echo $this->createUrl('index'); ?>&obatalkes_id=' + obatalkes_id +
                        '&caraPrint=' + caraPrint +
                        '&tgl_awal=' + $("#GFInformasikartustokobatalkesV_tgl_awal").val() +
                        '&tgl_akhir=' + $("#GFInformasikartustokobatalkesV_tgl_akhir").val() +
                        '&pilihTgl=' + $("#GFInformasikartustokobatalkesV_pilihTgl").prop("checked") +
                        '&instalasi=' + instalasi_id +
                        '&ruangan=' + ruangan_id +
                        '&transaksi=' + $("#GFInformasikartustokobatalkesV_transaksi").val(), 'printwin', 'left=100,top=100,width=1000,height=640');
                }

                function redirectObat(id) {
                    window.location.replace('<?php echo $this->createUrl("index"); ?>&obatalkes_id=' + id);
                }
            </script>
        <?php } ?>
    </div>
</div>
<?php
$this->endWidget();
?>
<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Obat dan Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 500,
        'resizable' => false,
    ),
));
$modObatAlkes = new GFObatalkesM('searchDialog');
$modObatAlkes->unsetAttributes();
if (isset($_GET['GFObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['GFObatalkesM'];
    $modObatAlkes->jenisobatalkes_nama = $_GET['GFObatalkesM']['jenisobatalkes_nama'];
    $modObatAlkes->satuankecil_nama = $_GET['GFObatalkesM']['satuankecil_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchDialog(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        redirectObat($data->obatalkes_id);
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
        ),
        'obatalkes_nama',
        'obatalkes_kategori',
        'obatalkes_golongan',
        array(
            'name' => 'satuankecil_id',
            'type' => 'raw',
            'value' => '$data->satuankecil->satuankecil_nama',
            'filter' =>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
        ),
        array(
            'name' => 'hargajual',
            'type' => 'raw',
            'value' => '"Rp ".MyFormatter::formatNumberForPrint($data->hargajual)',
            'filter' => false,
        ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => '$data->StokObatRuangan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>