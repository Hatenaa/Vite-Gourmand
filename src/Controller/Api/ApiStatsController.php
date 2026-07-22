<?php

namespace App\Controller\Api;

use App\Repository\OrderStatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ApiStatsController extends AbstractController
{
    #[Route('/api/stats', name: 'api_stats', methods: ['GET'])]
    public function index(Request $request, OrderStatRepository $repository): JsonResponse
    {

        $menuTitles = $request->query->all('menus');
        $fromParam = $request->query->get('from');
        $toParam = $request->query->get('to');
        $mode = $request->query->get('mode', 'orders');

        $from = $fromParam ? new \DateTimeImmutable($fromParam . '-01') : null;
        $to = $toParam ? new \DateTimeImmutable($toParam . '-01') : null;

        $stats = $repository->findByFilters($menuTitles, $from, $to);

        return $this->json($this->formatForChart($stats, $mode));
    }

    /**
     * @param \App\Document\OrderStat[] $stats
     */
    private function formatForChart(array $stats, string $mode): array
    {
        $byMenu = [];
        $labelsSet = [];

        foreach ($stats as $stat) {

            $month = $stat->getMonth()->format('Y-m');
            $labelsSet[$month] = true;
            $byMenu[$stat->getMenuTitle()][$month] = $stat;
        }

        $labels = array_keys($labelsSet);
        sort($labels);

        $datasets = [];

        foreach ($byMenu as $menuTitle => $monthStats) {
            $data = [];
            foreach ($labels as $label) {

                if (isset($monthStats[$label])) {
                    
                    $data[] = $mode === 'revenue'
                        ? $monthStats[$label]->getTotalRevenue()
                        : $monthStats[$label]->getOrderCount();
                } else {
                    $data[] = 0;
                }
            }
            $datasets[] = [
                'label' => $menuTitle,
                'data' => $data,
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }
}