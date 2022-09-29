<?php

namespace LexioWrapper;

use Psr\Http\Message\StreamInterface;

class AddSigner
{

       /**
        * @var Signer[]
        */
       private array $signers;
       private LexioToken $lexioToken;

       public function __construct(LexioToken $lexioToken)
       {
              $this->lexioToken = $lexioToken;
       }

       public function add(Signer $signer): self
       {
              $this->signers[] = $signer;

              return $this;
       }

       public function send(string $documentToken): StreamInterface
       {
              $url = "{$this->lexioToken->getBaseUrl()}/add_signers/{$documentToken}";
              $client = new \GuzzleHttp\Client();
              $res = $client->request("POST", $url, [
                     "json" => array_map(function (Signer $signer) {
                            return [
                                   "email" => $signer->getEmail(),
                                   "nome" => $signer->getName(),
                                   "funcao" => $signer->getFunction()
                            ];
                     }, $this->signers),
                     "headers" => [
                            "lexiotoken" => $this->lexioToken->getLexioToken()
                     ]
              ]);

              return $res->getBody();
       }
}
