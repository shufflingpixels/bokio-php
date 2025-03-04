<?php

namespace Tests\Api;

use DateTime;
use PHPUnit\Framework\TestCase;
use Shufflingpixels\BokioApi\Api\JournalResource;
use Shufflingpixels\BokioApi\Requests\JournalEntryRequest;
use Shufflingpixels\BokioApi\Responses\JournalCollectionResponse;
use Shufflingpixels\BokioApi\Responses\JournalEntryItemResponse;
use Shufflingpixels\BokioApi\Responses\JournalEntryResponse;
use Tests\ApiHttpMock;

class JournalResourceTest extends TestCase
{
    public function test_all() : void
    {
        $mock = new ApiHttpMock($this);
        $client = $mock->request('GET', 'journal-entries?pageSize=10')
            ->responseFromFile('Journal/all.json')
            ->create();

        $journalApi = new JournalResource($client);
        $response = $journalApi->all(null, 10);

        $expected = new JournalCollectionResponse();
        $expected->currentPage = 1;
        $expected->totalItems = 1;
        $expected->totalPages = 1;
        $expected->items[0] = new JournalEntryResponse();
        $expected->items[0]->id = 'a419cf69-db6f-4de9-992c-b1a60942a443';
        $expected->items[0]->title = 'invoice 1234';
        $expected->items[0]->date = new DateTime('2024-10-10 00:00:00');
        $expected->items[0]->journalEntryNumber = "V342";

        $expected->items[0]->items[0] = new JournalEntryItemResponse();
        $expected->items[0]->items[0]->id = 1;
        $expected->items[0]->items[0]->debit = 200;
        $expected->items[0]->items[0]->credit = 0;
        $expected->items[0]->items[0]->account = 1930;

        $expected->items[0]->items[1] = new JournalEntryItemResponse();
        $expected->items[0]->items[1]->id = 2;
        $expected->items[0]->items[1]->debit = 0;
        $expected->items[0]->items[1]->credit = 40;
        $expected->items[0]->items[1]->account = 3011;

        $expected->items[0]->items[2] = new JournalEntryItemResponse();
        $expected->items[0]->items[2]->id = 3;
        $expected->items[0]->items[2]->debit = 0;
        $expected->items[0]->items[2]->credit = 160;
        $expected->items[0]->items[2]->account = 2611;

        $this->assertEquals($expected, $response);
    }

    public function test_get() : void
    {
        $mock = new ApiHttpMock($this);
        $client = $mock->request('GET', 'journal-entries/53bdb737-afe0-4156-aa38-94b2c2791dae')
            ->responseFromFile('Journal/get.json')
            ->create();

        $journalApi = new JournalResource($client);
        $response = $journalApi->get('53bdb737-afe0-4156-aa38-94b2c2791dae');

        $expected = new JournalEntryResponse();
        $expected->id = '53bdb737-afe0-4156-aa38-94b2c2791dae';
        $expected->title = 'transfer';
        $expected->date = new DateTime('2023-11-28 00:00:00');
        $expected->journalEntryNumber = "V192";

        $expected->items[0] = new JournalEntryItemResponse();
        $expected->items[0]->id = 1;
        $expected->items[0]->debit = 90;
        $expected->items[0]->credit = 0;
        $expected->items[0]->account = 1930;

        $expected->items[1] = new JournalEntryItemResponse();
        $expected->items[1]->id = 2;
        $expected->items[1]->debit = 0;
        $expected->items[1]->credit = 90;
        $expected->items[1]->account = 1931;

        $this->assertEquals($expected, $response);
    }

    public function test_create() : void
    {
        $mock = new ApiHttpMock($this);
        $client = $mock->requestFromFile('POST', 'journal-entries', 'Journal/create_req.json')
            ->responseFromFile('Journal/create_resp.json')
            ->create();

        $journalApi = new JournalResource($client);
        $response = $journalApi->create(new JournalEntryRequest([
            'title' => 'my entry',
            'date' => '2024-04-03',
            'items' => [
                [
                    'debit' => 838,
                    'account' => 1930,
                ],
                [
                    'credit' => 8,
                    'account' => 1690,
                ],
                [
                    'credit' => 830,
                    'account' => 1730,
                ],
            ]
        ]));

        $expected = new JournalEntryResponse();
        $expected->id = '6a157985-0ebc-4664-ad65-e7795afee948';
        $expected->title = 'my entry';
        $expected->journalEntryNumber = 'V788';
        $expected->date = new DateTime('2024-04-03 00:00:00');

        $expected->items[0] = new JournalEntryItemResponse();
        $expected->items[0]->id = 1;
        $expected->items[0]->debit = 838;
        $expected->items[0]->account = 1930;

        $expected->items[1] = new JournalEntryItemResponse();
        $expected->items[1]->id = 2;
        $expected->items[1]->credit = 8;
        $expected->items[1]->account = 1690;

        $expected->items[2] = new JournalEntryItemResponse();
        $expected->items[2]->id = 3;
        $expected->items[2]->credit = 830;
        $expected->items[2]->account = 1730;

        $this->assertEquals($expected, $response);
    }

    public function test_reverse() : void
    {
        $mock = new ApiHttpMock($this);
        $client = $mock->request('POST', 'journal-entries/6a157985-0ebc-4664-ad65-e7795afee948/reverse')
            ->responseFromFile('Journal/reverse.json')
            ->create();

        $journalApi = new JournalResource($client);
        $response = $journalApi->reverse('6a157985-0ebc-4664-ad65-e7795afee948');

        $expected = new JournalEntryResponse();
        $expected->id = '111f4ff8-7caa-45dc-846a-69b0687d4f9f';
        $expected->title = 'reverse my entry';
        $expected->journalEntryNumber = 'V789';
        $expected->date = new DateTime('2024-04-05 00:00:00');
        $expected->reversingjournalEntryId = '6a157985-0ebc-4664-ad65-e7795afee948';

        $expected->items[0] = new JournalEntryItemResponse();
        $expected->items[0]->id = 1;
        $expected->items[0]->credit = 838;
        $expected->items[0]->account = 1930;

        $expected->items[1] = new JournalEntryItemResponse();
        $expected->items[1]->id = 2;
        $expected->items[1]->debit = 8;
        $expected->items[1]->account = 1690;

        $expected->items[2] = new JournalEntryItemResponse();
        $expected->items[2]->id = 3;
        $expected->items[2]->debit = 830;
        $expected->items[2]->account = 1730;


        $this->assertEquals($expected, $response);
    }
}
