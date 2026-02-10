# VelocityMail PHP SDK

SDK Oficial para la integración profesional de envío de correos electrónicos a través de la API de VelocityMail.

## Instalación

La forma recomendada de instalar el SDK es a través de [Composer](https://getcomposer.org/):

```bash
composer require velocitymail/sdk-php
```

## Uso Rápido

```php
require 'vendor/autoload.php';

use VelocityMail\VelocityMailClient;

$client = new VelocityMailClient('vmail_tu_api_key_aqui');

try {
    $result = $client->send(
        to: 'cliente@ejemplo.com',
        subject: '¡Bienvenido a bordo!',
        content: '<h1>Hola</h1><p>Gracias por unirte.</p>',
        options: [
            'from_name' => 'Soporte Especializado'
        ]
    );

    print_r($result);
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
```

## Requisitos

- PHP >= 7.4
- Extensión cURL de PHP
- Extensión JSON de PHP

## Licencia

Este proyecto está bajo la Licencia MIT.
