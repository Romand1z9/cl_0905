@extends(config('settings.theme').'.layouts.app')

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $articles !!}
@endsection

@section('sidebar')
    {!! $right_bar !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection