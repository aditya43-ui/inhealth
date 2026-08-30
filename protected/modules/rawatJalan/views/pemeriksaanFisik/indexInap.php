<?php

/**
 * view utama untuk menampilkan form pemeriksaan fisik
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.taggd.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl . '/css/taggd.css'); ?>
<style>
    .dbnstyle {
        float: right !important;
    }

    .dbnstyle label {
        color: #fafafa !important;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Anamnesa',
);
$this->widget('bootstrap.widgets.BootAlert');

$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'tabel-riwayatpemeriksaanfisik',
    'content' => array(
        'content-detailpemeriksaanfisik' => array(
            'header' => '<b>Tabel Riwayat Pemeriksaan Fisik</b>',
            'isi' => $this->renderPartial($this->path_view . '_tabelRiwayatFisik', array(
                'tabelPemeriksaan' => $tabelPemeriksaan,
                'format' => new MyFormatter(),
            ), true),
            'active' => true,
        ),
    ),
));

?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'rjpemeriksaan-fisik-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#RJPemeriksaanFisikT_keadaanumum_annoninput .maininput',
));

$hide = '';
$headThorax = 'Pemeriksaan Thorax';
if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_POLIK_GIGI) {
    $hide = 'hidden';
    $headThorax = 'Tanda Vital';
}

?>
<style>
    .groupUkurans {
        display: inline;
    }
</style>
<style>
    .hoveringIcon:hover {
        background-color: #FFA0A2;
        cursor: pointer;
        -webkit-border-radius: 1px;
        -moz-border-radius: 1px;
        -o-border-radius: 1px;
        -border-radius: 1px;
    }

    .taggd:hover {
        cursor: crosshair;
    }

    /*--------------------------*/
    #imgtag {
        position: relative;
        min-width: 300px;
        min-height: 300px;
        float: none;
        border: 3px solid #FFF;
        cursor: crosshair;
        text-align: center;
    }

    .tagview {
        border: 1px solid #F10303;
        width: 100px;
        height: 100px;
        position: absolute;
        /*display:none;*/
        opacity: 0;
        color: #FFFFFF;
        text-align: center;
    }

    .square {
        display: block;
        height: 79px;
    }

    .person {
        background: #282828;
        border-top: 1px solid #F10303;
    }

    #tagit {
        position: absolute;
        top: 0;
        left: 0;
        width: 300px;
        border: 1px solid #D7C7C7;
    }

    /*			#tagit .box
									{
											border: 1px solid #F10303;
											width: 10px;
											height: 10px;
											float: left;
									}*/
    #tagit .name {
        /*float: left;*/
        background-color: #FFF;
        width: 295px;
        /*height: 92px;*/
        /*padding: 5px;*/
        font-size: 10pt;
        margin: 0 auto;
        margin-bottom: 0 auto;
    }

    #tagit DIV.text {
        margin-bottom: 5px;
    }

    #tagit INPUT[type=text] {
        margin-bottom: 5px;
    }

    #tagit #tagname {
        width: 110px;
    }

    #taglist {
        width: 300px;
        min-height: 200px;
        height: auto !important;
        height: 200px;
        float: left;
        padding: 10px;
        margin-left: 20px;
        color: #000;
    }

    #taglist OL {
        padding: 0 20px;
        float: left;
        cursor: pointer;
    }

    #taglist OL A {}

    #taglist OL A:hover {
        text-decoration: underline;
    }

    .tagtitle {
        font-size: 14px;
        text-align: center;
        width: 100%;
        float: left;
    }
</style>

<?php echo $form->errorSummary($modPemeriksaanFisik); ?>

