<?php

/**
 * This is the model class for table "photopemeriksaan_t".
 *
 * The followings are the available columns in table 'photopemeriksaan_t':
 * @property integer $photopemeriksaan_id
 * @property integer $pegawai_id
 * @property integer $pasien_id
 * @property integer $pasienadmisi_id
 * @property integer $pendaftaran_id
 * @property string $tglphotopemeriksaan
 * @property integer $nourut
 * @property string $pathphoto
 * @property string $judulphotopemeriksaan
 * @property string $keteranganphoto
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property boolean $tampildigalery
 */
class PhotopemeriksaanT extends CActiveRecord
{
        /** @var string Extensions for gallery images */
        public $galleryExt = 'jpg';
        /** @var string directory in web root for galleries */
        public $galleryDir = 'data/images/pemeriksaanpasien/photos/';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PhotopemeriksaanT the static model class
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
		return 'photopemeriksaan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, pasien_id, pendaftaran_id, tglphotopemeriksaan, nourut, pathphoto, judulphotopemeriksaan, keteranganphoto, create_time, create_loginpemakai_id, create_ruangan', 'required'),
			array('pegawai_id, pasien_id, pasienadmisi_id, pendaftaran_id, nourut, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('pathphoto', 'length', 'max'=>400),
			array('judulphotopemeriksaan', 'length', 'max'=>50),
			array('update_time, tampildigalery', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('photopemeriksaan_id, pegawai_id, pasien_id, pasienadmisi_id, pendaftaran_id, tglphotopemeriksaan, nourut, pathphoto, judulphotopemeriksaan, keteranganphoto, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tampildigalery', 'safe', 'on'=>'search'),
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
                    'pendaftaran'=>array(self::BELONGS_TO,'PendaftaranT','pendaftaran_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'photopemeriksaan_id' => 'Photopemeriksaan',
			'pegawai_id' => 'Pegawai',
			'pasien_id' => 'Pasien',
			'pasienadmisi_id' => 'Pasienadmisi',
			'pendaftaran_id' => 'Pendaftaran',
			'tglphotopemeriksaan' => 'Tglphotopemeriksaan',
			'nourut' => 'Nourut',
			'pathphoto' => 'Pathphoto',
			'judulphotopemeriksaan' => 'Judulphotopemeriksaan',
			'keteranganphoto' => 'Keteranganphoto',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'tampildigalery' => 'Tampildigalery',
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

		$criteria->compare('photopemeriksaan_id',$this->photopemeriksaan_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('tglphotopemeriksaan',$this->tglphotopemeriksaan,true);
		$criteria->compare('nourut',$this->nourut);
		$criteria->compare('pathphoto',$this->pathphoto,true);
		$criteria->compare('judulphotopemeriksaan',$this->judulphotopemeriksaan,true);
		$criteria->compare('keteranganphoto',$this->keteranganphoto,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('tampildigalery',$this->tampildigalery);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
                
        public function save($runValidation = true, $attributes = null)
        {
            parent::save($runValidation, $attributes);
            if ($this->nourut == null) {
                $this->nourut = $this->photopemeriksaan_id;
                $this->setIsNewRecord(false);
                $this->save(false);
            }
            return true;
        }

        public function getPreview($pathphoto = null)
        {
//            return PARAMS::urlPemeriksaanPasienThumbsDirectory."kecil_".$pathphoto;
            return Yii::app()->request->baseUrl . '/' . $this->galleryDir . '' . $pathphoto;
//            return Yii::app()->request->baseUrl . '/' . $this->galleryDir . '/_' . $this->getFileName('') . '.' . $this->galleryExt;
        }

        private function getFileName($version = '')
        {
            return $this->photopemeriksaan_id . $version;
        }

        public function getUrl($version = '')
        {
            return Params::urlPemeriksaanPasienThumbsDirectory()."kecil_".$this->getFileName($version);
        }

        public function setImage($path)
        {
            //save image in original size
            Yii::app()->image->load($path)->save(Params::pathPemeriksaanPasienThumbsDirectory()."kecil_".$this->getFileName(''));
            //create image preview for gallery manager
            Yii::app()->image->load($path)->resize(300, null)->save(Params::pathPemeriksaanPasienThumbsDirectory()."kecil_".$this->getFileName(''));

            $this->updateImages();
        }

        public function delete()
        {
            $this->removeFile(Params::pathPemeriksaanPasienThumbsDirectory()."kecil_".$this->getFileName(''));
            $this->removeFile(Params::pathPemeriksaanPasienThumbsDirectory()."kecil_".$this->getFileName(''));

            $this->removeImages();
            return parent::delete();
        }

        private function removeFile($fileName)
        {
            if (file_exists($fileName))
                @unlink($fileName);
        }

        public function removeImages()
        {
                $this->removeFile(Params::pathPemeriksaanPasienThumbsDirectory()."kecil_".$this->pathphoto);
                $this->removeFile(Params::pathPemeriksaanPasienPhotosDirectory().$this->pathphoto);
        }

        /**
         * Regenerate image versions
         */
        public function updateImages()
        {
            foreach ($this->versions as $version => $actions) {
                $this->removeFile(Yii::getPathOfAlias('webroot') . '/' .$this->galleryDir . '/' . $this->getFileName($version) . '.' . $this->galleryExt);

                $image = Yii::app()->image->load(Yii::getPathOfAlias('webroot') . '/' .$this->galleryDir . '/' . $this->getFileName('') . '.' . $this->galleryExt);
                foreach ($actions as $method => $args) {
                    call_user_func_array(array($image, $method), is_array($args) ? $args : array($args));
                }
                $image->save(Yii::getPathOfAlias('webroot') . '/' .$this->galleryDir . '/' . $this->getFileName($version) . '.' . $this->galleryExt);
            }
        }
        
        private $_versions;

        public function getVersions()
        {
            if (empty($this->_versions)) $this->_versions = unserialize($this->pathphoto);
            return $this->_versions;
        }

        public function setVersions($value)
        {
            $this->_versions = $value;
        }
        
        /** @return Gallery Returns gallery associated with model */
        public function getGallery()
        {
            if (empty($this->_gallery)) {
                $this->_gallery = PhotopemeriksaanT::model()->findByPk($this->getOwner()->{$this->photopemeriksaan_id});
            }
            return $this->_gallery;
        }

        /** @return GalleryPhoto[] Photos from associated gallery */
        public function getGalleryPhotos()
        {
            $criteria = new CDbCriteria();
            $criteria->condition = 'pendaftaran_id = :pendaftaran_id';            
            $criteria->params[':pendaftaran_id'] = isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null;
            $criteria->order = 'nourut asc';
            $criteria->addCondition('tampildigalery is false');
            return PhotopemeriksaanT::model()->findAll($criteria);
        }
}