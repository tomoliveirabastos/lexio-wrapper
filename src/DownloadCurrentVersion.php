<?php

namespace LexioWrapper;

class DownloadCurrentVersion
{
       private LexioToken $lexioToken;
       public function __construct(LexioToken $lexioToken)
       {
              $this->lexioToken = $lexioToken;
       }

       public function save(string $documentToken, string $filepath): void
       {
              $url = "{$this->lexioToken->getBaseUrl()}/content/signed_document/{$documentToken}";

              $client = new \GuzzleHttp\Client();

              $res = $client->request("GET", $url, [
                     "headers" => [
                            "lexiotoken" => $this->lexioToken->getLexioToken()
                     ]
              ]);

              file_put_contents($filepath, $res->getBody());
       }
}
