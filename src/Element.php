<?php

namespace Chameleon\Millikart;

final class Element
{

    public const ROOT = 'TKKPG';
    public const REQUEST = 'Request';
    public const OPERATION = 'Operation';
    public const LANGUAGE = 'Language';
    public const ORDER = 'Order';
    public const ORDER_TYPE = 'OrderType';
    public const MERCHANT = 'Merchant';
    public const AMOUNT = 'Amount';
    public const CURRENCY = 'Currency';
    public const DESCRIPTION = 'Description';
    public const APPROVE_URL = 'ApproveURL';
    public const CANCEL_URL = 'CancelURL';
    public const DECLINE_URL = 'DeclineURL';
    public const SHOW_PARAMS = 'ShowParams';
    public const SHOW_OPERATIONS = 'ShowOperations';
    public const RESPONSE = 'Response';
    public const STATUS = 'Status';
    public const ORDER_ID = 'OrderID';
    public const ORDER_STATUS = 'OrderStatus';
    public const SESSION_ID = 'SessionID';

    public const URL = 'URL';

    /**
     * @param mixed ...$elements
     * @return string
     */
    public static function line(...$elements): string
    {
        return implode('.', $elements);
    }
}
