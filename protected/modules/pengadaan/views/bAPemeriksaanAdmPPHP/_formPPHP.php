<table class="table table-bordered table-condensed table-condensed" id="tabel-pphp">
    <thead>
        <tr>
            <th style="text-align: center">No</th>
            <th style="text-align: center">Nama PPHP <span class="required">*</span></th>
            <th style="text-align: center">NIP</th>
            <th style="text-align: center">Jabatan <span class="required">*</span></th>
            <th style="text-align: center">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($model->bapemeriksaanadmpphp_id)){
            $cekPegPPHP = PegpphpT::model()->findAllByAttributes(array('suratperjanjiankerja_id' => $model->suratperjanjiankerja_id, 'bapemeriksaanadmpphp_id'=>$model->bapemeriksaanadmpphp_id));
            foreach($cekPegPPHP as $i => $det){
                echo $this->renderPartial('_rowTabel',array('modDetail'=>$det, 'i'=>$i+1)); 
            } 
        }?>
    </tbody>
</table>   