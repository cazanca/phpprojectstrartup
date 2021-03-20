<?php $v->layout("_theme", ["title" => "Confirme e ative sua conta no " . CONF_SITE_NAME]); ?>

<h3>Seja bem-vindo(a) ao <?= CONF_SITE_NAME ?> <?= $first_name; ?>. Vamos confirmar seu cadastro?</h3>
<p>É importante confirmar seu cadastro. Se não reconhece o email ignore-o</p>
<p><a title='Confirmar Cadastro' href='<?= $confirm_link; ?>'>CLIQUE AQUI PARA CONFIRMAR</a></p>