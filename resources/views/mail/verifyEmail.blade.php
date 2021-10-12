
@component('mail::message')

# Ola!

Por favor clique no link abaixo para verificar seu e-mail.

@component('mail::button', ['url' => $url, "color" => "blue"])
Verifique Seu E-mail
@endcomponent

Se você não criou uma conta, nenhuma ação é requerida!.

Atenciosamente {{ config('app.name') }}!

@slot('subcopy')
@lang(
    "Se você estiver tendo problemas para clicar no botão \"Verifique Seu E-mail\",copie e cole a URL abaixo\n".
    'em seu navegador:',
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $url }})</span>
@endslot

@endcomponent
