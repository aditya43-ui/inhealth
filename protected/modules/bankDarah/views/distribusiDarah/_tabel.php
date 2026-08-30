<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>No. Kantong Darah</th>
            <th>Jenis Kantong Darah</th>
            <th>Jenis Kantong</th>
            <th>Golongan Darah</th>
            <th>Rhesus</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody id="tab_kantong_darah">
        <?php if (!$model->isNewRecord) {
            $detail = DistribusidarahdetT::model()->findAllByAttributes(array(
                'distribusidarah_id'=>$model->distribusidarah_id,
            ));
            
            foreach ($detail as $idx => $item) {
                echo $this->renderPartial($this->path_view."_rowKantongSimpan", array(
                    'detail'=>$item,
                    'no'=>$idx + 1,
                ), true);
            }
        }
?>
    </tbody>
</table>