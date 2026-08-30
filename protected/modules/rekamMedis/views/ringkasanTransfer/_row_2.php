<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    <i></i> Data Pasien Saat Akan Ditransfer
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid" style="border-bottom: 1px solid black">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Tanggal Transfer</label>
                            <div class="controls">
                                <?php
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modelTransfer,
                                    'attribute' => 'tgl_transfer',
                                    'mode' => 'datetime',
                                    'options' => array(
                                        'dateFormat' => Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                        'onClose' => 'js:function(){hitungPerawatan()}',
                                        'sideBySide' => true,
                                    ),
                                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker2-5 tgl_transfer span4', 'style' => 'width:150px;'),
                                ));
                                ?>
                                <?php echo $form->error($modelTransfer, 'tgl_transfer'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Dokter yang merawat</label>
                            <div class="controls">
                                <?php
                                    echo $form->hiddenField($modelTransfer, 'dokter_id',['class'=>'dokter_id']);
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modelTransfer,
                                        'attribute' => 'dokter_nama',
                                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                        })
                                        }',
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 2,
                                            'focus' => 'js:function( event, ui ) {
                                                $(this).val("");
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                $(".dokter_id").val(ui.item.pegawai_id);
                                                $(".dokter_nama").val(ui.item.namaLengkap);                                
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'class'=>'dokter_nama span4',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogDokter'),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Petugas Pendamping 1</label>
                            <div class="controls">
                                <?php
                                    echo $form->hiddenField($modelTransfer, 'pendamping1_id',['class'=>'pendamping1_id']);
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modelTransfer,
                                        'attribute' => 'pendamping1_nama',
                                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                        })
                                        }',
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 2,
                                            'focus' => 'js:function( event, ui ) {
                                                $(this).val("");
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                $(".pendamping1_id").val(ui.item.pegawai_id);
                                                $(".pendamping1_nama").val(ui.item.namaLengkap);                                
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'class'=>'pendamping1_nama span4',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPendamping1'),
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Petugas Pendamping 2</label>
                            <div class="controls">
                                <?php
                                    echo $form->hiddenField($modelTransfer, 'pendamping2_id',['class'=>'pendamping2_id']);
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modelTransfer,
                                        'attribute' => 'pendamping2_nama',
                                        'source' => 'js: function(request, response) {
                                        $.ajax({
                                            url: "' . $this->createUrl('/actionAutoComplete/dropPetugasRuangan') . '",
                                            dataType: "json",
                                            data: {
                                                term: request.term,
                                                ruangan_id: '.Yii::app()->user->getState('ruangan_id').'
                                            },
                                            success: function (data) {
                                                response(data);
                                            }
                                        })
                                        }',
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 2,
                                            'focus' => 'js:function( event, ui ) {
                                                $(this).val("");
                                                return false;
                                            }',
                                            'select' => 'js:function( event, ui ) {
                                                $(".pendamping2_id").val(ui.item.pegawai_id);
                                                $(".pendamping2_nama").val(ui.item.namaLengkap);                                
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'class'=>'pendamping2_nama span4',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPendamping2'),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid" style="border-bottom: 1px solid black">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Indikasi MRS</label>
                            <div class="controls">
                                <?php 
                                    echo $form->textArea($modelTransfer,'indikasimrs',array('rows'=>4, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Alasan Transfer</label>
                            <div class="controls">
                                <?php 
                                    echo $form->textArea($modelTransfer,'alasantransfer',array('rows'=>4, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Derajat Pasien</label>
                            <div class="controls">
                                <?php echo CHtml::activeRadioButtonList($modelTransfer, 'derajatpasien', array('Nol' => 'Nol', 'Satu' => 'Satu', 'Dua' => 'Dua', 'Tiga' => 'Tiga'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '  ')); ?>       
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Cara Transfer</label>
                            <div class="controls">
                                <?php echo CHtml::activeRadioButtonList($modelTransfer, 'caratransfer', array('Jalan Sendiri' => 'Jalan Sendiri', 'Kursi Roda' => 'Kursi Roda', 'Brankar' => 'Brankar'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '<br>')); ?>       
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-fluid" style="border-bottom: 1px solid black">
                    <h4><b>KONDISI PASIEN SAAT AKAN DITRANSFER</b></h4>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Diagnosa</label>
                            <div class="controls">
                                <?php 
                                    echo $form->textArea($modelTransfer,'diagnosa',array('rows'=>4, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Anamnesa</label>
                            <div class="controls">
                                <?php 
                                    echo $form->textArea($modelTransfer,'ditransfer_anamnesa',array('rows'=>4, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Kesadaran</label>
                            <div class="controls">
                                <?php echo CHtml::activeRadioButtonList($modelTransfer, 'ditransfer_kesadaran', array('Compos Mentis' => 'Compos Mentis', 'Delirium' => 'Delirium', 'Somnolen' => 'Somnolen', 'Apatis' => 'Apatis', 'Sopor' => 'Sopor', 'Koma' => 'Koma'), array('labelOptions' => array('style' => 'display:inline'), 'separator' => '<br>')); ?>       
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Tekanan Darah</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'ditransfer_sistolik',['class'=>'span2 integer']) ?> / <?php echo $form->textField($modelTransfer, 'ditransfer_diastolik',['class'=>'span2 integer']) ?> mmHg
                            </div>
                        </div>   
                        <div class="control-group">
                            <label class="control-label">Pernafasan</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'ditransfer_pernapasan',['class'=>'span4 integer']) ?> x/mnt
                            </div>
                        </div>   
                        <div class="control-group">
                            <label class="control-label">Nadi</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'ditransfer_nadi',['class'=>'span4 integer']) ?> x/mnt
                            </div>
                        </div>   
                        <div class="control-group">
                            <label class="control-label">Suhu</label>
                            <div class="controls">
                                <?php echo $form->textField($modelTransfer, 'ditransfer_suhu',['class'=>'span4 float']) ?> &#176;C
                            </div>
                        </div>   
                        <div class="control-group ">
                            <label class="control-label">GCS</label>
                            <div class="controls">
                                <label>E</label>
                                <?php
                                $crit = new CDbCriteria();
                                $crit->compare('LOWER(metodegcs_singkatan)', "e");
                                $crit->addCondition('metodegcs_nilai is not null');
                                $crit->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList($modelTransfer, 'ditransfer_gcs_eye', CHtml::listData(MetodegcsM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => ''));
                                ?> 
                            </div>
                        </div> 
                        <div class="control-group ">
                            <label class="control-label"></label>
                            <div class="controls">
                                <label>V</label>
                                <?php
                                $crit3 = new CDbCriteria();
                                $crit3->compare('LOWER(metodegcs_singkatan)', "v");
                                $crit3->addCondition('metodegcs_nilai is not null');
                                $crit3->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList($modelTransfer, 'ditransfer_gcs_verbal', CHtml::listData(MetodegcsM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => ''));
                                ?>
                            </div>
                        </div> 
                        <div class="control-group ">
                            <label class="control-label"></label>
                            <div class="controls">
                                <label>M</label>
                                <?php
                                $crit2 = new CDbCriteria();
                                $crit2->compare('LOWER(metodegcs_singkatan)', "m");
                                $crit2->addCondition('metodegcs_nilai is not null');
                                $crit2->order = 'metodegcs_nilai ASC';
                                echo $form->dropDownList($modelTransfer, 'ditransfer_gcs_motorik', CHtml::listData(MetodegcsM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => ''));
                                ?>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="row-fluid">
                    <h4><b>OBAT YANG TELAH DIBERIKAN</b></h4>
                    <div class="col-sm-12">
                        <table class="items table table-striped table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Dosis</th>
                                    <th>Cara Pemberian</th>
                                    <th>Signa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $modPendaftaran = PendaftaranT::model()->findByPk($_GET['pendaftaran_id']);
                                    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
                                    $modPencatatan = ObatalkespasienT::model()->findAllByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id));
                                    if (!empty($modPencatatan)) { 
                                ?>
                                    <?php
                                        $pendaftaran_id = $_GET['pendaftaran_id'];
                                        foreach($modPencatatan as $mp => $val){
                                    ?>
                                    <tr>
                                        <td><?php echo $val->obatalkes->obatalkes_nama ?></td>
                                        <td><?php echo $val->kekuatan_oa ?> <?php echo $val->satuankekuatan_oa ?></td>
                                        <td><?php echo $val->ket_penggunaan ?></td>
                                        <td><?php echo $val->signa_oa ?></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4">Data tidak ditemukan</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>