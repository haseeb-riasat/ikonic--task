var skeletonId = '#skeleton';
var contentId = '#content';
var skipCounter = 0;
var takeAmount = 10;

function getRequests(mode) {
  $(skeletonId).removeClass('d-none');
var functionsOnSuccess = [
[getRequestsOnSuccess, ['response']]
];
if (mode == 'sent')
ajax('/get_sent_requests/?offset=' + skipCounter + '&limit=' + takeAmount, 'GET', functionsOnSuccess);
else
ajax('/get_received_requests/?offset=' + skipCounter + '&limit=' + takeAmount, 'GET', functionsOnSuccess);
}

function getMoreRequests(mode) {
  $(contentId).addClass('d-none');
getRequests(mode);
}

function getRequestsOnSuccess(response) {
// hide skeletons
$(skeletonId).addClass('d-none');
// show content
$(contentId).removeClass('d-none');
$('#content').html(response.content);
setLoadMoreData();
}

function getConnections() {
  $(skeletonId).removeClass('d-none');
var functionsOnSuccess = [
[getConnectionsSuccess, ['response']]
];
ajax('/get_friends/?offset=' + skipCounter + '&limit=' + takeAmount, 'GET', functionsOnSuccess);
}

function getMoreConnections() {
  $(contentId).addClass('d-none');
getConnections();
}

function getConnectionsSuccess(response) {
// hide skeletons
$(skeletonId).addClass('d-none');
// show content
$(contentId).removeClass('d-none');
$('#content').html(response.content);
setLoadMoreData();
}

function getConnectionsInCommon(userId, connectionId) {
  $(skeletonId).removeClass('d-none');
  var form = ajaxForm([
    ['user_id', userId],
    ['connection_id', connectionId]
    ]);
  var functionsOnSuccess = [
  [getConnectionsInCommonSuccess, ['response']]
  ];
  ajax('/remove_friend?offset=' + skipCounter + '&limit=' + takeAmount, 'POST', functionsOnSuccess, form);
}

function getMoreConnectionsInCommon(userId, connectionId) {
getConnectionsInCommon();
}
function getConnectionsInCommonSuccess(response) {
  // hide skeletons
  $(skeletonId).addClass('d-none');
  // show content
  $(contentId).removeClass('d-none');
  $('#content').html(response.content);
  setLoadMoreData();
  }

function getSuggestions() {
$(skeletonId).removeClass('d-none');
var functionsOnSuccess = [
[getSuggestionsSuccess, ['response']]
];
ajax('/get_suggestions/?offset=' + skipCounter + '&limit=' + takeAmount, 'GET', functionsOnSuccess);
}

function getSuggestionsSuccess(response) {
// hide skeletons
$(skeletonId).addClass('d-none');
// show content
$(contentId).removeClass('d-none');
$('#content').html(response.content);
setLoadMoreData();
}

function getMoreSuggestions() {
  $(contentId).addClass('d-none');
getSuggestions();
}

function sendRequest(userId, suggestionId) {
// show skeletons
// hide content
var form = ajaxForm([
['user_id', userId],
['suggestion_id', suggestionId]
]);
var functionsOnSuccess = [
  [getCommonSuccess,['response']]
];
// POST 
ajax('/send_request', 'POST',functionsOnSuccess, form);
}

function deleteRequest(userId, requestId) {
var form = ajaxForm([
['user_id', userId],
['request_id', requestId]
]);
var functionsOnSuccess = [
  [getCommonSuccess,['response']]
];
ajax('/withdraw_request', 'POST', functionsOnSuccess, form);
}

function acceptRequest(userId, requestId) {
var form = ajaxForm([
['user_id', userId],
['request_id', requestId]
]);
var functionsOnSuccess = [
  [getCommonSuccess,['response']]
];
ajax('/accept_request', 'POST', functionsOnSuccess, form);
}
function getCommonSuccess(response) {
  console.log(response);
  // hide skeletons
  $(skeletonId).addClass('d-none');
  // show content
  $(contentId).removeClass('d-none');
  $('#content').html(response.content);
  }
function removeConnection(userId, connectionId) {
var form = ajaxForm([
['user_id', userId],
['connection_id', connectionId]
]);
var functionsOnSuccess = [
  [getCommonSuccess,['response']]
];
ajax('/remove_friend', 'POST', functionsOnSuccess, form);
}
$("#get_suggestions_btn").on("click", function () {
resetLoadMoreData();
getSuggestions();
});
$("#get_sent_requests_btn").on("click", function () {
resetLoadMoreData();
getRequests('sent');
});
$("#get_received_requests_btn").on("click", function () {
resetLoadMoreData();
getRequests('receive');
});
$("#get_connections_btn").on("click", function () {
resetLoadMoreData();
getConnections();
});
$("#get_connections_in_common_").on("click", function () {
  resetLoadMoreData();
  getConnectionsInCommon();
  });

function resetLoadMoreData() {
skipCounter = 0;
takeAmount = 10;
console.log('in reset',skipCounter,takeAmount);
}

function setLoadMoreData() {
skipCounter = takeAmount;
takeAmount += 10;
console.log('in set',skipCounter,takeAmount);
}
$(function () {
getSuggestions();
});
