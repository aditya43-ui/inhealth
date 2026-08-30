<div class="panel_dialog_cari dialog_sep">
    <table class="table table-bordered table-condensed tab_riwayat_base">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>No. Sep</th>
                <th>Tgl. Sep</th>
                <th>No. Kartu dan Nama Peserta</th>
                <th>No. Rujukan</th>
                <th>Diagnosa</th>
                <th>Poliklinik</th>
            </tr>
        </thead>
        <tbody class="tab_riwayat_sep">
            
        </tbody>
    </table>
</div>


<script>


    function setNomorDanCariRiwayatSEP() {

        var no_kartu = $("#nomorkartu").val();

        $("#dialogRiwayatSep").dialog("open");


        $(".tab_riwayat_sep").empty();
        $(".tab_riwayat_base").addClass('animation-loading');

        $.post('<?php echo $this->createUrl('getLoadRiwayatSEP'); ?>', {
            nokartu: no_kartu
        }, function(data) {
            if (data.ok != 1) {
                myAlert(data.msg);
            } else {
                $(".tab_riwayat_sep").html(data.html);
            }
            $(".tab_riwayat_base").removeClass('animation-loading');
        }, 'json');
    }


</script>