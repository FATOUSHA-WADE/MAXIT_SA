<?php
namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    private string $sid;
    private string $token;
    private string $from;
    private Client $client;

    public function __construct()
    {
        $this->sid = $_ENV['TWILIO_SID'];         
        $this->token = $_ENV['TWILIO_TOKEN'];
        $this->from = $_ENV['TWILIO_FROM'];
        $this->client = new Client($this->sid, $this->token);
    }

    public function sendCode(string $to, string $code): bool
    {
        try 
        {
            $this->client->messages->create($to,
            [
                'from' => $this->from,
                'body' => "Votre code secret MAXIT est : $code"
            ]
        );
            return true;
        } catch (\Exception $e) {
          throw new \Exception("Erreur lors de l'envoi du sms: " . $e->getMessage());
          exit;
            
        }
    }
}
