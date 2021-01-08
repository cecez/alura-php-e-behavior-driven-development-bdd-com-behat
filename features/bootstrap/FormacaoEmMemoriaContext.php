<?php

use Alura\Armazenamento\Entity\Formacao;
use Behat\Behat\Context\Context;

class FormacaoEmMemoriaContext implements Context
{
    private string $_mensagemDeErro;
    /**
     * @var Formacao
     */
    private Formacao $_formacao;

    /**
     * @When eu tentar criar uma formação com a descrição :descricao
     */
    public function euTentarCriarUmaFormacaoComADescricao(string $descricao)
    {
        $this->_formacao = new Formacao();
        try {
            $this->_formacao->setDescricao($descricao);
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
     * @When /^eu devo ter uma formação criada com a descrição "([^"]*)"$/
     */
    public function euDevoTerUmaFormaçãoCriadaComADescrição(string $descricao)
    {
        assert($this->_formacao->getDescricao() === $descricao);
    }

}