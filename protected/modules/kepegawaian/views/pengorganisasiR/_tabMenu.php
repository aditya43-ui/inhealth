<?php
            $this->widget('bootstrap.widgets.BootMenu',array(
                'type'=>'tabs',
                'stacked'=>false,
                'items'=>array(
                    array('label'=>'Pendidikan','url'=>'#'),
                    array('label'=>'Diklat','url'=>'#'),
                    array('label'=>'Pengalaman kerja','url'=>'#'),
                    array('label'=>'Pengalaman Organisasi','url'=>'','active'=>true,),
                    array('label'=>'Jabatan','url'=>'#'),
                    array('label'=>'Pangkat','url'=>'#'),
                    array('label'=>'Mutasi kerja','url'=>'#'),
                    array('label'=>'Cuti ijin tugas belajar','url'=>'#'),
                    array('label'=>'Hukuman disiplin','url'=>'#'),
                ),
            ))
        ?>