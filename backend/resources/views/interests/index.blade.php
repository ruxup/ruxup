<html>
<head><title>Interests</title></head>
<body>
<div>
    @if(count($interests) != 0)
        {
        @foreach($interests as $interest)
            {!! $interest !!}
        @endforeach
        }
    @endif
        <a href="{!! url(route('interests.index')) !!}">Stay on this page</a>
</div>
</body>
</html>
