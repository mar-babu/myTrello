@if(isset($users))
    @foreach($users as $user)
        <p> {{ $user['name'] }} ( {{ $user['email'] }} ) </p>
    @endforeach
@endif