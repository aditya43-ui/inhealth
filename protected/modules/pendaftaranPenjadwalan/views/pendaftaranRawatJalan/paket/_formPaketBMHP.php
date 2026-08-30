<div class="control-group">
    <label class="control-label">Tipe Tarif</label>
    <div class="controls">
        <?php echo CHtml::dropDownList('input_tipepaket', null, CHtml::listData(
            TipepaketM::model()->findAll('tipepaket_aktif = true and is_paketmedis = true order by tipepaket_nama asc'),
            'tipepaket_id', 'tipepaket_nama'
        ), array('empty'=>'-- Pilih --', 'onchange'=>'loadListPaketBMHP()')); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">Nama Paket Medis</label>
    <div class="controls">
        <?php echo CHtml::dropDownList('input_paketbmhp', null, array(), array('empty'=>'-- Pilih --')); ?>
    </div>
</div>

<div class="control-group">
    <label class="control-label">&nbsp;</label>
    <div class="controls">
       <?php echo CHtml::htmlButton("+", array('class'=>'btn btn-success', 'onclick'=>'tambahPaketBMHP();')); ?>
    </div>
</div>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Tipe Paket</th>
            <th>Nama Paket</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody class="tab_bmhp">

    </tbody>
</table>

<script>

function loadListPaketBMHP() {
    var id = $("#input_tipepaket").val();
    $.post('<?php echo $this->createURL('loadListPaketBMHP'); ?>', {id: id}, function(data) {
        $("#input_paketbmhp").html(data.html);
    }, 'json');
}

function tambahPaketBMHP() {
    var paket_id = $("#input_paketbmhp").val();

    if (paket_id == "") {
        myAlert("Paket medis harus dipilih.");
    }

    $.post('<?php echo $this->createUrl('loadPaketBMHP'); ?>', {id: paket_id}, function(data) {
        if (data.ok == 0) {x
            myAlert(data.msg);
        } else {
            $(".tab_bmhp").append(data.html);
        }
        $("#input_tipepaket").val("");
        $("#input_paketbmhp").val("");
    }, 'json');
}

function hapusRowPaket(obj) {
    $(obj).parents("tr").remove();
}

</script>

