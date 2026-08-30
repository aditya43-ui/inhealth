<?php if(isset($_GET['id'])){$disabled = 'disabled';} else {$readonly = false;} ?>
<table id="tabelDetail" class="table table-striped table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>No. Pendaftaran/<br>No. RM</th>
            <th>No. Penunjang</th>
            <th>Nama Pasien</th>
            <th>Alamat Pasien</th>
            <th>Jenis Penjamin<br> / Penjamin</th>
            <th>Jumlah Tarif</th>
            <th>Jumlah Jasa</th>
            <th>Jumlah Bayar</th>
            <th>Sisa Jasa</th>
            <th>Pilih <?php echo CHtml::checkBox('pilihSemua', true, array('disabled'=>false, 'onclick'=>'checkAll(this);'));?></th>
        </tr>
    </thead>
    <tbody>
        <?php //target untuk actionAjax/addDetailPembayaranJasa ?>
        <?php
       
        if(count((array)$dataDetails)>0){
            $tr = '';
            $disabled = true;
            foreach ($dataDetails as $i => $detail){
                $modDetails = new $modDetails;
                $modDetails->attributes = $detail;
                $modDetails->pilihDetail = true;
                $modDetails->penjaminId = (isset($detail->penjaminId) ? $detail->penjaminId : null);
                $tr .= "<tr>";
                $tr .= "<td>".($i+1).
                        CHtml::activeHiddenField($modDetails,'['.$i.']pendaftaran_id',array('value'=>$modDetails->pendaftaran_id)).
                        CHtml::activeHiddenField($modDetails,'['.$i.']pembayaranjasa_id',array('value'=>null)).
                        CHtml::activeHiddenField($modDetails,'['.$i.']pasien_id',array('value'=>$modDetails->pasien_id));
                        CHtml::activeHiddenField($modDetails,'['.$i.']penjaminId',array('value'=>isset($modDetails->pendaftaran->penjamin_id) ? $modDetails->pendaftaran->penjamin_id : null ));
                if(!empty($rujukandariId)) {
                    $tr .= CHtml::activeHiddenField($modDetails,'['.$i.']pasienmasukpenunjang_id',array('value'=>$modDetails->pasienmasukpenunjang_id));
                }
                $tr .= "</td>";
                $tr .= "<td>".(isset($modDetails->pasien->no_rekam_medik) ? $modDetails->pasien->no_rekam_medik : null)."<br>".(isset($modDetails->pendaftaran->no_pendaftaran)? $modDetails->pendaftaran->no_pendaftaran:null)."</td>";
                if(!empty($modDetails->rujukandari_id)){
                    $tr .= "<td>".empty($modDetails->no_masukpenunjang) ? "-" : $modDetails->no_masukpenunjang."</td>";
                }else{
                    $tr .= "<td><p style="margin: 0; text-align: center;">-</p></td>";
                }
                $tr .= "<td>".(isset($modDetails->pasien->nama_pasien)? $modDetails->pasien->nama_pasien : "")."</td>";
                $tr .= "<td>".(isset($modDetails->pasien->alamat_pasien) ? $modDetails->pasien->alamat_pasien:"" )."</td>";
                $tr .= "<td>".(isset(PenjaminpasienM::model()->findByPk($modDetails->penjaminId)->penjamin_nama) ? PenjaminpasienM::model()->findByPk($modDetails->penjaminId)->penjamin_nama : "")."</td>";
                $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']jumahtarif', array('disabled'=>$disabled,'readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);"))."</td>";
                $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']jumlahjasa', array('disabled'=>$disabled,'readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onkeyup'=>'hitungSemua();'))."</td>";
                $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']jumlahbayar', array('disabled'=>$disabled,'readonly'=>false, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'onkeyup'=>'hitungSemua();'))."</td>";
                $tr .= "<td>".CHtml::activeTextField($modDetails,'['.$i.']sisajasa', array('disabled'=>$disabled,'readonly'=>true, 'class'=>'inputFormTabel integer', 'onkeypress'=>"return $(this).focusNextInputField(event);"))."</td>";
                $tr .= "<td>".CHtml::activeCheckBox($modDetails,'['.$i.']pilihDetail', array('disabled'=>$disabled))."</td>";
                $tr .= "</tr>";
            }
            
            echo $tr;
        }
        ?>
    </tbody>
</table>
