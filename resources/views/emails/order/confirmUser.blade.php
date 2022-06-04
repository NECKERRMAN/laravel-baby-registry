@component('mail::message')
# {{ ucfirst(__('new_articles_bought'))}}

{{ ucfirst(__('take_a_look'))}}
<br>
{{ $name }} {{ __('has_bought_articles')}}
<br>
{{ $message }}
<br>
{{ucfirst(__('greetings'))}}
<br>
{{ config('app.name') }}
@endcomponent
