
    <i class="fa fa-heartbeat activity-icon"></i> 
    <p>
        Remove <a href="#">{{ $data->name }}</a> (by <a href="{{ route('users.show', ['id' => $data->id]) }}"> {{ $data->author }}</a>) from Favorites
        <span class="timestamp">{{ $date }}</span>
    </p>
