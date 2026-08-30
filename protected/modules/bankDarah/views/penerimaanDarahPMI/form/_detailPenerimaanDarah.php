<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Detail Penerimaan Darah</div>
    </div>
    <div class="panel-body">
        <?php
        $detail = new PenerimaandarahpmidetT;
        ?>
        <div id="subform_detail" <?php echo $model->isNewRecord ? '' : ''; ?> >           
 
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis Darah</th>
                    <th>Gol. Darah</th>
                    <th>Rhesus</th>
                    <th>Jumlah Permintaan</th>
                    <th>Jumlah Terima</th>
                    <th>Keterangan</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody id="tab_terimadarah">
                <?php
                if (!empty($model->penerimaandarahpmi_id) ) {
                    $detail = PenerimaandarahpmidetT::model()->findAllByAttributes(array(
                        'penerimaandarahpmi_id' => $model->penerimaandarahpmi_id,
                    ));

                    foreach ($detail as $idx => $item) {
                        $jenis = JeniskomponendarahM::model()->findByPk($item->jeniskomponendarah_id);

                        if (!empty($model->is_detailpenerimaan)){
                            echo $this->renderPartial($this->path_view . "form/_rowDarahTerima", array(
                            'item' => $item,
                            'cnt' => ($idx + 1),
                            'jenis' => $jenis,
                                ), true);
                        }else{
                            $item->jumlah = $item->jumlah_permintaan;
                            echo $this->renderPartial($this->path_view . "form/_rowDarah", array(
                            'item' => $item,
                            'cnt' => ($idx + 1),
                            'jenis' => $jenis,
                                ), true);
                        }
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align:right;"><label><span class="total_permintaan"></span></label></th>
                    <th style="text-align:right;">
                        <?php echo $form->hiddenField($model, 'jumlah_terima', array(
                            'class'=>'',
                        )); ?>
                        <label><span class="total_penerimaan"></span></label>
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
</div>