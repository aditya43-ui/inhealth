<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
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
            //     'content' => array(
            //         'content2' => array(
            //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Kunjungan',
            //             'isi' => CHtml::hiddenField('filter', 'kunjungan', array('disabled' => 'disabled')) .
            //                 '<div class="control-group">
            //                         ' . CHtml::label('Kunjungan', 'kunjungan', array('class' => 'control-label')) . ' 
            //                         <div class="controls">
            //                             ' . $form->dropDownList($model, 'kunjungan', LookupM::getItems('kunjungan'), array(
            //                     'class' => 'form-control', 'multiple' => 'multiple'
            //                 )) . '
            //                         </div>
            //                     </div>',
            //             'active' => true,
            //         ),
            //     ),
            // ));
            ?>
            <div id='searching'>
                <div class="control-group">
                    <label class="control-label">Jenis Pemeriksaan Lab</label>
                    <div class="controls">
                        <?php
                        echo CHtml::hiddenField('idJenisPemeriksaan')
                            . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'jenispemeriksaanlab_nama', array(
                                'id' => 'jenispemeriksaanlab', 'data-offset-top' => 200,
                                'inline' => false,
                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/JenisPemeriksaanlab'),
                                'placeholder' => 'Jenis Pemeriksaan Lab'
                            ))
                            . '<a href="javascript:void(0);" id="tombolJenisPemeriksaanLab" 
                                onclick="$(&quot;#dialogJenisPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                                <i class="icon-list"></i>
                                <i class="entypo-search"></i>
                            </a></span></div>';

                        // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                        //     'id' => 'pemeriksaan',
                        //     //                                    'parent'=>false,
                        //     //                                    'disabled'=>true,
                        //     //                                    'accordion'=>false, //default
                        //     'content' => array(
                        //         'content4' => array(
                        //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Jenis Pemeriksaan',
                        //             'isi' =>
                        //             '<table>
                        // 					<tr>
                        // 						<td>' . CHtml::hiddenField('idJenisPemeriksaan')
                        //                 . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'jenispemeriksaanlab_nama', array(
                        //                     'id' => 'jenispemeriksaanlab', 'data-offset-top' => 200,
                        //                     'inline' => false,
                        //                     'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/JenisPemeriksaanlab'),
                        //                     'placeholder' => 'Jenis Pemeriksaan Lab'
                        //                 ))
                        //                 . '<a href="javascript:void(0);" id="tombolJenisPemeriksaanLab" 
                        // 									onclick="$(&quot;#dialogJenisPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                        // 									<i class="icon-list"></i>
                        // 									<i class="entypo-search"></i>
                        // 								</a></span></div>
                        // 							</td>
                        // 						</tr>
                        // 					</table>',
                        //             'active' => true,
                        //         ),
                        //     ),
                        //     //                                    'htmlOptions'=>array('class'=>'aw',)
                        // ));
                        ?>
                    </div>
                </div>
            </div>

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
            //     'id' => 'instalasi',
            //     'content' => array(
            //         'content6' => array(
            //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Instalasi dan Ruangan',
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
            //     //                                    'htmlOptions'=>array('class'=>'aw',)
            // ));
            ?>
        </div>
        <div class="col-sm-6">
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
            //     'id' => 'carabayar',
            //     'content' => array(
            //         'content3' => array(
            //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Jenis Penjamin',
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


            <div class="control-group">
                <label class="control-label">Nama Pemeriksaan Lab</label>
                <div class="controls">
                    <?php
                    echo CHtml::hiddenField('idPemeriksaan')
                        . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'pemeriksaanlab_nama', array(
                            'id' => 'pemeriksaanlab', 'data-offset-top' => 200,
                            'inline' => false,
                            'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pemeriksaanlab'),
                            'placeholder' => 'Nama Pemeriksaan Lab'
                        ))
                        . '<a href="javascript:void(0);" id="tombolPemeriksaanLab" 
                  onclick="$(&quot;#dialogPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                  <i class="icon-list"></i>
                  <i class="entypo-search">	</i>
                  </a></span></div>';

                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'big2',
                    //     //                                    'parent'=>false,
                    //     //                                    'disabled'=>true,
                    //     //                                    'accordion'=>false, //default
                    //     'content' => array(
                    //         'content5' => array(
                    //             'header' => '<i class="entypo-doc-text"></i> Berdasarkan Pemeriksaan',
                    //             'isi' =>
                    //             '<table>
                    //   <tr>
                    //     <td>' . CHtml::hiddenField('idPemeriksaan')
                    //                 . '<div class="input-append"><span class="add-on">' . $form->textField($model, 'pemeriksaanlab_nama', array(
                    //                     'id' => 'pemeriksaanlab', 'data-offset-top' => 200,
                    //                     'inline' => false,
                    //                     'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pemeriksaanlab'),
                    //                     'placeholder' => 'Nama Pemeriksaan Lab'
                    //                 ))
                    //                 . '<a href="javascript:void(0);" id="tombolPemeriksaanLab" 
                    //         onclick="$(&quot;#dialogPemeriksaanLab&quot;).dialog(&quot;open&quot;);return false;">
                    //         <i class="icon-list"></i>
                    //         <i class="entypo-search">	</i>
                    //         </a></span></div>
                    //     </td>
                    //   </tr>
                    // </table>',
                    //             'active' => true,
                    //         ),
                    //     ),
                    //     //                                    'htmlOptions'=>array('class'=>'aw',)
                    // ));
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Saring Berdasarkan</label>
                <div class="controls">
                    <?php
                    echo '<table>
                <tr>
                    <td style="width: 40%;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kunjungan', 'id' => 'rkunjungan')) . ' <label for="rkunjungan">Kunjungan</label></td>                                               
                    <td style="width: 40%;">' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar')) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
                </tr>                                            
                <tr>
                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'jenispemeriksaan', 'id' => 'rjenispemeriksaan')) . ' <label for="rjenispemeriksaan">Jenis Pemeriksaan</label></td>
                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'pemeriksaan', 'id' => 'rpemeriksaan')) . ' <label for="rpemeriksaan">Pemeriksaan</label></td>
                </tr>
                <tr>
                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal')) . ' <label for="rinstalasiasal">Instalasi asal</label></td>
                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal')) . ' <label for="rruanganasal">Ruangan Asal</label></td>
                </tr>
            </table>';

                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'grafik',
                    //     'content' => array(
                    //         'content7' => array(
                    //             'header' => '<i class="entypo-doc-text"></i> Data Grafik',
                    //             'isi' =>
                    //             '<table>
                    // 					<tr>
                    // 						<td style="width: 40%;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kunjungan', 'id' => 'rkunjungan')) . ' <label for="rkunjungan">Kunjungan</label></td>                                               
                    // 						<td style="width: 40%;">' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar')) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
                    // 					</tr>                                            
                    // 					<tr>
                    // 						<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'jenispemeriksaan', 'id' => 'rjenispemeriksaan')) . ' <label for="rjenispemeriksaan">Jenis Pemeriksaan</label></td>
                    // 						<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'pemeriksaan', 'id' => 'rpemeriksaan')) . ' <label for="rpemeriksaan">Pemeriksaan</label></td>
                    // 					</tr>
                    // 					<tr>
                    // 						<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal')) . ' <label for="rinstalasiasal">Instalasi asal</label></td>
                    // 						<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal')) . ' <label for="rruanganasal">Ruangan Asal</label></td>
                    // 					</tr>
                    // 				</table>',
                    //             'active' => TRUE,
                    //         ),
                    //     ),
                    //     //                                    'htmlOptions'=>array('class'=>'aw',)
                    // ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array(
            'class' => 'btn btn-danger',
            'type' => 'submit',
            'id' => 'btn_simpan',
            'title' => 'Cari'
        )); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/index'), array(
            'class' => 'btn btn-default',
            'title' => 'Ulang',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        ));
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
 * Dialog untuk Jenis Pemeriksaan Lab
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisPemeriksaanLab',
    'options' => array(
        'title' => 'Daftar Jenis Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => true,
    ),
));

