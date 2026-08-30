<table class="table table-condensed table-bordered table-striped" id="form-dokpendukung">
    <thead>
        <tr>
            <th style="text-align: center;">Jenis Dokumen</th>
            <th style="text-align: center;">File </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $jenis_id = array();
        $jnspengadaan = PengadaanjenisT::model()->findAll(" t.rencanaumumpengadaan_id = ".$_GET['id']." ");
        if (!empty($jnspengadaan)) {
            foreach ($jnspengadaan as $p){
                $jenis_id[] = $p->jenispengadaan_id;
            }
        }
        $cri = new CDbCriteria();
        $cri->select = 'dokumenpengadaan_id, dokumenpendukungpengadaan_nama';
        $cri->group = $cri->select; 
        $cri->addCondition('rencanaumumpengadaan_id = '.$_GET['id']);
        $cri->order = 't.dokumenpengadaan_id asc';
        $modDokumen = ADPengadaandokumenpendukungT::model()->findAll($cri);
        foreach($modDokumen as $dokumen){ ?>
        <tr>
            <td style="text-align: center; vertical-align: middle"> <label> <?= $dokumen['dokumenpendukungpengadaan_nama']; ?></label></td>
            <td style="vertical-align: middle"> <?php 
                $det = ADPengadaandokumenpendukungT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $_GET['id'], 'dokumenpengadaan_id' => $dokumen->dokumenpengadaan_id));
                foreach($det as $detail){
                    echo "<ol>" . CHtml::link('<u>'.$detail->dokumenpendukungpengadaan_file.'</u>',$this->createUrl('UnduhDokDukungRUP',array('dokumenpendukungpengadaan_id'=>$detail->dokumenpendukungpengadaan_id)),array('class'=>'','title'=>'Klik untuk download dokumen pendukung','rel'=>'tooltip')) ." </ol> ";

                }
            ?></td>
        </tr>
        <?php }
        ?>
    </tbody>
</table>   
