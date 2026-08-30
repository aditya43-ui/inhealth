<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Intervensi Pencegahan Jatuh</div>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-sm-12">
            
            <?php echo CHtml::activeHiddenField($modIntervensi,'kelompok_pasien',array('class'=>'', 'value'=>'dewasa')) ?>
            
            <div style="font-style: italic; color: red;">Bagian dengan tanda * harus diisi.</div>
            <br />
        </div>
            <div class="col-sm-4">
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                            $this->widget('MyDateTimePicker',array(
                            'model'=>$modIntervensi,
                            'attribute'=>'tgl_intervensi',
                            'mode'=>'date',
                            'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'span2'),
                        )); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Jam <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$modIntervensi,
                            'attribute'=>'jam_intervensi',
                                'mode'=>'time',

                                'options'=> array(
                                        'showOn' => false,
                                ),
                                'htmlOptions'=>array(
                            'readonly'=>TRUE,
                            'class'=>'span2 cekreq',
                            'placeholder'=>'00:00:00',
                            'onkeyup'=>"return $(this).focusNextInputField(event),",
                                ),
                            ));
                        ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Nama Petugas <br>Pengkaji <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($modIntervensi, 'petugas_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState("ruangan_id")),array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'), array('empty' => '-- Pilih --', 'class' => 'span3 cekreq', 'style'=>'width:145px;')); ?>
                    </div>
                </div>
                
            </div>
            <div class="col-sm-4">
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modIntervensi,'resikojatuh_tingkat', array('class'=>'control-label', 'label'=>'Risiko Jatuh Pasien <span class="required">*</span>')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeRadioButtonList($modIntervensi,'resikojatuh_tingkat',array('Resiko Rendah'=>'Resiko Rendah','Resiko Tinggi'=>'Resiko Tinggi') , array('onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'cekreq risikojatuh','onclick'=>'setRisikoJatuh(this);')); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="control-group ">
                    <?php  echo CHtml::label('Evalusasi :', '', array('class' => 'control-label')) ?>
                </div>

                <div class="control-group ">
                    <?php  echo CHtml::label('Apakah terjadi insiden jatuh ? <span style="font-color:red">*</span>', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="form-inline">
                            <div class="radio inline">
                            <?php echo $form->radioButtonList($modIntervensi,'evaluasi_pencegahanjatuh',array('ya'=>'Ya','tidak'=>'Tidak') , array('class'=>'cekreq','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <p class="help-block">Pilih Intervensi Pencegahan Pasien Jatuh yang Dilakukan</p>

        <table width="100%" class="tablefont" id="tblpencegahan">
        <tr>
            <td><strong>TINDAKAN PENCEGAHAN JATUH RESIKO RENDAH</strong></td>
        </tr>
        <?php
            $modMasterIntervensiRendah = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'rendah' and kelompok_pasien = 'dewasa' ORDER BY intervensipencegahanjatuh_urutan ASC");

            if(count($modMasterIntervensiRendah)>0){
                $noRendah = 1;
                foreach ($modMasterIntervensiRendah as $ir => $dataInvRendah){
                    $oriIntevensi = new IntervensicegahjatuhpasiendetT();

                    if(is_array($modDetail) && count($modDetail)>0){
                        foreach ($modDetail as $dataOriIntervensi){
                            if($dataOriIntervensi->intervensicegahjatuh_tingkat == $dataInvRendah->intervensipencegahanjatuh_tingkat && $dataOriIntervensi->intervensicegahjatuh_nama == $dataInvRendah->intervensipencegahanjatuh_nama){
                                $oriIntevensi->isdilakukan_r = $dataOriIntervensi->isdilakukan;
                            }
                        }
                    }
                    ?>
                <tr class="intervensirendah">
                            <td style="padding-left: 15px;">
                                <?php echo CHtml::activeCheckBox($oriIntevensi,'['.$ir.']isdilakukan_r',array('class'=>'checkisdilakukan_r disabledcls', 'text_id'=>$ir)) ?>
                                <?php echo CHtml::activeHiddenField($oriIntevensi,'['.$ir.']intervensicegahjatuh_nama_r',array('class'=>'', 'value'=>$dataInvRendah->intervensipencegahanjatuh_nama)) ?>
                                <?php echo CHtml::activeHiddenField($oriIntevensi,'['.$ir.']intervensicegahjatuh_urutan_r',array('class'=>'', 'value'=>$dataInvRendah->intervensipencegahanjatuh_urutan)) ?>
                                <?php echo CHtml::activeHiddenField($oriIntevensi,'['.$ir.']intervensicegahjatuh_tingkat_r',array('class'=>'', 'value'=>$dataInvRendah->intervensipencegahanjatuh_tingkat)) ?>
                                <span class="textintervensirendah"><?php echo $noRendah.'. '.$dataInvRendah->intervensipencegahanjatuh_nama; ?></span>
                            </td>
                        </tr>
                    <?php
                    $noRendah++;
                }
            }
        ?>
        <tr>
            <td><strong>TINDAKAN PENCEGAHAN JATUH RESIKO TINGGI</strong></td>
        </tr>
        <?php
            $modMasterIntervensiSedang = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'tinggi' and kelompok_pasien = 'dewasa' ORDER BY intervensipencegahanjatuh_urutan ASC");

            if(count($modMasterIntervensiSedang)>0){
                $noSedang = 1;
                foreach ($modMasterIntervensiSedang as $is => $dataInvSedang){
                    $oriIntevensi = new IntervensicegahjatuhpasiendetT();

                    if(is_array($modDetail) && count($modDetail)>0){
                        foreach ($modDetail as $dataOriIntervensi){
                            if($dataOriIntervensi->intervensicegahjatuh_tingkat == $dataInvSedang->intervensipencegahanjatuh_tingkat && $dataOriIntervensi->intervensicegahjatuh_nama == $dataInvSedang->intervensipencegahanjatuh_nama){
                                $oriIntevensi->isdilakukan_s = $dataOriIntervensi->isdilakukan;
                            }
                        }
                    }
                    ?>
                        <tr class="intervensitinggi">
                            <td style="padding-left: 15px;">
                                <?php echo CHtml::activeCheckBox($oriIntevensi,'['.$is.']isdilakukan_s',array('class'=>'checkisdilakukan_s disabledcls', 'text_id'=>$is)) ?>
                                <?php echo CHtml::activeHiddenField($oriIntevensi,'['.$is.']intervensicegahjatuh_nama_s',array('class'=>'', 'value'=>$dataInvSedang->intervensipencegahanjatuh_nama)) ?>
                                <?php echo CHtml::activeHiddenField($oriIntevensi,'['.$is.']intervensicegahjatuh_urutan_s',array('class'=>'', 'value'=>$dataInvSedang->intervensipencegahanjatuh_urutan)) ?>
                                <?php echo CHtml::activeHiddenField($oriIntevensi,'['.$is.']intervensicegahjatuh_tingkat_s',array('class'=>'', 'value'=>$dataInvSedang->intervensipencegahanjatuh_tingkat)) ?>
                                <span class="textintervensitinggi"><?php echo $noSedang.'. '.$dataInvSedang->intervensipencegahanjatuh_nama; ?></span>
                            </td>
                        </tr>
                    <?php
                    $noSedang++;
                }
            }
        ?>
        <!-- <tr>
            <td><strong>TINDAKAN PENCEGAHAN JATUH RESIKO SANGAT TINGGI</strong></td>
        </tr> -->
        <?php
            // $modMasterIntervensiTinggi = IntervensipencegahanjatuhM::model()->findAll("intervensipencegahanjatuh_aktif = true and intervensipencegahanjatuh_tingkat = 'sangat_tinggi' and kelompok_pasien = 'dewasa' ORDER BY intervensipencegahanjatuh_urutan ASC");

            // if(count($modMasterIntervensiTinggi)>0){
            //     $noTinggi = 1;
            //     foreach ($modMasterIntervensiTinggi as $it => $dataInvTinggi){
            //         $oriIntevensi = new IntervensicegahjatuhpasiendetT();

            //         if(is_array($modDetail) && count($modDetail)>0){
            //             foreach ($modDetail as $dataOriIntervensi){
            //                 if($dataOriIntervensi->intervensicegahjatuh_tingkat == $dataInvTinggi->intervensipencegahanjatuh_tingkat && $dataOriIntervensi->intervensicegahjatuh_nama == $dataInvTinggi->intervensipencegahanjatuh_nama){
            //                     $oriIntevensi->isdilakukan_t = $dataOriIntervensi->isdilakukan;
            //                 }
            //             }
            //         }
                    ?>
                        <!-- <tr class="intervensisangattinggi">
                            <td style="padding-left: 15px;">
                                <?php //echo CHtml::activeCheckBox($oriIntevensi,'['.$it.']isdilakukan_t',array('class'=>'checkisdilakukan_t disabledcls', 'text_id'=>$it)) ?>
                                <?php //echo CHtml::activeHiddenField($oriIntevensi,'['.$it.']intervensicegahjatuh_nama_t',array('class'=>'', 'value'=>$dataInvTinggi->intervensipencegahanjatuh_nama)) ?>
                                <?php //echo CHtml::activeHiddenField($oriIntevensi,'['.$it.']intervensicegahjatuh_urutan_t',array('class'=>'', 'value'=>$dataInvTinggi->intervensipencegahanjatuh_urutan)) ?>
                                <?php //echo CHtml::activeHiddenField($oriIntevensi,'['.$it.']intervensicegahjatuh_tingkat_t',array('class'=>'', 'value'=>$dataInvTinggi->intervensipencegahanjatuh_tingkat)) ?>
                                <span class="textintervensisangattinggi"><?php //echo $noTinggi.'. '.$dataInvTinggi->intervensipencegahanjatuh_nama; ?></span>
                            </td>
                        </tr> -->
                    <?php
            //         $noTinggi++;
            //     }
            // }
        ?>
        </table>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions pull-right">
            <?php
                    if(isset($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','id'=>'btn_simpan','disabled'=>true));
                            
                    }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')), array('class'=>'btn btn-green', 'type'=>'button','onclick'=>'simpanData_dewasa();')); //RND-8620
                            
                    }
            ?>
    </div>
</div>