@component('mail::layout')
{{-- Header --}}
@isset($header)
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ $header }}
@endcomponent
@endslot
@endisset

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
