<?php

namespace App\Services;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoMailService
{
    protected $apiInstance;

    public function __construct()
    {
        // Récupération sécurisée de la clé API via le config
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', config('services.brevo.key'));
        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }
    
    public function sendWelcomeEmail($user)
    {
        $sendSmtpEmail = new \Brevo\Client\Model\SendSmtpEmail([
            'subject' => "Bienvenue chez Quincaillerie ARCS Pro !",
            'sender' => ['name' => 'Équipe ARCS', 'email' => config('mail.from.address')],
            'to' => [['email' => $user->email, 'name' => $user->name]],
            'htmlContent' => "<h1>Bienvenue {$user->name} !</h1><p>Votre compte est prêt. " . ($user->is_pro ? "Notre équipe étudie vos avantages Pro." : "") . "</p>",
        ]);

        try {
            $this->apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) { \Log::error($e->getMessage()); }
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