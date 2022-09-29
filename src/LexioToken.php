<?php

namespace LexioWrapper;

class LexioToken
{

       private string $lexioToken;
       private string $baseurl = "https://app.lexio.legal/api";

       public function __construct(string $lexioToken)
       {
              $this->lexioToken = $lexioToken;
       }

       public function getBaseUrl(): string
       {
              return $this->baseurl;
       }

       public function getLexioToken(): string
       {
              return $this->lexioToken;
       }
}
