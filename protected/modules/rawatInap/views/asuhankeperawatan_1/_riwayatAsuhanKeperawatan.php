
<?php
if(!empty($tr)){
?>
       <div id="tablehide">
           <?php $this->widget('bootstrap.widgets.BootPager', array(
                    'pages' => $pages,    
                    'header'=>'<div class="pagination" id="pagin">',
                    'footer'=>'</div>',
           )); ?>
            <table class="items table table-striped table-bordered table-condensed">
            <thead>
                <tr >
                    <th rowspan="2">Tgl. Kunjungan/<br>No. Pendaftaran</th>
                    <th colspan ="2"><p style="margin: 0; text-align: center;">Anamnesis</p></th>  
                    <th colspan ="4"><p style="margin: 0; text-align: center;">Pemeriksaan Fisik</p></th>  
                    <th rowspan="2"><p style="margin: 0; text-align: center;">Nama Diagnosa</p></th>  
                    <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Tanggal Asuhan Keperawatan</p></th>  
                    <th rowspan="2"><p style="margin: 0; text-align: center;">Diagnosa Keperawatan</p></th>  
                    <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Rencana</p></th>  
                    <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Evaluasi</p></th>  
                    <th valign='middle' rowspan="2"><p style="margin: 0; text-align: center;">Planning</p></th>  
                </tr>
                <tr>
                    <th><p style="margin: 0; text-align: center;">Keluhan Utama</p></th>  
                    <th><p style="margin: 0; text-align: center;">Riwayat Penyakit</p></th>  
                    <th><p style="margin: 0; text-align: center;">TD</p></th>  
                    <th><p style="margin: 0; text-align: center;">DN</p></th>  
                    <th><p style="margin: 0; text-align: center;">ST</p></th>  
                    <th><p style="margin: 0; text-align: center;">TB/BB</p></th>  
                </tr>
            </thead>
            <tbody>
                <?php 
                    echo $tr;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    
                </tr>
            </tfoot>
        </table>
            </div>
        
        
<?php
} else {
?>
<div class="alert alert-block alert-error">
    <a class="close" data-dismiss="alert">×</a>
    Tidak ada data Riwayat Asuhan Keperawatan pasien
</div>

<?php   
}
?>