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
        $formacao->setDescricao($descricao);

        $this->em->persist($formacao);
        $this->em->flush();
    }

    /**
     * @Then eu vou ver a seguinte mensagem e erro :arg1
     */
    public function euVouVerASeguinteMensagemEErro($arg1)
    {
        throw new PendingException();
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
    }

    /**
     * @Then se eu buscar no banco, devo encontrar essa formação
     */
    public function seEuBuscarNoBancoDevoEncontrarEssaFormacao()
    {
        throw new PendingException();
    }
}
