<?php

namespace App\Controller;

use App\Form\TimeZoneFormType;
use App\Service\TimeZoneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Exception;

class TimeZoneController extends AbstractController
{
    private TimeZoneService $timeZoneService;
    public function __construct(TimeZoneService $timeZoneService)
    {
        $this->timeZoneService = $timeZoneService;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/timezone/form", name="timezone_form", methods={"GET", "POST"})
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(TimeZoneFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            return $this->redirectToRoute('timezone_result', [
                'inputDate' => $formData['date'],
                'inputTimezone' => $formData['timezone'],
            ]);
        }

        return $this->render('timezone/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     * @Route("/timezone/result", name="timezone_result", methods={"GET"})
     */
    public function result(Request $request): Response
    {
        $date = new DateTime($request->get('inputDate'));

        return $this->render('timezone/result.html.twig', [
            'inputTimezone' => $request->get('inputTimezone'),
            'offsetInMinutes' => $this->timeZoneService->getOffsetInMinutes($request->get('inputTimezone')),
            'februaryDaysCount' => $this->timeZoneService->getFebruaryDaysCount($request->get('inputDate')),
            'monthName' => $date->format('F'),
            'monthLength' => (int)$date->format('t'),
        ]);
    }
}
