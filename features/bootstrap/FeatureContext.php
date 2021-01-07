<?php

use Alura\Armazenamento\Entity\Formacao;
use Alura\Armazenamento\Infra\EntitymanagerCreator;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private EntityManagerInterface $em;
    private string $_mensagemDeErro = '';
    private ?int $_idFormacaoInserida;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When eu tentar criar uma formação com a descrição :descricao
     */
    public function euTentarCriarUmaFormacaoComADescricao(string $descricao)
    {
        $formacao = new Formacao();
        try {
            $formacao->setDescricao($descricao);
        } catch (\InvalidArgumentException $e) {
            $this->_mensagemDeErro = $e->getMessage();
        }
    }

    /**
     * @Then eu vou ver a seguinte mensagem e erro :mensagemDeErro
     */
    public function euVouVerASeguinteMensagemEErro(string $mensagemDeErro)
    {
        assert($mensagemDeErro === $this->_mensagemDeErro);
    }

    /**
     * @Given que estou conectado ao banco de dados
     */
    public function queEstouConectadoAoBancoDeDados()
    {
        $this->em = (new EntitymanagerCreator())->getEntityManager();
    }

    /**
     * @When tento salvar uma nova formação com a descrição :descricao
     */
    public function tentoSalvarUmaNovaFormacaoComADescricao(string $descricao)
    {
        $formacao = new Formacao();
        $formacao->setDescricao($descricao);

        $this->em->persist($formacao);
        $this->em->flush();

        // armazena id para outro método consultar
        $this->_idFormacaoInserida = $formacao->getId();
    }

    /**
     * @Then se eu buscar no banco, devo encontrar essa formação
     */
    public function seEuBuscarNoBancoDevoEncontrarEssaFormacao()
    {
        /** @var \Doctrine\Persistence\ObjectRepository $repositorio */
        $repositorio = $this->em->getRepository(Formacao::class);

        /** @var Formacao $formacao */
        $formacao = $repositorio->find($this->_idFormacaoInserida);

        assert($formacao instanceof Formacao);

    }
}