<div class="row">
    <div class="col-sm-6">
        <fieldset class=''>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="glyphicon glyphicon-file"></i> Data <b>Pemeriksaan</b>
                    </div>
                </div>     
                  <?php if(isset($_GET['pendaftaran_id'])):?>
                <div class="panel-body">
                    <?php echo CHtml::hiddenField('url', $this->createUrl('', array('pendaftaran_id' => $modPendaftaran->pendaftaran_id)), array('readonly' => TRUE)); ?>
                    <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                    <?php endif ; ?>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'tglperiksafisik', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php $this->widget('MyDateTimePicker', array(
                                'model' => $modPemeriksaanFisik,
                                'attribute' => 'tglperiksafisik',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true, 'class' => 'span3 dtPicker3 realtime',
                                    'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modPemeriksaanFisik,'keadaanumum',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200)); 
                    ?>
                    <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'keadaanumum', array('class' => 'control-label required')) ?>
                          <div class="controls">
                          <?php echo $form->textArea($modPemeriksaanFisik, 'keadaanumum', array('placeholder' => '', 'class' => 'span4 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            <?php
                            // $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                            //     'model' => $modPemeriksaanFisik,
                            //     'attribute' => 'keadaanumum',
                            //     'data' => explode(',', $modPemeriksaanFisik->keadaanumum),
                            //     'debugMode' => true,
                            //     'options' => array(
                            //         //'bricket'=>false,
                            //         'json_url' => $this->createUrl('MasterKeadaanUmum'),
                            //         'addontab' => true,
                            //         'maxitems' => 10,
                            //         'input_min_size' => 0,
                            //         'cache' => true,
                            //         'newel' => true,
                            //         'addoncomma' => true,
                            //         'select_all_text' => "",
                            //     ),
                            // ));
                            ?>
                            <?php echo $form->error($modPemeriksaanFisik, 'keadaanumum'); ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'pegawai_id', CHtml::listData($modPemeriksaanFisik->getDokterItems(), 'pegawai_id', 'NamaLengkap'), array('onkeypress' => "return $(this).focusNextInputField(event);",)); ?>
                    <?php echo $form->dropDownListRow($modPemeriksaanFisik, 'ppds_id', CHtml::listData($modPemeriksaanFisik->getPPDS(), 'ppds_id', 'ppds_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'class' => 'required')); ?>
            
                    <div class="control-group">
                        <?php
                        //var_dump($modPemeriksaanFisik->attributes); die;
                        echo $form->label($modPemeriksaanFisik, 'perawat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPemeriksaanFisik, 'paramedis_nama', CHtml::listData($modPemeriksaanFisik->ParamedisItems, 'pegawai.nama_pegawai', 'pegawai.nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>
                    </div>
                    <!--<div class="control-group">
						<?php echo $form->LabelEx($modPemeriksaanFisik, 'paramedis_nama', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php $this->widget('MyJuiAutoComplete', array(
                                'model' => $modPemeriksaanFisik,
                                'attribute' => 'paramedis_nama',
                                'value' => '',
                                //                      RND-5044    'sourceUrl'=> Yii::app()->createUrl('ActionAutoComplete/Paramedis'),
                                'sourceUrl' => $this->createUrl('AutocompleteParamedisRJ'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 2,
                                    'focus' => 'js:function( event, ui ) {
										$(this).val( ui.item.label);
										return false;
									}',
                                ),
                            )); ?>
							</div>
					  </div> 
					-->
                </div>
            </div>
        </fieldset>
    </div>

    <div class="col-sm-6">
        <fieldset class="">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">Tanda Vital</div>
                </div>
                <div class="panel-body">
                    <?php
                    if (!empty($hide)) {
                        echo $this->renderPartial($this->path_view . "pemeriksaan/_thorax", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);
                    } else {
                        echo $this->renderPartial($this->path_view . "pemeriksaan/_tandaVitalInap", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);
                    }
                    ?>
                    <?php //echo $this->renderPartial($this->path_view."pemeriksaan/_tandaVital", array('modPemeriksaanFisik'=>$modPemeriksaanFisik, 'form'=>$form),true) 
                    ?>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row" <?php echo $hide ?>>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Pemeriksaan Anggota Tubuh
                </div>
            </div>
            <div class="panel-body" style="width:412px !important;">
                <div class="gambar">
                    <?php echo $this->renderPartial($this->path_view . "_formGambarNew", array('id' => $modPemeriksaanFisik->gambartubuh_id, 'temp_file' => $modPemeriksaanFisik->temp_file, 'modGambarTubuh' => $modGambarTubuh, 'modPasien' => $modPasien)); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class='block-tabel'>
                    <table class="items table table-bordered table-striped table-condensed" id="table-bagtubuh">
                        <thead>
                            <tr>
                                <th width='30'>No.</th>
                                <th>Bagian Tubuh</th>
                                <th>Look</th>
                                <th>Feel</th>
                                <th>Move</th>
                                <th>Sensory</th>
                                <th>Motorik</th>
                                <th>Keterangan</th>
                                <th width='80'>Batal / Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (($modPemeriksaanGambar)) {
                                foreach ($modPemeriksaanGambar as $ii => $vv) {
                                    $vv->namabagtubuh = $vv->bagiantubuh->namabagtubuh;
                                    $vv->kordinat_tubuh_x = number_format($vv->kordinat_tubuh_x, 7);
                                    $vv->kordinat_tubuh_y = number_format($vv->kordinat_tubuh_y, 7);
                                    echo $this->renderPartial($this->path_view . '_rowDetail', array('modPemeriksaanGbr' => $vv, 'i' => $ii + 1), true);
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm-6">
        <fieldset class=''>
            <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_kepalaLeher", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
        </fieldset>
    </div>
    <div class="col-sm-6">
        <fieldset class="">
            <div class="panel panel-success panel_cgsews">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'gcs_eye', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
                        Glasgow Coma Scale
                        <?php echo CHtml::link('<i class="icon-chevron-right" style="cursor:pointer;"></i>', '', array('onclick' => "$('#dialogGCS').dialog('open')", 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="panel-body">
                    <div id="divGlowComoScale" style="display: block">
                        <?php // echo  CHtml::button('Gunakan Metode GCS',array('class'=>'btn btn-info','onclick'=>"$('#dialogGCS').dialog('open')", 'onkeypress'=>"return $(this).focusNextInputField(event);"));
                        ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'gcs_eye', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php $crit = new CDbCriteria();
                                $crit->compare('LOWER(metodegcs_singkatan)', "e");
                                $crit->addCondition('metodegcs_nilai is not null');
                                $crit->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList(
                                    $modPemeriksaanFisik,
                                    'gcs_eye',
                                    CHtml::listData(RJMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),
                                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()')
                                ); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'gcs_verbal', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $crit3 = new CDbCriteria();
                                $crit3->compare('LOWER(metodegcs_singkatan)', "v");
                                $crit3->addCondition('metodegcs_nilai is not null');
                                $crit3->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList(
                                    $modPemeriksaanFisik,
                                    'gcs_verbal',
                                    CHtml::listData(RJMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),
                                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()')
                                ); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'gcs_motorik', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $crit2 = new CDbCriteria();
                                $crit2->compare('LOWER(metodegcs_singkatan)', "m");
                                $crit2->addCondition('metodegcs_nilai is not null');
                                $crit2->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList(
                                    $modPemeriksaanFisik,
                                    'gcs_motorik',
                                    CHtml::listData(RJMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),
                                    array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'hitungCGS()')
                                ); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modPemeriksaanFisik, 'namaGCS', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($modPemeriksaanFisik, 'gcs_id', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
                                <?php // echo CHtml::textField('namaGCS',(isset($modPemeriksaanFisik->gcs->gcs_nama) ? $modPemeriksaanFisik->gcs->gcs_nama : "-"),array('disabled'=>true,'class'=>'span1')); 
                                ?>
                                <?php echo $form->textField($modPemeriksaanFisik, 'namaGCS', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)) . ' '; ?>
                            </div>
                        </div>
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'dialogGCS',
                            'options' => array(
                                'title' => '',
                                'autoOpen' => false,
                                'width' => 600,
                                'height' => 500,
                                'modal' => false,
                                //'hide'=>'explode',
                                'resizelable' => false,
                            ),
                        ));
                        ?>
                        <table>
                            <?php foreach ($modRJMetodeGSCM as $i => $item) :
                                if ($item->metodegcs_nilai == '') {
                                    echo "<tr bgcolor='#E5ECF9'>
										<td>" . $item->metodegcs_nama . "</td>
										<td>&nbsp;</td>    
									</tr>";
                                } else {
                                    echo "<tr>
										<td>" . $item->metodegcs_nama . "</td>
										<td><div id=\"divTombol\">" . CHtml::button($item->metodegcs_nilai, array(
                                        'class' => 'btn btn-prymari',
                                        'onclick' => 'SetNilai(this)',
                                        'id' => $item->metodegcs_singkatan,
                                    )) . "</div>
										</td>    
									</tr>";
                                }
                            endforeach; ?>
                        </table>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
        </fieldset>
        <?php /*
		<fieldset class="">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="panel-title">Tanda Vital Janin</div>
				</div>
				<div class="panel-body">
					<div id="divJanin" style="display: block">
						<div class="control-group">
							<?php echo $form->labelEx($modPemeriksaanFisik,'denyutjantung_janin', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textField($modPemeriksaanFisik, 'denyutjantung_janin', array('class'=>'span2 numbersOnly', 'style'=>'text-align: right;')); ?> /menit
							</div>
						</div>
						<div class="control-group">
							<?php echo $form->labelEx($modPemeriksaanFisik,'tinggifundus_uteri', array('class'=>'control-label')) ?>
							<div class="controls">
								<?php echo $form->textField($modPemeriksaanFisik, 'tinggifundus_uteri', array('class'=>'span2 numbersOnly', 'style'=>'text-align: right;')); ?> cm
							</div>
						</div>
					</div>
				</div>
			</div>
		</fieldset>
                 * 
                 */ ?>

    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php
        echo $this->renderPartial($this->path_view . "pemeriksaan/_integumen", array(
            'modIntegumen' => $modIntegumen,
            'form' => $form
        ), true);
        ?>
    </div>
</div>

<div class="row" hidden>
    <div class="col-sm-6">
        <?php echo $this->renderPartial($this->path_view . 'pemeriksaan._ews', array(
            'model' => $modPemeriksaanFisik, 'form' => $form
        ), true); ?>
    </div>
</div>

<div class="row" <?php echo $hide ?>>
    <div class="col-sm-6">
        <div class="panel panel-success panel_cgsews">
            <div class="panel-heading">
                <div class="panel-title"><?php echo $form->checkBox($modPemeriksaanFisik, 'thorax', array('class' => 'cek_ews', 'uncheckValue' => null)); ?><?php echo $headThorax; ?></div>
                <div class="panel-title dbnstyle">
                    <span><?php echo CHtml::checkBox("DbnTorax", '', array('onchange' => 'dbnTorax()')) . ' <label>DBN (Dalam Batas Normal)</label>' ?></span>
                </div>
            </div>
            <div class="panel-body">
                <?php
                if (!empty($hide)) {
                    echo $this->renderPartial($this->path_view . "pemeriksaan/_tandaVital", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);
                } else {
                    echo $this->renderPartial($this->path_view . "pemeriksaan/_thorax", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_cardio", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
    </div>

    <div class="clear"></div>

    <div class="col-sm-6" style="margin-top:17px">
        <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_pulmo", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>
    </div>

    <div class="col-sm-6" style="margin-top:17px">
        <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_abdomen", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>

    </div>

    <div class="clear"></div>

    <div class="col-sm-6" style="margin-top:17px">
        <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_obstetri", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>

    </div>

    <div class="col-sm-6" style="margin-top:17px">
        <?php echo $this->renderPartial($this->path_view . "pemeriksaan/rd/_genitalia", array('modPemeriksaanFisik' => $modPemeriksaanFisik, 'form' => $form), true);                                   ?>

    </div>

    <div class="clear"></div>

</div>


<div class="row" hidden>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    Jalan Nafas
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_paten', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_paten', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_obstruktifpartial', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_obstruktifpartial', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_obstruktifnormal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_obstruktifnormal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_stridor', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_stridor', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'jn_gargling', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'jn_gargling', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-lungs"></i> Pernapasan
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_normal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_normal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_kussmaul', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_kussmaul', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_takipnea', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_takipnea', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_retraktif', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_retraktif', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pgp_dangkal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'pgp_dangkal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-lungs"></i> Pernapasan Gerakan Dada
                </div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pgd_simetri', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'pgd_simetri', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'pgd_asimetri', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'pgd_asimetri', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Sirkulasi</div>
            </div>
            <div class="panel-body">
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'sirkulasi_nadicarotis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanFisik, 'sirkulasi_nadicarotis', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this)', 'style' => 'text-align:right')); ?> x/Menit
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'sirkulasi_nadiradialis', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modPemeriksaanFisik, 'sirkulasi_nadiradialis', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 3, 'onkeyup' => 'returnValue(this)', 'style' => 'text-align:right')); ?> x/Menit
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modPemeriksaanFisik, 'cfr_kecil_2', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->checkBox($modPemeriksaanFisik, 'cfr_kecil_2', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <= 2 </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'cfr_besar_2', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPemeriksaanFisik, 'cfr_besar_2', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                            >= 2
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_normal', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_normal', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_jaundice', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_jaundice', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_cyanosis', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_cyanosis', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_pucat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_pucat', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'kulit_berkeringat', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->checkBox($modPemeriksaanFisik, 'kulit_berkeringat', array('onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($modPemeriksaanFisik, 'akral', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->textArea($modPemeriksaanFisik, 'akral', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        //echo CHtml::htmlButton($modPemeriksaanFisik->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')) : 
        //Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="'.MyIcon::getIcons('simpan').'"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')).'&nbsp;'; 

        if ($modPemeriksaanFisik->isNewRecord) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan'));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
        }
        ?>
        <?php
        if ($modPemeriksaanFisik->isNewRecord) {
            //echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
            echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
        } else {
            //echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemeriksaanFisik();return false",'disabled'=>FALSE  ));
            echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Fisik', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPemeriksaanFisik();return false", 'disabled' => FALSE));
        }
        ?>
        <?php
        $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
        $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>
    <?php
    $diastolic = CHtml::activeId($modPemeriksaanFisik, 'td_diastolic');
    $js = <<< JS
//Di komen karna menggunakan onkeyup = returnValue
//if ($('#${diastolic}').val().length == 2){
//    $('#${diastolic}').val('0'+$('#${diastolic}').val());
//};
//    $('#${diastolic}').blur(function(){
//    var jumlahPanjang = $(this).val().length;
//    var tambah = '';
//    for (i=jumlahPanjang; i<3;i++){
//        tambah = tambah+'0';
//    }
//    $(this).val(tambah+$(this).val());
//    change($(this));
//});

   $('#namaGCS').attr('value',' - ');

$('#pemeriksaanFisik').attr('checked',true);
$('#divBagianYAngDiperiksa').slideToggle(500);
$('#pemeriksaanFisik').change(function(){
        if ($(this).is(':checked')){
                $('#divBagianYAngDiperiksa input').removeAttr('disabled');
                $('#divBagianYAngDiperiksa select').removeAttr('disabled');
        }else{
                $('#divBagianYAngDiperiksa input').attr('disabled','true');
                $('#divBagianYAngDiperiksa select').attr('disabled','true');
                $('#divBagianYAngDiperiksa input').attr('value','');
                $('#divBagianYAngDiperiksa select').attr('value','');
        }
        $('#divBagianYAngDiperiksa').slideToggle(500);
    });
//===============Awal untu Mengecek Form Sudah DiUbah Atw Belum====================    
    $(":input").keyup(function(event){
            $('#berubah').val('Ya');
         });
    $(":input").change(function(event){
            $('#berubah').val('Ya');
         });  
    $(":input").click(function(event){
            $('#berubah').val('Ya');
         });  
//================Akhir untuk Mengecek  Form Sudah DiUbah Atw Belum===================         
$('.groupUkurans').find('input').keyup(function(){
    gantiHidden();
    getBeratBadanIdeal();
    getBMI();
});

getBMI();
getText();
JS;
    Yii::app()->clientScript->registerScript('cekform', $js, CClientScript::POS_READY);
    ?>

    <?php
    // RND-5044 $urlgetMetodeGCS=Yii::app()->createUrl('ActionAjax/GetMetodeGCS');
    $urlgetMetodeGCS = $this->createUrl('GetMetodeGCS');
    $idTekananDarah = CHtml::activeId($modPemeriksaanFisik, 'tekanandarah');
    $systolic = CHtml::activeId($modPemeriksaanFisik, 'td_systolic');
    $diastolic = CHtml::activeId($modPemeriksaanFisik, 'td_diastolic');
    $idDetakNadi = CHtml::activeId($modPemeriksaanFisik, 'detaknadi');
    $getTextTekananDarah = Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/GetTextTekananDarah');
    $arteriPressure = CHtml::activeId($modPemeriksaanFisik, 'meanarteripressure');
    $beratBadan = CHtml::activeId($modPemeriksaanFisik, 'beratbadan_kg');
    $tinggiBadan = CHtml::activeId($modPemeriksaanFisik, 'tinggibadan_cm');
    $jenisKelamin = CHtml::activeId($modPasien, 'jenis_kelamin');
    $jenisKelaminPerempuan = Params::JENIS_KELAMIN_PEREMPUAN;
    $beratBadanIdeal = CHtml::activeId($modPemeriksaanFisik, 'bb_ideal');
    $getBMIText = Yii::app()->createUrl('rawatJalan/pemeriksaanFisik/getBMIText');
    // RND-5044 $getfromDevice = Yii::app()->createUrl('actionAjax/getfromDevice');
    $getfromDevice = $this->createUrl('getfromDevice');
    $js = <<< JS
//==================================================Validasi===============================================
//*Jangan Lupa untuk menambahkan hiddenField dengan id "berubah" di setiap form
//* hidden field dengan id "url"
//*Copas Saja hiddenfield di Line 36 dan 35
//* ubah juga id button simpannya jadi "btn_simpan"

function palidasiForm(obj)
{
    var berubah = $('#berubah').val();
    if(berubah=='Ya'){
        myConfirm("Apakah Anda Akan menyimpan Perubahan Yang Sudah Dilakukan?","Perhatian!",function(r) {
            if(r){
                $('#url').val(obj);
                $('#btn_simpan').click();
            }
        });
    }      
}

function ubahWarna(obj)   
{ 
    $(obj).attr("class","btn btn-success");
}

function kembaliWarna(obj)
{
   $(obj).attr("class","btn");
}

function SetNilai(obj)
{
    idTombol=obj.id;
    valueGCS=obj.value;
    i=0;
    if(idTombol=='E'){
        $('#RJPemeriksaanFisikT_gcs_eye').val(valueGCS);
    }else if(idTombol=='M'){
        $('#RJPemeriksaanFisikT_gcs_motorik').val(valueGCS);
    }else if(idTombol=='V'){
        $('#RJPemeriksaanFisikT_gcs_verbal').val(valueGCS);
    } 
    
    $('#divTombol #'+idTombol).each(function() {
        $(this).attr("class","btn"); 
    });

//    jumlah=$('#divTombol #'+idTombol).length;

$(obj).attr("class","btn btn-success"); 
    $(obj).removeAttr('onmouseout');
    $(obj).removeAttr('onmouseover');

    hitungCGS();
}

function hitungCGS()
{
    gcs_eye =  $('#RJPemeriksaanFisikT_gcs_eye').val();
    gcs_motorik =  $('#RJPemeriksaanFisikT_gcs_motorik').val();
    gcs_verbal =  $('#RJPemeriksaanFisikT_gcs_verbal').val();    
    if((gcs_eye!='') && (gcs_motorik!='') &&(gcs_verbal!='')){
        $.post("${urlgetMetodeGCS}",{gcs_eye: gcs_eye,gcs_motorik:gcs_motorik,gcs_verbal:gcs_verbal},
        function(data){
               if(data.pesan==null){
                $('#RJPemeriksaanFisikT_gcs_id').val(data.idGCS);
                 $('#RJPemeriksaanFisikT_namaGCS').val(data.nilai);
               }else{
                $('#RJPemeriksaanFisikT_gcs_id').val(data.idGCS);
                 $('#RJPemeriksaanFisikT_namaGCS').val(data.nilai);
                // myAlert(data.pesan);
               }    
        },"json");
    }
}    

function getTekananDarah(obj){
    var hasil = $(obj).val();
    var data = hasil.split(' / ');

    data[0] = data[0].replace(/_/gi, "0");
    data[1] = data[1].replace(/_/gi, "0");
    $('#${systolic}').val(data[0]);
    $('#${diastolic}').val(data[1]);
}
    
function returnValue(obj){
    var value = $(obj).val();
    var attrID = $(obj).attr('id');
    var td = $('#${idTekananDarah}').val();
    var splitTD = td.split(' / ');
    
    if (attrID == '${diastolic}'){
        splitTD[0] = splitTD[0].replace(/_/gi, "0");
        $('#${idTekananDarah}').val(splitTD[0]+' / '+value);
    }
    else if (attrID == '${systolic}'){
        splitTD[1] = splitTD[1].replace(/_/gi, "0");
        $('#${idTekananDarah}').val(value+' / '+splitTD[1]);
    }
}

function change(obj){
    var value = $(obj).val();
    var hasil = value.replace(/_/gi, "0");
    
    if (value == ''){
        $(obj).val('000 / 000')
    }else{
        $(obj).val(hasil);
        returnValue(obj);
    }
    
}

function getText(){
    var dias = parseFloat($('#${diastolic}').val());
    var sys = parseFloat($('#${systolic}').val());
    var arteri = ((sys+(2*dias))/3);
    
    if (jQuery.isNumeric(dias)){
        if (jQuery.isNumeric(sys)){
            $.post('${getTextTekananDarah}', {diastolic:dias, systolic:sys}, function(data){
                if (data.text == null){
                    $('#tekananDarah').val('Tekanan Darah Tidak Ditemukan');
                } else {
                    $('#tekananDarah').val(data.text);
                }
            },'json');
            $('#${arteriPressure}').val(arteri.toFixed(2));
        }
    }
}

function gantiJumlah(obj){
    var value = parseFloat($(obj).val());
    var teman = $(obj).parent('.groupUkurans').find('input[type="text"]');
    var valueTeman = parseFloat(teman.val());
    var hasil;

    hasil = valueTeman*value;
    teman.val(hasil);
}

function gantiHidden(){
    var defaultBB = parseFloat(0.001);
    var defaultTB = parseFloat(100);
    var valueBB = parseFloat($('#${beratBadan}').val());
    var valueTB = parseFloat($('#${tinggiBadan}').val());

    if ($('#gram').val() != defaultBB){
        $('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB*defaultBB);
    }
    else{
        $('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueBB);
    }
    
    if ($('#meter').val() != defaultTB){
        $('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB*defaultTB);
    }
    else{
        $('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val(valueTB);
    }
}            
            
function getBeratBadanIdeal(){
    var beratBadan = parseFloat($('#${beratBadan}').val());
    var tinggiBadan = parseFloat($('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var jenisKelamin = $('#${jenisKelamin}').val();
    var hasil;
    if (jenisKelamin == "${jenisKelaminPerempuan}"){
        hasil = (tinggiBadan - 100) - ((15/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#${beratBadanIdeal}').val(hasil);
    }
    else{
        hasil = (tinggiBadan - 100) - ((10/100)*(tinggiBadan-100));
        if (hasil < 0){
            hasil = 0;
        }
        $('#${beratBadanIdeal}').val(hasil);
    }
}

function getBMI(){
    var beratBadan = parseFloat($('#${beratBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var tinggiBadan = parseFloat($('#${tinggiBadan}').parent('.groupUkurans').find('input[type="hidden"]').val());
    var hasil;
    
    hasil = (beratBadan/((tinggiBadan*tinggiBadan)/10000));
    if (jQuery.isNumeric(hasil)){
        $.post('${getBMIText}', {bmi:hasil}, function(data){
            $('#imt').val(data.text);
            $('#imtValue').val(Math.floor(hasil));
        },'json');
    }
}

function getfromDevice(){
    $.post('${getfromDevice}',{},function(dataz){
        $('#${idDetakNadi}').val(dataz.detaknadi);
        $('#${idTekananDarah}').val(dataz.tekanandarah);
        $('#${systolic}').val(dataz.sys);
        $('#${diastolic}').val(dataz.dias);
            getText();
    }, 'json');
    
    
}

  function ceklisCGSEWS() {
            $(".cek_ews").each(function() {
                $(this).parents(".panel_cgsews")
                    .find(".panel-body").hide()
                    .find(":input").prop("disabled", true);
                if ($(this).is(":checked")) {
                    $(this).parents(".panel_cgsews")
                        .find(".panel-body").show()
                        .find(":input").prop("disabled", false);

                }
            });
        }

        $(document).ready(function() {
            $(".cek_ews").on("click", ceklisCGSEWS);
            ceklisCGSEWS();
        });
JS;
    Yii::app()->clientScript->registerScript('validasi', $js, CClientScript::POS_HEAD);

    $js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9.]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9.].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
    Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
    ?>
    <?php echo $this->renderPartial($this->path_view . '_jsFunctions', array(
        'modPendaftaran' => $modPendaftaran,
        'modPemeriksaanFisik' => $modPemeriksaanFisik,
        'modBagianTubuh' => $modBagianTubuh,
        'modPemeriksaanGambar' => $modPemeriksaanGambar
    )); ?>
    <script>
           $(document).ready(function() {
           var pegawai = jQuery('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'pegawai_id') ?>');	
           jQuery(pegawai).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();


       });


       $(document).ready(function() {
           var ppds = jQuery('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'ppds_id') ?>');	
           jQuery(ppds).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();

       });


       $(document).ready(function() {
           var perawat = jQuery('#<?php echo CHtml::activeId($modPemeriksaanFisik, 'paramedis_nama') ?>');	
           jQuery(perawat).multiselect({
                   includeSelectAllOption: false,
                   buttonClass: "form-control",
                   maxHeight: 300,
                   buttonWidth: '182px',
                   enableCaseInsensitiveFiltering: true
           }).hide();

           $('#RJPemeriksaanFisikT_gcs_eye').change();
           $('#RJPemeriksaanFisikT_gcs_verbal').change();
           $('#RJPemeriksaanFisikT_gcs_motorik').change();

       });


    function searchDokter() {
            $('#rjpemeriksaan-fisik-t-form input[name*="pegawai_id"]').each(function() {
            });
    }

    function searchPPDS() {
            $('#rjpemeriksaan-fisik-t-form input[name*="ppds_id"]').each(function() {
            });
    }

    function searchPerawat() {
            $('#rjpemeriksaan-fisik-t-form input[name*="paramedis_nama"]').each(function() {
            });
    }
    </script>