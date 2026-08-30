    <table class="table table-condensed table-bordered table-striped" id="tabelRAB">
        <thead>
        <th style="text-align: center; vertical-align: middle">No.</th>        
        <th style="text-align: center; vertical-align: middle">Jenis Barang/Jasa</th>
        <th style="text-align: center; vertical-align: middle">Satuan</th>
        <th style="text-align: center; vertical-align: middle">Volume<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Harga (Rp)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Pajak (%)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Jumlah Harga (Rp)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Serapan (Rp)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle">Sisa Pagu (Rp)<span class="required">*</span></th>
        <th style="text-align: center; vertical-align: middle"> Aksi </th>
        </thead>
        <tbody>
            <?php
            $total = $total_sisapagu = $total_serapan = 0;
            $i = 1;
            $det = RencanaumumpengadaandetT::model()->findAllByAttributes(array('rencanaumumpengadaan_id' => $_GET['id']));
            $tr = "";
            foreach ($det as $key => $value) {
                $detJumlah =  $value->rencanaumumpengadaandet_jumlah;
                $serapan = 0;
                $critNota = new CDbCriteria();
                $critNota->join = "join notadinaspptk_t nota on t.notadinaspptk_id = nota.notadinaspptk_id";
                $critNota->addCondition('nota.rencanaumumpengadaan_id = '.$model->rencanaumumpengadaan_id." and dokumenpelaksanaananggarandet_id = ".$value['dokumenpelaksanaananggarandet_id']);
                $modNota = NotadinaspptkdetT::model()->findAll($critNota);
                if (!empty($modNota)) {
                    foreach($modNota as $det){
                        $serapan += $det['jumlah_diterima'];
                    }
                }
                $modDPA = DokumenpelaksanaananggarandetT::model()->findByPk($value['dokumenpelaksanaananggarandet_id']);
                $value->sisapagu_pengadaan = $detJumlah + $modDPA->sisapagu_pengadaan;
                $value->rencanaumumpengadaandet_jumlah = number_format($detJumlah,2,",",".");
                $value->rencanaumumpengadaandet_harga = number_format($value->rencanaumumpengadaandet_harga,2,",",".");
                $value->rencanaumumpengadaandet_pajak = number_format($value->rencanaumumpengadaandet_pajak,2,",","");                
                $value->rencanaumumpengadaandet_volume = number_format($value->rencanaumumpengadaandet_volume,2,",","");                
                $value->rencanaumumpengadaandet_jmlpajak = number_format($value->rencanaumumpengadaandet_jmlpajak,2,",","");                
                $value->rencanaumumpengadaandet_volumeawal = $value->rencanaumumpengadaandet_volume;
                $value->rencanaumumpengadaandet_persenpajakawal = $value->rencanaumumpengadaandet_pajak;
                $value->rencanaumumpengadaandet_totalawal = $value->rencanaumumpengadaandet_jumlah;
                $value->rencanaumumpengadaandet_estimasiawal = $value->rencanaumumpengadaandet_harga;
                $value->serapan = MyFormatter::formatNumberForPrint($serapan, 2);
                $tr .= $this->renderPartial($this->path_view_revisi."_rowRAB", array('modRAB' => $value, 'i' => $key), true);
                $total += $detJumlah;
                $total_sisapagu += $value->sisapagu_pengadaan;
                $total_serapan += $serapan;
            }
            echo $tr;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" style="text-align: right;"><label>Total Harga</label></th>
                <th>
                    <?php echo $form->hiddenField($model,'total_harga',array('readonly'=>true, 'value' => number_format($model->total_harga,2,",","."), 'class'=>'integer-decimal')); ?>
                    <?php echo $form->hiddenField($model,'total_pajak',array('readonly'=>true, 'value' => number_format($model->total_pajak,2,",","."), 'class'=>'integer-decimal')); ?>
                    <?php echo CHtml::hiddenField('jenis_trans',(($model->ispaket)?'paket':'nonpaket'),array('readonly'=>true, 'class'=>'')); ?>
                    <?php
                    echo CHtml::textField('total_hargaseluruhnya', number_format($total,2,",","."), array('readonly' => true, 'class' => 'span3 required integer-decimal total_hargaseluruhnya'));
                    ?>
                </th>
                <th>
                    <?php
                    echo CHtml::textField('total_serapan', number_format($total_serapan,2,",","."), array('readonly' => true, 'class' => 'span3 required integer-decimal total_serapan'));
                    ?>
                </th>
                <th>
                    <?php
                    echo CHtml::textField('total_sisapagu', number_format($total_sisapagu,2,",","."), array('readonly' => true, 'class' => 'span3 required integer-decimal total_sisapagu'));
                    ?>
                </th>
                <th></th>
            </tr>
        </tfoot>
    </table>
<table class="hide" id="tabelHapusRAB">
    <tbody>
        
    </tbody>
</table>