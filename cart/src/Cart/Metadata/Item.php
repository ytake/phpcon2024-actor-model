<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: item.proto

namespace Cart\Metadata;

class Item
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�

item.protoprotobuf"<
Item
	productId (	
number (
	unitPrice ("&
Items
items (2.protobuf.ItemB �Cart\\ProtoBuf�Cart\\Metadatabproto3'
        , true);

        static::$is_initialized = true;
    }
}

