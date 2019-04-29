<?php

namespace Alura\Armazenamento\Controller\Local;

use Alura\Armazenamento\Helper\HtmlViewTrait;
use Alura\Armazenamento\Entity\Local;
use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Lista implements RequestHandlerInterface
{
    use HtmlViewTrait;

    private $locaisRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->locaisRepository = $entityManager->getRepository(Local::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $locais = $this->locaisRepository->findBy($request->getQueryParams(), ['descricao' => 'ASC']);
        $titulo = 'Listagem de Locais';

        $html = $this->getHtmlFromTemplate('locais/listar-locais.php', compact('locais', 'titulo'));

        return new Response(200, [], $html);
    }
}
