<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: event.proto

namespace Cart\Metadata;

class Event
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \Cart\Metadata\Item::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
event.protoprotobuf"%
Added
item (2.protobuf.Item" 
ItemRemoved
	productId (	"0
ItemUpdated
	productId (	
number (")
Cleared
items (2.protobuf.Items"*
Replaced
items (2.protobuf.Items"9
Paid
items (2.protobuf.Items
	shopperId (B�
Cart\\Event�Cart\\Metadatabproto3'
        , true);

        static::$is_initialized = true;
    }
}

