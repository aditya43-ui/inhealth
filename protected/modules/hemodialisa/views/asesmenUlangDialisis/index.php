<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Asesmen Ulang Dialisis</div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial('_dataPasien', array()); ?>
        <?php $this->renderPartial('_asesmenulangdialisis', ['modPemeriksaanLab' => $modPemeriksaanLab, 'modPendaftaran'=>$modPendaftaran, 'modPenyulitHD'=>$modPenyulitHD, 'modTransfusi'=>$modTransfusi, 'modGizi'=>$modGizi, 'modAwalDialisis'=>$modAwalDialisis]); ?>
        
        
    </div>
</div>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameRincian' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Alat Kesehatan ala cak lontong (non racik - therapi obat)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPendaftaran',
    'options'=>array(
        'title'=>'Pencarian No. Pendaftaran',
        'autoOpen'=>false,
        'position'=>['top',20] ,
        'modal'=>true,
        'width'=>550,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPendaftaran = new HDInfoKunjunganRDV('searchHD');
$modPendaftaran->unsetAttributes();
if(isset($_GET['HDInfoKunjunganRDV'])){
    $modPendaftaran->attributes = $_GET['HDInfoKunjunganRDV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pendaftaran-grid',
	'dataProvider'=>$modPendaftaran->searchAsesmen(),
	'filter'=>$modPendaftaran,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectPendaftaran",
                                    "onClick" => "
                                                setPendaftaran(\'$data->pendaftaran_id\');
                                                $(\'#dialogPendaftaran\').dialog(\'close\');
                                                return false;"))',
                ),
                'no_pendaftaran',
                'no_rekam_medik',
                'nama_pasien',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
<script>
    $(document).ready(function(){
        <?php if(isset($_GET['pendaftaran_id'])) { ?>
                var id = <?php echo $_GET['pendaftaran_id']; ?>;
//                console.log('pendaftaran_id = '+id);
                $.ajax({
                    url: '<?= $this->createUrl('setDataPasien') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {id:id},
                    success: function(data){
                        $('#pendaftaran_id').val(id);
                        $('#no_pendaftaran').val(data.no_pendaftaran);
                        $('#tgl_pendaftaran').val(data.tgl_pendaftaran);
                        $('#umur').val(data.umur);
                        $('#dokter_pemeriksa').val(data.dokter_pemeriksa);
                        $('#no_rm').val(data.no_rm);
                        $('#nama_pasien').val(data.nama_pasien);
                        $('#jk').val(data.jk);
                        $('#cara_bayar').val(data.cara_bayar);
                        $('#penjamin').val(data.penjamin);
//                        console.log(data);
                            
                    }
                })
                var dataset = <?= json_encode($grafik); ?>;
                generateGrafik($('#chart_tandavital'), 'line', dataset);
        <?php } ?>
    })
    
    function setPendaftaran(id){
//        console.log(id); return false;
        location.href = '<?= $this->createUrl('index&pendaftaran_id='); ?>'+id;
    }
    
    function hapusRiwayat(id){
        var url = '<?= Yii::app()->createUrl('rawatInap/asesmenAwalMedisAnak/hapusRiwayat') ?>';
//        console.log(url);return false;
        myConfirm('Apakah anda yakin menghapus data ini ?', 'Perhatian!', function(r){
            if(r){
                $.ajax({
                    url: url,
                    dataType: 'json',
                    type: 'post',
                    data: {id:id},
                    success: function(data){
                        if(data.sukses == 1){
                            toastr.success(data.pesan, "Perhatian!");
//                            location.href = '<?php //echo $this->createUrl('index&pendaftaran_id=') ?>'+pendaftaran_id;
                            window.location.reload();
                        }else{
                            toastr.error(data.pesan, "Perhatian!");
                        }
                    }
                })
            }
        })
    }
    
    function print(id) {
        window.open('<?php echo Yii::app()->createUrl('rawatInap/asesmenAwalMedisAnak/print'); ?>&id='+id, 'printwin', 'left=100,top=100,width=640,height=480');

    }
    
    function generateGrafik(id,tipe, getdata, jenis, legend){        
                                                        
       var dtset = getdata;    
        var display_tick_xaxes = true;        
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;
        
        if (tipe == 'pie'){
            display_tick_xaxes = false;
            display_tick_yaxes = false;
        }
        
        if (jenis == 'stacked'){
            stacked_yaxes = true;
        }
        
        if ( legend == 'off'){
            legend_display = false;
        }
           
       setTimeout(function(){
           var grafikTiga = new Chart(id,{
            type: tipe,            
            data: dtset,
            options: {                
                responsive: true,
                title: {
                    display: true,
                    text: ''
                },
                legend: {
                    display:legend_display,
                    position:'right'
                },
                tooltips: {
                        mode: 'index',
                        intersect: false,
                },
                plugins: {
                    labels: {
                      render: function (args) {
                        if (tipe == 'pie'){
                            return args.label+'\n'+args.percentage+'%';
                        }else{
                            return args.value;
                        }                        
                      },                                            
                       fontColor: '#333',
                       fontStyle: 'bold',
                    }
                },
                scales: {
                    xAxes: [{
                        ticks: {
                            display: display_tick_xaxes
                        } ,
                         stacked: stacked_yaxes,
                    }],
                    yAxes: [{
                            display: display_tick_yaxes,
                            stacked: stacked_yaxes,
                            ticks: {
                                min: 0,
                                max: 200,
                                stepSize: 20,
                                fontSize:15,            
                            }                               
                    }]
                },
              }
        });   
       },300);                                                  
                                                                        
    }
</script>

