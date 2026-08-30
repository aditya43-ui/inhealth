<?php

/**
 * form pencarian 
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'searchLaporan',
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
            ?>
            <div class="row">
                <div class="col-sm-6">
                    <?php echo CHtml::hiddenField('type', ''); ?>
                    <div class="control-group">
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
                    echo CHtml::hiddenField('filter', 'wilayah', array('disabled' => 'disabled')) .
                        '<div class="control-group">
                        ' . CHtml::label('Provinsi', 'propinsi_id', array('class' => 'control-label')) . ' 
                        <div class="controls">
                            ' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                            'class' => 'form-control', 'multiple' => 'multiple'
                        )) . '
                        </div>
                    </div>
                    <div class="control-group">
                        ' . CHtml::label('Kabupaten', 'kabupaten_id', array('class' => 'control-label')) . ' 
                        <div class="controls">												 
                            ' . $form->dropDownList(
                            $model,
                            'kabupaten_id',
                            array(),
                            array('class' => 'form-control', 'multiple' => 'multiple')
                        ) . '
                        </div>
                    </div>';

                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'wilayah',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content2' => array(
                    //             'multi' => 'multi',
                    //             'header' => 'Berdasarkan Wilayah',
                    //             'isi' => CHtml::hiddenField('filter', 'wilayah', array('disabled' => 'disabled')) .
                    //                 '<div class="control-group">
                    // 				' . CHtml::label('Provinsi', 'propinsi_id', array('class' => 'control-label')) . ' 
                    // 				<div class="controls">
                    // 					' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                    //                     'class' => 'form-control', 'multiple' => 'multiple'
                    //                 )) . '
                    // 				</div>
                    // 			</div>
                    // 			<div class="control-group">
                    // 				' . CHtml::label('Kabupaten', 'kabupaten_id', array('class' => 'control-label')) . ' 
                    // 				<div class="controls">												 
                    // 					' . $form->dropDownList(
                    //                     $model,
                    //                     'kabupaten_id',
                    //                     array(),
                    //                     array('class' => 'form-control', 'multiple' => 'multiple')
                    //                 ) . '
                    // 				</div>
                    // 			</div>',
                    //             'active' => true,
                    //         ),
                    //     ),
                    // ));
                    ?>

                    <?php
                    echo CHtml::hiddenField('filter', 'instalasiasal_id', array('disabled' => 'disabled')) .
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
                    //     'id' => 'instalruangan',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content4' => array(
                    //             'multi' => 'multi',
                    //             'header' => 'Berdasarkan Instalasi dan Ruangan',
                    //             'isi' => CHtml::hiddenField('filter', 'instalasiasal_id', array('disabled' => 'disabled')) .
                    //                 '<div class="control-group">
                    // 				' . CHtml::label('Instalasi', 'instalasiasal_id', array('class' => 'control-label')) . ' 
                    // 				<div class="controls">
                    // 					' . $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->getDropInsPelayanan(), 'instalasi_id', 'instalasi_nama'), array(
                    //                     'class' => 'form-control', 'multiple' => 'multiple'
                    //                 )) . '
                    // 				</div>
                    // 			</div>
                    // 			<div class="control-group">
                    // 				' . CHtml::label('Ruangan', 'ruanganasal_id', array('class' => 'control-label')) . ' 
                    // 				<div class="controls">												 
                    // 					' . $form->dropDownList(
                    //                     $model,
                    //                     'ruanganasal_id',
                    //                     array(),
                    //                     array('class' => 'form-control', 'multiple' => 'multiple')
                    //                 ) . '
                    // 				</div>
                    // 			</div>',
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
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content3' => array(
                    //             'multi' => 'multi',
                    //             'header' => 'Berdasarkan Jenis Penjamin',
                    //             'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
                    //                 '<div class="control-group">
                    // 				' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                    // 				<div class="controls">
                    // 					' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                    //                     'class' => 'form-control', 'multiple' => 'multiple'
                    //                 )) . '
                    // 				</div>
                    // 			</div>
                    // 			<div class="control-group">
                    // 				' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                    // 				<div class="controls">												 
                    // 					' . $form->dropDownList(
                    //                     $model,
                    //                     'penjamin_id',
                    //                     array(),
                    //                     array('class' => 'form-control', 'multiple' => 'multiple')
                    //                 ) . '
                    // 				</div>
                    // 			</div>',
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
                    //         'content5' => array(
                    //             'multi' => 'multi',
                    //             'header' => 'Berdasarkan Kunjungan',
                    //             'isi' => CHtml::hiddenField('filter', 'kunjungan', array('disabled' => 'disabled')) .
                    //                 '<div class="control-group">
                    // 				' . CHtml::label('Kunjungan', 'kunjungan', array('class' => 'control-label')) . ' 
                    // 				<div class="controls">
                    // 					' . $form->dropDownList($model, 'kunjungan', LookupM::getItems('kunjungan'), array(
                    //                     'class' => 'form-control', 'multiple' => 'multiple'
                    //                 )) . '
                    // 				</div>
                    // 			</div>',
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
                                    <td style="width: 120px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kunjungan', 'id' => 'rkunjungan',)) . ' <label for="rkunjungan">Kunjungan</label></td>                                               
                                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
                                </tr>                                                                                    
                                <tr>
                                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal',)) . ' <label for="rinstalasiasal">Instalasi asal</label></td>
                                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal',)) . ' <label for="rruanganasal">Ruangan Asal</label></td>
                                </tr>
                                <tr>
                                    <td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'wilayah', 'id' => 'rwilayah',)) . ' <label for="rwilayah">Wilayah</label></td>                                            
                                </tr>
                            </table>';
                            ?>
                        </div>
                    </div>


                    <?php
                    // $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    //     'id' => 'grafik',
                    //     'slide' => true,
                    //     'content' => array(
                    //         'content6' => array(
                    //             'header' => 'Data grafik',
                    //             'isi' =>
                    //             '<table>
                    // 			<tr>
                    // 				<td style="width: 120px;">' . CHtml::radioButton('tampilGrafik', true, array('name' => 'dataGrafik', 'value' => 'kunjungan', 'id' => 'rkunjungan',)) . ' <label for="rkunjungan">Kunjungan</label></td>                                               
                    // 				<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'carabayar', 'id' => 'rcarabayar',)) . ' <label for="rcarabayar">Jenis Penjamin</label></td>                                                                                           
                    // 			</tr>                                                                                    
                    // 			<tr>
                    // 				<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'instalasiasal', 'id' => 'rinstalasiasal',)) . ' <label for="rinstalasiasal">Instalasi asal</label></td>
                    // 				<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'ruanganasal', 'id' => 'rruanganasal',)) . ' <label for="rruanganasal">Ruangan Asal</label></td>
                    // 			</tr>
                    // 			<tr>
                    // 				<td>' . CHtml::radioButton('tampilGrafik', false, array('name' => 'dataGrafik', 'value' => 'wilayah', 'id' => 'rwilayah',)) . ' <label for="rwilayah">Wilayah</label></td>                                            
                    // 			</tr>
                    // 		</table>',
                    //             'active' => TRUE,
                    //         ),
                    //     ),
                    // ));
                    ?>
                </div>
            </div>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(
                    Yii::t(
                        'mds',
                        '{icon} Search',
                        array('{icon}' => '<i class="entypo-search"></i>')
                    ),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                );
                ?>
                <?php
                echo CHtml::link(
                    Yii::t(
                        'mds',
                        '{icon} Ulang',
                        array('{icon}' => '<i class="entypo-arrows-ccw"></i>')
                    ),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
                ?>
            </div>
            <?php //$this->widget('UserTips', array('type' => 'create')); 
            ?>
        </div>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));

$this->renderPartial("_jsFunctions", array('model' => $model));
?>