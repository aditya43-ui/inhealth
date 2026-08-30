<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>                  
            <th>No</th>
            <th class="hide">No. Identitas Pendonor</th>  
            <th class="hide">No. Formulir</th>
            <th>No. Kantong Darah Utama</th>
            <th class="hide">No. Sampel Konfirmasi Gol Darah</th>
            <th class="hide">No. Sampel Skrining IMLTD</th>
            <th>Golongan Darah</th>
            <th>Rhesus</th>
            <th>Jenis Kantong</th>
            <th class="hide">No. Komponen Darah</th>
            <th style="width: 130px">Kantong Utama <br>
                <div style="text-align:center">
                    <?php echo CHtml::checkBox('check_semua',false, array('rel' => 'tooltip', 'title' => 'Pilih semua', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column pilihkantong','onclick'=>'checkAll()','checked'=>'checked')) ?>
                </div>
            </th>
            <th style="width: 130px">Sampel Konfirmasi Gol Darah <br> 
                <div style="text-align:center">
                    <?php echo CHtml::checkBox('check_sampel',false, array('rel' => 'tooltip', 'title' => 'Pilih semua', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column pilihsample','onclick'=>'checkAll("pengujian")','checked'=>'checked')) ?>
                </div>
            </th>
            <th style="width: 130px">Sampel Skrining IMLTD <br>
                <div style="text-align:center">
                    <?php echo CHtml::checkBox('check_kantong',false, array('rel' => 'tooltip', 'title' => 'Pilih semua', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'checkbox-column pilihimltd','onclick'=>'checkAll("imltd")','checked'=>'checked')) ?>
                </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no=1; 
        $nama_lengkap='';
        $no_formulir='';
        $jeniskantong_nama='';
        $no_utama = '';
        $no_sampel = '';
        $no_identitas = '';
        $i=0;
        
        $row_arr = array();
        ?>
            <?php if(count($modKirimKantongdetail) > 0) {
                
                foreach ($modKirimKantongdetail as $data) {   
                    
                    $no_utama = '';
                    $no_sampel = '';
                    $modKantongDarah = KantongdarahT::model()->findByPk($data->kantongdarah_id);
                    $cekTerimaKantongDet = TerimakantongdetT::model()->findByAttributes(array('kantongdarah_id'=>$data->kantongdarah_id));
                    if (!empty($cekTerimaKantongDet)){
                        $modTerimaKantongDet->attributes = $cekTerimaKantongDet->attributes;
                        $modTerimaKantongDet->terimakantongdet_id = $cekTerimaKantongDet->terimakantongdet_id;
                    }
                    $modTerimaKantongDet->jeniskantongdarah_id=$data->jeniskantongdarah_id;
                    $modTerimaKantongDet->komponendarah_id=$data->komponendarah_id;
                    $modTerimaKantongDet->jmlterima=$data->jmlkirim;
                    $modTerimaKantongDet->nobarcodekantong=$data->nomorbarcode;
                    $modTerimaKantongDet->kantongdarah_id = $data->kantongdarah_id;                    
                    if(isset($modKantongDarah)) {
                        
                        
                        $modPendonor = PendonorM::model()->findByPk($modKantongDarah->pendonor_id);
                        $modDonasi = DaftardonasiT::model()->findByPk($modKantongDarah->daftarpendonor_id);
                        if (!empty($modPendonor)){
                            $nama_lengkap = $modPendonor->nama_lengkap;
                            $no_identitas = $modPendonor->no_identitas;
                        }
                        if (!empty($modDonasi)){
                            $no_formulir = $modDonasi->no_formulir;
                        }
                        $modJenisKantong = JeniskantongdarahM::model()->findByPk($data->jeniskantongdarah_id);
                        $jeniskantong_nama= $modJenisKantong->nama_jenis;
                        
                        $no_utama = $modKantongDarah->nomorbarcode_utama;
                        $no_sampel = $modKantongDarah->nomorbarcode_sample;
                        $no_sampe_imltd = $modKantongDarah->nomorbarcode_sample_imltd;
                        
                        if (empty($row_arr[$modKantongDarah->nomorbarcode_sample])) {
                            $row_arr[$modKantongDarah->nomorbarcode_sample] = array(
                                'nomorbarcode_utama'=>$no_utama,
                                'no_sampel'=>$no_sampel,
                                'no_sampel_imltd'=>$no_sampe_imltd,
                                'nama_lengkap'=>$nama_lengkap,
                                'no_identitas'=>$no_identitas,
                                'no_formulir'=>$no_formulir,
                                'jeniskantong_nama'=>$jeniskantong_nama,
                                'gol_darah'=>$modKantongDarah->gol_darah,
                                'rhesus'=>$modKantongDarah->rhesus,                                
                                'detail'=>array(),
                            );
                            
                        }
                        $row_arr[$modKantongDarah->nomorbarcode_sample]['detail'][] = $modTerimaKantongDet->attributes;                        
                    } 
                }   
                
                foreach ($row_arr as $no_sampel => $item) : ?>
        <tr>   
            <td><?php echo $no++; ?>
                <?php echo CHtml::hiddenField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?>

            </td>
            <td class="hide"><?php echo $item['no_identitas']; ?></td>
            <td class="hide"><?php echo $item['no_formulir']; ?></td>
            <td><span class="nobarcodeutama"><?php echo $item['nomorbarcode_utama']; ?></span></td>
            <td class="hide"><span class="nobarcodesample"><?php echo $item['no_sampel']; ?></span></td>
            <td class="hide"><span class="nobarcodeimltd"><?php echo $item['no_sampel_imltd']; ?></span></td>
            <td><?php echo $item['gol_darah']; ?></td>
            <td><?php echo $item['rhesus']; ?></td>
            <td><?php echo $item['jeniskantong_nama']; 
            
            
            foreach ($item['detail'] as $detail) {
                echo CHtml::activeHiddenField($modTerimaKantongDet, 'detail['.$no_sampel.'][detail]['.$detail['kantongdarah_id'].'][jeniskantongdarah_id]', array('value'=>$detail['jeniskantongdarah_id'], 'readonly'=>true));
                echo CHtml::activeHiddenField($modTerimaKantongDet, 'detail['.$no_sampel.'][detail]['.$detail['kantongdarah_id'].'][komponendarah_id]', array('value'=>$detail['komponendarah_id'], 'readonly'=>true));
                echo CHtml::activeHiddenField($modTerimaKantongDet, 'detail['.$no_sampel.'][detail]['.$detail['kantongdarah_id'].'][jmlterima]', array('value'=>$detail['jmlterima'], 'readonly'=>true));
                echo CHtml::activeHiddenField($modTerimaKantongDet, 'detail['.$no_sampel.'][detail]['.$detail['kantongdarah_id'].'][nobarcodekantong]', array('value'=>$detail['nobarcodekantong'], 'readonly'=>true));
                echo CHtml::activeHiddenField($modTerimaKantongDet, 'detail['.$no_sampel.'][detail]['.$detail['kantongdarah_id'].'][terimakantongdet_id]', array('value'=>$detail['terimakantongdet_id'], 'readonly'=>true));                
            }
            ?>
            </td>
            <td  class="hide">
                <ul>
                    <?php foreach ($item['detail'] as $detail) {
                        $kantong = KantongdarahT::model()->findByPk($detail['kantongdarah_id']);
                        if (!empty($kantong)) {
                            echo '<li>'.$kantong->no_kantongdarah.'</li>';
                        }
                    }
                    ?>
                </ul>
            </td>
            <td style="text-align: center;"><?php 
                //echo CHtml::activeCheckBox($modTerimaKantongDet,'detail['.$no_sampel.'][checklist]', array('class'=>'checklist','onclick'=>'setNol(this);'));//'checked'=>true, 
                echo CHtml::activeCheckBox($modTerimaKantongDet,'detail['.$no_sampel.'][sampel_utama]', array('class'=>'checklist', 'checked'=>($detail['sampel_utama'])?true:false));//'checked'=>true, 
                
            ?></td>
            <td style="text-align: center;"><?php echo CHtml::activeCheckBox($modTerimaKantongDet,'detail['.$no_sampel.'][sampel_konfirmasi]', array('class'=>'checklistsample', 'checked'=>($detail['sampel_konfirmasi'])?true:false)); //'checked'=>true, ?></td>
            <td style="text-align: center;"><?php echo CHtml::activeCheckBox($modTerimaKantongDet,'detail['.$no_sampel.'][sampel_imltd]', array('class'=>'checklistimltd', 'checked'=>($detail['sampel_imltd'])?true:false)); //'checked'=>true, ?></td>
        </tr>
            
                <?php endforeach;
                
            } ?>
    </tbody>
</table>