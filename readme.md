# MilliKart Laravel
---
#### Install
```console
//Laravel 5.5+
composer require the-hasanov/millikart

//Laravel 5.4
composer require the-hasanov/millikart:1.1
//this version also need add service prodivder manually
```
### Laravel
Example
```php
MilliKart::register([
    'amount' => 2000, //20azn
    'reference' => uniqid('test_'),
    'description' => 'test description'
]);//return array

MilliKart::status('test_reference');//return array
```
### Native PHP
```php
$millikart=new \Chameleon\MilliKart(include 'src/config/millikart.php');

$millikart->register([
    'amount' => 2000,
    'reference' => uniqid('test_'),
    'description' => 'test description'
]);//return array

$millikart->status('test_reference'); //return array
```
### TODO
- [ ] Payment Model
- [ ] Payment Events 
