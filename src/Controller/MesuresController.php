<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MesuresController extends AbstractController
{
    #[Route('/mesures', name: 'app_mesures')]
    public function index(): Response
    {
        return $this->render('mesures/index.html.twig', [
            'controller_name' => 'MesuresController',
        ]);
    }
    #[Route('/mesures/all', name: 'app_mesures_all')]
    public function getJson(Request $request)
    {
        // V�rifier si la demande contient un fichier JSON
        if ($request->files->has('json_file')) {
            // R�cup�rer le fichier JSON
            $jsonFile = $request->files->get('json_file');

            // V�rifier si le fichier est valide
            if ($jsonFile->isValid() && $jsonFile->getClientOriginalExtension() === 'json') {
                // Lire le contenu du fichier JSON
                $jsonContent = file_get_contents($jsonFile->getPathname());

                // Convertir le JSON en tableau associatif
                $jsonData = json_decode($jsonContent, true);

                // Faire ce que vous avez besoin de faire avec les donn�es JSON
                // Par exemple, retourner les donn�es JSON en tant que r�ponse JSON
                return new JsonResponse($jsonData); 
            } else {
                // Le fichier n'est pas un fichier JSON valide
                return new JsonResponse(['error' => 'Invalid JSON file'], 400);
            }
        } else {
            // Aucun fichier JSON trouv� dans la demande
            return new JsonResponse(['error' => 'No JSON file found in the request'], 400);
        }
    }
}
