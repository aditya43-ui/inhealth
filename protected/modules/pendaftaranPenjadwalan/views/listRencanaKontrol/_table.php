<?php
$itemsCssClass = 'table table-striped table-bordered table-condensed';
$table = 'ext.bootstrap.widgets.BootGridView';
$sort = true;
if (isset($caraPrint)) {
    $data = $model->listRencanaKontrol();
    $data->pagination = false;
    $template = "{items}";
    $sort = false;
    if ($caraPrint == "EXCEL") {
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }        
} else {
    $data = $model->listRencanaKontrol();
    $template = "{summary}\n{items}\n{pager}";    
}

$this->widget($table, array(
    'id' => 'list-rencana-kontrol-grid',
    'dataProvider' => $data,
    'template' => $template,
    'itemsCssClass' => $itemsCssClass,
    'columns' => $model->columnListRencanaKontrol,
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});cekData();}',
)); ?>

<script>
    function print(res) {
        // var dt = JSON.parse(res);
        console.log(res.jnsKontrol);
        let kelamin = "-";
        let tglLahir = "-";
        let diagnosa = "-";
        if(res.search_no_surat_kontrol.sep != undefined){
             kelamin = res.search_no_surat_kontrol.sep.peserta.kelamin ?? "-";
             tglLahir = res.search_no_surat_kontrol.sep.peserta.tglLahir ?? "-";
             diagnosa = res.search_no_surat_kontrol.sep.diagnosa ?? "-";
        }
        if(res.search_kartu.peserta != undefined){
            kelamin = res.search_kartu.peserta.sex ?? "-";
            tglLahir = res.search_kartu.peserta.tglLahir ?? "-";  
            if(kelamin == 'L'){
                kelamin = 'Laki-Laki';
            }else {
                kelamin = 'Perempuan';
            }         
        }

        // if(res.jnsKontrol == 1){
        //     window.open('index.php?r=asuransi/listRencanaKontrol/printSpri&noKartu='+res.noKartu+'&noSuratKontrol='+res.noSuratKontrol+'&nama='+res.nama+'&namaDokter='+res.namaDokter+'&tglRencanaKontrol='+res.tglRencanaKontrol+'&kelamin='+kelamin+'&tglLahir='+tglLahir+'&diagnosa='+diagnosa+'&tglTerbitKontrol='+res.tglTerbitKontrol+'&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=860,height=480');
        // }else {
        //     window.open('index.php?r=asuransi/listRencanaKontrol/printRencanaKontrol&noKartu='+res.noKartu+'&noSuratKontrol='+res.noSuratKontrol+'&nama='+res.nama+'&namaDokter='+res.namaDokter+'&tglRencanaKontrol='+res.tglRencanaKontrol+'&kelamin='+kelamin+'&tglLahir='+tglLahir+'&diagnosa='+diagnosa+'&tglTerbitKontrol='+res.tglTerbitKontrol+'&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=860,height=480'); 
        // }



        window.open('<?= $this->createUrl('print') ?>&noKartu='+res.noKartu+'&noSuratKontrol='+res.noSuratKontrol+'&nama='+res.nama+'&kodeDokter='+res.kodeDokter+'&namaDokter='+res.namaDokter+'&tglRencanaKontrol='+res.tglRencanaKontrol+'&kelamin='+kelamin+'&tglLahir='+tglLahir+'&diagnosa='+diagnosa+'&tglTerbitKontrol='+res.tglTerbitKontrol+'&jnsKontrol='+res.jnsKontrol+'&caraPrint=PRINT', 'printwin', 'left=100,top=100,width=860,height=480');

        // window.open('<?php //echo $this->createUrl('listRencanaKontrol/print&', array()); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>