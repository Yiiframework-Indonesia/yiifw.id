<?php

namespace app\classes;

use Yii;
use yii\db\Query;
use yii\base\Object;
use yii\di\Instance;
use yii\db\Connection;
use yii\base\InvalidConfigException;

/**
 * Description of TokenManager
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class TokenManager extends Object
{
    /**
     *
     * @var Connection
     */
    public $db = 'db';
    public $tokenTable = '{{%token}}';
    public $gcProbability = 1; // 0.01

    /**
     * Initializes the DbCache component.
     * This method will initialize the [[db]] property to make sure it refers to a valid DB connection.
     * @throws InvalidConfigException if [[db]] is invalid.
     */

    public function init()
    {
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::className());
    }

    public function generateToken($data, $category = 'app', $expire = 0)
    {
        $token = md5(serialize([Yii::$app->params['app.secretKey'], $category, $data, time()]));
        $command = $this->db->createCommand()->insert($this->tokenTable, [
            'id' => $token,
            'category' => $category,
            'expire' => $expire > 0 ? time() + $expire : 0,
            'data' => [serialize($data), \PDO::PARAM_LOB]
        ]);
        if ($command->execute()) {
            $this->gc();
            return $token;
        }
    }

    public function getTokenData($token, $category = 'app')
    {
        $query = new Query;
        $query->select(['data'])
            ->from($this->tokenTable)
            ->where(['id' => $token, 'category' => $category])
            ->andWhere(['OR', ['expire' => 0], ['>', 'expire', time()]]);

        if ($this->db->enableQueryCache) {
            // temporarily disable and re-enable query caching
            $this->db->enableQueryCache = false;
            $result = $query->createCommand($this->db)->queryScalar();
            $this->db->enableQueryCache = true;
        } else {
            $result = $query->createCommand($this->db)->queryScalar();
        }
        return $result === false ? false : unserialize($result);
    }

    public function deleteToken($token)
    {
        return $this->db->createCommand()
                ->delete($this->tokenTable, ['id' => $token])
                ->execute();
    }

    public function updateToken($token, $data)
    {
        return $this->db->createCommand()
                ->update($this->tokenTable, ['data' => [serialize($data), \PDO::PARAM_LOB]], ['id' => $token])
                ->execute();
    }

    /**
     * Removes the expired data values.
     * @param boolean $force whether to enforce the garbage collection regardless of [[gcProbability]].
     * Defaults to false, meaning the actual deletion happens with the probability as specified by [[gcProbability]].
     */
    public function gc($force = false)
    {
        if ($force || mt_rand(0, 100) < $this->gcProbability) {
            $this->db->createCommand()
                ->delete($this->tokenTable, '[[expire]] > 0 AND [[expire]] < ' . time())
                ->execute();
        }
    }
}
