# Millikart for Laravel (new version) 
#### Don't use in production. Still in development stage.
``` PHP
use Chameleon\Millikart\Operation\CreateOrder;

Millikart::createOrder(function (CreateOrder $createOrder){
    $createOrder->amount(10.0)
        ->allUrl('http://example.com/payment/callback')
        ->description('Order Description');
});
```
