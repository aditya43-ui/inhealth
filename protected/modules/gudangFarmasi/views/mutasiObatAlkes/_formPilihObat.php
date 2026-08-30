<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Obat dan Alkes', 'obatalkes_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'obatalkes_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    is_nobatch_tglkadaluarsa: $("#' . CHtml::activeId($model, 'is_nobatch_tglkadaluarsa') . '").val(),
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#obatalkes_id").val(ui.item.obatalkes_id);
                                $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                                return false;
                            }',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Obat dan Alkes',
                        'class' => 'span3 custom-only',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                ));
                ?>
            </div>
        </div>
        <div class="control-group" hidden>
            <?php echo CHtml::label('Berdasarkan No. Batch / Tgl. Kedaluwarsa', '', array('class' => 'control-label')); ?>
            <div class="controls checkbox-inline">
                <?php echo $form->checkBox($model, 'is_nobatch_tglkadaluarsa', array('onclick' => 'refreshDialogObat();')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label('Jumlah', 'qty_input', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::textField('qty_input', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer2')) ?>
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'tambahObatAlkes();return false;',
                        'class' => 'btn btn-primary',
                        'onkeyup' => "tambahObatAlkes();",
                        'rel' => "tooltip",
                        'id' => "btn_input",
                        'title' => "Klik untuk menambahkan mutasi",
                    )
                ); ?>
            </div>
        </div>
    </div>
    <!--<div class="col-sm-6">
		
	</div>-->
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Daftar Stok Ruangan ' . Yii::app()->user->getState('ruangan_nama'),
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 620,
        'resizable' => false,
    ),
));
$format = new MyFormatter();
$modObatAlkes = new GFInfostokobatalkesruanganV('searchDialogMutasi');
$modObatAlkes->unsetAttributes();
$modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
$modObatAlkes->instalasi_id = Yii::app()->user->getState('instalasi_id');
if (isset($_GET['GFInfostokobatalkesruanganV'])) {
    $modObatAlkes->attributes = $_GET['GFInfostokobatalkesruanganV'];
    $modObatAlkes->obatalkes_kode = isset($_GET['GFInfostokobatalkesruanganV']['obatalkes_kode']) ? $_GET['GFInfostokobatalkesruanganV']['obatalkes_kode'] : null;
    $modObatAlkes->jenisobatalkes_nama = isset($_GET['GFInfostokobatalkesruanganV']['jenisobatalkes_nama']) ? $_GET['GFInfostokobatalkesruanganV']['jenisobatalkes_nama'] : null;
    $modObatAlkes->satuankecil_nama = isset($_GET['GFInfostokobatalkesruanganV']['satuankecil_nama']) ? $_GET['GFInfostokobatalkesruanganV']['satuankecil_nama'] : null;
    $modObatAlkes->tglkadaluarsa = isset($_GET['GFInfostokobatalkesruanganV']['tglkadaluarsa']) ? $format->formatDateTimeForDb($_GET['GFInfostokobatalkesruanganV']['tglkadaluarsa']) : null;
}

$provider = $modObatAlkes->searchDataObat();
$provider->sort->defaultOrder = 'obatalkes_nama asc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $provider,
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
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),
        array(
            'header' => 'Jenis Obat Alkes',
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "")',
            'filter' =>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll(array(
                'condition' => 'jenisobatalkes_aktif = true',
                'order' => 'jenisobatalkes_nama'
            )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --')),
        ),

        array(
            'name' => 'obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'name' => 'obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        //'obatalkes_kategori',
        //'obatalkes_golongan',
        // 'nobatch',

        array(
            'header' => 'Tgl. Kedaluwarsa',
            'name' => 'tglkadaluarsa',
            'type' => 'raw',
            'value' => function ($data) {
                $criteria = new CDbCriteria();
                $criteria->select = "tglkadaluarsa";
                $criteria->compare('obatalkes_id', $data->obatalkes_id);
                $criteria->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'tglterima DESC';
                $stok = StokobatalkesT::model()->find($criteria);
                return MyFormatter::formatDateTimeForUser($stok->tglkadaluarsa);
            },
            'filter' => $this->widget(
                'MyDateTimePicker',
                array(
                    'model' => $modObatAlkes,
                    'attribute' => 'tglkadaluarsa',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => false, 'class' => 'dtPicker3 datemask', 'placeholder' => '00/00/0000', 'id' => 'tglkadaluarsa'),
                ),
                true
            )
        ),

        /*
                    
             * 
                ), 
                array(
                    'name'=>'satuankecil_id',
                    'type'=>'raw',
//                    'value'=>'isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : isset($data->satuankecil_nama) ? $data->satuankecil_nama : ""',
                    'value'=>'$data->satuankecil_nama',
                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama'),
                ), */

        //                array(
        //                    'name'=>'hargajual',
        //                    'type'=>'raw',
        //                    'value'=>'MyFormatter::formatNumberForPrint($data->hargajual)',
        //                    'filter'=>false,
        //                ),
        array(
            'header' => 'Jumlah Stok',
            'value' => function ($data) {
                $oa = ObatalkesM::model()->findByPk($data->obatalkes_id);

                $satuan = ($data->satuankecil_nama == null) ? $data->satuankecil->satuankecil_nama : $data->satuankecil_nama;

                return $oa->StokObatRuangan . " " . $satuan;
            },
            'htmlOptions' => array(
                'style' => 'text-align: right;'
            )
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
			jQuery(\'#tglkadaluarsa\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tglkadaluarsa_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});}',
));

$this->endWidget();
?>