$modJenisPemeriksaan = new JenispemeriksaanlabM;
$modJenisPemeriksaan->unsetAttributes();
if (isset($_GET['JenispemeriksaanlabM'])) {
    $modJenisPemeriksaan->attributes = $_GET['JenispemeriksaanlabM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenispemeriksaan-m-grid',
    'dataProvider' => $modJenisPemeriksaan->search(),
    'filter' => $modJenisPemeriksaan,
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
                                                      $(\"#idJenisPemeriksaan\").val(\"$data->jenispemeriksaanlab_id\");
                                                      $(\"#jenispemeriksaanlab\").val(\"$data->jenispemeriksaanlab_nama\");
                                                      $(\"#dialogJenisPemeriksaanLab\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        //                array(
        //                    'header'=>'ID',
        //                    'filter'=>false,
        //                    'value'=>'$data->jenispemeriksaanlab_id',
        //                ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_nama',
            'value' => '$data->jenispemeriksaanlab_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
/**
 * Dialog untuk Nama Pemeriksaan Lab
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemeriksaanLab',
    'options' => array(
        'title' => 'Daftar Nama Pemeriksaan Laboratorium',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 450,
        'resizable' => true,
    ),
));

$modPemeriksaan = new PemeriksaanlabM;
$modPemeriksaan->unsetAttributes();
if (isset($_GET['PemeriksaanlabM'])) {
    $modPemeriksaan->attributes = $_GET['PemeriksaanlabM'];
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
                                                      $(\"#idPemeriksaan\").val(\"$data->pemeriksaanlab_id\");
                                                      $(\"#pemeriksaanlab\").val(\"$data->pemeriksaanlab_nama\");
                                                      $(\"#dialogPemeriksaanLab\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        //                array(
        //                    'header'=>'ID',
        //                    'filter'=>false,
        //                    'value'=>'$data->pemeriksaanlab_id',
        //                ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'name' => 'jenispemeriksaanlab_id',
            'value' => '$data->jenispemeriksaan->jenispemeriksaanlab_nama',
            'filter' => Chtml::activeDropDownList($modPemeriksaan, 'jenispemeriksaanlab_id', Chtml::listData(LBJenisPemeriksaanLabM::model()->findAll(" jenispemeriksaanlab_aktif = TRUE ORDER BY jenispemeriksaanlab_nama ASC "), 'jenispemeriksaanlab_id', 'jenispemeriksaanlab_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kode Pemeriksaan',
            'name' => 'pemeriksaanlab_kode',
            'value' => '$data->pemeriksaanlab_kode',
        ),
        array(
            'header' => 'Nama Pemeriksaan',
            'name' => 'pemeriksaanlab_nama',
            'value' => '$data->pemeriksaanlab_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
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
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>