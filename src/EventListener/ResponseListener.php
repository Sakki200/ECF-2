<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $request = $event->getRequest();

        // Ajouter HSTS seulement pour les connexions HTTPS
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }
        // Ajouter le Content Security Policy (CSP)
        // $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' https://ga.jspm.io http://www.w3.org/2000/svg; 'script-src-elem' 'self'; style-src 'self'; font-src 'self'; img-src 'self'; frame-ancestors 'self'; form-action 'self';");

        // Ajouter l'en-tête X-Frame-Options pour prévenir le clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // Retirer l'en-tête X-Powered-By pour masquer les informations sur le serveur
        $response->headers->remove('X-Powered-By');

        // Ajouter l'en-tête X-Content-Type-Options pour éviter le mime-sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Ajouter l'en-tête X-XSS-Protection pour protéger contre les attaques XSS
        $response->headers->set('X-XSS-Protection', '1; mode=block');
    }
}
