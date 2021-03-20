<?php $v->layout('auth_layout') ?>

<div class="form-signin">
    <div class="account-logo">
        <a href="<?= url('/') ?>"><img src="<?= assets('img/umum.png') ?>" alt="Logo da UMUM"></a>
    </div>

    <div class="alert alert-info my-4">
        Por favor consulte o seu e-mail para confirmar o cadastro
    </div>

    <div class="text-center register-link">
        <a href="<?= url('/') ?>">Acesse o sistema</a>
    </div>
</div>