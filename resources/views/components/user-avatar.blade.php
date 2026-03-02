<style>
    .user-avatar{
        max-height: 3rem;
        max-width: 3rem;
        margin-right:0.5rem;
        overflow: hidden;
    }
</style>

@php
    $width = $size ?? '3rem';
    $height = $size ?? '3rem';
@endphp

<div class="flex flex-col items-center justify-center rounded-full bg-white overflow-hidden object-cover mr-2" style="height: {{$height ?? '3rem'}}; width: {{$width ?? '3rem'}};">
    <img class="w-full h-full rounded-full object-cover" width="{{$width}}" height="{{$height}}"
        src="{{ $user->avatar ? asset('storage/avatars/' . $user->avatar->avatar) : 'https://ui-avatars.com/api/?name= '.$user->name .'&background=random&size=128' }}"
        alt="{{ $user->name }}">
</div>