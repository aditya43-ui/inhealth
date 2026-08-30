<?php

/**
 * This is the model class for table "post_m".
 *
 * The followings are the available columns in table 'post_m': 
 * 
 * 
 * digunakan untuk modul portal rs post berita
 * @package application.models
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author      Yusuf Putra Anugrah <yusufputra@.com>
 * @version     2.0.0
 * @link        http://172.9.1.15/simpp/docs/ 
 * @property integer $post_id
 * @property string $post_judul
 * @property string $post_namalain
 * @property string $post_tgl
 * @property string $post_desc
 * @property integer $kategoripost_id
 * @property boolean $post_aktif
 * @property string $post_gambar
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_ruangan
 * @property integer $jml_dilihat
 *
 * The followings are the available model relations:
 * @property KategoripostM $kategoripost
 */
class PostM extends CActiveRecord
{
        public $loginpemakai,$kategoripost_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostM the static model class
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
		return 'post_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_judul, post_tgl, post_desc, kategoripost_id, create_loginpemakai_id, create_time, create_ruangan', 'required'),
			array('kategoripost_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, jml_dilihat', 'numerical', 'integerOnly'=>true),
			array('post_judul, post_namalain', 'length', 'max'=>250),
			array('post_gambar', 'length', 'max'=>200),
			array('post_aktif', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('post_id, post_judul, post_namalain, post_tgl, post_desc, kategoripost_id, post_aktif, post_gambar, create_loginpemakai_id, update_loginpemakai_id, create_time, update_time, create_ruangan, jml_dilihat', 'safe', 'on'=>'search'),
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
			'kategoripost' => array(self::BELONGS_TO, 'KategoripostM', 'kategoripost_id'),
                        
                        
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'post_id' => 'Post',
			'post_judul' => 'Post Judul',
			'post_namalain' => 'Post Namalain',
			'post_tgl' => 'Post Tgl',
			'post_desc' => 'Post Desc',
			'kategoripost_id' => 'Kategoripost',
			'post_aktif' => 'Post Aktif',
			'post_gambar' => 'Post Gambar',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_ruangan' => 'Create Ruangan',
			'jml_dilihat' => 'Jml Dilihat',
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

		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('post_judul',$this->post_judul,true);
		$criteria->compare('post_namalain',$this->post_namalain,true);
		$criteria->compare('post_tgl',$this->post_tgl,true);
		$criteria->compare('post_desc',$this->post_desc,true);
		$criteria->compare('kategoripost_id',$this->kategoripost_id);
		$criteria->compare('post_aktif',$this->post_aktif);
		$criteria->compare('post_gambar',$this->post_gambar,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('jml_dilihat',$this->jml_dilihat);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        
		));
	}
        /**
         * digunakan untuk filter berita
         * @return \CActiveDataProvider CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchNew()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select="t.*,t.post_judul,t.post_desc,k.kategoripost_nama";
		$criteria->join="join kategoripost_m k on k.kategoripost_id = t.kategoripost_id";
		$criteria->compare('lower(t.post_judul)',strtolower($this->post_judul),true);
		$criteria->compare('lower(t.post_desc)',strtolower($this->post_desc),true);
		$criteria->compare('lower(k.kategoripost_nama)',strtolower($this->kategoripost_nama),true);
                $criteria->compare('t.post_aktif',$this->post_aktif);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                      
                       
		));
	}
        /**
         * digunakan untuk filter print
         * @return \CActiveDataProvider CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
         */
        public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select="t.*,t.post_judul,t.post_desc,k.kategoripost_nama";
		$criteria->join="join kategoripost_m k on k.kategoripost_id = t.kategoripost_id";
		$criteria->compare('lower(t.post_judul)',strtolower($this->post_judul),true);
		$criteria->compare('lower(t.post_desc)',strtolower($this->post_desc),true);
		$criteria->compare('lower(k.kategoripost_nama)',strtolower($this->kategoripost_nama),true);
                $criteria->compare('t.post_aktif',$this->post_aktif);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' =>false
                       
		));
	}
        /**
         * menampilkan jumlah komen pada berita tertentu
         * @return type integer untuk mengambil jumlah comment berdasarkan id berita
         */
        public function getJumlahComment()
	{
		$modComment = KommentarT::model()->findAllByAttributes(array('post_id'=>$this->post_id, 'kommentar_tampil'=>true, 'kommentar_tampil'=>true));
		return count($modComment);
	}
        
        /**
         * menampilkan data komentar berdasarkan id
         * @return type object mengambil data komentar pada tabel
         */
	public function getComment()
	{
		$modComment = KommentarT::model()->findAllByAttributes(array('post_id'=>$this->post_id, 'kommentar_tampil'=>true, 'kommentar_tampil'=>true));
		return $modComment;
	}
}