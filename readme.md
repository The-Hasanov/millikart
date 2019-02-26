# MilliKart Laravel
---
#### Install

Laravel 5.5+
```console
composer require the-hasanov/millikart
```
[Laravel 5.4](https://github.com/The-Hasanov/millikart/tree/1.1)
### Usage
#### Laravel
```php
$response=MilliKart::register([
    'amount' => 2000, //20azn
    'reference' => '123test_ref',
    'description' => 'test description'
]);//return MilliKartResponse

//or use builder

MilliKart::register(function (MilliKartBuilder $builder) {
    $builder->amountAZN(20.0)
        ->reference('123test_ref')
        ->description('test description');
});

if($response->isValidRegister()){
    $response->redirect();// return url
}
// Check transaction status
MilliKart::status('123test_ref'); //return MilliKartResponse
```
### TODO
- [x] Response
- [X] Parameters Builder
- [ ] Payment Model
- [ ] Payment Events 
