# Documentation API - Boutique en Ligne

## URL de base

``` bash
http://localhost:8000/api
```

En production, remplace `localhost:8000` par l'URL de ton serveur.

## Authentification

Actuellement, l'API est publique et ne nécessite pas d'authentification. Pour une utilisation en production, nous recommandons d'ajouter Laravel Sanctum pour sécuriser l'API.

## Format des réponses

Toutes les réponses sont au format JSON et suivent cette structure :

```json
{
    "success": true,
    "message": "Description de la réponse",
    "data": { ... }
}
```

## Endpoints disponibles

### 1. Lister tous les produits

**GET** `/api/products`

**Paramètres query optionnels :**

- `category` : Filtrer par catégorie (ex: Smartphones)
- `brand` : Filtrer par marque (ex: Apple)
- `search` : Recherche textuelle dans titre et description
- `featured` : `true` pour afficher uniquement les produits vedettes
- `new` : `true` pour afficher uniquement les nouveaux produits
- `sort` : Champ de tri (`created_at`, `price`, `title`, `stock`)
- `order` : Ordre de tri (`asc` ou `desc`)
- `per_page` : Nombre d'éléments par page (max 100)
- `page` : Numéro de la page

**Exemple de requête :**

```bash
curl "http://localhost:8000/api/products?category=Smartphones&sort=price&order=asc&per_page=10"
```

**Exemple de réponse :**

```json
{
    "success": true,
    "message": "Produits récupérés avec succès",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "iPhone 15 Pro Max",
                "desc": "Le summum de la technologie Apple avec puce A17 Pro.",
                "category": "Smartphones",
                "brand": "Apple",
                "price": 850000,
                "stock": 5,
                "img": "products/abc123.jpg",
                "image_url": "http://localhost:8000/storage/products/abc123.jpg",
                "featured": true,
                "new": true,
                "created_at": "2025-01-15T10:30:00.000000Z",
                "updated_at": "2025-01-15T10:30:00.000000Z"
            }
        ],
        "per_page": 12,
        "total": 52
    }
}
```

### 2. Récupérer les détails d'un produit

**GET** `/api/products/{id}`

**Exemple de requête :**

```bash
curl "http://localhost:8000/api/products/1"
```

**Exemple de réponse :**

```json
{
    "success": true,
    "message": "Détails du produit récupérés avec succès",
    "data": {
        "product": {
            "id": 1,
            "title": "iPhone 15 Pro Max",
            ...
        },
        "similar_products": [...]
    }
}
```

### 3. Créer un nouveau produit

**POST** `/api/products`

**Headers requis :**

```
Content-Type: application/json
Accept: application/json
```

**Corps de la requête (JSON) :**

```json
{
    "title": "Nouveau Produit",
    "desc": "Description du produit",
    "category": "Smartphones",
    "brand": "Samsung",
    "price": 500000,
    "stock": 10,
    "featured": false,
    "new": true
}
```

**Pour envoyer une image, utilise multipart/form-data** :

```bash
curl -X POST http://localhost:8000/api/products \
  -F "title=Nouveau Produit" \
  -F "category=Smartphones" \
  -F "brand=Samsung" \
  -F "price=500000" \
  -F "stock=10" \
  -F "img=@/chemin/vers/image.jpg"
```

### 4. Mettre à jour un produit

**PUT/PATCH** `/api/products/{id}`

**Corps de la requête (JSON) :**

```json
{
    "price": 450000,
    "stock": 8
}
```

Note : Tu peux envoyer uniquement les champs à modifier (mise à jour partielle).

### 5. Supprimer un produit

**DELETE** `/api/products/{id}`

**Exemple de requête :**

```bash
curl -X DELETE "http://localhost:8000/api/products/1"
```

### 6. Récupérer toutes les catégories

**GET** `/api/products-categories`

**Exemple de réponse :**

```json
{
    "success": true,
    "message": "Catégories récupérées avec succès",
    "data": [
        "Smartphones",
        "Laptops",
        "Écouteurs",
        "Tablettes",
        "Appareils Photo"
    ]
}
```

### 7. Récupérer toutes les marques

**GET** `/api/products-brands`

**Exemple de réponse :**

```json
{
    "success": true,
    "message": "Marques récupérées avec succès",
    "data": [
        "Apple",
        "Samsung",
        "ASUS",
        "Dell",
        "HP"
    ]
}
```

### 8. Récupérer les statistiques

**GET** `/api/products-statistics`

**Exemple de réponse :**

```json
{
    "success": true,
    "message": "Statistiques récupérées avec succès",
    "data": {
        "total_products": 52,
        "total_stock": 385,
        "featured_products": 12,
        "new_products": 15,
        "out_of_stock_products": 3,
        "total_categories": 7,
        "total_brands": 15
    }
}
```

