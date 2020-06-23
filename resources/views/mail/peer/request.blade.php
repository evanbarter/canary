@component('mail::message')
# Peer Request

You have received a peer request from {{ $peer->name }} ({{ $peer->url }}). You can confirm you would like to peer with {{ $peer->name }} by clicking below.

@component('mail::button', ['url' => config('app.url') . '/peers/confirm/' . $peer->id])
Confirm
@endcomponent

@component('mail::panel')
## You should know...
* You have up to 24 hours to confirm this request.
* By confirming this peer request, you will be able to see any posts {{ $peer->name }} has restricted to their peers, but they will see posts you have restricted to peers also.
* {{ $peer->name }} won't be able to see who else you peer with, or any of their posts.
@endcomponent

@endcomponent
