<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $create_user_id
 * @property string $create_time
 * @property integer $update_user_id
 * @property string $update_time
 * @property string $last_login_time
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Client[] $clients
 * @property Client[] $clients1
 * @property Upload[] $uploads
 * @property Upload[] $uploads1
 * @property User $updateUser
 * @property User[] $users
 * @property User $createUser
 * @property User[] $users1
 */
class User extends MyActiveRecord
{
        const STATUS_INACTIVE = 0;
        const STATUS_ACTIVE = 1;
        
        public $password_repeat;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, password_repeat', 'required'),
			array('create_user_id, update_user_id, status', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>64),
			array('password', 'length', 'max'=>100),
                        array('password', 'compare', 'compareAttribute'=>'password_repeat'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, create_user_id, create_time, update_user_id, update_time, last_login_time, status', 'safe', 'on'=>'search'),
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
			'createdClients' => array(self::HAS_MANY, 'Client', 'create_user_id'),
			'updatedClients' => array(self::HAS_MANY, 'Client', 'update_user_id'),
			'createdUploads' => array(self::HAS_MANY, 'Upload', 'create_user_id'),
			'updatedUploads' => array(self::HAS_MANY, 'Upload', 'update_user_id'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
			'updatedUsers' => array(self::HAS_MANY, 'User', 'update_user_id'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
			'createdUsers' => array(self::HAS_MANY, 'User', 'create_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
                        'password_repeat' => 'Repeat Password',
			'create_user_id' => 'Create User',
			'create_time' => 'Create Time',
			'update_user_id' => 'Update User',
			'update_time' => 'Update Time',
			'last_login_time' => 'Last Login Time',
			'status' => 'Status',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function beforeSave()
        {
            if(parent::beforeSave())
            {
                
                    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
                return true;
            }
            else
                return false;
        }
}
