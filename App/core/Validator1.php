<?php 

namespace App\Core;

class Validator
{
    public static array $errors = [];

    public static function isEmail(string $key, string $value, string $message = ''): bool
    {
       
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::addError($key, $message ?: 'L\'email n\'est pas valide');
            return false;
        }
        
        return true;
    }

    public static function isEmpty(string $key, string $value, string $message = ''): bool
    {
        if (trim($value) === '')
        {
            self::addError($key, $message ?: "Le champ $key ne peut pas être vide");
            return true;
        }
        return false;
    }

    public static function isValid(): bool
    {
        return count(self::$errors) === 0;
    }
     /**
     * Vérifie l'unicité d'une valeur via le repository
     */
    public static function isUnique(string $key, string $value, $repository, string $column, string $message = ''): bool
    {
        if (!$repository->isUnique($column, $value)) {
            self::addError($key, $message ?: "La valeur de $key existe déjà");
            return false;
        }
        return true;
    }
    public static function isValidPhone(string $key, string $value, string $message = ''): bool
    {
        
        $value = trim($value);

       
        if (!preg_match('/^(77|78|76|70|75)[0-9]{7}$/', $value)) {
            self::addError($key, $message ?: "Le numéro doit contenir 9 chiffres et commencer par 77, 78, 76 ou 70.");
            return false;
        }

        return true;
    }

   public static function isPhoneUniqueInCompte(string $key, string $value, $compteRepository, string $message = ''): bool
    {
        if (!self::isValidPhone($key, $value)) 
        {
            return false;
        }

        if (!$compteRepository->isUnique('telephone', $value)) {
            self::addError($key, $message ?: "Ce numéro de téléphone est déjà utilisé.");
            return false;
        }

        return true;
    }



  
public static function isFileValid($field, $file, $types = ['image/jpeg', 'image/png'], $maxSize = 2_000_000) {
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        self::addError($field, 'Le fichier est obligatoire.');
        return false;
    }
    if (!in_array($file['type'], $types)) {
        self::addError($field, 'Type de fichier non autorisé.');
        return false;
    }
    if ($file['size'] > $maxSize) {
        self::addError($field, 'Le fichier est trop volumineux.');
        return false;
    }
    return true;
}
   
    public static function addError(string $field, string $message): void
    {
        if (!isset(self::$errors[$field])) {
            self::$errors[$field] = [];
        }
        self::$errors[$field][] = $message;
    }
    
    public static function getErrors(): array
    {
        return self::$errors;
    }
}