<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SecuredApiPlaceholderController extends AbstractController
{
    #[Route('/api/placeholder', name: 'app_api_placeholder')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SecuredApi/PlaceholderController.php',
        ]);
    }
}
