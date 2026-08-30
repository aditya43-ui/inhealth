<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<fieldset>
      <legend class="rim2">Pendaftaran Pemeriksaan Pasien</legend>
    <legend class="rim">Data Pasien</legend>
    <table class="table table-condensed">
        <tr>
            <tr>
            <td><?php echo CHtml::label('Tgl. Pendaftaran', 'tgl_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('tglPendaftaran', '', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::label('No. Rekam Medik', 'no_rekam_medik',array('class'=>'control-label')); ?></td>
            <td>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
//                                    'model'=>$modPasien,
                                    'name'=>'no_rekam_medik',
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('sistemAdministrator/ActionAutoComplete/daftarPasien').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                     'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                isiDataPasien(ui.item);
                                                return false;
                                            }',
                                    ),
                                )); 
                ?>
            </td>
            <td rowspan="4">
                <?php 
                   
                        echo CHtml::image(Params::urlPhotoPasienDirectory().'no_photo.jpeg', 'Foto pasien', array('width'=>120));
                ?> 
            </td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('No. Pendaftaran', 'no_pendaftaran',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('noPendaftaran', '', array('readonly'=>true)); ?></td>
            
            
            <td><?php echo CHtml::label('Nama Pasien', 'nama_pasien',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('namaPasien', '', array('readonly'=>true)); ?></td>
        </tr>
            <td><?php echo CHtml::label('Jenis Kasus Penyakit', 'jeniskasuspenyakit_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('jenisKasusPenyakit', '', array('readonly'=>true)); ?></td>
        
            
            <td><?php echo CHtml::label('Bin', 'bin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('namaBin', '', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('Kelas Pelayanan', 'kelaspelayanan_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('kelaspelayanan', '', array('readonly'=>true)); ?></td>
            
            
            <td><?php echo CHtml::label('Umur', 'umur',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('umur', '', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('Jenis Penjamin', 'carabayar_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('caraBayar', '', array('readonly'=>true)); ?></td>
            
            
            <td><?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('jeniskelamin', '', array('readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td><?php echo CHtml::label('Penjamin', 'penjamin_id',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('penjaminNama', '', array('readonly'=>true)); ?></td>
            
            <td><?php echo CHtml::Label('Dokter Pemeriksa', 'Dokter Pemeriksa',array('class'=>'control-label')); ?></td>
            <td><?php echo CHtml::textField('pegawaiNama', '', array('readonly'=>true)); ?></td>
        </tr>
    </table>
</fieldset>
<?php echo CHtml::hiddenField('idPasienKirimKeunitLain', '',array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('idKelasPelayanan', '',array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('pendaftaran_id', '',array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('statuspasien', '',array('readonly'=>true)); ?>
<?php echo CHtml::hiddenField('pasien_id', '',array('readonly'=>true)); ?>
<hr>

<script type="text/javascript">
function isiDataPasien(data)
{
    $('#idKelasPelayanan').val(data.kelaspelayanan_id);
    $('#idPasienKirimKeunitLain').val(data.pasienkirimkeunitlain_id);
    $('#pendaftaran_id').val(data.pendaftaran_id);
    $('#pasien_id').val(data.pasien_id);
    $('#statuspasien').val(data.statuspasien);
    $('#namaPasien').val(data.nama_pasien);
    $('#namaBin').val(data.nama_bin);
    $('#jeniskelamin').val(data.jeniskelamin);
    $('#tglPendaftaran').val(data.tgl_pendaftaran);
    $('#umur').val(data.umur);
    $('#noPendaftaran').val(data.no_pendaftaran);
    $('#jenisKasusPenyakit').val(data.jeniskasuspenyakit_nama);
    $('#caraBayar').val(data.carabayar_nama);
    $('#kelaspelayanan').val(data.kelaspelayanan_nama);
    $('#penjaminNama').val(data.penjamin_nama);
    $('#pegawaiNama').val(data.nama_pegawai);
    
}
</script>
