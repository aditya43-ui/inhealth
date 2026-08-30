<div class="white-container">
    <legend class="rim2">Rencana <b>Kebutuhan</b></legend>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data Rencana Kebutuhan berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'rencanakebutuhan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai cekObat >> ,'onsubmit'=>'return requiredCheck(this);'
    )); ?>

    <fieldset class="box" id="form-rencanakebutuhan">
        <legend class="rim">Data Rencana Kebutuhan</legend>
        <div>
            <?php $this->renderPartial($this->path_view . '_formRencanaKebutuhan', array('form' => $form, 'format' => $format, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>

    <fieldset class="box" id="form-recomendedorder">
        <legend class="rim">Recomended Order (RO)</legend>
        <div>
            <?php $this->renderPartial($this->path_view . '_formRecomendedOrder', array('form' => $form, 'format' => $format, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>

    <?php if (!isset($_GET['sukses'])) { ?>
        <fieldset class="box" id="form-tambahobatalkes">
            <legend class='rim'>Tambah Obat dan Alat Kesehatan</legend>
            <div class="row">
                <?php $this->renderPartial($this->path_view . '_formObatRencanaKebutuhan', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>
            </div>
        </fieldset>
    <?php } ?>

    <div class="block-tabel">
        <h6>Tabel <b>Rencana Kebutuhan</b></h6>
        <table class="items table table-striped table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Asal Barang</th>
                    <th>Kategori / Nama Obat</th>
                    <th>Satuan </th>
                    <th>Jumlah Permintaan</th>
                    <th>Buffer Stok</th>
                    <th>Harga Netto</th>
                    <th>Stok Akhir</th>
                    <th>Minimal Stok</th>
                    <th>Maksimal Stok</th>
                    <th>Sub Total</th>
                    <th>VEN</th>
                    <th>ABC</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$modDetails) > 0) {
                    foreach ($modDetails as $i => $modRencanaDetailKeb) {
                        echo $this->renderPartial($this->path_view . '_rowObatRencanaKebutuhan', array('modRencanaDetailKeb' => $modRencanaDetailKeb, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi));
                    }
                }
                ?>
            <tfoot>
                <tr>
                    <td colspan="10">Total</td>
                    <td><?php echo CHtml::textField('total', '', array('class' => 'span2 integer', 'style' => 'width:90px;')) ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
    <?php isset($_GET['ubah']) ? $modRencanaKebFarmasi->rencanakebfarmasi_id = '' : ''; ?>
    <fieldset class="box">
        <legend class='rim'>Pegawai Berwenang</legend>
        <div class="row">
            <div class="span2">
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaKebFarmasi, 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modRencanaKebFarmasi, 'pegawaimengetahui_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modRencanaKebFarmasi,
                            'attribute' => 'pegawaimengetahui_nama',
                            'source' => 'js: function(request, response) {
											   $.ajax({
												   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
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
									$("#' . Chtml::activeId($modRencanaKebFarmasi, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimengetahui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modRencanaKebFarmasi, 'pegawaimengetahui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($modRencanaKebFarmasi, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modRencanaKebFarmasi, 'pegawaimenyetujui_id', array('readonly' => true)); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modRencanaKebFarmasi,
                            'attribute' => 'pegawaimenyetujui_nama',
                            'source' => 'js: function(request, response) {
											   $.ajax({
												   url: "' . $this->createUrl('AutocompletePegawaiMenyetujui') . '",
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
									$("#' . Chtml::activeId($modRencanaKebFarmasi, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimenyetujui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modRencanaKebFarmasi, 'pegawaimenyetujui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMenyetujui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="form-actions">
        <?php
        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'cekObat();', 'onkeypress' => 'cekObat();')); //formSubmit(this,event)
            //              Jika tanpa CekObat();
            //                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
        }

        if (!isset($_GET['frame'])) {
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    'onclick' => 'return refreshForm(this);'
                )
            );
        }
        if (!isset($_GET['sukses'])) {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
            //                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4043*/
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
            //                    echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')")); /**RND-4043*/
        }

        $content = $this->renderPartial($this->path_view . 'tips/tipsRencanaKebutuhan', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>