### 9. Test de santé de l'API

**GET** `/api/health`

Vérifie que l'API fonctionne correctement.

## Codes de statut HTTP

- `200 OK` : Requête réussie
- `201 Created` : Ressource créée avec succès
- `400 Bad Request` : Erreur de validation des données
- `404 Not Found` : Ressource introuvable
- `500 Internal Server Error` : Erreur serveur

## Pagination

Toutes les listes paginées incluent ces informations :

```json
{
    "current_page": 1,
    "data": [...],
    "first_page_url": "http://localhost:8000/api/products?page=1",
    "last_page": 5,
    "last_page_url": "http://localhost:8000/api/products?page=5",
    "next_page_url": "http://localhost:8000/api/products?page=2",
    "per_page": 12,
    "prev_page_url": null,
    "total": 52
}
```

## Exemples d'utilisation

### JavaScript (Fetch API)

```javascript
// Récupérer tous les produits
fetch('http://localhost:8000/api/products')
    .then(response => response.json())
    .then(data => {
        console.log(data.data.data); // Tableau des produits
    });

// Créer un nouveau produit
fetch('http://localhost:8000/api/products', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    body: JSON.stringify({
        title: 'iPhone 16 Pro',
        category: 'Smartphones',
        brand: 'Apple',
        price: 900000,
        stock: 3
    })
})
.then(response => response.json())
.then(data => {
    console.log(data.data); // Nouveau produit créé
});
```

### React (avec Axios)

```javascript
import axios from 'axios';

const API_URL = 'http://localhost:8000/api';

// Récupérer les produits
const fetchProducts = async () => {
    try {
        const response = await axios.get(`${API_URL}/products`);
        return response.data.data.data;
    } catch (error) {
        console.error('Erreur:', error);
    }
};

// Créer un produit
const createProduct = async (productData) => {
    try {
        const response = await axios.post(`${API_URL}/products`, productData);
        return response.data.data;
    } catch (error) {
        console.error('Erreur:', error.response.data);
    }
};
```

### Python (avec requests)

```python
import requests

API_URL = 'http://localhost:8000/api'

# Récupérer les produits
response = requests.get(f'{API_URL}/products')
products = response.json()['data']['data']

# Créer un produit
new_product = {
    'title': 'Galaxy S25',
    'category': 'Smartphones',
    'brand': 'Samsung',
    'price': 700000,
    'stock': 5
}
response = requests.post(f'{API_URL}/products', json=new_product)
created_product = response.json()['data']
```

## Notes importantes

1. **Images** : Les URLs des images sont complètes et directement utilisables
2. **Validation** : Tous les endpoints valident les données entrantes
3. **Pagination** : Par défaut 12 éléments par page, maximum 100
4. **Filtres** : Les filtres sont cumulables
5. **CORS** : L'API accepte les requêtes depuis n'importe quel domaine en développement

## Support

Pour toute question ou problème, contacte-moi directement.

``` bash
## Étape 5 : Tester ton API

Avant de donner accès à ton collègue, tu devrais tester ton API pour t'assurer qu'elle fonctionne correctement. Tu peux utiliser plusieurs outils pour cela.

Le plus simple est d'utiliser ton navigateur pour les requêtes GET. Démarre ton serveur Laravel avec `php artisan serve` puis visite ces URLs :
```

<http://localhost:8000/api/health>
<http://localhost:8000/api/products>
<http://localhost:8000/api/products/1>
<http://localhost:8000/api/products-categories>
<http://localhost:8000/api/products-statistics>

# Tester le health check

curl <http://localhost:8000/api/health>

# Récupérer tous les produits

curl <http://localhost:8000/api/products>

# Récupérer un produit spécifique

curl <http://localhost:8000/api/products/1>

# Récupérer les produits avec filtres

curl "<http://localhost:8000/api/products?category=Smartphones&featured=1>"

# Créer un nouveau produit (JSON)

curl -X POST <http://localhost:8000/api/products> \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "title": "Test Product",
    "desc": "Description du test",
    "category": "Smartphones",
    "brand": "TestBrand",
    "price": 100000,
    "stock": 5,
    "featured": true,
    "new": false
  }'

# Mettre à jour un produit

curl -X PUT <http://localhost:8000/api/products/1> \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "price": 800000,
    "stock": 10
  }'

# Supprimer un produit

curl -X DELETE <http://localhost:8000/api/products/1>

# Récupérer les statistiques

curl <http://localhost:8000/api/products-statistics>

# Récupérer les catégories

curl <http://localhost:8000/api/products-categories>

# Récupérer les marques

curl <http://localhost:8000/api/products-brands>
