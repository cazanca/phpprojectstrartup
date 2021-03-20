<?php $v->layout('auth_layout') ?>

<form action="<?= url('/recuperar') ?>" method="POST" class="form-signin">
    <div class="account-logo">
        <a href="/"><img src="<?= assets('img/umum.png') ?>" alt="Logo da UMUM"></a>
    </div>
    <div class="response"><?= flash() ?></div>
    <input type="hidden" name="code" value="<?= $code ?>">
    <div class="form-group">
        <label for="password">Nova Senha</label>
        <input type="password" id="password" autofocus="" name="password" placeholder="Nova senha" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="conf_password">Confirmar a senha</label>
        <input type="password" id="conf_password" autofocus="" name="conf_password" placeholder="Confirmar a senha" class="form-control" required>
    </div>
    <?= csrf_input() ?>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary account-btn login-btn">Recuperar</button>
    </div>
    <div class="text-center register-link">
        <a href="<?= url('/') ?>">Acesse o sistema</a>
    </div>
</form>