<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Log;

class BrevoMailService
{
    protected $apiInstance;

    public function __construct()
    {
        // Configuration de l'API avec ta clé
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('services.brevo.key'));
        
        $this->apiInstance = new TransactionalEmailsApi(
            new Client(),
            $config
        );
    }
    
    public function sendWelcomeEmail($user)
    {
        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => "Bienvenue chez Quincaillerie ARCS Pro - Bras-Panon",
            'sender' => [
                'name' => config('mail.from.name'), 
                'email' => config('mail.from.address')
            ],
            'to' => [[
                'email' => $user->email, 
                'name' => $user->name
            ]],
            'htmlContent' => "
                <div style='font-family: Arial, sans-serif; color: #333;'>
                    <h1 style='color: #00429d;'>Félicitations {$user->name} !</h1>
                    <p>Votre compte est désormais actif sur notre plateforme.</p>
                    <p>Vous pouvez accéder à votre espace client pour suivre vos commandes et gérer vos informations.</p>
                    <div style='margin-top: 20px; padding: 15px; background-color: #f8fafc; border-radius: 10px;'>
                        <p style='margin: 0;'><strong>Type de compte :</strong> " . ($user->is_pro ? 'Professionnel' : 'Particulier') . "</p>
                    </div>
                    <p style='margin-top: 20px;'>À très bientôt dans notre magasin de Bras-Panon !</p>
                </div>",
        ]);

        try {
            return $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (Exception $e) {
            Log::error("Échec de l'envoi Brevo (SDK getbrevo) : " . $e->getMessage());
            return false;
        }
    }
    /**
     * Mail envoyé automatiquement dès que Stripe valide le paiement
     */
    public function sendOrderConfirmation($order)
    {
        $this->sendEmail(
            $order, 
            "Confirmation de commande #{$order->order_number}", 
            'emails.order-confirmation'
        );
    }

    /**
     * Mail envoyé manuellement par l'admin quand le colis est prêt
     */
    public function sendShippingNotification($order)
    {
        $this->sendEmail(
            $order, 
            "Votre commande #{$order->order_number} est en route !", 
            'emails.order-shipped'
        );
    }

    private function sendEmail($order, $subject, $view)
    {
        $sendSmtpEmail = new SendSmtpEmail([
            'subject' => $subject,
            'sender' => ['name' => config('mail.from.name'), 'email' => config('mail.from.address')],
            'to' => [['email' => $order->user->email, 'name' => $order->user->name]],
            'htmlContent' => view($view, compact('order'))->render(),
        ]);

        try {
            $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            \Log::error("Échec envoi Brevo : " . $e->getMessage());
        }
    }

    /**
     * Alerte envoyée à l'administrateur quand un stock devient critique
     */
    public function sendLowStockAlert($product)
    {
        $adminEmail = config('mail.from.address'); // Ou une autre adresse admin spécifique

        $sendSmtpEmail = new \Brevo\Client\Model\SendSmtpEmail([
            'subject' => "⚠️ ALERTE STOCK CRITIQUE : {$product->name}",
            'sender' => ['name' => 'Système ARCS Pro', 'email' => $adminEmail],
            'to' => [['email' => $adminEmail, 'name' => 'Gestionnaire Stock']],
            'htmlContent' => view('emails.low-stock-alert', compact('product'))->render(),
        ]);

        try {
            $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            \Log::error("Erreur alerte stock Brevo : " . $e->getMessage());
        }
    }
}