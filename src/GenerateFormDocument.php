<?php

namespace LexioWrapper;

use Psr\Http\Message\StreamInterface;

class GenerateFormDocument
{
       private string $templateName;
       private array $document = [];
       private LexioToken $lexioToken;

       public function __construct(LexioToken $lexioToken)
       {
              $this->lexioToken = $lexioToken;
       }

       public function setTemplateName(string $templateName): self
       {
              $this->templateName = $templateName;
              return $this;
       }

       public function addDocumentBuild(DocumentBuild $document)
       {
              $payload = $document->getAnswers();
              $payload["document"] = [
                     "titulo" => $document->getTitle(),
                     "signers" => $document->getSigners(),
              ];

              $this->document[] = $payload;

              return $this;
       }

       public function send(): StreamInterface
       {
              $url = "{$this->lexioToken->getBaseUrl()}/generate_form_document/{$this->templateName}";

              $client = new \GuzzleHttp\Client();
              try {

                     $res = $client->request("POST", $url, [
                            "json" => $this->document,
                            "headers" => [
                                   "lexiotoken" => $this->lexioToken->getLexioToken()
                            ]
                     ]);

                     return $res->getBody();
              } catch (\GuzzleHttp\Exception\RequestException $e) {

                     return $e->getResponse()->getBody();
              }
       }
}
