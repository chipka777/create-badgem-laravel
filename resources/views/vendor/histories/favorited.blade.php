
    <i class="fa fa-heart activity-icon"></i> 
    <p>
        Added <a href="#">{{ $data->name }}</a> (by <a href="{{ route('users.show', ['id' => $data->id]) }}"> {{ $data->author }}</a>) the image in Favorites
        <span class="timestamp">{{ $date }}</span>
    </p>
