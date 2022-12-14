# lexio-wrapper
#### documentation - https://app.lexio.legal/lexio/documentation

```bash
composer require tomoliveirabastos/lexio-wrapper:dev-main
```

### Example

```bash
use LexioWrapper\AddSigner;
use LexioWrapper\DocumentBuild;
use LexioWrapper\LexioToken;
use LexioWrapper\ReceiveDocument;
use LexioWrapper\DownloadCurrentVersion;
use LexioWrapper\GenerateFormDocument;
use LexioWrapper\Signer;

function receiveDocument()
{
       $lexiotoken = "SEU LEXIO TOKEN AQUI";

       $path = __DIR__ . "/test.pdf";

       $lexioToken = new LexioToken($lexiotoken);

       $signer = new Signer();
       $signer->setEmail("email@email.com")
              ->setName("Nome sobrenome")
              ->setFunction("parte");

       $receiveDocument = new ReceiveDocument($lexioToken);
       $result = $receiveDocument->setFileFromSystem($path)
              ->setFileName("test")
              ->addSigner($signer)
              ->send();
       return $result;
}

function addSigner(string $documentToken)
{
       $lexiotoken = "SEU LEXIO TOKEN AQUI";

       $lexioToken = new LexioToken($lexiotoken);

       $signer = new Signer();
       $signer->setEmail("email1@email.com")
              ->setName("Nome sobrenome")
              ->setFunction("parte");

       $signer2 = new Signer();
       $signer2->setEmail("email2@email.com")
              ->setName("Nome sobrenome")
              ->setFunction("parte");

       $addSigner = new AddSigner($lexioToken);
       $addSigner
              ->add($signer)
              ->add($signer2)
              ->send($documentToken);
}

function download(string $documentToken)
{
       $lexiotoken = "SEU LEXIO TOKEN AQUI";

       $fileDestinyToSave = __DIR__ . "/document.pdf";
       $lexioToken = new LexioToken($lexiotoken);
       $download = new DownloadCurrentVersion($lexioToken);

       $download->save($documentToken, $fileDestinyToSave);
}

function generateFormDocument()
{
       $lexiotoken = "SEU LEXIO TOKEN AQUI";

       $lexioToken = new LexioToken($lexiotoken);

       $signer = new Signer();
       $signer->setName("Nome sobrenome");
       $signer->setEmail("email@example");
       $signer->setFunction("parte");

       $build = new DocumentBuild();
       $build->setTitle("MeuTitulo");

       $campos = [
              "Campo1" => "resposta",
              "Campo2" => "resposta"
       ];

       foreach ($campos as $k => $v) {
              $build->setAnswers($k, $v);
       }

       $build->addSigner($signer);

       $generate = new GenerateFormDocument($lexioToken);
       $generate->setTemplateName("ExampleTemplateName");
       $generate->addDocumentBuild($build);
       $generate->addDocumentBuild($build);
       $generate->addDocumentBuild($build);

       $response = $generate->send();

       var_dump($response->getContents());
}
```
