<a href="{{ route('users.show',$user->id) }}">
    <img src="{{ $user->getavatar('140') }}" alt="{{ $user->name }}" class="avatar">
</a>
<h1>{{ $user->name }}</h1>