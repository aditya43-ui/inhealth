<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('#oppekeperawatan-info-search').submit(function(){
	$('#informasiasuhankeperawatan-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasiasuhankeperawatan-grid', {
            data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>OPPE Keperawatan</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->renderPartial($this->path_view . '_search', array(
                    'model' => $model
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>OPPE Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="oppe-keperawatan">
                <?php
                $this->renderPartial($this->path_view . '_tableDefault', array(
                    'model' => $model,
                    'modDefault' => $modDefault
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
// ===========================Dialog Detail2=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetail',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Detail',
        'autoOpen' => false,
        'minWidth' => 1000,
        'height' => 320,
        'resizable' => false,
    ),
));
?>
<iframe src="" name="frameDetail" style="width: 100%; height: 98%; border: none;"></iframe>
<?php
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
    /**
     * Load data berdasarkan ajax
     * @returns {undefined}
     */
    function loadData() {
        var bulan_pilih = $('#LaporanoppekeperawatanV_bulan_pilih').val();
        var bulan_pilih_awal = $('#LaporanoppekeperawatanV_bulan_pilih_awal').val();
        var bulan_pilih_akhir = $('#LaporanoppekeperawatanV_bulan_pilih_akhir').val();
        var pegawai_id = $('#LaporanoppekeperawatanV_pegawai_id').val();
        var indikator = $('#LaporanoppekeperawatanV_indikatoroppekeperawatan_id').val();
        $('#informasiasuhankeperawatan-grid').addClass('animation-loading');
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetData'); ?>',
            data: {
                bulan_pilih: bulan_pilih,
                bulan_pilih_awal: bulan_pilih_awal,
                bulan_pilih_akhir: bulan_pilih_akhir,
                pegawai_id: pegawai_id,
                indikator: indikator
            },
            dataType: "json",
            success: function(data) {
                $('#oppe-keperawatan').html(data.return);
                $('#informasiasuhankeperawatan-grid').removeClass('animation-loading');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
    /**
     * Cek data sebelum disimpan
     * @returns {Boolean}     
     */
    function cekForm() {
        //        $("#oppekeperawatan-info-search").submit(); 
    }
    $(document).ready(function() {
        $('#LaporanoppekeperawatanV_bulan_pilih').monthpicker({
            pattern: 'mmmm yyyy'
        });
        $('#LaporanoppekeperawatanV_bulan_pilih_awal').monthpicker({
            pattern: 'mmmm yyyy'
        });
        $('#LaporanoppekeperawatanV_bulan_pilih_akhir').monthpicker({
            pattern: 'mmmm yyyy'
        });
        //        if($(".tabelawal")){
        //            $(".tabelawal").show();
        //            $(".tabel1").hide();
        //            $(".tabel2").hide();
        //        }else{
        //            $(".tabel1").show();
        //            $(".tabelawal").hide();
        //            $(".tabel2").hide();
        //        }
    });
</script>