
@component('mail::message')

@slot('header')
  <img id="img" style="width:200px;" src="{{ asset('storage/logo/logo.png') }}">
@endslot

# Ola!

Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.

@component('mail::button', ['url' => $url, "color" => "blue"])
Modificar senha
@endcomponent

Se você não solicitou um redefinição de senha no LuStore, nenhuma ação adicional será necessária.

Atenciosamente {{ config('app.name') }}

@slot('subcopy')
@lang(
    "Se você estiver tendo problemas para clicar no botão \"Modificar senha\",copie e cole a URL abaixo\n".
    'em seu navegador:',
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $url }})</span>
@endslot

@endcomponent
