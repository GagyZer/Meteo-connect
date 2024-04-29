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
        // Vérifier si la demande contient un fichier JSON
        if ($request->files->has('json_file')) {
            // Récupérer le fichier JSON
            $jsonFile = $request->files->get('json_file');

            // Vérifier si le fichier est valide
            if ($jsonFile->isValid() && $jsonFile->getClientOriginalExtension() === 'json') {
                // Lire le contenu du fichier JSON
                $jsonContent = file_get_contents($jsonFile->getPathname());

                // Convertir le JSON en tableau associatif
                $jsonData = json_decode($jsonContent, true);

                // Faire ce que vous avez besoin de faire avec les données JSON
                // Par exemple, retourner les données JSON en tant que réponse JSON
                return new JsonResponse($jsonData); 
            } else {
                // Le fichier n'est pas un fichier JSON valide
                return new JsonResponse(['error' => 'Invalid JSON file'], 400);
            }
        } else {
            // Aucun fichier JSON trouvé dans la demande
            return new JsonResponse(['error' => 'No JSON file found in the request'], 400);
        }
    }
}
