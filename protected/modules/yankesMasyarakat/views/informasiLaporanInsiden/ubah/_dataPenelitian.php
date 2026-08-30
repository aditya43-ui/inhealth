<?php
    if (isset($_GET['seriousae_id'])) {
        $sae = SeriousaeT::model()->findByPk($_GET['seriousae_id']);
        $sampel = SampelhumansubjectT::model()->findByAttributes(array('sampelhumansubject_id' => $sae->sampelhumansubject_id));
    }
    if (isset($_GET['adverseevent_id'])) {
        $adverse = AdverseeventT::model()->findByPk($_GET['adverseevent_id']);
        $sampel = SampelhumansubjectT::model()->findByAttributes(array('sampelhumansubject_id' => $adverse->sampelhumansubject_id));
    }
    $penelitian = PenelitianM::model()->findByAttributes(array('penelitian_id' => $sampel->penelitian_id));
    $golongan = GolonganpenelitianM::model()->findByAttributes(array('golonganpenelitian_id' => $penelitian->golonganpenelitian_id));
    $jenis = JenispenelitianM::model()->findByAttributes(array('jenispenelitian_id' => $penelitian->jenispenelitian_id));
    $penelitian_id = $penelitian->penelitian_id; 
    
    $peneliti_nama = " ";
    $instalasi_nama = " ";
    $criteria = new CDbCriteria();
    $criteria->addCondition('anggotapenelitian_ketua = true');
    $criteria->addCondition('penelitian_id = '.$penelitian_id);
    $anggota = AnggotapenelitianM::model()->findAll($criteria);
    foreach ($anggota as $item){
        $pen = PenelitiM::model()->findByPk($item->peneliti_id);
        $instalasi = InstalasiM::model()->findByPk($pen->instalasi_id);
        if (!empty($pen->instalasi_id)) {
            $instalasi_nama .= $instalasi->instalasi_nama;
        } else {
            $instalasi_nama .= " ";
        }
        $peneliti_nama .= $pen->peneliti_nama;
    }
    
    $kategoripenelitian_nama = "";
            $kategori = KategoripenelitianPenelitianM::model()->findAllByAttributes(array(
                'penelitian_id'=>$penelitian_id,
            ));

    foreach ($kategori as $item) {
        $kat = KategoripenelitianM::model()->findByPk($item->kategoripenelitian_id);
        $kategoripenelitian_nama .= "- ".$kat->kategoripenelitian_nama."\n";
    }
?>
<div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b> Penelitian </b></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                            <?php echo CHtml::label('Penelitian <span class="required">*</span>', 'penelitian_id', array('class' => 'control-label required')) ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($penelitian,'penelitian_nomor',array('class'=>'span4', 'readonly'=>true)); ?>

                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Ketua Penelitian', 'ketua_penelitian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField("ketua_penelitian", $peneliti_nama, array(
                                        'readonly'=>true, 
                                        'class'=>'span3',
                                        'rows'=>4,
                                        'onblur'=>'return false;',
                                        )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Instalasi / Departemen', 'instalas_penelitiani', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textField("ketua_penelitian", $instalasi_nama, array(
                                        'readonly'=>true, 
                                        'class'=>'span3',
                                        'rows'=>4,
                                        'onblur'=>'return false;',
                                        )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Golongan Penelitian', 'golongan_penelitian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($golongan,'golonganpenelitian_nama',array('class'=>'span4', 'readonly'=>true)); ?>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group">
                            <?php echo CHtml::label('Judul Penelitian', 'judul_penelitian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($penelitian,'penelitian_id',array('class'=>'span3', 'readonly' => true, 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?> 
                                <?php echo CHtml::activeTextArea($penelitian,'judul_penelitian',array('class'=>'span4', 'readonly'=>true, 'style'=>'height: 80px;')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Kategori Penelitian', 'kategori_penelitian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::textArea("kategori_penelitian", $kategoripenelitian_nama, array(
                                        'readonly'=>true, 
                                        'class'=>'span3',
                                        'rows'=>4,
                                        'onblur'=>'return false;',
                                        )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Penelitian', 'jenis_penelitian', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo CHtml::activeTextField($jenis,'jenispenelitian_nama',array('class'=>'span4', 'readonly'=>true)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>


<?php
//========= Dialog buat cari Penelitian =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPenelitian',
    'options' => array(
        'title' => 'Daftar Penelitian',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 660,
        'resizable' => false,
    ),
));
?>
<?php
    $modPenelitian = new PenelitianM('search');
    $modPenelitian->unsetAttributes();
    $modPenelitian->penelitian_aktif = true;
    if(isset($_GET['PenelitianM'])) {
        $modPenelitian->attributes = $_GET['PenelitianM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',
        array(
            'id'=>'penelitian-m-grid',
            'dataProvider'=>$modPenelitian->search(),
            'filter'=>$modPenelitian,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $attr = CJSON::encode($data->attributes);
                        return CHtml::link('<i class="icon-form-check"></i>', '#', array(
                            'class'=>'btn-small',
                            'id'=>'selectRuangan',
                            'onclick'=>"inputPenelitian(".$data->penelitian_id."); $('#dialogPenelitian').dialog('close'); return false;"
                        ));
                    },
                ),
                'judul_penelitian',
                array(
                    'header'=>'Nomor Penelitian',
                    'type'=>'raw',
                    'name'=>'penelitian_nomor',
                    'value'=>function($data) {
                        if(!empty($data->penelitian_nomor)){
                            return $data->penelitian_nomor;
                        }else{
                            return "-";
                        }
                    },
                ),
                 array(
                    'header'=>'Nomor Surat Ijin Penelitian',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $modIjin = SuratijinpenelitianM::model()->findByAttributes(array('penelitian_id'=>$data->penelitian_id));
                        if(!empty($modIjin->suratijinpenelitian_id)){
                            return $modIjin->suratijinpenelitian_nomor;
                        }else{
                            return "-";
                        }
                    },
                ),
                 array(
                    'header'=>'Ketua',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $modAnggota = AnggotapenelitianM::model()->findByAttributes(array('penelitian_id'=>$data->penelitian_id,'anggotapenelitian_ketua'=>true));
                        if(!empty($modAnggota->anggotapenelitian_id)){
                            $modPeneliti = PenelitiM::model()->findByPk($modAnggota->peneliti_id);
                            return $modPeneliti->peneliti_nama;
                        }else{
                            return "-";
                        }
                    },
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )
);
$this->endWidget();
?>
