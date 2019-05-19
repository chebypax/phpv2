<?php


namespace app\models;


use app\services\Db;

class Order extends DbModel
{
    public $id;
    public $orderId;
    public $customerLogin;
    public $customerName;
    public $customerLastname;
    public $customerPhone;
    public $productId;
    public $productQuantity;
    public $status;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getTableName()
    {
        return "orders";
    }

    public static function getLastOrderId()
    {
        $tableName = static::getTableName();
        $sql = "SELECT MAX(`orderId`) FROM {$tableName}";
        $orderId = Db::getInstance()->queryOne($sql)['MAX(`orderId`)'];
        if ($orderId == null)
        {
            $orderId = 0;
        };
        return $orderId;
    }

    public static function getAllNew()
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `status` IS NULL";
        return Db::getInstance()->queryAll($sql);
    }

    public static function getAllNewOrderId()
    {
        $newOrders = static::getAllNew();
        $newOrderId = [];
        foreach ($newOrders as $order)
        {
        foreach ($order as $key=>$value)
        {
            if ($key == 'orderId' && !in_array($value, $newOrderId))
            {
                $newOrderId[] = $value;
            }
        }}
        return $newOrderId;
    }

    public static function getAllByOrderId($orderId)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `orderId` = :orderId";
        return Db::getInstance()->queryAll($sql, [':orderId' => $orderId]);
    }

    public static function getNewOneByOrderId($orderId)
    {
        $tableName = static::getTableName();
        $sql = "SELECT * FROM {$tableName} WHERE `orderId` = :orderId AND `status` IS NULL";
        return Db::getInstance()->queryObject($sql, [':orderId' => $orderId], get_called_class());
    }
}