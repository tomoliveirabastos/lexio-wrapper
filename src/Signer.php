<?php

namespace LexioWrapper;

class Signer
{

       private string $name;
       private string $email;
       private string $function;
       public function setName(string $name): self
       {
              $this->name = $name;

              return $this;
       }

       public function setEmail(string $email): self
       {
              $this->email = $email;
              return $this;
       }

       public function setFunction(string $function): self
       {
              $this->function = $function;
              return $this;
       }

       public function getName(): string
       {

              return $this->name;
       }

       public function getEmail(): string
       {

              return $this->email;
       }

       public function getFunction(): string
       {

              return $this->function;
       }
}
