<?php
declare(strict_types=1);

namespace Dreitier\Moco\Http;

use Illuminate\Http\Client\Response as HttpClientResponse;

class Response
{
    public function __construct(public readonly HttpClientResponse $response)
    {
    }

    public function successful(): bool
    {
        return $this->response->successful();
    }

    public function decodeJson(): array|object
    {
        $body = $this->response->body();
        $decodedContent = json_decode($body);

        return $decodedContent;
    }

    public static function handle(HttpClientResponse $response): Response
    {
        $r = new Response($response);

        if (!$r->successful()) {
            $url = "" . $response->effectiveUri();
            $phrase = $response->reason();
            $statusCode = $response->status();
            $content = $response->body();

            throw new Exception("Request on $url failed with $statusCode: $phrase. Content: " . $content, $statusCode, $r, json_decode($content));
        }

        return $r;
    }

    /**
     * If the Link header is present with rel="next", extract the query parameters from the next URL.
     * @param Response $response
     * @return array|null
     */
    public function extractQueryParamsForNextPage(): ?array
    {
        $linkHeader = $this->response->header("Link");

        if ($linkHeader) {
            if (preg_match("/<([^<|^>]*)>; rel=\"next\"/", $linkHeader, $matches)) {
                $nextUrl = $matches[1];
                $r = [];
                $parts = parse_url($nextUrl, PHP_URL_QUERY);
                parse_str($parts, $r);
                return $r;
            }
        }

        return null;
    }
}
