<?php

namespace App\Controller;

use App\Service\CallAPIService;
use DateTime;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DepartmentController extends AbstractController
{
    /**
     * @Route("/department/{department}", name="app_department")
     */
    public function index(string $department, CallAPIService $callApi, ChartBuilderInterface $chartBuilder): Response
    {
        $data = $callApi->getDatasByDepartment($department);

        $label = [];
        $newHospi = [];
        $newRea = [];

        for ($i = 1; $i <= 7; $i++) {
            $date = new DateTime('-' . $i . ' days');
            $datasByDate = $callApi->getDatasByDate($date->format('Y-m-d'));

            foreach ($datasByDate['allFranceDataByDate'] as $datas) {
                if ($datas['nom'] === $department) {
                    $label[] = $datas['date'];
                    $newHospi[] = $datas['nouvellesHospitalisations'];
                    $newRea[] = $datas['nouvellesReanimations'];
                    break;
                }
            }
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => array_reverse($label),
            'datasets' => [
                [
                    'label' => 'Nouvelles hospitalisations',
                    'borderColor' => 'rgb(255, 79, 32)',
                    'data' => array_reverse($newHospi)
                ],
                [
                    'label' => 'Nouvelles entrées en réa',
                    'borderColor' => 'rgb(25, 79, 142)',
                    'data' => array_reverse($newRea)
                ]
            ]
        ]);


        return $this->render('department/index.html.twig', [
            'data' => $data,
            'chart' => $chart
        ]);
    }
}
