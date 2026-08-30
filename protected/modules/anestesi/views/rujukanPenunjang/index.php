<style>
	.glyphicon{
		font-size: 21px !important;
	}
</style>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Pasien Rujukan</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <b>Pasien Rujukan</b></div>
            </div>						
            <div class="panel-body">
                <?php 
                $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'pasienpenunjangrujukan-m-grid',
                    'dataProvider'=>$dataProvider,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed table-bordered',
                    'columns'=>array(
                        /*array(
                            'header' => 'No Urut',
                            'value' => '$data->nourut',
                        ),*/
                        array(
                            'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                            'name'=>'tgl_pendaftaran',
                            'type'=>'raw',
                            'value'=>'$data->tgl_pendaftaran."/<br/>".$data->no_pendaftaran',
                        ),
                        'tgl_kirimpasien',
                        array(
                            'header' => 'Instalasi<br/>Ruangan Asal',
                            'name' => 'instalasi_ruangan',
                            'value' => '$data->InstalasiNamaRuanganNama',
                        ),
                        'no_rekam_medik',
                        array(
                            'header' => 'Nama Pasien',
                            'name' => 'nama_pasien_panggilan',
                            'value' => '$data->namadepan.$data->nama_pasien',
                        ),
                        'alamat_pasien',
                        array(
                            'header' => 'Kasus Penyakit',
                            'name' => 'kasus_pelayanan',
                            'type' => 'raw',
                            'value' => '"$data->jeniskasuspenyakit_nama"',
                        ),
                        array(
                            'header'=>'Jenis Penjamin / Penjamin',
                            'value'=>'$data->CaraBayarPenjaminNama',
                        ),
                        array(
                            'header'=>'Evaluasi Pra Anastesi',
                            'value'=>function($data){
                                echo CHtml::link("<i class='icon-form-ubah'> </i>",Yii::app()->createUrl('/anestesi/evaluasiPraAnestesi/index&pendaftaran_id='.$data->pendaftaran_id.'&pasienkirimkeunitlain_id='.$data->pasienkirimkeunitlain_id),array("rel"=>"tooltip","title"=>"Klik untuk Menambahkan Rencana Anestesi"));
                                   
                            },
                        )
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                ));
                ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i>Pencarian</div>
            </div>						
            <div class="panel-body">				
                <?php
                $this->renderPartial($this->path_view_rujuk.'_formSearch',array('model' => $model)); 
                ?>				
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
// document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
// document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
function cekTanggal(){

    var checklist = $('#cbTglMasuk');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('tgl_awal_date').setAttribute("style","display:block;");
        document.getElementById('tgl_akhir_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
        document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
    }
}    
{
  
}
</script>