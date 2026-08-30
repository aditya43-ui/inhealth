<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pemeriksaan Rongga Mulut
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'periksaronggamulut-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>
        <div class="col-sm-6">
            <div class="panel panel-success">
                <div class="panel-body" style="width:412px !important;">
                    <?php
                    $i = 1;
                    $gbrTubuh = $modGambarTubuh->allDataGambarRonggaMulut;
                    foreach ($gbrTubuh as $tbh) {
                        if ($i == 1) {
                            $css = " 
								#imgtag" . $tbh->gambartubuh_id . "
								{
										position: relative;
										min-width: 300px;
										min-height: 300px;
										float: none;
										border: 3px solid #FFF;
										cursor: crosshair;
										text-align: center;
										z-index:10 !important;
								}
								#tagit" . $tbh->gambartubuh_id . "
								{
										position: absolute;
										top: 0;
										left: 0;
										width: 400px;
										border: 1px solid #D7C7C7;
										z-index: 10;
								}
								#tagit" . $tbh->gambartubuh_id . " .name
								{
										/*float: left;*/
										background-color: #FFF;
										width: 395px;
										/*height: 92px;*/
										/*padding: 5px;*/
										font-size: 10pt;
										margin:0 auto;
										margin-bottom: 0 auto;
								}
								#tagit" . $tbh->gambartubuh_id . " DIV.text
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
								{
										margin-bottom: 5px;
								}
								#tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
								{
										width: 110px;
								}";
                    ?>
                            <!--<div align="center" id="imgtag">
									<img img-no="" alt="<?php //echo $tbh->gambartubuh_id 
                                                        ?>"  id="myImgId" src="<?php //echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; 
                                                                                                                    ?>" class="taggd"/> 
							<div id="tagbox"></div>
							</div>-->
                            <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                                <!--<img img-no="<?php // echo $tbh->gambartubuh_id 
                                                    ?>" alt="<?php // echo $tbh->gambartubuh_id 
                                                                                                ?>" id="myImgId<?php // echo $tbh->gambartubuh_id 
                                                                                                                                                ?>" src="<?php // echo Params::urlPhotoAnatomiTubuh().$tbh->nama_file_gbr; 
                                                                                                                                                                                            ?>" class="taggd<?php // echo $tbh->gambartubuh_id 
                                                                                                                                                                                                                                                                                ?>" style="width:480px;"/>-->
                                <img img-no="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $tbh->gambartubuh_id ?>" src="<?php echo Params::urlPhotoAnatomiTubuh() . $tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" data-id="<?php echo $tbh->gambartubuh_id; ?>" />
                                <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                            </div>
                        <?php
                        } else {

                            //if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_RD ||  Yii::app()->user->getState('modul_id') == Params::MODUL_ID_PERSALINAN){
                            $css .= " 
                                #imgtag" . $tbh->gambartubuh_id . "
                                {
                                        position: relative;
                                        min-width: 300px;
                                        min-height: 300px;
                                        float: none;
                                        border: 3px solid #FFF;
                                        cursor: crosshair;
                                        text-align: center;
										z-index:10 !important;
                                }
                                #tagit" . $tbh->gambartubuh_id . "
                                {
                                        position: absolute;
                                        top: 0;
                                        left: 0;
                                        width: 300px;
                                        border: 1px solid #D7C7C7;
                                        z-index: 10;
                                }
                                #tagit" . $tbh->gambartubuh_id . " .name
                                {
                                        /*float: left;*/
                                        background-color: #FFF;
                                        width: 295px;
                                        /*height: 92px;*/
                                        /*padding: 5px;*/
                                        font-size: 10pt;
                                        margin:0 auto;
                                        margin-bottom: 0 auto;
                                }
                                #tagit" . $tbh->gambartubuh_id . " DIV.text
                                {
                                        margin-bottom: 5px;
                                }
                                #tagit" . $tbh->gambartubuh_id . " INPUT[type=text]
                                {
                                        margin-bottom: 5px;
                                }
                                #tagit" . $tbh->gambartubuh_id . " #tagname" . $tbh->gambartubuh_id . "
                                {
                                        width: 110px;
                                }";
                        ?>
                            <div align="center" id="imgtag<?php echo $tbh->gambartubuh_id ?>">
                                <img img-no="<?php echo $tbh->gambartubuh_id ?>" alt="<?php echo $tbh->gambartubuh_id ?>" id="myImgId<?php echo $i ?>" src="<?php echo Params::urlPhotoAnatomiTubuh() . $tbh->nama_file_gbr; ?>" class="taggd<?php echo $tbh->gambartubuh_id ?>" style="width:480px;" />
                                <div id="tagbox<?php echo $tbh->gambartubuh_id ?>"></div>
                            </div>
                    <?php
                        }
                        //}
                        $i++;
                    }
                    Yii::app()->clientScript->registerCss('anatomi', $css);
                    ?>
                    <?php /*
					<div align="center" id="imgtag">
						<img id="myImgId" src="<?php echo Params::urlPhotoAnatomiTubuh().$modGambarTubuh->FileNameGambar; ?>" class="taggd"/> 
						<div id="tagbox"></div>
					</div>
                     * 
                     */ ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglperiksaronggamulut', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglperiksaronggamulut',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true, 'class' => 'span3 dtPicker3',
                            'onkeypress' => "return $(this).focusNextInputField(event)"
                        ),
                    )); ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData(
                        PemeriksaanfisikT::model()->getDokterItems(Yii::app()->user->getState('ruangan_id')),
                        'pegawai_id',
                        'namaLengkap'
                    ), array('empty' => '-- Pilih --')); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Pemeriksaan</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="items table table-bordered table-striped table-condensed" id="table-bagtubuh">
                        <thead>
                            <tr>
                                <th width='30'>No.</th>
                                <th>Bagian Rongga Mulut</th>
                                <th>Bentuk Lesi</th>
                                <th>Keterangan</th>
                                <th width='80'>Batal / Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($modPemeriksaanGambar)) {
                                $i = 1;
                                $a = 0;
                                foreach ($modPemeriksaanGambar as $ii => $vv) {
                                    $vv->namabagtubuh = $vv->bagiantubuh->namabagtubuh;
                                    $vv->kordinat_tubuh_x = number_format($vv->kordinat_tubuh_x, 7);
                                    $vv->kordinat_tubuh_y = number_format($vv->kordinat_tubuh_y, 7);

                                    //var_dump($vv->kordinat_tubuh_y);
                                    echo $this->renderPartial($this->path_view . "_rowDetail", array('modPemeriksaanGbr' => $vv, 'i' => $i, 'a' => $a), true);
                                    $i++;
                                    $a++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')
            ) . '&nbsp;';
            if ($model->isNewRecord) {
                //echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Rongga Mulut', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
            } else {
                //echo CHtml::link(Yii::t('mds', '{icon} Print Pemeriksaan Rongga Mulut', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printPemeriksaanFisik();return false",'disabled'=>FALSE  ));
            }
            ?>
            <?php
            $content = $this->renderPartial('rawatJalan.views.tips.tips', array(), true);
            $this->widget('UserTips', array('type' => 'admin', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modPendaftaran' => $modPendaftaran,
    'model' => $model,
    'modBagianTubuh' => $modBagianTubuh,
    'modPemeriksaanGambar' => $modPemeriksaanGambar
)); ?>