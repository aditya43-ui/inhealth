<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="row">
    <div class='col-sm-6'>
        <div class='control-group'>
            <?php echo CHtml::activeLabel($modTerimaPersediaan, 'nofaktur', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeTextField($modTerimaPersediaan, "nofaktur", array('readonly' => true)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::activeLabel($modTerimaPersediaan, 'tglfaktur', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeTextField($modTerimaPersediaan, "tglfaktur", array('readonly' => true)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::activeLabel($modTerimaPersediaan, 'tgljatuhtempo', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeTextField($modTerimaPersediaan, "tgljatuhtempo", array('readonly' => true)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Umur Utang', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeTextField($modTerimaPersediaan, "umurhutang", array('readonly' => true)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Syarat Bayar', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeTextField($modTerimaPersediaan, "syaratbayar_nama", array('readonly' => true)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Keterangan Faktur', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeTextArea($modTerimaPersediaan, "keteranganfaktur", array('readonly' => true)); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::activeLabel($modTerimaPersediaan, 'supplier_id', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php echo CHtml::activeTextField($modTerimaPersediaan, "supplier_nama", array('readonly' => true)); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo CHtml::activeLabel($modTerimaPersediaan, 'jenis_terima', array('class' => 'control-label')); ?>

            <?php

            $jenisterima = 1;
            $jenisdisable = false;
            $data_jenis = array(1 => 'Umum', 2 => 'Bahan Makanan');
            if (!empty($modTerimaPersediaan->terimapersediaan_id)) {
                $jenisterima = 1;
                $jenisdisable = true;
            } else if (!empty($modTerimaMakanan->terimabahanmakan_id)) {
                $jenisterima = 2;
                $jenisdisable = true;
            }

            //            echo CHtml::label('Jenis Penerimaan', '', array('class' => 'control-label')); 
            ?>
            <div class="controls">
                <?php
                if ($jenisdisable) {
                    echo CHtml::hiddenField('jenisterima', $data_jenis[$jenisterima], array(
                        'disabled' => true,
                    ));
                } else {
                    echo CHtml::dropDownList('jenisterima', $jenisterima, $data_jenis, array(
                        'onchange' => 'resetTerima();', 'id' => 'jenisterima', 'disabled' => $jenisdisable,
                        'options' => array(
                            1 => array('data-dialog' => 'dialogTerimaPersediaan'),
                            2 => array('data-dialog' => 'dialogTerimaBahanMakanan'),
                        )
                    ));
                } ?>
            </div>
        </div>
        <!--		<div class="control-group">
			<?php // echo CHtml::label('No Terima', 'nopenerimaan', array('class' => 'control-label')); 
            ?>
			<div class="controls">
				<?php // echo CHtml::hiddenField('terimapersediaan_id', '', array('readonly' => TRUE)); 
                ?>				
				<?php

                //				if (empty($modTerimaPersediaan->terimapersediaan_id) && empty($modTerimaMakanan->terimabahanmakan_id)) {
                //					$this->widget('MyJuiAutoComplete', array(	
                //						'model'=>$modTerimaPersediaan,
                //						'attribute' => 'nopenerimaan',
                //						'sourceUrl' => Yii::app()->createUrl('/ActionAutoComplete/NoTerimaUntukBayarSupplier'),
                //						'options' => array(
                //							'showAnim' => 'fold',
                //							'minLength' => 2,
                //							'select' => 'js:function( event, ui ) {														
                //								loadDetail(ui.item.terimapersediaan_id);
                //							}',
                //						),
                //						'tombolDialog'=>array('idDialog'=>'dialogTerimaPersediaan', 'jsFunction'=>"bukaDialogTerima();"),
                //								'htmlOptions'=>array('placeholder'=>'No. Faktur','class'=>'all-caps','rel'=>'tooltip','title'=>'No. faktur / klik icon untuk mencari data faktur',
                //									'onkeyup'=>"return $(this).focusNextInputField(event)",                                    
                //									),
                //					));
                //				}else{
                //					echo CHtml::activeTextField($modTerimaPersediaan, "nopenerimaan", array('readonly'=>true));
                //				}
                ?>
			</div>
		</div>-->
        <!--		<div class='control-group'>
			<?php // echo CHtml::activeLabel($modTerimaPersediaan, 'tglterima',array('class'=>'control-label')); 
            ?>
			<div class='controls'>
				<?php // echo CHtml::activeTextField($modTerimaPersediaan, "tglterima", array('readonly'=>true)); 
                ?>
			</div>
		</div>-->
        <!--		<div class='control-group'>
			<?php // echo CHtml::activeLabel($modTerimaPersediaan, 'nosuratjalan',array('class'=>'control-label')); 
            ?>
			<div class='controls'>
				<?php // echo CHtml::activeTextField($modTerimaPersediaan, "nosuratjalan", array('readonly'=>true)); 
                ?>
			</div>
		</div>-->
        <!--		<div class='control-group'>
			<?php // echo CHtml::activeLabel($modTerimaPersediaan, 'tglsuratjalan',array('class'=>'control-label')); 
            ?>
			<div class='controls'>
				<?php // echo CHtml::activeTextField($modTerimaPersediaan, "tglsuratjalan", array('readonly'=>true)); 
                ?>
			</div>
		</div>		-->


    </div>
    <div class='col-sm-6'>
        <div class='control-group'>
            <?php echo CHtml::label('Total Harga', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php
                $modTerimaPersediaan->totalharga = number_format($modTerimaPersediaan->totalharga, 2, ",", ".");
                echo CHtml::activeTextField($modTerimaPersediaan, "totalharga", array('readonly' => true, 'class' => 'integer-decimal', 'style' => 'text-align:right;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Total Keringanan', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php
                $modTerimaPersediaan->discount = number_format($modTerimaPersediaan->discount, 2, ",", ".");
                echo CHtml::activeTextField($modTerimaPersediaan, "discount", array('readonly' => true, 'class' => 'integer-decimal', 'style' => 'text-align:right;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Total PPN', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php
                $modTerimaPersediaan->pajakppn = number_format($modTerimaPersediaan->pajakppn, 2, ",", ".");
                echo CHtml::activeTextField($modTerimaPersediaan, "pajakppn", array('readonly' => true, 'class' => 'integer-decimal', 'style' => 'text-align:right;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Total PPh', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php
                $modTerimaPersediaan->pajakpph = number_format($modTerimaPersediaan->pajakpph, 2, ",", ".");
                echo CHtml::activeTextField($modTerimaPersediaan, "pajakpph", array('readonly' => true, 'class' => 'integer-decimal', 'style' => 'text-align:right;')); ?>
            </div>
        </div>
        <div class='control-group'>
            <?php echo CHtml::label('Total Keseluruhan', '', array('class' => 'control-label')); ?>
            <div class='controls'>
                <?php
                $modTerimaPersediaan->totalkeseluruhan = number_format($modTerimaPersediaan->totalkeseluruhan, 2, ",", ".");
                echo CHtml::activeTextField($modTerimaPersediaan, "totalkeseluruhan", array('readonly' => true, 'class' => 'integer-decimal', 'style' => 'text-align:right;')); ?>
            </div>
        </div>
    </div>
</div>

<?php
//========= Dialog buat Permintaan Kebutuhan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTerimaPersediaan',
    'options' => array(
        'title' => 'Pencarian Terima Persediaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$format = new MyFormatter();
$modTerimaPers = new KUInformasifakturumumV;
if (isset($_GET['KUInformasifakturumumV'])) {
    $modTerimaPers->attributes = $_GET['KUInformasifakturumumV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'permintaan-m-grid',
    'dataProvider' => $modTerimaPers->searchDialog(),
    'filter' => $modTerimaPers,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "	
                                                  loadDetail($data->terimapersediaan_id);                                                  
                                                  $(\"#dialogTerimaPersediaan\").dialog(\"close\");    
                                        "))',
        ),
        'nopenerimaan',
        array(
            'name' => 'tglterima',
            'filter' => false,
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterima)))'
        ),
        array(
            'name' => 'tgljatuhtempo',
            'filter' => false,
            'value' => '(!empty($data->tgljatuhtempo))?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo))):""'
        ),
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier_nama',
            'filter' => CHtml::activeDropDownList($modTerimaPers, 'supplier_id', CHtml::listData(SupplierM::model()->getSupplierUmumItems(), 'supplier_id', 'supplier_nama'), array('empty' => '-- Piih --'))
        ),
        array(
            'header' => 'Total Tagihan',
            'value' => 'number_format($data->totalharga,0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            $("#testing").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();

//========= end Permintaan dialog =============================
?>
<?php
//========= Dialog buat Permintaan Kebutuhan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTerimaBahanMakanan',
    'options' => array(
        'title' => 'Pencarian Terima Persediaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$format = new MyFormatter();
$modTerimaPers = new GZTerimabahanmakan;
$modTerimaPers->unsetAttributes();
if (isset($_GET['GZTerimabahanmakan'])) {
    $modTerimaPers->attributes = $_GET['GZTerimabahanmakan'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'terimabahanmakan-m-grid',
    'dataProvider' => $modTerimaPers->searchInformasiDialog(),
    'filter' => $modTerimaPers,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "	
                                                  loadDetailBahan($data->terimabahanmakan_id);                                                  
                                                  $(\"#dialogTerimaBahanMakanan\").dialog(\"close\");    
                                        "))',
        ),
        'nopenerimaanbahan',
        array(
            'name' => 'tglterimabahan',
            'filter' => false,
            'value' => 'MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tglterimabahan)))'
        ), /*
		array(
			'name' => 'tgljatuhtempo',
			'filter'=> false,
			'value' => '(!empty($data->tgljatuhtempo))?MyFormatter::formatDateTimeForUser(date("Y-m-d", strtotime($data->tgljatuhtempo))):""'
		), */
        array(
            'header' => 'Supplier',
            'value' => '$data->supplier->supplier_nama',
            'filter' => CHtml::activeDropDownList($modTerimaPers, 'supplier_id', CHtml::listData(SupplierM::model()->getSupplierGiziItems(), 'supplier_id', 'supplier_nama'), array('empty' => '-- Piih --'))
        ),
        array(
            'header' => 'Total Tagihan',
            'value' => 'number_format(($data->totalharganetto + $data->biayapengiriman + $data->biayatransportasi + $data->biayapajak - $data->totaldiscount),0,"",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            $("#testing").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();

//========= end Permintaan dialog =============================
?>