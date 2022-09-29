<?php

namespace LexioWrapper;

use Psr\Http\Message\StreamInterface;

class ReceiveDocument
{
       private string $fileName;
       private string $baseDocument;
       private string $resumo = "";
       private bool $sendEmail = true;
       private bool $orderBy = false;
       private LexioToken $lexioToken;

       /**
        * @var Signer[] $signers
        */
       private array $signers = [];

       public function __construct(LexioToken $lexioToken)
       {
              $this->lexioToken = $lexioToken;
       }

       public function setFileFromSystem(string $filepath): self
       {

              if (!file_exists($filepath)) {

                     throw new \Exception("File does not exist");
              }

              $pathinfo  = pathinfo($filepath);
              $content = base64_encode(file_get_contents($filepath));

              $this->baseDocument = "data:application/{$pathinfo['extension']};base64,{$content}";

              return $this;
       }

       public function setFileName(string $fileName): self
       {

              $this->fileName = $fileName;
              return $this;
       }

       public function addSigner(Signer $signer)
       {
              $this->signers[] = $signer;

              return $this;
       }

       public function setResumo(string $resumo): self
       {

              $this->resumo = $resumo;
              return $this;
       }

       public function setSendEmail(bool $sendEmail): self
       {
              $this->sendEmail = $sendEmail;
              return $this;
       }

       public function setOrderBy(bool $orderBy): self
       {
              $this->orderBy = $orderBy;
              return $this;
       }

       public function getFileName(): string
       {
              return $this->fileName;
       }

       public function getBaseDocument(): string
       {
              return $this->baseDocument;
       }

       public function send(): StreamInterface
       {

              $payload = [
                     "filename" => $this->getFileName(),
                     "base_document" => $this->getBaseDocument(),
                     "signers" => array_map(function (Signer $signer) {
                            return [
                                   "completed_name" => $signer->getName(),
                                   "email" => $signer->getEmail(),
                                   "function" => $signer->getFunction()
                            ];
                     }, $this->signers),
                     "resumo" => $this->resumo,
                     "send_email" => $this->sendEmail,
                     "orderBy" => $this->orderBy,
              ];

              $url = "{$this->lexioToken->getBaseUrl()}/receive_document";

              $client = new \GuzzleHttp\Client();

              $res = $client->request("POST", $url, [
                     "json" => [
                            "document" => $payload
                     ],
                     "headers" => [
                            "lexiotoken" => $this->lexioToken->getLexioToken(),
                     ]
              ]);

              return $res->getBody();
       }
}
