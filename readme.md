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
MilliKart::register([
    'amount' => 2000, //20azn
    'reference' => uniqid('test_'),
    'description' => 'test description'
]);//return array

MilliKart::status('test_reference');//return array
```
#### Native PHP
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
