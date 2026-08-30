<?php
$this->breadcrumbs = array(
    'Informasi Kartu Stok Bahan Makanan',
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
    //        'focus'=>'#'.CHtml::activeId($model,'barang_nama'),
)); ?>
<div class="panel panel-gradient" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kartu Stok Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td width="100px">
                    <?php
                    if (!empty($prev)) {
                        echo CHtml::link('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', $this->createUrl('index', array('bahanmakanan_id' => $prev)), array('class' => 'btn btn-primary', 'style' => 'float:left;'));
                    }
                    ?>
                </td>
                <td style="text-align:center;">
                    <?php
                    // auto complete pencarian berdasarkan obat alkes
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'namabahanmakanan',
                        'htmlStyle' => true,
                        'source' => 'js: function(request, response) {
													   $.ajax({
														   url: "' . $this->createUrl('AutocompleteBahanMakanan') . '",
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
											redirectObat(ui.item.bahanmakanan_id);
											return false;
										}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3',
                            'style' => '',
                            //'onkeydown'=>'if (event.keyCode == 13) { this.form.submit(); return false; }',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'namabahanmakanan') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogBarang'),
                    ));
                    echo $form->hiddenField($model, 'bahanmakanan_id', array('readonly' => false, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                    ?>
                </td>
                <td width="100px">
                    <?php
                    if (!empty($next)) {
                        echo CHtml::link('Lanjut <i class="glyphicon glyphicon-arrow-right"></i>', $this->createUrl('index', array('bahanmakanan_id' => $next)), array('class' => 'btn btn-primary', 'style' => 'float:right'));
                    }
                    ?>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td width="10%">Kelompok</td>
                <td width="15%">: <?php echo $model->kelbahanmakanan; ?></td>
                <td width="10%">Nama</td>
                <td width="15%">: <?php echo $model->namabahanmakanan; ?></td>
            </tr>
            <tr>
                <td>Jenis</td>
                <td>: <?php echo $model->jenisbahanmakanan; ?></td>
                <td>Satuan</td>
                <td>: <?php echo $model->satuanbahan; ?></td>
            </tr>
        </table><br>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . 'searchBaru', array('form' => $form, 'model' => $model, 'format' => $format, 'disabled' => $disabled)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kartu Stok Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_tableBaru', array('model2' => $model2, 'pilihTgl' => $pilihTgl)) ?>
            </div>
        </div>
        <?php
        if (!isset($_GET['caraPrint']) || empty($_GET['caraPrint'])) {
        ?>
            <script type='text/javascript'>
                /**
                 * print
                 */
                function print(caraPrint) {
                    var bahanmakanan_id = '<?php echo isset($model->bahanmakanan_id) ? $model->bahanmakanan_id : ''; ?>';
                    window.open('<?php echo $this->createUrl('index'); ?>&bahanmakanan_id=' + bahanmakanan_id +
                        '&caraPrint=' + caraPrint +
                        '&tgl_awal=' + $("#InformasikartustokbahanmakananV_tgl_awal").val() +
                        '&tgl_akhir=' + $("#InformasikartustokbahanmakananV_tgl_akhir").val() +
                        '&pilihTgl=' + $("#InformasikartustokbahanmakananV_pilihTgl").prop("checked") +
                        '&transaksi=' + $("#InformasikartustokbahanmakananV_transaksi").val(), 'printwin', 'left=100,top=100,width=1000,height=640');
                }

                function redirectObat(id) {
                    window.location.replace('<?php echo $this->createUrl("index"); ?>&bahanmakanan_id=' + id);
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
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 500,
        'resizable' => false,
    ),
));
$modBarang = new GZBahanMakananM('searchDialog');
$modBarang->unsetAttributes();
if (isset($_GET['GZBahanMakananM'])) {
    $modBarang->attributes = $_GET['GZBahanMakananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'bahanmakanan-m-grid',
    'dataProvider' => $modBarang->searchDialog(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        redirectObat($data->bahanmakanan_id);
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'kelbahanmakanan',
            'type' => 'raw',
            'value' => '(!empty($data->kelbahanmakanan) ? $data->kelbahanmakanan : "")',
            'filter' =>  CHtml::activeTextField($modBarang, 'kelbahanmakanan'),
        ),
        'jenisbahanmakanan',
        'namabahanmakanan',
        array(
            'name' => 'satuanbahan',
            'type' => 'raw',
            'value' => '$data->satuanbahan',
            'filter' =>  CHtml::activeTextField($modBarang, 'satuanbahan'),
        ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => function ($data) {
                $b = new InformasikartustokbahanmakananV;
                $b->bahanmakanan_id = $data->bahanmakanan_id;
                $prov = $b->searchStokBahanMakanan();
                $tot = 0;
                foreach ($prov->data as $item) {
                    $stock = ($item->qty_masuk - $item->qty_keluar);
                    $tot += $stock;
                }
                return $tot;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>