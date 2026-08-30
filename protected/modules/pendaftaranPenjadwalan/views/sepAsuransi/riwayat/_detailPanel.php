<style>

    .riwayat_sep {
        border: 1px solid whitesmoke;
        border-radius: 5px;
        margin-bottom: 5px;
        padding: 5px;
    }

    .tab_sep_detail td {
        padding: 5px;
    }

</style>

<div class="panel panel-success" id="panel_riwayat_sep">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Sep Pasien</div>
    </div>
    <div class="panel-body">

        <?php
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked' => false, // whether this is a stacked menu
            'items' => array(
                array('label' => 'Data Pasien', 'url' => '#', 'itemOptions' => array(
                    'onclick'=>'pilihPanelRiwayat(1); return false;', 'class'=>'tab_riwayat',
                )),
                array('label' => 'Riwayat', 'url' => '#', 'itemOptions' => array(
                    'onclick'=>'pilihPanelRiwayat(2); return false;', 'class'=>'tab_riwayat',
                )),
            ),
        ));
        ?>

        <div id="detail_kartu" class="panel_tab_detail">

        </div>
        <div id="detail_riwayat" class="panel_tab_detail">

        </div>
    </div>
</div>

<script>
    var no_panel = 1;

    function renderPanelRiwayat() {
        $(".tab_riwayat").removeClass("active");
        $(".panel_tab_detail").hide();
        if (no_panel == 1) {
            $(".tab_riwayat").eq(0).addClass("active");
            $("#detail_kartu").show();
        }
        if (no_panel == 2) {
            $(".tab_riwayat").eq(1).addClass("active");
            $("#detail_riwayat").show();
        }
    }

    function pilihPanelRiwayat(v) {
        no_panel = v;
        renderPanelRiwayat();
    }

    $(document).ready(function() {
        renderPanelRiwayat();
    });

    function setDetailSep(data_sep) {
        $(".riwayat_sep_detail").empty();
        $.post('<?php echo $this->createUrl('detailSep'); ?>', {
            data: data_sep
        }, function(data) {
            if (data.ok == 0) {
                myAlert(data.msg);
            } else {
                $(".riwayat_sep_detail").html(data.html);
            }
        }, 'json');
    }
</script>