<div class="white-container">
    <legend class="rim2">Transaksi <b>Permintaan Penawaran</b></legend>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data Permintaan Penawaran berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'permintaanpenawaran-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#' . CHtml::activeId($modPermintaanPenawaran, 'keteranganpenawaran'),
    )); ?>
    <fieldset class="box" id="form-permintaanpenawaran">
        <legend class="rim">Data Permintaan Penawaran</legend>
        <div>
            <?php isset($_GET['ubah']) ? $modPermintaanPenawaran->permintaanpenawaran_id = '' : ''; ?>
            <?php $this->renderPartial($this->path_view . '_formPermintaanPenawaran', array('form' => $form, 'format' => $format, 'modPermintaanPenawaran' => $modPermintaanPenawaran, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>
        </div>
    </fieldset>
    <?php if (!isset($modRencanaKebFarmasi->rencanakebfarmasi_id)) { ?>
        <fieldset class="box" id="form-tambahobatalkes">
            <legend class='rim'>Obat dan Alat Kesehatan</legend>
            <div class="row">
                <?php $this->renderPartial($this->path_view . '_formObatAlkesPasien', array('form' => $form, 'format' => $format, 'modPermintaanPenawaran' => $modPermintaanPenawaran, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>
            </div>
        </fieldset>
    <?php } ?>
    <div class="block-tabel">
        <h6>Tabel <b>Permintaan Penawaran</b></h6>
        <div id="table-obatalkespasien">
            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                <thead>
                    <tr>
                        <th>No.Urut</th>
                        <th>Kategori/<br>Nama Obat</th>
                        <th>Asal Barang</th>
                        <th>Stok</th>
                        <th>Satuan Kecil/Besar</th>
                        <th>Jumlah Permintaan<br>(Satuan Besar)</th>
                        <th>Minimal Stok</th>
                        <th>Harga Satuan</th>
                        <th>Sub Total</th>
                        <?php echo ((!isset($_GET['sukses'])) ? "<th>Batal</th>" : ""); ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count((array)$modDetails) > 0) {
                        foreach ($modDetails as $i => $modPenawaranDetail) {
                            echo $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modPermintaanPenawaran' => $modPermintaanPenawaran, 'modPenawaranDetail' => $modPenawaranDetail, 'modObatAlkes' => $modObatAlkes));
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">Total</td>
                        <td><?php echo CHtml::textField('total', '', array('class' => 'span2 integer', 'style' => 'width:90px;')) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <fieldset class="box">
        <legend class='rim'>Pegawai Berwenang</legend>
        <div class="row">
            <div class="span2">
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($modPermintaanPenawaran, 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modPermintaanPenawaran, 'pegawaimengetahui_id', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPermintaanPenawaran,
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
									$("#' . Chtml::activeId($modPermintaanPenawaran, 'pegawaimengetahui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimengetahui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($modPermintaanPenawaran, 'pegawaimengetahui_id') . '").val(""); '
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group">
                    <?php echo $form->labelEx($modPermintaanPenawaran, 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($modPermintaanPenawaran, 'pegawaimenyetujui_id', array('readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model' => $modPermintaanPenawaran,
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
									$("#' . Chtml::activeId($modPermintaanPenawaran, 'pegawaimenyetujui_id') . '").val(ui.item.pegawai_id); 
									return false;
								}',
                            ),
                            'htmlOptions' => array(
                                'class' => 'pegawaimenyetujui_nama',
                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                'onblur' => 'if(this.value === "") $("#' . CHtml::activeId($modPermintaanPenawaran, 'pegawaimenyetujui_id') . '").val(""); '
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
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
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
            //                        echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);',array('class'=>'btn btn-info', 'disabled'=>'true'));  /**RND-4044*/
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')"));
            //                        echo CHtml::link(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),'javascript:void(0);', array('class'=>'btn btn-info', 'onclick'=>"print('EXCEL')"));  /**RND-4044*/
        }

        $content = $this->renderPartial($this->path_view . 'tips/tipsRencanaKebutuhan', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modPermintaanPenawaran' => $modPermintaanPenawaran, 'modRencanaKebFarmasi' => $modRencanaKebFarmasi)); ?>