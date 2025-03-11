<?php
// src/Service/JWTService.php

namespace App\Service;

use Firebase\JWT\JWT;  // Assure-toi d'avoir installé le package firebase/php-jwt

class JWTService
{
    private string $jwtSecret;

    // Injection de la clé secrète depuis l'environnement
    public function __construct(string $jwtSecret)
    {
        $this->jwtSecret = $jwtSecret;
    }

    // Méthode pour générer un token JWT
    public function generate(array $payload): string
    {
        // Gardons le payload comme tableau
        // Préparer le header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        // Utilisation de la méthode encode avec un tableau et trois paramètres
        return JWT::encode($payload, $this->jwtSecret, 'HS256');
    }

    // Méthode pour décoder un token JWT
    public function decode(string $token)
    {
        try {
            // Décoder le token en utilisant la clé secrète et l'algorithme HS256
            $decoded = JWT::decode($token, $this->jwtSecret, ['HS256']);
            
            // Retourner l'objet décodé
            return $decoded;
        } catch (\Exception $e) {
            // Gestion des erreurs si le token est invalide
            throw new \Exception('Invalid token: ' . $e->getMessage());
        }
    }
}
