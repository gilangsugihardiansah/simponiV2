<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $email
 * @property string $verified_email
 * @property string $password
 * @property string $name
 * @property string $address
 * @property string $phone_number
 * @property string $profession
 * @property string $instagram
 * @property string $date_of_birth
 * @property string $picture
 */
class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $ID;
    public $USERNAME;
    public $PASSWORD;
    public $NAMA;
    public $JENIS;
    public $UNIT;
    public $COMPANY;
    public $DATA_BAWAHAN;
    public $authKey;
    public $accessToken;

    private static $users = [
        'Creator' => [
            'ID' => '9999999-655effdf05928-99999',
            'USERNAME' => 'Creator',
            'PASSWORD' => 'hpiku1233',
            'NAMA' => 'Admin Creator',
            'JENIS' => '9',
            'UNIT' => 'SEMUA UNIT',
            'COMPANY' => 'HPI',
            'DATA_BAWAHAN' => '',
            'authKey' => 'test100key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->ID;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return (isset(self::$users['Creator']['ID']) AND self::$users['Creator']['ID'] == $id ) ? new static(self::$users['Creator']) : null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['USERNAME'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->ID;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->PASSWORD === $password;
    }

    /**
     * {@inheritdoc}
     */
    public function getCheckbwh()
    {
        return false;
    }
}
