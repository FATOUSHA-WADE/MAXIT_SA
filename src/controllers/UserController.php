<?php

namespace App\Controllers;

use App\Core\Abstract\AbstractController;
use App\Entities\User;
use App\Services\TransactionService;
use App\Services\CompteService;
use App\Core\App;
use App\Core\Paginator;
use App\Core\Validator;
use App\Entities\Compte;


class UserController extends AbstractController
  
{

    private TransactionService $transactionService;
    private CompteService $compteService;

    public function __construct()
    {
        parent::__construct();
       
        $this->layout = 'base.layout.php'; 
        $this->transactionService = App::getDependencie('TransactionService');
        $this->compteService = App::getDependencie('CompteService');
    }

    /**
     * Prépare les données communes pour tous les templates
     */
    private function prepareCommonData($userData): array
    {
        $user = $userData['user'];
        $compteActuel = $userData['compte'];
        
        // Toujours récupérer le compte principal pour la sidebar
        $comptePrincipal = $this->compteService->getComptePrincipal($user->getId());
        
        return [
            'user' => $user,
            'compte' => $compteActuel,
            'comptePrincipal' => $comptePrincipal
        ];
    }

    public function index(): void
    {
        $userData = $this->session->get('user');
       
        if (!$userData) {
            $this->redirect('/');
            return;
        }
        
        $commonData = $this->prepareCommonData($userData);
        $transactions = $this->transactionService->getLastTransactions($commonData['compte']->getId(), 10);
        
        $this->render('client/dashboard', array_merge($commonData, [
            'transactions' => $transactions
        ]));
    }

    public function transactions(): void
    {
        $userData = $this->session->get('user');
       
        if (!$userData) {
            $this->redirect('/');
            return;
        }
        
        $commonData = $this->prepareCommonData($userData);
        $allTransactions = $this->transactionService->getAllTransactions($commonData['compte']->getId());
        
      
        $result = Paginator::paginate($allTransactions, 6);
        
        $this->render('client/transactions/transactions', array_merge($commonData, [
            'transactions' => $result['items'],
            'pagination' => $result
        ]));
    }

