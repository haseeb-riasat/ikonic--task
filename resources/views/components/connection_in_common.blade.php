@forelse ($friends ?? [] as $key=>$friend)
<div class="p-2 shadow rounded mt-2  text-white bg-dark">{{$friend->friend->name}} - {{$friend->friend->email}}</div>
@empty
@endforelse