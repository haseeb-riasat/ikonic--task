@forelse ($suggestedFriendsList as $suggestedFriends)
<div class="my-2 shadow  text-white bg-dark p-1" id="">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$suggestedFriends->name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$suggestedFriends->email}}</td>
      <td class="align-middle"> 
    </table>
    <div>
      <button id="create_request_btn" class="btn btn-primary me-1" onclick="sendRequest('{{auth()->id()}}','{{$suggestedFriends->id}}')">Connect</button>
    </div>
  </div>
</div>
@empty
  
@endforelse
<div class="d-flex justify-content-center mt-2 py-3 {{-- d-none --}}" id="load_more_btn_parent">
  <button class="btn btn-primary" onclick="getMoreSuggestions()" id="load_more_btn">Load more</button>
</div>
