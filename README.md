[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
# smsby.api.php.client - клиент для работы с SMS.BY API

#### Внимание

> Реализовано только отправка быстрых смс, создание сообщений и отправка их в рассылке, получение альфа-имен, ID альфа-имени по  названию. а также проверка статуса смс и получение баланса
 
#### Официальная документация:
[https://app.sms.by/api/docs](https://app.sms.by/api/docs)

#### Подключение к проекту:
```cli
composer require igormakarov/smsby.api.php.client
```
```php
require_once 'vendor/autoload.php';
```

#### Иничиализация и описание методов:

Инициализация
```php
$client = new SmsByApiClient('yourApiKey');
```
Получить список альфа-имен(массив объектов AlphaName) 
```php
$client->getAlphaNames(): array<AlphaName> 
```
Получить ID альфа-имени по его названию 
```php
$id = $client->getAlphanameId('yourAlphaName'): int
```

Отправка быстрого сообщения, в результате возвращает ID SMS сообщения, по которому можно проверить статус отправки и доставки
```php
$smsId = $client->sendQuickSMS(string $message, string $phone, int $alphaNameId = 0): int
```
Отправка быстрого сообщения с переадресацией на Viber, если на SMS сообщение не будет доставлено, тот же sendQuickSMS только расширенней. В результате возвращает ID сообщения
```php
$smsId = $client->sendQuickSMSWithForwarding(string $message, string $phone, int $viberNameId, int $alphaNameId = 0, $forwardingTimeInMinutes = 60): int
```
Создание сообщения для массовой отправки
```php
$createdSmsMessage = $client->createSmsMessage(string $message, string $name = '', int $alphaNameId = 0, string $sendDateTime = ''): CreatedSmsMessage
```

Отправка SMS сообщения, созданного методом createSmsMessage, возвращает ID SMS сообщения
```php
$smsId = $client->sendSms(CreatedSmsMessage $createdSmsMessage, string $phone): int
```
Получить статус сообщения SmsStatus, принимает ID SMS отпраленного методом sendQuickSMS, sendQuickSMSWithForwarding или sendSms
```php
$smsStatus = $client->checkSMS(int $smsId): SmsStatus

Модель SmsStatus может вам показать отправленно ли, доставлено ли сообщение и когда 
$smsStatus->isDelivered(), $smsStatus->isSent()
```
Получить остаток на балансе, возвращает модель Balance в котором хранится информация о валюте и сколько денег на балансе
```php
$balanace = $client->getBalance(): Balance
```


#### Пример отправки быстрого сообщения(Обратите внимание так же на то, что в API от SMS.BY не сразу приходят статус отправки и доставки сообщения)
```php
  try {
    $client = new SmsByApiClient("yourApiKey");
    $firstAlphaName = $client->getAlphaNames()[0];
    $smsId = $client->sendQuickSMS("test", '375222222227', $firstAlphaName->getId());
    while (!$client->checkSMS($smsId)->isSent()) {
        sleep(2);
    }
    echo "Сообщение #" . $smsId . " отправлено \n";
    while (!$client->checkSMS($smsId)->isDelivered()) {
        sleep(2);
    }
    echo "Сообщение " . $smsId . " доставлено \n";
} catch (Exception $ex) {
    echo $ex->getMessage();
}
```
