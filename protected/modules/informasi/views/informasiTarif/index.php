<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Tarif</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Tarif',
        );
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                return false;
        });
        $('#searchCari').submit(function(){
                $.fn.yiiGridView.update('ininformasiTarif-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
    ");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body form-search">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'id' => 'searchCari',
                    'type' => 'horizontal',
                ));
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        echo $form->dropDownListRow(
                            $modTarifTindakanRuanganV,
                            'instalasi_id',
                            CHtml::listData($modTarifTindakanRuanganV->getInstalasiItems(), 'instalasi_id', 'instalasi_nama'),
                            array(
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --',
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => $this->createUrl('SetDropdownRuangan', array('encode' => false, 'model_nama' => get_class($modTarifTindakanRuanganV))),
                                    'update' => '#' . CHtml::activeId($modTarifTindakanRuanganV, 'ruangan_id')
                                )
                            )
                        );
                        ?>
                        <?php
                        echo $form->dropDownListRow(
                            $modTarifTindakanRuanganV,
                            'ruangan_id',
                            CHtml::listData($modTarifTindakanRuanganV->getRuanganItems($modTarifTindakanRuanganV->instalasi_id), 'ruangan_id', 'ruangan_nama'),
                            array(
                                'empty' => '-- Pilih --',
                                'class' => 'span3',
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            )
                        );
                        ?>
                        <?php echo $form->dropDownListRow($modTarifTindakanRuanganV, 'jenistarif_id', CHtml::listData(JenistarifM::model()->findAllByAttributes(array('jenistarif_aktif' => true)), 'jenistarif_id', 'jenistarif_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                        <?php
                        echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kategoritindakan_id', CHtml::listData($modTarifTindakanRuanganV->getKategoritindakanItems(), 'kategoritindakan_id', 'kategoritindakan_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php
                            echo $form->dropDownListRow($modTarifTindakanRuanganV, 'kelaspelayanan_id', CHtml::listData($modTarifTindakanRuanganV->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                            ?>
                            <?php echo $form->textFieldRow($modTarifTindakanRuanganV, 'daftartindakan_nama', array('placeholder' => 'Uraian Tindakan', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 30, 'autofocus' => TRUE)); ?>
                            <div class="control-label">Jenis Penjamin</div>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modTarifTindakanRuanganV, 'carabayar_id', CHtml::listData(CarabayarM::model()->findAll(), 'carabayar_id', 'carabayar_nama'), array(
                                    'empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => 'INTarifTindakanPerdaRuanganV')),
                                        'update' => '#INTarifTindakanPerdaRuanganV_penjamin_id'  //selector to update
                                    ),
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Penjamin', ' Penjamin', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->dropDownList($modTarifTindakanRuanganV, 'penjamin_id', CHtml::listData(PenjaminpasienM::model()->findAll(), 'penjamin_id', 'penjamin_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
                    );
                    ?>
                    <?php echo CHtml::htmlButton(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        array('title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset')
                    );
                    ?>
                    <?php
                    $content = $this->renderPartial('../tips/informasiTarif', array(), true);
                    $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
                    ?>
                </div>
                <!--</fieldset>-->
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Informasi Tarif</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'ininformasiTarif-grid',
                    'dataProvider' => $modTarifTindakanRuanganV->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Instalasi / Ruangan ',
                            'type' => 'raw',
                            'value' => '$data->InstalasiRuangan',
                        ),
                        'jenistarif_nama',
                        'kelompoktindakan_nama',
                        'kategoritindakan_nama',
                        'daftartindakan_nama',
                        'kelaspelayanan_nama',
                        'carabayar_nama',
                        'penjamin_nama',
                        array(
                            'header' => 'Tarif (Rp)',
                            'value' => '$this->grid->getOwner()->renderPartial(\'_tarifTotal\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id,\'daftartindakan_id\'=>$data->daftartindakan_id,\'jenistarif_id\'=>$data->jenistarif_id),true)',
                            'htmlOptions' => array('style' => 'text-align: right;',),
                        ),
                        'persencyto_tind',
                        'persendiskon_tind',
                        array(
                            'name' => 'Komponen Tarif',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'value' => 'CHtml::link("<i class=\'icon-form-komtarif\'></i> ",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/detailsTarif",array("kelaspelayanan_id"=>$data->kelaspelayanan_id,"daftartindakan_id"=>$data->daftartindakan_id, "kategoritindakan_id"=>$data->kategoritindakan_id, "jenistarif_id"=>$data->jenistarif_id)) ,array("title"=>"Klik untuk Melihat Detail Tarif","target"=>"iframe", "onclick"=>"$(\"#dialogDetailsTarif\").dialog(\"open\");", "rel"=>"tooltip"))',
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
$urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintTarif');
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint+"&d"+$('#search').serialize(),"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>
<?php
// ===========================Dialog Details Tarif=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailsTarif',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Komponen Tarif',
        'autoOpen' => false,
        'width' => 350,
        'height' => 350,
        'resizable' => false,
        'scroll' => false
    ),
));
?>
<iframe src="" name="iframe" style="width:100%; height: 98%;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details Tarif================================
?>
<?php
//    $url =Yii::app()->createUrl($this->route);
//    $urlshift = $this->createUrl('GantiInstalasi');
//    $js = <<< JS
//   
//    function ajaxGetInstalasi(){
//    instalasi = $("#instalasi_id").val();
//    $("#instalasi").val(instalasi);
//        $.fn.yiiGridView.update('ininformasiTarif-grid', {
//		data: $("#search").serialize()
//	});
////        instalasi_id = $('#instalasi_id').val();
////        $.post('${urlshift}', {instalasi_id:instalasi_id},function(data){
////            $('#instalasi').val(data.instalasi_id);
////             $('#ininformasiTarif-grid tbody').html(data);
////        },'json');
//    }
//    
//JS;
//    Yii::app()->clientScript->registerScript('onheadDialog', $js, CClientScript::POS_HEAD);
?>
<?php
//$url = $this->createUrl('GantiInstalasi');
//Yii::app()->clientScript->registerScript('list', '
//    function ajaxGetInstalasi(){
//        instalasi_id = $("#instalasi_id").val();
//        $.post("'.$url.'", {ajax:true,instalasi_id:instalasi_id},function(data){
//            $(".grid-view").html(data.isi);
//            jQuery(\'a[rel="popover"]\').popover();
//            jQuery(\'.poping\').popover({placement:"bottom"});
//        },"json");
//    }
//',  CClientScript::POS_HEAD); 
?>