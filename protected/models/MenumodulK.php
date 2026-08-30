<?php

/**
 * This is the model class for table "menumodul_k".
 *
 * The followings are the available columns in table 'menumodul_k':
 * @property integer $menu_id
 * @property integer $kelmenu_id
 * @property integer $modul_id
 * @property string $menu_nama
 * @property string $menu_namalainnya
 * @property string $menu_key
 * @property string $menu_url
 * @property string $menu_fungsi
 * @property integer $menu_urutan
 * @property boolean $menu_aktif
 * @property string $menu_icon
 * @property string $menu_shortcut
 */
class MenumodulK extends CActiveRecord
{
        public $kelmenu_nama, $kelmenu_url;
        public $tgl_awal, $tgl_akhir;
        public $bln_awal, $bln_akhir;
        public $thn_awal, $thn_akhir;
        public $jns_periode; 
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenumodulK the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menumodul_k';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kelmenu_id, modul_id, menu_nama, menu_url', 'required'),
			array('kelmenu_id, modul_id, menu_urutan', 'numerical', 'integerOnly'=>true),
			array('menu_nama, menu_namalainnya, menu_key', 'length', 'max'=>100),
			array('menu_url', 'length', 'max'=>100),
			array('menu_aktif, menu_icon,menu_shortcut,menu_fungsi', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('menu_id, kelmenu_id, modul_id, menu_nama, menu_namalainnya, menu_key, menu_url, menu_fungsi, menu_urutan, menu_aktif, menu_icon,menu_shortcut', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'kelompokmenu' => array(self::BELONGS_TO, 'KelompokmenuK', 'kelmenu_id'),
			'modulk' => array(self::BELONGS_TO, 'ModulK', 'modul_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'menu_id' => 'ID',
			'kelmenu_id' => 'Kelompok Menu',
			'modul_id' => 'Nama Modul',
			'menu_nama' => 'Menu',
			'menu_namalainnya' => 'Nama Lainnya',
			'menu_key' => 'Key',
			'menu_url' => 'Url',
			'menu_fungsi' => 'Fungsi',
			'menu_urutan' => 'Urutan',
			'menu_aktif' => 'Aktif',
			'menu_icon' => 'Icon Menu',
                        'menu_shortcut'=>'Shortcut Menu'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('menu_id',$this->menu_id);
		$criteria->compare('kelmenu_id',$this->kelmenu_id);
		$criteria->compare('modul_id',$this->modul_id);
		$criteria->compare('LOWER(menu_nama)',strtolower($this->menu_nama),true);
		$criteria->compare('LOWER(menu_namalainnya)',strtolower($this->menu_namalainnya),true);
		$criteria->compare('LOWER(menu_key)',strtolower($this->menu_key),true);
		$criteria->compare('LOWER(menu_url)',strtolower($this->menu_url),true);
		$criteria->compare('LOWER(menu_fungsi)',strtolower($this->menu_fungsi),true);
		$criteria->compare('LOWER(menu_icon)',strtolower($this->menu_icon),true);
		$criteria->compare('LOWER(menu_shortcut)',strtolower($this->menu_shortcut),true);
		$criteria->compare('menu_urutan',$this->menu_urutan);
		$criteria->compare('menu_aktif',isset($this->menu_aktif)?$this->menu_aktif:true);
                $criteria->order = 'kelompokmenu.kelmenu_nama, menu_urutan';
                $criteria->with = array('kelompokmenu','modulk');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('t.menu_id',$this->menu_id);
		$criteria->compare('t.kelmenu_id',$this->kelmenu_id);
		$criteria->compare('t.modul_id',$this->modul_id);
		$criteria->compare('LOWER(menu_nama)',strtolower($this->menu_nama),true);
		$criteria->compare('LOWER(menu_namalainnya)',strtolower($this->menu_namalainnya),true);
		$criteria->compare('LOWER(menu_key)',strtolower($this->menu_key),true);
		$criteria->compare('LOWER(menu_url)',strtolower($this->menu_url),true);
                $criteria->compare('LOWER(menu_icon)',strtolower($this->menu_icon),true);
                $criteria->compare('LOWER(menu_shortcut)',strtolower($this->menu_shortcut),true);
		$criteria->compare('LOWER(menu_fungsi)',strtolower($this->menu_fungsi),true);
		$criteria->compare('menu_urutan',$this->menu_urutan);
//		$criteria->compare('menu_aktif',$this->menu_aktif);
                $criteria->order = 'kelompokmenu.kelmenu_nama, menu_urutan';
                $criteria->with = array('kelompokmenu','modulk');
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
        public function beforeSave() {
            $this->menu_nama = ucwords(strtolower($this->menu_nama));
            $this->menu_namalainnya = strtoupper($this->menu_namalainnya);
            return parent::beforeSave();
        }
                
        public function getKelompokMenuItems()
        {
            return SAKelompokMenuK::model()->findAll(array('order'=>'kelmenu_nama'));
        }
        
        public function getKelompokMenu()
        {
            return SAKelompokMenuK::model()->findByPk($this->kelmenu_id)->kelmenu_nama;
        }
                
        public function getModulItems()
        {
            return SAModulK::model()->findAll(array('order'=>'modul_nama'));
        }
        
        public function getModul()
        {
            return SAModulK::model()->findByPk($this->modul_id)->modul_nama;
        }
        /**
		 * menampilkan menu berdasarkan hak akses
		 * @param type $compare
		 * @return type
		 */
        public function findAllAktif($compare=array())
        {
			// tambahan code untuk tidak menampilkan menu berdasarkan Konfigurasi otorisasi Approval  di systemadministrator
			$approvalKeuangan = ApprovalkeuanganK::model()->findAllByAttributes(['pegawai_id' => Yii::app()->user->getState('pegawai_id')]);
			// echo '<pre>';var_dump($approvalKeuangan);die;
			$arrMenuId = [Params::MENU_ID_BATAL_ALOKASI, Params::MENU_ID_BATAL_PEMBAYARAN, Params::MENU_ID_BATAL_TINDAKAN, Params::MENU_ID_BATAL_VERIFIKASI, Params::MENU_ID_PASIEN_RESEPTUR_OK, Params::MENU_ID_PASIEN_RESEPTUR_TRIAGE];
			if(!empty($approvalKeuangan)) {
				foreach($approvalKeuangan as $i => $val) {
					if($val->menu_id == Params::MENU_ID_BATAL_ALOKASI) {
						$elementToRemove = $val->menu_id;
						$arrMenuId = array_filter($arrMenuId, function ($value) use ($elementToRemove) {
							return $value != $elementToRemove;
						});
					}
					if($val->menu_id == Params::MENU_ID_BATAL_PEMBAYARAN) {
						$elementToRemove = $val->menu_id;
						$arrMenuId = array_filter($arrMenuId, function ($value) use ($elementToRemove) {
							return $value != $elementToRemove;
						});
					}
					if($val->menu_id == Params::MENU_ID_BATAL_TINDAKAN) {
						$elementToRemove = $val->menu_id;
						$arrMenuId = array_filter($arrMenuId, function ($value) use ($elementToRemove) {
							return $value != $elementToRemove;
						});
					}
					if($val->menu_id == Params::MENU_ID_BATAL_VERIFIKASI) {
						$elementToRemove = $val->menu_id;
						$arrMenuId = array_filter($arrMenuId, function ($value) use ($elementToRemove) {
							return $value != $elementToRemove;
						});
					}
				}
			}

			$menuRuangan = MenuruanganfarmasiK::model()->findAllByAttributes(['ruangan_id' => Yii::app()->user->getState('ruangan_id')]);

			if(!empty($menuRuangan)) {
				foreach($menuRuangan as $i => $val) {
					if($val->menu_id == Params::MENU_ID_PASIEN_RESEPTUR_OK) {
						$elementToRemove = $val->menu_id;
						$arrMenuId = array_filter($arrMenuId, function ($value) use ($elementToRemove) {
							return $value != $elementToRemove;
						});
					}
					if($val->menu_id == Params::MENU_ID_PASIEN_RESEPTUR_TRIAGE) {
						$elementToRemove = $val->menu_id;
						$arrMenuId = array_filter($arrMenuId, function ($value) use ($elementToRemove) {
							return $value != $elementToRemove;
						});
					}
				}
			}

			$modAkesMenu = UserakesmenuM::model()->findAll();

			if(!empty($modAkesMenu)) {
				foreach($modAkesMenu as $i => $data) {
					$arrMenuId[] = $data->menu_id;
				}
			}
			
			// mengambil data user yang berhak akses menu
			$userAkses = UserakesmenuM::model()->findAllByAttributes(['pegawai_id' => Yii::app()->user->getState('pegawai_id')]);

			if(!empty($userAkses)) {
				foreach ($userAkses as $i => $data) {
					$elementToRemove = $data->menu_id;
					$arrMenuId = array_filter($arrMenuId, function ($value) use ($elementToRemove) {
						return $value != $elementToRemove;
					});
				}
			}

			// echo '<pre>';var_dump($arrMenuId);die;

			$loginpemakai_id = (isset(Yii::app()->user->id) ? Yii::app()->user->id : 0);
			$criteria = new CDbCriteria;
                        
                        /*
                         * // Tampilkan menu sesuai dengan user login
			if($loginpemakai_id != Params::LOGINPEMAKAI_ID_ADMIN ){
				$sql = "select tugaspengguna_k.controller_nama from tugaspengguna_k 
						join peranpengguna_k on peranpengguna_k.peranpengguna_id = tugaspengguna_k.peranpengguna_id 
						join aksespengguna_k on aksespengguna_k.peranpengguna_id = peranpengguna_k.peranpengguna_id 
						where aksespengguna_k.loginpemakai_id = ".$loginpemakai_id." 
						group by tugaspengguna_k.controller_nama";
				$controllers = Yii::app()->db->createCommand($sql)->queryAll();
				if(count((array)$controllers)>0){
					foreach ($controllers as $i => $controller) {
						$criteria->addCondition("LOWER(menu_url) like '%".strtolower($controller['controller_nama'])."%'",($i==0)?'AND':'OR');
					}
				}
			}
                         * 
                         */
            $criteria->addCondition('t.menu_aktif = true');
            $criteria->addNotInCondition('t.menu_id', $arrMenuId);
            $criteria->order = 'kelompokmenu.kelmenu_urutan, menu_urutan';
            if(!empty($compare)){
                foreach($compare as $column=>$value)
                $criteria->compare($column,$value);
            }

            return self::model()->with('kelompokmenu','modulk')->findAll($criteria);
        }
        /**
         * menampilkan dibagi menu sesuai dengan kategorinya
         * digunakan di widget CMenu dan MySideMenu
         */
        public function listAllMenu($module_id = null){
            //init sidebar menu
            $menusArray = array();
            $criteria = new CDbCriteria();
            $criteria->compare('t.modul_id',$module_id);
            $criteria->addCondition('menu_aktif = TRUE');
            $criteria->join = "LEFT JOIN kelompokmenu_k ON kelompokmenu_k.kelmenu_id = t.kelmenu_id";
            $criteria->group = "kelompokmenu_k.kelmenu_id, kelompokmenu_k.kelmenu_nama, kelompokmenu_k.kelmenu_url,t.modul_id";
            $criteria->select = $criteria->group;
            $kelmenus = MenumodulK::model()->findAll($criteria);
            foreach($kelmenus AS $i => $kelmenu){
                $menusArray[$i]['label'] = $kelmenu->kelmenu_nama;
                $menusArray[$i]['url'] = Yii::app()->createUrl($kelmenu->kelmenu_url);
                $criteria_menu = new CDbCriteria();
                $criteria_menu->compare('t.modul_id',$module_id);
                $criteria_menu->compare('kelmenu_id',$kelmenu->kelmenu_id);
                $criteria_menu->addCondition('menu_aktif is true');
                $criteria_menu->order = "menu_urutan, menu_nama ASC";
                $menus = MenumodulK::model()->findAll($criteria_menu);
                foreach($menus as $j => $menu){
                    $menusArray[$i]['items'][$j]['label'] = $menu->menu_nama;
                    $menusArray[$i]['items'][$j]['url'] = Yii::app()->createUrl($menu->menu_url);
                }
            }
            return $menusArray;
        }
	public function searchDialog()
	{

		$criteria=new CDbCriteria;
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id ='.$this->modul_id);	
		}

		if(!empty($this->kelmenu_id)){
			$criteria->addCondition('kelmenu_id ='.$this->kelmenu_id);	
		}

		$criteria->compare('LOWER(menu_nama)',strtolower($this->menu_nama),true);
		$criteria->compare('LOWER(menu_url)',strtolower($this->menu_url),true);
		$criteria->addCondition('menu_aktif = true');

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria
		));
	}
	
	function findMenuById() {
		$criteria=new CDbCriteria;
		if(!empty($this->modul_id)){
			$criteria->addCondition('modul_id ='.$this->modul_id);	
		}
		if(!empty($this->kelmenu_id)){
			$criteria->addCondition('kelmenu_id ='.$this->kelmenu_id);	
		}
		
		$criteria->addInCondition('menu_id', [4488, 4547]);
		
		$criteria->compare('LOWER(menu_nama)',strtolower($this->menu_nama),true);
		$criteria->addCondition('menu_aktif = true');
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria
		));
	}
}
