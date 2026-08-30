<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'type' => 'horizontal',
            'id' => 'pencarian-tarif',
            'focus' => '#' . CHtml::activeId($modTarif, 'tarifambulans_kode'),
        )); ?>

        <!--<div class="control-label"> Daftar Tindakan </div>
		 <div class="controls">
			 <?php /* echo $form->hiddenField($modTarif, 'daftartindakan_id',array('id'=>'daftartindakan_id')) ?>
			 <?php $this->widget('MyJuiAutoComplete', array(
					'name'=>'daftartindakan', 
					 'source'=>'js: function(request, response) {
							$.ajax({
								url: "'.Yii::app()->createUrl('ActionAutoComplete/Daftartindakan').'",
								dataType: "json",
								data: {
									term: request.term,
								},
								success: function (data) {
										response(data);
								}
							})
						 }',
					 'options'=>array(
								'showAnim'=>'fold',
								'minLength' => 1,
								'focus'=> 'js:function( event, ui )
									{
									 $(this).val(ui.item.daftartindakan_nama);
									 return false;
									 }',
								'select'=>'js:function( event, ui ) {
									$("#daftartindakan_id").val(ui.item.daftartindakan_id);
									 return false;
								 }',
					 ),
					 'htmlOptions'=>array(
						 'readonly'=>false,
						 'placeholder'=>'Daftar Tindakan',
						 'size'=>13,
						 'onkeypress'=>"return $(this).focusNextInputField(event);",
					 ),
					 'tombolDialog'=>array('idDialog'=>'dialogDaftartindakan'),
			)); */ ?>
		 </div>-->
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($modTarif, 'tarifambulans_kode', array('placeholder' => 'Kode Tarif', 'size' => 20, 'maxlength' => 20, 'class' => 'span4')); ?>
            <?php echo $form->dropDownListRow(
                $modTarif,
                'kepropinsi_nama',
                CHtml::listData($modTarif->getPropinsiItems(), 'propinsi_nama', 'propinsi_nama'),
                array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST', 'url' => Yii::app()->createUrl('ActionDynamic/GetTarifKabupaten', array('encode' => false, 'namaModel' => 'AMTarifambulansM')),
                        'update' => '#AMTarifambulansM_kekabupaten_nama'
                    )
                )
            );
            ?>
            <?php echo $form->dropDownListRow(
                $modTarif,
                'kekabupaten_nama',
                array(),
                array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST', 'url' => Yii::app()->createUrl('ActionDynamic/GetTarifKecamatan', array('encode' => false, 'namaModel' => 'AMTarifambulansM')),
                        'update' => '#AMTarifambulansM_kekecamatan_nama'
                    )
                )
            );
            ?>
            <?php echo $form->dropDownListRow(
                $modTarif,
                'kekecamatan_nama',
                array(),
                array(
                    'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST', 'url' => Yii::app()->createUrl('ActionDynamic/GetTarifKelurahan', array('encode' => false, 'namaModel' => 'AMTarifambulansM')),
                        'update' => '#AMTarifambulansM_kekelurahan_nama'
                    )
                )
            );
            ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow(
                $modTarif,
                'kekelurahan_nama',
                array(),
                array('class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)
            );
            ?>
            <?php echo $form->textFieldRow($modTarif, 'tarifperkm', array('placeholder' => '00', 'class' => 'span4 numbers-only')); ?>
            <?php echo $form->textFieldRow($modTarif, 'tarifambulans', array('placeholder' => '00', 'class' => 'span4 numbers-only')); ?>
        </div>

        <div class="clear"></div>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari','class' => 'btn btn-danger', 'type' => 'submit')
            );
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'class' => 'btn btn-default',
                    'title' => 'Ulang',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>