    public function nouveauCompte(): void
    {
        $userData = $this->session->get('user');
       
        if (!$userData) {
            $this->redirect('/');
            return;
        }
        
        $user = $userData['user']; 
        $compte = $userData['compte'];
        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numeroTelephone = $_POST['numero_telephone'] ?? '';
            $solde = floatval($_POST['solde'] ?? 0);

            if (empty($numeroTelephone)) {
                $error = 'Le numéro de téléphone est requis';
            } elseif ($solde < 0) {
                $error = 'Le solde ne peut pas être négatif';
            } else {
                try {
                    $nouveauCompte = $this->compteService->creerCompteSecondaire(
                        $numeroTelephone, 
                        $user->getId(), 
                        $solde
                    );
                    
                    if ($nouveauCompte) {
                        $message = 'Compte secondaire créé avec succès !';
                    } else {
                        $error = 'Erreur lors de la création du compte';
                    }
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $this->render('client/nouveau-compte', [
            'user' => $user,
            'compte' => $compte,
            'message' => $message,
            'error' => $error
        ]);
    }

    public function acountsList()
    {
        $userData = $this->session->get('user');
        if (!$userData) {
            $this->redirect('/');
            return;
        }
        
        $commonData = $this->prepareCommonData($userData);
        $user = $commonData['user'];
        
        // Récupérer tous les comptes
        $allAccounts = $this->compteService->getTousLesComptes($user->getId());
        $primaryAccount = null;
        $secondaryAccounts = [];
        
        foreach ($allAccounts as $account) {
            if ($account->getTypeCompte() === 'Principal') {
                $primaryAccount = $account;
            } else {
                $secondaryAccounts[] = $account;
            }
        }
        $result = Paginator::paginate($secondaryAccounts,2);
      
        
        $totalAccounts = $this->compteService->countComptes();
        
        $this->render("client/compte/index", array_merge($commonData, [
            'accounts' => $result['items'],
            'pagination'=>$result,
            'primaryaccount' => $primaryAccount,
            'totalAccounts' => $totalAccounts
        ]));
    }

    public function depot(): void
    {
        $userData = $this->session->get('user');
        if (!$userData) {
            $this->redirect('/');
            return;
        }
        
        $commonData = $this->prepareCommonData($userData);
        $message = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $montant = floatval($_POST['montant'] ?? 0);
            if ($montant <= 0) {
                $error = 'Le montant doit être supérieur à zéro.';
            } else {
                try {
                    $transaction = new \App\Entities\Transaction(
                        0,
                        $montant,
                        'Depot',
                        new \DateTime(),
                        $commonData['compte']->getId()
                    );
                    $this->transactionService->createTransaction($transaction);
                    $commonData['compte']->setSolde($commonData['compte']->getSolde() + $montant);
                    $this->compteService->updateSolde($commonData['compte']->getId(), $commonData['compte']->getSolde());
                    $message = 'Dépôt effectué avec succès !';
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }
        $this->render('client/depot', array_merge($commonData, [
            'message' => $message,
            'error' => $error
        ]));
    }

    public function createSecondaryAccount()
    {
        $userData = $this->session->get('user');
        if (!$userData) {
            $this->redirect('/');
            return;
        }
        
        $commonData = $this->prepareCommonData($userData);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
           $rules = [
                'telephone' => ['required', 'length:9', 'phone'],
                'solde' => ['number'],
            ];
        
            $validator = Validator::make($_POST, $rules);
          
            if ($validator->validate())
            {
                try {
                  $account = new Compte(
                    0,
                    $_POST['solde'],
                    'Secondaire',
                    $_POST['telephone']
                  );
                $account->setUser($commonData['user']);
                $compte = $this->compteService->creerCompteSecondaire($account);
                    if ($compte) {
                        $this->session->set('success', 'Compte secondaire créé avec succès !');
                        $this->redirect('/client/acountsList');
                    } else {
                        $this->session->set('error', 'Erreur lors de la création du compte');
                    }
                } catch (\Throwable $th) {
                    echo "Erreur lors de la création du compte : " . $th->getMessage();
                    die;
                }
            }
        }

        $this->render("client/compte/create", $commonData);
    }

    public function setMainAccount()
    {
        $userData = $this->session->get('user');
        if (!$userData) {
            $this->redirect('/');
            return;
        }

        $user = $userData['user'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $compteId = $_POST['compte_id'] ?? null;

            if (!$compteId) {
                $this->session->set('general_error', 'ID du compte manquant');
                $this->redirect('/client/acountsList');
                return;
            }

            try {
                $result = $this->compteService->definirComptePrincipal($compteId, $user->getId());
                
                if ($result) {
                    $nouveauComptePrincipal = $this->compteService->getCompteById($compteId);
                    if ($nouveauComptePrincipal) {
                        $userData['compte'] = $nouveauComptePrincipal;
                        $this->session->set('user', $userData);
                    }
                    
                    $this->session->set('success', 'Compte principal défini avec succès !');
                    $this->redirect('/client/acountsList');
                    return;
                } else {
                    $this->session->set('general_error', 'Erreur lors de la définition du compte principal');
                }
            } catch (\Exception $e) {
                $this->session->set('general_error', $e->getMessage());
            }
        }

        $this->redirect('/client/acountsList');
    }

    public function depotTransfert(): void
    {
        $userData = $this->session->get('user');
        if (!$userData) {
            $this->redirect('/');
            return;
        }
        
        $commonData = $this->prepareCommonData($userData);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rules = [
                'telephone_destination' => ['required', 'length:9', 'phone'],
                'montant' => ['required'],
            ];
        
            $validator = Validator::make($_POST, $rules);
          
            if ($validator->validate()) {
                try {
                    $telephoneDestination = $_POST['telephone_destination'];
                    $montant = floatval($_POST['montant']);
                    
                    $compteDestination = $this->compteService->getCompteByTelephone($telephoneDestination);
                    
                    if (!$compteDestination) {
                        throw new \Exception("Compte de destination introuvable");
                    }
                    
                    if ($commonData['compte']->getSolde() < $montant) {
                        throw new \Exception("Solde insuffisant");
                    }
                    
                    // Débiter le compte source
                    $nouveauSoldeSource = $commonData['compte']->getSolde() - $montant;
                    $this->compteService->updateSolde($commonData['compte']->getId(), $nouveauSoldeSource);
                    
                    // Créditer le compte destination
                    $nouveauSoldeDestination = $compteDestination->getSolde() + $montant;
                    $this->compteService->updateSolde($compteDestination->getId(), $nouveauSoldeDestination);
                    
                    // Créer les transactions
                    $transactionSortie = new \App\Entities\Transaction(
                        0,
                        $montant,
                        'Depot',
                        new \DateTime(),
                        $commonData['compte']->getId()
                    );
                    $this->transactionService->createTransaction($transactionSortie);
                    
                    $transactionEntree = new \App\Entities\Transaction(
                        0,
                        $montant,
                        'Depot',
                        new \DateTime(),
                        $compteDestination->getId()
                    );
                    $this->transactionService->createTransaction($transactionEntree);
                    
                    $this->session->set('success', 'Dépôt par transfert effectué avec succès !');
                    $this->redirect('/client/dashboard');
                    return;
                    
                } catch (\Exception $e) {
                    $this->session->set('general_error', $e->getMessage());
                }
            } else {
                $this->session->set('field_errors', $validator->errors());
            }
        }
        
        $this->render('client/depot-transfert', array_merge($commonData, [
            'old' => $_POST ?? []
        ]));
    }
}
