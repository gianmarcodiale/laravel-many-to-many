@component('mail::message')
# Introduction

Hello admin,
Post {{$postSlug}} has been edited.

@component('mail::button', ['url' => $postUrl])
Review Post
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
