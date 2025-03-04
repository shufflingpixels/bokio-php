<?php

namespace Tests\Api;

use Shufflingpixels\BokioApi\Objects\Address;
use Shufflingpixels\BokioApi\Responses\CustomerCollectionResponse;
use Tests\ApiHttpMock;
use PHPUnit\Framework\TestCase;
use Shufflingpixels\BokioApi\Api\CustomerResource;
use Shufflingpixels\BokioApi\Enum\CustomerType;
use Shufflingpixels\BokioApi\Enum\LanguageEnum;
use Shufflingpixels\BokioApi\Objects\ContactDetails;
use Shufflingpixels\BokioApi\Objects\Customer;

class CustomerResourceTest extends TestCase
{
    public function test_all() : void
    {
        $mock = new ApiHttpMock($this);
        $client = $mock->request('GET', 'customers?page=2&pageSize=50')
            ->responseFromFile('Customer/all.json')
            ->create();

        $customerApi = new CustomerResource($client);

        $response = $customerApi->all(2, 50);

        $expected = new CustomerCollectionResponse();
        $expected->currentPage = 2;
        $expected->totalItems = 100;
        $expected->totalPages = 2;
        $expected->items[] = $this->getCustomer();
        $this->assertEquals($response, $expected);
    }

    public function test_get() : void
    {   
        $mock = new ApiHttpMock($this);
        $client = $mock->request('GET', 'customers/55c899c5-82b2-47fa-9c51-e35fc9b26443')
            ->responseFromFile('Customer/get.json')
            ->create();

        $customerApi = new CustomerResource($client);

        $response = $customerApi->get('55c899c5-82b2-47fa-9c51-e35fc9b26443');

        $this->assertEquals($response, $this->getCustomer());
    }

    public function test_create() : void
    {   
        $mock = new ApiHttpMock($this);
        $client = $mock->requestFromFile('POST', 'customers', 'Customer/create_req.json')
            ->responseFromFile('Customer/create_resp.json')
            ->create();
        
        $customer = new Customer([
            'name' => "customer 1",
            'type' => CustomerType::COMPANY,
            'vatNumber' => "SE1234567890",
            'orgNumber' => "123456-7890",
            'contactsDetails' => [
                [
                    'name' => 'John Doe',
                    'email' => 'john@email.com',
                    'phone' => '0927-5631505',
                    'isDefault' => true,
                ],
                [
                    "name" => "Jane Doe",
                    "email" => "jane@email.com",
                    "phone" => "0927-5631510",
                    "isDefault" => false
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

        $customerApi = new CustomerResource($client);
        $response = $customerApi->create($customer);

        $customer->id =  "a4ece1cf-5d86-4104-8741-1be1e65db753";
        $customer->contactsDetails[0]->id = '240a4af0-edfd-47b1-b4ab-f30450eaac19';
        $customer->contactsDetails[1]->id = '2bfaa3ff-6bd4-4720-a1e7-8e2ec5c35ec0';

        $this->assertEquals($customer, $response);
    }

    public function test_update() : void
    {
        $mock = new ApiHttpMock($this);
        $client = $mock->requestFromFile('PUT', 'customers/a4ece1cf-5d86-4104-8741-1be1e65db753', 'Customer/update.json')
            ->responseFromFile('Customer/update.json')
            ->create();

        $customer = new Customer([
            'id' => 'a4ece1cf-5d86-4104-8741-1be1e65db753',
            'name' => "customer 1 Updated",
            'type' => CustomerType::COMPANY,
            'vatNumber' => "SE1234567890",
            'orgNumber' => "123456-7890",
            'contactsDetails' => [
                [
                    'id' => '240a4af0-edfd-47b1-b4ab-f30450eaac19',
                    'name' => 'John Doe',
                    'email' => 'john@email.com',
                    'phone' => '0927-5631505',
                    'isDefault' => true,
                ],
                [
                    'id' => '2bfaa3ff-6bd4-4720-a1e7-8e2ec5c35ec0',
                    "name" => "Jane Doe",
                    "email" => "jane@email.com",
                    "phone" => "0927-5631510",
                    "isDefault" => false
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

        $customerApi = new CustomerResource($client);
        $response = $customerApi->update($customer);
        
        $this->assertEquals($customer, $response);
    }

    public function test_delete() : void
    {
        $mock = new ApiHttpMock($this);
        $client = $mock->request('delete', 'customers/a4ece1cf-5d86-4104-8741-1be1e65db753')
            ->response(204)
            ->create();

        $customerApi = new CustomerResource($client);
        $customerApi->delete('a4ece1cf-5d86-4104-8741-1be1e65db753');
    }

    protected function getCustomer() : Customer
    {
        $expected = new Customer();
        $expected->id = "55c899c5-82b2-47fa-9c51-e35fc9b26443";
        $expected->name = "customer 1";
        $expected->type = CustomerType::COMPANY;
        $expected->vatNumber = "SE1234567890";
        $expected->orgNumber = "123456-7890";
        $expected->language = LanguageEnum::SV;
        $expected->address = new Address();
        $expected->address->line1 = 'Älvsborgsvägen 10';
        $expected->address->line2 = null;
        $expected->address->city = 'Göteborg';
        $expected->address->postalCode = '123 45';
        $expected->address->country = 'SE';
        $expected->contactsDetails[0] = new ContactDetails();
        $expected->contactsDetails[0]->id = '240a4af0-edfd-47b1-b4ab-f30450eaac19';
        $expected->contactsDetails[0]->name = 'John Doe';
        $expected->contactsDetails[0]->email = 'john@email.com';
        $expected->contactsDetails[0]->phone = '0927-5631505';
        $expected->contactsDetails[0]->isDefault = true;
        return $expected;
    }
}
