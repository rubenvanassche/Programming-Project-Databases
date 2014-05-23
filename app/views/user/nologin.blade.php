@section('content')
<br>
<br>
<p style="text-align: center;" >Sorry, this content is only available to logged in users. Please <a href="#" data-toggle="modal" data-target="#loginModal" style="text-decoration: underline;">login</a> or <a href="{{action('UserController@register')}}" style="text-decoration:underline;">register</a>.</p>
@stop
