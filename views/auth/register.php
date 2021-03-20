<?php $v->layout('auth_layout') ?>

<form action="<?= url('/registar') ?>" method="POST" class="form-signin">
    <div class="account-logo">
        <a href="<?= url('/') ?>"><img src="<?= assets('img/umum.png') ?>" alt="Logo da UMUM"></a>
    </div>
    <div class="response"><?= flash() ?></div>
    <div class="form-group">
        <label for="first_name">Nome<span class="text-danger">*</span></label>
        <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Nome">
    </div>
    <div class="form-group">
        <label for="last_name">Apelido<span class="text-danger">*</span></label>
        <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Apelido | Sobrenome">
    </div>
    <div class="form-group">
        <label for="email">E-mail<span class="text-danger">*</span></label>
        <input type="text" id="email" autofocus="" name="email" placeholder="E-mail" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Senha<span class="text-danger">*</span></label>
        <input type="password" id="password" name="password" placeholder="Senha" class="form-control" required>
    </div>
    <?= csrf_input() ?>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary account-btn login-btn">Registar</button>
    </div>
    <div class="text-center register-link">
        Já tens uma conta? <a href="<?= url('/') ?>">Acesse o sistema</a>
    </div>
</form>