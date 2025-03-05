# Bookio API for PHP

PHP Wrapper for the experimental [Bookio API](https://docs.bokio.se/reference/overview)

## Install

Install via composer

```sh
composer require shufflingpixels/bokio-php
```

## Example

```php
<?php

require_once 'vendor/autoload.php';

use Shufflingpixels\BokioApi\Api;
use Shufflingpixels\BokioApi\Auth;
use Shufflingpixels\BokioApi\Enum\CustomerType;
use Shufflingpixels\BokioApi\Enum\LanguageEnum;
use Shufflingpixels\BokioApi\Exception\ApiException;
use Shufflingpixels\BokioApi\Exception\Exception;
use Shufflingpixels\BokioApi\Objects\Customer;

$api = new Api(new Auth('<company_id>', '<token>'));

try {
    $customer = new Customer([
        'name' => "Created From Api",
        'type' => CustomerType::COMPANY,
        'vatNumber' => "SE1234567890",
        'orgNumber' => "123456-7890",
        'contactsDetails' => [
            [
                'name' => 'Person 1',
                'email' => 'test@example.com',
                'phone' => '0739281831',
                'isDefault' => true,
            ],
            [
                'name' => 'Person 2',
            ],
        ],
        "address" => [
            'line1' => 'Älvsborgsvägen 10',
            'city' => 'Göteborg',
            'postalCode' => '123 45',
            'country' => 'SE',
        ],
        'language' => LanguageEnum::SV,
    ]);

    $response = $api->customer()->create($customer);

    print_r($response);
} catch (ApiException $e) {
    print_r($e->getError());
} catch (Exception $e) {
    print_r($e);
}
```

## Implemented

- [x] Journal Entries
    - [x] [Create](https://docs.bokio.se/reference/post-journalentry)
    - [x] [List](https://docs.bokio.se/reference/get-journalentry)
    - [x] [Get](https://docs.bokio.se/reference/get-journalentries-journalid)
    - [x] [Reverse](https://docs.bokio.se/reference/reverse-journalentry)

- [x] Customers
    - [x] [Create](https://docs.bokio.se/reference/post-customer)
    - [x] [List](https://docs.bokio.se/reference/get-customer)
    - [x] [Get](https://docs.bokio.se/reference/get-customers-customerid)
    - [x] [Update](https://docs.bokio.se/reference/put-customer)
    - [x] [Delete](https://docs.bokio.se/reference/delete-customer)

- [ ] Upload
    - [ ] [Add](https://docs.bokio.se/reference/add-upload) 
    - [ ] [List](https://docs.bokio.se/reference/get-uploads) 
    - [ ] [Get](https://docs.bokio.se/reference/get-upload) 
    - [ ] [Download](https://docs.bokio.se/reference/download-upload) 

- [ ] Invoice
    - [ ] [Create](https://docs.bokio.se/reference/post-invoice)
    - [ ] [List](https://docs.bokio.se/reference/get-invoice)
    - [ ] [Get](https://docs.bokio.se/reference/get-invoice)
    - [ ] [Update](https://docs.bokio.se/reference/put-invoice)
    - [ ] [Add line](https://docs.bokio.se/reference/post-invoice-lineitem)

## Author

Henrik Hautakoski <henrik@shufflingpixels.com>
