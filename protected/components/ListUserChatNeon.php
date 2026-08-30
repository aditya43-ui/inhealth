<?php

class ListUserChatNeon extends CWidget
{
    protected $messages;
    protected $userOnline;
    public $htmlOptions;

    public function init() {
            //$criteria = new CDbCriteria;
            //$criteria->compare('loginpemakai_aktif', true);
            //$criteria->compare('statuslogin', true);
            //$criteria->order = 'statuslogin, nama_pemakai ASC';
            //$this->userOnline = LoginpemakaiK::model()->findAll($criteria);
        
        $criteria = new CDbCriteria;
            $criteria->compare('loginpemakai_aktif', true);
            $criteria->compare('statuslogin', true);
            $criteria->order = 'statuslogin, nama_pemakai ASC';
            //$this->userOnline = LoginpemakaiK::model()->findAll($criteria);
			
			$login = LoginpemakaiK::model()->findAll($criteria);
			
			$group = array();
						
			//var_dump(count($login));die;
			foreach($login as $log){
				
				if (!empty($log->ruanganaktifitas))
				{
					$r_nama = RuanganM::model()->findByPk($log->ruanganaktifitas);
					$group[$log->ruanganaktifitas]['ruangan_nama'] =  $r_nama->ruangan_nama;
					$group[$log->ruanganaktifitas]['login'][$log->loginpemakai_id]['nama_pegawai'] =  (isset($log->pegawai_id))?$log->pegawai->nama_pegawai:$log->nama_pemakai;
					$group[$log->ruanganaktifitas]['login'][$log->loginpemakai_id]['nama_pemakai'] =  $log->nama_pemakai;
					$group[$log->ruanganaktifitas]['login'][$log->loginpemakai_id]['statuslogin'] =  $log->statuslogin;
					$group[$log->ruanganaktifitas]['login'][$log->loginpemakai_id]['loginpemakai_id'] =  $log->loginpemakai_id;
				}else{
					$group['no jabatan']['ruangan_nama'] =  'Belum Login';
					$group['no jabatan']['login'][$log->loginpemakai_id]['nama_pegawai'] = (isset($log->pegawai_id))?$log->pegawai->nama_pegawai:$log->nama_pemakai;
					$group['no jabatan']['login'][$log->loginpemakai_id]['nama_pemakai'] =  $log->nama_pemakai;
					$group['no jabatan']['login'][$log->loginpemakai_id]['statuslogin'] =  $log->statuslogin;
					$group['no jabatan']['login'][$log->loginpemakai_id]['loginpemakai_id'] =  $log->loginpemakai_id;
				}				
				
			}
			
            $this->userOnline = $group;
    }

    public function run() {
        echo CHtml::openTag('div', $this->htmlOptions);
        $this->renderItems($this->userOnline);
        echo '</div>';
    }

    /**
     * Renders the items in this menu.
     * @param array $items the menu items
     */
    public function renderItems($userOnline)
    {
        $this->render('listUserChatNeon/listNeon',array('userOnline'=>$userOnline));
    }
}
?>
