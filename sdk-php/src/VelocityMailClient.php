<?php

namespace VelocityMail;

use Exception;

/**
 * VelocityMailClient - SDK Oficial para integración de correos.
 */
class VelocityMailClient
{
    private string $apiKey;
    private string $baseUrl;

    /**
     * @param string $apiKey Tu API Key (vmail_...)
     * @param string $baseUrl URL base de tu instancia de VelocityMail
     */
    public function __construct(string $apiKey, string $baseUrl = 'https://velocitymail.mundoweb.pe')
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/') . '/api/v1/send';
    }

    /**
     * Envía un correo electrónico utilizando la API de VelocityMail.
     *
     * @param string $to Correo del destinatario.
     * @param string $subject Asunto del correo.
     * @param string $content Contenido en formato HTML.
     * @param array $options Opciones adicionales como 'from_name' o 'from_email'.
     * @return array Respuesta decodificada de la API.
     * @throws Exception Si ocurre un error de conexión o la API retorna un error.
     */
    public function send(string $to, string $subject, string $content, array $options = []): array
    {
        $payload = array_merge([
            'to' => $to,
            'subject' => $subject,
            'content' => $content,
        ], $options);

        $ch = curl_init($this->baseUrl);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        if ($curlError) {
            throw new Exception("Error de conexión (cURL): " . $curlError);
        }

        $result = json_decode($response, true);

        if ($httpCode !== 200) {
            $errorMsg = $result['message'] ?? 'Error desconocido de la API';
            throw new Exception("VelocityMail API Error ($httpCode): " . $errorMsg);
        }

        return $result;
    }
}
