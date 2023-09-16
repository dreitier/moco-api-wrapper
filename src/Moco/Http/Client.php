<?php
declare(strict_types=1);

namespace Dreitier\Moco\Http;

use Dreitier\Moco\Business\MocoId;
use Illuminate\Support\Facades\Http;

class Client
{
    public function __construct(
        public readonly string $subdomain,
        public readonly string $apiKey,
        public readonly string $relativePath,
        public readonly string $domain = 'mocoapp.com',
        public readonly string $apiVersion = 'v1')
    {
    }

    const HEADER_X_IMPERSONATE_USER_ID = 'X-IMPERSONATE-USER-ID';

    private ?int $impersonateAs = null;
    private bool $removeImpersonation = false;

    public function impersonate($userId): Client
    {
        $this->impersonateAs = $userId;
        $this->removeImpersonation = false;

        return $this;
    }

    public function impersonateNextCall(MocoId|int $userId): Client
    {
        $this->impersonateAs = ($userId instanceof MocoId) ? $userId->value : $userId;
        $this->removeImpersonation = true;

        return $this;
    }

    public function targetUrl($lastSegment = '')
    {
        $r = 'https://' . $this->subdomain . '.' . $this->domain . '/api/' . $this->apiVersion . '/' . $this->relativePath . '/' . $lastSegment;

        return $r;
    }

    public function createHttpClient()
    {
        $headers = [
            'Authorization' => 'Token token=' . $this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];

        if ($this->impersonateAs) {
            $headers[static::HEADER_X_IMPERSONATE_USER_ID] = $this->impersonateAs;

            if ($this->removeImpersonation) {
                $this->impersonateAs = null;
            }
        }

        return Http::withHeaders($headers);
    }

    public function get_response(string $relativePath, array|null|ConvertToParameter $query = null): Response
    {
        if ($query instanceof ConvertToParameter) {
            $query = $query->toArgs();
        }

        return Response::handle($this->createHttpClient()->get($this->targetUrl($relativePath), $query));
    }

    public function get(string $relativePath, array|null|ConvertToParameter $query = null): array|object
    {
        return $this->get_response($relativePath, $query)->decodeJson();
    }

    public function get_all_pages(string $relativePath, array|null|ConvertToParameter $query = null)
    {
        if ($query instanceof ConvertToParameter) {
            $query = $query->toArgs();
        }

        $r = [];

        do {
            $response = $this->get_response($relativePath, $query);
            $decodedContent = $response->decodeJson();

            $r = array_merge($r, $decodedContent);
        } while (null !== ($query = $response->extractQueryParamsForNextPage()));

        return $r;
    }

    public function post(string $relativePath, $data): array|object
    {
        return $this->post_response($relativePath, $data)->decodeJson();
    }

    public function post_response(string $relativePath, $data): Response
    {
        return Response::handle($this->createHttpClient()->post($this->targetUrl($relativePath), $data));
    }

    public function delete(string $relativePath): Response
    {
        return $this->delete_response($relativePath);
    }

    public function delete_response(string $relativePath): Response
    {
        return Response::handle($this->createHttpClient()->delete($this->targetUrl($relativePath), []));
    }

}
