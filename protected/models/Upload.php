<?php

/**
 * This is the model class for table "tbl_upload".
 *
 * The followings are the available columns in table 'tbl_upload':
 * @property integer $id
 * @property string $filename
 * @property integer $file_size
 * @property string $file_ext
 * @property integer $create_user_id
 * @property string $create_time
 * @property integer $update_user_id
 * @property string $update_time
 * @property integer $client_id
 *
 * The followings are the available model relations:
 * @property Client[] $clients
 * @property Client[] $clients1
 * @property Client[] $clients2
 * @property Client $client
 * @property User $createUser
 * @property User $updateUser
 */
class Upload extends MyActiveRecord
{
        public $file;
        public $formheader;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_upload';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(          
                        array('file','file','types'=>'jpg, png', 'maxSize'=> 1024 * 300, 'tooLarge'=>'File has to be smaller than 300kb', 'on'=>'insert, update'),
			array('filename, file_size, file_ext', 'required'),
			array('file_size, create_user_id, update_user_id, client_id', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>140),
			array('file_ext', 'length', 'max'=>64),
			array('create_time, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, filename, file_size, file_ext, create_user_id, create_time, update_user_id, update_time, client_id', 'safe', 'on'=>'search'),
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
			'uploadClient' => array(self::BELONGS_TO, 'Client', 'client_id'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'filename' => 'Filename',
			'file_size' => 'File Size',
			'file_ext' => 'File Ext',
			'create_user_id' => 'Create User',
			'create_time' => 'Create Time',
			'update_user_id' => 'Update User',
			'update_time' => 'Update Time',
			'client_id' => 'Client',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('file_size',$this->file_size);
		$criteria->compare('file_ext',$this->file_ext,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('client_id',$this->client_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Upload the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getFilepath()
        {
            $dir = Yii::app()->request->baseUrl.'/../../uploads/';
            $clientdir = $dir . md5($this->uploadClient->name . $this->uploadClient->id) . '/';
            
            return $clientdir . $this->filename;
        }
}
