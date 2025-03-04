<?php

namespace Shufflingpixels\BokioApi\Api;

use Shufflingpixels\BokioApi\Requests\JournalEntryRequest;
use Shufflingpixels\BokioApi\Responses\JournalCollectionResponse;
use Shufflingpixels\BokioApi\Responses\JournalEntryResponse;

class JournalResource extends AbstractResource
{
    public function all(?int $page = null, ?int $pageSize = null) : JournalCollectionResponse
    {
        $request = $this->client->request('GET', '/journal-entries', [
            'page' => $page,
            'pageSize' => $pageSize,
        ]);

        return $this->serializer->deserialize($this->client->send($request), JournalCollectionResponse::class);
    }

    public function get(string $id) : JournalEntryResponse
    {
        $request = $this->client->request('GET', sprintf('/journal-entries/%s', $id));

        return $this->serializer->deserialize($this->client->send($request), JournalEntryResponse::class);
    }

    public function create(JournalEntryRequest $entry) : JournalEntryResponse
    {
        $payload = $this->serializer->serialize($entry);
        $request = $this->client->request('POST', '/journal-entries', [], $payload);

        $response = $this->client->send($request);
        return $this->serializer->deserialize($response, JournalEntryResponse::class);
    }

    public function reverse(JournalEntryResponse|string $entry) : JournalEntryResponse
    {
        if (!is_string($entry)) {
            $entry = $entry->id;
        }

        $request = $this->client->request('POST', sprintf('/journal-entries/%s/reverse', $entry));
        $response = $this->client->send($request);
        return $this->serializer->deserialize($response, JournalEntryResponse::class);
    }
}
