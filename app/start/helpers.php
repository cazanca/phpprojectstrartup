<?php

function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function url(string $path = null): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

function url_back(): string
{
    # $_SERVER['HTTP_REFERER'] - url anterior
    return ($_SERVER['HTTP_REFERER'] ?? '');
}

function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

function date_fmt(string $date = "now", string $format = "d/m/Y H\hi"): string
{
    return (new DateTime($date))->format($format);
}

function passwd_rehash(string $hash): bool
{
    return password_needs_rehash($hash, CONF_PASSWD_ALGO, CONF_PASSWD_OPTION);
}

function csrf_input(): string
{
    $session = new \App\Core\Session();
    $session->csrf();
    return "<input type='hidden' id='csurf' name='csrf' value='" . ($session->csrf_token ?? "") . "'/>";
}

function csrf_verify($request): bool
{
    $session = new \App\Core\Session();
    if (empty($session->csrf_token) || empty($request['csrf']) || $request['csrf'] != $session->csrf_token) {
        return false;
    }
    return true;
}


function flash(): ?string
{
    $session = new \App\Core\Session();
    if ($flash = $session->flash()) {
        echo $flash;
    }
    return null;
}

function request_limit(string $key, int $limit = 5, int $seconds = 60): bool
{
    $session = new \App\Core\Session();
    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests < $limit) {
        $session->set($key, [
            "time" => time() + $seconds,
            "requests" => $session->$key->requests + 1
        ]);

        return false;
    }

    if ($session->has($key) && $session->$key->time >= time() && $session->$key->requests >= $limit) {
        return true;
    }

    $session->set($key, [
        "time" => time() + $seconds,
        "requests" => 1
    ]);

    return false;
}

function request_repeat(string $field, string $value): bool
{
    $session = new \App\Core\Session();
    if ($session->has($field) && $session->$field == $value) {
        return true;
    }

    $session->set($field, $value);
    return false;
}

function str_price(string $price): string
{
    return number_format($price, "2", ",", ".");
}


function assets(string $path)
{
    return url() . "/public/assets/" . $path;
}


function auth(): ?object
{
    return (new \App\Core\Session())->authUser;
}

function dd($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
    die();
}
