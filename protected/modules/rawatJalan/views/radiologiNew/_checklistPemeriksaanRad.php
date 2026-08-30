<table style="width: 100%; border: none; height:auto; ">
    <tr>
        <td>
            <div id="formPeriksaRad" class="">

                <?php echo CHtml::hiddenField('berubah', '', array('readonly' => TRUE)); ?>
                <?php

    $ceklist = false;


    foreach ($modJenis as $i => $jenis) {
        $cekperiksa = '';

        $nama_subjenis = array();
        
        foreach ($modPeriksaRad as $j => $pemeriksaan) {
        
            $nama_pemeriksaan = $pemeriksaan->pemeriksaanrad_nama;
            $sub = '';

            $input_sub_hidden = "";

            if(!empty($pemeriksaan->subjenis_pemeriksaanrad_id)) {

                if (in_array($pemeriksaan->subjenis_pemeriksaanrad_id, $nama_subjenis)) {
                    $input_sub_hidden = 'style="display:none !important;"';
                }

                $nama_pemeriksaan = ($pemeriksaan->subjenis_pr_nama) ?? "-";
                $sub = ", "  . $pemeriksaan->subjenis_pemeriksaanrad_id;
                $nama_subjenis[$pemeriksaan->subjenis_pemeriksaanrad_id] = $pemeriksaan->subjenis_pemeriksaanrad_id;
            }

            if($pemeriksaan->jenispemeriksaanrad_id == $jenis->jenispemeriksaanrad_id) {
            
                $cekperiksa .= '<label class="checkbox inline sub-'.$pemeriksaan->subjenis_pemeriksaanrad_id.'" '.$input_sub_hidden.'>' . CHtml::checkBox("pemeriksaanLab[]", $ceklist, array(
                                'value' => $pemeriksaan->kode_unik,
                                'onclick' => "inputperiksa(this," . Params::RUANGAN_ID_LAB_KLINIK . $sub . ");",
                                'class' => 'input_ceklis',
                            ));
                $cekperiksa .= '<span>' . $nama_pemeriksaan;
                $cekperiksa .= " (".MyFormatter::formatNumberForPrint($pemeriksaan->harga_tariftindakan).")" . "</span>";
                
                $cekperiksa .= "</label>";
                if ($input_sub_hidden == "") {
                    $cekperiksa .= "<br>"; 
                }
        
            }     

        }

        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'tabel-riwayatanamnesa_' . $i,
                'content' => array(
                'content-detailanamnesa_' . $i => array(
                'header' => '<h6>' . $jenis->jenispemeriksaanrad_nama . '</h6>',
                'isi' => $cekperiksa,
                'active' => false,
                ),
            ),
        ));    
    }


    // echo '<pre>';


    // die;

?>

                <!-- </div> -->
            </div>
        </td>
    </tr>
</table>