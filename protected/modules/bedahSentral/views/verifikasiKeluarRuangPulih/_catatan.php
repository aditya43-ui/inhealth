<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Jam</th>
            <th>Catatan Khusus Ruang Pulih</th>
            <th>Nama/Jabatan Pemberi Catatan</th>
        </tr>
    </thead>
    <tbody id="tab_catatan">
        <?php
        if (!$model->isNewRecord) {
            $detail = CatatankhususRuangpulihT::model()->findAllByAttributes(array(
                'pasienruangpulih_id'=>$model->pasienruangpulih_id,
            ));
            
            foreach ($detail as $ii=>$item) {
                echo $this->renderPartial('_rowCatatan', array('mod'=>$item, 'idx'=>$ii), true);
            }
        }
        
        ?>
    </tbody>
</table>