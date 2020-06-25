@component('mail::message')
# Peer Request

You have received a peer request from {{ $peer->name }} ({{ $peer->url }}). You can confirm you would like to peer with {{ $peer->name }} by clicking below.

@component('mail::button', ['url' => route('peers.confirm', $peer)])
Confirm
@endcomponent

@component('mail::panel')
## You should know...
* You have up to 24 hours to confirm this request.
* Peering is fully mutual. Either of you can break this connection at any time.
* By confirming this peer request, you will be able to see any posts {{ $peer->name }} has restricted to their peers, and they will see posts you have restricted to peers also.
* {{ $peer->name }} won't be able to see who else you peer with, or any of their posts.
@endcomponent

@endcomponent
