<?php
namespace App\Core;

class FileService
{
    public static function uploadFile($fichier, $dossier = null)
    {
           $dossier = $dossier ?? $_ENV['UPLOAD_DIR'] ?? 'images/uploads';
        
      
        if (!isset($fichier) || $fichier['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception("Fichier invalide ou erreur d'upload.");
        }

       
        $maxSize = $_ENV['UPLOAD_MAX_SIZE'] ?? 2097152;
        if ($fichier['size'] > $maxSize) {
            throw new \Exception("Fichier trop volumineux. Taille maximale: " . ($maxSize / 1024 / 1024) . "MB");
        }

      
        $allowedTypes = explode(',', $_ENV['UPLOAD_ALLOWED_TYPES'] ?? 'jpeg,jpg,png,gif');
        $extension = strtolower(pathinfo($fichier['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $allowedTypes)) {
            throw new \Exception("Type de fichier non autorisé. Types acceptés: " . implode(', ', $allowedTypes));
        }

        
        $publicDir = $_ENV['PUBLIC_PATH'] ?? 'public';
        $publicPath = realpath(__DIR__ . '/../../' . $publicDir);

        if (!$publicPath) {
            throw new \Exception("Le dossier public est introuvable.");
        }

        $uploadPath = $publicPath . '/' . $dossier;

        if (!is_dir($uploadPath)) 
        {
            if (!mkdir($uploadPath, 0755, true)) {
                throw new \Exception("Impossible de créer le dossier d'upload: " . $uploadPath);
            }
        }

        if (!is_writable($uploadPath)) {
            throw new \Exception("Le dossier d'upload n'est pas accessible en écriture: " . $uploadPath);
        }

        $extension = pathinfo($fichier['name'], PATHINFO_EXTENSION);
        $filename = uniqid('cni_', true) . '.' . $extension;
        $targetFile = $uploadPath . '/' . $filename;      
        
        if (move_uploaded_file($fichier['tmp_name'], $targetFile)) {
            return $dossier . '/' . $filename;
        } else {
            throw new \Exception("Échec de l'envoi du fichier vers: " . $targetFile);
        }
    }
}
