<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/dropCheck.css');
?>
<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));

    $format = new MyFormatter();
    ?>

    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis Pemeriksaan</label>
                <div class="controls">
                    <?php
                    echo CHtml::hiddenField('idPemeriksaan')
                        . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'jenispemeriksaanrad_nama', array(
                            'id' => 'pemeriksaanrad', 'data-offset-top' => 200,
                            'data-spy' => 'affix', 'style' => 'position: initial; margin-top:-5px; margin-left:-5px',
                            'inline' => false, 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'sourceUrl' => $this->createUrl('getPemeriksaanRad'),
                            'placeholder' => 'Jenis Pemeriksaan'
                        ))
                        . '<a href="javascript:void(0);" id="tombolPemeriksaanRadDialog" 
                            onclick="$(&quot;#dialogPemeriksaanRad&quot;).dialog(&quot;open&quot;);return false;">
                            <i class="icon-list"></i>
                            <i class="entypo-search"></i>
                        </a>
                        </span>
                    </div>';

                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'big',
                    //     'content' => array(
                    //         'content1' => array(
                    //             'header' => 'Berdasarkan Jenis Pemeriksaan',
                    //             'isi' =>
                    //             '<table>
                    // 							<tr>
                    // 								<td>' . CHtml::hiddenField('idPemeriksaan')
                    //                 . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'jenispemeriksaanrad_nama', array(
                    //                     'id' => 'pemeriksaanrad', 'data-offset-top' => 200,
                    //                     'data-spy' => 'affix', 'style' => 'position: initial; margin-top:-5px; margin-left:-5px',
                    //                     'inline' => false, 'onkeypress' => "return $(this).focusNextInputField(event)",
                    //                     'sourceUrl' => $this->createUrl('getPemeriksaanRad'),
                    //                     'placeholder' => 'Jenis Pemeriksaan'
                    //                 ))
                    //                 . '<a href="javascript:void(0);" id="tombolPemeriksaanRadDialog" 
                    // 											onclick="$(&quot;#dialogPemeriksaanRad&quot;).dialog(&quot;open&quot;);return false;">
                    // 											<i class="icon-list"></i>
                    // 											<i class="entypo-search"></i>
                    // 										</a>
                    // 										</span>
                    // 									</div>
                    // 								</td>
                    // 							</tr>
                    // 						</table>',
                    //             'active' => true,
                    //         ),
                    //     ),
                    //     'htmlOptions' => array('class' => 'aw')
                    // ));
                    ?>
                </div>
            </div>

            <?php
            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>
                <div class="control-group">
                    ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                    <div class="controls">												 
                        ' . $form->dropDownList(
                    $model,
                    'penjamin_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                    </div>
                </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'bayar',
            //     'slide' => true,
            //     'content' => array(
            //         'content2' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Jenis Penjamin',
            //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            // 						' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
            // 						<div class="controls">
            // 							' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            // 						</div>
            // 					</div>
            // 					<div class="control-group">
            // 						' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
            // 						<div class="controls">												 
            // 							' . $form->dropDownList(
            //                     $model,
            //                     'penjamin_id',
            //                     array(),
            //                     array('class' => 'form-control', 'multiple' => 'multiple')
            //                 ) . '
            // 						</div>
            // 					</div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>

            <?php
            echo CHtml::hiddenField('filter', 'kunjungan', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Kunjungan', 'kunjungan', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'kunjungan', LookupM::getItems('kunjungan'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'kunjungan',
            //     'slide' => true,
            //     'content' => array(
            //         'content3' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Kunjungan',
            //             'isi' => CHtml::hiddenField('filter', 'kunjungan', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            // 						' . CHtml::label('Kunjungan', 'kunjungan', array('class' => 'control-label')) . ' 
            // 						<div class="controls">
            // 							' . $form->dropDownList($model, 'kunjungan', LookupM::getItems('kunjungan'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            // 						</div>
            // 					</div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>
        </div>

        <div class="col-sm-6">
            <?php
            echo CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                '<div class="control-group">
                    ' . CHtml::label('Instalasi', 'instalasiasal_id', array('class' => 'control-label')) . ' 
                    <div class="controls">
                        ' . $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->getDropInsPelayanan(), 'instalasi_id', 'instalasi_nama'), array(
                    'class' => 'form-control', 'multiple' => 'multiple'
                )) . '
                    </div>
                </div>
                <div class="control-group">
                    ' . CHtml::label('Ruangan', 'ruanganasal_id', array('class' => 'control-label')) . ' 
                    <div class="controls">												 
                        ' . $form->dropDownList(
                    $model,
                    'ruanganasal_id',
                    array(),
                    array('class' => 'form-control', 'multiple' => 'multiple')
                ) . '
                    </div>
                </div>';

            // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            //     'id' => 'instalruang',
            //     'slide' => true,
            //     'content' => array(
            //         'content4' => array(
            //             'multi' => 'multi',
            //             'header' => 'Berdasarkan Instalasi dan Ruangan',
            //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            // 						' . CHtml::label('Instalasi', 'instalasiasal_id', array('class' => 'control-label')) . ' 
            // 						<div class="controls">
            // 							' . $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->getDropInsPelayanan(), 'instalasi_id', 'instalasi_nama'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            // 						</div>
            // 					</div>
            // 					<div class="control-group">
            // 						' . CHtml::label('Ruangan', 'ruanganasal_id', array('class' => 'control-label')) . ' 
            // 						<div class="controls">												 
            // 							' . $form->dropDownList(
            //                     $model,
            //                     'ruanganasal_id',
            //                     array(),
            //                     array('class' => 'form-control', 'multiple' => 'multiple')
            //                 ) . '
            // 						</div>
            // 					</div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>

            <div class="control-group">
                <label class="control-label">Filter</label>
                <div class="controls">
                    <?php
                    echo '<table>
            <tr>
                <td>' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kunjungan', 'id' => 'rkunjungan',)) . ' <label for="rkunjungan">Kunjungan</label></td>                                               
                <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
            </tr>                                                                                    
            <tr>
                <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal',)) . ' <label for="rinstalasiasal">Instalasi asal</label></td>
                <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal',)) . ' <label for="rruanganasal">Ruangan Asal</label></td>
            </tr>
            <tr>
                <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'jenispemeriksaan', 'id' => 'rjenispemeriksaan',)) . ' <label for="rjenispemeriksaan">Jenis Pemeriksaan</label></td>                                            
            </tr>
        </table>';

                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'grafik',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content5' => array(
                    //             'header' => 'Data grafik',
                    //             'isi' =>
                    //             '<table>
                    // 				<tr>
                    // 					<td>' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kunjungan', 'id' => 'rkunjungan',)) . ' <label for="rkunjungan">Kunjungan</label></td>                                               
                    // 					<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
                    // 				</tr>                                                                                    
                    // 				<tr>
                    // 					<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal',)) . ' <label for="rinstalasiasal">Instalasi asal</label></td>
                    // 					<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal',)) . ' <label for="rruanganasal">Ruangan Asal</label></td>
                    // 				</tr>
                    // 				<tr>
                    // 					<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'jenispemeriksaan', 'id' => 'rjenispemeriksaan',)) . ' <label for="rjenispemeriksaan">Jenis Pemeriksaan</label></td>                                            
                    // 				</tr>
                    // 			</table>',
                    //             'active' => TRUE,
                    //         ),
                    //     ),
                    // ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
            array(
                'title' => 'Ulang',
                'class' => 'btn btn-default',
                'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . '') . '";}); return false;'
            )
        );
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php
/**
 * Dialog untuk Pemeriksaan Rad
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaanRad',
    'options' => array(
        'title' => 'Daftar Nama Pemeriksaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPemeriksaan = new PemeriksaanradM;
$modPemeriksaan->unsetAttributes();
if (isset($_GET['PemeriksaanradM'])) {
    $modPemeriksaan->attributes = $_GET['PemeriksaanradM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pemeriksaan-m-grid',
    'dataProvider' => $modPemeriksaan->search(),
    'filter' => $modPemeriksaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#idPemeriksaan\").val(\"$data->pemeriksaanrad_id\");
                                                      $(\"#pemeriksaanrad\").val(\"$data->pemeriksaanrad_nama\");
                                                      $(\"#dialogPemeriksaanRad\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'ID',
            'filter' => false,
            'value' => '$data->pemeriksaanrad_id',
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanrad_nama',
            'value' => '$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',
        ),
        array(
            'header' => 'Nama Pemeriksaan',
            'name' => 'pemeriksaanrad_nama',
            'value' => '$data->pemeriksaanrad_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
<script>
    function checkAll() {
        if ($('#checkAllRuangan').is(':checked')) {
            $('#searchLaporan input[name*="ruanganasal_id"]').each(function() {
                $(this).attr('checked', true);
            });
        } else {
            $('#searchLaporan input[name*="ruanganasal_id"]').each(function() {
                $(this).removeAttr('checked');
            });
        }
    }
    var expanded = false;

    function showCheckboxes3() {
        $("#multiselect3").find("#checkboxes3").slideToggle('fast');
    }

    function showCheckboxes1() {
        $("#multiselect1").find("#checkboxes1").slideToggle('fast');

        // $('#checkboxes1 input[type="checkbox"]').on('click', function() {

        // var title = $(this).closest('#checkboxes1').find('input[type="checkbox"] label').html(),
        //    title = $(this).next('label').text() + ",";

        // if ($(this).is(':checked')) {
        //   var str = $("#dropKunjungan").val();
        //   var html = str.replace("-- Pilih --",'');    
        //   $('#dropKunjungan').find('option').remove().end().append('<option value="'+html+''+title+'">'+html+' '+title+'</option>').val('');

        // } else {
        //   var str = $("#dropKunjungan").val();
        //  var html = str.replace(title,'');   

        //  if (html == ''){        
        //      $('#dropKunjungan').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        //  }else{
        //     $('#dropKunjungan').find('option').remove().end().append('<option value="'+html+'">'+html+'</option>').val('');
        // }

        //}
        //});
    }

    function showCheckboxes2() {
        $("#multiselect2").find("#checkboxes2").slideToggle('fast');

        // $("#multiselect2").find('#checkboxes2 input[type="checkbox"]').on('click', function() {

        // var title = $(this).closest('#checkboxes2').find('input[type="checkbox"] label').html(),
        //   title = $(this).next('label').text() + ",";


        // if ($(this).is(':checked')) {
        //   var str = $("#dropCaraBayar").val();
        //  var html = str.replace("-- Pilih --",'');    
        // $('#dropCaraBayar').find('option').remove().end().append('<option value="'+html+''+title+'">'+html+' '+title+'</option>').val('');

        // } else {
        //   var str = $("#dropCaraBayar").val();
        //   var html = str.replace(title,'');   

        //  if (html == ''){        
        //   $('#dropCaraBayar').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        //  }else{
        //      $('#dropCaraBayar').find('option').remove().end().append('<option value="'+html+'">'+html+'</option>').val('');
        //  }

        // }
        // });
    }

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (!$clicked.parents().hasClass("multiselect")) {
            $("#checkboxes2").hide();
            $("#checkboxes1").hide();
            $("#checkboxes3").hide();
        }
    });
</script>