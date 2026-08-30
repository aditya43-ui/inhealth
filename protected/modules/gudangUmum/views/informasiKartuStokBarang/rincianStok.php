<?php
$this->breadcrumbs = array(
    'Informasi Kartu Stok Barang',
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
    'focus' => '#' . CHtml::activeId($model, 'barang_nama'),
)); ?>
<div class="panel panel-gradient" data-collapsed="0">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Kartu Stok Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <td width="100px">
                    <?php
                    if (!empty($prev)) {
                        echo CHtml::link('<i class="glyphicon glyphicon-arrow-left"></i> Kembali', $this->createUrl('index', array('barang_id' => $prev)), array('class' => 'btn btn-primary', 'style' => 'float:left;'));
                    } ?>
                </td>
                <td style="text-align:center;">
                    <?php
                    // auto complete pencarian berdasarkan obat alkes
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'barang_nama',
                        'htmlStyle' => true,
                        'source' => 'js: function(request, response) {
													   $.ajax({
														   url: "' . $this->createUrl('AutocompleteBarang') . '",
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
											redirectObat(ui.item.barang_id);
											return false;
										}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3 form-control',
                            'style' => '',
                            'placeholder' => 'Cari Barang',
                            //'onkeydown'=>'if (event.keyCode == 13) { this.form.submit(); return false; }',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'barang_nama') . '").val(""); '
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogBarang'),
                    ));
                    echo $form->hiddenField($model, 'barang_id', array('readonly' => false, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                    ?>
                </td>
                <td width="100px">
                    <?php
                    if (!empty($next)) {
                        echo CHtml::link('Lanjut <i class="glyphicon glyphicon-arrow-right"></i>', $this->createUrl('index', array('barang_id' => $next)), array('class' => 'btn btn-primary', 'style' => 'float:right'));
                    }
                    ?>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" style="margin: 0;" cellpadding="0" cellspacing="0">
            <tr>
                <td width="10%">Kode</td>
                <td width="15%">: <?php echo $model->barang_kode; ?></td>
                <td width="10%">Jenis Barang</td>
                <td width="15%">: <?php echo $model->jenisbarang_nama; ?></td>
            </tr>
            <tr>
                <td>Tipe</td>
                <td>: <?php echo $model->barang_type; ?></td>
                <td>Nama</td>
                <td>: <?php echo $model->barang_nama; ?></td>
            </tr>
            <tr>
                <td>Satuan</td>
                <td>: <?php echo $model->barang_satuan; ?></td>
            </tr>
        </table><br>
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
                    <i class="entypo-credit-card"></i> Tabel <b>Kartu Stok Barang</b>
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
                    barang_id = '<?php echo isset($model->barang_id) ? $model->barang_id : ''; ?>';
                    var instalasi_id = 'kosong';
                    var ruangan_id = 'kosong';
                    //  if ($("#InformasikartustokbarangV_instalasi_id").val() == ''){
                    //	  instalasi_id = $("#InformasikartustokbarangV_instalasi_id").val();
                    //  }
                    //  
                    //   if ($("#InformasikartustokbarangV_ruangan_id").val() != ''){
                    //	   ruangan_id = $("#InformasikartustokbarangV_ruangan_id").val();
                    //  }
                    window.open('<?php echo $this->createUrl('index'); ?>&barang_id=' + barang_id +
                        '&caraPrint=' + caraPrint +
                        '&tgl_awal=' + $("#InformasikartustokbarangV_tgl_awal").val() +
                        '&tgl_akhir=' + $("#InformasikartustokbarangV_tgl_akhir").val() +
                        '&pilihTgl=' + $("#InformasikartustokbarangV_pilihTgl").prop("checked") +
                        '&instalasi=' + instalasi_id +
                        '&ruangan=' + ruangan_id +
                        '&transaksi=' + $("#InformasikartustokbarangV_transaksi").val(), 'printwin', 'left=100,top=100,width=1000,height=640');
                }

                function redirectObat(id) {
                    window.location.replace('<?php echo $this->createUrl("index"); ?>&barang_id=' + id);
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
        'title' => 'Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 500,
        'resizable' => false,
    ),
));
$modBarang = new GUBarangM('searchDialog');
$modBarang->unsetAttributes();
if (isset($_GET['GUBarangM'])) {
    $modBarang->attributes = $_GET['GUBarangM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
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
                                        redirectObat($data->barang_id);
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'name' => 'barang_type',
            'type' => 'raw',
            'value' => '(!empty($data->barang_type) ? $data->barang_type : "")',
            'filter' =>  CHtml::activeTextField($modBarang, 'barang_type'),
        ),
        'barang_kode',
        'barang_nama',
        array(
            'name' => 'barang_satuan',
            'type' => 'raw',
            'value' => '$data->barang_satuan',
            'filter' =>  CHtml::activeTextField($modBarang, 'barang_satuan'),
        ),
        //                array(
        //                    'name'=>'hargajual',
        //                    'type'=>'raw',
        //                    'value'=>'MyFormatter::formatNumberForPrint($data->hargajual)',
        //                    'filter'=>false,
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => function ($data) {
                $b = new GUInformasistokbarangV;
                $b->barang_id = $data->barang_id;
                $b->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $prov = $b->search();
                $tot = 0;
                foreach ($prov->data as $item) {
                    $tot += $item->inventarisasi_stok;
                }
                return $tot;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>