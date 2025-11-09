<?php
// src/Controller/UploadController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route('/upload-image', name: 'upload_image', methods: ['POST'])]
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $image = $request->files->get('image');
            $folderName = $request->request->get('folder', 'uploads');
            $category = $request->request->get('category', 'general');

            // Validation du fichier
            if (!$image) {
                return new JsonResponse(['error' => 'Aucun fichier reçu'], 400);
            }

            // Validation du type MIME
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                return new JsonResponse(['error' => 'Type de fichier non autorisé'], 400);
            }

            // Validation de la taille (5MB max)
            if ($image->getSize() > 5 * 1024 * 1024) {
                return new JsonResponse(['error' => 'Fichier trop volumineux (max 5MB)'], 400);
            }

            // Nettoyage du nom du dossier
            $folderName = preg_replace('/[^a-zA-Z0-9_-]/', '', $folderName);
            if (empty($folderName)) {
                $folderName = 'uploads';
            }

            // Création du dossier
            $targetDirectory = $this->getParameter('kernel.project_dir') . '/public/storage/' . $folderName;
            if (!is_dir($targetDirectory)) {
                if (!mkdir($targetDirectory, 0755, true)) {
                    return new JsonResponse(['error' => 'Impossible de créer le dossier'], 500);
                }
            }

            // Génération du nom de fichier
            $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate(
                'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                $originalFilename
            );
            $filename = $safeFilename . '_' . uniqid() . '.' . $image->guessExtension();

            // Déplacement du fichier
            $image->move($targetDirectory, $filename);

            // URL publique
            $baseUrl = $request->getSchemeAndHttpHost();
            $imageUrl = $baseUrl . '/storage/' . $folderName . '/' . $filename;

            return new JsonResponse([
                'url' => $imageUrl,
                'filename' => $filename,
                'folder' => $folderName,
                'category' => $category,
                'message' => 'Fichier uploadé avec succès'
            ]);

        } catch (FileException $e) {
            return new JsonResponse(['error' => 'Erreur lors du sauvegarde du fichier: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Erreur serveur: ' . $e->getMessage()], 500);
        }
    }
}
