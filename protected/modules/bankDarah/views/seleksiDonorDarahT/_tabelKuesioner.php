<div class="span12">
    <table class="table table-bordered table-condensed table-striped" id="tabel_kuesioner">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Jawab</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(!empty($cekSeleksi)){
                $disabled = true;
                $readonly = true;
            }else{
                $disabled = false;
                $readonly = false;
            }
           /* kondisi jika pendonor jeniskelamin = LAKI-LAKI maka kuesinor untuk hamil,menstruasi,menyusui tidak di tampilkan */
            if($modPendonor->jenis_kelamin =='PEREMPUAN') {
            $modPertanyaan = KuesionerdonorM::model()->findAll("kuesioner_aktif IS TRUE ORDER BY kuesioner_urutan ASC");            
            }else{
            $modPertanyaan = KuesionerdonorM::model()->findAll("kuesionerdonor_id NOT IN ('25', '26', '27')  and  kuesioner_aktif IS TRUE ORDER BY kuesioner_urutan ASC");    
            }
            /* end */
            $no = 1;
            foreach ($modPertanyaan as $value) {
                if($value->kuesioner_urutan >= 20) {
                $class_wanita ='wanita';
                }else{
                $class_wanita="default";
                }
                echo '<tr>';
                echo '<td><label>'.$no.'</label></td>';
                echo '<td><label>'.$value->kuesioner_desc.'</label></td>';
                echo '<td>'.CHtml::radioButtonList('Kuesioner['.$value->kuesionerdonor_id.']', isset($getSioner[$value->kuesionerdonor_id])?$getSioner[$value->kuesionerdonor_id]:(($value->kuesioner_urutan <= 3)? '1' : '0'), array('1'=>'YA', '0' => 'TIDAK'), array('onclick'=>'setValidasi(this,'.$value->kuesionerdonor_id.')','class'=>($value->kuesioner_urutan <= 3)? "kuesioner_wajib" : $class_wanita,'labelOptions'=>array('style'=>'display:inline'),'readonly'=>$readonly,'disabled'=>$disabled)).'</td>';
                echo '</tr>';
                $no++;
            }
            ?>
        </tbody>
    </table>
</div>