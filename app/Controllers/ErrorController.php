<?php

namespace App\Controllers;

use App\Core\Controller;
use stdClass;

class ErrorController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../views/error");
    }

    public function index(array $data): void
    {
        $error = new stdClass();

        switch ($data['errorcode']) {
            case 'problemas':
                $error->code = "Oops!";
                $error->title = " Estamos enfrentando problemas";
                $error->message = "Parece que nosso serviço não esta disponível no momento. Já estamos vendo isso mas caso precise, envie um e-mail :)";
                $error->linkTitle = "Enviar";
                $error->link = "mailto:" . CONF_MAIL_SUPPORT;
                break;
            case 'manutencao':
                $error->code = "Oops!";
                $error->title = " Desculpa. Estamos em manutenção";
                $error->message = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo.";
                $error->linkTitle = null;
                $error->link = null;
                break;
            case 'negado':
                $error->code = "401";
                $error->title = " Acesso negado";
                $error->message = "Desulpa. Não tens permissão para visualizar este conteudo";
                $error->linkTitle = "Continue navegando";
                $error->link = url("/logout");
                break;
            case '404':
                $error->code = "404";
                $error->title = " Não encontrado";
                $error->message = "Oops! Conteúdo não encontrado";
                $error->linkTitle = "Continue navegando";
                $error->link = url_back();
                break;

            default:
                $error->code = $data['errorcode'];
                $error->title = " Oops!. Conteúdo indisponível :/";
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível no momento ou foi removido";
                $error->linkTitle = "Continue navegando!";
                $error->link = url_back();
                break;
        }

        $this->view->render("error", ["error" => $error]);
    }
}
