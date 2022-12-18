@forelse ($friends as $key=>$friend)
@if ($friend->friend_id==auth()->id())
@php  
$friend=$friend->user;
@endphp
@else
@php
$friend=$friend->friend;
@endphp
@endif
<div class="my-2 shadow text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$friend->name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$friend->email}}</td>
      <td class="align-middle">
    </table>
    <div>
      <button style="width: 220px" id="get_connections_in_common_" class="btn btn-primary" type="button"
        data-bs-toggle="collapse" data-bs-target="#collapse_{{$key}}" aria-expanded="false" aria-controls="collapseExample">
        Connections in common ()
      </button>
      <button id="create_request_btn_" class="btn btn-danger me-1" onclick="removeConnection('{{auth()->id()}}','{{$friend->id}}')">Remove Connection</button>
    </div>

  </div>
  <div class="collapse" id="collapse_{{$key}}">

    <div id="content_" class="p-2">
      {{-- Display data here --}}
      <x-connection_in_common />
    </div>
    <div id="connections_in_common_skeletons_">
      <div id="skeleton">
        @for ($i = 0; $i < 10; $i++)
          <x-skeleton />
        @endfor
      </div>
    </div>
    <div class="d-flex justify-content-center w-100 py-2">
      <button class="btn btn-sm btn-primary" id="load_more_connections_in_common_">Load
        more</button>
    </div>
  </div>
</div>
@empty
@endforelse
<div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
  <button class="btn btn-primary" onclick="getMoreConnections()" id="load_more_btn">Load more</button>
</div>
