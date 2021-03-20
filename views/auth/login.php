<?php $v->layout('auth_layout') ?>

<form action="<?= url('/') ?>" method="POST" class="form-signin">
    <div class="account-logo">
        <a href="<?= url('/') ?>"><img src="<?= assets('img/umum.png') ?>" alt="Logo da UMUM"></a>
    </div>
    <div class="response"><?= flash() ?></div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="text" id="email" autofocus="" name="email" placeholder="E-mail" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password" placeholder="Senha" class="form-control" required>
    </div>
    <div class="form-group text-right">
        <a href="<?= url('/esqueceu') ?>">Esqueceu a senha?</a>
    </div>
    <?= csrf_input() ?>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary account-btn login-btn">Login</button>
    </div>
    <div class="text-center register-link">
        Não tens uma conta? <a href="<?= url('/registar') ?>">Cria agora</a>
    </div>
</form>