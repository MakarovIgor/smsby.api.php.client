<?php

namespace igormakarov\SmsByApiClient;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use igormakarov\SmsByApiClient\MapperResponseToModel\AlphaNameCategoriesMapper;
use igormakarov\SmsByApiClient\MapperResponseToModel\AlphaNamesMapper;
use igormakarov\SmsByApiClient\MapperResponseToModel\BalanceMapper;
use igormakarov\SmsByApiClient\MapperResponseToModel\CreatedSmsMessageMapper;
use igormakarov\SmsByApiClient\Model\Balance;
use igormakarov\SmsByApiClient\Model\CreatedSmsMessage;
use igormakarov\SmsByApiClient\Model\SmsStatus;

class SmsByApiClient
{
    private string $token;
    private Client $httpClient;
    private string $apiUrl = 'https://app.sms.by/api/';

    /**
     * @throws Exception
     */
    public function __construct(string $token)
    {
        if (empty($token)) {
            throw new Exception('Token is empty!');
        }
        $this->token = $token;
        $this->httpClient = new Client();
    }

    /**
     * @throws Exception
     */
    public function getAlphaNames(): array
    {
        $content = $this->sendRequest("getAlphanames");
        return AlphaNamesMapper::newList($content);
    }

    /**
     * @throws Exception
     */
    public function getAlphanameId(string $name): int
    {
        $content = $this->sendRequest("getAlphanameId", ['name' => $name]);
        return $content['id'];
    }

    /**
     * @throws Exception
     */
    public function getAlphanameCategories(): array
    {
        $content = $this->sendRequest("getAlphanameCategory");
        return AlphaNameCategoriesMapper::newList($content);
    }

    /**
     * @throws Exception
     */
    public function sendQuickSMS(string $message, string $phone, int $alphaNameId = 0): int
    {
        if (empty($message)) {
            throw new Exception('Message text is empty');
        }

        $content = $this->sendRequest("sendQuickSMS",
            [
                'message' => $message,
                'phone' => $phone,
                'alphaname_id' => $alphaNameId
            ],
            "POST"
        );

        return (int)$content['sms_id'];
    }

    /**
     * @throws Exception
     */
    public function sendQuickSMSWithForwarding
    (
        string $message,
        string $phone,
        int $viberNameId,
        int $alphaNameId = 0,
        $forwardingTimeInMinutes = 60
    ): int
    {
        $content = $this->sendRequest(
            "sendQuickSMS",
            [
                'message' => $message,
                'phone' => $phone,
                'alphaname_id' => $alphaNameId,
                'forwarding_message' => 1,
                'forwarding_time' => $forwardingTimeInMinutes,
                'vibername_id' => $viberNameId
            ],
            "POST"
        );
        return (int)$content['sms_id'];
    }

    /**
     * @throws Exception
     */
    public function sendSms(CreatedSmsMessage $createdMessage, string $phone): int
    {
        $content = $this->sendRequest('sendSms', ['message_id' => $createdMessage->getId(), 'phone' => $phone]);
        return (int)$content['sms_id'];
    }

    /**
     * @throws Exception
     */
    public function checkSMS(int $smsId): SmsStatus
    {
        $smsStatus = $this->sendRequest("checkSMS", ['sms_id' => $smsId]);
        return new SmsStatus($smsStatus['sent'], $smsStatus['delivered']);
    }

    /**
     * @throws Exception
     */
    public function createSmsMessage(string $message, string $name = '', int $alphaNameId = 0, string $sendDateTime = ''): CreatedSmsMessage
    {
        if (empty($message)) {
            throw new Exception('Message text is empty');
        }

        $params = [
            'message' => $message,
            'alphaname_id' => $alphaNameId,
        ];

        if (!empty($name)) {
            $params['name'] = $name;
        }

        if (!empty($sendDateTime)) {
            $params['time'] = $sendDateTime;
        }

        $createdMessageStatus = $this->sendRequest("createSmsMessage", $params);
        return CreatedSmsMessageMapper::newInstance($createdMessageStatus);
    }

    /**
     * @throws Exception
     */
    public function getMessagesList(): array
    {
        $content = $this->sendRequest("getMessagesList");
        return $content['result'];
    }

    /**
     * @throws Exception
     */
    public function getMessagesListWithLimit(int $limitOffset, int $limitRows): array
    {
        $content = $this->sendRequest("getMessagesList",
            [
                'limit_offset' => $limitOffset,
                'limit_rows' => $limitRows
            ]
        );
        return $content['result'];
    }

    /**
     * @throws Exception
     */
    public function getBalance(): Balance
    {
        $content = $this->sendRequest("getBalance");
        return BalanceMapper::newInstance($content);
    }

    /**
     * @throws Exception
     */
    protected function sendRequest(string $command, array $params = [], string $method = 'GET', string $apiVersion = 'v1')
    {
        try {
            $params['token'] = $this->token;
            $url = $this->buildUrl($apiVersion, $command);
            $response = $this->httpClient->request($method, $url, ['query' => $params]);
            $responseData = json_decode($response->getBody()->getContents(), true);
            $this->validateResponse($responseData);
            return $responseData;
        } catch (GuzzleException $ex) {
            if ($ex->getCode() == 403) {
                throw new Exception('Access Denied');
            }
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function validateResponse(array $decodedResponseData)
    {
        if (isset($decodedResponseData['error'])) {
            throw new Exception($decodedResponseData['error']);
        }
    }

    private function buildUrl(string $apiVersion, string $command): string
    {
        return $this->apiUrl . $apiVersion . '/' . $command;
    }


    private function test()
    {
        var_dump('test');
    }
}