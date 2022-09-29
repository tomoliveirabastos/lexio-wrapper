<?php

namespace LexioWrapper;

class LexioToken
{

       private string $lexioToken;
       private string $baseurl = "localhost:8000/api";

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
