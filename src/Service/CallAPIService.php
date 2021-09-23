<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallAPIService
{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getApi(string $var)
    {
        $response = $this->client->request('GET', 'https://coronavirusapi-france.now.sh/' . $var);

        return $response->toArray();
    }

    public function getGlobalDatasForFrance()
    {
        return $this->getApi('FranceLiveGlobalData');
    }

    public function getDatasByDepartment(string $department)
    {
        return $this->getApi('LiveDataByDepartement?Departement=' . $department);
    }

    public function getDatasForAllDepartments()
    {
        return $this->getApi('AllLiveData');
    }

    public function getDatasByDate($date)
    {
        return $this->getApi('AllDataByDate?date=' . $date);
    }
}
