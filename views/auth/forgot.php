<?php $v->layout('auth_layout') ?>

<form action="<?= url('/esqueceu') ?>" method="POST" class="form-signin">
    <div class="account-logo">
        <a href="/"><img src="<?= assets('img/umum.png') ?>" alt="Logo da UMUM"></a>
    </div>
    <div class="response"><?= flash() ?></div>
    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" autofocus="" name="email" placeholder="E-mail" class="form-control" required>
    </div>
    <?= csrf_input() ?>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary account-btn login-btn">Recuperar</button>
    </div>
    <div class="text-center register-link">
        <a href="<?= url('/') ?>">Acesse o sistema</a>
    </div>
</form>