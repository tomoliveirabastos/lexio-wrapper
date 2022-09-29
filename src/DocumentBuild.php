<?php

namespace LexioWrapper;

class DocumentBuild
{
       private string $titulo;
       private array $answers = [];
       private array $signers = [];

       public function addSigner(Signer $signer): self
       {
              $this->signers[] = [
                     "email" => $signer->getEmail(),
                     "funcao" => $signer->getFunction()
              ];

              return $this;
       }

       public function setTitle(string $title): self
       {
              $this->titulo = $title;

              return $this;
       }

       public function setAnswers(string $key, string $value): self
       {
              $this->answers[$key] = $value;

              return $this;
       }

       public function getAnswers(): array
       {
              return $this->answers;
       }

       public function getSigners(): array
       {

              return $this->signers;
       }

       public function getTitle(): string
       {

              return $this->titulo;
       }
}
