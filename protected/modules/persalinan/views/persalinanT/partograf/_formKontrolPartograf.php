<?php
/**
 * form pemeriksaan kontrol partograf
 * issue RSST-1589, RSST-2474
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<p>&nbsp;</p>
<div class="panel panel-dark">
    <span class="group-title">
        Pemeriksaan Kontrol Partogram
    </span>
     <div class="panel-body" id="form-partografkontrol">
        <div class="col-sm-6">
            <?php echo CHtml::activeHiddenField($model, 'pemeriksaanpartografdet_id',array('readonly'=>true)); ?>
            <div class="control-group">
                <label class="control-label">Pemeriksaan Ke -</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'pemeriksaan_ke',array('class'=>'numbers-only required periksake', 'readonly'=>true)); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Jam</label>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'waktucatat',
                            'mode' => 'time',
                            'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('placeholder'=>'Jam','readonly' => true, 'class' => 'p3_waktu required', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            ),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Denyut Jantung Janin</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'p1_djj_menit',array('class'=>'numbers-only')); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Penyisipan</label>
                <div class="controls">
                    <?php echo CHtml::activeDropDownList($model,'p2_penyusupan', LookupM::getItems('partograf_penyusupan'),array('empty' => '-- Pilih --')); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Pembukaan Serviks</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'p3_pembukaanserviks',array('class'=>'numbers-only')); ?> <label> cm</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Turunnya Kepala Janin</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'p3_turunnyakepala',array('class'=>'numbers-only')); ?> <label> cm</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Kontraksi Uterus</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'p4_kontraksi_jml',array('class'=>'numbers-only')); ?> <label> kali</label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeRadioButton($model, 'p4_kontraksi_lama_detik',array('uncheckValue'=>null,'value'=> Params::PARTOGRAF_KONTRAK_KURANG));
                    ?>
                </div>
                <div class="controls">
                    <label><?php echo Params::PARTOGRAF_KONTRAK_KURANG ?></label>
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeRadioButton($model, 'p4_kontraksi_lama_detik',array('uncheckValue'=>null,'value'=> Params::PARTOGRAF_KONTRAK_SD));
                    ?>
                </div>
                <div class="controls">
                    <label><?php echo Params::PARTOGRAF_KONTRAK_SD ?></label>
                </div>
            </div>
            
             <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php 
                        echo CHtml::activeRadioButton($model, 'p4_kontraksi_lama_detik',array('uncheckValue'=>null,'value'=> Params::PARTOGRAF_KONTRAK_LEBIH));
                    ?>
                </div>
                <div class="controls">
                    <label><?php echo Params::PARTOGRAF_KONTRAK_LEBIH ?></label>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label"><b>GCS</b></label>
            </div>
            <div class="control-group">
                  <?php echo CHtml::label('Eye','sesak_nafas',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php   $crit = new CDbCriteria();
                            $crit->compare('LOWER(metodegcs_singkatan)',"e");
                            $crit->addCondition('metodegcs_nilai is not null');
                            $crit->order = 'metodegcs_nilai ASC';
                            echo CHtml::activeDropDownList($model,'gcs_eye',  
                            CHtml::listData(PSMetodeGCSM::model()->findAll($crit), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>

                </div>
            </div>
            <div class="control-group">
                  <?php echo CHtml::label('Verbal','sesak_nafas',array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php 
                            $crit3 = new CDbCriteria();
                            $crit3->compare('LOWER(metodegcs_singkatan)',"v");
                            $crit3->addCondition('metodegcs_nilai is not null');
                            $crit3->order = 'metodegcs_nilai ASC';
                            echo CHtml::activeDropDownList($model,'gcs_verbal',
                            CHtml::listData(PSMetodeGCSM::model()->findAll($crit3), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                </div>
            </div>
            <div class="control-group">
                  <?php echo CHtml::label('Motorik','sesak_nafas',array('class'=>'control-label')); ?>
                <div class="controls">
                   <?php 
                            $crit2 = new CDbCriteria();
                            $crit2->compare('LOWER(metodegcs_singkatan)',"m");
                            $crit2->addCondition('metodegcs_nilai is not null');
                            $crit2->order = 'metodegcs_nilai ASC';
                            echo CHtml::activeDropDownList($model,'gcs_motorik',
                            CHtml::listData(PSMetodeGCSM::model()->findAll($crit2), 'metodegcs_nilai', 'textMetodeGCSM'),array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'onchange'=>'hitungCGS()')); ?>
                </div>
            </div>
            
            <?php echo CHtml::activeHiddenField($model, 'gcs_totalskor',array('readonly'=>true)) ?>
            
            <div class="control-group">
                <label class="control-label">Obat dan Cairan IV</label>
                <div class="controls input_obat_iv">
                    <?php echo CHtml::htmlButton("+ Tambah Obat", array(
                        'class' => 'btn btn-danger', 'onclick'=>'$("#dialogOA").dialog("open");'
                    )); ?><br>
                </div>
            </div>
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>Obat/Cairan IV</th>
                        <th>Qty</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody class="tab_iv">
                    <?php 
                    if (!empty($arr_oa)) {
                        foreach ($arr_oa as $id => $qty) {
                            $oa = ObatalkesM::model()->findByPk($id);
                            
                            echo '<tr data-id="'.$id.'">';
                            echo '<td>'.$oa->obatalkes_nama.'</td>';
                            echo '<td>'.CHtml::textField('qty['.$id.']', $qty, array(
                                'class'=>'span1 qty_oa_iv',
                                'style'=>'text-align: right',
                            )).'</td>';
                            echo '<td>'.CHtml::htmlButton('-', array('class' => 'btn btn-default', 'onclick'=>'removeRow(this);')).'</td>';
                            echo '</tr>';
                        }
                    }
?>
                </tbody>
            </table>
        </div>
        
        <div class="col-sm-6">
            <div class="control-group">
                <label class="control-label">Penepisan</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'penepisan') ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Perlunakan</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'perlunakan') ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Skor Pelvik</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'skor_pelvik',array('class' => 'numbers-only')) ?>
                </div>
            </div>                       
                                    
            <div class="control-group">
                <label class="control-label">Ketuban Show</label>
                <div class="controls">
                    <?php echo CHtml::activeDropDownList($model, 'p2_airketuban', LookupM::getItems('partograf_airketuban'),array('empty' => '-- Pilih --')); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Respirasi</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'respirasi',array('class' => '')) ?>
                </div>
            </div> 
            
            <div class="control-group">
                <label class="control-label">Tensi</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p6_systolic',array('class'=>'span2 numbers-only')) ?>
                </div>
                <div class="controls">
                    <label>/</label>
                </div>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p6_diastolic',array('class'=>'span2 numbers-only')) ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Nadi</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p6_nadi', array('class' => 'numbers-only')); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Suhu</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p7_suhu',array('class' => 'p7_suhu angkacoma-only')); ?> 
                </div>
                <div class="controls">
                    <sup>o</sup>C
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">CVP</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'center_venous_pressure',array()); ?> 
                </div>                
            </div>
            
            <div class="control-group">
                <label class="control-label">Oksilosin Unit</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p5_oksitosin_unit',array('class' => ' numbers-only')); ?> 
                </div>                
            </div>
            
            <div class="control-group">
                <label class="control-label">Tetes Menit</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p5_tetes_menit',array('class' => ' numbers-only')); ?> 
                </div>                
            </div>
            
            <div class="control-group">
                <label class="control-label">Urin :</label>                
            </div>
            <div class="control-group">
                <label class="control-label">Protein</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p8_urin_protein',array()); ?> 
                </div>                
            </div>
            <div class="control-group">
                <label class="control-label">Aseton</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p8_urin_aseton',array()); ?> 
                </div>                
            </div>
            <div class="control-group">
                <label class="control-label">Volume</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, 'p8_urin_volume',array('class' => ' numbers-only')); ?> 
                </div>                
            </div>
        </div>
         <div class="clear"></div>
            <div class="col-sm-6">
                <?php 
                if (!isset($ubah)){
                    echo CHtml::link(" <i class='".MyIcon::getIcons('tambah-baris')."'></i> Tambah","javascript:;",array('id'=>'tombol-tambah','onclick'=>'tambahPartografKontrol(this,"tambah");','class' => 'btn btn-danger',));
                }else{
                    echo CHtml::link(" <i class='".MyIcon::getIcons('simpan')."'></i> Simpan","javascript:;",array('id'=>'tombol-ubah','onclick'=>'tambahPartografKontrol("dialog",'.$model->nourutlain.');','class' => 'btn btn-danger','style'=>'color:#fff;')); 
                }
                ?> 
            </div>
    </div>
</div>