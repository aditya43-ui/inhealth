<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Laporan Kartu Piutang',
);
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinoutTable.css');
$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikPiutang&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
/*
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
*/
");
?>
<style>
    .head_rek td {
        font-weight: bold;
    }

    .num {
        text-align: right !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kartu Piutang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $this->renderPartial('akuntansi.views.laporanKartu.piutang/_search', array(
                'model' => $model,
            )); ?>
        </div><!--search-form-->
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kartu Piutang</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="progress" id="progress_tabel">
                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only"></span>
                    </div>
                </div>

                <div class="table_content">

                </div>
                <div class="table_total">

                </div>
                <?php // $this->renderPartial('akuntansi.views.laporanKartu.piutang/_table', array('model'=>$model)); 
                ?>
                <?php // $this->renderPartial('_tab'); 
                ?>

            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPiutang');
        $this->renderPartial('akuntansi.views.laporanKartu._footerNoGraph', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>

<script>
    var tgl_awal;
    var tgl_akhir;
    var penjamin_id;

    var penjamin_list = new Array();
    var penjamin_list_cnt = 0;

    function loadPencarian() {
        $(".table_content").empty();
        //$(".table_content").hide();
        $(".table_total").empty();
        //$(".table_total").hide();

        $("#progress_tabel .progress-bar").css("width", "0%");

        tgl_awal = $("#AKLaporankartupiutangV_tgl_awal").val();
        tgl_akhir = $("#AKLaporankartupiutangV_tgl_akhir").val();
        penjamin_id = $("#AKLaporankartupiutangV_penjamin_id").val();
        penjamin_list = new Array();
        penjamin_list_cnt = 0;

        $("#btn_simpan").prop("disabled", true);

        $.get('<?php echo $this->createUrl('ajaxLaporanKartuPiutang'); ?>', {
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir,
            penjamin_id: penjamin_id
        }, function(data) {
            penjamin_list = data.penjamin;
            if (penjamin_list.length == 0) {
                console.log("Total : " + penjamin_list);
                $("#btn_simpan").prop("disabled", false);
                $("#progress_tabel .progress-bar").css("width", "0%");

                return false;
            }

            $(".table_total").html(data.row_total);
            $("#progress_tabel .progress-bar").css("width", (1 * 100 / (penjamin_list.length + 1)) + "%");
            rollingLoadPencarian(tgl_awal, tgl_akhir, penjamin_list[penjamin_list_cnt].penjamin_id);

        }, 'json');
    }

    function rollingLoadPencarian(tgl_awal, tgl_akhir, penjamin_id) {

        $.get('<?php echo $this->createUrl('ajaxLaporanKartuPiutangPenjamin'); ?>', {
            tgl_awal: tgl_awal,
            tgl_akhir: tgl_akhir,
            penjamin_id: penjamin_id
        }, setelahLoadPenjamin, 'json');
    }

    function setelahLoadPenjamin(data) {

        var total_debit = 0;
        var total_kredit = 0;
        var total_saldo = 0;

        penjamin_list_cnt++;

        $("#progress_tabel .progress-bar").css("width", ((penjamin_list_cnt + 1) * 100 / (penjamin_list.length + 1)) + "%");

        $(".table_content").append(data.html);



        $(".table_content .tab_penjamin").each(function(data) {
            total_debit += parseFloat($(this).find(".grand_debit").val());
            total_kredit += parseFloat($(this).find(".grand_kredit").val());
        });

        total_saldo = total_debit - total_kredit;

        if (total_saldo < 0) {
            total_saldo = "(" + accounting.formatMoney(Math.abs(total_saldo), '', 2, '.', ',') + ")";
        } else {
            total_saldo = accounting.formatMoney(Math.abs(total_saldo), '', 2, '.', ',');
        }

        $("#great_debit").html(accounting.formatMoney(total_debit, '', 2, '.', ','));
        $("#great_kredit").html(accounting.formatMoney(total_kredit, '', 2, '.', ','));
        $("#great_saldo").html(total_saldo);

        if (penjamin_list_cnt >= penjamin_list.length) {
            //$(".table_content").show();
            //$(".table_total").show();

            $("#btn_simpan").prop("disabled", false);
            return false;
        }

        rollingLoadPencarian(tgl_awal, tgl_akhir, penjamin_list[penjamin_list_cnt].penjamin_id);
    }

    $(document).ready(function() {

        var penjamin = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

        jQuery(penjamin).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '182px',
            enableCaseInsensitiveFiltering: true
        }).hide();
    });
</script>