<?php

return [

    /**
     * Configuration CORS pour permettre aux applications externes d'accéder à l'API.
     * Ces paramètres contrôlent quels domaines peuvent faire des requêtes vers ton API.
     */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    /**
     * Liste des origines autorisées à accéder à l'API.
     * En développement, tu peux utiliser '*' pour permettre toutes les origines.
     * En production, spécifie les domaines exacts pour plus de sécurité.
     */
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
