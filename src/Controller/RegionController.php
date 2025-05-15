<?php

namespace App\Controller;

use App\Entity\Hospital;
use App\Entity\Region;
use App\Form\HospitalForm;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegionController extends AbstractController
{
    #[Route("/api/regions", name: "region.all")]
    function index(Request $request, EntityManagerInterface $em): Response
    {
        $regions = $em->getRepository(Region::class)->findAll();
        return $this->json($regions, 200, [], ['groups' => ['region:read']]);
    }

    #[Route("/api/region/{slug}", name: "region.getRegion")]
    function getRegion(Request $request, string $slug, EntityManagerInterface $em): Response
    {
        $region = $em->getRepository(Region::class)->findOneBy(["slug" => $slug]);
        // dd($region);
        return $this->json($region, 200, [], ['groups' => ['region:read']]);
    }

    #[Route("/api/region/{slug}/hospitals", name: "region.getHospitals")]
    function getHospitals(Request $request, string $slug, EntityManagerInterface $em): Response
    {
        $region = $em->getRepository(Region::class)->findOneBy(["slug" => $slug]);
        // $hospitals = $region->getHospitals();
        return $this->json($region, 200, [], ['groups' => ['region:read']]);
    }

    #[Route('/hospital/add', name: 'hospital_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $hospital = new Hospital();
        $form = $this->createForm(HospitalForm::class, $hospital);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($hospital);
            $em->flush();
            $this->addFlash("success", "Hopital ajouté");
            return $this->redirectToRoute("region.all");
        }
        return $this->render('hospital/create.html.twig', [
            'form' => $form
        ]);
    }
}
