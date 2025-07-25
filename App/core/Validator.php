<?php

namespace App\Core;

class Validator
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public static function make(array $data, array $rules): self
    {
        return new self($data, $rules);
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;

            foreach ($rules as $rule) {
              
                [$ruleName, $params] = $this->parseRule($rule);

                $method = 'validate' . ucfirst($ruleName);
                if (method_exists($this, $method)) {
                    $this->$method($field, $value, $params);
                }
            }
        }

        return empty($this->errors);
    }

    protected function parseRule(string $rule): array
    {
        if (strpos($rule, ':') !== false) {
            [$ruleName, $params] = explode(':', $rule, 2);
            $params = explode(',', $params);
        } else {
            $ruleName = $rule;
            $params = [];
        }
        return [$ruleName, $params];
    }

    protected function validateRequired(string $field, $value, array $params)
    {
        if (is_null($value) || trim($value) === '') {
            $this->addError($field, "Le champ $field est obligatoire.");
        }
    }

    protected function validateEmail(string $field, $value, array $params)
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, "Le champ $field doit être une adresse email valide.");
        }
    }

    protected function validateUnique(string $field, $value, array $params)
    {
        if (count($params) !== 2) {
            throw new \Exception("La règle unique doit avoir deux paramètres: table,colonne");
        }
        [$table, $column] = $params;

        
        $repositoryClass = "App\\Repositories\\" . ucfirst($table) . "Repository";

        if (!class_exists($repositoryClass)) {
            throw new \Exception("Le repository $repositoryClass n'existe pas.");
        }

        /** @var \App\Core\Abstract\AbstractRepository $repo */
        $repo = $repositoryClass::getInstance();

        if (!$repo->isUnique($column, $value)) {
            $this->addError($field, "La valeur de $field existe déjà.");
        }
    }

    protected function validatePhone(string $field, $value, array $params)
    {
        if ($value && !preg_match('/^(77|78|76|70|75)[0-9]{7}$/', $value)) {
            $this->addError($field, "Le numéro $field doit commencer par 77,78,76,70 ou 75 et contenir 9 chiffres.");
        }
    }

    protected function validateFile(string $field, $value, array $params)
    {
        // Ici tu peux récupérer $_FILES[$field] dans $this->data ou adapter la logique
        $file = $_FILES[$field] ?? null;

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            $this->addError($field, "Le fichier $field est obligatoire.");
            return;
        }
    }

    protected function validateMimes(string $field, $value, array $params)
    {
        $file = $_FILES[$field] ?? null;
        if ($file && !in_array($file['type'], array_map(fn($e) => "image/$e", $params))) {
            $this->addError($field, "Le fichier $field doit être de type : " . implode(', ', $params));
        }
    }

    protected function validateMax(string $field, $value, array $params)
    {
        $maxSize = (int)$params[0];
        $file = $_FILES[$field] ?? null;
        if ($file && $file['size'] > $maxSize) {
            $this->addError($field, "Le fichier $field est trop volumineux (max $maxSize octets).");
        }
    }
    protected function validateLength(string $field, $value, array $params)
    {
        if (!$value) {
            return; 
        }

        $length = strlen(trim((string)$value));

        if (count($params) === 1) {
            $exact = (int)$params[0];
            if ($length !== $exact) {
                $this->addError($field, "Le champ $field doit contenir exactement $exact caractères.");
            }
        } elseif (count($params) === 2) {
            $min = (int)$params[0];
            $max = (int)$params[1];
            if ($length < $min || $length > $max) {
                $this->addError($field, "Le champ $field doit contenir entre $min et $max caractères.");
            }
        } else {
            throw new \Exception("La règle length attend 1 ou 2 paramètres.");
        }
    }
     protected function validateNumber(string $field, $value, array $params)
    {
        if ($value && !is_numeric($value)) {
            $this->addError($field, "Le champ $field doit être un nombre.");
        }
        
        if ($value && (float)$value <= 0) {
            $this->addError($field, "Le champ $field doit être supérieur à zéro.");
        }
    }
    protected function addError(string $field, string $message)
    {
        $this->errors[$field][] = $message;
    }

    public function errors(): array
    {
        return $this->errors;
    }
   
}
