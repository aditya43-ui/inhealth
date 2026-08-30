<div class="row" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading" style="display: flex;">
                <div class="panel-title">
                    <i></i> Form Pencatatan Dokter Penanggung Jawab Pelayanan (DPJP)
                </div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group ">
                            <label class="control-label">Tanggal</label>
                            <div class="controls">
                                <?php
                                    $this->widget('MyDateTimePicker', array(
                                        'model' => $modPencatatan,
                                        'attribute' => 'tanggal',
                                        'value' => null,
                                        'mode' => 'datetime',
                                        'options' => array(
                                            'dateFormat' => Params::DATE_FORMAT,
                                            // 'minDate' => 'd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'class' => 'span3 htpd',
                                            'placeholder' => date('d M Y H:i:s'),
                                            // 'disabled' => $jenis == 'lihat',
                                        ),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Nama Karyawan</label>
                            <div class="controls">
                                <?php
                                    echo $form->hiddenField($modPencatatan, 'pegawai_id',['class'=>'perawat_id']);
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modPencatatan,
                                        'attribute' => 'pegawai_nama',
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
                                                $(".pegawai_id").val(ui.item.pegawai_id);
                                                $(".pegawai_nama").val(ui.item.namaLengkap);                                
                                                return false;
                                            }',
                                        ),
                                        'htmlOptions' => array(
                                            'onkeyup' => "return $(this).focusNextInputField(event)",
                                            'class'=>'pegawai_nama',
                                            'disabled' => $jenis == 'lihat',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid">
                    <table class="items table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th style="text-align: center;" rowspan="2">Diagnosa</th>
                                <th style="text-align: center;" colspan="3">DPJP</th>
                                <th style="text-align: center;" colspan="3">DPJP Utama</th>
                                <th style="text-align: center;" rowspan="2">Keterangan</th>
                            </tr>
                            <tr>
                                <th style="text-align: center;">Nama</th>
                                <th style="text-align: center;">Tanggal Mulai</th>
                                <th style="text-align: center;">Tanggal Berakhir</th>
                                <th style="text-align: center;">Nama</th>
                                <th style="text-align: center;">Tanggal Mulai</th>
                                <th style="text-align: center;">Tanggal Berakhir</th>
                            </tr>
                        </thead>
                        <?php if($new){ ?>
                        <tbody>
                            <?php
                                $no = 0;
                                foreach ($modDiagnosa as $key => $res) {
                                $diagnosa = DiagnosaM::model()->findByPk($res->diagnosa_id);
                            ?>
                            <tr>
                                <th>
                                    <?php 
                                        $modPencatatanDet->diagnosa_id = $diagnosa->diagnosa_id; 
                                        $modPencatatanDet->diagnosa_nama = $diagnosa->diagnosa_nama; 
                                        
                                        echo $form->hiddenField($modPencatatanDet, '[' . $key . ']diagnosa_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        echo $form->textField($modPencatatanDet, '[' . $key . ']diagnosa_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        $modPencatatanDet->dpjp_id = $res->pegawai->pegawai_id;
                                        $modPencatatanDet->dpjp_nama = $res->pegawai->namaLengkap;

                                        echo $form->hiddenField($modPencatatanDet, '[' . $key . ']dpjp_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        echo $form->textField($modPencatatanDet, '[' . $key . ']dpjp_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglmulai_dpjp',
                                            'value' => null,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglberakhir_dpjp',
                                            'value' => null,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        if(!empty($res->pasienadmisi_id)){
                                            $pas = PasienadmisiT::model()->findByPk($res->pasienadmisi_id);

                                            $modPencatatanDet->dpjputama_id = $pas->pegawai->pegawai_id;
                                            $modPencatatanDet->dpjputama_nama = $pas->pegawai->namaLengkap;
    
                                            echo $form->hiddenField($modPencatatanDet, '[' . $key . ']dpjputama_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                            echo $form->textField($modPencatatanDet, '[' . $key . ']dpjputama_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        } else {
                                            $pen = PendaftaranT::model()->findByPk($res->pendaftaran_id);

                                            $modPencatatanDet->dpjputama_id = $pen->pegawai->pegawai_id;
                                            $modPencatatanDet->dpjputama_nama = $pen->pegawai->namaLengkap;
    
                                            echo $form->hiddenField($modPencatatanDet, '[' . $key . ']dpjputama_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                            echo $form->textField($modPencatatanDet, '[' . $key . ']dpjputama_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        }
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglmulai_dpjputama',
                                            'value' => null,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglberakhir_dpjputama',
                                            'value' => null,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        echo $form->textArea($modPencatatanDet,'[' . $key . ']keterangan',array('rows'=>3, 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                    ?>
                                </th>
                            </tr>
                            <?php
                                $no++;
                                }
                            ?>
                        </tbody>
                        <?php } else { ?>
                        <tbody>
                            <?php
                                $no = 0;
                            $modDetLoad = PencatatandpjpdetT::model()->findAllByAttributes(array('pencatatandpjp_id' => $modPencatatan->pencatatandpjp_id));
                            if(count($modDetLoad) > 0){
                                foreach ($modDetLoad as $key => $res) {
                                    $diagnosa = DiagnosaM::model()->findByPk($res->diagnosa_id);
                                    // echo '<pre>';var_dump($res->diagnosa_id, $diagnosa->diagnosa_id);die;
                            ?>
                            <tr>
                                <th>
                                    <?php 
                                        $modPencatatanDet->diagnosa_id = $diagnosa->diagnosa_id; 
                                        $modPencatatanDet->diagnosa_nama = $diagnosa->diagnosa_nama; 
                                        
                                        echo $form->textField($modPencatatanDet, '[' . $key . ']diagnosa_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        echo $form->textField($modPencatatanDet, '[' . $key . ']diagnosa_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        $modPencatatanDet->dpjp_id = $res->dpjp->pegawai_id;
                                        $modPencatatanDet->dpjp_nama = $res->dpjp->namaLengkap;

                                        echo $form->hiddenField($modPencatatanDet, '[' . $key . ']dpjp_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        echo $form->textField($modPencatatanDet, '[' . $key . ']dpjp_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $modPencatatanDet->tglmulai_dpjp = MyFormatter::formatDateTimeForUser($res->tglmulai_dpjp);
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglmulai_dpjp',
                                            // 'value' => $res->tglmulai_dpjp,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $modPencatatanDet->tglberakhir_dpjp = MyFormatter::formatDateTimeForUser($res->tglberakhir_dpjp);
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglberakhir_dpjp',
                                            // 'value' => $res->tglberakhir_dpjp,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        if(!empty($res->pasienadmisi_id)){
                                            $pas = PasienadmisiT::model()->findByPk($res->pasienadmisi_id);

                                            $modPencatatanDet->dpjputama_id = $pas->pegawai->pegawai_id;
                                            $modPencatatanDet->dpjputama_nama = $pas->pegawai->namaLengkap;
    
                                            echo $form->hiddenField($modPencatatanDet, '[' . $key . ']dpjputama_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                            echo $form->textField($modPencatatanDet, '[' . $key . ']dpjputama_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        } else {
                                            $pen = PendaftaranT::model()->findByPk($res->pendaftaran_id);

                                            $modPencatatanDet->dpjputama_id = $pen->pegawai->pegawai_id;
                                            $modPencatatanDet->dpjputama_nama = $pen->pegawai->namaLengkap;
    
                                            echo $form->hiddenField($modPencatatanDet, '[' . $key . ']dpjputama_id', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                            echo $form->textField($modPencatatanDet, '[' . $key . ']dpjputama_nama', array('readonly' => true, 'class' => 'span2', 'onkeypress' => 'return $(this).focusNextInputField(event);'));
                                        }
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $modPencatatanDet->tglmulai_dpjputama = MyFormatter::formatDateTimeForUser($res->tglmulai_dpjputama);
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglmulai_dpjputama',
                                            // 'value' => $res->tglmulai_dpjputama,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php
                                        $modPencatatanDet->tglberakhir_dpjputama = MyFormatter::formatDateTimeForUser($res->tglberakhir_dpjputama);
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $modPencatatanDet,
                                            'attribute' => '[' . $key . ']tglberakhir_dpjputama',
                                            // 'value' => $res->tglberakhir_dpjputama,
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                                // 'minDate' => 'd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 htpd',
                                                // 'disabled' => $jenis == 'lihat',
                                            ),
                                        ));
                                    ?>
                                </th>
                                <th>
                                    <?php 
                                        $modPencatatanDet->keterangan = $res->keterangan;
                                        echo $form->textArea($modPencatatanDet,'[' . $key . ']keterangan',array('rows'=>3, 'class'=>'span2', 'onkeypress' => "return $(this).focusNextInputField(event)", 'readonly' => false)); 
                                    ?>
                                </th>
                            </tr>
                            <?php
                                $no++;
                                }
                            }
                            ?>
                        </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>