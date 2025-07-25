<?php
namespace App\Controllers;
use App\Core\Abstract\AbstractController;
use App\Services\SecurityService;
use App\Entities\User;
use App\Repositories\UserRepository;
use App\Repositories\CompteRepository;
use App\Entities\Compte;
use App\Core\FileService;
use App\Core\Validator;
use App\Core\Session;
use App\Core\App;
use App\Services\SmsService;

class SecurityController extends AbstractController
{
    private SecurityService $securityService;
    private CompteRepository $compteRepository;
    private SmsService $smsService;

    public function __construct()
    {
        parent::__construct();
        $this->layout = 'security.layout.php';
        $this->compteRepository = App::getDependencie('CompteRepository');
        $this->securityService = App::getDependencie('SecurityService');
        $this->smsService = new SmsService();
    }

    public function login()
    {
        $success = $this->session->unset('success');

        if($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $rules = [
                'telephone' => ['required', 'length:9', 'phone'],
                'password' => ['required'],
            ];
          
            $validator = Validator::make($_POST, $rules);
            
            if ($validator->validate()) 
            {
                $user = $this->securityService->login(trim($_POST['telephone']), trim($_POST['password']));
                
                if ($user) 
                {
                    $this->session->set('user', $user);
                    header('Location: /client/dashboard');
                    exit();
                } else 
                {
                    
                    $this->session->set('general_error', 'Identifiants incorrects');
                }
            } else 
            {
                
                $this->session->set('field_errors', $validator->errors());
            }
        }
   
        
        $this->render("auth/login",[
            'success' => $success,
            'old' => $_POST ?? [],
           
        ]);
    }
    public function logout()
    {
        $this->session->destroy();
        header('Location: /');
        exit();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $rules = [
                'nom' => ['required'],
                'prenom' => ['required'],
                'numero_cni' => ['required', 'unique:user,numero_cni' ,'length:13'],
                'numero_telephone' => ['required', 'phone', 'unique:compte,telephone'],
                'photorecto' => ['file', 'mimes:jpeg,png,jpg', 'max:2000000'],
                'photoverso' => ['file', 'mimes:jpeg,png,jpg', 'max:2000000'],
                'password' => ['required'],
            ];

            $data = array_merge($_POST, $_FILES);
            
            $validator = Validator::make($data, $rules);
            
            if ($validator->validate()) 
            {
                try {
                    $photorectoPath = FileService::uploadFile($_FILES['photorecto'], 'images/cni');
                    $photoversoPath = FileService::uploadFile($_FILES['photoverso'], 'images/cni');

                    $userData = $_POST;
                    $userData['photorecto'] = $photorectoPath;
                    $userData['photoverso'] = $photoversoPath;
                    $user = User::toObject($userData);
                    $compte = new Compte(
                        0,
                        0.0,
                        'Principal',
                        $_POST['numero_telephone'],
                        0
                    ); 
                    $userId = $this->securityService->registerUserWithCompte($user, $compte);
                  
                    if ($userId !== false)
                     {
                        $code = random_int(100000, 999999); 
                        $phoneNumber = '+221' . $_POST['numero_telephone'];
                        $this->smsService->sendCode($phoneNumber, $code);
                        $this->session->set('success', 'Inscription réussie !');
                        $this->redirect('/');
                        exit;
                    } else {
                        $this->session->set('errors', ['Erreur lors de l\'inscription. Veuillez réessayer.']);
                    }
                } catch (\Exception $e) {
                    $this->session->set('errors', ['Erreur lors de l\'upload: ' . $e->getMessage()]);
                }
            } else 
            {
                $this->session->set('errors', $validator->errors());
            }
        }

        $this->render('auth/register', [
            'old' => $_POST ?? [],
        ]);
    }
}