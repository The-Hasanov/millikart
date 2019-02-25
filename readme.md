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
    'reference' => uniqid('test_'),
    'description' => 'test description'
]);//return MilliKartResponse

MilliKart::status('test_reference'); //return MilliKartResponse
```
### TODO
- [x] Response
- [ ] Payment Model
- [ ] Payment Events 
