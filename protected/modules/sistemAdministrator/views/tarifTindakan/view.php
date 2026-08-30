<div class="white-container">
    <legend class="rim2">Lihat <b>Nominal Tarif</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Nominal Tarif'=>array('index'),
            $model->tariftindakan_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tarif Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tarif Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tarif Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Update').' Tarif Tindakan', 'icon'=>'pencil','url'=>array('update','id'=>$model->tariftindakan_id))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Delete').' Tarif Tindakan','icon'=>'trash','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->tariftindakan_id),'confirm'=>Yii::t('mds','Are you sure you want to delete this item?')))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tarif Tindakan', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu=$arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'satarif-tindakan-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#kategoritindakan',
    )); ?>
    <table class="table">
            <tr>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Perda Tarif','perda_tarif',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('perda',  $model->perdanama_sk,array('class'=>'span3', 'readonly'=>TRUE, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Tarif','jenis_tarif',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('jenistarif',  $model->jenistarif_nama,array('class'=>'span3', 'readonly'=>TRUE, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Kategori Tindakan','kategori_tariftindakan',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('daftartindakan',  $model->kategoritindakan_nama,array('class'=>'span3', 'readonly'=>TRUE, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Daftar Tindakan','daftar_tariftindakan',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('daftartindakan',  $model->daftartindakan_nama,array('class'=>'span3', 'readonly'=>TRUE, 'onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('Kelas Pelayanan','kelaspelayanan',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('kelaspelayanan_id', $model->kelaspelayanan_nama,array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE)) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Persen Keringanan','persen_diskon',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('persendiskon_tind', $model->persendiskon_tind,array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE,'style' => 'text-align:right')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Harga Keringanan','harga_diskon',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('hargadiskon_tind', $model->hargadiskon_tind,array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE,'style' => 'text-align:right')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Persen Cyto','persen_cyto',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php echo CHtml::textfield('persencyto_tind', $model->persencyto_tind,array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE,'style' => 'text-align:right')) ?>
                        </div>
                    </div>
                    <!-- <div class="control-group">
                        <?php //echo CHtml::label('Dibuat Oleh','nama_pemakai',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php //echo CHtml::textfield('nama_pemakai', strtoupper($model->nama_pemakai),array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE)) ?>
                        </div>
                    </div> -->
                     <!-- <div class="control-group">
                        <?php //echo CHtml::label('Tanggal Dibuat','create_time',array('class'=>"control-label")) ?>
                        <div class="controls">
                            <?php //echo CHtml::textfield('create_time', date('Y-m-d h:i:s', strtotime($model->create_time)) ,array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE)) ?>
                        </div>
                    </div> -->
                      <!-- <div class="control-group">
                        <?php //echo CHtml::label('Diupdate Oleh','nama_pemakai_update',array('class'=>"control-label required")) ?>
                        <div class="controls">
                            <?php //echo CHtml::textfield('nama_pemakai_update', strtoupper($model->nama_pemakai_update),array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE)) ?>
                        </div>
                    </div> -->
                     <!-- <div class="control-group">
                        <?php //echo CHtml::label('Tanggal Diupdate','update_time',array('class'=>"control-label")) ?>
                        <div class="controls">
                            <?php //echo CHtml::textfield('update_time', date('Y-m-d h:i:s', strtotime($model->update_time)) ,array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE)) ?>
                        </div>
                    </div> -->
                      <!-- <div class="control-group">
                        <?php //echo CHtml::label('Ruangan Dibuat','ruangan_dibuat_nama',array('class'=>"control-label")) ?>
                        <div class="controls">
                            <?php //echo CHtml::textfield('ruangan_dibuat_nama',$model->ruangan_dibuat_nama,array('onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>TRUE)) ?>
                        </div>
                    </div> -->
                </td>
            </tr>
        </table>
        <table width="100%" class="table table-striped table-condensed" id="tblInputTarifTindakan">
            <thead>
                <tr>
                    <th>Komponen Tarif</th>
                    <th>Nominal Tarif</th>
                </tr>
            </thead>
            <tbody>
                <?php
                     foreach ($modKomponenTarif as $tind) {
                        echo  '<tr><td>'.KomponentarifM::model()->findByPk($tind->komponentarif_id)->komponentarif_nama.'</td>';
                        /*
                         * Kondisi untuk menentukan textfield dari komponentarif total harga dan yang komponen tarif biasa
                         */
                        if ($tind->komponentarif_id == Params::KOMPONENTARIF_ID_TOTAL) {
                            $textField = CHtml::textField('totaltariftindakan',  number_format($tind->harga_tariftindakan,0,'','.'),array("readonly"=>TRUE,'style' => 'text-align:right'));
                        }else
                        {
                            $textField = CHtml::textField('hargatariftindakan[]',number_format($tind->harga_tariftindakan,0,'','.'),array("readonly"=>TRUE,'onkeypress'=>"return $(this).focusNextInputField(event)",'style' => 'text-align:right'));
                        }

                        echo '<td>'.$textField.'</td>';
                    }
                ?>
            </tbody>
        </table>
    <?php $this->endWidget() ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Nominal Tarif', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
    $this->widget('UserTips',array('type'=>'view'));?>
</div>
