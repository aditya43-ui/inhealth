<style>
.btn-blue {
    background-color: #6488EA;
    border-color: #6488EA;
}

.btn-blue:hover {
    background-color: #819EED;
    border-color: #819EED;
}
</style>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemeriksaanlaboratorium-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); ?>

<?php
    if (isset($_GET['sukses'])) {   
        $this->widget('bootstrap.widgets.BootAlert');
    }
?>



<table style="width: 100;" class="table table-bordered table-condensed table-stripped">
    <thead>
        <tr>
            <th>Jenis Pemeriksaan</th>
            <th>Sample Lab</th>
            <th>Alasan</th>
            <!-- <th>Pilih</th> -->
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($modPermintaan)):?>
        <?php foreach($modPermintaan as $i => $perm):?>
        <?php
            $jns_periksa = '';
            $periksa = '';    
            if(!empty($perm->pemeriksaanlab)) {
                $jns_periksa = $perm->pemeriksaanlab->jenispemeriksaan->jenispemeriksaanlab_nama;
                $periksa = $perm->pemeriksaanlab->pemeriksaanlab_nama;
            }    
        ?>
        <tr>
            <td class="jns-periksa"><?=$jns_periksa?></td>
            <td class="sample-periksa">
                <?= $perm->samplelab->samplelab_nama ?>

            </td>
            <td class="alasan-minta">
                <?php echo CHtml::dropDownList('permintaan[' . $i .'][alasan_mintaulangsampel]', $perm->alasan_mintaulangsampel, LookupM::getItems('mintaulangsampel'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'setAlasan(this);', 'disabled'=>true)) ?>

            </td>
            <td class="btn-minta-td" hidden>
                <?php echo CHtml::hiddenField('permintaan[' . $i .'][permintaankepenunjang_id]', $perm->permintaankepenunjang_id, ['class' => 'span1', 'onkeyup' => 'hitungTarif(this)']) ?>
                <?php echo CHtml::hiddenField('permintaan[' . $i .'][samplelab_id]', $perm->samplelab_id, ['class' => 'span1 samplelab_id', 'onkeyup' => 'hitungTarif(this)']) ?>
                <?php echo CHtml::hiddenField('permintaan[' . $i .'][mintaulang_samplelab_id]', $perm->mintaulang_samplelab_id, ['class' => 'span1 mintaulang_samplelab_id', 'onkeyup' => 'hitungTarif(this)']) ?>
                <?php if(!empty($perm->mintaulang_samplelab_id)):?>
                <?php echo CHtml::button("✖",array('id'=>'pilihminta','onclick' => 'setMintaUlang(this);', 'class'=>'btn btn-danger btn-minta', 'style'=>   'border-radius: 4px;'));  ?>
                <?php else:?>
                <?php echo CHtml::button("✔",array('id'=>'pilihminta','onclick' => 'setMintaUlang(this);', 'class'=>'btn btn-success btn-minta', 'style'=>   'border-radius: 4px;'));  ?>
                <?php endif;?>
            </td>
        </tr>
        <?php endforeach;?>
        <?php endif;?>
    </tbody>
</table>

<script>
function setAlasan(obj) {
    var alasan = $(obj).val();
    console.log('alasannya: ' + alasan);

    $('.mintaulang_samplelab_id').each(function() {
        if ($(this).val() !== "") {
            $(this).closest('tr').find('.alasan_mintaulangsampel').val(alasan);
        }
    });

}

function setMintaUlang(obj) {

    var samplelab_id = $(obj).closest('tr').find('.samplelab_id').val();
    var alasan = $('#mintaulang').val();

    if ($(obj).hasClass('btn-success')) {

        $(obj).closest('tr').find('.mintaulang_samplelab_id').val(samplelab_id);
        $(obj).closest('tr').find('.alasan_mintaulangsampel').val(alasan);

        $(obj).removeClass('btn-success');
        $(obj).addClass('btn-danger');
        $(obj).val('✖');
    } else {

        $(obj).closest('tr').find('.mintaulang_samplelab_id').val('');
        $(obj).closest('tr').find('.alasan_mintaulangsampel').val('');

        $(obj).removeClass('btn-danger');
        $(obj).addClass('btn-success');
        $(obj).val('✔');
    }
}

function setOneRowJenis() {

    $('.jns-periksa').each(function(idx) {

        console.log($('.jns-periksa').eq(idx).html() + ' ----- ' + $('.jns-periksa').eq(idx - 1).html());

        console.log(parseInt(idx) + ' ///////////////// ' + (parseInt(idx) - 1));

        var rowspan = 1;
        var rowspan_s = 1;
        var idx_pertama = 0;
        var idx_pertama_s = 0;

        if (parseInt(idx) - 1 < 0) {
            idx_pertama = 0;
        } else {
            if ($('.jns-periksa').eq(parseInt(idx)).html() == $('.jns-periksa').eq(parseInt(idx - 1)).html()) {
                $('.jns-periksa').eq(idx).closest('td').addClass('hide');
                rowspan++;
                $('.jns-periksa').eq(idx_pertama).attr('rowspan', rowspan);

                console.log($('.sample-periksa').eq(parseInt(idx_pertama)).html() + ' ------------------- ' + $(
                    '.sample-periksa').eq(parseInt(idx_pertama) - 1).html());
                if ($('.sample-periksa').eq(parseInt(idx_pertama)).html() == $('.sample-periksa').eq(parseInt(
                        idx_pertama) - 1).html()) {
                    console.log('tes sample sama');

                    $('.sample-periksa').eq(idx).closest('td').addClass('hide');
                    $('.alasan-minta').eq(idx).closest('td').addClass('hide');
                    $('.btn-minta-td').eq(idx).closest('td').addClass('hide');
                    rowspan_s++;
                    $('.sample-periksa').eq(idx_pertama_s).attr('rowspan', rowspan_s);
                    $('.alasan-minta').eq(idx_pertama_s).attr('rowspan', rowspan_s);
                    $('.btn-minta-td').eq(idx_pertama_s).attr('rowspan', rowspan_s);
                    console.log(rowspan_s);
                } else {
                    idx_pertama_s = idx;
                    rowspan_s = 1;
                }
            } else {
                idx_pertama = idx;
                idx_pertama_s = idx;
                rowspan = 1;
                rowspan_s = 1;
            }
        }
    });
}

$(document).ready(function() {
    setOneRowJenis();
});
</script>

<?php $this->endWidget(); ?>