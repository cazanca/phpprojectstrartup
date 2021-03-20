<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Core\View;
use App\Helpers\Email;
use App\Models\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../views/auth/");
    }

    public function index()
    {
        $this->view->render('login', ["title" => "login"]);
    }

    public function login(array $data)
    {
        if (!csrf_verify($data)) {
            $json['message'] = $this->message->error("Por favor use o formulário")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['email']) || empty($data['password'])) {
            $json['message'] = $this->message->warning("Informe seu e-mail e senha para entrar")->render();
            echo \json_encode($json);
            return;
        }

        #Limit de requisição
        if (request_limit("weblogin", 5, 3 * 60)) {
            $json['message'] = $this->message->warning("Você já efetuou 3 tentativas, por favor aguarde por 3 min para tentar novamente.")->render();
            echo \json_encode($json);
            return;
        }

        if (!is_email($data["email"])) {
            $json['message'] = $this->message->warning("O e-mail informado não é valido")->render();
            echo json_encode($json);
            return;
        }


        $user = Auth::where('email', $data['email'])->get();
        if ($user = $user->first()) {

            if ($user->status == 'registered') {
                $json['message'] = $this->message->info("O seu cadastro não foi confirmado, por favor consulte o seu email!")->render();
                echo json_encode($json);
                return;
            }

            if (!password_verify($data['password'], $user->password)) {
                $json['message'] = $this->message->warning("E-mail ou senha incorreta!")->render();
                echo json_encode($json);
                return;
            }


            if (passwd_rehash($user->password)) {
                $user->password = $data['password'];
                $user->save();
            }

            (new Session())->set("authUser", ["user_id" => $user->id, "apelido" => $user->last_name]);
            $this->message->success("Seja bem-vindo(a), {$user->first_name}")->flash();
            $json['redirect'] = url('/home');
            echo json_encode($json);
            return;
        }

        $json['message'] = $this->message->warning("E-mail ou senha incorreta!")->render();
        echo json_encode($json);
        return;
    }

    public function create()
    {
        $this->view->render('register', ['title' => 'Registar']);
    }

    public function store(array $data)
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        if (!csrf_verify($data)) {
            $json['message'] = $this->message->error("Por favor use o formulário")->render();
            echo json_encode($json);
            return;
        }

        if (in_array("", $data, true)) {
            $json['message'] = $this->message->warning("Por favor preencha todos os campos")->render();
            echo json_encode($json);
            return;
        }

        if (!is_email($data["email"])) {
            $json['message'] = $this->message->warning("O e-mail informado não é valido")->render();
            echo json_encode($json);
            return;
        }

        // verificar o tamanho da senha
        if (mb_strlen($data['password']) < CONF_PASSWD_MIN_LEN || mb_strlen($data['password']) > CONF_PASSWD_MAX_LEN) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $json['message'] =  $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres")->render();
            echo json_encode($json);
            return;
        }

        // verificar se o email já esta cadastrado
        $email = Auth::where("email", $data['email'])->get();
        if ($email->count()) {
            $json['message'] = $this->message->warning("O e-mail informado já está cadastrado")->render();
            echo json_encode($json);
            return;
        }


        $user = new Auth;
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);

        if ($user->save()) {
            # Email
            $view = new View(__DIR__ . "/../../public/views/email");
            $message = $view->template("confirm", [
                "first_name" => $user->first_name,
                "confirm_link" => url('/obrigado/' . base64_encode($user->email))
            ]);

            $sendEmail = new Email();
            $sendEmail->bootstrap(
                "Activa sua conta no " . CONF_SITE_NAME,
                $message,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            )->send();
            $json['redirect'] = url('/confirma');
        } else {
            $json['message'] =  $this->message->error("Não foi possível cadastrar o usuário, tente novamente")->after('!')->render();
        }
        echo json_encode($json);
        return;
    }


    public function confirm()
    {
        $this->view->render("confirm", ["title" => "Confirmar o cadastro"]);
    }

    public function success(array $data): void
    {
        $title = '';
        $email = base64_decode($data['email']);
        $auth = Auth::where('email', $email)->get();
        if (($auth = $auth->first()) && $auth->status != 'confirmed') {
            $auth->status = "confirmed";
            $auth->save();
            $title = "Cadastro confirmado com sucesso";
        }
        $title = "O cadastro já foi confirmado";

        $this->view->render("success", ["title" => $title]);
    }

    public function forgot()
    {
        $this->view->render("forgot", ["title" => "Esqueceu a senha"]);
    }

    public function forgotSend(array $data)
    {
        if (!csrf_verify($data)) {
            $json["message"] = $this->message->error("Por favor use o formulário")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['email'])) {
            $json["message"] = $this->message->warning("Informe o seu e-mail para continuar")->render();
            echo json_encode($json);
            return;
        }

        if (!is_email($data['email'])) {
            $json["message"] = $this->message->warning("O e-mail informado não é válido")->render();
            echo json_encode($json);
            return;
        }

        $email = filter_var($data['email'], FILTER_SANITIZE_STRIPPED);
        $user = Auth::where('email', $email)->get();

        if ($user = $user->first()) {
            $user->forget = md5(uniqid(rand(), true));
            $user->save();
            $view = new View(__DIR__ . "/../../public/views/email");
            $message = $view->template("forget", [
                "first_name" => $user->first_name,
                "forget_link" => url("/recuperar/{$user->email}|{$user->forget}")
            ]);

            (new Email())->bootstrap(
                "Recupere a sua senha no " . CONF_SITE_NAME,
                $message,
                $user->email,
                "{$user->fist_name} {$user->last_name}"
            )->send();

            $json["message"] = $this->message->success("Acesse o seu e-mail para recuperar a senha")->render();
            $json['success'] = true;
            echo json_encode($json);
            return;
        } else {
            $json["message"] = $this->message->warning("O e-mail informado não esta cadastrado")->render();
            echo json_encode($json);
            return;
        }
    }

    public function reset(array $data)
    {
        $this->view->render("reset", [
            "title" => "Recuperar",
            "code" => $data["code"]
        ]);
    }

    public function resetUpdate(array $data)
    {
        if (!csrf_verify($data)) {
            $json["message"] = $this->message->error("Por favor use o formulário")->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['password']) || empty($data['conf_password'])) {
            $json["message"] = $this->message->error("Por favor preencha todos os campos")->render();
            echo json_encode($json);
            return;
        }

        list($email, $code) = explode('|', $data['code']);

        $user = Auth::where("email", $email)->get();
        if ($user = $user->first()) {

            if ($user->forget != $code) {
                $json['message'] = $this->message->error("Desculpa, mas o código de recuperação não é válido!")->render();
                echo json_encode($json);
                return;
            }

            // verificar o tamanho da senha
            if (mb_strlen($data['password']) < CONF_PASSWD_MIN_LEN || mb_strlen($data['password']) > CONF_PASSWD_MAX_LEN) {
                $min = CONF_PASSWD_MIN_LEN;
                $max = CONF_PASSWD_MAX_LEN;
                $json['message'] =  $this->message->warning("A senha deve ter entre {$min} e {$max} caracteres")->render();
                echo json_encode($json);
                return;
            }

            if ($data['password'] != $data['conf_password']) {
                $json['message'] = $this->message->warning("Você informou duas senhas diferentes")->render();
                echo json_encode($json);
                return;
            }

            $user->password = password_hash($data['password'], CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
            $user->forget = null;
            if ($user->save()) {
                $this->message->success("Senha alterada com sucesso")->flash();
                $json["redirect"] = url('/');
                echo json_encode($json);
                return;
            }
        } else {
            $json['message'] = $this->message->warning("A conta para  recuperação não foi encontrada")->render();
            echo json_encode($json);
            return;
        }
    }

    public function home()
    {
        echo "<h1 class='text-primary'>Next Vídeo With Roles and Permission</h1>";
    }

    public function logout()
    {
        if (auth()) {
            $nome = $_SESSION['authUser']->apelido;
            $this->message->info("Volta logo " . $nome)->after("!")->flash();
        }

        unset($_SESSION['authUser']);
        redirect('/');
    }
}
