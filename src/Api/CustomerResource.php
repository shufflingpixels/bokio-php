<?php

namespace Shufflingpixels\BokioApi\Api;

use InvalidArgumentException;
use Shufflingpixels\BokioApi\Objects\Customer;
use Shufflingpixels\BokioApi\Responses\CustomerCollectionResponse;

class CustomerResource extends AbstractResource
{
    public function all(?int $page = null, ?int $pageSize = null) : CustomerCollectionResponse
    {
        $request = $this->client->request('GET', '/customers', [
            'page' => $page,
            'pageSize' => $pageSize,
        ]);
        $response = $this->client->send($request);
        return $this->serializer->deserialize($response, CustomerCollectionResponse::class);
    }

    public function get(string $id) : Customer
    {
        $request = $this->client->request('GET', '/customers/' . $id);
        $response = $this->client->send($request);
        return $this->serializer->deserialize($response, Customer::class);
    }

    public function create(Customer $customer) : Customer
    {
        if ($customer->id) {
            throw new InvalidArgumentException('Customer already exists.');
        }

        $payload = $this->serializer->serialize($customer);
        $request = $this->client->request('POST', '/customers', [], $payload);

        $response = $this->client->send($request);
        return $this->serializer->deserialize($response, Customer::class);
    }

    public function update(Customer $customer) : Customer
    {
        if ($customer->id === null) {
            throw new InvalidArgumentException('Can only update existing customers.');
        }

        $payload = $this->serializer->serialize($customer);
        $request = $this->client->request('PUT', "/customers/{$customer->id}", [], $payload);

        $response = $this->client->send($request);
        return $this->serializer->deserialize($response, Customer::class);
    }

    public function save(Customer $customer) : Customer
    {
        if ($customer->id) {
            return $this->update($customer);
        }
        return $this->create($customer);
    }

    public function delete(Customer|string $customer) : void
    {
        if (!is_string($customer)) {
            $customer = $customer->id;
        }
        $request = $this->client->request('DELETE', "/customers/{$customer}");
        $this->client->send($request);
    }
}
