# CRex - easy and fast php data container
---
```php
composer require the-hasanov/millikart
```
### Laravel
Service Provider
```php
Chameleon\MilliKartServiceProvider::class,
```
Facade
```php
MilliKart => Chameleon\MilliKartFacade::class
```
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

