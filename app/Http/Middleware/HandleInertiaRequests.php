<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function share(Request $request): array
    {
        // On prépare les données de base
        $shared = [
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                ] : null,
            ],
            'flash' => [
                'message' => $request->session()->get('message'),
            ],
        ];

        // SÉCURITÉ RADICALE : On n'ajoute Ziggy que SI la classe existe
        if (class_exists(\Tightenco\Ziggy\Ziggy::class)) {
            $shared['ziggy'] = array_merge((new \Tightenco\Ziggy\Ziggy)->toArray(), [
                'location' => $request->url(),
            ]);
        } else {
            // Si Ziggy est toujours porté disparu, on envoie un tableau vide
            // pour ne pas faire crash l'application.
            $shared['ziggy'] = ['routes' => [], 'url' => $request->url()];
        }

        return array_merge(parent::share($request), $shared);
    }
}