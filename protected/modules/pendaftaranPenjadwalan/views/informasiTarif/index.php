 <?php
    $this->breadcrumbs = array(
        'Informasi Tarif Pelayanan',
    );
    $arrMenu = array();
    $this->menu = $arrMenu;
    ?>
 <div class="panel panel-gradient">
     <div class="panel-heading">
         <div class="panel-title">
             <i class="entypo-ticket"></i> Informasi <b>Tarif Pelayanan</b>
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
                 <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
                 <?php
                    $form = $this->beginWidget(
                        'ext.bootstrap.widgets.BootActiveForm',
                        array(
                            'id' => 'formCariInput',
                            'enableAjaxValidation' => false,
                            'type' => 'horizontal',
                            'focus' => '#' . CHtml::activeId($modTarifTindakanRuanganV, 'daftartindakan_nama'),
                            'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                        )
                    );
                    ?>
                 <div class="row">
                     <div class="col-sm-6">
                         <?php
                            echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true), array('order' => 'jenistarif_nama ASC')), 'jenistarif_id', 'jenistarif_nama'), array('empty' => '-- Pilih --', 'class' => 'span3'));
                            ?>
                         <?php /*
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'instalasi_id',
                        CHtml::listData($modTarifTindakanRuanganV->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'),
                        array(
                            'empty'=>'-- Pilih --',
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'ajax'=>array(
                                'type'=>'POST',
                                'url'=>$this->createUrl('ruanganDariInstalasi',array('encode'=>false,'namaModel'=>'PPTarifTindakanPerdaRuanganV')),
                                'update'=>'#PPTarifTindakanPerdaRuanganV_ruangan_id'
                            )
                        )
                    );
                ?>
               <?php
                    echo $form->dropDownListRow($modTarifTindakanRuanganV,'ruangan_id',
                        CHtml::listData($modTarifTindakanRuanganV->getRuanganItems($modTarifTindakanRuanganV->instalasi_id), 'ruangan_id', 'ruangan_nama'),
                        array(
                            'class'=>'span3', 
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'empty'=>'-- Pilih --'
                        )
                    );*/
                            ?>
                         <div class="control-group">
                             <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                             <div class="controls">
                                 <?php echo $form->dropDownList($modTarifTindakanRuanganV, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array(
                                        'class' => 'form-control', 'multiple' => 'multiple'
                                    ));
                                    ?>
                             </div>
                         </div>
                         <div class="control-group">
                             <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                             <div class="controls">
                                 <?php
                                    echo $form->dropDownList(
                                        $modTarifTindakanRuanganV,
                                        'ruangan_id',
                                        array(),
                                        array('class' => 'form-control', 'multiple' => 'multiple')
                                    );
                                    ?>
                             </div>
                         </div>
                         <?php
                            echo $form->dropDownListRow(
                                $modTarifTindakanRuanganV,
                                'kelaspelayanan_id',
                                CHtml::listData(KelaspelayananM::model()->findAll("kelaspelayanan_aktif = TRUE ORDER BY kelaspelayanan_nama ASC"), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                                array(
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'empty' => '-- Pilih --'
                                )
                            );
                            ?>
                     </div>
                     <div class="col-sm-6">
                         <?php
                            echo $form->dropDownListRow(
                                $modTarifTindakanRuanganV,
                                'kelompoktindakan_nama',
                                CHtml::listData($modTarifTindakanRuanganV->getKelompokTindakanItems(), 'kelompoktindakan_nama', 'kelompoktindakan_nama'),
                                array(
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'empty' => '-- Pilih --'
                                )
                            );
                            ?>
                         <?php
                            echo $form->dropDownListRow(
                                $modTarifTindakanRuanganV,
                                'komponenunit_nama',
                                CHtml::listData($modTarifTindakanRuanganV->getKomponenUnitItems(), 'komponenunit_nama', 'komponenunit_nama'),
                                array(
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'empty' => '-- Pilih --'
                                )
                            );
                            ?>
                         <?php
                            echo $form->dropDownListRow(
                                $modTarifTindakanRuanganV,
                                'kategoritindakan_id',
                                CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'),
                                array(
                                    'class' => 'span3',
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'empty' => '-- Pilih --'
                                )
                            );
                            ?>
                         <?php
                            echo $form->textFieldRow(
                                $modTarifTindakanRuanganV,
                                'daftartindakan_nama',
                                array(
                                    'class' => 'span3 custom-only',
                                    'onkeypress' => "return $(this).focusNextInputField(event);",
                                    'maxlength' => 30,
                                    'placeholder' => 'Uraian Tindakan'
                                )
                            );
                            ?>
                     </div>
                 </div>
                 <div class="form-actions">
                     <?php
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                            array(
                                'class' => 'btn btn-danger',
                                'type' => 'submit',
                                'title' => 'Cari'
                            )
                        );
                        ?>
                     <?php echo CHtml::link(
                            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                            $this->createUrl($this->id . '/index'),
                            array(
                                'class' => 'btn btn-default',
                                'title' => 'Ulang',
                                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                            )
                        ); ?>
                     <?php echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')),
                            array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printTarif()')
                        ); ?>
                     <?php
                        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiTarifPelayanan', array(), true);
                        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                        ?>
                 </div>
                 <?php $this->endWidget(); ?>
             </div>
         </div>
         <div class="panel panel-success">
             <div class="panel-heading">
                 <div class="panel-title">
                     <i class="entypo-credit-card"></i> Tabel <b>Tarif Pelayanan</b>
                 </div>
             </div>
             <div class="panel-body table-responsive">
                 <?php
                    $this->widget(
                        'ext.bootstrap.widgets.BootGridView',
                        array(
                            'id' => 'daftarTindakan-grid',
                            'dataProvider' => $modTarifTindakanRuanganV->searchInformasi(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                            'columns' => array(
                                array(
                                    'header' => 'Penjamin',
                                    'value' => '$data->penjamin_nama'
                                ),
                                'jenistarif_nama',
                                array(
                                    'header' => 'Instalasi',
                                    'type' => 'raw',
                                    'value' => '$data->instalasi_nama',
                                ),
                                array(
                                    'header' => 'Ruangan ',
                                    'type' => 'raw',
                                    'value' => '$data->ruangan_nama',
                                ),
                                array(
                                    'header' => 'Kelas Pelayanan',
                                    'value' => '$data->kelaspelayanan_nama',
                                    'filter' => false,
                                ),
                                'kelompoktindakan_nama',
                                'komponenunit_nama',
                                'kategoritindakan_nama',
                                'daftartindakan_nama',
                                array(
                                    'header' => 'Cyto <br> Tindakan (%)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'value' => '$data->persencyto_tind',
                                ),
                                array(
                                    'header' => 'Keringanan <br> Tindakan (%)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'value' => '$data->persendiskon_tind',
                                ),
                                array(
                                    'name' => 'Komponen<br>Tarif',
                                    'type' => 'raw',
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                    'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id, "jenistarif_id"=>$data->jenistarif_id)) ,array("title"=>"Klik untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))'
                                ),
                                array(
                                    'name' => 'tarifTotal',
                                    'header' => 'Tarif Total (Rp)',
                                    'htmlOptions' => array('style' => 'text-align: right;'),
                                    'value' => '$this->grid->getOwner()->renderPartial(\'pendaftaranPenjadwalan.views.informasiTarif._tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                                ),
                            ),
                            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                        )
                    );
                    ?>
             </div>
         </div>
         <?php
            // ===========================Dialog Details Tarif=========================================
            $this->beginWidget(
                'zii.widgets.jui.CJuiDialog',
                array(
                    'id' => 'dialogDetailsTarif',
                    'options' =>
                    array(
                        'title' => 'Komponen Tarif',
                        'autoOpen' => false,
                        'width' => 480,
                        'height' => 280,
                        'resizable' => false,
                    ),
                )
            );
            ?>
         <iframe src="" name="iframe" style="width: 100%; height: 98%;"></iframe>
         <?php
            $this->endWidget('zii.widgets.jui.CJuiDialog');
            //===============================Akhir Dialog Details Tarif================================
            Yii::app()->clientScript->registerScript('search', "
    $('#formCariInput').submit(function(){
            $.fn.yiiGridView.update('daftarTindakan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
            ?>
     </div>
 </div>
 <?php $urlPrint = $this->createUrl('print'); ?>
 <script>
     function printTarif() {
         //console.log("<?php echo $urlPrint; ?>&" + $("#formCari").serialize());
         window.open("<?php echo $urlPrint; ?>&" + $("#formCariInput").serialize() + "&caraPrint=PRINT", "", 'location=_new, width=900px');
     }
     $(document).ready(function() {
         jQuery("#PPTarifTindakanPerdaRuanganV_instalasi_id").multiselect({
             includeSelectAllOption: true,
             buttonClass: "form-control",
             maxHeight: 300,
             buttonWidth: '182px',
             enableCaseInsensitiveFiltering: true,
             onChange: function(element, checked) {
                 var brands = jQuery('#PPTarifTindakanPerdaRuanganV_instalasi_id option:selected');
                 var selected = [];
                 $(brands).each(function(index, brand) {
                     selected.push($(this).val());
                 });
                 jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").addClass('animation-loading');
                 jQuery.ajax({
                     type: 'POST',
                     url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                     dataType: "json",
                     data: {
                         instalasi_id: selected
                     },
                     success: function(data) {
                         if (data.sukses != '1') {
                             //toastr.error(data.pesan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").addClass('animation-loading');
                         } else {
                             //alert(data.ruangan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").html(data.ruangan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").multiselect('rebuild');
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").multiselect({
                                 includeSelectAllOption: true,
                                 buttonClass: "form-control",
                                 maxHeight: 300,
                                 buttonWidth: '182px',
                                 enableCaseInsensitiveFiltering: true,
                             }).hide();
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").removeClass('animation-loading');
                         }
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                         console.log(errorThrown);
                     }
                 });
             },
             onSelectAll: function() {
                 var brands = jQuery('#PPTarifTindakanPerdaRuanganV_instalasi_id option:selected');
                 var selected = [];
                 $(brands).each(function(index, brand) {
                     selected.push($(this).val());
                 });
                 jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").addClass('animation-loading');
                 jQuery.ajax({
                     type: 'POST',
                     url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                     dataType: "json",
                     data: {
                         instalasi_id: selected
                     },
                     success: function(data) {
                         if (data.sukses != '1') {
                             //toastr.error(data.pesan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").addClass('animation-loading');
                         } else {
                             //alert(data.ruangan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").html(data.ruangan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").multiselect('rebuild');
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").multiselect({
                                 includeSelectAllOption: true,
                                 buttonClass: "form-control",
                                 maxHeight: 300,
                                 buttonWidth: '182px',
                                 enableCaseInsensitiveFiltering: true,
                             }).hide();
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").removeClass('animation-loading');
                         }
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                         console.log(errorThrown);
                     }
                 });
             },
             onDeselectAll: function() {
                 var brands = jQuery('#PPTarifTindakanPerdaRuanganV_instalasi_id option:selected');
                 var selected = '';
                 jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").addClass('animation-loading');
                 jQuery.ajax({
                     type: 'POST',
                     url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                     dataType: "json",
                     data: {
                         instalasi_id: selected
                     },
                     success: function(data) {
                         if (data.sukses != '1') {
                             //toastr.error(data.pesan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").addClass('animation-loading');
                         } else {
                             //alert(data.ruangan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").html(data.ruangan);
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").multiselect('rebuild');
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").multiselect({
                                 includeSelectAllOption: true,
                                 buttonClass: "form-control",
                                 maxHeight: 300,
                                 buttonWidth: '182px',
                                 enableCaseInsensitiveFiltering: true,
                             }).hide();
                             jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").removeClass('animation-loading');
                         }
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                         console.log(errorThrown);
                     }
                 });
             }
         }).hide();
         jQuery("#PPTarifTindakanPerdaRuanganV_ruangan_id").multiselect({
             includeSelectAllOption: true,
             buttonClass: "form-control",
             maxHeight: 300,
             buttonWidth: '182px',
             enableCaseInsensitiveFiltering: true,
         }).hide();
     });
 </script>