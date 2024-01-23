<!-- https://us1.locationiq.com/v1/search?key=pk.5d872a6601bcdc3db3b751e26979349f&q=221b%2C%20Baker%20St%2C%20London%20&format=json -->

<?php

class LocationAPI
{
    private string $apiUrl;
    private string $apiKey;

    /**
     * Конструктор класса, принимает API-ключ и устанавливает базовый URL для запросов к внешнему API.
     *
     * @param   string  $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiUrl = 'https://us1.locationiq.com/v1/';
        $this->apiKey = $apiKey;
    }

    /**
     * Метод для получения адреса по заданным координатам.
     *
     * @param   array  $coordinates   Ассоциативный массив с координатами ['latitude' => float, 'longitude' => float].
     *
     * @return array
     */
    public function getAddressByCoordinates(array $coordinates): array
    {
        $url = $this->apiUrl . 'reverse.php?key=' . $this->apiKey . '&lat=' . $coordinates['latitude'] . '&lon=' . $coordinates['longitude'] . '&format=json';

        return $this->makeRequest($url);
    }

    /**
     * Метод для получения координат по заданному адресу.
     *
     * @param   array  $addressData   Ассоциативный массив с данными адреса ['address' => string].
     *
     * @return array
     */
    public function getCoordinatesByAddress(array $addressData): array
    {
        $url = $this->apiUrl . 'search.php?key=' . $this->apiKey . '&q=' . urlencode($addressData['address']) . '&format=json';

        return $this->makeRequest($url);
    }

    /**
     * Приватный метод для выполнения HTTP-запроса с использованием cURL.
     *
     * @param   string  $url   URL для выполнения запроса.
     *
     * @return array
     */
    private function makeRequest(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}

$apiKey = 'pk.5d872a6601bcdc3db3b751e26979349f';
$locationAPI = new LocationAPI($apiKey);

$coordinates = ['latitude' => 51.5237629, 'longitude' => -0.1584743];
$coordinatesAddress = $locationAPI->getAddressByCoordinates($coordinates);
print_r($coordinatesAddress);

$addressData = [
    'address' => 'Sherlock Holmes Museum, 221b, Baker Street, Мерилибон, Лондон, Большой Лондон, Англия, NW1 6XE, Великобритания'
];
$addressCoordinates = $locationAPI->getCoordinatesByAddress($addressData);
print_r($addressCoordinates);

?>