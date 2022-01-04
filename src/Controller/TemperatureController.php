<?php

namespace App\Controller;

use App\Entity\Temperature;
use App\Form\TemperatureType;
use App\Repository\TemperatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/temperature")
 */
class TemperatureController extends AbstractController
{
    /**
     * @Route("/", name="temperature_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->redirectToRoute('temperature_by_5minutes');
    }

    /**
     * @Route("/1hour", name="temperature_by_hours", methods={"GET"})
     */
    public function hour(TemperatureRepository $temperatureRepository): Response
    {
        $temperatures = $temperatureRepository->findAVGByPart(3600, 4320);

        $labels = [];
        $data = [];

        foreach ($temperatures as $temperature) {
            $labels[] = $temperature['ts'];
            $data[] = $temperature['avg'];
        }

        return $this->render('temperature/index.html.twig', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * @Route("/15min", name="temperature_by_15minutes", methods={"GET"})
     */
    public function fifteenMinute(TemperatureRepository $temperatureRepository): Response
    {
        $temperatures = $temperatureRepository->findAVGByPart(900, 2880);

        $labels = [];
        $data = [];

        foreach ($temperatures as $temperature) {
            $labels[] = $temperature['ts'];
            $data[] = $temperature['avg'];
        }

        return $this->render('temperature/index.html.twig', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * @Route("/5min", name="temperature_by_5minutes", methods={"GET"})
     */
    public function fiveMinute(TemperatureRepository $temperatureRepository): Response
    {
        $temperatures = $temperatureRepository->findAVGByPart(300, 4032);

        $labels = [];
        $data = [];

        foreach ($temperatures as $temperature) {
            $labels[] = $temperature['ts'];
            $data[] = $temperature['avg'];
        }

        return $this->render('temperature/index.html.twig', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * @Route("/1min", name="temperature_by_1minute", methods={"GET"})
     */
    public function minute(TemperatureRepository $temperatureRepository): Response
    {
        $temperatures = $temperatureRepository->findAVGByPart(60, 4320);

        $labels = [];
        $data = [];

        foreach ($temperatures as $temperature) {
            $labels[] = $temperature['ts'];
            $data[] = $temperature['avg'];
        }

        return $this->render('temperature/index.html.twig', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    /**
     * @Route("/second", name="temperature_by_seconds", methods={"GET"})
     */
    public function second(TemperatureRepository $temperatureRepository): Response
    {
        $temperatures = $temperatureRepository->findAVGByPart(1);

        $labels = [];
        $data = [];

        foreach ($temperatures as $temperature) {
            $labels[] = $temperature['ts'];
            $data[] = $temperature['avg'];
        }

        return $this->render('temperature/index.html.twig', [
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
