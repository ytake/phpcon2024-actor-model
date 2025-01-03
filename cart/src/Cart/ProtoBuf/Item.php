<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: item.proto

namespace Cart\ProtoBuf;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>protobuf.Item</code>
 */
class Item extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string productId = 1;</code>
     */
    protected $productId = '';
    /**
     * Generated from protobuf field <code>int32 number = 2;</code>
     */
    protected $number = 0;
    /**
     * Generated from protobuf field <code>float unitPrice = 3;</code>
     */
    protected $unitPrice = 0.0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $productId
     *     @type int $number
     *     @type float $unitPrice
     * }
     */
    public function __construct($data = NULL) {
        \Cart\Metadata\Item::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string productId = 1;</code>
     * @return string
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Generated from protobuf field <code>string productId = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setProductId($var)
    {
        GPBUtil::checkString($var, True);
        $this->productId = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>int32 number = 2;</code>
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Generated from protobuf field <code>int32 number = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setNumber($var)
    {
        GPBUtil::checkInt32($var);
        $this->number = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>float unitPrice = 3;</code>
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Generated from protobuf field <code>float unitPrice = 3;</code>
     * @param float $var
     * @return $this
     */
    public function setUnitPrice($var)
    {
        GPBUtil::checkFloat($var);
        $this->unitPrice = $var;

        return $this;
    }

}

