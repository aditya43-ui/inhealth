<style>
.btn-grey {
    background-color: grey;
    color: white;
    font-weight: bold;
}

.btn-blue {
    background-color: blue;
    color: white;
    font-weight: bold;
}


.btn-green {
    background-color: green;
    color: white;
    font-weight: bold;
}


.btn-orange {
    background-color: orange;
    color: white;
    font-weight: bold;
}

.btn-red {
    background-color: red;
    color: white;
    font-weight: bold;
}

.btn-blue-rev {
    background-color: white;
    border-color: blue;
    color: blue;
    font-weight: bold;
}

.btn-group .btn-blue-rev:hover {
    background-color: blue;
    border-color: white;
    color: white;
    font-weight: bold;
}
</style>

<table class="table table-striped table-bordered table-condensed" style="width: 100%;">
    <thead>
        <tr>
            <td style="width: 5%;">No</td>
            <td style="width: 10%;">No. Lab</td>
            <td style="width: 25%;">Jenis Pemeriksaan</td>
            <td style="">Sample Lab</td>
            <td style="">Cara Ambil Sample</td>
            <td style="">Pemeriksaan</td>
        </tr>
    </thead>
    <tbody>
        <?php
        // var_dump($model->pasienmasukpenunjang_id); die;
            $penunjang = PasienmasukpenunjangT::model()->findByPk($model->pasienmasukpenunjang_id);

            $crit = new CDbCriteria;
            $crit->select = 'caraambilsampel_id, jenispemeriksaanlab_id, samplelab_id, no_lab, daftartindakan_id, tindakanpelayanan_id, pasienmasukpenunjang_id';
            $crit->group = $crit->select;
            $crit->addCondition("pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id");

            $tindakan = TindakanpelayananT::model()->findAll($crit);
        ?>
        <?php foreach ($tindakan as $no => $tindakan) {?>
        <tr class="tr-periksa">
            <td class="td-no" style="text-align: right;"><?= $no+1 ?></td>
            <td class="td-nolab"><?= $tindakan->no_lab ?></td>
            <td class="td-jenis">
                <?= isset($tindakan->jenispemeriksaanlab_id) ? $tindakan->jenispemeriksaanlab->jenispemeriksaanlab_nama : ' - ' ?>
            </td>
            <td class="td-sample"><?= isset($tindakan->samplelab) ? $tindakan->samplelab->samplelab_nama : ' - ' ?></td>
            <td class="td-cara">
                <?= isset($tindakan->caraambilsampel) ? $tindakan->caraambilsampel->caraambilsampel_nama : ' - ' ?></td>

            <td class="td-pemeriksaan">
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo CHtml::link('Kultur', $this->createUrl('pemeriksaanKultur', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id, 'pemeriksaan' => 'kultur')), array('class' => 'btn btn-grey')); ?>
                        <?php echo CHtml::link('Pewarnaan Langsung', $this->createUrl('pewarnaanLangsung', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id)), array('class' => 'btn btn-blue')); ?>
                        <?php echo CHtml::link('CCI', $this->createUrl('cci', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id)), array('class' => 'btn btn-green')); ?>
                        <?php echo CHtml::link('PCR COVID', $this->createUrl('pcrCovid', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id, 'daftartindakan_id'=>$tindakan->daftartindakan_id, 'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id)), array('class' => 'btn btn-orange')); ?>
                        <?php echo CHtml::link('VIRAL LOAD', $this->createUrl('viralLoad', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id)), array('class' => 'btn btn-red')); ?>
                        <?php echo CHtml::link('TBC', $this->createUrl('Tbc', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id)), array('class' => 'btn btn-blue-rev')); ?>
                    </div>
                </center>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<script>
function setOneRow() {
    $('.tr-periksa').each(function(idx) {

        var no = $(this).find('.td-no').html();
        var lab = $(this).find('.td-nolab').html();
        var jenis = $(this).find('.td-jenis').html();
        var sample = $(this).find('.td-sample').html();
        var cara = $(this).find('.td-cara').html();

        var idx_awal = 0;
        var rowspan = 1;

        if (idx > 0) {

            var idx_sbl = parseInt(idx) - 1;
            var idx_skr = parseInt(idx);

            var jns_sbl = $('.td-jenis').eq(idx_sbl).html();
            var jns_skr = $('.td-jenis').eq(idx_skr).html();

            if (jns_sbl == jns_skr) {
                $('.td-no').eq(idx_skr).addClass('hide');
                $('.td-nolab').eq(idx_skr).addClass('hide');
                $('.td-jenis').eq(idx_skr).addClass('hide');
                $('.td-sample').eq(idx_skr).addClass('hide');
                $('.td-cara').eq(idx_skr).addClass('hide');
                $('.td-pemeriksaan').eq(idx_skr).addClass('hide');
                rowspan++;
                $('.td-no').eq(idx_awal).attr('rowspan', rowspan);
                $('.td-nolab').eq(idx_awal).attr('rowspan', rowspan);
                $('.td-jenis').eq(idx_awal).attr('rowspan', rowspan);
                $('.td-sample').eq(idx_awal).attr('rowspan', rowspan);
                $('.td-cara').eq(idx_awal).attr('rowspan', rowspan);
                $('.td-pemeriksaan').eq(idx_awal).attr('rowspan', rowspan);

            } else {
                idx_awal = idx;
            }
        }

    });

    $('.td-no').not('.hide').each(function(idx) {
        $(this).html(idx+1);
    });
}

$(document).ready(function() {

    setOneRow();

});
</script>