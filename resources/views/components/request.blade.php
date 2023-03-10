@forelse ($friendRequests as $request)
<div class="my-2 shadow text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">@if($mode=='sent') {{$request->friend->name}} @else {{$request->user->name}} @endif</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">@if($mode=='sent') {{$request->friend->email}} @else {{$request->user->email}} @endif</td>
      <td class="align-middle">
    </table>
    <div>
      @if ($mode == 'sent')
        <button id="cancel_request_btn_" class="btn btn-danger me-1"
          onclick="deleteRequest('{{auth()->id()}}','{{$request->friend->id}}')">Withdraw Request</button>
      @else
        <button id="accept_request_btn_" class="btn btn-primary me-1"
          onclick="acceptRequest('{{auth()->id()}}','{{$request->user->id}}')">Accept</button>
      @endif
    </div>
  </div>
</div>
@empty
@endforelse
<div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
  <button class="btn btn-primary" onclick="getMoreRequests('{{$mode}}')" id="load_more_btn">Load more</button>
</div>
